<?php
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles' );
function child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

add_action( 'wp_enqueue_scripts', 'my_custom_scripts', 100 );
function my_custom_scripts()
{
    wp_dequeue_script( 'jquery' );
    wp_deregister_script( 'jquery' );
}
?>
