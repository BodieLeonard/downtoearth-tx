<?php    
                         
function jqueryslider_panel()
{
	yiw_admin( jqueryslider_panel_array() );
}  

function jqueryslider_panel_array()
{
	global $shortname, $themename;
	
	$prefix = 'slider';
	
	$options = array (         
	    
	    /* =================== ARROW FADE SLIDER =================== */
	    "settings" => array(    
	        array( "name" => __('Slider Manager', TEXTDOMAIN),
	        	   "type" => "title"),
	    
	        array( "name" => __("Slider Settings", TEXTDOMAIN),
	        	   "type" => "section",
				   "effect" => 0),
	        array( "type" => "open"),  
	         
	        array( "name" => __("Effect", TEXTDOMAIN),
	        	   "desc" => __("Select the effect you want for slides transiction.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_effect",
	        	   "type" => "select",
	        	   "options" => $GLOBALS['fxs'],
				   "std" => 'fade'),	
	         
	        array( "name" => __("Easing", TEXTDOMAIN),
	        	   "desc" => __("Select the easing for effect transition.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_easing",
	        	   "type" => "select",
	        	   "options" => $GLOBALS['easings'],
				   "std" => FALSE ),	
	        	
	        array( "name" => __("Speed (s)", TEXTDOMAIN),
	        	   "desc" => __("Select the speed of transiction between slides, expressed in seconds.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_speed",
	        	   "min" => 0,
	        	   "max" => 5,
	        	   "step" => 0.1,
	        	   "type" => "slider_control",
	        	   "std" => 0.5),  
	        	
	        array( "name" => __("Timeout (s)", TEXTDOMAIN),
	        	   "desc" => __("Select the delay between slides, expressed in seconds.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_timeout",
	        	   "min" => 0,
	        	   "max" => 20,
	        	   "step" => 0.5,
	        	   "type" => "slider_control",
	        	   "std" => 5),     
	         
	        array( "name" => __("Show more text", TEXTDOMAIN),
	        	   "desc" => __("Select if you want to show more text after tooltip content, linked with slide's link.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_show_more_text",
	        	   "type" => "on-off",
				   "std" => 'no'),
	         
	        array( "name" => __("More text", TEXTDOMAIN),
	        	   "desc" => __("Write what you want to show on more link, if you have selected 'YES' on option above.", TEXTDOMAIN),
	        	   "id" => $shortname."_{$prefix}_more_text",
	        	   "type" => "text",
				   "std" => __( 'Read more...', TEXTDOMAIN ) ),
	        	
	        array( "type" => "close")
	    ),
		        
	    "slides" => array(    
	        array( "name" => __("Slides", TEXTDOMAIN),
	        	   "type" => "section",
	        	   "valueButton" => __("Add/Edit Slide", TEXTDOMAIN),
				   "effect" => 0),
	        array( "type" => "open"),  
	         
	        array( "id" => $shortname."_{$prefix}_slides",
	        	   "data" => "array",
	        	   "type" => "slides-table",
				   "config" => "title, image, caption, link, video",
				   "videoSize" => "384x310 px",
				   "max-height" => 180 ),	
	        	
	        array( "type" => "close")
	    )        
	    /* =================== END ARROW FADE SLIDER =================== */
	 
	);                                  
	
	return $options;
}
?>