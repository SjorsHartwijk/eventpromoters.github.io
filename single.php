<?php
/**
 * Single post.
 *
 * @package Eventpromoters
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="page-hero">
			<div class="wrap wrap--narrow">
				<?php
				$ep_cats = get_the_category_list( ', ' );
				if ( $ep_cats ) {
					echo '<p class="eyebrow">' . wp_kses_post( $ep_cats ) . '</p>';
				}
				the_title( '<h1 class="d page-hero__title">', '</h1>' );
				eventpromoters_posted_on();
				?>
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
				the_tags( '<p class="entry-tags">', ' ', '</p>' );
				?>
			</div>
		</div>

		<div class="wrap wrap--narrow">
			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-label">' . esc_html__( 'Vorige', 'eventpromoters' ) . '</span> %title',
					'next_text' => '<span class="nav-label">' . esc_html__( 'Volgende', 'eventpromoters' ) . '</span> %title',
				)
			);
			?>
		</div>
	</article>

	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile;

get_footer();
