<?php
// Load the widget on widgets_init
function ssn_load_pass_widget() {
	register_widget('SSN_Widget_BookPass_Image');
}
add_action('widgets_init', 'ssn_load_pass_widget');

/**
 * SSN_Widget_Invitation_Image class
 **/
class SSN_Widget_BookPass_Image extends SSN_Image_Widget {
	
	function SSN_Widget_BookPass_Image() {
		$this->SSN_Image_Widget();
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "SSN: Réserver Pass", 'ssn'),
					'description' => __( "Réserver son pass bien-être", 'ssn')
				),
				'control_ops' => array(
					'id_base' => 'ssn_bookpass_image',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Pass bien-être",
				'link' => "",
				'imageurl' => get_template_directory_uri() . '/images/widget_pass_bienetre.png',
			);
	}

}
