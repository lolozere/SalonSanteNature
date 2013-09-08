<?php
global $ssn_years;
global $ssn_posts_list_slugs;

$ssn_posts_list_slugs = array('exposants', 'conferences', 'therapeutes-bien-etre');

/**
 * Return the most recent year of the post
 * 
 */
function ssn_get_last_year() {
	global $post;
	$metas = get_metadata('post', $post->ID);
	$years = array();
	foreach($metas as $meta_key => $meta_value) {
		$matches = array();
		if ($meta_value[0] == 1 && preg_match('/'.SSN_FICHE_META_PREFIX.'year_([0-9]{4})/', $meta_key, $matches)) {
			$years[] = $matches[1];
		} elseif (preg_match('/'.SSN_FICHE_META_PREFIX.'year$/', $meta_key, $matches)) {
			$years[] = $meta_value[0];
		}
	}
	if (count($years) > 0) {
		rsort($years);
		return current($years);
	} else {
		return null;
	}
}

/**
 * Return the request year
 *
 */
function ssn_get_request_year() {
	global $ssn_posts_list_slugs, $ssn_current_year, $ssn_last_year;
	foreach($ssn_posts_list_slugs as $slug) {
		$regex = '/'.$slug.'\/([0-9]{4})\/?/';
		//echo $regex; exit();
		if (preg_match($regex, $_SERVER['REQUEST_URI'], $years)) {
			return $years[1];
		}
	}
	if (preg_match('/([0-9]{4})\/?$/', $_SERVER['REQUEST_URI'], $years)) {
		return $years[1];
	}
	if (preg_match('/([0-9]{4})\/page\/[0-9]+\/?$/', $_SERVER['REQUEST_URI'], $years)) {
		return $years[1];
	}
	return $ssn_last_year;
}

/**
 * Return the current year
 *
 */
function ssn_get_current_year() {
	global $ssn_current_year, $ssn_last_year;
	if (is_single() && !is_null($year = ssn_get_last_year())) {
		return $year;
	}
	$year = ssn_get_request_year();
	if ($year != $ssn_current_year) {
		return $year;
	} elseif (!empty($ssn_current_year)) {
		return $ssn_current_year;
	} elseif ($ssn_last_year != $ssn_current_year) {
		return $ssn_current_year;
	} else {
		return $ssn_last_year;
	}
}

/*-----------------------------------------------------------------------------------*/
// EXPOSANTS
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'ssn_create_exposant' );
function ssn_create_exposant() {
	$labels = array(
			'name' => __('Exposants', 'ssn'),
			'singular_name' => __('Exposant', 'ssn'),
			'add_new' => __('Ajouter', 'ssn'), __('Recipe', 'ssn'),
			'add_new_item' => __('Exposant', 'ssn'),
			'edit_item' => __('Modifier', 'ssn'),
			'new_item' => __('Nouvel exposant', 'ssn'),
			'view_item' => __('Voir fiche', 'ssn'),
			'search_items' => __('Rechercher exposants', 'ssn'),
			'not_found' =>  __('Aucun exposant trouvé', 'ssn'),
			'not_found_in_trash' => __('Aucun exposant dans la corbeille', 'ssn'),
			'parent_item_colon' => ''
	);

	$supports = array(
			'title',
			'editor',
			//'thumbnail',
			'categories',
			'comments',
			'excerpt'
	);

	register_post_type( 'exposant',
			array(
					'labels' => $labels,
					'public' => true,
					'menu_position' => 6,
					'has_archive' => true,
					'hierarchical' => false,
					'supports' => $supports,
					'rewrite' => array( 'slug' => __('exposant', 'ssn') ),
					'menu_icon' => get_template_directory_uri() . '/images/icone_exposant.png'
			)
	);
}

/*add_filter('rewrite_rules_array', 'ssn_rewrite_rules');
function ssn_rewrite_rules($rules) {
	echo nl2br(print_r($rules, true));
	exit();
	return $rules;
}*/

