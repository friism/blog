<?php
/**
* Template Name: Full Width
 */

get_header(); ?>

	<main id="main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>

	</main>

<?php
get_footer();
