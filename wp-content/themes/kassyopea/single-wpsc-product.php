<?php 
if( is_front_page() ) :
	get_template_part( 'home', 'store' ); 
	
else:

get_header() ?>             
            
        </div>                   
        
		<?php clear('border-header') ?>
                           
    </div>
    <!-- END HEADER -->         
		
	<?php $layout = get_layout_page(); ?>
	
	<!-- START CONTENT -->
    <div id="content" class="group">
	
	   <?php
        	$tmp_query = $wp_query;
        	
        	if ( have_posts() ) : 
        
        	    while ( have_posts() ) : the_post();
        			
        			$wpautop = get_post_meta( get_current_ID(), '_page_remove_wpautop', true );
        			
        			if( $wpautop )
        				remove_filter( 'the_content', 'wpautop' );    
        				
        			the_content();
        		
        			if( $wpautop )
        				add_filter( 'the_content', 'wpautop' ); 
        		
        		endwhile; 
        	
        	endif; 
        	
        	$wp_query = $tmp_query; 
        	
        	$wp_query = new WP_Query();
        	wp_reset_postdata();
        ?>   
            
    	<?php clear() ?>
    
    </div>
    <!-- END CONTENT --> 
        
<?php get_footer(); endif; ?>
