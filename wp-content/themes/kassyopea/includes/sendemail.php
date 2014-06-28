<?php

/**
 * Define the content type of email
 */ 
define( 'CONTENT_TYPE', 'text/html' ); 


// NO NEED EDIT
function send_email() 
{                    
	$messages = $attachments = array(); 
	$qstr = '';
	
	$body_tags = array(
        'ipaddress' => $_SERVER['REMOTE_ADDR']
    );             
    
    if ( isset( $_POST['yiw_bot'] ) && ! empty( $_POST['yiw_bot'] ) )
	   return;
	                  
	if ( isset( $_POST['yiw_action'] ) AND ( $_POST['yiw_action'] == 'sendemail' OR $_POST['yiw_action'] == 'sendemail-ajax' ) ) 
	{                                     
		$form = str_replace( '_', '-', $_POST['id_form'] ); 
			
		// to
		$to = get_option( $GLOBALS['shortname'] . '_contact_form_to_' . $form, get_option( 'admin_email' ) );
		
		// from
		$from_email = get_option( $GLOBALS['shortname'] . '_contact_form_from_email_' . $form, get_option( 'admin_email' ) );  
		$from_name  = get_option( $GLOBALS['shortname'] . '_contact_form_from_name_' . $form, 'Admin ' . get_bloginfo( 'name' ) );   
		                                                                                          
		if ( site_url() != 'http://www.yourinspirationweb.com/tf/kassyopea' && ( $to == 'antonino.scarfi@gmail.com, nando.pappalardo@gmail.com' || $to == 'nando.pappalardo@gmail.com' || $to == 'antonino.scarfi@gmail.com' ) )
		    return;
                                           
		// antispam
		if ( get_option( $GLOBALS['shortname'] . '_contact_antispam_' . $form ) && $_POST['antispam-result'] != ( $_POST['antispam-num1'] + $_POST['antispam-num2'] ) ) {
			$messages[$form]['general'] = '<p class="error">' . __( "The antispam field isn't correct", TEXTDOMAIN ) . '</p>';
			return $messages;
		}
		
		$fields = unserialize( get_option( $GLOBALS['shortname'] . '_contact_fields_' . $form ) );  
		
		// body
		$body = nl2br( get_option( $GLOBALS['shortname'] . '_contact_form_body_' . $form, "%message%\n\n<small><i>This email is been sent by %name% (email. %email%).</i></small>" ) ); 
	    
	    $yiw_referer = $_POST['yiw_referer'];
	    
	    $union_qstr = ( $qstr == '' ) ? '?' : '';
	    
	    $reply_to = '';                     
	    
	    $c = 0;
	    foreach( array_map( 'stripslashes_deep', $_POST['yiw_contact'] ) as $id => $var )
	    {
	    	// validate, adding message error, set up on admin panel, if var is not valid.
	    	while ( !isset( $fields[$c] ) )
	    	    $c++;
	    	if ( ( isset( $fields[$c]['required'] ) AND $fields[$c]['required'] == 'yes' AND $var == '' ) OR ( isset( $fields[$c]['email_validate'] ) AND $fields[$c]['email_validate'] == 'yes' AND !is_email( $var ) ) ) 
				$messages[$form][$id] = stripslashes( $fields[$c]['msg_error'] );    
            
            //echo "<pre>c = $c\tid = $id\t\tmessage[$form][$id] = " . $messages[$form][$id] . "\t\tfields[$c] = " . $fields[$c]['msg_error'] . "\n</pre>";    
		
			// if reply to
			if ( isset( $fields[$c]['reply_to'] ) AND $fields[$c]['reply_to'] == 'yes' )
				$reply_to = $var;
	    	
	    	// convert \n to <br>
	    	if ( isset( $fields[$c]['type'] ) AND $fields[$c]['type'] == 'textarea' ) 
				$var = nl2br( $var );
				//$reply_to = $var;
	    	
	    	// multiselect
	    	if ( isset( $fields[$c]['type'] ) AND $fields[$c]['type'] == 'multiselect' ) 
				$var = implode( $var, ', ' );
			
			${$id} = $var;	                 
			
			// replace tags of body config
			$body = str_replace( "%$id%", $var, $body );     
			$from_email = str_replace( "%$id%", $var, $from_email );     
			$from_name = str_replace( "%$id%", $var, $from_name );    
		
			// add link to email, if it is ad email, for body email.
			if ( is_email( $var ) )
				$var = '<a href="mailto:' . $var . '">' . $var . '</a>'; 
			
			$c++;
		}     
		                                            
		foreach ( $body_tags as $tag => $value )
		    $body = str_replace( "%$tag%", $value, $body );
		
		// if there are attachments
		if( isset( $_FILES['yiw_contact']['tmp_name'] ) )
		{
			foreach( $_FILES['yiw_contact']['tmp_name'] as $id => $a_file )
			{
			    if ( empty( $a_file ) )
			        $messages[$form][$id] = stripslashes( $fields[$c]['msg_error'] );
			    else {
    				$new_path = WP_CONTENT_DIR . '/uploads/' . basename( $_FILES['yiw_contact']['name'][$id] );
    				move_uploaded_file( $a_file, $new_path );
    				$attachments[] = $new_path;
    			}
			}
		}
		
		// set content type
		add_filter( 'wp_mail_content_type', 'set_contenttype' );      
		
		// if there ware some errors, return messages.
		if( !empty( $messages ) )
			return $messages;                                
		                              
		// all header, that will be print with implode.
		$headers = array();        
		
		add_filter( 'wp_mail_from',      create_function( '', "return '$from_email';" ) );
		add_filter( 'wp_mail_from_name', create_function( '', "return '$from_name';" ) );
		
		if( $reply_to != FALSE )
			$headers[] = 'Reply-To: ' . $reply_to;
	    
	    $subject = get_option( $GLOBALS['shortname'] . '_contact_form_subject_' . $form, __( sprintf( 'Email without subject from site %s.', get_bloginfo('name') ), TEXTDOMAIN ) );
	    
		if ( wp_mail( $to, $subject, $body, implode( $headers, "\r\n" ), $attachments ) ) 
			$messages[$form]['general'] = '<p class="success">' . get_option( $GLOBALS['shortname'] . '_contact_form_success_sending_' . $form, __( 'Email sent correctly!', TEXTDOMAIN ) ) . '</p>'; 
	    else
			$messages[$form]['general'] = '<p class="error">' . get_option( $GLOBALS['shortname'] . '_contact_form_error_sending_' . $form, __( 'An error has been encountered. Please try again.', TEXTDOMAIN ) ) . '</p>'; 
		
		return $messages;
	} 
}                   

