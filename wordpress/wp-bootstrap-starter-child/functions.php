<?php
function my_theme_enqueue_styles() {
    $parent_style = 'wp-bootstrap-starter-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function my_custom_scripts()
{
    wp_dequeue_script( 'jquery' );
    wp_deregister_script( 'jquery' );
    wp_dequeue_script( 'wp-bootstrap-starter-themejs' );
    wp_deregister_script( 'wp-bootstrap-starter-themejs' );
    wp_dequeue_script( 'wp-bootstrap-starter-bootstrapjs' );
    wp_deregister_script( 'wp-bootstrap-starter-bootstrapjs' );
}
add_action( 'wp_enqueue_scripts', 'my_custom_scripts', 100 );

/**
 * Add search box to primary menu
 */
function wpgood_nav_search($items, $args) {
    // If this isn't the primary menu, do nothing
    if( !($args->theme_location == 'primary') ) 
    return $items;
    // Otherwise, add search form
    return $items . '<li>' . get_search_form(false) . '</li>';
}
add_filter('wp_nav_menu_items', 'wpgood_nav_search', 10, 2);

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

?>
