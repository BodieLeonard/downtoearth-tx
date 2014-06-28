<?php 
global $color_theme, $current_user, $actual_font, $post, $wpsc_pages;

$wpsc_class = '';
if ( is_page( $wpsc_pages ) || is_post_type_archive( 'wpsc-product' ) || 'wpsc-product' == get_post_type() ) 
	$wpsc_class = 'wpsc';
                                                         
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php wp_title(' | ', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />                      
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/prettyPhoto.css" type="text/css" media="screen" />   
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/tipsy.css" type="text/css" media="screen" /> 
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custom.php?style=<?php echo $color_theme ?>" type="text/css" media="screen" /> 
    
    <?php                                      
    	if( plugin_is_activated( 'wp-e-commerce/wp-shopping-cart.php' ) )
    		wp_enqueue_style('wp-ecommerce-style', get_template_directory_uri()."/css/wp-ecommerce.css");
    	
    	wp_enqueue_style('niov-slider', get_template_directory_uri()."/css/nivo-slider.css");
    	
        wp_enqueue_script( 'jquery-cycle',       get_template_directory_uri()."/js/jquery.cycle.all.min.js", array('jquery'), "2.94");
        wp_enqueue_script( 'jquery-easing',      get_template_directory_uri()."/js/jquery.easing.1.3.js", array('jquery'), "1.3");
        wp_enqueue_script( 'jquery-prettyPhoto', get_template_directory_uri()."/js/jquery.prettyPhoto.js", array('jquery'), "3.0");
        wp_enqueue_script( 'jquery-tipsy',       get_template_directory_uri()."/js/jquery.tipsy.js", array('jquery'));
        wp_enqueue_script( 'jquery-hrzAccordion',get_template_directory_uri()."/js/jquery.hrzAccordion.js", array('jquery')); 
        wp_enqueue_script( 'jquery-tweetable',   get_template_directory_uri()."/js/jquery.tweetable.js", array('jquery'));       
        wp_enqueue_script( 'jquery-jcarousel',   get_template_directory_uri()."/js/jquery.jcarousel.min.js", array('jquery'));         
    	wp_enqueue_script( 'jquery-nivo', 		 get_template_directory_uri()."/js/jquery.nivo.slider.pack.js", array('jquery'), "2.5.2" );
        //wp_enqueue_script( 'jquery-quicksend',   get_template_directory_uri()."/js/jquery.quicksand.js", array('jquery'), '1.2.2', true);  
         
        wp_enqueue_script('swfobject');   
		wp_enqueue_script( 'jquery-custom',      get_template_directory_uri()."/js/jquery.custom.js", array('jquery', 'jquery-ui-tabs'), '1.0', true);
        
        wp_localize_script( 'jquery-custom', 'objectL10n', array(
			'wait' => __( 'wait...', TEXTDOMAIN ),
			'emailerror' => get_option( 'bl_contact_form_error_email', __( 'Insert correct email', TEXTDOMAIN ) ),
			'requireerror' => get_option( 'bl_contact_form_required', __( 'This field is required', TEXTDOMAIN ) )
		) );                                                          	 
        
        if( $actual_font != 'default' )
        {
	        wp_enqueue_script('cufon', get_template_directory_uri()."/js/cufon-yui.js");                                 
	        wp_enqueue_script('cufon-' . $actual_font, get_template_directory_uri()."/fonts/{$actual_font}.font.js");   
		}    
		                   
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );                   
		
		wp_enqueue_style( 'jquery-jCarousel', get_template_directory_uri() . '/css/jCarousel.css' );                                       

        wp_head();
    ?>                      
    <!--[if IE]> 
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" type="text/css" media="screen, projection" /> 
    <![endif]-->
    <!--[if IE 7]>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie7.css" type="text/css" media="screen" />
    <![endif]-->      

    <!-- [favicon] begin -->
    <?php $favicon = unserialize( get_option('bl_favicon') ) ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $favicon['url']; ?>" />
    <link rel="icon" type="image/x-icon" href="<?php echo $favicon['url']; ?>" />
    
    <script type="text/javascript">                 
		<?php if( $actual_font != 'default' ) : ?>  
        Cufon.replace('h1:not(.no-cufon)', {fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_option_fontsize( 'h1' ), 'px\'' ) ?>});
        Cufon.replace('h2:not(.no-cufon)', {fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_option_fontsize( 'h2' ), 'px\'' ) ?>});
        Cufon.replace('h3:not(.no-cufon)', {fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_option_fontsize( 'h3' ), 'px\'' ) ?>});
        Cufon.replace('h4:not(.no-cufon)', {fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_option_fontsize( 'h4' ), 'px\'' ) ?>});
        Cufon.replace('h5:not(.no-cufon)', {fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_option_fontsize( 'h5' ), 'px\'' ) ?>});
        Cufon.replace('h6:not(.no-cufon)', {fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_option_fontsize( 'h6' ), 'px\'' ) ?>});
        
		Cufon.replace('.sidebar-small-size h3, .sidebar-small-size h2', 		{fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_option_fontsize( 'h5' ), 'px\'' ) ?>});
		Cufon.replace('.name-testimonial span.title', 	{fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_fontsize( $actual_font, 'title-testim' ), 'px\'' ) ?>});
		Cufon.replace('.call-to-action .incipit h2', 	{fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_fontsize( $actual_font, 'calltoaction-h' ), 'px\'' ) ?>});   
		Cufon.replace('.call-to-action .incipit p', 	{fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_fontsize( $actual_font, 'calltoaction-p' ), 'px\'' ) ?>});   
		Cufon.replace('#content .contact-form label .label',		{fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_fontsize( $actual_font, 'contact-label' ), 'px\'' ) ?>});   
		Cufon.replace('#content .contact-form label .sublabel', 	{fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_fontsize( $actual_font, 'contact-sublabel' ), 'px\'' ) ?>});   
        
		Cufon.replace('#nav ul.level-1 > li > a', 		{fontFamily: '<?php echo $actual_font ?>', hover: true<?php string_( ', fontSize: \'', get_option_fontsize( 'nav' ), 'px\'' ) ?>});   
		Cufon.replace('.name-testimonial span.website', {fontFamily: '<?php echo $actual_font ?>', hover: true<?php string_( ', fontSize: \'', get_fontsize( $actual_font, 'title-testim' ), 'px\'' ) ?>});   
		Cufon.replace('#portfolio li h3 a', 			{fontFamily: '<?php echo $actual_font ?>', hover: true});   
        
		Cufon.replace('#footer h2', {fontFamily: '<?php echo $actual_font ?>', textShadow: '0 2px 0 rgba(255,255,255,0.42)'});       
        
		Cufon.replace('#topbar a:not(.access-info-box *)', {fontFamily: '<?php echo $actual_font ?>', textShadow: '0 2px 2px #dcdbdb'<?php string_( ', fontSize: \'', get_fontsize( $actual_font, 'topbar' ), 'px\'' ) ?>, hover: true});  
		
        Cufon.replace('.p404 strong', {fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', 100, '%\'' ) ?>});     
        
        <?php if( if_ecommerce() ) : ?>
		Cufon.replace('.sidebar .featured-projects-widget p.categories', 	{fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_fontsize( $actual_font, 'project-widget' ), 'px\'' ) ?>});   
		Cufon.replace('.sidebar .featured-projects-widget p.categories a', 	{fontFamily: '<?php echo $actual_font ?>'<?php string_( ', fontSize: \'', get_fontsize( $actual_font, 'project-widget' ), 'px\'' ) ?>});   
		<?php endif ?>
		
		<?php do_action( 'yiw_add_cufon_role' ) ?>
		
		<?php endif ?>
    </script>                        
