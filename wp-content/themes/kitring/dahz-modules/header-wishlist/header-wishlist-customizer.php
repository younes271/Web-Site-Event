<?php
if( !class_exists( 'Dahz_Framework_Header_Wishlist_Customizer' ) ){

	Class Dahz_Framework_Header_Wishlist_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer(){
			//header_wishlist
			$dv_field = array();

			$transport = array(
				'selector' 		  => '#de-site-header',
				'render_callback' => 'dahz_framework_get_header'
			);

			$dv_field[] = array(
				'type'        => 'radio-image',
				'settings'    => 'style',
				'label'       => esc_html__( 'Wishlist Style', 'kitring' ),
				'description' => esc_html__('Select type of wishlist style do you want to use', 'kitring' ),
				'default'     => 'style-3',
				'priority'    => 11,
				'choices'     => array(
					'style-1'	=> get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-1.svg',
					'style-2'	=> get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-2.svg',
					'style-3' 	=> get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-3.svg',
					'style-4'   => get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-4.svg',
					'style-5'   => get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-5.svg',
					'style-6' 	=> get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-6.svg',
					'style-7' 	=> get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-7.svg',
					'style-8' 	=> get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-8.svg',
					'style-9' 	=> get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-9.svg',
					'style-10' 	=> get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-10.svg',
					'style-11' 	=> get_template_directory_uri() . '/assets/images/customizer/df_wishlist-style-11.svg',
				),
				'partial_refresh' => array(
					'header_wishlist_style' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'enable_uppercase',
				'label'    => esc_html__( 'Enable Uppercase Text', 'kitring' ),
				'default'  => '0',
				'priority' => 11,
				'partial_refresh' => array(
					'header_wishlist_enable_uppercase' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'desktop_font_size',
				'label'    => esc_html__( 'Desktop Font Size', 'kitring' ),
				'priority' => 11,
				'default'  => '18px',
				'partial_refresh' => array(
					'header_wishlist_desktop_font_size' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'text',
				'settings' => 'desktop_icon_ratio',
				'label'    => esc_html__( 'Desktop Icon Ratio', 'kitring' ),
				'priority' => 11,
				'default'  => '1',
				'partial_refresh' => array(
					'header_wishlist_desktop_icon_ratio' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'mobile_font_size',
				'label'    => esc_html__( 'Mobile Font Size', 'kitring' ),
				'priority' => 11,
				'default'  => '18px',
				'partial_refresh' => array(
					'header_wishlist_mobile_font_size' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'text',
				'settings' => 'mobile_icon_ratio',
				'label'    => esc_html__( 'Mobile Icon Ratio', 'kitring' ),
				'priority' => 11,
				'default'  => '1',
				'partial_refresh' => array(
					'header_wishlist_mobile_icon_ratio' => $transport
				)
			);

			$dv_field[] = array(
				'type'       => 'color',
				'choices'     => array(
					'alpha' => true,
				),
				'settings'   => 'counter_color',
				'label'      => __( 'Counter Text Color', 'kitring' ),
				'default'    => '#ffffff',
				'priority'	 => 11,
				'transport'  => 'postMessage',
				'js_vars'    => array(
					array(
						'element'  => '.de-featured-area,.de-archive__header,.de-page__header,#de-archive-content.de-content-boxed,#de-archive-content.de-content-framed,#de-archive-content.de-content-fullwidth,#page.de-content-fullwidth,.de-page.de-content-boxed,.de-page.de-content-framed,.de-page.de-content-fullwidth,.de-single.de-content-boxed,.de-single.de-content-framed,.de-single.de-content-fullwidth,.de-404.de-content-boxed,.de-404.de-content-framed,.de-404.de-content-fullwidth,.calista,.coralie,.centaur,.catalina,.cloe,.de-portfolio-single,.de-sc-post-carousel__content,#de-product-container',
						'function' => 'css',
						'property' => 'background-color'
					),
				)
			);
			$dv_field[] = array(
				'type'       => 'color',
				'choices'     => array(
					'alpha' => true,
				),
				'settings'   => 'counter_bg_color',
				'label'      => __( 'Counter Background Color', 'kitring' ),
				'default'    => '#ff0000',
				'priority'	 => 11,
				'transport'  => 'postMessage',
				'js_vars'    => array(
					array(
						'element'  => '.de-featured-area,.de-archive__header,.de-page__header,#de-archive-content.de-content-boxed,#de-archive-content.de-content-framed,#de-archive-content.de-content-fullwidth,#page.de-content-fullwidth,.de-page.de-content-boxed,.de-page.de-content-framed,.de-page.de-content-fullwidth,.de-single.de-content-boxed,.de-single.de-content-framed,.de-single.de-content-fullwidth,.de-404.de-content-boxed,.de-404.de-content-framed,.de-404.de-content-fullwidth,.calista,.coralie,.centaur,.catalina,.cloe,.de-portfolio-single,.de-sc-post-carousel__content,#de-product-container',
						'function' => 'css',
						'property' => 'background-color'
					),
				)
			);


			return $dv_field;

		}

	}

}
