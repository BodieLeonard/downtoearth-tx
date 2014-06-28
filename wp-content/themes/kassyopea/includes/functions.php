<?php
/**
 * @package WordPress
 * @subpackage Kassyopea
 */                                                                               

// define the text domain location for the theme
define("TEXTDOMAIN", 'ka');     

define( 'ENABLE_IMPORT', 1 );        

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain(TEXTDOMAIN, TEMPLATEPATH . '/languages');   

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; 

function warning_version_wp() {
	global $theme_update_notice, $pagenow;
	//if ( $pagenow == "themes.php") {
?>
		<div id="message" class="error fade">
		<?php _e( 'The theme you are using requires WordPress version 3.0 or higher. So, many features of it will not perform correctly.', TEXTDOMAIN ) ?>
		</div>
<?php
	//}
}                         

if( version_compare($wp_version, "3.0", "<") )
	add_action('admin_notices', 'warning_version_wp');	                                                       

// default theme setup
function kassyopea_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style( 'css/editor-style.css' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );  

	// This theme uses the menues
	add_theme_support( 'menus' );          

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// Post Format support.                      
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );       

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	
	add_image_size( 'thumb-testimonial', 68, 68 );
	add_image_size( 'thumb-recentposts', 55, 55, true );   // for shortcode
	add_image_size( 'img-accordion-slider', 130, 205, true );
	add_image_size( 'portfolio-thumb-3cols', 280, 143, true );
	add_image_size( 'portfolio-thumb-slider', 205, 118, true );
	add_image_size( 'portfolio-thumb-gallery', 179, 179, true );  
    
	// This theme uses wp_nav_menu() in more locations.
	register_nav_menus(
        array(
            'nav'           => __( 'Navigation' ),
            'footer-nav'    => __( 'Footer Navigation' )
        )
    );
    
    // sidebars registers        
	register_sidebar( sidebar_args( 'Home Colourful Section', 'box-sections', 'h2' ) );  
	register_sidebar( sidebar_args( 'Home Sidebar', 'section', 'h2' ) );    
	register_sidebar( sidebar_args( 'Blog Sidebar' ) );               
	register_sidebar( sidebar_args( 'Shop Sidebar' ) );              
	
	// add sidebar created from plugin
	if( get_option( 'bl_sidebars' ) )
	{
		foreach( unserialize( get_option( 'bl_sidebars' ) ) AS $sidebar )
		{
			register_sidebar( sidebar_args( $sidebar ) );
		}
	}                                                           
	
	// footer sidebars
	for( $i = 1; $i <= get_option( 'bl_footer_rows', 2 ); $i++ )
		register_sidebar( sidebar_args( "Footer Row $i", 'one-third widget', 'h2' ) );
	
	// add custom style
	add_action( 'wp_head', 'yiw_custom_style', 999 );
	
	// add custom js
	add_action( 'wp_footer', 'yiw_custom_js', 999 );
}
add_action( 'after_setup_theme', 'kassyopea_setup' );     

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since 1.0
 */
function yiw_page_menu_args( $args ) {
    $args['show_home'] = true;
    $args['menu_class'] = 'menu';
    return $args;
}
add_filter( 'wp_page_menu_args', 'yiw_page_menu_args' ); 

function yiw_custom_style()
{
	string_( '<style type="text/css">', stripslashes_deep( get_option( 'bl_custom_style', '' ) ), '</style>' );
}

function yiw_custom_js()
{
	string_( '<script type="text/javascript">', stripslashes_deep( get_option( 'bl_custom_js', '' ) ), '</script>' );
}

function sidebar_args( $name, $widget_class = 'widget', $title = 'h3' )
{   
	$id = strtolower( str_replace( ' ', '-', $name ) );
	
    return array(
        'name' => $name,
        'id' => $id,
		'before_widget' => '<div id="%1$s" class="' . $widget_class . ' %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<' . $title . '>',
		'after_title' => '</' . $title . '>',
    );
}                             

