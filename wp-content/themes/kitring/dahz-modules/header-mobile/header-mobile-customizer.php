<?php
if( !class_exists( 'Dahz_Framework_Header_Mobile_Customizer' ) ){

	Class Dahz_Framework_Header_Mobile_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer(){

			$dv_field = array();
			//mobile_header
			$transport = array(
				'selector' 		  => '#de-site-header',
				'render_callback' => 'dahz_framework_get_header'
			);
			
			$dv_field[] = array(
				'type'        => 'image',
				'settings'    => 'logo_normal',
				'label'       => esc_html__( 'Upload Logo Mobile', 'kitring' ),
				'description' => esc_html__('Upload custom logo.', 'kitring' ),
				'default'     => get_template_directory_uri() . '/assets/images/logo/default-logo.svg',
				'priority'    => 11,
				'partial_refresh' => array(
					'mobile_header_logo_normal' => $transport
				)
			);

			$dv_field[] = array(
				'type'        => 'image',
				'settings'    => 'logo_retina',
				'label'       => esc_html__( 'Upload Retina Logo Sticky', 'kitring' ),
				'description' => esc_html__('Upload custom retina logo.', 'kitring' ),
				'default'     => get_template_directory_uri() . '/assets/images/logo/default-logo.svg',
				'priority'    => 11,
				'partial_refresh' => array(
					'mobile_header_logo_retina' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'        => 'dimension',
				'settings'    => 'logo_height',
				'label'       => esc_html__( 'Mobile Logo Height', 'kitring' ),
				'description' => esc_html__('Define your logo height on mobile area', 'kitring' ),
				'default'     => '30px',
				'priority'    => 11,
				'partial_refresh' => array(
					'mobile_header_logo_height' => $transport
				)
			);

			$dv_field[] = array(
				'type'     => 'slider',
				'settings' => 'logo_padding_top',
				'label'    => esc_html__( 'Mobile Logo Padding Top', 'kitring' ),
				'priority' => 11,
				'default'  => '10',
				'choices'  => array(
					'min'  => '0',
					'max'  => '50',
					'step' => '1',
				),
				'partial_refresh' => array(
					'mobile_header_logo_padding_top' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'     => 'slider',
				'settings' => 'logo_padding_bottom',
				'label'    => esc_html__( 'Mobile Logo Padding Bottom', 'kitring' ),
				'priority' => 11,
				'default'  => '10',
				'choices'  => array(
					'min'  => '0',
					'max'  => '50',
					'step' => '1',
				),
				'partial_refresh' => array(
					'mobile_header_logo_padding_bottom' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'		=> 'select',
				'settings'	=> 'menu_style',
				'priority'	=> 11,
				'label'		=> esc_html__( 'Menu Style', 'kitring' ),
				'default'	=> 'off-canvas',
				'choices'	=> array(
					'off-canvas'	=> __( 'Off Canvas', 'kitring' ),
					'modal'			=> __( 'Modal', 'kitring' )
				),
				'partial_refresh' => array(
					'mobile_header_menu_style' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'		=> 'select',
				'settings'	=> 'off_canvas_animation',
				'priority'	=> 11,
				'label'		=> esc_html__( 'Animation Modes', 'kitring' ),
				'default'	=> 'slide',
				'choices'	=> array(
					'slide'	=> __( 'Slide', 'kitring' ),
					'push'	=> __( 'Push', 'kitring' ),
					'reveal'=> __( 'Reveal', 'kitring' ),
				),
				'partial_refresh' => array(
					'mobile_header_off_canvas_animation' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'		=> 'checkbox',
				'settings'	=> 'off_canvas_right',
				'priority'	=> 11,
				'label'		=> esc_html__( 'Display on the right', 'kitring' ),
				'default'	=> '1',
				'partial_refresh' => array(
					'mobile_header_off_canvas_right' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'     => 'text',
				'settings' => 'icon_ratio',
				'label'    => esc_html__( 'Mobile Icon Ratio( burger menu )', 'kitring' ),
				'description'=> __( 'Enter a size ratio, if you want the icon to appear larger than the default size, for example 1.5 or 2 to double the size', 'kitring' ),
				'priority' => 11,
				'default'  => '1',
				'partial_refresh' => array(
					'mobile_header_icon_ratio' => $transport
				)
			);
						
			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'primary_menu_font_size',
				'label'    => esc_html__( 'Mobile Primary Menu Font Size', 'kitring' ),
				'default'  => '14px',
				'priority' => 11,
				'partial_refresh' => array(
					'mobile_header_primary_menu_font_size' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'enable_primary_menu_uppercase',
				'label'    => esc_html__( 'Uppercase text', 'kitring' ),
				'default'  => '0',
				'priority' => 11,
				'partial_refresh' => array(
					'mobile_header_enable_primary_menu_uppercase' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'megamenu_title_font_size',
				'label'    => esc_html__( 'Mobile Mega menu title Font Size', 'kitring' ),
				'default'  => '14px',
				'priority' => 11,
				'partial_refresh' => array(
					'mobile_header_megamenu_title_font_size' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'enable_megamenu_title_uppercase',
				'label'    => esc_html__( 'Uppercase text', 'kitring' ),
				'default'  => '0',
				'priority' => 11,
				'partial_refresh' => array(
					'mobile_header_enable_uppercase' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'dropdown_menu_font_size',
				'label'    => esc_html__( 'Mobile Secondary Menu & Dropdown Font Size', 'kitring' ),
				'default'  => '14px',
				'priority' => 11,
				'partial_refresh' => array(
					'mobile_header_dropdown_menu_font_size' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'enable_dropdown_uppercase',
				'label'    => esc_html__( 'Uppercase Text', 'kitring' ),
				'default'  => '0',
				'priority' => 11,
				'partial_refresh' => array(
					'mobile_header_enable_dropdown_uppercase' => $transport
				)
			);
			
			$dv_field[] = array(
				'type'     => 'color',
				'choices'     => array(
					'alpha' => true,
				),
				'settings' => 'color',
				'label'    => esc_html__( 'Mobile Element Color', 'kitring' ),
				'default'  => '#000000',
				'priority' => 11,
				'choices'     => array(
					'alpha' => true,
				)
			);
			
			$dv_field[] = array(
				'type'     => 'color',
				'choices'     => array(
					'alpha' => true,
				),
				'settings' => 'hover_color',
				'label'    => esc_html__( 'Mobile Element Hover Color', 'kitring' ),
				'default'  => '#ffffff',
				'priority' => 11,
				'choices'     => array(
					'alpha' => true,
				)
			);
			
			$dv_field[] = array(
				'type'     => 'color',
				'choices'     => array(
					'alpha' => true,
				),
				'settings' => 'background_color',
				'label'    => esc_html__( 'Mobile Background Color', 'kitring' ),
				'default'  => '#ffffff',
				'priority' => 11,
				'choices'     => array(
					'alpha' => true,
				)
			);

			

			$dv_field[] = array(
				'type'     => 'color',
				'choices'     => array(
					'alpha' => true,
				),
				'settings' => 'divider_color',
				'label'    => esc_html__( 'Mobile Divider Color', 'kitring' ),
				'default'  => '#F8F8F8',
				'priority' => 11,
				'choices'     => array(
					'alpha' => true,
				)
			);
			
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'content_block',
				'label'       => esc_html__( 'Custom Content Block', 'kitring' ),
				'description' => esc_html__('Display a custom area content block', 'kitring' ),
				'default'     => '',
				'priority'    => 11,
				'choices'     => dahz_framework_get_content_block(),
				'partial_refresh' => array(
					'mobile_header_content_block' => $transport
				)
			);

			$items = apply_filters( 'dahz_framework_header_mobile_elements', array() );
			
			$mobile_elements = array();
			
			foreach ($items as $id => $item) {
				
				$mobile_elements[$id] = $item['title'];
			
			}
			
			$dv_field[] = array(
				'type'        => 'sortable',
				'settings'    => 'mobile_menu_element',
				'label'       => esc_html__( 'Mobile Menu Element', 'kitring' ),
				'description' => esc_html__('Display your element on mobile burger menu. Background setting will be the same with dropdown menu', 'kitring' ),
				'multiple'    => 999,
				'choices'     => $mobile_elements,
				'priority'    => 11,
				'partial_refresh' => array(
					'mobile_header_mobile_menu_element' => $transport
				)

			);

			return $dv_field;

		}

	}

}