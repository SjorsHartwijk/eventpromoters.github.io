<?php
/**
 * Sidebar.
 *
 * @package Eventpromoters
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside class="sidebar" aria-label="<?php esc_attr_e( 'Zijbalk', 'eventpromoters' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
