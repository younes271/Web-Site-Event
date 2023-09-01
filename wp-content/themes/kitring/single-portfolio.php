<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

get_header();


dahz_framework_get_template_part( 'global/global-wrapper', 'open' );

while ( have_posts() ) : the_post();
			
	/*
	 * Include the Post-Format-specific template for the content.
	 * If you want to override this in a child theme, then include a file
	 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
	 */
	dahz_framework_get_template_part( 'content/single-post/content', 'single-portfolio' );

endwhile;
	
dahz_framework_get_template_part( 'global/global-wrapper', 'close' );

get_footer();