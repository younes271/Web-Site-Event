<?php

if( !class_exists( 'Dahz_Framework_Header_Before_And_After' ) ){

	Class Dahz_Framework_Header_Before_And_After {

		public function __construct(){

			add_action( 'dahz_framework_module_header-before-and-after_init', array( $this, 'dahz_framework_header_before_and_after_init' ) );

			add_action( 'dahz_framework_before_header', array( $this, 'dahz_framework_render_before_header' ) );

			add_action( 'dahz_framework_before_content', array( $this, 'dahz_framework_render_after_header' ), 5 );

		}

		public function dahz_framework_header_before_and_after_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-before-and-after-customizer.php' );
			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Before_And_After_Customizer',
				array(
					'id'	=> 'before_and_after_header',
					'title'	=> array( 'title' => esc_html__( 'Before and After Header', 'kitring' ), 'priority' => 17 ),
					'panel'	=> 'header'
				),
				array()
			);

		}

		public function dahz_framework_render_before_header(){
			
			$content_block = dahz_framework_get_option( 'before_and_after_header_before_header' );
			
			$meta_content_block = 'inherit';
			
			if( is_singular( 'post' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'before_header', 'inherit' );
				
			} else if( is_singular( 'page' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'before_header', 'inherit' );
				
			} else if( is_singular( 'portfolio' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'before_header', 'inherit' );
				
			} else if( is_singular( 'product' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'before_header', 'inherit' );
				
			}
						
			$content_block = $meta_content_block !== 'inherit' ? !empty( $meta_content_block ) ? $meta_content_block : '' : $content_block;

			echo dahz_framework_do_content_block( apply_filters( 'dahz_framework_override_before_header', $content_block ) );

		}

		public function dahz_framework_render_after_header(){
			
			$content_block = dahz_framework_get_option( 'before_and_after_header_after_header' );
			
			$meta_content_block = 'inherit';
			
			if( is_singular( 'post' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'after_header', 'inherit' );
				
			} else if( is_singular( 'page' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'after_header', 'inherit' );
				
			} else if( is_singular( 'portfolio' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'after_header', 'inherit' );
				
			} else if( is_singular( 'product' ) ){
				
				$meta_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'after_header', 'inherit' );
				
			}
			
			$content_block = $meta_content_block !== 'inherit' ? !empty( $meta_content_block ) ? $meta_content_block : '' : $content_block;

			echo dahz_framework_do_content_block( apply_filters( 'dahz_framework_override_after_header', $content_block ) );

		}

	}

	new Dahz_Framework_Header_Before_And_After();

}
