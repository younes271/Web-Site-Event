<?php
/**
 * Dahz_Framework functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dahz_Framework
 */

if ( !function_exists( 'dahz_framework_include' ) ) {

	function dahz_framework_include( $file, $variable_to_extract = array() ) {

		if ( !empty( $variable_to_extract ) && is_array( $variable_to_extract ) ) {

			extract( $variable_to_extract );

		}

		include( $file );

	}

}
if ( !function_exists( 'dahz_framework_custom_codes' ) ) {

	function dahz_framework_custom_codes() {

		$custom_code_js_header = dahz_framework_get_option( 'custom_code_js_header' );

		$custom_code_js_footer = dahz_framework_get_option( 'custom_code_js_footer' );

		wp_add_inline_script(
			'pace',
			'(function($) {window.paceOptions = {ajax: false}})(jQuery)',
			'before'
		);

		wp_add_inline_script(
			'jquery-migrate',
			sprintf(
				'
				(function ($) {
					window.dahz = window.dahz || {};
					dahz.lazyload = {
						height:0,
						width:0,
						imgWidth:0,
						ratio:0,
						init: function( img ) {
							dahz.lazyload.height = parseInt( $( img ).attr( "height" ) );
							dahz.lazyload.width = parseInt( $( img ).attr( "width" ) );
							dahz.lazyload.imgWidth = $( img ).parent().width();
							dahz.lazyload.ratio = dahz.lazyload.getRatio( dahz.lazyload.height, dahz.lazyload.width, dahz.lazyload.imgWidth );
							$( img ).attr( "style", "width :" + dahz.lazyload.imgWidth + "px; height :" +dahz.lazyload.ratio + "px;" );
						},
						getRatio: function( height, width, imgWidth ) {
							return ( height / width ) * imgWidth;
						}
					};
				})(jQuery);
				',
				$custom_code_js_header
			)
		);

		if ( !empty( $custom_code_js_header ) ) {

			wp_add_inline_script(
				'jquery-migrate',
				sprintf(
					'(function($) {%1$s})(jQuery)',
					$custom_code_js_header
				)
			);
		}

		if ( !empty( $custom_code_js_footer ) ) {

			wp_add_inline_script(
				'uikit',
				sprintf(
					'(function($) {%1$s})(jQuery)',
					$custom_code_js_footer
				)
			);
		}

	}

}

add_action( 'wp_enqueue_scripts', 'dahz_framework_custom_codes', 11 );

if ( !function_exists( 'dahz_framework_return_include' ) ) {

	function dahz_framework_return_include( $file, $variable_to_extract = array() ) {

		if ( !empty( $variable_to_extract ) ) {

			extract( $variable_to_extract );

		}

		return include( $file );

	}

}

