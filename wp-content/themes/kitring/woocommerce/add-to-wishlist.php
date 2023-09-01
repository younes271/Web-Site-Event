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
$icon = !empty( $icon ) ? '' : '';
$label_added = $product_added_text .' '. apply_filters( 'yith-wcwl-browse-label', $browse_wishlist_text );
$label_existed = $already_in_wishslist_text .' '. apply_filters( 'yith-wcwl-browse-label', $browse_wishlist_text );
$is_show = ( $exists && ! $available_multi_wishlist );
?>
<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr( $product_id ) ?>">
	<?php if( ! ( $disable_wishlist && ! is_user_logged_in() ) ): ?>
		<div class="yith-wcwl-add-button <?php echo ! empty( $is_show  ) ? 'hide': 'show' ?>" style="display:<?php echo ! empty( $is_show  ) ? 'none': 'block' ?>">
			<?php yith_wcwl_get_template( 'add-to-wishlist-' . $template_part . '.php', $atts ); ?>
		</div>
		<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
			<a class="button de-product__item--add-to-cart-button" aria-label="<?php echo esc_attr( $label_added ); ?>" data-uk-icon="df_wishlist-fill" href="<?php echo esc_url( $wishlist_url )?>" rel="nofollow" title="<?php echo esc_attr( $label_added ); ?>" uk-tooltip="pos: left;animation: false;cls: de-product-thumbnail__tooltip">
				<?php echo apply_filters( 'dahz_framework_wishlist_icon', $icon ); ?>
				<span><?php echo esc_html( $label_added ); ?></span>
			</a>
		</div>
		<div class="yith-wcwl-wishlistexistsbrowse <?php echo ! empty( $is_show  ) ? 'show' : 'hide' ?>" style="display:<?php echo ! empty( $is_show  ) ? 'block' : 'none' ?>">
			<a class="button de-product__item--add-to-cart-button" aria-label="<?php echo esc_attr( $label_existed ); ?>" data-uk-icon="df_wishlist-fill" href="<?php echo esc_url( $wishlist_url ) ?>" rel="nofollow" title="<?php echo esc_attr( $label_existed ); ?>" uk-tooltip="pos: left;animation: false;cls: de-product-thumbnail__tooltip">
				<?php echo apply_filters( 'dahz_framework_wishlist_icon', $icon ); ?>
				<span><?php echo esc_html( $label_existed ); ?></span>
			</a>
		</div>
		<div style="clear:both"></div>
		<div class="yith-wcwl-wishlistaddresponse"></div>
	<?php else: ?>
		<a aria-label="<?php echo esc_attr( $label ); ?>" data-uk-icon="df_wishlist-fill" href="<?php echo esc_url( add_query_arg( array( 'wishlist_notice' => 'true', 'add_to_wishlist' => $product_id ), get_permalink( wc_get_page_id( 'myaccount' ) ) ) )?>" rel="nofollow" class="button de-product__item--add-to-cart-button <?php echo esc_attr( str_replace( 'add_to_wishlist asd', '', $link_classes ) );?>" title="<?php echo esc_attr( $label ); ?>" uk-tooltip="pos: left;animation: false;cls: de-product-thumbnail__tooltip">
			<?php echo apply_filters( 'dahz_framework_wishlist_icon', $icon ); ?>
			<span><?php echo esc_html( $label ); ?></span>
		</a>
	<?php endif; ?>
</div>