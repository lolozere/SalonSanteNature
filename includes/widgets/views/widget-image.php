<?php
echo $before_widget;
if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
?>
<a title="<?php esc_attr((!empty($title))?$title:'');?>" href="<?php echo $link;?>">
	<img src="<?php echo $imageurl; ?>" alt="<?php esc_attr((!empty($title))?$title:'');?>">
</a>
<?
echo $after_widget;
?>