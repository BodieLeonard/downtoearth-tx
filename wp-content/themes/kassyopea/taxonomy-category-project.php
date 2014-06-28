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
        <div class="inner layout-sidebar-no">      
			
			<?php 
				$type_bl_portfolio = get_option( 'bl_portfolio_type', '3columns' );
				
				clear('space');
			?>
            
			<!-- START HENTRY -->                     
            <div class="hentry">                          
            	<?php if( get_option( 'bl_panel_portfolioshow' ) ) get_template_part( 'portfolio', $type_bl_portfolio ) ?>       
        
            	<?php comments_template(); ?>     
            </div>               
            <!-- END HENTRY -->   
            
            <?php clear() ?>    
            
        </div>
    </div>  
    <!-- END CONTENT --> 
        
<?php get_footer() ?>
