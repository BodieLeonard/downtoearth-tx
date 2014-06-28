<?php 
if( is_front_page() || is_home() ) {
	add_filter( 'body_class', create_function( '$classes = \'\'', '$classes[] = \'wpsc\'; return $classes;' ) );
	get_template_part( 'home', 'store' ); 
	die;
}

global $yiw_layout;
$yiw_layout = get_layout_page();

get_header() ?>            
            
        </div>                   
        
		<?php clear('border-header') ?>
                           
    </div>
    <!-- END HEADER -->     
	
	<!-- START CONTENT -->
    <div id="content">
    
        <div class="inner layout-<?php echo $yiw_layout ?> post-<?php echo get_current_ID() ?> group">                
        
        	<?php get_template_part( 'title', 'slogan' ) ?>     
			
			<?php get_template_part( 'accordion-slider' ) ?>  
		
			<?php do_action( 'yiw_before_hentry' ) ?>   
			<?php do_action( 'yiw_before_hentry_' . get_current_pagename() ) ?>  
            
            <!-- START HENTRY -->                     
            <div class="hentry">      
            	<?php get_template_part('loop', 'page') ?> 
        
            	<?php comments_template(); ?>  
            </div>               
            <!-- END HENTRY -->    
            
            <?php if( $yiw_layout != 'sidebar-no' ) get_sidebar() ?>  
            
    		<?php clear() ?><div class="clear"></div>	      
			        
        	<?php get_template_part( 'extra-content' ) ?>
            
        </div>               
    
    </div>
    <!-- END CONTENT --> 
        
<?php get_footer(); ?>
