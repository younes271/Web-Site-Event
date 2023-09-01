<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package kitring
 */

get_header();

$disabled_footer = dahz_framework_get_static_option( 'disabled_footer', false );

dahz_framework_get_template_part( 'global/global-wrapper', 'open' );

	if ( have_posts() ) :

		/* Start the Loop */

		while ( have_posts() ) : the_post();

			dahz_framework_get_template_part( 'content/single-post/content-single', 'post' );

		endwhile; // End of the loop.

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;

dahz_framework_get_template_part( 'global/global-wrapper', 'close' );

if ( $disabled_footer ) {
	
	get_footer( 'blank' );
	
} else {
	
	get_footer();
	
}