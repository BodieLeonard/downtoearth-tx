<?php
/**
 * @package WordPress
 * @subpackage Kassyopea
 */     

/* allow shortcodes in sidebar widgets */
add_filter('widget_text', 'do_shortcode');


/** 
 * CALL TO ACTION 
 * 
 * @description
 *    Shows a box with an incipit and a number phone   
 * 
 * @example
 *   [call title="" incipit="" phone="" [class=""]]
 * 
 * @attr  
 *   class - class of container of box call to action (optional) @default: 'call-to-action'
 *   href  - url of button
 *   title  - the title of call to action
 *   incipit - the text below title  
**/
function call_func($atts, $content = null) 
{
    extract(shortcode_atts(array(
        'class' => 'call-to-action',
        'title' => null,
        'incipit' => null,
        'phone' => null
    ), $atts));        
	
	$style = '';
	if( is_null( $incipit ) )
		$style = ' style="margin-top:0;line-height:101px;"';
	else
		$incipit = "<p>$incipit</p>";
    
    $html = "<div class=\"$class\">
				<div class=\"incipit\">
					<h2{$style}>$title</h2>
					$incipit
				</div>
				<div class=\"separate-phone\"></div>
				<div class=\"number-phone\">$phone</div>
				<div class=\"clear\"></div>
				<div class=\"decoration-image\"></div>
			</div>";   
    
    return apply_filters( 'yiw_call_shortcode', $html );
}
add_shortcode('call', 'call_func');


/** 
 * BOX SECTION                    
 * 
 * @description
 *    Shows a box, with Title and icons on left and a text of section (you can use HTMl tags)  
 * 
 * @example
 *   [section icon="" [size=""] title="" [class=""] [last=""] [border=""]]text[/section]
 * 
 * @attr  
 *   class - class of container of box (optional) @default: 'box-sections'
 *   icon  - one of set already been in $icons_name array
 *   size  - icons size (32 or 48) (optional) @default: 48 
 *   last  - specifics if this section is the last element (optional) @default: false 
 *   title - the title
 *   text  - text of the section
 *   border  - add border class
**/
function section_func($atts, $content = null) 
{
    extract(shortcode_atts(array(
        'class' => 'box-sections',
        'before_title' => '<h2>',
        'title' => null,          
        'after_title' => '</h2>',
        'icon' => null,
        'size' => 32,
        'last' => false,
        'border' => false
    ), $atts));
    
    $img = '';
    if(!is_null($icon)) $img = "<img src=\"".get_url_icon($icon, $size)."\" alt=\"$title\" class=\"icon\" />";   
    
    $last_class = '';
    if($last) $last_class = ' last';
    
    if( $border )
    	$class .= '-border';
    
    $html = "\n";
    $html .= "<div class=\"$class{$last_class}\">\n";
    $html .= "    $img\n";
    $html .= "    {$before_title}{$title}{$after_title}"; 
    $html .= "    ".do_shortcode($content)."\n";
    $html .= "</div>\n";    
    
    return apply_filters( 'yiw_section_shortcode', $html );
}
add_shortcode('section', 'section_func');


/** 
 * BOX SECTION TEXT                   
 * 
 * @description
 *    This is the same of above, but for only text.
**/
function section_text_func($atts, $content = null) 
{
    extract(shortcode_atts(array(
        'class' => 'box-sections',
        'title' => null,
        'icon' => null,
        'size' => 32,
        'last' => false
    ), $atts));  
    
    $html = do_shortcode("[section icon=\"$icon\" size=\"$size\" title=\"$title\" class=\"$class\" last=\"$last\"]<p>$content</p>[/section]");
	
	return apply_filters( 'yiw_section_text_shortcode', $html );
}
add_shortcode('section_text', 'section_text_func');


/** 
 * SECTION CAPTION                   
 * 
 * @description
 *    Show a box with a captions
 * 
 * @example
 * 	  [section_caption title=""]
 * 	  
 *         [caption_text title=""]text[/caption_text]
 *         [caption_text title=""]text[/caption_text]
 *         [caption_text title=""]text[/caption_text]
 *   
 * 	  [/section_caption] 	               
 * 
 * @attr  
 *   title (section_caption) - the title of section captions
 *   title (caption) - the title of single caption
 *   text  - the text of single caption 
**/
function section_caption_func($atts, $content = null) 
{
    extract(shortcode_atts(array(
        'title' => null
    ), $atts));                                    
    
    $html  = '<div class="section-caption">'."\n";
    
    $html .= "    <h5>$title</h5>\n";
    $html .= "    <div class=\"captions\">\n";
    $html .= "    ".do_shortcode($content)."\n";
    $html .= "    </div>\n";
    
    $html .= do_shortcode('[clear]');
    
    $html .= '</div>'."\n";
    
    return apply_filters( 'yiw_section_caption_shortcode', $html );
}
add_shortcode('section_caption', 'section_caption_func');


/** 
 * CAPTION                   
 * 
 * @description
 *    This is linked to above. Read that description
**/
function caption_text_func($atts, $content = null) 
{
    extract(shortcode_atts(array(
        'title' => null
    ), $atts));                                     
    
    $content = apply_filters('the_content', $content);     
    
    $html  = "<div class=\"caption\">\n";
    $html .= "    <h6 class=\"red-normal\">$title</h6>\n";
    $html .= "    $content\n";
    $html .= "</div>\n";
    
    return apply_filters( 'yiw_caption_text_shortcode', $html );
}
add_shortcode('caption_text', 'caption_text_func');


