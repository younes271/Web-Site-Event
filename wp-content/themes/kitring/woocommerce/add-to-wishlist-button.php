<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

global $product;

?>

<a aria-label="<?php echo esc_attr( $label ); ?>" data-uk-icon="df_wishlist-outline" href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-product-id="<?php echo esc_attr( $product_id ) ?>" data-product-type="<?php echo esc_attr( $product_type )?>" class="button de-product__item--add-to-cart-button uk-position-relative <?php echo apply_filters( 'dahz_framework_wishlist_btn_classes', $link_classes ) ?>" title="<?php echo esc_attr( $label ); ?>" data-uk-tooltip="pos: left;animation: false;offset: 25;cls: de-product-thumbnail__tooltip">
	<span><?php echo esc_html( $label ); ?></span>
</a>
