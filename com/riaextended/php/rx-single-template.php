<?php get_header(); ?>

<?php
require_once(AXP_CLASS_PATH.'/com/riaextended/php/rx_post_options.php');
require_once(AXP_CLASS_PATH.'/com/riaextended/php/rx_plugin_options.php');

$post_options = new AxPostOptions(get_the_ID());
$featured_images = $post_options->getFeaturedImages(1980, 1080);
$video_settings = $post_options->getVideoSettings();
$subtitle = $post_options->getSubtitle();
$postTitle = get_the_title($post->ID);
$svg_line_opacity = '.2';
$svg_poly_image_opacity = '.8';
$portfolio_thumbs = $post_options->gePortfolioThumbs();
$count_thumbs = -1;

$pluginOpts = new AxPluginOptions();
$labels = $pluginOpts->getLabels();
$colors = $pluginOpts->getColors();
$svg_line_color = $colors['generalCol'];

$related_post_settings = $pluginOpts->getRelatedSettings();
?>

<?php if(($featured_images) || ($video_settings['isFeaturedVideo'])):?>
	
	<!--featured images showcase-->
	<?php if(!$video_settings['isFeaturedVideo'] && ($featured_images)):?>
		
			<div class="portfolioSingleFeaturedImages">
				<ul id="featuredimages">
					<?php for ($i=0; $i < sizeof($featured_images); $i++): ?>
					<li class="rx_featuredImage" data-image="<?php echo $featured_images[$i];?>"><?php echo $featured_images[$i];?></li>
					<?php endfor;?>
				</ul>
				
				
				<!--featured images nav-->
				<div class="featuredImagesNav">
					<div class="centeredNav">
						<div class="leftNavControl thumb_navigation">											
							<svg class="nav_svg" width="40" height="130" viewBox="0 0 40 130" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
								<polygon class="r_polly" opacity=".6" fill="#<?php echo $svg_line_color;?>" points="25,0 20,80 0,40" />																																																																	
							</svg>						
						</div>
						<!--nav content-->
						<div class="navContentMask">
							<div class="navContent">
								
								<?php if($portfolio_thumbs):?>
									<?php for ($i=0; $i < sizeof($portfolio_thumbs); $i++):?>
										<?php $count_thumbs++;?>
										<!--portfolio thumb primary shape-->
										<?php if($count_thumbs%2==0):?>										
											<div class="portfolioThumbItem">
												<!--svg lines-->
												<div class="svgLinesUI">
													<svg width="220" height="130" viewBox="0 0 220 130" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
														<g>
															<clipPath id="hex-mask-first_<?php echo $count_thumbs;?>">
																<polygon points="24,4 196,4 215,126 5,126" />
															</clipPath>
														</g>																										      																														
														<polygon class="r_polly" fill="#<?php echo $svg_line_color;?>" opacity="<?php echo $svg_line_opacity;?>" points="20,0 200,0 220,130 0,130" />																														
														<image class="polly_image" opacity="<?php echo $svg_poly_image_opacity;?>" clip-path="url(#hex-mask-first_<?php echo $count_thumbs;?>)" height="100%" width="100%" xlink:href="<?php echo $portfolio_thumbs[$i];?>" preserveAspectRatio="xMidYMin slice" />																						
													</svg>
												</div>											
												<!--/svg image-->								
											</div>																				
										<?php endif;?>
										<!--/portfolio thumb primary shape-->
										
										<!--portfolio thumb secondary shape-->
										<?php if($count_thumbs%2!=0):?>										
											<div class="portfolioThumbItem">
												<!--svg lines-->
												<div class="svgLinesUI">
													<svg width="220" height="130" viewBox="0 0 220 130" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">      																														
														<g>
															<clipPath id="hex-mask-second_<?php echo $count_thumbs;?>">
																<polygon points="4,4 216,4 196,126 24,126" />
															</clipPath>	
														</g>													
														<polygon class="r_polly" fill="#<?php echo $svg_line_color;?>" opacity="<?php echo $svg_line_opacity;?>" points="0,0 220,0 200,130 20,130" />																														
														<image class="polly_image" opacity="<?php echo $svg_poly_image_opacity;?>" clip-path="url(#hex-mask-second_<?php echo $count_thumbs;?>)" height="100%" width="100%" xlink:href="<?php echo $portfolio_thumbs[$i];?>" preserveAspectRatio="xMidYMin slice" />																						
													</svg>
												</div>											
												<!--/svg image-->								
											</div>																				
										<?php endif;?>
										<!--portfolio thumb secondary shape-->									
																		
									<?php endfor;?>
								<?php endif;?>																											
								
							</div>
						</div>
						<!--/nav content-->
						<div class="rightNavControl thumb_navigation">
							<svg class="nav_svg" width="40" height="130" viewBox="0 0 40 130" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
								<polygon class="r_polly" opacity=".6" fill="#<?php echo $svg_line_color;?>" points="15,0 20,80 40,40" />																																																																	
							</svg>						
						</div>
					</div>
				</div>	
				<!--featured images nav-->				
								
			</div>
		
		
		
	<?php endif;?>
	<!--/featured images showcase-->
	
	<!--featured video-->
	<?php if($video_settings['isFeaturedVideo']):?>		
		<div class="portfolioVideoShowcase">
			<?php echo $video_settings['embedVideoCode'];?>
		</div>		
	<?php endif;?>
	<!--/featured video-->	
	
