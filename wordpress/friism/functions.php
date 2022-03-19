<?php

add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
add_theme_support( 'responsive-embeds' );

function theme_styles() {
  wp_enqueue_style( 'bootstrap_css', get_stylesheet_directory_uri() . '/bootstrap.min.css' );
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
    echo '<meta property="og:description" content="' . esc_html($excerpt) . '"/>';
  }

  if ( is_singular()) {
    echo '<meta property="fb:admins" content="337600016"/>';
    echo '<meta property="fb:app_id" content="620660554979626"/>';
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';

    echo '<meta name="twitter:card" content="summary_large_image" />';
    echo '<meta name="twitter:site" content="@friism" />';
    echo '<meta name="twitter:creator" content="@friism" />';
    echo '<meta name="twitter:title" content="' . htmlspecialchars(get_the_title()) . '" />';

    echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '"/>';
    if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
      //Create a default image on your server or an image in your media library, and insert it's URL here
      // $default_image="http://example.com/image.jpg";
      // echo '<meta property="og:image" content="' . $default_image . '"/>';
    }
    else {
      $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
      echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
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
    $replacement = '<img loading="lazy" $1class="$2 img-fluid mx-auto"$3>';
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

?>