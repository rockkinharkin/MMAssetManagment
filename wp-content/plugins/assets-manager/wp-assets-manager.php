<?php
/*
	Plugin Name: Assets Manager for WordPress
	Plugin URI: https://www.jackreichert.com/2015/11/how-assets-manager-replaced-our-sharefile/
	Description: Plugin creates an assets manager. Providing a self hosted file sharing platform.
	Version: 1.0.2
	Author: Jack Reichert
	Author URI: http://www.jackreichert.com
	Text Domain: assets-manager
	License: GPL3
*/

$wp_assets_manager = new WP_Assets_Manager();

class WP_Assets_Manager {
	private $Assets_Manager_Asset_Type;

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
	 * Include all dependencies
	 */
	public function include_dependencies() {
		// rh appended
		require ABSPATH.'/vendor/autoload.php';
		require_once 'inc/AWS_Resources.php';
		//require_once 'inc/Shortcodes.php';
		//require_once 'inc/Licence_Post_Type.php';
		// original
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

	/**
	 * Plugin activation
	 */
	public function setup() {
		register_activation_hook( __FILE__, array( $this, 'wp_assets_manager_activate' ) );
		register_activation_hook( __FILE__, array( $this,'install' ) );
	}

	/**
	 * Plugin deactivation
	 */
	public function teardown() {
		register_deactivation_hook( __FILE__, array( $this, 'wp_assets_manager_deactivate' ) );
	}

	/**
	 * Instantiates all components of plugin
	 */
	public function instantiate_components() {
		// rh additions
		/**=== Licences ===**/
	//	$MMLM_LicencePostType = new MM_Licence_Manager_Post_Type();
	//	$MMLM_LicencePostType->init();

		//shortcodes
	//	$scLoadAssets = new scLoadAssets();
	//	$scLoadAssets->init();

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

	public function asset_manager_uninstall(){
		register_uninstall_hook( __FILE__, array( $this,'uninstall' ) );
	}

	public function uninstall () {
	   global $wpdb;

	  delete_option( "mmlm_db_version" );

	  if( isset( $wpdb ) ){
	    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}mmlm_customers,
	                                        {$wpdb->prefix}mmlm_content,
	                                        {$wpdb->prefix}mmlm_content");
	  }
	}

	/**public function install() {
	 global $wpdb;

	 //setting up tablenames
	// $tn_customers = $wpdb->prefix."mmam_customers";
	 $tn_licences = $wpdb->prefix."mmam_licences";

	$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $tn_customers (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			parent_id mediumint(9) NOT NULL,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			name TEXT NULL,
			address VARCHAR(500) NULL,
			phone		VARCHAR(200) NULL,
			{$wpdb->prefix}user_id BIGINT(20),
			PRIMARY KEY(id)
		) $charset_collate;";


	$sql .= "CREATE TABLE $tn_licences (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		licence_key VARCHAR(200) NOT NULL,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		{$wpdb->prefix}user_id BIGINT(20),
		{$wpdb->prefix}post_id BIGINT(20),
		{$wpdb->prefix}mmlm_customer_id BIGINT(20),
		PRIMARY KEY(id)
	) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( "mmlm_db_version", "1.0" );
	}**/
}