<?php endif;?>


<!--portfolio content-->
<div class="portfolioSingleContent" data-isPortfolio="true">
	<p class="aeolusFont2 pageTitle"><?php echo $postTitle;?></p>
	<p class="aeolusFont1 pageSubtitle"><?php echo $subtitle;?></p>	
	
			<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
				
				<!--the content-->
				<div class="rxPostContent">
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php the_content();?>
					</div>
				</div>
				<!--/the content-->
									
			<?php endwhile; else: ?>
			<p><?php _e('No posts were found. Sorry!', 'default_textdomain'); ?></p>
			<?php endif; wp_reset_query();?>
			
			
			
	<div class="related_content rxPostContent">
		<div class="rx_nav">
		    <p class="alignright nextPost"><?php next_post_link('%link', $labels['nextLB'].' »');?></p>
		    <p class="alignright previousPost"><?php previous_post_link('%link', '« '.$labels['prevLB']);?></p>
		    <div class="clear-fx"></div> 	
		</div>	
					
		<!--related projects-->
		<?php if($related_post_settings['showRelated']):?>
			<?php
						$showRelatedPosts = false;
					 	$terms = get_the_terms($post->ID , 'ae_portfolio_categories', 'string');			
			?>
			<?php if(is_array($terms)):?>
			<!--related main-->
			<div class="relatedPortfolio">			
				<h3 class="relatedTitle"><?php echo $labels['relatedLB'];?></h3>
				<div class="relatedTitleUnderline"></div>
				<?php
						$term_ids = wp_list_pluck($terms,'term_id');
						if(is_array($term_ids)){
							$comma_separated_ids = implode(",", $term_ids);
							$ids = explode(',', $comma_separated_ids);						
						}
																			
						
						if(isset($ids)){
								$posts_array = get_posts(array('numberposts'=>$related_post_settings['relatedProjectsMaxNo'], 'post_type'=>AX_PORTFOLIO_SLUG, 'post_status'=>'publish',
								'exclude'=>get_the_ID(), 'tax_query'=>array(
										'relation'=>'AND',
										array('taxonomy'=>'ae_portfolio_categories',
										'field'=>'id',
										'terms'=>$ids									
										)
									)
								));						
						}														
						if(isset($posts_array)){
							if(is_array($posts_array)){							
								if(sizeof($posts_array)>0){
									$showRelatedPosts = true;
								}
							}
						}			
				?>

				<?php if($showRelatedPosts):?>
					<div class="container-fluid">
					<div class="row">
								<div class="rx_related_posts">
									<?php								
									global $post;
									$out = '';
									$groupCount = -1;				
									foreach($posts_array as $post ) :	setup_postdata($post); ?>																									
									<?php
										$groupCount++;
										if($groupCount==0){
											$out .= '<div class="row-fluid">';						
											//echo $groupCount." -open row <br />";
										}																	
										
										$post_opts = new AxPostOptions($post->ID);
																													
										$p_thumb = $post_opts->getFeaturedImageThumb($post->ID, 800, 500);									
										$permalink = get_permalink($post->ID);
										$r_title = get_the_title($post->ID);
										$out .= '
										<div class="col-md-4">
											<div class="rx_related_post" data-url="'.$permalink.'">
												<a href="'.$permalink.'" class="hero_thumb_image_link"><img src="'.$p_thumb.'" alt="" /></a>
												<div class="rx_related_post_overlay">
													<a href="'.$permalink.'" class="rx_related_link fontStyle1">'.$r_title.'</a>
												</div>										
											</div>
										</div>
										';
										if($groupCount==2){						
											//echo $groupCount." -close row <br />";
											$out .= '</div>';
											$groupCount = -1;
										}																	
									?>																
									<?php endforeach; ?>			
									<?php
									if($groupCount==0 || $groupCount==1){
										//echo $groupCount." -close row final <br />";
										$out .= '</div>';
									}
									echo $out;								
									?>
								</div>
					</div>
					<!--end row-->
					</div>
					<!--end container-->
				<?php endif;?>
			</div>
			<?php endif;?>	
			<!--/related main-->	
		<?php endif;?>
		<!--/related projects-->
	</div>			
			
			
			
			
				
</div>
<!--portfolio content-->



<?php get_footer(); ?>
