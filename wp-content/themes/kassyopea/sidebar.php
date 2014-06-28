            <?php 
				$sidebar = get_post_meta( get_current_ID(), '_sidebar_choose_page', true ); 
				$sidebar = apply_filters( 'yiw_sidebar', $sidebar );
				
				global $wp_query;
				
				$tmp_query = $wp_query;
			?>                  
			
			<!-- START SIDEBAR -->
            <div class="sidebar sidebar-<?php echo get_post_meta( get_current_ID(), '_sidebar_layout', true ) ?>">     
		
				<?php do_action( 'yiw_before_sidebar' ) ?> 
				<?php do_action( 'yiw_before_sidebar_' . get_current_pagename() ) ?> 
				
                <?php dynamic_sidebar( $sidebar ) ?>      
		
				<?php do_action( 'yiw_after_sidebar' ) ?>       
				<?php do_action( 'yiw_after_sidebar_' . get_current_pagename() ) ?> 
				
            </div>               
            <!-- END SIDEBAR -->      
            
            <?php 
				$wp_query = $tmp_query;
				
				wp_reset_postdata();
			?>