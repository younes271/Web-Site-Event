<?php

if( !class_exists( 'Dahz_Framework_Header_Cart_Customizer' ) ){

	Class Dahz_Framework_Header_Cart_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer(){

			$transport = array(
				'selector' 		  => '#de-site-header',
				'render_callback' => 'dahz_framework_get_header'
			);

			$dv_field = array();

			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'display_as',
				'label'       => esc_html__( 'Display Cart as', 'kitring' ),
				'description' => esc_html__('select type of cart layout displayed on header', 'kitring' ),
				'default'     => 'as-sidebar',
				'priority'    => 11,
				'choices'     => array(
					'as-link'     => __( 'As Link', 'kitring' ),
					'as-dropdown' => __( 'Dropdown', 'kitring' ),
					'as-sidebar'  => __( 'Off Canvas', 'kitring' ),
				),
				'partial_refresh' => array(
					'header_cart_display_as' => $transport
				)
			);

			$dv_field[] = array(
				'type'        => 'radio-image',
				'settings'    => 'style',
				'label'       => esc_html__( 'Cart Style', 'kitring' ),
				'description' => esc_html__('Select cart style displayed on header', 'kitring' ),
				'default'     => 'style-3',
				'priority'    => 11,
				'choices'     => array(
					'style-1'	=> get_template_directory_uri() . '/assets/images/customizer/df_cart-style-1.svg',
					'style-2'	=> get_template_directory_uri() . '/assets/images/customizer/df_cart-style-2.svg',
					'style-3' 	=> get_template_directory_uri() . '/assets/images/customizer/df_cart-style-3.svg',
					'style-4'   => get_template_directory_uri() . '/assets/images/customizer/df_cart-style-4.svg',
					'style-5'   => get_template_directory_uri() . '/assets/images/customizer/df_cart-style-5.svg',
					'style-6' 	=> get_template_directory_uri() . '/assets/images/customizer/df_cart-style-6.svg',
					'style-7' 	=> get_template_directory_uri() . '/assets/images/customizer/df_cart-style-7.svg',
				),
				'partial_refresh' => array(
					'header_cart_style' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'desktop_font_size',
				'label'    => esc_html__( 'Desktop Font Size', 'kitring' ),
				'description'=> __( 'Set your text size(px) . Default is 18px', 'kitring' ),
				'priority' => 11,
				'default'  => '18px',
				'partial_refresh' => array(
					'header_cart_desktop_font_size' => $transport
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
					'header_cart_desktop_icon_ratio' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'mobile_font_size',
				'label'    => esc_html__( 'Mobile Font Size', 'kitring' ),
				'description'=> __( 'Set your text size(px) . Default is 18px', 'kitring' ),
				'priority' => 11,
				'default'  => '18px',
				'partial_refresh' => array(
					'header_cart_mobile_font_size' => $transport
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
					'header_cart_mobile_icon_ratio' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'is_show_total_price',
				'label'    => esc_html__( 'Show total price on desktop', 'kitring' ),
				'default'  => '1',
				'priority' => 11,
				'partial_refresh' => array(
					'header_cart_is_show_total_price' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'is_show_total_price_on_mobile',
				'label'    => esc_html__( 'Show total price on mobile', 'kitring' ),
				'default'  => '0',
				'priority' => 11,
				'partial_refresh' => array(
					'header_cart_is_show_total_price_on_mobile' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'enable_uppercase',
				'label'    => esc_html__( 'Uppercase Text', 'kitring' ),
				'default'  => '0',
				'priority' => 11,
				'partial_refresh' => array(
					'header_cart_enable_uppercase' => $transport
				)
			);

			$dv_field[] = array(
				'type'       => 'color',
				'choices'     => array(
					'alpha' => true,
				),
				'settings'   => 'counter_color',
				'label'      => __( 'Counter Text Color', 'kitring' ),
				'description'=> __( 'this option only for style 5,6,7', 'kitring' ),
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
				'description'=> __( 'this option only for style 5,6,7', 'kitring' ),
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

			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'content_block',
				'label'       => esc_html__( 'Content Block', 'kitring' ),
				'description' => esc_html__('Display a custom content, this element will be rendered after the cart (Display as link, not include) You can use a custom content block', 'kitring' ),
				'default'     => '',
				'priority'    => 11,
				'choices'     => dahz_framework_get_content_block(),
				'partial_refresh' => array(
					'header_cart_content_block' => $transport
				)
			);


			return $dv_field;

		}

	}

}
