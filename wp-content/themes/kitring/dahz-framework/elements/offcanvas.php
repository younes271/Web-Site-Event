<?php
if( !class_exists( 'Dahz_Framework_Element_Offcanvas' ) ){
	
	class Dahz_Framework_Element_Offcanvas extends Dahz_Framework_Element {
		
		public function dahz_framework_get_selector(){
			return 'uk-offcanvas';
		}
		
		public function dahz_framework_get_prefix(){
			return 'offcanvas';
		}
		
		public function dahz_framework_get_prefix_mod(){
			return 'offcanvas';
		}
		
		public function dahz_framework_get_configs() {
			return array(
				'global',
				'style',
			);
		}
		
		public function dahz_framework_get_config_types() {
			
			return array(
				'style'	=> array(
					'bar'	=> array(
						'background',
						'padding_horizontal',
						'm_padding_horizontal',
						'padding_top',
						'padding_bottom',
						'm_padding_top',
						'm_padding_bottom',
						'width',
						'm_width',
					),
					'close'	=> array(
						'padding',
						'position',
					),
					'overlay'	=> array(
						'overlay_background',
					),
				),
			);
		}
		
		public function dahz_framework_get_config_settings() {
			
			return array(
				'style'	=> array(
					'background' 	=> array(
						'property'	=> 'background-color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'overlay_background'	=> array(
						'property'	=> 'overlay-background',
						'default'	=> 'rgba(31, 31, 31, 0.9)',
						'type'		=> 'color',
					),
					'padding_horizontal'		=> array(
						'property'		=> 'padding-horizontal',
						'default'		=> '40px',
						'type'			=> 'dimension',
					),
					'm_padding_horizontal'		=> array(
						'property'		=> 'm-padding-horizontal',
						'default'		=> '40px',
						'type'			=> 'dimension',
					),
					'padding_top'		=> array(
						'property'		=> 'padding-top',
						'default'		=> '40px',
						'type'			=> 'dimension',
					),
					'm_padding_top'		=> array(
						'property'		=> 'm-padding-top',
						'default'		=> '40px',
						'type'			=> 'dimension',
					),
					'padding_bottom'		=> array(
						'property'		=> 'padding-bottom',
						'default'		=> '40px',
						'type'			=> 'dimension',
					),
					'm_padding_bottom'		=> array(
						'property'		=> 'm-padding-bottom',
						'default'		=> '40px',
						'type'			=> 'dimension',
					),
					'width'		=> array(
						'property'		=> 'width',
						'default'		=> '350px',
						'type'			=> 'dimension',
					),
					'm_width'		=> array(
						'property'		=> 'm-width',
						'default'		=> '350px',
						'type'			=> 'dimension',
					),
					'padding'		=> array(
						'property'		=> 'padding',
						'default'		=> '5px',
						'type'			=> 'dimension',
					),
					'position'		=> array(
						'property'		=> 'position',
						'default'		=> '20px',
						'type'			=> 'dimension',
					),
				),
				'global'	=> array(
					'z_index'		=> array(
						'property'		=> 'z-index',
						'default'		=> '1000',
						'type'			=> 'text',
					),
				),
			);
		}
		
	}
	
}