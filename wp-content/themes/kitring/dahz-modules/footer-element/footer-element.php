<?php

if( !class_exists( 'Dahz_Framework_Footer_Element' ) ){

	Class Dahz_Framework_Footer_Element {

		public function __construct(){

			add_action( 'dahz_framework_module_footer-element_init', array( $this, 'dahz_framework_footer_element_init' ) );

			add_filter( 'dahz_framework_customize_footer_builder_items', array( $this, 'dahz_framework_footer_lists' ) );

			add_filter( 'dahz_framework_default_styles'	, array( $this, 'dahz_framework_footer_element_style' ), 20, 1 );

			add_filter( 'dahz_framework_attributes_footer_section_container_args', array( $this, 'dahz_framework_footer_section_container_args' ), 10 );

		}

		public function dahz_framework_footer_section_container_args( $attributes ){

			$is_footer_fullwidth = dahz_framework_get_option( 'footer_element_is_footer_fullwidth', false );

			if( $is_footer_fullwidth )
				$attributes['class'][] = 'uk-container-expand';

			return $attributes;

		}

		public function dahz_framework_footer_element_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/footer-element-customizer.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Footer_Element_Customizer',
				array(
					'id'	=> 'footer_element',
					'title' => esc_html__( 'Footer Element', 'kitring' ) ,
					'panel'	=> 'footer'
				),
				array()
			);

		}

		public function dahz_framework_footer_element_style( $style ) {

			$style .= sprintf(
				'
				.de-footer__site-info p{
					font-size:%1$s;
				}
				',
				dahz_framework_get_option( 'footer_element_footer_site_info_font_size', '14px' )
			);

			return $style;

		}

		public function dahz_framework_footer_lists( $items ){

			$items['payment_logo'] = array(
				'title'				=> esc_html__( 'Payment Logo', 'kitring' ),
				'description'		=> esc_html__( 'Display payment option', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_payment_logo' ),
				'section_callback'	=> 'footer_element',
				'is_repeatable'		=> false
			);

			$items['footer_logo'] = array(
				'title'				=> esc_html__( 'Footer Logo', 'kitring' ),
				'description'		=> esc_html__( 'Display Footer Logo', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_footer_logo' ),
				'section_callback'	=> 'footer_element',
				'is_repeatable'		=> false
			);

			return $items;

		}

		function dahz_framework_footer_logo( $builder_type, $section, $row, $column ){

			global $dahz_framework;

			$site_logo = dahz_framework_get_option( 'footer_element_logo_normal', get_template_directory_uri() . '/assets/images/logo/light-logo.svg' );

			$site_logo_retina = dahz_framework_get_option( 'footer_element_logo_retina', get_template_directory_uri() . '/assets/images/logo/light-logo.svg' );

			if( empty( $site_logo ) && empty( $site_logo_retina ) ) return;

			echo apply_filters(
				'dahz_framework_footer_logo',
				sprintf(
					'
					<a href="%4$s" rel="home">
						<img src="%1$s" data-src-2x="%2$s" data-src-3x="%2$s" alt="%3$s" />
					</a>
					',
					!empty( $site_logo ) ? esc_url( $site_logo ) : esc_url( $site_logo_retina ),
					!empty( $site_logo_retina ) ? esc_url( $site_logo_retina ) : esc_url( $site_logo ),
					esc_html__('Footer Logo', 'kitring' ),
					esc_url( home_url( '/' ) )
				)
			);

		}

		public function dahz_framework_payment_logo() {

			$image_normal = dahz_framework_get_option( 'footer_element_payment_logo_normal', '' );

			$image_retina = dahz_framework_get_option( 'footer_element_payment_logo_retina', '' );

			$placeholder = get_template_directory_uri() . '/assets/images/img-loader.png';

			if( !empty( $image_normal ) || !empty( $image_retina ) ){

				printf( '
					<div>
						<img src="%1$s" data-src-2x="%2$s" data-src-3x="%2$s" alt="%3$s" />
					</div>
					',
					!empty( $image_normal ) ? esc_url( $image_normal ) : esc_url( $image_retina ),
					!empty( $image_retina ) ? esc_url( $image_retina ) : esc_url( $image_normal ),
					esc_html__('Payment Logo', 'kitring' ),
					esc_url( $placeholder )
				);

			}

		}
	}

	new Dahz_Framework_Footer_Element();

}