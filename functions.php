<?php
/**
 * Eventpromoters theme functions.
 *
 * @package Eventpromoters
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EVENTPROMOTERS_VERSION', '2.0.0' );

/**
 * Theme setup.
 */
function eventpromoters_setup() {
	load_theme_textdomain( 'eventpromoters', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 60,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_theme_support(
		'editor-color-palette',
		array(
			array( 'name' => __( 'Navy', 'eventpromoters' ), 'slug' => 'navy', 'color' => '#1E1654' ),
			array( 'name' => __( 'Indigo', 'eventpromoters' ), 'slug' => 'indigo', 'color' => '#4B3BD6' ),
			array( 'name' => __( 'Mint', 'eventpromoters' ), 'slug' => 'mint', 'color' => '#3DDC97' ),
			array( 'name' => __( 'Lavendel', 'eventpromoters' ), 'slug' => 'lavender', 'color' => '#EEEBFA' ),
			array( 'name' => __( 'Koraal', 'eventpromoters' ), 'slug' => 'coral', 'color' => '#FF6F59' ),
			array( 'name' => __( 'Crème', 'eventpromoters' ), 'slug' => 'cream', 'color' => '#FAF8F5' ),
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Hoofdmenu', 'eventpromoters' ),
			'footer'  => __( 'Footermenu', 'eventpromoters' ),
		)
	);
}
add_action( 'after_setup_theme', 'eventpromoters_setup' );

/**
 * Content width.
 */
function eventpromoters_content_width() {
	$GLOBALS['content_width'] = 760;
}
add_action( 'after_setup_theme', 'eventpromoters_content_width', 0 );

/**
 * Widget areas.
 */
function eventpromoters_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'eventpromoters' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Wordt getoond naast berichten en archieven.', 'eventpromoters' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'eventpromoters_widgets_init' );

/**
 * Enqueue styles & scripts.
 */
function eventpromoters_assets() {
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'eventpromoters', $uri . '/assets/css/theme.css', array(), EVENTPROMOTERS_VERSION );
	wp_enqueue_script( 'eventpromoters', $uri . '/assets/js/theme.js', array(), EVENTPROMOTERS_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eventpromoters_assets' );

/**
 * Swap `no-js` for `js` before first paint, so the collapsed mobile menu is only
 * used when the toggle script can actually open it.
 */
function eventpromoters_js_class() {
	echo "<script>document.documentElement.className=document.documentElement.className.replace(/\\bno-js\\b/,'js');</script>\n";
}
add_action( 'wp_head', 'eventpromoters_js_class', 0 );

/**
 * Preload the fonts used above the fold: hero title (Cond), brand/nav (Bold), body (DM Sans).
 */
function eventpromoters_preload_fonts() {
	$fonts = array( 'FuturaPTCond-BoldObl.woff2', 'FuturaPT-BoldObl.woff2', 'DMSans-latin.woff2' );
	if ( ! is_front_page() && ! is_404() ) {
		// Other pages have no condensed hero title.
		array_shift( $fonts );
	}
	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_template_directory_uri() . '/assets/fonts/' . $font )
		);
	}
}
add_action( 'wp_head', 'eventpromoters_preload_fonts', 1 );

/**
 * Theme color + favicon fallback (when no Site Icon is set).
 */
function eventpromoters_head_meta() {
	echo '<meta name="theme-color" content="#1E1654">' . "\n";
	if ( ! has_site_icon() ) {
		$img = get_template_directory_uri() . '/assets/images/';
		printf( '<link rel="icon" type="image/png" href="%s" media="(prefers-color-scheme: light)">' . "\n", esc_url( $img . 'favicon.png' ) );
		printf( '<link rel="icon" type="image/png" href="%s" media="(prefers-color-scheme: dark)">' . "\n", esc_url( $img . 'favicon-dark.png' ) );
	}
}
add_action( 'wp_head', 'eventpromoters_head_meta', 2 );

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/contact-form.php';
