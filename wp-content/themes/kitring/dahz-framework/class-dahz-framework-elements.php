<?php
if( !class_exists( 'Dahz_Framework_Elements' ) ){
	
	class Dahz_Framework_Elements {
		
		protected static $_instance = null;
		
		public $elements = array(
			'button' 	=> null,
			'form'		=> null,
			'inverse'	=> null,
			'offcanvas'	=> null,
		);
		
		function __construct(){
			$this->dahz_framework_includes();
			
		}
		
		function dahz_framework_get_element_styles(){
			
			$css_variables = '';
			
			$css_styles = '';
			
			foreach( $this->elements as $element => $element_settings ){
				
				$css = $element_settings->dahz_framework_get_variable_css();

				$css_variables .= $css['css_variables'];
				
				$css_styles .= $css['css_styles'];
				
			}
			
			return ':root{' . apply_filters( 'dahz_framework_css_variables', $css_variables ) . '}' . apply_filters( 'dahz_framework_css_styles', $css_styles );
			
		}
		
		public static function dahz_framework_instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;

		}
		
		private function dahz_framework_includes(){
			
			dahz_framework_include( get_template_directory() . '/dahz-framework/abstract-class-dahz-framework-element.php' );
			
			foreach( $this->elements as $element => $value ){
				
				dahz_framework_include( get_template_directory() . "/dahz-framework/elements/{$element}.php" );
				
				$class = 'Dahz_Framework_Element_' . ucwords( $element );
				
				$element_class = new $class();
				
				$element_class->dahz_framework_initialize();
				
				$this->elements[$element] = $element_class;
				
				
			}
			
		}
		
		public function dahz_framework_get_element( $element ){
			
			return isset( $this->elements[ $element ] ) ? $this->elements[ $element ] : false;
			
		}
		
		public function dahz_framework_get_customizer( $element ){
			
			$customizer = dahz_framework_elements()->dahz_framework_get_element( $element );
			
			$controls = array();
			
			if( $customizer && isset( $customizer->configs ) ){
				
				foreach( $customizer->configs as $config_name ){
					
					if( ! isset( $customizer->config_types[ $config_name ] ) && ! isset( $customizer->config_settings[ $config_name ] ) ){
						
						continue;
					
					} elseif( ! isset( $customizer->config_types[ $config_name ] ) && isset( $customizer->config_settings[ $config_name ] ) ){
						
						if( $config_name !== 'global' ){
							
							$controls[] = array(
								'type'     => 'custom',
								'settings' => "{$config_name}_custom_heading_title",
								'label'    => '',
								'default'  => '<div class="de-customizer-title">' . ucwords( str_replace( '_', ' ', $config_name ) ) . '</div>',
							);
							
						}
						
						foreach( $customizer->config_settings[ $config_name ] as $style_name => $style ){
								
							$control = array(
								'type'		=> isset( $style['type'] ) ? $style['type'] : 'text',
								'settings'	=> "{$config_name}_{$style_name}",
								'label'		=> ucwords( str_replace( '_', ' ', $style_name ) ),
								'default'	=> isset( $style['default'] ) ? $style['default'] : '',
							);
							
							if( $control['type'] == 'color' ){
									
								$control['choices'] = array(
									'alpha' => true,
								);
							
							}
							
							if( isset( $style['choices'] ) ){
								
								$control['choices'] = $style['choices'];
								
							}
							
							$controls[] = $control;
							
						}
						
					} elseif( isset( $customizer->config_types[ $config_name ] ) && isset( $customizer->config_settings[ $config_name ] ) ){
						
						foreach( $customizer->config_types[ $config_name ] as $type => $type_settings ){
						
							if( ! isset( $customizer->config_settings[ $config_name ] ) ){continue;}
							
							$controls[] = array(
								'type'     => 'custom',
								'settings' => "{$type}_custom_heading_title",
								'label'    => '',
								'default'  => '<div class="de-customizer-title">' . ucwords( str_replace( '_', ' ', $type ) ) . '</div>',
							);
							
							foreach( $customizer->config_settings[ $config_name ] as $style_name => $style ){
								
								if( $type_settings && is_array( $type_settings ) && ! in_array( $style_name, $type_settings ) ){ continue; }
								
								$control = array(
									'type'		=> isset( $style['type'] ) ? $style['type'] : 'text',
									'settings'	=> "{$config_name}_{$type}_{$style_name}",
									'label'		=> ucwords( str_replace( '_', ' ', $style_name ) ),
									'default'	=> isset( $style['default'] ) ? $style['default'] : '',
								);
								
								if( $control['type'] == 'color' ){
									
									$control['choices'] = array(
										'alpha' => true,
									);
								
								}
								
								if( isset( $style['choices'] ) ){
									
									$control['choices'] = $style['choices'];
									
								}
								
								$controls[] = $control;
								
							}
						
						}
						
					}
										
				}
				
			}
						
			return $controls;
			
		}
		
	}
	
}