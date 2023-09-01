<?php
if( !class_exists( 'Dahz_Framework_Customizer_Extend' ) ){
	
	abstract Class Dahz_Framework_Customizer_Extend extends Dahz_Framework_Customizer{
		
		abstract protected function dahz_framework_set_customizer();
		
		public function dahz_framework_customizer_init( $id, $title = '', $panel = '', $is_extend = false ){
			
			if( !$is_extend ){

				$this->dahz_framework_add_section_customizer( $id, $title, $this->dahz_framework_set_customizer(), $panel );
				
			} else {
				
				$this->dahz_framework_add_field_customizer( $this->id, $this->dahz_framework_set_customizer() );
				
			}
			
		}
		
	}
	
}