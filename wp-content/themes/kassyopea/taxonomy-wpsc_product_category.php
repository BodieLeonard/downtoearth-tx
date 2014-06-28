<?php 

get_header() ?>            
            
        </div>                   
        
		<?php clear('border-header') ?>
                           
    </div>
    <!-- END HEADER -->             
		
	<?php global $shortname;
	
	$layout = get_post_meta( get_current_ID(), '_layout_page', true );
	
	if ( empty( $layout ) ) 
		$layout = get_option( $shortname . '_default_layout_page', 'sidebar-left' );
        
    if ( get_post_type() == 'wpsc-product' ) $layout = 'sidebar-left'; ?>  
	
	<!-- START CONTENT -->
    <div id="content">
    
        <div class="inner layout-<?php echo $layout ?> post-<?php echo get_current_ID() ?> group">   
        
            <?php clear('space'); ?>
            
            <!-- START HENTRY -->                     
            <div class="hentry">      
            	<?php get_template_part('loop', 'page') ?> 
        
            	<?php comments_template(); ?>  
            </div>               
            <!-- END HENTRY -->    
            
            <?php if( $layout != 'sidebar-no' ) get_sidebar() ?>  
            
    		<?php clear('space') ?>	      
            
        </div>               
    
    </div>
    <!-- END CONTENT --> 
        
<?php get_footer(); ?>
