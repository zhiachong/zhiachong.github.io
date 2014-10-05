<?php
/**
 * Vintage Camera functions and definitions
 *
 * @package Vintage Camera
 * @since Vintage Camera 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Vintage Camera 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 740; /* pixels */


/**
	 * WordPress.com-specific functions and definitions
	 */
	require( get_template_directory() . '/inc/wpcom.php' );


if ( ! function_exists( 'vintage_camera_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Vintage Camera 1.0
 */
function vintage_camera_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Vintage Camera, use a find and replace
	 * to change 'vintage-camera' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'vintage-camera', get_template_directory() . '/languages' );

	/* Jetpack Infinite Scroll */
	add_theme_support( 'infinite-scroll', array(
		'container'  => 'content',
		'footer'     => 'main',
		'footer_widgets' => 'infinite_scroll_has_footer_widgets'
	) );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'headermenu' => __( 'Header Menu', 'vintage-camera' ),
	) );

	/**
	 * Add support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'audio', 'video', 'status', 'quote', 'link', 'chat' ) );

	/**
	* Add support for editor style
	*/
	add_editor_style();

	/**
	* Add support for post thumbnails
	*/
	add_theme_support( 'post-thumbnails' );

	/**
	 * Add support for custom backgrounds
	 */
	$args = vintage_camera_get_layout_defaults();
	$args = apply_filters( 'vintage_camera_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	}
	else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}

}
endif; // vintage_camera_setup
add_action( 'after_setup_theme', 'vintage_camera_setup' );

/* Filter to add author credit to Infinite Scroll footer */
function vintage_camera_footer_credits( $credit ) {
	$credit = sprintf( __( '%3$s | Theme: %1$s by %2$s.', 'vintage-camera' ), 'Vintage Camera', '<a href="http://carolinemoore.net/" rel="designer">Caroline Moore</a>', '<a href="http://wordpress.org/" title="' . esc_attr( __( 'A Semantic Personal Publishing Platform', 'vintage-camera' ) ) . '" rel="generator">Proudly powered by WordPress</a>' );
	return $credit;
}
add_filter( 'infinite_scroll_credit', 'vintage_camera_footer_credits' );

function infinite_scroll_has_footer_widgets() {
	if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) || has_nav_menu( 'headermenu' ) )
		return true;
	return false;
}


/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Vintage Camera 1.0
 */
function vintage_camera_widgets_init() {
	register_sidebar( array(
		'id'            => 'sidebar-1',
		'name'          => __( 'First Sidebar' , 'vintage-camera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
		)
	);

	register_sidebar( array(
		'id'            => 'sidebar-2',
		'name'          => __( 'Second Sidebar' , 'vintage-camera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
		)
	);

	register_sidebar( array(
		'id'            => 'sidebar-3',
		'name'          => __( 'Third Sidebar' , 'vintage-camera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
		)
	);
}
add_action( 'widgets_init', 'vintage_camera_widgets_init' );


/**
 * Enqueue Google fonts in admin
 */
function vintage_camera_admin_styles() {
	wp_enqueue_style( 'vintage-camera-googlefonts', 'http://fonts.googleapis.com/css?family=Sansita+One|Trochut:400,700,400italic|Alegreya:400italic,700italic,400,700' );
}
add_action( 'admin_enqueue_scripts', 'vintage_camera_admin_styles' );


/**
 * Enqueue scripts and styles
 */
function vintage_camera_scripts() {
	global $post;

	$options = vintage_camera_get_theme_options();
	$vintage_camera_themestyle = $options['theme_style'];
	$vintage_camera_customcss = $options['custom_css'];

	wp_enqueue_style( 'vintage-camera-googlefonts', 'http://fonts.googleapis.com/css?family=Sansita+One|Trochut:400,700,400italic|Alegreya:400italic,700italic,400,700' );

	wp_register_style( 'vintage-camera-mediaie', get_template_directory_uri() . '/layouts/ie.css', 'media-css' );
	wp_register_style( 'vintage-camera-iecolors', get_template_directory_uri() . '/css/iecolors.css' );

	// Enqueue color and layout CSS for IE < 9 in conditional tags
	$GLOBALS['wp_styles']->add_data( 'vintage-camera-iecolors', 'conditional', 'lt IE 9' );
	$GLOBALS['wp_styles']->add_data( 'vintage-camera-mediaie', 'conditional', 'lt IE 9' );
	wp_enqueue_style( 'vintage-camera-iecolors' );
	wp_enqueue_style( 'vintage-camera-mediaie' );

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'vintage-camera-small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'vintage-camera-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	if ( $vintage_camera_customcss ) {
		echo "<style type='text/css'>";
		echo $vintage_camera_customcss;
		echo "</style>";
	}
}
add_action( 'wp_enqueue_scripts', 'vintage_camera_scripts' );


/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );