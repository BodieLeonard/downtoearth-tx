    <!-- START FOOTER -->
	<div id="footer">
	
		<div class="inner">                 
			
			<?php do_action( 'yiw_before_render_footer' ) ?>
			<?php do_action( 'yiw_before_render_footer_' . get_current_pagename() ) ?> 
		
			<?php for( $i = 1; $i <= get_option( 'bl_footer_rows', 2 ); $i++ ) : ?>
				
				<?php dynamic_sidebar( "Footer Row $i" ) ?>
			
				<?php clear() ?>
			
			<?php endfor ?>                   
			
			<?php do_action( 'yiw_after_render_footer' ) ?>
			<?php do_action( 'yiw_after_render_footer_' . get_current_pagename() ) ?> 
			
			<?php clear('space') ?>       
		
		</div>
	
	</div>
	<!-- END FOOTER -->   
	
	<?php get_template_part( 'footer', 'small' ) ?>