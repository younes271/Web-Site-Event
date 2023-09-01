<?php

if ( !class_exists( 'Dahz_Framework_Sticky_Header' ) ) {

	class Dahz_Framework_Sticky_Header {

		public function __construct() {

			add_action( 'dahz_framework_module_header-sticky_init', array( $this, 'dahz_framework_header_sticky_init' ) );

			add_filter( 'dahz_framework_header_section_class', array( $this, 'dahz_framework_sticky_header_class' ), 10, 3 );

			add_filter( 'dahz_framework_logo_sticky', array( $this, 'dahz_framework_transparent_header_logo_sticky' ), 10, 2 );

			add_filter( 'dahz_framework_header_class', array( $this, 'dahz_framework_header_sticky_class' ), 998, 1 );

			add_filter( 'dahz_framework_preset_required', array( $this, 'dahz_framework_header_preset_required' ), 10, 1 );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_header_sticky_style' ), 10, 1 );

			add_filter( 'dahz_framework_header_content', array( $this, 'dahz_framework_header_sticky_desktop' ), 10, 2 );

			add_filter( 'dahz_framework_headermobile_content', array( $this, 'dahz_framework_header_sticky_mobile' ), 10, 2 );

		}

		public function dahz_framework_header_sticky_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-sticky-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Sticky_Customizer',
				array(
					'id'	=> 'sticky_header',
					'title'	=> array( 'title' => esc_html__( 'Sticky Header', 'kitring' ), 'priority' => 6 ),
					'panel'	=> 'header'
				),
				array()
			);

		}

		public function dahz_framework_header_preset_required( $presets_required ) {

			$presets_required['header']['sections'][] = 'sticky_header';

			return $presets_required;

		}

		/**
		 * dahz_framework_sticky_header_class
		 * set section sticky class
		 * @param $sticky_class, $header_type, $id_section
		 * @return $sticky_class
		 */
		public function dahz_framework_sticky_header_class( $sticky_class, $header_type, $id_section ) {

			if ( $id_section === 'after-section' ) {
				return 'de-' . $header_type . '__section--show-on-sticky';
			}

			if ( $header_type == 'header' ) {

				$sticky_sections = dahz_framework_get_option( 'sticky_header_element_to_sticky', array( '2' ) );


			} else if ( $header_type == 'header-mobile' ) {

				$sticky_sections = dahz_framework_get_option( 'sticky_header_mobile_element_to_sticky', array( '2' ) );

			}

			$section_name = $header_type . '-section' . $id_section;

			if ( is_array( $sticky_sections ) && in_array( $id_section, $sticky_sections ) ) {
				$sticky_class = 'de-' . $header_type . '__section--show-on-sticky';
			}

			return $sticky_class;

		}

		/**
		 * dahz_framework_transparent_header_logo_sticky
		 * set logo on header sticky
		 * @param $sticky_logo
		 * @return $sticky_logo
		 */
		public function dahz_framework_transparent_header_logo_sticky( $sticky_logo, $logo_normal ) {

			$sticky_logo_normal = dahz_framework_get_option( 'logo_and_site_identity_header_sticky_logo_normal', get_template_directory_uri() . '/assets/images/logo/default-logo.svg' );

			$sticky_logo_retina = dahz_framework_get_option( 'logo_and_site_identity_header_sticky_logo_retina', get_template_directory_uri() . '/assets/images/logo/default-logo.svg' );

			if ( !empty( $sticky_logo_normal ) || !empty( $sticky_logo_retina ) ) {

				$sticky_logo = sprintf( '
					<a href="%4$s" rel="home">
						<img src="%1$s" data-src-2x="%2$s" data-src-3x="%2$s" alt="%3$s" />
					</a>
					',
					!empty( $sticky_logo_normal ) ? esc_url( $sticky_logo_normal ) : esc_url( $sticky_logo_retina ),
					!empty( $sticky_logo_retina ) ? esc_url( $sticky_logo_retina ) : esc_url( $sticky_logo_normal ),
					esc_html__( 'Site Logo', 'kitring' ),
					esc_url( home_url( '/' ) )
				);

			} else {

				$sticky_logo = $logo_normal;

			}

			return sprintf(
				'
				<div class="de-header__logo-media de-header__logo-media--sticky">
					%1$s
				</div>
				',
				$sticky_logo
			);

		}

		/**
		 * dahz_framework_header_sticky_class
		 * set header transparent skin class
		 * @param $class
		 * @return $class
		 */
		public function dahz_framework_header_sticky_class( $class ) {

			if ( is_singular( 'post' ) ) {

				$sticky_header_skin_metabox = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'sticky_header_skin', 'off' );

				$remove_shadow_sticky_metabox = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'remove_shadow_sticky', 'off' );

				if ( $sticky_header_skin_metabox == 'on' ) $class[] .= 'site-header--transparent-sticky';

				if ( $remove_shadow_sticky_metabox == 'on' ) $class[] .= 'site-header--no-shadow-sticky';

			}

			if ( is_singular( 'page' ) ) {

				$sticky_header_skin_metabox = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'sticky_header_skin', 'off' );

				$remove_shadow_sticky_metabox = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'remove_shadow_sticky', 'off' );

				if ( $sticky_header_skin_metabox == 'on' ) $class[] .= 'site-header--transparent-sticky';

				if ( $remove_shadow_sticky_metabox == 'on' ) $class[] .= 'site-header--no-shadow-sticky';

			}

			if ( is_home() && !is_front_page() ) {

				$page_id = get_option( 'page_for_posts' );

				$sticky_header_skin_metabox = dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'sticky_header_skin', 'off' );

				$remove_shadow_sticky_metabox = dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'remove_shadow_sticky', 'off' );

				if ( $sticky_header_skin_metabox == 'on' ) $class[] .= 'site-header--transparent-sticky';

				if ( $remove_shadow_sticky_metabox == 'on' ) $class[] .= 'site-header--no-shadow-sticky';

			}

			if ( class_exists( 'WooCommerce' ) ) {

				if ( is_singular( 'product' ) ) {

					$sticky_header_skin_metabox = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'sticky_header_skin', 'off' );

					$remove_shadow_sticky_metabox = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'remove_shadow_sticky', 'off' );

					if ( $sticky_header_skin_metabox == 'on' ) $class[] .= 'site-header--transparent-sticky';

					if ( $remove_shadow_sticky_metabox == 'on' ) $class[] .= 'site-header--no-shadow-sticky';

				}

			}

			if ( class_exists( 'DahzExtender_Portfolios' ) ) {

				if ( is_singular( 'portfolio' ) ) {

					$sticky_header_skin_metabox = dahz_framework_get_meta( get_the_ID(), 'portfolio', 'portfolio-sticky-header-skin', 'off' );

					$remove_shadow_sticky_metabox = dahz_framework_get_meta( get_the_ID(), 'portfolio', 'portfolio-remove-shadow-sticky', 'off' );

					if ( $sticky_header_skin_metabox == 'on' ) $class[] .= 'site-header--transparent-sticky';

					if ( $remove_shadow_sticky_metabox == 'on' ) $class[] .= 'site-header--no-shadow-sticky';

				}

			}

			return $class;

		}

		/**
		 * lorem ipsum
		 *
		 * @param $output, $header
		 * @return $output
		 */
		public function dahz_framework_header_sticky_desktop( $output, $header ) {

			$sticky_sections = dahz_framework_get_option( 'sticky_header_element_to_sticky', array( '2' ) );

			if( !is_array( $sticky_sections ) || empty( $sticky_sections ) ){ return $output; }

			global $dahz_framework;

			$builder_empty_sections = array();

			if( property_exists( $dahz_framework, 'builder_empty_sections' ) && is_array( $dahz_framework->builder_empty_sections ) ){

				$builder_empty_sections = isset( $dahz_framework->builder_empty_sections['header'] ) && is_array( $dahz_framework->builder_empty_sections['header'] ) ? $dahz_framework->builder_empty_sections['header'] : array();

			}

			$different = array_diff( $sticky_sections, $builder_empty_sections );

			if ( !empty( $sticky_sections ) && !empty( $different ) ) {

				$output = sprintf(
					'
					<div id="de-header-horizontal-desktop" class="uk-visible@m ds-header--wrapper de-header__wrapper de-header default uk-position-z-index">
						<div class="de-header__sticky--wrapper" data-header-sticky-box-shadow="%2$s" data-header-sticky-offset="%3$s">
							%1$s
						</div>
					</div>
					',
					$header,
					dahz_framework_get_option( 'sticky_header_box_shadow', '' ),
					apply_filters( 'dahz_framework_header_sticky_offset', 0 )
				);

			}

			return $output;
		}

		/**
		 * lorem ipsum
		 *
		 * @param $output, $header_mobile
		 * @return $output
		 */
		public function dahz_framework_header_sticky_mobile( $output, $header_mobile ) {

			$sticky_sections = dahz_framework_get_option( 'sticky_header_mobile_element_to_sticky', array( '2' ) );

			if( !is_array( $sticky_sections ) || empty( $sticky_sections ) ){ return $output; }

			global $dahz_framework;

			$builder_empty_sections = array();

			if( property_exists( $dahz_framework, 'builder_empty_sections' ) && is_array( $dahz_framework->builder_empty_sections ) ){

				$builder_empty_sections = isset( $dahz_framework->builder_empty_sections['headermobile'] ) && is_array( $dahz_framework->builder_empty_sections['headermobile'] ) ? $dahz_framework->builder_empty_sections['headermobile'] : array();

			}

			$different = array_diff( $sticky_sections, $builder_empty_sections );

			if ( !empty( $sticky_sections ) && !empty( $different ) ) {

				$output = sprintf(
					'
					<div id="de-header-horizontal-mobile" class="uk-hidden@m ds-header-mobile--wrapper de-header-mobile__wrapper de-header-mobile default">
						<div class="de-header__sticky--wrapper" data-header-sticky-box-shadow="%2$s" data-header-sticky-offset="%3$s">
							%1$s
						</div>
					</div>
					',
					$header_mobile,
					dahz_framework_get_option( 'sticky_header_box_shadow', '' ),
					apply_filters( 'dahz_framework_header_sticky_offset', 0 )
				);

			}

			return $output;
		}

		/**
		 * default style for sticky
		 *
		 * @param $styles
		 * @return $styles
		 */
		public function dahz_framework_header_sticky_style( $styles ) {
			for ( $i = 1; $i <= 3; $i++ ) {
				$styles .= sprintf(
					'
					.de-header__sticky--wrapper.uk-sticky.uk-active #header-section%1$s.de-header__section {
						min-height: %2$spx;
					}
					',
					$i, # 1
					dahz_framework_get_option( 'header_section' . $i . '_section_sticky_height', '80' ) # 2
				);
			}

			return $styles;
		}

	}

	new Dahz_Framework_Sticky_Header();

}