<?php
/**
 * Template Content Product
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<?php
if ( ! empty( glamon_global_var( 'shop_box_style', '', false ) ) ) {
	get_template_part( 'woocommerce/shop-box/shop-box', glamon_global_var( 'shop_box_style', '', false ) );
} else {
	get_template_part( 'woocommerce/shop-box/shop-box-style-one', 'none' );
}
