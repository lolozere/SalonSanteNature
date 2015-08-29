<?php
/**
 * STIC_Widget_Slider class
 **/
class STIC_Widget_FacebookBox extends WP_Widget {
	
	function STIC_Widget_FacebookBox() {
		extract($this->get_base_settings());
		$this->WP_Widget($widget_ops['id_base'], $widget_ops['name'], $widget_ops, $control_ops);
	}
	
	/**
	 * Widget frontend output
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		
		$instance = array_merge($this->get_defaults(), $instance);
		
		extract( $args );
		extract( $instance );
		
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		
		stic_fb_box_get_template('facebook-box-widget.php', array_merge($instance, $args));
		
		echo $after_widget;
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
		$new_instance = wp_parse_args( (array) $new_instance, $this->get_defaults() );
		$instance['href'] = $new_instance['href'];
		$instance['title'] = $new_instance['title'];
		$instance['header'] = (!empty($new_instance['header']))?'1':'0';
		$instance['width'] = intval($new_instance['width']);
		return $instance;
	}
	
	/**
	 * Form UI
	 *
	 * @param object $instance Widget Instance
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->get_defaults() );
		$instance['widget'] = $this;
		stic_fb_box_get_template('facebook-box-widget-admin.php', $instance );
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "Facebook Like Box", 'stic_fb_box'),
					'description' => __( "Affiche la facebook like box", 'stic_fb_box'),
					'classname' => 'widget_last_interview'
				),
				'control_ops' => array(
					'id_base' => 'stic_facebookbox',
				),
			);
	}
	
	function get_defaults() {
		$defaults =  array(
				'title' => __('Ils me suivent...', 'stic_fb_box'), 'width' => 250, 'href' => 'http://...',
				'colorscheme' => 'light', 'show_faces' => true, 'header' => false, 'stream' => false, 
				'show_border' => true
			);
		return $defaults;
	}

}
