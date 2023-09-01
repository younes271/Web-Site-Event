<?php

/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */
$metas = '';

if ( $render_date ){

	$metas .= sprintf(
		'
		<li>
			%1$s
		</li>
		',
		dahz_framework_get_post_meta_date()
	);
}

if ( $render_category ){

	$metas .= sprintf(
		'
		<li class="uk-width-auto">
			%1$s
		</li>
		',
		dahz_framework_get_post_meta_categories()
	);
}

if ( $render_comment && $option_comment ){

	$metas .= sprintf(
		'
		<li>
			%1$s
		</li>
		',
		dahz_framework_get_post_meta_comment()
	);
	
}
if( !empty( $metas ) ){
	
	$metaAlignment = dahz_framework_get_option( 'blog_single_title_alignment', 'left' );

	$singlePostMetaLayout = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'post_title_alignment', 'left' );

	if ( $metaAlignment == 'left' ) {
		
		if ( $singlePostMetaLayout == 'left' ) {

			$metaAlignmentClass = '';

		} elseif ( $singlePostMetaLayout == 'center' ) {

			$metaAlignmentClass = 'uk-flex-center';

		} else {
			$metaAlignmentClass = '';
		}

	} elseif ( $metaAlignment == 'center' ) {
		
		if ( $singlePostMetaLayout == 'left' ) {

			$metaAlignmentClass = '';

		} elseif ( $singlePostMetaLayout == 'center' ) {

			$metaAlignmentClass = 'uk-flex-center';

		} else {
			$metaAlignmentClass = 'uk-flex-center';
		}

	}
	
	echo sprintf(
		'
		<ul class="uk-subnav uk-subnav-divider uk-margin-remove-top %2$s">
			%1$s
		</ul>
		',
		$metas,
		( is_single() ? $metaAlignmentClass : '' )
		
	);
	
}