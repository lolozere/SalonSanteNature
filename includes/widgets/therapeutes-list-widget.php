<?php
// Load the widget on widgets_init
function ssn_load_therapeutes_widget() {
	register_widget('SSN_Widget_Therapeutes');
}
add_action('widgets_init', 'ssn_load_therapeutes_widget');

/**
 * SSN_Widget_Exposants class
 **/
class SSN_Widget_Therapeutes extends SSN_Widget_PostsList {
	
	function SSN_Widget_Therapeutes() {
		$this->SSN_Widget_PostsList();
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "SSN: Thérapeutes", 'ssn'),
					'description' => __( "Liste des thérapeutes par ordre alphabétique", 'ssn'),
					'classname' => 'widget_therapeutes widget_by_name'
				),
				'control_ops' => array(
					'id_base' => 'ssn_therapeutes',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Liste des thérapeutes par ordre alphabétique",
			);
	}
	
	function get_type() {
		return 'therapeute';
	}

}
