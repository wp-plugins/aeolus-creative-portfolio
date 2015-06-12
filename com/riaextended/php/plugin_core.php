<?php
require_once(AXP_CLASS_PATH.'com/riaextended/php/plugin_base.php');
require_once(AXP_CLASS_PATH.'com/riaextended/php/customposts/utils/CPTHelper.php');
require_once(AXP_CLASS_PATH.'com/riaextended/php/customposts/RxCPT.php');
require_once(AXP_CLASS_PATH.'com/riaextended/php/RxShortcodes.php');
require_once(AXP_CLASS_PATH.'com/riaextended/php/script_manager/ScriptManager.php');
require_once(AXP_CLASS_PATH.'com/riaextended/php/admin_pages/rx_option_page.php');
require_once(AXP_CLASS_PATH.'/com/riaextended/php/rx_plugin_options.php');
/**
 * Wrapper
 */
class AXPluginCore extends AxPluginBase {
	
	//fire up 
	public function start($options=null)
	{	
		parent::start();						
		add_filter('excerpt_more', array($this, 'rx_excerpt_more'));
		if(isset($options['addSinglePage'])){
			add_filter("single_template", array($this, 'rx_plugin_single'));
		}
		register_activation_hook($options['PLUGIN_FILE'], array($this, 'rx_activate_plugin') );
		add_action("wp_before_admin_bar_render", array($this, 'adminBarCustom')); 		
	}
	
	//admin bar custom
	public function adminBarCustom(){
		if(function_exists('get_current_screen')){
			$current_screen = get_current_screen();		
			if($current_screen->post_type==AX_PORTFOLIO_SLUG){			
				require_once(AXP_CLASS_PATH.'com/riaextended/php/admin_pages/banner.php');
			}
		}
	}
	
	//plugin activation
	public function rx_activate_plugin(){
		if(version_compare(get_bloginfo('version'), '3.5', '<' )){
			deactivate_plugins(basename( __FILE__ ));
		}else{
			try{		
				$this->addCPT();
				flush_rewrite_rules();
			}catch(Exception $e){}
		}		
	}
	
	//read more link - override
	public function rx_excerpt_more($more) {
	       global $post;		   
		   $p_type = get_post_type($post);
		   if($p_type==AX_PORTFOLIO_SLUG){
		   		$val = '...';
		   }	   
		return $val;
	}
	
	//rx single template
	public function rx_plugin_single($single_template){
		global $post;		
		if($post->post_type==AX_PORTFOLIO_SLUG){
			$single_template = dirname( __FILE__ ) . '/rx-single-template.php';	
			//print_r($single_template);					
		}
		return $single_template;
	}		
	
	//init handler - override 
	public function initializeHandler(){				
		parent::initializeHandler();	
		$this->addCPT();	
		$this->addTaxonomy();						
	}
	
	//add taxonomy
	private function addTaxonomy(){
		//portfolio taxonomy
		if(isset($this->rxCPT)){
			register_taxonomy('ae_portfolio_categories', $this->rxCPT->getPostSlug(), array('label'=>'Portfolio Categories', 'hierarchical'=>true));
		}				
	}		
	
	private $rxCPT;
	/*
	 * create youtube CPT
	 */
	public function addCPT(){
		$plugin_opts = new AxPluginOptions();
		$opts = $plugin_opts->getOptions();
		$settings = array('post_custom_meta_data'=>AX_POST_CUSTOM_META, 'post_type' => AX_PORTFOLIO_SLUG, 'name' => __('Aeolus Portfolio', AX_PLUGIN_TEXTDOMAIN), 'menu_icon' => AX_TEMPPATH.'/com/riaextended/images/icons/camera-black.png',
		'singular_name' => __('Aeolus Portfolio', AX_PLUGIN_TEXTDOMAIN), 'rewrite' => $opts['portfolio_re_write_slug'], 'add_new' => __('Add new', AX_PLUGIN_TEXTDOMAIN),
		'edit_item' => __('Edit', AX_PLUGIN_TEXTDOMAIN), 'new_item' => __('New', AX_PLUGIN_TEXTDOMAIN), 'view_item' => __('View item', AX_PLUGIN_TEXTDOMAIN), 'search_items' => __('Search items', AX_PLUGIN_TEXTDOMAIN),
		'not_found' => __('No item found', AX_PLUGIN_TEXTDOMAIN), 'not_found_in_trash' => __('Item not found in trash', AX_PLUGIN_TEXTDOMAIN), 
		'supports' => array('title', 'editor', 'thumbnail'));
		
		$cptHelper = new RXPCPTHelper($settings);
		$this->rxCPT = new AxCPT();
		$this->rxCPT->create($cptHelper, $settings);		
	}
	
	//admin init handler - override 
	public function adminInitHandler(){
		//add meta boxes pages		
		$this->rxCPT->addMetaBox(__('Featured images', AX_PLUGIN_TEXTDOMAIN), 'meta_box_images_id_21783', 'meta_box_images');
		$this->rxCPT->addMetaBox(__('Featured video', AX_PLUGIN_TEXTDOMAIN), 'meta_box_video_id_8249', 'meta_box_video');							
		$this->rxCPT->addMetaBox(__('Extra Settings', AX_PLUGIN_TEXTDOMAIN), 'meta_box_subtitle_id_023648', 'meta_box_subtitle');
	}

