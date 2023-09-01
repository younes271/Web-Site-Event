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
 * @package glamon
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" <?php post_class( 'site-main' ); ?> >
	<?php if ( ! empty( glamon_global_var( 'blog-style', '', false ) ) ) : ?>
		<?php get_template_part( 'inc/blog/blog', glamon_global_var( 'blog-style', '', false ) ); ?>
	<?php else : ?>
		<?php get_template_part( 'inc/blog/blog', 'default' ); ?>
	<?php endif; ?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
