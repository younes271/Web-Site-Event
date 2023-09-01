<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 * @author Dahz | Rama
 */
if ( $render_author ){

	$metas[] = sprintf(
		'
		<div class="de-single__author-image uk-inline">
			<a class="uk-link" href="%1$s" aria-label="%3$s">%2$s</a>
		</div>
		<div class="de-single__author-description uk-inline">
			<span>%4$s</span>
			<a class="uk-link" href="%1$s">
				<span>%3$s</span>
			</a>
			<span>- %5$s</span>
		</div>
		',
		esc_url( dahz_framework_get_meta_author_link() ),
		get_avatar( get_the_author_meta( 'ID' ) ),
		get_the_author_meta( 'display_name' ),
		esc_html__( 'By', 'kitring' ),
		esc_html__( 'In', 'kitring' )
	);
}
foreach ( $categories as $category ) {

	$metas[] = sprintf(
		'
		<a class="uk-link" href="%1$s"><span class="uk-inline">%2$s</span></a>
		',
		esc_url( get_category_link( $category->term_id ) ),
		esc_html( $category->name )
	);

}
if ( $metas ) {
	echo apply_filters( 'dahz_framework_meta_post_html',
		implode( $metas )
	);
}
