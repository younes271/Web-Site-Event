<?php
if( !class_exists( 'Dahz_Framework_Presets' ) ){


	Class Dahz_Framework_Presets{
		
		public $is_disable_footer = false;
		
		public $footer_content_block = '';

		public function __construct(){

			add_action( 'dahz_framework_module_presets_init', array( $this, 'dahz_framework_presets_init' ) );

		}
		
		public function dahz_framework_presets_init( $path ){
			
			if ( is_admin() ) dahz_framework_include( $path . '/presets-metaboxes.php' );
			
			add_action( 'dahz_framework_before_default_styles', array( $this, 'dahz_framework_get_header_preset' ), 5 );
			
			add_action( 'dahz_framework_before_default_styles', array( $this, 'dahz_framework_get_footer_preset' ), 5 );
						
		}
		
		public function dahz_framework_get_header_preset() {
			
			$preset_name		 = '';
			
			if( is_singular( 'page' ) ){
				
				$preset_name = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'header_preset_saved', '' );

			} else if( is_singular( 'post' ) ){
				
				$preset_name = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'header_preset_saved', '' );
				
			}  else if( class_exists( 'Woocommerce' ) && is_product() ){
				
				$preset_name = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'header_preset_saved', '' );
				
			} else if( post_type_exists( 'portfolio' ) && is_singular( 'portfolio' ) ){
				
				$preset_name = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'header_preset_saved', '' );

			} else if( is_home() && !is_front_page() ){
				
				$page_id 		= get_option( 'page_for_posts' );
				
				$preset_name = dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'header_preset_saved', '' );

			} 
			
			if( empty( $preset_name ) ) return;

			dahz_framework_overrides_header_preset( 'saved', $preset_name, true );

		}

		public function dahz_framework_get_footer_preset(){
			
			$footers	 = array(
				'dahz_meta_page'		=> is_singular( 'page' ),
				'dahz_meta_post'		=> is_singular( 'post' ),
				'dahz_meta_portfolio'	=> post_type_exists( 'portfolio' ) && is_singular( 'portfolio' ),
				'dahz_meta_product' 	=> class_exists( 'Woocommerce' ) && is_product()
			);

			foreach( $footers as $meta_key => $condition ){
				
				if( $condition ){
					
					$preset_name = dahz_framework_get_meta( get_the_ID(), $meta_key, 'footer_preset_saved', '' );

				}
				
			}
			if( is_home() && !is_front_page() ){
				
				$page_id = get_option( 'page_for_posts' );
				
				$preset_name = dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'footer_preset_saved', '' );
				
			}
						
			if( empty( $preset_name ) ) return;

			if( $preset_name === 'disable' ){

				dahz_framework_override_static_option( array( 'disabled_footer' => true ) );

				
			} else {
				
				dahz_framework_overrides_footer_preset( 'saved', $preset_name, true );
				
			}
			
		}
		
		
	}

	new Dahz_Framework_Presets();

}
