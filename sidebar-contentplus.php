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

	<?php if ( is_active_sidebar( 'contentplus' ) ) : ?>
		<div id="troisieme" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'contentplus' ); ?>
           
           <aside class="widget_therapeutes widget_themes">
           		<h3>Liste des thérapeutes par thème</h3>
           		<ul>
                	<li><a href="#" >Réflexologies</a></li>
                    <li><a href="#" >Massages</a></li>
                    <li><a href="#" >Ostéopathie</a></li>
                    <li><a href="#" >Soins énergétiques</a></li>
                    <li><a href="#" >Ennéagramme</a></li>
                    <li><a href="#" >Éducation à la communication</a></li>
                    <li><a href="#" >Parcours du dos</a></li>
                </ul>
           </aside>
            
		</div><!-- #secondary -->
	<?php endif; ?>