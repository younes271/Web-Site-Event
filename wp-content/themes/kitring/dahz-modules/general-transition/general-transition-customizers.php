<?php

if ( !class_exists( 'Dahz_Framework_Modules_General_Transition_Customizer' ) ) {

	Class Dahz_Framework_Modules_General_Transition_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer() {
			$dv_field = array();

			$img_url = get_template_directory_uri() . '/assets/images/customizer/blog/';

			/**
			 * section general_transition
			 * add field enable transitions
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'switch',
				'settings'	=> 'enable_transitions',
				'label'		=> __( 'Enable Transitions', 'kitring' ),
				'default'	=> 'off',
				'choices'	=> array(
					'on'	=> __( 'On', 'kitring' ),
					'off'	=> __( 'Off', 'kitring' )
				)
			);

			/**
			 * section general_transitions
			 * add field transitions_loader
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'radio-image',
				'settings'	=> 'transitions_loader',
				'label'		=> esc_html__( 'Transitions Loader', 'kitring' ),
				'default'	=> 'loader-1',
				'choices'	=> array(
					'loader-1' => get_template_directory_uri() . '/assets/images/customizer/df_transition-style-1.svg',
					'loader-2' => get_template_directory_uri() . '/assets/images/customizer/df_transition-style-2.svg',
					'loader-3' => get_template_directory_uri() . '/assets/images/customizer/df_transition-style-3.svg',
					'loader-4' => get_template_directory_uri() . '/assets/images/customizer/df_transition-style-4.svg',
					'loader-5' => get_template_directory_uri() . '/assets/images/customizer/df_transition-style-5.svg',
				),
			);
			
			$dv_field[] = array(
				'priority'	=> 10,
				'type'			=> 'image',
				'settings'		=> 'transition_image',
				'label'			=> __( 'Transition Image', 'kitring' ),
				'default'		=> '',
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_transition_transitions_loader',
						'operator'	=> '==',
						'value'		=> 'loader-5',
					)
				),
			);
			
			$dv_field[] = array(
				'priority'	=> 10,
				'type'			=> 'dimension',
				'settings'		=> 'transition_image_width',
				'label'			=> __( 'Transition Image Width', 'kitring' ),
				'default'		=> '100px',
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_transition_transitions_loader',
						'operator'	=> '==',
						'value'		=> 'loader-5',
					)
				),
			);
			
			$dv_field[] = array(
				'priority'	=> 10,
				'type'			=> 'dimension',
				'settings'		=> 'transition_image_height',
				'label'			=> __( 'Transition Image Height', 'kitring' ),
				'default'		=> '100px',
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_transition_transitions_loader',
						'operator'	=> '==',
						'value'		=> 'loader-5',
					)
				),
			);

			return $dv_field;
		}

	}

}