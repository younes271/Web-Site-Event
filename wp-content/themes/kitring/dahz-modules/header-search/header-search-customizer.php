<?php

if ( !class_exists( 'Dahz_Framework_Header_Search_Customizer' ) ) {

	Class Dahz_Framework_Header_Search_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer() {

			$transport = array(
				'selector'        => '#de-site-header',
				'render_callback' => 'dahz_framework_get_header'
			);

			$helper_brand = class_exists( 'Dahz_Framework_Woo_Extender_Brand' ) ? Kirki_Helper::get_terms( array( 'taxonomy' => 'brand' ) ) : array( '0' => 'Empty' );
			$helper_cat   = class_exists( 'Woocommerce' ) ? Kirki_Helper::get_terms( array( 'taxonomy' => 'product_cat' ) ) : array( '0' => 'Empty' );

			$helper_brand = array( '0' => 'Empty' ) + $helper_brand;
			$helper_cat   = array( '0' => 'Empty' ) + $helper_cat;

			$dv_field = array();

			$dv_field[] = array(
				'type'        => 'radio-image',
				'settings'    => 'style',
				'label'       => esc_html__( 'Search Style', 'kitring' ),
				'description' => esc_html__('Select type of search displayed on header', 'kitring' ),
				'default'     => 'as-text-icon',
				'priority'    => 11,
				'choices'     => array(
					'text'      => get_template_directory_uri() . '/assets/images/customizer/df_search-style-1.svg',
					'icon'      => get_template_directory_uri() . '/assets/images/customizer/df_search-style-2.svg',
					'icon-right'=> get_template_directory_uri() . '/assets/images/customizer/df_search-style-3.svg',
					'text-icon' => get_template_directory_uri() . '/assets/images/customizer/df_search-style-4.svg',
					'icon-text' => get_template_directory_uri() . '/assets/images/customizer/df_search-style-5.svg',
				),
				'partial_refresh' => array(
					'header_search_style' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'enable_uppercase',
				'label'    => esc_html__( 'Uppercase text', 'kitring' ),
				'default'  => '0',
				'priority' => 11,
				'partial_refresh' => array(
					'header_search_enable_uppercase' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'desktop_font_size',
				'label'    => esc_html__( 'Desktop text font size', 'kitring' ),
				'description'=> __( 'Set your text size(px) . Default is 18px', 'kitring' ),
				'priority' => 11,
				'default'  => '18px',
				'partial_refresh' => array(
					'header_search_desktop_font_size' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'text',
				'settings' => 'desktop_icon_ratio',
				'label'    => esc_html__( 'Desktop Icon Ratio', 'kitring' ),
				'description'=> __( 'Enter a size ratio, if you want the icon to appear larger than the default size, for example 1.5 or 2 to double the size', 'kitring' ),
				'priority' => 11,
				'default'  => '1',
				'partial_refresh' => array(
					'header_search_desktop_icon_ratio' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'mobile_font_size',
				'description'=> __( 'Set your text size(px) . Default is 18px', 'kitring' ),
				'label'    => esc_html__( 'Mobile text font size', 'kitring' ),
				'priority' => 11,
				'default'  => '18px',
				'partial_refresh' => array(
					'header_search_mobile_font_size' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'text',
				'settings' => 'mobile_icon_ratio',
				'description'=> __( 'Enter a size ratio, if you want the icon to appear larger than the default size, for example 1.5 or 2 to double the size', 'kitring' ),
				'label'    => esc_html__( 'Mobile Icon Ratio', 'kitring' ),
				'priority' => 11,
				'default'  => '1',
				'partial_refresh' => array(
					'header_search_mobile_icon_ratio' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'multicheck',
				'settings' => 'post_type',
				'label'    => esc_html__( 'Search Query', 'kitring' ),
				'default'  => array( 'post', 'page' ),
				'priority' => 11,
				'choices'  => array(
					'product' 	=> esc_attr__( 'Product', 'kitring' ),
					'post' 		=> esc_attr__( 'Post', 'kitring' ),
					'portfolio' => esc_attr__( 'Portfolio', 'kitring' ),
					'page' 		=> esc_attr__( 'Page', 'kitring' )
				),
				'partial_refresh' => array(
					'header_search_post_type' => $transport
				)
			);

			return $dv_field;

		}

	}

}