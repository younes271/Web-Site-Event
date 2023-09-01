<?php
/**
 * The content containing the global wrapper open
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kitring
 */

?>

<div <?php dahz_framework_set_attributes( 
	array( 
		'class' => array( 'uk-container', 'de-main-container' ),
		'id'	=> "de-archive-content"
	),
	'main_container'
);?>>
	<div <?php dahz_framework_set_attributes( 
		array( 
			'class' 		=> array( 'uk-grid-large', 'de-main-grid' ),
			'data-uk-grid'	=> ''
		),
		'main_grid'
	);?>>
		<div <?php dahz_framework_set_attributes( 
			array( 
				'class' 		=> array( 'uk-width-expand@m', 'de-main-content' ),
			),
			'main_content'
		);?>>
		
			<?php do_action( 'dahz_framework_before_main_content' ); ?>
			
			<div <?php dahz_framework_set_attributes( 
				array(
					'class' 		=> array( 'de-content', 'uk-child-width-1-1@s' ),
					'data-uk-grid'	=> ''
				),
				'content'
			);?>>