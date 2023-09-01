<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kitring
 * @since 1.0
 * @version 1.0
 */

global $post;

$featured_list = '';

$wrapper_attr = array( 'class' => array( 'de-featured-area' ) );

if ( $layout == 'featured-2' || $layout == 'featured-3' ) {
	$wrapper_attr['class'][] = 'uk-container';
} 

$featured_attr = array(
	'class'			=> array( 'uk-position-relative uk-transition-toggle' ),
	'data-uk-slider'=> array( 'center:true;' )
);

$slider_attr = array(
	'class'						=> array( 'uk-slider-items uk-grid' ),
	'data-uk-grid'				=> '',
	'data-uk-height-viewport'	=> array( 'offset-top:true;' )
);

if ( $layout == 'featured-4' ) {
	$slider_attr['class'][] = 'uk-grid-collapse';
} else {
	$slider_attr['class'][] = 'uk-grid-large';
}

$uppercase = $enable_uppercase ? ' uk-text-uppercase' : '';

$metas = dahz_framework_get_option( 
	'blog_featured_area_post_meta', 
	array(
		'date',
		'categories',
		'comment',
	)
);

$heading_style = dahz_framework_get_option( 'blog_featured_area_heading', 'uk-article-title' );

?>
<div class="uk-section uk-padding-remove-vertical de-featured-area">
	<div <?php dahz_framework_set_attributes( $wrapper_attr, 'featured_area_wrapper' ); ?>>
		<div <?php dahz_framework_set_attributes( $featured_attr, 'featured_area_inner_wrapper' ); ?>>
			<ul <?php dahz_framework_set_attributes( $slider_attr, 'featured_area_slider_wrapper' ); ?>>
				<?php
				foreach( $posts_featured as $post ) {

					setup_postdata( $post );
					
					$featured_list .= dahz_framework_get_template_html(
						"{$layout}.php",
						array(
							'uppercase' 	=> $uppercase,
							'metas'			=> $metas,
							'heading_style'	=> $heading_style,
						),
						'dahz-modules/blog-featured-area/templates/'
					);
				}

				wp_reset_postdata();

				echo apply_filters( 'dahz_framework_featured_area_item', $featured_list );
				?>
			</ul>
			<a class="uk-box-shadow-large uk-width-auto uk-card uk-card-body uk-card-default uk-position-center-left uk-position-small uk-transition-fade" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
			<a class="uk-box-shadow-large uk-width-auto uk-card uk-card-body uk-card-default uk-position-center-right uk-position-small uk-transition-fade" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
			<ul class="uk-position-bottom uk-flex-center uk-position-medium uk-slider-nav uk-dotnav"></ul>
		</div>
	</div>
</div>