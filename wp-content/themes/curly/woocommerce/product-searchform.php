<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form role="search" method="get" class="mkdf-searchform searchform" id="searchform-<?php echo esc_attr(rand(0, 1000)); ?>" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text"><?php esc_html_e('Search for:', 'curly'); ?></label>
    <div class="input-holder clearfix">
        <input type="search" class="search-field" placeholder="<?php esc_attr_e('Product Search...', 'curly'); ?>" value="" name="s" title="<?php esc_attr_e('Search for:', 'curly'); ?>"/>
        <button type="submit" class="mkdf-search-submit <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ); ?>"><?php echo curly_mkdf_icon_collections()->renderIcon('fa-search', 'font_awesome'); ?></button>
        <input type="hidden" name="post_type" value="product"/>
    </div>
</form>