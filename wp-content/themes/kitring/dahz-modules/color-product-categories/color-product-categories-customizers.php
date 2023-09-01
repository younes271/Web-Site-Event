<?php
/*
	1. 	class : Dahz_Framework_Modules_Color_Product_Categories_Customizer
*/
if( !class_exists( 'Dahz_Framework_Modules_Color_Product_Categories_Customizer' ) ){

	Class Dahz_Framework_Modules_Color_Product_Categories_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer(){

			$dv_field = array();
			
			$img_url = get_template_directory_uri() . '/assets/images/customizer/woocommerce/';
			
			$dv_field[] = array(
				'type'		=> 'radio-image',
				'priority'	=> 10,
				'settings'	=> 'style',
				'label'		=> __( 'Categories Style', 'kitring' ),
				'transport'	=> 'refresh',
				'default'	=> 'style-1',
				'choices'	=> array(
					'layout-1'	=> $img_url . 'df_catgeories-style-1.svg',
					'layout-2'	=> $img_url . 'df_catgeories-style-2.svg',
					'layout-3'	=> $img_url . 'df_catgeories-style-3.svg' ,
					'layout-4'	=> $img_url . 'df_catgeories-style-4.svg' ,
				)
			);
			
			$dv_field[] = array(
				'type'		=> 'select',
				'priority'	=> 10,
				'settings'	=> 'hover_effect',
				'label'		=> __( 'Hover Effect', 'kitring' ),
				'default'	=> 'zoom',
				'multiple'	=> 1,
				'choices'	=> array(
					'zoom' 					=> __( 'Zoom', 'kitring' ),
					'zoom-glare' 			=> __( 'Zoom Glare', 'kitring' ),
					'push' 					=> __( 'Push', 'kitring' ),
					'push-glare'			=> __( 'Push Glare', 'kitring' ),
					'parallax-tilt'			=> __( 'Parallax Tilt', 'kitring' ),
					'parallax-tilt-glare'	=> __( 'Parallax Tilt Glare', 'kitring' ),
				),
			);
			
			$dv_field[] = array(
				'type'		=> 'select',
				'priority'	=> 10,
				'settings'	=> 'hover_effect',
				'label'		=> __( 'Hover Effect', 'kitring' ),
				'default'	=> 'zoom',
				'multiple'	=> 1,
				'choices'	=> array(
					'zoom' 					=> __( 'Zoom', 'kitring' ),
					'zoom-glare' 			=> __( 'Zoom Glare', 'kitring' ),
					'push' 					=> __( 'Push', 'kitring' ),
					'push-glare'			=> __( 'Push Glare', 'kitring' ),
					'parallax-tilt'			=> __( 'Parallax Tilt', 'kitring' ),
					'parallax-tilt-glare'	=> __( 'Parallax Tilt Glare', 'kitring' ),
				),
			);
			
			$dv_field[] = array(
				'type'		=> 'select',
				'settings'	=> 'box_shadow',
				'priority'	=> 10,
				'label'		=> esc_html__( 'Box Shadow', 'kitring' ),
				'default'	=> '',
				'choices'	=> array(
					''						=> __( 'None', 'kitring' ),
					'uk-box-shadow-small'	=> __( 'Small', 'kitring' ),
					'uk-box-shadow-medium'	=> __( 'Medium', 'kitring' ),
					'uk-box-shadow-large'	=> __( 'Large', 'kitring' ),
					'uk-box-shadow-xlarge'	=> __( 'Extra Large', 'kitring' ),
				),
			);
			
			$dv_field[] = array(
				'type'		=> 'select',
				'settings'	=> 'hover_box_shadow',
				'priority'	=> 10,
				'label'		=> esc_html__( 'Hover Box Shadow', 'kitring' ),
				'default'	=> '',
				'choices'	=> array(
					''								=> __( 'None', 'kitring' ),
					'uk-box-shadow-hover-small'		=> __( 'Small', 'kitring' ),
					'uk-box-shadow-hover-medium'	=> __( 'Medium', 'kitring' ),
					'uk-box-shadow-hover-large'		=> __( 'Large', 'kitring' ),
					'uk-box-shadow-hover-xlarge'	=> __( 'Extra Large', 'kitring' ),
				),
			);
			
			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'show_total_number_hover',
				'label'    => esc_html__( 'Show Total Number When Hover', 'kitring' ),
				'default'  => '0',
				'priority' => 10,
			);
			
			$dv_field[] = array(
				'type'     => 'checkbox',
				'settings' => 'show_mobile',
				'label'    => esc_html__( 'Always Show on Mobile', 'kitring' ),
				'default'  => '0',
				'priority' => 10,
			);
			
			$dv_field[] = array(
				'type'		=> 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'	=> 'text_color',
				'label'		=> __( 'Text color', 'kitring' ),
				'default'	=> '#67686e',
				'transport'	=> 'postMessage',
			);
			
			$dv_field[] = array(
				'type'		=> 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'	=> 'color_overlay',
				'label'		=> __( 'Color Overlay', 'kitring' ),
				'default'	=> '#67686e',
				'transport'	=> 'postMessage',
			);
			
			$dv_field[] = array(
				'type'		=> 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'	=> 'hover_text_color',
				'label'		=> __( 'Hover Text color', 'kitring' ),
				'default'	=> '#67686e',
				'transport'	=> 'postMessage',
			);
						
			$dv_field[] = array(
				'type'		=> 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'	=> 'hover_border_color',
				'label'		=> __( 'Hover Border Color', 'kitring' ),
				'default'	=> '#67686e',
				'transport'	=> 'postMessage',
			);
			
			$dv_field[] = array(
				'type'		=> 'color',
				'choices'   => array(
					'alpha' => true,
				),
				'settings'	=> 'hover_color_overlay',
				'label'		=> __( 'Hover Color Overlay', 'kitring' ),
				'default'	=> '#67686e',
				'transport'	=> 'postMessage',
			);
			
			return $dv_field;

		}

	}

}