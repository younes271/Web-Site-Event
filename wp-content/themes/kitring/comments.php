<?php
/**
 * The template for displaying comments
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
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : // You can start editing here -- including this comment! ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>

			<?php dahz_framework_get_template_part( 'content/comments/content', 'navigation-above' );?>

		<?php endif; // Check for comment navigation. ?>

			<?php dahz_framework_get_template_part( 'content/comments/content', 'comments' );?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>

			<?php dahz_framework_get_template_part( 'content/comments/content', 'navigation-below' );?>

		<?php endif; // Check for comment navigation. ?>

	<?php endif; // Check for have_comments. ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : // If comments are closed and there are comments, let's leave a little note, shall we? ?>

		<?php dahz_framework_get_template_part( 'content/comments/content', 'closed' );?>

	<?php endif; ?>

	<?php dahz_framework_get_template_part( 'content/comments/content', 'form' );?>

</div><!-- #comments -->