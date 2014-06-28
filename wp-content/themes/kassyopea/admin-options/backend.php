<?php

/**
 * Custom types name
 */
define('TYPE_TESTIMONIALS', 'bl_testimonials');
define('TYPE_PORTFOLIO', 'bl_portfolio');
define('TYPE_GALLERY', 'bl_gallery');
define('TYPE_FAQ', 'bl_faq');

add_action( 'init', 'yiw_register_post_types', 0  );
add_action( 'init', 'yiw_register_taxonomies', 0  );
add_action( 'init', 'yiw_register_dymanics_types', 0  );

if( isset( $_GET['post_type'] ) )
{
	switch( $_GET['post_type'] )
	{
		case TYPE_TESTIMONIALS :
			add_action( 'manage_posts_custom_column',  'yiw_bl_testimonials_custom_columns');
			add_filter( 'manage_edit-'.TYPE_TESTIMONIALS.'_columns', 'yiw_bl_testimonials_edit_columns');
		break;
			
		case TYPE_PORTFOLIO :
			if( get_option( 'bl_panel_portfolioshow' ) )
			{
				add_action( 'manage_posts_custom_column',  'yiw_bl_portfolio_custom_columns');
				add_filter( 'manage_edit-'.TYPE_PORTFOLIO.'_columns', 'yiw_bl_portfolio_edit_columns'); 
			}
		break;  
			
		case TYPE_GALLERY :
			if( get_option( 'bl_panel_galleryshow' ) )
			{
				add_action( 'manage_posts_custom_column',  'yiw_bl_gallery_custom_columns');
				add_filter( 'manage_edit-'.TYPE_GALLERY.'_columns', 'yiw_bl_gallery_edit_columns'); 
			}
		break;      
			
		case TYPE_FAQ :
			add_action( 'manage_posts_custom_column',  'yiw_bl_faq_custom_columns');
			add_filter( 'manage_edit-'.TYPE_FAQ.'_columns', 'yiw_bl_faq_edit_columns'); 
		break;      
		      
		default :
			if( in_array( $_GET['post_type'], yiw_get_slides( 'slug' ) ) ) {                                                          
				add_action( 'manage_posts_custom_column',  'yiw_default_custom_columns' );
				add_filter( 'manage_edit-'.$_GET['post_type'].'_columns', 'yiw_default_edit_columns');
			}
		break;                                  
	}
}

/**
 * Register post types for the theme
 *
 * @return void
 */
function yiw_register_post_types(){
  
	register_post_type(         
        TYPE_TESTIMONIALS,
        array(
		  'description' => __('Testimonals', TEXTDOMAIN),
		  'exclude_from_search' => false,
		  'show_ui' => true,
		  'labels' => yiw_label(__('Testimonial', TEXTDOMAIN), __('Testimonials', TEXTDOMAIN)),
		  'supports' => array( 'title', 'editor', 'thumbnail' ),
		  'public' => true,
		  'capability_type' => 'post',
    	  'publicly_queryable' => true,
		  'rewrite' => array( 'slug' => TYPE_TESTIMONIALS, 'with_front' => true )
        )
    ); 
  
  	if( get_option( 'bl_panel_portfolioshow' ) )
		register_post_type(         
	        TYPE_PORTFOLIO,
	        array(
			  'description' => __('Portfolio', TEXTDOMAIN),
			  'exclude_from_search' => false,
			  'show_ui' => true,
			  'labels' => yiw_label(__('Work', TEXTDOMAIN), __('Works', TEXTDOMAIN), __('Portfolio', TEXTDOMAIN)),
			  'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			  'public' => true,
			  'capability_type' => 'post',
	    	  'publicly_queryable' => true,
			  'rewrite' => array( 'slug' => false, 'with_front' => true ),
			  'taxonomies' => array( 'category-project', 'post_tag' )
	        )
	    ); 
  
  	if( get_option( 'bl_panel_galleryshow' ) ) 
		register_post_type(         
	        TYPE_GALLERY,
	        array(
			  'description' => __('Gallery', TEXTDOMAIN),
			  'exclude_from_search' => false,
			  'show_ui' => true,
			  'labels' => yiw_label(__('Photo', TEXTDOMAIN), __('Photos', TEXTDOMAIN), __('Gallery', TEXTDOMAIN) ),
			  'supports' => array( 'title', 'editor', 'thumbnail' ),
			  'public' => true,
			  'capability_type' => 'post',
	    	  'publicly_queryable' => true,
			  'rewrite' => array( 'slug' => false, 'with_front' => true )
	        )
	    ); 
  
	register_post_type(         
        TYPE_FAQ,
        array(
		  'description' => __('Faq', TEXTDOMAIN),
		  'exclude_from_search' => false,
		  'show_ui' => true,
		  'labels' => yiw_label(__('Faq', TEXTDOMAIN), __('Faqs', TEXTDOMAIN)),
		  'supports' => array( 'title', 'editor', 'revisions' ),
		  'public' => true,
		  'capability_type' => 'page',
    	  'publicly_queryable' => true,
		  'rewrite' => array( 'slug' => TYPE_FAQ, 'with_front' => true )
        )
    ); 
            
	//flush_rewrite_rules();
    
}

/**
 * Registers taxonomies
 * 
 */
function yiw_register_taxonomies()
{
	if( get_option( 'bl_panel_portfolioshow' ) )
	    register_taxonomy('category-project', array( TYPE_PORTFOLIO ), array(
			'hierarchical' => true,
			'labels' => yiw_label_tax(__('Category', TEXTDOMAIN), __('Categories', TEXTDOMAIN)),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'category-project' => 'project' ),
		));
		
	if( get_option( 'bl_panel_galleryshow' ) )
	    register_taxonomy('category-photo', array( TYPE_GALLERY ), array(
			'hierarchical' => true,
			'labels' => yiw_label_tax(__('Category', TEXTDOMAIN), __('Categories', TEXTDOMAIN)),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'category-photo' => 'category-photo' ),
		));
}	 	       
   
/**
 * Registers dynamic custom types and taxonomies
 */
function yiw_register_dymanics_types()
{
	foreach( yiw_get_slides() as $id => $post_type )
	{
		register_post_type(         
	        $post_type['slug'],
	        array(
			  'description' => __('The post type for the content of accordion sliders', TEXTDOMAIN),
			  'exclude_from_search' => false,
			  'show_ui' => true,
			  'label' => $post_type['name'],
			  'supports' => array( 'title', 'editor', 'thumbnail' ),
			  'public' => true,
			  'capability_type' => 'post',
	    	  'publicly_queryable' => true,
			  'rewrite' => array( 'slug' => $post_type['slug'], 'with_front' => true )
	        )
	    );    
		
		//add_filter( 'manage_edit-'.$name_post_type.'_columns', 'yiw_bl_team_edit_columns');
	}                             
                                        
	//flush_rewrite_rules();
}


         

/**
 * Create a custom fields for custom types
 */
 
 
/**
 * bl_team
 */
function yiw_default_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __( "Name", TEXTDOMAIN ),
		"description" => __( "Description", TEXTDOMAIN ),
		"profile" => __( "Profile", TEXTDOMAIN )
	);
	
	return $columns;
}

function yiw_default_custom_columns($column){
	global $post;
	
	switch ($column) {
		case "description":
		  the_excerpt();
		  break;
		case "profile": 
		  echo get_post_meta( $post->ID, '_slider_accordion_subtitle', true );     
		  break;
	}
}	 
 
 
/**
 * testimonials
 */
function yiw_bl_testimonials_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __( "Name", TEXTDOMAIN ),
		"story" => __( "Story", TEXTDOMAIN ),
		"website" => __( "Web Site", TEXTDOMAIN )
	);
	
	return $columns;
}

function yiw_bl_testimonials_custom_columns($column){
	global $post;
	                                      
	switch ($column) {
		case "story":                      
			add_filter('excerpt_length', 'yiw_new_excerpt_length_testimonial');
			add_filter('excerpt_more', 'yiw_new_excerpt_more_testimonial');
		  	
			the_excerpt();     
		  	break;
		case "website":
			$url = get_post_meta( $post->ID, '_testimonial_website', true );
  			echo "<a href=\"" . esc_url( $url ) . "\">$url</a>";
		  	break;
	}                                  

}	                  
	
function yiw_new_excerpt_length_testimonial($length) {
	return 20;
}                                
	
function yiw_new_excerpt_more_testimonial($more) {
	return '[...]';
} 
 
 
/**
 * bl_portfolio
 */
function yiw_bl_portfolio_edit_columns($columns){
	$columns = array(
	    'cb' => '<input type="checkbox" />',
	    'title' => __( 'Portfolio Title', TEXTDOMAIN ),
	    'description-portfolio' => __( 'Description', TEXTDOMAIN ),
	    //'year' => __( 'Year Completed', TEXTDOMAIN ),
	    'category-project' => __( 'Category Project', TEXTDOMAIN ),
	);

	
	return $columns;
}

function yiw_bl_portfolio_custom_columns($column){
	global $post;
	                                      
	switch ($column) {
	    case "description-portfolio":
	      the_excerpt();
	      break;
	    case "year":
	      $custom = get_post_custom();
	      echo $custom["year_completed"][0];
	      break;
	    case "category-project":
	      echo get_the_term_list($post->ID, 'category-project', '', ', ','');
	      break;
	}                            

}	
 
 
/**
 * bl_gallery
 */
