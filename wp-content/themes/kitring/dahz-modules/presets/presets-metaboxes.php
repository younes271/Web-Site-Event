<?php

if( !class_exists( 'Dahz_Framework_Presets_Metaboxes' ) ){


	Class Dahz_Framework_Presets_Metaboxes{

		public function __construct(){

			add_action( "dahz_framework_metabox_before_header_dahz_meta_page", array( $this, 'dahz_framework_header_presets_metabox_page' ), 9 );

			add_action( "dahz_framework_metabox_before_footer_dahz_meta_page", array( $this, 'dahz_framework_footer_presets_metabox_page' ), 5 );

			add_action( 'dahz_framework_metabox_before_header_dahz_meta_post', array( $this, 'dahz_framework_header_presets_metabox_post' ), 10 );

			add_action( 'dahz_framework_metabox_before_footer_dahz_meta_post', array( $this, 'dahz_framework_footer_presets_metabox_post' ), 17 );

			add_action( 'dahz_framework_metabox_before_header_portfolio', array( $this, 'dahz_framework_header_presets_metabox_portfolio' ), 9 );

			add_action( 'dahz_framework_metabox_before_footer_portfolio', array( $this, 'dahz_framework_footer_presets_metabox_portfolio' ), 16 );

			add_action( 'dahz_framework_metabox_before_header_dahz_meta_product', array( $this, 'dahz_framework_header_presets_metabox_product' ), 11 );

			add_action( 'dahz_framework_metabox_before_footer_dahz_meta_product', array( $this, 'dahz_framework_footer_presets_metabox_product' ), 11 );

		}

		public function dahz_framework_header_presets_metabox_page( $dahz_meta ){

			$this->dahz_framework_header_presets_metabox( $dahz_meta, 'header' );

		}

		public function dahz_framework_footer_presets_metabox_page( $dahz_meta ){

			$this->dahz_framework_footer_presets_metabox( $dahz_meta, 'footer-page' );

		}

		public function dahz_framework_header_presets_metabox_post( $dahz_meta ){

			$this->dahz_framework_header_presets_metabox( $dahz_meta, 'header-single' );

		}

		public function dahz_framework_footer_presets_metabox_post( $dahz_meta ){

			$this->dahz_framework_footer_presets_metabox( $dahz_meta, 'footer-single' );

		}

		public function dahz_framework_header_presets_metabox_portfolio( $dahz_meta ){

			$this->dahz_framework_header_presets_metabox( $dahz_meta, 'header-portfolio' );

		}

		public function dahz_framework_footer_presets_metabox_portfolio( $dahz_meta ){

			$this->dahz_framework_footer_presets_metabox( $dahz_meta, 'footer-portfolio' );

		}

		public function dahz_framework_header_presets_metabox_product( $dahz_meta ){

			$this->dahz_framework_header_presets_metabox( $dahz_meta, 'product-header' );

		}

		public function dahz_framework_footer_presets_metabox_product( $dahz_meta ){

			$this->dahz_framework_footer_presets_metabox( $dahz_meta, 'footer-product' );

		}

		public function dahz_framework_header_presets_metabox( &$dahz_meta, $section ){

			$dahz_meta->dahz_framework_metabox_add_field(
				$section,
				array(
					'id'			=> 'header_preset_saved',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Header Layout', 'kitring' ),
					'description'	=> esc_html__('Select your header preset & skin, it based from header builder you have been created before', 'kitring' ),
					'options'		=> dahz_framework_get_builder_presets_option('header'),
				)
			);

		}

		public function dahz_framework_footer_presets_metabox( &$dahz_meta, $section ){

			$dahz_meta->dahz_framework_metabox_add_field(
				$section,
				array(
					'id'			=> 'footer_preset_saved',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Footer Preset', 'kitring' ),
					'description'	=> esc_html__('Select your footer Preset, it based from footer builder you have been created before', 'kitring' ),
					'options'		=> dahz_framework_get_builder_presets_option('footer'),
					'dependencies'	=> array(
						array(
							'setting'	=> 'page_footer_type',
							'operator'	=> '==',
							'value'		=> 'footer-preset',
						),
					)
				)
			);

		}

	}

	new Dahz_Framework_Presets_Metaboxes();

}
