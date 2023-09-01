<?php

if ( !class_exists( 'Dahz_Framework_Metabox_Page' ) ) {

	Class Dahz_Framework_Metabox_Page {

		public function __construct() {

			add_action( 'dahz_framework_metabox_dahz_meta_page', array( $this, 'dahz_framework_register_panel_page_metabox_header' ), 8 );

			add_action( 'dahz_framework_metabox_dahz_meta_page', array( $this, 'dahz_framework_register_panel_page_metabox_content' ), 12 );

			add_action( 'dahz_framework_metabox_dahz_meta_page', array( $this, 'dahz_framework_register_panel_page_metabox_footer' ), 12 );

		}

		public function dahz_framework_register_panel_page_metabox_header( $dahz_meta ) {

			$dahz_meta->dahz_framework_metabox_add_section( 'header', esc_html__( 'Header', 'kitring' ), '',
				array(
					array(
						'id'		=>'page_template',
						'operator'	=> '!==',
						'value'		=> 'blank-template.php'
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header',
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

			do_action( 'dahz_framework_metabox_before_header_dahz_meta_page', $dahz_meta );

			$dahz_meta->dahz_framework_metabox_add_field(
				'header',
				array(
					'id'			=> 'overide_main_menu',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Custom Menu', 'kitring' ),
					'description'	=> esc_html__( 'Overide Main menu', 'kitring' ),
					'options'		=> dahz_framework_get_all_menu()
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header',
				array(
					'id'			=> 'sticky_header_skin',
					'type'			=> 'switcher',
					'default'		=> false,
					'title'			=> esc_html__( 'Transparent Sticky Header', 'kitring' ),
					'description'	=> esc_html__( 'Enable transparent background on header sticky when activated', 'kitring' )
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header',
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
				'header',
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

		public function dahz_framework_register_panel_page_metabox_footer( $dahz_meta ) {

			$dahz_meta->dahz_framework_metabox_add_section( 'footer-page', esc_html__( 'Footer', 'kitring' ), '',
				array(
					array(
						'id'		=>'page_template',
						'operator'	=> '!==',
						'value'		=> 'blank-template.php'
					)
				)
			);

			do_action( 'dahz_framework_metabox_before_footer_dahz_meta_page', $dahz_meta );

			$dahz_meta->dahz_framework_metabox_add_field(
				'footer-page',
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
				'footer-page',
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
				'footer-page',
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

		public function dahz_framework_register_panel_page_metabox_content( $dahz_meta ) {

			$dahz_meta->dahz_framework_metabox_add_section( 'contents-page', esc_html__( 'Contents', 'kitring' ), '',
				array(
					array(
						'id'		=>'page_template',
						'operator'	=> '!==',
						'value'		=> 'page-brand.php'
					),
					array(
						'id'		=>'page_template',
						'operator'	=> '!==',
						'value'		=> 'portfolio-template.php'
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'contents-page',
				array(
					'id'			=> 'layout',
					'type'			=> 'radio_image',
					'title'			=> esc_html__( 'Sidebar Layout', 'kitring' ),
					'description'	=> esc_html__('Select sidebar layout', 'kitring' ),
					'options'		=> array(
						'inherit'			=> get_template_directory_uri() . '/assets/images/metabox/df_inherit.svg',
						'fullwidth'			=> get_template_directory_uri() . '/assets/images/metabox/df_layout-full.svg',
						'sidebar-left'		=> get_template_directory_uri() . '/assets/images/metabox/df_layout-left.svg',
						'sidebar-right'		=> get_template_directory_uri() . '/assets/images/metabox/df_layout-right.svg',
					),
					'default'		=> 'default',
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'contents-page',
				array(
					'id'			=> 'enable_featured_area',
					'type'			=> 'switcher',
					'default'		=> false,
					'title'			=> esc_html__( 'Enable Featured Area Slider', 'kitring' ),
					'description'	=> esc_html__( 'Display featured area slider', 'kitring' )
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'contents-page',
				array(
					'id'			=> 'remove_default_padding_top',
					'type'			=> 'switcher',
					'default'		=> false,
					'title'			=> esc_html__( 'Remove Default Padding Top', 'kitring' ),
					'description'	=> esc_html__( 'Remove default Padding top', 'kitring' )
				)
			);
			
			$dahz_meta->dahz_framework_metabox_add_field(
				'contents-page',
				array(
					'id'			=> 'remove_default_padding_bottom',
					'type'			=> 'switcher',
					'default'		=> false,
					'title'			=> esc_html__( 'Remove Default Padding Bottom', 'kitring' ),
					'description'	=> esc_html__( 'Remove default padding bottom', 'kitring' )
				)
			);

		}

	}

	new Dahz_Framework_Metabox_Page();

}
