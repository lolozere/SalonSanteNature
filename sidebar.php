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

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
	
         
            <a href= "#" title="réservez votre pass bien-être"><img src="<?php echo get_template_directory_uri(); ?>/images/widget_pass_bienetre.png" /></a>
            
        </div>
        
        
        <!-- #secondary -->
	<?php endif; ?>