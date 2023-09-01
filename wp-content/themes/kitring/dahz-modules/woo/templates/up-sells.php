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
global $product;

$attributes = array();
dahz_framework_override_static_option( array(
	'loop_product_class' => "uk-width-{$mobile_column} uk-width-{$mobile_landscape_column}@s uk-width-{$tablet_column}@m uk-width-{$desktop_column}@l"
) );
if ( $upsells ) :
	$attributes['class'] = array(
		'uk-slider-items uk-grid products de-product'
	);
	$attributes['data-layout'] = dahz_framework_get_option( 'shop_woo_layout', 'elaina' );
?>

	<h4 class="uk-text-center uk-margin">
		<?php if( !empty( $title ) ):?>
			<?php echo apply_filters( 'dahz_framework_upsells_title', $title );?>
		<?php else:?>
			<?php esc_html_e( 'You may also like', 'kitring' ) ?>
		<?php endif;?>
	</h4>

	<div class="uk-position-relative uk-visible-toggle uk-margin-large" data-uk-slider>
		<ul <?php dahz_framework_set_attributes( $attributes, 'upsells_loop_start_product' );?>>
			<?php foreach ( $upsells as $upsell ) : ?>
				<?php
				$post_object = get_post( $upsell->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object );

				wc_get_template_part( 'content', 'product' );
				?>
			<?php endforeach; ?>
		</ul>
		<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slider-item="previous" aria-label="<?php esc_attr_e( 'Previous', 'kitring' ); ?>"></a>
		<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slider-item="next" aria-label="<?php esc_attr_e( 'Next', 'kitring' ); ?>"></a>
	</div>
<?php endif;

wp_reset_postdata();

dahz_framework_override_static_option( array(
	'loop_product_class' => ""
) );