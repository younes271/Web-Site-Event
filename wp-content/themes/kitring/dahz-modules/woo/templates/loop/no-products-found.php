<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$home_page_content_block = dahz_framework_get_option( 'shop_woo_element_replace_homepage_content' );

?>
<?php if( is_shop() && !empty( $home_page_content_block ) && !wc_get_loop_prop( 'is_search' ) && !wc_get_loop_prop( 'is_filtered' ) ):?>
	<?php echo dahz_framework_do_content_block( apply_filters( 'dahz_framework_override_shop_content', $home_page_content_block ) );?>
<?php else :?>
	<p class="woocommerce-info"><?php _e( 'No products were found matching your selection.', 'kitring' ); ?></p>
<?php endif;?>
