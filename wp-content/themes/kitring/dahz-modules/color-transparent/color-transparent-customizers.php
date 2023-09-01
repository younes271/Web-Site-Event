<?php

if ( !class_exists( 'Dahz_Framework_Modules_Color_Transparent_Customizer' ) ) {
	Class Dahz_Framework_Modules_Color_Transparent_Customizer extends Dahz_Framework_Customizer_Extend {
		public function dahz_framework_set_customizer() {
			$dv_field = array();

			$dv_field[] = array(
				'type'     => 'custom',
				'settings' => 'color_transparent_dark_title',
				'label'    => '',
				'default'  => '<div class="de-customizer-title">Dark</div>',
			);

			$dv_field[] = array(
				'type'      => 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'  => 'global_color_dark',
				'label'     => __( 'Global Dark Color', 'kitring' ),
				'default'   => '#000000',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
							'element'  => '.widget ul li, .widget.widget_search input.de-form-search, .widget.widget_search i, .widget.widget_tag_cloud .tagcloud a, .de-archive__content .de-social-share, .achilles .de-archive__item .de-social-share, .aleixo .de-archive__item:first-child .de-social-share, .alika .de-archive__item:first-child .de-social-share, .alfio .de-archive__item:first-child .de-social-share, .de-separator, table tbody tr, table tbody tr:nth-child(1), .de-single__section-social .de-social-share, .de-single__comments-area-item, .woocommerce-cart .entry-content .woocommerce table thead, .woocommerce-cart .entry-content .woocommerce table tbody tr.cart_item, .woocommerce-cart .entry-content .woocommerce .cart_totals h4, .woocommerce-cart .entry-content .woocommerce .cart_totals table tr, .woocommerce-cart .entry-content .woocommerce table tbody td.actions input#coupon_code, .woocommerce-cart .entry-content .woocommerce table tbody td.product-quantity input, .woocommerce-cart .entry-content .woocommerce table tbody .coupon h4, .woocommerce-cart .entry-content .woocommerce .cart-collaterals, .woocommerce form.woocommerce-shipping-calculator select, .woocommerce form.woocommerce-shipping-calculator input, form.woocommerce-checkout input:not(.de-btn), form.woocommerce-checkout table thead, form.woocommerce-checkout table tfoot tr, form.woocommerce-checkout .woocommerce-checkout-payment ul li, form.woocommerce-checkout .select2-container .select2-choice, form.woocommerce-checkout textarea, form.woocommerce-checkout .de-order-details, form.track_order input, .de-customer-account__option a, .de-account-registration input, .woocommerce-MyAccount-content input, .woocommerce-MyAccount-content .select2-container .select2-choice, .woocommerce-account .woocommerce-MyAccount-navigation > ul li.woocommerce-MyAccount-navigation-link, .woocommerce #reviews #review_form_wrapper, .woocommerce #reviews .comment-form-author input, .woocommerce #reviews .comment-form-email input, .widget.widget_archive select, .de-widget__aboutme, .widget.widget_categories select',
							'function' => 'css',
							'property' => 'border-color'
						),
					),
			);

			$dv_field[] = array(
				'type'      => 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'  => 'divider_color_dark',
				'label'     => __( 'Divider Dark Color', 'kitring' ),
				'default'   => '#000000',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.widget ul li, .widget.widget_search input.de-form-search, .widget.widget_search i, .widget.widget_tag_cloud .tagcloud a, .de-archive__content .de-social-share, .achilles .de-archive__item .de-social-share, .aleixo .de-archive__item:first-child .de-social-share, .alika .de-archive__item:first-child .de-social-share, .alfio .de-archive__item:first-child .de-social-share, .de-separator, table tbody tr, table tbody tr:nth-child(1), .de-single__section-social .de-social-share, .de-single__comments-area-item, .woocommerce-cart .entry-content .woocommerce table thead, .woocommerce-cart .entry-content .woocommerce table tbody tr.cart_item, .woocommerce-cart .entry-content .woocommerce .cart_totals h4, .woocommerce-cart .entry-content .woocommerce .cart_totals table tr, .woocommerce-cart .entry-content .woocommerce table tbody td.actions input#coupon_code, .woocommerce-cart .entry-content .woocommerce table tbody td.product-quantity input, .woocommerce-cart .entry-content .woocommerce table tbody .coupon h4, .woocommerce-cart .entry-content .woocommerce .cart-collaterals, .woocommerce form.woocommerce-shipping-calculator select, .woocommerce form.woocommerce-shipping-calculator input, form.woocommerce-checkout input:not(.de-btn), form.woocommerce-checkout table thead, form.woocommerce-checkout table tfoot tr, form.woocommerce-checkout .woocommerce-checkout-payment ul li, form.woocommerce-checkout .select2-container .select2-choice, form.woocommerce-checkout textarea, form.woocommerce-checkout .de-order-details, form.track_order input, .de-customer-account__option a, .de-account-registration input, .woocommerce-MyAccount-content input, .woocommerce-MyAccount-content .select2-container .select2-choice, .woocommerce-account .woocommerce-MyAccount-navigation > ul li.woocommerce-MyAccount-navigation-link, .woocommerce #reviews #review_form_wrapper, .woocommerce #reviews .comment-form-author input, .woocommerce #reviews .comment-form-email input, .widget.widget_archive select, .de-widget__aboutme, .widget.widget_categories select',
						'function' => 'css',
						'property' => 'border-color'
					),
				),
			);

			$dv_field[] = array(
				'type'      => 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'  => 'dot_nav_color_dark',
				'label'     => __( 'Dot Nav Dark Color', 'kitring' ),
				'default'   => '#000000',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.widget ul li, .widget.widget_search input.de-form-search, .widget.widget_search i, .widget.widget_tag_cloud .tagcloud a, .de-archive__content .de-social-share, .achilles .de-archive__item .de-social-share, .aleixo .de-archive__item:first-child .de-social-share, .alika .de-archive__item:first-child .de-social-share, .alfio .de-archive__item:first-child .de-social-share, .de-separator, table tbody tr, table tbody tr:nth-child(1), .de-single__section-social .de-social-share, .de-single__comments-area-item, .woocommerce-cart .entry-content .woocommerce table thead, .woocommerce-cart .entry-content .woocommerce table tbody tr.cart_item, .woocommerce-cart .entry-content .woocommerce .cart_totals h4, .woocommerce-cart .entry-content .woocommerce .cart_totals table tr, .woocommerce-cart .entry-content .woocommerce table tbody td.actions input#coupon_code, .woocommerce-cart .entry-content .woocommerce table tbody td.product-quantity input, .woocommerce-cart .entry-content .woocommerce table tbody .coupon h4, .woocommerce-cart .entry-content .woocommerce .cart-collaterals, .woocommerce form.woocommerce-shipping-calculator select, .woocommerce form.woocommerce-shipping-calculator input, form.woocommerce-checkout input:not(.de-btn), form.woocommerce-checkout table thead, form.woocommerce-checkout table tfoot tr, form.woocommerce-checkout .woocommerce-checkout-payment ul li, form.woocommerce-checkout .select2-container .select2-choice, form.woocommerce-checkout textarea, form.woocommerce-checkout .de-order-details, form.track_order input, .de-customer-account__option a, .de-account-registration input, .woocommerce-MyAccount-content input, .woocommerce-MyAccount-content .select2-container .select2-choice, .woocommerce-account .woocommerce-MyAccount-navigation > ul li.woocommerce-MyAccount-navigation-link, .woocommerce #reviews #review_form_wrapper, .woocommerce #reviews .comment-form-author input, .woocommerce #reviews .comment-form-email input, .widget.widget_archive select, .de-widget__aboutme, .widget.widget_categories select',
						'function' => 'css',
						'property' => 'border-color'
					),
				),
			);

			$dv_field[] = array(
				'type'      => 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'  => 'slide_nav_color_dark',
				'label'     => __( 'Slide Nav Dark Color', 'kitring' ),
				'default'   => '#000000',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.widget ul li, .widget.widget_search input.de-form-search, .widget.widget_search i, .widget.widget_tag_cloud .tagcloud a, .de-archive__content .de-social-share, .achilles .de-archive__item .de-social-share, .aleixo .de-archive__item:first-child .de-social-share, .alika .de-archive__item:first-child .de-social-share, .alfio .de-archive__item:first-child .de-social-share, .de-separator, table tbody tr, table tbody tr:nth-child(1), .de-single__section-social .de-social-share, .de-single__comments-area-item, .woocommerce-cart .entry-content .woocommerce table thead, .woocommerce-cart .entry-content .woocommerce table tbody tr.cart_item, .woocommerce-cart .entry-content .woocommerce .cart_totals h4, .woocommerce-cart .entry-content .woocommerce .cart_totals table tr, .woocommerce-cart .entry-content .woocommerce table tbody td.actions input#coupon_code, .woocommerce-cart .entry-content .woocommerce table tbody td.product-quantity input, .woocommerce-cart .entry-content .woocommerce table tbody .coupon h4, .woocommerce-cart .entry-content .woocommerce .cart-collaterals, .woocommerce form.woocommerce-shipping-calculator select, .woocommerce form.woocommerce-shipping-calculator input, form.woocommerce-checkout input:not(.de-btn), form.woocommerce-checkout table thead, form.woocommerce-checkout table tfoot tr, form.woocommerce-checkout .woocommerce-checkout-payment ul li, form.woocommerce-checkout .select2-container .select2-choice, form.woocommerce-checkout textarea, form.woocommerce-checkout .de-order-details, form.track_order input, .de-customer-account__option a, .de-account-registration input, .woocommerce-MyAccount-content input, .woocommerce-MyAccount-content .select2-container .select2-choice, .woocommerce-account .woocommerce-MyAccount-navigation > ul li.woocommerce-MyAccount-navigation-link, .woocommerce #reviews #review_form_wrapper, .woocommerce #reviews .comment-form-author input, .woocommerce #reviews .comment-form-email input, .widget.widget_archive select, .de-widget__aboutme, .widget.widget_categories select',
						'function' => 'css',
						'property' => 'border-color'
					),
				),
			);

			$dv_field[] = array(
				'type'     => 'custom',
				'settings' => 'color_transparent_light_title',
				'label'    => '',
				'default'  => '<div class="de-customizer-title">Light</div>',
			);

			$dv_field[] = array(
				'type'      => 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'  => 'global_color_light',
				'label'     => __( 'Global Light Color', 'kitring' ),
				'default'   => '#ffffff',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.widget ul li, .widget.widget_search input.de-form-search, .widget.widget_search i, .widget.widget_tag_cloud .tagcloud a, .de-archive__content .de-social-share, .achilles .de-archive__item .de-social-share, .aleixo .de-archive__item:first-child .de-social-share, .alika .de-archive__item:first-child .de-social-share, .alfio .de-archive__item:first-child .de-social-share, .de-separator, table tbody tr, table tbody tr:nth-child(1), .de-single__section-social .de-social-share, .de-single__comments-area-item, .woocommerce-cart .entry-content .woocommerce table thead, .woocommerce-cart .entry-content .woocommerce table tbody tr.cart_item, .woocommerce-cart .entry-content .woocommerce .cart_totals h4, .woocommerce-cart .entry-content .woocommerce .cart_totals table tr, .woocommerce-cart .entry-content .woocommerce table tbody td.actions input#coupon_code, .woocommerce-cart .entry-content .woocommerce table tbody td.product-quantity input, .woocommerce-cart .entry-content .woocommerce table tbody .coupon h4, .woocommerce-cart .entry-content .woocommerce .cart-collaterals, .woocommerce form.woocommerce-shipping-calculator select, .woocommerce form.woocommerce-shipping-calculator input, form.woocommerce-checkout input:not(.de-btn), form.woocommerce-checkout table thead, form.woocommerce-checkout table tfoot tr, form.woocommerce-checkout .woocommerce-checkout-payment ul li, form.woocommerce-checkout .select2-container .select2-choice, form.woocommerce-checkout textarea, form.woocommerce-checkout .de-order-details, form.track_order input, .de-customer-account__option a, .de-account-registration input, .woocommerce-MyAccount-content input, .woocommerce-MyAccount-content .select2-container .select2-choice, .woocommerce-account .woocommerce-MyAccount-navigation > ul li.woocommerce-MyAccount-navigation-link, .woocommerce #reviews #review_form_wrapper, .woocommerce #reviews .comment-form-author input, .woocommerce #reviews .comment-form-email input, .widget.widget_archive select, .de-widget__aboutme, .widget.widget_categories select',
						'function' => 'css',
						'property' => 'border-color'
					),
				),
			);

			$dv_field[] = array(
				'type'      => 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'  => 'divider_color_light',
				'label'     => __( 'Divider Light Color', 'kitring' ),
				'default'   => '#ffffff',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.widget ul li, .widget.widget_search input.de-form-search, .widget.widget_search i, .widget.widget_tag_cloud .tagcloud a, .de-archive__content .de-social-share, .achilles .de-archive__item .de-social-share, .aleixo .de-archive__item:first-child .de-social-share, .alika .de-archive__item:first-child .de-social-share, .alfio .de-archive__item:first-child .de-social-share, .de-separator, table tbody tr, table tbody tr:nth-child(1), .de-single__section-social .de-social-share, .de-single__comments-area-item, .woocommerce-cart .entry-content .woocommerce table thead, .woocommerce-cart .entry-content .woocommerce table tbody tr.cart_item, .woocommerce-cart .entry-content .woocommerce .cart_totals h4, .woocommerce-cart .entry-content .woocommerce .cart_totals table tr, .woocommerce-cart .entry-content .woocommerce table tbody td.actions input#coupon_code, .woocommerce-cart .entry-content .woocommerce table tbody td.product-quantity input, .woocommerce-cart .entry-content .woocommerce table tbody .coupon h4, .woocommerce-cart .entry-content .woocommerce .cart-collaterals, .woocommerce form.woocommerce-shipping-calculator select, .woocommerce form.woocommerce-shipping-calculator input, form.woocommerce-checkout input:not(.de-btn), form.woocommerce-checkout table thead, form.woocommerce-checkout table tfoot tr, form.woocommerce-checkout .woocommerce-checkout-payment ul li, form.woocommerce-checkout .select2-container .select2-choice, form.woocommerce-checkout textarea, form.woocommerce-checkout .de-order-details, form.track_order input, .de-customer-account__option a, .de-account-registration input, .woocommerce-MyAccount-content input, .woocommerce-MyAccount-content .select2-container .select2-choice, .woocommerce-account .woocommerce-MyAccount-navigation > ul li.woocommerce-MyAccount-navigation-link, .woocommerce #reviews #review_form_wrapper, .woocommerce #reviews .comment-form-author input, .woocommerce #reviews .comment-form-email input, .widget.widget_archive select, .de-widget__aboutme, .widget.widget_categories select',
						'function' => 'css',
						'property' => 'border-color'
					),
				),
			);

			$dv_field[] = array(
				'type'      => 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'  => 'dot_nav_color_light',
				'label'     => __( 'Dot Nav Light Color', 'kitring' ),
				'default'   => '#ffffff',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.widget ul li, .widget.widget_search input.de-form-search, .widget.widget_search i, .widget.widget_tag_cloud .tagcloud a, .de-archive__content .de-social-share, .achilles .de-archive__item .de-social-share, .aleixo .de-archive__item:first-child .de-social-share, .alika .de-archive__item:first-child .de-social-share, .alfio .de-archive__item:first-child .de-social-share, .de-separator, table tbody tr, table tbody tr:nth-child(1), .de-single__section-social .de-social-share, .de-single__comments-area-item, .woocommerce-cart .entry-content .woocommerce table thead, .woocommerce-cart .entry-content .woocommerce table tbody tr.cart_item, .woocommerce-cart .entry-content .woocommerce .cart_totals h4, .woocommerce-cart .entry-content .woocommerce .cart_totals table tr, .woocommerce-cart .entry-content .woocommerce table tbody td.actions input#coupon_code, .woocommerce-cart .entry-content .woocommerce table tbody td.product-quantity input, .woocommerce-cart .entry-content .woocommerce table tbody .coupon h4, .woocommerce-cart .entry-content .woocommerce .cart-collaterals, .woocommerce form.woocommerce-shipping-calculator select, .woocommerce form.woocommerce-shipping-calculator input, form.woocommerce-checkout input:not(.de-btn), form.woocommerce-checkout table thead, form.woocommerce-checkout table tfoot tr, form.woocommerce-checkout .woocommerce-checkout-payment ul li, form.woocommerce-checkout .select2-container .select2-choice, form.woocommerce-checkout textarea, form.woocommerce-checkout .de-order-details, form.track_order input, .de-customer-account__option a, .de-account-registration input, .woocommerce-MyAccount-content input, .woocommerce-MyAccount-content .select2-container .select2-choice, .woocommerce-account .woocommerce-MyAccount-navigation > ul li.woocommerce-MyAccount-navigation-link, .woocommerce #reviews #review_form_wrapper, .woocommerce #reviews .comment-form-author input, .woocommerce #reviews .comment-form-email input, .widget.widget_archive select, .de-widget__aboutme, .widget.widget_categories select',
						'function' => 'css',
						'property' => 'border-color'
					),
				),
			);

			$dv_field[] = array(
				'type'      => 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'  => 'slide_nav_color_light',
				'label'     => __( 'Slide Nav Light Color', 'kitring' ),
				'default'   => '#ffffff',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.widget ul li, .widget.widget_search input.de-form-search, .widget.widget_search i, .widget.widget_tag_cloud .tagcloud a, .de-archive__content .de-social-share, .achilles .de-archive__item .de-social-share, .aleixo .de-archive__item:first-child .de-social-share, .alika .de-archive__item:first-child .de-social-share, .alfio .de-archive__item:first-child .de-social-share, .de-separator, table tbody tr, table tbody tr:nth-child(1), .de-single__section-social .de-social-share, .de-single__comments-area-item, .woocommerce-cart .entry-content .woocommerce table thead, .woocommerce-cart .entry-content .woocommerce table tbody tr.cart_item, .woocommerce-cart .entry-content .woocommerce .cart_totals h4, .woocommerce-cart .entry-content .woocommerce .cart_totals table tr, .woocommerce-cart .entry-content .woocommerce table tbody td.actions input#coupon_code, .woocommerce-cart .entry-content .woocommerce table tbody td.product-quantity input, .woocommerce-cart .entry-content .woocommerce table tbody .coupon h4, .woocommerce-cart .entry-content .woocommerce .cart-collaterals, .woocommerce form.woocommerce-shipping-calculator select, .woocommerce form.woocommerce-shipping-calculator input, form.woocommerce-checkout input:not(.de-btn), form.woocommerce-checkout table thead, form.woocommerce-checkout table tfoot tr, form.woocommerce-checkout .woocommerce-checkout-payment ul li, form.woocommerce-checkout .select2-container .select2-choice, form.woocommerce-checkout textarea, form.woocommerce-checkout .de-order-details, form.track_order input, .de-customer-account__option a, .de-account-registration input, .woocommerce-MyAccount-content input, .woocommerce-MyAccount-content .select2-container .select2-choice, .woocommerce-account .woocommerce-MyAccount-navigation > ul li.woocommerce-MyAccount-navigation-link, .woocommerce #reviews #review_form_wrapper, .woocommerce #reviews .comment-form-author input, .woocommerce #reviews .comment-form-email input, .widget.widget_archive select, .de-widget__aboutme, .widget.widget_categories select',
						'function' => 'css',
						'property' => 'border-color'
					),
				),
			);

			return $dv_field;
		}
	}
}