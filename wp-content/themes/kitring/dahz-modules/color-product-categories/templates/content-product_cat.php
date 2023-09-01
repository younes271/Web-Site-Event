<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
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
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hover_effect = dahz_framework_get_option( 'product_categories_hover_effect', 'zoom' );

$text_color = dahz_framework_get_option( 'product_categories_text_color', '#ffffff' );

$color_overlay = dahz_framework_get_option( 'product_categories_color_overlay', 'rgba(154,166,172,0.5)' );

$hover_border_color = dahz_framework_get_option( 'product_categories_hover_border_color', '#000000' );

$show_total_number_when_hover = dahz_framework_get_option( 'product_categories_show_total_number_hover', false );

$product_tax_style = dahz_framework_get_option( 'product_categories_style', 'layout-1' );

$always_show_on_mobile = dahz_framework_get_option( 'product_categories_show_mobile', true );

$item_attr = array();

$content_attr = array();

$wrapper_attr = array();

$wrapper_attr['class'] = array( 'de-product-categories de-product__item', join( ' ', wc_get_product_cat_class( '', $category ) ) );


$wrapper_attr['data-layout'] = $product_tax_style;

# Hover effect

$wrapper_attr['data-hover-effect'] = $hover_effect;

# Show total number when hover

$wrapper_attr['data-hover-number'] = $show_total_number_when_hover;

# Always show on mobile

$wrapper_attr['data-show-mobile'] = $always_show_on_mobile;

$item_attr['class'] = array( 'de-product-categories__item de-ratio de-ratio-1-1' );

if ( $hover_effect === 'parallax-tilt' || $hover_effect === 'parallax-tilt-glare' ) {
	$item_attr['data-tilt'] = '';

	$item_attr['data-tilt-perspective'] = '4000';

	$item_attr['data-tilt-scale'] = '1.04';
}

$category_image_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );

# SETTING RATIO
$category_image_crop = get_option( 'woocommerce_thumbnail_cropping' );

$category_image_crop_w = '1';

$category_image_crop_h = '1';

switch( $category_image_crop ){
	case 'custom':
		$category_image_crop_w = get_option( 'woocommerce_thumbnail_cropping_custom_width' );

		$category_image_crop_h = get_option( 'woocommerce_thumbnail_cropping_custom_height' );
		break;
	case 'uncropped':
		$category_image_src = wp_get_attachment_image_src( $category_image_id, 'full' );

		if( $category_image_src ){

			$category_image_crop_w = get_option( 'woocommerce_thumbnail_image_width' );

			$category_image_crop_h = ( $category_image_src['2'] / $category_image_src['1'] ) * $category_image_crop_w;

		}

		break;
}

$item_ratio = 'padding-bottom: calc(('. $category_image_crop_h .'/'. $category_image_crop_w .') * 100%)';

$item_attr['style'] = $item_ratio;
# END OF SETTING RATIO

# SETTING CONTENT
# Class
$content_attr['class'] = 'de-product-categories__item-detail';

# Style
$content_attr['style'] = array();

# Text color
$content_attr['style'][] = sprintf( 'color: %s;', $text_color );

# Overlay color
$content_attr['style'][] = sprintf( 'background-color: %s;', $color_overlay );

# Border color
$content_attr['style'][] = sprintf( 'border-color: %s;', $hover_border_color );
# END OF SETTING CONTENT
?>
<li <?php dahz_framework_set_attributes( $wrapper_attr, 'product_categories_wrapper' ); ?>>
	<div <?php dahz_framework_set_attributes( $item_attr, 'product_categories_item' ); ?>>
		<div class="de-product-categories__item-category">
			<a href="<?php echo esc_url( get_term_link( $category->term_id ) ); ?>">
				<?php echo wp_get_attachment_image( $category_image_id, 'shop_catalog', false, array( 'alt' => get_post_field( 'post_title', $category_image_id ), ) ); ?>
				<div <?php dahz_framework_set_attributes( $content_attr, 'product_categories_content' ); ?>>
					<div>
						<h3><?php echo esc_html( $category->name ); ?></h3>
						<p><?php echo esc_html( sprintf( '%s Products', $category->category_count ) ); ?></p>
					</div>
				</div>
			</a>
		</div>
	</div>
</li>