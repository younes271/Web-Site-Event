<?php

if ( !class_exists( 'Dahz_Framework_Navigation_Size' ) ) {
	class Dahz_Framework_Navigation_Size {
		public function __construct() {
			add_action( 'dahz_framework_module_header-navigation-size_init', array( $this, 'dahz_framework_header_navigation_size_init' ) );

			add_filter( 'dahz_framework_preset_required', array( $this, 'dahz_framework_header_preset_required' ), 10, 1 );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_navigation_style' ), 20, 1 );

			add_filter( 'dahz_framework_attributes_secondary_menu_container_args', array( $this, 'dahz_framework_secondary_wrapper_attributes' ), 10 );

			add_filter( 'dahz_framework_attributes_primary_menu_container_args', array( $this, 'dahz_framework_primary_wrapper_attributes' ), 10 );
		}

		public function dahz_framework_secondary_wrapper_attributes( $attributes ) {
			$hover_style = dahz_framework_get_option( 'header_navigation_size_secondary_hover_style', 'style-2' );

			switch ( $hover_style ) {
				case 'style-1':
					$hover_style = 'de-menu-item--change-color';
					break;
				case 'style-2':
					$hover_style = 'de-menu-item--underline';
					break;
				default:
					$hover_style = 'de-menu-item--pills';
					break;
			}

			$attributes['class'][] = 'de-header-navigation__secondary-menu uk-flex-wrap';
			$attributes['class'][] = $hover_style;

			return $attributes;
		}

		public function dahz_framework_primary_wrapper_attributes( $attributes ) {
			$hover_style = dahz_framework_get_option( 'header_navigation_size_primary_hover_style', 'style-2' );

			switch ( $hover_style ) {
				case 'style-1':
					$hover_style = 'de-menu-item--change-color';
					break;
				case 'style-2':
					$hover_style = 'de-menu-item--underline';
					break;
				default:
					$hover_style = 'de-menu-item--pills';
					break;
			}

			$attributes['class'][] = 'de-header-navigation__primary-menu';
			$attributes['class'][] = $hover_style;

			return $attributes;
		}

		public function dahz_framework_header_navigation_size_init( $path ) {
			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-navigation-size-customizer.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Navigation_Size_Customizer',
				array(
					'id'	=> 'header_navigation_size',
					'title'	=> array( 'title' => esc_html__( 'Navigation', 'kitring' ), 'priority' => 7 ),
					'panel'	=> 'header'
				),
				array()
			);
		}

		public function dahz_framework_header_preset_required( $presets_required ) {
			$presets_required['header']['sections'][] = 'header_navigation_size';

			return $presets_required;
		}

		public function dahz_framework_navigation_style( $styles ) {
			$uppercase_style = 'text-transform:uppercase;';

			$styles .= sprintf(
				'
				.de-header-navigation__primary-menu > li > a{
					font-size:%1$s;
					%3$s
				}
				.de-header-navigation__secondary-menu > li > a{
					font-size:%2$s;
					%4$s
				}
				',
				dahz_framework_get_option( 'header_navigation_size_primary', '16px' ),
				dahz_framework_get_option( 'header_navigation_size_secondary', '16px' ),
				dahz_framework_get_option( 'header_navigation_size_is_primary_uppercase_nav', false ) ? $uppercase_style : '',
				dahz_framework_get_option( 'header_navigation_size_is_secondary_uppercase_nav', false ) ? $uppercase_style : ''
			);

			return $styles;
		}
	}

	new Dahz_Framework_Navigation_Size();
}