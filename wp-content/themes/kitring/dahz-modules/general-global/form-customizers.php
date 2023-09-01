<?php

if ( !class_exists( 'Dahz_Framework_Modules_Form_Customizer' ) ) {
		
	class Dahz_Framework_Modules_Form_Customizer extends Dahz_Framework_Customizer_Extend {
				
		public function dahz_framework_set_customizer() {
			
			$dv_field = dahz_framework_elements()->dahz_framework_get_customizer( 'form' );
			
			return $dv_field;
		}
	}
}