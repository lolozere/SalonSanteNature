<?php
/**
 * SSN_Image_Widget class
 **/
abstract class SSN_Image_Widget extends SSN_Widget {
	
	function SSN_Image_Widget() {
		$this->SSN_Widget();
		$this->widget_options['classname'] = 'widget_sp_image';
	}

	/**
	 * Widget frontend output
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );
		include( $this->getTemplateHierarchy( 'widget-image' ) );
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
		$instance['link'] = $new_instance['link'];
		$instance = array_merge($this->get_defaults(), $instance);
		return $instance;
	}

	/**
	 * Form UI
	 *
	 * @param object $instance Widget Instance
	 * @author Modern Tribe, Inc.
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->get_defaults() );
		extract($instance);
		include( $this->getTemplateHierarchy( 'widget-image-admin' ) );
	}

}
