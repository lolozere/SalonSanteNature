<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<?php get_sidebar(); ?>
	<div id="primary" class="site-content <?php echo ssn_get_class_content();?>">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); 

				get_template_part( 'content', $post->post_type);?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>