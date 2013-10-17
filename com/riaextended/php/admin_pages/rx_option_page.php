<?php

/**
 *  generic settings
 */
class RX_GenericSettingsPage{
	
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
class RXOptionPage extends RX_GenericSettingsPage {
	
	public function settings_page(){
		$options = get_option($this->getOptionGroup());							
		?>
		<div class="spacer10"></div>
		<form method="post" action="options.php">
			<?php settings_fields($this->getOptionGroup()); ?>				
		  
		  <!--options wrapper-->
		  <div id="optionsWrapper">	
		        <div class="navbar navbar-inverse">
		            <div class="navbar-inner">
		                <div class="container">
		                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> 
		                    <a class="brand" href="#overview">Aeolus Settings</a>
		                </div>
		            </div>
		        </div>
        		  									
				<p class="submit">
					<input type="submit" class="button-primary pull-right" value="<?php _e('Save Changes', RX_PLUGIN_TEXTDOMAIN) ?>" />
		        </p>
		        <div class="clearfix spacer10"></div>		        
		        
			    <div class="tabbable tabs-left">
				    <ul class="nav nav-tabs">					    
					    <li class="active"><a href="#general_opts" data-toggle="tab"><i class="icon-home"></i> <?php _e('General Options', RX_PLUGIN_TEXTDOMAIN) ?></a></li>					    					    					    				    				    
				    </ul>
				    
				    <!--tabs content-->
				    <div class="tab-content">
					    					    
					    <?php
					    	//general style tab
					    	require_once(RXP_CLASS_PATH.'/com/riaextended/php/admin_pages/settings_pages/general_options.php');					    																																																																
					    ?>


				    </div>
				    <!--/tabs content-->
			    </div>
    
	        
		        
				<p class="submit">
					<input type="submit" class="button-primary pull-right" value="<?php _e('Save Changes', RX_PLUGIN_TEXTDOMAIN) ?>" />
		        </p>		        
		        
	      </div>
	      <!--options wrapper-->
		</form>		
		
		<?php
	}

}


?>