	//add submenu page
	public function adminMenuHandler(){
		$rx_options_page = new AXOptionPage(AX_PORTFOLIO_OPTION_GROUP);
		add_submenu_page( 'edit.php?post_type='.AX_PORTFOLIO_SLUG, 'Aeolus settings', 'Aeolus settings', 'manage_options', 'rx_portfolio_sett', array($rx_options_page, 'settings_page'));		 
	}

	
	
	//admin enqueue scripts handler - override 
	public function adminEnqueueScriptsHandler(){		
		$screenID = get_current_screen()->id;		
		if($screenID==AX_PORTFOLIO_SLUG){
			parent::adminEnqueueScriptsHandler();
			ScriptPManager::enqueColorPicker();
			ScriptPManager::enqueJqueryUI();
			wp_register_script( 'portfolio_options_script', AXP_JS_ADMIN.'/rx_portfolio_admin.js', array('jquery'));			 
			wp_enqueue_script('portfolio_options_script');			
			wp_enqueue_media();					
		}
		if($screenID==AX_PORTFOLIO_SLUG.'_page_rx_portfolio_sett'){
			parent::adminEnqueueScriptsHandler();
			wp_register_style('rx_admin_bootstrap', AX_TEMPPATH.'/com/riaextended/bootstrap_3_0/css/bootstrap.min.css');				 
			wp_enqueue_style('rx_admin_bootstrap');				
			wp_register_script('rx_admin_bootstrap_js', AX_TEMPPATH.'/com/riaextended/bootstrap_3_0/js/bootstrap.min.js', array('jquery'));
			wp_enqueue_script('rx_admin_bootstrap_js');
			
			wp_register_script('rx_options_page_script', AX_TEMPPATH.'/com/riaextended/js'.'/admin_pages/rx_options.js');
			wp_enqueue_script('rx_options_page_script');
			ScriptPManager::enqueColorPicker();
			wp_register_style('rx_admin-options', AX_TEMPPATH.'/com/riaextended/css/admin_options.css');
			wp_enqueue_style('rx_admin-options');									
		}
		if($screenID=="edit-".AX_PORTFOLIO_SLUG || $screenID==AX_PORTFOLIO_SLUG."_page_rx_portfolio_sett" || $screenID==AX_PORTFOLIO_SLUG){
			$this->bannerCss();	
			$this->bannerCss();
		}				
	}

	public function bannerCss(){
		wp_register_style('sk_admin-style', AX_TEMPPATH.'/com/riaextended/css/rx_admin.css');
		wp_enqueue_style('sk_admin-style');
	}
		

	//WP Enqueue scripts handler
	public function WPEnqueueScriptsHandler(){
		parent::WPEnqueueScriptsHandler();
		wp_register_style('rx-bootstrap-light', AX_TEMPPATH.'/bootstrap_3_0/css/bootstrap.min.css');
		wp_enqueue_style('rx-bootstrap-light');	
		wp_register_script('rx-bootstrap-js', AX_TEMPPATH.'/bootstrap_3_0/js/bootstrap.min.js', array('jquery'));			 
		wp_enqueue_script('rx-bootstrap-js');
		wp_register_style('rx_portfolio_css', AX_TEMPPATH.'/css/rx_portfolio.css');
		wp_enqueue_style('rx_portfolio_css');
		
		//backstretch js
		wp_register_script('backstretch-js', AX_TEMPPATH.'/js/external/backstretch.js', array('jquery'));
		wp_enqueue_script('backstretch-js');			
							
		wp_register_script('rx-portfolio-js', AX_TEMPPATH.'/js/aeolus_portfolio.js', array('jquery'));			 
		wp_enqueue_script('rx-portfolio-js');
		
		//fluid iFrames
		wp_register_script('fluidvids', AX_TEMPPATH.'/js/external/fluidvids.min.js', array('jquery'), null, TRUE);
		wp_enqueue_script('fluidvids');		
		
		$fonts_css = $this->getGoogleFontsCSS();
		wp_add_inline_style('rx_portfolio_css', $fonts_css);
		
		$pluginOpts = new AxPluginOptions();
		$plugin_custom_css = $pluginOpts->getCustomCSS();
		wp_add_inline_style('rx_portfolio_css', $plugin_custom_css);																										
	}
	
	//google fonts
	public function getGoogleFontsCSS(){
		return '
		  @import url(http://fonts.googleapis.com/css?family=Montserrat);
		  @import url(http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300);		
		';
	}
	
	/**
	 * SAVE POST EXTRA DATA
	 */
	 public function savePostHandler(){
		global $post;						
		if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;
		}
		if(!current_user_can('edit_posts') || !current_user_can('publish_posts')){
			return;
		}
			//save portfolio data
		if(isset($this->rxCPT) && isset($_POST['post_type'])){
			if($this->rxCPT->getPostSlug() == $_POST['post_type']){									
				if(current_user_can( 'edit_posts', $post->ID ) && isset($_POST[$this->rxCPT->getPostCustomMeta()])){							
					update_post_meta($post->ID, $this->rxCPT->getPostCustomMeta(), $_POST[$this->rxCPT->getPostCustomMeta()]);
				}		 
			}						
		}				
												
	 }


	/*
	 * register shortcodes 
	 */ 
	public function registerShortcodes(){			
		$shorcodesHelper = new RxPShortcodes();
		$shorcodesHelper->registerShortcodes();	
	}
			
	
		
}


?>
