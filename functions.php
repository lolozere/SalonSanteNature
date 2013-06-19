<?php
/**
 * SSN functions and definitions.
 */

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;

/**
 * Set up years
 */
global $ssn_years, $ssn_last_year;
$year_max = date('Y', time());
$year_min = $year_max-1;
$ssn_last_year = $year_max;
$ssn_years = array(strval($year_min) => strval($year_min));
for($i=2012; $i<=$year_max; $i++) {
	$ssn_years[strval($i)] = strval($i);
}
if (!is_admin()) {
	global $ssn_current_year;
	foreach(array_keys($_GET) as $year) {
		if (preg_match('/[0-9]{4}/', $year)) {
			$ssn_current_year = $year;
		}
	}
}

define('SSN_PAGE_EXPOSANTS_ID', 3774);
define('SSN_PAGE_THERAPEUTES_ID', 3830);
define('SSN_PAGE_CONFERENCES_ID', 3843);

require_once(get_template_directory().'/includes/templating.php');

function ssn_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'ssn', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'page', 'article', 'exposant', 'therapeute', 'conference' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'ssn-menu-institutionnel', __( 'Menu institutionnel', 'ssn' ) );
	register_nav_menu( 'ssn-menu-salon', __( 'Menu Salon', 'ssn' ) );
	register_nav_menu( 'ssn-menu-salon-tour', __( 'Menu Découvrez le salon', 'ssn' ) );
	register_nav_menu( 'ssn-menu-conferences', __( 'Menu Conférences', 'ssn' ) );
	register_nav_menu( 'ssn-menu-pass', __( 'Menu Pass Bien-être', 'ssn' ) );
	register_nav_menu( 'ssn-menu-book-stand', __( 'Menu Réservez votre stand', 'ssn' ) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'ssn_setup' );

/**
 * Enqueues scripts and styles for front-end.
 *
 */
