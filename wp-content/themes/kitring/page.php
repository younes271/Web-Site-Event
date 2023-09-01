<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

get_header();

	$disabled_footer = dahz_framework_get_static_option( 'disabled_footer', false );

	do_action( 'dahz_framework_page_header' );

	dahz_framework_get_template_part( 'global/global-wrapper', 'open' );
	
			while ( have_posts() ) : the_post();

				dahz_framework_get_template_part( 'content/page/content', 'page' );

			endwhile; // End of the loop.

	dahz_framework_get_template_part( 'global/global-wrapper', 'close' );

if ( $disabled_footer ) {

	get_footer( 'blank' );

} else {

	get_footer();

}