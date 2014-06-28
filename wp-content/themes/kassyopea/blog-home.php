<?php      
/**
 * @package WordPress
 * @subpackage Kassyopea
 * @since Kassyopea 1.0
 */

$slider_show = get_option( 'bl_slider_show' );
$section_show = get_option( 'bl_grey_section_show' );
$testimonial_show = get_option( 'bl_testimonial_slider_show' );
?>

<?php get_header() ?> 

			<!-- START SLIDER -->
            <?php if( $slider_show ) get_template_part( 'slider', get_option( 'bl_slider_type', 'home' ) ) ?>       
            <!-- END SLIDER -->             
		
			<?php do_action( 'yiw_after_render_slider' ) ?>    
            
        </div>           
                                                         
		<?php if( !$slider_show AND !$section_show OR $testimonial_show ) clear('border-header') ?>
                           
    </div>
    <!-- END HEADER -->                     
            
    <?php clear() ?>
            
    <?php if( $section_show ) get_template_part( 'home', 'greysection' ) ?>
                                  
    <?php if( $testimonial_show ) get_template_part( 'home', 'testimonialslider' ) ?>          
		
	<?php $layout = get_layout_page(); ?>    
    
    <!-- START CONTENT -->
    <div id="content" class="group">
    
        <div class="inner layout-<?php echo $layout ?> post-<?php echo get_current_ID() ?> group">                           
        
        	<?php get_template_part( 'title', 'slogan' ) ?>     
			
			<?php get_template_part( 'accordion-slider' ) ?>   
		
			<?php do_action( 'yiw_before_hentry' ) ?>   
			<?php do_action( 'yiw_before_hentry_' . get_current_pagename() ) ?>  
            
            <!-- START HENTRY -->                     
            <div class="hentry">           
            	<?php global $paged ?>
                <?php query_posts('cat=' . exclude_categories( get_option('bl_blog_cats_exclude_1') ) . '&posts_per_page=' . get_option( 'bl_blog_items' ) . '&paged=' . $paged); ?>
            	
				<?php get_template_part('loop', 'index') ?> 
            </div>               
            <!-- END HENTRY -->   
            
			<!-- START SIDEBAR -->
			<?php get_sidebar( 'blog' ) ?>       
            <!-- END SIDEBAR -->       
            
    		<?php clear() ?>	      
			                                             
            <!-- START EXTRA CONTENT -->
        	<?php get_template_part( 'extra-content' ) ?> 
            <!-- END EXTRA CONTENT -->              
            
    		<?php clear() ?>	
            
        </div>               
            
    	<?php clear('space') ?>
    
    </div>
    <!-- END CONTENT -->    
    
<?php get_footer() ?>
