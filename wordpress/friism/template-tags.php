<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WP_Bootstrap_Starter
 */

if ( ! function_exists( 'wp_bootstrap_starter_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function wp_bootstrap_starter_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	echo '<span>' . $time_string . '</span>';
}
endif;

if ( ! function_exists( 'wp_bootstrap_starter_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function wp_bootstrap_starter_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'wp-bootstrap-starter' ) );
		if ( $categories_list && wp_bootstrap_starter_categorized_blog() ) {
			printf( '<span>' . esc_html__( 'Posted in %1$s', 'wp-bootstrap-starter' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'wp-bootstrap-starter' ) );
		if ( $tags_list ) {
			printf( ' | <span>' . esc_html__( 'Tagged %1$s', 'wp-bootstrap-starter' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'wp-bootstrap-starter' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		' | <span>',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function wp_bootstrap_starter_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'wp_bootstrap_starter_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wp_bootstrap_starter_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so wp_bootstrap_starter_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so wp_bootstrap_starter_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in wp_bootstrap_starter_categorized_blog.
 */
function wp_bootstrap_starter_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'wp_bootstrap_starter_categories' );
}
add_action( 'edit_category', 'wp_bootstrap_starter_category_transient_flusher' );
add_action( 'save_post',     'wp_bootstrap_starter_category_transient_flusher' );
