<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

	<h1><?php printf( esc_html__( 'Search Results for: %s', 'wp-bootstrap-starter' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();

		/**
		 * Run the loop for the search to output the results.
		 * If you want to overload this in a child theme then include a file
		 * called content-search.php and that will be used instead.
		 */
		get_template_part( 'template-parts/content', 'search' );

	endwhile;
	?>

	<nav class="col-lg-8">
		<div class="border-top py-3">
			<?php next_posts_link('Older') ?>
			<?php previous_posts_link('Newer') ?>
		</div>
	</nav>
	<?php
else :

	get_template_part( 'template-parts/content', 'none' );

endif; ?>

<?php
get_footer();
