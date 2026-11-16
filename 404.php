<?php
/**
 * 404 page.
 *
 * @package Eventpromoters
 */

get_header();
?>
<section class="hero hero--compact">
	<div class="hero__dots" aria-hidden="true"></div>
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Fout 404', 'eventpromoters' ); ?></p>
		<h1 class="d hero__title"><?php esc_html_e( 'Deze pagina is', 'eventpromoters' ); ?> <span class="hero__highlight"><?php esc_html_e( 'uitverkocht.', 'eventpromoters' ); ?></span></h1>
		<p class="hero__lead"><?php esc_html_e( 'De pagina die je zoekt bestaat niet (meer). Zoek opnieuw of ga terug naar de homepage.', 'eventpromoters' ); ?></p>
		<?php get_search_form(); ?>
		<div class="btn-row">
			<a class="btn btn--indigo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Naar de homepage', 'eventpromoters' ); ?></a>
		</div>
	</div>
</section>
<?php
get_footer();
