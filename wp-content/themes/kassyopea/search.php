<?php 
/**
 * @package WordPress
 * @subpackage Kassyopea
 * @since Kassyopea 1.0
 */
 
get_header() ?>                
            
        </div>                   
        
		<?php clear('border-header') ?>
                           
    </div>
    <!-- END HEADER -->   
	
	<!-- START CONTENT -->
    <div id="content">
    
        <div class="inner">                   
        
        	<?php global $post; $slogan = get_post_meta( $post->ID, '_slogan_page', true ) ?>
                    
            <?php if( $slogan != '' ) : ?><h2 class="title-page"><?php convertTags( $slogan ) ?></h2><?php else : clear('space'); endif; ?>    
			
			<?php get_template_part('accordion-slider') ?>
            
            <!-- START HENTRY -->                     
            <div class="hentry">      
            	<?php get_template_part('loop', 'index') ?> 
            </div>               
            <!-- END HENTRY -->    
            
			<!-- START SIDEBAR -->
			<?php get_sidebar( 'blog' ) ?>       
            <!-- END SIDEBAR -->
            
    		<?php clear() ?>	
            
        </div>               
            
    	<?php clear('space') ?>
    
    </div>
    <!-- END CONTENT --> 
        
<?php get_footer() ?>
