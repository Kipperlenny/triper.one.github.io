<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package triperone
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>

<body <?php body_class( 'myEvents'); ?>>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#content">
            <?php esc_html_e( 'Skip to content', 'triperone' ); ?>
        </a>
        <header id="masthead" class="site-header" role="banner">
           <div class="wrapper">
            <div class="site-branding zilla-one-fourth">
                <div class="logo">
                    <?php triper_logo(); ?>
                </div>
                <?php triper_site_title(); ?>
                    <?php if ( ! get_theme_mod( 'triper_hide_blogdescription' ) ) : ?>
                        <div class="site-description">
                            <?php bloginfo( 'description' ); ?>
                        </div>
                        <?php endif; ?>
                </div><!-- .site-branding -->
                <nav id="site-navigation" class="main-navigation zilla-three-fourth zilla-column-last" role="navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <?php esc_html_e( 'Primary Menu', 'triperone' ); ?>
                </button>
                <?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'menu_class' => 'nav-menu') ); ?>
            </nav>
            <!-- #site-navigation -->
            </div><!-- /.wrapper -->
        </header>
        <!-- #masthead -->