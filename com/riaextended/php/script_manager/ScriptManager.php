<?php


/**
 * scripts manager
 */
class ScriptPManager {
	
	public static function enqueFluidDivs(){
		//fluid iFrames
		wp_register_script( 'fluidvids', AX_JS.'/external/fluidvids.min.js', array('jquery'), null, TRUE);
		wp_enqueue_script('fluidvids');		
	}

	public static function enqueJqueryUI(){
			//jqueryui		
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-widget');
			wp_enqueue_script('jquery-ui-selectable');
			wp_enqueue_script('jquery-ui-button');	
			wp_enqueue_script('jquery-ui-mouse');
			wp_enqueue_script('jquery-ui-spinner');
			wp_enqueue_script('jquery-ui-accordion');
			wp_enqueue_script('jquery-ui-dialog');
						
			//jqueryui theme
			//wp_register_style('jqueryui-style', AXP_JS_ADMIN.'/jqueryui/css/redmond/jquery-ui-1.10.2.custom.css');
			//wp_enqueue_style('jqueryui-style');						
	}	

	public static function enqueColorPicker(){
			 wp_register_style( 'cpicker_style', AX_TEMPPATH.'/com/riaextended/js'.'/cpick/colpick.css');		 
		     wp_enqueue_style( 'cpicker_style');
			 wp_register_script( 'color_picker', AX_TEMPPATH.'/com/riaextended/js'.'/cpick/colpick.js', array('jquery'));
			 wp_enqueue_script('color_picker');		     
			/*
			 //color picker style
		     wp_register_style( 'cpicker_style', AX_TEMPPATH.'/com/riaextended/js'.'/cpicker/css/colorpicker.css');
			 wp_register_style( 'cpicker_layout', AX_TEMPPATH.'/com/riaextended/js'.'/cpicker/css/layout.css');		 
		     wp_enqueue_style( 'cpicker_style');
			 //wp_enqueue_style( 'cpicker_layout');
			 
			 //color picker script
			 wp_register_script( 'color_picker', AX_TEMPPATH.'/com/riaextended/js'.'/cpicker/js/colorpicker.js', array('jquery'));
			 wp_register_script( 'color_picker_eye', AX_TEMPPATH.'/com/riaextended/js'.'/cpicker/js/eye.js', array('jquery'));
			 wp_register_script( 'color_picker_layout', AX_TEMPPATH.'/com/riaextended/js'.'/cpicker/js/layout.js', array('jquery'));
			 wp_register_script( 'color_picker_utils', AX_TEMPPATH.'/com/riaextended/js'.'/cpicker/js/utils.js', array('jquery'));
			 wp_enqueue_script('color_picker');
			 wp_enqueue_script('color_picker_eye');	
			 wp_enqueue_script('color_picker_layout');	
			 wp_enqueue_script('color_picker_utils');
			 */			 		
	}


}


?>