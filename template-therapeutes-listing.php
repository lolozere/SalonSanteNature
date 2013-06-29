<?php /* Template Name: Liste des thérapeutes */
get_header(); ?>
<?php get_sidebar(); ?>
	<div id="primary" class="site-content <?echo ssn_get_class_content();?>">
		<div id="content" role="main" class="articles-list therapeutes-list">
			<?php
			$list_args = array( 'post_type' => 'therapeute', 'posts_per_page' => 10, 'paged' => $paged, 'orderby' => 'title', 'order' => 'ASC' );
			global $ssn_current_year, $ssn_last_year;
			if (!empty($ssn_current_year)) {
				$list_args['meta_key'] = SSN_FICHE_META_PREFIX.'year_'.$ssn_current_year;
				$list_args['meta_value'] = '1';
			} else {
				$list_args['meta_key'] = SSN_FICHE_META_PREFIX.'year_'.$ssn_last_year;
				$list_args['meta_value'] = '1';
			}
			
			global $wp_query;
			$wp_query = new WP_Query( $list_args );
			
			if ( $wp_query->have_posts() ) :?>
			<header class="archive-header">
				<h1 class="archive-title">
					<?php echo sprintf(__('Pôle thérapeutes', 'ssn') . ' %s', $ssn_current_year); ?>
				</h1>
			</header>
				<?php while ( $wp_query->have_posts() ) :
					$wp_query->the_post();
					get_template_part( 'content', $post->post_type);
				endwhile;
			else:
				?>
				<header class="archive-header">
					<h1 class="archive-title">
						<?php echo sprintf(__('Pôle thérapeutes', 'ssn') . ' %s', $ssn_current_year); ?>
					</h1>
				</header>
				<div class="entry-content">
					<p><?php _e( "Aucun thérapeute encore référencé.", 'ssn' ); ?></p>
				</div><!-- .entry-content -->
				<?php 
			endif;
			ssn_content_nav( 'nav-below' );

		?></div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>