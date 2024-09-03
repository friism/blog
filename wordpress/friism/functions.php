<?php

add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
add_theme_support( 'responsive-embeds' );

function theme_styles() {
  wp_enqueue_style( 'simple_css', get_stylesheet_directory_uri() . '/simple.min.css' );
}

add_action( 'wp_enqueue_scripts', 'theme_styles');

require get_template_directory() . '/template-tags.php';

function add_opengraph_doctype($output) {
  $prefixValue = 'og: https://ogp.me/ns# fb: http://www.facebook.com/2008/fbml';
  if (is_singular()) { //if it is not a post or a page
    $prefixValue = $prefixValue . ' article: http://ogp.me/ns/article#';
  }

  $output = $output . ' xmlns="http://www.w3.org/1999/xhtml" prefix="' . $prefixValue .'"';
  return $output;
}
add_filter('language_attributes', 'add_opengraph_doctype');

function facebook_open_graph() {
  global $post;
  if($excerpt = get_the_excerpt()) {
    $excerpt = wp_strip_all_tags($excerpt, true);
  }
  else {
    $excerpt = get_bloginfo('description');
  }
  if (strlen($excerpt) !== 0){
    echo '<meta property="og:description" content="' . esc_html($excerpt) . '">';
  }

  if ( is_singular()) {
    echo '<meta property="fb:admins" content="337600016">';
    echo '<meta property="fb:app_id" content="620660554979626">';
    echo '<meta property="og:title" content="' . get_the_title() . '">';
    echo '<meta property="og:type" content="article">';
    echo '<meta property="og:url" content="' . get_permalink() . '">';

    echo '<meta name="twitter:card" content="summary_large_image" >';
    echo '<meta name="twitter:site" content="@friism" >';
    echo '<meta name="twitter:creator" content="@friism" >';
    echo '<meta name="twitter:title" content="' . htmlspecialchars(get_the_title()) . '" >';

    echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '">';
    if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
      //Create a default image on your server or an image in your media library, and insert it's URL here
      // $default_image="http://example.com/image.jpg";
      // echo '<meta property="og:image" content="' . $default_image . '"/>';
    }
    else {
      $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
      echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '">';
      echo '<meta name="twitter:image" content="' . esc_attr( $thumbnail_src[0] ) . '">';
    }
  }
  echo "
";
}
add_action( 'wp_head', 'facebook_open_graph', 5 );

function add_responsive_class_and_lazyload($content){
  if ( $content ) {
    $imgPattern ="/<img (.*?)class=\"(.*?)\"(.*?)>/i";
    $replacement = '<img loading="lazy" $1class="$2 img-fluid"$3>';
    $content = preg_replace($imgPattern, $replacement, $content);

    $figPattern ="/<figure (.*?)class=\"(.*?)\"(.*?)>/i";
    $replacement = '<figure $1class="$2 figure"$3>';
    $content = preg_replace($figPattern, $replacement, $content);

    // TODO: this is not very robust if WP makes the caption tag more complicated
    $captionPattern ="/<figcaption>/i";
    $replacement = '<figcaption class="text-center fst-italic">';
    $content = preg_replace($captionPattern, $replacement, $content);
  }
  return $content;
}

add_filter('the_content','add_responsive_class_and_lazyload');

function lazy_embed_oembed_html($content){
  $content = str_replace('<iframe ','<iframe loading="lazy" ', $content);
  return $content;
}

add_filter('embed_oembed_html', 'lazy_embed_oembed_html');

/**
 * Disable the emoji's
 */
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
 }
 add_action( 'init', 'disable_emojis' );
 
 /**
  * Filter function used to remove the tinymce emoji plugin.
  * 
  * @param array $plugins 
  * @return array Difference betwen the two arrays
  */
 function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
  return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
  return array();
  }
 }
 
 /**
  * Remove emoji CDN hostname from DNS prefetching hints.
  *
  * @param array $urls URLs to print for resource hints.
  * @param string $relation_type The relation type the URLs are printed for.
  * @return array Difference betwen the two arrays.
  */
 function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
  /** This filter is documented in wp-includes/formatting.php */
  $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
 
  $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }
 
 return $urls;
 }

function comments_end_callback($comment, $args, $depth) {
  ?>
  </article>
  <?php
}

function comment( $comment, $args, $depth ) {
  ?>
    <article id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
      <p>
        <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <?php comment_author_link(); ?> on <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>"><?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'wp-bootstrap-starter' ), get_comment_date(), get_comment_time()); ?></time></a>
        <?php edit_comment_link('Edit'); ?>
      </p>
      <?php comment_text(); ?>
      <?php if ( '0' == $comment->comment_approved ) : ?>
        <p class="comment-awaiting-moderation">
          <?php _e( 'Your comment is awaiting moderation.', 'wp-bootstrap-starter' ); ?>
        </p>
      <?php endif; ?>
      <p>
        <?php comment_reply_link(
          array_merge(
            $args, array(
              'add_below' => 'comment',
              'depth' 	=> $depth,
              'max_depth' => $args['max_depth']
            )
          )
        ); ?>
      </p>
  <?php
  }
?>