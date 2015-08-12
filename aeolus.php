<?php
/*
Plugin Name: Aeolus - Creative Portfolio
Plugin URI: http://sakuraplugins.com/
Description: Aeolus – a carefully crafted WordPress plugin that displays your work in a clean, fancy way.
Author: SakuraPlugins
Version: 1.8.2
Author URI: http://sakuraplugins.com/
*/
define('AX_TEMPPATH', plugins_url('', __FILE__));
define('AXP_JS_ADMIN', AX_TEMPPATH.'/com/riaextended/js');
define('AX_JS', AX_TEMPPATH.'/js');
define('AXP_CLASS_PATH', plugin_dir_path(__FILE__));
define('AX_PLUGIN_TEXTDOMAIN', 'rx_portfolio');
define('AX_PORTFOLIO_SLUG', 'rx_aeolus');
define('AX_POST_CUSTOM_META', 'rx_portfolio_post_options');
define('AX_PORTFOLIO_OPTION_GROUP', 'AX_PORTFOLIO_OPTION_GROUP');
define('AX_PORTFOLIO_FILE', __FILE__);


require_once(AXP_CLASS_PATH.'/com/riaextended/php/plugin_core.php');
$plugin_core = new AXPluginCore();
$plugin_core->start(array('addSinglePage'=>false, 'PLUGIN_FILE'=>__FILE__));
//register de-activation handler

register_deactivation_hook(__FILE__, 'aeolus_plugin_deactivate' );
function aeolus_plugin_deactivate() {
	flush_rewrite_rules();
}
?>