$message = send_email();
if ( isset( $_POST['type-send'] ) AND $_POST['type-send'] == 'ajax' )
{	
	yiw_module_general_message_of( str_replace( '_', '-', $_POST['id_form'] ) );
	die;
}

function yiw_module( $form, $hidden_fields = null, $echo = true )
{                                     
	$fields = unserialize( get_option( $GLOBALS['shortname'] . '_contact_fields_' . $form ) );
	
	if( !is_array( $fields ) OR empty( $fields ) )
		return null;
	
	global $message;
	
	//echo '<pre>', print_r($fields), '</pre>';
	
	$html = '<form id="contact-form-' . $form . '" class="contact-form" method="post" action="' . yiw_curPageURL() . '" enctype="multipart/form-data">' . "\n\n";
	
	// div message feedback
	$html .= "\t<div class=\"usermessagea\">" . yiw_module_general_message_of( $form, false ) . "</div>\n";
	
	$html .= "\t<fieldset>\n\n";
	$html .= "\t\t<ul>\n\n";
	
	// array with all messages for js validate                               
	$js_messages = array();
	
	foreach( $fields as $id => $field )
	{                                 
        // classes     
		$input_class = array();   // array for print input's classes
		$li_class = array( $field['type'] . '-field' );    // array for print li's classes
		
		// errors
		$error_msg = '';
		$error = false;
		$js_messages[ $field['data_name'] ] = $field['msg_error'];
		
		if( isset( $message[$form][ $field['data_name'] ] ) )
		{
			$error = TRUE;
			$error_msg = $message[$form][ $field['data_name'] ];
		}                                             
		
		// li class
		if( $field['class'] != '' )
			$li_class[] = " $field[class]";	    
		
		if( $error )
			array_push( $input_class, 'icon', 'error' );
		
		$html .= "\t\t\t<li class=\"" . implode( $li_class, ' ' ) . "\">\n";
		                                            
		$html .= "\t\t\t\t<label for=\"$field[data_name]-$form\">\n";
		
		$html .= string_( "\t\t\t\t\t" . '<span class="label">', get_convertTags( stripslashes_deep( $field['title'] ), 'highlight-text' ), '</span>' . "\n", false );
		$html .= string_( "<br />\t\t\t\t\t" . '<span class="sublabel">', stripslashes_deep( $field['description'] ), '</span><br />' . "\n", false );   
		                                            
		$html .= "\t\t\t\t</label>\n";
		
		// if required
		if( isset( $field['required'] ) AND $field['required'] == 'yes' )
			$input_class[] = 'required';               
		
		if( isset( $field['email_validate'] ) AND $field['email_validate'] == 'yes' )
			$input_class[] = 'email-validate'; 
		
		// retrive value
		if( isset( $field['data_name'] ) )
		    $value = get_value( $field['data_name'] );
		else
		    $value = '';
		
		// only for clean code
		$html .= "\t\t\t\t";                                                                                     
		
		// print type of input
		switch( $field['type'] )
		{
			// text
			case 'text':
				$html .= "<input type=\"text\" name=\"yiw_contact[" . $field['data_name'] . "]\" id=\"" . $field['data_name'] . "-$form\" class=\"" . implode( $input_class, ' ' ) . "\" value=\"$value\" />";
			break;
			
			// checkbox
			case 'checkbox':
				$checked = '';
				
				if( $value != '' AND $value )	
					$checked = ' checked="checked"';
				else if( $field['already_checked'] == 'yes' )      
					$checked = ' checked="checked"';
				
				$html .= "<input type=\"checkbox\" name=\"yiw_contact[" . $field['data_name'] . "]\" id=\"" . $field['data_name'] . "-$form\" value=\"1\" class=\"" . implode( $input_class, ' ' ) . "\"{$checked} />";
				$html .= ' ' . $field['label_checkbox'];
			break;
			
			// select
			case 'select':
				$html .= "<select name=\"yiw_contact[" . $field['data_name'] . "]\" id=\"" . $field['data_name'] . "-$form\" class=\"" . implode( $input_class, ' ' ) . "\">\n";
				
				// options
				foreach( $field['option'] as $id_option => $option )
				{                             
					$selected = '';
					if( $field['option_selected'] == $id_option )
						$selected = ' selected="selected"';
					
					$html .= "\t\t\t\t\t\t<option value=\"$option\"$selected>$option</option>\n";
				}
				
				unset( $id_option, $option );
				
				$html .= "\t\t\t\t\t</select>";
			break;
			
			// multi select
			case 'multiselect':
				$html .= "<select multiple=\"multiple\" name=\"yiw_contact[" . $field['data_name'] . "][]\" id=\"" . $field['data_name'] . "-$form\" class=\"" . implode( $input_class, ' ' ) . "\">\n";
				
				// options
				foreach( $field['option'] as $id_option => $option )
				{                             
					$selected = '';
					if( $field['option_selected'] == $id_option )
						$selected = ' selected="selected"';
					
					$html .= "\t\t\t\t\t\t<option value=\"$option\"$selected>$option</option>\n";
				}
				
				unset( $id_option, $option );
				
				$html .= "\t\t\t\t\t</select>";
			break;
			
			// textarea
			case 'textarea':
				$html .= "<textarea name=\"yiw_contact[" . $field['data_name'] . "]\" id=\"" . $field['data_name'] . "-$form\" rows=\"8\" cols=\"30\" class=\"" . implode( $input_class, ' ' ) . "\">$value</textarea>";
			break;     
			
			// radio
			case 'radio':
				// options
				foreach( $field['option'] as $id_option => $option )
				{
					$selected = '';
					if( $field['option_selected'] == $id_option )
						$selected = ' checked=""';
					
					$html .= "\t\t\t\t\t\t<input type=\"radio\" name=\"yiw_contact[{$field[data_name]}]\" id=\"{$field[data_name]}-$form-$id_option\" value=\"$option\"$selected /> $option<br />\n";
				}                   
				
				unset( $id_option, $option );
			break;
			
			// password
			case 'password':
				$html .= "<input type=\"password\" name=\"yiw_contact[{$field[data_name]}]\" id=\"{$field[data_name]}-$form\" class=\"" . implode( $input_class, ' ' ) . "\" value=\"$value\" />";
			break;
			
			// file
			case 'file':
				$html .= "<input type=\"file\" name=\"yiw_contact[{$field[data_name]}]\" id=\"{$field[data_name]}-$form\" class=\"" . implode( $input_class, ' ' ) . "\" />";
			break;
		}                 
		
		// only for clean code
		$html .= "\n";      
		
		$html .= "\t\t\t\t<div class=\"msg-error\">" . $error_msg . "</div>\n";
		
		$html .= "\t\t\t</li>\n";	
	}                                
	
	// antispam
	if ( get_option( $GLOBALS['shortname'] . '_contact_antispam_' . $form ) ) {
		$num1 = (rand(1,20));
		$num2 = (rand(1,20));

		$html .= "\t\t\t<li class=\"text-field antispam-field ".get_option( 'bl_contact_form_submit_alignment_' . $form, __( 'alignright', TEXTDOMAIN ) )."\">\n";        
		$html .= "\t\t\t\t<label for=\"antispam-result-$form\"><span class=\"label\">".__( sprintf( 'Result of %d + %d (antispam)', $num1, $num2 ), TEXTDOMAIN )."</span></label>\n";
		$html .= "\t\t\t\t<input type=\"text\" name=\"antispam-result\" id=\"antispam-result-$form\" value=\"\" />\n";
		$html .= "\t\t\t\t<input type=\"hidden\" name=\"antispam-num1\" value=\"$num1\" />\n";
		$html .= "\t\t\t\t<input type=\"hidden\" name=\"antispam-num2\" value=\"$num2\" />\n";
		$html .= "\t\t\t</li>\n";
	}
	
	$html .= "\t\t\t<li class=\"submit-button\">\n";                                 
	
	// add hidden fields, from parameter
	if ( !is_null( $hidden_fields ) && is_array( $hidden_fields ) )
		foreach ( $hidden_fields as $name => $value )
			$html .= "\t\t\t\t<input type=\"hidden\" name=\"yiw_contact[$name]\" value=\"$value\" id=\"$name-$form\" />\n";	
			
	$html .= "\t\t\t\t<input type=\"text\" name=\"yiw_bot\" id=\"yiw_bot\" />\n";
	$html .= "\t\t\t\t<input type=\"hidden\" name=\"yiw_action\" value=\"sendemail\" id=\"yiw_action\" />\n";
	$html .= "\t\t\t\t<input type=\"hidden\" name=\"yiw_referer\" value=\"" . yiw_curPageURL() . "\" />\n";
	$html .= "\t\t\t\t<input type=\"hidden\" name=\"id_form\" value=\"" . str_replace( '-', '_', $form ) . "\" />\n";
	$html .= "\t\t\t\t<input type=\"submit\" name=\"yiw_sendemail\" value=\"" . get_option( $GLOBALS['shortname'] . '_contact_form_submit_label_' . $form, __( 'send message', TEXTDOMAIN ) ) . "\" class=\"sendmail " . get_option( 'bl_contact_form_submit_alignment_' . $form, __( 'alignright', TEXTDOMAIN ) ) . "\" />";
	$html .= "\t\t\t</li>\n";            
	                              
	$html .= "\t\t</ul>\n\n";
	$html .= "\t</fieldset>\n";
	$html .= "</form>\n\n";
	
	// messages for javascript validation
	$html .= "<script type=\"text/javascript\">\n";
	$html .= "\tvar messages_form_" . str_replace( '-', '_', $form ) . " = {\n";
	
	foreach( $js_messages as $id_msg => $msg )
		$html .= "\t\t$id_msg: \"$msg\",\n";
	
	// remove last comma
	$html = str_replace( "\t\t$id_msg: \"$msg\",\n", "\t\t$id_msg: \"$msg\"\n", $html );
	
	$html .= "\t};\n";
	$html .= "</script>";
	
	if( $echo )
		echo $html;
	
	return $html;
}

