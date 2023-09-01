<?php
if( !class_exists( 'Dahz_Framework_Customizer_Init' ) ){

	Class Dahz_Framework_Customizer_Init{

		function __construct(){

			add_action( 'init', array( $this, 'dahz_framework_customizer_init' ), 1 );

			add_action( 'customize_preview_init', array( $this, 'dahz_framework_customizer_preview_init' ) );

			add_action( 'dahz_framework_customizer_preview_init', 'dahz_framework_set_customize_options' );

			add_action( 'customize_controls_enqueue_scripts', array( $this, 'dahz_framework_customize_controls_enqueue_scripts' ) );
			
			add_action( 'wp_ajax_df_customize_builder', array( $this, 'dahz_framework_customize_builder_render' ) );

			add_action( 'wp_ajax_nopriv_df_customize_builder', array( $this, 'dahz_framework_customize_builder_render' ) );

			add_action( 'wp_ajax_df_customize_builder_save_preset', array( $this, 'dahz_framework_customize_builder_save_preset' ) );

			add_action( 'wp_ajax_nopriv_df_customize_builder_save_preset', array( $this, 'dahz_framework_customize_builder_save_preset' ) );

			add_action( 'wp_ajax_df_customize_builder_remove_preset', array( $this, 'dahz_framework_customize_builder_remove_preset' ) );
			
			add_action( 'wp_ajax_nopriv_df_customize_builder_remove_preset', array( $this, 'dahz_framework_customize_builder_remove_preset' ) );

			add_action( 'wp_ajax_df_customize_builder_get_saved_preset', array( $this, 'dahz_framework_customize_builder_get_saved_preset' ) );

			add_action( 'wp_ajax_nopriv_df_customize_builder_get_saved_preset', array( $this, 'dahz_framework_customize_builder_get_saved_preset' ) );
			
			add_action( 'wp_ajax_dahz_framework_purge_merged_scripts', array( $this, 'dahz_framework_purge_merged_scripts' ) );

			add_action( 'wp_ajax_nopriv_dahz_framework_purge_merged_scripts', array( $this, 'dahz_framework_purge_merged_scripts' ) );
			
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'dahz_framework_customize_shortcut_render' ), 1000 );

			add_filter( 'dahz_framework_customize_header_builder_items', 'dahz_framework_header_lists' );

			add_filter( 'dahz_framework_customize_footer_builder_items', 'dahz_framework_footer_lists' );

			add_filter( 'dahz_framework_customize_headermobile_builder_items', 'dahz_framework_headermobile_lists' );

			//add_action( 'customize_save_footer_builder_element_desktop_edit', array( $this, 'abc' ) );
			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/kirki/kirki.php' );
			
			if( is_customize_preview() ){

				dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/class-dahz-framework-customizer.php' );

				dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/class-dahz-framework-customizer-extend.php' );

				dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/class-dahz-framework-customizer-core.php' );

				add_filter( 'dahz_framework_builder_element_json', array( $this, 'dahz_framework_builder_element_edit_state' ), 20, 3 );

			}

			add_filter( 'kirki/config', array( $this, 'kirki_configuration_styling' ) );

		}
		
		public function dahz_framework_purge_merged_scripts(){
			
			array_map( 'unlink', glob( get_template_directory() . '/assets/merged/*.css' ) );
			
			array_map( 'unlink', glob( get_template_directory() . '/assets/merged/*.js' ) );
			
		}
		/**
		 * function 	: dahz_framework_builder_element_edit_state
		 * Description 	: filter for builder element when edit presets
		 * param 		: $builder_element, $builder_type, $device_type
		 * return		: string
		 */
		function dahz_framework_builder_element_edit_state( $builder_element, $builder_type, $device_type ){

			global $dahz_framework;

			$builder_is_edit = dahz_framework_get_option( "{$builder_type}_builder_element_{$device_type}_is_edit", false );

			if( $builder_is_edit ){

				$builder_element = dahz_framework_get_option( "{$builder_type}_builder_element_{$device_type}_edit" );

			}

			return $builder_element;

		}
		/**
		 * dahz_framework_customizer_init
		 * initiate customizer builder
		 * @param -
		 * @return -
		 */
		public function dahz_framework_customizer_init(){

			global $dahz_framework;

			if( ( !is_admin() || defined( 'DOING_AJAX' ) ) && ( !is_customize_preview() || defined( 'DOING_AJAX' ) ) ){

				$dahz_framework->mods = apply_filters( 'dahz_framework_theme_mods', get_theme_mods() );

			}

			if( is_customize_preview() ){

				global $dahz_framework_customizer;

				$dahz_framework_customizer = ( object ) array(

					'settings'	=> array(),

				);

				do_action( 'dahz_framework_customizer_setting' );

			}

			do_action( 'dahz_framework_customizer_init' );

		}

		/**
		 * dahz_framework_customizer_preview_init
		 * initiate customizer builder preview
		 * @param - $manager
		 * @return -
		 */
		public function dahz_framework_customizer_preview_init( $manager ){

			global $dahz_framework;

			$dahz_framework->mods = get_theme_mods();

			if( !empty( $dahz_framework->mods ) ){

				foreach( $dahz_framework->mods as $option => $value ){

					$dahz_framework->mods[$option] = apply_filters( "theme_mod_{$option}", $dahz_framework->mods[$option] );

				}

			}

			do_action( 'dahz_framework_customizer_preview_init' );

		}

		/**
		 * dahz_framework_customize_controls_enqueue_scripts
		 * enqueue script customizer builder
		 * @param -
		 * @return -
		 */
		public function dahz_framework_customize_controls_enqueue_scripts(){

			global $dahz_export_import_error;

			wp_register_script( 'dahz-framework-customizer', get_template_directory_uri() . '/dahz-framework/admin/assets/js/dahz-framework-customizer.js', array( 'jquery' ), null, true );

			wp_localize_script(
				'dahz-framework-customizer',
				'dfExportImport',
				array(
					'messages' => array(
						'emptyImport'			=> esc_html__( 'Please choose a file to import.', 'kitring' ),
						'dahzExportImportError' => $dahz_export_import_error
					),
					'config' => array(
						'customizerURL'				=> admin_url( 'customize.php' ),
						'exportNonce'				=> wp_create_nonce( 'dahz-customizer-exporting' ),
						'exportColorSchemeNonce'	=> wp_create_nonce( 'dahz-customizer-color-scheme-exporting' ),
						'headerPresetNonce'			=> wp_create_nonce( 'dahz-header-preset-exporting' ),
						'footerPresetNonce'			=> wp_create_nonce( 'dahz-footer-preset-exporting' )
					)
				)
			);

			wp_localize_script(
				'dahz-framework-customizer', 
				'dfCustomizerLocalize',
				array(
					'notices'		=> array(
						'deletedMergedScripts'	=> esc_html__( 'All Scripts Has Been Deleted', 'kitring' )
					),
					'ajaxURL' 		=> admin_url( 'admin-ajax.php' ),
					'isDevelopMode'	=> DAHZ_FRAMEWORK_DEVELOP_MODE,
					'messages'		=> array(
						'errorSavePresetIncomplete' => esc_html__( 'Please Complete The Form', 'kitring' ),
						'itemNotExist'				=> esc_html__( 'This Item Not Exist', 'kitring' ),
					),
					'items'			=> array(
						'header'		=> dahz_framework_get_builder_items( 'header' ),
						'headermobile'	=> dahz_framework_get_builder_items( 'headermobile' ),
						'footer'		=> dahz_framework_get_builder_items( 'footer' ),
					),
					'presetRequired'	=> apply_filters(
						'dahz_framework_preset_required',
						array(
							'header'		=> array(
								'sections'	=> array(
									'header_section1',
									'header_section2',
									'header_section3',
								),
								'controls'	=> array(
									'logo_and_site_identity_is_header_fullwidth',
								),
								'exclude_sections'	=> array(
									'menu_locations'
								),
								'exclude_controls'	=> array(
									'blogname',
									'blogdescription',
									'site_icon'
								)
							),
							'footer'		=> array(
								'sections'	=> array(
									'footer_section1',
									'footer_section2',
									'footer_section3',
								),
								'controls'	=> array(
								
								),
								'exclude_sections'	=> array(
									'menu_locations',
								)
							),
							'headermobile'	=> array(
								'sections'	=> array(
									
								),
								'controls'	=> array(
								
								),
								'exclude_sections'	=> array(
									'menu_locations',
									'logo_and_site_identity'
								)
							),
						)
					)
				)
			);
			
			wp_enqueue_script( 'dahz-framework-customizer' );

		}

		/**
		 * dahz_framework_customize_builder_render
		 * render customizer builder
		 * @param -
		 * @return -
		 */
		public function dahz_framework_customize_builder_render(){

			$builder_type = $_POST['builder_type'];

			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/html-customize-builder.php' );

			die;

		}

		/**
		 * dahz_framework_customize_shortcut_render
		 * render customizer builder shortcut
		 * @param -
		 * @return -
		 */
		public function dahz_framework_customize_shortcut_render(){

			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/customizer/html-customize-shortcut.php' );

		}

		/**
		 * dahz_framework_customize_builder_save_preset
		 * save builder preset to database
		 * @param -
		 * @return -
		 */
		public function dahz_framework_customize_builder_save_preset(){

			$preset = $_POST['preset'];

			if ( empty( $preset['name'] ) ) {

				echo json_encode( array( 'status' => 0, 'message' => esc_html__( "Name is required", 'kitring' ) ) );

				die();

			}

			if ( empty( $preset['value'] ) || !is_array( $preset['value'] ) ) {

				echo json_encode( array( 'status' => 0, 'message' => esc_html__( "Value is not valid", 'kitring' ) ) );

				die();

			}

			$builder_type = $preset['builder_type'];

			$customize_builder_presets = get_option( "dahz_customize_{$builder_type}_builder_presets" );

			if ( isset( $customize_builder_presets[$preset['name']] ) && $preset['action_type'] !== 'replace' ) {

				echo json_encode( array( 'status' => 2, 'message' => esc_html__( "Preset is already exist", 'kitring' ) ) );

				die();

			}

			if ( !isset( $preset['value'] ) ) {

				$preset['value'] = array( 
					'dataSection' 	=> array(), 
					'1' 			=> array(), 
					'2' 			=> array(), 
					'3' 			=> array() 
				);

			}

			if ( !isset( $preset['value']['dataSection'] ) ) {

				$preset['value']['dataSection'] = array();

			}
			if ( !isset( $preset['value']['1'] ) ) {

				$preset['value']['1'] = array();

			}
			if ( !isset( $preset['value']['2'] ) ) {

				$preset['value']['2'] = array();

			}
			if ( !isset( $preset['value']['3'] ) ) {

				$preset['value']['3'] = array();

			}

			$customize_builder_presets[$preset['name']] = array(
				'option_id'	=> "dahz_customize_{$builder_type}_builder_preset_".$preset['name']
			);
			
			if( DAHZ_FRAMEWORK_DEVELOP_MODE ){
				
				$customize_builder_presets[$preset['name']]['preset_title'] = $preset['title'];
				$customize_builder_presets[$preset['name']]['preset_category_id'] = $preset['category_id'];
				$customize_builder_presets[$preset['name']]['preset_category_name'] = $preset['category_name'];
				$customize_builder_presets[$preset['name']]['preset_image'] = $preset['image'];
				
			}

			update_option( "dahz_customize_{$builder_type}_builder_presets", $customize_builder_presets, 'no' );

			update_option( "dahz_customize_{$builder_type}_builder_preset_".$preset['name'], $preset['value'], 'no' );

			echo json_encode(
				array(
					'status' 	=> 1,
					'message' 	=> esc_html__( "Preset successfully saved", 'kitring' ),
					'type'		=> $preset['action_type'],
					'preset'	=> sprintf(
						'<div class="de-custom-%1$s__preset-item" data-item="saved" data-preset-value="%3$s" data-preset-name="%2$s">
							<div class="de-custom-%1$s__preset-item-placeholder">
								<p>%2$s</p>
								<div class="de-custom-%1$s__preset-item-state">
									<p>Default %1$s</p>
								</div>
								<div class="de-custom-%1$s__preset-item-action">
									<a class="de-custom-%1$s__preset-item-set">
										<span>
											<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.1 490.1" style="enable-background:new 0 0 490.1 490.1;" xml:space="preserve">
												<g>
													<path d="M490.05,404.8V85.2c0-47-38.2-85.2-85.2-85.2c-9.5,0-17.2,7.7-17.2,17.1c0,9.5,7.7,17.2,17.2,17.2
														c28,0,50.9,22.8,50.9,50.9v319.7c0,28.1-22.8,50.9-50.9,50.9H85.25c-28.1,0-50.9-22.8-50.9-50.9V85.2c0-28.1,22.8-50.9,50.9-50.9
														h0.5c9.5,0,16.9-7.7,16.9-17.2S94.75,0,85.25,0c-47,0-85.2,38.2-85.2,85.2v319.7c0,47,38.2,85.2,85.2,85.2h319.7
														C451.85,490,490.05,451.8,490.05,404.8z"/>
													<path d="M165.95,397.4c6.9,0,13.6-2.6,18.9-7.3l59.4-53.5l59.4,53.5c5.2,4.7,11.9,7.3,18.9,7.3c15.6,0,28.3-12.7,28.3-28.3v-352
														c0-9.5-7.7-17.1-17.1-17.1h-179c-9.5,0-17.2,7.7-17.2,17.1v352C137.55,384.7,150.35,397.4,165.95,397.4z M171.85,34.3h144.5
														v321.3l-53.3-48.1c-5.2-4.7-11.9-7.3-18.9-7.3s-13.7,2.6-18.9,7.3l-53.3,48.1V34.3H171.85z"/>
												</g>
											</svg>
										</span>
										Set As Default
									</a>
									<a class="de-custom-%1$s__preset-item-edit">
										<span>
											<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.273 490.273" style="enable-background:new 0 0 490.273 490.273;" xml:space="preserve">
												<g>
													<path d="M313.548,152.387l-230.8,230.9c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5l230.8-230.8
														c6.7-6.7,6.7-17.6,0-24.3C331.148,145.687,320.248,145.687,313.548,152.387z"/>
													<path d="M431.148,191.887c4.4,0,8.8-1.7,12.1-5l25.2-25.2c29.1-29.1,29.1-76.4,0-105.4l-34.4-34.4
														c-14.1-14.1-32.8-21.8-52.7-21.8c-19.9,0-38.6,7.8-52.7,21.8l-25.2,25.2c-6.7,6.7-6.7,17.6,0,24.3l115.6,115.6
														C422.348,190.187,426.748,191.887,431.148,191.887z M352.948,45.987c7.6-7.6,17.7-11.8,28.5-11.8c10.7,0,20.9,4.2,28.5,11.8
														l34.4,34.4c15.7,15.7,15.7,41.2,0,56.9l-13.2,13.2l-91.4-91.4L352.948,45.987z"/>
													<path d="M162.848,467.187l243.5-243.5c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-239.3,239.5l-105.6,14.2l14.2-105.6
														l228.6-228.6c6.7-6.7,6.7-17.6,0-24.3c-6.7-6.7-17.6-6.7-24.3,0l-232.6,232.8c-2.7,2.7-4.4,6.1-4.9,9.8l-18,133.6
														c-0.7,5.3,1.1,10.6,4.9,14.4c3.2,3.2,7.6,5,12.1,5c0.8,0,1.5-0.1,2.3-0.2l133.6-18
														C156.748,471.587,160.248,469.887,162.848,467.187z"/>
												</g>
											</svg>
										</span>
										Edit
									</a>
									<a class="de-custom-%1$s__preset-item-delete">
										<span>
											<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 489.7 489.7" style="enable-background:new 0 0 489.7 489.7;" xml:space="preserve">
												<g>
													<path d="M411.8,131.7c-9.5,0-17.2,7.7-17.2,17.2v288.2c0,10.1-8.2,18.4-18.4,18.4H113.3c-10.1,0-18.4-8.2-18.4-18.4V148.8
														c0-9.5-7.7-17.2-17.1-17.2c-9.5,0-17.2,7.7-17.2,17.2V437c0,29,23.6,52.7,52.7,52.7h262.9c29,0,52.7-23.6,52.7-52.7V148.8
														C428.9,139.3,421.2,131.7,411.8,131.7z"/>
													<path d="M457.3,75.9H353V56.1C353,25.2,327.8,0,296.9,0H192.7c-31,0-56.1,25.2-56.1,56.1v19.8H32.3c-9.5,0-17.1,7.7-17.1,17.2
														s7.7,17.1,17.1,17.1h425c9.5,0,17.2-7.7,17.2-17.1C474.4,83.5,466.8,75.9,457.3,75.9z M170.9,56.1c0-12,9.8-21.8,21.8-21.8h104.2
														c12,0,21.8,9.8,21.8,21.8v19.8H170.9V56.1z"/>
													<path d="M262,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1
														C254.3,413.7,262,406.1,262,396.6z"/>
													<path d="M186.1,396.6V180.9c0-9.5-7.7-17.1-17.2-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1
														C178.4,413.7,186.1,406.1,186.1,396.6z"/>
													<path d="M337.8,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1
														S337.8,406.1,337.8,396.6z"/>
												</g>
											</svg>
										</span>
										Delete
									</a>
								</div>
							</div>
						</div>',
						esc_attr( $builder_type ),
						esc_html( $preset['name'] ),
						esc_attr( htmlspecialchars( json_encode( $preset['value'], true ) ) )
					),
					'presetName'=> $preset['name']
				)
			);

			die();

		}

		/**
		 * dahz_framework_customize_builder_remove_preset
		 * remove saved builder preset from database
		 * @param -
		 * @return -
		 */
		public function dahz_framework_customize_builder_remove_preset(){

			$preset = $_POST['preset'];

			if ( empty( $preset['name'] ) ) {

				echo json_encode( array( 'status' => 0, 'message' => esc_html__( "Name is required", 'kitring' ) ) );

				die();

			}

			$builder_type = $preset['builder_type'];

			$customize_builder_presets = get_option( "dahz_customize_{$builder_type}_builder_presets" );

			if ( isset( $customize_builder_presets[$preset['name']] ) && $preset['action_type'] === 'delete' ) {

				unset( $customize_builder_presets[$preset['name']] );

				echo json_encode( array( 'status' => 1, 'message' => esc_html__( "Preset successfully deleted", 'kitring' ) ) );

			}

			update_option( "dahz_customize_{$builder_type}_builder_presets", $customize_builder_presets, 'no' );

			delete_option( "dahz_customize_{$builder_type}_builder_preset_".$preset['name'] );

			die();

		}

		/**
		 * dahz_framework_customize_builder_get_saved_preset
		 * get saved builder preset from database
		 * @param -
		 * @return -
		 */
		public function dahz_framework_customize_builder_get_saved_preset(){

			$builder_type = $_POST['builder_type'];

			$customize_builder_presets = get_option( "dahz_customize_{$builder_type}_builder_presets" );

			$presets = '';

			$preset_value = array();

			if( !empty( $customize_builder_presets ) && is_array( $customize_builder_presets ) ){

				foreach( $customize_builder_presets as $name => $value ){
					$preset_value = get_option( $value['option_id'] );
					$presets .= sprintf(
						'<div class="de-custom-%1$s__preset-item" data-item="saved" data-preset-value="%3$s" data-preset-name="%2$s">
							<div class="de-custom-%1$s__preset-item-placeholder">
								<p>%2$s</p>
								<div class="de-custom-%1$s__preset-item-state">
									<p>Default %1$s</p>
								</div>
								<div class="de-custom-%1$s__preset-item-action">
									<a class="de-custom-%1$s__preset-item-set">
										<span>
											<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.1 490.1" style="enable-background:new 0 0 490.1 490.1;" xml:space="preserve">
												<g>
													<path d="M490.05,404.8V85.2c0-47-38.2-85.2-85.2-85.2c-9.5,0-17.2,7.7-17.2,17.1c0,9.5,7.7,17.2,17.2,17.2
														c28,0,50.9,22.8,50.9,50.9v319.7c0,28.1-22.8,50.9-50.9,50.9H85.25c-28.1,0-50.9-22.8-50.9-50.9V85.2c0-28.1,22.8-50.9,50.9-50.9
														h0.5c9.5,0,16.9-7.7,16.9-17.2S94.75,0,85.25,0c-47,0-85.2,38.2-85.2,85.2v319.7c0,47,38.2,85.2,85.2,85.2h319.7
														C451.85,490,490.05,451.8,490.05,404.8z"/>
													<path d="M165.95,397.4c6.9,0,13.6-2.6,18.9-7.3l59.4-53.5l59.4,53.5c5.2,4.7,11.9,7.3,18.9,7.3c15.6,0,28.3-12.7,28.3-28.3v-352
														c0-9.5-7.7-17.1-17.1-17.1h-179c-9.5,0-17.2,7.7-17.2,17.1v352C137.55,384.7,150.35,397.4,165.95,397.4z M171.85,34.3h144.5
														v321.3l-53.3-48.1c-5.2-4.7-11.9-7.3-18.9-7.3s-13.7,2.6-18.9,7.3l-53.3,48.1V34.3H171.85z"/>
												</g>
											</svg>
										</span>
										Set As Default
									</a>
									<a class="de-custom-%1$s__preset-item-edit">
										<span>
											<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.273 490.273" style="enable-background:new 0 0 490.273 490.273;" xml:space="preserve">
												<g>
													<path d="M313.548,152.387l-230.8,230.9c-6.7,6.7-6.7,17.6,0,24.3c3.3,3.3,7.7,5,12.1,5s8.8-1.7,12.1-5l230.8-230.8
														c6.7-6.7,6.7-17.6,0-24.3C331.148,145.687,320.248,145.687,313.548,152.387z"/>
													<path d="M431.148,191.887c4.4,0,8.8-1.7,12.1-5l25.2-25.2c29.1-29.1,29.1-76.4,0-105.4l-34.4-34.4
														c-14.1-14.1-32.8-21.8-52.7-21.8c-19.9,0-38.6,7.8-52.7,21.8l-25.2,25.2c-6.7,6.7-6.7,17.6,0,24.3l115.6,115.6
														C422.348,190.187,426.748,191.887,431.148,191.887z M352.948,45.987c7.6-7.6,17.7-11.8,28.5-11.8c10.7,0,20.9,4.2,28.5,11.8
														l34.4,34.4c15.7,15.7,15.7,41.2,0,56.9l-13.2,13.2l-91.4-91.4L352.948,45.987z"/>
													<path d="M162.848,467.187l243.5-243.5c6.7-6.7,6.7-17.6,0-24.3s-17.6-6.7-24.3,0l-239.3,239.5l-105.6,14.2l14.2-105.6
														l228.6-228.6c6.7-6.7,6.7-17.6,0-24.3c-6.7-6.7-17.6-6.7-24.3,0l-232.6,232.8c-2.7,2.7-4.4,6.1-4.9,9.8l-18,133.6
														c-0.7,5.3,1.1,10.6,4.9,14.4c3.2,3.2,7.6,5,12.1,5c0.8,0,1.5-0.1,2.3-0.2l133.6-18
														C156.748,471.587,160.248,469.887,162.848,467.187z"/>
												</g>
											</svg>
										</span>
										Edit
									</a>
									<a class="de-custom-%1$s__preset-item-delete">
										<span>
											<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 489.7 489.7" style="enable-background:new 0 0 489.7 489.7;" xml:space="preserve">
												<g>
													<path d="M411.8,131.7c-9.5,0-17.2,7.7-17.2,17.2v288.2c0,10.1-8.2,18.4-18.4,18.4H113.3c-10.1,0-18.4-8.2-18.4-18.4V148.8
														c0-9.5-7.7-17.2-17.1-17.2c-9.5,0-17.2,7.7-17.2,17.2V437c0,29,23.6,52.7,52.7,52.7h262.9c29,0,52.7-23.6,52.7-52.7V148.8
														C428.9,139.3,421.2,131.7,411.8,131.7z"/>
													<path d="M457.3,75.9H353V56.1C353,25.2,327.8,0,296.9,0H192.7c-31,0-56.1,25.2-56.1,56.1v19.8H32.3c-9.5,0-17.1,7.7-17.1,17.2
														s7.7,17.1,17.1,17.1h425c9.5,0,17.2-7.7,17.2-17.1C474.4,83.5,466.8,75.9,457.3,75.9z M170.9,56.1c0-12,9.8-21.8,21.8-21.8h104.2
														c12,0,21.8,9.8,21.8,21.8v19.8H170.9V56.1z"/>
													<path d="M262,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1
														C254.3,413.7,262,406.1,262,396.6z"/>
													<path d="M186.1,396.6V180.9c0-9.5-7.7-17.1-17.2-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1
														C178.4,413.7,186.1,406.1,186.1,396.6z"/>
													<path d="M337.8,396.6V180.9c0-9.5-7.7-17.1-17.1-17.1s-17.1,7.7-17.1,17.1v215.7c0,9.5,7.7,17.1,17.1,17.1
														S337.8,406.1,337.8,396.6z"/>
												</g>
											</svg>
										</span>
										Delete
									</a>
								</div>
							</div>
						</div>',
						esc_attr( $builder_type ),
						esc_html( $name ),
						esc_attr( htmlspecialchars( json_encode( $preset_value, true ) ) )
					);

				}

			}

			echo apply_filters( 'dahz_framework_builder_saved_preset', $presets );

			die();

		}

		/**
		 * Configuration sample for the Kirki Customizer.
		 * The function's argument is an array of existing config values
		 * The function returns the array with the addition of our own arguments
		 * and then that result is used in the kirki/config filter
		 *
		 * @param $config the configuration array
		 *
		 * @return array
		 */
		public function kirki_configuration_styling( $config ) {
			return wp_parse_args( array(
				'logo_image'   => '',
				'disable_loader' => true
			), $config );
		}

	}

	new Dahz_Framework_Customizer_Init();

}
