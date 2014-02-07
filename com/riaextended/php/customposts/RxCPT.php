<?php
require_once(AXP_CLASS_PATH.'/com/riaextended/php/customposts/GenericPostType.php');
require_once(AXP_CLASS_PATH.'/com/riaextended/php/libs/rx__resizer.php');
/**
 * Rx CPT
 */
class AxCPT extends AXGenericPostType {
	
	/* THUMBS SUBTITLE
	================================================== */	
	public function meta_box_subtitle(){
		global $post;
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;
						
			$customPostOptions = get_post_meta($post->ID, $this->getPostCustomMeta(), false);
			$rx_portfolio_subtitle = (isset($customPostOptions[0]['rx_portfolio_subtitle']))?$customPostOptions[0]['rx_portfolio_subtitle']:'';	
			$rx_portfolio_customurl = (isset($customPostOptions[0]['rx_portfolio_customurl']))?$customPostOptions[0]['rx_portfolio_customurl']:'';			
															
		?>
		<div class="optionBox">
			<p class="sk_notice"><strong>NOTE!</strong> Subtitle will be displayed within preview. Custom URL will replace the permalink, portfolio item will redirect to a custom URL (Leave blank to use the original permalink).</p>
			<div class="sk_admin_row">
				<div class="sk_admin_span3">
					Subtitle:
					<input style="height: 30px" type="text" name="<?php echo $this->getPostCustomMeta();?>[rx_portfolio_subtitle]" value="<?php echo $rx_portfolio_subtitle;?>" />
				</div>
				<div class="sk_admin_span3">	
					Custom url:
					<input style="height: 30px" type="text" name="<?php echo $this->getPostCustomMeta();?>[rx_portfolio_customurl]" value="<?php echo esc_url($rx_portfolio_customurl);?>" />																		
				</div>
				<div class="sk_admin_span3">															
				</div>
				<div class="sk_clear_fx"></div>
			</div>		
		</div>
		<?php		
	}	
	
	/* FEATURED IMAGES
	================================================== */
	public function meta_box_images(){
		global $post;
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;
						
			$customPostOptions = get_post_meta($post->ID, $this->getPostCustomMeta(), false);									
		?>
		<p class="sk_notice"><strong>NOTE!</strong> As a thumb preview please add a featured image from the right panel. Recommended featured image: 1980x1080 (about 150KB-300KB filesize).</p>
		<div id="featured_images_rx_portfolio" class="optionBox" data-post_meta="<?php echo AX_POST_CUSTOM_META;?>">
			<strong>Featured Images</strong>
			<div class="hline"></div>
			<?php
				$featuredImagesAC = (isset($customPostOptions[0]['featuredImages']))?$customPostOptions[0]['featuredImages']:array();																
			?>
			<input id="addFeaturedImagesBTN" type='submit' value='Add images' class='button-secondary' />
			<input id="removeAllFeaturedImagesBTN" type='submit' value='Remove all' class='button-secondary' />
			<div id="featuresThumbsContainer">
				<ul class="sortableThumbs" id="featuredImagesUI">
					<?php if(!empty($featuredImagesAC)):?>
								<?php								
								for ($i=0; $i < sizeof($featuredImagesAC); $i++) {
									$res = wp_get_attachment_image_src($featuredImagesAC[$i], 'medium');
									$iconUrl = 'http://placehold.it/150x150';
									if($res){
										$resizeRes = ax__resize($res[0], 150, 150, true);
										$iconUrl = ($resizeRes)?$resizeRes:$iconUrl;
									}
									$iconHTML = '<li class="ui-state-default"><div class="thumbBoxImage">';
                               		$iconHTML .= '<div class="featuredThumb"><img src="'.$iconUrl.'" /></div>';
                               		$iconHTML .= '<input type="hidden" name="'.$this->getPostCustomMeta().'[featuredImages][]" value="'.$featuredImagesAC[$i].'" />';
									$iconHTML .= '<div class="featuredThumbOverlay">
									<div class="thumbOverlayMove"></div>
									<div class="thumbOverlayRemove"></div>
									</div>';
									$iconHTML .= '</div></li>';
									echo $iconHTML;
								}
								?>
					<?php endif;?>					
				</ul>
				<div class="sk_clear_fx"></div>	
			</div>
		</div>		
						
		
		<?php		
	}

	/* FEATURED VIDEO
	================================================== */
	public function meta_box_video(){
		global $post;
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;						
			$customPostOptions = get_post_meta($post->ID, $this->getPostCustomMeta(), false);									
		?>
		<p class="sk_notice"><strong>NOTE!</strong> Use video instead of featured images. Enter embeded video (iframe code).</p>
		<div class="optionBox">
			<strong>Featured video</strong>
			<div class="hline"></div>
			<?php
				$isFeaturedVideo = (isset($customPostOptions[0]['isFeaturedVideo']))?$customPostOptions[0]['isFeaturedVideo']:'';
				$isFeaturedVideoChecked = ($isFeaturedVideo=='ON')?'checked':'';
				$embedVideoCode = (isset($customPostOptions[0]['embedVideoCode']))?$customPostOptions[0]['embedVideoCode']:'';
			?>
			<label class="checkbox">
				<input type="checkbox" name="<?php echo $this->getPostCustomMeta();?>[isFeaturedVideo]" value="ON" <?php echo $isFeaturedVideoChecked;?>> Use featured video (On/Off)
			</label>
			<div class="space10"></div>
			<textarea rows="8" cols="150" style="width: 100%;" name="<?php echo $this->getPostCustomMeta();?>[embedVideoCode]"><?php echo $embedVideoCode;?></textarea>			
		</div>								
		
		<?php		
	}	
		
}


?>
