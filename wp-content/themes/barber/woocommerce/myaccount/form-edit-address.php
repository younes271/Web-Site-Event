<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
  * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$page_title = ( $load_address === 'billing' ) ? esc_html__( 'Billing Address', 'barber' ) : esc_html__( 'Shipping Address', 'barber' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

	<form method="post">
		<div class="title-hdwoo">
			<h3 class="title-cart"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></h3>
		</div>

		<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

		<?php
			foreach ( $address as $key => $field ) {
				if ( isset( $field['country_field'], $address[ $field['country_field'] ] ) ) {
					$field['country'] = wc_get_post_data_by_key( $field['country_field'], $address[ $field['country_field'] ]['value'] );
				}
				woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
			}
		?>

		<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

		<p>
			<input type="submit" class="button btn btn-primary" name="save_address" value="<?php esc_attr_e( 'Save Address', 'barber' ); ?>" />
			<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
			<input type="hidden" name="action" value="edit_address" />
		</p>

	</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
