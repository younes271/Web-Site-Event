<?php

if( !class_exists( 'Dahz_Framework_Modules_Single_Post_Metabox' ) ){

	Class Dahz_Framework_Modules_Single_Post_Metabox {

		function __construct(){

			add_action( 'dahz_framework_metabox_dahz_meta_post', array( $this, 'dahz_framework_register_panel_to_core' ), 11 );

			add_action( 'dahz_framework_metabox_dahz_meta_post', array( $this, 'dahz_framework_register_panel_metabox_post_header' ), 9 );

			add_action( 'dahz_framework_metabox_dahz_meta_post', array( $this, 'dahz_framework_register_panel_single_video' ), 13 );

			add_action( 'dahz_framework_metabox_dahz_meta_post', array( $this, 'dahz_framework_register_panel_single_audio' ), 14 );

			add_action( 'dahz_framework_metabox_dahz_meta_post', array( $this, 'dahz_framework_register_panel_single_gallery' ), 15 );

			add_action( 'dahz_framework_metabox_dahz_meta_post', array( $this, 'dahz_framework_register_panel_single_footer' ), 16 );

		}

		public function dahz_framework_register_panel_to_core( $dahz_meta ){

			$dahz_meta->dahz_framework_metabox_add_field(
				'contents',
				array(
					'id'			=> 'disable_featured_image',
					'type'			=> 'switcher',
					'default'		=> false,
					'title'			=> esc_html__( 'Disable Featured Image', 'kitring' ),
					'description'	=> esc_html__('This option only works for post format standard', 'kitring' ),
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'contents',
				array(
					'id'		=> 'post_title_alignment',
					'type'		=> 'select',
					'title'		=> esc_html__( 'Page Title Alinment', 'kitring' ),
					'default'	=> 'inherit',
					'options'	=> array(
						'inherit'	=> esc_attr__('Inherit', 'kitring'),
						'left'		=> esc_attr__('Left', 'kitring'),
						'center'	=> esc_attr__('Center', 'kitring'),
					),
					'description'	=> esc_html__('This option will override default option from customizer', 'kitring' ),
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'contents',
				array(
					'id'		=> 'subtitle',
					'type'		=> 'textarea',
					'title'		=> esc_html__( 'Subtitle', 'kitring' ),
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'contents',
				array(
					'id'		=> 'affiliate_title',
					'type'		=> 'textfield',
					'title'		=> esc_html__( 'Custom Content Title', 'kitring' ),
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'contents',
				array(
					'id'		=> 'affiliate_content_block',
					'type'		=> 'select',
					'title'		=> esc_html__( 'Custom Content', 'kitring' ),
					'options'	=> dahz_framework_get_content_block(),
				)
			);

		}

		public function dahz_framework_register_panel_metabox_post_header( $dahz_meta ){

			$dahz_meta->dahz_framework_metabox_add_section( 'header-single',esc_html__('Header', 'kitring' ) );

			do_action( 'dahz_framework_metabox_before_header_dahz_meta_post', $dahz_meta );

			// $dahz_meta->dahz_framework_metabox_add_field(
			// 	'header-single',
			// 	array(
			// 		'id'			=> 'header_transparent_skin',
			// 		'type'			=> 'select',
			// 		'title'			=> esc_html__( 'Header Transparent Skin', 'kitring' ),
			// 		'description'	=> esc_html__('According to the color scheme you choose the text colors will be changed to make it more readable. If you choose theme default the displaying will correspond to the theme options settings', 'kitring' ),
			// 		'options'		=> array(
			// 							'inherit'			=> esc_html__( 'Inherit', 'kitring' ),
			// 							'no-transparency'	=> esc_html__( 'No Transparency', 'kitring' ),
			// 							'transparent-light'	=> esc_html__( 'Light', 'kitring' ),
			// 							'transparent-dark'	=> esc_html__( 'Dark', 'kitring' ),
			// 						)
			// 	)
			// );

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-single',
				array(
					'id'			=> 'overide_main_menu',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Custom Menu', 'kitring' ),
					'description'	=> esc_html__('Overide Main Menu', 'kitring' ),
					'options'		=> dahz_framework_get_all_menu(),
				)
			);

			// $dahz_meta->dahz_framework_metabox_add_field(
			// 	'header-single',
			// 	array(
			// 		'id'			=> 'sticky_header_skin',
			// 		'type'			=> 'switcher',
			// 		'default'		=> false,
			// 		'title'			=> esc_html__( 'Transparent Sticky Header', 'kitring' ),
			// 		'description'	=> esc_html__('Enable transparent background on header sticky when activated', 'kitring' ),
			// 	)
			// );

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-single',
				array(
					'id'			=> 'before_header',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Before Header', 'kitring' ),
					 'description'	=> esc_html__('Display a custom area before header area. You can use custom content block to display globally', 'kitring' ),
					'options'		=> dahz_framework_get_content_block( true ),
					'default'		=> 'inherit'
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'header-single',
				array(
					'id' 			=> 'after_header',
					'type'			=> 'select',
					'title'			=> esc_html__( 'After Header', 'kitring' ),
					'description'	=> esc_html__('Display a custom area after header area. You can use custom content block to display globally', 'kitring' ),
					'options'		=> dahz_framework_get_content_block( true ),
					'default'		=> 'inherit'
				)
			);

		}

		public function dahz_framework_register_panel_single_video( $dahz_meta ){

			$dahz_meta->dahz_framework_metabox_add_section( 'single-video',esc_html__('Video', 'kitring' ), '',
				array(
					array(
						'name'		=>	'post_format',
						'operator'	=>	'==',
						'value'		=>	'video'
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-video',
				array(
					'id'		=> 'video_url',
					'type'		=> 'oembed',
					'title'		=> esc_html__( 'Video Media URL', 'kitring' ),
					'description'	=> esc_html__('Enter Vide URL (ex: Youtube, Vimeo). What sites can I embed From? Here', 'kitring' ),
				)
			);

		}

		public function dahz_framework_register_panel_single_audio( $dahz_meta ){

			$dahz_meta->dahz_framework_metabox_add_section( 'single-audio',esc_html__('Audio', 'kitring' ), '',
				array(
					array(
						'name'		=>	'post_format',
						'operator'	=>	'==',
						'value'		=>	'audio'
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-audio',
				array(
					'id'		=> 'audio_url',
					'type'		=> 'oembed',
					'title'		=> esc_html__( 'Audio Media URL', 'kitring' ),
					'description'	=> esc_html__('Enter Audio URL (ex: Soundcloud). What sites Can I embed From? Here', 'kitring' ),
				)
			);

		}

		public function dahz_framework_register_panel_single_gallery( $dahz_meta ){

			$dahz_meta->dahz_framework_metabox_add_section( 'single-gallery',esc_html__('Gallery', 'kitring' ), '',
				array(
					array(
						'name'		=>	'post_format',
						'operator'	=>	'==',
						'value'		=>	'gallery'
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'enable_lightbox',
					'type'			=> 'switcher',
					'title'			=> esc_html__( 'Enable Lightbox', 'kitring' ),
					'description'	=> esc_html__('Display image lightbox', 'kitring' ),
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'gallery_style',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Gallery Style', 'kitring' ),
					'description'	=> esc_html__('Select gallery style', 'kitring' ),
					'options'		=> array(
						'slider'			=> esc_html__( 'Slider', 'kitring' ),
						'tiled'				=> esc_html__( 'Tiled', 'kitring' )
					),
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'image_upload',
					'type'			=> 'repeater',
					'title'			=> esc_html__( 'Image Upload', 'kitring' ),
					'description'	=> esc_html__('Select from media', 'kitring' ),
					'options'		=> array(
						array(
							'id' 		=> 'image',
							'type'		=> 'image_uploader',
							'title'		=> __( 'Image', 'kitring' ),
							'description'	=> esc_html__('Specify images from media library. Image title and caption are set via WordPress media library', 'kitring' ),
						),
						array(
							'id' 		=> 'media_width',
							'type'		=> 'range',
							'title'		=> __( 'Media Width', 'kitring' ),
							'description'	=> esc_html__('Settings for image width & height will work only if the option is set as masonry', 'kitring' ),
						),
						array(
							'id' 		=> 'media_height',
							'type'		=> 'range',
							'title'		=> __( 'Media Height', 'kitring' ),
							'description'	=> esc_html__('Settings for image width & height will work only if the option is set as masonry', 'kitring' ),
						),
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'gallery_height',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Gallery Height', 'kitring' ),
					'description'	=> esc_html__('Select gallery area height', 'kitring' ),
					'options'		=> array(
						'auto'						=> esc_html__( 'Auto', 'kitring' ),
						'viewport-minus-section'	=> esc_html__( 'Viewport (Minus the following section)', 'kitring' ),
						'viewport'					=> esc_html__( 'Viewport', 'kitring' ),
						'viewport-minus-percent'	=> esc_html__( 'Viewport (Minus 20%)', 'kitring' ),
						'match-height'				=> esc_html__( 'Match Height', 'kitring' )
					),
					'dependencies'	=> array(
						array(
							'setting'	=>	'gallery_style',
							'operator'	=>	'==',
							'value'		=>	'slider',
						)
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'		=> 'minimum_height',
					'type'		=> 'textfield',
					'title'		=> esc_html__( 'Minimum Height (px)', 'kitring' ),
					'dependencies'	=> array(
						array(
							'setting'	=>	'gallery_height',
							'operator'	=>	'==',
							'value'		=>	'viewport-minus-section',
						),
						array(
							'setting'	=>	'gallery_height',
							'operator'	=>	'==',
							'value'		=>	'viewport',
						),
						array(
							'setting'	=>	'gallery_height',
							'operator'	=>	'==',
							'value'		=>	'viewport-minus-percent',
						)
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'		=> 'desktop_height',
					'type'		=> 'textfield',
					'title'		=> esc_html__( 'Desktop Height (px)', 'kitring' ),
					'dependencies'	=> array(
						array(
							'setting'	=>	'gallery_height',
							'operator'	=>	'==',
							'value'		=>	'match-height',
						)
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'		=> 'mobile_height',
					'type'		=> 'textfield',
					'title'		=> esc_html__( 'Mobile Height (px)', 'kitring' ),
					'dependencies'	=> array(
						array(
							'setting'	=>	'gallery_height',
							'operator'	=>	'==',
							'value'		=>	'match-height',
						)
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'column_gap',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Column Gap', 'kitring' ),
					'description'	=> esc_html__('Select select gap between image', 'kitring' ),
					'options'		=> array(
						'uk-grid-small'			=> esc_html__( 'Small', 'kitring' ),
						'uk-grid-medium'		=> esc_html__( 'Medium', 'kitring' ),
						'uk-grid'				=> esc_html__( 'Default', 'kitring' ),
						'uk-grid-large'			=> esc_html__( 'Large', 'kitring' ),
						'uk-grid-collapse'		=> esc_html__( 'Collapse (No Gutter)', 'kitring' )
					),
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'desktop_column',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Desktop Column', 'kitring' ),
					'description'	=> esc_html__('Select Column', 'kitring' ),
					'options'		=> array(
						'1-1'		=> esc_html__( '1 Column = 100%', 'kitring' ),
						'1-2'		=> esc_html__( '2 Columns = 50%', 'kitring' ),
						'1-3'		=> esc_html__( '3 Columns = 33%', 'kitring' ),
						'1-4'		=> esc_html__( '4 Columns = 25%', 'kitring' ),
						'1-5'		=> esc_html__( '5 Columns = 20%', 'kitring' ),
						'1-6'		=> esc_html__( '6 Columns = 16%', 'kitring' ),
						'5-6'		=> esc_html__( '5/6 Columns = 83%', 'kitring' ),
						'4-5'		=> esc_html__( '4/5 Columns = 80%', 'kitring' ),
						'3-5'		=> esc_html__( '3/5 Columns = 60%', 'kitring' ),
					),
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'tablet_landscape_column',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Tablet Landscape Column', 'kitring' ),
					'description'	=> esc_html__('Select Column', 'kitring' ),
					'options'		=> array(
						'1-1'		=> esc_html__( '1 Column = 100%', 'kitring' ),
						'1-2'		=> esc_html__( '2 Columns = 50%', 'kitring' ),
						'1-3'		=> esc_html__( '3 Columns = 33%', 'kitring' ),
						'1-4'		=> esc_html__( '4 Columns = 25%', 'kitring' ),
						'1-5'		=> esc_html__( '5 Columns = 20%', 'kitring' ),
						'1-6'		=> esc_html__( '6 Columns = 16%', 'kitring' ),
						'5-6'		=> esc_html__( '5/6 Columns = 83%', 'kitring' ),
						'4-5'		=> esc_html__( '4/5 Columns = 80%', 'kitring' ),
						'3-5'		=> esc_html__( '3/5 Columns = 60%', 'kitring' ),
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'phone_landscape_column',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Phone Landscape Column', 'kitring' ),
					'description'	=> esc_html__('Select Column', 'kitring' ),
					'options'		=> array(
						'1-1'		=> esc_html__( '1 Column = 100%', 'kitring' ),
						'1-2'		=> esc_html__( '2 Columns = 50%', 'kitring' ),
						'1-3'		=> esc_html__( '3 Columns = 33%', 'kitring' ),
						'1-4'		=> esc_html__( '4 Columns = 25%', 'kitring' ),
						'1-5'		=> esc_html__( '5 Columns = 20%', 'kitring' ),
						'1-6'		=> esc_html__( '6 Columns = 16%', 'kitring' ),
						'5-6'		=> esc_html__( '5/6 Columns = 83%', 'kitring' ),
						'4-5'		=> esc_html__( '4/5 Columns = 80%', 'kitring' ),
						'3-5'		=> esc_html__( '3/5 Columns = 60%', 'kitring' ),
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'phone_potrait_column',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Phone Potrait Column', 'kitring' ),
					'description'	=> esc_html__('Select Column', 'kitring' ),
					'options'		=> array(
						'1-1'		=> esc_html__( '1 Column = 100%', 'kitring' ),
						'1-2'		=> esc_html__( '2 Columns = 50%', 'kitring' ),
						'1-3'		=> esc_html__( '3 Columns = 33%', 'kitring' ),
						'1-4'		=> esc_html__( '4 Columns = 25%', 'kitring' ),
						'1-5'		=> esc_html__( '5 Columns = 20%', 'kitring' ),
						'1-6'		=> esc_html__( '6 Columns = 16%', 'kitring' ),
						'5-6'		=> esc_html__( '5/6 Columns = 83%', 'kitring' ),
						'4-5'		=> esc_html__( '4/5 Columns = 80%', 'kitring' ),
						'3-5'		=> esc_html__( '3/5 Columns = 60%', 'kitring' ),
					)
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'is_center_active_slide',
					'type'			=> 'switcher',
					'title'			=> esc_html__( 'Center Active Slide', 'kitring' ),
					'dependencies'	=> array(
						array(
							'setting'	=>	'gallery_style',
							'operator'	=>	'==',
							'value'		=>	'slider',
						)
					),
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'single-gallery',
				array(
					'id'			=> 'autoplay_gallery_area',
					'type'			=> 'switcher',
					'title'			=> esc_html__( 'Autoplay Gallery Area', 'kitring' ),
					'dependencies'	=> array(
						array(
							'setting'		=>'gallery_style',
							'operator'	=> '==',
							'value'		=> 'slider'
						)
					),
				)
			);

		}

		public function dahz_framework_register_panel_single_footer( $dahz_meta ){

			$dahz_meta->dahz_framework_metabox_add_section( 'footer-single',esc_html__('Footer', 'kitring' ), '',
				array(
					array(
						'id'		=> 'single_template',
						'operator'	=> '!==',
						'value'		=> 'blank-template.php'
					)
				)
			);

			do_action( 'dahz_framework_metabox_before_footer_dahz_meta_post', $dahz_meta );

			$dahz_meta->dahz_framework_metabox_add_field(
				'footer-single',
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
				'footer-single',
				array(
					'id'			=> 'before_footer',
					'type'			=> 'select',
					'title'			=> esc_html__( 'Before Footer', 'kitring' ),
					'description'	=> esc_html__('Display a custom area before footer area. You can use custom content block to display globally', 'kitring' ),
					'options'		=> dahz_framework_get_content_block( true ),
					'default'		=> 'inherit'
				)
			);

			$dahz_meta->dahz_framework_metabox_add_field(
				'footer-single',
				array(
					'id'			=> 'after_footer',
					'type'			=> 'select',
					'title'			=> esc_html__( 'After Footer', 'kitring' ),
					'description'	=> esc_html__('Display a custom area after footer area. You can use custom content block to display globally', 'kitring' ),
					'options'		=> dahz_framework_get_content_block( true ),
					'default'		=> 'inherit'
				)
			);

		}

	}

	new Dahz_Framework_Modules_Single_Post_Metabox();

}
