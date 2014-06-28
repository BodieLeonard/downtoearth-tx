<?php 
/**
 * Add new field for contact customize panel.
 *
 * Page for adding new field to contact module.
 *
 * @package Wordpress
 * @subpackage Kassyopea
 * @since 1.1
 */                             

if ( !defined( 'IFRAME_REQUEST' ) )
	define( 'IFRAME_REQUEST' , true );  

define( 'WP_USER_ADMIN', 1 );

require_once( '../../includes/mtx-safe-wp-load.php' );

/** Load WordPress Administration Bootstrap */
// require_once('../../../../../wp-admin/admin.php');
// 
// if (!current_user_can('manage_options'))
// 	wp_die(__('You do not have permission to edit options.'));

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset')); 

$action = $_GET['action'];

$types = array(
	'text' => 'Text Input',
	'checkbox' => 'Checkbox',      
	'select' => 'Select',   
	'multiselect' => 'Multi Select',
	'textarea' => 'Text Area',
	'radio' => 'Radio Input',
	'password' => 'Password Field',
	'file' => 'File Upload'
);

function get_name_field( $field )
{
	return "{$_GET[id]}[{$field}]";         
}

function name_field( $field )
{
	echo get_name_field( $field );         
}

function get_id_field( $field )
{
	return "{$_GET[id]}_{$field}";      
}                     

function id_field( $field )
{
	echo get_id_field( $field );         
}            

$attrs = array(
	'title' => '',
	'data_name' => '',
	'description' => '',
	'type' => '',
	'option' => '',
	'option_selected' => '',
	'already_checked' => '',
	'label_checkbox' => '',
	'msg_error' => '',
	'required' => '',
	'email_validate' => '',
	'reply_to' => '',
	'class' => ''
);

switch( $action )
{
	case 'new-field' :
		$title = __( 'Add New Field', TEXTDOMAIN );
		$subtitle = __( 'Add new field for your contact module.', TEXTDOMAIN );
		$action_submit = 'save';            
		                                                                 
		$fields = null;
		$c_field = null;
	break;
	
	case 'edit-field' :
		$title = __( 'Edit Field', TEXTDOMAIN );         
		$subtitle = __( 'Edit the attributes of field.', TEXTDOMAIN );  
		$action_submit = 'update-array';
		                                                                 
		$fields = stripslashes_deep( maybe_unserialize( get_option( $_GET['id'] ) ) );
		$c_field = intval( $_GET['c'] );                               

		//echo '<pre>', print_r($fields), '</pre>';
		
		foreach( $attrs as $id => $value )
		{
			$attrs[$id] = $fields[$c_field][$id]; 
		}
	break;
	
	default:
		$title = '';
		$subtitle = '';
	break;
}

$parent_file = 'admin.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php do_action('admin_xml_ns'); ?> <?php language_attributes(); ?>>
<head>                   
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<title><?php echo $title; ?></title>
<?php        
	wp_admin_css( 'global', true );
	wp_admin_css( 'wp-admin', true );
	//wp_print_styles( 'colors' ); 
	wp_enqueue_style( 'colors-admin', site_url() . '/wp-admin/css/colors-fresh.css' );  
	wp_print_styles( 'colors-admin' ); 
	wp_admin_css( 'media', true );  
	wp_print_scripts( 'jquery' );
	wp_print_scripts( 'thickbox' );      
