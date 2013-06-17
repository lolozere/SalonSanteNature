<?php
// Load the widget on widgets_init
function ssn_load_exposants_widget() {
	register_widget('SSN_Widget_Exposants');
}
add_action('widgets_init', 'ssn_load_exposants_widget');

/**
 * SSN_Widget_Exposants class
 **/
class SSN_Widget_Exposants extends SSN_Widget_PostsList {
	
	function SSN_Widget_Exposants() {
		$this->SSN_Widget_PostsList();
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "SSN: Exposants", 'ssn'),
					'description' => __( "Liste des exposants par ordre alphabétique", 'ssn'),
					'classname' => 'widget_exposants widget_by_name'
				),
				'control_ops' => array(
					'id_base' => 'ssn_exposants',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Liste des exposants par ordre alphabétique",
			);
	}
	
	function get_type() {
		return 'exposant';
	}

}
