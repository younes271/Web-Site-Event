<?php

/**
 * The Comments wrapper template file
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
if ( post_password_required() ) {
	return;
}
$enable_comment_counts = dahz_framework_get_option( 'blog_single_enable_comment_counts', true );

?>
<div class="uk-width-1-1 uk-margin-auto de-comments">
	<hr class="uk-margin-medium">
	<div class="uk-width-auto">

			<?php
			if ( get_comments_number() > 0 ) {
				printf( // WPCS: XSS OK.
					'<h2 class="uk-margin de-comments__title">' .
					esc_html( _nx( '%1$s Comment', '%2$s Comments', get_comments_number(), 'comments title', 'kitring' ) ) . '</h2>',
					$enable_comment_counts ? ' <span class="de-single__comments-area-counter">1</span>' : '',
					$enable_comment_counts ? ' <span class="de-single__comments-area-counter">' . number_format_i18n( get_comments_number() ) . '</span>' : ''
				);
			}
			?>
			
		<?php comments_template(); ?>
	</div>
</div>
