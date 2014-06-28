<?php    
                         
function flashslider_panel()
{
	yiw_admin( flashslider_panel_array() );
}  

function flashslider_panel_array()
{
	global $shortname, $themename;
	
	$namesection = 'flashslider';
	
	$options = array (            
	    "title" => array(    
	        array( 	"name" => __('Flash Slider Manager', TEXTDOMAIN),
	        	   	"type" => "title")
	    ),            
	    
	    "transitions" => array(
	        array( "name" => __("Transitions", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),  
			
			array( 	"name" => __( 'Pieces', TEXTDOMAIN ),
					"desc" => __( 'Number of pieces to which the image is sliced', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_Pieces",
					"type" => "slider_control",
					"min" => 0,
					"max" => 40,
					"std" => 9),
			
			array( 	"name" => __( 'Time', TEXTDOMAIN ),
					"desc" => __( 'Time for one cube to turn', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_Time",
					"type" => "slider_control",
					"min" => 0,
					"max" => 30,
					"step" => 0.1,
					"label" => "s",
					"std" => 1.2),
			
			array( 	"name" => __( 'Transition', TEXTDOMAIN ),
					"desc" => __( 'Transition type of the Tweener class', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_Transition",
					"type" => "select",
					"options" => $GLOBALS['easings'],
					"std" => "easeInOutBack"),    
			
			array( 	"name" => __( 'Depth Offset', TEXTDOMAIN ),
					"desc" => __( 'The offset during transition on the z-axis. Value between 100 and 1000 are recommended.', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_DepthOffset",
					"type" => "slider_control",
					"min" => 100,
					"max" => 1000,
					"step" => 50,
					"std" => 300), 
			
			array( 	"name" => __( 'Cube Distance', TEXTDOMAIN ),
					"desc" => __( 'The distance between the cubes during transition. Values between 5 and 50 are recommended.', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_CubeDistance",
					"type" => "slider_control",
					"min" => 5,
					"max" => 50,
					"std" => 30),
	        	
	        array( "type" => "close")
		),
	    
	    "general" => array(
	        array( "name" => __("General Configuration", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),  
			
			array( 	"name" => __( 'Loader Color', TEXTDOMAIN ),
					"desc" => __( 'Color of the cubes before the first image appears, also the color of the back sides of the cube, which become visible at some transition types', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_LoaderColor",
					"type" => "color-picker",
					"std" => "#333333"),
			
			array( 	"name" => __( 'Inner Side Color', TEXTDOMAIN ),
					"desc" => __( 'Color of the inner sides of the cube when sliced', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_InnerSideColor",
					"type" => "color-picker",
					"std" => "#222222"),    
			
			array( 	"name" => __( 'Autoplay', TEXTDOMAIN ),
					"desc" => __( 'Number of seconds from one transition to another, if not stopped. Set to 0 to disable autoplay', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_Autoplay",
					"type" => "slider_control",
					"min" => 0,
					"max" => 120,
					"label" => "s",
					"std" => 10),
	        	
	        array( "type" => "close")
		),
	    
	    "shadow" => array(
	        array( "name" => __("Shadow", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),  
			
			array( 	"name" => __( 'Side Shadow Alpha', TEXTDOMAIN ),
					"desc" => __( 'Sides get darker when moved away from the front. This is the degree of darkness - 0 == no change, 1 == 100% black.', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_SideShadowAlpha",
					"type" => "slider_control",
					"min" => 0,
					"max" => 1,
					"step" => 0.1,
					"std" => 0.8),
			
			array( 	"name" => __( 'Drop Shadow Alpha', TEXTDOMAIN ),
					"desc" => __( 'Alpha of the drop shadow - 0 == no shadow, 1 == opaque', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_DropShadowAlpha",
					"type" => "slider_control",
					"min" => 0,
					"max" => 1,
					"step" => 0.1,
					"std" => 0.7),
			
			array( 	"name" => __( 'Drop Shadow Distance', TEXTDOMAIN ),
					"desc" => __( 'Distance of the shadow from the bottom of the image', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_DropShadowDistance",
					"type" => "slider_control",
					"min" => 0,
					"max" => 100,
					"std" => 25),     
			
			array( 	"name" => __( 'Drop Shadow Scale', TEXTDOMAIN ),
					"desc" => __( 'As the shadow is blurred, it appears wider that the actual image, when not resized. Thus it\'s a good idea to make it slightly smaller. - 1 would be no resizing at all.', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_DropShadowScale",
					"type" => "slider_control",
					"min" => 0,
					"max" => 1,
					"step" => 0.05,
					"std" => 0.95),
			
			array( 	"name" => __( 'Drop Shadow Blur X', TEXTDOMAIN ),
					"desc" => __( 'Blur of the drop shadow on the x-axis', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_DropShadowBlurX",
					"type" => "slider_control",
					"min" => 0,
					"max" => 200,
					"std" => 40),
			
			array( 	"name" => __( 'Drop Shadow Blur Y', TEXTDOMAIN ),
					"desc" => __( 'Blur of the drop shadow on the y-axis', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_DropShadowBlurY",
					"type" => "slider_control",
					"min" => 0,
					"max" => 200,
					"std" => 4),
	        	
	        array( "type" => "close")
		),     
	    
	    "menu" => array(
	        array( "name" => __("Menu", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),   
			
			array( 	"name" => __( 'Menu Distance X', TEXTDOMAIN ),
					"desc" => __( 'Distance between two menu items (from center to center).', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_MenuDistanceX",
					"type" => "slider_control",
					"min" => 0,
					"max" => 400,
					"std" => 20),
			
			array( 	"name" => __( 'Menu Distance Y', TEXTDOMAIN ),
					"desc" => __( 'Distance of the menu from the bottom of the image.', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_MenuDistanceY",
					"type" => "slider_control",
					"min" => 0,
					"max" => 400,
					"std" => 50),      
			
			array( 	"name" => __( 'Menu Color Inactive Item', TEXTDOMAIN ),
					"desc" => __( 'Color of an inactive menu item.', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_MenuColor1",
					"type" => "color-picker",
					"std" => "#999999"),
			
			array( 	"name" => __( 'Menu Color Active Item', TEXTDOMAIN ),
					"desc" => __( 'Color of an active menu item.', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_MenuColor2",
					"type" => "color-picker",
					"std" => "#333333"),
			
			array( 	"name" => __( 'Menu Color Inner Circle od Active Item', TEXTDOMAIN ),
					"desc" => __( 'Color of the inner circle of an active menu item. Should equal the background color of the whole thing.', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_MenuColor3",
					"type" => "color-picker",
					"std" => "#FFFFFF"),
	        	
	        array( "type" => "close")
		),
	    
	    "control" => array(
	        array( "name" => __("Controls", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),     
			
			array( 	"name" => __( 'Control Size', TEXTDOMAIN ),
					"desc" => __( 'Size of the controls, which appear on rollover (play, stop, info, link)', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_ControlSize",
					"type" => "slider_control",
					"min" => 0,
					"max" => 400,
					"step" => 10,
					"std" => 100),  
			
			array( 	"name" => __( 'Control Distance', TEXTDOMAIN ),
					"desc" => __( 'Distance between the controls (from the borders).', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_ControlDistance",
					"type" => "slider_control",
					"min" => 0,
					"max" => 100,
					"std" => 20),         
			
			array( 	"name" => __( 'Bg Color', TEXTDOMAIN ),
					"desc" => __( 'Background color of the controls', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_ControlColor1",
					"type" => "color-picker",
					"std" => "#222222"),  
			
			array( 	"name" => __( 'Font Color', TEXTDOMAIN ),
					"desc" => __( 'Font color of the controls', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_ControlColor2",
					"type" => "color-picker",
					"std" => "#FFFFFF"),
			
			array( 	"name" => __( 'Control Alpha', TEXTDOMAIN ),
					"desc" => __( 'Alpha of a control, when mouse is not over', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_ControlAlpha",
					"type" => "slider_control",
					"min" => 0,
					"max" => 1,
					"step" => 0.05,
					"std" => 0.8),
			
			array( 	"name" => __( 'Control Alpha Hover status', TEXTDOMAIN ),
					"desc" => __( 'Alpha of a control, when mouse is hover.', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_ControlAlphaOver",
					"type" => "slider_control",
					"min" => 0,
					"max" => 1,
					"step" => 0.05,
					"std" => 0.95),
			
			array( 	"name" => __( 'Control X', TEXTDOMAIN ),
					"desc" => __( 'X-position of the point, which aligns the controls (measured from [0,0] of the image)', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_ControlsX",
					"type" => "slider_control",
					"min" => 0,
					"max" => 960,
					"step" => 10,
					"std" => 450),
			
			array( 	"name" => __( 'Control Y', TEXTDOMAIN ),
					"desc" => __( 'Y-position of the point, which aligns the controls (measured from [0,0] of the image)', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_ControlsY",
					"type" => "slider_control",
					"min" => 0,
					"max" => 350,
					"step" => 10,
					"std" => 280),
			
			array( 	"name" => __( 'Controls Align', TEXTDOMAIN ),
					"desc" => __( 'Type of alignment from the point [controlsX, controlsY]', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_ControlsAlign",
					"type" => "select",
					"options" => array( 
						'center' => __( 'center', TEXTDOMAIN ),
						'left' => __( 'left', TEXTDOMAIN ),
						'right' => __( 'right', TEXTDOMAIN ), 
					),
					"std" => 'center'),
	        	
	        array( "type" => "close")
		),
	    
	    "tooltip" => array(
	        array( "name" => __("Tooltip", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),    
			
			array( 	"name" => __( 'Tooltip Height', TEXTDOMAIN ),
					"desc" => __( 'Height of the tooltip surface in the menu', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_TooltipHeight",
					"type" => "slider_control",
					"min" => 0,
					"max" => 200,
					"std" => 30),  
			
			array( 	"name" => __( 'Tooltip Color', TEXTDOMAIN ),
					"desc" => __( 'Color of the tooltip surface in the menu', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_TooltipColor",
					"type" => "color-picker",
					"std" => "#222222"),  
			
			array( 	"name" => __( 'Tooltip Text Y', TEXTDOMAIN ),
					"desc" => __( 'Y-distance of the tooltip text field from the top of the tooltip', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_TooltipTextY",
					"type" => "slider_control",
					"min" => 0,
					"max" => 200,
					"std" => 5),          
			
			array( 	"name" => __( 'Tooltip Text Color', TEXTDOMAIN ),
					"desc" => __( 'Color of the tooltip text', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_TooltipTextColor",
					"type" => "color-picker",
					"std" => "#FFFFFF"),     
			
			array( 	"name" => __( 'Tooltip Margin Left', TEXTDOMAIN ),
					"desc" => __( 'Margin of the text to the left end of the tooltip', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_TooltipMarginLeft",
					"type" => "slider_control",
					"min" => 0,
					"max" => 50,
					"std" => 5),      
			
			array( 	"name" => __( 'Tooltip Margin Right', TEXTDOMAIN ),
					"desc" => __( 'Margin of the text to the right end of the tooltip', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_TooltipMarginRight",
					"type" => "slider_control",
					"min" => 0,
					"max" => 50,
					"std" => 7),       
			
			array( 	"name" => __( 'Tooltip Text Sharpness', TEXTDOMAIN ),
					"desc" => __( 'Sharpness of the tooltip text (-400 to 400)', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_TooltipTextSharpness",
					"type" => "slider_control",
					"min" => -400,
					"max" => 400,   
					"step" => 10,
					"std" => 50),      
			
			array( 	"name" => __( 'Tooltip Text Thickness', TEXTDOMAIN ),
					"desc" => __( 'Thickness of the tooltip text (-400 to 400)', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_TooltipTextThickness",
					"type" => "slider_control",
					"min" => -400,
					"max" => 400,    
					"step" => 10,
					"std" => -100),       
	        	
	        array( "type" => "close")
		),
	    
	    "info" => array(
	        array( "name" => __("Info Box", TEXTDOMAIN),
	        	   "type" => "section"),
	        array( "type" => "open"),    
			
			array( 	"name" => __( 'Info Width', TEXTDOMAIN ),
					"desc" => __( 'The width of the info text field', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_InfoWidth",
					"type" => "slider_control",
					"min" => 0,
					"max" => 960,
					"step" => 20,
					"std" => 400), 
			
			array( 	"name" => __( 'Info Background', TEXTDOMAIN ),
					"desc" => __( 'The background color of the info text field', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_InfoBackground",
					"type" => "color-picker",
					"std" => "#FFFFFF"),    
			
			array( 	"name" => __( 'Info Background Alpha', TEXTDOMAIN ),
					"desc" => __( 'The alpha of the background of the info text, the image shines through, when smaller than 1', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_InfoBackgroundAlpha",
					"type" => "slider_control",
					"min" => 0,
					"max" => 1,
					"step" => 0.05,
					"std" => 0.95),         
			
			array( 	"name" => __( 'Info Margin', TEXTDOMAIN ),
					"desc" => __( 'The margin of the text field in the info section to all sides', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_InfoMargin",
					"type" => "slider_control",
					"min" => 0,
					"max" => 100,
					"std" => 15),       
			
			array( 	"name" => __( 'Info Text Sharpness', TEXTDOMAIN ),
					"desc" => __( 'Sharpness of the Info text (-400 to 400)', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_InfoTextSharpness",
					"type" => "slider_control",
					"min" => -400,
					"max" => 400, 
					"step" => 10,
					"std" => 0),      
			
			array( 	"name" => __( 'Info Text Thickness', TEXTDOMAIN ),
					"desc" => __( 'Thickness of the Info text (-400 to 400)', TEXTDOMAIN ),
					"id" => $shortname."_{$namesection}_InfoTextThickness",
					"type" => "slider_control",
					"min" => -400,
					"max" => 400,
					"step" => 10,
					"std" => 0),      
	        	
	        array( "type" => "close")
		),     
		        
	    "slides" => array(    
	        array( "name" => __("Slides", TEXTDOMAIN),
	        	   "type" => "section",
	        	   "valueButton" => __("Add/Edit Slide", TEXTDOMAIN),
				   "effect" => 0),
	        array( "type" => "open"),  
	         
	        array( "id" => $shortname."_{$namesection}_slides",
	        	   "noreset" => true,
	        	   "data" => "array",
	        	   "type" => "slides-table",
				   "config" => "title, image, caption, link",
				   "max-height" => 350 ),	
	        	
	        array( "type" => "close")
	    ),    
	 
	);         
	
	return $options;         
}
?>