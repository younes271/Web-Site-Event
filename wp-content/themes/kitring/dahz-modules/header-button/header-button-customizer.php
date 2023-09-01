<?php
if( !class_exists( 'Dahz_Framework_Header_Button_Customizer' ) ){

	Class Dahz_Framework_Header_Button_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer(){
			
			$transport = array(
				'selector' 		  => '#de-site-header',
				'render_callback' => 'dahz_framework_get_header'
			);

			$dv_field = array();

			/**
			 * section color_button
			 * add field button_solid_color_bg
			 */
			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'text',
				'label'     => __( 'Button Text', 'kitring' ),
			);
			
			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'link',
				'label'     => __( 'Button Link', 'kitring' ),
			);

			/**
			 * section color_button
			 * add field button_solid_color_text
			 */
			$dv_field[] = array(
				'type'      => 'multicolor',
				'settings'  => 'text_color',
				'label'     => __( 'Text Color', 'kitring' ),
				'transport' => 'postMessage',
				'choices'   => array(
					'regular' => esc_attr__( 'Regular', 'kitring' ),
					'hover'   => esc_attr__( 'Hover', 'kitring' ),
				),
				'default'   => array(
					'regular' => '#ffffff',
					'hover'   => '#ffffff',
				),
			);
			$dv_field[] = array(
				'type'      => 'multicolor',
				'settings'  => 'background_color',
				'label'     => __( 'Background Color', 'kitring' ),
				'transport' => 'postMessage',
				'choices'   => array(
					'regular' => esc_attr__( 'Regular', 'kitring' ),
					'hover'   => esc_attr__( 'Hover', 'kitring' ),
				),
				'default'   => array(
					'regular' => '#ffffff',
					'hover'   => '#ffffff',
				),
			);

			$dv_field[] = array(
				'type'     	=> 'select',
				'settings' 	=> 'target',
				'label'    	=> esc_html__( 'Button Target', 'kitring' ),
				'priority' 	=> 11,
				'default'	=> '_blank',
				'choices'  	=> array( 
					'_self' => __( 'Same Window', 'kitring' ),
					'_blank'=> __( 'New Window', 'kitring' ),
				),
			);

			return $dv_field;

		}

	}

}