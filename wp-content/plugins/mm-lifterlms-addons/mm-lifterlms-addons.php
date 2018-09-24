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
new MM_LifterLMS_AddOns();

class MM_LifterLMS_AddOns {

  function __construct(){
    $this->exists = in_array( 'lifterlms/lifterlms.php',get_option('active_plugins') );
    $this->requires();
    $this->hooks();
  }

  private function requires(){
      require_once ABSPATH.'wp-content/plugins/mm-lifterlms-addons/inc/shortcodes.php';
  }

  private function hooks(){
      add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_scripts' );
      add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );
      add_action( 'save_post', 'wpdocs_save_meta_box' );
      add_action( 'admin_menu', 'mm_upload_asset_register' ); // Upload Asset View
  }

  // load scripts
  function load_custom_wp_admin_scripts() {
    $screen = get_current_screen();
    // echo "SCREEN:::".$screen->base;
    // echo ":::::";
    // echo strpos( $screen->base, 'mm-upload-asset');

    if ( strpos( $screen->base, 'toplevel_page_mm-upload-asset') !== false ){
     wp_enqueue_style( 'mmaddon-styles', plugins_url('css/style.css',__FILE__ ) );
     wp_enqueue_script( 'mmaddon-script', plugins_url('js/upload.js',__FILE__ ), ['jquery'], '1.0.0' );
   }
  }

  // /**
  //  * Register meta box(es).
  //  */
  public function wpdocs_register_meta_boxes() {
    if( $this->exists == 1 ){
      add_meta_box( 'mm-course-assets', __( 'Course Assets', 'mm-lifterlms-addons' ), 'build_course_assets_meta_box', 'course','side' );
    }
    return false;
  }


  /* Meta Display callback
   @param WP_Post $post Current post object.
   */
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
  			                     <a class="llms-button-primary full" href="http://'.WP_SITEURL.'wp-admin/admin.php?page=llms-link-assets&amp;course_id='.$post->ID.'">Attach Assets</a>
  	                     </div>
  		            </div>';
    }
    /**
     * Save meta box content.
     *
     * @param int $post_id Post ID
     */
    public function wpdocs_save_meta_box( $post_id ) {
        // Save logic goes here. Don't forget to include nonce checks!
    }


  public function mm_upload_asset_register()
  {
      add_menu_page(
          'Upload MAKEMATIC Asset',     // page title
          'Upload MAKEMATIC Asset',     // menu title
          'manage_options',   // capability
          'mm-upload-asset',     // menu slug
          'mm_upload_asset_view' // callback function
      );
  }
  public function mm_upload_asset_view(){
      global $title;

      print '<div class="wrap">';
      print "<h1>$title</h1>";

      $file = plugin_dir_path( __FILE__ ) . "/views/upload.php";

      if ( file_exists( $file ) )
          require $file;

      print '</div>';
  }
}
?>
