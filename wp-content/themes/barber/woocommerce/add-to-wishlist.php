<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

global $product;
?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($product_id) ?>">
	<?php if( ! ( $disable_wishlist && ! is_user_logged_in() ) ): ?>
	    <div class="yith-wcwl-add-button <?php echo ( $exists && ! $available_multi_wishlist ) ? 'hide': 'show' ?>" style="display:<?php echo ( $exists && ! $available_multi_wishlist ) ? 'none': 'block' ?>">

	        <?php yith_wcwl_get_template( 'add-to-wishlist-' . $template_part . '.php', $atts ); ?>

	    </div>

	    <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
	        <a data-toggle="tooltip" data-original-title="<?php echo esc_attr__('wishlist','barber');?>" href="<?php echo esc_url( $wishlist_url )?>" rel="nofollow">
	        </a>
	    </div>

	    <div class="yith-wcwl-wishlistexistsbrowse <?php echo ( $exists && ! $available_multi_wishlist ) ? 'show' : 'hide' ?>" style="display:<?php echo ( $exists && ! $available_multi_wishlist ) ? 'block' : 'none' ?>">
	        <a data-toggle="tooltip" data-original-title="<?php echo esc_attr__('wishlist','barber');?>" href="<?php echo esc_url( $wishlist_url ) ?>" rel="nofollow">
	        </a>
	    </div>

	    <div style="clear:both"></div>
	    <div class="yith-wcwl-wishlistaddresponse"></div>
	<?php else: ?>
		<a data-toggle="tooltip" data-original-title="<?php echo esc_attr__('wishlist','barber');?>" href="<?php echo esc_url( add_query_arg( array( 'wishlist_notice' => 'true', 'add_to_wishlist' => $product_id ), get_permalink( wc_get_page_id( 'myaccount' ) ) ) )?>" rel="nofollow" class="<?php echo str_replace( 'add_to_wishlist', '', $link_classes ) ?>" >
			<?php echo wp_kses($icon, apr_allow_html()); ?>
			<?php echo wp_kses($label, apr_allow_html()); ?>
		</a>
	<?php endif; ?>

</div>