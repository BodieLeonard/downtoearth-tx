<?php    
                         
function accordionslider_panel()
{
	yiw_admin( accordionslider_panel_array() );
}  

function accordionslider_panel_array()
{
	global $shortname, $themename, $wp_post_types;
	
	$options = array (         
	    
	    /* =================== SIDEBARS =================== */
	    "add-accordion-slider" => array(    
	        array( "name" => __('Accordion Sliders manager', TEXTDOMAIN),
	        	   "type" => "title"),
	    
	        array( "name" => __("Create Accordion Slider", TEXTDOMAIN),
	        	   "type" => "section",
				   "effect" => 0),
	        array( "type" => "open"),  
	         
	        array( "name" => __("Slider name", TEXTDOMAIN),
	        	   "desc" => __("Add new accordion slider. Creating this slider, you create new custom post type automatically, where you can create the contents for this slider.", TEXTDOMAIN),
	        	   "id" => $shortname."_accordion_sliders",
	        	   "type" => "text",
	        	   "data" => "array",
	        	   "mode" => "merge",
	        	   "control" => $wp_post_types,
	        	   "show_value" => false,
				   "std" => ''),	
	        	
	        array( "type" => "close")
	    ),
		        
	    "table-accordion-sliders" => array(    
	        array( "name" => __("Accordion sliders created", TEXTDOMAIN),
	        	   "type" => "section",
				   "effect" => 0,
				   "show-submit" => false),
	        array( "type" => "open"),  
	         
	        array( "name" => __("List sliders created", TEXTDOMAIN),
	        	   "desc" => __("Table with sliders that you have created.", TEXTDOMAIN),
	        	   "values" => $shortname."_accordion_sliders",            
	        	   "label" => array( 'Accordion slider', 'Accordion Sliders' ),
	        	   "type" => "sidebar-table"),	
	        	
	        array( "type" => "close")
	    )        
	    /* =================== END SIDEBARS =================== */
	 
	);         
	
	return $options;         
}
?>