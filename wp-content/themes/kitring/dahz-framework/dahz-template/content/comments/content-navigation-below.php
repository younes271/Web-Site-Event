<?php
/**
 * The template for displaying comments navigation
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>
<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
	<div class="nav-links uk-flex uk-flex-center">
		<?php paginate_comments_links( array('prev_text' => '<i data-uk-icon="icon:chevron-left;" ></i>', 'next_text' => '<i data-uk-icon="icon:chevron-right" ></i>') ) ?>
	</div><!-- .nav-links -->
</nav><!-- #comment-nav-below -->
