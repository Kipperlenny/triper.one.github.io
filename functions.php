<?php
/**
 * triperone functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package triperone
 */


// set the number of loaded posts per request on "my events" and "global activity"
define("POSTSPERPAGEINDEXPHP", 4);
define("FOUNDPOSTSLIMIT", 4);


/**
	 * Backwards compat shim
	 * register_api_field isn't part of wp rest api anymore
*/
if ( ! function_exists( 'register_api_field' ) ) {
	
	function register_api_field( $object_type, $attributes, $args = array() ) {
		_deprecated_function( 'register_api_field', 'WPAPI-2.0', 'register_rest_field' );
		register_rest_field( $object_type, $attributes, $args );
	}
}


/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more() {
    return sprintf( ' [...]  <a class="read-more" href="%1$s">%2$s</a>', get_permalink(get_the_ID()), __( ' Read More', 'triperone' ));
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );



/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 100;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );



/**
 * Die benötigten Template Parts laden
 * @author Andreas Hecht
 */         
get_template_part('custom-functions/index', 'my-events-functions');
get_template_part('custom-functions/index', 'global-activity-functions');
get_template_part('custom-functions/index', 'filter-functions');
get_template_part('custom-functions/event', 'filter-pagination-functions');
get_template_part('custom-functions/event', 'myevents-pagination-functions');
get_template_part('custom-functions/event', 'global-activity-pagination-functions');
get_template_part('custom-functions/event', 'article-functions');
get_template_part('custom-functions/event', 'index-pagination-functions');
get_template_part('custom-functions/event', 'custom-rest-fields-functions');
get_template_part('custom-functions/event', 'vote-functions');
get_template_part('custom-functions/event', 'new-event-functions');
get_template_part('custom-functions/event', 'join-event-functions');



// change the logo at wp_login.php
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png);
            padding-bottom: 30px;
			height: 200px;
			width: 300px !important;
			background-size: 300px 200px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

//change the link of the logo in the wp_login.php
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );



//add capability to edit events for author
$role = get_role( 'author' );
$role->add_cap( 'edit_posts' );
$role->add_cap( 'edit_events' );
$role->add_cap( 'publish_events' );
$role->add_cap( 'delete_published_events' );




add_action ('init', 'triper_register_events_posttype');
function triper_register_events_posttype(){
	  $labels = array(
		'name'               => _x( 'Events', 'post type general name', 'triperone' ),
		'singular_name'      => _x( 'Event', 'post type singular name', 'triperone' ),
		'menu_name'          => _x( 'Events', 'admin menu', 'triperone' ),
		'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'triperone' ),
		'add_new'            => _x( 'Add New', 'event', 'triperone' ),
		'add_new_item'       => __( 'Add New Event', 'triperone' ),
		'new_item'           => __( 'New Event', 'triperone' ),
		'edit_item'          => __( 'Edit Event', 'triperone' ),
		'view_item'          => __( 'View Event', 'triperone' ),
		'all_items'          => __( 'All Events', 'triperone' ),
		'search_items'       => __( 'Search Events', 'triperone' ),
		'not_found'          => __( 'No events found.', 'triperone' ),
		'not_found_in_trash' => __( 'No events found in Trash.', 'triperone' )
  );
 
	$args = array(
		'label' => 'Events',
		'labels' => $labels,
		'show_in_menu' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => true,
		'menu_position' => 2,
		'menu_icon' => 'dashicons-calendar-alt',
		'supports' => array('title','editor','thumbnail', 'excerpt', 'author', 'custom-fields', 'comments','revisions', 'archives',),
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'post_tag'),
		'rest_base' => 'events',
		'rewrite' => array('slug' => 'events'),
	);
	register_post_type('event', $args);
}



if ( ! function_exists( 'triperone_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function triperone_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on triperone, use a find and replace
	 * to change 'triperone' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'triperone', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 660, 300, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'triperone' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'triperone_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'triperone_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function triperone_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'triperone_content_width', 640 );
}
add_action( 'after_setup_theme', 'triperone_content_width', 0 );

/**
 * Register widget areas. Zwei Funktionen zusammengeführt.
 * @author Andreas Hecht
 */