if ( !function_exists( 'dahz_framework_init_default_styles' ) ) {

	function dahz_framework_init_default_styles() {

		global $dahz_framework;
		
		do_action( 'dahz_framework_before_default_styles' );

		$custom_code_css = dahz_framework_get_option( 'custom_code_css' );

		$default_styles	= $custom_code_css;
		
		if( is_customize_preview() ){
			
			$default_styles .= dahz_framework_elements()->dahz_framework_get_element_styles();
		
		} else {
			
			$current_theme = wp_get_theme();
			
			$theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
			
			$element_styles = get_option( "{$theme_name}_element_styles" );
			
			$default_styles .= ! empty( $element_styles ) ? $element_styles : '';
			
		}
		
		$icon_mobile_menu_parent_open = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><title>df</title><g id="dots-horizontal"><path d="M4,8.5a1,1,0,1,1-1,1,1,1,0,0,1,1-1m0-1a2,2,0,1,0,2,2,2,2,0,0,0-2-2Zm6,1a1,1,0,1,1-1,1,1,1,0,0,1,1-1m0-1a2,2,0,1,0,2,2,2,2,0,0,0-2-2Zm6,1a1,1,0,1,1-1,1,1,1,0,0,1,1-1m0-1a2,2,0,1,0,2,2,2,2,0,0,0-2-2Z"/></g></svg>';

		$icon_mobile_menu_parent_close = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><title>df</title><g id="dots-vertical"><path d="M11,3.5a1,1,0,1,1-1-1,1,1,0,0,1,1,1m1,0a2,2,0,1,0-2,2,2,2,0,0,0,2-2Zm-1,6a1,1,0,1,1-1-1,1,1,0,0,1,1,1m1,0a2,2,0,1,0-2,2,2,2,0,0,0,2-2Zm-1,6a1,1,0,1,1-1-1,1,1,0,0,1,1,1m1,0a2,2,0,1,0-2,2,2,2,0,0,0,2-2Z"/></g></svg>';
		
		$default_styles .='
			#de-header-horizontal.de-header-transparent .de-header__wrapper {
				position:absolute;
				top: 0;
				right: 0;
				left: 0;
			}
			.woocommerce-orders-table__cell-order-actions a{
				background:none!important;
				color:' . dahz_framework_get_option( 'color_button_modifier_text_color', '#000000' ) . '!important;
			}
			.woocommerce-orders-table__cell-order-actions a:hover{
				background:none!important;
				color:' . dahz_framework_get_option( 'color_button_modifier_text_hover_color', '#000000' ) . '!important;
			}
			.de-footer__widget .de-sidebar__widget-separator:last-child,
			.sidebar .de-sidebar__widget-separator:last-child {
				display:none;
			}
			@media( max-width:959px ) {
				.footer-section__toggle-content {
					max-height:0;
					transition :.3s;
					overflow:hidden;
				}
			}
			.header-mobile-menu__container--content .uk-parent > a::after{
				content: "";
				width: 1.5em;
				height: 1.5em;
				float: right;
				background-image: url(data:image/svg+xml;charset=UTF-8,' . rawurlencode( $icon_mobile_menu_parent_open ) . ');
				background-repeat: no-repeat;
				background-position: 50% 50%;
				transition:.3s;
			}
			.header-mobile-menu__container--content .uk-parent.uk-open > a::after{
				background-image: url(data:image/svg+xml;charset=UTF-8,' . rawurlencode( $icon_mobile_menu_parent_close ) . ');
			}
			#masthead .sub-menu-item {
				position: relative;
			}
			.de-dropdown__dropped{
				top:-15px !important;
			}
			.footer-section__toggle-content--show {
				max-height:100vh;
			}
			.footer-section__toggle-content--btn {
				position: relative;
			}
			.footer-section__toggle-content--btn::after{
				content: "";
				width: 10px;
				height: 10px;
				border-left: 1px solid;
				border-bottom: 1px solid;
				transform: rotate(-45deg) translateY(-40%);
			}
			.footer-section__toggle-content--btn.active{
				padding-bottom:10px!important;
				margin-bottom:10px;
			}
			.footer-section__toggle-content--btn.active::after{
				border: 0;
				border-right: 1px solid;
				border-top: 1px solid;
				transform: rotate(-45deg) translateX(-30%);
			}
			.footer-section__toggle-content--btn{
				display: flex;
				align-items: center;
				transition:.3s;
				justify-content: space-between;
			}
			.de-mobile-nav .de-mobile-nav__depth-1, .de-mobile-nav .de-mobile-nav__depth-2{
					padding: 5px 0 5px 20px;
			}
			.de-dot-nav{
				display: block;
				box-sizing: border-box;
				width: 10px;
				height: 10px;
				border-radius: 50%;
				background: transparent;
				text-indent: 100%;
				overflow: hidden;
				white-space: nowrap;
				border: 1px solid rgba(102,102,102,0.4);
				transition: .2s ease-in-out;
				transition-property: background-color,border-color;
			}
			.uk-active > .de-dot-nav{
				background-color: rgba(102,102,102,0.6);
				border-color: transparent;
			}
			.de-header__section--show-on-sticky.uk-active{
				z-index:1000;
			}
			.de-dropdown__container{
				z-index:1020;
			}
		';
		// header section

		for ( $i = 1; $i <= 3; $i++ ) {

			$header_bg_image = '';

			$footer_bg_image = '';

			$header__section_bg_img = dahz_framework_get_option( 'header_section'. $i .'_section_bg_img' );

			$footer_section_bg_img = dahz_framework_get_option( 'footer_section'. $i .'_section_bg_img' );

			$header_section_color = dahz_framework_get_option(
				"header_section{$i}_section_color",
				array(
					'link'	=> '#333333',
					'hover'	=> '#999999'
				)
			);

			$footer_section_color = dahz_framework_get_option(
				"footer_section{$i}_section_color",
				array(
					'link'	=> '#a8a8a8',
					'hover'	=> '#999999'
				)
			);

			if ( !empty( $header__section_bg_img ) ) {

				$header_bg_image = sprintf(
					'
					background-image: url( %1$s );
					background-attachment: %2$s;
					background-position: %3$s;
					background-repeat: %4$s;
					background-size: %5$s;
					',
					dahz_framework_get_option( 'header_section' . $i . '_section_bg_img' ),
					dahz_framework_get_option( 'header_section' . $i . '_section_bg_img_attachment', 'scroll' ),
					dahz_framework_get_option( 'header_section' . $i . '_section_bg_img_position', 'left top' ),
					dahz_framework_get_option( 'header_section' . $i . '_section_bg_img_repeat', 'repeat' ),
					dahz_framework_get_option( 'header_section' . $i . '_section_bg_img_size', 'auto' )
				);

			}

			if ( !empty( $footer_section_bg_img ) ) {

				$footer_bg_image = sprintf(
					'
					background-image: url( %1$s );
					background-attachment: %2$s;
					background-position: %3$s;
					background-repeat: %4$s;
					background-size: %5$s;
					',
					dahz_framework_get_option( 'footer_section' . $i . '_section_bg_img' ),
					dahz_framework_get_option( 'footer_section' . $i . '_section_bg_img_attachment', 'scroll' ),
					dahz_framework_get_option( 'footer_section' . $i . '_section_bg_img_position', 'left top' ),
					dahz_framework_get_option( 'footer_section' . $i . '_section_bg_img_repeat', 'repeat' ),
					dahz_framework_get_option( 'footer_section' . $i . '_section_bg_img_size', 'auto' )
				);

			}


			$default_styles .= sprintf(
				'
				#header-section%1$s.de-header__section {
					min-height: %4$spx;
				}
				#header-mobile-section%1$s.de-header-mobile__section {
					min-height: %5$spx;
				}
				#header-section%1$s.de-header__section,
				#header-mobile-section%1$s.de-header-mobile__section {
					background-color: %2$s;
					%3$s
					border-bottom-width: %6$spx;
					border-bottom-color: %7$s;
					border-bottom-style: %8$s;
				}
				#header-section%1$s .de-primary-menu > li > .sub-menu,
				#header-section%1$s .menu > li > ul.sub-menu,
				#header-section%1$s .de-header__mini-cart-container--as-dropdown.de-header__mini-cart-container--horizontal,
				#header-section%1$s .de-account-content__wrapper ul.de-dropdown,
				#header-section%1$s .de-currency__element ul.de-dropdown,
				#header-section%1$s .de-account-content__wrapper .de-account-content--as-dropdown {
					top: calc( 100%% + %6$spx );
				}
				#header-section%1$s.de-header__section *:not(.uk-button),
				#header-section%1$s.de-header__section *:not(.uk-button):visited,
				#header-mobile-section%1$s.de-header-mobile__section *:not(.uk-button),
				#header-mobile-section%1$s.de-header-mobile__section ul.de-primary-menu--modified>li>a:not(.uk-button):after
				{
					color: %9$s;
				}
				#header-section%1$s.de-header__section ul.de-primary-menu--modified > li > a:after,
				#header-mobile-section%1$s.de-header-mobile__section ul.de-primary-menu--modified > li > a:after {
					background: %9$s;
				}
				#header-section%1$s.de-header__section a:not(.uk-button):hover,
				#header-section%1$s.de-header__section a:not(.uk-button):hover *,
				#header-mobile-section%1$s.de-header-mobile__section a:not(.uk-button):hover,
				#header-mobile-section%1$s.de-header-mobile__section a:not(.uk-button):hover * {
					color: %10$s;
				}

				#header-section%1$s .hover-2 > ul > li > a:first-child:after,
				#header-section%1$s .hover-2 #secondary-menu > li > a:first-child:after,
				.de-header-vertical #header-section%1$s .is-uppercase.hover-2 .sub-menu > li:hover > a:after {
					background-color: %10$s;
				}
				#footer-section%1$s.de-footer__section {
					background-color: %11$s;
					%12$s
					padding-top: %13$spx;
					padding-bottom: %14$spx;
					border-top-width: %15$spx;
					border-top-color: %16$s;
					border-top-style: %17$s;
				}
				#footer-section%1$s.de-footer__section .de-footer__main-navigation .menu ul.children > li {
					border-color: %16$s;
				}
				#footer-section%1$s.de-footer__section {
					color: %20$s;
				}
				#footer-section%1$s.de-footer__section a {
					color: %18$s;
				}
				#footer-section%1$s.de-footer__section .uk-h1 a,
				#footer-section%1$s.de-footer__section .uk-h2 a,
				#footer-section%1$s.de-footer__section .uk-h3 a,
				#footer-section%1$s.de-footer__section .uk-h4 a,
				#footer-section%1$s.de-footer__section .uk-h5 a,
				#footer-section%1$s.de-footer__section .uk-h6 a,
				#footer-section%1$s.de-footer__section h1 a,
				#footer-section%1$s.de-footer__section h2 a,
				#footer-section%1$s.de-footer__section h3 a,
				#footer-section%1$s.de-footer__section h4 a,
				#footer-section%1$s.de-footer__section h5 a,
				#footer-section%1$s.de-footer__section h6 a {
					color: %21$s;
				}
				#footer-section%1$s.de-footer__section a:hover {
					color: %19$s !important;
				}
				#footer-section%1$s.de-footer__section .de-widget__recent-posts-meta a,
				#footer-section%1$s.de-footer__section .rss-date {
					color: %22$s;
				}
				#footer-section%1$s.de-footer__section .widget-title {
					color: %23$s;
				}
				#footer-section%1$s.de-footer__section .widget.widget_calendar table #today {
					border-color: %24$s;
				}
				',
				$i, // 1
				dahz_framework_get_option( 'header_section' . $i . '_section_bg_color', '#fff' ), // 2
				$header_bg_image, // 3
				(int)dahz_framework_get_option( 'header_section' . $i . '_section_height', '80' ), // 4
				(int)dahz_framework_get_option( 'header_section' . $i . '_section_mobile_height', '80' ), // 5
				(int)dahz_framework_get_option( 'header_section' . $i . '_section_border_bottom', '0' ), // 6
				dahz_framework_get_option( 'header_section' . $i . '_section_border_color', '#ececec' ), // 7
				dahz_framework_get_option( 'header_section' . $i . '_section_border_style', 'solid' ), // 8,
				isset( $header_section_color['link'] ) ? $header_section_color['link'] : '#726240',
				isset( $header_section_color['hover'] ) ? $header_section_color['hover'] : 'rgba(114,98,64,0.8)',
				dahz_framework_get_option( 'footer_section' . $i . '_section_bg_color', '#fff' ), // 11
				$footer_bg_image, // 12
				(int)dahz_framework_get_option( 'footer_section' . $i . '_section_padding_top', '12' ), // 13
				(int)dahz_framework_get_option( 'footer_section' . $i . '_section_padding_bottom', '12' ), // 14
				(int)dahz_framework_get_option( 'footer_section' . $i . '_section_border_top', '0' ), // 15
				dahz_framework_get_option( 'footer_section' . $i . '_section_border_color', '#ececec' ), // 16
				dahz_framework_get_option( 'footer_section' . $i . '_section_border_style', 'solid' ),// 17
				isset( $footer_section_color['link'] ) ? $footer_section_color['link'] : '', // 18
				isset( $footer_section_color['hover'] ) ? $footer_section_color['hover'] : '',// 19
				dahz_framework_get_option( 'footer_section' . $i . '_body_text_color', '#525252' ), // 20
				dahz_framework_get_option( 'footer_section' . $i . '_heading_text_color', '#0e0e0e' ), // 21
				dahz_framework_get_option( 'footer_section' . $i . '_extra_color', '#525252' ), // 22
				dahz_framework_get_option( 'footer_section' . $i . '_widget_title_color', '#0e0e0e' ), // 23
				dahz_framework_get_option( 'footer_section' . $i . '_divider_color', '#0e0e0e' ) // 24
			);

			# Hover style
			switch ( dahz_framework_get_option( 'color_general_hover_style' ) ) {
				case 'thin-underline':
					$default_styles .= sprintf(
						'
						#footer-section%1$s.de-footer__section .uk-h1 a:hover,
						#footer-section%1$s.de-footer__section .uk-h2 a:hover,
						#footer-section%1$s.de-footer__section .uk-h3 a:hover,
						#footer-section%1$s.de-footer__section .uk-h4 a:hover,
						#footer-section%1$s.de-footer__section .uk-h5 a:hover,
						#footer-section%1$s.de-footer__section .uk-h6 a:hover,
						#footer-section%1$s.de-footer__section h1 a:hover,
						#footer-section%1$s.de-footer__section h2 a:hover,
						#footer-section%1$s.de-footer__section h3 a:hover,
						#footer-section%1$s.de-footer__section h4 a:hover,
						#footer-section%1$s.de-footer__section h5 a:hover,
						#footer-section%1$s.de-footer__section h6 a:hover,
						#footer-section%1$s.de-footer__section p a:hover,
						#footer-section%1$s.de-footer__section li a:hover,
						#footer-section%1$s.de-footer__section .de-widget__recent-posts-meta a:hover {
							box-shadow: inset 0 -1px 0 %2$s;
						}
						',
						$i, # 1
						dahz_framework_hex2rgba( isset( $footer_section_color['hover'] ) ? $footer_section_color['hover'] : '', 0.3 ) # 2
					);
					break;
				case 'thick-underline':
					$default_styles .= sprintf(
						'
						#footer-section%1$s.de-footer__section p a,
						#footer-section%1$s.de-footer__section li a {
							box-shadow: inset 0 -1px 0 %2$s;
						}
						#footer-section%1$s.de-footer__section .uk-h1 a,
						#footer-section%1$s.de-footer__section .uk-h2 a,
						#footer-section%1$s.de-footer__section .uk-h3 a,
						#footer-section%1$s.de-footer__section .uk-h4 a,
						#footer-section%1$s.de-footer__section .uk-h5 a,
						#footer-section%1$s.de-footer__section .uk-h6 a,
						#footer-section%1$s.de-footer__section h1 a,
						#footer-section%1$s.de-footer__section h2 a,
						#footer-section%1$s.de-footer__section h3 a,
						#footer-section%1$s.de-footer__section h4 a,
						#footer-section%1$s.de-footer__section h5 a,
						#footer-section%1$s.de-footer__section h6 a {
							box-shadow: inset 0 -1px 0 %4$s;
						}
						#footer-section%1$s.de-footer__section .entry-meta a,
						#footer-section%1$s.de-footer__section .uk-breadcrumb a,
						#footer-section%1$s.de-footer__section .de-widget__recent-posts-meta a {
							box-shadow: inset 0 -1px 0 %5$s;
						}
						#footer-section%1$s.de-footer__section .uk-h1 a:hover,
						#footer-section%1$s.de-footer__section .uk-h2 a:hover,
						#footer-section%1$s.de-footer__section .uk-h3 a:hover,
						#footer-section%1$s.de-footer__section .uk-h4 a:hover,
						#footer-section%1$s.de-footer__section .uk-h5 a:hover,
						#footer-section%1$s.de-footer__section .uk-h6 a:hover,
						#footer-section%1$s.de-footer__section h1 a:hover,
						#footer-section%1$s.de-footer__section h2 a:hover,
						#footer-section%1$s.de-footer__section h3 a:hover,
						#footer-section%1$s.de-footer__section h4 a:hover,
						#footer-section%1$s.de-footer__section h5 a:hover,
						#footer-section%1$s.de-footer__section h6 a:hover,
						#footer-section%1$s.de-footer__section p a:hover,
						#footer-section%1$s.de-footer__section li a:hover,
						#footer-section%1$s.de-footer__section .de-widget__recent-posts-meta a:hover {
							box-shadow: inset 0 -8px 0 %3$s;
						}
						',
						$i, # 1
						dahz_framework_hex2rgba( isset( $footer_section_color['link'] ) ? $footer_section_color['link'] : '', 0.3 ), # 2
						dahz_framework_hex2rgba( isset( $footer_section_color['hover'] ) ? $footer_section_color['hover'] : '', 0.1 ), # 3
						dahz_framework_hex2rgba( dahz_framework_get_option( 'footer_section' . $i . '_heading_text_color', '#0e0e0e' ), 0.3 ), # 4
						dahz_framework_hex2rgba( dahz_framework_get_option( 'footer_section' . $i . '_extra_color', '#525252' ), 0.3 ) # 5
					);
					break;
			}

			do_action( 'dahz_framework_loop_builder_section_styles', $i, $default_styles );

		}
		// header row
		wp_add_inline_style( 'dahz-framework-app-style', apply_filters( 'dahz_framework_default_styles', $default_styles ) );

	}

}

