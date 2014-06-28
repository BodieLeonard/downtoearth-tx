<?php

class google_map extends WP_Widget 
{
    function google_map() 
    {
		$widget_ops = array( 
            'classname' => 'google-map', 
            'description' => __('Box with google map.', TEXTDOMAIN) 
        );

		$control_ops = array( 'id_base' => 'google-map' );

		$this->WP_Widget( 'google-map', 'Google Map', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) 
    {
        extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		$src = isset( $instance['src'] ) ? $instance['src'] : false;

        echo $before_widget;
        
        if ( $title ) echo $before_title . $title . $after_title;
        
        if( $src ) echo do_shortcode( "[googlemap src=\"$src\"]" );
        
        echo $after_widget;
	}

    function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['src'] = $new_instance['src'];          

		return $instance;
	}

    function form( $instance ) 
    {
        global $icons_name, $fxs, $easings;
        
        
		/* Impostazioni di default del widget */
		$defaults = array( 
            'title' => 'Google Map', 
            'src' => ''
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:
			     <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		    </label>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'src' ); ?>">Src:
			     <input type="text" id="<?php echo $this->get_field_id( 'src' ); ?>" name="<?php echo $this->get_field_name( 'src' ); ?>" value="<?php echo $instance['src']; ?>" class="widefat" />
		    </label>
        </p>
    <?php
    }
}

?>
