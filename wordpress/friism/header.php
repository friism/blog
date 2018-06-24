<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body>
<div class="container">
	<header class="blog-header py-3">
        <div class="row">
          <div class="col-6">
            <a class="blog-header-logo text-dark" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
          </div>
          <div class="col-6 d-flex justify-content-end align-items-center">
            <?php get_search_form() ?>
          </div>
        </div>
    </header><!-- #masthead -->
</div>
<main class="container">
	<div class="row">
