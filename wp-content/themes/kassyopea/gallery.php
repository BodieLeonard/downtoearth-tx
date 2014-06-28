<?php
 
/**
 * @package WordPress
 * @subpackage Kassyopea
 * @since Kassyopea 1.0
 */
 
/*
Template Name: Gallery
*/
?>

<?php get_header() ?>             
            
        </div>                   
        
		<?php clear('border-header') ?>
                           
    </div>
    <!-- END HEADER -->             
		
	<?php $layout = get_layout_page(); ?>   
	
	<!-- START CONTENT -->
    <div id="content">
    
        <div class="inner layout-<?php echo $layout ?>">                
        
        	<?php get_template_part( 'title', 'slogan' ) ?>     
			
			<?php get_template_part( 'accordion-slider' ) ?>
            
            <!-- START HENTRY -->                     
            <div class="hentry">                        
            	<?php get_template_part('loop', 'page') ?>
            	
            	<?php if( get_option( 'bl_panel_galleryshow' ) ) get_template_part( 'loop', 'gallery' ) ?>               
        
            	<?php comments_template(); ?>  
            </div>               
            <!-- END HENTRY -->    
            
            <?php if( $layout != 'sidebar-no' ) get_sidebar() ?>  
            
    		<?php clear() ?>	      
			        
        	<?php get_template_part( 'extra-content' ) ?>    
            
        </div>               
    
    </div>
    <!-- END CONTENT --> 
        
<?php get_footer() ?>
