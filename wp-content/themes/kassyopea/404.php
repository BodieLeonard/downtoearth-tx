<?php      
/**
 * @package WordPress
 * @subpackage Kassyopea
 * @since Kassyopea 1.0
 */
?>

<?php get_header() ?>           
            
        </div>                   
        
		<?php clear('border-header') ?>
                           
    </div>
    <!-- END HEADER -->   
	
	<!-- START CONTENT -->
    <div id="content">
    
        <div class="p404 inner">
                  
            <h1><strong>404</strong> <?php _e('error', TEXTDOMAIN) ?></h1>
            <h3><?php _e('Page not found', TEXTDOMAIN) ?> <img src="<?php echo get_template_directory_uri() ?>/images/icons/search.png" alt="<?php _e('Page not found', TEXTDOMAIN) ?>" /></h3>    
        
            <p>
                <?php _e('We are sorry but the page you are looking for does not exist.', TEXTDOMAIN) ?><br/>
                <?php _e('You could retourn to the ', TEXTDOMAIN) ?> <a href="<?php bloginfo('url') ?>">homepage</a> <?php _e('or search using the search box below', TEXTDOMAIN) ?>
            </p>
            
            <!-- START SEARCH -->
            <form method="get" id="searchform" action="<?php echo home_url(); ?>/">
                <fieldset>
                    <input type="text" name="s" id="s" value="<?php the_search_query(); ?>" />
                    <input type="submit" id="searchsubmit" value="GO" />
                </fieldset>
            </form>             
            <!-- END SEARCH -->
        </div>            
    
    </div>
    <!-- END CONTENT -->
    
<?php get_footer() ?>
