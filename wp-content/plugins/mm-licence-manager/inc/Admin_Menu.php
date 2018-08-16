<?php
class MMLM_Admin_Menu {

  function mm_admin_menu(){
          //add_menu_page( 'MM Licence Manager', 'MM Licence Manager', 'administrator', 'mm-licence-manager', $this->load_licences() );
          //add_submenu_page('mm-licence-manager','Assets')
          //  add_submenu_page('mm-licence-manager','Licences')
          return true;
  }

  function load_licences($menuslug=NULL){
    return true;
  }
}
?>
