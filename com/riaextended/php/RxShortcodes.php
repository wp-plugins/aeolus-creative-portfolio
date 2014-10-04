<?php
/**
 * Shortcode
 */
require_once(AXP_CLASS_PATH.'/com/riaextended/php/rx_plugin_options.php');
require_once(AXP_CLASS_PATH.'/com/riaextended/php/rx_post_options.php');
require_once(AXP_CLASS_PATH.'/com/riaextended/php/libs/blogutils/BlogPagination.php');
require_once(AXP_CLASS_PATH.'/com/riaextended/php/libs/mobile/rx_mobile_detect.php');
class RxPShortcodes{
	
	public function registerShortcodes(){
		add_shortcode('rx_aeolus_parallax', array($this, 'rx_aeolus_parallax'));						
		add_shortcode('rx_aeolus_three_cols', array($this, 'rx_aeolus_three_cols'));	
		add_shortcode('rx_aeolus_two_cols', array($this, 'rx_aeolus_two_cols'));
		add_shortcode('rx_aeolus_one_col', array($this, 'rx_aeolus_one_col'));																				
	}
	
	//parallax shortcode
	public function rx_aeolus_parallax($atts, $content = null){				
		$count_posts = 0;
		if ( get_query_var('paged') ) {
		    $paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
		    $paged = get_query_var('page');
		} else {
		    $paged = 1;
		}		
		
		$detect = new RX_Mobile_Detect();
		$is_mobile = ($detect->isMobile())?'true':'false';	
		$pluginOpts = new AxPluginOptions();
		$labels = $pluginOpts->getLabels();
		$colors = $pluginOpts->getColors();
		$opts = $pluginOpts->getOptions();
		
		$rx_query = array('post_type' => AX_PORTFOLIO_SLUG, 'paged'=>$paged, 'posts_per_page' =>$opts['max_portfolio_posts']);													
		$out = '<div class="rx_parallax" data-isMobile="'.$is_mobile.'">';			
			$query = new WP_Query($rx_query);			
			if($query->have_posts()) {				
				
				while($query->have_posts()){
					$count_posts++;							
					$query->the_post();	
					$id = get_the_ID();
					$title = get_the_title($id);					
					$post_options = new AxPostOptions(get_the_ID());
					$subtitle = $post_options->getSubtitle();					
					$featuredImageURL = $post_options->getFeaturedImageURL(get_the_ID());					
					$out .= '
					<div id="p_item'.$count_posts.'" class="rxParalaxItem" data-back="'.$featuredImageURL.'" style="background-image: url('.$featuredImageURL.');">
					
						<!--portfolio triangle-->
			             <div class="portfolioExcerptTriangleUI">
			                 <div class="portfolioExcerptTriangle">	                     
			                     <svg class="svgTriangle" width="640" height="300" viewBox="0 0 640 300" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">            
			                          <polygon fill="#'.$colors['generalCol'].'" fill-opacity="0.9" points="0,0 640,0 320,300" />
			                     </svg>
			                 </div>                 
			             </div>
			            <!--/portfolio triangle-->
			            
			             <!--portfolio title-->
			             <div class="portfolioTitleUI">
			             	<p class="aeolusFont2 titlePortfolio">'.$title.'</p>
			             	<div class="portfolioHLine"></div>
			             	<p class="aeolusFont1 portfolioSubtitle">'.$subtitle.'</p>
			             	<div class="permalinkTriangleUI">
				                <svg width="140" height="75" viewBox="0 0 140 75" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">            
				                     <polygon class="permalinkFill" fill="'.$pluginOpts->adjustBrightness($colors['generalCol'], -30).'" fill-opacity="0" points="0,0 140,0 70,75" />
				                </svg>	
			             	</div>
			             	<a class="aeolusFont1 openPortfolio" href="'.$post_options->getURL($id).'">'.$labels['readMoreLB'].'</a>
			             </div>
			             <!--portfolio title-->	
			             
			             <!--bottom triangles-->
			             <div class="portfolioItemBottomUI">
			                 <div class="left_right_triangle">
			                     <svg width="2000" height="1300" viewBox="0 0 2000 1300" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">            
			                          <polygon fill="#'.$colors['generalCol'].'" fill-opacity="0.3" points="0,0 1680,1300 0,1300" />
			                     </svg>                     
			                 </div>
			                 <div class="left_right_triangle">
			                     <svg width="2000" height="1300" viewBox="0 0 2000 1300" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">            
			                          <polygon fill="#'.$colors['generalCol'].'" fill-opacity="0.3" points="320,1300 2000,1300 2000,0" />
			                     </svg>                      
			                 </div>
			                 <div class="clear-fx"></div>
			             </div>
			             <!--/bottom triangles--> 						 					
												
					</div>
					';											 
				}			
			} else {
				// no posts found
				//echo "no posts found";
			}			
			
			$pagination = new RxBlogPagination();
			$pagination_html = $pagination->kriesi_pagination($query->max_num_pages, 2);
			$out .= '<div class="paginationUI">';	
			$out .= $pagination_html;	
			$out .= '<div class="clear-fx"></div>';
			$out .= '</div>';		
			wp_reset_query();			
			
			if($count_posts!=1 && $count_posts!=0){
				$out .= '<div class="portfolioSideNav">';
				for ($i=0; $i < $count_posts; $i++){
					$out .= '<div class="portfolioNavPoint"></div>';
				}
				$out .= '</div>';
			}
			
			
			
			
			
		$out .= '</div>';
		return $out;		
	}
		
	
	
	
	/* three cols shortcode
	================================================== */	
	public function rx_aeolus_three_cols($atts, $content = null){
		extract(shortcode_atts(array('category_slug' => ''), $atts));
		$rx_query = array('post_type' => AX_PORTFOLIO_SLUG, 'posts_per_page' =>'-1');		
		if($category_slug!=''){									 
			 $term = term_exists($category_slug);
			 if ($term == 0 || $term == null) {
			 	echo "The ".$category_slug." does not exist!";
			 	return;
			 }
			 $term_id = $term;
			 if(is_array($term)){
			 	$term_id = $term['term_id'];
			 }
			$args = array(
				'tax_query' => array(
					array(
						'taxonomy' => 'ae_portfolio_categories',
						'field' => 'id',
						'terms' => $term_id
					)
				)
			);
			$rx_query = array_merge($rx_query, $args);			 		
		}				
						
		
		$out = '<div class="rx_portfolio container-fluid">';			
			$query = new WP_Query($rx_query);
			if($query->have_posts()) {
				$groupCount = -1;
				
				while($query->have_posts()){
					$groupCount++;
					if($groupCount==0){
						$out .= '<div class="row">';						
						//echo $groupCount." -open row <br />";
					}
														
					$query->the_post();
					$id = get_the_ID();
					$post_options = new AxPostOptions($id);
					$thumbnail_url = $post_options->getFeaturedImage($id, 800, 650);					
					$title = get_the_title($id);					
					
					$out .= '
					<div class="col-md-4">
						<div class="rx_thumb_ui">
							<div class="rx_thumb_container"><a href="'.$post_options->getURL($id).'" class="rx_image_link"><img src="'.$thumbnail_url.'" alt="" /></a></div>
							<div class="rx_hoverui" data-url="'.$post_options->getURL($id).'">
								<p class="rx_thumb_title aeolusFont1">'.$title.'</p>																				
							</div>					
						</div>	
					</div>
					';					
					
					
					if($groupCount==2){						
						//echo $groupCount." -close row <br />";
						$out .= '</div>';
						$groupCount = -1;
					}					 
				}
				if($groupCount==0 || $groupCount==1){
					//echo $groupCount." -close row final <br />";
					$out .= '</div>';
				}				
			} else {
				// no posts found
				//echo "no posts found";
			}
			/* Restore original Post Data */
			wp_reset_query();
		$out .= '</div>';
		return $out;		
	}




