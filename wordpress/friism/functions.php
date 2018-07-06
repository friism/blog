<?php

add_theme_support( 'post-thumbnails' );

add_action('wp_head', 'wpb_add_googleanalytics');
function wpb_add_googleanalytics() { ?>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-2317092-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-2317092-1');
</script>
<?php }

function theme_styles() {

  wp_enqueue_style( 'bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' );
  wp_enqueue_style( 'roboto_font', 'https://fonts.googleapis.com/css?family=Roboto' );
	wp_enqueue_style( 'main_css', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_styles');

function theme_js() {

	global $wp_scripts;
  wp_enqueue_script( 'jquery_js', 'https://code.jquery.com/jquery-3.3.1.slim.min.js');
  wp_enqueue_script( 'popper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js');
  wp_enqueue_script( 'bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js');
	// wp_enqueue_script( 'my_custom_js', get_template_directory_uri() . '/js/scripts.js');
}
add_action( 'wp_enqueue_scripts', 'theme_js');

require get_template_directory() . '/template-tags.php';

function add_opengraph_doctype($output) {
  $output = $output . '
  xmlns="http://www.w3.org/1999/xhtml"
  xmlns:og="https://ogp.me/ns#"
  xmlns:fb="http://www.facebook.com/2008/fbml"';
  if (is_singular()) { //if it is not a post or a page
    $output = $output . ' xmlns:article="http://ogp.me/ns/article#"';
  }
  return $output;
}
add_filter('language_attributes', 'add_opengraph_doctype');

function facebook_open_graph() {
  global $post;
  if ( !is_singular()) //if it is not a post or a page
    return;
  if($excerpt = $post->post_excerpt) {
    $excerpt = strip_tags($post->post_excerpt);
    $excerpt = str_replace("", "'", $excerpt);
  }
  else {
    $excerpt = get_bloginfo('description');
  }

  echo '<meta property="fb:admins" content="337600016"/>';
  echo '<meta property="fb:app_id" content="620660554979626"/>';
  echo '<meta property="og:title" content="' . get_the_title() . '"/>';
  if (strlen($excerpt) !== 0){
    echo '<meta property="og:description" content="' . $excerpt . '"/>';
  }
  echo '<meta property="og:type" content="article"/>';
  echo '<meta property="og:url" content="' . get_permalink() . '"/>';

  echo '<meta name="twitter:card" content="summary_large_image" />';
  echo '<meta name="twitter:site" content="@friism" />';
  echo '<meta name="twitter:creator" content="@friism" />';
  echo '<meta name="twitter:title" content="' . get_the_title() . '" />';

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
  echo "
";
}
add_action( 'wp_head', 'facebook_open_graph', 5 );

?>