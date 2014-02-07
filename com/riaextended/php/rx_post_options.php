<?php

/**
 * post options
 */
require_once(AXP_CLASS_PATH.'/com/riaextended/php/libs/rx__resizer.php');
class AxPostOptions {
	
	private $customPostOptions;
	function __construct($id) {
		$this->customPostOptions = get_post_meta($id, AX_POST_CUSTOM_META, false);
	}	
	
	//get featured image
	public function getFeaturedImageURL($id){
		$imageURL = 'http://placehold.it/1920x1080';
		$res = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
		if($res){
			$imageURL = $res[0];
		}
		return $imageURL;
	}
	
	
	
	//get post settings
	public function getPostSettings(){
		$isFeaturedVideo = (isset($this->customPostOptions[0]['isFeaturedVideo']))?$this->customPostOptions[0]['isFeaturedVideo']:'';
		$isFeaturedVideo = ($isFeaturedVideo=='ON')?true:false;
		return array('isFeaturedVideo'=>$isFeaturedVideo, 'post_images_height'=>450);
	}
	
	//get video code
	public function getVideoCode(){
		return (isset($this->customPostOptions[0]['embedVideoCode']))?$this->customPostOptions[0]['embedVideoCode']:'';
	}	
	//get featured image
	public function getFeaturedImage($post_id, $w=800, $h=650, $isOneCol=false){
		$imageURL = 'http://placehold.it/'.$w.'x'.$h;		
		$res = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
		if($res){
			if($isOneCol){
				$thumb_temp_url = ax__resize($res[0], $w);
			}else{
				$thumb_temp_url = ax__resize($res[0], $w, $h, true);
			}
			($thumb_temp_url)?$imageURL = $thumb_temp_url:$imageURL=$imageURL;	
		}
		return $imageURL;
	}
	
	//get featured images
	public function getFeaturedImages($w, $h){
		$featuredImages = false;
		$featuredImagesAC = (isset($this->customPostOptions[0]['featuredImages']))?$this->customPostOptions[0]['featuredImages']:array();						
		if(!empty($featuredImagesAC)){
			$featuredImages = array();
			for ($i=0; $i < sizeof($featuredImagesAC); $i++) {
				$res = wp_get_attachment_image_src($featuredImagesAC[$i], 'full'); 
				$imageUrl = $res[0];
				/*
				$imageUrl = 'http://placehold.it/'.$w.'x'.$h;
				if($res){
					$resizeRes = ax__resize($res[0], $w);
					$imageUrl = ($resizeRes)?$resizeRes:$imageUrl;					
				}				 
				*/
				array_push($featuredImages, $imageUrl);
			}
		}
		return $featuredImages;
	}
	
	//get portfolio single - thumbs
	public function gePortfolioThumbs($w=220, $h=130){
		$featuredImages = false;
		$featuredImagesAC = (isset($this->customPostOptions[0]['featuredImages']))?$this->customPostOptions[0]['featuredImages']:array();		
		if(!empty($featuredImagesAC)){
			$featuredImages = array();
			for ($i=0; $i < sizeof($featuredImagesAC); $i++) {
				$res = wp_get_attachment_image_src($featuredImagesAC[$i], 'full'); 
				$imageUrl = 'http://placehold.it/'.$w.'x'.$h;
				if($res){
					$resizeRes = ax__resize($res[0], $w, $h, true);
					$imageUrl = ($resizeRes)?$resizeRes:$imageUrl;					
				}
				array_push($featuredImages, $imageUrl);
			}
		}
		return $featuredImages;		
	}	
	
	public function getFeaturedImageThumb($post_id, $w, $h){
		$imageURL = 'http://placehold.it/'.$w.'x'.$h;
		$res = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
		if($res){
			$thumb_temp_url = ax__resize($res[0], $w, $h, true);
			($thumb_temp_url)?$imageURL = $thumb_temp_url:$imageURL=$imageURL;	
		}
		return $imageURL;		
	}		
	
	//get video settings
	public function getVideoSettings(){
		$isFeaturedVideo = (isset($this->customPostOptions[0]['isFeaturedVideo']))?$this->customPostOptions[0]['isFeaturedVideo']:'';
		$isFeaturedVideo = ($isFeaturedVideo=='ON')?true:false;
		$embedVideoCode = (isset($this->customPostOptions[0]['embedVideoCode']))?$this->customPostOptions[0]['embedVideoCode']:'';
		return array('isFeaturedVideo'=>$isFeaturedVideo, 'embedVideoCode'=>$embedVideoCode);		
	}	
	
	
	//get subtitle
	public function getSubtitle(){
		return (isset($this->customPostOptions[0]['rx_portfolio_subtitle']))?$this->customPostOptions[0]['rx_portfolio_subtitle']:'';
	}	

	//get subtitle
	public function getURL($ids){
		$customUrl = (isset($this->customPostOptions[0]['rx_portfolio_customurl']))?$this->customPostOptions[0]['rx_portfolio_customurl']:false;
		if(!$customUrl){
			$customUrl = get_permalink($ids);
		}
		return $customUrl;
	}
	
	
	public function get_the_excerpt_max_charlength($charlength) {
		$out = '';
		$excerpt = get_the_excerpt();
		$charlength++;
	
		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				$out .= mb_substr( $subex, 0, $excut );
			} else {
				$out .= $subex;
			}
			$out .= '[...]';
		} else {
			$out .= $excerpt;
		}
		return $out;
	}

	
	//get bootstrap carousel
	public function getBootstrapCarousel($carouselImagesAC){
		$carousel_id = uniqid('carousel_');
		$active = 'active';
		$carouselItems = '';
		$carouselIndicators = '';
		for ($i=0; $i < sizeof($carouselImagesAC); $i++) { 
			$carouselItems .= '<div class="'.$active.' item"><img src="'.$carouselImagesAC[$i].'" alt="" /></div>';			
			$carouselIndicators .= '<li data-target="#'.$carousel_id.'" data-slide-to="'.$i.'" class="'.$active.'"></li>';
			$active = '';
		}
		$carouselControlsStyle = (sizeof($carouselImagesAC)==1)?$carouselControlsStyle='display: none;':$carouselControlsStyle='';		
		
		$carouselHTML = '
		<!--image carousel-->
		<div id="'.$carousel_id.'" class="carousel slide">
			<ol class="carousel-indicators" style="'.$carouselControlsStyle.'">
				'.$carouselIndicators.'
			</ol>		
			<!-- Carousel items -->
				<div class="carousel-inner">
					'.$carouselItems.'						
				</div>						
			<!-- /Carousel items -->
			<!-- Carousel nav -->
				<a style="'.$carouselControlsStyle.'" class="carousel-control left" href="#'.$carousel_id.'" data-slide="prev">&lsaquo;</a>
				<a style="'.$carouselControlsStyle.'" class="carousel-control right" href="#'.$carousel_id.'" data-slide="next">&rsaquo;</a>
			<!-- Carousel nav -->												
		</div>		
		<!--/image carousel-->
		';
		
		return $carouselHTML;
	}	
			
	
}


?>