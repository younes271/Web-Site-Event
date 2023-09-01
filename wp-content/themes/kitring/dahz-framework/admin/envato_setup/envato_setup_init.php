<?php

// This is the setup wizard init file.
// This file changes for each one of dahz's themes
// This is where I extend the default 'Envato_Theme_Setup_Wizard' class and can do things like remove steps from the setup process.

// This particular init file has a custom "Update" step that is triggered on a theme update. If the setup wizard finds some old shortcodes after a theme update then it will go through the content and replace them. Probably remove this from your end product.

if ( ! defined( 'ABSPATH' ) ) exit;


add_filter('envato_setup_logo_image','dtbwp_envato_setup_logo_image');

function dtbwp_envato_setup_logo_image( $old_image_url ){

	return get_template_directory_uri().'/images/logo.png';
}

if ( ! function_exists( 'envato_theme_setup_wizard' ) ) :

	function envato_theme_setup_wizard() {

		if( class_exists('Envato_Theme_Setup_Wizard' ) ) {
			
			class Dahz_Framework_Envato_Theme_Setup_Wizard extends Envato_Theme_Setup_Wizard {

				/**
				 * Holds the current instance of the theme manager
				 *
				 * @since 1.1.3
				 * @var Envato_Theme_Setup_Wizard
				 */
				public static $instance = null;
				
				public $image_color_type = array();
				
				public $dahz_styles = array();
				
				public $dahz_settings = array();
				
				public $attachments = array();
				
				public $attachment_id = '';
				
				public $enable_identic = true;
				
				public $ignore_mods = array(
					'footer_element_payment_logo_normal',
					'footer_element_payment_logo_retina',
					'logo_and_site_identity_logo_default_retina',
					'logo_and_site_identity_logo_light_normal',
					'logo_and_site_identity_logo_light_retina',
					'logo_and_site_identity_logo_dark_normal',
					'logo_and_site_identity_logo_dark_retina',
					'logo_and_site_identity_logo_vertical_normal',
					'logo_and_site_identity_logo_vertical_retina',
					'logo_and_site_identity_logo_default_normal',
					'sticky_header_logo_normal',
					'sticky_header_logo_retina',
					'footer_element_footer_description',
					'footer_element_footer_site_info',
					'nav_menu_locations'
				); 

				/**
				 * @since 1.1.3
				 *
				 * @return Envato_Theme_Setup_Wizard
				 */
				public static function get_instance() {

					if ( ! self::$instance ) {
						self::$instance = new self;
					}
					self::$instance->dahz_styles = array(
						'color_scheme_1'	=> array(
							'name'			=> __( 'Color Scheme 1', 'kitring' ),
							'image'			=> get_template_directory_uri() . '/assets/images/color-scheme/color-scheme-home-1.jpg',
							'file'			=> get_template_directory() . '/assets/presets/color-scheme/color-scheme-1.json',
							'is_local_file' => true
						),
						'color_scheme_2'	=> array(
							'name'			=> __( 'Color Scheme 2', 'kitring' ),
							'image'			=> get_template_directory_uri() . '/assets/images/color-scheme/color-scheme-home-2.jpg',
							'file'			=> get_template_directory() . '/assets/presets/color-scheme/color-scheme-2.json',
							'is_local_file' => true
						),
						'color_scheme_3'	=> array(
							'name'			=> __( 'Color Scheme 3', 'kitring' ),
							'image'			=> get_template_directory_uri() . '/assets/images/color-scheme/color-scheme-home-3.jpg',
							'file'			=> get_template_directory() . '/assets/presets/color-scheme/color-scheme-3.json',
							'is_local_file' => true
						),
						'color_scheme_4'	=> array(
							'name'			=> __( 'Color Scheme 4', 'kitring' ),
							'image'			=> get_template_directory_uri() . '/assets/images/color-scheme/color-scheme-home-4.jpg',
							'file'			=> get_template_directory() . '/assets/presets/color-scheme/color-scheme-4.json',
							'is_local_file' => true
						),
						'color_scheme_5'	=> array(
							'name'			=> __( 'Color Scheme 5', 'kitring' ),
							'image'			=> get_template_directory_uri() . '/assets/images/color-scheme/color-scheme-home-5.jpg',
							'file'			=> get_template_directory() . '/assets/presets/color-scheme/color-scheme-5.json',
							'is_local_file' => true
						),
						'color_scheme_6'	=> array(
							'name'			=> __( 'Color Scheme 6', 'kitring' ),
							'image'			=> get_template_directory_uri() . '/assets/images/color-scheme/color-scheme-home-6.jpg',
							'file'			=> get_template_directory() . '/assets/presets/color-scheme/color-scheme-6.json',
							'is_local_file' => true
						),

					);
					

					return self::$instance;
				}

				public function init_actions(){
					
					if ( apply_filters( $this->theme_name . '_enable_setup_wizard', true ) && current_user_can( 'manage_options' )  ) {
						
						add_filter( 
							$this->theme_name . '_theme_setup_wizard_content', 
							array(
								$this,
								'theme_setup_wizard_content'
							) 
						);
						
						add_filter( $this->theme_name . '_theme_setup_wizard_steps', array(
							$this,
							'theme_setup_wizard_steps'
						) );
						
					}
					
					parent::init_actions();
				}

				public function theme_setup_wizard_steps($steps){
					$steps = array(
						'introduction' => array(
							'name'    => esc_html__( 'Introduction', 'kitring' ),
							'view'    => array( $this, 'envato_setup_introduction' ),
							'handler' => array( $this, 'envato_setup_introduction_save' ),
						),
					);
					
					$steps['child_themes'] = array(
						'name'    => esc_html__( 'Child Themes', 'kitring' ),
						'view'    => array( $this, 'dahz_framework_setup_child_themes' ),
						'handler' => '',
					);
					
					if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
						$steps['default_plugins'] = array(
							'name'    => esc_html__( 'Plugins', 'kitring' ),
							'view'    => array( $this, 'envato_setup_default_plugins' ),
							'handler' => '',
						);
					}
					
					$steps['default_content'] = array(
						'name'    => esc_html__( 'Content', 'kitring' ),
						'view'    => array( $this, 'envato_setup_default_content' ),
						'handler' => '',
					);
					
					$steps['help_support']    = array(
						'name'    => esc_html__( 'Support', 'kitring' ),
						'view'    => array( $this, 'envato_setup_help_support' ),
						'handler' => '',
					);
					$steps['next_steps']      = array(
						'name'    => esc_html__( 'Ready', 'kitring' ),
						'view'    => array( $this, 'envato_setup_ready' ),
						'handler' => '',
					);
					
					return $steps;
				}
				
				public function dahz_framework_is_complete_setup(){
					
					$template = get_stylesheet();
					
					return get_option( "dahz_framework_init_setup_{$template}", false );
					
				}
				
				public function dahz_framework_set_theme_mod( $name, $value ){
					
					if( !in_array( $name, $this->ignore_mods ) ){
						
						$decoded_url = is_string( $value ) && !is_array( json_decode( $value, true ) ) ? urldecode( $value ) : false;
						
						$decoded_json = json_decode( $decoded_url, true );

						$value = $value === 'false' ? false :  $value ;

						$value = $value === 'true' ? true :  $value ;
						
						set_theme_mod( $name, is_array( $decoded_json ) ? $decoded_json : $value );
					
					} else {
						
						remove_theme_mod( $name );
						
					}
					
				}
				
				public function dahz_framework_load_default_setup(){
										
					$this->dahz_framework_set_theme_mod_images();
					
					$file = get_template_directory() . '/assets/presets/style/default.json';
					
					if ( is_file( $file ) ) {
							
						WP_Filesystem();
						
						global $wp_filesystem;

						if ( file_exists( $file ) ) {
							
							$mods = maybe_unserialize( $wp_filesystem->get_contents( $file ) );
							
							$mods = isset( $mods['mods'] ) ? $mods['mods'] : array();
							
							foreach( $mods as $key => $value ){
								
								$this->dahz_framework_set_theme_mod( $key, $value );
								
							}
							
						}
						
					}
					
					$current_theme = wp_get_theme();
			
					$theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
					
					update_option( "{$theme_name}_element_styles", dahz_framework_elements()->dahz_framework_get_element_styles() );
					
					$template = get_stylesheet();
					
					update_option( "dahz_framework_init_setup_{$template}", time(), 'no' );
				
				}
				
				public function dahz_framework_set_theme_mod_images(){
					
					$this->dahz_framework_upload_default_images();
					
					$data_demo_images = get_transient( 'dahz_import_default_images' );

					$mods_with_image_default = array(
						'footer-bg-white-brush'	=> array(
							'footer_section2_section_bg_img'
						),
						'off-canvas'			=> array(
							'header_off_canvas_bg_image'
						),
						'header-brush'			=> array(
							'header_section1_section_bg_img'
						)
						
					);
					foreach( $mods_with_image_default as $image => $mods_page_title ){
						if( isset( $data_demo_images['filedetails'][$image] ) ){
							$image_url = wp_get_attachment_url( $data_demo_images['filedetails'][$image]['image_id'] );
							foreach( $mods_page_title as $mod ){
								set_theme_mod( $mod, $image_url );
							}
						}
					}
					
				}
				
				public function envato_setup_introduction() {

					if ( isset( $_REQUEST['export'] ) ) {

						include( 'envato-setup-export.php' );

					}  else if ( get_option( 'envato_setup_complete', false ) ) {
						dahz_framework_get_template(
							'introduction-setup-complete.php',
							array(
								'_this'	=> $this
							),
							'dahz-framework/admin/envato_setup/templates/'
						);
					} else {
						dahz_framework_get_template(
							'introduction.php',
							array(
								'_this'	=> $this
							),
							'dahz-framework/admin/envato_setup/templates/'
						);
					}
				}
				
				public function dahz_framework_setup_design_save(){
					
					check_admin_referer( 'envato-setup' );
					
					$is_local_file = isset( $_POST['is_local_file'] ) ? $_POST['is_local_file'] : false;
					
					$style = isset( $_POST['style'] ) ? $_POST['style'] : 'style_1';

					if( $is_local_file && !empty( $style ) ){

						if ( isset( $this->dahz_styles[$style]['file'] ) && is_file( $this->dahz_styles[$style]['file'] ) ) {
							
							WP_Filesystem();
							
							global $wp_filesystem;

							if ( file_exists( $this->dahz_styles[$style]['file'] ) ) {
								
								$mods = maybe_unserialize( $wp_filesystem->get_contents( $this->dahz_styles[$style]['file'] ) );
								
								$mods = isset( $mods['mods'] ) ? $mods['mods'] : array();
								
								foreach( $mods as $key => $value ){
									set_theme_mod( $key, $value );
								}
								
							}
							
						}
						
					}
										
					wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
					
					exit;
					
				}
				
				public function dahz_framework_setup_design(){
					
					$styles = $this->dahz_styles;
					
					dahz_framework_get_template(
						'design.php',
						array(
							'_this'		=> $this,
							'styles'	=> $styles
						),
						'dahz-framework/admin/envato_setup/templates/'
					);
					
				}
				
				public function dahz_framework_setup_child_themes(){
					
					dahz_framework_get_template(
						'child-themes.php',
						array(
							'_this'	=> $this
						),
						'dahz-framework/admin/envato_setup/templates/'
					);
					
				}
				
				public function theme_setup_wizard_content( $content ){
					
					return $content;
				}
				
				public function dahz_framework_search_attachment( $item ){
					
					return $item['post_id'] == $this->attachment_id;
					
				}
				
				public function envato_setup_default_content(){
					
					dahz_framework_get_template(
						'default-content.php',
						array(
							'_this'	=> $this
						),
						'dahz-framework/admin/envato_setup/templates/'
					);
				}

				public function dahz_framework_make_child_theme( $new_theme_title ) {

					$parent_theme_title = 'kitring';
					$parent_theme_template = 'kitring';
					$parent_theme_name = get_stylesheet();
					$parent_theme_dir = get_stylesheet_directory();

					// Turn a theme name into a directory name
					$new_theme_name = sanitize_title( $new_theme_title );
					$theme_root = get_theme_root();

					// Validate theme name
					$new_theme_path = $theme_root.'/'.$new_theme_name;
					if ( file_exists( $new_theme_path ) ) {
						// Don't create child theme.
					} else{
						// Create Child theme
						wp_mkdir_p( $new_theme_path );

						$plugin_folder = get_template_directory().'/dahz-framework/admin/envato_setup/child-theme/';

						// Make style.css
						ob_start();
						
						require $plugin_folder.'child-theme-css.php';
						
						$css = ob_get_clean();
						
						WP_Filesystem();
						
						global $wp_filesystem;
						
						$wp_filesystem->put_contents( $new_theme_path.'/style.css', $css );

						// Copy functions.php 
						copy( $plugin_folder.'functions.php', $new_theme_path.'/functions.php' );
						
						// Copy screenshot
						copy( $plugin_folder.'screenshot.png', $new_theme_path.'/screenshot.png' );

						// Make child theme an allowed theme (network enable theme)
						$allowed_themes = get_site_option( 'allowedthemes' );
						
						$allowed_themes[ $new_theme_name ] = true;
						
						update_site_option( 'allowedthemes', $allowed_themes );
					
					}
					
					// Switch to theme
					if($parent_theme_template !== $new_theme_name){
						echo '<p class="lead success">Child Theme <strong>'.$new_theme_title.'</strong> created and activated! Folder is located in wp-content/themes/<strong>'.$new_theme_name.'</strong></p>';
						update_option( 'kitring_child_theme', $new_theme_name, 'no' );
						switch_theme( $new_theme_name, $new_theme_name );
						$this->dahz_framework_load_default_setup();
					}
			}
				
				public function _content_default_get() {

					$content = array();
					
					// find out what content is in our default json file.
					$available_content = $this->_get_json( 'default.json' );
										
					foreach ( $available_content as $post_type => $post_data ) {
						if ( count( $post_data ) ) {
							$first           = current( $post_data );
							$post_type_title = ! empty( $first['type_title'] ) ? $first['type_title'] : ucwords( $post_type ) . 's';
							if ( $post_type_title == 'Navigation Menu Items' ) {
								$post_type_title = 'Navigation';
							}
							$content[ $post_type ] = array(
								'title'            => $post_type_title,
								'description'      => sprintf( esc_html__( 'This will create default %s as seen in the demo.', 'kitring' ), $post_type_title ),
								'pending'          => esc_html__( 'Pending.', 'kitring' ),
								'installing'       => esc_html__( 'Installing.', 'kitring' ),
								'success'          => esc_html__( 'Success.', 'kitring' ),
								'install_callback' => array( $this, '_content_install_type' ),
								'checked'          => $this->is_possible_upgrade() ? 0 : 1,
								// dont check if already have content installed.
							);
						}
					}

					$content['widgets'] = array(
						'title'            => esc_html__( 'Widgets', 'kitring' ),
						'description'      => esc_html__( 'Insert default sidebar widgets as seen in the demo.', 'kitring' ),
						'pending'          => esc_html__( 'Pending.', 'kitring' ),
						'installing'       => esc_html__( 'Installing Default Widgets.', 'kitring' ),
						'success'          => esc_html__( 'Success.', 'kitring' ),
						'install_callback' => array( $this, '_content_install_widgets' ),
						'checked'          => $this->is_possible_upgrade() ? 0 : 1,
						// dont check if already have content installed.
					);
					$content['settings'] = array(
						'title'            => esc_html__( 'Settings', 'kitring' ),
						'description'      => esc_html__( 'Configure default settings.', 'kitring' ),
						'pending'          => esc_html__( 'Pending.', 'kitring' ),
						'installing'       => esc_html__( 'Installing Default Settings.', 'kitring' ),
						'success'          => esc_html__( 'Success.', 'kitring' ),
						'install_callback' => array( $this, '_content_install_settings' ),
						'checked'          => $this->is_possible_upgrade() ? 0 : 1,
						// dont check if already have content installed.
					);

					$content = apply_filters( $this->theme_name . '_theme_setup_wizard_content', $content );

					return $content;

				}
				
				public function dahz_framework_upload_default_images() {

					require_once( ABSPATH . 'wp-admin/includes/file.php' );
					
					$data_demo_images = array();
					
					$data_demo_images_id = array();
					
					$data_demo_images_filename = get_transient( 'dahz_import_default_images' );
					
					$data_demo_images_filename = isset( $data_demo_images_filename['filename'] ) ? $data_demo_images_filename['filename'] : array();
					
					$dahz_setting = $this->_get_json( 'dahz-options.json' );
					
					$wc_setting = isset( $dahz_setting['woocommerce_setting'] ) ? $dahz_setting['woocommerce_setting'] : array();
					
					$shop_thumbnail = isset( $wc_setting['shop_thumbnail_image_size'] ) 
						? 
						$wc_setting['shop_thumbnail_image_size']
						:
						array(
							'width'		=> 180,
							'height'	=> 180,
							'crop'		=> true
						);
						
					update_option( 'shop_thumbnail_image_size', $shop_thumbnail );
					
					$shop_catalog = isset( $wc_setting['shop_catalog_image_size'] ) 
						? 
						$wc_setting['shop_catalog_image_size']
						:
						array(
							'width'		=> 300,
							'height'	=> 300,
							'crop'		=> true
						);
						
					update_option( 'shop_catalog_image_size', $shop_catalog );
					
					$shop_single = isset( $wc_setting['shop_single_image_size'] ) 
						? 
						$wc_setting['shop_single_image_size']
						:
						array(
							'width'		=> 600,
							'height'	=> 600,
							'crop'		=> true
						);
						
					update_option( 'shop_single_image_size', $shop_single );
										
					foreach ( glob(get_template_directory()."/assets/images/default-images/*") as $param ) {
						
						//$filename should be the path to a file in the upload directory.
						$filename = $param;
						
						if( in_array( $filename, $data_demo_images_filename ) ) continue;

						//The ID of the post this attachment is for.

						//Check the type of file. We'll use this as the 'post_mime_type'.
						$filetype = wp_check_filetype( basename( $filename ), null );
						
						$file_name = pathinfo( $filename , PATHINFO_FILENAME );
						
						$file_detail = $this->dahz_framework_parse_filename($file_name);

						// Get the path to the upload directory.
						$wp_upload_dir = wp_upload_dir();
						
						WP_Filesystem();
						
						global $wp_filesystem;
						
						$file_data = $wp_filesystem->get_contents( $filename );
						
						$upload    = wp_upload_bits( basename( $filename ), 0, $file_data, date( "Y-m-d h:i:sa" ) );
						
						if ( $upload['error'] ) {
							return new WP_Error( 'upload_dir_error', $upload['error'] );
						}

						$attachment = array(
							'guid'           => $upload['url'] . '/' . basename( $upload['file'] ), 
							'post_mime_type' => $upload['type'],
							'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload['file'] ) ),
							'post_content'   => '',
							'post_status'    => 'inherit'
						);

						$attach_id = wp_insert_attachment( $attachment, $upload['file'] );

						require_once( ABSPATH . 'wp-admin/includes/image.php' );

						$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
						
						wp_update_attachment_metadata( $attach_id, $attach_data );
						
						if( !isset( $data_demo_images[ 'filedetails' ] ) ){
							$data_demo_images[ 'filedetails' ] = array();
						}

						$data_demo_images[ 'filedetails' ][ $file_name ] = array(
							'image_id'	=> $attach_id,
							'meta_data'	=> wp_get_attachment_metadata( $attach_id )
						);

						if( !isset( $data_demo_images['filename'] ) ){
							$data_demo_images['filename'] = array();
						}

						$data_demo_images['filename'][] = $file_name;
						
					}
					if( !empty( $data_demo_images ) ){
						set_transient( 'dahz_import_default_images', $data_demo_images, 60 * 60 * 24 );
					}
					
					return true;

				}
				
				public function dahz_framework_parse_filename( $file_name ){

					$parse_file_name = explode( '-', $file_name );
					
					return array(
						'orientation'	=> isset( $parse_file_name[1] ) ? $parse_file_name[1] : 'pot',
						'size_type'		=> isset( $parse_file_name[2] ) ? $parse_file_name[2] : 'pot',
						'color_type'	=> isset( $parse_file_name[3] ) ? $parse_file_name[3] : 'pot',
					);
				}
				
				public function dahz_framework_replace_image( $image_id, $type = 'post' ){
					
					if( empty( $image_id ) ) return false;
					
					if( $this->enable_identic ){
						
						return $this->_imported_post_id( $image_id );
					
					}
					
					$this->attachment_id = $image_id;
					
					$result = array_filter( $this->attachments, array( $this, 'dahz_framework_search_attachment' ) );
					
					$keys = array_keys( $result );
					
					if( !empty( $keys ) ){
						
						$image_detail = $result[$keys[0]];
						
						$image_width = isset( $image_detail['meta']['_wp_attachment_metadata']['width'] ) ? $image_detail['meta']['_wp_attachment_metadata']['width'] : 50;

						$image_height = isset( $image_detail['meta']['_wp_attachment_metadata']['height'] ) ? $image_detail['meta']['_wp_attachment_metadata']['height'] : 100;
						
					} else {
						
						$image_detail = array();

						$image_width = 0;
						$image_height = 0;

					}
					
					$default_demo_images = get_transient( 'dahz_import_default_images' );

					$image_orientation = 'pot';

					if( $image_width > $image_height ){
						
						$image_orientation = 'land';
					
					}

					$image_calc = array();
					
					$this->image_color_type[$type] = isset( $this->image_color_type[$type] ) ? $this->image_color_type[$type] : 'l';
					
					if( $this->image_color_type[$type] === 'l' ){
						
						$this->image_color_type[$type] = 'd';
						
					} else {
						
						$this->image_color_type[$type] = 'l';
						
					}
					if( !isset( $default_demo_images[$image_orientation] ) ) return false;
					
					foreach( $default_demo_images[$image_orientation] as $size_type => $default_images ){
						
						if( isset( $default_images[$this->image_color_type[$type]]['image_id'] ) ){
							
							$image_calc[ $default_images[$this->image_color_type[$type]]['image_id'] ] = ( $default_images[$this->image_color_type[$type]]['meta_data']['width'] / $default_images[$this->image_color_type[$type]]['meta_data']['height'] ) - ( $image_width / $image_height );
						
						}
						
					}
					
					asort($image_calc);
					
					reset($image_calc);
					
					$first_key = key($image_calc);
					
					return $first_key;

				}
				
				public function _content_install_updates(){
					
					
					return true;

				}
				
				public function ajax_content() {
					
					$content = $this->_content_default_get();
					
					if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['content'] ) && isset( $content[ $_POST['content'] ] ) ) {
						wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'No content Found', 'kitring' ) ) );
					}
					
					$json         = false;
					
					$this_content = $content[ $_POST['content'] ];

					if ( isset( $_POST['proceed'] ) ) {
						// install the content!

						$this->log( ' -!! STARTING SECTION for ' . $_POST['content'] );

						// init delayed posts from transient.
						$this->delay_posts = get_transient( 'delayed_posts' );
						if ( ! is_array( $this->delay_posts ) ) {
							$this->delay_posts = array();
						}

						if ( ! empty( $this_content['install_callback'] ) ) {
							if ( $result = call_user_func( $this_content['install_callback'] ) ) {

								$this->log( ' -- FINISH. Writing ' . count( $this->delay_posts, COUNT_RECURSIVE ) . ' delayed posts to transient ' );
								set_transient( 'delayed_posts', $this->delay_posts, 60 * 60 * 24 );

								if ( is_array( $result ) && isset( $result['retry'] ) ) {
									// we split the stuff up again.
									$json = array(
										'url'         => admin_url( 'admin-ajax.php' ),
										'action'      => 'envato_setup_content',
										'proceed'     => 'true',
										'retry'       => time(),
										'retry_count' => $result['retry_count'],
										'content'     => $_POST['content'],
										'sub_content' => $_POST['sub_content'],
										'_wpnonce'    => wp_create_nonce( 'envato_setup_nonce' ),
										'message'     => $this_content['installing'],
										'logs'        => $this->logs,
										'errors'      => $this->errors,
									);
								} else {
									$json = array(
										'done'    => 1,
										'message' => $this_content['success'],
										'debug'   => $result,
										'logs'    => $this->logs,
										'errors'  => $this->errors,
									);
								}
							}
						}
					} else {

						$json = array(
							'url'      		=> admin_url( 'admin-ajax.php' ),
							'action'   		=> 'envato_setup_content',
							'proceed'  		=> 'true',
							'content'  		=> $_POST['content'],
							'sub_content' 	=> $_POST['sub_content'],
							'_wpnonce' 		=> wp_create_nonce( 'envato_setup_nonce' ),
							'message'  		=> $this_content['installing'],
							'logs'     		=> $this->logs,
							'errors'   		=> $this->errors,
						);
					}

					if ( $json ) {
						$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
						wp_send_json( $json );
					} else {
						wp_send_json( array(
							'error'   => 1,
							'message' => esc_html__( 'Error', 'kitring' ),
							'logs'    => $this->logs,
							'errors'  => $this->errors,
						) );
					}

					exit;

				}
				
				public function _content_install_type() {
					
					$post_type = ! empty( $_POST['content'] ) ? $_POST['content'] : false;
					
					$sub_content = ! empty( $_POST['sub_content'] ) ? $_POST['sub_content'] : array();
					
					$all_data = $this->_get_json( 'default.json' );

					if ( ! $post_type || ! isset( $all_data[ $post_type ] ) ) {
						return false;
					}
					
					$this->dahz_settings = $this->_get_json( 'dahz-options.json' );
					
					$this->attachments = isset( $all_data['attachment'] ) ? $all_data['attachment'] : array();
					
					$limit = 10 + ( isset( $_REQUEST['retry_count'] ) ? (int) $_REQUEST['retry_count'] : 0 );
					
					$x = 0;

					foreach ( $all_data[ $post_type ] as $post_data ) {
						
						if( !in_array( $post_data['post_id'], $sub_content ) && $post_type !== 'attachment' && $post_type !== "nav_menu_item" ){
							continue;
						}
						
						$this->_process_post_data( $post_type, $post_data );

						if ( $x ++ > $limit ) {
							return array( 'retry' => 1, 'retry_count' => $limit );
						}
					}

					$this->_handle_delayed_posts();

					$this->_handle_post_orphans();

					// now we have to handle any custom SQL queries. This is needed for the events manager to store location and event details.
					$sql = $this->_get_sql( basename( $post_type ) . '.sql' );
					if ( $sql ) {
						global $wpdb;
						// do a find-replace with certain keys.
						if ( preg_match_all( '#__POSTID_(\d+)__#', $sql, $matches ) ) {
							foreach ( $matches[0] as $match_id => $match ) {
								$new_id = $this->_imported_post_id( $matches[1][ $match_id ] );
								if ( ! $new_id ) {
									$new_id = 0;
								}
								$sql = str_replace( $match, $new_id, $sql );
							}
						}
						$sql  = str_replace( '__DBPREFIX__', $wpdb->prefix, $sql );
						$bits = preg_split( "/;(\s*\n|$)/", $sql );
						foreach ( $bits as $bit ) {
							$bit = trim( $bit );
							if ( $bit ) {
								$wpdb->query( $bit );
							}
						}
					}

					return true;

				}
				
				public function _process_post_data( $post_type, $post_data, $delayed = 0, $debug = false ) {
					
					$this->log( " Processing $post_type " . $post_data['post_id'] );
					$original_post_data = $post_data;

					if ( $debug ) {
						echo "HERE\n";
					}
					if ( ! post_type_exists( $post_type ) ) {
						return false;
					}
					if ( ! $debug && $this->_imported_post_id( $post_data['post_id'] ) ) {
						
						return true; // already done :)
					}
					/*if ( 'nav_menu_item' == $post_type ) {
						$this->process_menu_item( $post );
						continue;
					}*/

					if ( empty( $post_data['post_title'] ) && empty( $post_data['post_name'] ) ) {
						// this is menu items
						$post_data['post_name'] = $post_data['post_id'];
					}

					$post_data['post_type'] = $post_type;

					$post_parent = (int) $post_data['post_parent'];
					if ( $post_parent ) {
						// if we already know the parent, map it to the new local ID
						if ( $this->_imported_post_id( $post_parent ) ) {
							$post_data['post_parent'] = $this->_imported_post_id( $post_parent );
							// otherwise record the parent for later
						} else {
							$this->_post_orphans( intval( $post_data['post_id'] ), $post_parent );
							$post_data['post_parent'] = 0;
						}
					}

					// check if already exists
					if ( ! $debug ) {
						if ( empty( $post_data['post_title'] ) && ! empty( $post_data['post_name'] ) ) {
							global $wpdb;
							$sql     = "
							SELECT ID, post_name, post_parent, post_type
							FROM $wpdb->posts
							WHERE post_name = %s
							AND post_type = %s
						";
							$pages   = $wpdb->get_results( $wpdb->prepare( $sql, array(
								$post_data['post_name'],
								$post_type,
							) ), OBJECT_K );
							$foundid = 0;
							foreach ( (array) $pages as $page ) {
								if ( $page->post_name == $post_data['post_name'] && empty( $page->post_title ) ) {
									$foundid = $page->ID;
								}
							}
							
							if ( $foundid ) {
								$this->_imported_post_id( $post_data['post_id'], $foundid );
								
								return true;
							}
						}
						// dont use post_exists because it will dupe up on media with same name but different slug
						if ( ! empty( $post_data['post_title'] ) && ! empty( $post_data['post_name'] ) ) {
							global $wpdb;
							$sql     = "
							SELECT ID, post_name, post_parent, post_type
							FROM $wpdb->posts
							WHERE post_name = %s
							AND post_title = %s
							AND post_type = %s
							";
							$pages   = $wpdb->get_results( $wpdb->prepare( $sql, array(
								$post_data['post_name'],
								$post_data['post_title'],
								$post_type,
							) ), OBJECT_K );
							$foundid = 0;
							foreach ( (array) $pages as $page ) {
								if ( $page->post_name == $post_data['post_name'] ) {
									$foundid = $page->ID;
								}
							}
							if ( $foundid ) {
								$this->_imported_post_id( $post_data['post_id'], $foundid );

								return true;
							}
						}
					}

					// backwards compat with old import format.
					if ( isset( $post_data['meta'] ) ) {
						foreach ( $post_data['meta'] as $key => $meta ) {
							if(is_array($meta) && count($meta) == 1){
								$single_meta = current($meta);
								if(!is_array($single_meta)){
									$post_data['meta'][$key] = $single_meta;
								}
							}
						}
					}

					switch ( $post_type ) {
						case 'attachment':
							// import media via url
						
							if ( ! empty( $post_data['guid'] ) ) {
								
								// check if this has already been imported.
								$old_guid = $post_data['guid'];
								if ( $this->_imported_post_id( $old_guid ) ) {
									
									return true; // alrady done;
								}
								// ignore post parent, we haven't imported those yet.
								//                          $file_data = wp_remote_get($post_data['guid']);
								$remote_url = $post_data['guid'];

								$post_data['upload_date'] = date( 'Y/m', strtotime( $post_data['post_date_gmt'] ) );
								if ( isset( $post_data['meta'] ) ) {
									foreach ( $post_data['meta'] as $key => $meta ) {
										if ( $key == '_wp_attached_file' ) {
											foreach ( (array) $meta as $meta_val ) {
												if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta_val, $matches ) ) {
													$post_data['upload_date'] = $matches[0];
												}
											}
										}
									}
								}

								$upload = $this->_fetch_remote_file( $remote_url, $post_data );

								if ( ! is_array( $upload ) || is_wp_error( $upload ) ) {
									
									return false;
								}
								
								if ( $info = wp_check_filetype( $upload['file'] ) ) {
									$post['post_mime_type'] = $info['type'];
								} else {
									return false;
								}
								
								$post_data['guid'] = $upload['url'];

								// as per wp-admin/includes/upload.php
								$post_id = wp_insert_attachment( $post_data, $upload['file'] );
								
								if($post_id) {

									if ( ! empty( $post_data['meta'] ) ) {
										foreach ( $post_data['meta'] as $meta_key => $meta_val ) {
											if($meta_key != '_wp_attached_file' && !empty($meta_val)) {
												update_post_meta( $post_id, $meta_key, $meta_val );
											}
										}
									}

									wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

									// remap resized image URLs, works by stripping the extension and remapping the URL stub.
									if ( preg_match( '!^image/!', $info['type'] ) ) {
										$parts = pathinfo( $remote_url );
										$name  = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

										$parts_new = pathinfo( $upload['url'] );
										$name_new  = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

										$this->_imported_post_id( $parts['dirname'] . '/' . $name, $parts_new['dirname'] . '/' . $name_new );
									}
									$this->_imported_post_id( $post_data['post_id'], $post_id );

								}

							}
							break;
						default:
							// work out if we have to delay this post insertion
							
							if ( ! empty( $post_data['meta'] ) && is_array( $post_data['meta'] ) ) {

								// replace any elementor post data:

								// fix for double json encoded stuff:
								foreach ( $post_data['meta'] as $meta_key => $meta_val ) {
									if ( is_string( $meta_val ) && strlen( $meta_val ) && $meta_val[0] == '[' ) {
										$test_json = @json_decode( $meta_val, true );
										if ( is_array( $test_json ) ) {
											$post_data['meta'][ $meta_key ] = $test_json;
										}
									}
								}

								array_walk_recursive( $post_data['meta'], array( $this, '_elementor_id_import' ) );

								// replace menu data:
								// work out what we're replacing. a tax, page, term etc..
								if( $post_type == 'nav_menu_item' ){

								}
								if( !empty( $post_data['meta']['_menu_item_menu_item_parent'] ) ) {
									$new_parent_id = $this->_imported_post_id( $post_data['meta']['_menu_item_menu_item_parent'] );
									if(!$new_parent_id) {
										if ( $delayed ) {
											// already delayed, unable to find this meta value, skip inserting it
											$this->error( 'Unable to find replacement. Continue anyway.... content will most likely break..' );
										} else {
											$this->error( 'Unable to find replacement. Delaying.... ' );
											$this->_delay_post_process( $post_type, $original_post_data );
											return false;
										}
									}
									$post_data['meta']['_menu_item_menu_item_parent'] = $new_parent_id;
								}
								if( isset( $post_data['meta'][ '_menu_item_type' ] ) ){
									
									switch($post_data['meta'][ '_menu_item_type' ]){
										case 'post_type':
											if(!empty($post_data['meta']['_menu_item_object_id'])) {
												$new_parent_id = $this->_imported_post_id( $post_data['meta']['_menu_item_object_id'] );
												if(!$new_parent_id) {
													if ( $delayed ) {
														// already delayed, unable to find this meta value, skip inserting it
														$this->error( 'Unable to find replacement. Continue anyway.... content will most likely break..' );
													} else {
														$this->error( 'Unable to find replacement. Delaying.... ' );
														$this->_delay_post_process( $post_type, $original_post_data );
														return false;
													}
												}
												$post_data['meta']['_menu_item_object_id'] = $new_parent_id;
											}
											break;
										case 'taxonomy':
											if(!empty($post_data['meta']['_menu_item_object_id'])) {
												$new_parent_id = $this->_imported_term_id( $post_data['meta']['_menu_item_object_id'] );
												if(!$new_parent_id) {
													if ( $delayed ) {
														// already delayed, unable to find this meta value, skip inserting it
														$this->error( 'Unable to find replacement. Continue anyway.... content will most likely break..' );
													} else {
														$this->error( 'Unable to find replacement. Delaying.... ' );
														$this->_delay_post_process( $post_type, $original_post_data );
														return false;
													}
												}
												$post_data['meta']['_menu_item_object_id'] = $new_parent_id;
											}
											break;
									}
									
								}								

							}

							$post_data['post_content'] = $this->_parse_gallery_shortcode_content($post_data['post_content']);

							// we have to fix up all the visual composer inserted image ids
							$replace_post_id_keys = array(
								'parallax_image',
								'dtbwp_row_image_top',
								'dtbwp_row_image_bottom',
								'image',
								'item', // vc grid
								'post_id',
								'background_image',
								'image_id',
								'image_hover',
								'custom_image',
								'custom_image_hover',
								'product_item_picture',
								'custom_item_picture',
								'icon_image',
								'member_picture',
								'icon_img',
								'image_split',
								'images_item',
								'markericon',
								'fb_bg_image',
								'bb_bg_image',
								'image_before',
								'image_after',
								'hover_image',
								'image_thumbnav',
								'section_background_image',
								'row_background_image',
								'column_background_image'
							);
							foreach ( $replace_post_id_keys as $replace_key ) {
								
								if ( preg_match_all( '# ' . $replace_key . '="(\d+)"#', $post_data['post_content'], $matches ) ) {
									
									foreach ( $matches[0] as $match_id => $string ) {

										if( $replace_key === 'item' || $replace_key === 'post_id' ){
											$new_id = $this->_imported_post_id( $matches[1][ $match_id ] );
										} else {
											$new_id = $this->dahz_framework_replace_image( $matches[1][ $match_id ], $post_type );
										}
										if ( $new_id ) {
											$post_data['post_content'] = str_replace( $string, ' ' . $replace_key . '="' . $new_id . '"', $post_data['post_content'] );
										} else {
											$this->error( 'Unable to find POST replacement for ' . $replace_key . '="' . $matches[1][ $match_id ] . '" in content.' );
											if ( $delayed ) {
												// already delayed, unable to find this meta value, insert it anyway.
											} else {

												$this->error( 'Adding ' . $post_data['post_id'] . ' to delay listing.' );

												$this->_delay_post_process( $post_type, $original_post_data );

												return false;
											}
											
										}
										
									}
									
								}
								
							}
							
							$replace_tax_id_keys = array(
								'taxonomies',
							);
							
							foreach ( $replace_tax_id_keys as $replace_key ) {
								if ( preg_match_all( '# ' . $replace_key . '="(\d+)"#', $post_data['post_content'], $matches ) ) {
									foreach ( $matches[0] as $match_id => $string ) {
										$new_id = $this->_imported_term_id( $matches[1][ $match_id ] );
										if ( $new_id ) {
											$post_data['post_content'] = str_replace( $string, ' ' . $replace_key . '="' . $new_id . '"', $post_data['post_content'] );
										} else {
											$this->error( 'Unable to find TAXONOMY replacement for ' . $replace_key . '="' . $matches[1][ $match_id ] . '" in content.' );
											if ( $delayed ) {
												// already delayed, unable to find this meta value, insert it anyway.
											} else {
												//                                      echo "Delaying post id ".$post_data['post_id']."... \n\n";
												$this->_delay_post_process( $post_type, $original_post_data );

												return false;
											}
										}
									}
								}
							}
							
							$dahz_shortcodes = array(
								'product_pair' => array(
									'ids1',
									'ids2'
								),
								'product_info' => array(
									'ids'
								),
								'product_display' => array(
									'product_ids'
								),
								'product_menu' => array(
									'product_ids'
								),
								'product_showcase' => array(
									'product_ids'
								),
								'blog' => array(
									'post_ids'
								),	
								'portfolio' => array(
									'post_ids'
								),
								'big_post' => array(
									'post_ids'
								),
							);

							foreach ( $dahz_shortcodes as $shortcode => $replace_key ) {
								
								if ( preg_match_all( '#\[' . $shortcode . '[^\]]*\]#', $post_data['post_content'], $matches ) ) {
									
									foreach ( $matches[0] as $match_id => $string ) {
										
										$search_string = $matches[0][$match_id];
										
										foreach( $replace_key as $field ){
											
											if ( preg_match( '#' . $field . '="([^"]+)"#', $string, $ids_matches ) ) {
												
												$replace_ids = array_map( 'trim', explode(',', $ids_matches[1] ) );
												
												$new_replace_ids = array();
												
												foreach( $replace_ids as $replace_id ){
													
													$new_replace_id = $this->_imported_post_id( $replace_id );
							
													if( !$new_replace_id ) {
														
														if ( $delayed ) {
															// already delayed, unable to find this meta value, skip inserting it
															$this->error( 'Unable to find replacement. Continue anyway.... content will most likely break..' );
														
														} else {

															$this->error( 'Unable to find replacement. Delaying.... ' );

															$this->_delay_post_process( $post_type, $original_post_data );

															return false;

														}

													}
													
													$new_replace_ids[] = $new_replace_id;
													
												}
												$sub_content = str_replace( $ids_matches[0], ' ' . $field . '="' . implode( ',', $new_replace_ids ) . '"', $search_string );

												$post_data['post_content'] = str_replace( $search_string, $sub_content, $post_data['post_content'] );
												
												$search_string = $sub_content;

											}
										}
										
									}
								}
							}
							
							
							if( !$this->dahz_framework_update_delayed_post_meta( $post_data, $post_type, $original_post_data, $delayed ) ){
								return false;
							}

							$post_id = wp_insert_post( $post_data, true );
							
							if ( ! is_wp_error( $post_id ) ) {
								$this->_imported_post_id( $post_data['post_id'], $post_id );
								// add/update post meta
								if ( ! empty( $post_data['meta'] ) ) {
									foreach ( $post_data['meta'] as $meta_key => $meta_val ) {

										// if the post has a featured image, take note of this in case of remap
										if ( '_thumbnail_id' == $meta_key ) {
											/// find this inserted id and use that instead.
											$inserted_id = $this->dahz_framework_replace_image( intval( $meta_val ), $post_type );
											if ( $inserted_id ) {
												$meta_val = $inserted_id;
											}
										}
										
										
										
										update_post_meta( $post_id, $meta_key, $meta_val );
										
										$this->dahz_framework_update_post_meta( $post_id, $meta_key, $meta_val );

									}
								}
								if ( ! empty( $post_data['terms'] ) ) {
									do_action( 'dahz_framework_process_post_data_terms', $post_data['terms'], $post_type );
									$terms_to_set = array();
									foreach ( $post_data['terms'] as $term_slug => $terms ) {
										foreach ( $terms as $term ) {
											/*"term_id": 21,
											"name": "Tea",
											"slug": "tea",
											"term_group": 0,
											"term_taxonomy_id": 21,
											"taxonomy": "category",
											"description": "",
											"parent": 0,
											"count": 1,
											"filter": "raw"*/
											$taxonomy = $term['taxonomy'];
											if ( taxonomy_exists( $taxonomy ) ) {
												$term_exists = term_exists( $term['slug'], $taxonomy );
												$term_id     = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
												if ( ! $term_id ) {
													if ( ! empty( $term['parent'] ) ) {
														// see if we have imported this yet?
														$term['parent'] = $this->_imported_term_id( $term['parent'] );
													}
													$t = wp_insert_term( $term['name'], $taxonomy, $term );
													
													if ( ! is_wp_error( $t ) ) {
														
														if( isset( $this->dahz_settings['term_meta']["dahz_framework_taxonomy_{$taxonomy}"][$term['term_id']] ) ){
															
															$current_term_meta = get_option( "dahz_framework_taxonomy_{$taxonomy}" );
															
															$current_term_meta = !is_array( $current_term_meta ) ? array() : $current_term_meta;
															
															if( isset( $current_term_meta[$term['term_id']] ) ){
																unset( $current_term_meta[$term['term_id']] );
															}
															
															$current_term_meta[$t['term_id']] = $this->dahz_settings['term_meta']["dahz_framework_taxonomy_{$taxonomy}"][$term['term_id']];
															
															$this->dahz_framework_update_term_meta_image( $current_term_meta[$t['term_id']], $taxonomy );
																													
															update_option( "dahz_framework_taxonomy_{$taxonomy}", $current_term_meta, 'no' );
														
														}
														if( $post_type === 'product' ){
																														
															if( isset( $this->dahz_settings['term_swatches'][$taxonomy][$term['term_id']] ) ){
															
																$current_term_meta = get_option( "dahz_framework_term_swatches" );
																
																$current_term_meta = !is_array( $current_term_meta ) ? array() : $current_term_meta;
																if( !isset( $current_term_meta[$taxonomy] ) || ( isset( $current_term_meta[$taxonomy] ) && !is_array( $current_term_meta[$taxonomy] ) ) ){
																	$current_term_meta[$taxonomy] = array();
																}
																if( isset( $current_term_meta[$taxonomy][$term['term_id']] ) ){
																	unset( $current_term_meta[$taxonomy][$term['term_id']] );
																}
																
																$current_term_meta[$taxonomy][$t['term_id']] = $this->dahz_settings['term_swatches'][$taxonomy][$term['term_id']];
																
																$this->dahz_framework_update_term_meta_image( $current_term_meta[$taxonomy][$t['term_id']], $taxonomy );
																
																update_option( "dahz_framework_term_swatches", $current_term_meta, 'no' );
															
															}
															
														}
														
														$term_id = $t['term_id'];
													
													} else {
														// todo - error
														continue;
													}
												}
												$this->_imported_term_id( $term['term_id'], $term_id );
												// add the term meta.
												if($term_id && !empty($term['meta']) && is_array($term['meta'])){
													foreach($term['meta'] as $meta_key => $meta_val){
														// we have to replace certain meta_key/meta_val
														// e.g. thumbnail id from woocommerce product categories.
														switch($meta_key){
															case 'thumbnail_id':
																if( $new_meta_val = $this->dahz_framework_replace_image( $meta_val, $taxonomy ) ){
																	// use this new id.
																	$meta_val = $new_meta_val;
																}
																break;
														}
														update_term_meta( $term_id, $meta_key, $meta_val );
													}
												}
												$terms_to_set[ $taxonomy ][] = intval( $term_id );
											}
										}
									}
									foreach ( $terms_to_set as $tax => $ids ) {
										wp_set_post_terms( $post_id, $ids, $tax );
									}
								}

								// procses visual composer just to be sure.
								if ( strpos( $post_data['post_content'], '[vc_' ) !== false ) {
									$this->vc_post( $post_id );
								}
								if ( !empty($post_data['meta']['_elementor_data']) || !!empty($post_data['meta']['_elementor_css']) ) {
									$this->elementor_post( $post_id );
								}
							}

							break;
					}

					return true;
				}
				
				public function dahz_framework_update_term_meta_image( &$current_term_meta, $taxonomy ){
					$replace_key = array(
						'brand_image_upload',
						'logo_upload',
						'image_upload',
						'page_title_img',
						'image'
					);
					foreach( $replace_key as $key ){
						
						if ( isset( $current_term_meta[$key] ) ) {
							/// find this inserted id and use that instead.
							$inserted_id = $this->dahz_framework_replace_image( intval( $current_term_meta[$key] ), $taxonomy );
							if ( $inserted_id ) {
								$current_term_meta[$key] = $inserted_id;
							}
						}
						
					}
					
				}
				
				public function dahz_framework_update_post_meta( $post_id, $meta_key, $meta_val ){
					
					switch( $meta_key ){
						
						case "dahz_meta_post":
							$this->dahz_framework_update_post_meta_post( $post_id, $meta_key, $meta_val );
							break;
						case "dahz_meta_page":
							$this->dahz_framework_update_post_meta_page( $post_id, $meta_key, $meta_val );
							break;
						case "dahz_meta_product":
							$this->dahz_framework_update_post_meta_product( $post_id, $meta_key, $meta_val );
							break;
						case "portfolio":
							$this->dahz_framework_update_post_meta_portfolio( $post_id, $meta_key, $meta_val );
							break;
						case "mega_menu":
							$this->dahz_framework_update_post_meta_nav( $post_id, $meta_key, $meta_val );
							break;
						case "_product_image_gallery":
							if( !empty( $meta_val ) ){

								$gallery = explode( ',', $meta_val );
								
								$galleries = array();
								
								foreach( $gallery as $image ){
									
									$inserted_id = $this->dahz_framework_replace_image( intval( $image ), 'product' );
									
									if( $inserted_id ){
										$galleries[] = $inserted_id;
									}
									
								}
								
								update_post_meta( $post_id, $meta_key, implode( ',', $galleries ) );
								
							}
							break;
						
					}
					
				}
				
				public function dahz_framework_update_post_meta_post( $post_id, $meta_key, $meta_val ){
					
					if( !empty( $meta_val['single_gallery'] ) ){

						$gallery = explode( ',', $meta_val['single_gallery'] );
						$galleries = array();
						foreach( $gallery as $image ){
							
							$inserted_id = $this->dahz_framework_replace_image( intval( $image ), 'post' );
							
							if( $inserted_id ){
								$galleries[] = $inserted_id;
							}
							
						}
						
						$meta_val['single_gallery'] = implode( ',', $galleries );
						
					}
					
					if( !empty( $meta_val['featured_image_upload'] ) ){
						
						$inserted_id = $this->dahz_framework_replace_image( intval( $meta_val['featured_image_upload'] ), 'post' );
							
						if( $inserted_id ){
							$meta_val['featured_image_upload'] = $inserted_id;
						}
						
					}
					
					update_post_meta( $post_id, $meta_key, $meta_val );
					
				}
				
				public function dahz_framework_update_post_meta_page( $post_id, $meta_key, $meta_val ){

					if( !empty( $meta_val['page_title_img'] ) ){
						
						$inserted_id = $this->dahz_framework_replace_image( intval( $meta_val['page_title_img'] ), 'page' );
							
						if( $inserted_id ){
							$meta_val['page_title_img'] = $inserted_id;
						}
						
					}
					
					update_post_meta( $post_id, $meta_key, $meta_val );
				
				}
				
				public function dahz_framework_update_post_meta_product( $post_id, $meta_key, $meta_val ){
					
					if( !empty( $meta_val['dv_swatches_value'] ) && is_array( $meta_val['dv_swatches_value'] ) ){
						
						foreach( $meta_val['dv_swatches_value'] as $taxonomy_name => $taxonomy ){
							
							if( !empty( $taxonomy['terms'] ) && is_array( $taxonomy['terms'] ) ){
								
								foreach( $taxonomy['terms'] as $term_name => $term ){
									
									if( !empty( $term['image_preview_click'] ) ){
										
										$inserted_id = $this->dahz_framework_replace_image( intval( $term['image_preview_click'] ), 'product' );
										
										if( $inserted_id ){
											$meta_val['dv_swatches_value'][$taxonomy_name]['terms'][$term_name]['image_preview_click'] = $inserted_id;
										}
										
									}
									if( !empty( $term['image_preview_hover'] ) ){
										
										$inserted_id = $this->dahz_framework_replace_image( intval( $term['image_preview_hover'] ), 'product' );
										
										if( $inserted_id ){
											$meta_val['dv_swatches_value'][$taxonomy_name]['terms'][$term_name]['image_preview_hover'] = $inserted_id;
										}
										
									}
									if( !empty( $term['image'] ) ){
										
										$inserted_id = $this->dahz_framework_replace_image( intval( $term['image'] ), 'product' );
										
										if( $inserted_id ){
											$meta_val['dv_swatches_value'][$taxonomy_name]['terms'][$term_name]['image'] = $inserted_id;
										}
										
									}
									
								}
								
							}
							
						}
												
					}
					
					if( !empty( $meta_val['dv_image_variations_gallery'] ) && is_array( $meta_val['dv_image_variations_gallery'] ) ){
						
						foreach( $meta_val['dv_image_variations_gallery'] as $variation_id => $variation_gallery ){
							
							if( !empty( $variation_gallery ) ){

								$gallery = explode( ',', $variation_gallery );
								
								$galleries = array();
								
								foreach( $gallery as $image ){
									
									$inserted_id = $this->dahz_framework_replace_image( intval( $image ), 'product' );
									
									if( $inserted_id ){
										$galleries[] = $inserted_id;
									}
									
								}
								
								$meta_val['dv_image_variations_gallery'][$variation_id] = implode( ',', $galleries );
								
							}
							
						}
												
					}
										
					update_post_meta( $post_id, $meta_key, $meta_val );
					//overide_main_menu, before_header, after_header, content_block, before_footer, after_footer, size_guide, dv_swatches_value, dv_image_variations_gallery
				}
				
				public function dahz_framework_update_post_meta_portfolio( $post_id, $meta_key, $meta_val ){
					
					if( isset( $meta_val['page_title_img'] ) ){
						
						$inserted_id = $this->dahz_framework_replace_image( intval( $meta_val['page_title_img'] ), 'portfolio' );
							
						if( $inserted_id ){
							$meta_val['page_title_img'] = $inserted_id;
						}
						
					}
					
					if( isset( $meta_val['portfolio_featured_image_upload'] ) ){
						
						$inserted_id = $this->dahz_framework_replace_image( intval( $meta_val['portfolio_featured_image_upload'] ), 'portfolio' );
							
						if( $inserted_id ){
							$meta_val['portfolio_featured_image_upload'] = $inserted_id;
						}
						
					}
					
					update_post_meta( $post_id, $meta_key, $meta_val );
					//page_title_img, portfolio_featured_image_upload, portfolio_overide_main_menu, portfolio_before_header, portfolio_after_header, page_title_content_block, portfolio_content_block, portfolio_before_footer, portfolio_after_footer
				}
				
				public function dahz_framework_update_post_meta_nav( $post_id, $meta_key, $meta_val ){
					
					if( isset( $meta_val['submenu_background_image'] ) ){
						
						$inserted_id = $this->dahz_framework_replace_image( intval( $meta_val['submenu_background_image'] ), 'nav' );
							
						if( $inserted_id ){
							$meta_val['submenu_background_image'] = $inserted_id;
						}
						
					}
					
					if( isset( $meta_val['image_replace_link'] ) ){
						
						$inserted_id = $this->dahz_framework_replace_image( intval( $meta_val['image_replace_link'] ), 'nav' );
							
						if( $inserted_id ){
							$meta_val['image_replace_link'] = $inserted_id;
						}
						
					}
										
					update_post_meta( $post_id, $meta_key, $meta_val );
					/*
					submenu_background_image
					image_replace_link
					*/
				}
				
				public function dahz_framework_update_delayed_post_meta( &$post_data, $post_type, $original_post_data, $delayed ){
					
					$result = true;
										
					if( !empty( $post_data['meta']['dahz_meta_post'] ) ) {
						
						$result = $this->dahz_framework_update_delayed_post_meta_post( $post_data, $post_type, $original_post_data, $delayed );
						
					} else if( !empty( $post_data['meta']['dahz_meta_page'] ) ){
						
						$result = $this->dahz_framework_update_delayed_post_meta_page( $post_data, $post_type, $original_post_data, $delayed );
						
					} else if( !empty( $post_data['meta']['dahz_meta_product'] ) ){
						
						$result = $this->dahz_framework_update_delayed_post_meta_product( $post_data, $post_type, $original_post_data, $delayed );
						
					} else if( !empty( $post_data['meta']['portfolio'] ) ){
						
						$result = $this->dahz_framework_update_delayed_post_meta_portfolio( $post_data, $post_type, $original_post_data, $delayed );
						
					} else if( !empty( $post_data['meta']['mega_menu'] ) ){
						
						$result = $this->dahz_framework_update_delayed_post_meta_nav( $post_data, $post_type, $original_post_data, $delayed );
						
					}
					
					return $result;
					
				}
				
				public function dahz_framework_update_delayed_post_meta_post( &$post_data, $post_type, $original_post_data, $delayed ){
					
										
					return true;
										
					//single_gallery, featured_image_upload, overide_main_menu, after_header, before_header, single_content_block,before_footer, after_footer
				}
				
				public function dahz_framework_update_delayed_post_meta_page( &$post_data, $post_type, $original_post_data, $delayed ){
					
					return true;
					//page_title_img, faq_menu_tab, overide_main_menu, before_header, after_header, page_title_content_block, page_content_block, before_footer, after_footer
				}
				
				public function dahz_framework_update_delayed_post_meta_product( &$post_data, $post_type, $original_post_data, $delayed ){
					$meta_val = $post_data['meta']['dahz_meta_product'];

					if( !empty( $meta_val['dv_image_variations_gallery'] ) && is_array( $meta_val['dv_image_variations_gallery'] ) ){

						
						foreach( $meta_val['dv_image_variations_gallery'] as $variation_id => $gallery ){
							
							$new_parent_id = $this->_imported_post_id( $variation_id );
							
							if( !$new_parent_id ) {
								
								if ( $delayed ) {
									// already delayed, unable to find this meta value, skip inserting it
									$this->error( 'Unable to find replacement. Continue anyway.... content will most likely break..' );
								
								} else {

									$this->error( 'Unable to find replacement. Delaying.... ' );

									$this->_delay_post_process( $post_type, $original_post_data );

									return false;

								}

							} else {
								
								$gallery = $post_data['meta']['dahz_meta_product']['dv_image_variations_gallery'][$variation_id];
								
								unset( $post_data['meta']['dahz_meta_product']['dv_image_variations_gallery'][$variation_id] );
								
								$post_data['meta']['dahz_meta_product']['dv_image_variations_gallery'][$new_parent_id] = $gallery;
								
							}
							
						}
												
					}
										
					return true;
					//overide_main_menu, before_header, after_header, content_block, before_footer, after_footer, size_guide, dv_swatches_value, dv_image_variations_gallery
				}
				
				public function dahz_framework_update_delayed_post_meta_portfolio( &$post_data, $post_type, $original_post_data, $delayed ){
										
					return true;
					//page_title_img, portfolio_featured_image_upload, portfolio_overide_main_menu, portfolio_before_header, portfolio_after_header, page_title_content_block, portfolio_content_block, portfolio_before_footer, portfolio_after_footer
				}
				
				public function dahz_framework_update_delayed_post_meta_nav( &$post_data, $post_type, $original_post_data, $delayed ){
					
					$meta = $post_data['meta']['mega_menu'];
					$meta_keys = array(
						'carousel_content',
					);
					foreach( $meta_keys as $key ){

						if( !empty( $meta[$key] ) ){
							
							$contents = explode( ',', $meta[$key] );
							
							$new_contents = array();
							
							foreach( $contents as $content ){
								
								$new_parent_id = $this->_imported_post_id( $content );
							
								if( !$new_parent_id ) {
									
									if ( $delayed ) {
										// already delayed, unable to find this meta value, skip inserting it
										$this->error( 'Unable to find replacement. Continue anyway.... content will most likely break..' );
									
									} else {

										$this->error( 'Unable to find replacement. Delaying.... ' );

										$this->_delay_post_process( $post_type, $original_post_data );

										return false;

									}

								}
								
								$new_contents[] = $new_parent_id;
								
							}
							
							$post_data['meta']['mega_menu'][$key] = implode( ',', $new_contents );

						}
						
					}
					
					return true;
					//page_title_img, portfolio_featured_image_upload, portfolio_overide_main_menu, portfolio_before_header, portfolio_after_header, page_title_content_block, portfolio_content_block, portfolio_before_footer, portfolio_after_footer
				}
				/* Note: area lain 
					widget : content block
					taxonomy : content block
					customizer : content block
					terms : asdf
					get_option
				*/

			}

			Dahz_Framework_Envato_Theme_Setup_Wizard::get_instance();
		}else{
			// log error?
		}
	}
endif;