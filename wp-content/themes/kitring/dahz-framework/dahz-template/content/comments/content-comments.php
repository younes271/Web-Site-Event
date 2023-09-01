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
<ul class="comment-list uk-comment-list">
	<?php wp_list_comments( 'callback=dahz_framework_format_comment&short_ping=true' );?>
</ul><!-- .comment-list -->
