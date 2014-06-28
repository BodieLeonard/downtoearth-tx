<?php
/**
 * Widgets
 * 
 * Main file for manage widget.     
 * 
 * @package WordPress
 * @subpackage Kassyopea
 * @author YIW
 */

// unregister all default WP Widgets
function unregister_default_wp_widgets() 
{ 
	//unregister_widget('WP_Widget_Pages');
	//unregister_widget('WP_Widget_Calendar');
	//unregister_widget('WP_Widget_Archives');
	//unregister_widget('WP_Widget_Links');
	//unregister_widget('WP_Widget_Meta');
	//unregister_widget('WP_Widget_Search');
	//unregister_widget('WP_Widget_Text');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	//unregister_widget('WP_Widget_Recent_Comments');
	//unregister_widget('WP_Widget_RSS');
	//unregister_widget('WP_Widget_Tag_Cloud');
}
  
add_action( 'widgets_init', 'unregister_default_wp_widgets', 1); 

add_action( 'widgets_init', 'yiw_register_widgets' ); 

function yiw_register_widgets() 
{
   register_widget( 'icon_text' );
   register_widget( 'testimonials' );
   register_widget( 'almost_all_categories' );
   //register_widget( 'gallery_categories' );
   register_widget( 'last_tweets' );
   register_widget( 'featured_projects' );
   register_widget( 'popular_posts' );
   register_widget( 'recent_posts' );
   register_widget( 'google_map' );
   register_widget( 'quick_contact' );
}

// Icon Text
include_once 'icon_text.php';

// testimonials
include_once 'testimonials.php';

// Almost Categories
include_once 'almost_all_categories.php';

// Gallery Categories
include_once 'gallery_categories.php';

// Last Tweets
include_once 'last_tweets.php';

// Featured Projects
include_once 'featured_projects.php';

// Popular Posts
include_once 'popular_posts.php';

// Recent Posts
include_once 'recent_posts.php';

// Google Map
include_once 'google_map.php';

// Quick Contact Form
include_once 'quick_contact.php';
?>