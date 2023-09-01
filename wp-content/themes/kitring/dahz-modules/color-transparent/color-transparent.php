<?php

if ( !class_exists( 'Dahz_Framework_Color_Transparent' ) ) {
	Class Dahz_Framework_Color_Transparent {
		public function __construct() {
			add_action( 'dahz_framework_module_color-transparent_init', array( $this, 'dahz_framework_color_transparent_init' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_transparent_color_style' ) );
		}

		public function dahz_framework_color_transparent_init( $path ) {
			if ( is_customize_preview() ) dahz_framework_include( $path . '/color-transparent-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Color_Transparent_Customizer',
				array(
					'id'	=> 'color_transparent',
					'title'	=> array( 'title' => esc_html__( 'Transparent Element', 'kitring' ), 'priority' => 5 ),
					'panel'	=> 'color',
				),
				array()
			);
		}

		public function dahz_framework_transparent_color_style( $default_styles ) {
			# Global Dark Color
			$dark_global = dahz_framework_get_option(
				'color_transparent_global_color_dark',
				'#000000'
			);

			# Divider Dark Color
			$dark_divider = dahz_framework_get_option(
				'color_transparent_divider_color_dark',
				'#000000'
			);

			# Dot Nav Dark Color
			$dark_dot_nav = dahz_framework_get_option(
				'color_transparent_dot_nav_color_dark',
				'#000000'
			);

			# Slide Nav Dark Color
			$dark_slide_nav = dahz_framework_get_option(
				'color_transparent_slide_nav_color_dark',
				'#000000'
			);

			# Global Light Color
			$light_global = dahz_framework_get_option(
				'color_transparent_global_color_light',
				'#ffffff'
			);

			# Divider Light Color
			$light_divider = dahz_framework_get_option(
				'color_transparent_divider_color_light',
				'#ffffff'
			);

			# Dot Nav Light Color
			$light_dot_nav = dahz_framework_get_option(
				'color_transparent_dot_nav_color_light',
				'#ffffff'
			);

			# Slide Nav Light Color
			$light_slide_nav = dahz_framework_get_option(
				'color_transparent_slide_nav_color_light',
				'#ffffff'
			);

			$default_styles .= sprintf(
				'
				.site-header.transparent-dark .de-header__section,
				.site-header.transparent-light .de-header__section {
					background: transparent !important;
				}
				.site-header.transparent-dark .de-header__section a:hover,
				.site-header.transparent-light .de-header__section a:hover,
				.uk-dark a:not(.uk-button):hover,
				.uk-light a:not(.uk-button):hover {
					opacity: .8 !important;
				}
				.site-header.transparent-dark .de-header__section *,
				.uk-dark *:not(.uk-button) {
					color: %1$s !important;
				}
				.site-header.transparent-dark .de-header__section {
					border-color: %2$s !important;
				}
				.site-header.transparent-light .de-header__section *,
				.uk-light *:not(.uk-button) {
					color: %3$s !important;
				}
				.site-header.transparent-light .de-header__section {
					border-color: %4$s !important;
				}
				.uk-dark .uk-dotnav li.uk-active a {
					background-color: %5$s !important;
				}
				.uk-dark .uk-slidenav * {
					color: %6$s !important;
				}
				.uk-light .uk-dotnav li.uk-active a {
					background-color: %7$s !important;
				}
				.uk-light .uk-slidenav * {
					color: %8$s !important;
				}
				.uk-dark .uk-dotnav li a {
					background-color: %9$s !important;
				}
				.uk-light .uk-dotnav li a {
					background-color: %10$s !important;
				}
				',
				$dark_global, # 1
				$dark_divider, # 2
				$light_global, # 3
				$light_divider, # 4
				$dark_dot_nav, # 5
				$dark_slide_nav, # 6
				$light_dot_nav, # 7
				$light_slide_nav, # 8
				dahz_framework_hex2rgba( $dark_dot_nav, 0.5 ), # 9
				dahz_framework_hex2rgba( $light_dot_nav, 0.5 ) # 10
			);

			# Hover style
			switch ( dahz_framework_get_option( 'color_general_hover_style' ) ) {
				case 'thin-underline':
					$default_styles .= sprintf(
						'
						.de-content__wrapper .uk-light a:hover {
							box-shadow: inset 0 -1px 0 %1$s;
						}
						.de-content__wrapper .uk-dark a:hover {
							box-shadow: inset 0 -1px 0 %2$s;
						}
						',
						dahz_framework_hex2rgba( $light_global, 0.3 ), # 1
						dahz_framework_hex2rgba( $dark_global, 0.3 ) # 2
					);
					break;
				case 'thick-underline':
					$default_styles .= sprintf(
						'
						.de-content__wrapper .uk-light a {
							box-shadow: inset 0 -1px 0 %1$s;
						}
						.de-content__wrapper .uk-light a:hover {
							box-shadow: inset 0 -8px 0 %2$s;
						}
						.de-content__wrapper .uk-dark a {
							box-shadow: inset 0 -1px 0 %3$s;
						}
						.de-content__wrapper .uk-dark a:hover {
							box-shadow: inset 0 -8px 0 %4$s;
						}
						',
						dahz_framework_hex2rgba( $light_global, 0.3 ), # 1
						dahz_framework_hex2rgba( $light_global, 0.1 ), # 2
						dahz_framework_hex2rgba( $dark_global, 0.3 ), # 3
						dahz_framework_hex2rgba( $dark_global, 0.1 ) # 4
					);
					break;
			}

			return $default_styles;
		}
	}

	new Dahz_Framework_Color_Transparent();
}