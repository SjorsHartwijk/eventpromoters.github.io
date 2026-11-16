<?php
/**
 * Contact section with form.
 *
 * @package Eventpromoters
 */

$ep_email = eventpromoters_mod( 'contact_email' );
$ep_phone = eventpromoters_mod( 'contact_phone' );
?>
<section id="contact" class="section">
	<div class="wrap split split--top">
		<div>
			<p class="eyebrow"><?php esc_html_e( 'Contact', 'eventpromoters' ); ?></p>
			<h2 class="d section__title"><?php esc_html_e( 'Jouw event is de volgende', 'eventpromoters' ); ?></h2>
			<p class="section__intro"><?php esc_html_e( 'Neem contact met ons op voor meer informatie of een offerte.', 'eventpromoters' ); ?></p>
			<?php if ( $ep_email ) : ?>
				<p class="contact-line"><strong><?php esc_html_e( 'E-mail', 'eventpromoters' ); ?></strong><br><a href="<?php echo esc_url( 'mailto:' . antispambot( $ep_email ) ); ?>"><?php echo esc_html( antispambot( $ep_email ) ); ?></a></p>
			<?php endif; ?>
			<?php if ( $ep_phone ) : ?>
				<p class="contact-line"><strong><?php esc_html_e( 'Telefoon', 'eventpromoters' ); ?></strong><br><a href="<?php echo esc_url( eventpromoters_tel( $ep_phone ) ); ?>"><?php echo esc_html( $ep_phone ); ?></a></p>
			<?php endif; ?>
		</div>

		<form class="card form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
			<?php echo eventpromoters_contact_notice(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside. ?>
			<input type="hidden" name="action" value="ep_contact">
			<?php wp_nonce_field( 'ep_contact', 'ep_contact_nonce' ); ?>
			<div class="form__hp" aria-hidden="true">
				<label for="ep_website">Website</label>
				<input type="text" id="ep_website" name="ep_website" tabindex="-1" autocomplete="off">
			</div>
			<?php
			$ep_fields = array(
				'name'    => array( __( 'Naam', 'eventpromoters' ), 'text', 'name', __( 'Je naam', 'eventpromoters' ) ),
				'email'   => array( __( 'E-mailadres', 'eventpromoters' ), 'email', 'email', __( 'Je e-mailadres', 'eventpromoters' ) ),
				'message' => array( __( 'Bericht', 'eventpromoters' ), 'textarea', 'off', __( 'Vertel kort over je event', 'eventpromoters' ) ),
			);
			$ep_state  = eventpromoters_contact_state();
			foreach ( $ep_fields as $ep_key => $ep_field ) :
				list( $ep_label, $ep_type, $ep_auto, $ep_placeholder ) = $ep_field;
				$ep_id    = 'ep_' . $ep_key;
				$ep_error = eventpromoters_contact_field_error( $ep_key );
				$ep_attrs = sprintf(
					'class="field" id="%1$s" name="%1$s" autocomplete="%2$s" placeholder="%3$s" required%4$s',
					esc_attr( $ep_id ),
					esc_attr( $ep_auto ),
					esc_attr( $ep_placeholder ),
					$ep_error ? ' aria-invalid="true" aria-describedby="' . esc_attr( $ep_id . '-error' ) . '"' : ''
				);
				?>
				<div class="form__row<?php echo $ep_error ? ' form__row--error' : ''; ?>">
					<label class="label" for="<?php echo esc_attr( $ep_id ); ?>"><?php echo esc_html( $ep_label ); ?></label>
					<?php if ( 'textarea' === $ep_type ) : ?>
						<textarea <?php echo $ep_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?> rows="5"><?php echo esc_textarea( $ep_state['values'][ $ep_key ] ); ?></textarea>
					<?php else : ?>
						<input type="<?php echo esc_attr( $ep_type ); ?>" value="<?php echo esc_attr( $ep_state['values'][ $ep_key ] ); ?>" <?php echo $ep_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>>
					<?php endif; ?>
					<?php if ( $ep_error ) : ?>
						<p class="field-error" id="<?php echo esc_attr( $ep_id . '-error' ); ?>"><?php echo esc_html( $ep_error ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
			<div><button type="submit" class="btn btn--navy"><?php esc_html_e( 'Verstuur bericht', 'eventpromoters' ); ?></button></div>
		</form>
	</div>
</section>
