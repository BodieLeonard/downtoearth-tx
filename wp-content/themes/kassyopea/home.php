<?php      
/**
 * @package WordPress
 * @subpackage Kassyopea
 * @since Kassyopea 1.0
 */
 
/*
Template Name: Home
*/                    

if( ( is_home() || is_front_page() ) && get_option( 'show_on_front' ) == 'posts' ) {
    get_template_part( 'blog', 'home' ); 
    die;
}                          

if ( get_option( 'show_on_front' ) == 'page' && get_option( 'page_for_posts' ) != 0 ) {
    get_template_part( 'blog' ); 
    die;
}

$slider_show = get_option( 'bl_slider_show' );
$section_show = get_option( 'bl_grey_section_show' );
$testimonial_show = get_option( 'bl_testimonial_slider_show' );        

global $yiw_layout;
$yiw_layout = get_layout_page();
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
    
    <!-- START CONTENT -->
    <div id="content" class="group">
    
        <div class="inner layout-<?php echo $yiw_layout ?> post-<?php echo get_current_ID() ?> group">                           
        
        	<?php get_template_part( 'title', 'slogan' ) ?>     
			
			<?php get_template_part( 'accordion-slider' ) ?>   
		
			<?php do_action( 'yiw_before_hentry' ) ?>   
			<?php do_action( 'yiw_before_hentry_' . get_current_pagename() ) ?>  
            
            <!-- START HENTRY -->
            <div class="hentry">
                <?php 
                	if ( is_front_page() )
						get_template_part( 'loop', 'page' ); 
					elseif ( is_home() )
						get_template_part( 'loop', 'index' ); 
				?> 
            </div>               
            <!-- END HENTRY -->                        
            
            <!-- START SIDEBAR -->
            <?php if( $yiw_layout != 'sidebar-no' ) get_sidebar() ?>  
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
