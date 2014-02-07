<?php
$skPluginInfo = get_plugin_data(AX_PORTFOLIO_FILE, $markup = true, $translate = true );
?>
<div class="gravityBannerSpace"></div>
<div id="gravityBanner">
	<div id="adminLogo"></div>
	<div class="supportUI">
		<a class="skButton skActionButton" target="_blank" href="http://www.sakuraplugins.com/">SakuraPlugins</a>
	</div>	
	<div class="pluginInfo">Version <?php echo $skPluginInfo['Version']?></div>
	<div class="clear-admin"></div>
</div>