	/* two cols shortcode
	================================================== */	
	public function rx_aeolus_two_cols($atts, $content = null){
		extract(shortcode_atts(array('category_slug' => ''), $atts));
		$rx_query = array('post_type' => AX_PORTFOLIO_SLUG, 'posts_per_page' =>'-1');		
		if($category_slug!=''){									 
			 $term = term_exists($category_slug);
			 if ($term == 0 || $term == null) {
			 	echo "The ".$category_slug." does not exist!";
			 	return;
			 }
			 $term_id = $term;
			 if(is_array($term)){
			 	$term_id = $term['term_id'];
			 }
			$args = array(
				'tax_query' => array(
					array(
						'taxonomy' => 'ae_portfolio_categories',
						'field' => 'id',
						'terms' => $term_id
					)
				)
			);
			$rx_query = array_merge($rx_query, $args);			 		
		}	
		
		
		$out = '<div class="rx_portfolio container-fluid">';			
			$query = new WP_Query($rx_query);
			if($query->have_posts()) {
				$groupCount = -1;
				
				while($query->have_posts()){
					$groupCount++;
					if($groupCount==0){
						$out .= '<div class="row">';						
						//echo $groupCount." -open row <br />";
					}
														
					$query->the_post();
					$id = get_the_ID();
					$post_options = new AxPostOptions($id);
					$thumbnail_url = $post_options->getFeaturedImage($id, 800, 650);					
					$title = get_the_title($id);					
					
					$out .= '					
					<div class="col-md-6">
						<div class="rx_thumb_ui">
							<div class="rx_thumb_container"><a href="'.$post_options->getURL($id).'" class="rx_image_link"><img src="'.$thumbnail_url.'" alt="" /></a></div>
							<div class="rx_hoverui" data-url="'.$post_options->getURL($id).'">
								<p class="rx_thumb_title aeolusFont1">'.$title.'</p>																				
							</div>			
						</div>			
					</div>					
					';					
					
					
					if($groupCount==1){						
						//echo $groupCount." -close row <br />";
						$out .= '</div>';
						$groupCount = -1;
					}					 
				}
				if($groupCount==0){
					//echo $groupCount." -close row final <br />";
					$out .= '</div>';
				}				
			} else {
				// no posts found
			}
			/* Restore original Post Data */
			wp_reset_query();
		$out .= '</div>';
		return $out;		
	}


