<?php

if( !class_exists( 'Dahz_Framework_General_Global' ) ){

	Class Dahz_Framework_General_Global{

		public function __construct(){

			add_action( 'dahz_framework_module_general-global_init', array( $this, 'dahz_framework_general_global_init' ) );

			add_action( 'dahz_framework_footer_content', 'dahz_framework_render_backtotop' );

			add_filter( 'body_class', array( $this, 'dahz_framework_totop_active' ) );
			
			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_global_style' ) );

		}

		public function dahz_framework_general_global_init( $path ){

			if ( is_customize_preview() ){
				dahz_framework_include( $path . '/general-global-customizers.php' );
				dahz_framework_include( $path . '/style-customizers.php' );
			}
			
			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_General_Global_Customizer',
				array(
					'id'	=> 'global',
					'title' => array( 'title' => esc_html__( 'Global', 'kitring' ), 'priority' => 1 ),
					'panel'	=> 'general'
				),
				array()
			);
			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Inverse_Customizer',
				array(
					'id'	=> 'inverse',
					'title'	=> array( 'title' => esc_html__( 'Inverse', 'kitring' ), 'priority' => 2 ),
					'panel'	=> 'style'
				),
				array()
			);
			
			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Form_Customizer',
				array(
					'id'	=> 'form',
					'title' => array( 'title' => esc_html__( 'Form', 'kitring' ) ),
					'panel'	=> 'style'
				),
				array()
			);
			
			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Color_Button_Customizer',
				array(
					'id'	=> 'color_button',
					'title'	=> array( 'title' => esc_html__( 'Button', 'kitring' ), 'priority' => 2 ),
					'panel'	=> 'style'
				),
				array()
			);
			
			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Offcanvas_Customizer',
				array(
					'id'	=> 'offcanvas',
					'title'	=> array( 'title' => esc_html__( 'Offcanvas', 'kitring' ), 'priority' => 3 ),
					'panel'	=> 'style'
				),
				array()
			);

		}
		public function dahz_framework_totop_active( $classes ){

			if ( dahz_framework_get_option( 'woocommerce_demo_store', false ) ) {

				$classes[] = 'demo-store-active';

			}
			
			if ( dahz_framework_get_option( 'global_enable_back_to_top', true ) ) {

				$classes[] = 'enable-back-to-top';

			}

			return $classes;

		}
		
		public function dahz_framework_global_style( $styles ){
			
			$enable_uppercase_widget_title = dahz_framework_get_option( 'global_global_widget_title', false );
			
			if( $enable_uppercase_widget_title ){
				
				$styles .= '.widgettitle, .widget-title{text-transform:uppercase;}';
				
			}
			
			return $styles;
			
		}

	}

	new Dahz_Framework_General_Global();

}
