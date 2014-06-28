<?php
// define the color folder
define("COLORS_FOLDER", 'colors');

define("ACTIVE_COLOR_PICKER", 0);     

$root = get_template_directory_uri() . '/images/';      

$color_theme = get_color_scheme( 'grey' );                        
    
// default colors set    
$default_color = array(
    'bg-body' => '#fff',
    'color-text' => '#535252',
    'color-links' => '#b91003', 
    'color-links-hover' => '#b91003', 
    'color-nav' => '#858484', 
    'color-nav-hover' => '#4F4F4F', 
    'color-nav-descr' => '#515050',
    'color-titles' => '#535252',   
    'color-evid' => '#b91003', 
    'newsletter-input' => '#AFAFAE',
    'newsletter-submit' => '#525050',
    'title-footer' => '#141414',
    'bg-copyright' => '#525050',
    'bg-flickr' => '#BCBBBB',
    'border-flickr' => '#ECECEC',
    'border-quick-contact' => '#E1E1E1',
    'bg-quick-contact' => '#AEADAD',
); 
    
$default_images = array(
    'gradient-home-section'	=> "$root/bg/gradient-home-section.png",
    'home-section-bg'		=> "$root/bg/home-section-bg.png",     
    'pag-slider'			=> "$root/bg/pag-slider.png",
    'logo'					=> "$root/logo.png"
);

// return the color of the theme
function get_color_scheme( $default = null )
{
	$color_theme = $default; 
	
	if( get_option( 'aa_active_colorpicker' ) AND isset( $_GET['style'] ) ) {
		setcookie( 'bl_color_scheme', $style, time()-3600 );
	    $style = $_GET['style'];
	    if( in_array( $style, get_list_colors() ) )
	    {
	        setcookie( 'bl_color_scheme', $style, time() + 3600, '/' );
	        $color_theme = $style;           
	    }    
	    //echo $color_theme;
	}
	elseif( get_option( 'aa_active_colorpicker' ) AND isset( $_COOKIE['bl_color_scheme'] ) )
		$color_theme = $_COOKIE['bl_color_scheme'];    
	elseif( get_option('bl_color_scheme') != '' ) 
	    $color_theme = get_option('bl_color_scheme');   
	
	return $color_theme;    	
}

// add additional style for color, if it exists
function add_style_color()
{
	global $color_theme;                
	
	if ( substr( 'abcdef', 0, 1 ) == '#' )
		return;
	
	//$path = get_template_directory_uri();
    //$path = str_replace("http://$_SERVER[SERVER_NAME]", "$_SERVER[DOCUMENT_ROOT]", $path);
    
    $path_css = "/css/colors/$color_theme.css";
    
    if( file_exists( dirname(__FILE__) . '/..' . $path_css ) )
	    wp_enqueue_style( "color-$color_theme", get_template_directory_uri() . $path_css );
}
add_action( 'init', 'add_style_color' );

/**
 * In questa funzione cosa viene fatto?
 * - viene richiamato il colore globale che viene scelto;
 * - viene inserito un array con delle path di default per ogni immagine che potrà essere modificata, in base al colore, specificandone soltanto la cartella in cui si troverà di default
 * - viene passato in parametro il nome dell'immagine che si intende controllare.
 * 
 * E cosa fa?
 * - controlla se il nome dell'immagine passato in parametro (compreso di estensione) esista nella cartella dedicata al colore
 * - Se esiste, allora ritornerà il path assoluto di quell'immagine, prelevata dalla cartella colore
 * - Altrimenti, se non esiste alcune immagine nella cartella del colore, farà riferimento all'array $default per prendere la directory di default, da cui prendere l'immagine.
 * 
 *  
 **/        
function get_image($img, $echo = TRUE)
{
    global $color_theme, $default_images;
    
    $root = get_template_directory_uri() . '/images';
    $root_dir = dirname(__FILE__) . '/../images';
    $exts = explode(';', '.gif;.png;.jpg');
    
    $path = "$root_dir/".COLORS_FOLDER."/$color_theme/$img";
    
    $path_ext = FALSE;
    foreach($exts as $ext)
    {
        if( file_exists($path.$ext) ) 
        {
            $path_ext = $ext;
            break;
        }
    }
          
    if(!$path_ext)
    {
        $url = $default_images[$img];
    }            
    else
    {
        $url = "$root/".COLORS_FOLDER."/$color_theme/$img{$path_ext}";
    } 
    
    if( $img == 'logo' AND $logo = get_option('bl_logo') AND $logo != '' ) 
	{
		$the_ = unserialize( $logo );       
		if( $the_['url'] != '' ) $url = $the_['url'];
	}           
        
    if($echo) echo 'background-image:url(\'' . $url . '\');';
    return $url;
}     

