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
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $cross_sells ) :

	$title = dahz_framework_get_option( 'single_woo_cross_sells_title', '' );

	$desktop_column = dahz_framework_get_option( 'single_woo_up_cross_sells_desktop_column', '1-4' );

	$tablet_column = dahz_framework_get_option( 'single_woo_up_cross_sells_tablet_column', '1-4' );

	$mobile_landscape_column = dahz_framework_get_option( 'single_woo_up_cross_sells_phone_landscape_column', '1-4' );

	$mobile_column = dahz_framework_get_option( 'single_woo_up_cross_sells_phone_potrait_column', '1-4' );

	$attributes = array();

	dahz_framework_override_static_option( array(
		'loop_product_class' => "uk-width-{$mobile_column} uk-width-{$mobile_landscape_column}@s uk-width-{$tablet_column}@m uk-width-{$desktop_column}@l"
	) );

	$attributes['class'] = array(
		'uk-slider-items uk-grid products de-product'
	);

	$attributes['data-layout'] = dahz_framework_get_option( 'shop_woo_layout', 'elaina' );

?>

	<div class="cross-sells">
		<h4 class="	uk-margin-large">
			<?php if( !empty( $title ) ):?>
				<?php echo apply_filters( 'dahz_framework_cross_sells_title', $title );?>
			<?php else:?>
				<?php _e( 'You may be interested in&hellip;', 'kitring' ) ?>
			<?php endif;?>
		</h4>
		<div class="uk-position-relative uk-visible-toggle" data-uk-slider>
			<div class="uk-slider-container">
				<ul <?php dahz_framework_set_attributes( $attributes, 'upsells_loop_start_product' );?>>
					<?php foreach ( $cross_sells as $cross_sell ) : ?>
						<?php
						$post_object = get_post( $cross_sell->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object );

						wc_get_template_part( 'content', 'product' ); ?>

					<?php endforeach; ?>
				</ul>
			</div>
			<a class="uk-position-center-left-out uk-box-shadow-medium uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
			<a class="uk-position-center-right-out uk-box-shadow-medium uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
		</div>
	</div>

<?php endif;

wp_reset_postdata();

dahz_framework_override_static_option( array(
	'loop_product_class' => ""
) );
