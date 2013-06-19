<?php
/* Template Name: Page sans colonne complémentaire */

get_header(); ?>
<?php get_sidebar(); ?>
	<div id="primary" class="site-content two-columns">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>