<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly

global $product;
?>

<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-product-id="<?php echo esc_attr($product_id) ?>" data-product-type="<?php echo esc_attr($product_type)?>" class="<?php echo esc_attr($link_classes) ?>" data-toggle="tooltip" data-original-title="<?php echo esc_attr__('add wishlist','barber');?>">
    <?php echo wp_kses($icon, apr_allow_html()); ?>
</a>
<img src="<?php echo esc_url( get_template_directory_uri() . '/images/ajax-loader.gif' ) ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />