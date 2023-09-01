<?php

if ( !class_exists( 'Dahz_Framework_Modules_General_Global_Customizer' ) ) {

	Class Dahz_Framework_Modules_General_Global_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer() {
			$dv_field = array();

			/**
			 * section global
			 * add field disable_comment_on_page
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'switch',
				'settings'	=> 'disable_comment_on_page',
				'label'		=> __( 'Disable Comment on Page', 'kitring' ),
				'default'	=> 'off',
				'choices'	=> array(
					'on'	=> __( 'On', 'kitring' ),
					'off'	=> __( 'Off', 'kitring' )
				)
			);

			/**
			 * section global
			 * add field enable_sticky_sidebar
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'switch',
				'settings'	=> 'enable_sticky_sidebar',
				'label'		=> __( 'Enable Sticky Sidebar', 'kitring' ),
				'default'	=> 'on',
				'choices'	=> array(
					'on'	=> __( 'On', 'kitring' ),
					'off'	=> __( 'Off', 'kitring' )
				)
			);

			/**
			 * section global
			 * add field enable_back_to_top
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'switch',
				'settings'	=> 'enable_back_to_top',
				'label'		=> __( 'Enable Back to Top', 'kitring' ),
				'default'	=> 'on',
				'choices'	=> array(
					'on'	=> __( 'On', 'kitring' ),
					'off'	=> __( 'Off', 'kitring' )
				)
			);

			/**
			 * section global
			 * add field global widget title
			 */
			$dv_field[] = array(
				'priority'	=> 12,
				'type'		=> 'switch',
				'settings'	=> 'global_widget_title',
				'label'		=> __( 'Enable Uppercase Widget Title', 'kitring' ),
				'default'	=> 'off',
				'choices'	=> array(
					'on'	=> __( 'On', 'kitring' ),
					'off'	=> __( 'Off', 'kitring' )
				)
			);

			return $dv_field;
		}

	}

}