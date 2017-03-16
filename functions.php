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


//$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);


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




add_action ('init', 'register_events_posttype');
function register_events_posttype(){
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
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function triperone_sidebar_left_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Left', 'triperone' ),
		'id'            => 'sidebar-left',
		'description'   => esc_html__( 'User Info.', 'triperone' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'triperone_sidebar_left_widgets_init' );

function triperone_sidebar_right_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Right', 'triperone' ),
		'id'            => 'sidebar-right',
		'description'   => esc_html__( 'Add widgets here.', 'triperone' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'triperone_sidebar_right_widgets_init' );




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
 * Enqueue scripts and styles.
 */
function triperone_scripts() {
	wp_enqueue_style( 'triperone-style', get_stylesheet_uri() );
	wp_enqueue_style( 'triperone-main', get_template_directory_uri() . '/css/main.css' );
	wp_enqueue_style( 'triperone-flex', get_template_directory_uri() . '/css/flex.css' );
	wp_enqueue_style( 'triperone-header', get_template_directory_uri() . '/css/header.css' );
	wp_enqueue_style( 'triperone-index', get_template_directory_uri() . '/css/index.css' );
	wp_enqueue_style( 'triperone-page', get_template_directory_uri() . '/css/page.css' );
	wp_enqueue_style( 'triperone-sidebar-right', get_template_directory_uri() . '/css/sidebar-right.css' );
	wp_enqueue_style( 'triperone-sidebar-left', get_template_directory_uri() . '/css/sidebar-left.css' );
	wp_enqueue_style( 'triperone-pikaday', get_template_directory_uri() . '/css/pikaday.css' );
	wp_enqueue_style( 'triperone-cs-skin-elastic', get_template_directory_uri() . '/plugins/selectinspiration/css/cs-skin-elastic.css' );
	wp_enqueue_style( 'triperone-cs-select', get_template_directory_uri() . '/plugins/selectinspiration/css/cs-select.css' );
	wp_enqueue_style( 'triperone-ratingsstars', get_template_directory_uri() . '/plugins/ratingstars/ratingstars.css' );
	wp_enqueue_style( 'triperone-font-awesome', get_template_directory_uri() . '/plugins/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'triperone-tablet', get_template_directory_uri() . '/css/tablet.css' );

	wp_enqueue_script( 'triperone-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'triperone-pikaday', get_template_directory_uri() . '/js/pikaday.js', array(), '', true );
	wp_enqueue_script( 'triperone-classie', get_template_directory_uri() . '/plugins/selectinspiration/js/classie.js', array(), '', true );
	wp_enqueue_script( 'triperone-selectFx', get_template_directory_uri() . '/plugins/selectinspiration/js/selectFx.js', array(), '', true );
	wp_enqueue_script( 'triperone-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'triperone-map', get_template_directory_uri() . '/js/map.js', array(), '', true );
	wp_enqueue_script( 'triperone-google-map-api', 	"https://maps.googleapis.com/maps/api/js?key=AIzaSyCKw_vf18b0Ob0jHat29pK73OUAce48B7I&callback=initMap&libraries=places&language=de#asyncload", array(), '', true );

	//wp_enqueue_script( 'triperone-ratingstars', get_template_directory_uri() . '/plugins/ratingstars/ratingstars.js', array('jquery'), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'triperone_scripts' );

//register scripts for loading right before the closing body tag 
function enqueue_footer_scripts(){
	wp_enqueue_script( 'triperone-indexjs', get_template_directory_uri() . '/js/index.js');
}
add_action( 'wp_footer', 'enqueue_footer_scripts');



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
