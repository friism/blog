<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>">
	<header>
		<?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<p>
			<?php wp_bootstrap_starter_posted_on(); ?>
		</p>
		<?php endif; ?>
	</header>

	<div>
		<?php the_excerpt(); ?>
	</div>

	<footer>
		<?php wp_bootstrap_starter_entry_footer(); ?>
	</footer>
</article>
