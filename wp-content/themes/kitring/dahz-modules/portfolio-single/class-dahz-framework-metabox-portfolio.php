<?php

if ( !class_exists( 'Dahz_Framework_Metabox_Portfolio' ) ) {

	Class Dahz_Framework_Metabox_Portfolio {

		public function __construct() {

			add_action( 'dahz_framework_register_metabox', array( $this, 'dahz_framework_register_metabox_portfolio' ) );

			add_action( 'dahz_framework_metabox_dahz_meta_portfolio', array( $this, 'dahz_framework_register_panel_portfolio_metabox_header' ), 8 );

			add_action( 'dahz_framework_metabox_dahz_meta_portfolio', array( $this, 'dahz_framework_register_panel_portfolio_metabox_content' ), 12 );

			add_action( 'dahz_framework_metabox_dahz_meta_portfolio', array( $this, 'dahz_framework_register_panel_portfolio_metabox_footer' ), 12 );

		}

		/**
		 * register metabox section on post type portfolio
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param -
		 * @return -
		 */
		public function dahz_framework_register_metabox_portfolio() {

			dahz_framework_register_metabox(
				'dahz_meta_portfolio',
				array(
					'title'		=> esc_html__( 'Dahz Metabox - Portfolio', 'kitring' ),
					'post_type'	=> 'portfolio',
					'priority'	=> 'default',
					'context'	=> 'normal'
				)
			);
		}

		/**
		 * register metabox panel header on post type portfolio
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param -
		 * @return -
		 */
		public function dahz_framework_register_panel_portfolio_metabox_header( $dahz_meta ) {

			$dahz_meta->dahz_framework_metabox_add_section( 'header-portfolio', esc_html__( 'Header', 'kitring' ) );

			do_action( 'dahz_framework_metabox_before_header_dahz_meta_portfolio', $dahz_meta );

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-portfolio',
				array(
					'id'			=> 'header_transparent_skin',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Header Transparent Skin', 'kitring' ),
					'default'		=> 'inherit',
					'description'	=> esc_html__('According to the color scheme you choose the text colors will be changed to make it more readable. If you choose theme default the displaying will correspond to the theme options settings', 'kitring' ),
					'options'		=> array(
										'inherit'			=> esc_html__( 'Inherit', 'kitring' ),
										'no-transparency'	=> esc_html__( 'No Transparency', 'kitring' ),
										'transparent-light'	=> esc_html__( 'Light', 'kitring' ),
										'transparent-dark'	=> esc_html__( 'Dark', 'kitring' ),
									)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-portfolio',
				array(
					'id'			=> 'header_preset_saved',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Header Layout', 'kitring' ),
					'default'		=> 'inherit',
					'description'	=> esc_html__('Select your header preset & skin, it based from header builder you have been created before', 'kitring' ),
					'options'		=> dahz_framework_get_builder_presets_option('header')
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-portfolio',
				array(
					'id'			=> 'remove_shadow_sticky',
					'type'			=> 'switcher',
					'title'			=> esc_html__( 'Remove Shadow Sticky', 'kitring' ),
					'description'	=> esc_html__( 'Remove shadow from header sticky when activated', 'kitring' ),
					'default'		=> false,
					'dependencies'	=> array(
						array(
							'setting'	=>	'sticky_header_skin',
							'operator'	=>	'==',
							'value'		=>	'on',
						)
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-portfolio',
				array(
					'id'			=> 'overide_main_menu',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Custom Menu', 'kitring' ),
					'description'	=> esc_html__( 'Overide Main menu', 'kitring' ),
					'options'		=> dahz_framework_get_all_menu()
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-portfolio',
				array(
					'id'			=> 'sticky_header_skin',
					'type'			=> 'switcher',
					'default'		=> false,
					'title'			=> esc_html__( 'Enable Transparent Sticky Header', 'kitring' ),
					'description'	=> esc_html__( 'Enable transparent background on header sticky when activated', 'kitring' )
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-portfolio',
				array(
					'id'			=> 'before_header',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Before Header', 'kitring' ),
					'description'	=> esc_html__( 'Display a custom area before & after header area. You can use custom content block to display globally', 'kitring' ),
					'options'		=> dahz_framework_get_content_block( true ),
					'default'		=> 'inherit'
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-portfolio',
				array(
					'id'			=> 'after_header',
					'type'			=> 'select',
					'title'			=> esc_html__( 'After Header', 'kitring' ),
					'description'	=> esc_html__( 'Display a custom area before & after header area. You can use custom content block to display globally', 'kitring' ),
					'options'		=> dahz_framework_get_content_block( true ),
					'default'		=> 'inherit'
				)
			);

		}

		/**
		 * register metabox panel page title on post type portfolio
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param -
		 * @return -
		 */
		public function dahz_framework_register_panel_portfolio_metabox_content( $dahz_meta ) {

			$dahz_meta->dahz_framework_metabox_add_section( 'content-portfolio', esc_html__( 'Content', 'kitring' ) );

			$dahz_meta->dahz_framework_metabox_add_field(
				'content-portfolio',
				array(
					'id'			=> 'disable_portfolio_details',
					'type'			=> 'switcher',
					'title'			=> esc_html__( 'Disable Portfolio Details', 'kitring' ),
					'description'	=> esc_html__( 'Override the portfolio visibility', 'kitring' ),
					'default'		=> false
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'content-portfolio',
				array(
					'id'			=> 'portfolio_details_layout',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Portfolio Details Layout', 'kitring' ),
					'description'	=> esc_html__('Specify the layout template for all the portfolio posts', 'kitring' ),
					'options'		=> array(
										'left'		=> esc_html__( 'Details on Left', 'kitring' ),
										'right'		=> esc_html__( 'Details on Right', 'kitring' ),
										'bottom'	=> esc_html__( 'Details on Bottom', 'kitring' ),
										'top'		=> esc_html__( 'Details on Top', 'kitring' )
									),
					'default'		=> 'details_on_left',
					'dependencies'	=> array(
						array(
							'setting'	=>	'disable_portfolio_details',
							'operator'	=>	'==',
							'value'		=>	'off',
						)
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'content-portfolio',
				array(
					'id'			=> 'sticky_sidebar',
					'type'			=> 'switcher',
					'title'			=> esc_html__( 'Sticky Sidebar', 'kitring' ),
					'description'	=> esc_html__( 'Activate to have a sticky sidebar', 'kitring' ),
					'default'		=> false,
					'dependencies'	=> array(
						array(
							'setting'	=>	'portfolio_details_layout',
							'operator'	=>	'!==',
							'value'		=>	'top',
						),
						array(
							'setting'	=>	'portfolio_details_layout',
							'operator'	=>	'!==',
							'value'		=>	'bottom',
						)
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'content-portfolio',
				array(
					'id'			=> 'description_title',
					'type'			=> 'textfield',
					'title'			=> esc_html__( 'Description Title', 'kitring' ),
					'dependencies'	=> array(
						array(
							'setting'	=>	'disable_portfolio_details',
							'operator'	=>	'==',
							'value'		=>	'off',
						)
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'content-portfolio',
				array(
					'id'			=> 'description_content',
					'type'			=> 'textarea',
					'title'			=> esc_html__( 'Description', 'kitring' ),
					'description'	=> esc_html__( 'Insert portfolio description', 'kitring' ),
					'dependencies'	=> array(
						array(
							'setting'	=>	'disable_portfolio_details',
							'operator'	=>	'==',
							'value'		=>	'off',
						)
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'content-portfolio',
				array(
					'id'			=> 'portfolio_details',
					'type'			=> 'repeater',
					'title'			=> esc_html__( 'Details', 'kitring' ),
					'options'		=> array(
						array(
							'id' 		=> 'item_title',
							'type'		=> 'textfield',
							'title'		=> __( 'Item Title', 'kitring' ),
							'default'	=> ''
						),
						array(
							'id' 		=> 'item_text',
							'type'		=> 'textfield',
							'title'		=> __( 'Item Text', 'kitring' ),
							'default'	=> ''
						),
						array(
							'id' 		=> 'item_url',
							'type'		=> 'textfield',
							'title'		=> __( 'Enter Full URL for Item Text Link', 'kitring' ),
							'default'	=> ''
						),
					),
					'dependencies'	=> array(
						array(
							'setting'	=>	'disable_portfolio_details',
							'operator'	=>	'==',
							'value'		=>	'off',
						)
					)
				)
			);
		}

		/**
		 * register metabox panel footer on post type portfolio
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param -
		 * @return -
		 */
		public function dahz_framework_register_panel_portfolio_metabox_footer( $dahz_meta ) {

			$dahz_meta->dahz_framework_metabox_add_section( 'footer-portfolio', esc_html__( 'Footer', 'kitring' ) );

			do_action( 'dahz_framework_metabox_before_footer_dahz_meta_portfolio', $dahz_meta );

			$dahz_meta->dahz_framework_metabox_add_field(
				'footer-portfolio',
				array(
					'id'			=> 'footer_preset_saved',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Footer Layout', 'kitring' ),
					'default'		=> 'inherit',
					'description'	=> esc_html__('Select your footer preset & skin, it based from footer builder you have been created before', 'kitring' ),
					'options'		=> dahz_framework_get_builder_presets_option('footer')
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'footer-portfolio',
				array(
					'id'			=> 'before_footer',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Before Footer', 'kitring' ),
					'description'	=> esc_html__( 'Display a custom area before footer area. You can use custom content block to display globally', 'kitring' ),
					'options'		=> dahz_framework_get_content_block( true ),
					'default'		=> 'inherit'
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'footer-portfolio',
				array(
					'id'			=> 'after_footer',
					'type'			=> 'select',
					'title'			=> esc_html__( 'After Footer', 'kitring' ),
					'description'	=> esc_html__( 'Display a custom area after footer area. You can use custom content block to display globally', 'kitring' ),
					'options'		=> dahz_framework_get_content_block( true ),
					'default'		=> 'inherit'
				)
			);

		}

	}

	new Dahz_Framework_Metabox_Portfolio();

}