/** 
 * LAST POST BOX            
 * 
 * @description
 *    Shows last post of a specific category 
 * 
 * @example
 *   [lastpost icon="" [size=""] title="" [class=""] [cat_name=""] [more_text=""] [showdate="yes|no"] [showtitle="yes|no"] [last=""]]
 * 
 * @attr  
 *   class - class of container of box (optional) @default: 'box-sections'
 *   icon  - one of set already been in $icons_name array
 *   size  - icons size (32 or 48) (optional) @default: 48 
 *   title - the title
 *   cat_name - NAME category of last post to show (optional) @deafult: all categories
 *   more_text  - text of more link  @deafult: null
 *   showdate - if show the date of post (optional) @deafult: yes
 *   showtitle - if show the title of post (optional) @deafult: yes            
 *   last  - specifics if this section is the last element (optional) @default: false 
**/
function lastpost_func($atts, $content = null) 
{
    extract(shortcode_atts(array(
        'class' => 'box-sections',
        'title' => null,
        'icon'  => null,
        'size'  => 48,
        'cat_name'   => null,
        'more_text'  => null,
        'showdate' => 'no',
        'showtitle' => 'yes',
        'last' => false
    ), $atts));     
	
	global $wp_query;
	
	$tmp_query = $wp_query;     
    
    $args = array(
       'post_type'=>'post',
       'category_name' => $cat_name,
       'showposts' => 1
    );
    
    $posts = new WP_Query();
    $posts->query($args);
    
    $date = TRUE;
    if($showdate == 'no') $date = FALSE;
    $title_ = TRUE;
    if($showtitle == 'no') $title_ = FALSE; 
                    
    $last_class = '';
    if($last) $last_class = ' last';
                    
    $html = "\n";
    while($posts->have_posts()) :    
        $posts->the_post();           
        
        global $more;
        $more = 0;

        $img = '';
        if(!is_null($icon)) $img = "<img src=\"".get_url_icon($icon, $size)."\" alt=\"$title\" class=\"icon\" />";
        
        $html .= "<div class=\"$class{$last_class}\">\n";
        $html .= "    $img\n";
        $html .= "    <h2>$title</h2>\n"; 
        if($title_)
        {
            $html .= "    <div class=\"clear\"></div>";
            $html .= "    <h4 class=\"title-widget-blog\"><a href=\"".get_permalink()."\">".get_the_title()."</a></h4>\n";
        }
        if($date)
        {                                        
            $html .= "    <div class=\"clear\"></div>";
            $html .= "    <p>".the_date('F jS, Y', '<small>', '</small>', FALSE)."</p>\n";
        }                                  
        
        $content = get_the_content($more_text);            
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        
        $html .= "    $content\n";
        $html .= "</div>\n";    
    endwhile;
    
    $wp_query = $tmp_query;
    
    wp_reset_postdata();
    
    return apply_filters( 'yiw_lastpost_shortcode', $html );
}
add_shortcode('lastpost', 'lastpost_func');


/** 
 * RECENT POST            
 * 
 * @description
 *    Shows recent posts
 * 
 * @example
 *   [recentpost items="" [cat_name=""] [more_text=""]]
 * 
 * @attr  
 *   cat_name - NAME category of last post to show (optional) @deafult: all categories
 *   more_text  - text of more link (optional)  @deafult: null
 *   items - number of items to show @default: 3 
**/
function recentpost_func($atts, $content = null) 
{
    extract(shortcode_atts(array(
        'cat_name'   => null,
        'more_text'  => null,
        'items' => 3,
		'popular' => false                           
    ), $atts));
    
    global $icons_name,$wp_query;
	
	$tmp_query = $wp_query;     
    
    $args = array(
       'posts_per_page' => $items,
       'orderby' => 'date',
       'order' => 'DESC'
    );                            
    
    if(!is_null($cat_name)) $args['category_name'] = $cat_name;
    if( $popular ) $args['orderby'] = 'comment_count';
    
    $args['order'] = 'DESC'; 
    
    $myposts = new WP_Query( $args );    
                    
    $html = "\n";       
    $html .= '<div class="recent-post">'."\n"; 
    if( $myposts->have_posts() ) : while( $myposts->have_posts() ) : $myposts->the_post();  
         
        $img = '';
        if(has_post_thumbnail())
        {
            $img = get_the_post_thumbnail( get_the_ID(), 'thumb-recentposts' );
        }
        else
        {
            $img = '<img src="'.get_bloginfo('template_url').'/images/no_image_recentposts.jpg" alt="No Image" />';
        }
              
        $html .= '<div class="link">'."\n";                         
        $html .= "    <div class=\"thumb-img\">$img<div class=\"thumb-shadow\"></div></div>\n"; 
        $html .= the_title( '<p>', ' ', false );
        $html .= '<a href="'.get_permalink().'" title="'.get_the_title().'">'.$more_text.'</a><br />';
        $html .= '<small>'.get_the_date( get_option( 'bl_date_format' ) ).'</small></p>';
        $html .= "\n<div class=\"clear\"></div>\n</div>\n";
    
    endwhile; endif; 
    
    $wp_query = $tmp_query;
    
    wp_reset_postdata();
    
    $html .= '</div>';
    
    //$myposts->rewind_posts();
    
    //unset($myposts);   
    
    return apply_filters( 'yiw_recentpost_shortcode', $html );
}
add_shortcode('recentpost', 'recentpost_func');


/** 
 * POPULAR POST            
 * 
 * @description
 *    Shows popular posts
 * 
 * @example
 *   [popularpost items="" [cat_name=""] [more_text=""]]
 * 
 * @attr  
 *   cat_name - NAME category of last post to show (optional) @deafult: all categories
 *   more_text  - text of more link (optional)  @deafult: null
 *   items - number of items to show @default: 3 
**/
function popularpost_func($atts, $content = null) 
{                           
    extract(shortcode_atts(array(
        'cat_name'   => null,
        'more_text'  => null,
        'items' => null                          
    ), $atts));
    
    $html = do_shortcode('[recentpost items="' . $items . '" cat_name="' . $cat_name . '" more_text="' . $more_text . '" popular="1"]');

	return apply_filters( 'yiw_popularpost_shortcode', $html );
}
add_shortcode('popularpost', 'popularpost_func');


/** 
 * LAST IMAGE ATTACHED TO A POST      
 * 
 * @description
 *    Gets the latest image attached to a post.   
 * 
 * @example
 *   [postimage size="" float="left"]
 * 
 * @attr  
 *   size   - size of image (ex. thumbnail)
 *   float  - floating of image
**/
function sc_postimage($atts, $content = null) {
	extract(shortcode_atts(array(
		"size" => 'thumbnail',
		"float" => 'none'
	), $atts));
	$images =& get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . get_the_id() );
	foreach( $images as $imageID => $imagePost )
	$fullimage = wp_get_attachment_image($imageID, $size, false);
	$imagedata = wp_get_attachment_image_src($imageID, $size, false);
	$width = ($imagedata[1]+2);
	$height = ($imagedata[2]+2);
	
	$html = '<div class="postimage" style="width: '.$width.'px; height: '.$height.'px; float: '.$float.';">'.$fullimage.'</div>';

	return apply_filters( 'yiw_postimage_shortcode', $html );
}
add_shortcode("postimage", "sc_postimage");


/** 
 * SOCIAL     
 * 
 * @description
 *    Print a simple icon link for social     
 * 
 * @example
 *   [social type="" href="" [title=""] [target=""]]
 * 
 * @attr  
 *   type - the icon of social @params: facebook|twitter|rss|ecc...
 *   title - a title for the link icon 
 *   href - the url of social page
 *   target - the attribute 'target' for <a> tag  
**/
function social_func($atts, $content = null) {
	extract(shortcode_atts(array(
		"type" => '',
		"title" => null,
		"href" => '#',
		"size" => '',
		'target' => ''
	), $atts));
	
	if ( $size != 'small' )
		$size = '';
	
	if ( $size != '' ) 
		$size = '-' . $size;
	
	if ( $target != '' )
		$target = ' target="' . $target . '"';
    
    if( is_null($title) ) $title = ucfirst($type);
	$html = "<a href=\"".esc_url($href)."\" class=\"socials{$size} {$type}{$size}\" title=\"$title\"{$target}>$type</a>\n";
	
	return apply_filters( 'yiw_social_shortcode', $html );
}
add_shortcode("social", "social_func");


