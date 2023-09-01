<?php
if( !class_exists( 'Dahz_Framework_Header_Contact_Customizer' ) ){

	Class Dahz_Framework_Header_Contact_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer(){
			
			$transport = array(
				'selector' 		  => '#de-site-header',
				'render_callback' => 'dahz_framework_get_header'
			);

			$dv_field = array();

			$dv_field[] = array(
				'type'      => 'custom',
				'settings'  => 'custom_title_header_contact',
				'default'   => '<div class="de-customizer-title">' . __( 'Contact', 'kitring' ) . '</div>',
			);
			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'phone',
				'label'     => __( 'Phone', 'kitring' ),
				'description'=> __('To view the changes, go to the single product page manually', 'kitring' ),
			);
			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'email',
				'label'     => __( 'Email', 'kitring' ),
				'description'=> __('To view the changes, go to the single product page manually', 'kitring' ),
			);
			$dv_field[] = array(
				'type'      => 'custom',
				'settings'  => 'custom_title_header_contact_opening_hours',
				'default'   => '<div class="de-customizer-title">' . __( 'Opening Hours', 'kitring' ) . '</div>',
			);
			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'opening_hours_line_1',
				'label'     => __( 'Opening Hours Line 1', 'kitring' ),
				'description'=> __('To view the changes, go to the single product page manually', 'kitring' ),
			);
			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'opening_hours_line_2',
				'label'     => __( 'Opening Hours Line 2', 'kitring' ),
				'description'=> __('To view the changes, go to the single product page manually', 'kitring' ),
			);
			$dv_field[] = array(
				'type'      => 'custom',
				'settings'  => 'custom_title_header_contact_address',
				'default'   => '<div class="de-customizer-title">' . __( 'Address', 'kitring' ) . '</div>',
			);
			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'address_line_1',
				'label'     => __( 'Address Line 1', 'kitring' ),
				'description'=> __('To view the changes, go to the single product page manually', 'kitring' ),
			);
			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'address_line_2',
				'label'     => __( 'Address Line 2', 'kitring' ),
				'description'=> __('To view the changes, go to the single product page manually', 'kitring' ),
			);
			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'link_map',
				'label'     => __( 'Link Map', 'kitring' ),
				'description'=> __('To view the changes, go to the single product page manually', 'kitring' ),
			);
			
			return $dv_field;

		}

	}

}