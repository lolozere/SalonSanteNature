<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php global $ssn_current_year; ?>
	<section id="primary" class="site-content <?echo ssn_get_class_content();?>">
		<div id="content" role="main" class="articles-list therapeutes-list">
			<?php 
			
			if ( have_posts() ) : ?>
				<header class="archive-header">
					<h1 class="archive-title">
						<?php echo sprintf(__('Pôle thérapie / Bien-être', 'ssn') . ' %s', ssn_get_current_year()); ?> &gt;
						<?php 
						$current_term = get_term_by( 'slug', get_query_var('term') ,'tpeute_theme' );								
						echo '<span>'.$current_term->name.'</span>'; 
						?>
					</h1>
				</header><!-- .archive-header -->
				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
					/* Include the post format-specific template for the content. If you want to
					 * this in a child theme then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', $post->post_type);
				endwhile;
				ssn_content_nav( 'nav-below' );
				?>
	
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_footer(); ?>
