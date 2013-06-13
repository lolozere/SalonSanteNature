<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titre', 'ssn'); ?></label>
	<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Destination', 'ssn'); ?></label>
	<input placeholder="http://" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
</p>
<p>
	<img src="<?php echo $imageurl;?>" />
</p>