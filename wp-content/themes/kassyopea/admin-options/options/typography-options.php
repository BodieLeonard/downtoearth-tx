<?php                

function typography_panel()
{
	yiw_admin( typography_panel_array() );
}  

function typography_panel_array()
{
	global $shortname, $themename, $actual_font;
	
	$options = array (
	 
	    /* =================== GENERAL =================== */
	    "typography" => array(    
	        array( "name" => __('Typography Settings', TEXTDOMAIN),
	        	   "type" => "title"),
	    
	        array( "name" => __("Typography", TEXTDOMAIN), 
				   "effect" => 0,
	        	   "type" => "section"),
	        array( "type" => "open"),
	         
	        array( "name" => __("Font for main titles", TEXTDOMAIN),
	        	   "desc" => __("Select the cufon font for the mains texts. NB: the following font size settings must be configured after change this font setting.", TEXTDOMAIN),
	        	   "id" => $shortname."_font",
	        	   "type" => "select",
	        	   "options" => get_list_fonts(),
	        	   "std" => "delicious"),   
	        	
	        array( "type" => "close")
		),     
	        	
	    "main" => array(        
	        array( "name" => __("Main Typography", TEXTDOMAIN), 
	        	   "type" => "section"),
	        array( "type" => "open"),
	        
	        array( "name" => __("Main Text", TEXTDOMAIN),
	        	   "desc" => __("Select the size for the main text.", TEXTDOMAIN),
	        	   "id" => $shortname."_p_size_$actual_font",
	        	   "min" => 8,
	        	   "max" => 72,
	        	   "label" => 'px',
	        	   "type" => "slider_control",
	        	   "std" => 13 ),     
	        	
	        array( "name" => __("Head line 1 (h1)", TEXTDOMAIN),
	        	   "desc" => __("Select the size for headline 1 (h1).", TEXTDOMAIN),
	        	   "id" => $shortname."_h1_size_$actual_font",
	        	   "min" => 8,
	        	   "max" => 72,     
	        	   "label" => 'px',
	        	   "type" => "slider_control",
	        	   "std" => get_fontsize( $actual_font, 'h1' ) ),   
	        	
	        array( "name" => __("Head line 2 (h2)", TEXTDOMAIN),
	        	   "desc" => __("Select the size for headline 2 (h2).", TEXTDOMAIN),
	        	   "id" => $shortname."_h2_size_$actual_font",
	        	   "min" => 8,
	        	   "max" => 72,     
	        	   "label" => 'px',
	        	   "type" => "slider_control",
	        	   "std" => get_fontsize( $actual_font, 'h2' ) ),     
	        	
	        array( "name" => __("Head line 3 (h3)", TEXTDOMAIN),
	        	   "desc" => __("Select the size for headline 3 (h3).", TEXTDOMAIN),
	        	   "id" => $shortname."_h3_size_$actual_font",
	        	   "min" => 8,
	        	   "max" => 72,     
	        	   "label" => 'px',
	        	   "type" => "slider_control",
	        	   "std" => get_fontsize( $actual_font, 'h3' ) ),          
	        	
	        array( "name" => __("Head line 4 (h4)", TEXTDOMAIN),
	        	   "desc" => __("Select the size for headline 4 (h4).", TEXTDOMAIN),
	        	   "id" => $shortname."_h4_size_$actual_font",
	        	   "min" => 8,
	        	   "max" => 72,     
	        	   "label" => 'px',
	        	   "type" => "slider_control",
	        	   "std" => get_fontsize( $actual_font, 'h4' ) ),              
	        	
	        array( "name" => __("Head line 5 (h5)", TEXTDOMAIN),
	        	   "desc" => __("Select the size for headline 5 (h5).", TEXTDOMAIN),
	        	   "id" => $shortname."_h5_size_$actual_font",
	        	   "min" => 8,
	        	   "max" => 72,     
	        	   "label" => 'px',
	        	   "type" => "slider_control",
	        	   "std" => get_fontsize( $actual_font, 'h5' ) ),              
	        	
	        array( "name" => __("Head line 6 (h6)", TEXTDOMAIN),
	        	   "desc" => __("Select the size for headline 6 (h6).", TEXTDOMAIN),
	        	   "id" => $shortname."_h6_size_$actual_font",
	        	   "min" => 8,
	        	   "max" => 72,     
	        	   "label" => 'px',
	        	   "type" => "slider_control",
	        	   "std" => get_fontsize( $actual_font, 'h6' ) ),   
	        	
	        array( "type" => "close")
	    ),  
	        	
	    "various" => array(    
	        array( "name" => __("Various", TEXTDOMAIN), 
	        	   "type" => "section"),
	        array( "type" => "open"),
	        
	        array( "name" => __("Navigation Items", TEXTDOMAIN),
	        	   "desc" => __("Select the size for the navigation items.", TEXTDOMAIN),
	        	   "id" => $shortname."_nav_size_$actual_font",
	        	   "min" => 8,
	        	   "max" => 72,
	        	   "label" => 'px',
	        	   "type" => "slider_control",
	        	   "std" => get_fontsize( $actual_font, 'nav' ) ),       
	        	
	        array( "type" => "close")
	    )        
	    /* =================== END GENERAL =================== */
	 
	);                               
	
	return $options;  
}
?>