<?php
/**
 * Single page.
 *
 * @package Eventpromoters
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="page-hero">
			<div class="wrap">
				<?php the_title( '<h1 class="d page-hero__title">', '</h1>' ); ?>
				<?php if ( has_excerpt() ) : ?>
					<div class="page-hero__intro"><?php the_excerpt(); ?></div>
				<?php endif; ?>
			</div>
		</header>

		<div class="section section--tight">
			<div class="wrap wrap--narrow entry-content">
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="entry-media"><?php the_post_thumbnail( 'large' ); ?></figure>
				<?php endif; ?>
				<?php
				the_content();
				wp_link_pages(
					array(
						'before' => '<nav class="page-links">' . esc_html__( "Pagina's:", 'eventpromoters' ),
						'after'  => '</nav>',
					)
				);
				?>
			</div>
		</div>
	</article>

	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile;

get_footer();
