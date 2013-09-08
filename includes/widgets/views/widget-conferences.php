<?php
echo $before_widget;
$widget_id = uniqid('list_');
if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }?>
<?php if (!empty($minimize) && $minimize == '1'): ?>
<script>
!function ($) {
	$(document).ready(function() {
		$('#<?php echo $widget_id?>[data-toggle="scrollbox"]').scrollbox();;
	});
}(window.jQuery);
</script>
<div id="<?php echo $widget_id;?>" data-toggle="scrollbox" class="scroll" data-height="240">
	<div class="scroll-inner">
<?php endif?>
<?php ssn_list_conferences(); ?>
<?php if (!empty($minimize) && $minimize == '1'): ?>
	</div>
	<div class="scroll-control">
		<i data-direction="up" class="icon-arrow-up" style="cursor: pointer;">Précédents</i>
		<i data-direction="down" class="icon-arrow-down" style="cursor: pointer;">Suivants</i>
		<i data-direction="all" style="cursor: pointer;">Tous</i>
		<i data-direction="minimize" style="cursor: pointer;">Réduire</i>
	</div>
</div>
<?php endif?>

<?php echo $after_widget; ?>