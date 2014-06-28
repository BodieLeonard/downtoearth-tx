<?php    
                         
function sidebars_panel()
{
	yiw_admin( sidebars_panel_array() );
}  

function sidebars_panel_array()
{
	global $shortname, $themename;
	
	$options = array (         
	    
	    /* =================== SIDEBARS =================== */
	    "add-sidebar" => array(    
	        array( "name" => __('Sidebar Manager', TEXTDOMAIN),
	        	   "type" => "title"),
	    
	        array( "name" => __("Create Sidebar", TEXTDOMAIN),
	        	   "type" => "section",
				   "effect" => 0),
	        array( "type" => "open"),  
	         
	        array( "name" => __("Sidebar name", TEXTDOMAIN),
	        	   "desc" => __("Add a new sidebar.<br/><b>NB:</b> by default, there are 1 sidebar have already created: <br />- '<strong>Blog Sidebar</strong>', for Blog Template; <br />- '<strong>Home Colourful Section</strong>'; <br />- '<strong>Home Sidebar</strong>'; <br />- '<strong>Footer Row 1/2/3</strong>', for Footer.", TEXTDOMAIN),
	        	   "id" => $shortname."_sidebars",
	        	   "type" => "text",
	        	   "button" => "Add Sidebar",
	        	   "data" => "array",
	        	   "mode" => "merge",
	        	   "show_value" => false,
				   "std" => ''),	
	        	
	        array( "type" => "close")
	    ),
		        
	    "table-sidebar" => array(    
	        array( "name" => __("Sidebar created", TEXTDOMAIN),
	        	   "type" => "section",
				   "effect" => 0,
				   "show-submit" => false),
				   
	        array( "type" => "open"),  
	         
	        array( "name" => __("List sidebar created", TEXTDOMAIN),
	        	   "desc" => __("Table with sidebar that you have created.", TEXTDOMAIN),
	        	   "values" => $shortname."_sidebars",
	        	   "label" => array( 'Sidebar', 'Sidebars' ),
	        	   "type" => "sidebar-table"),	
	        	
	        array( "type" => "close")
	    )        
	    /* =================== END SIDEBARS =================== */
	 
	);         
	
	return $options;               
}
?>