			<?php 
				wp_reset_query();
				
				$post_id = get_current_ID();
				
				$extra_content = do_shortcode( get_post_meta( $post_id, '_page_extra_content', true ) );
				
				if( get_post_meta( $post_id, '_page_extra_content_autop', true ) ) 
					$extra_content = apply_filters( 'the_content', $extra_content );
			
				if( $extra_content != '' ) : ?>
            
				<div class="extra-content"><?php echo $extra_content ?></div>   
				
			<?php endif; 
			
				clear('space'); 
				
			?>                  
		
			<?php do_action( 'yiw_after_extra-content' ) ?> 
			<?php do_action( 'yiw_after_extra-content_' . get_current_pagename() ) ?>  