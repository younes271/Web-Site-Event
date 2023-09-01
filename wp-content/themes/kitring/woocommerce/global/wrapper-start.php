<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
do_action( 'dahz_woocommerce_before_main_content' );
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