<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package triperone
 */

if ( ! function_exists( 'triperone_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function triperone_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'triperone' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'triperone' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;



if ( ! function_exists( 'triperone_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function triperone_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'event' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'triperone' ) );
		$postId = get_the_ID();
		if ( $categories_list && triperone_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in:', 'triperone' ) .'<br>'.' %1$s'. '</span>', iterateSlugs($postId) ); // WPCS: XSS OK.
		}


		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'triperone' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged: ', 'triperone' ) .'<br>'.' %1$s'. '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<br><span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'triperone' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'triperone' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<br><span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function triperone_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'triperone_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'triperone_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so triperone_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so triperone_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in triperone_categorized_blog.
 */
function triperone_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'triperone_categories' );
}
add_action( 'edit_category', 'triperone_category_transient_flusher' );
add_action( 'save_post',     'triperone_category_transient_flusher' );





if ( ! function_exists( 'triper_logo' ) ) :
/**
 * Zeigt das Logo an und nutzt den Customizer dazu
 * @author Andreas Hecht
 */
function triper_logo() {
	if ( ! get_theme_mod( 'triper_logo' ) ) {
		return;
	}
	$logo_tag = ( is_front_page() && get_theme_mod( 'triper_replace_blogname' ) ) ? 'div' : 'div';
	$logo_alt = ( get_theme_mod( 'triper_replace_blogname' ) ) ? get_bloginfo( 'name' ) : '';
	$logo_src = esc_url( get_theme_mod( 'triper_logo' ) );
	if ( get_theme_mod( 'triper_retina_logo' ) ) :
		list( $logo_width ) = getimagesize( $logo_src );
		$logo_width = round( $logo_width / 2 ); ?>
		<<?php echo esc_attr( $logo_tag ); ?> class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img alt="<?php echo esc_attr( $logo_alt ); ?>" src="<?php echo esc_attr( $logo_src ); ?>" /></a></<?php echo esc_attr( $logo_tag ); ?>>
	<?php else: ?>
		<<?php echo esc_attr( $logo_tag ); ?> class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img alt="<?php echo esc_attr( $logo_alt ); ?>" src="<?php echo esc_attr( $logo_src ); ?>" /></a></<?php echo esc_attr( $logo_tag ); ?>>
	<?php endif;
}
endif;


if ( ! function_exists( 'triper_site_title' ) ) :
/**
 * Zeigt den Titel der Website an oder auch nicht, wenn Logo in Verwendung
 * @author Andreas Hecht
 */
function triper_site_title() {
	if ( get_theme_mod( 'triper_logo' ) && get_theme_mod( 'triper_replace_blogname' ) ) {
		return;
	}
	$title_tag = ( is_front_page() ) ? 'div' : 'div';
	?>
	<<?php echo esc_attr( $title_tag ); ?> class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></<?php echo esc_attr( $title_tag ); ?>>
	<?php
}
endif;
