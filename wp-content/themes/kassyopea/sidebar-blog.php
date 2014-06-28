			<div class="sidebar">
			
				<?php do_action( 'yiw_before_sidebar' ) ?> 
				<?php do_action( 'yiw_before_sidebar_' . get_current_pagename() ) ?> 
				
                <?php dynamic_sidebar( 'Blog Sidebar' ) ?>                          
		
				<?php do_action( 'yiw_after_sidebar' ) ?>       
				<?php do_action( 'yiw_after_sidebar_' . get_current_pagename() ) ?> 
				
            </div>        