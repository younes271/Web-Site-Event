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
 * @package kitring
 */
 ?>

<form class="uk-search uk-search-default uk-width-1-1" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="hidden" name="post_type" value="post" />
	<input type="hidden" name="post_type" value="page" />
	<button class="uk-search-icon-flip" type="submit" name="submit" value="<?php esc_attr_e(' Search', 'kitring' ); ?>" aria-label="submit" data-uk-search-icon>
	</button>
	<input class="uk-search-input uk-width-1-1" type="text" placeholder="<?php esc_attr_e( 'Search', 'kitring' );?>" value="<?php echo esc_attr( get_search_query() );?>" name="s" title="<?php esc_attr_e( 'search', 'kitring' );?>">
</form>
