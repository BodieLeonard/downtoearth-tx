<?php                             
require_once 'install_panel.php';  

function install_add_init() 
{
    $file_dir = get_bloginfo('template_directory')."/admin-options/include";
    
    wp_enqueue_style("functions", $file_dir."/functions.css", false, "1.0", "all"); 
    wp_enqueue_style("wp-admin");
		
	$deps = array(
		'jquery'
	);
                                                                                                                                                 
    wp_enqueue_script("rm_script", $file_dir."/rm_script.js", $deps, '1.0', true); 
}                   
if ( isset( $_GET['page'] ) AND ( $_GET['page'] == basename(__FILE__) OR preg_match('/sub-page-(.*)/', $_GET['page']) ) ) 
	add_action('admin_init', 'install_add_init');   
	
// tables to export or import
$tables = array( 'posts', 'postmeta', 'terms', 'term_taxonomy', 'term_relationships' );

function export_theme()
{
	global $wpdb, $tables;
	
	$db = array();  // all backup will be in this array
	
	// retrive all values of tables
	foreach( $tables as $table )
	{
		if( $table == 'posts' )
			$where = " WHERE post_type <> 'revision'";
		else
			$where = '';
			
		$db[$table] = $wpdb->get_results( "SELECT * FROM {$wpdb->$table}{$where}", ARRAY_A );
	}
	
	// options
	$theme = get_option( 'stylesheet' );
	$sql = "SELECT blog_id, option_name, option_value, autoload FROM {$wpdb->options} 
WHERE 	option_name LIKE 'bl\_%' 
OR		option_name = 'sidebars_widgets'
OR		option_name = 'show_on_front'
OR		option_name = 'page_on_front'
OR		option_name = 'page_for_posts'
OR		option_name LIKE 'widget%'
OR		option_name LIKE 'theme\_mods\_%'";

	if( if_ecommerce() )
		$sql .= " OR option_name LIKE 'wpsc_%'";
	
	$sql .= ';';

	$db['options'] = $wpdb->get_results( $sql, ARRAY_A );
	
	//echo '<pre>', print_r( $db ), '</pre>'; die;
	
	$info['content'] = gzcompress( base64_encode( serialize( $db ) ), 9 );
	$info['filename'] = 'themewp_export_' . time() . '.gz';

	return $info;
}   

