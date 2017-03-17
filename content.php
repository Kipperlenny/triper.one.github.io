<?php
/**
 * Zeigt den Inhalt der einzelnen Beiträge an. =>single.php
 * @author Andreas Hecht
 * @package triperone
 */
 ?>
<div class="post-full post-full-summary">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_sticky() && is_home() && ! is_paged() ): ?>
			<div class="featured"><?php esc_html_e( 'Featured', 'triperone' ); ?></div>
			<?php endif; ?>
			<?php triper_category(); ?>
			<?php if( is_single() ) : ?>
			<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php else : ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php endif; ?>
			<?php do_action( 'sharing-top' );?>
			<?php triper_entry_meta(); ?>
			<?php if ( has_post_thumbnail() ): ?>
			<div class="post-thumbnail">
			<?php if( is_single() ) : ?>
				<?php the_post_thumbnail(); ?>
				<?php else : ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				<?php endif; ?>
			</div><!-- .post-thumbnail -->
			<?php endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array(	'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'triperone' ), 'after'  => '</div>', 'pagelink' => '<span class="page-numbers">%</span>',  ) ); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-## -->
</div><!-- .post-full -->