<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 */

get_header(); ?>
<?php get_sidebar(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Page non trouvée...', 'ssn' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Il semble que nous ne pouvons trouver ce que vous recherchez.', 'ssn' ); ?></p>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>