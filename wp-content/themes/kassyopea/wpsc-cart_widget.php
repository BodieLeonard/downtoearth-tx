<?php
 //echo "<pre>".print_r($GLOBALS['wpsc_cart']->cart_items[0], true)."</pre>";
?>                                
<div class="cartcount"><?php printf( _n('%d item', '%d items', wpsc_cart_item_count(), TEXTDOMAIN), wpsc_cart_item_count() ); ?></div>
<div id="small-cart" class="access-info-box shopping-cart-wrapper widget_wp_shopping_cart">
	<div id="small-cart-header">
		<div class="cart-message">
		<?php if( isset( $cart_messages ) AND count($cart_messages) > 0 ): ?>
			
			<?php foreach((array)$cart_messages as $cart_message) { ?>
			  <p><?php echo $cart_message; ?></p>
			<?php } ?>  
			
		<?php else: ?>
			
			<p style="font-weight:bold;"><?php _e('Shopping Cart', TEXTDOMAIN); ?></p>  
		
		<?php endif; ?>   
		</div>
	</div>
	<?php if(wpsc_cart_item_count() > 0): ?>
	<div class="shippingcart">
		<table>
			<thead>
				<tr>
					<th scope="col" id='product'><?php _e('Product', TEXTDOMAIN); ?></th>
					<th scope="col" id='quantity' class="text-right"><?php _e('Quantity', TEXTDOMAIN); ?></th>
					<th scope="col" id='price' class="text-right"><?php _e('Price', TEXTDOMAIN); ?></th>
				</tr>
			</thead>
			
			<tfoot>
				<tr class="topmargin">
					<td colspan="2" class="label"><?php _e('Total', TEXTDOMAIN); ?>:</td>
					<td class="text-right bold"><?php echo wpsc_cart_total_widget(); ?></td>
				</tr>	
				                                        
				<?php if(wpsc_cart_has_shipping() && !wpsc_cart_show_plus_postage()) : ?>  
					<tr> 
						<td colspan="2" class="label"><?php _e('Shipping', TEXTDOMAIN); ?>:</td> 
						<td class="text-right bold"><?php echo wpsc_cart_shipping(); ?></td> 
					</tr>                    
				<?php endif; ?>               
				                                                              
				<?php if( (wpsc_cart_tax(false) > 0) && wpsc_cart_show_plus_postage()) : ?>  
					<tr>		
						<td colspan="2" class="label"><?php _e('Postage &amp; Tax', TEXTDOMAIN); ?>:</td> 
						<td class="text-right bold"><?php echo wpsc_cart_tax(); ?></td> 
					</tr>    
				<?php endif; ?>
			</tfoot>
			
			<?php while(wpsc_have_cart_items()): wpsc_the_cart_item(); ?>
			<tbody>
				<tr>
					<td><?php echo wpsc_cart_item_name(); ?></td>
					<td class="text-right"><?php echo wpsc_cart_item_quantity(); ?></td>
					<td class="text-right"><?php echo wpsc_cart_item_price(); ?></td>
				</tr>	
			</tbody>
			<?php endwhile; ?>
		</table>
	</div>
		
	<div class="small-cart-links">
		<a class="checkout-link" href='<?php echo get_option('shopping_cart_url'); ?>'><?php echo __('Checkout', TEXTDOMAIN); ?></a>
		<form action='' method='post' class='wpsc_empty_the_cart'>
			<input type='hidden' name='wpsc_ajax_action' value='empty_cart' />
			<a class='emptycart' href='<?php echo htmlentities(add_query_arg('wpsc_ajax_action', 'empty_cart', remove_query_arg('ajax')), ENT_QUOTES); ?>'><?php echo __('Empty Your Cart', TEXTDOMAIN); ?></a>
		</form>
		
		<?php clear() ?>
	</div>
		
	<?php else: ?>                                                                      
	<p class="empty"><?php echo __('Your shopping cart is empty', TEXTDOMAIN); ?></p>
	<div class="small-cart-links">
	  	<a class="visitshop" href="<?php echo get_option('product_list_url'); ?>"><?php echo __('Visit the shop', TEXTDOMAIN); ?></a>    
	
		<?php clear() ?>
	</div>
	<?php endif; ?>        

<?php
//wpsc_google_checkout();
?>
</div>