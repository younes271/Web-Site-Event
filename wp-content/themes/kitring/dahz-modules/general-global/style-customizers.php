<?php

if ( !class_exists( 'Dahz_Framework_Modules_Form_Customizer' ) ) {
		
	class Dahz_Framework_Modules_Form_Customizer extends Dahz_Framework_Customizer_Extend {
				
		public function dahz_framework_set_customizer() {
			
			$dv_field = dahz_framework_elements()->dahz_framework_get_customizer( 'form' );
			
			return $dv_field;
		}
	}
}

if ( !class_exists( 'Dahz_Framework_Modules_Color_Button_Customizer' ) ) {
	
	class Dahz_Framework_Modules_Color_Button_Customizer extends Dahz_Framework_Customizer_Extend {
				
		public function dahz_framework_set_customizer() {
			
			$dv_field = dahz_framework_elements()->dahz_framework_get_customizer( 'button' );
			
			return $dv_field;
		}
	}
}

if ( !class_exists( 'Dahz_Framework_Modules_Inverse_Customizer' ) ) {
	
	class Dahz_Framework_Modules_Inverse_Customizer extends Dahz_Framework_Customizer_Extend {
				
		public function dahz_framework_set_customizer() {
			
			$dv_field = dahz_framework_elements()->dahz_framework_get_customizer( 'inverse' );
			
			return $dv_field;
		}
	}
}
if ( !class_exists( 'Dahz_Framework_Modules_Offcanvas_Customizer' ) ) {
	
	class Dahz_Framework_Modules_Offcanvas_Customizer extends Dahz_Framework_Customizer_Extend {
				
		public function dahz_framework_set_customizer() {
			
			$dv_field = dahz_framework_elements()->dahz_framework_get_customizer( 'offcanvas' );
			
			return $dv_field;
		}
	}
}