<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

?>

<article id="post-<?php the_ID(); ?>">
	<hgroup>
		<?php
		if ( is_single() ) :
			the_title( '<h1>', '</h1>' );
		else :
			the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<p>
			<?php wp_bootstrap_starter_posted_on(); ?>
		</p>
		<?php endif; ?>
	</hgroup>

	<div>
		<?php
        if ( is_single() ) :
			the_content();
        else :
            the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wp-bootstrap-starter' ) );
        endif;

			wp_link_pages( array(
				'before' => '<div>' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
				'after'  => '</div>',
			) );
		?>
	</div>

	<footer>
		<?php wp_bootstrap_starter_entry_footer(); ?>
	</footer>
</article>
