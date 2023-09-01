<?php
/**
 * Shop Box Style Three Template
 *
 * @package glamon
 */

global $product;
?>

<!-- radiantthemes-shop-box style-three -->
<div <?php post_class( 'radiantthemes-shop-box matchHeight style-three' ); ?>>
	<div class="holder">
		<div class="pic">
			<a class="product-image" href="<?php the_permalink(); ?>" style="background-image:url(<?php esc_url( the_post_thumbnail_url( 'large' ) ); ?>)"></a>
		</div>
		<div class="data">
			<?php if ( $product->is_on_sale() ) { ?>
				<?php echo wp_kses_post( apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'glamon' ) . '</span>', $post, $product ) ); ?>
			<?php } ?>
			<?php
			/**
			 * Woocommerce Before Shop Loop Item hook.
			 * woocommerce_before_shop_loop_item hook.
			 *
			 * @hooked woocommerce_template_loop_product_link_open - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item' );
			?>
			<?php
			/**
			 * Woocommerce Shop Loop Item Title hook.
			 * woocommerce_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );
			?>
			</a>
			<div class="info-box">
				<?php
				/**
				 * Woocommerce After Shop Loop Item Title hook.
				 * woocommerce_after_shop_loop_item_title hook.
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
				<div class="action-buttons">
					<?php
					/**
					 * Woocommerce After Shop Loop Item hook.
					 * woocommerce_after_shop_loop_item hook.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item' );
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- radiantthemes-shop-box style-three -->
