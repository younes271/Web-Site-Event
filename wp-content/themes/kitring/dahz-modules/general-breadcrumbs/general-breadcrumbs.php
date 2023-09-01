<?php

if( !class_exists( 'Dahz_Framework_General_Breadcrumbs' ) ){

	Class Dahz_Framework_General_Breadcrumbs{

		public function __construct(){

			add_action( 'dahz_framework_module_general-breadcrumbs_init', array( $this, 'dahz_framework_general_breadcrumbs_init' ) );

			add_filter( 'dahz_framework_attributes_breadcrumbs_args', array( $this, 'dahz_framework_breadcrumbs_args' ) );
			
			add_filter( 'dahz_framework_attributes_breadcrumbs_link_args', array( $this, 'dahz_framework_breadcrumbs_link_args' ) );
			
		}
		
		public function dahz_framework_breadcrumbs_args( $attributes ){
			
			$is_uppercase = dahz_framework_get_option( 'general_breadcrumbs_enable_uppercase', false );
						
			$attributes['class'][] = $is_uppercase ? 'uk-text-uppercase' : '';
			
			$attributes['class'][] = dahz_framework_get_option( 'general_breadcrumbs_size' );

			return $attributes;
			
		}
		
		public function dahz_framework_breadcrumbs_link_args( $attributes ){
			
			$attributes['class'][] = dahz_framework_get_option( 'general_breadcrumbs_size' );

			return $attributes;
			
		}

		public function dahz_framework_general_breadcrumbs_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/general-breadcrumbs-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_General_Breadcrumbs_Customizer',
				array(
					'id'	=> 'general_breadcrumbs',
					'title' => array( 'title' => esc_html__( 'Breadcrumbs', 'kitring' ), 'priority' => 5 ),
					'panel'	=> 'general'
				),
				array()
			);

		}

	}

	new Dahz_Framework_General_Breadcrumbs();

}