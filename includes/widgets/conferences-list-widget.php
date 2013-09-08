<?php
// Load the widget on widgets_init
function ssn_load_conferences_widget() {
	register_widget('SSN_Widget_Conferences');
}
add_action('widgets_init', 'ssn_load_conferences_widget');

/**
 * SSN_Widget_Conferences class
 **/
class SSN_Widget_Conferences extends SSN_Widget_PostsList {
	
	function SSN_Widget_Conferences() {
		$this->SSN_Widget_PostsList();
	}
	
	/**
	 * Widget frontend output
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		$args['post_type'] = $this->get_type();
		extract( $args );
		extract( $instance );
		include( $this->getTemplateHierarchy( 'widget-conferences' ) );
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "SSN: Conférences", 'ssn'),
					'description' => __( "Liste des conférences par ordre alphabétique", 'ssn'),
					'classname' => 'widget_conférences widget_by_name'
				),
				'control_ops' => array(
					'id_base' => 'ssn_conferences',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Liste des conférences par ordre alphabétique",
			);
	}
	
	function get_type() {
		return 'conference';
	}

}
