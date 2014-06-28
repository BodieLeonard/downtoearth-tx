<?php 
	global $wp_query, $post;  
	
	if ( have_posts() ) : 

	    while ( have_posts() ) : the_post();
	    	
			add_filter( 'the_title', 'get_convertTags' ); 
			
			$wpautop = get_post_meta( get_current_ID(), '_page_remove_wpautop', true );
			
			if( $wpautop )
				remove_filter( 'the_content', 'wpautop' );
			
			if( get_post_meta( $post->ID, '_show_title_page', true ) ) 
				the_title( '<h3 class="title-post-page">', '</h3>' );       
				
			the_content();
			
			wp_link_pages();
		
			if( $wpautop )
				add_filter( 'the_content', 'wpautop' ); 
		
		endwhile; 
	
	endif; 
	
	wp_reset_query();
?>                    