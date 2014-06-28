<?php 

/*
Template Name: Store
*/

add_filter( 'body_class', create_function( '$classes = \'\'', '$classes[] = \'wpsc\'; return $classes;' ) );

get_template_part('page'); ?>  