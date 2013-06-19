<?php
// Load the widget on widgets_init
function ssn_load_themestherapeute_widget() {
	register_widget('SSN_Widget_ThemesTherapeute');
}
add_action('widgets_init', 'ssn_load_themestherapeute_widget');

/**
 * SSN_Widget_ThemesTherapeute class
 **/
class SSN_Widget_ThemesTherapeute extends SSN_Widget {
	
	function SSN_Widget_ThemesTherapeute() {
		$this->SSN_Widget();
	}
	
	/**
	 * Widget frontend output
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		$args['taxonomy'] = 'tpeute_theme';
		extract( $args );
		extract( $instance );
		include( $this->getTemplateHierarchy( 'widget-themes' ) );
	}
	
	/**
	 * Update widget options
	 *
	 * @param object $new_instance Widget Instance
	 * @param object $old_instance Widget Instance
	 * @return object
	 * @author Laurent Chedanne
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance = array_merge($this->get_defaults(), $instance);
		return $instance;
	}
	
	/**
	 * Form UI
	 *
	 * @param object $instance Widget Instance
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->get_defaults() );
		extract($instance);
		include( $this->getTemplateHierarchy( 'widget-themes-admin' ) );
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "SSN: Thèmes Thérapeutes", 'ssn'),
					'description' => __( "Liste des thèmes des thérapeutes", 'ssn'),
					'classname' => 'widget_therapeutes widget_themes'
				),
				'control_ops' => array(
					'id_base' => 'ssn_themestherapeute',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Liste des thérapeutes par thème",
			);
	}

}
