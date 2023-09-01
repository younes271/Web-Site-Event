<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package kitring
 */

get_header('blank'); 

	if ( have_posts() ) :?>
	<div id="lazy_content_block">
	<?php
		/* Start the Loop */

		while ( have_posts() ) : the_post();

			the_content();

		endwhile; // End of the loop.
	
	else :

		get_template_part( 'template-parts/content', 'none' );

	endif; ?>
	</div>
	<?php

get_footer('blank');
