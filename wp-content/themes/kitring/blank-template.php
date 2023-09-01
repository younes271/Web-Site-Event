<?php
/*
* Template Name: Blank Template
* Template part for displaying page content in page.php
*/

get_header( 'blank' );

	do_action( 'dahz_framework_page_header' );

	dahz_framework_get_template_part( 'global/global-wrapper', 'open' );
	
			while ( have_posts() ) : the_post();

				dahz_framework_get_template_part( 'content/page/content', 'page' );

			endwhile; // End of the loop.

	dahz_framework_get_template_part( 'global/global-wrapper', 'close' );

get_footer( 'blank' );