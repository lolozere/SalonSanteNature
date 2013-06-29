<?php
/**
 * SSN_Widget class
 **/
abstract class SSN_Widget extends WP_Widget {
	
	/**
	 * Return array with two keys :
	 * - widget_ops
	 * - control_ops
	 * 
	 */
	abstract function get_base_settings();

	function SSN_Widget() {
		extract($this->get_base_settings());
		$this->WP_Widget($widget_ops['id_base'], $widget_ops['name'], $widget_ops, $control_ops);
	}
	
	abstract function get_defaults();

	/**
	 * Loads theme files in appropriate hierarchy: 1) child theme,
	 * 2) parent template, 3) plugin resources. will look in the image-widget/
	 * directory in a theme and the views/ directory in the plugin
	 *
	 **/
	function getTemplateHierarchy($template) {
		// whether or not .php was added
		$template_slug = rtrim($template, '.php');
		$template = $template_slug . '.php';

		if ( $theme_file = locate_template(array('views/'.$template)) ) {
			$file = $theme_file;
		} else {
			$file = 'views/' . $template;
		}
		
		return apply_filters( 'sp_template_image-widget_'.$template, $file);
	}
}
