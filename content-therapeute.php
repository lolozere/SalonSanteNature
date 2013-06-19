<?php
/**
 * The default template for displaying exposant. 
 * Used for both single and index/archive/search.
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'ssn' ); ?>
		</div>
		<?php endif; ?>
		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<strong class="fiche-title">Pôle Thérapeute <?php echo ssn_get_last_year();?></strong>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ssn' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->

		<?php if ( !is_single() ) : // Only display Excerpts for Search ?>
		<ul class="entry-themes">
			<?php $themes = explode('|', get_the_term_list( $post->ID, 'tpeute_theme', '', '|', '')); 
			foreach($themes as $link_theme) {
				echo '<li>'.$link_theme.'</li>';
			}
			?>
		</ul><!-- .entry-themes -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<p><?php edit_post_link( __( 'Edit', 'ssn' ), '<span class="edit-link">', '</span>' ); ?></p>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'ssn' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<footer class="entry-meta">
			<?php 
			$url_site = get_post_meta($post->ID, SSN_FICHE_META_PREFIX.'site_url', true);
			$fiche_email = get_post_meta($post->ID, SSN_FICHE_META_PREFIX.'email', true);
			if (!empty($url_site)) {
				?><a href="<?php echo $url_site?>" class="fiche-url-site"><?php echo preg_replace('/http:\/\//', '', $url_site);?></a><?php 
			}
			if (!empty($fiche_email)) {
				?><span class="fiche-email"><?php echo $fiche_email;?></a><?php
			}?>
			<?php
			if (!is_single()) {?>
			<a href="<?php get_permalink();?>" class="more-link">Notre prestation sur le salon</a>
			<?php }?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
