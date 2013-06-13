<?php
// Load the widget on widgets_init
function ssn_load_invitation_widget() {
	register_widget('SSN_Widget_Invitation_Image');
}
add_action('widgets_init', 'ssn_load_invitation_widget');

/**
 * SSN_Widget_Invitation_Image class
 **/
class SSN_Widget_Invitation_Image extends SSN_Image_Widget {
	
	function SSN_Invitation_Widget() {
		$this->SSN_Image_Widget();
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "SSN: Invitation Gratuite", 'ssn'),
					'description' => __( "Affiche le menu d'invitation gratuite", 'ssn')
				),
				'control_ops' => array(
					'id_base' => 'ssn_invitation_image',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Invitation gratuite",
				'link' => "",
				'imageurl' => get_template_directory_uri() . '/images/widget_entreegratuite.png',
			);
	}

}
