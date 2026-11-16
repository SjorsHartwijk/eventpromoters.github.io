<?php
/**
 * Customizer: editable texts for the front page, contact details and socials.
 *
 * @package Eventpromoters
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Defaults for every theme mod used by the theme.
 *
 * @return array<string,string>
 */
function eventpromoters_defaults() {
	return array(
		'hero_eyebrow'   => 'Digitale marketing voor evenementen, artiesten & festivals',
		'hero_title'     => 'Zorg dat ze',
		'hero_highlight' => 'komen.',
		'hero_text'      => 'Wij versterken de online zichtbaarheid van jouw event en helpen met het verhogen van de betrokkenheid van je fans, van eerste aankondiging tot laatste ticket.',
		'stat_1_value'   => '500+',
		'stat_1_label'   => 'Tevreden klanten',
		'stat_2_value'   => '10.000+',
		'stat_2_label'   => 'Verkochte tickets',
		'stat_3_value'   => '100+',
		'stat_3_label'   => 'Succesvolle campagnes',
		'stat_4_value'   => '2.000 kg',
		'stat_4_label'   => 'Confetti gebruikt',
		'statement_text' => 'Van eerste aankondiging tot laatste ticket: wij zorgen dat jouw fans het zien, het delen en komen.',
		'about_image'      => '',
		'audience_image_1' => '',
		'audience_image_2' => '',
		'audience_image_3' => '',
		'about_title'    => 'Passie voor events, kennis van digitaal',
		'about_text'     => 'Wij zijn een team van ervaren professionals met een passie voor evenementenorganisatie en digitale marketing. Ons doel is om jouw visie tot leven te brengen, je verwachtingen te overtreffen en de digitale impact van je evenement te versterken.',
		'contact_email'  => 'info@eventpromoters.nl',
		'contact_phone'  => '+31 6 12345678',
		'social_bluesky' => '',
		'social_instagram' => '',
		'social_linkedin'  => '',
		'footer_text'    => 'Digitale marketing specialisten voor evenementen, artiesten en festivals.',
		'cta_label'      => 'Plan een gesprek',
	);
}

/**
 * Get a theme mod with the theme default as fallback.
 *
 * @param string $key Setting key.
 * @return string
 */
function eventpromoters_mod( $key ) {
	$defaults = eventpromoters_defaults();
	return (string) get_theme_mod( $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
}

/**
 * Register Customizer panels, sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function eventpromoters_customize_register( $wp_customize ) {
	$defaults = eventpromoters_defaults();

	$wp_customize->add_panel(
		'eventpromoters',
		array(
			'title'    => __( 'Eventpromoters', 'eventpromoters' ),
			'priority' => 30,
		)
	);

	$sections = array(
		'ep_hero'    => array(
			'title'  => __( 'Hero', 'eventpromoters' ),
			'fields' => array(
				'hero_eyebrow'   => array( __( 'Bovenregel', 'eventpromoters' ), 'text' ),
				'hero_title'     => array( __( 'Titel', 'eventpromoters' ), 'text' ),
				'hero_highlight' => array( __( 'Gemarkeerd woord', 'eventpromoters' ), 'text' ),
				'hero_text'      => array( __( 'Introtekst', 'eventpromoters' ), 'textarea' ),
				'cta_label'      => array( __( 'Knoptekst (gesprek)', 'eventpromoters' ), 'text' ),
			),
		),
		'ep_stats'   => array(
			'title'  => __( 'Cijfers', 'eventpromoters' ),
			'fields' => array(),
		),
		'ep_statement' => array(
			'title'  => __( 'Statement (scroll-moment)', 'eventpromoters' ),
			'fields' => array(
				'statement_text' => array( __( 'Statementzin (woorden lichten op tijdens scrollen)', 'eventpromoters' ), 'textarea' ),
			),
		),
		'ep_photos'  => array(
			'title'  => __( "Foto's", 'eventpromoters' ),
			'fields' => array(
				'audience_image_1' => array( __( 'Voor wie: Evenementen', 'eventpromoters' ), 'image' ),
				'audience_image_2' => array( __( 'Voor wie: Artiesten', 'eventpromoters' ), 'image' ),
				'audience_image_3' => array( __( 'Voor wie: Festivals', 'eventpromoters' ), 'image' ),
				'about_image'      => array( __( 'Over ons: teamfoto of sfeerfoto', 'eventpromoters' ), 'image' ),
			),
		),
		'ep_about'   => array(
			'title'  => __( 'Over ons', 'eventpromoters' ),
			'fields' => array(
				'about_title' => array( __( 'Titel', 'eventpromoters' ), 'text' ),
				'about_text'  => array( __( 'Tekst', 'eventpromoters' ), 'textarea' ),
			),
		),
		'ep_contact' => array(
			'title'  => __( 'Contact & socials', 'eventpromoters' ),
			'fields' => array(
				'contact_email'    => array( __( 'E-mailadres', 'eventpromoters' ), 'email' ),
				'contact_phone'    => array( __( 'Telefoonnummer', 'eventpromoters' ), 'text' ),
				'social_bluesky'   => array( __( 'Bluesky URL', 'eventpromoters' ), 'url' ),
				'social_instagram' => array( __( 'Instagram URL', 'eventpromoters' ), 'url' ),
				'social_linkedin'  => array( __( 'LinkedIn URL', 'eventpromoters' ), 'url' ),
				'footer_text'      => array( __( 'Footertekst', 'eventpromoters' ), 'textarea' ),
			),
		),
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		/* translators: %d: stat number */
		$sections['ep_stats']['fields'][ "stat_{$i}_value" ] = array( sprintf( __( 'Cijfer %d – waarde', 'eventpromoters' ), $i ), 'text' );
		/* translators: %d: stat number */
		$sections['ep_stats']['fields'][ "stat_{$i}_label" ] = array( sprintf( __( 'Cijfer %d – label', 'eventpromoters' ), $i ), 'text' );
	}

	foreach ( $sections as $section_id => $section ) {
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => $section['title'],
				'panel' => 'eventpromoters',
			)
		);

		foreach ( $section['fields'] as $key => $field ) {
			list( $label, $type ) = $field;

			if ( 'image' === $type ) {
				$wp_customize->add_setting(
					$key,
					array(
						'default'           => '',
						'sanitize_callback' => 'absint',
						'transport'         => 'refresh',
					)
				);
				$wp_customize->add_control(
					new WP_Customize_Media_Control(
						$wp_customize,
						$key,
						array(
							'label'       => $label,
							'section'     => $section_id,
							'mime_type'   => 'image',
							'description' => __( 'Gebruik een echte foto van jullie werk of events (liggend, minimaal 1600px breed).', 'eventpromoters' ),
						)
					)
				);
				continue;
			}

			switch ( $type ) {
				case 'url':
					$sanitize = 'esc_url_raw';
					break;
				case 'email':
					$sanitize = 'sanitize_email';
					break;
				case 'textarea':
					$sanitize = 'sanitize_textarea_field';
					break;
				default:
					$sanitize = 'sanitize_text_field';
			}

			$wp_customize->add_setting(
				$key,
				array(
					'default'           => $defaults[ $key ],
					'sanitize_callback' => $sanitize,
					'transport'         => 'refresh',
				)
			);
			$wp_customize->add_control(
				$key,
				array(
					'label'   => $label,
					'section' => $section_id,
					'type'    => $type,
				)
			);
		}
	}
}
add_action( 'customize_register', 'eventpromoters_customize_register' );
