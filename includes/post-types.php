<?php
global $ssn_years;

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
					'menu_position' => 2,
					'hierarchical' => false,
					'supports' => $supports,
					'taxonomies' => array('exposant-theme', 'post_tag'),
					'rewrite' => array( 'slug' => __('exposant', 'ssn') )
			)
	);
}
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
// Add columns
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
 
function exposant_custom_columns($column){
	global $post;
	switch ($column) {
		case 'year':
			$metas = get_metadata('post', $post->ID);
			$years = array();
			foreach($metas as $meta_key => $meta_value) {
				$matches = array();
				if ($meta_value[0] == 1 && preg_match('/'.SSN_FICHE_META_PREFIX.'year_([0-9]{4})/', $meta_key, $matches)) {
					$years[] = $matches[1];
				}
			}
			echo join(', ', $years);
			break;
		case 'theme':
			echo get_the_term_list( $post->ID, 'exposant_theme', '', ', ', '');
			break;
	  }
}
add_filter("manage_edit-exposant_columns", "exposant_theme_edit_columns");  
add_action("manage_posts_custom_column",  "exposant_custom_columns");
//Add Exposants in RSS Feed
function ssn_exposants_feed($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'exposant');
	return $qv;
}
add_filter('request', 'ssn_exposants_feed');

function ssn_get_last_year() {
	global $post;
	$metas = get_metadata('post', $post->ID);
	$years = array();
	foreach($metas as $meta_key => $meta_value) {
		$matches = array();
		if ($meta_value[0] == 1 && preg_match('/'.SSN_FICHE_META_PREFIX.'year_([0-9]{4})/', $meta_key, $matches)) {
			$years[] = $matches[1];
		}
	}
	if (count($years) > 0) {
		rsort($years);
		return current($years);
	} else {
		return null;
	}
}
