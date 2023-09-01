<?php

if ( !class_exists( 'Dahz_Framework_Modules_General_404_Customizer' ) ) {

	Class Dahz_Framework_Modules_General_404_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer() {
			$dv_field = array();

			/**
			 * section notfound
			 * add field image_404
			 */
			$dv_field[] = array(
				'type'			=> 'image',
				'settings'		=> 'image_404',
				'label'			=> __( '404 Page', 'kitring' ),
				'description'	=> __( 'Upload image for 404 page', 'kitring' ),
				'help'			=> '',
				'default'		=> get_template_directory_uri() . '/assets/images/customizer/404.png',
			);

			/**
			 * section notfound
			 * add field title_text_404
			 */
			$dv_field[] = array(
				'type'		=> 'text',
				'settings'	=> 'title_text_404',
				'label'		=> __( '404 Title', 'kitring' ),
				'default'	=> esc_attr__( 'Woopsie Daisy!' , 'kitring' ),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '.de-404__title',
						'function'	=> 'html'
					),
				),
			);

			/**
			 * section notfound
			 * add field subtitle_text_404
			 */
			$dv_field[] = array(
				'type'		=> 'textarea',
				'settings'	=> 'subtitle_text_404',
				'label'		=> __( 'Subtitle', 'kitring' ),
				'default'	=> esc_attr__( 'Looks like something went completely wrong! but don\'t worry<br>It can happen to the best of us, and it just happened to you', 'kitring' ),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '.de-404__subtitle',
						'function'	=> 'html'
					),
				),
			);

			/**
			 * section notfound
			 * add field enable_back_to_homepage
			 */
			$dv_field[] = array(
				'type'		=> 'switch',
				'settings'	=> 'enable_back_to_homepage',
				'label'		=> __( 'Back to Homepage Button', 'kitring' ),
				'default'	=> 'on',
				'choices'	=> array(
					'on'	=> __( 'On', 'kitring' ),
					'off'	=> __( 'Off', 'kitring' )
				)
			);

			return $dv_field;
		}

	}

}