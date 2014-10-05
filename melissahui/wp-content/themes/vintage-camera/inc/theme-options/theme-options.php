<?php
/**
 * Vintage Camera Theme Options
 *
 * @package Vintage Camera

 */

/**
 * Register the form setting for our vintage_camera_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, vintage_camera_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *

 */
function vintage_camera_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === vintage_camera_get_theme_options() )
		add_option( 'vintage_camera_theme_options', vintage_camera_get_default_theme_options() );

	register_setting(
		'vintage_camera_options',       // Options group, see settings_fields() call in vintage_camera_theme_options_render_page()
		'vintage_camera_theme_options', // Database option, see vintage_camera_get_theme_options()
		'vintage_camera_theme_options_validate' // The sanitization callback, see vintage_camera_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'theme_options' // Menu slug, used to uniquely identify the page; see vintage_camera_theme_options_add_page()
	);

	/* Register our individual settings fields */

	add_settings_field( 'vintage_camera_theme_style', __( 'Theme Style', 'vintage-camera' ), 'vintage_camera_settings_field_theme_style', 'theme_options', 'general' );

	add_settings_field( 'vintage_camera_custom_css', __( 'Custom CSS', 'vintage-camera' ), 'vintage_camera_settings_field_custom_css', 'theme_options', 'general' );

	add_settings_field(
		'vintage_camera_support', // Unique identifier for the field for this section
		__( 'Support Caroline Themes', 'vintage-camera' ), // Setting field label
		'vintage_camera_settings_field_support', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see _s_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);

}
add_action( 'admin_init', 'vintage_camera_theme_options_init' );

/**
 * Change the capability required to save the 'vintage_camera_options' options group.
 *
 * @see vintage_camera_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see vintage_camera_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function vintage_camera_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_vintage_camera_options', 'vintage_camera_option_page_capability' );

/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *

 */
