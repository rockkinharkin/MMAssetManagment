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

defined( 'ABSPATH' ) or die ('Unauthorised Access');

$plugin = new MM_LifterLMS_AddOns();
$plugin->__construct();

class MM_LifterLMS_AddOns {

  function __construct(){
    $this->exists = in_array( 'lifterlms/lifterlms.php',get_option('active_plugins') );
    $this->aws_requires();
    $this->other_requires();
    $this->hooks();
  }

  public function aws_requires(){
    //require_once  ABSPATH.'vendor/autoload.php';
    require_once ABSPATH.'wp-content/plugins/mm-lifterlms-addons/config.php';
  }

  private function other_requires(){
      require_once ABSPATH.'wp-content/plugins/mm-lifterlms-addons/classes/class.shortcodes.php';
  }

  private function hooks(){
      add_action( 'admin_enqueue_scripts', array($this,'load_custom_wp_admin_scripts' ));
      add_action( 'add_meta_boxes', array($this,'wpdocs_register_meta_boxes' ));
    //  add_action( 'save_post', array($this,'wpdocs_save_meta_box' ));
      add_action( 'admin_menu', array($this,'mm_upload_asset_register' )); // Upload Asset View
      add_action( 'admin_menu', array($this,'custom_menu_page_removing' ));
  }

  // load scripts
  function load_custom_wp_admin_scripts() {
    $screen = get_current_screen();

    if ( strpos( $screen->base, 'toplevel_page_mm-upload-asset') !== false ){
     //styles
     wp_enqueue_style( 'mmaddon-styles', plugins_url('uploader/css/style.css',__FILE__ ) );

     // scripts
     wp_enqueue_script( 'mmaddon-script', "https://sdk.amazonaws.com/js/aws-sdk-2.2.43.min.js");
     wp_enqueue_script( 'mmaddon-evap-script', plugins_url("uploader/js/evaporate.js",__FILE__ ));
   }
  }

  // /**
  //  * Register meta box(es).
  //  */
  public function wpdocs_register_meta_boxes($post) {
  //  if( $this->exists == 1 ){
      add_meta_box( 'mm-course-assets', __( 'Course Assets', 'mm-lifterlms-addons' ), array($this,'build_course_assets_meta_box'), 'course','side' );
  //  }
    return false;
  }

  public function wpdocs_my_display_callback( $post ) {
    echo "<div><h2>hello<h2></div>";
   // Display code/markup goes here. Don't forget to include nonces!
  }

  public function build_course_assets_meta_box( $post ){
      wp_nonce_field( basename( __FILE__ ), 'mm_course_assets_meta_box_nonce' );

      echo '<div id="course_builder" class="postbox ">
                  <button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Course Builder</span>
                  <span class="toggle-indicator" aria-hidden="true"></span>
                  </button>
                        <div class="llms-builder-launcher">
  			                     <a class="llms-button-primary full" href="'.WP_SITEURL.'wp-admin/admin.php?page=mm-upload-asset&amp;course_id='.$post->ID.'&course_slug='.$post->post_name.'">Attach Assets</a>
  	                     </div>
  		            </div>';
    }

    /**
     * Save meta box content.
     *
     * @param int $post_id Post ID
     */
    // public function wpdocs_save_meta_box( $post_id ) {
    //     // Save logic goes here. Don't forget to include nonce checks!
    // }


  public function mm_upload_asset_register()
  {
      add_menu_page(
          'Upload Assets',     // page title
          'MM Asset Uploader',     // menu title
          'manage_options',   // capability
          'mm-upload-asset',     // menu slug
          array($this,'mm_upload_asset_view') // callback function
      );
  }

  public function mm_upload_asset_view(){
      global $title;
      $post = get_post($_GET['course_id']);

      echo '<div class="wrap">';
      echo "<h1>$title for ". $post->post_title."</h1>";

      $file = plugin_dir_path( __FILE__ ) . "/uploader/index.php";

      if ( file_exists( $file ) ){
          require $file;
      echo '</div>';
  }
}

// removes the admin menu item MM Upload asset
public function custom_menu_page_removing() {
    remove_menu_page( 'mm-upload-asset' );
}

}
?>
