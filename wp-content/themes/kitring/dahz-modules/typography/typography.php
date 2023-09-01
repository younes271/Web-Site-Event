<?php

if ( !class_exists( 'Dahz_Framework_Typography' ) ) {

	Class Dahz_Framework_Typography{

		public $path = '';

		public $source_font = false;

		public $main_font = '';

		public $secondary_font = '';

		public $main_font_weight = '';

		public $main_font_style = '';

		public $secondary_font_weight = '';

		public $secondary_font_style = '';

		public $google_font = '';

		public function __construct() {

			add_action( 'dahz_framework_module_typography_init', array( $this, 'dahz_framework_typography_init' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_default_fonts' ), 5 );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_global_fonts' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_customizer_calculate' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_enquue_google_fonts' ), 6 );

		}

		/**
		* dahz_framework_customizer_calculate
		* Calculate Font Size
		* @param -
		* @return -
		*/
		public function dahz_framework_customizer_calculate( $dv_default_styles ) {

			$calculate_items = apply_filters( 'dahz_framework_typography_option_list', array(
				'body'			=> array(
					'is_global'				=> true,
					'is_class'				=> false,
					'is_secondary_class'	=> true,
					'size'					=> 1,
					'large'					=> '',
					'line_height'			=> 1.75,
				),
				'h1,.uk-h1'			=> array(
					'is_global'				=> false,
					'is_class'				=> false,
					'is_secondary_class'	=> false,
					'large'					=> '',
					'medium'				=> 3,
					'small'					=> 1.75,
					'line_height_large'		=> '',
					'line_height_medium'	=> 1.2,
					'line_height_small'		=> 1.2,
				),
				'h2,.uk-h2'			=> array(
					'is_global'				=> false,
					'is_class'				=> false,
					'is_secondary_class'	=> false,
					'large'					=> '',
					'medium'				=> 2.25,
					'small'					=> 1.5,
					'line_height_large'		=> '',
					'line_height_medium'	=> 1.2,
					'line_height_small'		=> 1.2,
				),
				'h3,.uk-h3'			=> array(
					'is_global'				=> false,
					'is_class'				=> false,
					'is_secondary_class'	=> false,
					'large'					=> '',
					'medium'				=> 1.75,
					'small'					=> 1.25,
					'line_height_large'		=> '',
					'line_height_medium'	=> 1.2,
					'line_height_small'		=> 1.2,
				),
				'h4,.uk-h4'			=> array(
					'is_global'				=> false,
					'is_class'				=> false,
					'is_secondary_class'	=> false,
					'large'					=> '',
					'medium'				=> 1.25,
					'small'					=> 1.125,
					'line_height_large'		=> '',
					'line_height_medium'	=> 1.2,
					'line_height_small'		=> 1.2,
				),
				'h5,.uk-h5'			=> array(
					'is_global'				=> false,
					'is_class'				=> false,
					'is_secondary_class'	=> false,
					'large'					=> '',
					'medium'				=> 1,
					'small'					=> 1,
					'line_height_large'		=> '',
					'line_height_medium'	=> 1.2,
					'line_height_small'		=> 1.2,
				),
				'h6,.uk-h6'			=> array(
					'is_global'				=> false,
					'is_class'				=> false,
					'is_secondary_class'	=> false,
					'large'					=> '',
					'medium'				=> 0.875,
					'small'					=> 0.875,
					'line_height_large'		=> '',
					'line_height_medium'	=> 1.2,
					'line_height_small'		=> 1.2,
				),
				'.uk-heading-primary'	=> array(
					'is_global'				=> false,
					'is_class'				=> false,
					'is_secondary_class'	=> false,
					'large'					=> 3.75,
					'medium'				=> 3.375,
					'small'					=> 3,
					'line_height_large'		=> 1.1,
					'line_height_medium'	=> 1.2,
					'line_height_small'		=> 1.2,
				),
				'.uk-article-title'	=> array(
					'is_global'				=> false,
					'is_class'				=> false,
					'is_secondary_class'	=> false,
					'medium'				=> 2.6,
					'small'					=> 2.23,
					'large'					=> '',
					'line_height_medium'	=> 1.2,
					'line_height_small'		=> 1.2,
				),
				'.uk-heading-hero'	=> array(
					'is_global'				=> false,
					'is_class'				=> false,
					'is_secondary_class'	=> false,
					'large'					=> 8,
					'medium'				=> 6,
					'small'					=> 4,
					'line_height_large'		=> 1,
					'line_height_medium'	=> 1,
					'line_height_small'		=> 1.1,
				),
			) );

			$dv_main_font_size			= dahz_framework_get_option( 'typography_main_font_size', '16px' );
			$dv_main_letter_space		= dahz_framework_get_option( 'typography_main_letter_spacing', '0' );
			$dv_secondary_font_size		= dahz_framework_get_option( 'typography_secondary_font_size', '15px' );
			$dv_secondary_letter_space	= dahz_framework_get_option( 'typography_secondary_letter_spacing', '0' );
			$dv_button_font_size		= dahz_framework_get_option( 'typography_button_size', '14px' );
			$dv_button_letter_space		= dahz_framework_get_option( 'typography_button_letter_spacing', '1px' );

			$dv_main_size_used = (int)$dv_main_font_size <= 0 ? 16 : (int)$dv_main_font_size;

			$dv_secondary_size_used = (int)$dv_secondary_font_size <= 0 ? 15 : (int)$dv_secondary_font_size;

			foreach( $calculate_items as $items => $items_child ) {

				do_action( 'dahz_framework_calculate_global_typo_style', $items, $items_child, $dv_secondary_size_used );

				if ( $items_child['is_secondary_class'] ) {

					if ( $items_child['is_global'] ) {
						$dv_default_styles .= sprintf('
							body {
								font-size: %1$spx;
								line-height: %2$s;
								letter-spacing: %3$s;
							}
							p {
								margin-bottom: 20px;
							}',
							$items_child['size'] * $dv_secondary_size_used, # 1
							$items_child['line_height'], # 2
							$dv_secondary_letter_space # 3
						);
					} else {
						$dv_default_styles .= sprintf('
							%1$s%2$s {
								font-size: %3$spx;
								line-height: %4$s;
								letter-spacing: %5$s;
								margin-bottom: 20px;
							}',
							$items_child['is_class'] ? '.' : '', # 1
							$items, # 2
							$items_child['size'] * $dv_secondary_size_used, # 3
							$items_child['line_height'], # 4
							$dv_secondary_letter_space # 5
						);
					}
				} else {
					$dv_default_styles .= sprintf('
						@media screen and ( min-width: 1200px ) {
							%1$s%2$s {
								font-size: %3$s;
								line-height: %4$s;
								letter-spacing: %5$s;
							}
						}',
						$items_child['is_class'] ? '.' : '', # 1
						$items, # 2
						( $items_child['large'] == '' ? 'inherit' : $items_child['large'] * $dv_main_size_used . 'px' ), # 3
						( $items_child['line_height_medium'] == '' ? 'inherit' : $items_child['line_height_medium'] ), # 4
						$dv_main_letter_space # 5
					);

					$dv_default_styles .= sprintf('
						@media screen and ( min-width: 960px ) {
							%1$s%2$s {
								font-size: %3$s;
								line-height: %4$s;
								letter-spacing: %5$s;
							}
						}',
						$items_child['is_class'] ? '.' : '', # 1
						$items, # 2
						$items_child['medium'] * $dv_main_size_used . 'px', # 3
						$items_child['line_height_medium'], # 4
						$dv_main_letter_space # 5
					);

					$dv_default_styles .= sprintf('
						@media screen and ( max-width: 960px ) {
							%1$s%2$s {
								font-size: %3$spx;
								line-height: %4$s;
								letter-spacing: %5$s;
								margin-bottom: 10px;
							}
						}',
						$items_child['is_class'] ? '.' : '', # 1
						$items, # 2
						$items_child['small'] * $dv_main_size_used, # 3
						$items_child['line_height_medium'], # 4
						$dv_main_letter_space # 5
					);
				}
			}

			$button_font_size = (int)$dv_button_font_size <= 0 ? 14 : (int)$dv_button_font_size;
			$button_letter_spacing = (int)$dv_button_letter_space <= 0 ? 1 : (int)$dv_button_letter_space;

			$dv_default_styles .= sprintf(
				'
				.de-btn {
					font-size: %spx;
					letter-spacing: %spx;
				}
				.de-btn--small {
					font-size: %spx;
				}
				.de-btn--medium {
					font-size: %spx;
				}
				.de-btn--large {
					font-size: %spx;
				}
				.de-btn--xlarge {
					font-size: %spx;
				}
				',
				$button_font_size,
				$button_letter_spacing,
				$button_font_size * 0.750,
				$button_font_size * 1.000,
				$button_font_size * 1.375,
				$button_font_size * 1.750
			);

			return $dv_default_styles;
		}

		public function dahz_framework_typography_init( $path ) {

			$this->path = $path;

			if ( is_customize_preview() ) {

				dahz_framework_include( $path . '/typography-customizers.php' );

			}

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Typography',
				array(
					'id'		=> 'typography',
					'title' 	=> esc_html__( 'Typography', 'kitring' ) ,
					'priority'	=> 10
				),
				array()
			);

		}

		/**
		* dahz_framework_default_fonts
		* enqueue default fonts
		* @param -
		* @return void | enqueue style
		*/
		public function dahz_framework_default_fonts() {

			$source_font = dahz_framework_get_option( 'typography_source_font', 'google-fonts' );

			if ( $source_font === 'google-fonts' ) {

				$typographies = array(
					'typography_main_font'		=> dahz_framework_get_option(
						'typography_main_font',
						array(
							'font-family'		=> 'Poppins',
							'variant'			=> 600,
							'subsets'			=> array( 'latin-ext' ),
							'font-weight'		=> 600,
							'font-style'		=> 'normal'
						)
					),
					'typography_secondary_font'	=> dahz_framework_get_option(
						'typography_secondary_font',
						array(
							'font-family'		=> 'Lato',
							'variant'			=> 'regular',
							'subsets'			=> array( 'latin-ext' ),
							'font-weight'		=> 400,
							'font-style'		=> 'normal'
						)
					)
				);

				$font_families = array();

				$subsets = array();

				$weights = array();

				foreach( $typographies as $type => $typography ) {

					if ( isset( $typography['font-family'] ) && !in_array( $typography['font-family'], $font_families ) ) {

						if ( $type === 'typography_main_font' ) {

							$this->main_font		= $typography['font-family'];
							$this->main_font_weight = $typography['font-weight'];
							$this->main_font_style	= $typography['font-style'];

						} else {

							$this->secondary_font			= $typography['font-family'];
							$this->secondary_font_weight	= $typography['font-weight'];
							$this->secondary_font_style	= $typography['font-style'];

						}

						$font_families[] = sprintf(
							'
							%1$s%2$s
							',
							$typography['font-family'],
							!empty( $typography['font-weight'] ) ? ':' . $typography['font-weight'] : ''
						);

					}
					if ( !empty( $typography['subsets'] ) && is_array( $typography['subsets'] ) ) {

						foreach( $typography['subsets'] as $subset ) {

							if ( !in_array( $subset, $subsets ) ) {

								$subsets[] = $subset;

							}

						}

					}

				}

				$font_family_request = !empty( $font_families ) ? sprintf( 'family=%s', implode( '|', $font_families ) ) : '';

				$font_subsets_request = !empty( $subsets ) ? sprintf( 'subset=%s', implode( ',', $subsets ) ) : '';

				if ( !empty( $font_family_request ) ) {

					$this->google_font = sprintf(
						'//fonts.googleapis.com/css?%1$s%2$s',
						$font_family_request,
						!empty( $font_subsets_request ) ? '&amp;'. $font_subsets_request : ''
					);

				}

			} else {

				$this->main_font = dahz_framework_get_option( 'typography_typekit_id_main' );

				$this->main_font_weight = 400;

				$this->main_font_style = 'normal';

				$this->secondary_font = dahz_framework_get_option( 'typography_typekit_id_secondary' );

				$this->secondary_font_weight = 400;

				$this->secondary_font_style = 'normal';

			}

		}

		/**
		 * dahz_framework_global_fonts
		 * Assign selected font from customizer to stylesheet
		 * @param - $dv_default_styles
		 * @return
		 */

		public function dahz_framework_global_fonts( $default_styles ) {

			/*
				Get Font Setting
			*/
			$typography_header_element = dahz_framework_get_option( 'typography_header_element', 'main-font' );
			$header_element_font_family = $typography_header_element === 'main-font' ? $this->main_font : $this->secondary_font;
			$header_element_font_weight = $typography_header_element === 'main-font' ? $this->main_font_weight : $this->secondary_font_weight;
			$header_element_font_style = $typography_header_element === 'main-font' ? $this->main_font_style : $this->secondary_font_style;

			$typography_dropdown_element = dahz_framework_get_option( 'typography_dropdown_font', 'secondary-font' );
			$dropdown_element_font_family = $typography_dropdown_element === 'main-font' ? $this->main_font : $this->secondary_font;
			$dropdown_element_font_weight = $typography_dropdown_element === 'main-font' ? $this->main_font_weight : $this->secondary_font_weight;
			$dropdown_element_font_style = $typography_dropdown_element === 'main-font' ? $this->main_font_style : $this->secondary_font_style;

			$typography_button_element = dahz_framework_get_option( 'typography_button_font', 'main-font' );
			$button_element_font_family = $typography_button_element === 'main-font' ? $this->main_font : $this->secondary_font;
			$button_element_font_weight = $typography_button_element === 'main-font' ? $this->main_font_weight : $this->secondary_font_weight;
			$button_element_font_style = $typography_button_element === 'main-font' ? $this->main_font_style : $this->secondary_font_style;

			/*
				Set Font Setting
			*/
			$default_styles = sprintf(
				'
				body,
				p,
				.de-cart-checkout__collaterals__cart-totals__shipping-method li .amount,
				.de-header-search__content-input input[type="text"],
				.de-related-post__media a.de-ratio-content--inner > span {
					font-family: %2$s;
					font-style: %8$s;
					font-weight: %9$s;
				}
				h1, h2, h3, h4, h5, h6, .uk-h1, .uk-h2, .uk-h3, .uk-h4, .uk-h5, .uk-h6, .uk-countdown-number, .de-single .de-related-post__media .de-ratio-content--inner, blockquote p {
					font-family: %1$s;
					font-style: %6$s;
					font-weight: %7$s;
				}
				#masthead [data-item-id="mega_menu"] .uk-navbar-dropdown-grid > div > a,
				.de-header-navigation__primary-menu > li > a,
				.de-header-navigation__secondary-menu > li > a,
				.de-header__item > div > a,
				.de-header-mobile__item > div > a,
				a.de-header__empty-menu--primary-menu,
				a.de-header__empty-menu--secondary-menu,
				.header-mobile-menu__elements > div > a,
				.header-mobile-menu__elements > ul > li > a{
					font-family: %3$s;
					font-style: %10$s;
					font-weight: %11$s;
				}
				.header-mobile-menu__elements ul.sub-menu > li > a,
				.header-mobile-menu__elements ul.uk-nav-sub > li > a,
				#masthead .de-header__wrapper .de-header-dropdown > li > a{
					font-family: %4$s;
					font-style: %12$s;
					font-weight: %13$s;
				}
				.de-btn {
					font-family: %5$s;
					font-style: %14$s;
					font-weight: %15$s;
				}
				',
				$this->main_font,				#1
				$this->secondary_font,			#2
				$header_element_font_family,	#3
				$dropdown_element_font_family,	#4
				$button_element_font_family,	#5
				$this->main_font_style,			#6
				$this->main_font_weight,		#7
				$this->secondary_font_style,	#8
				$this->secondary_font_weight,	#9
				$header_element_font_style,		#10
				$header_element_font_weight,	#11
				$dropdown_element_font_style,	#12
				$dropdown_element_font_weight,	#13
				$button_element_font_style,		#14
				$button_element_font_weight		#15

			) . $default_styles;

			return $default_styles;

		}

		public function dahz_framework_enquue_google_fonts(){

			if( empty( $this->google_font ) ){return;}

			wp_enqueue_style(
				'dahz-framework-typo-font',
				esc_url( $this->google_font ),
				null
			);

		}

	}

	new Dahz_Framework_Typography();

}
