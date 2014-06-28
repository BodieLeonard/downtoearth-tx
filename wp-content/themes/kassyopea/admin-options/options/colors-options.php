<?php                         

function colors_panel()
{
	yiw_admin( colors_panel_array() );
}  

function colors_panel_array()
{
	global $shortname, $themename, $color_theme;
	
	$prefix = 'color';
	
	$options = array (         
	    
	    /* =================== COLORS =================== */
	    "title" => array(    
	        array( "name" => __('Colors Settings', TEXTDOMAIN),
	        	   "type" => "title"),   
	    ),
	                                                    
	    "scheme" => array( 
	        array( "name" => __("Color Scheme", TEXTDOMAIN),
	        	   "type" => "section",
				   "effect" => 0),
	        array( "type" => "open"),  
	         
	        array( "name" => __("Colour Scheme", TEXTDOMAIN),
	        	   "desc" => __("Select the colour scheme for the theme. <br/> WARNING: if you want to change the color scheme and the color below this form too, you have to change this color scheme in first and then, after update, you can change single colors, in 'Colors' section.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_scheme",
	        	   "type" => "select",
	        	   "options" => get_list_colors(),
	        	   "std" => "grey"),
	        
	        array( "type" => "close") 
	    ),		 
	                                 
	    "general" => array(        
	        array( "name" => __("General", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),  
	        
	        array( "name" => __("Body content background color", TEXTDOMAIN),
	        	   "desc" => __("Select the background color of the main text content.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_bg-body_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('bg-body', false, true)),
	         
	        array( "name" => __("Color Text", TEXTDOMAIN),
	        	   "desc" => __("Select the colour of general text", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_color-text_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('color-text', false, true)),
	         
	        array( "name" => __("Color Highlight", TEXTDOMAIN),
	        	   "desc" => __("Select the general highlight color", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_color-evid_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('color-evid', false, true)),	
	         
	        array( "name" => __("Color Links", TEXTDOMAIN),
	        	   "desc" => __("Select the colour all links.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_color-links_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('color-links', false, true)),	
	         
	        array( "name" => __("Color Links Hover", TEXTDOMAIN),
	        	   "desc" => __("Select the colour of hover state of all links.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_color-links-hover_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('color-links-hover', false, true)),
	        
	        array( "type" => "close") 
	    ),	
	    
	    "navigation" => array(       
	    
	        array( "name" => __("Navigation", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),
	        
	        array( "name" => __("Color Nav Links", TEXTDOMAIN),
	        	   "desc" => __("Select the colour of navigation links.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_color-nav_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('color-nav', false, true)),
	         
	        array( "name" => __("Color Nav Links Hover", TEXTDOMAIN),
	        	   "desc" => __("Select the colour of hover state of navigation links.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_color-nav-hover_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('color-nav-hover', false, true)),	
	         
	        array( "name" => __("Color Nav Links Descriptions", TEXTDOMAIN),
	        	   "desc" => __("Select the colour of text description, under each item of navigation.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_color-nav-descr_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('color-nav-descr', false, true)),	
	        
	        array( "type" => "close") 
	    ),	
	    
	    "footer" => array(      
	    
	        array( "name" => __("Footer", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),		
	         
	        array( "name" => __("Background Copyright Section", TEXTDOMAIN),
	        	   "desc" => __("Select the background color of copyright zone.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_bg-copyright_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('bg-copyright', false, true)),	
	         
	        array( "name" => __("Color Title Footer", TEXTDOMAIN),
	        	   "desc" => __("Select the title color, of each section of footer.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_title-footer_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('title-footer', false, true)),		
	         
	        array( "name" => __("Background Color of Flickr Thumbs", TEXTDOMAIN),
	        	   "desc" => __("Select the background color of flickr thumbs, on footer.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_bg-flickr_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('bg-flickr', false, true)),	
	         
	        array( "name" => __("Border Color of Flickr Thumbs", TEXTDOMAIN),
	        	   "desc" => __("Select the border color of flickr thumbs, on footer.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_border-flickr_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('border-flickr', false, true)),		
	         
	        array( "name" => __("Background Color of Quick Contact form", TEXTDOMAIN),
	        	   "desc" => __("Select the background color of quick contact form, on footer.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_bg-quick-contact_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('bg-quick-contact', false, true)),	
	         
	        array( "name" => __("Border Color of Quick Contact form", TEXTDOMAIN),
	        	   "desc" => __("Select the border color of quick contact form, on footer.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_border-quick-contact_".$color_theme,
	        	   "type" => "color-picker",
	        	   "std" => get_color('border-quick-contact', false, true)),	
	        	
	        array( "type" => "close")
	    )        
	    /* =================== END COLORS =================== */
	 
	);   
	
	return $options;                
}

?>