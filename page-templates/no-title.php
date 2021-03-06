<?php
/* Template Name: Page libre */

get_header(); ?>
<?php get_sidebar(); ?>
	<div id="primary" class="site-content no-title <?echo ssn_get_class_content();?>">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'free' ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>