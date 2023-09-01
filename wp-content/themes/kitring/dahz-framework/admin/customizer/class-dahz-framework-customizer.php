<?php
if( !class_exists( 'Dahz_Framework_Customizer' ) ){
	
	abstract Class Dahz_Framework_Customizer{
		
		/**
		 * add_config 
		 * extend kirki plugin for customizer config
		 * @param $config_id, $args
		 * @return void 
		 */
		protected function dahz_framework_customizer_kirki_add_config( $config_id, $args = array() ) {
		    if ( class_exists( 'Kirki' ) ) {
		      Kirki::add_config( $config_id, $args );
		      return;
		    }
		}

		/**
		 * add_panel
		 * extend kirki plugin for customizer panel
		 * @param $id, $args
		 * @return void 
		 */
		protected function dahz_framework_customizer_kirki_add_panel( $id = '', $args = array() ) {
			if ( class_exists( 'Kirki' ) ) {
				Kirki::add_panel( $id, $args );
			}
		}

		/**
		 * add_section
		 * extend kirki plugin for customizer section
		 * @param $id, $args
		 * @return void 
		 */
		private function dahz_framework_customizer_kirki_add_section( $id, $args ) {
			if ( class_exists( 'Kirki' ) ) {
				Kirki::add_section( $id, $args );
			}
		}

		/**
		 * add_field
		 * extend kirki plugin for customizer field
		 * @param $config_id, $args
		 * @return void 
		 */
		public function dahz_framework_customizer_kirki_add_field( $config_id, $args ) {
			// if Kirki exists, use it.
			if ( class_exists( 'Kirki' ) ) {
				Kirki::add_field( $config_id, $args );
				return;
			}
		}
		
		/**
		 * dahz_framework_commerce_add_section_customize
		 * add section customizer
		 * @param $id, $title, $field, $panel
		 * @return void 
		 */
		protected function dahz_framework_add_section_customizer( $id, $title = "", $field = array(), $panel = null, $active_callback = '', $option = 'option' ){
			
			$current_panel = '';
			
			if( is_array( $panel ) ){
			
				$this->dahz_framework_customizer_kirki_add_panel(
				
					$panel['id'], 
					array(
						'title'       => $panel['title'],
						'description' => $panel['description'],
						'priority' 	  => isset( $panel['priority'] ) ? $panel['priority'] : 100,
					)
					
				);
				
				$current_panel = $panel['id'];
				
			} else {
				
				if( !empty( $panel ) ){
					
					$current_panel = $panel;
					
				} 				
				
			}
			$option_section = array(
				'title'       => is_array($title) ? $title['title'] : $title,
				'panel'       => $current_panel
			);
			if( is_array( $title ) ){
				
				$option_section['priority'] = !empty( $title['priority'] ) ? $title['priority'] : 1;
				
			}
			if( !empty( $active_callback ) ){
				
				$option_section['active_callback'] = $active_callback;
				
			}
			$this->dahz_framework_customizer_kirki_add_section(
				$id, 
				$option_section
			);

			if($field){	
				foreach( $field as $section_field ){
					$section_field['section'] = $id ;
					$section_field['settings'] = $id.'_'.$section_field['settings'] ;
					$this->dahz_framework_customizer_kirki_add_field( $option, $section_field );
				}
			}
		}
		
		/**
		 * dahz_framework_commerce_add_field_customizer
		 * add field customizer
		 * @param $id, $field
		 * @return void
		 */
		protected function dahz_framework_add_field_customizer( $id, $field = array() ){
			if($field){
				foreach( $field as $section_field ){
					$section_field['section'] = $id;
					$section_field['settings'] = $id.'_'.$section_field['settings'];
					$this->dahz_framework_customizer_kirki_add_field( 'option', $section_field );
				}
			}
		}

		/**
		 * dahz_framework_set_customizer_property
		 * set customizer property
		 * @param $class, $property, $prefix
		 * @return void 
		 */
		protected function dahz_framework_set_customize_property( $class, $property, $prefix ){
			global $dahz_framework_woo;
			foreach( $property as $key => $default ){
				$class->{$key} = isset( $dahz_framework_woo->options[$prefix.'_'.$key] ) ? $dahz_framework_woo->options[$prefix.'_'.$key] : $default;
			}
		}
		
	}

	
}