<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titre', 'ssn'); ?></label>
	<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('minimize'); ?>"><?php _e('Minimiser ?', 'ssn'); ?></label>
	<select id="<?php echo $this->get_field_id('minimize'); ?>" name="<?php echo $this->get_field_name('minimize'); ?>">
		<option value="0" <?php echo (($minimize == '0')?'selected':'');?>>Non</option>
		<option value="1" <?php echo (($minimize == '1')?'selected':'');?>>Oui</option>
	</select>
</p>