<?php

if ( !class_exists( 'Dahz_Framework_Modules_Color_Button_Customizer' ) ) {
		
	class Dahz_Framework_Modules_Color_Button_Customizer extends Dahz_Framework_Customizer_Extend {
		
		private function dahz_framework_get_button_option( $args = array() ){
			
			
			
		}
		
		public function dahz_framework_set_customizer() {
			
			$dv_field = dahz_framework_elements()->dahz_framework_get_customizer( 'button' );
			// /**
			 // * section color_button
			 // * add field button_fill_color_title
			 // */
			// $dv_field[] = array(
				// 'type'     => 'custom',
				// 'settings' => 'button_fill_color_title',
				// 'label'    => '',
				// 'default'  => '<div class="de-customizer-title">Button Fill</div>',
			// );

			// /**
			 // * section color_button
			 // * add field button_solid_color_bg
			 // */
			// $dv_field[] = array(
				// 'type'      => 'multicolor',
				// 'settings'  => 'button_solid_color_bg',
				// 'label'     => __( 'Button Fill: Background', 'kitring' ),
				// 'transport' => 'postMessage',
				// 'choices'   => array(
					// 'bg_regular' => esc_attr__( 'Regular', 'kitring' ),
					// 'bg_hover'   => esc_attr__( 'Hover', 'kitring' ),
				// ),
				// 'default'   => array(
					// 'bg_regular' => '#0c0c0c',
					// 'bg_hover'   => '#636363',
				// ),
			// );

			// /**
			 // * section color_button
			 // * add field button_solid_color_text
			 // */
			// $dv_field[] = array(
				// 'type'      => 'multicolor',
				// 'settings'  => 'button_solid_color_text',
				// 'label'     => __( 'Button Fill: Text', 'kitring' ),
				// 'transport' => 'postMessage',
				// 'choices'   => array(
					// 'text_regular' => esc_attr__( 'Regular', 'kitring' ),
					// 'text_hover'   => esc_attr__( 'Hover', 'kitring' ),
				// ),
				// 'default'   => array(
					// 'text_regular' => '#ffffff',
					// 'text_hover'   => '#ffffff',
				// ),
			// );

			// /**
			 // * section color_button
			 // * add field button_outline_color_title
			 // */
			// $dv_field[] = array(
				// 'type'     => 'custom',
				// 'settings' => 'button_outline_color_title',
				// 'label'    => '',
				// 'section'  => 'color_button',
				// 'default'  => '<div class="de-customizer-title">Button Outline</div>',
			// );

			// /**
			 // * section color_button
			 // * add field button_outline
			 // */
			// $dv_field[] = array(
				// 'type'      => 'multicolor',
				// 'settings'  => 'button_outline',
				// 'label'     => __( 'Button Outline', 'kitring' ),
				// 'transport' => 'postMessage',
				// 'choices'   => array(
					// 'border_color' => esc_attr__( 'Border', 'kitring' ),
					// 'text_color'   => esc_attr__( 'Text', 'kitring' ),
				// ),
				// 'default'   => array(
					// 'border_color' => '#ffffff',
					// 'text_color'   => '#ffffff',
				// ),
			// );

			// /**
			 // * section color_button
			 // * add field button_outline_hover
			 // */
			// $dv_field[] = array(
				// 'type'      => 'multicolor',
				// 'settings'  => 'button_outline_hover',
				// 'label'     => __( 'Button Outline Hover', 'kitring' ),
				// 'transport' => 'postMessage',
				// 'choices'   => array(
					// 'background_color' => esc_attr__( 'Background', 'kitring' ),
					// 'text_color'       => esc_attr__( 'Text', 'kitring' ),
				// ),
				// 'default'   => array(
					// 'background_color' => '#636363',
					// 'text_color'       => '#ffffff',
				// ),
			// );

			// /**
			 // * section color_button
			 // * add field button_text_color_title
			 // */
			// $dv_field[] = array(
				// 'type'     => 'custom',
				// 'settings' => 'button_text_color_title',
				// 'label'    => '',
				// 'section'  => 'color_button',
				// 'default'  => '<div class="de-customizer-title">Button Text</div>',
			// );

			// /**
			 // * section color_button
			 // * add field button_text_color
			 // */
			// $dv_field[] = array(
				// 'type'     => 'color',
				// 'settings' => 'button_text_color',
				// 'label'    => __( 'Button Text Default', 'kitring' ),
				// 'default'  => '#333333',
			// );

			// /**
			 // * section color_button
			 // * add field button_text_color_hover
			 // */
			// $dv_field[] = array(
				// 'type'     => 'color',
				// 'settings' => 'button_text_color_hover',
				// 'label'    => __( 'Button Text Hover', 'kitring' ),
				// 'default'  => '#999999',
			// );

			// /**
			 // * section color_button
			 // * add field button_radius_title
			 // */
			// $dv_field[] = array(
				// 'type'     => 'custom',
				// 'settings' => 'button_radius_title',
				// 'label'    => '',
				// 'section'  => 'color_button',
				// 'default'  => '<div class="de-customizer-title">Button Radius</div>',
			// );

			// /**
			 // * section color_button
			 // * add field global_button_radius
			 // */
			// $dv_field[] = array(
				// 'type'      => 'slider',
				// 'settings'  => 'global_button_radius',
				// 'label'     => __( 'Global Button Radius (px units)', 'kitring' ),
				// 'default'   => '0',
				// 'choices'   => array(
					// 'min'   => '0',
					// 'max'   => '60',
					// 'step'  => '1',
				// ),
				// 'transport' => 'postMessage',
				// 'js_vars'   => array(
						// array(
							// 'element'  => '#de-content-wrapper .de-btn.de-btn--boxed',
							// 'function' => 'css',
							// 'units'    => 'px',
							// 'property' => 'border-radius'
						// ),
					// ),
			// );

			return $dv_field;
		}
	}
}