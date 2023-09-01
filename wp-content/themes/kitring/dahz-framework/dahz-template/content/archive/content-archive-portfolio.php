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
$image_ratio = dahz_framework_get_option( 'portfolio_archive_image_ratio', '' );

$featured_image_attributes = array( 'class' => array( 'de-portfolio__featured-image' ) );

$featured_image_args = array();

if( !empty( $image_ratio ) ){
	
	$background_color = dahz_framework_get_option( 'global_lazy_load_placeholder_color', '##e5e5e5' );
	
	$featured_image_attributes['class'][] = "de-ratio de-ratio-{$image_ratio}";
	
	$featured_image_attributes['style'] = "background-color:{$background_color};";
	
	$featured_image_args = array( 
		'attributes'	=> array(
			'class'			=> 'img-responsive de-img-thumbnail',
			'data-uk-cover'	=> '',
		),
		'items_wrap'	=> '<a href="%1$s" class="de-ratio-content uk-cover-container" aria-label="%2$s">%3$s</a>', 
	);
	
}

?>
<div <?php post_class();?>>
	<article <?php dahz_framework_set_attributes( 
		array( 
			'class' => array( 'uk-article' ),
		),
		'loop_portfolio'
	);?>>
		<div <?php dahz_framework_set_attributes( 
			$featured_image_attributes,
			'portfolio_featured_image'
		);?>>
			<?php 
			dahz_framework_featured_image(
				get_the_ID(), 
				$featured_image_args
			);
			?>
		</div>
		<div <?php dahz_framework_set_attributes( 
			array( 
				'class' => array( 'uk-margin' ),
			),
			'loop_portfolio_content'
		);?>>
			<?php 
				dahz_framework_post_meta( 
					get_the_ID(),
					array(
						'items_wrap'	=> '<ul class="uk-text-small uk-subnav uk-subnav-divider uk-margin-remove-bottom">%1$s</ul>',
						'metas'			=> array( 'categories' ),
						'meta_params'	=> array( 'categories' => array( get_the_ID(), 'portfolio_categories' ) ),
					)
				);
			?>
			<?php dahz_framework_title();?>
		</div>
	</article>
</div>