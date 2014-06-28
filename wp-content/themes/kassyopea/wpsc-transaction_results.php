<?php
	/**
	 * The Transaction Results Theme.
	 *
	 * Displays everything within transaction results.  Hopefully much more useable than the previous implementation.
	 *
	 * @package WPSC
	 * @since WPSC 3.8
	 */

	global $purchase_log, $errorcode, $sessionid, $echo_to_screen, $cart, $message_html;
?>
<div class="inner layout-<?php echo $layout ?>">
            
	<!-- START HENTRY -->
	<div class="hentry">
		<div class="wrap">
		
		<?php
			echo wpsc_transaction_theme();
			if ( ( true === $echo_to_screen ) && ( $cart != null ) && ( $errorcode == 0 ) && ( $sessionid != null ) ) {			
				
				// Code to check whether transaction is processed, true if accepted false if pending or incomplete
				
				
				echo "<br />" . wpautop(str_replace("$",'\$',$message_html));						
			}elseif ( true === $echo_to_screen && ( !isset($purchase_log) ) ) {
					_e('Oops, there is nothing in your cart.', TEXTDOMAIN) . "<a href=".get_option("product_list_url").">" . __('Please visit our shop', TEXTDOMAIN) . "</a>";
			}
		?>	
			
		</div>
	</div>
	<?php clear('space') ?>
</div>