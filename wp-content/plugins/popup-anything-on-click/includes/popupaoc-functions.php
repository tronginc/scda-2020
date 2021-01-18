<?php
/**
 * Plugin generic functions file
 *
 * @package Popup Anything On Click
 * @since 1.0.0
 */

 // Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Function to get unique value number
 * 
 * @package Popup Anything On Click
 * @since 1.0
 */
function popupaoc_get_unique() {
	static $unique = 0;
	$unique++;

	return $unique;
}

/**
 * Function to get button style type
 * 
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_popup_type() {
	$popup_type = array(
						'simple_link'	=> __('Simple Link','popup-anything-on-click'),
						'image'			=> __('Image','popup-anything-on-click'),
						'button'		=> __('Button','popup-anything-on-click'),		
					);
	return apply_filters('popupaoc_popup_type', $popup_type );
}

/**
 * Function to get button style type
 * 
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_effect() {
	$popup_effect = array(
						'fadein'	 => __('Fadein','popup-anything-on-click'),
						'slide'		 => __('Slide','popup-anything-on-click'),
						'fall'		 => __('Fall','popup-anything-on-click'),
						'flip'		 => __('Flip','popup-anything-on-click'),
						'blur'		 => __('Blur','popup-anything-on-click'),
						'rotate'	 => __('Rotate','popup-anything-on-click'),						
						'sign'	     => __('Sign','popup-anything-on-click'),
						'superscaled'=> __('Super scaled','popup-anything-on-click'),
						'slit'		 => __('Slit','popup-anything-on-click'),
						'corner'	 => __('Corner','popup-anything-on-click'),
						'push'		 => __('Push','popup-anything-on-click'),						
						'slip'	     => __('Slip','popup-anything-on-click'),
						'scale'      => __('scale','popup-anything-on-click'),
						'contentscale'=> __('Content Scale','popup-anything-on-click'),						
						'slidetogether'	 => __('Slide Together','popup-anything-on-click'),
						
					);
	return apply_filters('popupaoc_effect', $popup_effect );
}

/**
 * Function to get button style type
 * 
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_positionx() {
	$positionx= array(	
						'center'	=> __('Center','popup-anything-on-click'),	
						'left'		=> __('Left','popup-anything-on-click'),						
						'right'		=> __('Right','popup-anything-on-click')
					);
	return apply_filters('popupaoc_positionx', $positionx );
}

/**
 * Function to get button style type
 * 
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_positiony() {
	$positiony = array(
						'center'	=> __('Center','popup-anything-on-click'),
						'top'		=> __('Top','popup-anything-on-click'),						
						'bottom'	=> __('Bottom','popup-anything-on-click')
					);
	return apply_filters('popupaoc_positiony', $positiony );
}


/**
 * Function to Full Screen
 * 
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_popupfullscreen() {
	$popupfullscreen = array(
						'false'	    => __('False','popup-anything-on-click'),		
						'true'		=> __('True','popup-anything-on-click')
											
					);
	return apply_filters('popupaoc_popupfullscreen', $popupfullscreen );
}

/**
 * Function to Overlay
 * 
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_popupoverlay() {
	$popupoverlay = array(
						'true'		=> __('True','popup-anything-on-click'),
						'false'	    => __('False','popup-anything-on-click')						
					);
	return apply_filters('popupaoc_popupoverlay', $popupoverlay );
}

/**
 * Function to Loader
 * 
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_lodaer() {
	$popuploader = array(
						'true'		=> __('True','popup-anything-on-click'),
						'false'	    => __('False','popup-anything-on-click')						
					);
	return apply_filters('popupaoc_lodaer', $popuploader );
}

/**
 * Set Settings Default Option Page
 * 
 * Handles to return all settings value
 *
 * @package Popup Anything On Click
 * @since 1.6.1
 */
function popupaoc_default_settings() {
	global $popupaoc_options;

	$default_options = array(
		'add_js' => '',
	);

	$default_options = apply_filters('popupaoc_default_settings', $default_options );	
	// Update default options
	update_option( 'popupaoc_options', $default_options );
	// Overwrite global variable when option is update
	$popupaoc_options = popupaoc_get_settings();
}

/**
 * Get Settings From Option Page
 * 
 * Handles to return all settings value
 * 
 * @package Popup Anything On Click
 * @since 1.6.1
 */
function popupaoc_get_settings() {
	
	$options = get_option('popupaoc_options');
	$settings = is_array($options) ? $options : array();
	return $settings;
}

/**
 * Get an option
 * Looks to see if the specified setting exists, returns default if not
 * 
 * @package Popup Anything On Click
 * @since 1.6.1
 */
function popupaoc_get_option( $key = '', $default = false ) {
	global $popupaoc_options;
	
	$value = ! empty( $popupaoc_options[ $key ] ) ? $popupaoc_options[ $key ] : $default;
	$value = apply_filters( 'popupaoc_get_option', $value, $key, $default );
	return apply_filters( 'popupaoc_get_option_' . $key, $value, $key, $default );
}

/**
 * Escape Tags & Slashes
 *
 * Handles escapping the slashes and tags
 *
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_esc_attr($data) {
    return esc_attr( stripslashes($data) );
}

/**
 * Strip Slashes From Array
 *
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_slashes_deep($data = array(), $flag = false) {
  
    if($flag != true) {
        $data = popupaoc_nohtml_kses($data);
    }
    $data = stripslashes_deep($data);
    return $data;
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @package Popup Anything On Click
 * @since 1.0
 */
function popupaoc_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'popupaoc_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize numeric value and return fallback value if it is blank
 * 
 * @package Popup Anything On Click
 * @since 1.0
 */
function popupaoc_clean_numeric( $var, $fallback = null ) {
	$data = abs($var);
	return ( empty($data) && $fallback ) ? $fallback : $data;
}

/**
 * Sanitize URL
 * 
 * @package Popup Anything On Click
 * @since 1.0
 */
function popupaoc_clean_url( $url ) {
	return esc_url_raw( trim($url) );
}

/**
 * Strip Html Tags 
 * 
 * It will sanitize text input (strip html tags, and escape characters)
 * 
 * @package Popup Anything On Click
 * @since 1.0.0
 */

function popupaoc_nohtml_kses($data = array()) {
  
  if ( is_array($data) ) {
    
    $data = array_map('popupaoc_nohtml_kses', $data);
    
  } elseif ( is_string( $data ) ) {
    $data = trim( $data );
    $data = wp_filter_nohtml_kses($data);
  }
  
  return $data;
}

/**
 * Function to add array after specific key
 * 
 * @package Popup Anything On Click
 * @since 1.0.0
 */
function popupaoc_add_array(&$array, $value, $index, $from_last = false) {

    if( is_array($array) && is_array($value) ) {

        if( $from_last ) {
            $total_count    = count($array);
            $index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
        }
        
        $split_arr  = array_splice($array, max(0, $index));
        $array      = array_merge( $array, $value, $split_arr);
    }
    
    return $array;
}