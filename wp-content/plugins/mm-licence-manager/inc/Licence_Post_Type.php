<?php
/** delete this file when finished building **/
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
			'mm-licences',
			array(
				'labels'          => array(
					'name'          => __( 'MM Licences' ),
					'singular_name' => __( 'MM Licence' ),
          'add_new'       => __('Add New Licence'),
          'edit_item'     => __('Edit Licence'),
          'view_item'     => __('View Licence'),
          'view_items'    => __('View Licences')
				),
				'public'              => true,
				'menu_position'       => 10,
				'exclude_from_search' => true,
				'show_in_menu'        => true,
        'supports'            => array( 'title', 'editor','administrator' ),
        'rewrite'             => array('slug','mm-licences')
			)
		);
  }
}
?>
