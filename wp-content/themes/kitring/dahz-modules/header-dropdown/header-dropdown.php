<?php

if ( !class_exists( 'Dahz_Framework_Header_Dropdown' ) ) {
	class Dahz_Framework_Header_Dropdown {
		function __construct() {
			add_action( 'dahz_framework_module_header-dropdown_init', array( $this, 'dahz_framework_header_dropdown_init' ) );

			add_filter( 'dahz_framework_default_styles'	, array( $this, 'dahz_framework_dropdown_header_style' ) );

			add_filter( 'dahz_framework_preset_required', array( $this, 'dahz_framework_header_preset_required' ), 10, 1 );

			add_filter( 'dahz_framework_attributes_dropdown_container_args', array( $this, 'dahz_framework_dropdown_container_attributes' ), 10 );

			add_filter( 'dahz_framework_attributes_dropdown_start_level_args', array( $this, 'dahz_framework_dropdown_start_level_attributes' ), 10 );

			add_filter( 'dahz_framework_dropdown_title', array( $this, 'dahz_framework_dropdown_override' ), 10, 3 );
		}

		public function dahz_framework_dropdown_container_attributes( $attributes ) {
			$attributes['class'][] = dahz_framework_get_option( 'header_dropdown_box_shadow', '' );
			$attributes['class'][] = 'de-dropdown__container';

			return $attributes;
		}

		public function dahz_framework_dropdown_start_level_attributes( $attributes ) {
			$hover_style = dahz_framework_get_option( 'header_dropdown_style', 'style-2' );

			switch ( $hover_style ) {
				case 'style-1':
					$hover_style = 'de-menu-item--underline';
					break;
				case 'style-2':
					$hover_style = 'de-menu-item--change-color';
					break;
				default:
					$hover_style = 'de-menu-item--push';
					break;
			}

			$attributes['class'][] = 'de-header-dropdown';

			$attributes['class'][] = $hover_style;

			return $attributes;
		}

		public function dahz_framework_header_dropdown_init( $path ) {
			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-dropdown-customizer.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Dropdown_Customizer',
				array(
					'id'	=> 'header_dropdown',
					'title'	=> array( 'title' => esc_html__( 'Dropdown', 'kitring' ), 'priority' => 9 ),
					'panel'	=> 'header'
				),
				array()
			);
		}

		public function dahz_framework_header_preset_required( $presets_required ) {
			$presets_required['header']['sections'][] = 'header_dropdown';

			return $presets_required;
		}

		/**
		 * setting to dropdown hover style
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param $woo_template, $woo_slug, $woo_name
		 * @return $woo_template
		 */
		public function dahz_framework_header_dropdown_hover( $classes ) {
			$dropdown_hover = dahz_framework_get_option( 'header_dropdown_style', 'style-1' );

			switch ( $dropdown_hover ) {
				case 'style-2' :
					$classes .= ' de-dropdown--underlined ';
					break;

				default :
					$classes .= ' de-dropdown--default ';
					break;
			}

			return $classes;
		}

		public function dahz_framework_dropdown_header_style( $styles ) {
			$uppercase_style = 'text-transform:uppercase;';

			$styles .= sprintf(
				'
				#masthead .de-header__wrapper .de-header-dropdown > li > a > span,
				#masthead .de-header__wrapper .de-header-dropdown > li > a {
					font-size:%1$s;
					%2$s
					color:%3$s !important;
				}
				#masthead .de-header__wrapper .de-header-dropdown > li > a:hover > span,
				#masthead .de-header__wrapper .de-header-dropdown > li > a:hover {
					color:%4$s !important;
				}
				#masthead .de-header__wrapper .uk-dropdown-nav.de-dropdown__container,
				#masthead .de-header__wrapper .uk-navbar-dropdown.de-dropdown__container,
				#masthead .de-header__wrapper .de-dropdown__container .uk-card,
				#masthead .de-header__wrapper .de-dropdown__container .uk-card,
				.primary-menu .menu-item-depth-0>.uk-dropdown-nav:before,
				.secondary-menu .menu-item-depth-0>.uk-navbar-dropdown:before {
					background-color:%5$s !important;
				}
				#masthead [data-item-id="mega_menu"] .uk-drop-grid > div > a > span {
					font-size:%6$s;
					%7$s
					color:%8$s !important;
					%10$s
				}
				#masthead [data-item-id="mega_menu"] .uk-drop-grid > div > a:hover > span {
					color:%9$s !important;
				}
				',
				dahz_framework_get_option( 'header_dropdown_font_size', '14px' ), # 1
				dahz_framework_get_option( 'header_dropdown_enable_uppercase', false ) ? $uppercase_style : '', # 2
				dahz_framework_get_option( 'header_dropdown_color_normal', 'inherit' ), # 3
				dahz_framework_get_option( 'header_dropdown_color_hover', 'inherit' ), # 4
				dahz_framework_get_option( 'header_dropdown_background', '#ffffff' ), # 5
				dahz_framework_get_option( 'header_dropdown_megamenu_title_font_size', '14px' ), # 6
				dahz_framework_get_option( 'header_dropdown_megamenu_title_enable_uppercase', false ) ? $uppercase_style : '', # 7
				dahz_framework_get_option( 'header_dropdown_megamenu_title_color', 'inherit' ), # 8
				dahz_framework_get_option( 'header_dropdown_megamenu_title_hover_color', 'inherit' ), # 9
				dahz_framework_get_option( 'header_dropdown_megamenu_title_enable_divider', false ) # 10
					?
					sprintf(
						'
						border-bottom-style:solid;
						border-bottom-width:1px;
						border-bottom-color:%1$s;
						',
						dahz_framework_get_option( 'header_dropdown_megamenu_title_divider_color', 'inherit' )
					)
					:
					''
			);

			return $styles;
		}

		/**
		 * add span to dropdown
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param $title, $item_id, $depth
		 * @return $title
		 */
		public function dahz_framework_dropdown_override( $title, $item_id, $depth ) {
			$title = sprintf( '<span>%s</span>', $title );

			return $title;
		}
	}

	new Dahz_Framework_Header_Dropdown();
}
