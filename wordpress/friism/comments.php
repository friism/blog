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

<div id="comments" class="col-lg-8 align-self-center">
    <?php
    if ( have_comments() ) : ?>
        <h3>Comments</h3>

        <?php
            wp_list_comments( array( 'callback' => 'wp_bootstrap_starter_comment', 'type' => 'comment', 'avatar_size' => 30, 'style' => 'div' ));
        ?>
        <?php 
    endif;

    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wp-bootstrap-starter' ); ?></p>
        <?php
    endif; ?>

    <?php comment_form( $args = array(
        'fields' => array(
            'author'    =>  '<div class="form-group row"><div class="col"><input type="text" class="form-control" id="author" name="author" placeholder="Name" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . ( $req ? 'required' : '' ) . ' /></div>',
            'email'     =>  '<div class="col"><input type="text" class="form-control" id="email" name="email" placeholder="Email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" ' . ( $req ? 'required' : '' ) . ' /></div>',
            'url'       =>  '<div class="col"><input type="text" class="form-control" id="url" name="url" placeholder="Website" value="' . esc_attr( $commenter['comment_author_url'] ) . '" ' . ( $req ? 'required' : '' ) . ' /></div></div>',
            'cookies'   =>  '<div class="form-group"><div class="form-check"><input type="checkbox" class="form-check-input" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" value="yes" /><label for="wp-comment-cookies-consent" class="form-check-label">' . __( 'Save my name, email, and website in this browser for the next time I comment.' ) . '</label></div></div>',
        ),
        'id_form'           => 'commentform',  // that's the wordpress default value! delete it or edit it ;)
        'id_submit'         => 'commentsubmit',
        'title_reply'       => __( 'Leave a Reply', 'wp-bootstrap-starter' ),  // that's the wordpress default value! delete it or edit it ;)
        'title_reply_to'    => __( 'Leave a Reply to %s', 'wp-bootstrap-starter' ),  // that's the wordpress default value! delete it or edit it ;)
        'cancel_reply_link' => __( 'Cancel Reply', 'wp-bootstrap-starter' ),  // that's the wordpress default value! delete it or edit it ;)
        'label_submit'      => __( 'Post Comment', 'wp-bootstrap-starter' ),  // that's the wordpress default value! delete it or edit it ;)

        'class_submit'      => 'btn btn-secondary',
        'class_form'        => NULL,

        'comment_field'     =>  '<p><textarea placeholder="Start typing..." id="comment" class="form-control" name="comment" cols="45" rows="8" required></textarea></p>',

        'comment_notes_after' => '<p class="form-allowed-tags">' .
            __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'wp-bootstrap-starter' ) .
            '</p><div class="alert alert-info">' . allowed_tags() . '</div>'

        // So, that was the needed stuff to have bootstrap basic styles for the form elements and buttons

        // Basically you can edit everything here!
        // Checkout the docs for more: http://codex.wordpress.org/Function_Reference/comment_form
        // Another note: some classes are added in the bootstrap-wp.js - ckeck from line 1

    ));

	?>
</div>
