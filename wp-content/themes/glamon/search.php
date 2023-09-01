<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package glamon
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php get_template_part( 'inc/blog/blog', 'default' ); ?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
