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

//Primary Nav items
add_filter('wp_nav_menu_items', 'add_account_link', 10, 2);

function add_account_link($items, $args) {
		    $accountlink = WP_SITEURL.'/my-courses/edit-account/';
		$mycourses = WP_SITEURL.'/my-courses/';

        if( is_user_logged_in() ){
			$items .= '<li><a href="'. $mycourses.'">My Courses</a></li>';
			$items .= '<li><a href="'. $accountlink.'">My Account</a></li>';
		}
    	return $items;
}

// login / logout button
add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);
function add_login_logout_link($items, $args) {
        ob_start();
        wp_loginout('index.php');
        $loginoutlink = ob_get_contents();
        ob_end_clean();
        $items .= '<li>'. $loginoutlink .'</li>';
    return $items;
}