/** 
 * TWITTER     
 * 
 * @description
 *    Print a list of last tweets     
 * 
 * @example
 *   [twitter username="YIW" items="5" [class="last-tweets-widget"] [time="true"] [replies="true"] ]
 * 
 * @attr  
 *   usarname - the username
 *   items - number of post for list 
**/
function twitter_func($atts, $content = null) {
	extract(shortcode_atts(array(
		"username" => null,
		"items" => 5,
		"class" => 'last-tweets-widget',
		"time" => true,
		"replies" => true
	), $atts));
    
    $html = '<div class="last-tweets-widget"></div>';
    $html .= "<script type=\"text/javascript\">
				jQuery(function($){
					$('.$class').tweetable({
						id: 'tweets',
						username: '$username', 
						time: true, 
						limit: $items, 
						replies: true
					});
				});
				</script> ";
    
	return apply_filters( 'yiw_twitter_shortcode', $html );
}
add_shortcode("twitter", "twitter_func");


/** 
 * SLIDER     
 * 
 * @description
 *    Show a custom Nivo Slider     
 * 
 * @example
 *   [slider effect="sliceDown" width="600" height="350"]
 *       wp-content/themes/bolder/example/slide/1.jpg
 *       wp-content/themes/bolder/example/slide/2.jpg
 *       wp-content/themes/bolder/example/slide/3.jpg
 *       wp-content/themes/bolder/example/slide/4.jpg
 *       wp-content/themes/bolder/example/slide/5.jpg
 *   [/slider]
 * 
 * @attr  
 *   effect - the effetc of slider. @param:     
        * sliceDown
        * sliceDownLeft
        * sliceUp
        * sliceUpLeft
        * sliceUpDown
        * sliceUpDownLeft
        * fold
        * fade
        * random
 *   width - the width of slider
 *   height - height of slider  
**/
function slider_func($atts, $content = null) {
	extract(shortcode_atts(array(
		"effect" => 'fade',
		"width" => 600,
		"height" => 350,
		"timeout" => 3
	), $atts));
    
    $urls = explode("\n", $content);
    $urls = array_map('trim', $urls);
    
    $html = "<div class=\"nivo-slider\" style=\"width:{$width}px; height:{$height}px\">\n";
    
    $i = 0;
    foreach($urls as $url)
    {
        $host = '';
        $url = str_replace( '<br />', '', $url );
        if( !preg_match('/http:\/\/(.*)/', $url) ) $host = get_bloginfo('url') . '/';
        
        if($url != '') $html .= "    <img src=\"{$host}{$url}\" alt=\"$i\" />\n";
        $i++;
    }
    
    $timeout *= 1000;
    
    $html .= "</div>\n";
    
    $html .= "  <script type=\"text/javascript\">
                    jQuery(document).ready(function($){
                        $('.nivo-slider').nivoSlider({
                            effect: '$effect',
                            directionNav:false,
                            pauseTime: $timeout 
                        });
                    });
                </script>";
    
	return apply_filters( 'yiw_slider_shortcode', $html );
}
add_shortcode("slider", "slider_func");


/** 
 * PRINT CLEAR     
 * 
 * @description
 *    Print a clear, to undo the floating   
 * 
 * @example
 *   [clear]
**/
function clear_func($atts, $content = null) {
	return '<div class="clear"></div>';
}
add_shortcode("clear", "clear_func");


/** 
 * PRINT SPACE     
 * 
 * @description
 *    Print a clear, to undo the floating   
 * 
 * @example
 *   [space]
**/
function space_func($atts, $content = null) {
	return '<div class="clear space"></div>';
}
add_shortcode("space", "space_func");


/** 
 * PRINT BORDER     
 * 
 * @description
 *    Print a clear, to undo the floating   
 * 
 * @example
 *   [border]
**/
function border_func($atts, $content = null) {
	return '<div class="clear border"></div>';
}
add_shortcode("border", "border_func");



/* ================================ TYPOGRAPHY ============================== */  


/** 
 * DROPCAP     
 * 
 * @description
 *    Format content, with big first letter     
 * 
 * @example
 *   [dropcap]text[/dropcap]
 * 
 * @attr  
 *   text - the text
**/
function dropcap_func($atts, $content = null) {
	return "<p class=\"dropcap\">".do_shortcode($content)."</p>";
}
add_shortcode("dropcap", "dropcap_func");


/** 
 * QUOTE     
 * 
 * @description
 *    Adds the content into a box quote    
 * 
 * @example
 *   [quote]text[/quote]
 * 
 * @attr  
 *   text - the text
**/
function quote_func($atts, $content = null) {
	return "<blockquote><p>".do_shortcode($content)."</p></blockquote>";
}
add_shortcode("quote", "quote_func");


/** 
 * HIGHLIGHT     
 * 
 * @description
 *    Text highlight    
 * 
 * @example
 *   [highlight]text[/highlight]
 * 
 * @attr  
 *   text - the text
**/
function highlight_func($atts, $content = null) {
	return "<span class=\"highlight\">".do_shortcode($content)."</span>";
}
add_shortcode("highlight", "highlight_func");                   



/* ================================ ALERT BOX =============================== */    


/** 
 * SUCCESS BOX     
 * 
 * @description
 *    Show an example of success box alert    
 * 
 * @example
 *   [success]text[/success]
 * 
 * @attr  
 *   text - the text
**/
function success_func($atts, $content = null) {
	return "<div class=\"box success-box\">".do_shortcode($content)."</div>";
}
add_shortcode("success", "success_func");    


/** 
 * ARROW BOX     
 * 
 * @description
 *    Show an example of box alert, with an arrow icon    
 * 
 * @example
 *   [arrow]text[/arrow]
 * 
 * @attr  
 *   text - the text
**/
function arrow_func($atts, $content = null) {
	return "<div class=\"box arrow-box\">".do_shortcode($content)."</div>";
}
add_shortcode("arrow", "arrow_func");    


/** 
 * ALERT BOX     
 * 
 * @description
 *    Show an alert box    
 * 
 * @example
 *   [alert]text[/alert]
 * 
 * @attr  
 *   text - the text
**/
function alert_func($atts, $content = null) {
	return "<div class=\"box alert-box\">".do_shortcode($content)."</div>";
}
add_shortcode("alert", "alert_func");    


