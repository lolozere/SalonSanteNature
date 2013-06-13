<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	<?php get_sidebar( 'contentplus' ); 
	global $ssn_last_year, $ssn_years;
	?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="footer-salon">
			<nav id="footermenu-salon-tour" class="menu-salon" role="navigation">
				<h3><?php _e( 'Découvrez le salon', 'ssn' ); ?></h3>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'ssn' ); ?>"><?php _e( 'Skip to content', 'ssn' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-salon-tour', 'menu_class' => 'nav-menu' ) ); ?>
			</nav>
			<nav id="footermenu-conferences" class="menu-salon" role="navigation">
				<h3><?php _e( 'Les conférences', 'ssn' ); ?></h3>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'ssn' ); ?>"><?php _e( 'Skip to content', 'ssn' ); ?></a>
				<p>En cours de dev par Laurent</p>
			</nav>
			<nav id="footermenu-pass" class="menu-salon" role="navigation">
				<h3><?php _e( 'Le Pass Bien-être', 'ssn' ); ?></h3>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'ssn' ); ?>"><?php _e( 'Skip to content', 'ssn' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-pass', 'menu_class' => 'nav-menu' ) ); ?>
			</nav>
			<nav id="footermenu-exposants" class="menu-salon" role="navigation">
				<h3><?php _e( 'Liste des exposants', 'ssn' ); ?></h3>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'ssn' ); ?>"><?php _e( 'Skip to content', 'ssn' ); ?></a>
				<div>
					<ul class="nav-menu">
						<li class="menu-item"><a href="<?php echo get_permalink(3774);?>">Liste des exposants <?php echo $ssn_last_year;?></a></li>
						<?php for($year=($ssn_last_year-1);$year>=($ssn_last_year-2);$year--) {?>
						<li class="menu-item"><a href="<?php echo get_permalink(3774);?>?<?php echo $year;?>">Liste des exposants <?php echo $year;?></a></li>
						<?php }?>
					</ul>
				</div>
			</nav>
			<nav id="footermenu-exposants" class="menu-salon" role="navigation">
				<h3><?php _e( 'Réservez votre stand', 'ssn' ); ?></h3>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'ssn' ); ?>"><?php _e( 'Skip to content', 'ssn' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-book-stand', 'menu_class' => 'nav-menu' ) ); ?>
			</nav>
		</div>
		<div class="footer-institutionnel">
			<nav id="footermenu-institutionnel" class="menu-salon" role="navigation">
				<h3><?php _e( 'Menu institutionnel', 'ssn' ); ?></h3>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'ssn' ); ?>"><?php _e( 'Skip to content', 'ssn' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-institutionnel', 'menu_class' => 'nav-menu' ) ); ?>
			</nav>
		</div>
		<div class="footer-credits">
			© Un site Salon Santé Nature, réalisé par <a href="http://www.soletic.org">Sol&TIC</a> et propulsé par WordPress
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>