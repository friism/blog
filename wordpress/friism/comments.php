<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php
if ( have_comments() ) : ?>
    <h3>Comments</h3>

    <?php
        wp_list_comments( array( 'type' => 'comment', 'avatar_size' => 30, 'style' => 'div', 'callback' => 'comment', 'end-callback' => 'comments_end_callback' ));
    ?>
    <?php 
endif;

if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

    <p><?php esc_html_e( 'Comments are closed.', 'wp-bootstrap-starter' ); ?></p>
    <?php
endif; ?>

<?php comment_form();?>

