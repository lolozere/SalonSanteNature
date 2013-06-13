<?php
// Load the widget on widgets_init
function ssn_load_newsletter_widget() {
	register_widget('SSN_Widget_Newsletter_Image');
}
add_action('widgets_init', 'ssn_load_newsletter_widget');

/**
 * SSN_Widget_Newsletter_Image class
 **/
class SSN_Widget_Newsletter_Image extends SSN_Image_Widget {
	
	function SSN_Widget_Newsletter_Image() {
		$this->SSN_Image_Widget();
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "SSN: Newsletter", 'ssn'),
					'description' => __( "Accès inscription newsletter", 'ssn')
				),
				'control_ops' => array(
					'id_base' => 'ssn_newsletter_image',
				),
			);
	}
	
	function get_defaults() {
		return array(
				'title' => "Newsletter",
				'link' => "",
				'imageurl' => get_template_directory_uri() . '/images/widget_newsletter.png',
			);
	}

}
