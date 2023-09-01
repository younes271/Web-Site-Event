<?php

if ( !class_exists( 'Dahz_Framework_Modules_Lazy_Load' ) ) {

	Class Dahz_Framework_Modules_Lazy_Load extends Dahz_Framework_Customizer {

		public function __construct() {

			$this->dahz_framework_lazy_load_options();

		}

		public function dahz_framework_lazy_load_options() {
			$field = array();

			$field[] = array(
				'priority'	=> 11,
				'type'		=> 'switch',
				'settings'	=> 'enable_lazy_load',
				'label'		=> __( 'Enable Lazy Load', 'kitring' ),
				'default'	=> 'off',
				'choices'	=> array(
					'on'	=> __( 'On', 'kitring' ),
					'off'	=> __( 'Off', 'kitring' )
				)
			);
			
			$field[] = array(
				'priority'	=> 12,
				'type'		=> 'color',
				'settings'	=> 'lazy_load_placeholder_color',
				'label'		=> __( 'Lazy Load Placeholder Color', 'kitring' ),
				'active_callback'	=> array(
					array(
						'setting'	=> 'global_enable_lazy_load',
						'operator'	=> '==',
						'value'		=> true,
					)
				),
			);

			$this->dahz_framework_add_field_customizer( 'global', $field );
		}

	}

	new Dahz_Framework_Modules_Lazy_Load();

}