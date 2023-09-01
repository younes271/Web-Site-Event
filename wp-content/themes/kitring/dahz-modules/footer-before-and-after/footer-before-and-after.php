<?php


if( !class_exists( 'Dahz_Framework_Footer_Before_And_After' ) ){


	Class Dahz_Framework_Footer_Before_And_After {

		public function __construct(){
			
			add_action( 'dahz_framework_module_footer-before-and-after_init', array( $this, 'dahz_framework_footer_before_and_after_init' ) );
			
			add_action('dahz_framework_before_footer', array( $this, 'dahz_framework_render_before_footer' ) );

			add_action('dahz_framework_after_footer', array( $this, 'dahz_framework_render_after_footer' ) );

		}
		
		public function dahz_framework_footer_before_and_after_init( $path ){
			
			if ( is_customize_preview() ) dahz_framework_include( $path . '/footer-before-and-after-customizer.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Footer_Before_And_After_Customizer',
				array(
					'id'	=> 'before_and_after_footer',
					'title' => esc_html__( 'Footer Before & After', 'kitring' ),
					'panel'	=> 'footer'
				),
				array()
			);
			
		}

		public function dahz_framework_render_before_footer(){
			
			$content_block = dahz_framework_get_option( 'before_and_after_footer_before_footer' );
			
			$meta_content_block = 'inherit';
			
			if( is_singular( 'post' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'before_footer', 'inherit' );
				
			} else if( is_singular( 'page' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'before_footer', 'inherit' );
				
			} else if( is_singular( 'portfolio' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'before_footer', 'inherit' );
				
			} else if( is_singular( 'product' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'before_footer', 'inherit' );
				
			}
			
			$content_block = $meta_content_block !== 'inherit' ? !empty( $meta_content_block ) ? $meta_content_block : '' : $content_block;
			
			echo dahz_framework_do_content_block( apply_filters( 'dahz_framework_override_before_footer', $content_block ) );
		
		}

		public function dahz_framework_render_after_footer(){
			
			$content_block = dahz_framework_get_option( 'before_and_after_footer_after_footer' );
			
			$meta_content_block = 'inherit';
			
			if( is_singular( 'post' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'after_footer', 'inherit' );
				
			} else if( is_singular( 'page' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'after_footer', 'inherit' );
				
			} else if( is_singular( 'portfolio' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'after_footer', 'inherit' );
				
			} else if( is_singular( 'product' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'after_footer', 'inherit' );
				
			}
			
			$content_block = $meta_content_block !== 'inherit' ? !empty( $meta_content_block ) ? $meta_content_block : '' : $content_block;
			
			echo dahz_framework_do_content_block( apply_filters( 'dahz_framework_override_after_footer', $content_block ) );
		
		}

	}

	new Dahz_Framework_Footer_Before_And_After();

}
