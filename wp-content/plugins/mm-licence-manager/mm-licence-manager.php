<?php
/*
	Plugin Name: MAKEMATIC Licence Manager for WordPress
	Plugin URI: https://www.makematic.com/staff/assets-manager
	Description: An asset and licence management system for makematic clients
	Version: 1.0
	Author: Rachael Harkin
	Author URI: http://www.hybrid.digital
	Text Domain: assets-manager
	License: GPL3
*/

//$mm_licence_manager = new WP_Assets_Manager();
$mm_licence_manager = new MM_Licence_Manager();

class MM_Licence_Manager {
	private $Licence_Manager_Asset_Type;

	/*
	 * Assets Manager class construct
	 */
	public function __construct() {
		$this->include_dependencies();
		$this->setup();
		$this->teardown();
		$this->instantiate_components();
	}

	/**
	 * Runs essential pieces of plugin to run within WordPress
	 */
	public function init() {
		$this->hooks();
	}

	/**
	 * Include all dependencies
	 */
	public function include_dependencies(){
		require ABSPATH.'/vendor/autoload.php';
		require_once 'inc/AWS_Resources.php';
		require_once 'inc/Shortcodes.php';
		require_once 'inc/Admin_Menu.php';
		require_once 'inc/Licence_Post_Type.php';
		require_once 'inc/Asset.php';
		require_once 'inc/Log_Assets_Access.php';
		require_once 'inc/Asset_Post_Type.php';
		require_once 'inc/Check_Asset_Restrictions.php';
		require_once 'inc/Serve_Attachment.php';
		require_once 'inc/Public.php';
		require_once 'inc/Admin.php';
		require_once 'inc/Save_AssetSet.php';
		require_once 'inc/Update_Assets.php';
	}

/* Plugin activation
*/
	public function setup() {
		register_activation_hook( __FILE__, array( $this, 'mm_licence_manager_activate' ) );
	}

	/**
	 * Plugin deactivation
	 */
	public function teardown() {
		register_deactivation_hook( __FILE__, array( $this, 'mm_licence_manager_deactivate' ) );
	}

	/**
	 * Instantiates all components of plugin
	 */
	public function instantiate_components() {
		/** rh menu **/
		/**$MMLM_Admin_Menu =  new MMLM_Admin_Menu();
		add_action('admin_menu', $MMLM_Admin_Menu->mm_admin_menu() );**/

		/**=== Licences ===**/
		$MMLM_LicencePostType = new MM_Licence_Manager_Post_Type();
		$MMLM_LicencePostType->init();

		$scLoadAssets = new scLoadAssets();
		$scLoadAssets->init();

		/**=== Assets ====**/
		$Log_Assets_Access = new Assets_Manager_Log_Assets_Access();
		$Log_Assets_Access->init();

		$Assets_Manager_Asset_Type = new Assets_Manager_Asset_Post_Type();
		$Assets_Manager_Asset_Type->init();

		$Check_Asset_Restrictions = new Check_Asset_Restrictions();
		$Check_Asset_Restrictions->init();

		$Serve_File = new Assets_Manager_Serve_Attachment();
		$Serve_File->init();

		$Public = new Assets_Manager_Public();
		$Public->init();

		$Assets_Manager_Admin = new Assets_Manager_Admin();
		$Assets_Manager_Admin->init();

		$Assets_Manager_Save_Admin = new Assets_Manager_Save_Asset_Set();
		$Assets_Manager_Save_Admin->init();

		$Assets_Manager_Update_Asset = new Assets_Manager_Update_Asset();
		$Assets_Manager_Update_Asset->init();
	}

	/**
	 * Run this on plugin activation
	 */
	public function wp_assets_manager_activate() {
		Assets_Manager_Log_Assets_Access::create_log_table();
		$this->create_asset_post_type();
	}

	/**
	 * Create asset post type
	 */
	private function create_asset_post_type() {
		$Assets_Manager_Asset_Type = new Assets_Manager_Asset_Post_Type();
		$Assets_Manager_Asset_Type->create();
		flush_rewrite_rules();
	}

	/**
	 * Clean up after deactivation
	 */
	public function wp_assets_manager_deactivate() {
		flush_rewrite_rules();
	}
}
