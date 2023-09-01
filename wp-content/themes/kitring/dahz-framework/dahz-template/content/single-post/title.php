<?php

/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

$postTitleAlignment = dahz_framework_get_option( 'blog_single_title_alignment', 'left' );

$postTitleClass = dahz_framework_get_option( 'blog_single_heading', 'uk-article-title' );

$singlePostTitleLayout = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'post_title_alignment', 'left' );

if( is_single() ) {

	if ( $postTitleAlignment == 'left' ) {
		
		if ( $singlePostTitleLayout == 'left' ) {

			$postAlignmentClass = '';

		} elseif ( $singlePostTitleLayout == 'center' ) {

			$postAlignmentClass = 'uk-flex uk-flex-center';

		} else {
			$postAlignmentClass = '';
		}

	} elseif ( $postTitleAlignment == 'center' ) {
		
		if ( $singlePostTitleLayout == 'left' ) {

			$postAlignmentClass = '';

		} elseif ( $singlePostTitleLayout == 'center' ) {

			$postAlignmentClass = 'uk-flex uk-flex-center';

		} else {
			$postAlignmentClass = 'uk-flex uk-flex-center';
		}

	}

	$uikitSinglePostTitleClass = 'uk-margin-medium-bottom uk-margin-remove-top ' . $postAlignmentClass;

} else {
	$uikitSinglePostTitleClass = '';
}

$SingleUppercaseTitle = '';

$enableSingleUppercaseTitle = dahz_framework_get_option( 'blog_single_enable_uppercase_post_title', false );

if ( $enableSingleUppercaseTitle === true )
	$SingleUppercaseTitle = 'uk-text-uppercase';

$singlePostTitleclass = $postTitleClass . ' ' . $uikitSinglePostTitleClass . ' ' . $SingleUppercaseTitle;

?>

<h2 class="entry-title de-archive__entry-title <?php echo esc_attr( $singlePostTitleclass ); ?>">
	<?php echo get_the_title(); ?>
</h2>
