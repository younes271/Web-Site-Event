<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
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
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Setup fullwidth shop area
$is_fullwidth = dahz_framework_get_option( 'shop_woo_is_full_archive', false );

$home_page_content_block = dahz_framework_get_option( 'shop_woo_element_replace_homepage_content' );

$wrapper_classes  = 'uk-container ';

$wrapper_classes .= $is_fullwidth ? 'uk-container-expand' : '';

// Setup sidebar shop area
$sidebar = dahz_framework_get_option( 'shop_woo_filter_sidebar_area', true );

$main_classes = $sidebar == 'sidebar' && dahz_framework_get_static_option( 'enable_sidebar' ) ? 'uk-width-2-3@m' : 'uk-width-1-1@m';

$is_sidebar = $sidebar == 'sidebar' && dahz_framework_get_static_option( 'enable_sidebar' ) ? 'uk-flex uk-flex-between' : '';

?>
<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
	<div class="de-shop uk-position-relative uk-grid <?php echo esc_attr( $is_sidebar ) ?>" data-uk-grid>
		<div id="de-content-render" class="ds-content-main de-main-content <?php echo esc_attr( $main_classes ); ?>">
			<?php if( is_shop() && !empty( $home_page_content_block ) && !wc_get_loop_prop( 'is_search' ) && !wc_get_loop_prop( 'is_filtered' ) ):?>

			<?php else:?>
			<div class="de-shop__menu">
				<ul class="de-shop__toolbar">
					<li><?php woocommerce_result_count(); ?></li>
					<li><?php dahz_framework_render_product_view_all(); ?></li>
				</ul>
				<ul class="de-shop__filter">
					<li><?php woocommerce_catalog_ordering(); ?></li>
				</ul>
			</div>
			<?php endif;?>
