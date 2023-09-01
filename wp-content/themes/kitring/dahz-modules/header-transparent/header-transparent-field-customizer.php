<?php

if( !class_exists( 'Dahz_Framework_Header_Transparent_Field_Customizers' ) ){

	Class Dahz_Framework_Header_Transparent_Field_Customizers extends Dahz_Framework_Customizer{

		public function __construct(){

			$sections = array(
				'blog_archive',
				'blog_single',
				'blog_template',
				'single_woo',
				'shop_woo',
				'portfolio_archive',
				'portfolio_single',
				'page'
			);
			foreach( $sections as $section ){

				$this->dahz_framework_set_field_header_transparent( $section );

			}
			$this->dahz_framework_header_transparent_logo();

		}

		public function dahz_framework_set_field_header_transparent( $section ){

			$field = $this->dahz_framework_header_transparent_fields( $section );

			$field[] = array(
				'type'     => 'custom',
				'settings' => "custom_title_{$section}_header_transparent",
				'label'    => '',
				'default'  => '<div class="de-customizer-title">'. esc_html__('Header Transparency', 'kitring' ) .'</div>',
				'priority' => 0,
			);

			$this->dahz_framework_add_field_customizer( $section, $field );

		}

		private function dahz_framework_header_transparent_fields( $section = '' ){

			$field = array();

			$field[] = array(
				'type'				=> 'select',
				'settings'			=> 'header_transparency',
				'label'				=> __( 'Header Transparency', 'kitring' ),
				'default'			=> 'normal',
				'priority'			=> 1,
				'choices'   		=> array(
					'no-transparency'	=> __( 'No Transparent', 'kitring' ),
					'transparent-light' => __( 'Light', 'kitring' ),
					'transparent-dark' 	=> __( 'Dark', 'kitring' ),
				),
				'description' 		=> __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			$this->dahz_framework_add_field_customizer( $section, $field );
		}

		private function dahz_framework_header_transparent_logo(){

			$dv_field = array();

			$dv_field[] = array(
				'type'     => 'custom',
				'settings' => 'custom_title_logo_light',
				'label'    => '',
				'default'  => '<div class="de-customizer-title">'. esc_html__( 'Light Logo', 'kitring' ).'</div>',
				'priority' => 14,
			);
			$dv_field[] = array(
				'type'     => 'image',
				'settings' => 'logo_light_normal',
				'label'    => esc_html__( 'Upload Logo - Light', 'kitring' ),
				'description'		=> esc_html__( 'Upload your custom logo.', 'kitring' ),
				'default'  => get_template_directory_uri() . '/assets/images/logo/light-logo.svg',
				'priority' => 14,
			);
			$dv_field[] = array(
				'type'     => 'image',
				'settings' => 'logo_light_retina',
				'label'    => esc_html__( 'Upload Retina Logo - Light', 'kitring' ),
				'description'		=> esc_html__( 'Upload your custom retina logo.', 'kitring' ),
				'default'  => get_template_directory_uri() . '/assets/images/logo/light-logo.svg',
				'priority' => 14,
			);
			$dv_field[] = array(
				'type'     => 'image',
				'settings' => 'logo_dark_normal',
				'label'    => esc_html__( 'Upload Logo - Dark', 'kitring' ),
				'description'		=> esc_html__( 'Upload your custom logo.', 'kitring' ),
				'default'  => get_template_directory_uri() . '/assets/images/logo/default-logo.svg',
				'priority' => 15,
			);
			$dv_field[] = array(
				'type'     => 'image',
				'settings' => 'logo_dark_retina',
				'label'    => esc_html__( 'Upload Retina Logo - Dark', 'kitring' ),
				'description'		=> esc_html__( 'Upload your custom retina logo.', 'kitring' ),
				'default'  => get_template_directory_uri() . '/assets/images/logo/default-logo.svg',
				'priority' => 15,
			);

			$this->dahz_framework_add_field_customizer( 'logo_and_site_identity', $dv_field );
		}

	}

	new Dahz_Framework_Header_Transparent_Field_Customizers();

}