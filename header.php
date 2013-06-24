<?php
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
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link href='http://fonts.googleapis.com/css?family=Ropa+Sans' rel='stylesheet' type='text/css'>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<script type="text/javascript">
startList = function() {
if (document.all&&document.getElementById) {
navRoot = document.getElementById("nav");
for (i=0; i<navRoot.childNodes.length; i++) {
node = navRoot.childNodes[i];
if (node.nodeName=="LI") {
node.onmouseover=function() {
this.className+=" over";
  }
  node.onmouseout=function() {
  this.className=this.className.replace
        (" over", "");
   }
   }
  }
 }
}
window.onload=startList;
</script>



<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>

<body <?php body_class(); ?>>

	<header id="masthead" class="site-header header-salon header-conference header-pass header-exposant header-stand " role="banner">
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
	        
	        
	        <nav id="site-navigation" class="main-navigation" role="navigation">
				<?php /*?><h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?><?php */?>
	            
	            <ul id="nav">
					<li id="liSalon" class="on">
						<a class="menuprincipal" href="#">
							<span><?php _e( 'Découvrez le salon', 'ssn' ); ?></span>
						</a>
						<ul id="vert">
							<li><?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-salon-tour', 'menu_class' => 'nav-menu' ) ); ?></li>
						</ul>
					</li>
					<li id="liConference" class="off"><a class="menuprincipal" href="#"><span>Conférences</span></a>
						<ul id="bleu">
							<li>
								<?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-conferences', 'menu_class' => 'nav-menu' ) ); ?>
							</li>
						</ul>
					</li>
					<li id="liPass" class="off">
						<a class="menuprincipal" href="#"><span>Pass Bien-être</span></a>
						<ul id="orange">
							<li><?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-pass', 'menu_class' => 'nav-menu' ) ); ?></li>
						</ul>
					</li>
					<li id="liExposant" class="off">
						<a class="menuprincipal" href="#"><span>Exposants</span></a>
						<ul id="jaune" class="nav-menu">
							<li class="menu-item">
								<a href="<?php echo get_permalink(SSN_PAGE_EXPOSANTS_ID);?>">Liste des exposants <?php echo $ssn_last_year;?></a>
							</li>
							<?php for($year=($ssn_last_year-1);$year>=($ssn_last_year-2);$year--) {?>
							<li class="menu-item"><a href="<?php echo get_permalink(SSN_PAGE_EXPOSANTS_ID);?>?<?php echo $year;?>">Liste des exposants <?php echo $year;?></a></li>
							<?php }?>
						</ul>
					</li>
					<li id="liStand" class="off">
						<a class="menuprincipal" href="#"><span>Stand</span></a>
						<ul id="rose">
							<li><?php wp_nav_menu( array( 'theme_location' => 'ssn-menu-book-stand', 'menu_class' => 'nav-menu' ) ); ?></li>
						</ul>
					</li>
				</ul>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->
<div id="page" class="hfeed site">
	<div id="main" class="wrapper">