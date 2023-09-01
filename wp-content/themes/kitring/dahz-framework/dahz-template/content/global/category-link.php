<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

?>

<a class="uk-link" href="<?php echo esc_url( get_category_link( $category->term_id ) );?>">
	<?php echo esc_html( $category->name );?>
</a>
