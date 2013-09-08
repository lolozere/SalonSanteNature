<?php
get_header(); ?>
<?php get_sidebar(); ?>
	<div id="primary" class="site-content <?echo ssn_get_class_content();?>">
		<div id="content" role="main" class="articles-list exposants-list">
			<?php if ( have_posts() ) : ?>
				<header class="archive-header">
					<h1 class="archive-title">
						<?php echo sprintf(__('Liste des exposants', 'ssn') . ' %s', ssn_get_request_year()); ?>
					</h1>
				</header>
				<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_type() ); ?>
				<?php endwhile;
			else:
				?>
				<header class="archive-header">
					<h1 class="archive-title">
						<?php echo sprintf(__('Liste des exposants', 'ssn') . ' %s', ssn_get_request_year()); ?>
					</h1>
				</header>
				<div class="entry-content">
					<p><?php _e( "Aucun exposant encore référencé.", 'ssn' ); ?></p>
				</div><!-- .entry-content -->
				<?php 
			endif;
			ssn_content_nav( 'nav-below' );

		?></div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>