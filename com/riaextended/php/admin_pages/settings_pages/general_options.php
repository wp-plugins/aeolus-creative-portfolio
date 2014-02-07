					    <!--==============================================================================-->
					    <!--GENERAL STYLE TAB-->
					    <!--==============================================================================-->
					    <div class="tab-pane active" id="general_opts">
					    	<h3>General options</h3>				    				    						    	
					    	<div class="hline"></div>					    	
					    	<div class="spacer20"></div>
	    	
					    	<!--related projects-->				    					    				    					    						    
					    	<div class="optionBox">
						    	<h4>Related projects</h4>
						    	<p>Show related projects within single pages.</p>
						    	<div class="hline"></div>
						    	<div class="spacer10"></div>
						    	<p class="sk_notice"><strong>NOTE!</strong> In order Related Projects to work you need to assign categories to projects.</p>					    						    							    	
						    	<div>
						    		<?php
									$showRelated = (isset($options['showRelated']))?$options['showRelated']:'';
									$showRelatedChecked = ($showRelated=="ON")?'checked':'';
									$relatedProjectsMaxNo = (isset($options['relatedProjectsMaxNo']))?$options['relatedProjectsMaxNo']:'3';						    		
						    		?>
									<label class="checkbox">
									  <input type="checkbox" name="<?php echo $this->getOptionGroup();?>[showRelated]" value="ON" <?php echo $showRelatedChecked;?>>Show related projects (On/Off)
									</label>
									<div class="spacer20"></div>
									<p>Max number of related projects</p>
									<input style="height: 30px;" class="smallInputText" type="text" name="<?php echo $this->getOptionGroup()?>[relatedProjectsMaxNo]" value="<?php echo $relatedProjectsMaxNo;?>" />						    						    		
						    	</div>
					    	</div>
					    	<!--/related projects-->					    						    	
					    	
					    	<div class="spacer20"></div>
					    	
					    	
					    	<!--options-->				    					    				    					    						    
					    	<div class="optionBox">
						    	<h4>Options</h4>
						    	<p>Labels used within plugin's front-end.</p>
						    	<div class="hline"></div>
						    	<div class="spacer10"></div>
						    	<p class="sk_notice"><strong>NOTE</strong> The re-write slug will affect the way permalinks look, ex: http://website.com/slug/item-name. If you change the slug, in order the changes to take effect, deactivate than activate the theme.</p>
						    	<p class="sk_notice"><strong>NOTE</strong> Do not add spaces within the portfolio slug! Make sure you do not have the same slug as the slug of the portfolio page.</p>						    						    						    							    	
						    	<div>
						    		<?php
										$portfolio_re_write_slug = (isset($options['portfolio_re_write_slug']))?$options['portfolio_re_write_slug']:'portfolio';
										$max_portfolio_posts = (isset($options['max_portfolio_posts']))?$options['max_portfolio_posts']:4;
										$portfolio_slider_height = (isset($options['portfolio_slider_height']))?$options['portfolio_slider_height']:500;
										$portfolio_padding = (isset($options['portfolio_padding']))?$options['portfolio_padding']:0;																																				    		
						    		?>
									<p>Portfolio re-write slug</p>
									<input style="height: 30px;" class="smallInputText" type="text" name="<?php echo $this->getOptionGroup()?>[portfolio_re_write_slug]" value="<?php echo $portfolio_re_write_slug;?>" />
									<p>Max portfolio items / page (for the parallax shortcode)</p>
									<input style="height: 30px;" class="smallInputText" type="text" name="<?php echo $this->getOptionGroup()?>[max_portfolio_posts]" value="<?php echo $max_portfolio_posts;?>" />
									<p>Slider height (used within single portfolio pages)</p>
									<input style="height: 30px;" class="smallInputText" type="text" name="<?php echo $this->getOptionGroup()?>[portfolio_slider_height]" value="<?php echo $portfolio_slider_height;?>" />
									<p>Padding content (single portfolio page - left and right)</p>
									<input style="height: 30px;" class="smallInputText" type="text" name="<?php echo $this->getOptionGroup()?>[portfolio_padding]" value="<?php echo $portfolio_padding;?>" />
									<p class="sk_notice"><strong>NOTE!</strong> If your theme outputs a full width (100%) page as single, you should add a padding of 20, if your contentent is enclosed within a container you should leave padding as 0.</p>																																																		    						    		
						    	</div>
					    	</div>
					    	<!--/options-->					    	
					    	
					    	
					    	<div class="spacer20"></div>
					    	
					    	
					    	<!--labels-->				    					    				    					    						    
					    	<div class="optionBox">
						    	<h4>Labels</h4>
						    	<p>Labels used within plugin's front-end.</p>
						    	<div class="hline"></div>
						    	<div class="spacer10"></div>						    						    						    							    	
						    	<div>
						    		<?php
										$readMoreLB = (isset($options['readMoreLB']))?$options['readMoreLB']:'Open';
										$nextLB = (isset($options['nextLB']))?$options['nextLB']:'Next';
										$prevLB = (isset($options['prevLB']))?$options['prevLB']:'Previous';
										$relatedLB = (isset($options['relatedLB']))?$options['relatedLB']:'Related projects';																										    		
						    		?>
									<p>Read more</p>
									<input style="height: 30px;" class="smallInputText" type="text" name="<?php echo $this->getOptionGroup()?>[readMoreLB]" value="<?php echo $readMoreLB;?>" />
									<p>Next</p>
									<input style="height: 30px;" class="smallInputText" type="text" name="<?php echo $this->getOptionGroup()?>[nextLB]" value="<?php echo $nextLB;?>" />
									<p>Previous</p>
									<input style="height: 30px;" class="smallInputText" type="text" name="<?php echo $this->getOptionGroup()?>[prevLB]" value="<?php echo $prevLB;?>" />
									<p>Related projects</p>
									<input style="height: 30px;" class="smallInputText" type="text" name="<?php echo $this->getOptionGroup()?>[relatedLB]" value="<?php echo $relatedLB;?>" />																																	    						    		
						    	</div>
					    	</div>
					    	<!--/labels-->					    						    	
					    	
					    	<div class="spacer20"></div>
					    	
					    	<!--styles-->				    					    				    					    						    
					    	<div class="optionBox">
						    	<h4>Look and feel</h4>
						    	<p>Choose colors.</p>
						    	<div class="hline"></div>
						    	<div class="spacer10"></div>
						    	<p class="sk_notice"><strong>NOTE!</strong> You can style this plugin further by editing it's CSS located at "css/rx_portfolio.css".</p>						    						    						    							    	
						    	<div>
						    		<?php		
						    			$generalCol = (isset($options['generalCol']))?$options['generalCol']:'1abb9f';																																    		
						    		?>	
									<p>Primary color</p>
									<input id="generalCol" style="height: 30px; width: 100px;" type="text" name="<?php echo $this->getOptionGroup()?>[generalCol]" value="<?php echo $generalCol;?>" />									
							    		<p>
							    			<button id="resetRxColorsBTN" class="btn" type="button">Reset to default</button>
							    		</p>																																										    																																		    						    		
						    	</div>
					    	</div>
					    	<!--/styles-->					    						    	
					    	
					    	<div class="spacer20"></div>
					    	
					    	<!--shortcodes-->				    					    				    					    						    
					    	<div class="optionBox">
						    	<h4>Shortcodes</h4>
						    	<p>Available shortcodes.</p>
						    	<div class="hline"></div>
						    	<div class="spacer10"></div>						    							    						    						    							    	
						    	<div>
						    		<p><span class="shortcode_showcase">[rx_aeolus_three_cols]</span>-Displays all portfolio as three columns.</p>
						    		<p><span class="shortcode_showcase">[rx_aeolus_two_cols]</span>-Displays all portfolio as two columns.</p>
						    		<p><span class="shortcode_showcase">[rx_aeolus_one_col]</span>-Displays all portfolio as one column.</p>
						    		<p class="sk_notice"><strong>NOTE!</strong> For each of the abobe shortcodes you can also display only one category by adding the category slug.</p>
						    		<p><span class="shortcode_showcase">[rx_aeolus_three_cols category_slug="web-design"]</span>Replace "web-design" with your own category slug.</p>
						    		<p><span class="shortcode_showcase">[rx_aeolus_two_cols category_slug="web-design"]</span>Replace "web-design" with your own category slug.</p>
						    		<p><span class="shortcode_showcase">[rx_aeolus_one_col category_slug="web-design"]</span>Replace "web-design" with your own category slug.</p>
						    		<p class="sk_notice"><strong>NOTE!</strong> In order to be able to display portfolio by category, first create categories, assign projects to at least one category. You can get the category slug by going to 
						    			Admin > Aeolus Portfolio > Categories > right panel > slug column</p>
						    			
						    		<p><span class="shortcode_showcase">[rx_aeolus_parallax]</span>-Displays all portfolio with pagination similar to a parallax effect.</p>
						    		<p class="sk_notice"><strong>NOTE!</strong> In order to achieve the best visual effect with [rx_aeolus_parallax], you should add it within a 100% width page (this is possible only if your theme supports this type of page).</p>																																    																																		    						    		
						    	</div>
					    	</div>
					    	<!--/shortcodes-->					    						    	
					    	
					    	<div class="spacer20"></div>					    						    						    						    	
					    	
					    						    						    						    
					    </div>
					    <!--/GENERAL STYLE TAB-->
