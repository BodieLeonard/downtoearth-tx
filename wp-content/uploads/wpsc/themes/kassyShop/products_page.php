<?php
global $wpsc_query, $wpdb, $post;
/*
 * Most functions called in this page can be found in the wpsc_query.php file
 */
?>                
        
<?php 
	$slogan = get_post_meta( $post->ID, '_slogan_page', true );
	if( ( $layout = get_post_meta( $post->ID, '_layout_page', true ) ) == '' ) $layout = 'sidebar-right'; 
?>
        
<?php if( $slogan != '' ) : ?><h2 class="title-page"><?php convertTags( $slogan ) ?></h2><?php else : clear('space'); endif; ?> 
            
<!-- START HENTRY -->
<div class="hentry">
	<div id='products_page_container' class="wrap wpsc_container products">
	
		<?php include 'breadcrumb.php' ?>
		
		<?php do_action('wpsc_top_of_products_page'); // Plugin hook for adding things to the top of the products page, like the live search ?>
		<?php if(wpsc_display_categories()): ?>
		  <?php if(get_option('wpsc_category_grid_view') == 1) :?>
				<div class='wpsc_categories wpsc_category_grid'>
					<?php wpsc_start_category_query(array('category_group'=> get_option('wpsc_default_category'), 'show_thumbnails'=> 1)); ?>
						<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_grid_item" title='<?php wpsc_print_category_name();?>'>
							<?php wpsc_print_category_image(45, 45); ?>
						</a>
						<?php wpsc_print_subcategory("", ""); ?>
					<?php wpsc_end_category_query(); ?>
					<div class='clear_category_group'></div>
				</div>
		  <?php else:?>
				<ul class='wpsc_categories'>
					<?php wpsc_start_category_query(array('category_group'=>get_option('wpsc_default_category'), 'show_thumbnails'=> get_option('show_category_thumbnails'))); ?>
							<li>
								<?php wpsc_print_category_image(32, 32); ?>
								
								<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_link"><?php wpsc_print_category_name();?></a>
								<?php if(get_option('wpsc_category_description')) :?>
									<?php wpsc_print_category_description("<div class='wpsc_subcategory'>", "</div>"); ?>				
								<?php endif;?>
								
								<?php wpsc_print_subcategory("<ul>", "</ul>"); ?>
							</li>
					<?php wpsc_end_category_query(); ?>
				</ul>
			<?php endif; ?>
		<?php endif; ?>
	
	
	
		
		<?php if(wpsc_display_products()): ?>
			<?php if(wpsc_is_in_category()) : ?>
				<div class='wpsc_category_details'>
					<?php if(get_option('show_category_thumbnails') && wpsc_category_image()) : ?>
						<img src='<?php echo wpsc_category_image(); ?>' alt='<?php echo wpsc_category_name(); ?>' title='<?php echo wpsc_category_name(); ?>' />
					<?php endif; ?>
					
					<?php if(get_option('wpsc_category_description') &&  wpsc_category_description()) : ?>
						<?php echo wpsc_category_description(); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			
			
			<!-- Start Pagination -->
			<?php if ( ( get_option( 'use_pagination' ) == 1 && ( get_option( 'wpsc_page_number_position' ) == 1 || get_option( 'wpsc_page_number_position' ) == 3 ) ) ) : ?>
				<div class="wpsc_page_numbers">
					<?php if ( wpsc_has_pages() ) : ?>
						Pages: <?php echo wpsc_first_products_link( '&laquo; First', true ); ?> <?php echo wpsc_previous_products_link( '&laquo; Previous', true ); ?> <?php echo wpsc_pagination( 10 ); ?> <?php echo wpsc_next_products_link( 'Next &raquo;', true ); ?> <?php echo wpsc_last_products_link( 'Last &raquo;', true ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>		
			<!-- End Pagination -->
			
			<?php 
				if( $layout != 'sidebar-no' )
					$last_each = 4;
				else
					$last_each = 5;
					
				$i = 0;     
			?>
			
			<?php /** start the product loop here */?>  
			<ul class="list-products">
			<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
			
				<?php $last_class = ( ! (($i+1) % $last_each) ) ? ' last' : '' ?>
			
				<?php if(wpsc_category_transition()) :?>
			  	<h3 class='wpsc_category_boundary'>
			    <?php echo wpsc_current_category_name(); ?>
					</h3>
				<?php endif; ?>
				                                                                                                                                            
				<li class="productsdisplay default_product_display product_view_<?php echo wpsc_the_product_id(); ?> <?php echo wpsc_category_class(); ?><?php echo $last_class ?>">
					<?php if(get_option('show_thumbnails')) :?>
						<!--<a rel="<?php echo str_replace(array(" ", '"',"'", '&quot;','&#039;'), array("_", "", "", "",''), wpsc_the_product_title()); ?>" class="thickbox preview_link" href="<?php echo wpsc_the_product_thumbnail(); ?>">-->
							<?php 
								if(wpsc_the_product_thumbnail())
									$src_image = wpsc_the_product_thumbnail(); 
								else 
									$src_image = get_bloginfo('template_url') . '/images/no_image_thumb.jpg';
							?>
						
							<div class="product-image">
								<a href="<?php echo wpsc_the_product_permalink() ?>" title="<?php echo wpsc_the_product_title(); ?>">
									<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo $src_image ?>" />  
						        </a>
								<?php if($wpsc_query->product['price'] - $wpsc_query->product['special_price'] > 0 && $wpsc_query->product['special_price'] > 0) : ?>
									<div class="sale-icon-small">Sale!</div>
								<?php endif; ?> 
							</div>
						<!--</a>-->             
						<div class="thumb-shadow">&nbsp;</div>
					<?php endif; ?>
					
					<p class="title-product">
						<?php if(get_option('hide_name_link') == 1) : ?>
							<?php echo wpsc_the_product_title(); ?>          
						<?php else: ?> 
							<a class="wpsc_product_title" href="<?php echo wpsc_the_product_permalink(); ?>"><?php echo wpsc_the_product_title(); ?></a>
						<?php endif; ?>
					</p>            
					
					<?php							
						do_action('wpsc_product_before_description', wpsc_the_product_id(), $wpsc_query->product);
						do_action('wpsc_product_addons', wpsc_the_product_id());
					?>
					
					<div class='wpsc_description'>
	    			<?php
						$value = '';
						$the_addl_desc = wpsc_the_product_additional_description();
						if( is_serialized($the_addl_desc) ) {
							$addl_descriptions = @unserialize($the_addl_desc);
						} else {
							$addl_descriptions = array('addl_desc', $the_addl_desc);
						}
						
						if( isset($addl_descriptions['addl_desc']) ) {
							$value = $addl_descriptions['addl_desc'];
						}
	
		            	if( function_exists('wpsc_addl_desc_show') ) {
		            		echo wpsc_addl_desc_show( $addl_descriptions );
		            	} else {
							echo stripslashes( wpautop($the_addl_desc, $br=1));
		            	}
		            ?>
					</div>    
				
					<?php if(wpsc_the_product_additional_description() AND FALSE) : ?>
					<div class='additional_description_span'>
						<a href='<?php echo wpsc_the_product_permalink(); ?>' class='additional_description_link'>
							<img class='additional_description_button'  src='<?php echo WPSC_URL; ?>/images/icon_window_expand.gif' title='Additional Description' alt='Additional Description' /><?php echo __('More Details', 'wpsc'); ?>
						</a>
						<div class='additional_description'>
							<?php
								$value = '';
								$the_addl_desc = wpsc_the_product_additional_description();
								if( is_serialized($the_addl_desc) ) {
									$addl_descriptions = @unserialize($the_addl_desc);
								} else {
									$addl_descriptions = array('addl_desc'=> $the_addl_desc);
								}
								
								if( isset($addl_descriptions['addl_desc']) ) {
									$value = $addl_descriptions['addl_desc'];
								}
							
								if( function_exists('wpsc_addl_desc_show') ) {
									echo wpsc_addl_desc_show( $addl_descriptions );
								} else {
									echo stripslashes( wpautop($the_addl_desc, $br=1));
								}
							?>
						</div>
						
						<br />
					</div>
					<?php endif; ?>
					
					<div class="price">
						<?php 
							$price = wpsc_the_product_price(get_option('wpsc_hide_decimals'));
							
							if( get_option('wpsc_hide_decimals') )	
								echo $price;
							else
								format_price( $price ); 
						?></div>
					
					<?php echo do_shortcode('[button_icon href="'.wpsc_the_product_permalink().'" icon="arrow"]'.__( 'More details', 'wpsc' ).'[/button_icon]') ?>    
				</li>   
	
			<?php $i++; endwhile; ?>
			</ul>
			<?php /** end the product loop here */?>
			
			
			<?php if(wpsc_product_count() < 1):?>
				<p><?php  echo __('There are no products in this group.', 'wpsc'); ?></p>
			<?php endif ; ?>
	
		<?php
	
		if(function_exists('fancy_notifications')) {
			echo fancy_notifications();
		}
		?>
			
			
			<!-- Start Pagination -->
			<?php if ( ( get_option( 'use_pagination' ) == 1 && ( get_option( 'wpsc_page_number_position' ) == 2 || get_option( 'wpsc_page_number_position' ) == 3 ) ) ) : ?>
				<div class="clear"></div>
				
				<div class="general-pagination">
					<?php if ( wpsc_has_pages() ) : ?>
						<?php echo wpsc_first_products_link( '&laquo;', true ); ?>
						<?php echo wpsc_previous_products_link( '<', true ); ?>
						<?php echo wpsc_pagination( 10 ); ?>
						<?php echo wpsc_next_products_link( '>', true ); ?> 
						<?php echo wpsc_last_products_link( '&raquo;', true ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<!-- End Pagination -->
			
			
		<?php endif; ?>
	</div>
</div>               
<!-- END HENTRY -->    

<!-- START SIDEBAR -->
<div class="sidebar sidebar-small-size">
    <?php if( $layout != 'sidebar-no' ) dynamic_sidebar( get_post_meta( $post->ID, '_sidebar_choose_page', true ) ) ?>
</div>               
<!-- END SIDEBAR --> 