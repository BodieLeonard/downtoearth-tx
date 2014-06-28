	<div id="footer-centered">    
			
		<div class="inner">	                 
			
			<?php do_action( 'yiw_before_render_footer' ) ?>
			<?php do_action( 'yiw_before_render_footer_' . get_current_pagename() ) ?> 
			
			<!-- START NAVIGATION -->
		    <?php 
				$options = array(
		            'theme_location' => 'footer-nav',
		            'containter' => 'none',
		            'menu_id' => 'footer-nav',
		            'depth' => 1
		        );
		        
		        wp_nav_menu( $options )
			?>
		    <!-- END NAVIGATION -->   
		    
		    <?php echo do_shortcode( wpautop( stripslashes_deep( get_option( 'bl_footer_text_centered' ) ) ) ) ?>    
			
			<?php do_action( 'yiw_after_render_footer' ) ?>
			<?php do_action( 'yiw_after_render_footer_' . get_current_pagename() ) ?> 
		
		</div>
		
	</div>