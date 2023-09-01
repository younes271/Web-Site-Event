<?php

	if( !class_exists( 'Dahz_Framework_Header_Logo_And_Site_Identity' ) ) {

		/**
		* Header Style
		*/

		class Dahz_Framework_Header_Logo_And_Site_Identity {

			function __construct(){
				
				add_action( 'dahz_framework_module_header-logo-and-site-identity_init', array( $this, 'dahz_framework_header_logo_and_site_identity_init' ) );

				add_filter( 'dahz_framework_attributes_header_section_1_container_args', array( $this, 'dahz_framework_header_section_container_args' ), 10 );
				
				add_filter( 'dahz_framework_attributes_header_section_2_container_args', array( $this, 'dahz_framework_header_section_container_args' ), 10 );

				add_filter( 'dahz_framework_attributes_header_section_3_container_args', array( $this, 'dahz_framework_header_section_container_args' ), 10 );

				
			}
			
			public function dahz_framework_header_logo_and_site_identity_init( $path ){
			
				if ( is_customize_preview() ) dahz_framework_include( $path . '/header-logo-and-site-identity-customizer.php' );

				dahz_framework_register_customizer(
					'Dahz_Framework_Header_Logo_And_Site_Identity_Customizer',
					array(
						'id'	=> 'logo_and_site_identity',
						'title'	=> array( 'title' => esc_html__( 'Logo & Site Identity', 'kitring' ), 'priority' => 3 ),
						'panel'	=> 'header'
					),
					array()
				);
				
			}

			public function dahz_framework_header_section_container_args( $attributes ){

				$is_header_fullwidth = dahz_framework_get_option( 'logo_and_site_identity_is_header_fullwidth', false );
				
				if( $is_header_fullwidth ){
					$attributes['class'][] = 'uk-container-expand';
				}

				return $attributes;

			}

		}

		new Dahz_Framework_Header_Logo_And_Site_Identity();

	}
