<?php
global $wpsc_query, $wpdb, $post;
	$page_id = $post->ID;
/*
 * Most functions called in this page can be found in the wpsc_query.php file
 */
$layout = get_layout_page();
?>       
        
		<div id='products_page_container' class="wrap wpsc_container products">
	
			<?php wpsc_output_breadcrumbs( array( 'before-breadcrumbs' => '', 'after-breadcrumbs' => '' ) ); ?>
		
		<?php do_action('wpsc_top_of_products_page'); // Plugin hook for adding things to the top of the products page, like the live search ?>
		<?php if(wpsc_display_categories()): ?>
		  <?php if(wpsc_category_grid_view()) :?>
				<div class="wpsc_categories wpsc_category_grid group">
					<?php wpsc_start_category_query(array('category_group'=> get_option('wpsc_default_category'), 'show_thumbnails'=> 1)); ?>
						<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_grid_item  <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>">
							<?php wpsc_print_category_image(get_option('category_image_width'),get_option('category_image_height')); ?>
						</a>
						<?php wpsc_print_subcategory("", ""); ?>
					<?php wpsc_end_category_query(); ?>
					
				</div><!--close wpsc_categories-->
		  <?php else:?>
				<ul class="wpsc_categories">
				
					<?php wpsc_start_category_query(array('category_group'=>get_option('wpsc_default_category'), 'show_thumbnails'=> get_option('show_category_thumbnails'))); ?>
							<li>
								<?php wpsc_print_category_image(get_option('category_image_width'), get_option('category_image_height')); ?>
								
								<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_link <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>"><?php wpsc_print_category_name(); ?></a>
								<?php if(wpsc_show_category_description()) :?>
									<?php wpsc_print_category_description("<div class='wpsc_subcategory'>", "</div>"); ?>				
								<?php endif;?>
								
								<?php wpsc_print_subcategory("<ul>", "</ul>"); ?>
							</li>
					<?php wpsc_end_category_query(); ?>
				</ul>
			<?php endif; ?>
		<?php endif; ?>
	<?php // */ ?>
		
		<?php if(wpsc_display_products() || wpsc_category_name() != ''): ?>
			
			<?php if(wpsc_is_in_category()) : ?>
				<div class="wpsc_category_details">
					<?php if(wpsc_show_category_thumbnails()) : ?>
						<img src="<?php echo wpsc_category_image(); ?>" alt="<?php echo wpsc_category_name(); ?>" />
					<?php endif; ?>
					
					<?php if(wpsc_show_category_description() &&  wpsc_category_description()) : ?>
						<?php echo wpsc_category_description(); ?>
					<?php endif; ?>
				</div><!--close wpsc_category_details-->
			<?php endif; ?>
			<?php if(wpsc_has_pages_top()) : ?>
				<div class="wpsc_page_numbers_top general-pagination">
					<?php wpsc_pagination(); ?>
				</div><!--close wpsc_page_numbers_top-->
				<?php clear('space') ?>
			<?php endif; ?>	
				
				<?php 
				    global $yiw_layout;
				    
					if( $yiw_layout != 'sidebar-no' )
						$last_each = 4;
					else
						$last_each = 5;
						
					$i = 0;     
				?>
				
				<?php /** start the product loop here */?>  
				<ul class="list-products default_product_display product_view_<?php echo wpsc_the_product_id(); ?> <?php echo wpsc_category_class(); ?> group">
				<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
				
					<?php $last_class = ( ! (($i+1) % $last_each) ) ? ' last' : '' ?>
				
					<?php if( wpsc_category_transition() ) :?>
					  	<h3 class='wpsc_category_boundary'>
					    <?php echo wpsc_current_category_name(); ?>
						</h3>
					<?php endif; ?>
					                                                                                                                                            
					<li class="productsdisplay default_product_display product_view_<?php echo wpsc_the_product_id(); ?> <?php echo wpsc_category_class(); ?><?php echo $last_class ?>">
						<?php if( wpsc_show_thumbnails() ) : $url_image = get_option('show_thumbnails_thickbox') ? wpsc_the_product_image() : wpsc_the_product_permalink() ?>
							<div class="product-image">
								<?php if(wpsc_the_product_thumbnail()) : ?>
									<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo $url_image; ?>">
										<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(); ?>"/>
									</a>
								<?php else: ?>
									<a href="<?php echo wpsc_the_product_permalink(); ?>">
										<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="No Image" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="<?php echo get_option('product_image_width'); ?>" height="<?php echo get_option('product_image_height'); ?>" />	
									</a>
								<?php endif; ?>    
								
								<?php if( wpsc_product_on_special() ) : ?>
									<div class="sale-icon-small">Sale!</div>
								<?php endif; ?> 
							</div>                
							<div class="thumb-shadow">&nbsp;</div>
						<?php endif; ?>
						
						<?php
						if(gold_cart_display_gallery()) :				
						      echo gold_shpcrt_display_gallery(wpsc_the_product_id(), true);
						endif;
						?>	
						
						<p class="title-product">
							<?php if(get_option('hide_name_link') == 1) : ?>
								<?php echo wpsc_the_product_title(); ?>          
							<?php else: ?> 
								<a class="wpsc_product_title" href="<?php echo wpsc_the_product_permalink(); ?>"><?php echo wpsc_the_product_title(); ?></a>
							<?php endif; ?>
						</p>            
						
						<?php	
							do_action('wpsc_product_before_description', wpsc_the_product_id(), ( ( isset( $wpsc_query->product ) ) ? $wpsc_query->product : null ) );
							do_action('wpsc_product_addons', wpsc_the_product_id());
						?>
						
						<?php if( !wpsc_show_stock_availability() OR wpsc_product_has_stock() ): ?>
							<div class="price">
							<?php 
								$price = wpsc_the_product_price(get_option('wpsc_hide_decimals'));
								
								if( get_option('wpsc_hide_decimals') )	
									echo $price;
								else
									format_price( $price ); 
							?>
							</div>
						<?php else : ?>
							<p><?php _e('Product not in stock', TEXTDOMAIN); ?></p>
						<?php endif ?>
						
						<?php echo do_shortcode('[button_icon href="'.wpsc_the_product_permalink().'" icon="arrow"]'.__( 'More details', TEXTDOMAIN ).'[/button_icon]') ?>    
					</li>   
					
					<?php if( !( ( $i + 1 ) % $last_each ) ) echo '<li style="display:block;height:0;with:100%;clear:both;visibility:hidden;margin:0;"></li>' ?>
		
				<?php $i++; endwhile; ?>
				</ul>
				<?php /** end the product loop here */?>
				
				
				<?php if(wpsc_product_count() < 1):?>
					<p><?php  echo __('There are no products in this group.', TEXTDOMAIN); ?></p>
				<?php endif ; ?>      
		    
			<?php do_action( 'wpsc_theme_footer' ); clear(); ?> 	
	
			<?php if( wpsc_has_pages_bottom() ) : ?>
				<div class="wpsc_page_numbers_bottom general-pagination">
					<?php wpsc_pagination(); ?>
				</div><!--close wpsc_page_numbers_bottom-->           
				<?php clear('space') ?>
			<?php endif; ?>
				
				
			<?php endif; ?>
		</div>      
		
		<?php //$wp_the_query = new WP_Query(); wp_reset_query(); ?>      