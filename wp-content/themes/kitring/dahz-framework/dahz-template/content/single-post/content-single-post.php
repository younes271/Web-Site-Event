<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */
if ( ! is_active_sidebar( dahz_framework_get_static_option( 'sidebar_id' ) ) || ! dahz_framework_get_static_option( 'enable_sidebar' ) ) {
	$contentWidthClass = 'uk-width-3-4@m';
} else {
	$contentWidthClass = 'uk-width-1-1';
}

$enableDropcap = dahz_framework_get_option( 'blog_single_enable_dropcap', false );

$dataFirstLetter = '';

if ( $enableDropcap === true ) {
	$dataFirstLetter = 'uk-dropcap';
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'uk-width-1-1@m uk-flex uk-flex-center' ); ?>>
	<div class="<?php echo esc_attr($contentWidthClass); ?>">
		<div class="entry-header">
			<?php

				$breadcrumbs_single = dahz_framework_get_option( 'breadcrumbs_on_single_post', false );

				$breadcrumbs_attachment = dahz_framework_get_option( 'breadcrumbs_on_attachment', false );

				/*
					* action hooked to dahz_framework_single_post_before_content
					* dahz_framework_render_post_thumbnail - 10
					* dahz_framework_render_breadcrumbs - 20
					* dahz_framework_render_post_categories - 30
					* dahz_framework_render_post_title - 40
					* dahz_framework_render_meta_post - 50
					*/

				if( !$breadcrumbs_single && is_singular( 'post' ) && !is_attachment() ){
					remove_action( 'dahz_framework_single_post_before_content', 'dahz_framework_render_breadcrumbs', 20 );
				}

				if( !$breadcrumbs_attachment && is_attachment() ){
					remove_action( 'dahz_framework_single_post_before_content', 'dahz_framework_render_breadcrumbs', 20 );
				}

				do_action( 'dahz_framework_single_post_before_content', get_the_ID() );

			?>
		</div>
		<div class="entry-content de-single__entry-content <?php echo esc_attr( $dataFirstLetter ) ?>">
			<?php

				/*
					* action hooked to dahz_framework_single_post_before_content
					* dahz_framework_render_post_content - 10
					* dahz_framework_render_post_tags - 20
					*/

				do_action( 'dahz_framework_single_post_content', get_the_ID() );

			?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->
<?php

/*
 * action hooked to dahz_framework_single_post_before_content
 * dahz_framework_render_post_navigation - 10
 */

do_action( 'dahz_framework_single_post_after_content', get_the_ID() );
