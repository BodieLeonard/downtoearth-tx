<?php
	// Setup globals
	// @todo: Get these out of template
	global $wp_query;

	// Setup image width and height variables
	// @todo: Investigate if these are still needed here
	$image_width  = get_option( 'single_view_image_width' );
	$image_height = get_option( 'single_view_image_height' );
	
	clear('space');
?>

<div class="inner layout-sidebar-no">
	<div class="hentry">
		<div id="single_product_page_container">
			
			<?php
				// Breadcrumbs
				wpsc_output_breadcrumbs( array( 'before-breadcrumbs' => '', 'after-breadcrumbs' => '' ) );
		
				// Plugin hook for adding things to the top of the products page, like the live search
				do_action( 'wpsc_top_of_products_page' );
			?>
			
			<div class="single_product_display group productdisplay">
		<?php
				/**
				 * Start the product loop here.
				 * This is single products view, so there should be only one
				 */
		
				while ( wpsc_have_products() ) : wpsc_the_product(); ?>
							
						<div class="textcol">	
							<div class="imagecol">
								<?php if ( wpsc_the_product_thumbnail() ) : ?>
										<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo wpsc_the_product_image(); ?>">
											<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(get_option('product_image_width'),get_option('product_image_height'),'','single'); ?>"/>
										</a>
										<?php 
										if ( function_exists( 'gold_shpcrt_display_gallery' ) ) :
											echo gold_shpcrt_display_gallery( wpsc_the_product_id() );
											
											if ( get_option( 'show_gallery' ) ) :
											?>
											<style type="text/css">
	.wpcart_gallery img { 
		width:<?php echo get_option('wpsc_gallery_image_width') ?>px !important; 
		height:<?php echo get_option('wpsc_gallery_image_height') ?>px !important; 
	}
	div.single_product_display div.textcol { min-height:<?php echo get_option('single_view_image_height') + get_option('wpsc_gallery_image_height') + 25 ?>px; }
											</style>
											<?php
											endif;
										endif;
										?>
								<?php else: ?>
										<a href="<?php echo wpsc_the_product_permalink(); ?>">
											<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo get_bloginfo('template_url') . '/wpsc-images/no_image.jpg'; ?>" width="<?php echo get_option('product_image_width'); ?>" height="<?php echo get_option('product_image_height'); ?>" />
										</a>
								<?php endif; ?>
								
								<?php if( wpsc_product_on_special() ) echo '          <div class="sale-icon-big">Sale!</div>'; ?>
							</div><!--close imagecol-->   
		
							<div class="producttext productcol">			
								
								<h2 class="prodtitles no-cufon">
									<?php echo wpsc_the_product_title(); ?> 
									<?php echo str_replace('>' . __( 'Edit', 'wpsc' ) . '<', '><img src="' . get_template_directory_uri() . '/images/icons/pencil16.png" alt="' . __( 'Edit', 'wpsc' ) . '" /><', wpsc_edit_the_product_link()); ?>
								</h2>
								
								<?php do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post); ?>
								
								<div class="product_description">
									<?php echo do_shortcode( wpsc_the_product_description() ); ?>
								</div><!--close product_description -->
								
								<?php do_action( 'wpsc_product_addons', wpsc_the_product_id() ); ?>		
								
								<?php if ( wpsc_the_product_additional_description() ) : ?>
									<div class="single_additional_description">
										<p><?php echo do_shortcode( wpsc_the_product_additional_description() ); ?></p>
									</div><!--close single_additional_description-->
								<?php endif; ?>		
								
								<?php do_action( 'wpsc_product_addon_after_descr', wpsc_the_product_id() ); ?>
								
								<?php
								/**
								 * Custom meta HTML and loop
								 */
								?>
		                        <?php if (wpsc_have_custom_meta()) : ?>
								<div class="custom_meta">
									<?php while ( wpsc_have_custom_meta() ) : wpsc_the_custom_meta(); ?>
										<p><strong><?php echo wpsc_custom_meta_name(); ?>: </strong><?php echo wpsc_custom_meta_value(); ?></p>
									<?php endwhile; ?>
								</div><!--close custom_meta-->
		                        <?php endif; ?>                
									
								<?php if(wpsc_show_stock_availability()): ?>
									<?php if(wpsc_product_has_stock()) : ?>
										<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="in_stock"><?php _e('Product in stock', TEXTDOMAIN); ?></div>
									<?php else: ?>
										<div id="stock_display_<?php echo wpsc_the_product_id(); ?>" class="out_of_stock"><?php _e('Product not in stock', TEXTDOMAIN); ?></div>
									<?php endif; ?>
								<?php endif; ?>	
							                     
								<div class="rating">   
									<?php 
										$old_star = site_url() . '/wp-content/plugins/wp-e-commerce/wpsc-core/images/';
										$new_star = get_template_directory_uri() . '/wpsc-images/';
										
										$rater = str_replace( $old_star . 'grey-star.gif', $new_star . 'grey-star.gif', wpsc_product_rater() );
										$rater = str_replace( $old_star . 'gold-star.gif', $new_star . 'gold-star.gif', $rater );
										
										echo $rater; clear(); 
									?>
								</div>
								
								<div class="price-text"> 
									
									<?php if(wpsc_product_is_donation()) : ?>
										<label for="donation_price_<?php echo wpsc_the_product_id(); ?>"><?php _e('Donation', TEXTDOMAIN); ?>: </label>
										<input type="text" id="donation_price_<?php echo wpsc_the_product_id(); ?>" name="donation_price" value="<?php echo wpsc_calculate_price(wpsc_the_product_id()); ?>" size="6" />
									<?php else : ?>                           
								
										<h2 class="prodtitles no-cufon"><?php _e( 'Price', TEXTDOMAIN ) ?></h2>   
									
										<div class="price">                  
											
											<?php if( wpsc_product_on_special() ) : ?>
												<span class="oldprice" id="old_product_price_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_product_normal_price(); ?></span>
											<?php endif; ?>    
											<span class="price-value pricedisplay" id='product_price_<?php echo wpsc_the_product_id(); ?>'><?php echo wpsc_the_product_price(); ?></span>    
											
											<?php if(wpsc_product_on_special()) : ?>
												<p class="pricedisplay product_<?php echo wpsc_the_product_id(); ?> pricesave"><?php _e('You save', TEXTDOMAIN); ?>: <span class="yousave" id="yousave_<?php echo wpsc_the_product_id(); ?>"><?php echo wpsc_currency_display(wpsc_you_save('type=amount'), array('html' => false)); ?>! (<?php echo wpsc_you_save(); ?>%)</span></p>
											<?php endif; ?>
				                                                                        
											<?php if( wpsc_product_has_multicurrency() ) : ?>
				        						<span class="textsmall">                 
													<?php echo wpsc_display_product_multicurrency(); ?>
												</span>	                                   
											<?php endif; ?>   
					
											<?php if( wpsc_show_pnp() ) : ?><br/>   										
												<span class="pricedisplay wpscsmall">
													<?php echo __('Shipping', TEXTDOMAIN); ?>:
													<?php echo wpsc_product_postage_and_packaging(); ?>
												</span>
											<?php endif; ?>	
										
										</div>
										
									<?php endif; ?>
									
									<?php clear() ?>
								</div><!--close wpsc_product_price-->
								
								<!--sharethis-->
								<?php if ( get_option( 'wpsc_share_this' ) == 1 ): ?>
								<div class="st_sharethis" displayText="ShareThis"></div>
								<?php endif; ?>
								<!--end sharethis-->
								
								<?php
								/**
								 * Form data
								 */
								?>
								
								<form class="product_form" enctype="multipart/form-data" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="1" id="product_<?php echo wpsc_the_product_id(); ?>">
									
									<?php if ( wpsc_product_has_personal_text() ) : ?>
										<div class="custom_text">
											<h4 class="no-cufon"><?php _e( 'Personalize Your Product', TEXTDOMAIN ); ?></h4>
											<p><?php _e( 'Complete this form to include a personalized message with your purchase.', TEXTDOMAIN ); ?></p>
											<textarea cols='55' rows='5' name="custom_text" class="right-fix"></textarea> 
								
											<?php clear() ?>
										</div>
									<?php endif; ?>
								
									<?php if ( wpsc_product_has_supplied_file() ) : ?>
										<div class="custom_file last">
											<h4 class="no-cufon"><?php _e( 'Upload a File', TEXTDOMAIN ); ?></h4>
											<p><?php _e( 'Select a file from your computer to include with this purchase.', TEXTDOMAIN ); ?></p>
											<input type="file" name="custom_file" class="right-fix" />
										</div>
									<?php endif; ?>	                     
							
									<?php if(wpsc_product_has_personal_text() OR wpsc_product_has_supplied_file()) : ?>	
										<div class="clear space"></div>         
									<?php endif; ?>     
									
									<div class="fields">
										<?php /** the variation group HTML and loop */?>     
				                        <?php if ( wpsc_have_variation_groups() ) { ?>
										<div class="wpsc_variation_forms">
											
											<?php while (wpsc_have_variation_groups()) : wpsc_the_variation_group(); ?>
												<p>
													<label for="<?php echo wpsc_vargrp_form_id(); ?>"><?php echo wpsc_the_vargrp_name(); ?>:</label>
													<?php /** the variation HTML and loop */?>
													<select class='wpsc_select_variation' name="variation[<?php echo wpsc_vargrp_id(); ?>]" id="<?php echo wpsc_vargrp_form_id(); ?>">
													<?php while (wpsc_have_variations()) : wpsc_the_variation(); ?>
														<option value="<?php echo wpsc_the_variation_id(); ?>" <?php echo wpsc_the_variation_out_of_stock(); ?>><?php echo wpsc_the_variation_name(); ?></option>
													<?php endwhile; ?>
													</select> 
												</p>
											<?php endwhile; ?>
										
										</div><!--close wpsc_variation_forms-->
										<?php } ?>
										
										<?php /** the variation group HTML and loop ends here */?>
			
										<?php
										/**
										 * Quantity options - MUST be enabled in Admin Settings
										 */
										?>
										<?php if( wpsc_has_multi_adding() ): ?>
			                            	<fieldset>
												<p>
													<label class='wpsc_quantity_update' for='wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>'>
														<?php echo __('Quantity', TEXTDOMAIN); ?>:
													</label>
													<input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" />          
											    </p>
												
												<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
												<input type="hidden" name="wpsc_update_quantity" value="true" />
			                                </fieldset>
										<?php endif ;?>
									</div>             
									
									<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
									<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />					
									<?php if( wpsc_product_is_customisable() ) : ?>
										<input type="hidden" value="true" name="is_customisable"/>
									<?php endif; ?>
							
									<?php
									/**
									 * Cart Options
									 */
									?>
		
									<div class="buy-button">
										<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
											
											<?php if(wpsc_product_has_stock()) : ?>
												
												<div class="add-cart-button">
													<div class="wpsc_buy_button_container more-button bg-button">
														
														<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
															<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
															<input class="wpsc_buy_button icon-img arrow" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', TEXTDOMAIN ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')" />
														<?php else: ?>
															<input class="wpsc_buy_button icon-img arrow" type="submit" value="<?php _e('Add To Cart', TEXTDOMAIN); ?>" name="Buy" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button" />
														<?php endif; ?>
														
														<div class="wpsc_loading_animation">
															<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
															<?php _e('Updating cart...', TEXTDOMAIN); ?>
														</div><!--close wpsc_loading_animation-->
													
													</div><!--close wpsc_buy_button_container-->
												</div>
											
											<?php else : ?>
											
												<p class="soldout"><?php _e('This product has sold out.', TEXTDOMAIN); ?></p>
											
											<?php endif ; ?>
										
										<?php endif ; ?>
									</div>
								</form><!--close product_form-->
							
								<?php
									if ( (get_option( 'hide_addtocart_button' ) == 0 ) && ( get_option( 'addtocart_or_buynow' ) == '1' ) )
										echo wpsc_buy_now_button( wpsc_the_product_id() );
		
									echo wpsc_also_bought( wpsc_the_product_id() );
								
								if(wpsc_show_fb_like()): ?>
			                        <div class="FB_like">
			                        	<iframe src="https://www.facebook.com/plugins/like.php?href=<?php echo wpsc_the_product_permalink(); ?>&amp;layout=standard&amp;show_faces=true&amp;width=435&amp;action=like&amp;font=arial&amp;colorscheme=light" frameborder="0"></iframe>
			                        </div><!--close FB_like-->
		                        <?php endif; ?>
							</div><!--close productcol-->
						</div>
				
						<form onsubmit="submitform(this);return false;" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_extra_<?php echo wpsc_the_product_id(); ?>">
							<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="prodid" />
							<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="item" />
						</form>
				</div><!--close single_product_display-->
				
				<?php echo wpsc_product_comments(); ?>
		
		<?php endwhile;   
		
				$special_items_show  = get_option( 'bl_store_show_special_items' );
				$special_items_title = get_option( 'bl_store_title_special_items', '' );
				$special_items_descr = get_option( 'bl_store_description_special_items', '' );
				
				if( $special_items_descr != '' )  
					$special_items_descr .= '[/special_products]';	                   	
		
				if( get_option( 'bl_store_show_special_items' ) ) 
					echo do_shortcode('[special_products title="' . $special_items_title . '"]' . $special_items_descr ); 
			
			do_action( 'wpsc_theme_footer' ); ?> 
		
		</div><!--close single_product_page_container-->
	</div>
</div>