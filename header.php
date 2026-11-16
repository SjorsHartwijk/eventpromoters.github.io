<?php
/**
 * Site header.
 *
 * @package Eventpromoters
 */

?><!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Direct naar hoofdinhoud', 'eventpromoters' ); ?></a>

<header class="site-header">
	<div class="wrap site-header__inner">
		<a class="brand d" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php eventpromoters_logo(); ?>
			<span><?php bloginfo( 'name' ); ?></span>
		</a>

		<button class="nav-toggle" type="button" aria-controls="site-nav" aria-expanded="false">
			<?php echo eventpromoters_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'eventpromoters' ); ?></span>
		</button>

		<nav id="site-nav" class="site-nav" aria-label="<?php esc_attr_e( 'Hoofdmenu', 'eventpromoters' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'depth'          => 2,
					'fallback_cb'    => 'eventpromoters_primary_fallback',
				)
			);
			?>
			<a class="btn btn--mint btn--sm" href="<?php echo esc_url( ( is_front_page() ? '' : home_url( '/' ) ) . '#contact' ); ?>"><?php echo esc_html( eventpromoters_mod( 'cta_label' ) ); ?></a>
		</nav>
	</div>
</header>

<main id="main" class="site-main" tabindex="-1">
