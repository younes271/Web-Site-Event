<?php
if( !class_exists( 'Dahz_Framework_Element_Button' ) ){
	
	class Dahz_Framework_Element_Button extends Dahz_Framework_Element {
		
		public function dahz_framework_get_selector(){
			return 'uk-button';
		}
		
		public function dahz_framework_get_prefix(){
			return 'button';
		}
		
		public function dahz_framework_get_prefix_mod(){
			return 'color_button';
		}
		
		public function dahz_framework_get_configs() {
			return array(
				'global',
				'modifier',
				'size',
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
				'modifier'	=> array(
					'default'	=> $default_setting,
					'primary'	=> $default_setting,
					'secondary'	=> $default_setting,
					'danger'	=> $default_setting,
					'disabled'	=> array(
						'background',
						'border',
						'color',
					),
					'text'	=> array(
						'hover_color',
						'border',
						'color',
						'disabled_color',
						'mode',
						'line_height',
					),
					'link'	=> array(
						'hover_color',
						'disabled_color',
						'color',
						'hover_text_decoration',
						'line_height',
					)
				),
				'size'		=> array(
					'large'	=> false,
					'small'	=> false,
				)
			);
		}
		
		public function dahz_framework_get_config_settings() {
			
			return array(
				'modifier'	=> array(
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
					),
					'mode'				=> array(
						'type'			=> 'select',
						'style_callback'=> array( $this, 'dahz_framework_button_text_mode' ),
						'default'		=> '',
						'choices'		=> array(
							''			=> __( 'None', 'kitring' ),
							'line'		=> __( 'Line', 'kitring' ),
							'arrow'		=> __( 'Arrow', 'kitring' ),
							'em_dash'	=> __( 'em dash', 'kitring' ),
						)
					),
					'hover_text_decoration'	=> array(
						'property'		=> 'hover-text-decoration',
						'default'		=> 'none',
						'type'			=> 'select',
						'choices'		=> array(
							'none'		=> __( 'None', 'kitring' ),
							'underline'	=> __( 'Underline', 'kitring' ),
						)
					),
					'line_height'		=> array(
						'property'		=> 'line-height',
						'default'		=> 'normal',
						'type'			=> 'text',
					),
				),
				'size'	=> array(
					'border_radius'		=> array(
						'property'		=> 'border-radius',
						'default'		=> '0px',
						'type'			=> 'dimension',
					),
					'font_size'			=> array(
						'property'		=> 'font-size',
						'default'		=> '12px',
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
				'global'	=> array(
					'font_size'			=> array(
						'property'		=> 'font-size',
						'default'		=> '12px',
						'type'			=> 'dimension',
					),
					'line_height'		=> array(
						'property'		=> 'line-height',
						'default'		=> 'normal',
						'type'			=> 'text',
					),
					'border_width'		=> array(
						'default'		=> '2px',
						'type'			=> 'dimension',
					),
					'border_radius'		=> array(
						'property'		=> 'border-radius',
						'default'		=> '0px',
						'type'			=> 'dimension',
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
					'padding_horizontal'=> array(
						'property'		=> 'padding-horizontal',
						'default'		=> '10px',
						'type'			=> 'dimension',
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
				),
			);
		}
		
		public function dahz_framework_button_text_mode( $value, $type, $config_name ){
			
			$styles = '';
			
			switch( $value ){
				case 'arrow':
					
					$text_color = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_color', '' );
					
					$text_hover_color = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_hover_color', '' );
					
					$arrow = '<svg width="22" height="14" viewBox="0 0 22 14" xmlns="http://www.w3.org/2000/svg"><path fill="none" stroke="' . $text_color . '" stroke-width="2" d="M14.4 1l5.8 5.9-5.8 6"/><path fill-rule="evenodd" clip-rule="evenodd" fill="' . $text_color . '" d="M0 6h18.8v2H0z"/></svg>';
					
					$arrow_hover = '<svg width="22" height="14" viewBox="0 0 22 14" xmlns="http://www.w3.org/2000/svg"><path fill="none" stroke="' . $text_hover_color . '" stroke-width="2" d="M14.4 1l5.8 5.9-5.8 6"/><path fill-rule="evenodd" clip-rule="evenodd" fill="' . $text_hover_color . '" d="M0 6h18.8v2H0z"/></svg>';
					
					$styles = '
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a,
						.uk-button-text {
							padding: 0!important;
							background: none;
							position: relative;
							padding-right: 46px!important;
						}
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a::before,
						.uk-button-text::before {
							content: "";
							position: absolute;
							top: 0;
							bottom: 0;
							right: 0;
							width: 26px;
							background-image: url("data:image/svg+xml;charset=UTF-8,' . rawurlencode( $arrow ) . '");
							background-repeat: no-repeat;
							background-position: calc(100% - 5px) 50%;
							transition: background-position 0.2s ease-out;
						}
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a:hover::before,
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a:focus::before,
						.uk-button-text:hover::before, .uk-button-text:focus::before {
							background-image: url("data:image/svg+xml;charset=UTF-8,' . rawurlencode( $arrow_hover ) . '");
							background-position: 100% 50%;
						}
					';
					
					break;
				case 'line':
					$border_color = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_border', '' );
					$styles = '
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a,
						.uk-button-text {
							padding: 0!important;
							background: none;
							position: relative;
							z-index: 0;
						}
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a::before,
						.uk-button-text::before {
							content: "";
							position: absolute;
							bottom: 0;
							left: 0;
							right: 100%;
							z-index: -1;
							border-bottom: 1px solid ' . $border_color . ';
							transition: right 0.3s ease-out;
						}
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a:hover::before,
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a:focus::before,
						.uk-button-text:hover::before, .uk-button-text:focus::before {
							right: 0;
						}
					';
					break;
				case 'em_dash':
					$border_color = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_' . $type . '_border', '' );
					$styles = '
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a,
						.uk-button-text {
							padding: 0!important;
							background: none;
							position: relative;
							padding-left: 28px!important;
						}
						.woocommerce-account .woocommerce-MyAccount-orders td.woocommerce-orders-table__cell-order-actions a::before,
						.uk-button-text::before {
							content: "";
							position: absolute;
							top: calc(50% - 1px);
							left: 0;
							width: 20px;
							border-bottom: 1px solid ' . $border_color . ';
						}
					';
					break;
			}
			return $styles;
			
		}
		
		public function dahz_framework_button_border_mode( $value, $type, $config_name ){
			
			$border_width = get_theme_mod( $this->prefix_mod . '_' . $config_name . '_border_width', '2px' );
			
			return "
				.woocommerce-page a:not(.de-product__item--add-to-cart-button).button, 
				.woocommerce a:not(.de-product__item--add-to-cart-button).button, 
				.woocommerce-page button.button, 
				.woocommerce button.button, 
				.woocommerce-page input.button, 
				.woocommerce input.button, 
				.woocommerce-page #respond input#submit, 
				.woocommerce #respond input#submit,
				.de-mini-cart__button,
				.uk-button-default:disabled, 
				.uk-button-primary:disabled, 
				.uk-button-secondary:disabled, 
				.uk-button-danger:disabled,
				.uk-button-default, 
				.uk-button-primary, 
				.uk-button-secondary, 
				.uk-button-danger{
					border{$value}-width:{$border_width};
					border{$value}-style:solid;
				}
			";
			
		}
		
	}
	
}