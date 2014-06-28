<?php
global $wpsc_query, $wpdb;
$image_width = get_option('single_view_image_width');
$image_height = get_option('single_view_image_height');
?>
<!--<h2 class="title-page"><?php convertTags( single_post_title( '', false ) )  ?></h2>-->

<div class="space"></div>
            
<div id='products_page_container' class="wrap wpsc_container">
	
	<?php include 'breadcrumb.php' ?>
	
	<?php do_action('wpsc_top_of_products_page'); // Plugin hook for adding things to the top of the products page, like the live search ?>
	
	<div class="productdisplay">
	<?php /** start the product loop here, this is single products view, so there should be only one */?>
		<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
			<div class="single_product_display product_view_<?php echo wpsc_the_product_id(); ?>">
				<div class="textcol">
					<?php if(get_option('show_thumbnails')) :?>
					<div class="imagecol">
						<?php 
								if(wpsc_the_product_thumbnail())
									$img_url = wpsc_the_product_image($image_width, $image_height);
								else
									$img_url = get_bloginfo('template_url') . '/images/no_image.jpg';
						?>
								<a rel="<?php echo str_replace(array(" ", '"',"'", '&quot;','&#039;'), array("_", "", "", "",''), wpsc_the_product_title()); ?>" class="thickbox preview_link" href="<?php echo wpsc_the_product_image(); ?>">
									<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo $img_url ?>" />
								</a>  
						
						<?php if($wpsc_query->product['price'] - $wpsc_query->product['special_price'] > 0 && $wpsc_query->product['special_price'] > 0) : ?>
							<div class="sale-icon-big">Sale!</div>
						<?php endif; ?> 
					</div>
					<?php endif; ?> 
		
					<div class="producttext">
						<h2 class="prodtitles no-cufon">
							<?php echo wpsc_the_product_title(); ?> 
							<?php echo str_replace('>Edit<', '><img src="'.get_bloginfo('template_url').'/images/icons/pencil16.png" alt="Edit" /><', wpsc_edit_the_product_link()); ?>
						</h2>
						
						<?php do_action('wpsc_product_before_description', wpsc_the_product_id(), $wpsc_query->product); ?>
						
						<div class="wpsc_description"><?php echo wpsc_the_product_description(); ?></div>
		
						<?php do_action('wpsc_product_addons', wpsc_the_product_id()); ?>
						
						<?php if(wpsc_the_product_additional_description()) : ?>
						<div class="single_additional_description">
					    <?php
										$value = '';
										$the_addl_desc = wpsc_the_product_additional_description();
										if( is_serialized($the_addl_desc) ) {
											$addl_descriptions = @unserialize($the_addl_desc);
										} else {
											$addl_descriptions = array('addl_desc', $the_addl_desc);
										}
										
										if( isset($addl_descriptions['addl_desc']) ) {
											$value = $addl_descriptions['addl_desc'];
										}
					
					    	if( function_exists('wpsc_addl_desc_show') ) {
					    		echo wpsc_addl_desc_show( $addl_descriptions );
					    	} else {
											echo stripslashes( wpautop($the_addl_desc, $br=1));
					    	}
					    ?>
						</div>
					<?php endif; ?>
				
					<?php do_action('wpsc_product_addon_after_descr', wpsc_the_product_id()); ?>

					<?php /** the custom meta HTML and loop */ ?>
					<div class="custom_meta">
						<?php while (wpsc_have_custom_meta()) : wpsc_the_custom_meta(); 	
								if (stripos(wpsc_custom_meta_name(),'g:') !== FALSE){
									continue;
								}
							?>
							<p><strong><?php echo wpsc_custom_meta_name(); ?>: </strong><?php echo wpsc_custom_meta_value(); ?></p>
						<?php endwhile; ?>
					</div>
					<?php /** the custom meta HTML and loop ends here */?>
					                     
					                     
					<div class="rating">   
						<?php echo wpsc_product_rater(); clear() ?>
					</div>
					
					<div class="price-text">
						<h2 class="prodtitles no-cufon"><?php _e( 'Price', 'wpsc' ) ?></h2>
						<div class="price">                       
							<?php if(wpsc_product_on_special()) : ?>
								<span class='oldprice'><?php echo wpsc_product_normal_price(); ?></span>
							<?php endif; ?>
							<span class='price-value'><?php echo wpsc_the_product_price(); ?></span> 
							
							<br/> 
                                      
        					<span class="textsmall">                 
								<?php if(wpsc_product_has_multicurrency()) : ?>
									<?php echo wpsc_display_product_multicurrency(); ?>
								<?php endif; ?>
							</span>	
							
							<br/>	       
	
							<?php if(get_option('display_pnp') == 1) : ?>
								<span class="pricedisplay wpscsmall">
									<?php echo __('P&amp;P', 'wpsc'); ?>:
									<?php echo wpsc_product_postage_and_packaging(); ?>
								</span>
							<?php endif; ?>	
						</div>                               
						<div class="clear">&nbsp;</div>
					</div>                               
					                    
					<form class='product_form' enctype="multipart/form-data" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="1" id="product_<?php echo wpsc_the_product_id(); ?>">          
					
					
					<?php if(wpsc_product_has_personal_text()) : ?>
						<div class='custom_text'>
							<h4 class="no-cufon"><?php echo __('Personalize your product', 'wpsc'); ?></h4>
							<p><?php echo __('Complete this form to include a personalized message with your purchase.', 'wpsc'); ?></p>
							<input type='text' name='custom_text' id="custom_text" value='' class="right-fix" />  
						
							<div class="clear"></div>
						</div>
					<?php endif; ?>
					
					<?php if(wpsc_product_has_supplied_file()) : ?>
						<div class='custom_file last'>
							<h4 class="no-cufon"><?php echo __('Upload a File', 'wpsc'); ?></h4>
							<p><?php echo __('Select a file from your computer to include with this purchase.  ', 'wpsc'); ?></p>
							<input type='file' name='custom_file' id="custom_file" value='' class="right-fix" />  
						</div>
					<?php endif; ?>                      
					
					<?php if(wpsc_product_has_personal_text() OR wpsc_product_has_supplied_file()) : ?>	
						<div class="clear space"></div>         
					<?php endif; ?>        
					
					<div class="fields">
						<?php /** the variation group HTML and loop */?>
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
						</div>
						<?php /** the variation group HTML and loop ends here */?>
										
						                   
						<!-- THIS IS THE QUANTITY OPTION MUST BE ENABLED FROM ADMIN SETTINGS -->
						<?php if(wpsc_has_multi_adding()): ?>
						<fieldset>
							<p>
								<label class='wpsc_quantity_update' for='wpsc_quantity_update[<?php echo wpsc_the_product_id(); ?>]'>
									<?php echo __('Quantity', 'wpsc'); ?>:
								</label>
								<input type="text" id='wpsc_quantity_update' name="wpsc_quantity_update[<?php echo wpsc_the_product_id(); ?>]" size="2" value="1"/>
						    </p>
						    
							<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
							<input type="hidden" name="wpsc_update_quantity" value="true"/>
						</fieldset>
						<?php endif ;?>   
					
						<?php if(function_exists('wpsc_akst_share_link') && (get_option('wpsc_share_this') == 1)) {
							echo wpsc_akst_share_link('return');
						} ?>
						
						<input type="hidden" value="add_to_cart" name="wpsc_ajax_action"/>
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id"/>
								
						<?php if(wpsc_product_is_customisable()) : ?>				
							<input type="hidden" value="true" name="is_customisable"/>
						<?php endif; ?>       
						<!-- END OF QUANTITY OPTION -->            
					</div>	
					
					
					<div class="buy-button">
						<?php if((get_option('hide_addtocart_button') == 0) ) : ?>
							
							<?php if(wpsc_product_has_stock()) : ?>
								
								<div class="add-cart-button">
									
									<div class="more-button bg-button">
										<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '' && (get_option('addtocart_or_buynow') == '1')) : ?>
											<?php $action =  wpsc_product_external_link(wpsc_the_product_id()); ?>           
											<input class="wpsc_buy_button icon-img arrow" type='button' value='<?php echo __('Buy Now', 'wpsc'); ?>' onclick='gotoexternallink("<?php echo $action; ?>")'>
										<?php else: ?>
											<input class="wpsc_buy_button icon-img arrow" type="submit" value="<?php echo __('Add To Cart', 'wpsc'); ?>" name="Buy" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/> 
										<?php endif; ?>
									</div>
									
									<br />
									
									<div class='wpsc_loading_animation'>
										<img title="Loading" alt="Loading" src="<?php echo WPSC_URL ;?>/images/indicator.gif" class="loadingimage" />
										<?php echo __('Updating cart...', 'wpsc'); ?>
									</div>
								</div>
								
							<?php else : ?>
								<p class='soldout'><?php echo __('This product has sold out.', 'wpsc'); ?></p>
							<?php endif ; ?>
							
						<?php endif ; ?>
					</div>
					</form>
					
					<?php if(get_option('addtocart_or_buynow')=='1') : ?>
						<?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
					<?php endif ; ?>
						
						
					<?php
						if(function_exists('gold_shpcrt_display_gallery')) :					
							echo gold_shpcrt_display_gallery(wpsc_the_product_id());
						endif;

						echo wpsc_also_bought(wpsc_the_product_id());
					?>
					</div>
		
					<form onsubmit="submitform(this);return false;" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_extra_<?php echo wpsc_the_product_id(); ?>">
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="prodid"/>
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="item"/>
					</form>
				</div>
			</div>
		</div>
		
		<?php echo wpsc_product_comments(); ?>
<?php endwhile; ?>
<?php /** end the product loop here */?>

		<?php 
			if( get_option( 'bl_store_show_special_items' ) ) 
				echo do_shortcode('[special_products title="' . get_option( 'bl_store_title_special_items' ) . '"]' . get_option( 'bl_store_description_special_items' ) . '[/special_products]'); 
		?>

		<?php
		if(function_exists('fancy_notifications')) {
			echo fancy_notifications();
		}
		?>
	

</div>