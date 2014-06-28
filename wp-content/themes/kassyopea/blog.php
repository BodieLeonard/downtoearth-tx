<?php       
/**
 * @package WordPress
 * @subpackage Kassyopea
 * @since Kassyopea 1.0
 */
 
/*
Template Name: Blog
*/

global $shortname;

get_header() ?>             
            
        </div>                   
        
		<?php clear('border-header') ?>
                           
    </div>
    <!-- END HEADER -->                             
		
	<?php $layout = get_layout_page(); ?>   
	
	<!-- START CONTENT -->
    <div id="content">
    
        <div class="inner layout-<?php echo $layout ?>">                       
        
        	<?php get_template_part( 'title', 'slogan' ) ?>       
			
			<?php get_template_part('accordion-slider') ?>
            
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
            
    		<?php clear('space') ?>	
            
        </div>               
    
    </div>
    <!-- END CONTENT --> 
        
<?php get_footer() ?>
