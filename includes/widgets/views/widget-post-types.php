<?php
echo $before_widget;
if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }

ssn_list_posts($post_type);

echo $after_widget;
?>