//add lightbox to the gallery
function yiw_add_lightbox( $html, $id, $size, $permalink, $icon, $text ) {
    global $wp_query;
    
	if ( ! $permalink AND 'wpsc-product' != $wp_query->post->post_type )
		return str_replace( '<a', '<a rel="prettyPhoto[gallery]"', $html );
	else
		return $html;
}
add_filter( 'wp_get_attachment_link', 'yiw_add_lightbox', 10, 6 );

// sort array
function yiw_subval_sort($a, $subkey) 
{
	if( is_array($a) AND !empty($a) )
	{
		foreach($a as $k => $v) 
		{
			$b[$k] = strtolower( $v[$subkey] );
		}
		
		asort($b);
		
		foreach($b as $key => $val) 
		{
			$c[] = $a[$key];
		}
		
		return $c;
	}
	
	return $a;
}                          

$message = '';           


// set of icons
$icons_name = array(            
    'bag', 'box', 'bubble', 'bulb',
    'calendar', 'cart', 'chart', 'clipboard', 'coffee',
    'diagram', 'doodles',
    'gear', 'gift', 'globe',
    'info',
    'label', 'letter',
    'moleskine', 'monitor', 'mphone',
    'new',
    'open',
    'pc', 'pencil', 'phone', 'pictures', 'postit',
    'qmark',
    'refresh',
    'shopbag', 'statistics',
    'testimonial', 'tick',
    'bag-grey', 'card-grey', 'cart-grey', 'mail-grey', 'pencil-grey', 'phone-grey', 'users-grey'
);  
                         
// include colors functions  
include_once dirname(__FILE__) . '/../includes/colors.php';  
                         
// include colors functions  
include_once dirname(__FILE__) . '/../includes/fonts.php';  
                         
// include admin panel  
include_once dirname(__FILE__) . '/../admin-options/yiw_panel.php';  

// include update notify
include_once dirname(__FILE__) . '/../admin-options/notify_update.php'; 

// include custom types
include_once dirname(__FILE__) . '/../admin-options/backend.php';    

// include meta boxes
include_once dirname(__FILE__) . '/../admin-options/metaboxes.php';  

// include widgets dashboard
include_once dirname(__FILE__) . '/../admin-options/dashboard.php'; 

// include buttons for tinymcs
//include_once dirname(__FILE__) . '/../admin-options/tinymce/tinymce.php'; 

// include widgets
include_once dirname(__FILE__) . '/../includes/widgets/widgets.php';    

// include shortcodes                        
include_once dirname(__FILE__) . '/../includes/shortcodes.php';       

// include send email script                        
include_once dirname(__FILE__) . '/../includes/sendemail.php';             

//add_meta_post();

function catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];

    if(empty($first_img)){ //Defines a default image
      $first_img = get_stylesheet_directory_uri()."/images/default.gif";
    }
    return $first_img;
}                 

