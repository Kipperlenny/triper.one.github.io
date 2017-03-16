<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package triperone
 */

if ( ! is_active_sidebar( 'sidebar-left' ) ) {
	echo '<h1> not active </h1>';
	return;
}
?>

<aside id="userSidebar" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-left' ); ?>
</aside><!-- #secondary -->
