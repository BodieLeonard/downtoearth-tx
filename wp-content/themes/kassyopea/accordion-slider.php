			<?php
				global $post, $wp_query;
				
				$tmp_query = $wp_query;
				
				if( get_post_meta( $post->ID, '_slider_accordion_show', true ) ) :
				
				$args = array( 'post_type' => get_post_meta( $post->ID, '_slider_accordion_name', true ), 'post_per_page' => 5 );
				$bl_teams = new WP_Query( $args );
				$first = TRUE;
				
				if( $bl_teams->have_posts() ) :
			?> 
    
		    <!-- START ACCORDION SLIDER -->
		    <ul class="accordion-slider">
		    
		    	<?php while( $bl_teams->have_posts() ) : $bl_teams->the_post(); ?>     
				
					<?php $width = intval( 960 - ( 154.4 * $bl_teams->post_count ) ); ?>
				
				<li class="step ListItem" id="bl_team-<?php the_ID() ?>" style="max-width:<?php echo $width + 154 ?>px">
					<div class="photo-preview title handle">
						<?php the_post_thumbnail('img-accordion-slider') ?>
						<h5 class="no-cufon"><span><?php the_title() ?></span></h5>
						<p class="profile"><?php echo get_post_meta( $post->ID, '_slider_accordion_subtitle', true ); ?></p>
					</div>
					<?php the_content() ?>
				</li>
				<?php $first = FALSE; endwhile ?>
				
			</ul>   
		    <!-- END ACCORDION SLIDER -->
		    
			<?php 
				endif; endif;
				
				$wp_query = $tmp_query; 
				
				wp_reset_postdata();
			?>        