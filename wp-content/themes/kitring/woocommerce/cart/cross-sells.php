<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;
$WooSinglecrosssellsTitle		= dahz_framework_get_option( 'single_woo_cross_sells_title' );

$WooSingleUpsellsDesktopCol = dahz_framework_get_option( 'single_woo_up_cross_sells_desktop_column', '1-2' );
$WooSingleUpsellsTabCol		= dahz_framework_get_option( 'single_woo_up_cross_sells_tablet_column', '1-2' );
$WooSingleLandscapeCol		= dahz_framework_get_option( 'single_woo_up_cross_sells_phone_landscape_column', '3-5' );
$WooSingleMobileCol			= dahz_framework_get_option( 'single_woo_related_phone_potrait_column', '3-5' );

dahz_framework_override_static_option( array(
	'loop_product_class' => "uk-width-{$WooSingleMobileCol} uk-width-{$WooSingleLandscapeCol}@s uk-width-{$WooSingleUpsellsTabCol}@m uk-width-{$WooSingleUpsellsDesktopCol}@l"
) );

if ( $cross_sells ) : ?>

	<div class="cross-sells">
		<?php
		$heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'You may be interested in&hellip;', 'kitring' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
				 	$post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); 
				?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>
	<?php 
endif;

wp_reset_postdata();

dahz_framework_override_static_option( 
	array(
		'loop_product_class' => ""
	) 
);