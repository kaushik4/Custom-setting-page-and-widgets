<?php
/*
Plugin Name: Widget Plugin
Plugin URI: www.worldwebtechnology.com
Description: This plugin adds a custom widget.
Version: 1.0
Author: World Web Technology
Author URI: http://www.worldwebtechnology.com/
License: GPL2
*/
//setting page
include 'widgetsetting.php';
// The widget class
class worldweb extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
			'worldweb',
			__( 'Wpd Ws Example Widget', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
	}

	// The widget form (for the backend )
	public function form( $instance ) {

		// Set widget defaults
		$defaults = array(
			'title'    => '',
			'fname'    => '',
			'lname'    => '',
			'select'   => '',
			'checkbox' => '',
		);
		
		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

		<?php // Widget Title ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type=" " value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php // Text fname ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'fname' ) ); ?>"><?php _e( 'First Name:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'fname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fname' ) ); ?>" type="text" value="<?php echo esc_attr( $fname ); ?>" />
		</p>

		<?php // Text lname ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'lname' ) ); ?>"><?php _e( 'Last Name:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'lname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'lname' ) ); ?>" type="text" value="<?php echo esc_attr( $lname ); ?>" />
		</p>

		

		<?php // Dropdown ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'select' ); ?>"><?php _e( 'Select', 'text_domain' ); ?></label><br>
			<select name="<?php echo $this->get_field_name( 'select' ); ?>" id="<?php echo $this->get_field_id( 'select' ); ?>" class="">
			<?php
			// Your options array
			$options = array(
				''        => __( 'Select Gender', 'text_domain' ),
				'option_1_male' => __( 'Male', 'text_domain' ),
				'option_2_female' => __( 'Female', 'text_domain' ),
			);

			// Loop through options and add each one to the select dropdown
			foreach ( $options as $key => $name ) {
				echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $select, $key, false ) . '>'. $name . '</option>';

			} ?>
			</select>
		</p>
		
		<?php // Checkbox ?>
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'Display sex publicly?' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>"><?php _e( 'Checkbox', 'text_domain' ); ?></label>
				</p>
	<?php }

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['fname']     = isset( $new_instance['fname'] ) ? wp_strip_all_tags( $new_instance['fname'] ) : '';
		$instance['lname']     = isset( $new_instance['lname'] ) ? wp_strip_all_tags( $new_instance['lname'] ) : '';
		$instance['checkbox'] = isset( $new_instance['checkbox'] ) ? 1 : false;
		$instance['select']   = isset( $new_instance['select'] ) ? wp_strip_all_tags( $new_instance['select'] ) : '';
		return $instance;
	}

	// Display the widget
	public function widget( $args, $instance ) {

		extract( $args );

		// Check the widget options
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$fname     = isset( $instance['fname'] ) ? $instance['fname'] : '';
		$lname     = isset( $instance['lname'] ) ? $instance['lname'] : '';
		$select   = isset( $instance['select'] ) ? $instance['select'] : '';
		$checkbox = ! empty( $instance['checkbox'] ) ? $instance['checkbox'] : false;

		// WordPress core before_widget hook (always include )
		echo $before_widget;

		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box">';

			// Display widget title if defined
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			// Display fname field
			if ( $fname ) {
				echo '<p>Hello my name is ' .$fname.' ' .$lname. '</p>';
			}
			// Display lname field
			if ( $lname ) {
				//echo '<p>' . $lname . '</p>';
			}

			// Display select field
			if ( $select ) {
				//echo '<p>' . $select . '</p>';
			}
			// Display something if checkbox is true
			if ( $checkbox ) {
				//echo '<p>Something awesome</p>';
			}

		echo '</div>';

		// after_widget hook (always include )
		echo $after_widget;

	}

}

// Register the widget
function worldweb_custom_widget() {
	register_widget( 'worldweb' );
}
add_action( 'widgets_init', 'worldweb_custom_widget' );