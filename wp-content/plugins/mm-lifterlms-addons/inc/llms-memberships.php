<?php
class MM_Assets_LLMS_Memberships {

  public function __construct(){
    $this->requires();
  }

  public function requires(){
    require_once ABSPATH.'wp-content/plugins/lifterlms/includes/class.llms.person.php';
    require_once ABSPATH.'wp-content/plugins/lifterlms/includes/functions/llms.functions.person.php';
  }

  public function isUserEnrolled($postid){
    return $enrolled = llms_is_user_enrolled( get_current_user_id(), $postid ) ? 'is-enrolled' : 'not-enrolled';
  }

  public function UserHasMembership($userid){
    $memberships['_has_membership'] = array();

    if( $userid > 1 ){
      $llmsUser = new LLMS_Person();

      $memberships = $llmsUser->get_user_memberships_data($userid); //returns the users "posts" ( courses ) / memberships they have purchased

      foreach ( $memberships as $membership ){
        print_r($membership);
        //if( isset( $membership['_enrollment_trigger'] ) ){
          $order = $membership['_enrollment_trigger']->meta_value;
          // $orderID = str_replace( 'order_','',$order );
          // $orderPost = get_post( $membership['_enrollment_trigger']->post_id );

          if( ( $membership['_status']->meta_value == 'enrolled' )
              && ( $membership['_start_date']->meta_value == 'yes' ) ) {
                  $memberships['_has_membership'][ $order ] = true;
          }else{
            $memberships['_has_membership'][ $order ] = false;
          }
        //}
      }
    }
    return $memberships;
  }
}?>
