<?php
/* Define the custom box */

// WP 3.0+
add_action('add_meta_boxes', 'admin_add_custom_box');

// backwards compatible
//add_action('admin_init', 'admin_add_custom_box', 1);

// adding some style
function admin_style_init()
{
	wp_enqueue_style('my_meta_css', get_template_directory_uri() . '/admin-options/include/metaboxes.css');
}
add_action( 'admin_init', 'admin_style_init' );

/* Do something with the data entered */
add_action('save_post', 'admin_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */
function admin_add_custom_box() {
    //add_meta_box( 'admin_sectionid', __( 'My Post Section Title', 'admin_textdomain' ), 'admin_inner_custom_box', 'post' );
    
	// page
	add_meta_box( 'admin_sidebar_page', __( 'Options of page', TEXTDOMAIN ), 'admin_options_page_inner_custom_box', 'page', 'side' );     
    add_meta_box( 'admin_slogan_page', __( 'Slogan Page', TEXTDOMAIN ), 'admin_slogan_page_inner_custom_box', 'post', 'side', 'high' );
    add_meta_box( 'admin_remove_wpautop_page', __( 'Remove WpAutoP filter.', TEXTDOMAIN ), 'admin_remove_wpautop_page_inner_custom_box', 'page', 'normal', 'high' );
    add_meta_box( 'admin_extra_content_page', __( 'Extra Content', TEXTDOMAIN ), 'admin_extra_content_page_inner_custom_box', 'page', 'normal', 'high' );
    
	// testimonials
	add_meta_box( 'admin_testimonial_website', __( 'Web Site Testimonial', TEXTDOMAIN ), 'admin_testimonial_website_inner_custom_box', 'bl_testimonials', 'side', 'high' );
    
	// portfolio                                                                                                                                                                        
    add_meta_box( 'admin_bl_portfolio_video_url', __( 'Video URL thumb', TEXTDOMAIN ), 'admin_bl_portfolio_video_url_inner_custom_box', 'bl_portfolio', 'normal', 'high' );
	//add_meta_box( 'admin_bl_portfolio_credits_meta', __( 'Design & Build Credits', TEXTDOMAIN ), 'admin_bl_portfolio_credits_meta_inner_custom_box', 'bl_portfolio', 'normal', 'low' );
    //add_meta_box( 'admin_bl_portfolio_year_completed', __( 'Year Completed', TEXTDOMAIN ), 'admin_bl_portfolio_year_completed_inner_custom_box', 'bl_portfolio', 'side', 'high' );            
	add_meta_box( 'admin_sidebar_page', __( 'Options of page', TEXTDOMAIN ), 'admin_options_page_inner_custom_box', 'bl_portfolio', 'side' );     
    add_meta_box( 'admin_slogan_page', __( 'Slogan Page', TEXTDOMAIN ), 'admin_slogan_page_inner_custom_box', 'bl_portfolio', 'side', 'high' );
    add_meta_box( 'admin_remove_wpautop_page', __( 'Remove WpAutoP filter.', TEXTDOMAIN ), 'admin_remove_wpautop_page_inner_custom_box', 'bl_portfolio', 'normal', 'high' );
    add_meta_box( 'admin_extra_content_page', __( 'Extra Content', TEXTDOMAIN ), 'admin_extra_content_page_inner_custom_box', 'bl_portfolio', 'normal', 'high' );
    
    // dynamics post type
    foreach( yiw_get_slides() as $post_type ) 
    	add_meta_box( 'admin_accordion_slider_subtitle', __( 'Subtitle slide', TEXTDOMAIN ), 'admin_slider_accordion_subtitle_inner_custom_box', $post_type['slug'], 'side', 'high' );
}                         

/* When the post is saved, saves our custom data */
function admin_save_postdata( $post_id ) {

	if ( isset( $_POST['admin_noncename'] ) AND !wp_verify_nonce( $_POST['admin_noncename'], plugin_basename(__FILE__) )) 
		return $post_id;
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;    
	
	if ( isset( $_POST['post_type'] ) AND 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		  return $post_id;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		  return $post_id;
	}
	
	$custom_keys['hidden'] = array();
	$custom_keys['public'] = array();
	
	if( isset( $_POST['post_type'] ) )
	{           
		// for all                          
		$custom_keys['hidden'][] = 'layout_page';
		$custom_keys['hidden'][] = 'sidebar_choose_page';  
		$custom_keys['hidden'][] = 'sidebar_layout';  
		$custom_keys['hidden'][] = 'slider_accordion_show';  
		$custom_keys['hidden'][] = 'slider_accordion_name';  
		$custom_keys['hidden'][] = 'slogan_page';  
		$custom_keys['hidden'][] = 'show_title_page';
		$custom_keys['hidden'][] = 'page_remove_wpautop';
		$custom_keys['hidden'][] = 'page_extra_content';
		$custom_keys['hidden'][] = 'page_extra_content_autop';
		
		switch( $_POST['post_type'] )
		{
			case 'bl_testimonials' :
				$custom_keys['hidden'][] = 'testimonial_website';                        
			break;
			
			case 'bl_portfolio' :
				//$custom_keys['hidden'][] = 'year_completed';   
				//$custom_keys['hidden'][] = 'designers';   
				//$custom_keys['hidden'][] = 'developers';   
				//$custom_keys['hidden'][] = 'producers';      
				$custom_keys['hidden'][] = 'video';                        
			break;
		}
	
		foreach( yiw_get_slides() as $post_type )
		{
			if( $post_type['slug'] == $_POST['post_type'] )
			{
				$custom_keys['hidden'][] = 'slider_accordion_subtitle';	
			}
		}      
	}
	
	// add post metas hidden
	foreach( $custom_keys['hidden'] as $key )
	{
		//if( isset( $_POST[$key] ) )
			add_post_meta( $post_id, '_'.$key, $_POST[$key], true ) or update_post_meta( $post_id, '_'.$key, $_POST[$key] );	
	}
	
	return $mydata;
}



// ========================== OPTIONS PAGE ================================

/* Prints the box content */
function admin_options_page_inner_custom_box() {

	// Use nonce for verification
	wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' ); 
  
	$post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
	
	// LAYOUT PAGE
	$select_layout = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_layout_page', true ) : ''; 
	if( $select_layout == '' ) $select_layout = get_option( $GLOBALS['shortname'] . '_default_layout_page', 'sidebar-right' );
	
	$layouts = array(
		'sidebar-no' => 'No Sidebar',
		'sidebar-left' => 'Left Sidebar',
		'sidebar-right' => 'Right Sidebar'
	);    
	?>
	
	<div class="yiw_metaboxes">
		<p><?php _e( 'You can configure this page as you want, setting these optional options.', TEXTDOMAIN ) ?></p>   
		
		<?php           
		// SLOGAN
		$select_slogan = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_slogan_page', true ) : '';     
		?>
		
		<label for="slogan_page"><?php _e( 'Slogan page', TEXTDOMAIN )?></label>    
		<p>
			<input type="text" name="slogan_page" id="slogan_page" value="<?php echo $select_slogan ?>" style="width:95%" />      
			<span><?php _e( 'Insert the slogan showed on top of this page/post.', TEXTDOMAIN ); ?></span>
		</p>                     
		
		
		<?php $select_title = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_show_title_page', true ) : ''; ?>     
		
		<label for="show_title_page"><?php _e( 'Show Title', TEXTDOMAIN ) ?></label> 
		<p>    
			<input type="checkbox" name="show_title_page" id="show_title_page" value="1"<?php echo ( ($select_title) ? ' checked=""' : '' ) ?> />      
			<label for="show_title_page"><?php _e( 'Show the title of this page.', TEXTDOMAIN ); ?></label>
		</p>
	
		<label for="layout_page">Layout Page</label>
		
		<p>
			<select name="layout_page" id="layout_page">
			
			<?php
			foreach( $layouts as $layout => $name_layout )
			{
				$selected = '';
				
				if( $layout == $select_layout )
					$selected = ' selected="selected"';
				
				?><option value="<?php echo $layout ?>"<?php echo $selected?>><?php echo $name_layout ?></option><?php
			} ?>
			                            
			</select>
			<span class="inline"><?php _e("Select layout of page", TEXTDOMAIN ) ?></span>
		</p>                         
		
		<?php
		// SIDEBAR
		$select_sidebar = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_sidebar_choose_page', true ) : '';     
		?>
		
		<label for="sidebar_choose_page">Sidebar Page</label>
		<p>
			<select name="sidebar_choose_page" id="sidebar_choose_page">
				<option></option>
			
				<?php
				foreach( $GLOBALS['wp_registered_sidebars'] as $sidebar )
				{
					$selected = '';
					if( $sidebar['name'] == $select_sidebar )
						$selected = ' selected="selected"';
					
					?><option value="<?php echo $sidebar['name'] ?>"<?php echo $selected ?>><?php echo $sidebar['name'] ?></option><?php
				} ?>
			                            
			</select>                
			<span class="inline"><?php _e("Select sidebar of page", TEXTDOMAIN ) ?></span>        
		</p>  
		
		<?php 
		$select_sidebar_layout = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_sidebar_layout', true ) : '';     
		?>
		
		<label for="sidebar_layout">Sidebar Layout</label>
		<p>
			<select name="sidebar_layout" id="sidebar_layout">
				<?php
				foreach( array( 'big-size' => 'Big Size Title', 'small-size' => 'Small Size Title' ) as $name_layout => $layout )
				{
					$selected_layout = 'big-size';
					if( $name_layout == $select_sidebar_layout )
						$selected_layout = ' selected="selected"';
					
					?><option value="<?php echo $name_layout ?>"<?php echo $selected_layout ?>><?php echo $layout ?></option><?php
				} ?>
			                            
			</select>                
			<span><?php _e("Choose layout sidebar, for different titles style.", TEXTDOMAIN ) ?></span>        
		</p>  
		
		<?php
		// ACCORDION SLIDER       
	  	$select_accordion = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_slider_accordion_show', true ) : '';     
	  	$name_slider = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_slider_accordion_name', true ) : '';  
		?>   
	
	  	<?php $checked_accordion = ( $select_accordion ) ? ' checked=""' : ''; ?>
		    
		<label for="slider_accordion_show"><?php _e( 'Accordion Slider', TEXTDOMAIN ) ?></label>    
		<p>
		  	<input type="checkbox" name="slider_accordion_show" id="slider_accordion_show" value="1"<?php echo $checked_accordion ?> />
		  	<label for="slider_accordion_show"><?php _e("Show slider accordion on page.", TEXTDOMAIN ) ?></label>
	    </p>
		     
	  	<p>
		  	<select name="slider_accordion_name" id="slider_accordion_name">               
		  	    <option value=""></option>
		  
		    <?php
		  	$post_types = unserialize( get_option('bl_accordion_sliders') );
		  
		  	foreach( $post_types as $post_type )	
		  	{
		  		$name_post_type = str_replace( ' ', '_', $post_type );
		  		$selected = ( $name_slider == $name_post_type ) ? ' selected="selected"' : '';
		  		
				?><option value="<?php echo $name_post_type ?>"<?php echo $selected ?>><?php echo $post_type ?></option><?php    
			}           
			
			?>
			</select>
			<label for="slider_accordion_name"><?php _e("Select name slider.", TEXTDOMAIN ) ?></label>
		</p>
	</div><?php  
}

/* Enable or not the remove wpautop for main content */
function admin_remove_wpautop_page_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );
  
  $post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
    
  $select_autop = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_page_remove_wpautop', true ) : FALSE;
  $checked_autop = ( $select_autop ) ? ' checked="checked"' : '';   

  // The actual fields for data entry       
  echo '<label>';
  echo '<input type="checkbox" id="page_remove_wpautop" name="page_remove_wpautop" value="1"' . $checked_autop . ' /> ';
  _e( "Remove 'wpautop' filter to main content.", TEXTDOMAIN );
  echo '</label>';
}

