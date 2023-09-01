<?php

if( !class_exists( 'Dahz_Framework_Header_Button' ) ){

	Class Dahz_Framework_Header_Button {

		public function __construct(){

			add_action( 'dahz_framework_module_header-button_init', array( $this, 'dahz_framework_header_button_init' ) );
			
			add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_header_item_button' ), 10, 3 );

			add_filter( 'dahz_framework_customize_headermobile_builder_items', array( $this, 'dahz_framework_header_item_button' ), 10, 3 );
			
			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_button_color_style' ) );
			
		}

		public function dahz_framework_header_button_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-button-customizer.php' );
			
			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Button_Customizer',
				array(
					'id'	=> 'header_button',
					'title'	=> array( 'title' => esc_html__( 'Button Header', 'kitring' ), 'priority' => 19 ),
					'panel'	=> 'header'
				),
				array()
			);

		}
		
		public function dahz_framework_header_item_button( $items ) {

			$items['button'] = array(
				'title'				=> esc_html__( 'Button', 'kitring' ),
				'description'		=> esc_html__( 'Display Button in Header', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_header_button_element' ),
				'section_callback'	=> 'header_button',
				'is_repeatable'		=> false
			);

			return $items;

		}
		
		public function dahz_framework_header_button_element( $builder_type, $section, $row, $column ){
			
			$button_text = dahz_framework_get_option( 'header_button_text' );
			$link_button = dahz_framework_get_option( 'header_button_link' );
			
			if( empty( $button_text ) ){return;}
			
			echo sprintf(
				'
				<a class="de-header-button uk-button uk-button-default" href="%3$s" target="%2$s">%1$s</a>
				',
				esc_html( $button_text ),
				esc_attr( dahz_framework_get_option( 'header_button_target', '_blank' ) ),
				esc_url($link_button)
			);
			
		}
		
		public function dahz_framework_button_color_style( $default_styles ) {
			
			$button_text = dahz_framework_get_option(
				'header_button_text_color',
				array(
					'regular'	=> '#333333',
					'hover'	=> '#999999'
				)
			);
			
			$button_text_regular	= $button_text['regular'];
			
			$button_text_hover	= $button_text['hover'];
			
			$button_background_color = dahz_framework_get_option(
				'header_button_background_color',
				array(
					'regular'	=> '#333333',
					'hover'	=> '#999999'
				)
			);
			
			$button_background_regular	= $button_background_color['regular'];
			
			$button_background_hover	= $button_background_color['hover'];
			
			$default_styles .= sprintf(
				'
				[data-item-id="button"] .de-btn--fill{
					background-color: %1$s;
					color: %2$s!important;
				}
				[data-item-id="button"] .de-btn--fill:hover{
					color: %3$s!important;
				}
				[data-item-id="button"] .de-btn--fill:hover::after {
					background-color: %4$s;
				}
				',
				$button_background_regular,
				$button_text_regular,
				$button_text_hover,
				$button_background_hover
			);

			return $default_styles;
		}

	}

	new Dahz_Framework_Header_Button();

}
