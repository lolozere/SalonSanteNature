<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	<?php 
	if ( is_active_sidebar( 'contentplus' ) && !ssn_is_full_page() && !ssn_is_two_columns()) : ?>
		<div id="troisieme" class="widget-area" role="complementary">
			<?php 
			if (is_front_page()) {
				dynamic_sidebar( 'sidebar-home' );
			} elseif (is_rubrique_exposants()) {
				dynamic_sidebar( 'sidebar-exposants' );
			} elseif (is_rubrique_pass()) {
				dynamic_sidebar( 'sidebar-pass' );
			} elseif (is_rubrique_conferences()) {
				dynamic_sidebar( 'sidebar-conference' );
			} elseif (is_rubrique_bookstand()) {
				dynamic_sidebar( 'sidebar-bookstand' );
			} else {
				dynamic_sidebar( 'contentplus' );
			}
			?>
		</div><!-- #troisieme -->
	<?php endif; ?>