/** 
 * ERROR BOX     
 * 
 * @description
 *    Show an error box    
 * 
 * @example
 *   [error]text[/error]
 * 
 * @attr  
 *   text - the text
**/
function error_func($atts, $content = null) {
	return "<div class=\"box error-box\">".do_shortcode($content)."</div>";
}
add_shortcode("error", "error_func");    


/** 
 * NOTICE BOX     
 * 
 * @description
 *    Show an notice box    
 * 
 * @example
 *   [notice]text[/notice]
 * 
 * @attr  
 *   text - the text
**/
function notice_func($atts, $content = null) {
	return "<div class=\"box notice-box\">".do_shortcode($content)."</div>";
}
add_shortcode("notice", "notice_func");    


/** 
 * INFO BOX     
 * 
 * @description
 *    Show an info box    
 * 
 * @example
 *   [info]text[/info]
 * 
 * @attr  
 *   text - the text
**/
function info_func($atts, $content = null) {
	return "<div class=\"box info-box\">".do_shortcode($content)."</div>";
}
add_shortcode("info", "info_func");                     



/* ================================ BUTTONS ================================= */    


/** 
 * BUTTON     
 * 
 * @description
 *    Show a simple custom button    
 * 
 * @example
 *   [button href="" color="green|blue|magenta|red|orange|yellow" width="large|small"]your text[/button]
 * 
 * @attr  
 *   href - the url of linking 
 *   color - background color of button
 *   width - the size of button    
 *   text - the text
**/
function button_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"color" => '',
		"width" => 'large',
		"href" => "#",
		'target' => '_self'
	), $atts));
	
	$html = "<a href=\"$href\" class=\"$width $color button\" target=\"$target\">$content</a>";
	
	return apply_filters( 'yiw_button_shortcode', $html );
}
add_shortcode("button", "button_func");       


/** 
 * BUTTON ICON     
 * 
 * @description
 *    Show a simple custom button, with icon    
 * 
 * @example
 *   [button_icon href="" icon="" icon_file="" icon_path=""]your text[/button_icon]
 * 
 * @attr  
 *   href - the url of linking 
 *   color - background color of button
 *   width - the size of button    
 *   text - the text
**/
function button_icon_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"icon" => 'arrow',
		"icon_file" => null,
		"icon_path" => FALSE,
		"href" => "#",
		"sense" => "ltr"
	), $atts));
	
	if( $icon_path )
		$path = $icon_path;
	else
		$path = get_template_directory_uri() . '/images/for_button/';
	
	$style = '';
	if( !is_null($icon_file) )
		$style = " style=\"background-image:url('{$path}{$icon_file}')\"";
	
	$html = '';
	//$html .= '<div class="more-button">';
	$html .= "	<a class=\"more-button more-button-$sense\" href=\"$href\" title=\"$content\">$content";
	$html .= "	<span class=\"icon $icon\"$style>&nbsp;</span></a>";
	//$html .= "</div>";
	
	return apply_filters( 'yiw_button_icon_shortcode', $html );
}
add_shortcode("button_icon", "button_icon_func");              



/* =========================== BULLETS LIST ================================= */    


/** 
 * LIST BULLET     
 * 
 * @description
 *    Show a simple custom button    
 * 
 * @example
 *   [list type="star|arrow|check|add|info"]
 *       <li>item</li>
 *       <li>item</li>
 *       <li>item</li>
 *   [/list]
 * 
 * @attr  
 *   color - background color of button
 *   width - the size of button    
 *   text - the text
**/
function list_func($atts, $content = null) {           
	extract(shortcode_atts(array(
		"type" => 'arrow'
	), $atts));
	
	$content = str_replace( '<ul>', '', $content );
	$content = str_replace( '</ul>', '', $content );
	$html = "<ul class=\"short $type\">".do_shortcode($content)."</ul>";
	
	return apply_filters( 'yiw_sc_list_html', $html );
}
add_shortcode("list", "list_func");               



/* =========================== COLUMNS LIST ================================= */    


/** 
 * ONE / FORTH     
 * 
 * @description
 *    Create one column of a quarter.    
 * 
 * @example
 *   [one_fourth [last=""]]text[/one_fourth]
 * 
 * @attr  
 *   last - specifics if this element is the last one and undo the margin right (optional) @deafult: false   
 *   text - the text
**/
function one_fourth_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"last" => false
	), $atts));
	
	$last_class = '';
	if($last) $last_class = ' last';
	return "<div class=\"one-fourth$last_class\">".do_shortcode( $content )."</div>";
}
add_shortcode("one_fourth", "one_fourth_func");  


/** 
 * ONE / FORTH LAST     
 * 
 * @description
 *    Is the same of above, but it's the last element.
**/
function one_fourth_last_func($atts, $content = null) {        	
    return do_shortcode('[one_fourth last="1"]'.$content.'[/one_fourth]');
}
add_shortcode("one_fourth_last", "one_fourth_last_func");  


/** 
 * ONE / THIRD     
 * 
 * @description
 *    Create one column of a third.    
 * 
 * @example
 *   [one_third [last=""]]text[/one_third]
 * 
 * @attr  
 *   last - specifics if this element is the last one and undo the margin right (optional) @deafult: false   
 *   text - the text
**/
function one_third_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"last" => false
	), $atts));
	
	$last_class = '';
	if($last) $last_class = ' last';
	return "<div class=\"one-third$last_class\">".do_shortcode( $content )."</div>";
}
add_shortcode("one_third", "one_third_func");          


/** 
 * ONE / THIRD LAST     
 * 
 * @description
 *    Is the same of above, but it's the last element.
**/
function one_third_last_func($atts, $content = null) {        	
    return do_shortcode('[one_third last="1"]'.$content.'[/one_third]');
}
add_shortcode("one_third_last", "one_third_last_func"); 


/** 
 * TWO / THIRD     
 * 
 * @description
 *    Create a content in two column of a third.    
 * 
 * @example
 *   [two_third [last=""]]text[/two_third]
 * 
 * @attr  
 *   last - specifics if this element is the last one and undo the margin right (optional) @deafult: false   
 *   text - the text
**/
function two_third_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"last" => false
	), $atts));
	
	$last_class = '';
	if($last) $last_class = ' last';
	return "<div class=\"two-third$last_class\">".do_shortcode( $content )."</div>";
}
add_shortcode("two_third", "two_third_func");       


/** 
 * TWO / THIRD LAST     
 * 
 * @description
 *    Is the same of above, but it's the last element.
**/
function two_third_last_func($atts, $content = null) {        	
    return do_shortcode('[two_third last="1"]'.$content.'[/two_third]');
}
add_shortcode("two_third_last", "two_third_last_func");      


