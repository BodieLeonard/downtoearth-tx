<?php
// items of admin options panel
$submenu_items = array( 
	'general' => __( 'General', TEXTDOMAIN ), 
	'colors' => __( 'Colors', TEXTDOMAIN ),           
	'typography' => __( 'Typography', TEXTDOMAIN ),   
	'jqueryslider' => __( 'jQuery Slider', TEXTDOMAIN ), 
	'flashslider' => __( 'Flash Slider', TEXTDOMAIN ), 
	'sidebars' => __( 'Sidebars', TEXTDOMAIN ), 
	'accordionslider' => __( 'Accordion Sliders', TEXTDOMAIN ),
	'contact' => __( 'Contact Customize', TEXTDOMAIN ),
	'store' => __( 'Store', TEXTDOMAIN ) 
);    
 
// all slider types
$sliders_type = array( 'home' => 'jQuery Slider', 'flash' => 'Flash Slider' );   

// get all categories created on theme
$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array();
foreach ($categories as $category_list ) 
{
    $wp_cats[$category_list->category_nicename] = $category_list->cat_name;
}
array_unshift($wp_cats, __("Choose a category"));  

// number of columns for big footer
$columns_footer = array( 'three' => 'Three Columns', 'four' => 'Four Columns', 'five' => 'Five Columns' );

// effects
$fxs = array(
    'blindX' => 'blindX', 		'blindY' => 'blindY', 		'blindZ' => 'blindZ', 		'cover' => 'cover', 		'curtainX' => 'curtainX',
    'curtainY' => 'curtainY', 	'fade' => 'fade', 			'fadeZoom' => 'fadeZoom', 	'growX' => 'growX', 		'growY' => 'growY',
    'scrollUp' => 'scrollUp', 	'scrollDown' => 'scrollDown','scrollLeft' => 'scrollLeft','scrollRight' => 'scrollRight', 	'scrollHorz' => 'scrollHorz',
    'shuffle' => 'shuffle', 	'slideX' => 'slideX', 		'slideY' => 'slideY', 		'toss' => 'toss', 			'turnUp' => 'turnUp',
    'turnLeft' => 'turnLeft', 	'turnRight' => 'turnRight', 'uncover' => 'uncover', 	'wipe' => 'wipe', 			'zoom' => 'zoom',
    'none' => 'none',			'turnDown' => 'turnDown',	'scrollVert' => 'scrollVert'
);

// nivo slider effect
$nivo_fxs = array(
	'sliceDown' => 'sliceDown',
    'sliceDownLeft' => 'sliceDownLeft',
    'sliceUp' => 'sliceUp',
    'sliceUpLeft' => 'sliceUpLeft',
    'sliceUpDown' => 'sliceUpDown',
    'sliceUpDownLeft' => 'sliceUpDownLeft',
    'fold' => 'fold',
    'fade' => 'fade',
    'random' => 'random',
    'slideInRight' => 'slideInRight',
    'slideInLeft' => 'slideInLeft'
);

// easings
$easings = array(
	FALSE => 'none',
	'easeInQuad' => 'easeInQuad',
	'easeOutQuad' => 'easeOutQuad',
	'easeInOutQuad' => 'easeInOutQuad',
	'easeInCubic' => 'easeInCubic',
	'easeOutCubic' => 'easeOutCubic',
	'easeInOutCubic' => 'easeInOutCubic',
	'easeInQuart' => 'easeInQuart',
	'easeOutQuart' => 'easeOutQuart',
	'easeInOutQuart' => 'easeInOutQuart',
	'easeInQuint' => 'easeInQuint',
	'easeOutQuint' => 'easeOutQuint',
	'easeInOutQuint' => 'easeInOutQuint',
	'easeInSine' => 'easeInSine',
	'easeOutSine' => 'easeOutSine',
	'easeInOutSine' => 'easeInOutSine',
	'easeInExpo' => 'easeInExpo',
	'easeOutExpo' => 'easeOutExpo',
	'easeInOutExpo' => 'easeInOutExpo',
	'easeInCirc' => 'easeInCirc',
	'easeOutCirc' => 'easeOutCirc',
	'easeInOutCirc' => 'easeInOutCirc',
	'easeInElastic' => 'easeInElastic',
	'easeOutElastic' => 'easeOutElastic',
	'easeInOutElastic' => 'easeInOutElastic',
	'easeInBack' => 'easeInBack',
	'easeOutBack' => 'easeOutBack',
	'easeInOutBack' => 'easeInOutBack',
	'easeInBounce' => 'easeInBounce',
	'easeOutBounce' => 'easeOutBounce',
	'easeInOutBounce' => 'easeInOutBounce'
);
?>
