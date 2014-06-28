<?php

class quick_contact extends WP_Widget 
{
    function quick_contact() 
    {
		$widget_ops = array( 
            'classname' => 'quick-contact', 
            'description' => __('Quick contact form. NB: you must use this widget on the footer only.', TEXTDOMAIN) 
        );

		$control_ops = array( 'id_base' => 'quick-contact' );

		$this->WP_Widget( 'quick-contact', 'Quick Contact Form', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) 
    {
    	global $message;
    	
        extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		echo '<div class="quick-contact-widget two-third last">';
	        echo $before_widget;
	        
	        if ( $title ) echo $before_title . $title . $after_title;
	        
	        echo do_shortcode( '[contact_form id="' . $instance['id_form'] . '"]' );
	        ?>
	        <!--<div class="message-feedback"><?php echo $message ?></div>
	        
	        <form id="quick-contact-form" action="<?php echo yiw_curPageURL() ?>" method="post">
	        	<fieldset>
					<p class="input-control">	
						<label for="quick-contact-name"><?php echo $instance['label_name'] ?></label>
						<input type="text" name="yiw_contact[name]" id="quick-contact-name" class="name-icon required" value="<?php if( isset( $_POST['yiw_name'] ) ) echo $_POST['yiw_name'] ?>" />
					</p> 
					
					<p class="input-control">
						<label for="quick-contact-email"><?php echo $instance['label_email'] ?></label>
						<input type="text" name="yiw_contact[email]" id="quick-contact-email" class="mail-icon last" value="<?php if( isset( $_POST['yiw_email'] ) ) echo $_POST['yiw_email'] ?>" /> 
					</p>
					
					<p class="input-control">
						<label for="quick-contact-message"><?php echo $instance['label_message'] ?></label>
						<textarea name="yiw_contact[message]" id="quick-contact-message" class="pencil-icon last required" rows="5" cols="50"><?php if( isset( $_POST['yiw_message'] ) ) echo $_POST['yiw_message'] ?></textarea>
					</p>
					
					<p class="submit-input">                                
						<input type="hidden" name="yiw_action" value="sendemail" id="yiw_action" />
						<input type="hidden" name="yiw_referer" value="<?php echo yiw_curPageURL() ?>" />    
						<input type="hidden" name="id_form" value="contact-form-widget" />
						<input type="submit" name="sendmail" id="quick-contact-sendemail" value="<?php echo $instance['label_submit'] ?>" />
					</p>                   
	        	</fieldset>
			</form>-->	
	        <?php
	        
	        echo $after_widget;
	    echo '</div>';
	}

    function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['id_form'] = $new_instance['id_form'];             

		return $instance;
	}

    function form( $instance ) 
    {
        global $icons_name, $fxs, $easings;
        
        
		/* Impostazioni di default del widget */
		$defaults = array( 
            'title' => 'Quick Contact', 
            'id_form' => ''
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>  
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:
			     <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		    </label>
        </p>
		
		<p>
			<?php _e( 'This widget will be showed in two columns, so we raccomend to not add other widgets after this.', TEXTDOMAIN ) ?>
		</p>
		
		<p>
			<?php _e( 'Select here the form that you have created and configurated on Theme Options panel.', TEXTDOMAIN ) ?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'label_name' ); ?>">Label Name:
			     <select id="<?php echo $this->get_field_id( 'id_form' ); ?>" name="<?php echo $this->get_field_name( 'id_form' ); ?>">
			     	<?php 
						$forms = get_list_forms();
						
						foreach( $forms as $id_form => $form )
							echo "<option value=\"$id_form\"" . ( ( $instance['id_form'] == $id_form ) ? ' selected="selected"' : '' ) . ">$form</option>\n"; 
					?>
			     </select>
		    </label>
        </p>
    <?php
    }
}

?>
