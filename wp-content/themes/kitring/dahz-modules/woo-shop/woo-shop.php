<?php

if ( !class_exists( 'Dahz_Framework_Woo_Shop' ) ) {

	Class Dahz_Framework_Woo_Shop {

		public function __construct() {

			add_action( 'dahz_framework_module_woo-shop_init', array( $this, 'dahz_framework_woo_shop_init' ) );

		}
		

		public function dahz_framework_woo_shop_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/woo-shop-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Woo_Shop_Customizer',
				array(
					'id'	=> 'shop_woo',
					'title'	=> esc_html__( 'Shop', 'kitring' ),
					'panel'	=> 'woocommerce',
				),
				array()
			);

		}
		

	}

	new Dahz_Framework_Woo_Shop();

}