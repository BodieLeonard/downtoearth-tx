<?php
add_action('admin_head','theme_check_ver'); //Theme Update Function
/****************************
Update Noticication Script
By Jeremy Clark

http://clark-technet.com

License: GPL

modified by: YIW (http://www.yourinspirationweb.com/en)
*****************************/
                                                            
$theme_sn = get_option( 'template' );                                 
$remote_file = "http://www.niubbys.altervista.org/kassyopea_.css";
$update_check_int = 24; // hours
        
// get version
if ( function_exists( 'wp_get_theme' ) ) {
    $theme_data = wp_get_theme();
    $version = $theme_data->version;    
} else {
    $theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
    $version = $theme_data['Version'];
}

$local_version = $version;      

$url_download = "http://themeforest.net/item/kassyopea-all-in-one-ecommerce-corporate/202074";
$theme_update_notice = "<p>New version <strong>%s</strong> available of <strong>Kassyopea theme</strong>. <a href=\"$url_download\">Download</a> new version and update your $local_version version!</p>";

$update_last_check = get_option($theme_sn.'_last_ver_check');

function theme_check_ver() {
	global $update_check_int, $update_last_check, $new_ver_notice, $theme_sn, $local_version;
	
 	$update_check_int_seconds = $update_check_int * 3600;
	$now = time();
	
	if ( empty( $update_last_check ) ) 
	{
		//first run
		theme_compare_ver();
		add_option($theme_sn.'_last_ver_check', $now);
	} 
	else 
	{
		$time_ago = $now - $update_last_check;
		if ( $time_ago > $update_check_int_seconds ) 
		{
			theme_compare_ver();
			update_option($theme_sn.'_last_ver_check', $now);
		}
	}        
	
	$remote_version = get_option('remote_version_theme');

    if( !is_update( $local_version, $remote_version ) )
	{
		add_action('admin_notices', 'theme_new_ver');
	}
}

function theme_compare_ver() {
	global $local_version, $theme_sn, $remote_file;  
    
        if( !file_exists( $remote_file ) )  
            return false;    
                           
        if ( function_exists( 'wp_get_theme' ) ) {
            $theme_data = wp_get_theme($remote_file);
            $remote_version = $theme_data->version;    
        } else {
            $theme_data = get_theme_data($remote_file);
            $remote_version = $theme_data['Version'];
        }
		
		update_option( 'remote_version_theme', $remote_version );
		
		if ( !is_update( $local_version, $remote_version ) ) 
		{
			add_action('admin_notices','theme_new_ver');
		}  
}	

function theme_new_ver() {
	global $theme_update_notice, $pagenow;
	//if ( $pagenow == "themes.php") {
?>
		<div id="message" class="updated fade">
		<?php printf( $theme_update_notice, get_option( 'remote_version_theme' ) ); ?>
		</div>
<?php
	//}
}

function is_update( $version1, $version2 )
{
	if ( $version2 > $version1 ) 
		return FALSE;
	else 
		return TRUE;
}         
?>