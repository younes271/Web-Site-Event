<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/

 * @package 	WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enableWooSingleRelated		= dahz_framework_get_option( 'single_woo_is_show_related_product', false );
$WooSingleRelatedTitle		= dahz_framework_get_option( 'single_woo_related_title' );

$WooSingleRelatedDesktopCol = dahz_framework_get_option( 'single_woo_related_desktop_column', '1-4' );
$WooSingleRelatedTabCol		= dahz_framework_get_option( 'single_woo_related_tablet_column', '1-4' );
$WooSingleLandscapeCol		= dahz_framework_get_option( 'single_woo_related_phone_landscape_column', '3-5' );
$WooSingleMobileCol			= dahz_framework_get_option( 'single_woo_related_phone_potrait_column', '3-5' );

if ( $enableWooSingleRelated === false )
	return '';

dahz_framework_override_static_option( array(
	'loop_product_class' => "uk-width-{$WooSingleMobileCol} uk-width-{$WooSingleLandscapeCol}@s uk-width-{$WooSingleRelatedTabCol}@m uk-width-{$WooSingleRelatedDesktopCol}@l"
) );

if ( $related_products ) : ?>

	<section class="related products uk-position-relative uk-position-z-index uk-slider uk-visible-toggle" data-uk-slider>

		<div class="uk-slider-container">

			<hr class="uk-margin-medium uk-margin-medium-top" />
	
			<h4>
				<?php if( !empty( $WooSingleRelatedTitle ) ):?>
					<?php echo apply_filters( 'dahz_framework_related_title', $WooSingleRelatedTitle );?>
				<?php else:?>
					<?php esc_html_e( 'Related products', 'kitring' ) ?>
				<?php endif;?>
			</h4>
	
			<?php woocommerce_product_loop_start(); ?>
	
				<?php foreach ( $related_products as $related_product ) : ?>
	
					<?php
						 $post_object = get_post( $related_product->get_id() );
	
						setup_postdata( $GLOBALS['post'] =& $post_object );
	
						wc_get_template_part( 'content', 'product' ); ?>
	
				<?php endforeach; ?>
	
			<?php woocommerce_product_loop_end(); ?>
		
			<div class="uk-slidenav-container">
				<a class="uk-position-center-left uk-position-small uk-hidden-hover uk-slidenav-previous uk-icon uk-slidenav" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
				<a class="uk-position-center-right uk-position-small uk-hidden-hover uk-slidenav-next uk-icon uk-slidenav" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
			</div>
		</div>

	</section>

<?php endif;

wp_reset_postdata();

dahz_framework_override_static_option( array(
	'loop_product_class' => ""
) );