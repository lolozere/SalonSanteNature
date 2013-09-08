<?php
/**
 * SSN_Widget_PostsList class
 **/
abstract class SSN_Widget_PostsList extends SSN_Widget {
	
	function SSN_Widget_PostsList() {
		$this->SSN_Widget();
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
		include( $this->getTemplateHierarchy( 'widget-post-types' ) );
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
		$instance['minimize'] = $new_instance['minimize'];
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
					'name' => __( "SSN: Fiches", 'ssn'),
					'description' => __( "Liste des fiches par ordre alphabétique", 'ssn'),
					'classname' => 'widget_fiches widget_by_name'
				),
				'control_ops' => array(
					'id_base' => 'ssn_fiches',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Liste des fiches par ordre alphabétique",
				'minimize' => '0',
			);
	}

	abstract function get_type();
}
