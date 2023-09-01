<?php
if( !class_exists( 'Dahz_Framework_Presets_Customizers' ) ){
	

	Class Dahz_Framework_Presets_Customizers extends Dahz_Framework_Customizer{
		
		public function __construct(){
			
			$this->dahz_framework_presets_archive_post();
			$this->dahz_framework_presets_single_post();
			$this->dahz_framework_presets_archive_portfolio();
			$this->dahz_framework_presets_single_portfolio();
			$this->dahz_framework_presets_page();
			$this->dahz_framework_presets_shop();
			$this->dahz_framework_presets_single_product();
			
		}
		
		public function dahz_framework_presets_archive_post(){
			
			$field = $this->dahz_framework_presets_fields( '', 'archive', 1 );

			$this->dahz_framework_add_field_customizer( 'archive', $field );
			
		}
		
		public function dahz_framework_presets_single_post(){
			
			$field = $this->dahz_framework_presets_fields( '', 'single_post', 1 );

			$this->dahz_framework_add_field_customizer( 'single_post', $field );
			
		}
		
		public function dahz_framework_presets_archive_portfolio(){
			
			$field = $this->dahz_framework_presets_fields( '', 'portfolio_archive', 1 );

			$this->dahz_framework_add_field_customizer( 'portfolio_archive', $field );
			
		}
		
		public function dahz_framework_presets_single_portfolio(){
			
			$field = $this->dahz_framework_presets_fields( '', 'portfolio_single', 1 );

			$this->dahz_framework_add_field_customizer( 'portfolio_single', $field );
			
		}
		
		public function dahz_framework_presets_page(){
			
			$field = $this->dahz_framework_presets_fields( '', 'page', 1 );

			$this->dahz_framework_add_field_customizer( 'page', $field );
			
		}
		
		public function dahz_framework_presets_shop(){
			
			$field = $this->dahz_framework_presets_fields( '', 'woo_shop', 1 );

			$this->dahz_framework_add_field_customizer( 'woo_shop', $field );
			
			$field_cat = $this->dahz_framework_presets_fields( 'cat', 'woo_shop', 10 );

			$this->dahz_framework_add_field_customizer( 'woo_shop', $field_cat );
			
			$field_brand = $this->dahz_framework_presets_fields( 'brand', 'woo_shop', 12 );

			$this->dahz_framework_add_field_customizer( 'woo_shop', $field_brand );
			
		}
		public function dahz_framework_presets_single_product(){
			
			$field = $this->dahz_framework_presets_fields( '', 'woo_single_product', 1 );

			$this->dahz_framework_add_field_customizer( 'woo_single_product', $field );
			
		}
		
		private function dahz_framework_presets_fields( $prefix = '', $section = '', $start_priority = 0 ){
			
			$field = array();
			
			$field[] = array(
				'type'            => 'select',
				'settings'        => !empty( $prefix ) ? "{$prefix}_header_saved_preset" : 'header_saved_preset',
				'label'           => esc_html__( 'Header Style Preset Saved', 'kitring' ),
				'description'     => esc_html__( 'Select your header preset & skin, it based from header builder you have been created before', 'kitring' ),
				'priority'        => $start_priority,
				'choices'         => Dahz_Framework_Customizer_Core::$header_presets,
			);
						
			$this->dahz_framework_add_field_customizer( $section, $field );
		}
		
	}
	
	new Dahz_Framework_Presets_Customizers();
	
}