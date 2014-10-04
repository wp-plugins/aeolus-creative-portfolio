<?php

/**
 *  generic settings
 */
class AX_GenericSettingsPage{
	
	private $optionsGroup;
	function __construct($optsGroup) {
		$this->optionsGroup = $optsGroup;
		add_action('admin_init', array($this, 'registerSettingsGroups'));
	}
	
	//register settings group
	public function registerSettingsGroups(){
		register_setting($this->optionsGroup, $this->optionsGroup);
	}	
	
	//get option group
	protected function getOptionGroup(){
		return $this->optionsGroup;
	}	
}


/**
 * RXOptionPage
 */
class AXOptionPage extends AX_GenericSettingsPage {
	
	public function settings_page(){
		$options = get_option($this->getOptionGroup());							
		?>
		<div class="spacer10"></div>
		<form method="post" action="options.php">
			<?php settings_fields($this->getOptionGroup()); ?>				
		  
		  <!--options wrapper-->
		  <div id="optionsWrapper">	

        		  									
				<p class="submit">
					<input type="submit" class="button-primary pull-right" value="<?php _e('Save Changes', AX_PLUGIN_TEXTDOMAIN) ?>" />
		        </p>
		        <div class="clearfix spacer10"></div>		        
		        
			    <div class="tabbable tabs-left">

				    <!--tabs content-->
				    <div class="tab-content">
					    					    
					    <?php
					    	//general style tab
					    	require_once(AXP_CLASS_PATH.'/com/riaextended/php/admin_pages/settings_pages/general_options.php');					    																																																																
					    ?>


				    </div>
				    <!--/tabs content-->
			    </div>
    
	        
		        
				<p class="submit">
					<input type="submit" class="button-primary pull-right" value="<?php _e('Save Changes', AX_PLUGIN_TEXTDOMAIN) ?>" />
		        </p>		        
		        
	      </div>
	      <!--options wrapper-->
		</form>		
		
		<?php
	}

}


?>