<?php
/**
 * The content containing the main content area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kitring
 */

$layout = '';

if ( is_home() ) {

	$layout = dahz_framework_get_option( 'blog_template_layout', 'layout-1' );

} else if ( is_archive() || is_search() ) {

	$layout = dahz_framework_get_option( 'blog_archive_layout', 'layout-1' );

}

$content_style = dahz_framework_get_option( 'general_layout_general_layout' );

$content_center = !dahz_framework_get_static_option( 'enable_sidebar' ) ? ' uk-flex-center' : 'uk-flex-between';

$content_center_search = ( is_archive() || is_search() ) && ! have_posts() && ! dahz_framework_get_static_option( 'enable_sidebar' ) ? ' uk-flex uk-flex-center uk-text-center' : '';

?>

<div id="de-archive-content" class="de-archive-content <?php echo esc_attr( $layout ); ?> de-content-<?php echo esc_attr( $content_style ); ?>">
	<div class="uk-container">
		<div class="<?php echo esc_attr( sprintf( 'uk-grid %s', $content_center ) ); ?>" data-uk-grid>
			<div id="de-content-render" class="<?php echo esc_attr( dahz_framework_get_static_option( 'content_class' ) ); ?> de-content-sticky">
				<div class="de-archive uk-grid uk-grid-large<?php echo esc_attr( $content_center_search );?>" data-uk-grid>
