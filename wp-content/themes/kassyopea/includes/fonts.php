<?php                  

$actual_font = get_option( 'bl_font', 'delicious' );  

// sizes for fonts
$sizes_fonts = array (
	
	'default' => array (         
			'p'				=> 13,
			'h1' 			=> 30,  
			'h2' 			=> 24,  
			'h3' 			=> 20,  
			'h4' 			=> 18,  
			'h5' 			=> 16,  
			'h6' 			=> 14,
			'nav'			=> 14,
			'topbar'		=> 13, 
			'profile-slider'=> 13, 
			'title-testim'	=> 16,   
			'calltoaction-h'=> 36,  
			'calltoaction-p'=> 16, 
			'contact-label' => 20, 
			'contact-sublabel'=> 14, 
			'project-widget'=> 16 
	),
	
	'delicious' => array (       
			'p'				=> 13,
			'h1' 			=> 36,  
			'h2' 			=> 32,  
			'h3' 			=> 28,  
			'h4' 			=> 24,  
			'h5' 			=> 20,  
			'h6' 			=> 18,
			'nav'			=> 18,
			'topbar'		=> 16,    
			'profile-slider'=> 16,      
			'title-testim'	=> 18,  
			'calltoaction-h'=> 48,      
			'calltoaction-p'=> 20,  
			'contact-label' => 24, 
			'contact-sublabel'=> 18,     
			'project-widget'=> 20, 
	),
	
	'dustismo' => array (           
			'p'				=> 13,
			'h1' 			=> 34,  
			'h2' 			=> 30,  
			'h3' 			=> 26,  
			'h4' 			=> 22,  
			'h5' 			=> 18,  
			'h6' 			=> 16,
			'nav'			=> 16,
			'topbar'		=> 14,    
			'profile-slider'=> 15,      
			'title-testim'	=> 16,  
			'calltoaction-h'=> 46,      
			'calltoaction-p'=> 18,  
			'contact-label' => 22, 
			'contact-sublabel'=> 16,     
			'project-widget'=> 18, 
	),    
	
	'League_gothic' => array (      
			'p'				=> 13,
			'h1' 			=> 40,  
			'h2' 			=> 36,  
			'h3' 			=> 32,  
			'h4' 			=> 28,  
			'h5' 			=> 24,  
			'h6' 			=> 20,
			'nav'			=> 18,
			'topbar'		=> 16,    
			'profile-slider'=> 16,      
			'title-testim'	=> 18,  
			'calltoaction-h'=> 48,      
			'calltoaction-p'=> 20,  
			'contact-label' => 24, 
			'contact-sublabel'=> 18,     
			'project-widget'=> 20, 
	),    
	                               
	'reklame' => array (            
			'p'				=> 13,
			'h1' 			=> 40,  
			'h2' 			=> 36,  
			'h3' 			=> 32,  
			'h4' 			=> 28,  
			'h5' 			=> 24,  
			'h6' 			=> 20,
			'nav'			=> 18,
			'topbar'		=> 16,    
			'profile-slider'=> 16,      
			'title-testim'	=> 18,  
			'calltoaction-h'=> 48,      
			'calltoaction-p'=> 20,  
			'contact-label' => 24, 
			'contact-sublabel'=> 18,     
			'project-widget'=> 20,  
	),    
);

function get_list_fonts()
{
    $folder = dirname(__FILE__) . '/../fonts/';
	
    $files = array();
	$files['default'] = 'No font';        
    
    if ( file_exists($folder) && $handle = opendir($folder) ) 
    {                                
       while (false !== ($file = readdir($handle))) 
       { 
	        if ( $file == ".." || $file == "." || $file[0] == '.' ) {
	            continue;
	        }
	        
	        $file = preg_replace( '/(.*).font.(.*)/', '$1', $file );

           $files[$file] = ucfirst( str_replace( '_', ' ', $file ) );
       }
    
       closedir($handle); 
    } 
    
    return $files;
}        

function get_fontsize( $font, $element )
{
	global $sizes_fonts;
	
	if( isset( $sizes_fonts[$font][$element] ) )
		$size = $sizes_fonts[$font][$element];
	else
		$size = $sizes_fonts['default'][$element];
	
	return $size;
}

function get_option_fontsize( $el )
{
	global $actual_font;
	
	$if_font = get_option( "bl_{$el}_size_{$actual_font}", get_fontsize( $actual_font, $el ) );
	
	if( !$if_font )
		return '';
	
	return $if_font;
}
?>
