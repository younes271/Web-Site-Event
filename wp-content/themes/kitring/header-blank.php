<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kitring
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="manifest" href="<?php echo esc_url( get_template_directory_uri() . '/assets/dist/json/manifest.json' );?>">
	<?php wp_head(); ?>
</head>

<body <?php dahz_framework_set_attributes( 
	array( 
		'class' => get_body_class()
	),
	'body'
);?>>
<div class="uk-offcanvas-content">
	<div <?php 

		dahz_framework_set_attributes( 
			array( 
				'class' => array( 'de-page-container ' . dahz_classes() .'' ),
				'id'	=> 'page',
			),
			'page_container'
	);?>>
		<div <?php dahz_framework_set_attributes( 
			array( 
				'class' => array( 'page-wrapper' ),
			), 
			'page' 
		);?>>
			<div <?php dahz_framework_set_attributes( 
				array( 
					'class' 					=> array( 'main de-content__wrapper', 'uk-section uk-padding-remove', dahz_classes('ds-site-content') ),
					'id'						=> 'de-content-wrapper',
					'data-uk-height-viewport'	=> array( 'expand:true;' )
				),
				'main'
			);?>>