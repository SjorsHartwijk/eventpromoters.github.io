<?php
/**
 * Post card used in archives.
 *
 * @package Eventpromoters
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card post-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'medium_large' ); ?>
		</a>
	<?php endif; ?>
	<?php eventpromoters_posted_on(); ?>
	<h2 class="d card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php the_excerpt(); ?>
	<a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Lees verder', 'eventpromoters' ); ?><span class="screen-reader-text"> <?php the_title(); ?></span> →</a>
</article>
