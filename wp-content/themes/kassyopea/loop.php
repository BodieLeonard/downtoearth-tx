       				<div class="clear"></div>
                    
                    <?php               
                    
                    global $post, $wp_query;  
                    
                    $tmp_query = $wp_query;   
					
					if (have_posts()) : 
                    
                    $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
                    <?php /* If this is a category archive */ if (is_category()) { ?>
                  <h3 class="red-normal"><?php printf(__('Archive for the &#8216;%s&#8217; Category', TEXTDOMAIN), single_cat_title('', false)); ?></h3>
                    <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
                  <h3 class="red-normal"><?php printf(__('Posts Tagged &#8216;%s&#8217;', TEXTDOMAIN), single_tag_title('', false) ); ?></h3>
                    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                  <h3 class="red-normal"><?php printf(__('Archive for %s | Daily archive page', TEXTDOMAIN), get_the_time(__('F jS, Y', TEXTDOMAIN))); ?></h3>
                    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                  <h3 class="red-normal"><?php printf(__('Archive for %s | Monthly archive page', TEXTDOMAIN), get_the_time(__('F Y', TEXTDOMAIN))); ?></h3>
                    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                  <h3 class="red-normal"><?php printf(__('Archive for %s | Yearly archive page', TEXTDOMAIN), get_the_time(__('Y', TEXTDOMAIN))); ?></h3>
                    <?php /* If this is a yearly archive */ } elseif (is_search()) { ?>
                  <h3 class="red-normal"><?php printf( __( 'Search Results for: %s', TEXTDOMAIN ), '<span>' . get_search_query() . '</span>' ); ?></h3>
                   <?php /* If this is an author archive */ } elseif (is_author()) { ?>               
                  <h3 class="red-normal"><?php _e('Author Archive', TEXTDOMAIN); ?></h3>
                    <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                  <h3 class="red-normal"><?php _e('Blog Archives', TEXTDOMAIN); ?></h3>        
                    <?php } 
                                                       
                        while (have_posts()) : the_post(); 
                          
                        global $more;
                        
                        if(!is_single()) $more = 0;
                    ?>                        
                
                    <div class="clear"></div>
                    
                        <div class="date">                                                     
                            <h3 class="title-blog no-cufon"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h3> 
                            
                            <div class="mon-year">
                                <?php echo '<span>' . get_the_time('M') . '</span><br />' . get_the_time('Y') ?>
                            </div>
                            
                            <div class="day">
                                <?php the_time('d') ?>
                            </div>
                            
                            <div class="clear"></div>
                        </div>
                        
                        <div class="clear line"></div>
                        <p class="meta">
                            <span class="left"><?php _e('posted by', TEXTDOMAIN) ?> <?php the_author_posts_link() ?> | </span> 
                            <span class="left tags">on <?php the_category( ', ' ) ?> | </span>
                            <span class="left comment"> <?php comments_popup_link(__('No comments', TEXTDOMAIN), __('1 comment', TEXTDOMAIN), __('% comments', TEXTDOMAIN)); ?></span>
                        </p>
                        <div class="clear"></div>
                        
                        <?php
                            global $content_width;
                            
                            $size = get_option( 'bl_blog_image_size' );
                            
                            if ( $size == 'custom' ) $size = array( get_option('bl_blog_image_width'), get_option('bl_blog_image_height') );
                        ?>
                        
                        <div id="post-<?php the_ID(); ?>" <?php post_class('hentry-post'); ?>>
							<?php if( has_post_thumbnail() ) 
							{                       
								$image = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
								$width = $image[1] + 12;
								$height = $image[2];
								
								if ( $width > $content_width ) {    
								    $height = intval( $height * $content_width / $width );
								    $width = $content_width;
								}
								
								// class of shadow
								if( $width < 60 )
									$class_shadow = '';
								elseif ( $width < 100 )
									$class_shadow = ' shadow60';
								elseif ( $width < 150 )
									$class_shadow = ' shadow100';
								elseif ( $width < 300 )
									$class_shadow = ' shadow150';
								elseif ( $width < 600 )
									$class_shadow = ' shadow300';
								elseif ( $width < 960 )
									$class_shadow = ' shadow600';     
								elseif ( $width >= 960 )
									$class_shadow = ' shadow960';
								?>
							
                            <div class="featured-image <?php echo get_option( 'bl_blog_image_align' ) ?>" style="width:<?php echo $width ?>px;">	
								<?php
								the_post_thumbnail( array( $width, $height ), array( 'class' => get_option( 'bl_blog_image_align' ) ) );
								echo '<div class="shadow-blog-img'.$class_shadow.'"></div>'; ?>    
							</div>
							<?php } ?>
                            
                            <?php the_content( __('Read more', TEXTDOMAIN) ) ?>   
                        
                        	<div class="clear"></div>      
					
							<?php if( is_single() ) the_tags( '<p class="list-tags">Tags: ', ', ', '</p>' ) ?>
                        </div>
                    
                    <?php endwhile; 
						
						else : ?>
						
							<div id="post-0" class="post error404 not-found">
								<h1 class="entry-title"><?php _e( 'Not Found', 'twentyten' ); ?></h1>
								<div class="entry-content">
									<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
									<?php get_search_form(); ?>
								</div><!-- .entry-content -->
							</div><!-- #post-0 -->
						
						<?php
						endif;
					
                    $wp_query = $tmp_query;
                    
                    wp_reset_postdata();
                    
                    if(function_exists('pagination')) : pagination(); else : ?> 
            
                        <div class="navigation">
                            <div class="alignleft"><?php next_posts_link(__('Next &raquo;', TEXTDOMAIN)) ?></div>
                            <div class="alignright"><?php previous_posts_link(__('&laquo; Back', TEXTDOMAIN)) ?></div>
                        </div>
                    
                    <?php endif; ?>       
        
                    <?php comments_template(); ?>
                
                	<?php clear( 'space' ) ?> 