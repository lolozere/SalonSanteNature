<?php
define('PASSBOOK_VERSION', '2013.1');

// Load the widget on widgets_init
function ssn_load_passbook_availability_widget() {
	register_widget('SSN_Widget_PassbookAvailability');
}
add_action('widgets_init', 'ssn_load_passbook_availability_widget');

function ssn_passbook_init() {
	global $wp_scripts;
	if (empty($wp_scripts->registered['jquery-scroll'])) {
		wp_register_script( 'jquery-scroll', get_template_directory_uri() . '/plugins/passbook/ressources/jquery.scrollbox.js', array('jquery-ui-widget'), PASSBOOK_VERSION);
	}
	wp_register_style('passbook-scroll', get_template_directory_uri() . '/plugins/passbook/ressources/passbook-style.css', array(), PASSBOOK_VERSION);
}
add_action( 'init', 'ssn_passbook_init' );

function ssn_passbook_js() {
	// CSS and JS
	wp_enqueue_style('passbook-scroll');
	wp_enqueue_script('jquery-scroll');
}
add_action('wp_enqueue_scripts', 'ssn_passbook_js');

/**
 * SSN_Widget_Exposants class
 * 
 * @author Laurent Chedanne
 **/
class SSN_Widget_PassbookAvailability extends WP_Widget {
	
	function SSN_Widget_PassbookAvailability() {
		extract($this->get_base_settings());
		$this->WP_Widget($widget_ops['id_base'], $widget_ops['name'], $widget_ops, $control_ops);
	}
	
	function widget( $args, $instance ) {
		global $post;
		$is_animation_card = (is_single() && $post->post_type == 'therapeute') || (is_page() && $post->post_parent == '6414') ;
		//6414 étant la page quoi de neuf
		

		if ($is_animation_card) {
			//get animation id
			$metas = get_metadata('post', $post->ID);
			$animationsId = null;
			foreach($metas as $meta_key => $meta_value) {
				if ($meta_key == SSN_FICHE_META_PREFIX.'animation_id') {
					$animationsId = $meta_value[0];
				}
			}
			if (!is_null($animationsId)) {
				extract($args);
				$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
				$api_url = empty( $instance['api_url'] ) ? '' : $instance['api_url'];
			
				echo $before_widget;
				if ( $title )
					echo $before_title . $title . $after_title;
				
				// get animation id
			
				// Use current theme search form if it exists
				include( $this->getTemplateHierarchy( 'widget-passbook-availability' ) );
				echo $after_widget;
			}
		}
	}
	
	/**
	 * Update widget options
	 *
	 * @param object $new_instance Widget Instance
	 * @param object $old_instance Widget Instance
	 * @return object
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => '', 'api_url' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['api_url'] = strip_tags($new_instance['api_url']);
		return $instance;
	}
	
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'api_url' => '') );
		$title = $instance['title'];
		$api_url = $instance['api_url'];
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('api_url'); ?>"><?php _e('API Url:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('api_url'); ?>" name="<?php echo $this->get_field_name('api_url'); ?>" type="text" value="<?php echo esc_attr($api_url); ?>" /></label></p>
	<?php
	}
	
	function get_base_settings() {
		return array(
				'widget_ops' => array(
					'name' => __( "Passbook: Créneaux Horaires", 'ssn'),
					'description' => __( "Si un article est relié à une animation de l'application Oxygen Passbook alors affiche les créneaux horaires", 'ssn'),
					'classname' => 'widget_passbook_availability'
				),
				'control_ops' => array(
					'id_base' => 'ssn_passbookavailability',
				),
			);
	}
	
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
