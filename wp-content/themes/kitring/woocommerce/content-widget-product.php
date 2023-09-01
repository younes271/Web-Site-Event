<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

$product_id = "";

if( is_object( $product ) ){

	if( method_exists($product,'get_id') ){

		$product_id = $product->get_id();

	} else {

		$product_id = $product->id;

	}
}
$rating = "";

if( is_object( $product ) ){

	if( method_exists($product,'get_average_rating') ){

		$rating = $product->get_average_rating();

	} else {

		$rating = $product->get_rating_html();

	}
}
?>
<li class="de-widget-product">
	<div class="de-widget-product__media">
		<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo apply_filters( 'dahz_framework_content_widget_product_thumbnail_html', $product->get_image() ); ?>
		</a>
	</div>
	<div class="de-widget-product__detail">
		<h6 class="de-widget-product__title uk-link-heading uk-margin-remove-bottom">
			<a class="uk-link" href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
				<?php echo apply_filters( 'dahz_framework_content_widget_product_title_html', $product->get_title() ); ?>
			</a>
		</h6>
		<?php
			if ( ! empty( $show_rating ) ) :

				if( function_exists('wc_get_rating_html') ){

					echo wc_get_rating_html( $rating );

				} else {

					if ( $rating ){

						echo apply_filters( 'dahz_framework_content_widget_product_rating_html', $rating );

					}

				}
			endif;
			echo '<p class="de-widget-product__price uk-margin-small-top">' . $product->get_price_html() . '</p>';
		?>
	</div>
</li>
