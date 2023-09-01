<?php
if( !class_exists( 'Dahz_Framework_Admin' ) ){
	
	Class Dahz_Framework_Admin {
		
		function __construct(){
			
			global $dahz_framework;
			
			add_action( 'admin_init', array( $this, 'dahz_framework_theme_add_editor_styles' ) );
										
			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/dahz-framework-admin-functions.php' );
									
			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/envato_setup/envato_setup_init.php' );
			
			dahz_framework_include( DAHZ_FRAMEWORK_PATH . 'admin/envato_setup/envato_setup.php' );

		}
		
		function dahz_framework_theme_add_editor_styles() {
			
			add_editor_style( 'custom-editor-style.css' );
			
		}
						
		/**
		reference : Customizer Export/Import plugin
		* dahz_framework_import_images
		* download and import customizer image
		* @param -
		* @return -
		*/
		
		public function dahz_framework_import_images( $customizer ){
			
			foreach ( $customizer as $key => $val ) {
			
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
		reference : Customizer Export/Import plugin
		* dahz_framework_sideload_image
		* side load image customizer method
		* @param -
		* @return -
		*/
		private function dahz_framework_sideload_image( $file ){
			
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
		reference : Customizer Export/Import plugin
		* dahz_framework_is_image_url
		* check if value customizer is image
		* @param -
		* @return -
		*/
		private function dahz_framework_is_image_url( $string = '' ){
			
			if ( is_string( $string ) ) {
				
				if ( preg_match( '/\.(jpg|jpeg|png|gif)/i', $string ) ) {
					return true;
				}
			}
			
			return false;
		}
		
		
	}
	
	new Dahz_Framework_Admin();
	
}