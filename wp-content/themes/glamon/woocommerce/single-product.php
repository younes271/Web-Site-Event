<?php
/**
 * Template Single Product
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header( 'shop' ); ?>

	<?php if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
		<!-- wraper_shop_single -->
		<div class="wraper_shop_single style-two">
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<!-- START SHOP SINGLE CONTENT -->
						<?php get_template_part( 'woocommerce/shop-details-box/shop-details-box-style-two', 'none' ); ?>
						<!-- END SHOP SINGLE CONTENT -->
					</div>
				</div>
				<!-- row -->
			</div>
		</div>
		<!-- wraper_shop_single -->
	<?php } else { ?>
		<!-- wraper_shop_single -->
		<div class="wraper_shop_single <?php echo esc_html( glamon_global_var( 'shop-details-style', '', false ) ); ?>">
			<div class="container">
				<!-- row -->
				<div class="row">
					<?php if ( 'shop-details-nosidebar' === glamon_global_var( 'shop-details-sidebar', '', false ) ) { ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<?php } else { ?>
						<?php if ( 'shop-details-leftsidebar' === glamon_global_var( 'shop-details-sidebar', '', false ) ) { ?>
							<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 pull-right">
						<?php } elseif ( 'shop-details-rightsidebar' === glamon_global_var( 'shop-details-sidebar', '', false ) ) { ?>
							<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 pull-left">
						<?php } else { ?>
							<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
						<?php } ?>
					<?php } ?>

						<!-- START SHOP SINGLE CONTENT -->
						<?php
						if ( ! empty( glamon_global_var( 'shop-details-style', '', false ) ) ) {
							get_template_part( 'woocommerce/shop-details-box/shop-details-box', glamon_global_var( 'shop-details-style', '', false ) );
						} else {
							get_template_part( 'woocommerce/shop-details-box/shop-details-box-style-one', 'none' );
						}
						?>
						<!-- END SHOP SINGLE CONTENT -->

						</div>
					<?php if ( 'shop-details-nosidebar' === glamon_global_var( 'shop-details-sidebar', '', false ) ) { ?>
					<?php } else { ?>
						<?php if ( 'shop-details-leftsidebar' === glamon_global_var( 'shop-details-sidebar', '', false ) ) { ?>
							<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 pull-left">
						<?php } elseif ( 'shop-details-rightsidebar' === glamon_global_var( 'shop-details-sidebar', '', false ) ) { ?>
							<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 pull-right">
						<?php } else { ?>
							<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<?php } ?>
							<aside id="secondary" class="widget-area">
							<?php
								/**
								 * Sidebar
								 */
								dynamic_sidebar( 'radiantthemes-product-sidebar' );
							?>
							</aside>
						</div>
					<?php } ?>
				</div>
				<!-- row -->
			</div>
		</div>
		<!-- wraper_shop_single -->
	<?php } ?>

<?php
get_footer( 'shop' );
