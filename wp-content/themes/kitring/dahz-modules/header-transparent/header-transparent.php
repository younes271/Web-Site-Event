<?php

if ( !class_exists( 'Dahz_Framework_Header_Transparent' ) ) {

	class Dahz_Framework_Header_Transparent {

		function __construct() {

			add_action( 'dahz_framework_module_header-transparent_init', array( $this, 'dahz_framework_header_transparent_init' ) );

			add_filter( 'dahz_framework_attributes_header_horizontal_wrapper_args', array( $this, 'dahz_framework_header_skin_class' ), 999 );

			add_filter( 'dahz_framework_logo_light', array( $this, 'dahz_framework_transparent_header_logo_light'), 10, 2 );

			add_filter( 'dahz_framework_logo_dark', array( $this, 'dahz_framework_transparent_header_logo_dark'), 10, 2 );

			$this->dahz_framework_register_taxonomy_metabox();

		}

		public function dahz_framework_header_transparent_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-transparent-field-customizer.php' );

		}

		public function dahz_framework_register_taxonomy_metabox() {

			add_action( 'dahz_framework_taxonomy_metabox_portfolio_categories', array( $this,'dahz_framework_image_thumbnail_taxonomy_metabox' ) );

			add_action( 'dahz_framework_taxonomy_metabox_portfolio_categories', array( $this,'dahz_framework_header_skin_taxonomy_metabox' ) );

			add_action( 'dahz_framework_taxonomy_metabox_category', array( $this,'dahz_framework_header_skin_taxonomy_metabox' ) );

			add_action( 'dahz_framework_taxonomy_metabox_product_cat', array( $this,'dahz_framework_header_skin_taxonomy_metabox' ) );

			add_action( 'dahz_framework_taxonomy_metabox_brand', array( $this,'dahz_framework_header_skin_taxonomy_metabox' ) );

			add_action( 'dahz_framework_taxonomy_metabox_product_tag', array( $this,'dahz_framework_header_skin_taxonomy_metabox' ) );

		}

		public function dahz_framework_image_thumbnail_taxonomy_metabox( $dahz_meta ) {

			$dahz_meta->dahz_framework_metabox_add_field(
				array(
					'id'			=> 'image_thumbnail',
					'type'			=> 'image_uploader',
					'title'			=> esc_html__( 'Image Thumbnail', 'kitring' ),
					'description'	=> esc_html__('Select image or pattern for thumbnail', 'kitring' ),
				)
			);

		}

		public function dahz_framework_header_skin_taxonomy_metabox( $dahz_meta ) {

			$dahz_meta->dahz_framework_metabox_add_field(
				array(
					'id'			=> 'header_transparent_skin',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Header Transparent Skin', 'kitring' ),
					'description'	=> esc_html__('According to the color scheme you choose the text colors will be changed to make it more readable. If you choose theme default the displaying will correspond to the theme options settings', 'kitring' ),
					'options'		=> array(
						'inherit'			=> esc_html__( 'Inherit', 'kitring' ),
						'no-transparency'	=> esc_html__( 'No Transparency', 'kitring' ),
						'transparent-light'	=> esc_html__( 'Light', 'kitring' ),
						'transparent-dark'	=> esc_html__( 'Dark', 'kitring' ),
					)
				)
			);

		}

		/**
		* dahz_framework_header_skin_class
		* set header skin class
		* @param $class
		* @return $class
		*/
		public function dahz_framework_header_skin_class( $attributes ) {

			$class = $this->dahz_framework_get_header_skin_class();

			if ( !empty( $class ) && $class !== 'no-transparency' ) {

				if ( isset( $attributes['class'] ) && is_string( $attributes['class'] ) ) {
					$attributes['class'] = str_replace( 'no-transparency', '', $attributes['class'] );
					$attributes['class'] .= " de-header-transparent {$class}";
				}

				$attributes['data-transparency'] = $class;

			} else {

				if ( isset( $attributes['class'] ) && is_string( $attributes['class'] ) ) $attributes['class'] .= " no-transparency";

			}

			return $attributes;

		}

		private function dahz_framework_get_header_skin_class() {

			$class = 'no-transparency';

			$is_shop = function_exists( 'is_shop' ) && is_shop();

			$is_product = function_exists( 'is_product' ) && is_product();

			if ( ( ( is_search() || is_archive() || is_404() ) /* || ( is_home() && is_front_page() ) */ ) && ( !is_post_type_archive( 'portfolio' ) ) && ( !$is_shop ) ) {

				$class = dahz_framework_get_option( 'blog_archive_header_transparency', 'no-transparency' );

			} else if ( is_home() /* && !is_front_page() */ ) {

				$class = dahz_framework_get_option( 'blog_template_header_transparency', 'no-transparency' );

			} else if ( is_singular( 'post' ) ) {

				$meta_option = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'header_transparent_skin', 'inherit' );

				$class = $meta_option !== 'inherit' ? $meta_option : dahz_framework_get_option( 'blog_single_header_transparency', 'no-transparency' );

			} else if ( is_post_type_archive( 'portfolio' ) ) {

				$class = dahz_framework_get_option( 'portfolio_archive_header_transparency', 'no-transparency' );

			} else if ( is_singular( 'portfolio' ) ) {

				$meta_option = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'header_transparent_skin', 'inherit' );

				$class = $meta_option !== 'inherit' ? $meta_option : dahz_framework_get_option( 'portfolio_single_header_transparency', 'no-transparency' );

			} else if ( $is_shop ) {

				$class = dahz_framework_get_option( 'shop_woo_header_transparency', 'no-transparency' );

			} else if ( $is_product ) {

				$meta_option = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'header_transparent_skin', 'inherit' );

				$class = $meta_option !== 'inherit' ? $meta_option : dahz_framework_get_option( 'single_woo_header_transparency', 'no-transparency' );

			} else if ( is_singular( 'page' ) ) {

				$meta_option = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'header_transparent_skin', 'inherit' );

				$class = $meta_option !== 'inherit' ? $meta_option : dahz_framework_get_option( 'page_header_transparency', 'no-transparency' );

			}

			return $class;

		}

		/**
		* dahz_framework_transparent_header_logo_light
		* set logo on header transparent light
		* @param $light_logo
		* @return $light_logo
		*/
		public function dahz_framework_transparent_header_logo_light( $light_logo, $logo_normal ) {

			$logo_light_normal = dahz_framework_get_option( 'logo_and_site_identity_logo_light_normal', get_template_directory_uri() . '/assets/images/logo/light-logo.svg' );

			$logo_light_retina = dahz_framework_get_option( 'logo_and_site_identity_logo_light_retina', get_template_directory_uri() . '/assets/images/logo/light-logo.svg' );

			if ( !empty( $logo_light_normal ) || !empty( $logo_light_retina ) ) {

				$logo = sprintf( '
					<a href="%4$s" rel="home">
						<img src="%1$s" data-src-2x="%2$s" data-src-3x="%2$s" alt="%3$s" />
					</a>
					',
					!empty( $logo_light_normal ) ? esc_url( $logo_light_normal ) : esc_url( $logo_light_retina ),
					!empty( $logo_light_retina ) ? esc_url( $logo_light_retina ) : esc_url( $logo_light_normal ),
					esc_html__('Site Logo', 'kitring' ),
					esc_url( home_url( '/' ) )
				);

			} else {

				$logo = $logo_normal;

			}

			return sprintf(
				'
				<div class="de-header__logo-media de-header__logo-media--light">
					%1$s
				</div>
				',
				$logo
			);

		}

		/**
		* dahz_framework_transparent_header_logo_dark
		* set logo on header transparent dark
		* @param $dark_logo
		* @return $dark_logo
		*/
		public function dahz_framework_transparent_header_logo_dark( $dark_logo, $logo_normal ) {

			$logo_light_normal = dahz_framework_get_option( 'logo_and_site_identity_logo_dark_normal', get_template_directory_uri() . '/assets/images/logo/default-logo.svg' );

			$logo_light_retina = dahz_framework_get_option( 'logo_and_site_identity_logo_dark_retina', get_template_directory_uri() . '/assets/images/logo/default-logo.svg' );

			if ( !empty( $logo_light_normal ) || !empty( $logo_light_retina ) ) {

				$logo = sprintf( '
					<a href="%4$s" rel="home">
						<img src="%1$s" data-src-2x="%2$s" data-src-3x="%2$s" alt="%3$s" />
					</a>
					',
					!empty( $logo_light_normal ) ? esc_url( $logo_light_normal ) : esc_url( $logo_light_retina ),
					!empty( $logo_light_retina ) ? esc_url( $logo_light_retina ) : esc_url( $logo_light_normal ),
					esc_html__('Site Logo', 'kitring' ),
					esc_url( home_url( '/' ) )
				);

			} else {

				$logo = $logo_normal;

			}

			return sprintf(
				'
				<div class="de-header__logo-media de-header__logo-media--dark">
					%1$s
				</div>
				',
				$logo
			);

		}

	}

	new Dahz_Framework_Header_Transparent();

}