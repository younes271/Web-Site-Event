<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="uk-flex-center uk-flex uk-text-center">
	<div class="woocommerce-form-coupon-toggle">
		<?php echo apply_filters(
			'woocommerce_checkout_coupon_message',
			'<span class="uk-h4">' . __( 'Have a coupon?', 'kitring' ) . '</span>'
		) . ' <a href="#" class="showcoupon uk-link">' . __( 'Click here to enter your code', 'kitring' ) . '</a>'; 
		?>
	</div>
</div>
<div class="uk-flex uk-flex-column uk-flex-middle">
	<form class="checkout_coupon woocommerce-form-coupon uk-width-1-3 uk-text-center" method="post" style="display:none">
		<p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'kitring' ); ?></p>

		<p class="form-row form-row-first">
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'kitring' ); ?>" id="coupon_code" value="" />
		</p>

		<p class="form-row form-row-last">
			<button type="submit" class="button uk-width-1-1" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'kitring' ); ?>"><?php esc_html_e( 'Apply coupon', 'kitring' ); ?></button>
		</p>

		<div class="clear"></div>
	</form>
</div>