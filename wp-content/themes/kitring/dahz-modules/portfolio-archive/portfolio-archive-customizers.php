<?php
/*
 * 1. class : Dahz_Framework_Modules_Portfolio_Archive_Customizer
 */
if( !class_exists( 'Dahz_Framework_Modules_Portfolio_Archive_Customizer' ) ){

	Class Dahz_Framework_Modules_Portfolio_Archive_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer(){

			$dv_field = array();

			$dv_field[] = array(
				'type'     => 'custom',
				'settings' => "custom_title_portfolio_archive_layout",
				'label'    => '',
				'default'  => '<div class="de-customizer-title">'. esc_html__('Layout', 'kitring' ) .'</div>',
			);
			
			// $dv_field[] = array(
			// 	'type'        => 'select',
			// 	'settings'    => 'portfolio_page',
			// 	'label'       => __( 'Set Page for Portfolio Archive', 'kitring' ),
			// 	'choices'  => Kirki_Helper::get_posts(
			// 		array(
			// 			'posts_per_page' => -1,
			// 			'post_type'      => 'page'
			// 		)
			// 	),
			// );
			
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'heading',
				'label'       => esc_html__( 'Heading Style', 'kitring' ),
				'default'	  => 'uk-h4',
				'choices'     => array(
					'uk-article-title'		=> __( 'Article', 'kitring' ),
					'uk-heading-primary'	=> __( 'Primary', 'kitring' ),
					'uk-heading-hero'		=> __( 'Hero', 'kitring' ),
					'uk-h1'					=> __( 'H1', 'kitring' ),
					'uk-h2'					=> __( 'H2', 'kitring' ),
					'uk-h3'					=> __( 'H3', 'kitring' ),
					'uk-h4'					=> __( 'H4', 'kitring' ),
					'uk-h5'					=> __( 'H5', 'kitring' ),
					'uk-h6'					=> __( 'H6', 'kitring' ),
				),
			); 
			
			$dv_field[] = array(
				'type'        => 'radio-image',
				'settings'    => 'layout',
				'label'       => __( 'Layout', 'kitring' ),
				'default'     => 'layout-1',
				'choices'     => array(
					'layout-1'  => get_template_directory_uri() . '/assets/images/customizer/portfolio/df_portfolio-style-1-coralie.svg',
					'layout-2'  => get_template_directory_uri() . '/assets/images/customizer/portfolio/df_portfolio-style-2-centaur.svg',
				),
				'description' => __( 'To view the changes, go to your portfolio pages manually', 'kitring' ),
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
				'type'		=> 'slider',
				'choices'	=> array(
					'min'	=> '1',
					'max'	=> '6',
					'step'	=> '1',
				),
				'settings'	=> 'desktop_column',
				'label'		=> esc_html__( 'Desktop Column', 'kitring' ),
				'default'	=> 3,
			);

			/**
			 * section archive_layout
			 * add field single_post_recent_tab_lndscp_column
			 */
			$dv_field[] = array(
				'type'		=> 'slider',
				'choices'	=> array(
					'min'	=> '1',
					'max'	=> '6',
					'step'	=> '1',
				),
				'settings'	=> 'tablet_landscape_column',
				'label'		=> esc_html__( 'Tablet Landscape Column', 'kitring' ),
				'default'	=> 2,
			);

			/**
			 * section archive_layout
			 * add field single_post_recent_phone_lndscp_column
			 */
			$dv_field[] = array(
				'type'		=> 'slider',
				'choices'	=> array(
					'min'	=> '1',
					'max'	=> '6',
					'step'	=> '1',
				),
				'settings'	=> 'phone_landscape_column',
				'label'		=> esc_html__( 'Phone Landscape Column', 'kitring' ),
				'default'	=> 2,
			);

			/**
			 * section archive_layout
			 * add field single_post_recent_phone_ptrt_column
			 */
			$dv_field[] = array(
				'type'		=> 'slider',
				'choices'	=> array(
					'min'	=> '1',
					'max'	=> '6',
					'step'	=> '1',
				),
				'settings'	=> 'phone_portrait_column',
				'label'		=> esc_html__( 'Phone Portrait Column', 'kitring' ),
				'default'	=> 1,
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
			
			$dv_field[] = array(
				'type' 		=> 'switch',
				'settings' 	=> 'enable_filter',
				'label' 	=> __( 'Enable Filter', 'kitring' ),
				'default' 	=> 'off',
				'choices' 	=> array(
					'on'  => __( 'On', 'kitring' ),
					'off' => __( 'Off', 'kitring' )
				),
			);
			
			$dv_field[] = array(
				'type'			=> 'select',
				'settings'		=> 'filter_alignment',
				'label'			=> __( 'Filter Alignment', 'kitring' ),
				'default'		=> 'uk-flex-left',
				'choices'     	=> array(
					'uk-flex-left'  	=> __( 'Left', 'kitring' ),
					'uk-flex-center'  	=> __( 'Center', 'kitring' ),
					'uk-flex-right'  	=> __( 'Right', 'kitring' ),
				),
				'active_callback'	=> array(
					array(
						'setting'	=> 'portfolio_archive_enable_filter',
						'operator'	=> '==',
						'value'		=> true,
					)
				),
			);
			
			$dv_field[] = array(
				'type'			=> 'select',
				'settings'		=> 'filter_style',
				'label'			=> __( 'Filter Style', 'kitring' ),
				'default'		=> 'pills',
				'choices'     	=> array(
					'pills'  	=> __( 'Pills', 'kitring' ),
					'tabs'  	=> __( 'Tabs', 'kitring' ),
				),
				'active_callback'	=> array(
					array(
						'setting'	=> 'portfolio_archive_enable_filter',
						'operator'	=> '==',
						'value'		=> true,
					)
				),
			);
			
			$dv_field[] = array(
				'type' 		=> 'switch',
				'settings' 	=> 'enable_masonry',
				'label' 	=> __( 'Enable Masonry', 'kitring' ),
				'default' 	=> 'off',
				'choices' 	=> array(
					'on'  => __( 'On', 'kitring' ),
					'off' => __( 'Off', 'kitring' )
				),
				
			);
			
			$dv_field[] = array(
				'type' 		=> 'switch',
				'settings' 	=> 'enable_parallax',
				'label' 	=> __( 'Enable Parallax', 'kitring' ),
				'default' 	=> 'off',
				'choices' 	=> array(
					'on'  => __( 'On', 'kitring' ),
					'off' => __( 'Off', 'kitring' )
				),
				
			);
			
			$dv_field[] = array(
				'type'		=> 'slider',
				'choices'	=> array(
					'min'	=> '0',
					'max'	=> '600',
					'step'	=> '10',
				),
				'settings'	=> 'parallax_speed',
				'label'		=> esc_html__( 'Parallax Speed', 'kitring' ),
				'default'	=> 0,
				'active_callback'	=> array(
					array(
						'setting'	=> 'portfolio_archive_enable_parallax',
						'operator'	=> '==',
						'value'		=> true,
					)
				),
			);

			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'pagination',
				'label'       => __( 'Pagination', 'kitring' ),
				'default'     => 'prev_next',
				'choices'     => array(
					'number'	=> __( 'Number', 'kitring' ),
					'prev_next'	=> __( 'Prev Next', 'kitring' ),
				),
				'description' => __( 'To view the changes, go to your blog pages manually', 'kitring' ),
			);
			
			$dv_field[] = array(
				'type'        => 'slider',
				'settings'    => 'per_page',
				'label'       => __( 'Portfolio Per Page', 'kitring' ),
				'default'     => 12,
				'choices'     => array(
					'min'  => 2,
					'max'  => 48,
					'step' => 1
				),
				'description' => __( 'To view the changes, go to your portfolio pages manually', 'kitring' ),
			);

			return $dv_field;

		}

	}

}