function vintage_camera_theme_options_add_page() {
	global $vintagecamera_options_hook;
	$vintagecamera_options_hook = add_theme_page(
		__( 'Theme Options', 'vintage-camera' ),   // Name of page
		__( 'Theme Options', 'vintage-camera' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'vintage_camera_theme_options_render_page' // Function that renders the options page
	);

	if ( ! $vintagecamera_options_hook )
		return;

	add_action('load-'.$vintagecamera_options_hook, 'vintagecamera_contextual_help', 10, 3);
}
add_action( 'admin_menu', 'vintage_camera_theme_options_add_page' );

/**
 * Returns an array of Theme Style options registered for Vintage Camera.
 *

 */
function vintage_camera_theme_style() {
	$vintage_camera_theme_style = array(
		'k1000' => array(
			'value' => 'k1000',
			'label' => __( 'K1000', 'vintage-camera' ),
			'defaults' => array(
				'default-color' => 'ededed',
				'default-image' => get_template_directory_uri() . '/img/background-light.png',
				'default-text-color' => '333',
				'default-description-color' => 'a9c137',
				'default-header-image' => get_template_directory_uri() . '/img/headers/k1000.png',
			)
		),
		'brownie' => array(
			'value' => 'brownie',
			'label' => __( 'Brownie', 'vintage-camera' ),
			'defaults' => array(
				'default-color' => 'c0b5a4',
				'default-image' => get_template_directory_uri() . '/img/background.png',
				'default-text-color' => '333',
				'default-description-color' => 'a1440b',
				'default-header-image' => get_template_directory_uri() . '/img/headers/brownie.png',
			)
		),
		'polaroid' => array(
			'value' => 'polaroid',
			'label' => __( 'Land', 'vintage-camera' ),
			'defaults' => array(
				'default-color' => 'c4c4c4',
				'default-image' => get_template_directory_uri() . '/img/background.png',
				'default-text-color' => 'fff',
				'default-description-color' => 'a5443f',
				'default-header-image' => get_template_directory_uri() . '/img/headers/polaroid.png',
			)
		),
		'diana' => array(
			'value' => 'diana',
			'label' => __( 'Diana', 'vintage-camera' ),
			'defaults' => array(
				'default-color' => '555',
				'default-image' => get_template_directory_uri() . '/img/background-dark.png',
				'default-text-color' => 'fff',
				'default-description-color' => '5ab9c1',
				'default-header-image' => get_template_directory_uri() . '/img/headers/diana.png',
			)
		),
		'sabre' => array(
			'value' => 'sabre',
			'label' => __( 'Sabre', 'vintage-camera' ),
			'defaults' => array(
				'default-color' => 'e7e4d3',
				'default-image' => get_template_directory_uri() . '/img/background-light.png',
				'default-text-color' => '333',
				'default-description-color' => 'e27d8c',
				'default-header-image' => get_template_directory_uri() . '/img/headers/sabre.png',
			)
		),
		'savoy' => array(
			'value' => 'savoy',
			'label' => __( 'Savoy', 'vintage-camera' ),
			'defaults' => array(
				'default-color' => 'e7e4d3',
				'default-image' => get_template_directory_uri() . '/img/background-light.png',
				'default-text-color' => '333',
				'default-description-color' => 'c64',
				'default-header-image' => get_template_directory_uri() . '/img/headers/savoy.png',
			)
		)
	);

	return apply_filters( 'vintage_camera_theme_style', $vintage_camera_theme_style );
}

/**
 * Returns the default options for Vintage Camera.
 *
 */
function vintage_camera_get_default_theme_options() {
	$default_theme_options = array(
		'theme_style' => 'k1000',
		'custom_css' => '',
		'support' => 0
	);

	return apply_filters( 'vintage_camera_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for Vintage Camera.
 *
 */
function vintage_camera_get_theme_options() {
	return get_option( 'vintage_camera_theme_options', vintage_camera_get_default_theme_options() );
}

/**
 * Renders the Theme Style setting field.
 *
 */
function vintage_camera_settings_field_theme_style() {
	$options = vintage_camera_get_theme_options();

	foreach ( vintage_camera_theme_style() as $button ) {
	?>
	<div class="layout">
		<label class="description">
			<img src="<?php echo get_template_directory_uri() ?>/img/ss/<?php echo $button['value']; ?>.png" alt="<?php echo $button['label']; ?> Style" /><br />
			<input type="radio" name="vintage_camera_theme_options[theme_style]" value="<?php echo esc_attr( $button['value'] ); ?>" <?php checked( $options['theme_style'], $button['value'] ); ?> />
			<?php echo $button['label']; ?>
		</label>
	</div>
	<?php
	}
}


/**
 * Renders the Custom CSS setting field.
 *
 */
function vintage_camera_settings_field_custom_css() {
	$options = vintage_camera_get_theme_options();
	?>
	<textarea class="large-text" type="text" name="vintage_camera_theme_options[custom_css]" id="custom_css" cols="50" rows="10" /><?php echo esc_textarea( $options['custom_css'] ); ?></textarea>
	<label class="description" for="custom_css"><?php _e( 'Add any custom CSS rules here so they will persist through theme updates.', 'vintage-camera' ); ?></label>
	<?php
}

/**
 * Renders the Support setting field.
 */
function vintage_camera_settings_field_support() {
	$options = vintage_camera_get_theme_options();

	if ( $options['support'] !== 'on' || !isset( $options['support'] ) ) {

	?>
	<label for"vintage-camera-support">
		<a href="<?php echo esc_url( 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6G3NYZ5EN28EY' ); ?>" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="PayPal - The safer, easier way to pay online!" class="alignright"></a>
		<?php _e( 'If you enjoy my themes, please consider making a secure donation using the PayPal button to your right. Anything is appreciated!', 'vintage-camera' ); ?>

		<br /><input type="checkbox" name="vintage_camera_theme_options[support]" id="support" <?php checked( 'on', $options['support'] ); ?> />
		<label class="description" for="support">
			<?php _e( 'No, thank you! Dismiss this message.', 'vintage-camera' ); ?>
		</label>
	</label>
	<?php
	}
	else { ?>
		<label class="description" for="support">
			<?php _e( 'Hide Donate Button', 'vintage-camera' ); ?>
		</label>
		<input type="checkbox" name="vintage_camera_theme_options[support]" id="support" <?php checked( 'on', $options['support'] ); ?> />

	</td>

	<?php
	}

}

/**
 * Returns the options array for Vintage Camera.
 */
function vintage_camera_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'vintage-camera' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'vintage_camera_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}


/**
 * Returns layout defaults
 */
function vintage_camera_get_layout_defaults() {
	$options = vintage_camera_get_theme_options();
	$theme_style = $options['theme_style'];

	$default_theme_options = vintage_camera_get_default_theme_options();
	$default_theme_style = $default_theme_options['theme_style'];

	$theme_style_values = vintage_camera_theme_style();

	if ( $theme_style ) {
		$defaults = $theme_style_values[$theme_style]['defaults'];
	} else {
		$defaults = $theme_style_values[$default_theme_style]['defaults'];
	}

	return apply_filters( 'vintage_camera_get_layout_defaults', $defaults );
}


/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see vintage_camera_theme_options_init()
 * @todo set up Reset Options action
 *

 */
function vintage_camera_theme_options_validate( $input ) {
	$output = $defaults = vintage_camera_get_default_theme_options();
	$theme_settings = vintage_camera_theme_style();
	$current_theme_options = vintage_camera_get_theme_options();

	// The sample Theme Styles value must be in our array of Theme Styles values
	if ( isset( $input['theme_style'] ) && array_key_exists( $input['theme_style'], vintage_camera_theme_style() ) ) {
		$output['theme_style'] = $input['theme_style'];

		// If user selects new theme_style, set bg-color automatically
		if ( $current_theme_options['theme_style'] != $input['theme_style'] ) {
			set_theme_mod( 'background_color', $theme_settings[$input['theme_style']]['defaults']['default-color'] );
		}
	}

	// The Support field should either be on or off
	if ( ! isset( $input['support'] ) )
		$input['support'] = 'off';
	$output['support'] = ( $input['support'] == 'on' ? 'on' : 'off' );

	// The Custom CSS must be safe text with the allowed tags for posts
	if ( isset( $input['custom_css'] ) )
		$output['custom_css'] = wp_filter_nohtml_kses( $input['custom_css'] );

	return apply_filters( 'vintage_camera_theme_options_validate', $output, $input, $defaults );
}

/**
 * Theme Options Admin Styles
*/

function vintage_camera_theme_options_admin_styles() {
	echo "<style type='text/css'>";
	echo ".layout .description { width: 300px; float: left; text-align: center; margin-bottom: 10px; padding: 10px; }";
	echo "</style>";
}

add_action( 'admin_print_styles-appearance_page_theme_options', 'vintage_camera_theme_options_admin_styles' );

/**
 * Add a contextual help menu to the Theme Options panel
 */
function vintagecamera_contextual_help() {

	global $vintagecamera_options_hook;

	$screen = get_current_screen();

	if ( $screen->id == $vintagecamera_options_hook ) {

		//Store Theme Options tab in variable
		$theme_options_content = '<p><a href="http://wordpress.org/tags/vintage-camera?forum_id=5" target="_blank">' . __( 'For basic support, please post in the WordPress forums.', 'vintage-camera' ) . '</a></p>';
		$theme_options_content .= '<p><strong>' . __( 'Theme Style', 'vintage-camera' ) . '</strong> - ' . __( 'This is where you can choose the overall look and feel of your blog. Defaults to K1000.', 'vintage-camera' ) . '</p>';
		$theme_options_content .= '<p><strong>' . __( 'Custom CSS', 'vintage-camera' ) . '</strong> - ' . __( 'You can override the theme\'s default CSS by putting your own code here.  It should be in the format:', 'vintage-camera' ) . '</p>';
		$theme_options_content .= '<blockquote><pre>.some-class { width: 100px; }</pre>';
		$theme_options_content .= '<pre>#some-id { background-color: #fff; }</pre></blockquote>';
		$theme_options_content .= '<p>' . __( 'Replacing any classes, ID\'s, etc. with the ones you want to override, and within them the attributes you want to change.', 'vintage-camera' ) . '</p>';
		$theme_options_content .= '<p><strong>' . __( 'Support Caroline Themes/Hide Donate Button', 'vintage-camera' ) . '</strong> - ' . __( 'If you like my themes and find them useful, please donate!  Checking the box will hide this information.', 'vintage-camera' ) . '</p>';
		$theme_options_content .= '<p><a href="http://www.carolinethemes.com" target="_blank">' . __( 'Visit Caroline Themes for more free WordPress themes!', 'vintage-camera' ) . '</a></p>';

		$screen->add_help_tab( array (
				'id' => 'vintage-camera-theme-options',
				'title' => __( 'Theme Options', 'vintage-camera' ),
				'content' => $theme_options_content
				)
		);

	}
}


/**
 * Add support for Theme Options in the Customizer
 */
function vintage_camera_customize_register( $wp_customize ) {

	$wp_customize->add_section( 'vintage_camera_theme_options', array(
		'title'		=> __( 'Theme Options', 'vintage-camera' ),
		'priority'	=> 35,
		'transport'	=> 'postMessage',
	) );

	$wp_customize->add_setting( 'vintage_camera_theme_options[theme_style]', array(
		'default'		=> 'k1000',
		'type'			=> 'option',
		'capability'	=> 'edit_theme_options',
	) );

	$wp_customize->add_control( 'vintage_camera_theme_style', array(
		'label'		=> __( 'Theme Style', 'vintage-camera' ),
		'section'	=> 'vintage_camera_theme_options',
		'settings'	=> 'vintage_camera_theme_options[theme_style]',
		'type'		=> 'select',
		'choices'	=> array(
						'brownie' 	=> __( 'Brownie', 'vintage-camera' ),
						'polaroid' 	=> __( 'Land', 'vintage-camera' ),
						'diana' 	=> __( 'Diana', 'vintage-camera' ),
						'k1000' 	=> __( 'K1000', 'vintage-camera' ),
						'sabre' 	=> __( 'Sabre', 'vintage-camera' ),
						'savoy' 	=> __( 'Savoy', 'vintage-camera' ),
					),
	) );

}
add_action( 'customize_register', 'vintage_camera_customize_register' );