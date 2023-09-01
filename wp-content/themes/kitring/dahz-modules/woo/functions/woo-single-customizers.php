<?php
/*
 1. class : Dahz_Framework_Modules_Woo_Single_Customizer
 */
if ( !class_exists( 'Dahz_Framework_Modules_Woo_Single_Customizer' ) ) {

	Class Dahz_Framework_Modules_Woo_Single_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer() {

			$dv_field = array();

			$img_url = get_template_directory_uri() . '/assets/images/customizer/woocommerce/';

			$dv_field[] = array(
				'type'      => 'custom',
				'settings'  => 'custom_title_single_product_layout',
				'label'     => '',
				'default'   => '<div class="de-customizer-title">Layout</div>',
			);

			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'product_column',
				'label'     => __( 'Product Column', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => '2-3',
				'choices'   => array(
					'1-6'   => __( '2 Columns', 'kitring' ),
					'1-4'   => __( '3 Columns', 'kitring' ),
					'1-3'   => __( '4 Columns', 'kitring' ),
					'5-12'  => __( '5 Columns', 'kitring' ),
					'1-2'   => __( '6 Columns', 'kitring' ),
					'7-12'  => __( '7 Columns', 'kitring' ),
					'2-3'   => __( '8 Columns', 'kitring' ),
				),
				'description' => __( 'Define image area for product when using layout 6', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'switch',
				'settings'  => 'is_prev_next_product',
				'label'     => __( 'Prev Next Product Navigation', 'kitring' ),
				'transport' => 'refresh',
				'default'   => 'on',
				'choices'   => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' )
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'custom',
				'settings'  => 'custom_title_single_product_related',
				'label'     => '',
				'default'   => '<div class="de-customizer-title">Related Product</div>',
			);

			$dv_field[] = array(
				'type'      => 'switch',
				'settings'  => 'is_show_related_product',
				'label'     => __( 'Display Related Products', 'kitring' ),
				'transport' => 'refresh',
				'default'   => 'on',
				'choices'   => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' )
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'related_title',
				'label'     => __( 'Related Product Text', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => __( 'Related Product', 'kitring' ),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'related_desktop_column',
				'label'     => __( 'Desktop Column', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => '1-4',
				'choices'   => array(
					'1-1'   => __( '100%', 'kitring' ),
					'5-6'   => __( '83%', 'kitring' ),
					'4-5'   => __( '80%', 'kitring' ),
					'3-5'   => __( '60%', 'kitring' ),
					'1-2'  	=> __( '50%', 'kitring' ),
					'1-3'   => __( '33%', 'kitring' ),
					'1-4'   => __( '25%', 'kitring' ),
					'1-5'   => __( '20%', 'kitring' ),
					'1-6'   => __( '16%', 'kitring' ),
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'related_tablet_column',
				'label'     => __( 'Tablet Landscape Column', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => '1-4',
				'choices'   => array(
					'1-1'   => __( '100%', 'kitring' ),
					'5-6'   => __( '83%', 'kitring' ),
					'4-5'   => __( '80%', 'kitring' ),
					'3-5'   => __( '60%', 'kitring' ),
					'1-2'  	=> __( '50%', 'kitring' ),
					'1-3'   => __( '33%', 'kitring' ),
					'1-4'   => __( '25%', 'kitring' ),
					'1-5'   => __( '20%', 'kitring' ),
					'1-6'   => __( '16%', 'kitring' ),
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'related_phone_landscape_column',
				'label'     => __( 'Phone Landscape Column', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => '3-5',
				'choices'   => array(
					'1-1'   => __( '100%', 'kitring' ),
					'5-6'   => __( '83%', 'kitring' ),
					'4-5'   => __( '80%', 'kitring' ),
					'3-5'   => __( '60%', 'kitring' ),
					'1-2'  	=> __( '50%', 'kitring' ),
					'1-3'   => __( '33%', 'kitring' ),
					'1-4'   => __( '25%', 'kitring' ),
					'1-5'   => __( '20%', 'kitring' ),
					'1-6'   => __( '16%', 'kitring' ),
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'related_phone_potrait_column',
				'label'     => __( 'Phone Potrait Column', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => '3-5',
				'choices'   => array(
					'1-1'   => __( '100%', 'kitring' ),
					'5-6'   => __( '83%', 'kitring' ),
					'4-5'   => __( '80%', 'kitring' ),
					'3-5'   => __( '60%', 'kitring' ),
					'1-2'  	=> __( '50%', 'kitring' ),
					'1-3'   => __( '33%', 'kitring' ),
					'1-4'   => __( '25%', 'kitring' ),
					'1-5'   => __( '20%', 'kitring' ),
					'1-6'   => __( '16%', 'kitring' ),
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'slider',
				'settings'  => 'related_per_page',
				'label'     => __( 'Related Product per Page', 'kitring' ),
				'transport' => 'refresh',
				'default'   => 12,
				'choices'   => array(
					'min'  => 1,
					'max'  => 48,
					'step' => 1,
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'custom',
				'settings'  => 'custom_title_upsells_crossells',
				'label'     => '',
				'default'   => '<div class="de-customizer-title">'. __( 'Upsells & Cross Sells', 'kitring' ) .'</div>',
			);

			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'up_sells_title',
				'label'     => __( 'Upsells Text', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => __( 'You may also like...', 'kitring' ),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'text',
				'settings'  => 'cross_sells_title',
				'label'     => __( 'Cross-Sells Text', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => __( 'You may be interested in&hellip;', 'kitring' ),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'up_cross_sells_desktop_column',
				'label'     => __( 'Desktop Column', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => '1-4',
				'choices'   => array(
					'1-1'   => __( '100%', 'kitring' ),
					'5-6'   => __( '83%', 'kitring' ),
					'4-5'   => __( '80%', 'kitring' ),
					'3-5'   => __( '60%', 'kitring' ),
					'1-2'  	=> __( '50%', 'kitring' ),
					'1-3'   => __( '33%', 'kitring' ),
					'1-4'   => __( '25%', 'kitring' ),
					'1-5'   => __( '20%', 'kitring' ),
					'1-6'   => __( '16%', 'kitring' ),
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'up_cross_sells_tablet_column',
				'label'     => __( 'Tablet Landscape Column', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => '1-4',
				'choices'   => array(
					'1-1'   => __( '100%', 'kitring' ),
					'5-6'   => __( '83%', 'kitring' ),
					'4-5'   => __( '80%', 'kitring' ),
					'3-5'   => __( '60%', 'kitring' ),
					'1-2'  	=> __( '50%', 'kitring' ),
					'1-3'   => __( '33%', 'kitring' ),
					'1-4'   => __( '25%', 'kitring' ),
					'1-5'   => __( '20%', 'kitring' ),
					'1-6'   => __( '16%', 'kitring' ),
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'up_cross_sells_phone_landscape_column',
				'label'     => __( 'Phone Landscape Column', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => '3-5',
				'choices'   => array(
					'1-1'   => __( '100%', 'kitring' ),
					'5-6'   => __( '83%', 'kitring' ),
					'4-5'   => __( '80%', 'kitring' ),
					'3-5'   => __( '60%', 'kitring' ),
					'1-2'  	=> __( '50%', 'kitring' ),
					'1-3'   => __( '33%', 'kitring' ),
					'1-4'   => __( '25%', 'kitring' ),
					'1-5'   => __( '20%', 'kitring' ),
					'1-6'   => __( '16%', 'kitring' ),
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'up_cross_sells_phone_potrait_column',
				'label'     => __( 'Phone Potrait Column', 'kitring' ),
				'transport' => 'postMessage',
				'default'   => '3-5',
				'choices'   => array(
					'1-1'   => __( '100%', 'kitring' ),
					'5-6'   => __( '83%', 'kitring' ),
					'4-5'   => __( '80%', 'kitring' ),
					'3-5'   => __( '60%', 'kitring' ),
					'1-2'  	=> __( '50%', 'kitring' ),
					'1-3'   => __( '33%', 'kitring' ),
					'1-4'   => __( '25%', 'kitring' ),
					'1-5'   => __( '20%', 'kitring' ),
					'1-6'   => __( '16%', 'kitring' ),
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'      => 'slider',
				'settings'  => 'up_cross_sells_per_page',
				'label'     => __( 'Product Per Page', 'kitring' ),
				'transport' => 'refresh',
				'default'   => 12,
				'choices'   => array(
					'min'  => 1,
					'max'  => 48,
					'step' => 1,
				),
				'description' => __('To view the changes, go to the single product page manually', 'kitring' ),
			);

			return $dv_field;

		}

	}

}