function yiw_bl_gallery_edit_columns($columns){
	$columns = array(
	    'cb' => '<input type="checkbox" />',
	    'title' => __( 'Photo Title', TEXTDOMAIN ),
	    'photo' => __( 'Photo', TEXTDOMAIN ),
	    'category-photo' => __( 'Category Photo', TEXTDOMAIN ),
	);

	
	return $columns;
}

function yiw_bl_gallery_custom_columns($column){
	global $post;
	                                      
	switch ($column) {
	    case "photo":
	      the_post_thumbnail( array( 70, 70 ) );
	      break;
	    case "category-photo":
	      echo get_the_term_list($post->ID, 'category-photo', '', ', ','');
	      break;
	}                            

}	
 
 
/**
 * faq
 */
function yiw_bl_faq_edit_columns($columns){
	$columns = array(
	    'cb' => '<input type="checkbox" />',
	    'title' => __( 'Question', TEXTDOMAIN ),
	    'description' => __( 'Answer', TEXTDOMAIN )
	);

	
	return $columns;
}

function yiw_bl_faq_custom_columns($column){
	global $post;
	                                      
	switch ($column) {
	    case "description":
	      	add_filter('excerpt_length', 'yiw_new_excerpt_length_bl_faq');
			add_filter('excerpt_more', 'yiw_new_excerpt_more_bl_faq');
		  	
			the_excerpt();
	      	break;
	}                            

}	      	                  
	
function yiw_new_excerpt_length_bl_faq($length) {
	return 20;
}                                
	
function yiw_new_excerpt_more_bl_faq($more) {
	return '[...]';
}     



add_action( 'admin_head', 'yiw_admin_style' );
function yiw_admin_style() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-team .wp-menu-image {
            background:transparent url('<?php echo home_url();?>/wp-admin/images/menu.png') no-repeat scroll -301px -33px !important;
        }
		#menu-posts-team:hover .wp-menu-image, #menu-posts-team.wp-has-current-submenu .wp-menu-image {
            background-position:-301px -1px!important;
        }
        #menu-posts-blportfolio .wp-menu-image, #menu-posts-blgallery .wp-menu-image {
            background:transparent url('<?php echo home_url();?>/wp-admin/images/menu.png') no-repeat scroll -1px -33px !important;
        }
		#menu-posts-blportfolio:hover .wp-menu-image, #menu-posts-blportfolio.wp-has-current-submenu .wp-menu-image,
		#menu-posts-blgallery:hover .wp-menu-image, #menu-posts-blgallery.wp-has-current-submenu .wp-menu-image {
            background-position:-1px -1px!important;
        }
    </style>
<?php } 



/**
 * Return Labels Post
 *
 * @return array
 */
function yiw_label($singular_name, $name, $title = FALSE)
{
	if( !$title )
		$title = $name;
		
	return array(
      "name" => $title,
      "singular_name" => $singular_name,
      "add_new" => __("Add New", TEXTDOMAIN),
      "add_new_item" => sprintf( __( "Add New %s", TEXTDOMAIN ), $singular_name),
      "edit_item" => sprintf( __( "Edit %s", TEXTDOMAIN ), $singular_name),
      "new_item" => sprintf( __( "New %s", TEXTDOMAIN), $singular_name),
      "view_item" => sprintf( __( "View %s", TEXTDOMAIN), $name),
      "search_items" => sprintf( __( "Search %s", TEXTDOMAIN), $name),
      "not_found" => sprintf( __( "No %s found", TEXTDOMAIN), $name),
      "not_found_in_trash" => sprintf( __( "No %s found in Trash", TEXTDOMAIN), $name),
      "parent_item_colon" => ""
  );
}	 	     

/**
 * Return Labels Post
 *
 * @return array
 */
function yiw_label_tax($singular_name, $name)
{
	return array(
      	'name' => $name,
		'singular_name' => $singular_name,
		'search_items' => sprintf( __( 'Search %s', TEXTDOMAIN ), $name),
		'all_items' => sprintf( __( 'All %s', TEXTDOMAIN ), $name),
		'parent_item' => sprintf( __( 'Parent %s', TEXTDOMAIN ), $singular_name),
		'parent_item_colon' => sprintf( __( 'Parent %s:', TEXTDOMAIN ), $singular_name),
		'edit_item' => sprintf( __( 'Edit %', TEXTDOMAIN ), $singular_name), 
		'update_item' => sprintf( __( 'Update %s', TEXTDOMAIN ), $singular_name),
		'add_new_item' => sprintf( __( 'Add New %s', TEXTDOMAIN ), $singular_name),
		'new_item_name' => sprintf( __( 'New %s Name', TEXTDOMAIN ), $singular_name),
		'menu_name' => $name,
  );
}       