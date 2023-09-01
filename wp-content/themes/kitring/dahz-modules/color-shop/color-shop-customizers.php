<?php
/*
	1. 	class : Dahz_Framework_Modules_Color_Shop_Customizer
*/
if( !class_exists( 'Dahz_Framework_Modules_Color_Shop_Customizer' ) ){

	Class Dahz_Framework_Modules_Color_Shop_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer(){

			$dv_field = array();
			
			$dv_field[] = array(
				'type'        => 'multicolor',
				'settings'    => 'success_color',
				'label'       => __( 'Success Color', 'kitring' ),
				'description' => __('Success Notification', 'kitring' ),
				'default'     => array(
					'background' => '#558754',
					'text'   => '#ffffff',
				),
				'choices'     => array(
					'background'    => esc_attr__( 'Background', 'kitring' ),
					'text'   => esc_attr__( 'Text', 'kitring' ),
				),

			);
			$dv_field[] = array(
				'type'        => 'multicolor',
				'settings'    => 'info_color',
				'label'       => __( 'Info Color', 'kitring' ),
				'description' => __('Info/General Notification', 'kitring' ),
				'default'     => array(
						'background' => '#828282',
						'text'   => '#ffffff',
				),
				'choices'     => array(
					'background'    => esc_attr__( 'Background', 'kitring' ),
					'text'   => esc_attr__( 'Text', 'kitring' ),
				),
			);
			$dv_field[] = array(
				'type'        => 'multicolor',
				'settings'    => 'alert_color',
				'label'       => __( 'Alert Color', 'kitring' ),
				'description' => __('Alert/Error Notification', 'kitring' ),
				'default'     => array(
						'background' => '#a4292b',
						'text'   => '#ffffff',
				),
				'choices'     => array(
					'background'    => esc_attr__( 'Background', 'kitring' ),
					'text'   => esc_attr__( 'Text', 'kitring' ),
				),
			);
			$dv_field[] = array(
				'type'        => 'multicolor',
				'settings'    => 'sale_color',
				'label'       => __( 'Sale Color', 'kitring' ),
				'description' => __('\'Sale\' Product Badge', 'kitring' ),
				'default'     => array(
						'background' => '#9e856f',
						'text'   => '#ffffff',
				),
				'choices'     => array(
					'background'    => esc_attr__( 'Background', 'kitring' ),
					'text'   => esc_attr__( 'Text', 'kitring' ),
				),
			);
			$dv_field[] = array(
				'type'        => 'multicolor',
				'settings'    => 'star_color',
				'label'       => __( 'Star Color', 'kitring' ),
				'description' => __('Star Ratings', 'kitring' ),
				'default'     => array(
						'normal' => '#d6d6d6',
						'hover'   => '#ffcf29',
				),
				'transport'	  => 'postMessage',
				'choices'     => array(
					'normal'    => esc_attr__( 'Normal', 'kitring' ),
					'hover'   => esc_attr__( 'Hover', 'kitring' ),
				),
			);
			
			return $dv_field;

		}

	}

}