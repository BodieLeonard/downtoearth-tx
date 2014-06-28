    <!-- START TESTIMONIAL -->
    <div id="testimonial-slider">        
    	<div class="inner">                 
			<a class="arrow-left" href="#"></a>
			<a class="arrow-right" href="#"></a>
			<ul>   
				<?php 
					$args = array(
						'post_type' => 'bl_testimonials',
						'posts_per_page' => -1	
					);    
					$args = apply_filters( 'yiw_testimonials_slider_query', $args );
					
					$testimonials = new WP_Query( $args );
					
					while( $testimonials->have_posts() ) : $testimonials->the_post();   
						add_filter( 'excerpt_length', 'excerpt_length_testimonials_slider' );
						add_filter( 'excerpt_more', 'excerpt_more_testimonials_slider' );
						remove_filter( 'the_excerpt', 'wpautop' );
						$author = $post->post_title;
                        $url = get_post_meta( get_the_ID(), '_testimonial_website', true );
                        
                        $url_html = '';
                        if( $url ) $url_html = ', <a href="' . esc_url( $url ) . '" rel="nofollow">' . $url . '</a>';
                ?>
                <li>
                <h5>"<?php the_excerpt() ?>"</h5>
                <h6><?php echo '<strong>' . $author . '</strong>' . $url_html; ?></h6>
				</li>
				<?php 
					endwhile; 
					wp_reset_query(); 
					remove_filter( 'excerpt_length', 'excerpt_length_testimonials_slider' );  
					remove_filter( 'excerpt_more', 'excerpt_more_testimonials_slider' );    
					add_filter( 'the_excerpt', 'wpautop' );
				?>
			</ul>  
		
			<?php clear() ?>    
    	</div>
    </div>                     
    <!-- END TESTIMONIAL -->   