function triper_sidebars_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Right', 'triperone' ),
		'id'            => 'sidebar-right',
		'description'   => esc_html__( 'Add widgets here.', 'triperone' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
    	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Left', 'triperone' ),
		'id'            => 'sidebar-left',
		'description'   => esc_html__( 'User Info.', 'triperone' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'triper_sidebars_init' );




//https://ikreativ.com/async-with-wordpress-enqueue/
function my_async_scripts($url)
{
    if ( strpos( $url, '#asyncload') === false )
        return $url;
    else if ( is_admin() )
        return str_replace( '#asyncload', '', $url );
    else
	return str_replace( '#asyncload', '', $url )."' async='async"; 
    }
add_filter( 'clean_url', 'my_async_scripts', 11, 1 );


/**
 * emoji aus dem header entfernen, unnötig.
 * @author Andreas Hecht
 */
function disable_emoji_dequeue_script() {
    wp_dequeue_script( 'emoji' );
}
add_action( 'wp_print_scripts', 'disable_emoji_dequeue_script', 100 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
remove_action( 'wp_print_styles', 'print_emoji_styles' );


/**
 * Enqueue scripts and styles.
 * 
 * Andreas Hecht: Unnötig aufgeteiltes CSS zu einer Datei zusammengefügt => Style.css
 */
function triperone_scripts() {
	wp_enqueue_style( 'triperone-style', get_stylesheet_uri() );
	wp_enqueue_style( 'triperone-cs-skin-elastic', get_template_directory_uri() . '/plugins/selectinspiration/css/cs-skin-elastic.css' );
	wp_enqueue_style( 'triperone-cs-select', get_template_directory_uri() . '/plugins/selectinspiration/css/cs-select.css' );
	wp_enqueue_style( 'triperone-ratingsstars', get_template_directory_uri() . '/plugins/ratingstars/ratingstars.css' );
	wp_enqueue_style( 'triperone-font-awesome', get_template_directory_uri() . '/plugins/font-awesome/css/font-awesome.min.css' );

	wp_enqueue_script( 'triperone-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'triperone-pikaday', get_template_directory_uri() . '/js/pikaday.js', array(), '', true );
	wp_enqueue_script( 'triperone-classie', get_template_directory_uri() . '/plugins/selectinspiration/js/classie.js', array(), '', true );
	wp_enqueue_script( 'triperone-selectFx', get_template_directory_uri() . '/plugins/selectinspiration/js/selectFx.js', array(), '', true );
	wp_enqueue_script( 'triperone-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'triperone-map', get_template_directory_uri() . '/js/map.js', array(), '', true );
	wp_enqueue_script( 'triperone-google-map-api', 	"https://maps.googleapis.com/maps/api/js?key=AIzaSyCKw_vf18b0Ob0jHat29pK73OUAce48B7I&callback=initMap&libraries=places&language=de#asyncload", array(), '', true );
    wp_enqueue_script( 'triperone', get_template_directory_uri() . '/js/index.js');

	//wp_enqueue_script( 'triperone-ratingstars', get_template_directory_uri() . '/plugins/ratingstars/ratingstars.js', array('jquery'), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'triperone_scripts' );



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Callback JavaScripts in den Footer laden
 * @author Andreas Hecht
 */
function triper_footer_callback_scripts() {
?>
<!--selectinspiration-->
<script>
    //callback function for select element inside filter form
    function onChangeFilterCategorySelection(el){
        // el === selection value
        console.log(el);
    }
    //callback function for select element inside new event form
    function onChangeNewEventCategorySelection(el){
        // el === selection value
        console.log(el);
    }  
    // "select inspiration" init 
    (function() {

        var newEventCategorySelection = document.getElementById("newEventCategorySelection");
        new SelectFx(newEventCategorySelection,{onChange:onChangeNewEventCategorySelection});
    })();
</script>
<!--pikaday-->
<script>
    var pickerStart = new Pikaday({ field: document.getElementById('searchDatePickerTo') });
    var pickerEnd = new Pikaday({ field: document.getElementById('searchDatePickerFrom') });
    var newEventDateStart = new Pikaday({ field: document.getElementById('newEventDateStart') });
</script>    
<?php }
add_action( 'wp_footer', 'triper_footer_callback_scripts' );


 /* =============================================================================
 Dynamische Copyright Daten im Footer
============================================================================= */

/**
 * Dynamische Copyright Daten im Footer ausgeben. © Von Jahr bis Jahr...
 * <?php echo triper_dynamic_copyright(); ?> - Diesen Tag dorthin einfügen, wo das Copyright erscheinen soll
 * @author Andreas Hecht
 */
function triper_dynamic_copyright() {
global $wpdb;
$copyright_dates = $wpdb->get_results("
SELECT
YEAR(min(post_date_gmt)) AS firstdate,
YEAR(max(post_date_gmt)) AS lastdate
FROM
$wpdb->posts
WHERE
post_status = 'publish'
");
$output = '';
if($copyright_dates) {
$copyright = "&copy; " . $copyright_dates[0]->firstdate;
if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
$copyright .= ' - ' . $copyright_dates[0]->lastdate;
}
$output = $copyright;
}
return $output;
}

 /* =============================================================================
 ### - WordPress Embeds ausschalten
============================================================================= */

/**
 * Disable embeds on init.
 *
 * - Removes the needed query vars.
 * - Disables oEmbed discovery.
 * - Completely removes the related JavaScript.
 *
 * @since 1.0.0
 */
function disable_embeds_init() {
	/* @var WP $wp */
	global $wp;

	// Remove the embed query var.
	$wp->public_query_vars = array_diff( $wp->public_query_vars, array(
		'embed',
	) );

	// Remove the REST API endpoint.
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );

	// Turn off oEmbed auto discovery.
	add_filter( 'embed_oembed_discover', '__return_false' );

	// Don't filter oEmbed results.
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

	// Remove oEmbed discovery links.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

	// Remove oEmbed-specific JavaScript from the front-end and back-end.
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );

	// Remove all embeds rewrite rules.
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

	// Remove filter of the oEmbed result before any HTTP requests are made.
	remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}

add_action( 'init', 'disable_embeds_init', 9999 );

/**
 * Removes the 'wpembed' TinyMCE plugin.
 *
 * @since 1.0.0
 *
 * @param array $plugins List of TinyMCE plugins.
 * @return array The modified list.
 */
function disable_embeds_tiny_mce_plugin( $plugins ) {
	return array_diff( $plugins, array( 'wpembed' ) );
}

/**
 * Remove all rewrite rules related to embeds.
 *
 * @since 1.2.0
 *
 * @param array $rules WordPress rewrite rules.
 * @return array Rewrite rules without embeds rules.
 */
function disable_embeds_rewrites( $rules ) {
	foreach ( $rules as $rule => $rewrite ) {
		if ( false !== strpos( $rewrite, 'embed=true' ) ) {
			unset( $rules[ $rule ] );
		}
	}

	return $rules;
}

/**
 * Remove embeds rewrite rules on plugin activation.
 *
 * @since 1.2.0
 */
function disable_embeds_remove_rewrite_rules() {
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
	flush_rewrite_rules( false );
}

register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );

/**
 * Flush rewrite rules on plugin deactivation.
 *
 * @since 1.2.0
 */
function disable_embeds_flush_rewrite_rules() {
	remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
	flush_rewrite_rules( false );
}

register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );

/* ############## Ende WP Embeds ausschalten ############################################# */


/**
 * Entfernen der potenziell gefährlichen XML-RPC Schnittstelle aus dem HTML-Header der Website
 * @author Andreas Hecht
 */
add_filter( 'wp_headers', 'triper_remove_x_pingback' );
 function triper_remove_x_pingback( $headers )
 {
 unset( $headers['X-Pingback'] );
 return $headers;
 }

 /* =============================================================================
 ### Unnötige Header-Elemente ausblenden
============================================================================= */
/**
 * Befreit den Header von unnötigen Einträgen
 * @author Andreas Hecht
 */ 
add_action('init', 'triper_remheadlink');
function triper_remheadlink()
	{
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'wp_shortlink_header', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	}



/**
 * Keine eigenen Pingbacks zulassen, weil es nervt
 * @author Andreas Hecht
 * 
 */
function triper_no_self_ping( &$links ) {
  $home = get_option( 'home' );
  foreach ( $links as $l => $link )
  if ( 0 === strpos( $link, $home ) )
  unset($links[$l]);
}

add_action( 'pre_ping', 'triper_no_self_ping' );


if ( ! function_exists( 'triper_category' ) ) :
/**
 * Display categories.
 */
function triper_category() {
	$categories = get_the_category();
	$i = 0;
	echo '<div class="cat-links">';
	foreach( $categories as $category ) {
		if ( 0 !== $i++ ) {
			echo '<span class="category-sep">/</span>';
		}
		printf( '<a rel="category tag" href="%1$s" class="category category-%2$s">%3$s</a>',
			esc_url( get_category_link( $category->term_id ) ),
			esc_attr( $category->term_id ),
			esc_html( $category->name )
		);
	}
	echo '</div><!-- .cat-links -->';
	echo "\n";
}
endif;

if ( ! function_exists( 'triper_entry_meta' ) ) :
/**
 * Display post header meta.
 */
function triper_entry_meta() {
	// Hide for pages on Search.
	if ( 'post' != get_post_type() ) {
		return;
	}
	?>
	<div class="entry-meta">
		<?php esc_html_e( 'Posted', 'triperone' ) ?>
		<span class="posted-on"><?php esc_html_e( 'on', 'triperone' ); ?>
		<?php printf( '<a href="%1$s" rel="bookmark"><time class="entry-date published updated" datetime="%2$s">%3$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		); ?>
		</span>
		<span class="byline"><?php esc_html_e( 'by', 'triperone' ); ?>
			<span class="author vcard">
				<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php printf( esc_html__( 'View all posts by %s', 'triperone' ), get_the_author() );?>"><span class="author-name"><?php echo get_the_author();?></span></a>
			</span>
		</span>
		<?php if ( ! post_password_required() && comments_open() ) : ?>
			<span class="entry-meta-sep"> / </span>
			<span class="comments-link">
				<?php comments_popup_link( esc_html__( '0 Comments', 'triperone' ), esc_html__( '1 Comment', 'triperone' ), esc_html__( '% Comments', 'triperone' ) ); ?>
			</span>
		<?php endif; ?>
	</div><!-- .entry-meta -->
	<?php
}
endif;


/**
 * Change the [...] string in the excerpt.
 */
function triper_change_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'triper_change_excerpt_more' );

/**
 * Modify the read more link text
 */
function triper_modify_read_more_link() {
	return '<a class="continue-reading" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_html__( 'Read more &raquo;', 'triperone' ) . '</a>';
}
add_filter( 'the_content_more_link', 'triper_modify_read_more_link' );