if ( ! function_exists( 'bolder_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function bolder_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$GLOBALS['count'] = $GLOBALS['count']+1;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-container">
    		<div class="comment-author vcard">
    		    <?php $url = get_template_directory_uri() . '/images/noavatar.png'; ?>
    			<?php echo get_avatar( $comment, 75 ); ?>
    			<div class="shadow-avatar-comment"></div>
    			<?php printf( __( '%s ', TEXTDOMAIN ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
    		</div><!-- .comment-author .vcard -->
    		
    		<div class="comment-meta commentmetadata">
                <?php if ( $comment->comment_approved == '0' ) : ?>
        			<em class="moderation"><?php _e( 'Your comment is awaiting moderation.', TEXTDOMAIN ); ?></em>
        			<br />
        		<?php endif; ?>
        		
        		<div class="intro">
            		<div class="commentDate">
            		  <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
            			<?php
            				/* translators: 1: date, 2: time */
            				printf( __( '%1$s at %2$s', TEXTDOMAIN ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', TEXTDOMAIN ), ' ' );
            			?>
        			</div>

        			<div class="commentNumber">#&nbsp;<?php echo $GLOBALS['count'] ?></div>
        		</div>
        			
    			<div class="comment-body"><?php comment_text(); ?></div>
    			
    			
    			<div class="reply">
        			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        			<?php clear() ?>
        		</div><!-- .reply -->
    		</div><!-- .comment-meta .commentmetadata -->
    	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', TEXTDOMAIN ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', TEXTDOMAIN), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

function get_current_ID()
{
	global $wp_query;
	$post_id = 0;
	
	if ( is_tax('wpsc_product_category') )
	   $post_id = get_pageID_by_pagename('products-page');
	else
	   $post_id = $wp_query->post->ID;
	   
	return $post_id;
}

function get_current_pagename()
{
	global $post;
	return $post->post_name;
}

function get_layout_page()
{
	global $shortname;
	
	$layout = get_post_meta( get_current_ID(), '_layout_page', true );
	
	if ( empty( $layout ) ) 
		$layout = get_option( $shortname . '_default_layout_page', 'sidebar-right' );
	
	return $layout;
}

function plugin_is_activated( $plugin )
{
	return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}
        
//------------------------------------------------------------------------------
// CHECK EMAIL
//------------------------------------------------------------------------------
function checkMail($m) {
	$r = "([A-z0-9]+[\._\-]?){1,3}([A-z0-9])*";
  	$r = "/(?i)^{$r}\@{$r}\.[A-z]{2,6}$/";
  	return preg_match($r, $m);
}

//------------------------------------------------------------------------------
// CHECK GENERIC
//------------------------------------------------------------------------------
Function checkGeneric($str) {
//	if (!preg_match("/^[a-z0-9 '-\^]+$/i", $str)) {
//		Return False;
//	}
	If (strlen($str) <= 2) {
		return False;
	} else {
		Return True;
	}
}

//------------------------------------------------------------------------------------------------
// CHECK TEL
//-----------------------------------------------------------------------------------
Function checktel($str) {
    if ($str == "") {
		$str = 0;
	}
	if (!is_numeric($str)) {
		Return False;
	}
	If (strlen($str) >= 18) {
		return False;
	} else {
		Return True;
	}
}           

//------------------------------------------------------------------------------
// CHECK GENERIC
//------------------------------------------------------------------------------
function get_convertTags($str, $class = '', $after = '') 
{
	if( $class != '' )
		$class = ' class="' . $class . '"';
		
    $str = str_replace('[', '<span' . $class . '>', $str);
    $str = str_replace(']', '</span>', $str);
    
    return $str . $after;
}  

function convertTags($str, $after = '') 
{
    echo get_convertTags($str, $after);
}                                 
add_filter( 'widget_title', 'get_convertTags' );       

function get_removeTags($str, $after = '') 
{
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    
    return $str . $after;
}                               
add_filter( 'wp_title', 'get_removeTags' );    

function yiw_curPageURL() {
	$pageURL = 'http';
	if ( isset( $_SERVER["HTTPS"] ) AND $_SERVER["HTTPS"] == "on" ) 
		$pageURL .= "s";
	
	$pageURL .= "://";
	
	if ( isset( $_SERVER["SERVER_PORT"] ) AND $_SERVER["SERVER_PORT"] != "80" ) 
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	else
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	
	return $pageURL;
}

function slideshowImages($path, $n = FALSE)
{
    $dir = $path;
    $dir = str_replace("http://$_SERVER[SERVER_NAME]", "$_SERVER[DOCUMENT_ROOT]", $path);
	
    $files = array();        
    $html = ''; $i = 1;
    if ($handle = opendir($dir)) 
    {                                
       while (false !== ($file = readdir($handle))) 
       { 
            list($name, $ext) = explode('.', $file);
            if ( $file == ".." || $file == "." || is_dir($file)) {
                continue;
            }

           if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') 
           {
                $html .= "<img src=\"{$path}{$file}\" alt=\"$name\" />";
                $i++;
           }
           
           if($n AND $i > $n) break;
       }
    
       closedir($handle); 
    }        
    
//     $html = '';
//     for($i = 0; $i < get_option('nums_images_slideshow_home_f'); $i++)
//     {
//         $html .= "<img src=\"{$path}{$file[$i]}\" alt=\"001\" />";
//     } 
    
    echo $html;
}              

function get_url_icon($icon, $size = 32)
{
    global $icons_name;
    
    $path = "/images/icons/{$icon}{$size}.png";
    
    if( file_exists( dirname(__FILE__) . '/..' . $path ) )
    	return get_template_directory_uri() . "/images/icons/{$icon}{$size}.png";
    else
    	return get_template_directory_uri() . "/images/icons/{$icon}.png";
}           

function list_icons( $selected = false, $echo = TRUE )
{
    global $icons_name;
    
    $html = '';
    foreach($icons_name as $icon)
    {
    	$option_select = '';
    	if( $selected != FALSE AND $selected == $icon )
    		$option_select = ' selected="selected"';
    		
        $html .= '<option value="'.$icon.'"'.$option_select.'>'.$icon.'</option>'."\n";
    }
    
    if($echo) echo $html;
    return $html;
}
	
class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

           $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '<strong>';
           $append = '</strong>';
           
           $item->description = trim( $item->description );
           $description  = ( !empty( $item->description ) AND $item->description != ' ' ) ? '<br /><span>'.esc_attr( $item->description ).'</span>' : '';

           //$description = $append = $prepend = "";

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            //$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;  
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $description;  
            $item_output .= '</a>';
            $item_output .= $args->link_after;
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
}


// convert a string of categories into excluded categories
function exclude_categories($cats)
{
    $excluded_cats = '-9999';
    $cats = explode(",", $cats);
    
    foreach ($cats as $cat) 
    {
    	$excluded_cats .= ',-' . $cat;
    }
    
    return $excluded_cats;
}                                     

// print the option from db, using do_shortcode, to convert the shortcodes
function option_theme($option)
{
    echo do_shortcode(stripslashes(get_option($option)));
}     

/**
 * Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
 */
function widget_first_last_classes($params) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

	if(!$my_widget_num) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$my_widget_num[$this_id] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

	if($my_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= 'widget-first ';
	} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'widget-last ';
	}

	$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"

	return $params;

}
add_filter('dynamic_sidebar_params','widget_first_last_classes');      

function get_links_sliders( &$a, &$url, $slide )
{
	switch( $slide['link_type'] )
    {
		case 'page':
			$a = TRUE;
			$url = get_permalink( $slide['link_page'] );
		break;
		
		case 'category': 
			$a = TRUE;
			$theCatId = get_category_by_slug( $slide['link_category'] );                              
			$url = get_category_link( $theCatId->term_id );
		break;
		
		case 'url':      
			$a = TRUE;                          
			$url = $slide['link_url'];
		break;
		
		case 'none':     
			$a = FALSE;
			$url = '';
		break;
	}  
}              

function featured_content( $slide, $before = '', $after = '' )
{
	global $link;
	
	switch( $slide['content_type'] ) { 
				
		case 'image' : ?>                    
        <?php if( $link ) : ?><a href="<?php echo $link_url ?>"><?php endif ?>
		<div class="featured-image"><?php echo $before ?><img src="<?php echo $slide['image_url'] ?>" alt="<?php echo $slide['slide_title'] ?>" /><?php echo $after ?></div>  
		<?php if( $link ) : ?></a><?php endif ?>
		<?php break;
		
		case 'video' : ?>
		<div class="video-container"><?php echo stripslashes_deep( $slide['code_video'] ) ?></div>
		<?php break;               
        
	}
}         

function clear( $class = '' )
{
	?><div class="clear<?php echo ' ' . $class ?>"></div><?php
}

// sliders
function split_title( $title, $pattern = '/(.*)\[(.*)\]/' )
{
	$return = array();
	
	if( preg_match($pattern, $title, $t, PREG_OFFSET_CAPTURE) )
	{
    	$return['title'] = $t[1][0];
    	$return['subtitle'] = $t[2][0];
    }
    else
    {
		$return['title'] = $title;	
	}
    
    return $return;
}

function string_( $before, $string, $after, $echo = true )
{
	$html = '';
	if( $string != '' AND !is_null( $string ) )
		$html = $before . $string . $after;
	
	if( $echo )
		echo $html;
	
	return $html;
}

function get_slides( $option )
{
	return yiw_subval_sort( unserialize( get_option( $option ) ), 'order' );
}          

function pagination( $pages = '', $range = 2 )
{  
     global $paged;
     if( empty( $paged ) ) $paged = 1;

     if( $pages == '' ) {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         
		 if( !$pages )
             $pages = 1;
     }   

     if( 1 != $pages ) {
         echo "<div class='general-pagination'>";
         if( $paged > 2 ) echo "<a href='" . get_pagenum_link( 1 ) . "'>&laquo;</a>";
         if( $paged > 1 ) echo "<a href='" . get_pagenum_link( $paged - 1 ) . "'>&lsaquo;</a>";

         for ( $i=1; $i <= $pages; $i++ )
         {
             if( 1 != $pages &&( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) )
             {
                 $class = ( $paged == $i ) ? " class='selected'" : '';
                 echo "<a href='", get_pagenum_link( $i ), "'$class >$i</a>";
             }
         }

         if ( $paged < $pages ) echo "<a href='", get_pagenum_link( $paged + 1 ), "'>&rsaquo;</a>";  
         if ( $paged < $pages - 1 ) echo "<a href='", get_pagenum_link($pages), "'>&raquo;</a>";
         
         clear();
         
         echo "</div>\n";
     }
}              

function echo_list_option( $option = array(), $value_select = false, $echo = true )
{
	if( empty( $option ) )
		return;
	
	foreach( $option as $key => $value )
	{
		$selected = '';
		if( $value_select != FALSE AND $key == $value_select )
			$selected = ' selected="selected"';
			
		$html .= "<option value=\"$key\"$selected>$value</option>\n";
	}
	
	if( $echo )
		echo $html;
		
	return $html;
}

// SHOP
if( !function_exists('format_price') )
{
	function format_price( $price, $echo = TRUE )
	{
		$pattern = '/(.*).([0-9]{2})/';
		if( preg_match( $pattern, $price ) )
			$price = preg_replace( $pattern, '$1<sup>$2</sup>', $price );
		
		if( $echo )  
			echo $price;
			
		return $price;
	}
}            

function if_ecommerce()
{
	return plugin_is_activated( 'wp-e-commerce/wp-shopping-cart.php' );
}    

function get_pageID_by_pagename( $page_name )
{
	global $wpdb;
	return $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$page_name'");
}                             

function yiw_get_slides( $key = false )
{                 	
	$return = array();
	
	if( $post_types = get_option( 'bl_accordion_sliders' ) )
    {
    	foreach( unserialize( $post_types ) as $id => $value )
		{
			switch( $key )
			{
				case 'name' :
					$return[] = $value;
				break;
				
				case 'slug' :
					$return[] = strtolower( str_replace( ' ', '_', $value ) );
				break;
				
				case FALSE :
					$return[$id]['name'] = $value;
					$return[$id]['slug'] = strtolower( str_replace( ' ', '_', $value ) );
				break;
			}
		}
    }
    else
    {
		$return = array();
	}
	
	return $return;
}                      

function url_to_pathname( $url )
{
	return str_replace( 'http://' . $_SERVER['SERVER_NAME'], $_SERVER['DOCUMENT_ROOT'], $url );
}              



// lenghts
function excerpt_length_testimonials_slider()
{
	return get_option( 'bl_testimonial_slider_words_split', 13 );
}           
function excerpt_more_testimonials_slider()
{
	return '...';
}           
?>