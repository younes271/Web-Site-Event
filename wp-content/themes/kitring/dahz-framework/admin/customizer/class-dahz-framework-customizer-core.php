<?php

if ( !class_exists( 'Dahz_Framework_Customizer_Core' ) ) {

	Class Dahz_Framework_Customizer_Core extends Dahz_Framework_Customizer {

		static $header_presets = array();
		static $header_presets_default = array();

		public function __construct() {
			self::$header_presets = dahz_framework_get_builder_presets_option( 'header' );
			$this->dahz_framework_general();
			$this->dahz_framework_header();
			$this->dahz_framework_footer();
			$this->dahz_framework_page();
			$this->dahz_framework_blog();
			$this->dahz_framework_export_import();
			if ( class_exists( 'Woocommerce' ) ) {
				$this->dahz_framework_woo();
			}
			add_action( 'customize_register', array( $this, 'dahz_framework_remove_sections' ), 11 );
			add_action( 'customize_register', array( $this, 'dahz_framework_export_import_control' ) );
			add_action( 'customize_register', array( $this, 'dahz_framework_purge_merged_scripts_control' ) );
			add_action( 'customize_register', array( $this, 'dahz_framework_export_import_customizer' ), 999 );
			add_action( 'customize_save_after', array( $this, 'dahz_framework_customize_save_after' ), 10 );

		}

		/**
		* dahz_framework_general
		* Register general section customizer CORE
		* @param -
		* @return -
		*/
		public function dahz_framework_general() {

			/* Custom Code Control Start */

				$custom_code	= array();

				$merge_scripts = array();

				$merge_scripts[] = array(
					'type'			=> 'switch',
					'settings'		=> 'is_merge_scripts',
					'label'			=> esc_html__( 'Enable Scripts Merger', 'kitring' ),
					'description'	=> esc_html__( 'Merge / Concatenate & Minify CSS & JS', 'kitring' ),
					'default'		=> '1',
					'priority'		=> 10,
				);

				$merge_scripts[] = array(
					'type'			=> 'dahz_purge_merged_scripts',
					'settings'		=> 'purge_merged_scripts',
					'default'		=> '',
					'priority'		=> 10,
				);

				// custom css
				$custom_code[]	= array(
					'type'			=> 'code',
					'settings'		=> 'css',
					'label'			=> esc_html__( 'Custom Code CSS', 'kitring' ),
					'description'	=> esc_html__( 'Quickly add custom CSS to your site without any complicated setups. Ideal for minor style alterations or small snippets. Do not place any style tags in these areas as they are already added for your convenience.', 'kitring' ),
					'default'		=> '',
					'priority'		=> 10,
					'choices'		=> array(
						'language'	=> 'css',
						'theme'		=> 'monokai',
						'height'	=> 250,
					),
				);

				// custom js on header
				$custom_code[]	= array(
					'type'			=> 'code',
					'settings'		=> 'js_header',
					'label'			=> esc_html__( 'Custom Code JS Header', 'kitring' ),
					'description'	=> esc_html__( 'Quickly add custom JavaScript to your site without any complicated setups. Ideal for minor style alterations or small snippets. Do not place any script tags in these areas as they are already added for your convenience.', 'kitring' ),
					'default'		=> '',
					'priority'		=> 10,
					'choices'		=> array(
						'language'	=> 'css',
						'theme'		=> 'monokai',
						'height'	=> 250,
					),
				);

				// custom js on footer
				$custom_code[]	= array(
					'type'			=> 'code',
					'settings'		=> 'js_footer',
					'label'			=> esc_html__( 'Custom Code JS Footer', 'kitring' ),
					'description'	=> esc_html__( 'Quickly add custom JavaScript to your site without any complicated setups. Ideal for minor style alterations or small snippets. Do not place any script tags in these areas as they are already added for your convenience.', 'kitring' ),
					'default'		=> '',
					'priority'		=> 10,
					'choices'		=> array(
						'language'	=> 'css',
						'theme'		=> 'monokai',
						'height'	=> 250,
					),
				);

			/* Custom Code Control End */

			/* Custom Code Init Start */

				$this->dahz_framework_add_section_customizer(
					'custom_code',
					array( 'title' => esc_html__( 'Custom Code', 'kitring' ), 'priority' => 9 ),
					$custom_code,
					'general'
				);
				$this->dahz_framework_add_section_customizer(
					'merge_scripts',
					array( 'title' => esc_html__( 'Merge Script', 'kitring' ), 'priority' => 8 ),
					$merge_scripts,
					'general'
				);

			/* Custom Code Init End */

			/* Add Panel General to Customizer */
			
			$this->dahz_framework_customizer_kirki_add_panel(
				'style',
				array(
					'title'			=> esc_html__( 'Style', 'kitring' ),
					'description'	=> esc_html__( 'Change Theme Style Options here.', 'kitring' ),
					'priority'		=> 5
				)
			);

			$this->dahz_framework_customizer_kirki_add_panel(
				'general',
				array(
					'title'			=> esc_html__( 'General', 'kitring' ),
					'description'	=> esc_html__( 'Change Theme General Options here.', 'kitring' ),
					'priority'		=> 1
				)
			);


		}

		/**
		* dahz_framework_header
		* Register header builder section customizer CORE
		* @param -
		* @return -
		*/
		public function dahz_framework_header() {

			/* Header Main Control Start */

				$transport = array(
					'selector'			=> '#de-site-header',
					'render_callback'	=> 'dahz_framework_get_header'
				);

				$header_main	= array();

				$header_main[]	= array(
					'type'				=> 'textarea',
					'settings'			=> 'element_desktop',
					'label'				=> esc_html__( 'Header builder desktop', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'header_builder_element_desktop' => $transport
					)
				);

				$header_main[]	= array(
					'type'				=> 'text',
					'settings'			=> 'element_desktop_preset_used',
					'label'				=> esc_html__( 'Header builder Desktop Preset Use', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'header_builder_element_desktop_preset_used' => $transport
					)
				);

				$header_main[]	= array(
					'type'				=> 'checkbox',
					'settings'			=> 'element_desktop_is_use_preset',
					'label'				=> esc_html__( 'Header builder Desktop is Preset Use', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'header_builder_element_desktop_is_use_preset' => $transport
					)
				);

				$header_main[]	= array(
					'type'				=> 'textarea',
					'settings'			=> 'element_desktop_edit',
					'label'				=> esc_html__( 'Header builder desktop Edit', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'header_builder_element_desktop_edit' => $transport
					)
				);

				$header_main[]	= array(
					'type'				=> 'checkbox',
					'settings'			=> 'element_desktop_is_edit',
					'label'				=> esc_html__( 'Edit', 'kitring' ),
					'default'			=> '0',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'header_builder_element_desktop_is_edit' => $transport
					)
				);

			/* Header Main Control End */

			/* Header Mobile Main Control Start */

				$headermobile_main = array();

				$headermobile_main[] = array(
					'type'				=> 'textarea',
					'settings'			=> 'element_mobile',
					'label'				=> esc_html__( 'Header builder mobile', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'headermobile_builder_element_mobile' => $transport
					)
				);

				$headermobile_main[] = array(
					'type'				=> 'text',
					'settings'			=> 'element_mobile_preset_used',
					'label'				=> esc_html__( 'Header builder Mobile Preset Use', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'headermobile_builder_element_mobile_preset_used' => $transport
					)
				);

				$headermobile_main[] = array(
					'type'				=> 'checkbox',
					'settings'			=> 'element_mobile_is_use_preset',
					'label'				=> esc_html__( 'Header builder Mobile is Preset Use', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'headermobile_builder_element_mobile_is_use_preset' => $transport
					)
				);

				$headermobile_main[]	= array(
					'type'				=> 'textarea',
					'settings'			=> 'element_mobile_edit',
					'label'				=> esc_html__( 'Header builder mobile Edit', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'headermobile_builder_element_mobile_edit' => $transport
					)
				);

				$headermobile_main[]	= array(
					'type'				=> 'checkbox',
					'settings'			=> 'element_mobile_is_edit',
					'label'				=> esc_html__( 'Edit', 'kitring' ),
					'default'			=> '0',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'headermobile_builder_element_mobile_is_edit' => $transport
					)
				);

			/* Header Mobile Main Control End */

				/* Header Logo and Site Identity Control Start */

				$logo_and_site = array();
				// section title: site logo
				$logo_and_site[] = array(
					'type'				=> 'custom',
					'settings'			=> 'custom_title_logo_default',
					'label'				=> '',
					'default'			=> '<div class="de-customizer-title">'. esc_html__( 'Default Logo', 'kitring' ) .'</div>',
					'priority'			=> 12,

				);
				// upload site logo normal
				$logo_and_site[] = array(
					'type'				=> 'image',
					'settings'			=> 'logo_default_normal',
					'label'				=> esc_html__( 'Upload Logo', 'kitring' ),
					'description'		=> esc_html__( 'Upload your custom logo.', 'kitring' ),
					'default'			=> get_template_directory_uri() . '/assets/images/logo/default-logo.svg',
					'priority'			=> 12,
					'partial_refresh'	=> array(
						'logo_and_site_identity_logo_default_normal' => $transport
					)
				);
				// upload site logo retina
				$logo_and_site[] = array(
					'type'				=> 'image',
					'settings'			=> 'logo_default_retina',
					'label'				=> esc_html__( 'Upload Retina Logo', 'kitring' ),
					'description'		=> esc_html__( 'Upload your custom retina logo.', 'kitring' ),
					'default'			=> get_template_directory_uri() . '/assets/images/logo/default-logo.svg',
					'priority'			=> 12,
					'partial_refresh'	=> array(
						'logo_and_site_identity_logo_default_retina' => $transport
					)
				);
				// section title: site icon
				$logo_and_site[] = array(
					'type'				=> 'custom',
					'settings'			=> 'custom_title_site_icon',
					'label'				=> '',
					'default'			=> '<div class="de-customizer-title">'. esc_html__( 'Site Icon', 'kitring' ) .'</div>',
					'priority'			=> 16,
				);
				$logo_and_site[] = array(
					'type'				=> 'select',
					'settings'			=> 'header_style',
					'label'				=> esc_html__( 'Header Style', 'kitring' ),
					'description'		=> esc_html__( 'Select your style of header', 'kitring' ),
					'default'			=> 'horizontal',
					'priority'			=> 11,
					'choices'			=> array(
						'horizontal'	=> 'Horizontal',
						'vertical'		=> 'Vertical',
						'hide'			=> 'Hide',
					),

				);


			/* Header Logo and Site Identity Control End */

			/* Header Before and After Control Start */

				$header_before_after = array();

				$header_before_after[] = array(
					'type'		=> 'textarea',
					'settings'	=> 'before_header',
					'label'		=> esc_html__( 'Before Header', 'kitring' ),
					'default'	=> '',
					'priority'	=> 11,
				);
				$header_before_after[] = array(
					'type'		=> 'textarea',
					'settings'	=> 'after_header',
					'label'		=> esc_html__( 'After Header', 'kitring' ),
					'default'	=> '',
					'priority'	=> 11,
				);

			/* Header Before and After Control End */

			/* Header Section Control Start */

				$header_section		= array();

				$header_section[]	= array(
					'type'		=> 'color',
					'choices'	=> array(
						'alpha' => true,
					),
					'settings'	=> 'section_bg_color',
					'label'		=> esc_html__( 'Background Color', 'kitring' ),
					'default'	=> '#fff',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);
				// section bg img
				$header_section[]	= array(
					'type'		=> 'image',
					'settings'	=> 'section_bg_img',
					'label'		=> esc_html__( 'Background Image', 'kitring' ),
					'default'	=> '',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);
				// section bg img attachment
				$header_section[]	= array(
					'type'		=> 'select',
					'settings'	=> 'section_bg_img_attachment',
					'label'		=> esc_html__( 'Image Attachment', 'kitring' ),
					'default'	=> 'scroll',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'fixed'		=> esc_attr__( 'Fixed', 'kitring' ),
						'scroll'	=> esc_attr__( 'Scroll', 'kitring' ),
					),
				);
				// section bg img position
				$header_section[]	= array(
					'type'		=> 'select',
					'settings'	=> 'section_bg_img_position',
					'label'		=> esc_html__( 'Image Position', 'kitring' ),
					'default'	=> 'left top',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'left top'		=> esc_attr__( 'Left Top', 'kitring' ),
						'center top'	=> esc_attr__( 'Center Top', 'kitring' ),
						'right top '	=> esc_attr__( 'Right Top', 'kitring' ),
						'left center'	=> esc_attr__( 'Left Center', 'kitring' ),
						'center center'	=> esc_attr__( 'Center Center', 'kitring' ),
						'right center '	=> esc_attr__( 'Right Center', 'kitring' ),
						'left bottom'	=> esc_attr__( 'Left Bottom', 'kitring' ),
						'center bottom'	=> esc_attr__( 'Center Bottom', 'kitring' ),
						'right bottom '	=> esc_attr__( 'Right Bottom', 'kitring' ),
					),
				);
				// section bg img repeat
				$header_section[]	= array(
					'type'		=> 'select',
					'settings'	=> 'section_bg_img_repeat',
					'label'		=> esc_html__( 'Image Repeat', 'kitring' ),
					'default'	=> 'repeat',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'repeat'	=> esc_attr__( 'Repeat', 'kitring' ),
						'repeat-x'	=> esc_attr__( 'Repeat-X', 'kitring' ),
						'repeat-y'	=> esc_attr__( 'Repeat-Y', 'kitring' ),
						'no-repeat'	=> esc_attr__( 'No Repeat', 'kitring' ),
					),
				);
				// section bg img size
				$header_section[]	= array(
					'type'		=> 'select',
					'settings'	=> 'section_bg_img_size',
					'label'		=> esc_html__( 'Image Size', 'kitring' ),
					'default'	=> 'auto',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'auto'		=> esc_attr__( 'Auto', 'kitring' ),
						'contain'	=> esc_attr__( 'Contain', 'kitring' ),
						'cover'		=> esc_attr__( 'Cover', 'kitring' ),
					),
				);
				// section title: color
				$header_section[]	= array(
					'type'		=> 'custom',
					'settings'	=> 'custom_title_section_color',
					'label'		=> '',
					'default'	=> '<div class="de-customizer-title">Element Color & Spacing</div>',
					'priority'	=> 11,
				);
				// section color
				$header_section[]	= array(
					'type'		=> 'multicolor',
					'settings'	=> 'section_color',
					'label'		=> esc_html__( 'Element Color', 'kitring' ),
					'default'	=> array(
						'link'	=> '#333',
						'hover'	=> '#999',
					),
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'link'	=> esc_attr__( 'Default Color', 'kitring' ),
						'hover'	=> esc_attr__( 'Hover Color', 'kitring' ),
					),
				);
				// section spacing padding top
				$header_section[]	= array(
					'type'		=> 'slider',
					'settings'	=> 'section_height',
					'label'		=> esc_html__( 'Section Height', 'kitring' ),
					'priority'	=> 11,
					'default'	=> '80',
					'choices'	=> array(
									'min'  => '0',
									'max'  => '500',
									'step' => '1',
								),
				);
				// section spacing padding top
				$header_section[]	= array(
					'type'		=> 'slider',
					'settings'	=> 'section_sticky_height',
					'label'		=> esc_html__( 'Section Sticky Height', 'kitring' ),
					'priority'	=> 11,
					'default'	=> '80',
					'choices'	=> array(
									'min'  => '0',
									'max'  => '500',
									'step' => '1',
								),
				);
				// section spacing padding top
				$header_section[]	= array(
					'type'		=> 'slider',
					'settings'	=> 'section_mobile_height',
					'label'		=> esc_html__( 'Section Mobile Height', 'kitring' ),
					'priority'	=> 11,
					'default'	=> '80',
					'choices'	=> array(
									'min'  => '0',
									'max'  => '100',
									'step' => '1',
								),
				);
				// section spacing border bottom
				$header_section[]	= array(
					'type'		=> 'slider',
					'settings'	=> 'section_border_bottom',
					'label'		=> esc_html__( 'Section Border: Bottom', 'kitring' ),
					'priority'	=> 11,
					'default'	=> 0,
					'choices'	=> array(
									'min'  => '0',
									'max'  => '20',
									'step' => '1',
								),
				);
				// section spacing border color
				$header_section[]	= array(
					'type'		=> 'color',
					'choices'    => array(
						'alpha' => true,
					),
					'settings'	=> 'section_border_color',
					'label'		=> esc_html__( 'Border Color', 'kitring' ),
					'default'	=> '#ececec',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);
				// section spacing border style
				$header_section[]	= array(
					'type'		=> 'select',
					'settings'	=> 'section_border_style',
					'label'		=> esc_html__( 'Section Border Style', 'kitring' ),
					'default'	=> 'solid',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'dotted'	=> esc_attr__( 'Dotted', 'kitring' ),
						'dashed'	=> esc_attr__( 'Dashed', 'kitring' ),
						'solid'		=> esc_attr__( 'Solid', 'kitring' ),
						'double'	=> esc_attr__( 'Double', 'kitring' ),
						'groove'	=> esc_attr__( 'Groove', 'kitring' ),
						'ridge'		=> esc_attr__( 'Ridge', 'kitring' ),
						'inset'		=> esc_attr__( 'Inset', 'kitring' ),
						'outset'	=> esc_attr__( 'Outset', 'kitring' ),
						'none'		=> esc_attr__( 'None', 'kitring' ),
						'hidden'	=> esc_attr__( 'Hidden', 'kitring' ),
					),
				);

			/* Header Section Control End */

			/* Header Main Init Start */

				$this->dahz_framework_add_section_customizer(
					'header_builder',
					array( 'title' => esc_html__( 'Header Builder', 'kitring' ), 'priority' => 1 ),
					$header_main,
					'header'
				);

			/* Header Main Init End */

			/* Header Mobile Main Init Start */

				$this->dahz_framework_add_section_customizer(
					'headermobile_builder',
					array( 'title' => esc_html__( 'Header Mobile Builder', 'kitring' ), 'priority' => 2 ),
					$headermobile_main,
					'header'
				);

			/* Header Mobile Main Init End */

			/* Header Logo and Site Identity Init Start */

				$this->dahz_framework_add_section_customizer(
					'logo_and_site_identity',
					array( 'title' => esc_html__( 'Logo & Site Identity', 'kitring' ), 'priority' => 3 ),
					$logo_and_site,
					'header'
				);

			/* Header Logo and Site Identity Init End */

			/* Header Before and After Init Start */

				$this->dahz_framework_add_section_customizer(
					'before_and_after_header',
					esc_html__( 'Before & After Header', 'kitring' ),
					$header_before_after,
					'header'
				);

			/* Header Before and After Init End */

			/* Header Section 1 Init Start */

				$this->dahz_framework_add_section_customizer(
					'header_section1',
					array( 'title' => esc_html__( 'Header Section 1', 'kitring' ), 'priority' => 4 ),
					$header_section,
					'header'
				);

			/* Header Section 1 Init End */

			/* Header Section 2 Init Start */

				$this->dahz_framework_add_section_customizer(
					'header_section2',
					array( 'title' => esc_html__( 'Header Section 2', 'kitring' ), 'priority' => 5 ),
					$header_section,
					'header'
				);

			/* Header Section 2 Init End */

			/* Header Section 3 Init Start */

				$this->dahz_framework_add_section_customizer(
					'header_section3',
					array( 'title' => esc_html__( 'Header Section 3', 'kitring' ), 'priority' => 5 ),
					$header_section,
					'header'
				);

			/* Header Section 3 Init End */

			/* Add Panel Header to Customizer */

			$this->dahz_framework_customizer_kirki_add_panel(
				'header',
				array(
					'title'			=> esc_html__( 'Header', 'kitring' ),
					'description'	=> esc_html__( 'Change Theme Header Options here.', 'kitring' ),
					'priority'		=> 2
				)
			);

		}

		/**
		* dahz_framework_footer
		* Register footer builder section customizer CORE
		* @param -
		* @return -
		*/
		public function dahz_framework_footer() {

			/* Footer Main Control Start */

				$footer_main	= array();

				$transport = array(
					'selector'			=> '#de-site-footer',
					'render_callback'	=> 'dahz_framework_get_footer'
				);

				$footer_main[]	= array(
					'type'				=> 'textarea',
					'settings'			=> 'element_desktop',
					'label'				=> esc_html__( 'Footer builder Desktop', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'footer_builder_element_desktop' => $transport
					)
				);

				$footer_main[]	= array(
					'type'				=> 'text',
					'settings'			=> 'element_desktop_preset_used',
					'label'				=> esc_html__( 'Footer builder Desktop Preset Use', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'footer_builder_element_desktop_preset_used' => $transport
					)
				);

				$footer_main[]	= array(
					'type'				=> 'checkbox',
					'settings'			=> 'element_desktop_is_use_preset',
					'label'				=> esc_html__( 'Footer builder Desktop is Preset Use', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'footer_builder_element_desktop_is_use_preset' => $transport
					)
				);

				$footer_main[]	= array(
					'type'				=> 'textarea',
					'settings'			=> 'element_desktop_edit',
					'label'				=> esc_html__( 'Footer builder Desktop Edit', 'kitring' ),
					'default'			=> '',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'footer_builder_element_desktop_edit' => $transport
					)
				);

				$footer_main[]	= array(
					'type'				=> 'checkbox',
					'settings'			=> 'element_desktop_is_edit',
					'label'				=> esc_html__( 'edit', 'kitring' ),
					'default'			=> '0',
					'priority'			=> 11,
					'partial_refresh'	=> array(
						'footer_builder_element_desktop_is_edit' => $transport
					)
				);

			/* Footer Main Control End */

			/* Footer General Control Start */

				$footer_element = array();

				// enable footer fullwidth
				$footer_element[] = array(
					'type'			=> 'switch',
					'settings'		=> 'is_footer_fullwidth',
					'label'			=> esc_html__( 'Enable Fullwidth Footer', 'kitring' ),
					'description'	=> esc_html__( 'Enabling this feature, will make your footer wider, you can also add custom padding if this enable', 'kitring' ),
					'default'		=> '0',
					'priority'		=> 10,
				);
				// footer description
				$footer_section[]	= array(
					'type'		=> 'custom',
					'settings'	=> 'custom_title_section_description_copyright',
					'label'		=> '',
					'default'	=> '<div class="de-customizer-title">'. __( 'Footer Description & Copyright', 'kitring' ) .'</div>',
					'priority'	=> 11,
				);

				$footer_element[] = array(
					'type'			=> 'text',
					'settings'		=> 'footer_description_title',
					'label'			=> esc_html__( 'Description Title', 'kitring' ),
					'default'		=> '',
					'priority'		=> 11,
				);

				$footer_element[] = array(
					'type'			=> 'textarea',
					'settings'		=> 'footer_description',
					'label'			=> esc_html__( 'Footer Description', 'kitring' ),
					'description'	=> esc_html__( 'This will displayed on footer, if you put this element on footer builder', 'kitring' ),
					'default'		=> '',
					'priority'		=> 11,
				);
				$footer_element[]	= array(
					'type'		=> 'select',
					'settings'	=> 'footer_description_alignment',
					'label'		=> esc_html__( 'Description Alignment', 'kitring' ),
					'default'	=> '',
					'priority'	=> 11,
					'choices'	=> array(
						'uk-text-left'		=> __( 'Left', 'kitring' ),
						'uk-text-center'	=> __( 'Center', 'kitring' ),
						'uk-text-right'		=> __( 'Right', 'kitring' )
					),
				);
				// footer site info

				$footer_element[] = array(
					'type'		=> 'textarea',
					'settings'	=> 'footer_site_info',
					'label'		=> esc_html__( 'Footer Site Info', 'kitring' ),
					'default'	=> __( '&#169;2018 Kitring – Barber, Salon &amp; MUA WordPress Theme', 'kitring' ),
					'priority'	=> 11,
				);

				$footer_element[] = array(
					'type'			=> 'dimension',
					'settings'		=> 'footer_site_info_font_size',
					'label'			=> esc_html__( 'Copyright Font Size', 'kitring' ),
					'default'		=> '16px',
					'priority'		=> 11,
				);

				$footer_element[]	= array(
					'type'		=> 'select',
					'settings'	=> 'footer_site_info_alignment',
					'label'		=> esc_html__( 'Copyright Alignment', 'kitring' ),
					'default'	=> '',
					'priority'	=> 11,
					'choices'	=> array(
						'uk-text-left'		=> __( 'Left', 'kitring' ),
						'uk-text-center'	=> __( 'Center', 'kitring' ),
						'uk-text-right'		=> __( 'Right', 'kitring' )
					),
				);

			/* Footer General Control End */

			/* Footer Before and After Control Start */

				$footer_before_after	= array();

				$footer_before_after[]	= array(
					'type'		=> 'select',
					'settings'	=> 'before_footer',
					'label'		=> esc_html__( 'Before Footer Content Block', 'kitring' ),
					'default'	=> '',
					'priority'	=> 11,
					'choices'	=> dahz_framework_get_content_block(),
				);

				$footer_before_after[]	= array(
					'type'		=> 'select',
					'settings'	=> 'after_footer',
					'label'		=> esc_html__( 'After Footer Content Block', 'kitring' ),
					'default'	=> '',
					'priority'	=> 12,
					'choices'	=> dahz_framework_get_content_block(),
				);

			/* Footer Before and After Control End */

			/* Footer Section Control Start */

				$footer_section	= array();

				// section bg img
				$footer_section[] = array(
					'type'		=> 'image',
					'settings'	=> 'section_bg_img',
					'label'		=> esc_html__( 'Background Image', 'kitring' ),
					'default'	=> '',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);
				// section bg color
				$footer_section[] = array(
					'type'		=> 'color',
					'choices'    => array(
						'alpha' => true,
					),
					'settings'	=> 'section_bg_color',
					'label'		=> esc_html__( 'Background Color', 'kitring' ),
					'default'	=> '#f9f9f9',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);
				// section bg img attachment
				$footer_section[] = array(
					'type'		=> 'select',
					'settings'	=> 'section_bg_img_attachment',
					'label'		=> esc_html__( 'Image Attachment', 'kitring' ),
					'default'	=> 'scroll',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'fixed'		=> esc_attr__( 'Fixed', 'kitring' ),
						'scroll'	=> esc_attr__( 'Scroll', 'kitring' ),
					),
				);
				// section bg img position
				$footer_section[]	= array(
					'type'		=> 'select',
					'settings'	=> 'section_bg_img_position',
					'label'		=> esc_html__( 'Image Position', 'kitring' ),
					'default'	=> 'left top',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'left top'		=> esc_attr__( 'Left Top', 'kitring' ),
						'center top'	=> esc_attr__( 'Center Top', 'kitring' ),
						'right top '	=> esc_attr__( 'Right Top', 'kitring' ),
						'left center'	=> esc_attr__( 'Left Center', 'kitring' ),
						'center center'	=> esc_attr__( 'Center Center', 'kitring' ),
						'right center '	=> esc_attr__( 'Right Center', 'kitring' ),
						'left bottom'	=> esc_attr__( 'Left Bottom', 'kitring' ),
						'center bottom'	=> esc_attr__( 'Center Bottom', 'kitring' ),
						'right bottom '	=> esc_attr__( 'Right Bottom', 'kitring' ),
					),
				);
				// section bg img repeat
				$footer_section[]	= array(
					'type'		=> 'select',
					'settings'	=> 'section_bg_img_repeat',
					'label'		=> esc_html__( 'Image Repeat', 'kitring' ),
					'default'	=> 'repeat',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'repeat'	=> esc_attr__( 'Repeat', 'kitring' ),
						'repeat-x'	=> esc_attr__( 'Repeat-X', 'kitring' ),
						'repeat-y'	=> esc_attr__( 'Repeat-Y', 'kitring' ),
						'no-repeat'	=> esc_attr__( 'No Repeat', 'kitring' ),
					),
				);
				// section bg img size
				$footer_section[]	= array(
					'type'		=> 'select',
					'settings'	=> 'section_bg_img_size',
					'label'		=> esc_html__( 'Image Size', 'kitring' ),
					'default'	=> 'auto',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'auto'		=> esc_attr__( 'Auto', 'kitring' ),
						'contain'	=> esc_attr__( 'Contain', 'kitring' ),
						'cover'		=> esc_attr__( 'Cover', 'kitring' ),
					),
				);
				// section title: color
				$footer_section[]	= array(
					'type'		=> 'custom',
					'settings'	=> 'custom_title_section_color',
					'label'		=> '',
					'default'	=> '<div class="de-customizer-title">'. __( 'Element Color', 'kitring' ) .'</div>',
					'priority'	=> 11,
				);
				// section color
				$footer_section[]	= array(
					'type'		=> 'multicolor',
					'settings'	=> 'section_color',
					'label'		=> esc_html__( 'Element Color', 'kitring' ),
					'default'	=> array(
						'link'	=> '#393939',
						'hover'	=> '#999999',
					),
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'link'	=> esc_attr__( 'Default Color', 'kitring' ),
						'hover'	=> esc_attr__( 'Hover Color', 'kitring' ),
					),
				);

				$footer_section[]	= array(
					'type'		=> 'color',
					'choices'    => array(
						'alpha' => true,
					),
					'settings'	=> 'body_text_color',
					'label'		=> esc_html__( 'Footer Body Text Color', 'kitring' ),
					'default'	=> '#ececec',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);

				$footer_section[]	= array(
					'type'		=> 'color',
					'choices'    => array(
						'alpha' => true,
					),
					'settings'	=> 'heading_text_color',
					'label'		=> esc_html__( 'Footer Heading Text Color', 'kitring' ),
					'default'	=> '#ececec',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);

				$footer_section[]	= array(
					'type'		=> 'color',
					'choices'    => array(
						'alpha' => true,
					),
					'settings'	=> 'extra_color',
					'label'		=> esc_html__( 'Footer Extra Color', 'kitring' ),
					'default'	=> '#ececec',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);

				$footer_section[]	= array(
					'type'		=> 'color',
					'choices'    => array(
						'alpha' => true,
					),
					'settings'	=> 'widget_title_color',
					'label'		=> esc_html__( 'Footer Widget Title Color', 'kitring' ),
					'default'	=> '#ececec',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);

				$footer_section[]	= array(
					'type'		=> 'color',
					'choices'    => array(
						'alpha' => true,
					),
					'settings'	=> 'divider_color',
					'label'		=> esc_html__( 'Footer Divider Color', 'kitring' ),
					'default'	=> '#ececec',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);

				$footer_section[]	= array(
					'type'		=> 'custom',
					'settings'	=> 'custom_title_section_spacing',
					'label'		=> '',
					'default'	=> '<div class="de-customizer-title">'. __( 'Spacing', 'kitring' ) .'</div>',
					'priority'	=> 11,
				);

				// section spacing padding top
				$footer_section[]	= array(
					'type'		=> 'slider',
					'settings'	=> 'section_padding_top',
					'label'		=> esc_html__( 'Section Padding: Top', 'kitring' ),
					'default'	=> '60',
					'priority'	=> 11,
					'choices'	=> array(
						'min'	=> '0',
						'max'	=> '200',
						'step'	=> '1',
					),
					'transport'	=> 'postMessage'
				);
				// section spacing padding bottom
				$footer_section[]	= array(
					'type'		=> 'slider',
					'settings'	=> 'section_padding_bottom',
					'label'		=> esc_html__( 'Section Padding: Bottom', 'kitring' ),
					'default'	=> '40',
					'priority'	=> 11,
					'choices'	=> array(
						'min'	=> '0',
						'max'	=> '200',
						'step'	=> '1',
					),
					'transport'	=> 'postMessage'
				);
				// section spacing border bottom
				$footer_section[]	= array(
					'type'		=> 'slider',
					'settings'	=> 'section_border_top',
					'label'		=> esc_html__( 'Section Border: Top', 'kitring' ),
					'default'	=> '0',
					'priority'	=> 11,
					'choices'	=> array(
						'min'	=> '0',
						'max'	=> '20',
						'step'	=> '1',
					),
					'transport'	=> 'postMessage'
				);
				// section spacing border style
				$footer_section[]	= array(
					'type'		=> 'select',
					'settings'	=> 'section_border_style',
					'label'		=> esc_html__( 'Section Border Style', 'kitring' ),
					'default'	=> 'none',
					'priority'	=> 11,
					'transport'	=> 'postMessage',
					'choices'	=> array(
						'dotted'	=> esc_attr__( 'Dotted', 'kitring' ),
						'dashed'	=> esc_attr__( 'Dashed', 'kitring' ),
						'solid'		=> esc_attr__( 'Solid', 'kitring' ),
						'double'	=> esc_attr__( 'Double', 'kitring' ),
						'groove'	=> esc_attr__( 'Groove', 'kitring' ),
						'ridge'		=> esc_attr__( 'Ridge', 'kitring' ),
						'inset'		=> esc_attr__( 'Inset', 'kitring' ),
						'outset'	=> esc_attr__( 'Outset', 'kitring' ),
						'none'		=> esc_attr__( 'None', 'kitring' ),
						'hidden'	=> esc_attr__( 'Hidden', 'kitring' ),
					),
				);
				// section spacing border color
				$footer_section[]	= array(
					'type'		=> 'color',
					'choices'    => array(
						'alpha' => true,
					),
					'settings'	=> 'section_border_color',
					'label'		=> esc_html__( 'Border Color', 'kitring' ),
					'default'	=> '#ececec',
					'priority'	=> 11,
					'transport'	=> 'postMessage'
				);

				// section title: color
				$footer_section[]	= array(
					'type'		=> 'custom',
					'settings'	=> 'custom_title_section_toggle',
					'label'		=> '',
					'default'	=> '<div class="de-customizer-title">'. __( 'Section Toggle', 'kitring' ) .'</div>',
					'priority'	=> 11,
				);
				// section title: bgcolor
				$footer_section[] = array(
					'type'			=> 'switch',
					'settings'		=> 'enable_mobile_toggle',
					'label'			=> esc_html__( 'Enable Section Toggle on Mobile', 'kitring' ),
					'description'	=> esc_html__( 'Enabling this feature, will make your footer toggle', 'kitring' ),
					'default'		=> '0',
					'priority'		=> 11,
				);

				$footer_section[] = array(
					'type'		=> 'text',
					'settings'	=> 'mobile_section_title',
					'label'		=> esc_html__( 'Section Title on Mobile', 'kitring' ),
					'default'	=> '',
					'priority'	=> 11,
				);

			/* Footer Section Control End */

			/* Footer Main Init Start */

				$this->dahz_framework_add_section_customizer(
					'footer_builder',
					array( 'title' => esc_html__( 'Footer Builder', 'kitring' ), 'priority' => 1 ),
					$footer_main,
					'footer'
				);

			/* Footer Main Init End */

			/* Footer General Init Start */

				$this->dahz_framework_add_section_customizer(
					'footer_element',
					array( 'title' => esc_html__( 'Footer Element', 'kitring' ), 'priority' => 2 ),
					$footer_element,
					'footer'
				);

			/* Footer General Init End */

			/* Footer Before and After Init Start */

				$this->dahz_framework_add_section_customizer(
					'before_and_after_footer',
					array( 'title' => esc_html__( 'Before and After Footer', 'kitring' ), 'priority' => 6 ),
					$footer_before_after,
					'footer'
				);

			/* Footer Before and After Init End */

			/* Footer Section 1 Init Start */

				$this->dahz_framework_add_section_customizer(
					'footer_section1',
					array( 'title' => esc_html__( 'Footer Section 1', 'kitring' ), 'priority' => 3 ),
					$footer_section,
					'footer'
				);

			/* Footer Section 1 Init End */

			/* Footer Section 2 Init Start */

				$this->dahz_framework_add_section_customizer(
					'footer_section2',
					array( 'title' => esc_html__( 'Footer Section 2', 'kitring' ), 'priority' => 4 ),
					$footer_section,
					'footer'
				);

			/* Footer Section 2 Init End */

			/* Footer Section 3 Init Start */

				$this->dahz_framework_add_section_customizer(
					'footer_section3',
					array( 'title' => esc_html__( 'Footer Section 3', 'kitring' ), 'priority' => 5 ),
					$footer_section,
					'footer'
				);

			/* Footer Section 3 Init End */

			/* Add Panel Footer to Customizer */

			$this->dahz_framework_customizer_kirki_add_panel(
				'footer',
				array(
					'title'			=> esc_html__( 'Footer', 'kitring' ),
					'description'	=> esc_html__( 'Change Theme Footer Options here.', 'kitring' ),
					'priority'		=> 3
				)
			);

		}

		/**
		* dahz_framework_page
		* Register footer builder section customizer CORE
		* @param -
		* @return -
		*/
		public function dahz_framework_page() {

			/* Page Control Start */

				$page	= array();

				$page[]	= array(
					'type'		=> 'radio-image',
					'settings'	=> 'layout',
					'label'		=> esc_html__( 'Sidebar Layout', 'kitring' ),
					'default'	=> 'full',
					'priority'	=> 11,
					'choices'	=> array(
									'fullwidth'  => get_template_directory_uri() . '/assets/images/customizer/df_body-full.svg',
									'sidebar-left'  => get_template_directory_uri() . '/assets/images/customizer/df_body-left-sidebar.svg',
									'sidebar-right' => get_template_directory_uri() . '/assets/images/customizer/df_body-right-sidebar.svg',
								),
				);

			/* Page Control End */

			/* Page Init Start */

				$this->dahz_framework_add_section_customizer(
					'page',
					esc_html__( 'Page', 'kitring' ),
					$page
				);

			/* Page Init End */

			/* Add Panel Page to Customizer */

			$this->dahz_framework_customizer_kirki_add_panel(
				'page',
				array(
					'title'       => esc_html__( 'Page', 'kitring' ),
					'description' => esc_html__( 'Change Theme Page Options here.', 'kitring' ),
					'priority'	  => 8
				)
			);
		}

		/**
		* dahz_framework_blog
		* Register blog section customizer CORE
		* @param -
		* @return -
		*/
		public function dahz_framework_blog() {

			/* Blog Control Start */

				$blog	= array();

				$blog[]	= array(
					'type'		=> 'radio',
					'settings'	=> 'layout',
					'label'		=> esc_html__( 'Post Layout', 'kitring' ),
					'default'	=> 'full_width',
					'priority'	=> 10,
					'choices'	=> array(
						'full_width'	=> esc_attr__( 'Fullwidth', 'kitring' ),
						'left_sidebar'	=> esc_attr__( 'Left Sidebar', 'kitring' ),
						'right_sidebar'	=> esc_attr__( 'Right Sidebar', 'kitring' ),
					),
				);

			/* Blog Control End */


			/* Add Panel Blog to Customizer */

			$this->dahz_framework_customizer_kirki_add_panel(
				'blog',
				array(
					'title'       => esc_html__( 'Blog', 'kitring' ),
					'description' => esc_html__( 'Change Theme Blog Options here.', 'kitring' ),
					'priority'	  => 6
				)
			);

		}

		/**
		* dahz_framework_woo
		* Register woocommerce section customizer CORE
		* @param -
		* @return -
		*/
		public function dahz_framework_woo() {

			/* Add Panel Woocommerce to Customizer */

			$this->dahz_framework_customizer_kirki_add_panel(
				'woocommerce',
				array(
					'title'       => esc_html__( 'Woocommerce', 'kitring' ),
					'description' => esc_html__( 'Change Theme Woocommerce Options here.', 'kitring' ),
					'priority'    => 9,
				)
			);

		}

		/**
		* dahz_framework_remove_sections
		* Unregister default section customizer
		* @param -
		* @return -
		*/
		function dahz_framework_remove_sections() {

			global $wp_customize;

			$wp_customize->remove_section( 'custom_css' );

		}

		/**
		* dahz_framework_export_import_control
		* register export import control
		* @param -
		* @return -
		*/
		public function dahz_framework_export_import_control( $wp_customize ) {

			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/class-dahz-framework-customizer-export-import.php' );
			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/class-dahz-framework-customizer-export-import-color-scheme.php' );
			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/class-dahz-framework-preset-export-import-header.php' );
			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/class-dahz-framework-preset-export-import-footer.php' );
			// Register our custom control with Kirki
			add_filter( 'kirki/control_types', function( $controls ) {
				$controls['dahz_export_import'] = 'Dahz_Framework_Customizer_Export_Import';
				$controls['dahz_export_import_color_scheme'] = 'Dahz_Framework_Customizer_Export_Import_Color_Scheme';
				$controls['dahz_preset_export_import_header'] = 'Dahz_Framework_Preset_Export_Import_Header';
				$controls['dahz_preset_export_import_footer'] = 'Dahz_Framework_Preset_Export_Import_Footer';
				return $controls;
			} );

		}

		public function dahz_framework_purge_merged_scripts_control( $wp_customize ) {

			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/class-dahz-framework-purge-merged-scripts.php' );
			// Register our custom control with Kirki
			add_filter( 'kirki/control_types', function( $controls ) {
				$controls['dahz_purge_merged_scripts'] = 'Dahz_Framework_Purge_Merged_Scripts';
				return $controls;
			} );

		}

		/**
		* dahz_framework_export_import
		* register section export import
		* @param -
		* @return -
		*/
		public function dahz_framework_export_import() {

			$this->dahz_framework_customizer_kirki_add_panel(
				'backup',
				array(
					'title'       => esc_html__( 'Backup', 'kitring' ),
					'description' => '',
					'priority'    => 11,
				)
			);


			$export_import = array();
			$header_import = array();
			$footer_import = array();

			$export_import[] = array(
				'type'		=> 'dahz_export_import',
				'settings'	=> 'export_import',
				'label'		=> esc_html__( 'Export Import', 'kitring' ),
				'default'	=> '',
			);

			$export_import[] = array(
				'type'		=> 'dahz_export_import_color_scheme',
				'settings'	=> 'export_import_color_scheme',
				'label'		=> esc_html__( 'Export Color Scheme', 'kitring' ),
				'default'	=> '',
			);

			$header_import[] = array(
				'type'		=> 'dahz_preset_export_import_header',
				'settings'	=> 'preset_export_import_header',
				'label'		=> esc_html__( 'Export Import', 'kitring' ),
				'default'	=> '',
			);

			$footer_import[] = array(
				'type'		=> 'dahz_preset_export_import_footer',
				'settings'	=> 'preset_export_import_footer',
				'label'		=> esc_html__( 'Export Import', 'kitring' ),
				'default'	=> '',
			);

			$this->dahz_framework_add_section_customizer(
				'export_import',
				array( 'title' => esc_html__( 'Export Import', 'kitring' ), 'priority' => 999 ),
				$export_import,
				'backup'
			);

			$this->dahz_framework_add_section_customizer(
				'header_backup',
				array( 'title' => esc_html__( 'Header Backup', 'kitring' ), 'priority' => 999 ),
				$header_import,
				'backup'
			);

			$this->dahz_framework_add_section_customizer(
				'footer_backup',
				array( 'title' => esc_html__( 'Footer Backup', 'kitring' ), 'priority' => 999 ),
				$footer_import,
				'backup'
			);

		}

		/**
		* reference : Customizer Export/Import plugin
		* dahz_framework_export_import_customizer
		* export import customizer method
		* @param -
		* @return -
		*/
		public function dahz_framework_export_import_customizer( $wp_customize ) {

			global $dahz_export_import_error;

			$dahz_export_import_error = '';

			if ( current_user_can( 'edit_theme_options' ) ) {

				if ( isset( $_REQUEST['dahz-customizer-export'] ) ) {
					$this->dahz_framework_export_customizer( $wp_customize );
				}
				if ( isset( $_REQUEST['dahz-customizer-export-color-scheme'] ) ) {
					$this->dahz_framework_export_customizer( $wp_customize, false, 'color-scheme' );
				}
				if ( isset( $_REQUEST['dahz-header-preset-export'] ) ) {
					$this->dahz_framework_export_customizer( $wp_customize, true, 'header' );
				}
				if ( isset( $_REQUEST['dahz-footer-preset-export'] ) ) {
					$this->dahz_framework_export_customizer( $wp_customize, true, 'footer' );
				}
				if ( isset( $_REQUEST['dahz-customizer-importing'] ) && isset( $_FILES['dahz-customizer-import-file'] ) ) {
					self::dahz_framework_import_customizer( $wp_customize );
				}
				if ( isset( $_REQUEST['dahz-header-preset-importing'] ) && isset( $_FILES['dahz-header-preset-import-file'] ) ) {
					self::dahz_framework_import_customizer( $wp_customize, true, 'header' );
				}
				if ( isset( $_REQUEST['dahz-footer-preset-importing'] ) && isset( $_FILES['dahz-footer-preset-import-file'] ) ) {
					self::dahz_framework_import_customizer( $wp_customize, true, 'footer' );
				}
			}

		}

		/**
		* reference : Customizer Export/Import plugin
		* dahz_framework_export_customizer
		* export customizer method
		* @param -
		* @return -
		*/

		public function dahz_framework_export_customizer( $wp_customize, $is_preset_export = false, $preset_type = '' ) {

			if ( ! $is_preset_export ) {
				if ( isset( $_REQUEST['dahz-customizer-export'] ) && wp_verify_nonce( $_REQUEST['dahz-customizer-export'], 'dahz-customizer-exporting' ) ) {
					$theme		= get_stylesheet();
					$template	= get_template();
					$charset	= get_option( 'blog_charset' );
					$mods		= get_theme_mods();
					foreach( $mods as $key => $value ) {
						if ( $value === false || $value === 'false' || $value === 0 || $value === '0' ) {
							$mods[$key] = false;
						} else if ( $value === true || $value === 'true' || $value === 1 || $value === '1' ) {
							$mods[$key] = true;
						}
					}
					$data		= array(
						'template'  => $template,
						'mods'	  	=> $mods ? $mods : array()
					);

					// Set the download headers.
					header( 'Content-disposition: attachment; filename=' . $theme . '-export-customizer-'.date("Y-m-d").'.json' );
					header( 'Content-Type: application/octet-stream; charset=' . $charset );

					// Serialize the export data.
					echo serialize( $data );

				} else if ( isset( $_REQUEST['dahz-customizer-export-color-scheme'] ) && wp_verify_nonce( $_REQUEST['dahz-customizer-export-color-scheme'], 'dahz-customizer-color-scheme-exporting' ) ) {

					$color_scheme = apply_filters( 'dahz_framework_mods_color_scheme', array( 'layout_background_color', 'layout_color_framed' ) );
					$mods = array();
					foreach( $color_scheme as $color ) {
						$color_mod = get_theme_mod( $color );
						if ( !empty( $color_mod ) ) {
							$mods[$color] = $color_mod;
						}
					}
					$theme		= get_stylesheet();
					$template	= get_template();
					$charset	= get_option( 'blog_charset' );
					$data		= array(
						'template'  => $template,
						'mods'	  	=> $mods ? $mods : array()
					);

					// Set the download headers.
					header( 'Content-disposition: attachment; filename=' . $theme . '-export-customizer-color-scheme-'.date("Y-m-d").'.json' );
					header( 'Content-Type: application/octet-stream; charset=' . $charset );

					// Serialize the export data.
					echo serialize( $data );

				}

				// Start the download.
			} else {

				switch( $preset_type ) {
					case "header" :
						if ( ! wp_verify_nonce( $_REQUEST['dahz-header-preset-export'], 'dahz-header-preset-exporting' ) ) {
							return;
						}
						$this->dahz_framework_export_header_preset();
						break;
					case "footer" :
						if ( ! wp_verify_nonce( $_REQUEST['dahz-footer-preset-export'], 'dahz-footer-preset-exporting' ) ) {
							return;
						}
						$this->dahz_framework_export_footer_preset();
						break;
					default :
						return;
						break;
				}

			}

			die();

		}

		public function dahz_framework_export_header_preset() {

			$header_preset = $this->dahz_framework_build_data_export_preset( get_option( "dahz_customize_header_builder_presets" ) );
			$header_mobile_preset = $this->dahz_framework_build_data_export_preset( get_option( "dahz_customize_headermobile_builder_presets" ) );

			$theme		= get_stylesheet();
			$template	= get_template();
			$charset	= get_option( 'blog_charset' );
			$data		= array(
				'template'  			=> $template,
				'header_presets'		=> !empty( $header_preset ) ? $header_preset : array(),
				'header_mobile_presets'	=> !empty( $header_mobile_preset ) ? $header_mobile_preset : array()
			);

			// Set the download headers.
			header( 'Content-disposition: attachment; filename=' . $theme . '-export-header-presets-'.date("Y-m-d").'.json' );
			header( 'Content-Type: application/octet-stream; charset=' . $charset );

			// Serialize the export data.
			echo serialize( $data );

		}

		public function dahz_framework_build_data_export_preset( $presets ) {

			if ( is_array( $presets ) && !empty( $presets ) ) {

				foreach( $presets as $id => $preset ) {

					$presets[$id]['preset_name'] = $preset['option_id'];
					$presets[$id]['preset_value'] = get_option( $preset['option_id'] );

				}

			}

			return $presets;

		}

		public function dahz_framework_export_footer_preset() {

			$footer_preset = $this->dahz_framework_build_data_export_preset( get_option( "dahz_customize_footer_builder_presets" ) );
			$theme		= get_stylesheet();
			$template	= get_template();
			$charset	= get_option( 'blog_charset' );
			$data		= array(
				'template'			=> $template,
				'footer_presets'	=> !empty( $footer_preset ) ? $footer_preset : array(),
			);

			// Set the download headers.
			header( 'Content-disposition: attachment; filename=' . $theme . '-export-footer-presets-'.date("Y-m-d").'.json' );
			header( 'Content-Type: application/octet-stream; charset=' . $charset );

			// Serialize the export data.
			echo serialize( $data );

		}

		/**
		* reference : Customizer Export/Import plugin
		* dahz_framework_import_customizer
		* import customizer method
		* @param -
		* @return -
		*/

		public function dahz_framework_import_customizer( $wp_customize, $is_import_preset = false, $preset_type = '' ) {

			if ( ! $is_import_preset ) {

				// Make sure we have a valid nonce.
				if ( ! wp_verify_nonce( $_REQUEST['dahz-customizer-importing'], 'dahz-customizer-import' ) ) {
					return;
				}

				// Make sure WordPress upload support is loaded.
				if ( ! function_exists( 'wp_handle_upload' ) ) {
					dahz_framework_include( ABSPATH . 'wp-admin/includes/file.php' );
				}

				// Setup global vars.
				global $wp_customize, $dahz_export_import_error, $wp_filesystem;

				if (!dahz_framework_filesystem_init()) {
					return false;
				}

				// Setup internal vars.
				$dahz_export_import_error = '';
				$template    = get_template();
				$overrides   = array( 'test_form' => false, 'test_type' => false, 'mimes' => array( 'json' => 'text/json' ) );
				$file        = wp_handle_upload( $_FILES['dahz-customizer-import-file'], $overrides );

				// Make sure we have an uploaded file.
				if ( isset( $file['error'] ) ) {
					$dahz_export_import_error = $file['error'];
					return;
				}
				if ( ! file_exists( $file['file'] ) ) {
					$dahz_export_import_error = esc_html__( 'Error importing settings! Please try again.', 'kitring' );
					return;
				}

				// Get the upload data.
				$raw  = $wp_filesystem->get_contents( $file['file'] );
				$data = @unserialize( $raw );

				// Remove the uploaded file.
				unlink( $file['file'] );

				// Data checks.
				if ( 'array' != gettype( $data ) ) {
					$dahz_export_import_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'kitring' );
					return;
				}
				if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
					$dahz_export_import_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'kitring' );
					return;
				}
				if ( $data['template'] != $template ) {
					$dahz_export_import_error = esc_html__( 'Error importing settings! The settings you uploaded are not for the current theme.', 'kitring' );
					return;
				}

				// Import images.
				if ( isset( $_REQUEST['dahz-customizer-import-images'] ) ) {
					$data['mods'] = $this->dahz_framework_import_images( $data['mods'] );
				}

				// Loop through the mods.
				foreach( $data['mods'] as $key => $val ) {

					// Call the customize_save_ dynamic action.
					do_action( 'customize_save_' . $key, $wp_customize );

					// Save the mod.
					set_theme_mod( $key, $val );
				}

				// Call the customize_save_after action.
				do_action( 'customize_save_after', $wp_customize );

			} else {

				$file = array();

				switch( $preset_type ) {
					case "header" :
						if ( ! wp_verify_nonce( $_REQUEST['dahz-header-preset-importing'], 'dahz-header-preset-import' ) ) {
							return;
						}
						$this->dahz_framework_import_header_preset();
						break;
					case "footer" :
						if ( ! wp_verify_nonce( $_REQUEST['dahz-footer-preset-importing'], 'dahz-footer-preset-import' ) ) {
							return;
						}
						$this->dahz_framework_import_footer_preset();
						break;
					default :
						return;
						break;
				}

			}

		}

		public function dahz_framework_import_header_preset() {

			// Make sure WordPress upload support is loaded.
			if ( ! function_exists( 'wp_handle_upload' ) ) {
				dahz_framework_include( ABSPATH . 'wp-admin/includes/file.php' );
			}

			// Setup global vars.
			global $wp_customize, $dahz_export_import_error, $wp_filesystem;

			if (!dahz_framework_filesystem_init()) {
				return false;
			}

			// Setup internal vars.
			$dahz_export_import_error = '';
			$template  = get_template();
			$overrides = array( 'test_form' => false, 'test_type' => false, 'mimes' => array( 'json' => 'text/json' ) );
			$file      = wp_handle_upload( $_FILES['dahz-header-preset-import-file'], $overrides );

			// Make sure we have an uploaded file.
			if ( isset( $file['error'] ) ) {
				$dahz_export_import_error = $file['error'];
				return;

			}
			if ( ! file_exists( $file['file'] ) ) {
				$dahz_export_import_error = esc_html__( 'Error importing settings! Please try again.', 'kitring' );
				return;
			}

			// Get the upload data.
			$raw  = $wp_filesystem->get_contents( $file['file'] );
			$data = @unserialize( $raw );

			// Remove the uploaded file.
			unlink( $file['file'] );

			// Data checks.
			if ( 'array' != gettype( $data ) ) {
				$dahz_export_import_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'kitring' );
				return;
			}
			if ( ! isset( $data['template'] ) || ! isset( $data['header_presets'] ) || ! isset( $data['header_mobile_presets'] ) ) {
				$dahz_export_import_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'kitring' );
				return;
			}
			if ( $data['template'] != $template ) {
				$dahz_export_import_error = esc_html__( 'Error importing settings! The settings you uploaded are not for the current theme.', 'kitring' );
				return;
			}

			$this->dahz_framework_import_preset( 'dahz_customize_header_builder_presets', $data['header_presets'] );

			$this->dahz_framework_import_preset( 'dahz_customize_headermobile_builder_presets', $data['header_mobile_presets'] );

		}

		public function dahz_framework_import_footer_preset() {

			// Make sure WordPress upload support is loaded.
			if ( ! function_exists( 'wp_handle_upload' ) ) {
				dahz_framework_include( ABSPATH . 'wp-admin/includes/file.php' );
			}

			// Setup global vars.
			global $wp_customize, $dahz_export_import_error, $wp_filesystem;

			if (!dahz_framework_filesystem_init()) {
				return false;
			}

			// Setup internal vars.
			$dahz_export_import_error	 = '';
			$template  = get_template();
			$overrides = array( 'test_form' => false, 'test_type' => false, 'mimes' => array( 'json' => 'text/json' ) );
			$file      = wp_handle_upload( $_FILES['dahz-footer-preset-import-file'], $overrides );

			// Make sure we have an uploaded file.
			if ( isset( $file['error'] ) ) {
				$dahz_export_import_error = $file['error'];
				return;

			}
			if ( ! file_exists( $file['file'] ) ) {
				$dahz_export_import_error = esc_html__( 'Error importing settings! Please try again.', 'kitring' );
				return;
			}

			// Get the upload data.
			$raw  = $wp_filesystem->get_contents( $file['file'] );
			$data = @unserialize( $raw );

			// Remove the uploaded file.
			unlink( $file['file'] );

			// Data checks.
			if ( 'array' != gettype( $data ) ) {
				$dahz_export_import_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'kitring' );
				return;
			}
			if ( ! isset( $data['template'] ) || ! isset( $data['footer_presets'] ) ) {
				$dahz_export_import_error = esc_html__( 'Error importing settings! Please check that you uploaded a customizer export file.', 'kitring' );
				return;
			}
			if ( $data['template'] != $template ) {
				$dahz_export_import_error = esc_html__( 'Error importing settings! The settings you uploaded are not for the current theme.', 'kitring' );
				return;
			}

			$this->dahz_framework_import_preset( 'dahz_customize_footer_builder_presets', $data['footer_presets'] );

		}

		public function dahz_framework_import_preset( $option_name, $presets ) {

			$option_preset = get_option( $option_name );

			$option_preset = !is_array( $option_preset ) && empty( $option_preset ) ? array() : $option_preset;

			if ( is_array( $presets ) && !empty( $presets ) ) {

				foreach( $presets as $id => $preset ) {

					$option_preset[$id] = array(
						'option_id'	=> $preset['preset_name']
					);

					update_option( $preset['preset_name'], $preset['preset_value'], 'no' );

				}

				update_option( $option_name, $option_preset, 'no' );

			}

		}

		/**
		* reference : Customizer Export/Import plugin
		* dahz_framework_import_images
		* download and import customizer image
		* @param -
		* @return -
		*/

		public function dahz_framework_import_images( $customizer ) {

			foreach( $customizer as $key => $val ) {

				if ( $this->dahz_framework_is_image_url( $val ) ) {

					$data = $this->dahz_framework_sideload_image( $val );

					if ( ! is_wp_error( $data ) ) {

						$customizer[ $key ] = $data->url;

					}

				}

			}

			return $customizer;

		}

		/**
		* reference : Customizer Export/Import plugin
		* dahz_framework_sideload_image
		* side load image customizer method
		* @param -
		* @return -
		*/
		private function dahz_framework_sideload_image( $file ) {

			$data = new stdClass();

			if ( ! function_exists( 'media_handle_sideload' ) ) {
				dahz_framework_include( ABSPATH . 'wp-admin/includes/media.php' );
				dahz_framework_include( ABSPATH . 'wp-admin/includes/file.php' );
				dahz_framework_include( ABSPATH . 'wp-admin/includes/image.php' );
			}
			if ( ! empty( $file ) ) {

				// Set variables for storage, fix file filename for query strings.
				preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
				$file_array = array();
				$file_array['name'] = basename( $matches[0] );

				// Download file to temp location.
				$file_array['tmp_name'] = download_url( $file );

				// If error storing temporarily, return the error.
				if ( is_wp_error( $file_array['tmp_name'] ) ) {
					return $file_array['tmp_name'];
				}

				// Do the validation and storage stuff.
				$id = media_handle_sideload( $file_array, 0 );

				// If error storing permanently, unlink.
				if ( is_wp_error( $id ) ) {
					@unlink( $file_array['tmp_name'] );
					return $id;
				}

				// Build the object to return.
				$meta					= wp_get_attachment_metadata( $id );
				$data->attachment_id	= $id;
				$data->url				= wp_get_attachment_url( $id );
				$data->thumbnail_url	= wp_get_attachment_thumb_url( $id );
				$data->height			= $meta['height'];
				$data->width			= $meta['width'];
			}

			return $data;
		}

		/**
		* reference : Customizer Export/Import plugin
		* dahz_framework_is_image_url
		* check if value customizer is image
		* @param -
		* @return -
		*/
		private function dahz_framework_is_image_url( $string = '' ) {

			if ( is_string( $string ) ) {

				if ( preg_match( '/\.(jpg|jpeg|png|gif)/i', $string ) ) {
					return true;
				}
			}

			return false;
		}

		public function dahz_framework_customize_save_after( $wp_customize ) {
			
			$current_theme = wp_get_theme();
			
			$theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
			
			update_option( "{$theme_name}_element_styles", dahz_framework_elements()->dahz_framework_get_element_styles() );
			
			if ( !class_exists( 'WP_Filesystem_Base' ) ) dahz_framework_include( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );

			$file_path = get_template_directory() . '/assets/dist/json/manifest.json';

			$response = sprintf(
				'{
					"display": "standalone",
					"orientation": "portrait",
					"short_name": "%1$s",
					"name": "%1$s - %2$s",
					"start_url": "%3$s/?utm_source=homescreen",
					"theme_color": "%4$s",
					"background_color": "%4$s",
					"icons": [
						{
						"src": "%5$s",
						"type": "image/png",
						"sizes": "192x192"
						},
						{
						"src": "%5$s",
						"type": "image/png",
						"sizes": "512x512"
						}
					]
				}',
				esc_html( get_bloginfo( 'name' ) ),
				esc_html( get_bloginfo( 'description' ) ),
				esc_url( get_site_url() ),
				$wp_customize->get_setting( 'logo_and_site_identity_theme_color' )->value(),
				get_stylesheet_directory_uri() . '/favicon.png'
			);

			WP_Filesystem();

			global $wp_filesystem;

			$wp_filesystem->put_contents( $file_path, $response );

		}

		public static function dahz_framework_sanitized_quotes( $value = '', $key = '' ) {

			$value = str_replace( '\\', $value );

			return $value;

		}

	}

	new Dahz_Framework_Customizer_Core();

}
