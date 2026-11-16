<?php
/**
 * Contact form handling (admin-post, nonce, honeypot, wp_mail).
 *
 * On a validation or send error the submitted values and the invalid fields
 * are kept in a short-lived transient, so the form can be refilled and the
 * problem fields marked after the redirect.
 *
 * @package Eventpromoters
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Redirect back to the contact section with a status (and optional state token).
 *
 * @param string $redirect Base URL.
 * @param string $status   Status key.
 * @param array  $state    Values + errors to keep for the next request.
 */
function eventpromoters_contact_redirect( $redirect, $status, $state = array() ) {
	$args = array( 'contact' => $status );
	if ( $state ) {
		$token = wp_generate_password( 12, false );
		set_transient( 'ep_contact_' . $token, $state, 10 * MINUTE_IN_SECONDS );
		$args['ep_t'] = $token;
	}
	wp_safe_redirect( add_query_arg( $args, $redirect ) . '#contact' );
	exit;
}

/**
 * Handle a contact form submission.
 */
function eventpromoters_handle_contact() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$redirect = remove_query_arg( array( 'contact', 'ep_t' ), $redirect );

	$values = array(
		'name'    => isset( $_POST['ep_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ep_name'] ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified below.
		'email'   => isset( $_POST['ep_email'] ) ? sanitize_email( wp_unslash( $_POST['ep_email'] ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Missing
		'message' => isset( $_POST['ep_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ep_message'] ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Missing
	);

	if ( ! isset( $_POST['ep_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ep_contact_nonce'] ) ), 'ep_contact' ) ) {
		eventpromoters_contact_redirect( $redirect, 'expired', array( 'values' => $values, 'errors' => array() ) );
	}

	// Honeypot: bots fill every field. Pretend success.
	if ( ! empty( $_POST['ep_website'] ) ) {
		eventpromoters_contact_redirect( $redirect, 'sent' );
	}

	$errors = array();
	if ( '' === $values['name'] ) {
		$errors[] = 'name';
	}
	if ( ! is_email( $values['email'] ) ) {
		$errors[] = 'email';
	}
	if ( '' === $values['message'] ) {
		$errors[] = 'message';
	}
	if ( $errors ) {
		eventpromoters_contact_redirect( $redirect, 'invalid', array( 'values' => $values, 'errors' => $errors ) );
	}

	$to = eventpromoters_mod( 'contact_email' );
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	/* translators: %s: sender name */
	$subject = sprintf( __( 'Nieuw contactbericht van %s', 'eventpromoters' ), $values['name'] );
	$body    = sprintf( "Naam: %s\nE-mail: %s\n\n%s", $values['name'], $values['email'], $values['message'] );
	$headers = array( sprintf( 'Reply-To: %s <%s>', $values['name'], $values['email'] ) );

	if ( wp_mail( $to, $subject, $body, $headers ) ) {
		eventpromoters_contact_redirect( $redirect, 'sent' );
	}
	eventpromoters_contact_redirect( $redirect, 'error', array( 'values' => $values, 'errors' => array() ) );
}
add_action( 'admin_post_nopriv_ep_contact', 'eventpromoters_handle_contact' );
add_action( 'admin_post_ep_contact', 'eventpromoters_handle_contact' );

/**
 * Current form state for this request: status, kept values and invalid fields.
 *
 * @return array{status:string,values:array<string,string>,errors:string[]}
 */
function eventpromoters_contact_state() {
	static $state = null;
	if ( null !== $state ) {
		return $state;
	}

	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- display only.
	$state = array(
		'status' => isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '',
		'values' => array(
			'name'    => '',
			'email'   => '',
			'message' => '',
		),
		'errors' => array(),
	);

	$token = isset( $_GET['ep_t'] ) ? preg_replace( '/[^A-Za-z0-9]/', '', wp_unslash( $_GET['ep_t'] ) ) : '';
	// phpcs:enable

	if ( $token ) {
		$kept = get_transient( 'ep_contact_' . $token );
		if ( is_array( $kept ) ) {
			if ( isset( $kept['values'] ) && is_array( $kept['values'] ) ) {
				$state['values'] = array_merge( $state['values'], array_intersect_key( $kept['values'], $state['values'] ) );
			}
			if ( isset( $kept['errors'] ) && is_array( $kept['errors'] ) ) {
				$state['errors'] = array_values( array_intersect( $kept['errors'], array( 'name', 'email', 'message' ) ) );
			}
		}
	}

	return $state;
}

/**
 * Field-level error message.
 *
 * @param string $field Field key.
 * @return string
 */
function eventpromoters_contact_field_error( $field ) {
	$messages = array(
		'name'    => __( 'Vul je naam in.', 'eventpromoters' ),
		'email'   => __( 'Vul een geldig e-mailadres in, bijvoorbeeld naam@voorbeeld.nl.', 'eventpromoters' ),
		'message' => __( 'Schrijf een kort bericht over je event.', 'eventpromoters' ),
	);
	$state = eventpromoters_contact_state();
	return in_array( $field, $state['errors'], true ) ? $messages[ $field ] : '';
}

/**
 * Status message after a submission. Gets focus via theme.js so screen readers announce it.
 *
 * @return string HTML.
 */
function eventpromoters_contact_notice() {
	$state = eventpromoters_contact_state();
	$email = eventpromoters_mod( 'contact_email' );
	$map   = array(
		'sent'    => array( 'success', __( 'Bedankt, je bericht is verstuurd. We nemen zo snel mogelijk contact met je op.', 'eventpromoters' ) ),
		'invalid' => array( 'error', __( 'Je bericht is nog niet verstuurd. Controleer de gemarkeerde velden hieronder.', 'eventpromoters' ) ),
		/* translators: %s: contact e-mail address */
		'error'   => array( 'error', sprintf( __( 'Versturen is mislukt door een storing aan onze kant. Je tekst staat er nog; probeer het opnieuw of mail ons direct op %s.', 'eventpromoters' ), $email ) ),
		'expired' => array( 'error', __( 'Het formulier was verlopen. Je tekst staat er nog; verstuur het opnieuw.', 'eventpromoters' ) ),
	);
	if ( ! isset( $map[ $state['status'] ] ) ) {
		return '';
	}
	return sprintf(
		'<div class="notice notice--%1$s" id="ep-contact-notice" role="%2$s" tabindex="-1">%3$s</div>',
		esc_attr( $map[ $state['status'] ][0] ),
		'success' === $map[ $state['status'] ][0] ? 'status' : 'alert',
		esc_html( $map[ $state['status'] ][1] )
	);
}