	/* one col shortcode
	================================================== */	
	public function rx_aeolus_one_col($atts, $content = null){
		extract(shortcode_atts(array('category_slug' => ''), $atts));
		$rx_query = array('post_type' => AX_PORTFOLIO_SLUG, 'posts_per_page' =>'-1');		
		if($category_slug!=''){									 
			 $term = term_exists($category_slug);
			 if ($term == 0 || $term == null) {
			 	echo "The ".$category_slug." does not exist!";
			 	return;
			 }
			 $term_id = $term;
			 if(is_array($term)){
			 	$term_id = $term['term_id'];
			 }
			$args = array(
				'tax_query' => array(
					array(
						'taxonomy' => 'ae_portfolio_categories',
						'field' => 'id',
						'terms' => $term_id
					)
				)
			);
			$rx_query = array_merge($rx_query, $args);			 		
		}
		
		$out = '<div class="rx_portfolio container-fluid">';			
			$query = new WP_Query($rx_query);
			if($query->have_posts()) {				
				
				while($query->have_posts()){

					$out .= '<div class="row">';
														
					$query->the_post();					
					$id = get_the_ID();
					$post_options = new AxPostOptions($id);
					$thumbnail_url = $post_options->getFeaturedImage($id, 1200, 500, true);					
					$title = get_the_title($id);					
					$out .= '
					<div class="col-md-12">
						<div class="rx_thumb_ui rx_thumb_ui_one_col">
							<div class="rx_thumb_container"><a href="'.$post_options->getURL($id).'" class="rx_image_link"><img src="'.$thumbnail_url.'" alt="" /></a></div>
							<div class="rx_hoverui" data-url="'.$post_options->getURL($id).'">
								<p class="rx_thumb_title aeolusFont1">'.$title.'</p>																				
							</div>						
						</div>
					</div>
					';					
					
					
					$out .= '</div>';					 
				}			
			} else {
				// no posts found
			}
			/* Restore original Post Data */
			wp_reset_query();

		$out .= '</div>';
		return $out;		
	}
	
							
		
}

?>
