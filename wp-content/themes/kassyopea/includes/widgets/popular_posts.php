<?php

class popular_posts extends WP_Widget 
{
    function popular_posts() 
    {
		$widget_ops = array( 
            'classname' => 'popular-posts', 
            'description' => __('Show a list of popular posts, in order of comments, with a preview thumb.', TEXTDOMAIN) 
        );

		$control_ops = array( 'id_base' => 'popular-posts' );

		$this->WP_Widget( 'popular-posts', 'Popular Posts', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) 
    {
        extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		$items = isset( $instance['items']) ? $instance['items'] : '';
		$more_text = isset( $instance['more_text']) ? $instance['more_text'] : '';

        echo $before_widget;
        
        if ( $title ) echo $before_title . $title . $after_title;
        
        echo do_shortcode( "[popularpost items=\"$items\" more_text=\"$more_text\"]" );
        
        echo $after_widget;
	}

    function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['items'] = $new_instance['items'];           

		$instance['more_text'] = $new_instance['more_text'];

		return $instance;
	}

    function form( $instance ) 
    {
        global $icons_name, $fxs, $easings;
        
        
		/* Impostazioni di default del widget */
		$defaults = array( 
            'title' => 'Popular Posts', 
            'items' => 3,     
            'more_text' => '|| ' . __( 'Read More', TEXTDOMAIN ),
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:
			     <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		    </label>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'items' ); ?>">Items:
			     <input type="text" id="<?php echo $this->get_field_id( 'items' ); ?>" name="<?php echo $this->get_field_name( 'items' ); ?>" value="<?php echo $instance['items']; ?>" size="3" />
		    </label>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'more_text' ); ?>">More Text:
			     <input type="text" id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" value="<?php echo $instance['more_text']; ?>" class="widefat" />
		    </label>
        </p>
    <?php
    }
}

?>
