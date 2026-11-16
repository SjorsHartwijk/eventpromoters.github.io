<?php
/**
 * Template helpers.
 *
 * @package Eventpromoters
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output the site logo: custom logo if set, otherwise the bundled white logo.
 */
function eventpromoters_logo() {
	if ( has_custom_logo() ) {
		$logo_id = get_theme_mod( 'custom_logo' );
		echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'brand__logo', 'alt' => '' ) );
		return;
	}
	printf(
		'<img class="brand__logo" src="%s" alt="" width="30" height="30">',
		esc_url( get_template_directory_uri() . '/assets/images/logo-white.png' )
	);
}

/**
 * Inline SVG icons used throughout the theme.
 *
 * @param string $name Icon name.
 * @return string
 */
function eventpromoters_icon( $name ) {
	$icons = array(
		'check'     => '<svg class="icon icon--check" width="22" height="22" viewBox="0 0 22 22" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="11" fill="currentColor"/><path d="M6 11.5 L9.5 15 L16 8" stroke="#1E1654" stroke-width="2.4" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'menu'    => '<svg class="icon" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>',
	);
	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Social links from the Customizer.
 *
 * @return array<string,array{label:string,url:string}>
 */
function eventpromoters_socials() {
	$out = array();
	foreach ( array( 'bluesky' => 'Bluesky', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn' ) as $key => $label ) {
		$url = eventpromoters_mod( 'social_' . $key );
		if ( $url ) {
			$out[ $key ] = array(
				'label' => $label,
				'url'   => $url,
			);
		}
	}
	return $out;
}

/**
 * Image chosen in the Customizer, or '' when none is set (never an empty frame).
 *
 * @param string $key   Theme mod holding an attachment ID.
 * @param string $sizes Sizes attribute for the responsive image.
 * @return string HTML.
 */
function eventpromoters_mod_image( $key, $sizes = '100vw' ) {
	$id = absint( get_theme_mod( $key ) );
	if ( ! $id ) {
		return '';
	}
	return wp_get_attachment_image(
		$id,
		'large',
		false,
		array(
			'sizes'   => $sizes,
			'loading' => 'lazy',
		)
	);
}

/**
 * Split a sentence into word spans for the scroll-lit statement.
 *
 * @param string $text Statement.
 * @return string HTML.
 */
function eventpromoters_words( $text ) {
	$words = preg_split( '/\s+/u', trim( $text ) );
	$out   = array();
	foreach ( $words as $word ) {
		$out[] = '<span class="w">' . esc_html( $word ) . '</span>';
	}
	return implode( ' ', $out );
}

/**
 * Turn a phone number into a tel: href.
 *
 * @param string $phone Phone number.
 * @return string
 */
function eventpromoters_tel( $phone ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
}

/**
 * Fallback for the primary menu when none is assigned: front-page anchors.
 */
function eventpromoters_primary_fallback() {
	$base  = is_front_page() ? '' : home_url( '/' );
	$items = array(
		'#diensten' => __( 'Diensten', 'eventpromoters' ),
		'#voor-wie' => __( 'Voor wie', 'eventpromoters' ),
		'#aanpak'   => __( 'Aanpak', 'eventpromoters' ),
		'#over-ons' => __( 'Over ons', 'eventpromoters' ),
	);
	echo '<ul id="primary-menu" class="menu">';
	foreach ( $items as $anchor => $label ) {
		printf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $base . $anchor ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Fallback for the footer menu.
 */
function eventpromoters_footer_fallback() {
	$base  = is_front_page() ? '' : home_url( '/' );
	$items = array(
		'#diensten' => __( 'Diensten', 'eventpromoters' ),
		'#voor-wie' => __( 'Voor wie', 'eventpromoters' ),
		'#over-ons' => __( 'Over ons', 'eventpromoters' ),
		'#contact'  => __( 'Contact', 'eventpromoters' ),
	);
	echo '<ul class="footer-links">';
	foreach ( $items as $anchor => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $base . $anchor ), esc_html( $label ) );
	}
	echo '</ul>';
}

/**
 * Post meta line (date + author).
 */
function eventpromoters_posted_on() {
	printf(
		'<p class="entry-meta"><time datetime="%1$s">%2$s</time> · %3$s</p>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_html( get_the_author() )
	);
}
