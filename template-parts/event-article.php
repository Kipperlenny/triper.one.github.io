<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package triperone
 */


$eventMetaArray = getEventData(get_the_ID());
$userId = get_the_author_meta('ID');
$userAvatarUrl = bp_core_fetch_avatar( array( 'item_id' => $userId, 'html' => false ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php triperone_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	 <div class="thumbnailDiv flexOne">
		<?php if (is_single()):?>
				<?php  
						$thumbnail_id    = get_post_thumbnail_id(get_the_ID());
						$thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

						if ($thumbnail_image && isset($thumbnail_image[0])) {
							$imageAlt = $thumbnail_image[0]->post_name;
						}
				?>
					<a href="<?php the_post_thumbnail_url(); ?>" title="<?php echo $imageAlt; ?>">
						<?php the_post_thumbnail( 'full', array( 'class' => 'featuredImageSingle fullSize' )); ?>
					</a>
		<?php endif; //if is_single ?>
	</div>
	<div class="theContentDiv flexTwo"><?php

			if ( !is_single() ) :
				the_excerpt( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'triperone' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			else : 
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'triperone' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			endif;
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'triperone' ),
					'after'  => '</div>',
				) );
			?>
	</div><!--theContentDiv-->



	<div class="entry-content flex 	<?php if (is_single()):?> flexColumn <?php endif; ?> alignItemsStart ">
	<div class="flexOne">
	<?php  if (get_post_type() === 'event'){?>
		<?php  if(isset($newEventRequestArray)){ ?>
				<p><?php echo 'Host: <a href="'.bp_core_get_user_domain( $userId ).'">'. get_the_author();?><img class="hostAvatar" src="<?php echo $userAvatarUrl; ?>" alt=""></a></p>
				<p><?php echo 'City: '.$newEventRequestArray["city"];?></p>
				<p><?php echo 'Country: '.$newEventRequestArray["country"];?></p>
				<p><?php echo 'Date: '. date('d M Y', $newEventRequestArray["dateStart"]); ?></p>
				<p><?php echo 'Time: '. date('h:i a', $newEventRequestArray["dateStart"]); ?></p>
				<p><?php echo 'maxParticipants: '.$newEventRequestArray["maxParticipants"];?></p>
		<?php } else { ?> 
				<p><?php echo 'Host: <a href="'.bp_core_get_user_domain( $userId ).'">'. get_the_author();?><img class="hostAvatar" src="<?php echo $userAvatarUrl; ?>" alt=""></a></p>
				<p>Country: <?php echo $eventMetaArray->country; ?></p>
				<p>City: <?php echo $eventMetaArray->city; ?></p>
				<p>Date: <?php echo date('d M Y', $eventMetaArray->date_start); ?></p>
				<p>Time: <?php echo date('h:i a', $eventMetaArray->date_start); ?></p>
				<?php  if ($eventMetaArray->max_participants > 0) {?>
					<p>Max. participants: <?php echo $eventMetaArray->max_participants; ?></p>
				<?php  }?>
			<?php  	} ?>
		<?php }// if post type === event ?>
	
	<footer class="entry-footer"> 
			<div class="commentEditDelete">
				<?php triperone_entry_footer(); ?>
			</div>
		<?php  get_template_part('template-parts/event', 'button');?>
	</footer><!-- .entry-footer -->
	
	<?php  get_template_part('template-parts/event', 'vote');?>
	<?php  get_template_part('template-parts/event', 'avarage-vote');?>
		</div><!-- .entry-content -->	
		
		<?php
		 if ( has_post_thumbnail() ) : ?>
		 	<?php  if(!is_single()){?>
			 <div class="thumbnailDiv flexOne">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail( 'medium', array( 'class' => 'img-thumbnail' )); ?>
					</a>
			</div>	
			<?php  }// if is not single?>
	<?php 
		endif; 
		?>
	</div>
	
</article><!-- #post-## -->