/** 
 * TWO / FORTH     
 * 
 * @description
 *    Create a content in two column of a quarter.    
 * 
 * @example
 *   [two_fourth [last=""]]text[/two_fourth]
 * 
 * @attr  
 *   last - specifics if this element is the last one and undo the margin right (optional) @deafult: false   
 *   text - the text
**/
function two_fourth_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"last" => false
	), $atts));
	
	$last_class = '';
	if($last) $last_class = ' last';
	return "<div class=\"two-fourth$last_class\">".do_shortcode( $content )."</div>";
}
add_shortcode("two_fourth", "two_fourth_func");       


/** 
 * TWO / FOURTH LAST     
 * 
 * @description
 *    Is the same of above, but it's the last element.
**/
function two_fourth_last_func($atts, $content = null) {        	
    return do_shortcode('[two_fourth last="1"]'.$content.'[/two_fourth]');
}
add_shortcode("two_fourth_last", "two_fourth_last_func");                 



/* =========================== TOGGLE & TABS ================================ */    


/** 
 * TOGGLE     
 * 
 * @description
 *    Create a toggle content.    
 * 
 * @example
 *   [toggle title="" opened=""]text[/toggle]
 * 
 * @attr  
 *   title - the title of toggle content   
 *   text - the text
**/
function toggle_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"title" => null,
		"opened" => false
	), $atts));
	
	$content = wpautop( do_shortcode( $content ) );
	
	$class = '';
	$title_link = 'Open';
	if( $opened ) {
		$class = ' opened';  
		$title_link = 'Close';
	}
	
	$html = '<div class="toggle">
            	<p class="tab-index tab-opened"><a href="#" title="'.$title_link.'" class="'.$class.'">'.$title.'</a></p>
				<div class="content-tab'.$class.'">
					<div class="arrow">&nbsp;</div>
					<div class="content">'.$content.'</div>
				</div>	
			</div>';
	
	return $html;
}
add_shortcode("toggle", "toggle_func");      


/** 
 * TABS     
 * 
 * @description
 *    Create a content with tabs.    
 * 
 * @example
 *   [tabs {ID}1={TITLE}1 {ID}2={TITLE} ... {ID}n={TITLE}n]
 *       [tab id="{ID}"]Text[/tab]
 *       [tab id="{ID}"]Text[/tab]
 *   [/tabs]
 * 
 * @attr  
 *   {ID} - the ID of tab
 *   {TITLE} - the title of tab
 *   id - the id of each tab    
 *   text - the text
**/
function tabs_func($atts, $content = null) {       
	
	$html = '<div class="tabs-container">'."\n";
	$html .= '    <ul class="tabs">'."\n";
    
    $i = 1;
    foreach($atts as $id => $title)
	{
        //if( !preg_match('/tab([0-9]{2})/', $attr) ) continue;
        
        $html .= '<li><h4><a href="#'.$id.'" title="'.$title.'">'.$title.'</a></h4></li>'."\n";
        
        $i++;
    }
    
    $html .= '    </ul>'."\n";
    
    $html .= '<div class="border-box">' . do_shortcode($content) . do_shortcode('[clear]') . '</div>';
    
    $html .= '</div>'."\n";
	
	return apply_filters( 'yiw_tabs_shortcode', $html );
}
add_shortcode("tabs", "tabs_func");    


/** 
 * TAB     
 * 
 * @description
 *    See above.       
 * 
 * @example
 *   [tab id=N]Text[/tab]
 *     
**/
function tab_func($atts, $content = null) {     
	extract(shortcode_atts(array(
		"id" => null
	), $atts));
	
	//$content = apply_filters('the_content', $content);
	
	$html = '<div id="'.$id.'" class="panel">'.wpautop(do_shortcode($content)).'<div class="clear"></div></div>';
	
	//return apply_filters('the_content', $html);
	return apply_filters( 'yiw_tab_shortcode', $html );
}
add_shortcode("tab", "tab_func");       


/** 
 * QUICK CONTACT BOX     
 * 
 * @description
 *    Create a box for quick contact with tab.    
 * 
 * @example
 *   [quick_contact [class=""] icon1="" icon2=""]
 *       [tab id=1]Text[/tab]
 *       [tab id=2]Text[/tab]
 *   [/quick_contact]
 * 
 * @attr  
 *   iconN - the icon of each tab
 *   id - the id of each tab    
 *   text - the text
**/
function quick_contact_func($atts, $content = null) { 
	extract(shortcode_atts(array(
		"class" => 'quick-contact-box'
	), $atts));      
	
	$html = '<div class="' . $class . '">'."\n";
	$html .= '    <ul class="nav-box">'."\n";
    
    $i = 1;
    foreach($atts as $attr => $value)
	{
        if( !preg_match('/icon([0-9]{1,2})/', $attr) ) continue;
        
        $html .= '<li><a href="#icon'.$i.'"><img src="' . get_url_icon( $value ) . '" alt="Image Tab ' . $i . '" class="nofade" /></a></li>'."\n";
        
        $i++;
    }
    
    $html .= '    </ul>'."\n";
    
    $html .= '<div class="box-info">' . $content . ' [clear]</div>';
    
    $html .= '</div>'."\n";
	
	return apply_filters( 'yiw_quick_contact_shortcode', do_shortcode( $html ) );
}
add_shortcode("quick_contact", "quick_contact_func");                         



/* =========================== TABLES ================================ */    


/** 
 * TABLE     
 * 
 * @description
 *    Create a toggle content.    
 * 
 * @example
 *   [table color="white|red|grey|blue"]
 *       <table width="100%" cellpadding="0" cellspacing="0">
 *       	<thead>
 *       	    <tr>
 *       	    	<th style="width:20%"></th>
 *       	    	<th style="width:20%">Free</th>
 *       	    	<th style="width:20%">Mini</th>
 *       	    	<th style="width:20%">Standard</th>
 *       	    	<th style="width:20%">Premium</th>
 *       	    </tr>
 *       	</thead>
 *       	
 *       	<tbody>
 *       	    <tr>
 *       	    	<th class="features">Features 1</th>
 *       	    	<td>1</td>
 *       	    	<td>unlimited</td>
 *       	    	<td>[x]</td>
 *       	    	<td>-</td>
 *       	    </tr>
 *       	</tbody>
 *       </table>
 *   [/table]
 * 
 * @attr                 
 *   color - the color   
 *   markup - the html markup of table
**/
function table_func($atts, $content = null) {        
	extract(shortcode_atts(array( 
		"color" => null
	), $atts));                                                                                             
	
	$html = '<div class="short-table '.$color.'">' . do_shortcode($content) . '</div>';
	
	return apply_filters( 'yiw_table_shortcode', $html );
}
add_shortcode("table", "table_func");      


