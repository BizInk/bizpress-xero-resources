<?php
/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function xero_settings_fields( $fields, $section ) {
	
	if('bizink-client_basic' == $section['id']){
		$fields['xero_content_page'] = array(
			'id'      => 'xero_content_page',
			'label'     => __( 'Bizink Client Xero', 'bizink-client' ),
			'type'      => 'select',
			'desc'      => __( 'Select the page to show the content. This page must contain the <code>[bizink-content]</code> shortcode.', 'bizink-client' ),
			'options'	=> cxbc_get_posts( [ 'post_type' => 'page' ] ),
			// 'chosen'	=> true,
			'required'	=> true,
		);
	}
	
	if('bizink-client_content' == $section['id']){
		$fields['xero_label'] = array(
			'id' => 'xero',
	        'label'	=> __( 'Bizink Client Xero', 'bizink-client' ),
	        'type' => 'divider'
		);
		$fields['xero_title'] = array(
			'id' => 'xero_title',
			'label'     => __( 'Xero Title', 'bizink-client' ),
			'type'      => 'text',
			'default'   => __( 'Xero Resources', 'bizink-client' ),
			'required'	=> true,
		);
		$fields['xero_desc'] = array(
			'id'      	=> 'xero_desc',
			'label'     => __( 'Xero Description', 'bizink-client' ),
			'type'      => 'textarea',
			'default'   => __( 'Free resources to help you use Xero.', 'bizink-client' ),
			'required'	=> true,
		);
	}

	return $fields;
}
add_filter( 'cx-settings-fields', 'xero_settings_fields', 10, 2 );

function xero_content( $types ) {
	$types[] = [
		'key' 	=> 'xero_content_page',
		'type'	=> 'xero-content'
	];

	return $types;
}
add_filter( 'bizink-content-types', 'xero_content' );

if( !function_exists( 'bizink_get_xero_page_object' ) ){
	function bizink_get_xero_page_object(){
		$post_id = cxbc_get_option( 'bizink-client_basic', 'xero_content_page' );
		$post = get_post( $post_id );
		return $post;
	}
}

add_action( 'init', 'bizink_xero_init');
function bizink_xero_init(){
	$post = bizink_get_xero_page_object();
	if( is_object( $post ) && get_post_type( $post ) == "page" ){
		add_rewrite_tag('%'.$post->post_name.'%', '([^&]+)', 'bizpress=');
		add_rewrite_rule('^'.$post->post_name . '/([^/]+)/?$','index.php?pagename=' . $post->post_name . '&bizpress=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/([a-z0-9-]+)[/]?$",'index.php?pagename='.$post->post_name.'&bizpress=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/topic/([a-z0-9-]+)[/]?$",'index.php?pagename='.$post->post_name.'&topic=$matches[1]','top');
		add_rewrite_rule("^".$post->post_name."/type/([a-z0-9-]+)[/]?$" ,'index.php?pagename='.$post->post_name.'&type=$matches[1]','top');
		//flush_rewrite_rules();
	}
}

add_filter('query_vars', 'bizpress_xero_qurey');
function bizpress_xero_qurey($vars) {
    $vars[] = "bizpress";
    return $vars;
}