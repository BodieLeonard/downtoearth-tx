<?php
/**
 * @package WordPress
 * @subpackage Kassyopea
 * 
 * Here the first hentry of theme, when all theme will be loaded.
 * On new update of theme, you can not replace this file.
 * You will write here all your custom functions, they remain after upgrade.
 */                                                           

require_once dirname(__FILE__) . '/includes/functions.php';   

/*-----------------------------------------------------------------------------------*/
/* End Theme Load Functions - You can add custom functions below */
/*-----------------------------------------------------------------------------------*/	

$wpsc_pages = array(
	'products',
	'products-page',
	'donate',
	'checkout',
	'transaction-results',
	'your account',
	'shop'
);	

function yiw_add_body_class( $classes = '' ) {
	global $wpsc_pages;
	
	foreach ( $wpsc_pages as $page )
		if ( is_page( $page ) )
			$classes[] = 'wpsc-' . $page;
	
	if ( is_page_template('store.php') ) 
		$classes[] = 'wpsc';
	
	return $classes;
}
add_filter( 'body_class', 'yiw_add_body_class' );

function yiw_check_sidebar( $sidebar ) {
	global $wpsc_pages;
	
	if ( is_page( $wpsc_pages ) || is_post_type_archive( 'wpsc-product' ) || 'wpsc-product' == get_post_type() || is_tax( 'wpsc_product_category' ) ) 
		return 'Shop Sidebar';
	else
		return $sidebar;	
} 
add_filter( 'yiw_sidebar', 'yiw_check_sidebar' );

?>