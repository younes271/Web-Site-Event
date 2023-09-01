<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
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

$display_price = '';

if(function_exists('wc_get_price_to_display')){

	$display_price = wc_get_price_to_display( $product );

} else {

	$display_price = $product->get_display_price();

}
?>
<div class="ds-price-container uk-margin uk-flex" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<h5 class="uk-margin-remove-bottom uk-margin-remove-top"><?php echo sprintf( '%1$s', $product->get_price_html() );?></h5>

	<meta itemprop="price" content="<?php echo esc_attr( $display_price ); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo esc_attr( $product->is_in_stock() ? 'InStock' : 'OutOfStock' );?>" />

</div>