function import_theme()
{
	global $wpdb, $tables;      
    
    $wpdb->show_errors();
	
	if( !isset( $_FILES['import-file'] ) )
		wp_die( __( "The file you have insert doesn't valid.", 'yiw' ) );    
	
	set_time_limit(0);
	
	switch ( substr( $_FILES['import-file']['name'], -3 ) ) {
	
	   case 'xml' :
    	   $error = __( sprintf( "The file you have insert is a WordPress eXtended RSS (WXR) file. You need to use this into the %s admin page to import this file. Here only <b>.gz</b> file are allowed.", '<a href="'.admin_url( 'import.php', false ).'">'.__( 'Tools -> Import', 'yiw' ).'</a>' ), 'yiw' ); 
    	   echo '<div id="message" class="error fade"><p>'.$error.'</p></div>';
           return;
	
	   case 'zip' :
	   case 'rar' :
    	   $error = __( sprintf( "The file you have insert is a ZIP or RAR file, that it doesn't allowed in this case. Here only <b>.gz</b> file are allowed.", '<a href="'.admin_url( 'import.php', false ).'">'.__( 'Tools -> Import', 'yiw' ).'</a>' ), 'yiw' ); 
    	   echo '<div id="message" class="error fade"><p>'.$error.'</p></div>';
           return;
	}                
	
	if ( substr( $_FILES['import-file']['name'], -2 ) != 'gz' ) {
    	   $error = __( sprintf( "The file you have insert is not a valid file. Here only <b>.gz</b> file are allowed.", '<a href="'.admin_url( 'import.php', false ).'">'.__( 'Tools -> Import', 'yiw' ).'</a>' ), 'yiw' ); 
    	   echo '<div id="message" class="error fade"><p>'.$error.'</p></div>';
           return;
    }
	
	// get db encoded
	$content_file = file_get_contents( $_FILES['import-file']['tmp_name'] );
	
	$db = unserialize( base64_decode( gzuncompress( $content_file ) ) ); 
	
	//echo '<pre>', print_r( $db ), '</pre>'; die;
	
	if( !is_array( $db ) )
		wp_die( __( 'An error encoured during during import. Please try again.', TEXTDOMAIN ) );
	
	// tables
	foreach( $tables as $table )
	{
		string_( '<p></p><p><strong>', '// ' . $table, '</strong><br />' );
		                                      
		// delete all row of each table
		$wpdb->query( "TRUNCATE TABLE {$wpdb->$table}" );
		string_( '', sprintf( __( 'Truncated %s table', TEXTDOMAIN ), $wpdb->$table ), '...<br />' );  
		
		// insert new data
		$error_data = array(); 
		foreach( $db[$table] as $id => $data )
		{                            
			if( $wpdb->insert( $wpdb->$table, $data ) )
				$insert = true;
			else
				$insert = false;   
			
			// save the ID that has error, to show.
			if( !$insert )
				$error_data[] = $id;         
		}                          
		                                     
		if( $insert )
			string_( '', sprintf( __( 'Insert new values into %s table', TEXTDOMAIN ), $wpdb->$table ), '...</p>' );
		else
			string_( '', sprintf( __( 'Error during insert new values (IDs: %s), in %s table', TEXTDOMAIN ), implode( $error_data, ' ' ), $wpdb->$table ), '...</p>' );
	}
	
	string_( '<p></p><p><strong>', '// options', '</strong><br />' );
	
	// delete options               
	$theme = get_option( 'stylesheet' );
	$sql = "DELETE FROM {$wpdb->options} 
WHERE 	option_name LIKE 'bl\_%' 
OR		option_name = 'sidebars_widgets'
OR		option_name = 'show_on_front'
OR		option_name = 'page_on_front'
OR		option_name = 'page_for_posts'
OR		option_name LIKE 'widget%'
OR		option_name LIKE 'theme\_mods\_%'
OR		option_name LIKE 'wpsc%'";  

	if( if_ecommerce() )
		$sql .= " AND option_name LIKE 'wpsc_%'"; 
	
	$sql .= ';';
    
	if( $wpdb->query( $sql ) )  
		string_( '', sprintf( __( 'Deleted value from %s table', TEXTDOMAIN ), $wpdb->options ), '...<br />' );
	else
		string_( '', sprintf( __( 'Error during deleting from %s table (SQL: %s)', TEXTDOMAIN ), $wpdb->options, $sql ), '...<br />' ); 
		    
	
	// update options
	$error_data = array();             
    $check = $wpdb->get_results( "SELECT * FROM {$wpdb->options} WHERE option_id = 1", ARRAY_A );
	foreach( $db['options'] as $id => $option )
	{                             
		if ( ! isset( $check['blog_id'] ) )
            unset( $option['blog_id'] );
          
        if( $wpdb->insert( $wpdb->options, $option ) )
			$insert = true;	
		else
			$insert = false;   
			
		// save the ID that has error, to show.
		if( !$insert )
			$error_data[] = $id; 	  
            
        // save the ID that has error, to show.
        if( !$insert )
            $wpdb->print_error();//$error_data[] = $option['option_name'];    
	}          
	                
	if( $insert )
		string_( '', sprintf( __( 'Insert new values, into %s table', TEXTDOMAIN ), $wpdb->options ), '...</p>' );	
	else
		string_( '', sprintf( __( 'Error during insert new values (IDs: %s), into %s table', TEXTDOMAIN ), implode( $error_data, ' ' ), $wpdb->options ), '...</p>' );	
	                               
	   
// 	// uploads
// 	string_( '<p></p><p><strong>', '// uploads', '</strong><br />' ); 
// 	
// 	// remove all directory from uploads
// 	//destroy( WP_CONTENT_DIR . '/uploads/' );
// 	
// 	// download new files
// 	foreach( $db['posts'] as $post )
// 	{
// 		if( $post['post_type'] != 'attachment' )
// 			continue;
// 		
// 		$file = explode( '/uploads/', $post['guid'] );
// 		$to = WP_CONTENT_DIR . '/uploads/' . $file[1];
// 		
// 		// create folder
// 		if( !is_dir( dirname( $to ) ) )
// 			mkdir( dirname( $to ), 0777, true );   
// 		  
// 		if( downloadRemoteFile( $post['guid'], $to ) )
// 			string_( '', sprintf( __( 'Moved file from %s to %s', TEXTDOMAIN ), $post['guid'], $to ), '...<br />' );
// 		else                              
// 			string_( '', sprintf( __( 'Error during move file from %s to %s', TEXTDOMAIN ), $post['guid'], $to ), '...<br />' ); 
// 		
// 		$uploads_ = wp_upload_dir();
// 		$new_path = $uploads_['baseurl'] . '/' . $file[1];
// 		
// 		$wpdb->query( "UPDATE $wpdb->posts SET guid = '$new_path' WHERE ID = '$post[ID]'" );
// 		
// 		// downloads others images dimension
// 		global $_wp_additional_image_sizes;
// 		
// 		foreach( $_wp_additional_image_sizes as $size_thumb )
// 		{
// 			list( $attach_url, $attach_width, $attach_height ) = wp_get_attachment_image_src( $post['ID'], 'full' );
// 			list( $new_width, $new_height ) = wp_constrain_dimensions( $attach_width, $attach_height, $size_thumb['width'], $size_thumb['height'] );
// 			
// 			list( $attach_name, $attach_ext ) = explode( '.', basename( $post['guid'] ) );
// 			
// 			$new_path_from 	= dirname( $post['guid'] ) 	. '/' . $attach_name . '-' . $new_width . 'x' . $new_height . '.' . $attach_ext;
// 			$new_path_to 	= dirname( $to ) 			. '/' . $attach_name . '-' . $new_width . 'x' . $new_height . '.' . $attach_ext;
// 		  
// 			if( downloadRemoteFile( $new_path_from, $new_path_to ) )
// 				string_( '', sprintf( __( 'Moved file from %s to %s', TEXTDOMAIN ), $new_path_from, $new_path_to ), '...<br />' );
// 			else                              
// 				string_( '', sprintf( __( 'Error during move file from %s to %s', TEXTDOMAIN ), $new_path_from, $new_path_to ), '...<br />' ); 
// 		}
// 	}
	
	echo '</p>';    
	
	return true;
}         

