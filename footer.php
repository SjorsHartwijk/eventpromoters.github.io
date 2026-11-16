<?php
/**
 * Site footer.
 *
 * @package Eventpromoters
 */

$ep_email = eventpromoters_mod( 'contact_email' );
$ep_phone = eventpromoters_mod( 'contact_phone' );
$ep_socials = eventpromoters_socials();
?>
</main>

<footer class="site-footer">
	<div class="wrap">
		<div class="site-footer__grid">
			<div>
				<p class="d site-footer__brand"><?php bloginfo( 'name' ); ?></p>
				<p><?php echo esc_html( eventpromoters_mod( 'footer_text' ) ); ?></p>
			</div>

			<div>
				<h2 class="site-footer__title"><?php esc_html_e( 'Links', 'eventpromoters' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'footer-links',
						'depth'          => 1,
						'fallback_cb'    => 'eventpromoters_footer_fallback',
					)
				);
				?>
			</div>

			<div>
				<h2 class="site-footer__title"><?php esc_html_e( 'Contact', 'eventpromoters' ); ?></h2>
				<ul class="footer-links">
					<?php if ( $ep_email ) : ?>
						<li><a href="<?php echo esc_url( 'mailto:' . antispambot( $ep_email ) ); ?>"><?php echo esc_html( antispambot( $ep_email ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( $ep_phone ) : ?>
						<li><a href="<?php echo esc_url( eventpromoters_tel( $ep_phone ) ); ?>"><?php echo esc_html( $ep_phone ); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>

			<?php if ( $ep_socials ) : ?>
				<div>
					<h2 class="site-footer__title"><?php esc_html_e( 'Volg ons', 'eventpromoters' ); ?></h2>
					<ul class="footer-links">
						<?php foreach ( $ep_socials as $ep_social ) : ?>
							<li><a href="<?php echo esc_url( $ep_social['url'] ); ?>" rel="noopener" target="_blank"><?php echo esc_html( $ep_social['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>

		<p class="site-footer__copy">&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Alle rechten voorbehouden.', 'eventpromoters' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