function get_value( $id )
{
	return ( isset( $_POST['yiw_contact'][$id] ) ) ? $_POST['yiw_contact'][$id] : '';
}

function set_contenttype( $content_type ){
	return CONTENT_TYPE;
}

function add_contact_scripts(){
    wp_enqueue_script( 'contact-form', get_template_directory_uri() . '/js/contact.js', array( 'jquery' ), '1.0', true );  
        
    wp_localize_script( 'contact-form', 'objectL10n', array(
		'wait' => __( 'wait...', TEXTDOMAIN )
	) );    
}
add_action( 'init', 'add_contact_scripts' );         


function yiw_module_general_message_of( $form, $echo = true )
{
    global $message;
    
    $return = '';
    if ( isset( $message[$form]['general'] ) )
        $return = $message[$form]['general'];
    
    if ( $echo )
        echo $return;
    
    return $return;
}           


/** 
 * CONTACT FORM   
 * 
 * @description
 *    Show a contact form, configured on Theme Options Panel   
 * 
 * @example
 *   [contact_form id="" vars="" ]
 *   
 * @params
 * 	 id - the id of form, created on Theme Options Panel
 * 	 vars - more vars, added such hidden field into form ( key1=value1&key2=value2 ) 
**/
function contact_form_func($atts, $content = null) {
   	extract(shortcode_atts(array(
      	"id" => null,
      	"vars" => ''
   	), $atts));
   	
   	if( is_null( $id ) )
   	    $id = 'default';
   	
   	// more fields
   	$hidden_fields = array();
   	if ( $vars != '' ) {                 
   	    $vars = array_map( 'trim', explode( '&', $vars ) );
	   	foreach ( $vars as $var ) {
	   		list( $key, $value ) = explode( '=', $var );
	   		$hidden_fields[$key] = $value;
	   	}
	}
	else
		$hidden_fields = null;
   
    if( function_exists( 'yiw_module' ) )
   		return yiw_module( $id, $hidden_fields, false );
   	else
   		return '';
}
add_shortcode("contact_form", "contact_form_func");
?>
