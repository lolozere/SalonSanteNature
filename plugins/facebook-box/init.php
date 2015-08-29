<?php
define('STIC_FB_BOX_VERSION', '1.0.0');

/*
 * ---------
* LIB
* ---------
*/
function stic_fb_box_get_template($template_name, $vars = array()) {
	extract($vars);
	// Directories
	$parent_directory = get_template_directory();
	$directory = get_stylesheet_directory();
	// Get right CSS Uri
	if (file_exists($directory.'/plugins/stic-facebook-box/templates/'.$template_name)) {
		include($directory.'/plugins/stic-facebook-box/templates/'.$template_name);
	} elseif ($directory != $parent_directory && file_exists($parent_directory.'/plugins/stic-facebook-box/templates/'.$template_name)) {
		include($parent_directory.'/plugins/stic-facebook-box/templates/'.$template_name);
	} else {
		include(__DIR__.'/templates/'.$template_name);
	}
}

require_once('widgets/facebook-box.php');

// Load the widget on widgets_init
function stic_fb_box_registrer_widgets() {
	register_widget('STIC_Widget_FacebookBox');
}
add_action('widgets_init', 'stic_fb_box_registrer_widgets');