function destroy( $dir ) 
{
    $mydir = opendir( $dir );
    
	while( false !== ( $file = readdir( $mydir ) ) ) {
        
		if( $file != "." && $file != ".." ) {
            
			chmod( $dir . $file, 0777 );
            
			if( is_dir( $dir . $file ) ) {
                chdir( '.' );
                destroy( $dir . $file . '/' );
                rmdir( $dir . $file ) or die( "couldn't delete $dir$file<br />" );
            }
            else
                unlink( $dir . $file ) or die( "couldn't delete $dir$file<br />" );
        }
    }
    closedir( $mydir );
}                   

function downloadRemoteFile( $url, $dir, $file_name = NULL )
{
    if( $file_name == NULL )
		$file_name = basename( $url );
		
    $url_stuff = parse_url( $url );
    $port = isset( $url_stuff['port'] ) ? $url_stuff['port'] : 80;

    $fp = fsockopen( $url_stuff['host'], $port );
    if( !$fp )
		return false;

    $query  = 'GET ' . $url_stuff['path'] . " HTTP/1.0\n";
    $query .= 'Host: ' . $url_stuff['host'];
    $query .= "\n\n";

    fwrite( $fp, $query );

    while ( $tmp = fread( $fp, 8192 ) )
        $buffer .= $tmp;               

    preg_match( '/Content-Length: ([0-9]+)/', $buffer, $parts );
    $file_binary = substr( $buffer, - $parts[1] ); 
    
    if( $file_name == NULL )
	{
        $temp = explode( ".", $url );
        $file_name = $temp[ count( $temp ) - 1 ];
    }
    
    $file_open = fopen( dirname( $dir ) . "/" . $file_name, 'w' );
    
	if( !$file_open )
		return false;
		
    fwrite( $file_open, $file_binary );
    fclose( $file_open );
    
    return true;
}  
?>