<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" class="my-4 col-lg-8 align-self-center">
	<header class="border-bottom">
		<?php the_title( sprintf( '<h2><a class="text-dark" href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<p class="text-secondary">
			<?php wp_bootstrap_starter_posted_on(); ?>
		</p>
		<?php endif; ?>
	</header>

	<div class="pt-3">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<?php wp_bootstrap_starter_entry_footer(); ?>
	</footer>
</article>
