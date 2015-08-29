<p>
	<label for="<?php echo $widget->get_field_id('title'); ?>">
		<?php _e('Titre:'); ?>
	</label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('title'); ?>" name="<?php echo $widget->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<p>
	<label for="<?php echo $widget->get_field_id('href'); ?>">
		<?php _e('Page facebook:'); ?>
	</label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('href'); ?>" name="<?php echo $widget->get_field_name('href'); ?>" type="text" value="<?php echo esc_attr($href); ?>" />
	<br /><span style="font-style: italic; font-size: 0.95em;">http://www.facebook.com/Solidees</span>
</p>
<p>
	<label for="<?php echo $widget->get_field_id('width'); ?>">
		<?php _e('Largeur (px):'); ?>
	</label> 
	<input class="widefat" id="<?php echo $widget->get_field_id('width'); ?>" name="<?php echo $widget->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" />
</p>
<p>
	<input class="checkbox" type="checkbox" <?php echo ($header)?'checked="checked"':''; ?> id="<?php echo $widget->get_field_id('header'); ?>" name="<?php echo $widget->get_field_name('header'); ?>" />
	<label for="<?php echo $widget->get_field_id('header'); ?>"><?php _e('Afficher entête'); ?></label>
</p>
