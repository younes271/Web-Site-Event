<?php

if( !class_exists( 'Dahz_Framework_General_404' ) ){

	Class Dahz_Framework_General_404{

		public function __construct(){

			add_action( 'dahz_framework_module_general-404_init', array( $this, 'dahz_framework_general_404_init' ) );

		}

		public function dahz_framework_general_404_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/general-404-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_General_404_Customizer',
				array(
					'id'	=> 'notfound',
					'title' => array( 'title' => esc_html__( '404 Page', 'kitring' ), 'priority' => 3 ),
					'panel'	=> 'general'
				),
				array()
			);

		}
		
	}

	new Dahz_Framework_General_404();

}