/** 
 * TICK     
 * 
 * @description
 *    Insert a tick on the content   
 * 
 * @example
 *   [x]
 * 
**/
function x_func($atts, $content = null) {    
	
	return '<img src="'.get_template_directory_uri().'/images/bg/yes.png" alt="yes" />';
}
add_shortcode("x", "x_func");             


/** 
 * TABLES PRICES    
 * 
 * @description
 *    Create a box of prices.    
 * 
 * @example
 *   [price title="" price="" href="" buttontext="" color="white|red|grey|blue|green|yellow" [last="0|1"]]
 *       <li>feature 1</li>
 *       <li>feature 2</li>
 *       <li>feature 3</li>
 *       <li>feature 4</li> 
 *   [/price] 
 * 
 * @attr  
 *   title - title of box
 *   price - price, showed below title
 *   buttontext - the text of button 
 *   href - hyperlink of button More Info
 *   text - list of features    
 *   color - the color   
**/
function price_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"title" => '',
		"price" => '',
		"buttontext" => 'More info',
		"href" => '#',
		"color" => null,
		"last" => 0
	), $atts));
	
	if( $last ) $last = ' last';
	else $last = '';
	                                     
	$html  = '<div class="one-third'.$last.'">';
	$html .= '	<div class="price-table">';
	$html .= '	  <div class="head '.$color.'">';
	$html .= '	   	<p>'.$title.'</p>';
	$html .= '		<h2 class="price">'.$price.'</h2>';
	$html .= '	  </div>';
	$html .= '	  <div class="body">';
	$html .= '		<ul>';
	$html .= '			'.do_shortcode($content);
	$html .= '		</ul>';
	$html .= '';		
	$html .= '		<p class="more"><a href="'.$href.'">'.$buttontext.'</a></p>';
	$html .= '	  </div>';
	$html .= '  </div>';
	$html .= '</div>';
	
	return apply_filters( 'yiw_price_shortcode', $html );
}
add_shortcode("price", "price_func");     


/** 
 * TABLES PRICES LAST    
 * 
 * @description
 *    Create a box of prices.    
 * 
 * @example
 *   [price_last title="" price="" href="" buttontext="" color="white|red|grey|blue|green|yellow"]
 *       <li>feature 1</li>
 *       <li>feature 2</li>
 *       <li>feature 3</li>
 *       <li>feature 4</li> 
 *   [/price_last]   
**/
function price_last_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"title" => '',
		"price" => '',
		"buttontext" => 'More info',
		"href" => '#',
		"color" => null
	), $atts));
	
	return do_shortcode("[price title=\"$title\" price=\"$price\" href=\"$href\" buttontext=\"$buttontext\" color=\"$color\" last=\"1\"]{$content}[/price]");
}
add_shortcode("price_last", "price_last_func");                                



/* =========================== MEDIA ================================ */    


/** 
 * YOUTUBE     
 * 
 * @description
 *    Embed the player youtube video.    
 * 
 * @example
 *   [youtube width="640" height="385" video_id="wSBIcNmCAX0"]
 * 
 * @attr  
 *   width - the width of player
 *   height - the height of player   
 *   video_id - the id of video
 *      es.  URL : http://www.youtube.com/watch?v=RomZBcLH6do     video_id : RomZBcLH6do 
**/
function youtube_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"width" => 640,
		"height" => 385,
		"video_id" => null
	), $atts));
	
	$html = '<object width="'.$width.'" height="'.$height.'">
                <param name="movie" value="http://www.youtube.com/v/'.$video_id.'?fs=1"></param>
                <param name="allowFullScreen" value="true"></param>
                <param name="allowscriptaccess" value="always"></param>
                <embed src="http://www.youtube.com/v/'.$video_id.'?fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed>
            </object>';
	
	return apply_filters( 'yiw_youtube_shortcode', $html );
}
add_shortcode("youtube", "youtube_func");     


/** 
 * VIMEO     
 * 
 * @description
 *    Embed the player vimeo video.    
 * 
 * @example
 *   [vimeo width="640" height="360" video_id="3109777"]
 * 
 * @attr  
 *   width - the width of player
 *   height - the height of player   
 *   video_id - the id of video
 *      es.  URL : http://vimeo.com/3109777     video_id : 3109777 
**/
function vimeo_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"width" => 640,
		"height" => 385,
		"video_id" => null
	), $atts));
	
	$html = '<object width="'.$width.'" height="'.$height.'">
                    <param name="allowfullscreen" value="true" />
                    <param name="allowscriptaccess" value="always" />
                    <param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$video_id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" />
                    <embed src="http://vimeo.com/moogaloop.swf?clip_id='.$video_id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'.$width.'" height="'.$height.'"></embed>
                </object>';
	
	return apply_filters( 'yiw_vimeo_shortcode', $html );
}
add_shortcode("vimeo", "vimeo_func");     


/** 
 * DAILYMOTION     
 * 
 * @description
 *    Embed the player dailymotion video.    
 * 
 * @example
 *   [dailymotion width="640" height="360" video_id="xgis0k"]
 * 
 * @attr  
 *   width - the width of player
 *   height - the height of player   
 *   video_id - the id of video
 *      es.  URL : http://dailymotion.virgilio.it/video/xgp1c6     video_id : xgp1c6 
**/
function dailymotion_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"width" => 640,
		"height" => 385,
		"video_id" => null
	), $atts));
	
	$html = '<object width="'.$width.'" height="'.$height.'">
                <param name="movie" value="http://dailymotion.virgilio.it/swf/video/'.$video_id.'?width='.$width.'&theme=none&foreground=%23F7FFFD&highlight=%23FFC300&background=%23171D1B&additionalInfos=1&hideInfos=1&start=&animatedTitle=&iframe=0&autoPlay=0"></param>
                <param name="allowFullScreen" value="true"></param>
                <param name="allowScriptAccess" value="always"></param>
                <embed type="application/x-shockwave-flash" src="http://dailymotion.virgilio.it/swf/video/'.$video_id.'?width='.$width.'&theme=none&foreground=%23F7FFFD&highlight=%23FFC300&background=%23171D1B&additionalInfos=1&hideInfos=1&start=&animatedTitle=&iframe=0&autoPlay=0" width="'.$width.'" height="'.$height.'" allowfullscreen="true" allowscriptaccess="always"></embed>
            </object>';
	
	return apply_filters( 'yiw_dailymotion_shortcode', $html );
}
add_shortcode("dailymotion", "dailymotion_func");                         



/* =========================== WIDGETS ================================ */    


