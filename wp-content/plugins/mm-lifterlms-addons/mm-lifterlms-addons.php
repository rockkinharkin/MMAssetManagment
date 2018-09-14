<?php
/*
!!! This plugin has a dependency for LifterLMS being installed.!!!

	Plugin Name: MAKEMATIC Lifter LMS Extension pack
	Plugin URI: https://www.makematic.com/lifterlms/extensionpack
	Description: Bespoke features developed in conjucntion with LifterLMS for the MAKEMATIC asset system. Mainly
  the linking & uploading of assets to a lifterlms course.
	Version: 1.0
	Author: Rachael Harkin
	Author URI: http://hybrid.digital
	Text Domain: asset-licence-manager
	License: GPL3
*/

defined( 'ABSPATH' ) || exit;
if (  is_plugin_active( ABSPATH.'wp-content/plugins/lifterlms/lifterlms.php' ) ) {


// /**
//  * Register meta box(es).
//  */
function wpdocs_register_meta_boxes() {
    add_meta_box( 'mm-course-assets', __( 'Course Assets', 'mm-lifterlms-addons' ), 'build_course_assets_meta_box', 'course','side' );
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );

/* Meta Display callback
 @param WP_Post $post Current post object.
 */
 function wpdocs_my_display_callback( $post ) {
   echo "<div><h2>hello<h2></div>";
    // Display code/markup goes here. Don't forget to include nonces!
}

function build_course_assets_meta_box( $post ){
    wp_nonce_field( basename( __FILE__ ), 'mm_course_assets_meta_box_nonce' );

    echo '<div id="course_builder" class="postbox ">
                <button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Course Builder</span>
                <span class="toggle-indicator" aria-hidden="true"></span>
                </button>
                      <div class="llms-builder-launcher">
			                     <a class="llms-button-primary full" href="http://'.WP_SITEURL.'wp-admin/admin.php?page=llms-link-assets&amp;course_id='.$post->ID.'">Attach Assets</a>
	                     </div>
		            </div>';
  }
  /**
   * Save meta box content.
   *
   * @param int $post_id Post ID
   */
  function wpdocs_save_meta_box( $post_id ) {
      // Save logic goes here. Don't forget to include nonce checks!
  }

  add_action( 'save_post', 'wpdocs_save_meta_box' );
}
?>