function ssn_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Loads our special font CSS file.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'twentytwelve-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'ssn' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'ssn' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		wp_enqueue_style( 'ssn-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'ssn-style', get_stylesheet_uri() );

	/*
	 * Loads the Internet Explorer specific stylesheet.
	 */
	wp_enqueue_style( 'ssn-ie', get_template_directory_uri() . '/css/ie.css', array( 'ssn-style' ), '20121010' );
	$wp_styles->add_data( 'ssn-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'ssn_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function ssn_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'ssn' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'ssn_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 */
function ssn_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'ssn_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 */
function ssn_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'ssn' ),
		'id' => 'sidebar-1',
		'description' => __( 'Colonne de gauche du site utilisée par défaut', 'ssn' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	/*
	 * Les colonnes principales
	 */
	register_sidebar( array(
			'name' => __( 'PRINCIPALE - Accueil', 'ssn' ),
			'id' => 'sidebar-mainhome',
			'description' => __( "Colonne de gauche du site sur la page d'accueil", 'ssn' ),
			'before_widget' => '<aside id="%1$s" class="widgets-home widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );
	register_sidebar( array(
			'name' => __( 'PRINCIPALE - Rubrique conférences', 'ssn' ),
			'id' => 'sidebar-mainconference',
			'description' => __( "Colonne de gauche du site sur la rubrique des conférences", 'ssn' ),
			'before_widget' => '<aside id="%1$s" class="widgets-conference widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );
	register_sidebar( array(
			'name' => __( 'PRINCIPALE - Rubrique pass bien-être', 'ssn' ),
			'id' => 'sidebar-mainpass',
			'description' => __( "Colonne de gauche du site sur les pages de la rubrique pass", 'ssn' ),
			'before_widget' => '<aside id="%1$s" class="widgets-pass widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );
	register_sidebar( array(
			'name' => __( 'PRINCIPALE - Rubrique exposants', 'ssn' ),
			'id' => 'sidebar-mainexposants',
			'description' => __( "Colonne de gauche du site sur les pages de la rubrique exposants", 'ssn' ),
			'before_widget' => '<aside id="%1$s" class="widgets-pass widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );
	
	/*
	 * Les colonnes complémentaires
	 */
	register_sidebar( array(
			'name' => __( 'SPLUS - Accueil', 'ssn' ),
			'id' => 'sidebar-home',
			'description' => __( "Colonne de droite sur la page d'accueil", 'ssn' ),
			'before_widget' => '<aside id="%1$s" class="widgets-home widget-plus %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );
	register_sidebar( array(
			'name' => __( 'SPLUS - Rubrique exposants', 'ssn' ),
			'id' => 'sidebar-exposants',
			'description' => __( "Colonne de droite par défaut sur les pages de la rubrique exposant", 'ssn' ),
			'before_widget' => '<aside id="%1$s" class="widgets-exposant widget-plus %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );
	register_sidebar( array(
			'name' => __( 'SPLUS - Rubrique conférences', 'ssn' ),
			'id' => 'sidebar-conference',
			'description' => __( "Colonne de droite par défaut sur les pages de la rubrique conférences", 'ssn' ),
			'before_widget' => '<aside id="%1$s" class="widgets-conference widget-plus %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );
	register_sidebar( array(
			'name' => __( 'SPLUS - Rubrique pass bien-être', 'ssn' ),
			'id' => 'sidebar-pass',
			'description' => __( "Colonne de droite par défaut sur les pages de la rubrique du pass bien-être", 'ssn' ),
			'before_widget' => '<aside id="%1$s" class="widgets-pass widget-plus %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );
	register_sidebar( array(
			'name' => __( 'SPLUS - Rubrique réserver stand', 'ssn' ),
			'id' => 'sidebar-bookstand',
			'description' => __( "Colonne de droite par défaut sur les pages de la rubrique pour réserver son stand", 'ssn' ),
			'before_widget' => '<aside id="%1$s" class="widgets-bookstand widget-plus %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'SPLUS - Colonne droite par défaut', 'ssn' ),
		'id' => 'contentplus',
		'description' => __( "Colonne par défaut s'affichant sur des pages qui n'appartiennent à aucune rubrique en particulier", 'ssn' ),
		'before_widget' => '<aside id="%1$s" class="widgets-default widget-plus %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'ssn_widgets_init' );

function ssn_init_type_request() {
	is_rubrique_exposants();
	is_rubrique_conferences();
	is_rubrique_pass();
	is_rubrique_bookstand();
}
add_action('wp_head', 'ssn_init_type_request');

/**
 * Return true if current page is on exposant rubrique
 */
$ssn_is_rubrique_exposant = null;
function is_rubrique_exposants() {
	global $ssn_is_rubrique_exposant, $post;
	if (empty($ssn_is_rubrique_exposant) && ((is_page() && get_queried_object_id() == SSN_PAGE_EXPOSANTS_ID) || (is_single() && $post->post_type == 'exposant'))) {
		$ssn_is_rubrique_exposant = true;
	} elseif (empty($ssn_is_rubrique_exposant)) {
		global $wp_query;
		$ssn_is_rubrique_exposant = (!empty($wp_query->query_vars['exposant_theme']));
	}
	return $ssn_is_rubrique_exposant;
}
$ssn_is_rubrique_conferences = null;
function is_rubrique_conferences() {
	global $ssn_is_rubrique_conferences, $post;
	if (empty($ssn_is_rubrique_conferences) && is_single() && $post->post_type == 'conference') {
		$ssn_is_rubrique_conferences = true;
	} elseif (empty($ssn_is_rubrique_conferences)) {
		$ssn_is_rubrique_conferences = false;
		$menu = wp_get_nav_menu_object( 'ssn-menu-conferences' );
		if ( ! $menu && ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ssn-menu-conferences' ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ 'ssn-menu-conferences' ] );
		}
		if ( $menu && ! is_wp_error($menu) && !isset($menu_items) ) {
			$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
			foreach($menu_items as $menu_item) {
				if (!(strpos($_SERVER['REQUEST_URI'], $menu_item->url) === false) || !(strpos($menu_item->url, $_SERVER['REQUEST_URI']) === false)) {
					$ssn_is_rubrique_conferences = true;
				}
			}
		}
	}
	return $ssn_is_rubrique_conferences;
}
$ssn_is_rubrique_bookstand = null;
function is_rubrique_bookstand() {
	global $ssn_is_rubrique_bookstand, $post;
	if (empty($ssn_is_rubrique_bookstand)) {
		$ssn_is_rubrique_bookstand = false;
		$menu = wp_get_nav_menu_object( 'ssn-menu-book-stand' );
		if ( ! $menu && ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ssn-menu-book-stand' ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ 'ssn-menu-book-stand' ] );
		}
		if ( $menu && ! is_wp_error($menu) && !isset($menu_items) ) {
			$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
			foreach($menu_items as $menu_item) {
				if (!(strpos($_SERVER['REQUEST_URI'], $menu_item->url) === false) || !(strpos($menu_item->url, $_SERVER['REQUEST_URI']) === false)) {
					$ssn_is_rubrique_bookstand = true;
				}
			}
		}
	}
	return $ssn_is_rubrique_bookstand;
}
/**
 * Return true if current page is on pass rubrique
 */
$ssn_is_rubrique_pass = null;
function is_rubrique_pass() {
	global $ssn_is_rubrique_pass, $post;
	if (empty($ssn_is_rubrique_pass) && ((is_page() && in_array(get_queried_object_id(), array(SSN_PAGE_THERAPEUTES_ID))) || (is_single() && $post->post_type == 'therapeute'))) {
		$ssn_is_rubrique_pass = true;
	} elseif (empty($ssn_is_rubrique_pass)) {
		global $wp_query;
		$ssn_is_rubrique_pass = (!empty($wp_query->query_vars['tpeute_theme']));
		if (!$ssn_is_rubrique_pass) {
			$menu = wp_get_nav_menu_object( 'ssn-menu-pass' );
			if ( ! $menu && ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ssn-menu-pass' ] ) ) {
				$menu = wp_get_nav_menu_object( $locations[ 'ssn-menu-pass' ] );
			}
			if ( $menu && ! is_wp_error($menu) && !isset($menu_items) ) {
				$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
				foreach($menu_items as $menu_item) {
					if (!(strpos($_SERVER['REQUEST_URI'], $menu_item->url) === false) || !(strpos($menu_item->url, $_SERVER['REQUEST_URI']) === false)) {
						$ssn_is_rubrique_conferences = true;
					}
				}
			}
			$ssn_is_rubrique_pass = false;
		}
	}
	return $ssn_is_rubrique_pass;
}


if ( ! function_exists( 'ssn_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 */
function ssn_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );
	
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'ssn' ); ?></h3>
			<div class="nav-previous alignleft"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Page précédente', 'ssn' ) ); ?></div>
			<div class="nav-next alignright"><?php next_posts_link( __( 'Page suivante <span class="meta-nav">&rarr;</span>', 'ssn' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'ssn_comment' ) ) :
function ssn_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'ssn' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'ssn' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'ssn' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'ssn' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'ssn' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'ssn' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'ssn' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

function ssn_more_link() {
	if (!is_single()) {
		$post = get_post();
		echo "<a href=\"" . get_permalink() . "\" class=\"more-link\">En savoir plus</a>";
	}
}

if ( ! function_exists( 'ssn_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 */
function ssn_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'ssn' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'ssn' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'ssn' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'ssn' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'ssn' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'ssn' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function ssn_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'ssn_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 */
function ssn_customize_preview_js() {
	wp_enqueue_script( 'ssn-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'ssn_customize_preview_js' );

/*-----------------------------------------------------------------------------------*/
//	Metabox
/*-----------------------------------------------------------------------------------*/

// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri().'/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_stylesheet_directory().'/meta-box' ) );

// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';
include get_stylesheet_directory().'/includes/config-meta-boxes.php';

/*-----------------------------------------------------------------------------------*/
//	Type d'articles
/*-----------------------------------------------------------------------------------*/
require_once(get_template_directory().'/includes/post-types.php');

/*-----------------------------------------------------------------------------------*/
//	Widgets
/*-----------------------------------------------------------------------------------*/
require_once(get_template_directory().'/includes/widgets/ssn-widget.php');
require_once(get_template_directory().'/includes/widgets/image-widget.php');
require_once(get_template_directory().'/includes/widgets/invitation-gratuite-widget.php');
require_once(get_template_directory().'/includes/widgets/book-pass-widget.php');
require_once(get_template_directory().'/includes/widgets/newsletter-widget.php');
require_once(get_template_directory().'/includes/widgets/exposants-access-widget.php');
require_once(get_template_directory().'/includes/widgets/therapeutes-access-widget.php');
require_once(get_template_directory().'/includes/widgets/themes-exposants-widget.php');
require_once(get_template_directory().'/includes/widgets/themes-therapeutes-widget.php');
require_once(get_template_directory().'/includes/widgets/posts-list-widget.php');
require_once(get_template_directory().'/includes/widgets/exposants-list-widget.php');
require_once(get_template_directory().'/includes/widgets/therapeutes-list-widget.php');
require_once(get_template_directory().'/includes/widgets/conferences-list-widget.php');

/*-----------------------------------------------------------------------------------*/
//	Order of list articles and filter by year
/*-----------------------------------------------------------------------------------*/
add_filter('posts_orderby', 'ssn_fiche_alphabetical' );
function ssn_fiche_alphabetical( $orderby ) {
	if (is_archive())
		return "post_title ASC";
	return $orderby;
}
add_action('pre_get_posts', 'ssn_fiche_filter_by_year' );
function ssn_fiche_filter_by_year( $wp_query ) {
	global $ssn_current_year, $ssn_last_year;
	/*
	 * Pour une raison inconnue, Wordpress ne détectete par les URLS commençant par therapeutes-par-themes
	* On fait le rewirting nous-même
	*/
	if (preg_match('/'.__('therapeutes\-par\-themes').'/', $_SERVER['REQUEST_URI']) && !empty($wp_query->query_vars['category_name'])) {
		$wp_query->set('tpeute_theme', $wp_query->get('category_name'));
		$wp_query->set('taxonomy', 'tpeute_theme');
		$wp_query->set('term', $wp_query->get('tpeute_theme'));
		$wp_query->set('category_name', '');
		$wp_query->is_tax = true; $wp_query->is_category = false;
	}
	if (preg_match('/'.__('therapeute').'\//', $_SERVER['REQUEST_URI']) && !empty($wp_query->query_vars['category_name'])) {
		$wp_query->set('therapeute', $wp_query->get('category_name'));
		$wp_query->set('post_type', 'therapeute');
		$wp_query->set('name', $wp_query->get('category_name'));
		$wp_query->set('category_name', '');
		$wp_query->is_single = true; $wp_query->is_archive = false; $wp_query->is_category = false;
	}
	if (preg_match('/'.__('conference\/.+').'\//', $_SERVER['REQUEST_URI']) && !empty($wp_query->query_vars['category_name'])) {
		$wp_query->set('conference', $wp_query->get('category_name'));
		$wp_query->set('post_type', 'conference');
		$wp_query->set('name', $wp_query->get('category_name'));
		$wp_query->set('category_name', '');
		$wp_query->is_single = true; $wp_query->is_archive = false; $wp_query->is_category = false;
	}
	/*
	 * Cas normal...
	 */
	if (is_archive() && !is_admin()) {
		$year = (!empty($ssn_current_year))?$ssn_current_year:$ssn_last_year;
		global $wp_query;
		$wp_query->set('meta_key', SSN_FICHE_META_PREFIX.'year_'.$year);
		$wp_query->set('meta_value', '1');
	}
}

/**
 * Display or retrieve the HTML list of a theme by taxonomy
 *
 * @param string $taxonomy
 */
function ssn_list_themes($taxonomy) {
	global $ssn_current_year, $ssn_last_year;
	$r = array(
			'show_option_all' => true, 'show_option_none' => false,
			'orderby' => 'name', 'order' => 'ASC',
			'style' => 'list',
			'show_count' => 1, 'hide_empty' => 0,
			'use_desc_for_title' => 1, 'child_of' => 0,
			'feed' => '', 'feed_type' => '',
			'feed_image' => '', 'exclude' => '',
			'exclude_tree' => '', 'current_category' => 0,
			'hierarchical' => true, 'title_li' => __( 'Thèmes' ),
			'echo' => 1, 'depth' => 0,
			'taxonomy' => $taxonomy
	);
	
	// Year
	$ssn_year = $ssn_last_year;
	if (is_single()) {
		$ssn_year = (is_null($year_found = ssn_get_last_year()))?$ssn_year:$year_found;
	} elseif (!empty($ssn_current_year))
		$ssn_year = $ssn_current_year;
	$request_uri_get_year = null;
	if ($ssn_year != $ssn_last_year)
		$request_uri_get_year = '?'.$ssn_year;
	
	if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] )
		$r['pad_counts'] = true;

	if ( true == $r['hierarchical'] ) {
		$r['exclude_tree'] = $r['exclude'];
		$r['exclude'] = '';
	}
	
	if ( !isset( $r['class'] ) )
		$r['class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];

	extract( $r );
	
	if ( !taxonomy_exists($taxonomy) )
		return false;

	$categories = get_categories( $r );
	$output = '<ul class="' . esc_attr( $class ) . '">';
	foreach ($categories as $category) {
		$cat_name = esc_attr( $category->name );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		if ( $use_desc_for_title == 0 || empty($category->description) )
			$title = esc_attr( sprintf(__( 'Voir tous de %s' ), $cat_name) );
		else
			$title = esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) );
		$output .= '<li><a href="' . esc_url( get_term_link($category) ) . $request_uri_get_year . '" title="'.$title.'">'.$cat_name.'</a></li>';
	}
	$output .= '</ul>';

	if ( $echo )
		echo $output;
	else
		return $output;
}

/**
 * Display or retrieve the HTML list of a theme by taxonomy
 *
 * @param string $taxonomy
 */
function ssn_list_posts($post_type) {
	global $ssn_current_year, $ssn_last_year;
	
	$ssn_year = $ssn_last_year;
	if (is_single()) {
		$ssn_year = (is_null($year_found = ssn_get_last_year()))?$ssn_year:$year_found;
	} elseif (!empty($ssn_current_year))
		$ssn_year = $ssn_current_year;
	
	$metas_args = array('meta_key' => SSN_FICHE_META_PREFIX.'year_'.$ssn_year, 'meta_value' => '1');
	if ($post_type == 'conference') {
		$metas_args = array('meta_key' => SSN_FICHE_META_PREFIX.'year', 'meta_value' => $ssn_year);
	}
	$posts = get_posts(array_merge(array(
			'post_type' => $post_type, 
			'orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => -1,
		), $metas_args));
	
	if (count($posts) <= 0) {
		switch($post_type) {
			case 'exposant':
				$output = '<p>'.__('Aucune fiche exposant en '.$ssn_year).'</p>';
				break;
			case 'therapeute':
				$output = '<p>'.__('Aucune fiche thérapeute en '.$ssn_year).'</p>';
				break;
			case 'conference':
				$output = '<p>'.__('Aucune fiche conférence en '.$ssn_year).'</p>';
				break;
		}
	} else {
		$output = '<ul class="widget-' . esc_attr( $post_type ) . '-list">';
		foreach ($posts as $post) {
			$title = esc_attr( $post->post_title );
			$output .= '<li><a href="' . esc_url( get_permalink($post->ID) ) . '" title="'.$title.'">'.$post->post_title.'</a></li>';
		}
		$output .= '</ul>';
	}

	echo $output;
}

/*
 * 
 * 

-- MIGRATION CONFERENCES

UPDATE wp_posts SET post_type='conference' WHERE post_type='post' AND EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Conférences%' AND object_id=wp_posts.ID 
);
INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT ID, 'SSN_META_year', '2012' 
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Conférences 2012%' AND object_id=wp_posts.ID 
);
INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT ID, 'SSN_META_year', '2011' 
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Conférences 2011%' AND object_id=wp_posts.ID 
);

-- MIGRATION EXPOSANTS

UPDATE wp_posts SET post_type='exposant' WHERE post_type='post' AND EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Exposants%' AND object_id=wp_posts.ID 
);
UPDATE wp_posts SET post_type='exposant' WHERE post_type='post' AND EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Thérapies et bien-être%' AND object_id=wp_posts.ID 
);
UPDATE wp_posts SET post_type='exposant' WHERE post_type='post' AND EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Monde solidaire%' AND object_id=wp_posts.ID 
);

INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT ID, 'SSN_META_year_2011', '1' 
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Exposants 2011%' AND object_id=wp_posts.ID 
);
INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
SELECT ID, 'SSN_META_year_2012', '1' 
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Exposants 2012%' AND object_id=wp_posts.ID 
);

UPDATE wp_postmeta SET meta_key='SSN_META_site_url' WHERE meta_key LIKE 'site';
UPDATE wp_postmeta SET meta_value=CONCAT('http://', meta_value) WHERE meta_key LIKE 'SSN_META_site_url';

# Migration catégorie
INSERT INTO wp_term_relationships (object_id, term_taxonomy_id)
SELECT ID, (SELECT wp_term_taxonomy.term_taxonomy_id
	FROM `wp_terms`
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
	WHERE taxonomy = 'exposant_theme' AND name LIKE 'Alimentation, cosmétique bio' LIMIT 1
)
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Alimentation, cosmétique bio%' AND object_id=wp_posts.ID 
);
INSERT INTO wp_term_relationships (object_id, term_taxonomy_id)
SELECT ID, (SELECT wp_term_taxonomy.term_taxonomy_id
	FROM `wp_terms`
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
	WHERE taxonomy = 'exposant_theme' AND name LIKE 'Culture et jeu' LIMIT 1
)
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Culture et jeu%' AND object_id=wp_posts.ID 
);
INSERT INTO wp_term_relationships (object_id, term_taxonomy_id)
SELECT ID, (SELECT wp_term_taxonomy.term_taxonomy_id
	FROM `wp_terms`
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
	WHERE taxonomy = 'exposant_theme' AND name LIKE 'Maison, Jardin, Terre' LIMIT 1
)
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Maison, Jardin, Terre%' AND object_id=wp_posts.ID 
);
INSERT INTO wp_term_relationships (object_id, term_taxonomy_id)
SELECT ID, (SELECT wp_term_taxonomy.term_taxonomy_id
	FROM `wp_terms`
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
	WHERE taxonomy = 'exposant_theme' AND name LIKE 'Monde solidaire' LIMIT 1
)
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Monde solidaire%' AND object_id=wp_posts.ID 
);
INSERT INTO wp_term_relationships (object_id, term_taxonomy_id)
SELECT ID, (SELECT wp_term_taxonomy.term_taxonomy_id
	FROM `wp_terms`
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
	WHERE taxonomy = 'exposant_theme' AND name LIKE 'Thérapies et bien-être' LIMIT 1
)
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Thérapies et bien-être%' AND object_id=wp_posts.ID 
);
INSERT INTO wp_term_relationships (object_id, term_taxonomy_id)
SELECT ID, (SELECT wp_term_taxonomy.term_taxonomy_id
	FROM `wp_terms`
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id = wp_terms.term_id
	WHERE taxonomy = 'exposant_theme' AND name LIKE 'Vêtements, Bijoux, Accessoires' LIMIT 1
)
FROM wp_posts
WHERE EXISTS(
	SELECT * FROM wp_terms 
	INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_id=wp_terms.term_id
	INNER JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
	WHERE wp_terms.name LIKE 'Vêtements, Bijoux, Accessoires%' AND object_id=wp_posts.ID 
);
UPDATE wp_term_taxonomy SET count=(
	SELECT COUNT(*) FROM wp_posts INNER JOIN wp_term_relationships ON object_id=ID
	WHERE wp_term_relationships.term_taxonomy_id=wp_term_taxonomy.term_taxonomy_id
) WHERE taxonomy='exposant_theme';
 
 */