// Custom Taxonomy Exposants Themes for Exposant
add_action( 'init', 'ssn_exposant_build_taxonomies', 0 );
function ssn_exposant_build_taxonomies() {
	$labels = array(
			'name' => __('Thèmes exposant', 'ssn'),
			'singular_name' => __('Thème exposant', 'ssn'),
			'search_items' => __('Rechercher un thème exposant', 'ssn'),
			'all_items' => __('Tous les thèmes exposants', 'ssn'),
			'parent_item' => __('Thème parent', 'ssn'),
			'parent_item_colon' =>__('Thème parent:', 'ssn'),
			'edit_item' => __('Modifier thème', 'ssn'),
			'update_item' => __('Mettre à jour le thème', 'ssn'),
			'add_new_item' => __('Ajouter un nouveau thème', 'ssn'),
			'new_item_name' => __('Nom du thème', 'ssn'),
			'menu_name' => __('Thèmes exposant', 'ssn')
	);
	register_taxonomy(
			'exposant_theme',
			'exposant',
			array(
					'hierarchical' => true,
					'labels' => $labels,
					'query_var' => true,
					'public' => true,
					'show_ui' => true,
					'rewrite' => array( 'slug' => __('exposants-par-themes', 'ssn') )
			)
	);
}
// Metabox for additional exposant informations
$meta_boxes[] = array(
		'id'		=> 'exposant_additional',
		'title'		=> __('Informations complémentaires', 'ssn'),
		'pages'		=> array( 'exposant' ),
		'fields'	=> array(
				array(
					'name'	=> __('Email', 'ssn'),
					'desc'	=> __('Adresse email de contact', 'ssn'),
					'clone'		=> false,
					'id'	=> SSN_FICHE_META_PREFIX."email",
					'type'	=> 'text'
				),
				array(
					'name'	=> __('Site internet', 'ssn'),
					'desc'	=> null,
					'clone'		=> false,
					'id'	=> SSN_FICHE_META_PREFIX."site_url",
					'type'	=> 'text'
				),
			)
	);
foreach($ssn_years as $year) {
	$meta_boxes[count($meta_boxes)-1]['fields'][] = array(
					'name'	=> __('Exposant ' . $year . ' ?', 'ssn'),
					'id'	=> SSN_FICHE_META_PREFIX."year_".$year,
					'type'	=> 'radio', 'options' => array('1' => 'Oui', '0' => 'Non')
				);
}

//Add Exposants in RSS Feed
function ssn_exposants_feed($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'exposant');
	return $qv;
}
add_filter('request', 'ssn_exposants_feed');

/*-----------------------------------------------------------------------------------*/
// THERAPEUTES
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'ssn_create_therapeute' );
function ssn_create_therapeute() {
	$labels = array(
			'name' => __('Thérapeutes', 'ssn'),
			'singular_name' => __('Thérapeute', 'ssn'),
			'add_new' => __('Ajouter', 'ssn'), __('Recipe', 'ssn'),
			'add_new_item' => __('Thérapeute', 'ssn'),
			'edit_item' => __('Modifier', 'ssn'),
			'new_item' => __('Nouveau thérapeute', 'ssn'),
			'view_item' => __('Voir fiche', 'ssn'),
			'search_items' => __('Rechercher thérapeuthes', 'ssn'),
			'not_found' =>  __('Aucun thérapeute trouvé', 'ssn'),
			'not_found_in_trash' => __('Aucun thérapeute dans la corbeille', 'ssn'),
			'parent_item_colon' => ''
	);

	$supports = array(
			'title',
			'editor',
			//'thumbnail',
			'categories',
			'comments',
			'excerpt'
	);

	register_post_type( 'therapeute',
			array(
					'labels' => $labels,
					'public' => true,
					'menu_position' => 7,
					'hierarchical' => false,
					'has_archive' => true,
					'supports' => $supports,
					'rewrite' => array( 'slug' => __('therapeute', 'ssn') ),
					'menu_icon' => get_template_directory_uri() . '/images/icone-therapeute.png'
			)
	);
}
// Custom Taxonomy Thérapeutes Themes for Thérapeute
add_action( 'init', 'ssn_therapeute_build_taxonomies', 0 );
function ssn_therapeute_build_taxonomies() {
	$labels = array(
			'name' => __('Thèmes thérapeute', 'ssn'),
			'singular_name' => __('Thème thérapeute', 'ssn'),
			'search_items' => __('Rechercher un thème thérapeute', 'ssn'),
			'all_items' => __('Tous les thèmes thérapeute', 'ssn'),
			'parent_item' => __('Thème parent', 'ssn'),
			'parent_item_colon' =>__('Thème parent:', 'ssn'),
			'edit_item' => __('Modifier thème', 'ssn'),
			'update_item' => __('Mettre à jour le thème', 'ssn'),
			'add_new_item' => __('Ajouter un nouveau thème', 'ssn'),
			'new_item_name' => __('Nom du thème', 'ssn'),
			'menu_name' => __('Thèmes thérapeute', 'ssn')
	);
	register_taxonomy(
			'tpeute_theme',
			'therapeute',
			array(
					'hierarchical' => true,
					'labels' => $labels,
					'query_var' => true,
					'public'=>true,
					'show_ui'=>true,
					'rewrite' => array( 'slug' => __('therapeutes-par-themes', 'ssn') )
			)
	);
}
// Metabox for additional exposant informations
$meta_boxes[] = array(
		'id'		=> 'therapeute_additional',
		'title'		=> __('Informations complémentaires', 'ssn'),
		'pages'		=> array( 'therapeute' ),
		'fields'	=> array(
				array(
						'name'	=> __('Email', 'ssn'),
						'desc'	=> __('Adresse email de contact', 'ssn'),
						'clone'		=> false,
						'id'	=> SSN_FICHE_META_PREFIX."email",
						'type'	=> 'text'
				),
				array(
						'name'	=> __('Site internet', 'ssn'),
						'desc'	=> null,
						'clone'		=> false,
						'id'	=> SSN_FICHE_META_PREFIX."site_url",
						'type'	=> 'text'
				),
				array(
						'name'	=> __("Identifiant d'animation", 'ssn'),
						'desc'	=> __('Pour afficher les disponiblités restantes du thérapeutes, saisir son identifiant dans la plateforme de réservation', 'ssn'),
						'clone'		=> false,
						'id'	=> SSN_FICHE_META_PREFIX."animation_id",
						'type'	=> 'text'
				),
		)
);
foreach($ssn_years as $year) {
	$meta_boxes[count($meta_boxes)-1]['fields'][] = array(
			'name'	=> __('Thérapeute ' . $year . ' ?', 'ssn'),
			'id'	=> SSN_FICHE_META_PREFIX."year_".$year,
			'type'	=> 'radio', 'options' => array('1' => 'Oui', '0' => 'Non')
	);
}

