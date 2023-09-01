<?php

if ( !class_exists('Dahz_Framework_Header_Off_Canvas') ) {

	class Dahz_Framework_Header_Off_Canvas {

		public $content_block = false;

		function __construct() {

			add_action( 'dahz_framework_module_header-off-canvas_init', array( $this, 'dahz_framework_header_off_canvas_init' ) );

			add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_off_canvas_builder' ) );

			add_filter( 'dahz_framework_customize_headermobile_builder_items', array( $this, 'dahz_framework_off_canvas_builder' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_off_canvas_style' ) );

			add_action( 'wp_footer', array( $this, 'dahz_framework_render_offcanvas_container' ), 10 );

			add_filter( 'dahz_framework_preset_required', array( $this, 'dahz_framework_exclude_preset_required' ) );

		}

		public function dahz_framework_header_off_canvas_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-off-canvas-customizer.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Off_Canvas_Customizer',
				array(
					'id'	=> 'header_off_canvas',
					'title'	=> array( 'title' => esc_html__( 'Off Canvas', 'kitring' ), 'priority' => 10 ),
					'panel'	=> 'header'
				),
				array()
			);

		}

		public function dahz_framework_exclude_preset_required( $preset_required ){

			$preset_required['headermobile']['exclude_sections'][] = 'header_off_canvas';

			return $preset_required;

		}

		/**
		* dahz_framework_of_canvas_icon_size
		* set header off canvas style from customizer
		* @param $dv_default_styles
		* @return $dv_default_styles
		*/
		public function dahz_framework_off_canvas_style( $styles ) {
			
			$offcanvas_bg_img = dahz_framework_get_option( 'header_off_canvas_bg_image' );
			
			$bg_image = '';
			
			if( !empty( $offcanvas_bg_img ) ){
				
				$bg_image = sprintf(
					'
					#header-off-canvas .header-off-canvas__container{
						background-image: url( %1$s );
						background-position: %2$s;
						background-repeat: %3$s;
						background-size: %4$s;
					}
					',
					$offcanvas_bg_img,
					dahz_framework_get_option( 'header_off_canvas_bg_position', 'left top' ),
					dahz_framework_get_option( 'header_off_canvas_bg_repeat', 'no-repeat' ),
					dahz_framework_get_option( 'header_off_canvas_bg_size', 'auto' )
				);
				
			}
			
			$styles .= sprintf(
				'
				%2$s
				#header-off-canvas .header-off-canvas__container .uk-offcanvas-close{
					color:%3$s;
				}
				#header-off-canvas .header-off-canvas__container .uk-offcanvas-close:hover{
					color:%4$s;
				}
				',
				dahz_framework_get_option( 'header_off_canvas_bg_color', '#ffffff' ),
				$bg_image,
				dahz_framework_get_option( 'header_off_canvas_icon_close_color', '#000000' ),
				dahz_framework_get_option( 'header_off_canvas_icon_close_hover_color', '#898484' )
			);

			return $styles;

		}

		/**
		* dahz_framework_off_canvas_builder
		* register header element: offcanvas
		* @param
		* @return $items
		*/
		public function dahz_framework_off_canvas_builder( $items ){

			$items['off_canvas'] = array(
				'title'				=> esc_html__( 'Off Canvas', 'kitring' ),
				'description'		=> esc_html__( 'Display off canvas element', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_render_off_canvas' ),
				'section_callback'	=> 'header_off_canvas',
				'is_repeatable'		=> false
			);

			return $items;

		}

		/**
		* dahz_framework_render_off_canvas
		* render header element : off canvas button
		* @param -
		* @return -
		*/
		public function dahz_framework_render_off_canvas() {
			
			$desktop_icon_ratio = dahz_framework_get_option( 'header_off_canvas_desktop_icon_ratio', '1' );
			
			$mobile_icon_ratio = dahz_framework_get_option( 'header_off_canvas_mobile_icon_ratio', '1' );
			
			$desktop_icon = dahz_framework_get_option( 'header_off_canvas_desktop_icon_style', 'df_off-canvas-left' );
			
			$mobile_icon = dahz_framework_get_option( 'header_off_canvas_mobile_icon_style', 'df_off-canvas-left' );
						
			echo sprintf(
				'
				<a aria-label="%5$s" href="#" class="uk-visible@m" data-uk-icon="icon:%3$s;ratio:%1$s;" data-uk-toggle="target: #header-off-canvas"></a>
				<a aria-label="%5$s" href="#" class="uk-hidden@m" data-uk-icon="icon:%4$s;ratio:%2$s;" data-uk-toggle="target: #header-off-canvas"></a>
				',
				(float)$desktop_icon_ratio,
				(float)$mobile_icon_ratio,
				$desktop_icon,
				$mobile_icon,
				__( 'Off Canvas Button Open', 'kitring' )
			);

		}

		/**
		* dahz_framework_render_offcanvas_container
		* render header element : off canvas container
		* @param $output
		* @return $output
		*/
		public function dahz_framework_render_offcanvas_container() {

			global $dahz_framework;

			if ( isset( $dahz_framework->builder_items['off_canvas'] ) ) {
				
				$desktop_icon_ratio = dahz_framework_get_option( 'header_off_canvas_desktop_icon_ratio', '1' );
			
				$mobile_icon_ratio = dahz_framework_get_option( 'header_off_canvas_mobile_icon_ratio', '1' );
				
				echo sprintf(
					'
					<div id="header-off-canvas" data-uk-offcanvas="overlay: %4$s;mode: %5$s;flip: %2$s;">
						<div class="uk-offcanvas-bar header-off-canvas__container">
							<a aria-label="%8$s" href="#" class="uk-offcanvas-close uk-visible@m" data-uk-icon="icon:close;ratio:%6$s;"></a>
							<a aria-label="%8$s" href="#" class="uk-offcanvas-close uk-hidden@m" data-uk-icon="icon:close;ratio:%7$s;"></a>
							%3$s
						</div>
					</div>
					',
					esc_attr( dahz_framework_get_option( 'logo_and_site_identity_header_style', 'horizontal' ) ),
					dahz_framework_get_option( 'header_off_canvas_style', 'from-left' ) !== 'from-left' ? esc_attr( 'true' ) : esc_attr( 'false' ),
					dahz_framework_do_content_block( dahz_framework_get_option( 'header_off_canvas_content_block' ) ),
					dahz_framework_get_option( 'header_off_canvas_desktop_icon_ratio', true ) ? esc_attr( 'true' ) : esc_attr( 'false' ),
					esc_attr( dahz_framework_get_option( 'header_off_canvas_animation', 'slide' ) ),
					(float)$desktop_icon_ratio,
					(float)$mobile_icon_ratio,
					__( 'Off Canvas Button Close', 'kitring' )
				);

			}

		}

	}

	new Dahz_Framework_Header_Off_Canvas();

}