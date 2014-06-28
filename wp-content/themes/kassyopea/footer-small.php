    <!-- START COPYRIGHT -->
	<div id="copyright">
		
		<div class="inner">                                  
			
			<?php do_action( 'yiw_before_render_footer' ) ?>
			<?php do_action( 'yiw_before_render_footer_' . get_current_pagename() ) ?> 
			
			<?php string_( '<p class="left two-fourth">', do_shortcode( stripslashes_deep( get_option( 'bl_copyright_text_left' ) ) ), '</p>' ) ?>
			
			<?php string_( '<p class="right two-fourth last">', do_shortcode( stripslashes_deep( get_option( 'bl_copyright_text_right' ) ) ), '</p>' ) ?>
			
			<?php clear() ?>                              
			
			<?php do_action( 'yiw_after_render_footer' ) ?>
			<?php do_action( 'yiw_after_render_footer_' . get_current_pagename() ) ?> 
			
		</div>
		
	</div>
	<!-- END COPYRIGHT -->  