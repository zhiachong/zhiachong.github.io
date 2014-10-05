<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Vintage Camera
 * @since Vintage Camera 1.0
 */


/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @uses vintage_camera_header_style()
 * @uses vintage_camera_admin_header_style()
 * @uses vintage_camera_admin_header_image()
 *
 * @package Vintage Camera
 */
function vintage_camera_custom_header_setup() {
	$options = vintage_camera_get_theme_options();
	$camerastyle = $options['theme_style'];
	
	$defaults = vintage_camera_get_layout_defaults();

	if( isset( $camerastyle ) && '' == $camerastyle || false == $camerastyle )
		$camerastyle = 'k1000';

	$args = array(
		'default-image'          => get_template_directory_uri() . '/img/headers/' . $camerastyle . '.png',
		'default-text-color'     => $defaults['default-text-color'],
		'width'                  => 600,
		'height'                 => 300,
		'flex-width'             => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'vintage_camera_header_style',
		'admin-head-callback'    => 'vintage_camera_admin_header_style',
		'admin-preview-callback' => 'vintage_camera_admin_header_image',
	);

	$args = apply_filters( 'vintage_camera_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'brownie' => array(
			'url'           => '%s/img/headers/brownie.png',
			'thumbnail_url' => '%s/img/headers/brownie-thumbnail.png',
			'description'   => __( 'Brownie', 'vintage-camera' )
		),
		'polaroid' => array(
			'url'           => '%s/img/headers/polaroid.png',
			'thumbnail_url' => '%s/img/headers/polaroid-thumbnail.png',
			'description'   => __( 'Land', 'vintage-camera' )
		),
		'diana' => array(
			'url'           => '%s/img/headers/diana.png',
			'thumbnail_url' => '%s/img/headers/diana-thumbnail.png',
			'description'   => __( 'Diana', 'vintage-camera' )
		),
		'k1000' => array(
			'url'           => '%s/img/headers/k1000.png',
			'thumbnail_url' => '%s/img/headers/k1000-thumbnail.png',
			'description'   => __( 'K1000', 'vintage-camera' )
		),
		'sabre' => array(
			'url'           => '%s/img/headers/sabre.png',
			'thumbnail_url' => '%s/img/headers/sabre-thumbnail.png',
			'description'   => __( 'Sabre', 'vintage-camera' )
		),
		'savoy' => array(
			'url'           => '%s/img/headers/savoy.png',
			'thumbnail_url' => '%s/img/headers/savoy-thumbnail.png',
			'description'   => __( 'Savoy', 'vintage-camera' )
		)
	) );
}
add_action( 'after_setup_theme', 'vintage_camera_custom_header_setup' );


if ( ! function_exists( 'vintage_camera_header_setup' ) ) :
/**
 * Styles the header image and text displayed on the blog
 */
function vintage_camera_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description,
		.divider {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // vintage_camera_header_style


if ( ! function_exists( 'vintage_camera_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in vintage_camera_custom_header_setup().
 */
function vintage_camera_admin_header_style() {
?>	
	<?php $defaults = vintage_camera_get_layout_defaults(); ?>
	
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		background: #<?php echo get_theme_mod( 'background_color', $defaults['default-color'] ); ?> url('<?php echo get_theme_mod( 'background_image', $defaults['default-image'] ); ?>') <?php echo get_theme_mod( 'background_repeat', 'repeat' ); ?> <?php echo get_theme_mod( 'background_position_x', 'left' ); ?> top;
	}
	#headimg h1 a {
		font-family: "Sansita One", sans-serif;
		font-size: 42px;
		clear: both;
		display: block;
		text-align: center;
		margin-bottom: 20px;
		margin-top: 30px;
		line-height: normal;
		text-decoration: none;
	}
	#description {
		font-style: italic;
		font-family: Trochut, serif;
		margin-top: 15px;
		text-align: center;
		color: #<?php echo $defaults['default-description-color']; ?>;
		clear: both;
		margin-bottom: 30px;
		font-size: 21px;
	}
	#headimg img {
		margin: 0 auto;
		display: block;
	}
	.divider {
		margin: auto;
		padding: 0;
		width: 120px;
		height: 10px;
		position: relative;
		clear: both;
		display: block;
		background-image:url(<?php echo get_template_directory_uri(); ?>/img/doodle.png);
		background-repeat: no-repeat;
	}
	</style>
<?php
}
endif; // vintage_camera_admin_header_style


if ( ! function_exists( 'vintage_camera_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in vintage_camera_setup().
 */
function vintage_camera_admin_header_image() { ?>
	<div id="headimg">
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
		<?php
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="divider"></div>
		<div id="description"><?php bloginfo( 'description' ); ?></div>
	</div>
<?php }
endif; // vintage_camera_admin_header_image


if ( ! function_exists( 'get_custom_header' ) ) {
/**
 * Return custom header information
 */
function get_custom_header() {
	return (object) array(
		'url' => get_header_image(),
		'thumbnail_url' => get_header_image(),
		'width' => HEADER_IMAGE_WIDTH,
		'height' => HEADER_IMAGE_HEIGHT,
	);
}
}