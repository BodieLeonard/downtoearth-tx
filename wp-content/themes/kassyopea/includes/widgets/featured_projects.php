<?php

class featured_projects extends WP_Widget 
{
    function featured_projects() 
    {
		$widget_ops = array( 
            'classname' => 'featured-projects', 
            'description' => __('Show a slider with featured project, added into portfolio Post Type.', TEXTDOMAIN) 
        );

		$control_ops = array( 'id_base' => 'featured-projects' );

		$this->WP_Widget( 'featured-projects', 'Featured Project', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) 
    {
        extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		$project_fx = isset( $instance['project_fx']) ? $instance['project_fx'] : false;
		$project_easing_fx = isset( $instance['project_easing_fx']) ? $instance['project_easing_fx'] : false;
		$project_speed_fx = isset( $instance['project_speed_fx']) ? $instance['project_speed_fx'] : false;
		$project_timeout_fx = isset( $instance['project_timeout_fx']) ? $instance['project_timeout_fx'] : false;
		$project_n_items = isset( $instance['project_n_items']) ? $instance['project_n_items'] : 5;
		$icon = (isset( $instance['icon']) AND $instance['icon'] != 0) ? $instance['icon'] : FALSE;
		$size = 32;

        global $more;
        $more = 0;

        $project_posts = new WP_Query("post_type=bl_portfolio&posts_per_page=$project_n_items");

        if( $project_posts->have_posts() )
        {
		    echo $before_widget;

            $icon_img = '';
            if($icon) $icon_img = "<img src=\"".get_url_icon($icon, $size)."\" alt=\"$title\" class=\"icon\" />";

		    if ( $title ) echo $before_title . $icon_img . $title . $after_title;

			echo '<div class="featured-projects-widget">';
	            echo '<ul>';
			    while( $project_posts->have_posts() )
			    {
	                $project_posts->the_post();
	                
	                echo '<li>';
	                	
						echo '<div class="thumb-project">';
	                    the_post_thumbnail( 'portfolio-thumb-3cols' );
						echo '<div class="shadow-thumb-sidebar"></div>';            
	                	echo '</div>';
	                	
	                	the_title( '<h5><span>', '</span></h5>' );
						the_terms( get_the_ID(), 'category-project', '<p class="categories">', ' & ', '</p>' );
						
						global $more;
						$more = 0;
						the_excerpt();
	                
					echo '</li>';
	            }
	            echo '</ul>';
	        echo '</div>';
	        
	        $easing_attr = '';
	        if( $project_easing_fx ) $easing_attr = "easing: '$project_easing_fx',";
            
            $script = "<script type=\"text/javascript\">
                jQuery(document).ready(function($){
                    $('.featured-projects-widget ul').cycle({
                        fx: '$project_fx',
                        $easing_attr
                        timeout: $project_timeout_fx,
                        speed: $project_speed_fx
                    });
                });
            </script>";
            
            echo $script;

		    echo $after_widget;
		
		}
	}

    function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['icon'] = $new_instance['icon'];               

		$instance['project_n_items'] = $new_instance['project_n_items'];

		$instance['project_fx'] = $new_instance['project_fx'];   

		$instance['project_easing_x'] = $new_instance['project_easing_fx'];

		$instance['project_timeout_fx'] = $new_instance['project_timeout_fx'];

		$instance['project_speed_fx'] = $new_instance['project_speed_fx'];


		return $instance;
	}

    function form( $instance ) 
    {
        global $icons_name, $fxs, $easings;
        
        
		/* Impostazioni di default del widget */
		$defaults = array( 
            'title' => 'Featured Projects', 
            'icon' => 'comment',       
            'project_n_items' => 5,
            'project_fx' => 'scrollLeft', 
            'project_easing_fx' => FALSE, 
            'project_timeout_fx' => 8000,  
            'project_speed_fx' => 300 
        );
        
        $categories = get_categories('hide_empty=1&orderby=name');
        $wp_cats = array();
        
        foreach ($categories as $category_list ) 
        {
            $wp_cats[$category_list->category_nicename] = $category_list->cat_name;
        }
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:
			     <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		    </label>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'icon' ); ?>">Icon (near title):
			     <select id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>">
			         <option value="0"></option>
                     <?php list_icons() ?>    
			     </select>
		    </label>
        </p>                            
		
		<p>
			<label for="<?php echo $this->get_field_id( 'project_n_items' ); ?>">Items:
			     <select id="<?php echo $this->get_field_id( 'project_n_items' ); ?>" name="<?php echo $this->get_field_name( 'project_n_items' ); ?>">
                    <?php 
                    for($i=1;$i<=20;$i++)
                    {
                        $select = '';
                        if($instance['project_n_items'] == $i) $select = ' selected="selected"';
                        echo "<option value=\"$i\"$select>$i</option>\n";
                    }
                    ?>
			     </select>
		    </label>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'project_fx' ); ?>">Effect Slider:
			     <select id="<?php echo $this->get_field_id( 'project_fx' ); ?>" name="<?php echo $this->get_field_name( 'project_fx' ); ?>">
                    <?php
                    foreach($fxs as $fx)
                    {
                        $select = '';
                        if($instance['project_fx'] == $fx) $select = ' selected="selected"';
                        echo "<option value=\"$fx\"$select>$fx</option>\n";
                    }
                    ?>
			     </select>
		    </label>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'project_easing_fx' ); ?>">Easing Effect:
			     <select id="<?php echo $this->get_field_id( 'project_easing_fx' ); ?>" name="<?php echo $this->get_field_name( 'project_easing_fx' ); ?>">
                    <?php
                    foreach($easings as $easing)
                    {
                        $select = '';
                        if($instance['project_easing_fx'] == $easing) $select = ' selected="selected"';
                        echo "<option value=\"$easing\"$select>$easing</option>\n";
                    }
                    ?>
			     </select>
		    </label>
        </p>                    
		
		<p>
			<label for="<?php echo $this->get_field_id( 'project_timeout_fx' ); ?>">Timeout (ms):
			     <input type="text" id="<?php echo $this->get_field_id( 'project_timeout_fx' ); ?>" name="<?php echo $this->get_field_name( 'project_timeout_fx' ); ?>" value="<?php echo $instance['project_timeout_fx']; ?>" size="4" />
		    </label>
        </p>          
		
		<p>
			<label for="<?php echo $this->get_field_id( 'project_speed_fx' ); ?>">Speed Animation (ms):
			     <input type="text" id="<?php echo $this->get_field_id( 'project_speed_fx' ); ?>" name="<?php echo $this->get_field_name( 'project_speed_fx' ); ?>" value="<?php echo $instance['project_speed_fx']; ?>" size="4" />
		    </label>
        </p>
    <?php
    }
}

?>
