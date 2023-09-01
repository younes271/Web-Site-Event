<?php
/**
 * Share template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.13
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly
?>

<div class="yith-wcwl-share">
    <h4 class="yith-wcwl-share-title"><?php echo esc_html( $share_title ); ?></h4>
    <ul class="uk-grid-small" data-uk-margin="margin:uk-margin-large;" data-uk-grid>
        <?php if( $share_facebook_enabled ): ?>
            <li>
                <a data-uk-icon="facebook" target="_blank" class="facebook" href="https://www.facebook.com/sharer.php?s=100&amp;p%5Btitle%5D=<?php echo esc_attr( $share_link_title ) ?>&amp;p%5Burl%5D=<?php echo urlencode( $share_link_url ) ?>" title="<?php esc_attr_e( 'Facebook', 'kitring' ) ?>"></a>
            </li>
        <?php endif; ?>

        <?php if( $share_twitter_enabled ): ?>
            <li>
                <a data-uk-icon="twitter" target="_blank" class="twitter" href="https://twitter.com/share?url=<?php echo urlencode( $share_link_url ) ?>&amp;text=<?php echo esc_attr( $share_twitter_summary ) ?>" title="<?php esc_attr_e( 'Twitter', 'kitring' ) ?>"></a>
            </li>
        <?php endif; ?>

        <?php if( $share_pinterest_enabled ): ?>
            <li>
                <a data-uk-icon="pinterest" target="_blank" class="pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( $share_link_url ) ?>&amp;description=<?php echo esc_attr( $share_summary ) ?>&amp;media=<?php echo esc_attr( $share_image_url ) ?>" title="<?php esc_attr_e( 'Pinterest', 'kitring' ) ?>" onclick="window.open(this.href); return false;"></a>
            </li>
        <?php endif; ?>

        <?php if( $share_googleplus_enabled ): ?>
            <li>
                <a data-uk-icon="google-plus" target="_blank" class="googleplus" href="https://plus.google.com/share?url=<?php echo urlencode( $share_link_url ) ?>&amp;title=<?php echo esc_attr( $share_link_title ) ?>" title="<?php esc_attr_e( 'Google+', 'kitring' ) ?>" onclick='javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'></a>
            </li>
        <?php endif; ?>

        <?php if( $share_email_enabled ): ?>
            <li>
                <a data-uk-icon="mail" class="email" href="mailto:?subject=<?php echo urlencode( apply_filters( 'yith_wcwl_email_share_subject', $share_link_title ) )?>&amp;body=<?php echo apply_filters( 'yith_wcwl_email_share_body', urlencode( $share_link_url ) ) ?>&amp;title=<?php echo esc_attr( $share_link_title ) ?>" title="<?php esc_attr_e( 'Email', 'kitring' ) ?>"></a>
            </li>
        <?php endif; ?>
    </ul>
</div>