add_action( 'wp_enqueue_scripts', 'dahz_framework_init_default_styles', 11 );

if ( !function_exists( 'dahz_framework_typography_enqueue_typekit' ) ) {

	function dahz_framework_typography_enqueue_typekit() {

		$source_font = dahz_framework_get_option( 'typography_source_font' );

		if ( $source_font === 'adobe-typekit' ) {

			$main_typekit = dahz_framework_get_option( 'typography_typekit_id_main' );

			$secondary_typekit = dahz_framework_get_option( 'typography_typekit_id_secondary' );

			if ( !empty( $main_typekit ) ) {

				wp_enqueue_script( 'dahz-framework-typekit-fonts', '//use.typekit.net/'. $main_typekit .'.js', array(), '1.0');

			}

			if ( !empty( $secondary_typekit ) && $main_typekit !== $secondary_typekit ) {

				wp_enqueue_script( 'dahz-framework-typekit-fonts', '//use.typekit.net/'. $secondary_typekit .'.js', array(), '1.0' );

			}

			if ( !empty( $main_typekit ) || !empty( $secondary_typekit ) ) {

				wp_add_inline_script( 'dahz-framework-typekit-fonts', 'try{Typekit.load({ async: true });}catch(e) {}' );

			}

		}

	}

}

add_action( 'wp_enqueue_scripts', 'dahz_framework_typography_enqueue_typekit' );

global $dahz_framework, $dahz_framework_modules;

$dahz_framework = ( object ) array();

$dahz_framework->site_key = 'de-content--kitring';

$dahz_framework_modules = array();

if (is_file( get_template_directory() . '/dahz-modules/data-dahz-framework-modules.php' ) ) {
	$dahz_framework_modules = require get_template_directory() . '/dahz-modules/data-dahz-framework-modules.php';
}

require get_template_directory() . '/dahz-framework/class-dahz-framework-init.php';

