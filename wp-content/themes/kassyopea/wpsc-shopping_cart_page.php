<?php
global $wpsc_cart, $wpdb, $wpsc_checkout, $wpsc_gateway, $wpsc_coupons;
$wpsc_checkout = new wpsc_checkout();
$wpsc_gateway = new wpsc_gateways();
$wpsc_coupons = ( isset( $_SESSION['coupon_numbers'] ) ) ? new wpsc_coupons( $_SESSION['coupon_numbers'] ) : null;
 //echo "<pre>".print_r($wpsc_cart, true)."</pre>";
// //echo "<pre>".print_r($wpsc_checkout, true)."</pre>";    
$alt = 0;         
        
global $post; $slogan = get_post_meta( $post->ID, '_slogan_page', true );

if( $slogan != '' ) : ?>
	<h2 class="title-page"><?php convertTags( $slogan ) ?></h2>
<?php 
endif; 
            
if(wpsc_cart_item_count() > 0) :
?> 

		<div id="shipping_cart">                      
			<div class="step" id="order-step">                        
				<h3 class="red-normal title-post-page"><?php _e('Checkout', TEXTDOMAIN); ?></h3>
				<p><?php _e('Please review your order', TEXTDOMAIN); ?></p>
				<table class="productcart checkout_cart">
					<thead>
						<tr class="header firstrow">
							<th class="imagepreview">&nbsp;</th>
							<th class="titleproduct" scope="col"><?php _e('Product', TEXTDOMAIN); ?></th>
							<th class="qty" scope="col"><?php _e('Quantity', TEXTDOMAIN); ?></th>
							<th class="price-product" scope="col"><?php _e('Price', TEXTDOMAIN); ?></th>  
							<th class="removebutton">&nbsp;</th>
						</tr>
					</thead>
					                                                       
					<tbody>	
					<?php while (wpsc_have_cart_items()) : wpsc_the_cart_item(); ?> 
                      <?php
                       $alt++;
                       if ($alt % 2 == 1)
                         $alt_class = 'alt';
                       else
                         $alt_class = '';
                       ?>
					<?php  //this displays the confirm your order html	?>
						<tr class="product_row product_row_<?php echo wpsc_the_cart_item_key(); ?> <?php echo $alt_class;?>">
							<td class="firstcol imagepreview wpsc_product_image wpsc_product_image_<?php echo wpsc_the_cart_item_key(); ?>">
								<img src='<?php echo wpsc_cart_item_image(65,65); ?>' alt='<?php echo wpsc_cart_item_name(); ?>' title='<?php echo wpsc_cart_item_name(); ?>' />
							</td>
							<td class="wpsc_product_name titleproduct wpsc_product_name_<?php echo wpsc_the_cart_item_key(); ?>">
							<a href='<?php echo wpsc_cart_item_url();?>'><?php echo wpsc_cart_item_name(); ?></a>
							</td>
							<td class="wpsc_product_quantity qty wpsc_product_quantity_<?php echo wpsc_the_cart_item_key(); ?>">
								<form action="<?php echo get_option('shopping_cart_url'); ?>" method="post" class="adjustform qty">
									<input type="text" name="quantity" size="2" value="<?php echo wpsc_cart_item_quantity(); ?>" /><br/>
									<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
									<input type="hidden" name="wpsc_update_quantity" value="true" />
									<input type="submit" value="<?php _e('Update', TEXTDOMAIN); ?>" name="submit" class="update-qty-button" />
								</form>
							</td>
							<td class="wpsc_product_price price-product wpsc_product_price_<?php echo wpsc_the_cart_item_key(); ?>"><span class="pricedisplay"><?php echo wpsc_cart_item_price(); ?></span></td>
							
							<td class="wpsc_product_remove removebutton wpsc_product_remove_<?php echo wpsc_the_cart_item_key(); ?>">
								<form action="<?php echo get_option('shopping_cart_url'); ?>" method="post" class="adjustform remove">
									<input type="hidden" name="quantity" value="0" />
									<input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />   
									<input type="hidden" name="wpsc_update_quantity" value="true" />
									
									<div class="more-button bg-button">
										<button class='remove_button icon-img remove' type="submit"><span><?php _e('Remove', TEXTDOMAIN); ?></span></button>
									</div>
								</form>
							</td>
						</tr>              
					<?php endwhile; ?>
					<?php //this HTML displays coupons if there are any active coupons to use ?>                
					</tbody>
					</table>
					
					<table class="productcart">
					<?php if(wpsc_uses_coupons()): ?>
						
						<?php if(wpsc_coupons_error()): ?>
							<tr><td><?php _e('Coupon is not valid.', TEXTDOMAIN); ?></td></tr>
						<?php endif; ?>
						<tr>
							<td colspan="2"><?php _e('Enter coupon code', TEXTDOMAIN); ?> :</td>
							<td  colspan="3" align='left'>
								<form  method="post" action="<?php echo get_option('shopping_cart_url'); ?>">
                                   <input type="text" name="coupon_num" id="coupon_num" value="<?php echo $wpsc_cart->coupons_name; ?>" />
                                   <input type="submit" value="<?php _e('Update', 'wpsc') ?>" />
                                </form>
							</td>
						</tr>
					<?php endif; ?>	
					</table>
					<?php  //this HTML dispalys the calculate your order HTML	?>

                   <?php if(wpsc_has_category_and_country_conflict()): ?>
                      <p class='validation-error'><?php echo $_SESSION['categoryAndShippingCountryConflict']; ?></p>
                      <?php unset($_SESSION['categoryAndShippingCountryConflict']);
                   endif;
                
                   if(isset($_SESSION['WpscGatewayErrorMessage']) && $_SESSION['WpscGatewayErrorMessage'] != '') :?>
                      <p class="validation-error"><?php echo $_SESSION['WpscGatewayErrorMessage']; ?></p>
                   <?php
                   endif;
                   ?>
					<?php do_action('wpsc_before_shipping_of_shopping_cart'); ?>
					
					<div id='wpsc_shopping_cart_container'>
					<?php if(wpsc_uses_shipping()): ?>
						<h3 class="red-normal"><?php _e( 'Calculate Shipping Price', TEXTDOMAIN ) ?></h3>
						<p><?php _e( 'Choose a country below to calculate your shipping price', TEXTDOMAIN ) ?></p>     
				
						<?php if (!wpsc_have_shipping_quote()) : // No valid shipping quotes ?>
							<?php if (($_SESSION['wpsc_zipcode'] == '') || ($_SESSION['wpsc_zipcode'] == 'Your Zipcode')) : // No valid shipping quotes ?>
								<?php if ($_SESSION['wpsc_update_location'] == true) :?>
									<p class="validation-error"><?php _e('Please provide a Zipcode and click Calculate in order to continue.', TEXTDOMAIN); ?></p>
								<?php endif; ?>
							<?php else: ?>
								<p class="validation-error"><?php _e('Sorry, online ordering is unavailable to this destination and/or weight. Please double check your destination details.', TEXTDOMAIN); ?></p>
							<?php endif; ?>
						<?php endif; ?>
						
							<form name='change_country' id='change_country' action='' method='post'>
								<?php echo wpsc_shipping_country_list();?>
								<input type='hidden' name='wpsc_update_location' value='true' />
								
								<br/>
						
								<?php if (wpsc_have_morethanone_shipping_quote()) :?>
									<?php while (wpsc_have_shipping_methods()) : wpsc_the_shipping_method(); ?>
											<?php 	if (!wpsc_have_shipping_quotes()) { continue; } // Don't display shipping method if it doesn't have at least one quote ?>
											<p><?php echo wpsc_shipping_method_name().__('- Choose a Shipping Rate', TEXTDOMAIN); ?></p>
											
											<?php while (wpsc_have_shipping_quotes()) : wpsc_the_shipping_quote();	?>
												<label for='<?php echo wpsc_shipping_quote_html_id(); ?>'><?php echo wpsc_shipping_quote_name(); ?></label>
												<label for='<?php echo wpsc_shipping_quote_html_id(); ?>'><?php echo wpsc_shipping_quote_value(); ?></label>
												
												<?php if(wpsc_have_morethanone_shipping_methods_and_quotes()): ?>
													<input type='radio' id='<?php echo wpsc_shipping_quote_html_id(); ?>' <?php echo wpsc_shipping_quote_selected_state(); ?>  onclick='switchmethod("<?php echo wpsc_shipping_quote_name(); ?>", "<?php echo wpsc_shipping_method_internal_name(); ?>")' value='<?php echo wpsc_shipping_quote_value(true); ?>' name='shipping_method' />
												<?php else: ?>
													<input <?php echo wpsc_shipping_quote_selected_state(); ?> disabled='disabled' type='radio' id='<?php echo wpsc_shipping_quote_html_id(); ?>'  value='<?php echo wpsc_shipping_quote_value(true); ?>' name='shipping_method' />
														<?php wpsc_update_shipping_single_method(); ?>
												<?php endif; ?>
											<?php endwhile; ?>
									<?php endwhile; ?>
								<?php endif; ?>                      
								
								<br/>
								
								<div class="more-button bg-button">
									<input type='submit' name='wpsc_submit_zipcode' value='Calculate' class="icon-img calc" />
								</div>  
							</form>
							
							<?php wpsc_update_shipping_multiple_methods(); ?>
					<?php endif;  ?>
					</div>     
					
					<table class="totals-price productcart">      
								
						<tfoot>	
							<tr class='total_price'>
								<td class="price-labels">
								<?php _e('Total Price', TEXTDOMAIN); ?>
								</td>
								<td class="price-values">
									<span id='checkout_total' class="pricedisplay checkout-total"><?php echo wpsc_cart_total(); ?></span>
								</td>
							</tr>
						</tfoot>
						
						<tbody>   
                               <?php
                                  $wpec_taxes_controller = new wpec_taxes_controller();
                                  if($wpec_taxes_controller->wpec_taxes_isenabled()):
                               ?>
								<tr class="total_price total_tax">
									<td class="price-labels">
										<?php echo wpsc_display_tax_label(true); ?>
									</td>
									
									<td class="price-values">
										<span id="checkout_tax" class="pricedisplay checkout-tax"><?php echo wpsc_cart_tax(); ?></span>
									</td>
								</tr>
							<?php endif; ?>
							
							<?php if(wpsc_uses_shipping()) : ?>
								<tr class="total_price total_shipping">
									<td class="price-labels">
										<?php _e('Total Shipping', TEXTDOMAIN); ?>
									</td>
									<td class="price-values">
										<span id="checkout_shipping" class="pricedisplay checkout-shipping"><?php echo wpsc_cart_shipping(); ?></span>
									</td>
								</tr>
							<?php endif; ?>
						
							  <?php if(wpsc_uses_coupons() && (wpsc_coupon_amount(false) > 0)): ?>
							<tr class="total_price">
								<td class="price-labels">
									<?php _e('Discount', TEXTDOMAIN); ?>
								</td>
								<td class="price-values">
									<span id="coupons_amount" class="pricedisplay"><?php echo wpsc_coupon_amount(); ?></span>
							    </td>
						   	</tr>
							  <?php endif ?>
						 </tbody>
					
					</table>      
							
					<div class="more-button next-step">
						<a href="#" id="checkout-next-step"><?php _e('Go to next step', TEXTDOMAIN); ?><div class="icon arrow"></div></a>
					</div>                              
				
					<div class="clear"></div> 
				</div><!-- end STEP -->                                       
			
					<?php do_action('wpsc_before_form_of_shopping_cart'); ?>
				
				<div class="step" id="signup-step">     
                 
                	<?php if(!empty($_SESSION['wpsc_checkout_user_error_messages'])): ?>
                		<p class="validation-error">
                		<?php
                		foreach($_SESSION['wpsc_checkout_user_error_messages'] as $user_error )
                		echo $user_error."<br />\n";
                		
                		$_SESSION['wpsc_checkout_user_error_messages'] = array();
                		?>
                	<?php endif; ?>

                	<?php if ( wpsc_show_user_login_form() && !is_user_logged_in() ): ?>
                			<p><?php _e('You must sign in or register with us to continue with your purchase', 'wpsc');?></p>
                			<div class="wpsc_registration_form">
                				
                				<fieldset class='wpsc_registration_form'>
                					<h2><?php _e( 'Sign in', 'wpsc' ); ?></h2>
                					
                					<?php
                					$args = array( 'remember' => false );
                					wp_login_form( $args );
                					?>
                					<div class="wpsc_signup_text"><?php _e('If you have bought from us before please sign in here to purchase', 'wpsc');?></div>
                				</fieldset>
                			</div>
                	<?php endif; ?>	
					<form name='wpsc_checkout_forms' class='wpsc_checkout_forms' action='#signup-step' method='post' enctype="multipart/form-data">
					
					   <?php 
					   /**  
					    * Both the registration forms and the checkout details forms must be in the same form element as they are submitted together, you cannot have two form elements submit together without the use of JavaScript.
					   */
					   ?>
				
					 <?php if(!is_user_logged_in() && get_option('users_can_register') && get_option('require_register')) :
							 global $current_user;
				    		 get_currentuserinfo();	  ?>
						<h3 class="red-normal"><?php _e('Not yet a member?', TEXTDOMAIN);?></h3>
						<p><?php _e("In order to buy from us, you'll need an account. Joining is free and easy. All you need is a username, password and valid email address.", TEXTDOMAIN);?></p>
						<?php	if(count($_SESSION['wpsc_checkout_user_error_messages']) > 0) : ?>
							<div class="login_error"> 
								<?php		  
								foreach($_SESSION['wpsc_checkout_user_error_messages'] as $user_error ) {
								  echo $user_error."<br />\n";
								}
								$_SESSION['wpsc_checkout_user_error_messages'] = array();
								?>			
						  </div>
						<?php endif; ?>
						
						
					  <fieldset class='wpsc_registration_form'>
							<label><?php _e('Username', TEXTDOMAIN); ?>:</label><input type="text" name="log" id="log" value="" size="20"/>
                            <label><?php _e('Password', TEXTDOMAIN); ?>:</label><input type="password" name="pwd" id="pwd" value="" size="20" />
                            <label><?php _e('E-mail', TEXTDOMAIN); ?>:</label><input type="text" name="user_email" id="user_email" value="<?php echo attribute_escape(stripslashes($user_email)); ?>" size="20" />
						</fieldset>
					<?php endif; ?>
				
					<h3 class="red-normal"><?php _e('Please enter your contact details:', TEXTDOMAIN); ?></h3>
					<?php /* _e('Note, Once you press submit, you will need to have your Credit card handy.', TEXTDOMAIN); <br /> */ ?>
					<p><?php _e('Fields marked with an asterisk must be filled in.', TEXTDOMAIN); ?></p>
					<?php
					  if(count($_SESSION['wpsc_checkout_misc_error_messages']) > 0) {
							echo "<div class='login_error'>\n\r";
							foreach((array)$_SESSION['wpsc_checkout_misc_error_messages'] as $user_error ) {
								echo $user_error."<br />\n";
							}
							echo "</div>\n\r";
						}
						$_SESSION['wpsc_checkout_misc_error_messages'] =array();
					?>
					<table class='wpsc_checkout_table'>
						<?php while (wpsc_have_checkout_items()) : wpsc_the_checkout_item(); ?>
							<?php if(wpsc_is_shipping_details()) : ?>
									<tr>
										<td colspan ='2'>
											<input type='checkbox' value='true' name='shippingSameBilling' id='shippingSameBilling' />
											<label for='shippingSameBilling'><?php _e('Shipping Address same as Billing Address?', TEXTDOMAIN); ?></label>
										
										</td>
									</tr>
							<?php endif; ?>
				
						  <?php if(wpsc_checkout_form_is_header() == true) : ?>
						  		<tr class="wpsc_shipping_forms <?php echo wpsc_the_checkout_item_error_class(false);?>">
							<td <?php if(wpsc_is_shipping_details()) echo "class='wpsc_shipping_forms'"; ?> colspan='2'>
								<h4 class="red-normal">
									<?php echo wpsc_checkout_form_name();?>
								</h4>
							</td>
								</tr>
						  <?php else: ?>
						  <?php if((!wpsc_uses_shipping()) && $wpsc_checkout->checkout_item->unique_name == 'shippingstate'): ?>
						  <?php else : ?>
						  		<tr <?php echo wpsc_the_checkout_item_error_class();?>>
							<td>
								<label for='<?php echo wpsc_checkout_form_element_id(); ?>'>
								<?php echo wpsc_checkout_form_name();?>
								</label>
							</td>
							<td>
								<?php echo wpsc_checkout_form_field();?>
								
						    <?php if(wpsc_the_checkout_item_error() != ''): ?>
						    <p class='validation-error'><?php echo wpsc_the_checkout_item_error(); ?></p>
						    
							<?php endif; ?>
							</td>
							</tr>
							<?php endif; ?>
						
							<?php endif; ?>
						
						<?php endwhile; ?>

					      <?php if (wpsc_show_find_us()) : ?>
					      <tr>
					         <td><label for='how_find_us'><?php _e('How did you find us' , TEXTDOMAIN); ?></label></td>
					         <td>
					            <select name='how_find_us'>
					               <option value='Word of Mouth'><?php _e('Word of mouth' , TEXTDOMAIN); ?></option>
					               <option value='Advertisement'><?php _e('Advertising' , TEXTDOMAIN); ?></option>
					               <option value='Internet'><?php _e('Internet' , TEXTDOMAIN); ?></option>
					               <option value='Customer'><?php _e('Existing Customer' , TEXTDOMAIN); ?></option>
					            </select>
					         </td>
					      </tr>
					      <?php endif; ?>
						<?php do_action('wpsc_inside_shopping_cart'); ?>	
						<tr>
							<td colspan='2' class='wpsc_gateway_container'>
							
							<?php  //this HTML displays activated payment gateways?>
							  
								<?php if(wpsc_gateway_count() > 1): // if we have more than one gateway enabled, offer the user a choice ?>
									<h3 class="red-normal"><?php _e('Select a payment gateway', TEXTDOMAIN);?></h3>
									<?php while (wpsc_have_gateways()) : wpsc_the_gateway(); ?>
										<div class="custom_gateway">
											<?php if(wpsc_gateway_internal_name() == 'noca'){ ?>
												<label><input type="radio" id='noca_gateway' value="<?php echo wpsc_gateway_internal_name();?>" <?php echo wpsc_gateway_is_checked(); ?> name="custom_gateway" class="custom_gateway"/><?php echo wpsc_gateway_name();?></label>
											<?php }else{ ?>
												<label><input type="radio" value="<?php echo wpsc_gateway_internal_name();?>" <?php echo wpsc_gateway_is_checked(); ?> name="custom_gateway" class="custom_gateway"/><?php echo wpsc_gateway_name();?></label>
											<?php } ?>
				
											
											<?php if(wpsc_gateway_form_fields()): ?> 
												<table class='<?php echo wpsc_gateway_form_field_style();?>'>
													<?php echo wpsc_gateway_form_fields();?> 
												</table>		
											<?php endif; ?>			
										</div>
									<?php endwhile; ?>
								<?php else: // otherwise, there is no choice, stick in a hidden form ?>
									<?php while (wpsc_have_gateways()) : wpsc_the_gateway(); ?>
										<input name='custom_gateway' value='<?php echo wpsc_gateway_internal_name();?>' type='hidden' />
										
											<?php if(wpsc_gateway_form_fields()): ?> 
												<table>
													<?php echo wpsc_gateway_form_fields();?> 
												</table>		
											<?php endif; ?>	
									<?php endwhile; ?>				
								<?php endif; ?>				
								
							</td>
						</tr>

					      <?php if(wpsc_has_tnc()) : ?>
					         <tr>
					            <td colspan='2'>
					                <label for="agree"><input id="agree" type='checkbox' value='yes' name='agree' /> <?php printf(__("I agree to The <a class='thickbox' target='_blank' href='%s' class='termsandconds'>Terms and Conditions</a>", "wpsc"), site_url("?termsandconds=true&amp;width=360&amp;height=400'")); ?></label>
					               </td>
					         </tr>
					      <?php endif; ?>
					</table>    
					
					<div class="next-step">        
						<?php if(!wpsc_has_tnc()) : ?>
							<input type='hidden' value='yes' name='agree' />
						<?php endif; ?>	
						
						<?php //exit('<pre>'.print_r($wpsc_gateway->wpsc_gateways[0]['name'], true).'</pre>');
						 if(count($wpsc_gateway->wpsc_gateways) == 1 && $wpsc_gateway->wpsc_gateways[0]['name'] == 'Noca')
						 { ?>
						 	<strong><?php _e('Please login or signup above to make your purchase', TEXTDOMAIN);?></strong><br />
							<?php _e('If you have just registered, please check your email and login before you make your purchase', TEXTDOMAIN);?>
						 <?php }
						 else
						 {
						 ?>                                                                      
						<input type='hidden' value='submit_checkout' name='wpsc_action' />
						<div class="more-button bg-button">
							<input type='submit' value='<?php _e('Purchase', TEXTDOMAIN);?>' name='submit' class='make_purchase icon-img arrow' /> 
						</div>
						<?php } ?>
					</div>           
			
					<div class="more-button more-button-rtl prev-step">
						<a href="#" id="checkout-back-step"><?php _e('Back', TEXTDOMAIN) ?></a>
						<div class="icon arrow-left"></div>
					</div>  
				</form>         
				</div><!-- end. STEP -->  
				
				<div class="clear"></div> 
			</div>
		<?php
		else: ?>
			<p><?php _e('Oops, there is nothing in your cart.', TEXTDOMAIN) ?> <a href="<?php echo get_option("product_list_url") ?>"><?php _e('Please visit our shop', TEXTDOMAIN) ?></a></p>
		<?php endif;
		do_action('wpsc_bottom_of_shopping_cart');
		?>
	
	<?php clear('space') ?>