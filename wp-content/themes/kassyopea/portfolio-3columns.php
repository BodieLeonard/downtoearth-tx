		<?php
                	global $paged, $wp_query;       
                	
                    $args = array(
						'post_type' => 'bl_portfolio',
						'posts_per_page' => get_option('bl_portfolio_items'),
						'paged' => $paged
					);                           
				
					$portfolio_cat = get_post_meta( get_current_ID(), 'portfolio_category', true );
					
					if ( ! empty( $portfolio_cat ) )
						$args['category-project'] = $portfolio_cat; 
						
					if ( is_tax() )
                       $args = wp_parse_args( $args, $wp_query->query );           
	             
	             	$tmp_query = $wp_query;
	             	
                    $portfolio = new WP_Query( $args );  

                 if(function_exists('pagination')) : pagination( $portfolio->max_num_pages ); else : ?> 
    
                <div class="navigation">
                    <div class="alignleft"><?php next_posts_link(__('Next &raquo;', TEXTDOMAIN)) ?></div>
                    <div class="alignright"><?php previous_posts_link(__('&laquo; Back', TEXTDOMAIN)) ?></div>
                </div>
            
            <?php endif; ?>            
			<ul id="portfolio">         
                <?php
                    
                    $i = 1;
                    
                    while( $portfolio->have_posts() ) : $portfolio->the_post();  
                        global $more;
                        $more = 0;
                ?>     
                
                <li <?php post_class( ($i % 3 == 0) ? 'last' : '' ) ?>>
                	
					<?php   
                        if( $thumb = get_post_meta(get_the_ID(), '_video', true) )
                        {
                            $class = 'video';
                        }
                        else
                        {
                            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                            $thumb = $thumb[0];
                            $class = 'img';
                        }
					?>
                    
                    <?php if( has_post_thumbnail() ) : ?>
                        <a class="thumb <?php echo $class ?>" href="<?php echo $thumb ?>" rel="prettyPhoto[movies]"><?php the_post_thumbnail('portfolio-thumb') ?></a>
                        <div class="shadow-thumb"></div>         
                    <?php endif ?>   
                
                    <h5><?php convertTags( get_the_title() ) ?></h5>
                    
                    <?php the_content('') ?>  
                    
                    <a href="<?php the_permalink() ?>" class="more-link"><?php echo get_option( 'bl_portfolio_more_text', __( 'View Project', TEXTDOMAIN ) ) ?></a>
                    
                    <div class="clear"></div>
                </li>       
                                                                        
                <?php 
                	if ($i % 3 == 0)
                		echo '<li class="clear"></li>';
                		
					$i++; endwhile;   
					
					$wp_query = $tmp_query;
					
					wp_reset_postdata(); 
				?>        
            </ul>                             
			
			<?php clear() ?>           
                
            <?php if(function_exists('pagination')) : pagination( $portfolio->max_num_pages ); else : ?> 
    
                <div class="navigation">
                    <div class="alignleft"><?php next_posts_link(__('Next &raquo;', TEXTDOMAIN)) ?></div>
                    <div class="alignright"><?php previous_posts_link(__('&laquo; Back', TEXTDOMAIN)) ?></div>
                </div>
            
            <?php endif; ?>      