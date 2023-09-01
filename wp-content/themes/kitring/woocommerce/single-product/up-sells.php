<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$WooSingleUpsellsTitle		= dahz_framework_get_option( 'single_woo_up_sells_title' );

$WooSingleUpsellsDesktopCol = dahz_framework_get_option( 'single_woo_up_cross_sells_desktop_column', '1-4' );
$WooSingleUpsellsTabCol		= dahz_framework_get_option( 'single_woo_up_cross_sells_tablet_column', '1-4' );
$WooSingleLandscapeCol		= dahz_framework_get_option( 'single_woo_up_cross_sells_phone_landscape_column', '3-5' );
$WooSingleMobileCol			= dahz_framework_get_option( 'single_woo_related_phone_potrait_column', '3-5' );

dahz_framework_override_static_option( array(
	'loop_product_class' => "uk-width-{$WooSingleMobileCol} uk-width-{$WooSingleLandscapeCol}@s uk-width-{$WooSingleUpsellsTabCol}@m uk-width-{$WooSingleUpsellsDesktopCol}@l"
) );

if ( $upsells ) : ?>

	<section class="up-sells upsells products">

		<hr class="uk-margin-medium uk-margin-medium-top" />

		<h4>
			<?php if( !empty( $WooSingleUpsellsTitle ) ):?>
				<?php echo apply_filters( 'dahz_framework_upsells_title', $WooSingleUpsellsTitle );?>
			<?php else:?>
				<?php esc_html_e( 'You may also like', 'kitring' ) ?>
			<?php endif;?>
		</h4>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
				 	$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>

<?php endif;

wp_reset_postdata();

dahz_framework_override_static_option( array(
	'loop_product_class' => ""
) );