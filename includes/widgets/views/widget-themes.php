<?php
echo $before_widget;
if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
?>
<ul>
	<?php ssn_list_themes('exposant_theme');?>
</ul>
<?
echo $after_widget;
?>