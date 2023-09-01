<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package kitring
 */

get_header();

	dahz_framework_get_template_part( 'global/global-wrapper', 'open' );

		dahz_framework_get_template_part( 'content/404/content', '404' );

	dahz_framework_get_template_part( 'global/global-wrapper', 'close' );

get_footer();
