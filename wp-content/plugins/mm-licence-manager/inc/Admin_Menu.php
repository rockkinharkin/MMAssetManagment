<?php
class MMLM_Admin_Menu {

  /**function mm_admin_menu(){
          //add_menu_page( 'MM Manage Licences', 'MM Manage Licences', 'administrator', 'mm-licence-manager', $this->load_licences() );
          add_submenu_page('mm-asset','Manage Licences','administrator', 'mm-licence-manager', $this->load_licences() );
          //  add_submenu_page('mm-licence-manager','Licences')

          register_mm_assets_menu_page() {
    add_menu_page(
        __( 'Manage Licences', 'managelicences' ),
        'custom menu',
        'manage_options',
        'myplugin/myplugin-admin.php',
        '',
        plugins_url( 'mm-licence-manager/icons/icon.png' ),
        6
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );


          /**-- Manage Licences
          -- Manage Assets
              -- list view of Assets
              -- single asset view ( show licences on page ) - not menu
           -- new asset**/
  //}

  /**function load_licences($menuslug=NULL){
    echo $content = "<h1>Licences</h1>";

    return add_filter('the_content',$content);
  }**/
}
?>
