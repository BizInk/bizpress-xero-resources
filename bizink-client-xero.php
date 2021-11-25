<?php
/**
 * Plugin Name: Bizink Client Xero
 * Description: Bizink Client Xero by Bizink
 * Plugin URI: https://bizinkonline.com
 * Author: Bizink
 * Author URI: https://bizinkonline.com
 * Version: 1.0
 * Text Domain: bizink-client-xero
 * Domain Path: /languages
 */

function xero_settings_fields( $fields, $section ) {

	if ( 'bizink-client_basic' != $section['id'] ) return $fields;
	
	$fields['xero_content_page'] = array(
		'id'      => 'xero_content_page',
		'label'     => __( 'Bizink Client Xero', 'bizink-client' ),
		'type'      => 'select',
		'desc'      => __( 'Select the page to show the content. This page must contain the <code>[bizink-content]</code> shortcode.', 'bizink-client' ),
		'options'	=> cxbc_get_posts( [ 'post_type' => 'page' ] ),
		// 'chosen'	=> true,
		'required'	=> true,
	);

	return $fields;
}
add_filter( 'cx-settings-fields', 'xero_settings_fields', 10, 2 );

function xero_content( $types ) {
	$types[] = [
		'key' 	=> 'xero_content_page',
		'type'	=> 'xero-resources'
	];

	return $types;
}
add_filter( 'bizink-content-types', 'xero_content' );