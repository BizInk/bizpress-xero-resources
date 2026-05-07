<?php
/**
 * Plugin Name: BizPress Xero Resources
 * Description: Show Xero resources on your site. Automatically updated by the Bizink team.
 * Plugin URI: https://bizinkonline.com
 * Author: Bizink
 * Author URI: https://bizinkonline.com
 * Version: 1.3.8
 * Text Domain: bizink-client
 * Domain Path: /languages
 */

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Updater
require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$myUpdateChecker = PucFactory::buildUpdateChecker('https://github.com/BizInk/bizpress-xero-resources',__FILE__,'bizpress-xero-resources');
$myUpdateChecker->setBranch('master');

if(is_plugin_active("bizpress-client/bizink-client.php")){
	require 'xero-resources.php';
}