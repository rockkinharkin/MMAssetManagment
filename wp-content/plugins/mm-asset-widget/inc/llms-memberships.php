<?php
class MM_Assets_LLMS_Memberships {

  public function __construct(){
    $this->requires();
  }

  public function requires(){
    require_once ABSPATH.'wp-content/plugins/lifterlms/includes/class.llms.person.php';
  }

  public function UserHasMembership($userid){
    $memberships['_has_membership'] = array();

    if( $userid > 1 ){
      $llmsUser = new LLMS_Person();
      $memberships = $llmsUser->get_user_memberships_data($userid);

      foreach ( $memberships as $membership ){
        if( isset( $membership['_enrollment_trigger'] ) ){
          $order = $membership['_enrollment_trigger']->meta_value;
          $orderID = str_replace( 'order_','',$order );
          $orderPost = get_post( $membership['_enrollment_trigger']->post_id );

          if( ( $membership['_status']->meta_value == 'enrolled' )
              && ( $membership['_start_date']->meta_value == 'yes' )
              && ( ( $orderPost->post_type ='llms_order' ) && ( $orderPost->post_status == 'llms_completed' ) )
            ){ // determines completion of the order
                  $memberships['_has_membership'][ $order ] = 'yes';
          }else{
            $memberships['_has_membership'][ $order ] = 'no';
          }
        }
      }
    }
    echo "CLASS CALL::".print_r($memberships);
    return $memberships;
  }
}?>
