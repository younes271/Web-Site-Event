<?php
/*
 * 1. class : Dahz_Framework_Modules_Portfolio_Single_Customizer
 */
if( !class_exists( 'Dahz_Framework_Modules_Portfolio_Single_Customizer' ) ){

	Class Dahz_Framework_Modules_Portfolio_Single_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer(){

			$dv_field = array();

			$dv_field[] = array(
				'type'     => 'custom',
				'settings' => "custom_title_portfolio_single_layout",
				'label'    => '',
				'default'  => '<div class="de-customizer-title">'. esc_html__('Layout', 'kitring' ) .'</div>',
			);

			$dv_field[] = array(
				'type'        => 'switch',
				'settings'    => 'prev_next',
				'label'       => __( 'Enable Prev Next', 'kitring' ),
				'default'     => 'on',
				'priority'    => 10,
				// 'transport' => 'postMessage',
				'choices'     => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' ),
				),
				'description'=> __( 'To view the changes, go to your portfolio pages manually', 'kitring' ),
			);
			
			$dv_field[] = array(
				'type'		=> 'text',
				'settings'	=> 'title_related',
				'label'		=> __( 'Related Portfolio Title', 'kitring' ),
				'default'	=> 'Related Portfolio',
				'description'=> __( 'Change the Portfolio Title', 'kitring' ),
			);
			
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'image_ratio',
				'label'       => esc_html__( 'Image Ratio', 'kitring' ),
				'default'	  => '',
				'choices'     => array(
					''			=> __( 'Uncrop', 'kitring' ),
					'1-1'		=> __( '1:1', 'kitring' ),
					'1-2'		=> __( '1:2', 'kitring' ),
					'2-1'		=> __( '2:1', 'kitring' ),
					'2-3'		=> __( '2:3', 'kitring' ),
					'3-2'		=> __( '3:2', 'kitring' ),
					'3-4'		=> __( '3:4', 'kitring' ),
					'4-3'		=> __( '4:3', 'kitring' ),
					'4-5'		=> __( '4:5', 'kitring' ),
					'5-4'		=> __( '5:4', 'kitring' ),
					'5-7'		=> __( '5:7', 'kitring' ),
					'7-5'		=> __( '7:5', 'kitring' ),
					'9-16'		=> __( '9:16', 'kitring' ),
					'16-9'		=> __( '16:9', 'kitring' ),
				),
			); 

			/**
			 * section archive_layout
			 * add field single_post_recent_desktop_column
			 */
						
			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'desktop_column',
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

			/**
			 * section archive_layout
			 * add field single_post_recent_tab_lndscp_column
			 */
			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'tablet_landscape_column',
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
			

			/**
			 * section archive_layout
			 * add field single_post_recent_phone_lndscp_column
			 */
			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'phone_landscape_column',
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

			/**
			 * section archive_layout
			 * add field single_post_recent_phone_ptrt_column
			 */
			$dv_field[] = array(
				'type'      => 'select',
				'settings'  => 'phone_potrait_column',
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
				'type'        => 'select',
				'settings'    => 'column_gap',
				'label'       => __( 'Column Gap', 'kitring' ),
				'default'     => 'column_gap',
				'choices'     => array(
					'' 					=> __( 'Default', 'kitring' ),
					'uk-grid-small' 	=> __( 'Small', 'kitring' ),
					'uk-grid-medium' 	=> __( 'Medium', 'kitring' ),
					'uk-grid-large' 	=> __( 'Large', 'kitring' ),
					'uk-grid-collapse' 	=> __( 'Collapse (No Gutter)', 'kitring' ),
				),
				'description' => __('To view the changes, go to your portfolio pages manually', 'kitring' ),
			);

			return $dv_field;

		}

	}

}