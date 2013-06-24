<?php
if (class_exists('super_rss_reader_widget')) {
	// Load the widget on widgets_init
	function ssn_load_rss_widget() {
		register_widget('SSN_Widget_RssBlog');
	}
	add_action('widgets_init', 'ssn_load_rss_widget');

	/**
	 * SSN_Widget_Rss class
	 **/
	class SSN_Widget_RssBlog extends super_rss_reader_widget {
		
		function get_base_settings() {
			return array(
					'widget_ops' => array(
							'name' => __( "SSN: Actu Blog", 'ssn'),
							'description' => __( "Affiche la dernière actu du blog", 'ssn'),
							'classname' => 'ssn_rssblog'
					),
					'control_ops' => array(
							'id_base' => 'ssn_rssblog',
					),
			);
		}
		
		## Display the Widget
		function widget($args, $instance){
			extract($args);
			$title = '';
		
			echo $before_widget . $title;
			echo "\n" . '
			<!-- Start - Blog RSS Reader v' . SRR_VERSION . '-->
			<div class="ssn-blog-widget">
				<div class="title">
            		<img title="Actu Blog" src="'. get_template_directory_uri() .'/images/actublog_titre.png" />
                </div>
                <div class="content">' . "\n";
		
			srr_rss_parser($instance);
		
			echo "\n" . '</div></div>
			<!-- End - Super RSS Reader -->
			' . "\n";
			echo $after_widget;
		}
		
		function SSN_Widget_RssBlog() {
			extract($this->get_base_settings());
			$this->WP_Widget($widget_ops['id_base'], $widget_ops['name'], $widget_ops, $control_ops);
		}
		
		## Save settings
		function update($new_instance, $old_instance) {
			$instance = wp_parse_args( (array) $instance, array(
					'title' => '', 'urls' => '', 'count' => 1,
					'show_date' => 0, 'show_desc' => 0, 'show_author' => 0, 'show_thumb' => 1,
					'open_newtab' => 1, 'strip_desc' => 100, 'read_more' => '[...]',
					'color_style' => 'none', 'enable_ticker' => 0, 'visible_items' => 1,
					'strip_title' => 0, 'ticker_speed' => 2,
			));
			$instance['urls'] = stripslashes($new_instance['urls']);
			return $instance;
		}
			
		## HJA Widget form
		function form($instance){
			$instance = wp_parse_args( (array) $instance, array(
				'title' => '', 'urls' => '', 'count' => 1,
				'show_date' => 0, 'show_desc' => 0, 'show_author' => 0, 'show_thumb' => 1, 
				'open_newtab' => 1, 'strip_desc' => 100, 'read_more' => '[...]',
				'color_style' => 'none', 'enable_ticker' => 0, 'visible_items' => 1, 
				'strip_title' => 0, 'ticker_speed' => 2,
			));
			
			$urls = htmlspecialchars($instance['urls']);
			?>
			<div class="srr_settings">
			<table width="100%" height="72" border="0">
				<tr>
					<td><label for="<?php echo $this->get_field_id('urls'); ?>">URLs: </label></td>
					<td><input id="<?php echo $this->get_field_id('urls');?>" name="<?php echo $this->get_field_name('urls'); ?>" type="text" value="<?php echo $urls; ?>" class="widefat"/>
					<small class="srr_smalltext">Plusieurs RSS possibles en séparant par une virgule.</small>
					</td>
				</tr>
			</table>
			</div>
			<?php
		}
		
	}
}