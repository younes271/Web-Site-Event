<?php
if( !class_exists( 'Dahz_Framework_Element_Inverse' ) ){
	
	class Dahz_Framework_Element_Inverse extends Dahz_Framework_Element {
		
		public function dahz_framework_get_selector(){
			return 'uk-inverse';
		}
		
		public function dahz_framework_get_prefix(){
			return 'inverse';
		}
		
		public function dahz_framework_get_prefix_mod(){
			return 'inverse';
		}
		
		public function dahz_framework_get_configs() {
			return array(
				'button',
				'form',
			);
		}
		
		public function dahz_framework_get_config_types() {
			
			$default_setting = array(
				'background',
				'border',
				'color',
				'hover_background',
				'hover_border',
				'hover_color',
			);
			
			return array(
				'button'		=> array(
					'button_default'	=> $default_setting,
					'button_primary'	=> $default_setting,
					'button_secondary'	=> $default_setting,
					'button_text'	=> array(
						'hover_color',
						'border',
						'color',
						'disabled_color',
					),
					'button_link'	=> array(
						'hover_color',
						'color',
					)
				),
				'form'			=> array(
					'form'			=> array(
						'background',
						'border',
						'color',
						'placeholder_color',
						'focus_background',
						'focus_border',
						'focus_color',
					),
					'form_select'	=> array(
						'icon_color',
					),
					'form_radio'	=> array(
						'background',
						'border',
						'focus_border',
						'checked_background',
						'checked_border',
						'checked_icon_color',
						'checked_focus_background',
					),
					'form_label'	=> array(
						'color'
					),
				)
			);
		}
		
		public function dahz_framework_get_config_settings() {
			
			return array(
				'button'	=> array(
					'background' 	=> array(
						'property'	=> 'background-color',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'border' 		=> array(
						'property'	=> 'border-color',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'color'			=> array(
						'property'	=> 'color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'hover_background'	=> array(
						'property'		=> 'hover-background-color',
						'default'		=> '#ffffff',
						'type'			=> 'color',
					),
					'hover_border'		=> array(
						'property'		=> 'hover-border-color',
						'default'		=> '#000000',
						'type'			=> 'color',
					),
					'hover_color'		=> array(
						'property'		=> 'hover-color',
						'default'		=> '#ffffff',
						'type'			=> 'color',
					),
					'disabled_color'	=> array(
						'property'		=> 'disabled-color',
						'default'		=> '#ffffff',
						'type'			=> 'color',
					)
				),
				'form'	=> array(
					'background' 	=> array(
						'property'	=> 'background-color',
						'default'	=> 'rgba(255,255,255,0)',
						'type'		=> 'color',
					),
					'border' 		=> array(
						'property'	=> 'border-color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'color'			=> array(
						'property'	=> 'color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'placeholder_color'	=> array(
						'property'	=> 'placeholder-color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'focus_background' 	=> array(
						'property'	=> 'focus-background',
						'default'	=> 'rgba(255,255,255,0)',
						'type'		=> 'color',
					),
					'focus_border' 		=> array(
						'property'	=> 'focus-border',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'focus_color'	=> array(
						'property'	=> 'focus-color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'icon_color'	=> array(
						'property'	=> 'icon-color',
						'default'	=> '#ffffff',
						'style_callback'	=> array( $this, 'dahz_framework_select_inverse_icon_color' ),
						'type'		=> 'color',
					),
					'checked_background' 	=> array(
						'property'	=> 'checked-background',
						'default'	=> 'rgba(255,255,255,0)',
						'type'		=> 'color',
					),
					'checked_border' 		=> array(
						'property'	=> 'checked-border',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'checked_icon_color' 	=> array(
						'property'	=> 'checked-icon-color',
						'style_callback'	=> array( $this, 'dahz_framework_checked_icon_inverse_color' ),
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'checked_focus_background' 	=> array(
						'property'	=> 'checked-focus-background',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
				)
			);
		}
		
		public function dahz_framework_select_inverse_icon_color( $value, $type, $config_name ){
			
			$icon_color = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_icon_color', '#ffffff' );

			$icon_background = sprintf('
				<svg width="24" height="16" viewBox="0 0 24 16" xmlns="http://www.w3.org/2000/svg">
					<polygon fill="%1$s" points="12 1 9 6 15 6" />
					<polygon fill="%1$s" points="12 13 9 8 15 8" />
				</svg>
			', $icon_color );
			
			return '
				.uk-light .select2-selection select2-selection--single,
				.uk-light select:not([multiple]):not([size]),
				.uk-light .uk-select:not([multiple]):not([size]) {
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $icon_background ) . '" );
				}
			';
			
		}
		
		public function dahz_framework_checked_icon_inverse_color( $value, $type, $config_name ){
			
			$icon_color = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_checked_icon_color', '#000000' );
			
			$form_radio_image = sprintf( 
				'
				<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
					<circle fill="%1$s" cx="8" cy="8" r="2" />
				</svg>
				',
				$icon_color
			);
			$form_checkbox_image = sprintf(
				'
				<svg width="14" height="11" viewBox="0 0 14 11" xmlns="http://www.w3.org/2000/svg">
					<polygon fill="%1$s" points="12 1 5 7.5 2 5 1 5.5 5 10 13 1.5" />
				</svg>
				',
				$icon_color
			);
			$form_checkbox_indeterminate_image = sprintf(
				'
				<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
					<rect fill="%1$s" x="3" y="8" width="10" height="1" />
				</svg>
				',
				$icon_color
			);

			
			return '
				.uk-light input[type=radio]:checked,
				.uk-light .uk-radio:checked{
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $form_radio_image ) . '" );
				}
				.uk-light input[type=checkbox]:checked,
				.uk-light .uk-checkbox:checked{
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $form_checkbox_image ) . '" );
				}
				.uk-light input[type=checkbox]:indeterminate,
				.uk-light .uk-checkbox:indeterminate{
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $form_checkbox_indeterminate_image ) . '" );
				}
			';
			
		}
				
	}
	
}