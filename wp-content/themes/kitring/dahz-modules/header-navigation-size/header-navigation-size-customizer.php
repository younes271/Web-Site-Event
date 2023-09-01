<?php
if( !class_exists( 'Dahz_Framework_Header_Navigation_Size_Customizer' ) ){

	Class Dahz_Framework_Header_Navigation_Size_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer(){

			$dv_field = array();

			$transport = array(
				'selector' 		  => '#de-site-header',
				'render_callback' => 'dahz_framework_get_header'
			);

			$dv_field[] = array(
				'type'        => 'dimension',
				'settings'    => 'primary',
				'label'       => esc_html__( 'Primary Nav Size', 'kitring' ),
				'description' => esc_html__('Set your main nav size (px)', 'kitring' ),
				'default'     => '16px',
				'priority'    => 11,
				'partial_refresh' => array(
					'header_navigation_size_primary' => $transport
				)
			);

			$dv_field[] = array(
				'type'        => 'radio-image',
				'settings'    => 'primary_hover_style',
				'label'       => esc_html__( 'Primary Hover Style', 'kitring' ),
				'description' => esc_html__('Select the hover type for main navigation', 'kitring' ),
				'default'     => 'style-2',
				'priority'    => 11,
				'choices'     => array(
					'style-1' => get_template_directory_uri() . '/assets/images/customizer/df_nav-style-1.svg',
					'style-2' => get_template_directory_uri() . '/assets/images/customizer/df_nav-style-2.svg',
					'style-3' => get_template_directory_uri() . '/assets/images/customizer/df_nav-style-3.svg',
				),
				'partial_refresh' => array(
					'header_navigation_primary_hover_style' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'is_primary_uppercase_nav',
				'label'    => esc_html__( 'Enable Primary Uppercase Navigation', 'kitring' ),
				'default'  => '0',
				'priority' => 11,
				'partial_refresh' => array(
					'header_navigation_is_primary_uppercase_nav' => $transport
				)
			);

			$dv_field[] = array(
				'type'        => 'dimension',
				'settings'    => 'secondary',
				'label'       => esc_html__( 'Secondary Nav Size', 'kitring' ),
				'description' => esc_html__('Set your secondary nav size (px)', 'kitring' ),
				'default'     => '16px',
				'priority'    => 11,
				'partial_refresh' => array(
					'header_navigation_secondary' => $transport
				)
			);

			$dv_field[] = array(
				'type'        => 'radio-image',
				'settings'    => 'secondary_hover_style',
				'label'       => esc_html__( 'Secondary Hover Style', 'kitring' ),
				'description' => esc_html__('Select the hover type for secondary navigation', 'kitring' ),
				'default'     => 'style-2',
				'priority'    => 11,
				'choices'     => array(
					'style-1' => get_template_directory_uri() . '/assets/images/customizer/df_nav-style-1.svg',
					'style-2' => get_template_directory_uri() . '/assets/images/customizer/df_nav-style-2.svg',
					'style-3' => get_template_directory_uri() . '/assets/images/customizer/df_nav-style-3.svg',
				),
				'partial_refresh' => array(
					'header_navigation_secondary_primary_hover_style' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'is_secondary_uppercase_nav',
				'label'    => esc_html__( 'Enable Secondary Uppercase Navigation', 'kitring' ),
				'default'  => '0',
				'priority' => 11,
				'partial_refresh' => array(
					'header_navigation_is_secondary_primary_uppercase_nav' => $transport
				)
			);

			return $dv_field;

		}

	}

}
