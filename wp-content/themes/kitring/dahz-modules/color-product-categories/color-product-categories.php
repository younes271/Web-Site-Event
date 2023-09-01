<?php

if( !class_exists( 'Dahz_Framework_Color_Product_Categories' ) ){

	Class Dahz_Framework_Color_Product_Categories{

		public function __construct(){

			add_action( 'dahz_framework_module_color-product-categories_init', array( $this, 'dahz_framework_color_product_categories_init' ) );
			
			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_shop_product_categories_style' ) );
			
			add_filter( 'woocommerce_locate_template', array( $this, 'dahz_framework_woo_relocate_template' ), 10, 3 );

		}

		public function dahz_framework_color_product_categories_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/color-product-categories-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Color_Product_Categories_Customizer',
				array(
					'id'	=> 'product_categories',
					'title' => array( 'title' => esc_html__( 'Product Categories', 'kitring' ), 'priority' => 4 ),
					'panel'	=> 'color'
				),
				array()
			);

		}
		
		public function dahz_framework_woo_relocate_template( $woo_template, $woo_template_name, $woo_template_path ) {
			
			if ( $woo_template_name === 'content-product_cat.php' ) {

				$woo_template = get_template_directory() . '/dahz-modules/color-product-categories/templates/content-product_cat.php';

			}

			return $woo_template;

		}
		
		public function dahz_framework_shop_product_categories_style( $default_styles ){
			
		 	$default_styles 	.= sprintf(
				'
				'
			);
			
			return $default_styles;
			
		}

	}

	new Dahz_Framework_Color_Product_Categories();

}