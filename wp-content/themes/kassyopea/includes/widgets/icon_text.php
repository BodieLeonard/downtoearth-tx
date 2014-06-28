<?php
class icon_text extends WP_Widget
{
    function icon_text() 
    {
		$widget_ops = array( 
            'classname' => 'icon-text', 
            'description' => __('Arbitrary text or HTML, with a simple icon near title.', TEXTDOMAIN)
        );

		$control_ops = array( 'id_base' => 'icon-text', 'width' => 430 );

		$this->WP_Widget( 'icon-text', 'Icon Text Widget', $widget_ops, $control_ops );
	}
	
	function form( $instance )
	{
		global $icons_name;
		
        /* Impostazioni di default del widget */
		$defaults = array( 
            'title' => '',
            'icon_img' => ''
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label>
				<strong><?php _e( 'Title', TEXTDOMAIN ) ?>:</strong><br />
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>                  
		
		<p>
			<label><?php _e( 'Icon (near title)', TEXTDOMAIN ) ?>:
			     <select id="<?php echo $this->get_field_id( 'icon_img' ); ?>" name="<?php echo $this->get_field_name( 'icon_img' ); ?>">
			         <option value="0"></option>
                     <?php list_icons( $instance['icon_img'] ) ?>    
			     </select>
		    </label>
        </p>
		
		<p>
			<label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" cols="20" rows="16"><?php echo $instance['text']; ?></textarea>
			</label>
		</p>
		
		<p>
			<label>
				<input type="checkbox" id="<?php echo $this->get_field_id( 'autop' ); ?>" name="<?php echo $this->get_field_name( 'autop' ); ?>" value="1"<?php if( $instance['autop'] ) echo ' checked="checked"' ?> />
				<?php _e( 'Automatically add paragraphs' ) ?>
			</label>
		</p>
		<?php
	}
	
	function widget( $args, $instance )
	{
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		
		echo $before_widget;
		
		if( $instance['autop'] )
			$instance['text'] = apply_filters( 'the_content', $instance['text'] );
		
		$text = "[section icon=\"$instance[icon_img]\" before_title=\"$before_title\" title=\"$title\" after_title=\"$after_title\" class=\"\"]" . $instance['text'] . "[/section]";
		echo apply_filters( 'widget_text', $text );  
		
		echo $after_widget;
	}                     

    function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['icon_img'] = $new_instance['icon_img'];

		$instance['text'] = $new_instance['text'];

		$instance['autop'] = $new_instance['autop'];

		return $instance;
	}
	
}     
?>
