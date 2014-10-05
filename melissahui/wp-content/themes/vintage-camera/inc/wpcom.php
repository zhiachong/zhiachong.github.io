<?php
/**
 * WordPress.com-specific functions and definitions
 *
 * @package Vintage Camera
 * @since Vintage Camera 1.0
 */

/**
 * Set a default theme color array for WP.com.
 *
 * @since Vintage Camera 1.0
 */
$options = get_option( 'vintage_camera_theme_options' );
$theme_style = $options['theme_style'];

if ( 'brownie' == $theme_style ) {
	$themecolors = array(
		'bg' => 'c0b5a4',
		'border' => '333333',
		'text' => '333333',
		'link' => 'a1440b',
		'url' => 'a1440b'
	);
} elseif ( 'polaroid' == $theme_style ) {
	$themecolors = array(
		'bg' => 'c4c4c4',
		'border' => '333333',
		'text' => '333333',
		'link' => 'a5443f',
		'url' => 'a5443f'
	);
} elseif ( 'diana' == $theme_style ) {
	$themecolors = array(
		'bg' => '555555',
		'border' => '333333',
		'text' => '333333',
		'link' => 'ffffff',
		'url' => 'ffffff'
	);
} elseif ( 'sabre' == $theme_style ) {
	$themecolors = array(
		'bg' => 'e7e4d3',
		'border' => '333333',
		'text' => '333333',
		'link' => 'e27d8c',
		'url' => 'e27d8c'
	);
} elseif ( 'savoy' == $theme_style ) {
	$themecolors = array(
		'bg' => 'e7e4d3',
		'border' => '333333',
		'text' => '333333',
		'link' => 'c64c64',
		'url' => 'c64c64'
	);
} else {
	$themecolors = array(
		'bg' => 'ededed',
		'border' => '333333',
		'text' => '333333',
		'link' => 'a9c137',
		'url' => 'a9c137'
	);
}