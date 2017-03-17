<?php
/**
 * Genutzt um den Blog anzuzeigen => ehemaliger Inhalt ausgelagert auf template-frontpage.php
 * @author Andreas Hecht
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Graphy
 */

get_header(); ?>

<div id="content" class="site-content themeform">

  <?php get_sidebar('left'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content' ); ?>

			<?php endwhile; ?>

			<?php
			the_posts_pagination( array(
				'prev_text' => esc_html__( '&laquo; Previous', 'triperone' ),
				'next_text' => esc_html__( 'Next &raquo;', 'triperone' ),
			) );
			?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar('right' ); ?>
  
   </div><!-- #content -->
    
<?php get_footer(); ?>