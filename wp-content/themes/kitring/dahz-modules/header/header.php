<?php

if( !class_exists( 'Dahz_Framework_Header' ) ){

	Class Dahz_Framework_Header{

		public $header_vertical_sections = array();

		public $path = '';

		public function __construct(){

			add_action( 'dahz_framework_module_header_init', array( $this, 'dahz_framework_header_init' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_header_default_style' ) );

		}

		public function dahz_framework_header_init( $path ){

			$this->path = $path;

		}

		/**
		* dahz_framework_header_default_style
		* set header style
		* @param $dv_default_styles
		* @return $dv_default_styles
		*/
		public function dahz_framework_header_default_style( $default_styles ){

			$default_styles .= sprintf(
				'
				.de-header__logo-media {
					padding-top: %1$spx;
					padding-bottom: %2$spx;
				}
				',
				(int)dahz_framework_get_option( 'logo_and_site_identity_logo_padding_top', '10' ),
				(int)dahz_framework_get_option( 'logo_and_site_identity_logo_padding_bottom', '10' )

			);

			return $default_styles;

		}

	}

	new Dahz_Framework_Header();

}