<?php
/*
	Plugin Name: Asset Widget
	Plugin URI: https://www.makematic.com/staff/assets-manager
	Description: An widget to display resources for displayed asset
	Version: 1.0
	Author: Rachael Harkin
	Author URI: http://www.hybrid.digital
	Text Domain: assets-manager
	License: GPL3
*/

// Register and load the widget
/*function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );*/

// Register and load the widget
function mm_asset_load_widget() {
    register_widget( 'mm_asset_widget' );
}
add_action( 'widgets_init', 'mm_asset_load_widget' );

// Creating the widget
class mm_asset_widget extends WP_Widget {

  function __construct() {
  parent::__construct(

  // Base ID of your widget
  'mm_asset_widget',

  // Widget name will appear in UI
  __('MM Asset Widget', 'mm_asset_widget'),

  // Widget description
  array( 'description' => __( 'This widget displays the asset resources for the current content displayed', 'mm_asset_widget' ), )
  );
  }

  // Creating widget front-end

  public function widget( $args, $instance ) {
  $title = apply_filters( 'widget_title', $instance['title'] );

  // before and after widget arguments are defined by themes
  echo $args['before_widget'];
  if ( ! empty( $title ) )
  echo $args['before_title'] . $title . $args['after_title'];

  // This is where you run the code and display the output
  echo __( 'Hello, World!', 'mm_asset_widget' );
  echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
  if ( isset( $instance[ 'title' ] ) ) {
  $title = $instance[ 'title' ];
  }
  else {
  $title = __( 'New title', 'mm_asset_widget' );
  }
  // Widget admin form
  ?>
  <p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
  </p>
  <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
  $instance = array();
  $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
  return $instance;
  }
} // Class wpb_widget ends here
?>