//Add Therapeutes in RSS Feed
function ssn_therapeutes_feed($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'therapeute');
	return $qv;
}
add_filter('request', 'ssn_therapeutes_feed');

/*-----------------------------------------------------------------------------------*/
// CONFERENCES
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'ssn_create_conference' );
function ssn_create_conference() {
	$labels = array(
			'name' => __('Conférences', 'ssn'),
			'singular_name' => __('Conférence', 'ssn'),
			'add_new' => __('Ajouter', 'ssn'), __('Recipe', 'ssn'),
			'add_new_item' => __('Conférence', 'ssn'),
			'edit_item' => __('Modifier', 'ssn'),
			'new_item' => __('Nouveau conférence', 'ssn'),
			'view_item' => __('Voir fiche', 'ssn'),
			'search_items' => __('Rechercher conférence', 'ssn'),
			'not_found' =>  __('Aucune conférence trouvée', 'ssn'),
			'not_found_in_trash' => __('Aucune conférence dans la corbeille', 'ssn'),
			'parent_item_colon' => ''
	);

	$supports = array(
			'title',
			'editor',
			//'thumbnail',
			'categories',
			'comments',
			'excerpt'
	);

	register_post_type( 'conference',
			array(
					'labels' => $labels,
					'public' => true,
					'menu_position' => 8,
					'hierarchical' => false,
					'has_archive' => true,
					'supports' => $supports,
					'rewrite' => array( 'slug' => __('conference', 'ssn') ),
					'menu_icon' => get_template_directory_uri() . '/images/icone-micro.png'
			)
	);
}
$meta_boxes[] = array(
		'id'		=> 'conference_additional',
		'title'		=> __('Détails sur la conférence', 'ssn'),
		'pages'		=> array( 'conference' ),
		'fields'	=> array(array(
			'name'	=> __('Année de la conférence', 'ssn'),
			'id'	=> SSN_FICHE_META_PREFIX."year",
			'type'	=> 'text'
	), array(
				'name'	=> __('Titre court', 'ssn'),
				'id'	=> SSN_FICHE_META_PREFIX."short_title",
				'type'	=> 'text'
		)),
);

//Add Exposants in RSS Feed
function ssn_conference_feed($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'conference');
	return $qv;
}
add_filter('request', 'ssn_conference_feed');

