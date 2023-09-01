<?php
if( !class_exists( 'Dahz_Framework_Element' ) ){
	
	abstract class Dahz_Framework_Element {
		
		public $selector = '';
		public $prefix = '';
		public $prefix_mod = '';
		public $configs = array();
		public $config_types = array();
		public $config_settings = array();
		
		
		abstract protected function dahz_framework_get_selector();
		abstract protected function dahz_framework_get_prefix();
		abstract protected function dahz_framework_get_prefix_mod();
		abstract protected function dahz_framework_get_configs();
		abstract protected function dahz_framework_get_config_types();
		abstract protected function dahz_framework_get_config_settings();
				
		public function dahz_framework_initialize(){
			
			$this->selector 		= $this->dahz_framework_get_selector();
			$this->prefix 			= $this->dahz_framework_get_prefix();
			$this->prefix_mod 		= $this->dahz_framework_get_prefix_mod();
			$this->configs 			= $this->dahz_framework_get_configs();
			$this->config_types 	= $this->dahz_framework_get_config_types();
			$this->config_settings 	= $this->dahz_framework_get_config_settings();

		}
		
		public function dahz_framework_get_variable_css(){
			
			$css_variables = '';
			
			$css_styles = '';
				
			if( !empty( $this->configs ) ){
				
				foreach( $this->configs as $config_name ){
					
					if( ! isset( $this->config_types[ $config_name ] ) && ! isset( $this->config_settings[ $config_name ] ) ){
						continue;
					} elseif( ! isset( $this->config_types[ $config_name ] ) && isset( $this->config_settings[ $config_name ] ) ){
						
						foreach( $this->config_settings[ $config_name ] as $style_name => $style ){
							
							if( isset( $style['property'] ) ){ 
							
								$css_variables .= '--' . $this->prefix . '-' . $config_name . '-' . $style['property'] . ':'. get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $style_name, isset( $style['default'] ) ? $style['default'] : '' ) . ';';
							
							}
							
							if( isset( $style['style_callback'] ) ){
								
								$css_styles .= call_user_func( $style['style_callback'], get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $style_name, isset( $style['default'] ) ? $style['default'] : '' ), '', $config_name );
								
							}
							
						}
						
					} elseif( isset( $this->config_types[ $config_name ] ) && isset( $this->config_settings[ $config_name ] ) ){
					
						foreach( $this->config_types[ $config_name ] as $type => $type_settings ){
							
							if( ! isset( $this->config_settings[ $config_name ] ) ){continue;}
													
							foreach( $this->config_settings[ $config_name ] as $style_name => $style ){
								
								if( $type_settings && is_array( $type_settings ) && ! in_array( $style_name, $type_settings ) ){ continue; }
								
								if( isset( $style['property'] ) ){ 
								
									$css_variables .= '--' . $this->prefix . '-' . str_replace( '_', '-', $type ) . '-' . $style['property'] . ':'. get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_' . $style_name, isset( $style['default'] ) ? $style['default'] : '' ) . ';';
								
								}
								
								if( isset( $style['style_callback'] ) ){
									
									$css_styles .= call_user_func( $style['style_callback'], get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_' . $style_name, isset( $style['default'] ) ? $style['default'] : '' ), $type, $config_name );
									
								}
								
							}
						
						}
						
					}
					
				}
				
			}
			
			return array(
				'css_variables' => $css_variables,
				'css_styles'		=> $css_styles
			);
			
		}
		
	}
	
}