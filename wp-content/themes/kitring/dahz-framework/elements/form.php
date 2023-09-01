<?php
if( !class_exists( 'Dahz_Framework_Element_Form' ) ){
	
	class Dahz_Framework_Element_Form extends Dahz_Framework_Element {
		
		public function dahz_framework_get_selector(){
			return 'uk-input';
		}
		
		public function dahz_framework_get_prefix(){
			return 'form';
		}
		
		public function dahz_framework_get_prefix_mod(){
			return 'form';
		}
		
		public function dahz_framework_get_configs() {
			return array(
				'global',
				'modifier',
				'size',
				'type',
				'width',
				'direction',
			);
		}
		
		public function dahz_framework_get_config_types() {
			
			$default_setting = array(
				'border',
				'color',
			);
			
			return array(
				'modifier'	=> array(
					'danger'	=> $default_setting,
					'success'	=> $default_setting,
					'blank'		=> array(
						'focus_border',
						'focus_border_style',
					),
				),
				'size'		=> array(
					'large'	=> false,
					'small'	=> false,
				),
				'type'		=> array(
					'legend'	=> array(
						'font_size',
						'line_height',
					),
					'label'		=> array(
						'color',
						'font_size',
						'font_weight',
						'letter_spacing',
						'text_transform',
					),
					'select'	=> array(
						'icon_color',
						'option_color',
						'padding_right',
						'disabled_icon_color',
					),
					'radio'		=> array(
						'background',
						'border',
						'border_width',
						'margin_top',
						'size',
						'checked_focus_background',
						'focus_border',
						'checked_background',
						'checked_border',
						'checked_icon_color',
						'disabled_background',
						'disabled_border',
						'checked_disabled_icon_color',
					),
					'range'		=> array(
						'thumb_background',
						'thumb_border',
						'thumb_border_radius',
						'thumb_border_width',
						'thumb_height',
						'track_background',
						'track_height',
						'track_focus_background',
					),
				),
				'direction'			=> array(
					'stacked'		=> array( 'margin_bottom' ),
					'horizontal'	=> array(
						'controls_margin_left',
						'controls_text_padding_top',
						'label_margin_top',
						'label_width',
					),
				),
			);
		}
		
		public function dahz_framework_get_config_settings() {
			
			return array(
				'modifier'	=> array(
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
					'focus_border'			=> array(
						'property'	=> 'focus-border',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'focus_border_style'	=> array(
						'type'			=> 'select',
						'property'		=> 'focus-border-style',
						'default'		=> '',
						'choices'		=> array(
							'none'			=> __( 'None', 'kitring' ),
							'solid'		=> __( 'Solid', 'kitring' ),
							'dashed'	=> __( 'Dashed', 'kitring' ),
							'dotted'	=> __( 'Dotted', 'kitring' ),
						)
					),
				),
				'size'	=> array(
					'font_size'			=> array(
						'property'		=> 'font-size',
						'default'		=> '14px',
						'type'			=> 'dimension',
					),
					'height'		=> array(
						'property'		=> 'height',
						'default'		=> '30px',
						'type'			=> 'dimension',
					),
					'line_height'		=> array(
						'property'		=> 'line-height',
						'default'		=> 'normal',
						'type'			=> 'text',
					),
					'padding_horizontal'=> array(
						'property'		=> 'padding-horizontal',
						'default'		=> '10px',
						'type'			=> 'dimension',
					),
				),
				'width'		=> array(
					'large'			=> array(
						'property'		=> 'large',
						'default'		=> '500px',
						'type'			=> 'dimension',
					),
					'medium'			=> array(
						'property'		=> 'medium',
						'default'		=> '200px',
						'type'			=> 'dimension',
					),
					'small'			=> array(
						'property'		=> 'small',
						'default'		=> '130px',
						'type'			=> 'dimension',
					),
					'xsmall'			=> array(
						'property'		=> 'xsmall',
						'default'		=> '50px',
						'type'			=> 'dimension',
					),
				),
				'type'				=> array(
					'font_size'			=> array(
						'property'		=> 'font-size',
						'default'		=> '14px',
						'type'			=> 'dimension',
					),
					'line_height'		=> array(
						'property'		=> 'line-height',
						'default'		=> 'normal',
						'type'			=> 'text',
					),
					'color'			=> array(
						'property'	=> 'color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'font_weight'		=> array(
						'type'			=> 'select',
						'property'		=> 'font-weight',
						'default'		=> 'inherit',
						'choices'		=> array(
							'inherit'	=> __( 'Inherit', 'kitring' ),
							'normal'	=> __( 'Normal', 'kitring' ),
							'bold'		=> __( 'Bold', 'kitring' ),
						)
					),
					'letter_spacing'	=> array(
						'property'		=> 'letter-spacing',
						'default'		=> '-0.6px',
						'type'			=> 'dimension',
					),
					'text_transform'	=> array(
						'type'			=> 'select',
						'property'		=> 'text-transform',
						'default'		=> 'inherit',
						'choices'		=> array(
							'inherit'		=> __( 'Inherit', 'kitring' ),
							'lowercase'		=> __( 'Lowercase', 'kitring' ),
							'uppercase'		=> __( 'Uppercase', 'kitring' ),
							'capitalize'	=> __( 'Capitalize', 'kitring' ),
						)
					),
					'icon_color'			=> array(
						'style_callback'	=> array( $this, 'dahz_framework_select_icon_color' ),
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'option_color'			=> array(
						'property'	=> 'option-color',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'padding_right'	=> array(
						'property'	=> 'padding-right',
						'default'	=> '20px',
						'type'		=> 'dimension',
					),
					'disabled_icon_color'	=> array(
						'style_callback'	=> array( $this, 'dahz_framework_select_disabled_icon_color' ),
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'background'			=> array(
						'property'	=> 'background',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'border'			=> array(
						'property'	=> 'border',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'border_width'			=> array(
						'property'	=> 'border-width',
						'default'	=> '1px',
						'type'		=> 'dimension',
					),
					'margin_top'			=> array(
						'property'	=> 'margin-top',
						'default'	=> '-4px',
						'type'		=> 'dimension',
					),
					'size'			=> array(
						'property'	=> 'size',
						'default'	=> '16px',
						'type'		=> 'dimension',
					),
					'checked_focus_background'			=> array(
						'property'	=> 'checked-focus-background',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'focus_border'			=> array(
						'property'	=> 'focus-border',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'checked_background'			=> array(
						'property'	=> 'checked-background',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'checked_border'			=> array(
						'property'	=> 'checked-border',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'checked_icon_color'			=> array(
						'style_callback'	=> array( $this, 'dahz_framework_checked_icon_color' ),
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'disabled_background'			=> array(
						'property'	=> 'disabled-background',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'disabled_border'			=> array(
						'property'	=> 'disabled-border',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'checked_disabled_icon_color'	=> array(
						'style_callback'	=> array( $this, 'dahz_framework_checked_disabled_icon_color' ),
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'thumb_background'			=> array(
						'property'	=> 'thumb-background',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'thumb_border'			=> array(
						'property'	=> 'thumb-border',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'thumb_border_radius'			=> array(
						'property'	=> 'thumb-border-radius',
						'default'	=> '500px',
						'type'		=> 'dimension',
					),
					'thumb_border_width'			=> array(
						'property'	=> 'thumb-border-width',
						'default'	=> '0',
						'type'		=> 'dimension',
					),
					'thumb_height'			=> array(
						'style_callback'=> array( $this, 'dahz_framework_range_thumb_height' ),
						'property'	=> 'thumb-height',
						'default'	=> '15px',
						'type'		=> 'dimension',
					),
					'track_background'			=> array(
						'property'	=> 'track-background',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
					'track_height'			=> array(
						'property'	=> 'track-height',
						'default'	=> '3px',
						'type'		=> 'dimension',
					),
					'track_focus_background'			=> array(
						'property'	=> 'track-focus-background',
						'default'	=> '#000000',
						'type'		=> 'color',
					),
				),
				'direction'			=> array(
					'margin_bottom'			=> array(
						'property'	=> 'margin-bottom',
						'default'	=> '5px',
						'type'		=> 'dimension',
					),
					'controls_margin_left'			=> array(
						'property'	=> 'controls-margin-left',
						'default'	=> '215px',
						'type'		=> 'dimension',
					),
					'controls_text_padding_top'			=> array(
						'property'	=> 'controls-text-padding-top',
						'default'	=> '7px',
						'type'		=> 'dimension',
					),
					'label_margin_top'			=> array(
						'property'	=> 'label-margin-top',
						'default'	=> '7px',
						'type'		=> 'dimension',
					),
					'label_width'			=> array(
						'property'	=> 'label-width',
						'default'	=> '200px',
						'type'		=> 'dimension',
					),
				),
				'global'			=> array(
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
					'border_mode'		=> array(
						'type'			=> 'select',
						'style_callback'=> array( $this, 'dahz_framework_button_border_mode' ),
						'default'		=> '',
						'choices'		=> array(
							''			=> __( 'Full', 'kitring' ),
							'-top'		=> __( 'Top', 'kitring' ),
							'-right'	=> __( 'Right', 'kitring' ),
							'-bottom'	=> __( 'Bottom', 'kitring' ),
							'-left'		=> __( 'Left', 'kitring' ),
						)
					),
					'border_radius'		=> array(
						'property'		=> 'border-radius',
						'default'		=> '0px',
						'type'			=> 'dimension',
					),
					'border_width'		=> array(
						'property'		=> 'border-width',
						'default'		=> '2px',
						'type'			=> 'dimension',
					),
					'color'			=> array(
						'property'	=> 'color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'height'			=> array(
						'property'		=> 'height',
						'default'		=> '50px',
						'type'			=> 'dimension',
					),
					'line_height'		=> array(
						'property'		=> 'line-height',
						'default'		=> '48px',
						'type'			=> 'text',
					),
					'padding_horizontal'=> array(
						'property'		=> 'padding-horizontal',
						'default'		=> '10px',
						'type'			=> 'dimension',
					),
					'padding_vertical'=> array(
						'property'		=> 'padding-vertical',
						'default'		=> '4px',
						'type'			=> 'dimension',
					),
					'placeholder_color'			=> array(
						'property'	=> 'placeholder-color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'focus_background'	=> array(
						'property'	=> 'focus-background',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'focus_border'			=> array(
						'property'	=> 'focus-border',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'focus_color'			=> array(
						'property'	=> 'focus-color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'disabled_background'			=> array(
						'property'	=> 'disabled-background',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'disabled_border'			=> array(
						'property'	=> 'disabled-border',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
					'disabled_color'			=> array(
						'property'	=> 'disabled-color',
						'default'	=> '#ffffff',
						'type'		=> 'color',
					),
				),
			);
		}
				
		public function dahz_framework_button_border_mode( $value, $type, $config_name ){
			
			$border_width = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_border_width', '2px' );
			return "
				input[type=date],
				input[type=datetime],
				input[type=datetime-local],
				input[type=email],
				input[type=month],
				input[type=number],
				input[type=password],
				input[type=range],
				input[type=search],
				input[type=tel],
				input[type=text],
				input[type=time],
				input[type=url],
				input[type=week],
				select,
				.select2-selection select2-selection--single,
				textarea{
					border{$value}-width:{$border_width};
					border{$value}-style:solid;
				}
			";
			
		}
		
		public function dahz_framework_select_icon_color( $value, $type, $config_name ){
			
			$icon_color = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_icon_color', '#000000' );

			$icon_background = sprintf('
				<svg width="24" height="16" viewBox="0 0 24 16" xmlns="http://www.w3.org/2000/svg">
					<polygon fill="%1$s" points="12 1 9 6 15 6" />
					<polygon fill="%1$s" points="12 13 9 8 15 8" />
				</svg>
			', $icon_color );
			
			return '
				.select2-selection select2-selection--single,
				select:not([multiple]):not([size]),
				.uk-select:not([multiple]):not([size]) {
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $icon_background ) . '" );
				}
			';
			
		}
		
		public function dahz_framework_select_disabled_icon_color( $value, $type, $config_name ){
			
			$icon_color = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_disabled_icon_color', '#000000' );

			$icon_background = sprintf('
				<svg width="24" height="16" viewBox="0 0 24 16" xmlns="http://www.w3.org/2000/svg">
					<polygon fill="%1$s" points="12 1 9 6 15 6" />
					<polygon fill="%1$s" points="12 13 9 8 15 8" />
				</svg>
			', $icon_color );
			
			return '
				.select2-selection select2-selection--single:disabled,
				select:not([multiple]):not([size]):disabled,
				.uk-select:not([multiple]):not([size]):disabled {
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $icon_background ) . '" );
				}
			';
			
		}
		
		public function dahz_framework_checked_icon_color( $value, $type, $config_name ){
			
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
				input[type=radio]:checked,
				.uk-radio:checked{
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $form_radio_image ) . '" );
				}
				input[type=checkbox]:checked,
				.uk-checkbox:checked{
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $form_checkbox_image ) . '" );
				}
				input[type=checkbox]:indeterminate,
				.uk-checkbox:indeterminate{
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $form_checkbox_indeterminate_image ) . '" );
				}
			';
			
		}
		
		public function dahz_framework_checked_disabled_icon_color( $value, $type, $config_name ){
			
			$icon_color = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_checked_disabled_icon_color', '#000000' );
			
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
				input[type=radio]:disabled:checked,
				.uk-radio:disabled:checked{
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $form_radio_image ) . '" );
				}
				input[type=checkbox]:disabled:checked,
				.uk-checkbox:checked:disabled{
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $form_checkbox_image ) . '" );
				}
				input[type=checkbox]:disabled:indeterminate,
				.uk-checkbox:disabled:indeterminate{
					background-image:url( "data:image/svg+xml;charset=UTF-8,' . rawurlencode( $form_checkbox_indeterminate_image ) . '" );
				}
			';
			
		}
		
		public function dahz_framework_range_thumb_height( $value, $type, $config_name ){
			
			return '
				input[type=range]::-webkit-slider-thumb,
				.uk-range::-webkit-slider-thumb {
					margin-top: ' . ( ( (int)$value / 2 ) * -1 ) . 'px;
				}
			';
			
		}
		
	}
	
}