<?php 
require_once '../includes/mtx-safe-wp-load.php';  
header("Content-type: text/css");
?>
/*
    Color Scheme: <?php echo $color_theme ?>
    
*/
#content { <?php css_color( 'bg-body', 'background-color' ) ?> }
		                                                
p, li, address, label, td, th, .sidebar li a, #footer-nav li a, p.title-product a, .widget_price_range a, #product-specials div { <?php css_color( 'color-text', 'color' ) ?> }
a, #recentcomments a, .sidebar .tweets-widget a #recentcomments a:hover, .sidebar .tweets-widget a:hover, .widget_price_range a:hover, 
.widget_price_range a:hover, .sidebar li a:hover { <?php css_color( 'color-links', 'color' ) ?> } 
a:hover, #footer-nav li a:hover, p.title-product a:hover { <?php css_color( 'color-links-hover', 'color' ) ?> } 

#nav li a { <?php css_color( 'color-nav', 'color' ) ?> }
#nav li a:hover, #nav li.current-menu-item a, #nav li.current-menu-parent a { <?php css_color( 'color-nav-hover', 'color' ) ?> }
#nav ul.sub-menu li a span { <?php css_color( 'color-nav-descr', 'color' ) ?> }   

h1 span, h2 span, h3 span, h4 span, h5 span, h6 span, span.highlight-text, .name-testimonial span.title,                    
h1.red-normal, h2.red-normal, h3.red-normal, h4.red-normal, h5.red-normal, h6.red-normal, #footer-nav li.current-menu-item a,
.productdisplay div.producttext h2.prodtitles, .productdisplay div.producttext h4, .productdisplay div.producttext .rating strong,
body.wpsc #content .sidebar h3, #slider .panel .hentry h2, .sidebar-small-size h3, .sidebar-small-size h2 
{ <?php css_color( 'color-evid', 'color' ) ?> }  

h1, h2, h3, h4, h5, h6 { <?php css_color( 'color-titles', 'color' ) ?> }

input.email-newsletter { <?php css_color( 'newsletter-input', 'background-color' ) ?> }
input.subscribe-newsletter { <?php css_color( 'newsletter-submit', 'background-color' ) ?> }

#logo a { <?php get_image('logo') ?> }
#home-section { <?php get_image('home-section-bg') ?> }
#home-section .inner { <?php get_image('gradient-home-section') ?> }

#slider .pagination a { <?php get_image('pag-slider') ?> }

#footer h2 { <?php css_color( 'title-footer', 'color' ) ?> }
.flickr img { <?php css_color( 'bg-flickr', 'background-color' ) ?><?php css_color( 'border-flickr', 'border-color' ) ?> }
#quick-contact-form input, #quick-contact-form textarea { <?php css_color( 'bg-quick-contact', 'background-color' ) ?><?php css_color( 'border-quick-contact', 'border-color' ) ?> }

#copyright { <?php css_color( 'bg-copyright', 'background-color' ) ?> }

/*typography*/
.yes_js p, li, .yes_js address, .yes_js label, .yes_js td, .yes_js th, .yes_js .sidebar li a, .wpsc-crumb, #home-section p, #content a.more-button, #content .more-button a, #content .more-button input, #content .more-button button, #commentform .form-submit input 
  { <?php string_( 'font-size:', get_option_fontsize( 'p' ), 'px;' ) ?> }
.yes_js h1 { <?php string_( 'font-size:', get_option_fontsize( 'h1' ), 'px;' ) ?> }
.yes_js h2 { <?php string_( 'font-size:', get_option_fontsize( 'h2' ), 'px;' ) ?> }
.yes_js h3 { <?php string_( 'font-size:', get_option_fontsize( 'h3' ), 'px;' ) ?> }
.yes_js h4 { <?php string_( 'font-size:', get_option_fontsize( 'h4' ), 'px;' ) ?> }
.yes_js h5 { <?php string_( 'font-size:', get_option_fontsize( 'h5' ), 'px;' ) ?> }
.yes_js h6 { <?php string_( 'font-size:', get_option_fontsize( 'h6' ), 'px;' ) ?> }

.yes_js .sidebar-small-size h3 { <?php string_( 'font-size:', get_option_fontsize( 'h5' ), 'px;' ) ?> }

div.cartcount { <?php string_( 'font-size:', get_fontsize( 'none', 'topbar' ), 'px;' ) ?> }