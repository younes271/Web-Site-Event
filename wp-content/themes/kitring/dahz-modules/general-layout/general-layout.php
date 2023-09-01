<?php

if ( !class_exists( 'Dahz_Framework_General_Layout' ) ) {

	Class Dahz_Framework_General_Layout{

		public function __construct() {

			add_action( 'dahz_framework_module_general-layout_init', array( $this, 'dahz_framework_general_layout_init' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_layout_style' ) );

			add_filter( 'dahz_framework_attributes_page_container_args', array( $this, 'dahz_framework_general_layout_outer_width' ) );

			add_filter( 'body_class' , array( $this, 'dahz_framework_general_layout' ) );

			add_filter( 'dahz_framework_attributes_page_args', array( $this, 'dahz_framework_page_box_shadow' ) );
			
			add_filter( 'dahz_framework_header_sticky_offset', array( $this, 'dahz_framework_header_sticky_offset' ) );

		}

		public function dahz_framework_general_layout_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/general-layout-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_General_Layout_Customizer',
				array(
					'id'	=> 'general_layout',
					'title' => array( 'title' => esc_html__( 'Layout', 'kitring' ), 'priority' => 4 ),
					'panel'	=> 'general'
				),
				array()
			);

		}

		public function dahz_framework_general_layout( $classes ) {
			
			$layout = dahz_framework_get_option( 'general_layout_general_layout', 'fullwidth' );
			
			$classes[] = $layout;
			
			$classes[] = "de-{$layout}";


			return $classes;

		}

		public function dahz_framework_page_box_shadow( $attributes ) {

			$attributes['class'][] = dahz_framework_get_option( 'general_layout_box_shadow', '' );

			return $attributes;

		}

		public function dahz_framework_general_layout_outer_width( $args ) {

			$layout = dahz_framework_get_option( 'general_layout_general_layout', 'fullwidth' );
			
			$args['class'][] = "de-content-{$layout}";

			return $args;

		}
		
		public function dahz_framework_header_sticky_offset( $offset ){
			
			$layout = dahz_framework_get_option( 'general_layout_general_layout', 'fullwidth' );
			
			if ( $layout !== 'framed' ) { return $offset; }
			
			$framed_width = dahz_framework_get_option( 'general_layout_site_framed_width', '40' );
			
			return ( $offset + (int)$framed_width );
			
		}

		public function dahz_framework_layout_style( $default_styles ) {

			$layout = dahz_framework_get_option( 'general_layout_general_layout', 'fullwidth' );

			$site_width = dahz_framework_get_option( 'general_layout_site_content_width', '1200' );

			$framed_width = dahz_framework_get_option( 'general_layout_site_framed_width', '40' );

			$boxed_width = dahz_framework_get_option( 'general_layout_site_boxed_width', '1400' );

			$layout_background_image = dahz_framework_get_option( 'general_layout_body_bg_image' );

			$outer_background_image = dahz_framework_get_option( 'general_layout_outer_bg_image' );

			$body_bg_color = dahz_framework_get_option( 'general_layout_body_bg_color', '#ffffff' );

			$layout_background = '';

			$outer_background = '';

			if ( !empty( $layout_background_image ) ) {

				$layout_background = sprintf(
					'
					background-image: url(%1$s);
					background-attachment: %2$s;
					background-position: %3$s;
					background-repeat: %4$s;
					background-size: %5$s;
					',
					esc_url( $layout_background_image ),
					dahz_framework_get_option( 'general_layout_body_bg_attachment', 'scroll' ),
					dahz_framework_get_option( 'general_layout_body_bg_position', 'left top' ),
					dahz_framework_get_option( 'general_layout_body_bg_repeat', 'no-repeat' ),
					dahz_framework_get_option( 'general_layout_body_bg_size', 'cover' )
				);

			}

			if ( $layout == 'framed' ) {
				$default_styles .= sprintf(
					'@media (min-width: 960px) {
						.framed .woocommerce-store-notice.demo_store {
							bottom: %1$spx;
							left: %1$spx;
							right: %1$spx;
						}
					}',
					!empty( $framed_width ) ? $framed_width : '0'
				);
			}

			if ( !empty( $outer_background_image ) ) {

				$outer_background = sprintf(
					'
					background-image: url(%1$s);
					background-attachment: %2$s;
					background-position: %3$s;
					background-repeat: %4$s;
					background-size: %5$s;
					',
					esc_url( $outer_background_image ),
					dahz_framework_get_option( 'general_layout_outer_bg_attachment', 'scroll' ),
					dahz_framework_get_option( 'general_layout_outer_bg_position', 'left top' ),
					dahz_framework_get_option( 'general_layout_outer_bg_repeat', 'no-repeat' ),
					dahz_framework_get_option( 'general_layout_outer_bg_size', 'cover' )
				);

			}

			$default_styles .= sprintf(
				'
				body,
				.de-single__navigation > div > h6 + div,
				#header-myaccount-dropdown,
				.uk-slider .uk-slidenav,
				.de-product-single__images li .de-gallery__link,
				.de-myaccount__navigation .uk-dropdown,
				.de-product-thumbnail:hover .woocommerce-loop-product__link img:nth-child(2),
				[data-layout=philo] .de-product-single__images-container img {
					background-color: %2$s;
				}

				#header-section1.de-header__section .de-mini-cart__item-outer-container,
				#header-section2.de-header__section .de-mini-cart__item-outer-container,
				#header-section3.de-header__section .de-mini-cart__item-outer-container {
					background-color: %2$s!important;
				}

				#de-content-wrapper{
					background-color:%2$s;
					%3$s
				}
				#page.de-content-boxed .page-wrapper{
					max-width: %4$spx;
					margin: 0 auto;
				}
				.de-content-boxed #de-header-horizontal:not(.no-transparency):not(.site-header--is-sticky) .de-header__wrapper {
					margin: 0 auto;
					width: %4$spx;
				}
				#page.de-content-boxed{
					background-color:%5$s;
					%6$s
				}
				@media ( min-width: 960px ) {
					#page.de-content-framed,
					#page.de-content-framed .page-wrapper:before {
						background-color:%12$s;
					}

					#page.de-content-framed:before,
					#page.de-content-framed .page-wrapper:before {
						height: %11$spx;
					}

					#page.de-content-framed:before {
						background-color:%12$s;
					}

					#page.de-content-framed .page-wrapper {
						background-color: %2$s;
						margin: %11$spx;
					}
				}

				.de-header-boxed .row,
				.de-featured-area.caris > .row,
				#de-archive-content > .row,
				.de-page > .row,
				.de-404 > .row,
				.de-single > .row,
				.de-single__section-related > .row,
				.de-footer-inner > .row:not(.expanded),
				.de-sub-footer > .row:not(.expanded),
				.calista .de-portfolio__container > .row,
				.de-portfolio__pagination.row,
				.coralie > .row,
				.centaur > .row,
				.de-portfolio-single > .row:not(.expanded),
				.de-archive__header-extra > .row,
				.de-shop-archive__wrap.row:not(.expanded),
				#de-product-container .de-product-single__wrapper,
				#de-product-container .de-product-single__wrapper[data-layout="layout-5"] .de-product-single__description,
				.trina .de-archive__header-inner > .row,
				.de-cart--sticky-top .de-cart__inner,
				.de-megamenu-sub[data-fullscreen="Yes"] > li,
				.ds-single-product .ds-site-content__header--wrapper-inner,
				.ds-single-post .ds-site-content__header--wrapper-inner {
					max-width: %1$spx;
				}
				.de-related-arrows--left:hover,
				.de-related-arrows--right:hover,
				.de-upsells-arrows--left:hover,
				.de-upsells-arrows--right:hover,
				.de-cross-sells-arrows--left:hover,
				.de-cross-sells-arrows--right:hover,
				.de-option--bgcolor-carousel-arrow:hover,
				.de-sc-newsletter__modal-container-inner,
				.de-sc-post-carousel__content,
				.de-product:not(.ellinor) .de-product-single__ajax-loader,
				.de-recent-view-arrows--left:hover,
				.de-recent-view-arrows--right:hover,
				.ella .de-quickview i,
				.de-product-single__viewing-bar,
				.de-product-single__viewing-bar-form .wrapper__label-value .label,
				.de-product-single__viewing-bar-form .wrapper__label-value .value,
				.de-cart.fullwidth .de-cart-content,
				.de-cart.sticky-side .de-cart--sticky-side .de-cart__inner,
				.de-product-detail__inner .de-swatches-container,
				.tlite,
				.de-search,
				.de-search__result .products,
				.de-product-single__size-modal-container,
				.color-count-wrapper,
				.tooltipster-sidetip.tooltipster-noir.tooltipster-noir-customized .tooltipster-box {
					background-color: %2$s;
				}
				@media screen and (max-width: 63.9375em) {
					.de-shop-archive__container {
						background-color: %2$s;
					}
				}
				.widget.woocommerce.widget_color_filter .widget-color--style-2.pa_color .df-widget-color-filter-list .color-count-wrapper::before {
					border-bottom-color: %2$s;
				}

				@media screen and (min-width: 1024px) {
					.de-quickview-modal,
					.de-sc-quickview__modal {
						background-color: %2$s;
					}
				}

				@media screen and (max-width: 1023px) {
					.de-product .de-quickview-btn i {
						background-color: %2$s;
					}
					.de-quickview-modal > div,
					.de-sc-quickview__modal > div {
						background-color: %2$s;
					}
				}
				.de-account-content--popup {
					background-color: %7$s;
				}

				.de-quickview-btn,
				.ellinor .yith-wcwl-add-to-wishlist,
				.ella .de-product-detail {
					background-color: %7$s;
				}

				.de-quickview-btn:hover,
				.ellinor .yith-wcwl-add-to-wishlist:hover,
				.ella .de-product-detail:hover,
				.ella .de-product-detail:hover .de-swatches-container {
					background-color: %2$s;
				}

				.de-product__checkout,
				.de-sc-taggd--list-inside .de-sc-taggd__inner-wrapper {
					background-color: %7$s;
				}
				.widget.widget_archive select, .widget.widget_categories select, .widget.widget_text select, .widget.widget_search form,
				.de-newsletter__container,
				.de-sc-showcase__summary,
				.de-single__pagination-container,
				.de-sc-newsletter__modal-close,
				.de-newsletter__close,
				.de-single__media--gallery-caption,
				.de-product .out-of-stock,
				.de-quickview__modal-inner,
				.de-form-search__result-item,
				.de-account-content--dropdown {
					background-color: %2$s;
				}

				.de-dropcap.background.black::first-letter {
					color: %2$s !important;
				}

				.de-sc-product-masonry--item-description,
				.de-shop-archive__loader-main {
					background-color: %8$s;
				}
				.calista .de-portfolio__content-item,
				.de-form-search__result-item:hover {
					background-color: %9$s;
				}
				.coralie .de-portfolio__content::before,
				.centaur .de-portfolio__content::before {
					background-color: %2$s;
				}
				.uk-container:not(.uk-container-small):not(.uk-container-large):not(.uk-container-expand),
				.ds-single-product .ds-site-content__header--wrapper-inner,
				.ds-single-post .ds-site-content__header--wrapper-inner {
					max-width: %10$spx;
				}
				',
				dahz_framework_get_option( 'general_layout_site_content_width', '1200' ),
				$body_bg_color,
				$layout_background,
				(int)$boxed_width,
				dahz_framework_get_option( 'general_layout_outer_bg_color', '#ffffff' ),
				$outer_background,
				dahz_framework_hex_to_rgba( $body_bg_color, '0.95' ),
				dahz_framework_hex_to_rgba( $body_bg_color, '0.85' ),
				dahz_framework_hex_to_rgba( $body_bg_color, '0.9' ),
				(int)$site_width,
				(int)$framed_width,
				dahz_framework_get_option( 'general_layout_framed_color', '#ffffff' )
			);

			return $default_styles;

		}

	}

	new Dahz_Framework_General_Layout();

}