/* Prints the box content */
function admin_extra_content_page_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );
  
  $post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
  
  $select_text = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_page_extra_content', true ) : '';     
  $select_autop = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_page_extra_content_autop', true ) : FALSE;
  $checked_autop = ( $select_autop ) ? ' checked="checked"' : '';   

  // The actual fields for data entry       
  echo '<p>' . __( 'If you want, you can add some text to show above the footer, under content and sidebar.', TEXTDOMAIN ) . '</p>';
  echo '<textarea name="page_extra_content" id="page_extra_content" style="width:100%;height:200px;" />'.$select_text.'</textarea>';   
  echo '<label>';
  echo '<input type="checkbox" id="page_extra_content_autop" name="page_extra_content_autop" value="1"' . $checked_autop . ' />';
  _e( 'Automatically add paragraphs', TEXTDOMAIN );
  echo '</label>';
}



// ========================== SLOGAN PAGE ================================

/* Prints the box content */
function admin_slogan_page_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );     
  
  $post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
  
  $select = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_slogan_page', true ) : '';     

  // The actual fields for data entry
  echo '<label><strong>' . __( 'Slogan page', TEXTDOMAIN ) .'</strong><br /><br />' ;
  echo '<input type="text" name="slogan_page" id="slogan_page" value="'.$select.'" />';
  echo '</label>';
}



