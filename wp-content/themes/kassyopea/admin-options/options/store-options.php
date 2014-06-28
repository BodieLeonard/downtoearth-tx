<?php                

function store_panel()
{
	yiw_admin( store_panel_array() );
}  

function store_panel_array()
{
	global $shortname, $themename;
	
	$options = array (
	 
	    /* =================== GENERAL =================== */
	    "general" => array(    
	        array( "name" => __('Store Configuration', TEXTDOMAIN),
	        	   "type" => "title"),
	    
	        array( "name" => __("Single Product Page", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),
	         
	        array( "name" => __("Show Special Items Widget", TEXTDOMAIN),
	        	   "desc" => __("Select if you want to show the special items widget after product details.", TEXTDOMAIN),
	        	   "id" => $shortname."_store_show_special_items",
	        	   "type" => "on-off",
	        	   "std" => 1),
	         
	        array( "name" => __("Title Special Items Widget", TEXTDOMAIN),
	        	   "desc" => __("The title of the special items widget after product details.", TEXTDOMAIN),
	        	   "id" => $shortname."_store_title_special_items",
	        	   "type" => "text",
	        	   "std" => ''),
	         
	        array( "name" => __("Description Special Items Widget", TEXTDOMAIN),
	        	   "desc" => __("The description of the special items widget after product details.", TEXTDOMAIN),
	        	   "id" => $shortname."_store_description_special_items",
	        	   "type" => "textarea",
	        	   "std" => ''),
	        
	         
	        array( "type" => "close")   
	    )           
	    /* =================== END FOOTER =================== */
	 
	);                               
	
	return $options;  
}
?>