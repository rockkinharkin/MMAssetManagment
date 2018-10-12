<?php
class MM_Shortcodes{

  function __construct(){
    $this->requires();
    $this->hooks();
    $this->userID=1;
    $this->postID=1;
    $this->assetType='video';

    if( isset($_GET['type'] ) ){ $this->assetType=$_GET['type'];}
    if( isset($_GET['aid'] ) ){ $this->postID=$_GET['aid'];}
    if( isset($_GET['uid'] ) ){ $this->userID=$_GET['uid'];}
    if( isset($_GET['src'] ) ){ $this->filesrc=$_GET['src'];}
  }

  public function checkLicence($userid,$assetid){
    echo "check licence function";
    $member = new MM_Assets_LLMS_Memberships();
    if(  $member->isUserEnrolled($userid,$assetid) == 'is-enrolled' ){
        $url = BUCKURL.'/'.$this->filesrc;
        return $url;
        //return wp_redirect($url); exit;
    }
  }

/*=================================*/
  private function hooks() {
    add_shortcode('checklicence', array( $this,'checkLicence') );
  }

  private function requires(){
    require_once ABSPATH.'wp-content/plugins/mm-lifter-lms-addons/config.php';
    require_once ABSPATH.'wp-content/plugins/mm-lifter-lms-addons/controllers/class.llms-memberships.php'; // to check memberships#
  }
} // end class
?>
