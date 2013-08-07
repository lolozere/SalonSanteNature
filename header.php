<?php
global $ssn_last_year, $ssn_years;
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link href='http://fonts.googleapis.com/css?family=Ropa+Sans' rel='stylesheet' type='text/css'>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php 
wp_head(); 
?>
</head>
<body <?php body_class(); ?>>

	<header id="masthead" class="site-header <?php echo ssn_get_class_header_navigation();?>" role="banner">
		<div class="site-header-bg">
			<div class="site-header-content">
				<hgroup>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</hgroup>
				<div class="header-institutionnel">
					<nav id="headermenu-institutionnel" class="menu-salon" role="navigation">
						<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'ssn' ); ?>"><?php _e( 'Skip to content', 'ssn' ); ?></a>
						<?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-institutionnel', 'menu_class' => 'nav-menu' ) ); ?>
					</nav>
				</div>
                <div id="social_btn">
                <a href="https://www.facebook.com/SALON.SANTE.NATURE?fref=ts"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt="facebook" title="suivez-nous sur facebook" /></a>
                <a href="https://plus.google.com/104156860937284771144/posts?hl=fr"><img src="<?php echo get_template_directory_uri(); ?>/images/google.png" alt="google+" title="suivez-nous sur google+" /></a>
                <a href="https://twitter.com/SalonSanteNatur"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" alt="twitter" title="suivez-nous sur twitter" /></a>

                </div>
		        <nav id="site-navigation" class="main-navigation" role="navigation">
		            <ul id="site-navigation-menu">
						<li id="liSalon" class="menu-rubrique <?php echo (is_rubrique_bookstand()||is_rubrique_conferences()||is_rubrique_pass()||is_rubrique_exposants())?'off':'default';?>" data-rubrique="salon">
							<a class="menuprincipal" href="<?php echo ssn_get_first_menu_item('ssn-menu-salon-tour')->url;?>">
								<span><?php _e( 'Découvrez le salon', 'ssn' ); ?></span>
							</a>
							<ul id="vert" class="menuprincipal-links">
								<li><?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-salon-tour', 'menu_class' => 'nav-menu' ) ); ?></li>
							</ul>
						</li>
						<li id="liConference" class="menu-rubrique  <?php echo (!is_rubrique_conferences())?'off':'default';?>" data-rubrique="conference">
							<a class="menuprincipal" href="<?php echo ssn_get_first_menu_item('ssn-menu-conferences')->url;?>">
								<span>Conférences</span>
							</a>
							<ul id="bleu" class="menuprincipal-links">
								<li>
									<?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-conferences', 'menu_class' => 'nav-menu' ) ); ?>
								</li>
							</ul>
						</li>
						<li id="liPass" class="menu-rubrique <?php echo (!is_rubrique_pass())?'off':'default';?>" data-rubrique="pass">
							<a class="menuprincipal" href="<?php echo ssn_get_first_menu_item('ssn-menu-pass')->url;?>"><span>Pass Bien-être</span></a>
							<ul id="orange" class="menuprincipal-links">
								<li><?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-pass', 'menu_class' => 'nav-menu' ) ); ?></li>
							</ul>
						</li>
						<li id="liExposant" class="menu-rubrique <?php echo (!is_rubrique_exposants())?'off':'default';?>" data-rubrique="exposant">
							<a class="menuprincipal" href="<?php echo get_permalink(SSN_PAGE_EXPOSANTS_ID);?>"><span>Exposants</span></a>
							<ul id="jaune" class="menuprincipal-links">
								<li>
									<div class="menu-exposant-container">
										<ul class="nav-menu">
											<li class="menu-item menu-item-type-post_type menu-item-object-page">
												<a href="<?php echo get_permalink(SSN_PAGE_EXPOSANTS_ID);?>">Liste des exposants <?php echo $ssn_last_year;?></a>
											</li>
											<?php for($year=($ssn_last_year-1);$year>=($ssn_last_year-2);$year--) {?>
											<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_permalink(SSN_PAGE_EXPOSANTS_ID);?>?<?php echo $year;?>">Liste des exposants <?php echo $year;?></a></li>
											<?php }?>
										</ul>
									</div>
								</li>
							</ul>
						</li>
						<li id="liStand" class="menu-rubrique <?php echo (!is_rubrique_bookstand())?'off':'';?>" data-rubrique="stand">
							<a class="menuprincipal" href="<?php echo ssn_get_first_menu_item('ssn-menu-book-stand')->url;?>"><span>Stand</span></a>
							<ul id="rose" class="menuprincipal-links">
								<li><?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-book-stand', 'menu_class' => 'nav-menu' ) ); ?></li>
							</ul>
						</li>
					</ul>
				</nav><!-- #site-navigation -->
			</div>
		</div>
	</header><!-- #masthead -->
<div id="page" class="hfeed site">
	<div id="main" class="wrapper">
	<p id="mouse_position1"></p><p id="mouse_position2"></p>