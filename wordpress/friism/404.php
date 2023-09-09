<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 */

get_header(); ?>
<main id="main" role="main">
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title">Oops! That page can&rsquo;t be found.</h1>
		</header>
		<div class="page-content">
			<p>It looks like nothing was found at this location. Maybe try one of the links below or a search?</p>
			<?php
				get_search_form();

			?>
		</div>
	</section>
</main>

<?php
get_footer();
