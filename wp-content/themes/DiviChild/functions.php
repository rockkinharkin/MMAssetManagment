<?php
/*-------------------------------------------------------
 * Divi Cake Child Theme Functions.php
------------------ ADD YOUR PHP HERE ------------------*/

function divichild_enqueue_scripts() {
    wp_register_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'parent-style' );
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

// removing the "author" section on the course intro page.
remove_filter( 'lifterlms_single_course_after_summary', 'lifterlms_template_course_author', 40 );

// Adding Resources Widget for course.
if ( !function_exists( 'load_mm_resources_widget' ) ) {
  add_filter( 'llms_course_meta_info_title', 'load_mm_resources_widget', 40 );

  function load_mm_resources_widget(){
    global $post;
    $p = (array)$post;
    $widget = new MM_Asset_Widget();
    $content = $widget->widget(NULL,$p);
    echo __( $content, 'MM_Asset_Widget' );
   }
}
