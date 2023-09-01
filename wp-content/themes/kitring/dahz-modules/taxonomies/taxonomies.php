<?php

if( !class_exists('Dahz_Taxonomies') ){

	Class Dahz_Taxonomies {

		function __construct(){

			add_action( 'dahz_framework_taxonomy_metabox_portfolio_categories', array( $this,'dahz_framework_taxonomy_metabox_image_thumbnail' ), 1 );
			
			add_action( 'dahz_framework_taxonomy_metabox_category', array( $this,'dahz_framework_taxonomy_metabox_image_thumbnail' ), 1 );
			
			add_action( 'dahz_framework_taxonomy_metabox_brand', array( $this,'dahz_framework_brand_categories_taxonomy_metabox' ) );
		
		}
		
		public function dahz_framework_brand_categories_taxonomy_metabox( $dahz_meta ){
			
			$dahz_meta->dahz_framework_metabox_add_field(
				array(
					'id'			=> 'categories',
					'type'			=> 'textfield',
					'title'			=> esc_html__( 'Type Product Categories Slug', 'kitring' ),
					'description'	=> esc_html__('Type product categories slug with "," separator', 'kitring' )
				)
			);
			
		}
		
		public function dahz_framework_taxonomy_metabox_image_thumbnail( $dahz_meta ){
			
			$dahz_meta->dahz_framework_metabox_add_field(
				array(
					'id'			=> 'image_upload',
					'type'			=> 'image_uploader',
					'title'			=> esc_html__( 'Image Category Display', 'kitring' ),
					'description'	=> esc_html__('Select image pattern for Thumbnail', 'kitring' ),
				)
			);
			
		}
		
	}

	new Dahz_Taxonomies();

}
