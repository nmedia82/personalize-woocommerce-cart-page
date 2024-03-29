<?php 
/*
Plugin Name: Personalized WooCommerce Store
Plugin URI: http://www.najeebmedia.com
Description: Woocommerce extension which allow store admin to add message in almost every area of store like Product, Cart, Checkout, My Account etc. Even some action like redirect login and registrion.
Version: 2.5
Author: Najeeb Ahmad
Author URI: http://www.najeebmedia.com/
Text Domain: nm-woostore
WC requires at least: 3.0.0
WC tested up to: 3.4.3
*/


/*
 * Lets start from here
*/

/*
 * loading plugin config file
 */
$_config = dirname(__FILE__).'/config.php';
if( file_exists($_config))
	include_once($_config);
else
	die('Reen, Reen, BUMP! not found '.$_config);


/* ======= the plugin main class =========== */
$_plugin = dirname(__FILE__).'/classes/plugin.class.php';
if( file_exists($_plugin))
	include_once($_plugin);
else
	die('Reen, Reen, BUMP! not found '.$_plugin);

/*
 * [1]
 * TODO: just replace class name with your plugin
 */
$nmwoostore = new NM_PLUGIN_WooStore();


if( is_admin() ){

	$_admin = dirname(__FILE__).'/classes/admin.class.php';
	if( file_exists($_admin))
		include_once($_admin );
	else
		die('file not found! '.$_admin);

	$nmwoostore_admin = new NM_PLUGIN_WooStore_Admin();
	
	$woostore_basename = plugin_basename( __FILE__ );
	add_filter( "plugin_action_links_{$woostore_basename}", 'woostore_settings_link');
}

function woostore_settings_link($links) {
	
	$quote_url = "https://najeebmedia.com/get-quote/";
	$woostore_setting_url = admin_url( 'admin.php?page=nm_woostore');
	
	$woostore_links = array();
	$woostore_links[] = sprintf(__('<a href="%s">Settings</a>', 'ppom'), esc_url($woostore_setting_url) );
	$woostore_links[] = sprintf(__('<a href="%s">Request for Customized Solution</a>', 'ppom'), esc_url($quote_url) );
	
	foreach($woostore_links as $link) {
		
  		array_push( $links, $link );
	}
	
  	return $links;
}

/*
 * activation/install the plugin data
*/
register_activation_hook( __FILE__, array('NM_PLUGIN_WooStore', 'activate_plugin'));
register_deactivation_hook( __FILE__, array('NM_PLUGIN_WooStore', 'deactivate_plugin'));


