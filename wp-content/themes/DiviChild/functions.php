<?php
/*-------------------------------------------------------
 * Divi Cake Child Theme Functions.php
------------------ ADD YOUR PHP HERE ------------------*/

function divichild_enqueue_scripts() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'divichild_enqueue_scripts' );

function my_et_builder_post_types($post_types){
	#$post_types[] = 'course';
	$post_types[] = 'llms_membership';
	$post_types[] = 'llms_engagement';
	$post_types[] = 'llms_order';
	return $post_types;
}
add_filter('et_builder_post_types','my_et_builder_post_types');
