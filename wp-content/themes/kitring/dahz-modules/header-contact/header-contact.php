<?php

if( !class_exists( 'Dahz_Framework_Header_Contact' ) ){

	Class Dahz_Framework_Header_Contact {

		public function __construct(){

			add_action( 'dahz_framework_module_header-contact_init', array( $this, 'dahz_framework_header_contact_init' ) );

			add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_header_item_contact' ), 10, 3 );

			add_filter( 'dahz_framework_customize_headermobile_builder_items', array( $this, 'dahz_framework_header_item_contact_mobile' ), 10, 3 );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_header_item_contact_style'), 10, 1 );

		}

		public function dahz_framework_header_item_contact( $items ) {

			$items['contact'] = array(
				'title'				=> esc_html__( 'Contact', 'kitring' ),
				'description'		=> esc_html__( 'Display Contact in Header', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_header_contact_element' ),
				'section_callback'	=> 'header_contact',
				'is_repeatable'		=> false
			);

			return $items;

		}

		public function dahz_framework_header_item_contact_mobile( $items ) {

			$items['contact_mobile'] = array(
				'title'				=> esc_html__( 'Contact', 'kitring' ),
				'description'		=> esc_html__( 'Display Contact in Mobile Menu', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_header_contact_element' ),
				'section_callback'	=> 'header_contact',
				'is_repeatable'		=> false
			);

			return $items;

		}

		public function dahz_framework_header_contact_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-contact-customizer.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Contact_Customizer',
				array(
					'id'	=> 'header_contact',
					'title'	=> array( 'title' => esc_html__( 'Contact', 'kitring' ), 'priority' => 18 ),
					'panel'	=> 'header'
				),
				array()
			);

		}

		public function dahz_framework_header_contact_element( $builder_type, $section, $row, $column ){

			$phone = dahz_framework_get_option( 'header_contact_phone' );

			$email = dahz_framework_get_option( 'header_contact_email' );

			$opening_hours_line_1 = dahz_framework_get_option( 'header_contact_opening_hours_line_1' );

			$opening_hours_line_2 = dahz_framework_get_option( 'header_contact_opening_hours_line_2' );

			$address_line_1 = dahz_framework_get_option( 'header_contact_address_line_1' );

			$address_line_2 = dahz_framework_get_option( 'header_contact_address_line_2' );

			$link_map = dahz_framework_get_option( 'header_contact_link_map' );

			dahz_framework_get_template(
				"header-contact.php",
				array(
					'enable_contact'		=> ( !empty( $phone ) || !empty( $email ) ),
					'icon_ratio'			=> ( $builder_type === 'headermobile' ? '1' : '2' ) ,
					'enable_opening_hours'	=> ( !empty( $opening_hours_line_1 ) || !empty( $opening_hours_line_2 ) ),
					'enable_address'		=> ( !empty( $address_line_1 ) || !empty( $address_line_2 ) || !empty( $link_map ) ),
					'phone'					=> $phone,
					'email'					=> $email,
					'opening_hours_line_1'	=> $opening_hours_line_1,
					'opening_hours_line_2'	=> $opening_hours_line_2,
					'address_line_1'		=> $address_line_1,
					'address_line_2'		=> $address_line_2,
					'link_map'				=> $link_map,
				),
				'dahz-modules/header-contact/templates/'
			);

		}

		public function dahz_framework_header_item_contact_style( $styles ) {
			$styles .= sprintf(
				'
				.de-header__section-contact-item--inner__item.item-1 {
					font-size: %s;
				}
				',
				dahz_framework_get_option( 'header_navigation_size_secondary', '12px' )
			);

			return $styles;
		}

	}

	new Dahz_Framework_Header_Contact();

}
