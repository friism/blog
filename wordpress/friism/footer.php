<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */

?>
</main>
<footer class="blog-footer ?>" role="contentinfo">
	<p>&copy; <?php echo date('Y'); ?> <?php echo '<a href="'.home_url().'">'.get_bloginfo('name').'</a>'; ?> </p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
