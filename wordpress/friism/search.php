<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 */

get_header();

if ( have_posts() ) {
	?><h1>
		<?php printf( esc_html__( 'Search Results for: %s', 'wp-bootstrap-starter' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	<?php
	while ( have_posts() ) {

		the_post();
		get_template_part( 'template-parts/content', 'search' );
	}

	get_template_part( 'template-parts/content', 'list-nav' );
}
else {

	get_template_part( 'template-parts/content', 'none' );

}

get_footer();
