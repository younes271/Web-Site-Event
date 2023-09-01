<?php
if( !class_exists( 'Dahz_Framework_Footer_Element_Customizer' ) ){

	Class Dahz_Framework_Footer_Element_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer(){

			$dv_field = array();
			$transport = array(
				'selector' 		  => '#de-site-footer',
				'render_callback' => 'dahz_framework_get_footer'
			);
			
			$dv_field[]	= array(
				'type'		=> 'custom',
				'settings'	=> 'custom_title_section_footer_logo',
				'label'		=> '',
				'default'	=> '<div class="de-customizer-title">'. __( 'Footer Logo', 'kitring' ) .'</div>',
				'priority'	=> 12,
			);
			
			$dv_field[] = array(
				'type'      => 'image',
				'settings'  => 'logo_normal',
				'label'     => esc_html__( 'Normal Logo', 'kitring' ),
				'priority'  => 12,
				'partial_refresh' => array(
					'footer_element_logo_normal' => $transport
				)
			);

			$dv_field[] = array(
				'type'      => 'image',
				'settings'  => 'logo_retina',
				'label'     => esc_html__( 'Retina Logo', 'kitring' ),
				'priority'  => 12,
				'partial_refresh' => array(
					'footer_element_logo_retina' => $transport
				)
			);
			
			$dv_field[]	= array(
				'type'		=> 'custom',
				'settings'	=> 'custom_title_section_payment_logo',
				'label'		=> '',
				'default'	=> '<div class="de-customizer-title">'. __( 'Footer Payment Logo', 'kitring' ) .'</div>',
				'priority'	=> 12,
			);
			
			$dv_field[] = array(
				'type'      => 'image',
				'settings'  => 'payment_logo_normal',
				'label'     => esc_html__( 'Payment Normal Logo', 'kitring' ),
				'priority'  => 12,
				'partial_refresh' => array(
					'footer_element_payment_logo_normal' => $transport
				)
			);

			$dv_field[] = array(
				'type'      => 'image',
				'settings'  => 'payment_logo_retina',
				'label'     => esc_html__( 'Payment Retina Logo', 'kitring' ),
				'priority'  => 12,
				'partial_refresh' => array(
					'footer_element_payment_logo_retina' => $transport
				)
			);
			
			return $dv_field;

		}

	}

}