<?php                

function general_panel()
{
	yiw_admin( general_panel_array() );
}  

function general_panel_array()
{
	global $shortname, $themename;
	
	$options = array (
	 
	    /* =================== GENERAL =================== */
	    "general" => array(    
	        array( "name" => __('General Settings', TEXTDOMAIN),
	        	   "type" => "title"),
	    
	        array( "name" => __("General", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),
	         
	        array( "name" => __("Colour Scheme", TEXTDOMAIN),
	        	   "desc" => __("Select the colour scheme for the theme.", TEXTDOMAIN),
	        	   "id" => $shortname."_color_scheme",
	        	   "type" => "select",
	        	   "options" => get_list_colors(),
	        	   "std" => "grey"),
	        	
	        array( "name" => __("Logo URL", TEXTDOMAIN),
	        	   "desc" => __("Enter the URL to your logo image", TEXTDOMAIN),
	        	   "id" => $shortname."_logo",     
	        	   "data" => "array",
	        	   "type" => "upload",
	        	   "std" => ""),
	        	
	        array( "name" => __("Custom Favicon", TEXTDOMAIN),
	        	   "desc" => __("A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image", TEXTDOMAIN),
	        	   "id" => $shortname."_favicon",
	        	   "data" => "array",
	        	   "type" => "upload",
	        	   "std" => home_url() ."/favicon.ico"),	  
	        	
	        array( "name" => __("Date Format", TEXTDOMAIN),
	        	   "desc" => __("Set the general date format of theme. Read <a href=\"http://codex.wordpress.org/Formatting_Date_and_Time\">Documentation on date formatting</a>", TEXTDOMAIN),
	        	   "id" => $shortname."_date_format",
	        	   "type" => "text",
	        	   "std" => get_option('date_format') ),	  
	        	
	        array( "name" => __("Default Layout page", TEXTDOMAIN),
	        	   "desc" => __("Set the default layout for all pages, where you can't select the layout on editor page.", TEXTDOMAIN),
	        	   "id" => $shortname."_default_layout_page",
	        	   "type" => "select",
	        	   "options" => array(
				   		'sidebar-right' => __( 'Sidebar Right', TEXTDOMAIN ),
				   		'sidebar-left' => __( 'Sidebar Left', TEXTDOMAIN ),
				   		'no-sidebar' => __( 'No Sidebar', TEXTDOMAIN ),
				   ),
	        	   "std" => 'sidebar-right' ),	
	        	
	        array( "name" => __("Topbar", TEXTDOMAIN),
	        	   "desc" => __("Select how you want show the topbar.", TEXTDOMAIN),
	        	   "id" => $shortname."_topbar",
	        	   "type" => "select",
	        	   "options" => array( 'fixed' => 'fixed', 'nofixed' => 'no fixed', 'none' => 'none' ),
	        	   "std" => __("fixed", TEXTDOMAIN)),       
	        	
	        array( "name" => __("Custom Style", TEXTDOMAIN),
	        	   "desc" => __("You can write here your custom css, that will replace the default css.", TEXTDOMAIN),
	        	   "id" => $shortname."_custom_style",
	        	   "type" => "textarea",
	        	   "std" => ''),	         
	        	
	        array( "name" => __("Addtionale JS scripts", TEXTDOMAIN),
	        	   "desc" => __("Insert here an optional additional scripts, it will insert on footer. We suggest to start script with <strong>jQuery(document).ready(function(){ // here your script });</strong>", TEXTDOMAIN),
	        	   "id" => $shortname."_custom_js",
	        	   "type" => "textarea",
	        	   "std" => "jQuery(document).ready(function(){\n\t// " . __( 'here your script', TEXTDOMAIN ) . "\n});"),  
	        	
	        array( "type" => "close")
	    ),        
	    /* =================== END GENERAL =================== */
	    
	                                                 
	    /* =================== HOME PAGE =================== */
	    "homepage" => array(
	        array( "name" => __("Homepage", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),              
	        	
	        array( "name" => __("Show Slider", TEXTDOMAIN),
	        	   "desc" => __("Say if you want to show the slider on the Home Page", TEXTDOMAIN),
	        	   "id" => $shortname."_slider_show",
	        	   "type" => "on-off",
	        	   "std" => 1),
	        
	        array( "name" => __("Slider type", TEXTDOMAIN),
	        	   "desc" => __("Select the slider type that you want on home page.", TEXTDOMAIN),
	        	   "id" => $shortname."_slider_type",
	        	   "type" => "select",
	        	   "options" => $GLOBALS['sliders_type'],
	        	   "std" => __("Choose a slider", TEXTDOMAIN)),             
	        	
	        array( "name" => __("Show Colourful Section", TEXTDOMAIN),
	        	   "desc" => __("Say if you want to show the colourful section, below slider.", TEXTDOMAIN),
	        	   "id" => $shortname."_grey_section_show",
	        	   "type" => "on-off",
	        	   "std" => 1),          
	        	
	        array( "name" => __("Show Testimonial Slider", TEXTDOMAIN),
	        	   "desc" => __("Say if you want to show the testimonial slider.", TEXTDOMAIN),
	        	   "id" => $shortname."_testimonial_slider_show",
	        	   "type" => "on-off",
	        	   "std" => 1),   
	        	
	        array( "name" => __("Word Split on Testimonial Slider", TEXTDOMAIN),
	        	   "desc" => __("Say how many words do you want to show on slider of testimonials.", TEXTDOMAIN),
	        	   "id" => $shortname."_testimonial_slider_words_split",
	        	   "type" => "slider_control",
	        	   "min" => 1,
	        	   "max" => 50,
	        	   "std" => 13),   
	        
	        array( "type" => "close")
	    ),   
	    /* =================== END HOME PAGE =================== */
	    
	                                                 
	    /* =================== portfolio =================== */
	    "portfolio" => array(
	        array( "name" => __("portfolio", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),
	        	
	        array( "name" => __("portfolio Type", TEXTDOMAIN),
	        	   "desc" => __("Say the layout for your portfolio page.", TEXTDOMAIN),
	        	   "id" => $shortname."_portfolio_type",
	        	   "type" => "select",
	        	   "options" => array('3columns' => __('3 Columns', TEXTDOMAIN), 'slider' => __('With Slider', TEXTDOMAIN)),
	        	   "std" => ''),   
	        	
	        array( "name" => __("Items", TEXTDOMAIN),
	        	   "desc" => __("Select how many items you want to show.", TEXTDOMAIN),
	        	   "id" => $shortname."_portfolio_items",
	        	   "min" => 1,
	        	   "max" => 40,
	        	   "type" => "slider_control",
	        	   "std" => 5),                     
        	
            array( "name" => __("More text", TEXTDOMAIN),
            	   "desc" => __("Define what show for more link.", TEXTDOMAIN),
            	   "id" => $shortname."_portfolio_more_text",
            	   "type" => "text",
            	   "std" => __( 'View Project', TEXTDOMAIN ) ), 
	        	
	        array( "name" => __("Lightbox Skin", TEXTDOMAIN),
	        	   "desc" => __("Specific what skin you want for videos and images lightbox.", TEXTDOMAIN),
	        	   "id" => $shortname."_portfolio_skin_lightbox",
	        	   "type" => "select",
	        	   "options" => array(
	                    'pp_default' => 'Default', 
	                    'facebook' => 'Facebook', 
	                    'light_rounded' => 'Light rounded', 
	                    'dark_rounded' => 'Dark rounded semi-transparent',
	                    'light_square' => 'Light square',
	                    'dark_square' => 'Dark square semi-transparent'
	                ),
	        	   "std" => 'pp_default'),
	        
	        array( "type" => "close")
	    ),   
	    /* =================== END portfolio =================== */
	    
	                                                 
	    /* =================== BLOG =================== */
	    "blog" => array(
	        array( "name" => __("Blog Settings", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),         
	        	
	        array( "name" => __("Items", TEXTDOMAIN),
	        	   "desc" => __("Select how many items you want to show on Blog Page", TEXTDOMAIN),
	        	   "id" => $shortname."_blog_items",
	        	   "min" => 1,
	        	   "max" => 50,
	        	   "type" => "slider_control",
	        	   "std" => 1),          
	        	
	        array( "name" => __("Exclude categories", TEXTDOMAIN),
	        	   "desc" => __("Select witch categories you want exlude from blog.", TEXTDOMAIN),
	        	   "id" => $shortname."_blog_cats_exclude",
	        	   "type" => "cat",
	        	   "cols" => 2,          // number of columns for multickecks
	        	   "heads" => array(__("Blog Page", TEXTDOMAIN), __("List cat. sidebar", TEXTDOMAIN)),  // in case of multi columns, specific the head for each column
	        	   "std" => ''),          
	        	
	        array( "name" => __("Featured Images Alignment", TEXTDOMAIN),
	        	   "desc" => __("Specific the featured images alignment", TEXTDOMAIN),
	        	   "id" => $shortname."_blog_image_align",
	        	   "type" => "select",
	        	   "options" => array(
	                    'alignleft' => 'Left', 
	                    'alignright' => 'Right', 
	                    'aligncenter' => 'Center'
	                ),
	        	   "std" => 'aligncenter'),
	        	
	        array( "name" => __("Featured Images Size", TEXTDOMAIN),
	        	   "desc" => __("Specific the featured images size", TEXTDOMAIN),
	        	   "id" => $shortname."_blog_image_size",
	        	   "type" => "select",
	        	   "options" => array(
	                    'post-thumbnail' => 'Standard', 
	                    'thumbnail' => 'Thumbnail', 
	                    'medium' => 'Medium',
	                    'large' => 'Large',
	                    'custom' => 'Custom'
	                ),
	        	   "std" => 'post-thumbnail'),
	        	
	        array( "name" => __("Featured Images Width", TEXTDOMAIN),
	        	   "desc" => __("Specific the featured images width, <strong>if you have selected custom size on option above.</strong>", TEXTDOMAIN),
	        	   "id" => $shortname."_blog_image_width",
	        	   "type" => "text",
	        	   "std" => ''),
	        	
	        array( "name" => __("Featured Images Height", TEXTDOMAIN),
	        	   "desc" => __("Specific the featured images height, <strong>if you have selected custom size on option above.</strong>", TEXTDOMAIN),
	        	   "id" => $shortname."_blog_image_height",
	        	   "type" => "text",
	        	   "std" => ''),
	        
	        array( "type" => "close")   
	    ),
	    /* =================== END BLOG =================== */    
	    
	                                                      
	    /* =================== FOOTER =================== */
	    "footer" => array(
	        array( "name" => __("Footer", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),   
	         
	        array( "name" => __("Footer Type", TEXTDOMAIN),
	        	   "desc" => __("Select the footer type for the theme", TEXTDOMAIN),
	        	   "id" => $shortname."_footer_type",
	        	   "type" => "select",
	        	   "options" => array(
				   		"big" => __( "Big Footer", TEXTDOMAIN ), 
						"small" => __( "Small Footer", TEXTDOMAIN ), 
						"centered" => __( "Centered Footer", TEXTDOMAIN )
					),
	        	   "std" => "big"),  
	         
	        array( "name" => __("N° Rows", TEXTDOMAIN),
	        	   "desc" => __("Select the number of rows you want to show on <strong>Big Footer</strong>.", TEXTDOMAIN),
	        	   "id" => $shortname."_footer_rows",
	        	   "type" => "slider_control",
	        	   "min" => 1,
	        	   "max" => 10,
	        	   "std" => 2),
	        	
	        array( "name" => __("Footer centered text", TEXTDOMAIN),
	        	   "desc" => __("Enter text used in <strong>centered footer</strong>. It can be HTML.", TEXTDOMAIN),
	        	   "id" => $shortname."_footer_text_centered",
	        	   "type" => "textarea",
	        	   "std" => ""),
	        	
	        array( "name" => __("Footer copyright text Left", TEXTDOMAIN),
	        	   "desc" => __("Enter text used in the left side of the footer. It can be HTML. <strong>NB: not figured on 'centered footer'</strong>", TEXTDOMAIN),
	        	   "id" => $shortname."_copyright_text_left",
	        	   "type" => "textarea",
	        	   "std" => ""),
	        	
	        array( "name" => __("Footer copyright text Right", TEXTDOMAIN),
	        	   "desc" => __("Enter text used in the right side of the footer. It can be HTML. <strong>NB: not figured on 'centered footer'</strong>", TEXTDOMAIN),
	        	   "id" => $shortname."_copyright_text_right",
	        	   "type" => "textarea",
	        	   "std" => ""),
	        	
	        array( "name" => __("Google Analytics Code", TEXTDOMAIN),
	        	   "desc" => __("You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.", TEXTDOMAIN),
	        	   "id" => $shortname."_ga_code",
	        	   "type" => "textarea",
	        	   "std" => ""),
	         
	        array( "type" => "close")   
	    ),           
	    /* =================== END FOOTER =================== */  
	    
	                                                      
	    /* =================== PANEL CONFIGURATION =================== */
	    "panel-configuration" => array(
	        array( "name" => __("Panel configuration", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),   
	         
	        array( "name" => __("Active Portfolio", TEXTDOMAIN),
	        	   "desc" => __("Choose if you want to show the portfolio section. <br>NB: if you hide the portfolio section, the portfolio template hasn't any effect.", TEXTDOMAIN),
	        	   "id" => $shortname."_panel_portfolioshow",
	        	   "type" => "on-off",
	        	   "std" => 1),   
	         
	        array( "name" => __("Active Gallery", TEXTDOMAIN),
	        	   "desc" => __("Choose if you want to show the gallery section. <br>NB: if you hide the gallery section, the gallery template hasn't any effect.", TEXTDOMAIN),
	        	   "id" => $shortname."_panel_galleryshow",
	        	   "type" => "on-off",
	        	   "std" => 1),  
	        
	         
	        array( "type" => "close")   
	    )           
	    /* =================== END FOOTER =================== */
	 
	);                               
	
	return $options;  
}
?>