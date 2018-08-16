<?php
class MM_Licence_Manager_Post_Type{

  public function __construct() {}

	/**
	 * Registers WordPress actions
	 */
	private function hooks() {
		add_action( 'init', array( $this, 'create' ) ); # creates custom post type `licence`
	}

	/**
	 * Runs essential pieces of plugin to run within WordPress
	 */
	public function init() {
		$this->hooks();
	}

	public function create() {
		register_post_type(
			'licence',
			array(
				'labels'          => array(
					'name'          => __( 'Licences' ),
					'singular_name' => __( 'Licence' )
				),
				'public'              => true,
				'menu_position'       => 10,
				'exclude_from_search' => true,
				'show_in_menu'        => false
			)
		);
  }
}
?>
