<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; ?>

<li>
	<div class="product-img">
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo $product->get_image(); ?>
		</a>
	</div>
	<div class="product-content">
		<a class="product-title" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo $product->get_title(); ?>
		</a>
		
		<?php if ( ! empty( $show_rating ) ) : ?>
			<?php echo $product->get_rating_html(); ?>
		<?php endif; ?>
		<div class="price">
			<?php echo $product->get_price_html(); ?>
		</div>
		<div class="widget_add_to_cart">
			<?php
            echo apply_filters( 'woocommerce_loop_add_to_cart_link',
				sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					esc_attr( $product->get_id() ),
					esc_attr( $product->get_sku() ),
					esc_attr( isset( $class ) ? $class : 'button' ),
					esc_html( $product->add_to_cart_text() )
				),
			$product );
            ?>
		</div>
	</div>
</li>