?>
<style type="text/css">
html, body { min-height:100%; height:inherit; }
</style>
</head>
<body id="media-upload">
	        
	<div id="media-upload-header"></div>
	
	<form action="<?php echo admin_url( 'admin.php?page=' . $_GET['page'] ) ?>" method="post" class="media-upload-form">  
		<h3 class="media-title"><?php echo $title; ?></h3>
		<p><?php echo $subtitle ?></p>
		
		<table class="describe" style="display: table;">
			
			<tbody>
				<tr>
					<th class="label" valign="top" scope="row">
						<label for="<?php id_field( 'title' ) ?>"><?php _e( 'Title Field', TEXTDOMAIN ) ?></label>
					</th>
					<td class="field">
						<input type="text" name="<?php name_field( 'title' ) ?>" id="<?php id_field( 'title' ) ?>" value="<?php echo $attrs['title'] ?>" />
						<p class="help"><?php _e( 'Insert the title of field.', TEXTDOMAIN ) ?></p>	
					</td>
				</tr>
				
				<tr>
					<th class="label" valign="top" scope="row">
						<label for="<?php id_field( 'data_name' ) ?>"><?php _e( 'Data Name', TEXTDOMAIN ) ?></label>
					</th>
					<td class="field">
						<input type="text" name="<?php name_field( 'data_name' ) ?>" id="<?php id_field( 'data_name' ) ?>" value="<?php echo $attrs['data_name'] ?>" />
						<p class="help"><?php _e( 'The identification name of this field, that you can insert into body email configuration.', TEXTDOMAIN ) ?></p>	
					</td>
				</tr>	
				
				<tr>
					<th class="label" valign="top" scope="row">
						<label for="<?php id_field( 'description' ) ?>"><?php _e( 'Description', TEXTDOMAIN ) ?></label>
					</th>
					<td class="field">
						<input type="text" name="<?php name_field( 'description' ) ?>" id="<?php id_field( 'description' ) ?>" value="<?php echo $attrs['description'] ?>" />
						<p class="help"><?php _e( 'Small description, showed near name title.' ) ?></p>	
					</td>
				</tr>	
				
				<tr>                 
					<th class="label" valign="top" scope="row">
						<label for="<?php id_field( 'type' ) ?>"><?php _e( 'Type field', TEXTDOMAIN ) ?></label>
					</th>
					<td class="field">
						<select id="type-select" name="<?php name_field( 'type' ) ?>">
							<?php echo_list_option( $types, $attrs['type'] ) ?>	
						</select>                                     
						<p class="help"><?php _e( 'Select the type of this field.' ) ?></p>	
					</td>
				</tr>      
				
				<tr class="options-list toggled<?php if( $attrs['type'] != 'select' AND $attrs['type'] != 'radio' AND $attrs['type'] != 'multiselect' ) : ?> hide-if-js<?php endif; ?>">           
					<th class="label" valign="top" scope="row">
						<label><?php _e( 'Add options', TEXTDOMAIN ) ?></label>
					</th>  
					<td class="field" colspan="2">                                        
						<a href="#" class="add-field-option button-secondary"><?php _e( 'Add option', TEXTDOMAIN ) ?></a><br />
						
						<?php 
						if( is_array( $attrs['option'] ) AND !empty( $attrs['option'] ) ) : 
							foreach( $attrs['option'] as $id => $value ) :
								$selected = '';
								if( intval( $attrs['option_selected'] ) == $id )
									$selected = ' checked=""';
						?>
						<p class="option">      
							<label><input type="radio" name="<?php name_field( 'option_selected' ) ?>" value="<?php echo $id ?>"<?php echo $selected ?> /> <?php _e( 'Selected', TEXTDOMAIN ) ?></label>
							<input type="text" name="<?php name_field( 'option' ) ?>[]" style="width:50%" value="<?php echo $value ?>" />
							<a href="#" class="del-field-option button-secondary"><?php _e( 'Delete option', TEXTDOMAIN ) ?></a>
						</p>
						<?php endforeach; endif; ?>
						
						<p class="option">      
							<label><input type="radio" name="<?php name_field( 'option_selected' ) ?>" value="<?php echo ( $id > 0 ) ? $id + 1 : 0 ?>" /> <?php _e( 'Selected', TEXTDOMAIN ) ?></label>
							<input type="text" name="<?php name_field( 'option' ) ?>[]" style="width:50%" />
							<a href="#" class="del-field-option button-secondary"><?php _e( 'Delete option', TEXTDOMAIN ) ?></a>
						</p>
						
					</td>
				</tr>       
				
				<tr class="if-checked toggled<?php if( $attrs['type'] != 'checkbox' ) : ?> hide-if-js<?php endif; ?>">           
					<th class="label" valign="top" scope="row">
						<label><?php _e( 'Checked', TEXTDOMAIN ) ?></label>
					</th>  
					<td class="field" colspan="2">    
						<label>
							<input type="checkbox" value="yes" name="<?php name_field( 'already_checked' ) ?>" id="<?php id_field( 'already_checked' ) ?>"<?php if( $attrs['already_checked'] == 'yes' ) : ?> checked="checked"<?php endif; ?> />
							<p class="help" style="display:inline;"><?php _e( 'Select this if you want this field already checked.' ) ?></p>
						</label>
					</td>
				</tr>      
				
				<tr class="if-checked toggled" <?php if( $attrs['type'] != 'checkbox' ) : ?> style="display:none;"<?php endif; ?>> 
					<th class="label" valign="top" scope="row">
						<label for="<?php id_field( 'label_checkbox' ) ?>"><?php _e( 'Label for Checkbox', TEXTDOMAIN ) ?></label>
					</th>
					<td class="field">
						<input type="text" name="<?php name_field( 'label_checkbox' ) ?>" id="<?php id_field( 'label_checkbox' ) ?>" value="<?php echo $attrs['label_checkbox'] ?>" />
						<p class="help"><?php _e( 'Insert the label message for checkbox.' ) ?></p>	
					</td>
				</tr>      
				
				<tr>
					<th class="label" valign="top" scope="row">
						<label for="<?php id_field( 'msg_error' ) ?>"><?php _e( 'Message Error', TEXTDOMAIN ) ?></label>
					</th>
					<td class="field">
						<input type="text" name="<?php name_field( 'msg_error' ) ?>" id="<?php id_field( 'msg_error' ) ?>" value="<?php echo $attrs['msg_error'] ?>" />
						<p class="help"><?php _e( 'Insert the error message for validation.' ) ?></p>	
					</td>
				</tr>	    
				
				<tr>           
					<th class="label" valign="top" scope="row">
						<label><?php _e( 'Required', TEXTDOMAIN ) ?></label>
					</th>  
					<td class="field" colspan="2">    
						<label>
							<input type="checkbox" value="yes" name="<?php name_field( 'required' ) ?>" id="<?php id_field( 'required' ) ?>"<?php if( $attrs['required'] == 'yes' ) : ?> checked="checked"<?php endif; ?> />
							<p class="help" style="display:inline;"><?php _e( 'Select this if it must be required.' ) ?></p>
						</label>
					</td>
				</tr>        
				
				<tr>           
					<th class="label" valign="top" scope="row">
						<label><?php _e( 'Email', TEXTDOMAIN ) ?></label>
					</th>  
					<td class="field" colspan="2">    
						<label>
							<input type="checkbox" value="yes" name="<?php name_field( 'email_validate' ) ?>" id="<?php id_field( 'email_validate' ) ?>"<?php if( $attrs['email_validate'] == 'yes' ) : ?> checked="checked"<?php endif; ?> />
							<p class="help" style="display:inline;"><?php _e( 'Select this if it must be a valid email.' ) ?></p>
						</label>
					</td>
				</tr>             
				
				<tr>           
					<th class="label" valign="top" scope="row">
						<label><?php _e( 'Reply To', TEXTDOMAIN ) ?></label>
					</th>  
					<td class="field" colspan="2">    
						<label>
							<input type="checkbox" value="yes" name="<?php name_field( 'reply_to' ) ?>" id="<?php id_field( 'reply_to' ) ?>"<?php if( $attrs['reply_to'] == 'yes' ) : ?> checked="checked"<?php endif; ?> />
							<p class="help" style="display:inline;"><?php _e( 'Select this if it\'s the email where you can reply.' ) ?></p>
						</label>
					</td>
				</tr>   
				
				<tr>
					<th class="label" valign="top" scope="row">
						<label for="<?php id_field( 'class' ) ?>"><?php _e( 'Class', TEXTDOMAIN ) ?></label>
					</th>
					<td class="field">
						<input type="text" name="<?php name_field( 'class' ) ?>" id="<?php id_field( 'class' ) ?>" value="<?php echo $attrs['class'] ?>" />
						<p class="help"><?php _e( 'Insert an additional class for more personalization. (you can insert more class, separeted by space)' ) ?></p>	
					</td>
				</tr>	
				
				<tr>
					<td colspan="2">
						<p>                                                                                                       
							<input type="hidden" name="action" value="<?php echo $action_submit ?>" />                         
							<input type="hidden" name="c" value="<?php echo $c_field ?>" />                                             
							<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />                                         
							<input type="hidden" name="save_only" value="<?php echo $_GET['id'] ?>" />              
							<input type="submit" class="button-secondary" value="<?php _e( 'Save', TEXTDOMAIN ) ?>" />
							<input type="button" class="button-secondary" value="<?php _e( 'Reset', TEXTDOMAIN ) ?>" onclick="self.parent.tb_remove();" />
							<img class="waiting" style="display:none;" src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" alt="" />
						</p> 
					</td>
				</tr>
			</tbody>
		
		</table>
		
	</form>
	
	<script type="text/javascript">
		jQuery(document).ready(function($){   
		
			$('.hide-if-js').hide();
		
			function disable_submit()
			{
				$('input[type="submit"]').attr("disabled", true);
				add_loading();
			}
		
			function enable_submit()
			{
				$('input[type="submit"]').removeAttr("disabled");
				remove_loading();
			}
			
			function add_loading()
			{
				$('.waiting').show();
			}
			
			function remove_loading()
			{
				$('.waiting').hide();
			}
			
			function remove_input(e)
			{
				$(e).css({backgroundColor:'#FF0000'}).animate({opacity:0}, 400, function(){
					$(e).remove();
				});	
			}
		
			$('.media-upload-form').live( 'submit', function(){			                                 
				var datastring = 'type-send=ajax&page=<?php echo $_GET['page'] ?>&';     
				
				$('.options-list p.option').each(function(e){
					if( $('input[type="text"]', this).val() == '' )
						remove_input(this);
				});              
					
				disable_submit();
				
				setTimeout( function() {
					$('input, select, textarea').each(function(){                           
						
						if( !( ( $(this).is(':checkbox') || $(this).is(':radio') ) && !$(this).is(':checked') ) )	
						{
							var val = $(this).val();
							datastring = datastring + $(this).attr('name') + "=" + val + '&';    
						}
					});              
					
					$.ajax({
						url: '<?php echo admin_url( 'admin.php' ) ?>',
						data: datastring,
						type: 'GET',
						success: function(response){        
							//self.parent.location = '<?php echo admin_url( 'admin.php?page=' . $_GET['page'] ) ?>'; 
							self.parent.location = response; 
						
							//enable_submit();
						}     
					});
				}, 500);
					
				return false;
			});
		
			$('#type-select').live( 'change', function(){
				var val = $(this).val();
				
				if( val == 'select' || val == 'radio' || val == 'multiselect' )
				{
					$('.toggled').hide();
					$('.options-list').show();
				} 
				else if( val == 'checkbox' )
				{                          
					$('.toggled').hide();
					$('.if-checked').show();
				}
				else
				{
					$('.toggled').hide();
				}
			});
			
			$('input[type="reset"]').live( 'click', function(){
				$('.toggled').hide();
			});
		
			$('.add-field-option').live( 'click', function(){
				var field_container = $(this).parent();                           
				var last_val = parseInt( field_container.find('p.option:last-child input[type="radio"]').val() );
				field_container.find('p.option:last-child').clone().appendTo(field_container).children('input[type="text"]').val('');
				field_container.find('p.option:last-child input[type="radio"]').val( last_val + 1 );
				return false;	
			});
			
			$('a.del-field-option').live( 'click', function(){
				$(this).parent().remove();
				return false;
			});                          
		
		});
	</script>    
	
</body>
</html>