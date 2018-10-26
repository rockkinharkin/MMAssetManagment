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

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class MM_LifterLMS_AddOns {

  function __construct(){
    $this->exists = in_array( 'lifterlms/lifterlms.php',get_option('active_plugins') );
    $this->aws_requires();
    $this->other_requires();
    $this->hooks();
  }

  public function aws_requires(){
    require  ABSPATH.'vendor/autoload.php';
    require_once ABSPATH.'wp-content/plugins/mm-lifterlms-addons/config.php';
    require_once ABSPATH.'wp-content/plugins/mm-lifterlms-addons/controllers/class.aws-resources.php';
  }

  private function other_requires(){
      require_once ABSPATH.'wp-content/plugins/mm-lifterlms-addons/controllers/class.shortcodes.php';
  }

  private function hooks(){
      add_action( 'admin_enqueue_scripts', array($this,'load_custom_wp_admin_scripts' ));
      add_action( 'add_meta_boxes', array($this,'wpdocs_register_meta_boxes' ));
      add_action( 'save_post', array($this,'wpdocs_save_meta_box' ));
      add_action( 'admin_menu', array($this,'mm_upload_asset_register' )); // Upload Asset View

      if( is_admin() === true ){ // must have this condition to execute ajax in admin area
        add_action( 'wp_ajax_upload_files', array( $this,'upload_files') );
        add_action( 'wp_ajax_upload_directory', array( $this,'upload_directory') );
      }
  }

  // load scripts
  function load_custom_wp_admin_scripts() {
    $screen = get_current_screen();

    if ( strpos( $screen->base, 'toplevel_page_mm-upload-asset') !== false ){
     wp_enqueue_style( 'mmaddon-styles', plugins_url('css/style.css',__FILE__ ) );
     wp_enqueue_script( 'mmaddon-script', plugins_url('js/upload.js',__FILE__ ), ['jquery'], '1.0.0', true );
    // wp_enqueue_script( 'mmaddon-script', 'https://cdn.jsdelivr.net/npm/uppload/dist/uppload.no-polyfills.min.js' );

     // need to do this so we can access php variables in javascript.
	   wp_localize_script( 'mmaddon-script', 'ajax_data', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( "upload_files_nonce" ) ) );
     wp_localize_script( 'mmaddon-script', 'ajax_data', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( "upload_directory_nonce" ) ) );

   }
  }

  // /**
  //  * Register meta box(es).
  //  */
  public function wpdocs_register_meta_boxes() {
    if( $this->exists == 1 ){
      add_meta_box( 'mm-course-assets', __( 'Course Assets', 'mm-lifterlms-addons' ), array($this,'build_course_assets_meta_box'), 'course','side' );
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
  			                     <a class="llms-button-primary full" href="'.WP_SITEURL.'wp-admin/admin.php?page=mm-upload-asset&amp;course_id='.$post->ID.'&course_slug='.$post->post_name.'">Attach Assets</a>
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
      echo "  <div>
          <h2>Please copy and paste the filepath the directory you wish to upload below</h2>
          <h2> Directory Structure</h2>
          <div id='directorystructure'>
          <p> below details the structure convention of the directory being uploaded to the AWS S3 bucket.<br>
          Please follow this convention when uploading assets as the websites 'Resources' widget
          relies on this convention to feed the files back to the user when they access to a course
          and its assets.</p>
            <ul>
              <li>".$post->ID."_".$post->post_title." - ( Main Directory )</li>
              <li>- docs   ( sub directory )</li>
              <li> -- file_1.docx</li>
              <li> -- file_2.txt</li>
              <li>- images ( sub directory )</li>
              <li>- videos ( sub directory )</li>
              <li>- audio  ( sub directory )</li>
            </ul>
          </div>";

      //$file = plugin_dir_path( __FILE__ ) . "/third-party/s3.fine-uploader/templates/simple-thumbnails.html";
      $file = plugin_dir_path( __FILE__ ) . "/views/upload3.php";

      if ( file_exists( $file ) )
          require $file;
      echo '</div>';
  }

  public function upload_files(){
    check_ajax_referer( 'upload_files_nonce', 'nonce' ); // verifies the call to function

    $assetid=$_POST['assetid'];
    $assetslug=$_POST['assetslug'];
    $files= $_POST['filelist']; // array of arrays

    $aws = new AWS_GetResources;

    $count = 0;
    foreach( $files as $f ){
      // each on is an array of filepaths
      $audio=$f['audio'];
      $docs=$f['docs'];
      $imgs=$f['images'];
      $vids=$f['videos'];

      foreach($imgs as $im){
        $filepath=$im;
        if( $filepath !='' ){
          $aws->standardUpload($assetid,$assetslug,$filepath);
          $count++;
        }
      }

      foreach($docs as $d){
        $filepath=$d;
        if( $filepath !='' ){
          $aws->standardUpload($assetid,$assetslug,$filepath);
          $count++;
        }
      }

      foreach($audio as $a){
        $filepath=$a;
        if( $filepath !='' ){
          $aws->standardUpload($assetid,$assetslug,$filepath);
          $count++;
        }
      }

      foreach($vids as $v){
        $filepath=$v;
        if( $filepath !='' ){
          $aws->standardUpload($assetid,$assetslug,$filepath);
          $count++;
        }
      }
    }
    error_log($count.' files have been processed');
    ob_clean();
    wp_die(); // prevent 0 output
  }
  public function upload_directory(){
    check_ajax_referer( 'upload_directory_nonce', 'nonce' ); // verifies the call to function

    error_log('InsideUPloadDirectory-rachs');

    $aws = new AWS_GetResources;
    $assetid=$_POST['assetid'];
    $assetslug=$_POST['assetslug'];
  //  $files=$_POST['data'];

  error_log("jsonString::".json_encode( $_FILES ));

    foreach($_FILES as $f){
      error_log('filename::'.$f['files']['name']);
    }

    if (!function_exists('wp_handle_upload')) {
           require_once(ABSPATH . 'wp-admin/includes/file.php');
       }
      // echo $_FILES["upload"]["name"];
    $movefile = wp_handle_upload($files);

    // echo $movefile['url'];
      if ($movefile && !isset($movefile['error'])) {
         echo "File Upload Successfully";
    } else {
        /**
         * Error generated by _wp_handle_upload()
         * @see _wp_handle_upload() in wp-admin/includes/file.php
         */
        echo $movefile['error'];
    }

    //echo $aws->fullUpload($assetid,$assetslug,$filepath);

  //  error_log( $f['filename']." has being processed");
    ob_clean();
    wp_die(); // prevent 0 output
  }
}

?>
