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
			<?php 
			if (is_front_page()) {
				dynamic_sidebar( 'sidebar-mainhome' );
			} elseif (is_rubrique_exposants()) {
				dynamic_sidebar( 'sidebar-mainexposants' );
			} elseif (is_rubrique_pass()) {
				dynamic_sidebar( 'sidebar-mainpass' );
			} elseif (is_rubrique_conferences()) {
				dynamic_sidebar( 'sidebar-mainconference' );
			} else {
				dynamic_sidebar( 'sidebar-1' );
			}
			?>            
            <aside id="widget_blog" class="widget_gauche">
            
            	<div id="titre">
            	<img title="Actu Blog" src="<?php echo get_template_directory_uri(); ?>/images/actublog_titre.png" />
            	<img src="<?php echo get_template_directory_uri(); ?>/images/photoblog_test.jpg" />
                </div>
                <div id="texte">
            	<p>Sortie du livre « Paroles de Nathanaël », le Feng Shui du corps par Georges Rafflin et Françoise Riu disponible au Salon Santé Nature</p><br/>
					<a href= "#" title="lire la suite">>> Lire la suite >></a>
            	</div>
            </aside>
        </div>
        
        
        <!-- #secondary -->
	<?php endif;?>