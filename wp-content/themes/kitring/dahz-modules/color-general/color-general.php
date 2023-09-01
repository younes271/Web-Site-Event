<?php

if ( !class_exists( 'Dahz_Framework_Color_General' ) ) {
	
	Class Dahz_Framework_Color_General{
		
		static $opacity = array(
			'0.3'	=> '4C',
			'0.1' 	=> '19',
			'0'		=> '00',
			'0.5'	=> '7F',
			'0.85'	=> 'D8',
			'0.9'	=> 'E5',
			'0.95'	=> 'F2'
		);

		public function __construct() {
			
			add_action( 'dahz_framework_module_color-general_init', array( $this, 'dahz_framework_color_general_init' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_general_color_style' ) );
			
			add_filter( 'dahz_framework_css_styles', array( $this, 'dahz_framework_hover_style' ) );
		
		}

		public function dahz_framework_color_general_init( $path ) {
			
			if ( is_customize_preview() ) dahz_framework_include( $path . '/color-general-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Color_General_Customizer',
				array(
					'id'	=> 'color_general',
					'title'	=> array( 'title' => esc_html__( 'General', 'kitring' ), 'priority' => 1 ),
					'panel'	=> array(
						'id'			=> 'color',
						'title'			=> esc_html__('Color', 'kitring' ),
						'description'	=> '',
						'priority'		=> 5,
					)
				),
				array()
			);
			
		}

		public function dahz_framework_general_color_style( $default_styles ) {
			
			$main_accent_color = dahz_framework_get_option(
				"color_general_main_accent_color_regular",
				array(
					'regular'	=> '#333333',
					'hover'		=> '#999999'
				)
			);

			$main_accent_color_regular = !empty( $main_accent_color['regular'] ) ? $main_accent_color['regular'] : '#333333';

			$main_accent_color_hover = !empty( $main_accent_color['hover'] ) ? $main_accent_color['hover'] : '#999999';

			$pagination_text_color = dahz_framework_get_option( 'color_general_pagination_text_color', '#000000' );

			$pagination_text_color_active = dahz_framework_get_option( 'color_general_pagination_text_color_active', '#ffffff' );
			
			$pagination_bg_color_active = dahz_framework_get_option ( 'color_general_pagination_bg_color_active', '#ffffff' );
			
			$pagination_bg_color_hover = dahz_framework_get_option( 'color_general_pagination_bg_color_hover', '#000000' );

			$pagination_border_color = dahz_framework_get_option( 'color_general_pagination_border_color', '#000000' );

			$body_text_color = dahz_framework_get_option( 'color_general_body_text_color', '#000000' );

			$heading_text_color = dahz_framework_get_option( 'color_general_heading_text_color', '#000000' );

			$extra_color = $main_accent_color_regular;

			$divider_color = dahz_framework_get_option( 'color_general_divider_color', '#000000' );

			$widget_title_color = dahz_framework_get_option( 'color_general_general_widget_title_color', '#000000' );

			$slide_nav_color = dahz_framework_get_option( 'color_general_slide_nav_color', '#000000' );

			$dot_nav_color = dahz_framework_get_option( 'color_general_dot_nav_color', '#000000' );

			$light_color = dahz_framework_get_option( 'color_transparent_global_color_light', '#fff' );

			# Divider
			$default_styles .= sprintf(
				'
				hr,
				figcaption,
				.achilles .de-archive .entry-social,
				.achilles .de-archive .entry-content,
				.agata .de-archive .entry-wrapper::after,
				.agneta .de-archive .entry-wrapper::after,
				.aleixo .de-archive .entry-item:first-child .entry-social,
				.aleixo .de-archive .entry-wrapper::after,
				.alika .uk-width-1-1\@m .de-archive .entry-item:first-child .entry-social,
				.alika .uk-width-1-1\@m .de-archive .entry-item:first-child .entry-wrapper,
				.alfio .de-archive .entry-item:first-child .entry-social,
				.alfio .de-archive .entry-wrapper::after,
				.de-single__social,
				.de-single__navigation > div > h6,
				.de-single__navigation > div > h6 + div {
					border-color: %1$s;
				}
				',
				$divider_color
			);

			$default_styles .= sprintf(
				'
				body,
				select,
				.de-myaccount__navigation .uk-button:not(:disabled),
				.uk-offcanvas-bar {
					color:%1$s;
				}
				#header-section1.de-header__section .delete-item.uk-icon,
				#header-section1.de-header__section .delete-item.uk-icon *,
				#header-section2.de-header__section .delete-item.uk-icon,
				#header-section2.de-header__section .delete-item.uk-icon *,
				#header-section3.de-header__section .delete-item.uk-icon,
				#header-section3.de-header__section .delete-item.uk-icon * {
					color: %1$s!important;
				}

				#header-section1.de-header__section .de-header__mini-cart--as-dropdown *:not(.uk-button):not(.uk-icon):not(svg):not(path),
				#header-section2.de-header__section .de-header__mini-cart--as-dropdown *:not(.uk-button):not(.uk-icon):not(svg):not(path),
				#header-section3.de-header__section .de-header__mini-cart--as-dropdown *:not(.uk-button):not(.uk-icon):not(svg):not(path) {
					color: %1$s!important;
				}
				.de-page--transition-loader-2 .pace .pace-activity,
				.de-page--transition-loader-3 .pace .pace-activity {
					border-top-color: %2$s;
					border-left-color: %2$s;
				}
				ul.de-myaccount__form-login-signup__tab li.uk-active:after,
				.de-product-single .de-tabs ul.tabs li.uk-active:after,
				.de-account-content--dropdown .de-account-content__tab li.uk-active a:after {
					border-color: %2$s;
				}

				.de-shop__menu form::before {
					border-left-color: transparent;
					border-right-color: transparent;
					border-top-color: %2$s;
				}
				@media screen and (max-width: 768px) {
					.de-shop__menu form::before {
						border-color: %13$s;
					}
				}

				.de-page--transition-loader-1 .pace .pace-progress,
				.de-page--transition-loader-2 .pace .pace-progress,
				.de-page--transition-loader-4 .pace .pace-progress,
				.uk-radio:checked:after,
				.uk-checkbox:checked:after,
				.widget_price_filter .ui-slider .ui-slider-range {
					background-color: %2$s;
				}
				.de-single__navigation--arrow h6 span,
				.uk-offcanvas-bar a:not(.de-mini-cart__button),
				blockquote svg,
				.widget.widget_calendar tbody #today {
					color:%2$s;
				}
				#header-section1.de-header__section .de-header__mini-cart--as-dropdown a:not(.uk-button):not(.uk-icon):not(svg):not(path),
				#header-section2.de-header__section .de-header__mini-cart--as-dropdown a:not(.uk-button):not(.uk-icon):not(svg):not(path),
				#header-section3.de-header__section .de-header__mini-cart--as-dropdown a:not(.uk-button):not(.uk-icon):not(svg):not(path) {
					color: %2$s!important;
				}

				.comment-navigation a.page-numbers,.uk-h1,.uk-h1 a,.uk-h2,.uk-h2 a,.uk-h3,.uk-h3 a,.uk-h4,.uk-h4 a,.uk-h5,.uk-h5 a,.uk-h6,.uk-h6 a,.uk-offcanvas-bar h6 a,blockquote p,h1,h1 a,h1 a.uk-link,h2,h2 a,h2 a.uk-link,h3,h3 a,h3 a.uk-link,h4,h4 a,h4 a.uk-link,h5,h5 a,h5 a.uk-link,h6,h6 a,h6 a.uk-link, .uk-dropcap::first-letter, .uk-dropcap>p:first-of-type::first-letter{color:%3$s}

				.widget-title{
					color:%5$s;
				}
				.uk-slidenav,
				[data-layout="pamela"] .de-product-single__images-container .slick-arrow,
				[data-layout="petya"] .de-product-single__images-container .slick-arrow,
				[data-layout="philana"] .de-product-single__images-container .slick-arrow,
				[data-layout="philo"] .de-product-single__images-container .slick-arrow {
					color:%6$s;
				}
				.uk-dotnav > * > *{
					background-color:%7$s;
				}
				.entry-meta a:hover,
				.uk-breadcrumb a:hover,
				a:hover,
				.uk-offcanvas-bar a:not(.de-mini-cart__button):hover,
				#header-section1.de-header__section .de-dropdown__container a:hover,
				#header-section2.de-header__section .de-dropdown__container a:hover,
				#header-section3.de-header__section .de-dropdown__container a:hover {
					color:%8$s;
				}

				#header-section1.de-header__section .de-header__mini-cart--as-dropdown a:not(.uk-button):not(.uk-icon):hover,
				#header-section2.de-header__section .de-header__mini-cart--as-dropdown a:not(.uk-button):not(.uk-icon):hover,
				#header-section3.de-header__section .de-header__mini-cart--as-dropdown a:not(.uk-button):not(.uk-icon):hover {
					color: %8$s!important;
				}

				.comment-navigation a.page-numbers:hover {
					border-color: %8$s;
				}
				form.woocommerce-checkout table tfoot tr,
				table,
				table tr,
				form.woocommerce-checkout .woocommerce-checkout-payment ul li,
				.select2-container--default .select2-selection--single,
				.de-sticky__add-to-cart-form form table tbody tr td.value select,
				.widget.widget_archive ul li,
				.widget select,
				.widget.widget_search form button[type="submit"],
				.de-themes--form-bordered textarea,
				.de-checkout-coupon form.checkout_coupon,
				.de-product-single .variations select,
				.de-sticky__add-to-cart-outer-container,
				.de-sticky__add-to-cart-container,
				.widget.widget_search form::after,
				.woocommerce .de-widget-product,
				.woocommerce .widget_product_categories ul.product-categories > li,
				.de-portfolio-details__description > div,
				.de-portfolio-details__contents > div,
				.de-portfolio-single > .uk-container:after,
				.de-portfolio-single .de-portfolio-details__container .uk-container:after,
				.de-portfolio-details__description.uk-width-1-1\@m > div,
				.de-portfolio-details__contents.uk-width-1-1\@m > div,
				.de-portfolio-single__section,
				.comment-navigation .page-numbers,
				.woocommerce-cart .de-content__wrapper .woocommerce .cart_totals table tr,
				.woocommerce-cart .de-content__wrapper .woocommerce table tbody tr.cart_item,
				.de-cart form .coupon h4,
				.de-custom-quantity-control button.ds-quantity-control.de-custom-quantity-control__button.ds-decrement-quantity,
				.de-custom-quantity-control button.ds-quantity-control.de-custom-quantity-control__button.ds-increment-quantity,
				form.woocommerce-checkout .de-order-details tr.cart_item,
				.widget .widget-title,
				.widget .de-widget-title,
				.de-myaccount__form-login-signup__tab,
				.de-product-single .de-tabs ul.tabs,
				.de-product-single .de-tabs,
				.de-review-parent .comment_container,
				.de-product-single__navigation-control,
				.woocommerce .widget_layered_nav ul.woocommerce-widget-layered-nav-list > li,
				.woocommerce .widget_recent_reviews ul li,
				.de-single__before-content-sect,
				.de-single__author-box--inner,
				.widget_product_search form::after,
				.widget.widget_calendar table #today,
				.widget_product_categories ul.product-categories > li,
				.de-content__wrapper .no-results form:after,
				.de-myaccount__navigation ul:not(.uk-dropdown-nav)>li:after,
				.de-myaccount__navigation .uk-button:not(:disabled),
				.widget .widget-title:after,
				.widget .de-widget-title:after,
				.de-myaccount .de-customer-account__option a::before,
				.de-portfolio-single__section:before,
				.de-account-content--dropdown .de-account-content__tab,
				.de-cart .woocommerce-cart-form__cart-item.cart_item,
				.de-cart .cart_totals table.shop_table.shop_table_responsive tr {
					border-color: %13$s;
				}

				.de-mini-cart__item {
					border-color: %13$s!important;
				}

				.widget_price_filter .price_slider_wrapper .ui-widget-content {
					background: %13$s;
				}
				blockquote {
					border-color: %2$s;
				}
				#footer-section2.de-footer__section .widget.widget_search {
					color:%1$s;
				}

				.de-pagination[data-pagination-type="number"] li a {
					color: %15$s;
				}

				.de-pagination.de-pagination__post[data-pagination-type="number"] li.active a {
					color: %16$s;
					background-color: %18$s;
					border-color: %19$s;
				}
				.de-pagination[data-pagination-type="number"] li a:hover{
					border-color: %19$s;
				}
				.de-pagination[data-pagination-type="number"] li.active a,
				.de-portfolio-single__pagination .de-portfolio-single__pagination-prev {
					color: %16$s;
					background-color: %18$s;
					border-color: %19$s;
				}

				.single-post .ds-site-content__header--wrapper {
					border-bottom: 1px;
					border-bottom-color: %13$s;
					border-bottom-style: solid;
				}
				',
				$body_text_color, # 1
				$main_accent_color_regular, # 2
				$heading_text_color, # 3
				$extra_color, # 4
				$widget_title_color, # 5
				$slide_nav_color, # 6
				$dot_nav_color, # 7
				$main_accent_color_hover, # 8
				dahz_framework_hex_to_rgba( $body_text_color, '0.3' ), # 9
				dahz_framework_hex_to_rgba( $body_text_color, '0.5' ), # 10
				dahz_framework_hex_to_rgba( $heading_text_color, '0.5' ), # 11
				dahz_framework_hex_to_rgba( $main_accent_color_regular, '0.3' ), # 12
				$divider_color, # 13
				dahz_framework_hex_to_rgba( $divider_color, '0.3' ), # 14
				$pagination_text_color, # 15
				$pagination_text_color_active, #16
				$pagination_bg_color_active, # 17
				$pagination_bg_color_hover, #18
				$pagination_border_color # 19
			);

			return $default_styles;
		}
		
		public function dahz_framework_hover_style( $styles ){
			
			$selector = '
				.de-content__wrapper * :not(.uk-pagination):not(.uk-tab) > :not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(.uk-h1):not(.uk-h2):not(.uk-h3):not(.uk-h4):not(.uk-h5):not(.uk-h6):not(.de-social-accounts) > a:not(.uk-button):not(.button)
			';
			
			$hover_selector = '
				.de-content__wrapper * :not(.uk-pagination):not(.uk-tab) > :not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(.uk-h1):not(.uk-h2):not(.uk-h3):not(.uk-h4):not(.uk-h5):not(.uk-h6):not(.de-social-accounts) > a:not(.uk-button):not(.button):hover,
				.de-content__wrapper * :not(.uk-pagination):not(.uk-tab) > :not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(.uk-h1):not(.uk-h2):not(.uk-h3):not(.uk-h4):not(.uk-h5):not(.uk-h6):not(.de-social-accounts) > a:not(.uk-button):not(.button):focus,
				.de-content__wrapper * :not(.uk-pagination):not(.uk-tab) > * > a:not(.uk-button):not(.button):hover,
				.de-content__wrapper * :not(.uk-pagination):not(.uk-tab) > * > a:not(.uk-button):not(.button):focus
			';
			
			$main_accent_color = get_theme_mod(
				"color_general_main_accent_color_regular",
				array(
					'regular'	=> '#333333',
					'hover'		=> '#999999'
				)
			);

			$main_accent_color_regular = !empty( $main_accent_color['regular'] ) ? $main_accent_color['regular'] : '#333333';

			$main_accent_color_hover = !empty( $main_accent_color['hover'] ) ? $main_accent_color['hover'] : '#999999';
			
			$styles .= sprintf(
				'
				%1$s{
					transition: .3s;
					color:%3$s;
				}
				%2$s{
					color:%4$s;
				}
				.ds-single-product .ds-site-content__product .woocommerce-tabs .uk-tab > .uk-active a{
					border-color : %3$s;
				}
				body.woocommerce .wishlist_table a:not(.de-product__item-grouped--add-to-cart-button):not(.checkout-button).button,
				body.woocommerce .ds-site-content__product .entry-summary a:not(.de-product__item-grouped--add-to-cart-button):not(.checkout-button).button
				{
					background-color:transparent;
					border:none;
					color:%3$s;
				}
				body.woocommerce .wishlist_table a:not(.de-product__item-grouped--add-to-cart-button):not(.checkout-button).button svg{
					display:none;
				}
				body.woocommerce .wishlist_table a:not(.de-product__item-grouped--add-to-cart-button):not(.checkout-button).button:hover,
				body.woocommerce .wishlist_table a:not(.de-product__item-grouped--add-to-cart-button):not(.checkout-button).button:focus,
				body.woocommerce .ds-site-content__product .entry-summary a:not(.de-product__item-grouped--add-to-cart-button):not(.checkout-button).button:hover,
				body.woocommerce .ds-site-content__product .entry-summary a:not(.de-product__item-grouped--add-to-cart-button):not(.checkout-button).button:focus
				{
					background-color:transparent;
					border:none;
					color:%4$s;
				}
				',
				$selector,
				$hover_selector,
				$main_accent_color_regular,
				$main_accent_color_hover
			);
			
			switch ( dahz_framework_get_option( 'color_general_hover_style' ) ) {
				case 'underline':
					$selector_before = '
						.de-content__wrapper * a.uk-link::before
					';
					$selector = '
						.de-content__wrapper * a.uk-link
					';
					$hover_selector = '
						.de-content__wrapper * a.uk-link:hover::before,
						.de-content__wrapper * a.uk-link:focus::before
					';
					$styles .= sprintf(
						'
						%1$s{
							padding: 0!important;
							background: none;
							position: relative;
							z-index: 0;
						}
						%5$s {
							content: "";
							position: absolute;
							bottom: 0;
							left: 0;
							right: 100%%;
							z-index: -1;
							border-bottom: 1px solid %4$s;
							transition: right 0.3s ease-out!important;
						}
						%2$s{
							right: 0;
						}
						',
						$selector,
						$hover_selector,
						$main_accent_color_regular,
						$main_accent_color_hover,
						$selector_before
					);

					break;
			}
			
			return $styles;
			
		}
		
	}

	new Dahz_Framework_Color_General();
}
