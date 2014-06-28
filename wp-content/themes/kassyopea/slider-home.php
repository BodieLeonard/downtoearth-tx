			<div id="slider">
            	
            	<div class="images">
	            	<?php 
	            		$slides = get_slides('bl_slider_slides');
						
						if( is_array( $slides ) AND !empty( $slides ) ) 
						{
							$first = TRUE;
							
							foreach( $slides as $id => $slide ) :
								$the_ = split_title( $slide['slide_title'] );
								get_links_sliders( $link, $link_url, $slide );
						
								if( get_option('bl_slider_show_more_text') AND $link ) 
									$more_text = " <a href=\"$link_url\">" . get_option( 'bl_slides_more_text', __( 'Read more...', TEXTDOMAIN ) ) . "</a>";
								else
									$more_text = '';
									
								$content_slide = stripslashes( $slide['tooltip_content'] ) . ' ' . $more_text;
						        $content_slide = wpautop( do_shortcode($content_slide) );
						        
						        $a_before = ( $link ) ? '<a href="'.$link_url.'">' : '';
						        $a_after  = ( $link ) ? '</a>' : '';
					?>
					<!-- START PANEL -->
					<div class="panel<?php if( $first ) echo ' first' ?>">
						<?php featured_content( $slide, $a_before, $a_after ) ?>
						
						<div class="hentry">
							<?php string_( '<h2>' . $a_before, $the_['title'], $a_after . '</h2>' ) ?>
							<?php string_( '<h4>', $the_['subtitle'], '</h4>' ) ?>
							                                                          
							<?php echo $content_slide ?>
						</div>
					</div>
					<!-- END PANEL -->
					<?php $first = FALSE; endforeach; } ?>
				</div>
				
				<!-- START PAGINATION -->
				<div class="controls">
					<a href="#" title="Pause" id="slider-pause"><img src="<?php echo get_template_directory_uri() . '/images/icons/slider-pause.png' ?>" alt="Pause" /></a>
					<a href="#" title="Play" id="slider-play"><img src="<?php echo get_template_directory_uri() . '/images/icons/slider-play.png' ?>" alt="Play" /></a>	
				</div>
				<div class="pagination"></div>
				<!-- END PAGINATION -->  
				
				<?php $easing = ( $eas = get_option('bl_slider_easing') ) ? "easing: '$eas'," : '' ?>             
                     
			    <script type="text/javascript">
			        jQuery(document).ready(function($){
			        	if ( $('#slider .images .panel').length != 0 ) {
				            $('#slider .images').cycle({
				            	fx: '<?php echo get_option('bl_slider_effect', 'fade') ?>',
								speed: <?php echo get_option('bl_slider_speed', 0.5) * 1000 ?>,
								timeout: <?php echo get_option('bl_slider_timeout', 5) * 1000 ?>,
								<?php echo $easing ?>
								pager: '.pagination',
								cleartype: true
							});                   
	    
						    $('#slider-pause').show();
						    
						    $('#slider-pause').click(function(){
								$('#slider .images').cycle('pause');
								$(this).hide();
								$('#slider-play').show();
								return false;
							});
						    
						    $('#slider-play').click(function(){
								$('#slider .images').cycle('resume');
								$(this).hide();
								$('#slider-pause').show();    
								return false;
							});
						}
			        });        
			    </script>   
					
			</div>   
