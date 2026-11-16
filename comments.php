<?php
/**
 * Comments.
 *
 * @package Eventpromoters
 */

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="section section--tight comments">
	<div class="wrap wrap--narrow">
		<?php if ( have_comments() ) : ?>
			<h2 class="d comments__title">
				<?php
				printf(
					/* translators: %s: number of comments */
					esc_html( _n( '%s reactie', '%s reacties', get_comments_number(), 'eventpromoters' ) ),
					esc_html( number_format_i18n( get_comments_number() ) )
				);
				?>
			</h2>
			<ol class="comment-list">
				<?php
				wp_list_comments(
					array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 48,
					)
				);
				?>
			</ol>
			<?php the_comments_navigation(); ?>
		<?php endif; ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Reageren is gesloten.', 'eventpromoters' ); ?></p>
		<?php endif; ?>

		<?php
		comment_form(
			array(
				'class_submit' => 'btn btn--navy',
				'title_reply'  => __( 'Laat een reactie achter', 'eventpromoters' ),
			)
		);
		?>
	</div>
</section>
