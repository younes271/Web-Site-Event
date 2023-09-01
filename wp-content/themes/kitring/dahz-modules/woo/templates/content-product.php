<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Setup layout
$layout_archive = dahz_framework_get_option( 'shop_woo_layout', 'elaina' );
// Setup landscape
$landscape_image = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'single_image_landscape', '' );

$landscape_state = 'esmeralda' == $layout_archive && !empty( $landscape_image ) ? true : false;

$landscape_data  = $landscape_state ? 'true' : 'false';
// Setup animation
$data_bottom_top = 'eunika' == $layout_archive || 'shortcode_quickview' == $layout_archive ? '' : 'opacity: 0;transform:translate3d(0px, 20px, 0px);transition: .15s;';

$data_90p_top    = 'eunika' == $layout_archive || 'shortcode_quickview' == $layout_archive ? '' : 'opacity: 1;transform:translate3d(0px, 0px, 0px);';

$is_show_data_unit_sold = dahz_framework_get_static_option( 'loop_product_show_data_unit_sold', false );

$loop_class = dahz_framework_get_static_option( 'loop_product_class', '' );

if( $is_show_data_unit_sold ){

	$units_sold = get_post_meta( get_the_ID(), 'total_sales', true );

}

?>
<li <?php post_class( array( 'de-product__item', $loop_class ) ); ?><?php echo ! empty( $is_show_data_unit_sold ) ? sprintf( ' data-sold="%1$s" ', esc_attr( (int)$units_sold ) ) : '';?> data-landscape="<?php echo esc_attr( $landscape_data ); ?>" data-bottom-top="<?php echo esc_attr( $data_bottom_top ); ?>" data-90p-top="<?php echo esc_attr( $data_90p_top ); ?>" data-rating="<?php echo esc_attr( $product->get_average_rating() );?>">
	<div class="de-product__item-wrapper">
		<div class="de-product-thumbnail">
			<div class="de-product-thumbnail__badges">
				<?php dahz_framework_render_badge_sale( 'de-product-thumbnail__badges-wording' ); ?>
				<?php dahz_framework_render_badge_outofstock( 'de-product-thumbnail__badges-wording' ); ?>
			</div>
			<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
			<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
			<?php if ( $landscape_state ) : ?>
				<?php dahz_framework_render_product_thumbnail_landscape(); ?>
			<?php else : ?>
				<?php woocommerce_template_loop_product_thumbnail(); ?>
			<?php endif; ?>
			<?php dahz_framework_render_product_thumbnail_secondary(); ?>
			<?php woocommerce_template_loop_product_link_close(); ?>
			<div class="de-product-thumbnail__action">
				<div class="de-product-thumbnail__action--wrapper">
					<?php dahz_framework_render_product_wishlist(); ?>
					<div class="de-product-thumbnail__action--add-to-cart">
						<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="de-product-detail">
			<div class="de-product-detail__wrapper">
				<div class="de-product-detail__wrapper--meta uk-margin-small-bottom">
					<?php dahz_framework_render_product_category_brand(); ?>
					<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
				</div>
				<h6 class="de-product-detail__title uk-margin-small-bottom">
					<a class="uk-link" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php the_title(); ?></a>
				</h6>
				<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
				<div class="de-product-detail__price">
					<?php woocommerce_template_loop_price(); ?>
				</div>
			</div>
		</div>
	</div>
</li>
