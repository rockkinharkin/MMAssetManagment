<?php

class Assets_Manager_Asset_Post_Type {
	/*
	 * Assets_Manager_Asset_Post_Type constructor.
	 */
	public function __construct() {}

	/**
	 * Registers WordPress actions
	 */
	private function hooks() {
		add_action( 'init', array( $this, 'create' ) ); # creates custom post type `assets`
	}

	/**
	 * Runs essential pieces of plugin to run within WordPress
	 */
	public function init() {
		$this->hooks();
	}

	public function create() {
		register_post_type(
			'mm-asset',
			array(
				'labels'          => array(
					'name'          => __( 'MM Assets' ),
					'singular_name' => __( 'MM Asset' )
				),
				'public'              => true,
				'menu_position'       => 10,
				'exclude_from_search' => true,
				'show_in_menu'        => true,
				'supports'            => array( 'title', 'editor','administrator')
			)
		);
	}
}
