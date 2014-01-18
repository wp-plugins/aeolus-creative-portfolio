<?php

/**
 * plugin options
 */
class AxPluginOptions {
	
	private $options;
	function __construct() {
		$this->options = get_option(AX_PORTFOLIO_OPTION_GROUP);		
	}
	
	private static $instance;
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new AxPluginOptions();
		}
		return self::$instance;		
	}
	
	public function getRelatedSettings(){
		$showRelated = (isset($this->options['showRelated']))?$this->options['showRelated']:'';
		$showRelated = ($showRelated=="ON")?true:false;
		$relatedProjectsMaxNo = (isset($this->options['relatedProjectsMaxNo']))?$this->options['relatedProjectsMaxNo']:'3';
		return array('showRelated'=>$showRelated, 'relatedProjectsMaxNo'=>$relatedProjectsMaxNo);		
	}	
	
	public function getLabels(){		
		$readMoreLB = (isset($this->options['readMoreLB']))?$this->options['readMoreLB']:'Open';
		$nextLB = (isset($this->options['nextLB']))?$this->options['nextLB']:'Next';
		$prevLB = (isset($this->options['prevLB']))?$this->options['prevLB']:'Previous';
		$relatedLB = (isset($this->options['relatedLB']))?$this->options['relatedLB']:'Related projects';				
		return array('readMoreLB'=>$readMoreLB, 'nextLB'=>$nextLB, 'prevLB'=>$prevLB, 'relatedLB'=>$relatedLB);
	}
	
	public function getColors(){
		$generalCol = (isset($this->options['generalCol']))?$this->options['generalCol']:'1abb9f';
		$generalCol_rgb = $this->html2rgb($generalCol);						
		return array('generalCol'=>$generalCol, 'gc_rgb'=>$generalCol_rgb);		
	}
	
	
	public function getOptions(){
		$portfolio_re_write_slug = (isset($this->options['portfolio_re_write_slug']))?$this->options['portfolio_re_write_slug']:'portfolio';
		$max_portfolio_posts = (isset($this->options['max_portfolio_posts']))?$this->options['max_portfolio_posts']:4;
		$portfolio_slider_height = (isset($this->options['portfolio_slider_height']))?$this->options['portfolio_slider_height']:500;
		$portfolio_padding = (isset($this->options['portfolio_padding']))?$this->options['portfolio_padding']:0;
		return array('portfolio_re_write_slug'=>$portfolio_re_write_slug, 'max_portfolio_posts'=>$max_portfolio_posts, 'portfolio_slider_height'=>$portfolio_slider_height, 'portfolio_padding'=>$portfolio_padding);
	}

	public function getCustomCSS(){
		$opts = $this->getOptions();
		$colors = $this->getColors();
		$custom_css = '';
		$custom_css .= '
			.rx_hoverui{
				background-color: #'.$colors['generalCol'].';
				background: rgba('.$colors['gc_rgb'][0].', '.$colors['gc_rgb'][1].', '.$colors['gc_rgb'][2].', .6);
			}
			.pagination span, .pagination a {
				background-color: #'.$colors['generalCol'].';
			}
			.pagination a:hover{
				background-color: #'.$colors['generalCol'].';
			}
			.paginationrx a.inactive{
				background-color: #'.$colors['generalCol'].';
			}			
			.pagination .current{
				background-color: #829bb0;
			}
			.portfolioNavPoint{
				background-color: #'.$colors['generalCol'].';
			}
			.pageTitle, .pageSubtitle{
				color: #'.$colors['generalCol'].';
			}
			.rx_related_post_overlay{
				background: #'.$colors['generalCol'].';
				background: rgba('.$colors['gc_rgb'][0].', '.$colors['gc_rgb'][1].', '.$colors['gc_rgb'][2].', .6);
			}
			.related_content .nextPost a, .related_content .previousPost a{				
				color: #'.$colors['generalCol'].' !important;
			}
			.portfolioSingleFeaturedImages{
				height:'.$opts['portfolio_slider_height'].'px;
			}
			.portfolioSingleContent{	
				padding: 20px '.$opts['portfolio_padding'].'px;
			}							
		';
		return $custom_css;		
	}
	
	
	public function adjustBrightness($hex, $steps) {
	    // Steps should be between -255 and 255. Negative = darker, positive = lighter
	    $steps = max(-255, min(255, $steps));
	
	    // Format the hex color string
	    $hex = str_replace('#', '', $hex);
	    if (strlen($hex) == 3) {
	        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	    }
	
	    // Get decimal values
	    $r = hexdec(substr($hex,0,2));
	    $g = hexdec(substr($hex,2,2));
	    $b = hexdec(substr($hex,4,2));
	
	    // Adjust number of steps and keep it inside 0 to 255
	    $r = max(0,min(255,$r + $steps));
	    $g = max(0,min(255,$g + $steps));  
	    $b = max(0,min(255,$b + $steps));
	
	    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
	    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
	    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
	
	    return '#'.$r_hex.$g_hex.$b_hex;
	}
	
	
	//utils - convert hex to rgb	
	public function html2rgb($color)
	{
	    if ($color[0] == '#')
	        $color = substr($color, 1);
	    if (strlen($color) == 6)
	        list($r, $g, $b) = array($color[0].$color[1],
	                                 $color[2].$color[3],
	                                 $color[4].$color[5]);
	    elseif (strlen($color) == 3)
	        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
	    else
	        return false;
	    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
	    return array($r, $g, $b);
	}	
	
	
	
}


?>