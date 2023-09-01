<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$class = array('product_item', 'grid-item', 'product');


$loop_index 	= wc_get_loop_prop('loop', 0);
$item_sizes     = wc_get_loop_prop('item_sizes', array());
$item_w         = 1;
$item_h         = 1;

$tmp_count = count($item_sizes);

if($loop_index >= $tmp_count){
    if($tmp_count > 0){
        $loop_index2 = $loop_index%$tmp_count;
    }
    else{
        $loop_index2 = $loop_index - $tmp_count;
    }
}
else{
	$loop_index2 = $loop_index;
}

if(!empty($item_sizes[$loop_index2]['w']) && ( $_tmp_size = $item_sizes[$loop_index2]['w'] )){
    $item_w = $_tmp_size;
}
if(!empty($item_sizes[$loop_index2]['h']) && ( $_tmp_size = $item_sizes[$loop_index2]['h'] )){
    $item_h = $_tmp_size;
}



?>
<li <?php wc_product_class( $class, get_the_ID() ); ?> data-width="<?php echo esc_attr($item_w);?>" data-height="<?php echo esc_attr($item_h);?>">
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>
	<div class="product_item--inner">
		<div class="product_item--thumbnail">
			<div class="product_item--thumbnail-holder">
				<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook.
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked Mgana_WooCommerce::add_second_thumbnail_to_loop - 15
				 * 
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
			</div>
			<div class="product_item_thumbnail_action product_item--action">
				<?php
				/**
				 * mgana/action/shop_loop_item_action hook.
				 */
				do_action('mgana/action/shop_loop_item_action_top');
				?>
			</div>
            <?php
                do_action('mgana/action/add_count_up_timer_in_product_listing');
            ?>
		</div>
		<div class="product_item--info">
			<div class="product_item--info-inner">
				<?php
				/**
				 * woocommerce_shop_loop_item_title hook.
				 *
				 */
				do_action( 'woocommerce_shop_loop_item_title' );

				/**
				 * woocommerce_after_shop_loop_item_title hook.
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 * @hooked Mgana_WooCommerce::shop_loop_item_excerpt - 11
				 * @hooked Mgana_WooCommerce::render_attribute_in_list - 15
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
			</div>
			<div class="product_item--info-action product_item--action">
				<?php
				/**
				 * mgana/action/shop_loop_item_action hook.
				 *
				 */
				do_action('mgana/action/shop_loop_item_action');
				?>
			</div>
		</div>
	</div>
    <?php

    /**
     * woocommerce_after_shop_loop_item hook.
     */
    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
</li>