/*-----------------------------------------------------------------------------------*/
// REWRITING
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'ssn_posts_rewriting' );
function ssn_posts_rewriting() {
	global $wp_rewrite;
	// Exposants
	add_rewrite_rule('^exposants/?$','index.php?post_type=exposant','top');
	add_rewrite_rule('^exposants/page/([0-9]+)/?$','index.php?post_type=exposant&paged=$matches[1]','top');
	add_rewrite_rule('^exposants/([0-9]{4})/page/([0-9]+)/?$','index.php?post_type=exposant&season=$matches[1]&paged=$matches[2]','top');
	add_rewrite_rule('^exposants/([0-9]{4})/?$','index.php?post_type=exposant','top');
	add_rewrite_rule('^exposants-par-themes/([^/]*)/([0-9]{4})/?$','index.php?post_type=exposant&exposant_theme=$matches[1]&taxonomy=exposant_theme&term=$matches[1]','top');
	add_rewrite_rule('^exposants-par-themes/([^/]*)/([0-9]{4})/page/([0-9]+)/?$','index.php?post_type=exposant&exposant_theme=$matches[1]&taxonomy=exposant_theme&term=$matches[1]&paged=$matches[3]','top');
	
	// Thérapeutes
	add_rewrite_rule('^therapeutes-bien-etre/?$','index.php?post_type=therapeute','top');
	add_rewrite_rule('^therapeutes-bien-etre/page/([0-9]+)/?$','index.php?post_type=therapeute&paged=$matches[1]','top');
	add_rewrite_rule('^therapeutes-bien-etre/([0-9]{4})/page/([0-9]+)/?$','index.php?post_type=therapeute&season=$matches[1]&paged=$matches[2]','top');
	add_rewrite_rule('^therapeutes-bien-etre/([0-9]{4})/?$','index.php?post_type=therapeute','top');
	add_rewrite_rule('^therapeutes-par-themes/([^/]*)/([0-9]{4})/?$','index.php?post_type=therapeute&tpeute_theme=$matches[1]&taxonomy=tpeute_theme&term=$matches[1]','top');
	add_rewrite_rule('^therapeutes-par-themes/([^/]*)/([0-9]{4})/page/([0-9]+)/?$','index.php?post_type=therapeute&tpeute_theme=$matches[1]&taxonomy=tpeute_theme&term=$matches[1]&paged=$matches[3]','top');

	/*$wp_query->set('tpeute_theme', $wp_query->get('category_name'));
	 $wp_query->set('taxonomy', 'tpeute_theme');
	$wp_query->set('term', $wp_query->get('tpeute_theme'));
	$wp_query->set('category_name', '');
	$wp_query->is_tax = true; $wp_query->is_category = false;*/

	//add_rewrite_rule('exposants/?','index.php?post_type=exposant','top');
	//add_rewrite_rule('exposants/page/([0-9]+)/?','index.php?post_type=exposant&paged=$matches[1]','top');
	//add_rewrite_rule('^exposants/([0-9]{4})/?','index.php?&paged=1&ssnyear=$matches[1]','top');
	$wp_rewrite->flush_rules(false);
}

/*-----------------------------------------------------------------------------------*/
// ADMIN LIST
/*-----------------------------------------------------------------------------------*/
// Add columns
add_filter("manage_edit-exposant_columns", "exposant_theme_edit_columns");
add_filter("manage_edit-therapeute_columns", "tpeute_theme_edit_columns");
add_filter("manage_edit-conference_columns", "conference_theme_edit_columns");
add_action('admin_head', 'ssn_admin_column_with');

function ssn_admin_column_with() {
	echo '<style type="text/css">';
	echo '.column-year { text-align: left; width:60px !important; overflow:hidden }';
	echo '</style>';
}
function exposant_theme_edit_columns($columns){
	$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => __( 'Exposant', 'ssn' ),
			"year" => __( 'Années', 'ssn' ),
			"theme" => __( 'Thème', 'ssn' ),
			"date" => __( 'Date de publication', 'ssn' ),
	);
	return $columns;
}
function tpeute_theme_edit_columns($columns){
	$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => __( 'Thérapeute', 'ssn' ),
			"year" => __( 'Années', 'ssn' ),
			"theme" => __( 'Thème', 'ssn' ),
			"animation_id" => __( 'ID Animations', 'ssn' ),
			"date" => __( 'Date de publication', 'ssn' ),
	);
	return $columns;
}
function conference_theme_edit_columns($columns){
	$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"year" => __( 'Année', 'ssn' ),
			"title" => __( 'Conférence', 'ssn' ),
			"date" => __( 'Date de publication', 'ssn' ),
	);
	return $columns;
}