/** 
 * Faqs    
 * 
 * @description
 *    Show all post on faq post types    
 * 
 * @example
 *   [faq items=""]
 *   
 * @params
 * 		items - number of item to show   
 * 
**/
function faq_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"items" => -1,
		"close_first" => false
	), $atts));         
	
	global $wp_query;
	
	$tmp_query = $wp_query;     
	
	$args = array(
		'post_type' => 'bl_faq',
        'posts_per_page' => $items	
	);
	
	$faqs = new WP_Query( $args );       
	
	$first = TRUE;
	if( $close_first ) $first = FALSE;
	
	$html = '';
	if( !$faqs->have_posts() ) return $html;
	
	//loop
	while( $faqs->have_posts() ) : $faqs->the_post();
	
		$title = the_title( '', '', false );
		$content = get_the_content();
		
		$attr = '';
		if( $first )
			$attr = ' opened="1"';
		
		$html .= do_shortcode( "[toggle title=\"$title\"{$attr}]{$content}[/toggle]" );
		$first = FALSE;	
	
	endwhile;          
	
	$wp_query = $tmp_query;
	
	wp_reset_postdata();
	
	return apply_filters( 'yiw_faq_shortcode', $html );
}
add_shortcode("faq", "faq_func");      


/** 
 * testimonials   
 * 
 * @description
 *    Show all post on testimonials post types    
 * 
 * @example
 *   [testimonials items=""]
 *   
 * @params
 * 		items - number of item to show   
 * 
**/
function testimonials_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"items" => null
	), $atts));
	
	wp_reset_query();  
	
	global $wp_query;
	
	$tmp_query = $wp_query;     
	
	$args = array(
		'post_type' => 'bl_testimonials',
        'posts_per_page' => -1	
	);
	if( !is_null( $items ) ) $args['posts_per_page'] = $items;
	
	$tests = new WP_Query( $args );   
	
	$html = '';
	if( !$tests->have_posts() ) return $html;
	
	//loop           
	$html = '';
	while( $tests->have_posts() ) : $tests->the_post();
	
		$title = the_title( '<span class="title">', '</span>', false );
		$website = get_post_meta( get_the_ID(), '_testimonial_website', true ); 
		if ( ! empty( $website ) ) {
		    $title = str_replace( '</span>', ',</span>', $title );
		    $website = "<a href=\"" . esc_url( $website ) . "\">$website</a>";
		}
		
		$html .= '<div class="testimonials-list">';   
		
		$html .= '	<div class="thumb-testimonial">';    
		$html .= '		' . get_the_post_thumbnail( null, 'thumb-testimonial' );   
		$html .= '		<div class="shadow-thumb"></div>'; 
		$html .= '		<p class="name-testimonial">' . $title . '<span class="website">' . $website . '</span><div class="clear"></div></p>'; 
		$html .= '	</div>'; 
		
		$content = apply_filters( 'the_content', get_the_content() );
		
		$html .= '	<div class="the-post">';    
		$html .= '		' . $content; 
		$html .= '	</div>';               
		
		$html .= '	<div class="clear"></div>';
		
		$html .= '</div>';
	
	endwhile;         
	
	$wp_query = $tmp_query;
	
	wp_reset_postdata(); 
	
	return apply_filters( 'yiw_testimonials_shortcode', $html );
}
add_shortcode("testimonials", "testimonials_func");       


/** 
 * Google Maps   
 * 
 * @description
 *    Print the google map box   
 * 
 * @example
 *   [googlemap src="" [width=""] [height=""] ]
 *   
 * @params
 * 	 src - the link of google map   
 * 	 width - the width of box   
 * 	 height - the height of box   
 * 
**/
function googlemap_func($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '274',
      "height" => '200',
      "src" => ''
   ), $atts));
   
   $html  = '<div class="google-map-frame">';
   $html .= '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&amp;output=embed" ></iframe>';
   $html .= '<div class="shadow-thumb-sidebar"></div>';
   $html .= '</div>';                                         
   
   return apply_filters( 'yiw_googlemap_shortcode', $html );
}
add_shortcode("googlemap", "googlemap_func");


/** 
 * News List   
 * 
 * @description
 *    Print list of posts   
 * 
 * @example
 *   [posts cat="" items="" icon="" title="" size="" last="" ]
 *   
 * @params
 * 	 cat   - id category of post
 * 	 items - number of posts 	 
 *   icon  - one of set already been in $icons_name array
 *   size  - icons size (32 or 48) (optional) @default: 48 
 *   last  - specifics if this section is the last element (optional) @default: false 
 *   title - the title  
 * 
**/
function posts_func($atts, $content = null) {
   	extract(shortcode_atts(array(
      	"cat" => -1,
      	"icon" => null,
      	"items" => 3,
      	"size" => 32,
      	"last" => false,
      	"title" => null
   	), $atts));
   	
   	global $wp_query;
   	
   	$tmp_query = $wp_query;
   
   	$loop = new WP_Query( array(
		'cat' => $cat,
		'posts_per_page' => $items              	
   	) );                          
	
	$html = '';
	while( $loop->have_posts() ) : $loop->the_post();   
		
		$html .= '<p>';
		$html .= the_title( '<a href="' . get_permalink() . '">', '</a><br />', false );
		
		add_filter( 'excerpt_length', 'excerpt_length_posts' );
		$html .= get_the_excerpt();                                   
		remove_filter( 'excerpt_length', 'excerpt_length_posts' );
		
		$html .= '</p>';
	
	endwhile;        
	
	$wp_query = $tmp_query;
	
	wp_reset_postdata();
	
	//return do_shortcode('[section icon="' . $icon . '" size="' . $size . '" title="' . $title . '" last="' . $last . '"]' . $html . '[/section]');      
   
   	return apply_filters( 'yiw_posts_shortcode', $html );
}
add_shortcode("posts", "posts_func");

function excerpt_length_posts() {
	return 5;
}


/** 
 * NEWSLETTER FORM   
 * 
 * @description
 *    Show a newsletter form   
 * 
 * @example
 *   [newsletter_form action="" label="" [label_submit=""] ]
 *   
 * @params
 * 	 action   - the action of form
 * 	 label    - the label of input text 
 * 	 label_submit - the label of submit button 
 * 
**/
function newsletter_form_func($atts, $content = null) {
   	extract(shortcode_atts(array(
      	"action" => '',
      	"label" => '',
      	"label_submit" => __( 'Sign up', TEXTDOMAIN ),
   	), $atts));
   
   	$html = '
<form method="post" action="' . $action . '" class="newsletter-form">
	<fieldset>
		<label>
			<span>' . $label . '</span>
			<input type="text" class="email-newsletter" name="email-newsletter" />&nbsp;
		</label>
		<input type="submit" value="' . $label_submit . '" class="subscribe-newsletter" name="subscribe" />
	</fieldset>
</form>'; 

	return apply_filters( 'yiw_newsletter_form_shortcode', $html );
}
add_shortcode("newsletter_form", "newsletter_form_func");



