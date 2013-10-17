<?php
/*
Plugin Name: Aeolus - Creative Portfolio
Plugin URI: http://sakurapixel.com/
Description: Aeolus – a carefully crafted WordPress plugin that displays your work in a clean, fancy way.
Author: SakuraPixel
Version: 1.0
Author URI: http://sakurapixel.com/
*/
define('RX_TEMPPATH', plugins_url('', __FILE__));
define('RXP_JS_ADMIN', RX_TEMPPATH.'/com/riaextended/js');
define('RX_JS', RX_TEMPPATH.'/js');
define('RXP_CLASS_PATH', plugin_dir_path(__FILE__));
define('RX_PLUGIN_TEXTDOMAIN', 'rx_portfolio');
define('RX_PORTFOLIO_SLUG', 'rx_aeolus');
define('RX_POST_CUSTOM_META', 'rx_portfolio_post_options');
define('RX_PORTFOLIO_OPTION_GROUP', 'rx_portfolio_option_group');


require_once(RXP_CLASS_PATH.'/com/riaextended/php/plugin_core.php');
$plugin_core = new RXPluginCore();
$plugin_core->start(array('addSinglePage'=>false, 'PLUGIN_FILE'=>__FILE__));
//register de-activation handler

register_deactivation_hook(__FILE__, 'aeolus_plugin_deactivate' );
function aeolus_plugin_deactivate() {
	flush_rewrite_rules();
}
?>