function ssn_custom_columns_post_type($column){
	global $post;
	switch ($column) {
		case 'year':
			$metas = get_metadata('post', $post->ID);
			$years = array();
			foreach($metas as $meta_key => $meta_value) {
				$matches = array();
				if ($meta_value[0] == 1 && preg_match('/'.SSN_FICHE_META_PREFIX.'year_([0-9]{4})/', $meta_key, $matches)) {
					$years[] = $matches[1];
				} elseif (preg_match('/'.SSN_FICHE_META_PREFIX.'year$/', $meta_key, $matches)) {
					$years[] = $meta_value[0];
				}
			}
			echo join(', ', array_unique($years));
			break;
		case 'animation_id':
			$metas = get_metadata('post', $post->ID);
			foreach($metas as $meta_key => $meta_value) {
				if ($meta_key == SSN_FICHE_META_PREFIX.'animation_id') {
					echo $meta_value[0];
				}
			}
			break;
				
	}
	if ($column == 'theme' && $post->post_type == 'exposant') {
		echo get_the_term_list( $post->ID, 'exposant_theme', '', ', ', '');
	} elseif ($column == 'theme' && $post->post_type == 'therapeute') {
		echo get_the_term_list( $post->ID, 'tpeute_theme', '', ', ', '');
	}
}
add_action("manage_posts_custom_column",  "ssn_custom_columns_post_type");

// Filter lists
add_action('restrict_manage_posts','ssn_restrict_listings');
function ssn_restrict_listings() {
	global $typenow;
	global $wp_query;
	
	$taxonomies = array('exposant' => array('exposant_theme'), 'therapeute' => array('tpeute_theme'));
	foreach($taxonomies as $post_type => $taxonomy_list) {
		if ($post_type == $typenow) {
			foreach($taxonomy_list as $taxonomy) {
				$theme_taxonomy = get_taxonomy($taxonomy);
				$selected_id = '';
				if (isset($wp_query->query[$taxonomy])) {
					$term = get_term_by('id', $wp_query->query[$taxonomy], $taxonomy);
					$selected_id = $wp_query->query[$taxonomy];
				}
				wp_dropdown_categories(array(
						'show_option_all' =>  __("Montrer tous les {$theme_taxonomy->label}"),
						'taxonomy'        =>  $taxonomy,
						'name'            =>  $taxonomy,
						'orderby'         =>  'name',
						'selected'        =>  $selected_id,
						'hierarchical'    =>  true,
						'depth'           =>  3,
						'show_count'      =>  true, // Show # listings in parens
						'hide_empty'      =>  false, // Don't show businesses w/o listings
					));
			}
		}
	}
}
add_filter('parse_query','ssn_convert_theme_id_to_taxonomy_term_in_query');
function ssn_convert_theme_id_to_taxonomy_term_in_query($query) {
	global $pagenow;
	$qv = &$query->query_vars;
	if (isset($qv['exposant_theme']) && $pagenow=='edit.php') {
		$term = get_term_by('id', $qv['exposant_theme'], 'exposant_theme');
		$qv['exposant_theme'] = $term->slug;
	} elseif (isset($qv['tpeute_theme']) && $pagenow=='edit.php') {
		$term = get_term_by('id', $qv['tpeute_theme'], 'therapeute_theme');
		$qv['tpeute_theme'] = $term->slug;
	}
}

/*-----------------------------------------------------------------------------------*/
// UNREGISTER ARTICLES
/*-----------------------------------------------------------------------------------*/
function ssn_toggle_custom_menu_order(){
	return true;
}
add_filter( 'custom_menu_order', 'ssn_toggle_custom_menu_order' );

function ssn_remove_those_menu_items( $menu_order ){
	global $menu;
	foreach ( $menu as $mkey => $m ) {
		$key = array_search( 'edit.php', $m );
		if ( $key )
			unset( $menu[$mkey] );
	}
	return $menu_order;
}
add_filter( 'menu_order', 'ssn_remove_those_menu_items' );
	
