<?php

if ( !class_exists( 'Dahz_Framework_Color_Shop' ) ) {

	Class Dahz_Framework_Color_Shop{

		public function __construct() {

			add_action( 'dahz_framework_module_color-shop_init', array( $this, 'dahz_framework_color_shop_init' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_shop_color_style' ) );

		}

		public function dahz_framework_color_shop_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/color-shop-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Color_Shop_Customizer',
				array(
					'id'	=> 'color_shop',
					'title' => array( 'title' => esc_html__( 'Shop', 'kitring' ), 'priority' => 3 ),
					'panel'	=> 'color'
				),
				array()
			);

		}

		public function dahz_framework_shop_color_style( $default_styles ) {
			$shop_success	= dahz_framework_get_option(
				'color_shop_success_color',
				array(
					'background'	=> '#333333',
					'text'			=> '#999999'
				)
			);
			$shop_success_bg	= $shop_success['background'];
			$shop_success_text	= $shop_success['text'];

			$shop_info	= dahz_framework_get_option(
				'color_shop_info_color',
				array(
					'background'	=> '#333333',
					'text'			=> '#999999'
				)
			);
			$shop_info_bg		= $shop_info['background'];
			$shop_info_text		= $shop_info['text'];

			$shop_alert	= dahz_framework_get_option(
				'color_shop_alert_color',
				array(
					'background'	=> '#333333',
					'text'			=> '#999999'
				)
			);
			$shop_alert_bg		= $shop_alert['background'];
			$shop_alert_text	= $shop_alert['text'];

			$shop_sale	= dahz_framework_get_option(
				'color_shop_sale_color',
				array(
					'background'	=> '#333333',
					'text'			=> '#999999'
				)
			);
			$shop_sale_bg		= $shop_sale['background'];
			$shop_sale_text		= $shop_sale['text'];

			$shop_new	= dahz_framework_get_option(
				'color_shop_new_color',
				array(
					'background'	=> '#333333',
					'text'			=> '#999999'
				)
			);
			$shop_new_bg		= $shop_new['background'];
			$shop_new_text		= $shop_new['text'];

			$star_color	= dahz_framework_get_option(
				'color_shop_star_color',
				array(
					'normal'	=> '#333333',
					'hover'		=> '#999999'
				)
			);
			$star_color_text	= $star_color['normal'];
			$star_color_hover	= $star_color['hover'];

			$default_styles	.= sprintf(
				'
				.woocommerce-message.success{
					background-color: %1$s;
					color: %2$s;
				}
				.woocommerce-info.notice {
					background-color: %12$s;
					color: %3$s;
				}

				.uk-notification .uk-notification-message .de-notices__error svg {
					fill: %3$s;
				}

				.woocommerce-Message--info h5,
				.woocommerce-Message--info a,
				.woocommerce-store-notice.demo_store a {
					color: %3$s;
				}
				.woocommerce-error .woocommerce-message {
					background-color: %4$s;
					color: %5$s;
				}

				.de-product-thumbnail__badges-wording.sale,
				.de-product-single__badge.sale {
					background-color: %10$s;
					color: %6$s;
				}
				.woocommerce p.stars.selected a.active ~ a:before,
				.woocommerce p.stars a:before,
				.woocommerce p.stars a:hover ~ a:before,
				.star-rating:before {
					color: %8$s;
				}
				.star-rating span:before,
				.woocommerce p.stars.selected a:not(.active):before,
				.woocommerce p.stars.selected a.active:before,
				.woocommerce p.stars:hover a:before {
					color: %9$s;
				}
				',
				$shop_success_bg,
				$shop_success_text,
				$shop_info_text,
				$shop_alert_bg,
				$shop_alert_text,
				$shop_sale_text,
				$shop_new_text,
				$star_color_text,
				$star_color_hover,
				$shop_sale_bg,
				$shop_new_bg,
				$shop_info_bg
			);

			return $default_styles;

		}

	}

	new Dahz_Framework_Color_Shop();

}