// ========================== WEB SITE TESTIMONIAL ================================

/* Prints the box content */
function admin_testimonial_website_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );      
  
  $post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
  
  $select = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_testimonial_website', true ) : '';     

  // The actual fields for data entry                                                       
  echo '<label for="testimonial_website"> ' . __("Web Site", TEXTDOMAIN ) . '</label> ';
  echo '<input type="text" name="testimonial_website" id="testimonial_website" value="'.$select.'" />';
                                
  echo '</select>';                         
}

/* Prints the box content */
function admin_slider_accordion_subtitle_inner_custom_box() {

  	// Use nonce for verification
  	wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );  
  
  	$post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
  
  	$select = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_slider_accordion_subtitle', true ) : '';   
	                                                
  	echo '<label for="slider_accordion_subtitle"> ' . __("Insert the subtitle.", TEXTDOMAIN ) . '</label><br /> ';
  	echo '<input type="text" name="slider_accordion_subtitle" id="slider_accordion_subtitle" value="'.$select.'" />';
}



// ========================== PORTFOLIO ================================

/* Prints the box content */
function admin_bl_portfolio_credits_meta_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );     
  
  $post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
  
  $designers 	= ( $post_id != FALSE ) ? get_post_meta( $post_id, '_designers', true ) : '';
  $developers 	= ( $post_id != FALSE ) ? get_post_meta( $post_id, '_developers', true ) : '';
  $producers 	= ( $post_id != FALSE ) ? get_post_meta( $post_id, '_producers', true ) : '';
  ?>
  <p><label>Designed By:</label><br />
  <textarea cols="50" rows="5" name="designers"><?php echo $designers; ?></textarea></p>
  <p><label>Built By:</label><br />
  <textarea cols="50" rows="5" name="developers"><?php echo $developers; ?></textarea></p>
  <p><label>Produced By:</label><br />
  <textarea cols="50" rows="5" name="producers"><?php echo $producers; ?></textarea></p>
  <?php                        
}

/* Prints the box content */
function admin_bl_portfolio_year_completed_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );  
  
	if( !isset( $_GET['post'] ) )
	  	return false;
  
  $year_completed = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_year_completed', true ) : '';
  ?>
  <label>Year:</label>
  <input type="text" name="year_completed" value="<?php echo $year_completed; ?>" />
  <?php
                 
}

/* Prints the box content */
function admin_bl_portfolio_video_url_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'admin_noncename' );  
  
  $post_id = ( isset( $_GET['post'] ) ) ? $_GET['post'] : false;
  
  $video = ( $post_id != FALSE ) ? get_post_meta( $post_id, '_video', true ) : '';
  ?>
  <label>Video URL:</label>
  <input type="text" name="video" value="<?php echo $video; ?>" style="width:80%;" />
  <p>Here, you can add an Youtube or Vimeo url video, to show on thumb of this portfolio element.</p>
  <?php
                 
}
?>
