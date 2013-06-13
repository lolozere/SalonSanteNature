<?php
// Load the widget on widgets_init
function ssn_load_therapeutes_access_widget() {
	register_widget('SSN_Widget_TherapeuteAccess_Image');
}
add_action('widgets_init', 'ssn_load_therapeutes_access_widget');

/**
 * SSN_Widget_ExposantAccess_Image class
 **/
class SSN_Widget_TherapeuteAccess_Image extends SSN_Image_Widget {
	
	function SSN_Widget_TherapeuteAccess_Image() {
		$this->SSN_Image_Widget();
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "SSN: Accès Thérapeutes", 'ssn'),
					'description' => __( "Image pour accéder à l'espace Thérapeutes", 'ssn')
				),
				'control_ops' => array(
					'id_base' => 'ssn_therapeuteaccess_image',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Thérapeutes",
				'link' => "",
				'imageurl' => get_template_directory_uri() . '/images/widget_therapeutes.png',
			);
	}

}