</head>                    
<?php $topbar = get_option( 'bl_topbar', 'fixed' ) ?>        
<body <?php body_class("no_js topbar-$topbar font_$actual_font $wpsc_class") ?>>      
    
	<?php if( $topbar != 'none' ) : ?>    
    <!-- START TOPBAR -->
    <div id="topbar">
		<ul class="inner">               
		
			<?php do_action( 'yiw_before_render_topbar' ) ?>    
			                                    
	    	<?php if( plugin_is_activated( 'wp-e-commerce/wp-shopping-cart.php' ) ) : ?>
			<li class="right icon cart margin fast-info" id="cart-top">                         
				<?php echo wpsc_shopping_basket_internals( ( isset( $_SESSION['nzshpcrt_cart'] ) ? $_SESSION['nzshpcrt_cart'] : null ), false, true); ?>
			</li>
	    	    
			<li class="right">                                               
				<a href="<?php echo get_permalink( get_pageID_by_pagename('checkout') ) ?>"><?php _e('Checkout', TEXTDOMAIN) ?></a> 
			</li>           
			<?php endif ?>
			
			<?php if ($current_user->user_level > -1) : ?>   
			
			<li class="right">
				<a href="<?php echo wp_logout_url( yiw_curPageURL() ); ?>"><?php _e('Logout', TEXTDOMAIN) ?></a> | 
				
				<?php if( plugin_is_activated( 'wp-e-commerce/wp-shopping-cart.php' ) ) : ?>
				<a href="<?php echo get_permalink( get_pageID_by_pagename('your-account') ) ?>"><?php _e('Your Account', TEXTDOMAIN) ?></a> |
				<?php endif ?>   
			
			<?php else : ?>                          
	    	                  
			<li class="right">
				| <a href="<?php echo home_url() ?>/wp-login.php?action=register"><?php _e('Register', TEXTDOMAIN) ?></a> |              
			</li>    
	    	<li class="right icon plus fast-info">                  
				<a href="<?php echo wp_login_url( yiw_curPageURL() ); ?>"><?php _e('Login', TEXTDOMAIN) ?></a>  
				<div id="fast-login" class="access-info-box">
					<form action="<?php echo wp_login_url( yiw_curPageURL() ); ?>" method="post" name="loginform">
						
						<div class="form">
							<p>
								<label>
									<?php _e( 'Username', TEXTDOMAIN ) ?><br/>
									<input type="text" tabindex="10" size="20" value="" name="log" class="input-text" />
								</label>
							</p>
							
							<p>
								<label>
									<?php _e( 'Password', TEXTDOMAIN ) ?><br/>
									<input type="password" tabindex="20" size="20" value="" name="pwd" class="input-text" />
								</label>
							</p>
							
							<p class="align-right">
								<input type="submit" tabindex="100" value="<?php _e( 'Login', TEXTDOMAIN ) ?>" name="wp-submit" class="input-submit" />
								<input type="hidden" value="<?php echo yiw_curPageURL(); ?>" name="redirect_to" />
								<input type="hidden" value="1" name="testcookie" />
							</p>    
						</div>
					
						<div class="small-cart-links">
							
							<label class="rememberme">
								<input type="checkbox" tabindex="90" value="forever" name="rememberme" />
								<?php _e( 'Remember Me', TEXTDOMAIN ) ?>
							</label>
								
							<a class="lostpassword" href="<?php echo wp_login_url(); ?>?action=lostpassword" title="<?php _e('Password Lost and Found', TEXTDOMAIN) ?>">
								> <?php _e( 'Lost password?', TEXTDOMAIN ) ?>
							</a>
						</div>
						
					</form>
				</div>                  
			
			<?php endif; ?>	                       
			
			</li>          
		
			<?php do_action( 'yiw_after_render_topbar' ) ?>  
	    </ul>      
	</div>            
    <!-- END TOPBAR -->
    <?php endif ?>

    <!-- START HEADER -->
    <div id="header">
        
        <div class="inner">     
		
			<?php do_action( 'yiw_before_render_header' ) ?>  
            
            <?php clear() ?>                  
                   
            <!-- START LOGO -->
            <div id="logo">
            	<a href="<?php bloginfo('url') ?>" title="<?php bloginfo('name') ?>"><?php bloginfo('name') ?></a>
            </div>         
            <!-- END LOGO -->
            
            <!-- START NAVIGATION -->
            <div id="nav">
                <?php 
    				$options = array(
                        'theme_location' => 'nav',
                        'container' => 'none',
                        'menu_class' => 'level-1',
                        'depth' => 3,
                        //'fallback_fb' => null
                    );                                  
                            
                    if ( has_nav_menu( 'nav' ) ) 
                        $nav_args['walker'] = new description_walker();
                    
                    wp_nav_menu( $options )
    			?>
    		</div>
            <!-- END NAVIGATION -->       
            
            <?php clear('space') ?>          
		
			<?php do_action( 'yiw_after_render_navigation' ) ?>