function get_color($name, $echo = TRUE, $default = FALSE)
{
    global $default_color, $color_theme;
    
    $codes_color = get_colors();
    
    $color = '';
    if( get_option('bl_color_' . $name . '_' . $color_theme) != '' )
        $color = get_option('bl_color_' . $name . '_' . $color_theme);          
    elseif( ! empty( $codes_color ) AND array_key_exists( $name, $codes_color ) )
		$color = $codes_color[$name];
    else
		$default = TRUE;  
    
    if( $default )
    	$color = $default_color[$name];
    
    if($echo) echo $color;
    return $color;
}

function css_color( $name, $prop )
{                          
	echo $prop, ':', get_color( $name, false ), ';';
}

// get colors from a file text of color theme
function get_colors()
{                            
    global $color_theme;   
    
    $root = get_template_directory_uri() . '/images';
    $root_dir = dirname(__FILE__) . '/../images';
    
    $color_set_file = "$root_dir/".COLORS_FOLDER."/$color_theme/{$color_theme}.txt";
    
    //echo 'URL: '.$color_set_file;
    
    $colors = array();
    if( file_exists($color_set_file) ) $colors = file($color_set_file);
    
    $codes = array();
    foreach($colors as $color_code)
    {
        $color_code = trim($color_code);
        
        // exclude the comments, with // str
        $str = explode("//", $color_code);
        
        // divide tag_name from code color
        list($tag, $code) = explode(":", $str[0]);
        
        $codes[$tag] = $code;
    }
    
    return $codes;
}

function get_list_colors()
{
    $folder = dirname(__FILE__) . '/../images/' . COLORS_FOLDER;
	
    $files = array();        
    
    if ( file_exists($folder) && $handle = opendir($folder) ) 
    {                                
       while (false !== ($file = readdir($handle))) 
       { 
            if ( $file == ".." || $file == "." || preg_match('/([.])/', $file) ) {
                continue;
            }

           $files[$file] = $file;
       }
    
       closedir($handle); 
    } 
    
    return $files;
}

/* COLOR PICKER */

add_option( 'aa_active_colorpicker', ACTIVE_COLOR_PICKER );

if( get_option( 'aa_active_colorpicker' ) )
{
	add_action( 'init', 'yiw_render_header_colorpicker' );
	add_action( 'wp_footer', 'yiw_render_colorpicker' );
}

function yiw_render_header_colorpicker()
{
	wp_enqueue_style( 'color-picker', get_template_directory_uri() . '/css/colorpicker.css' );
	wp_enqueue_script( 'tab-slider-out', 'http://tab-slide-out.googlecode.com/files/jquery.tabSlideOut.v1.3.js', array('jquery')); 
}

function get_url_color( $col )
{                                                              
	$qs = array();
	
	foreach( $_GET as $key => $value )
		if( $key != 'style' ) 
			$qs[] = "$key=$value";
	
	$qs[] = "style=$col";		
	
	return "?" . implode( '&amp;', $qs );
}

function yiw_render_colorpicker()
{
	?>
	<!-- START COLOR LIVE PICKER -->
    <div id="color-picker">
        
        <div class="label"></div>
        
        <?php 
        $colors_pick = get_list_colors();
        
        echo '<h5>Colors</h5>';
        foreach($colors_pick as $col)
        {
            echo "<a href=\"" . get_url_color( $col ) . "\" class=\"$col color\" title=\"" . ucfirst($col) . "\">$col</a>\n";
        }
        
        echo do_shortcode('[clear]');
        ?>
    </div>
    <script type="text/javascript">
        (function($){
            $('#color-picker a').tipsy({fade:true, gravity:'s'});   
        })(jQuery);
        
        jQuery(document).ready(function($){
                
            $('#color-picker').tabSlideOut({
                tabHandle: '#color-picker .label',                     //class of the element that will become your tab
                pathToTabImage: '<?php echo get_template_directory_uri() ?>/images/icons/gear32.png', //path to the image for the tab //Optionally can be set using css
                imageHeight: '32px',                     //height of tab image           //Optionally can be set using css
                imageWidth: '32px',                       //width of tab image            //Optionally can be set using css
                tabLocation: 'left',                      //side of screen where tab lives, top, right, bottom, or left
                speed: 300,                               //speed of animation
                action: 'click',                          //options: 'click' or 'hover', action to trigger animation
                topPos: '70px',                          //position from the top/ use if tabLocation is left or right
                leftPos: '0px',                          //position from left/ use if tabLocation is bottom or top
                fixedPosition: true                      //options: true makes it stick(fixed position) on scroll
            });

        });
    </script>
    <!-- END COLOR LIVE PICKER -->
	<?php
}
?>
