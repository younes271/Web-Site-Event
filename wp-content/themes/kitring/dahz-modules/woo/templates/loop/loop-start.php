<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.0.0
 */
$before_start = '';

$is_loop_product_shortcode = dahz_framework_get_static_option( 'is_loop_product_shortcode' );

$enable_loop_product_slider = dahz_framework_get_static_option( 'enable_loop_product_slider' );

$loopSliderClass = ( is_product() ? 'uk-slider-items' : '' );

$attributes = array(
	'class'				=> array( 'products', 'de-product', 'uk-grid', dahz_framework_get_static_option( 'loop_product_gutter' ), $loopSliderClass ),
	'data-layout'		=> dahz_framework_get_option( 'shop_woo_layout', 'elaina' ),
	'data-uk-grid'		=> ''
);

if( $is_loop_product_shortcode ){

	$mobile_column = dahz_framework_get_static_option( 'loop_product_phone_potrait_column', '1' );

	$tablet_column = dahz_framework_get_static_option( 'loop_product_tablet_landscape_column', '2' );

	$desktop_column = dahz_framework_get_static_option( 'loop_product_desktop_column', '3' );

	$mobile_landscape_column = dahz_framework_get_static_option( 'loop_product_phone_landscape_column', '2' );

	$attributes['class'][] = dahz_framework_get_static_option( 'loop_product_color_scheme', '' );

	if( $enable_loop_product_slider ){

		$attributes['class'][] = 'uk-slider-items';

		$slider_settings = array();

		$auto_play_interval = dahz_framework_get_static_option( 'loop_product_slider_auto_play_interval', '' );

		if( !empty( $auto_play_interval ) ) $slider_settings[] = "autoplay:true;autoplay-interval:{$auto_play_interval};";

		$enable_infinite = dahz_framework_get_static_option( 'loop_product_slider_enable_infinite', true );

		if( empty( $enable_infinite ) ) $slider_settings[] = 'finite:true;';

		$enable_slide = dahz_framework_get_static_option( 'loop_product_slider_enable_slide', true );

		if( !empty( $enable_slide ) ) $slider_settings[] = 'sets:true;';

		$enable_center_active = dahz_framework_get_static_option( 'loop_product_slider_enable_center_active', false );

		if( !empty( $enable_center_active ) ) $slider_settings[] = 'center:true;';

		$before_start = sprintf(
			'
			<div class="uk-position-relative uk-visible-toggle" %1$s>
			',
			dahz_framework_set_attributes(
				array(
					'uk-slider'	=> $slider_settings
				),
				'loop_start_product_slider',
				array(),
				false
			)
		);

	}

} else {

	$mobile_column = dahz_framework_get_option( 'shop_woo_mobile_column', '1' );

	$tablet_column = dahz_framework_get_option( 'shop_woo_tablet_column', '2' );

	$desktop_column = is_product() ? dahz_framework_get_option( 'single_woo_related_product_column', '3' ) : dahz_framework_get_option( 'shop_woo_desktop_column', '3' );

	$mobile_landscape_column = dahz_framework_get_option( 'shop_woo_mobile_landscape_column', '2' );

	$loop_product_transition = dahz_framework_get_option( 'shop_woo_product_transition' );

	if( !empty( $loop_product_transition ) ){

		$attributes['data-uk-scrollspy'] = array( 'target: > li;', "cls:{$loop_product_transition};repeat:true;" );

		if( dahz_framework_get_option( 'shop_woo_enable_delay_transition', false ) ) $attributes['data-uk-scrollspy'][] = 'delay:300';

	}

}

$attributes['class'][] = sprintf(
	'uk-child-width-1-%1$s uk-child-width-1-%4$s@s uk-child-width-1-%2$s@m uk-child-width-1-%3$s@l %5$s',
	$mobile_column,
	$tablet_column,
	$desktop_column,
	$mobile_landscape_column,
	dahz_framework_get_option( 'shop_woo_pagination', 'number' ) === 'number' ? '' : 'de-pagination-result'
);


echo apply_filters( 'dahz_framework_woo_before_loop_start', $before_start );
?>

<ul <?php dahz_framework_set_attributes( $attributes, 'loop_start_product' );?>>
