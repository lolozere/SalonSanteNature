<?php
/**
 * The template for displaying all pages.
 *
 */

get_header(); ?>
<?php get_sidebar(); ?>
	<div id="primary" class="site-content <?php echo ssn_get_class_content();?>">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>