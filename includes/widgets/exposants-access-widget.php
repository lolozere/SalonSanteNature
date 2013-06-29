<?php
// Load the widget on widgets_init
function ssn_load_exposants_access_widget() {
	register_widget('SSN_Widget_ExposantAccess_Image');
}
add_action('widgets_init', 'ssn_load_exposants_access_widget');

/**
 * SSN_Widget_ExposantAccess_Image class
 **/
class SSN_Widget_ExposantAccess_Image extends SSN_Image_Widget {
	
	function SSN_Widget_ExposantAccess_Image() {
		$this->SSN_Image_Widget();
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "SSN: Accès Exposant", 'ssn'),
					'description' => __( "Image pour accéder à l'espace exposant", 'ssn')
				),
				'control_ops' => array(
					'id_base' => 'ssn_exposantaccess_image',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Exposants",
				'link' => get_permalink(SSN_PAGE_EXPOSANTS_ID),
				'imageurl' => get_template_directory_uri() . '/images/widget_exposants.png',
			);
	}

}