// ------------------- WP ECOMMERCE -----------------------------------

        
/** 
 * BOX PRODUCTS     
 * 
 * @description
 *    Show a box with products    
 * 
 * @example
 *   [products icon="" title=""]description[/products]
 * 
 * @attr  
 *   icon - the class of the icon that will be showed near the title 
 *   title - the title of box
 *   description - a short description for the box 
 *   products - number of products to show 
**/
function products_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"icon" => null,
		"title" => 'Special items',
		"type" => null,
		"items" => 4
	), $atts));   
	
	$siteurl = site_url();       
	
	global $wp_query;
	
	$tmp_query = $wp_query;     	
    
	$args = array(
		'post_type' => 'wpsc-product'
	);                                  
    $products = new WP_Query( $args );
	
	if( $products->have_posts() ) :  
	
		$html = '<div class="clear"></div>';
		$html .= '<div class="special-products">';
		
		if( $content != null )
		{     
			$class_h2 = '';
			if( !is_null($icon) )
				$class_h2 = " class=\"icon $icon\"";
			
			//$content = apply_filters( 'the_content', $content );
			$content = do_shortcode( $content );
			
			$html .= "<div class=\"description\">
					<h2$class_h2>$title</h2>
					
					$content
				</div>";
		}
		
		$html .= '   <div class="products">';
		$html .= '	    <ul class="list-products">';
		
		$i = 1;            
		
		while( $products->have_posts() AND $i <= $items ) : $products->the_post();  
            
            global $wpsc_custom_meta, $wpsc_variations; 
            $wpsc_custom_meta = new wpsc_custom_meta( get_the_ID() );
            $wpsc_variations = new wpsc_variations( get_the_ID() );   
	
			$price = wpsc_the_product_price(get_option('wpsc_hide_decimals'));
			
			if( !get_option('wpsc_hide_decimals') )	
				$price = format_price( $price, false ); 
			
			
			if ( $type == 'specials' AND !wpsc_product_on_special() )
				continue;                           
			
			$last = '';
			if( $i == $items )
				$last = ' class="last"';
			
			$html .= '      <li'.$last.'>';
			
			$html .= '        <div class="product-image">';
			                                                              
			$html .= '        <a href="' . wpsc_the_product_permalink() . '">';
			
			if( wpsc_the_product_thumbnail() )
				$html .= '          <img class="product_image" id="product_image_' . wpsc_the_product_id() . '" alt="' . wpsc_the_product_title() . '" title="' . wpsc_the_product_title() . '" src="' . wpsc_the_product_thumbnail() . '"/>';  
			else 
				$html .= '          <img class="no-image" id="product_image_' . wpsc_the_product_id() . '" alt="No Image" title="' . wpsc_the_product_title() . '" src="' . WPSC_CORE_THEME_URL . 'wpsc-images/noimage.png" width="' . get_option('product_image_width') . '" height="' . get_option('product_image_height') . '" />';  
				
			$html .= '        </a>';
			
			if( wpsc_product_on_special() ) $html .= '          <div class="sale-icon-small">Sale!</div>';           
			
			$html .= '        </div>';
			$html .= '        <div class="thumb-shadow">&nbsp;</div>';   
			$html .= '        <p>' . wpsc_the_product_title() . '</p>';
			$html .= "        <div class=\"price\">$price</div>";
			$html .= "        " . do_shortcode('[button_icon href="' . wpsc_the_product_permalink() . '" icon="arrow"]' . __( 'More Details', TEXTDOMAIN ) . '[/button_icon]');
			
			$html .= '      </li>';	            
		
			$i++;
			
		endwhile;
		
		$html .= '      </ul>';
		$html .= '   </div>';                
		$html .= '   <div class="clear"></div>';
		$html .= '</div>';    
		$html .= '<div class="space"></div>';    
	
	endif;
	
	$wp_query = $tmp_query;
	
	wp_reset_postdata();
	
	return apply_filters( 'yiw_products_shortcode', $html );
}                                                       
if( plugin_is_activated( 'wp-e-commerce/wp-shopping-cart.php' ) ) add_shortcode("products", "products_func"); 

        
/** 
 * BOX SPECIAL PRODUCTS     
 * 
 * @description
 *    Show a box with special products    
 * 
 * @example
 *   [special_products icon="" title=""]description[/products]
 * 
 * @attr  
 *   icon - the class of the icon that will be showed near the title 
 *   title - the title of box
 *   description - a short description for the box 
 *   products - numbero of products to show 
**/
function special_products_func($atts, $content = null) {        
	extract(shortcode_atts(array(
		"icon" => null,
		"title" => 'Special items',
		"items" => 4
	), $atts));
	
	if( !is_null( $icon ) )
		$icon = " icon=\"$icon\"";
	
	if( $content != null )
		$content .= '[/products]';
	
	$html = do_shortcode("[products{$icon} title=\"$title\" items=\"$items\" type=\"specials\"]{$content}");
	
	return apply_filters( 'yiw_special_products_shortcode', $html );
}                                                       
add_shortcode("special_products", "special_products_func"); 


// ---------------------------- FORMATTING --------------------------------

        
/** 
 * BOLD       
 * 
 * @example
 *   [b]text[/b]
**/
function b_func($atts, $content = null) {      
	return "<b>{$content}</b>";
}                                                       
add_shortcode("b", "b_func"); 

        
/** 
 * STRONG       
 * 
 * @example
 *   [strong]text[/strong]
**/
function strong_func($atts, $content = null) {      
	return "<strong>{$content}</strong>";
}                                                       
add_shortcode("strong", "strong_func"); 

        
/** 
 * ITALIC       
 * 
 * @example
 *   [i]text[/i]
**/
function i_func($atts, $content = null) {      
	return "<i>{$content}</i>";
}                                                       
add_shortcode("i", "i_func"); 

        
/** 
 * ITALIC EM      
 * 
 * @example
 *   [em]text[/em]
**/
function em_func($atts, $content = null) {      
	return "<em>{$content}</em>";
}                                                       
add_shortcode("em", "em_func"); 

        
/** 
 * URL      
 * 
 * @example
 *   [url href="" title=""]text[/url]
**/
function url_func($atts, $content = null) {       
	extract(shortcode_atts(array(
		"href" => '#',
		"title" => null
	), $atts));
	    
	return "<a href=\"$href\" title=\"$title\">{$content}</a>";
}                                                       
add_shortcode("url", "url_func"); 
?>