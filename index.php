<?php
/**
 * Main template: blog index and fallback for archives & search.
 *
 * @package Eventpromoters
 */

get_header();
?>

<header class="page-hero">
	<div class="wrap">
		<?php if ( is_home() && ! is_front_page() ) : ?>
			<p class="eyebrow"><?php esc_html_e( 'Blog', 'eventpromoters' ); ?></p>
			<h1 class="d page-hero__title"><?php single_post_title(); ?></h1>
		<?php elseif ( is_search() ) : ?>
			<p class="eyebrow"><?php esc_html_e( 'Zoekresultaten', 'eventpromoters' ); ?></p>
			<h1 class="d page-hero__title"><?php echo esc_html( get_search_query() ); ?></h1>
		<?php elseif ( is_archive() ) : ?>
			<p class="eyebrow"><?php esc_html_e( 'Archief', 'eventpromoters' ); ?></p>
			<?php the_archive_title( '<h1 class="d page-hero__title">', '</h1>' ); ?>
			<?php the_archive_description( '<div class="page-hero__intro">', '</div>' ); ?>
		<?php else : ?>
			<h1 class="d page-hero__title"><?php esc_html_e( 'Nieuws', 'eventpromoters' ); ?></h1>
		<?php endif; ?>
	</div>
</header>

<div class="section section--tight">
	<div class="wrap layout<?php echo is_active_sidebar( 'sidebar-1' ) ? ' layout--sidebar' : ''; ?>">
		<div>
			<?php if ( have_posts() ) : ?>
				<div class="grid grid--2">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'card' );
					endwhile;
					?>
				</div>
				<?php
				the_posts_pagination(
					array(
						'prev_text' => __( 'Vorige', 'eventpromoters' ),
						'next_text' => __( 'Volgende', 'eventpromoters' ),
					)
				);
				?>
			<?php else : ?>
				<div class="entry-content">
					<p><?php esc_html_e( 'Er is (nog) niets gevonden. Probeer een andere zoekterm.', 'eventpromoters' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
