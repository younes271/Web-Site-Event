<?php

/**
 * Dahz_Framework_Header_Cart
 */

class Dahz_Framework_Header_Cart {

	public $content_block  = false;

	public $cart_container = '';

	function __construct() {
		
		add_filter( 'woocommerce_locate_template', array( $this, 'dahz_framework_woo_relocate_template' ), 10, 3 );

		add_action( 'dahz_framework_module_header-cart_init', array( $this, 'dahz_framework_header_cart_init' ) );

		add_filter( 'dahz_framework_default_styles'	, array( $this, 'dahz_framework_header_cart_style' ), 20, 1 );

		add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_header_item_cart' ), 10, 3 );

		add_filter( 'dahz_framework_customize_headermobile_builder_items', array( $this, 'dahz_framework_header_item_cart_mobile' ), 10, 3 );

		add_filter( 'dahz_framework_header_mobile_elements', array( $this, 'dahz_framework_header_item_cart_mobile' ) );

		add_action( 'before_woocommerce_init', array( $this, 'dahz_framework_minicart_remove_element' ), 20 );

		add_action( 'before_woocommerce_init', array( $this, 'dahz_framework_minicart_element' ), 20 );

		add_action( 'init', array( $this, 'dahz_framework_register_ajax_lazy_mini_cart' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_header_cart_script' ), 20 );

		add_action( 'wp_footer', array( $this, 'dahz_framework_render_cart_container' ), 10 );

	}
	
	public function dahz_framework_woo_relocate_template( $woo_template, $woo_template_name, $woo_template_path ) {

		if ( $woo_template_name === 'cart/mini-cart.php' ) {

			$woo_template = get_template_directory() . '/dahz-modules/header-cart/templates/mini-cart.php';

		}

		return $woo_template;

	}

	public function dahz_framework_header_cart_script() {

		wp_register_script( 'dahz-framework-header-cart', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/header-cart/assets/js/dahz-framework-header-cart.min.js', array( 'dahz-framework-script' ), null, true );

	}

	public function dahz_framework_register_ajax_lazy_mini_cart() {

		add_action( 'wp_ajax_dahz_framework_header_lazy_mini_cart', array( $this, 'dahz_framework_header_lazy_mini_cart' ), 10 );

		add_action( 'wp_ajax_nopriv_dahz_framework_header_lazy_mini_cart', array( $this, 'dahz_framework_header_lazy_mini_cart' ), 10 );

	}

	public function dahz_framework_header_cart_init( $path ) {

		if ( is_customize_preview() ) dahz_framework_include( $path . '/header-cart-customizer.php' );

		dahz_framework_register_customizer(
			'Dahz_Framework_Header_Cart_Customizer',
			array(
				'id'	=> 'header_cart',
				'title'	=> array( 'title' => esc_html__( 'Cart', 'kitring' ), 'priority' => 13 ),
				'panel'	=> 'header'
			),
			array()
		);

	}

	/**
	 * dahz_framework_minicart_remove_element
	 * all hooks to remove unused element on mini cart
	 * @param -
	 * @return -
	 */
	public function dahz_framework_minicart_remove_element() {

		remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );

		remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

	}

	/**
	 * dahz_framework_minicart_element
	 * all hooks to add element on mini cart
	 * @param -
	 * @return -
	 */
	public function dahz_framework_minicart_element() {

		add_filter( 'woocommerce_cart_item_remove_link', array( $this, 'dahz_framework_header_remove_item_cart' ), 10, 2 );

		add_action( 'woocommerce_widget_shopping_cart_buttons', array( $this, 'dahz_framework_header_button_cart'), 10 );

		add_filter( 'dahz_framework_preset_required', array( $this, 'dahz_framework_exclude_preset_required' ) );

	}

	public function dahz_framework_exclude_preset_required( $preset_required ) {

		$preset_required['headermobile']['exclude_sections'][] = 'header_cart';

		return $preset_required;

	}

	/**
	 * dahz_framework_header_item_cart
	 * register header element: cart
	 * @param $items
	 * @return $items
	 */
	public function dahz_framework_header_item_cart( $items ) {

		$items['cart'] = array(
			'title'				=> esc_html__( 'Cart', 'kitring' ),
			'description'		=> esc_html__( 'Display product cart', 'kitring' ),
			'render_callback'	=> array( $this, 'dahz_framework_header_elem_cart' ),
			'section_callback'	=> 'header_cart',
			'is_repeatable'		=> false
		);

		return $items;

	}

	public function dahz_framework_header_item_cart_mobile( $items ) {

		$items['cart_mobile'] = array(
			'title'				=> esc_html__( 'Cart', 'kitring' ),
			'description'		=> esc_html__( 'Display product cart', 'kitring' ),
			'render_callback'	=> array( $this, 'dahz_framework_header_elem_cart' ),
			'section_callback'	=> 'header_cart',
			'is_repeatable'		=> false
		);

		return $items;

	}

	public function dahz_framework_header_lazy_mini_cart() {

		woocommerce_mini_cart();

		die();

	}

	/**
	* dahz_framework_header_elem_cart
	* render header element : cart
	* @param -
	* @return -
	*/
	public function dahz_framework_header_elem_cart( $builder_type, $section, $row, $column ) {

		$cart_icon = '';

		$cart_text = '';

		$cart_total_item = '<span class="de-cart__total-item"></span>';

		$cart_total_price = '<span class="de-cart__total-price"></span>';

		$cart_url  = 'href="#"';

		$cart_icon_display = dahz_framework_get_option( 'header_cart_style', 'style-3' );

		$cart_display = dahz_framework_get_option( 'header_cart_display_as', 'as-sidebar' );

		$cart_display = $cart_display !== 'as-link' && ( $builder_type == 'mobile_elements' || $builder_type == 'headermobile' ) ? 'as-sidebar' : $cart_display;

		$header_layout = dahz_framework_get_option( 'logo_and_site_identity_header_style', 'horizontal' );

		$is_show_price = $builder_type == 'mobile_elements' || $builder_type == 'headermobile' ? dahz_framework_get_option( 'header_cart_is_show_total_price_on_mobile', false ) : dahz_framework_get_option( 'header_cart_is_show_total_price', false );

		switch ( $cart_icon_display ) {

			case 'style-1':
				$cart_total_item = '<span class="de-cart__total-item de-cart__total-item--badge"></span>';
				break;
			case 'style-2':
				$cart_total_price = '<span class="de-cart__total-price de-cart__total-price--divider"></span>';
				break;
			case 'style-4':
				$cart_icon = '<span data-uk-icon="icon:df_cart-bag;ratio:%1$s;"></span>';
				$cart_total_price = '<span class="de-cart__total-price de-cart__total-price--divider"></span>';
				break;
			case 'style-5':
				$cart_total_item = '<span class="de-cart__total-item uk-badge uk-text-top"></span>';
				break;
			case 'style-6':
				$cart_icon = '<span data-uk-icon="icon:df_cart-trolley;ratio:%1$s;"></span>';
				$cart_total_item = '<span class="de-cart__total-item uk-badge uk-text-top"></span>';
				break;
			case 'style-7':
				$cart_icon = '<span data-uk-icon="icon:df_cart-bag;ratio:%1$s;"></span>';
				$cart_total_item = '<span class="de-cart__total-item uk-badge uk-text-top"></span>';
				break;
			default:
				$cart_icon = '<span data-uk-icon="icon:df_cart-trolley;ratio:%1$s;"></span>';
				$cart_total_price = '<span class="de-cart__total-price de-cart__total-price--divider"></span>';
				break;

		}

		if( $cart_icon_display == 'style-2' || $cart_icon_display == 'style-3' || $cart_icon_display == 'style-4' || $cart_icon_display == 'style-5' ){

			$cart_text = '<span>' . __( 'Cart', 'kitring' ) . '</span>';

		}

		if( !empty( $cart_icon ) ){

			$icon_ratio = $builder_type == 'mobile_elements' || $builder_type == 'headermobile' ? dahz_framework_get_option( 'header_cart_mobile_icon_ratio', '1' ) : dahz_framework_get_option( 'header_cart_desktop_icon_ratio', '1' );

			$cart_icon = sprintf(
				$cart_icon,
				(float)$icon_ratio
			);

		}

		if( !$is_show_price ){

			$cart_total_price = '';

		}

		if ( $cart_display == 'as-link' ) {

			$cart_url = esc_url( wc_get_cart_url() );

		} else {

			$cart_url = '#';

		}

		wp_enqueue_script( 'dahz-framework-header-cart' );

		dahz_framework_get_template(

			"header-cart.php",

			array(
				'cart_icon_display'	=> $cart_icon_display,
				'cart_display'		=> $cart_display,
				'header_layout'		=> $header_layout,
				'cart_url'			=> $cart_url,
				'cart_link_content'	=> sprintf(
					$cart_icon_display == 'style-2' || $cart_icon_display == 'style-3' || $cart_icon_display == 'style-4'
						?
						'
						%1$s%2$s%4$s%3$s
						'
						:
						'
						%1$s%2$s%3$s%4$s
						',
					$cart_icon,
					$cart_text,
					$cart_total_price,
					$cart_total_item
				),
				'header_section'	=> $section
			),

			'dahz-modules/header-cart/templates/'

		);

	}

	/**
	* dahz_framework_render_cart_container
	* render header element : cart container
	* @param $output
	* @return $output
	*/
	public function dahz_framework_render_cart_container() {

		global $dahz_framework;

		$mobile_header	= dahz_framework_get_option( 'mobile_header_mobile_menu_element', array() );

		$enable_cart_mobile = in_array( 'cart_mobile', $mobile_header );

		if ( isset( $dahz_framework->builder_items['cart'] ) || $enable_cart_mobile || isset( $dahz_framework->builder_items['cart_mobile'] ) ) {

			$cart_display = dahz_framework_get_option( 'header_cart_display_as', 'as-sidebar' );

			if( !$enable_cart_mobile && !isset( $dahz_framework->builder_items['cart_mobile'] ) && $cart_display !== 'as-sidebar' ) return;

			$desktop_icon_ratio = dahz_framework_get_option( 'header_cart_desktop_icon_ratio', '1' );

			$mobile_icon_ratio = dahz_framework_get_option( 'header_cart_mobile_icon_ratio', '1' );

			echo sprintf(
				'
				<div class="%3$s" id="header-cart-off-canvas" data-uk-offcanvas="overlay:true;mode:slide;flip:true;">
					<div class="uk-offcanvas-bar">
						<a href="#" class="uk-offcanvas-close uk-visible@m" data-uk-icon="icon:close;ratio:%1$s;"></a>
						<a href="#" class="uk-offcanvas-close uk-hidden@m" data-uk-icon="icon:close;ratio:%2$s;"></a>
						<div class="uk-width-1 de-header__mini-cart-container" data-mini-cart-content-style="off-canvas" data-mini-cart-is-loaded="false">
							<div class="uk-position-center" data-uk-spinner></div>
						</div>
					</div>
				</div>
				',
				(float)$desktop_icon_ratio,
				(float)$mobile_icon_ratio,
				( $enable_cart_mobile || isset( $dahz_framework->builder_items['cart_mobile'] ) ) && $cart_display !== 'as-sidebar' ? 'uk-hidden@m' : ''
			);

		}

	}

	/**
	* dahz_framework_header_button_cart
	* render custom button mini cart
	* @param -
	* @return -
	*/
	public function dahz_framework_header_button_cart( $content_block ) {

		echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="uk-button uk-margin-small de-mini-cart__button uk-width-1-1 wc-forward">' . esc_html__( 'View cart', 'kitring' ) . '</a>';
		echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="uk-button de-mini-cart__button uk-width-1-1 checkout wc-forward">' . esc_html__( 'Checkout', 'kitring' ) . '</a>';

	}

	/**
	* dahz_framework_header_remove_item_cart
	* replace default remove item cart
	* @param $remove_btn
	* @return $remove_btn
	*/
	public function dahz_framework_header_remove_item_cart( $remove_btn, $cart_item_key ) {

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			$remove_btn = sprintf( '<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
				esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
				esc_html__( 'Remove this item', 'kitring' ),
				esc_attr( $product_id ),
				esc_attr( $_product->get_sku() ),
				'<i data-uk-icon="close" class="delete-item"></i>'
			);

		}

		return $remove_btn;

	}

	/**
	* dahz_framework_header_cart_style
	* set header cart style from customizer
	* @param $dv_default_styles
	* @return $dv_default_styles
	*/
	public function dahz_framework_header_cart_style( $style ) {

		$desktop_icon_ratio = dahz_framework_get_option( 'header_cart_desktop_icon_ratio', '1' );

		$mobile_icon_ratio = dahz_framework_get_option( 'header_cart_mobile_icon_ratio', '1' );

		$style .= sprintf(
			'
			#header-cart-off-canvas .de-header__mini-cart-container{
				display: flex;
				flex-direction: column;
				justify-content: space-between;
				box-sizing: border-box;
				padding: 0;
				padding-top:%1$spx;
				height:100%%;

			}
			#header-cart-off-canvas .de-mini-cart__item-outer-container{
				overflow: auto;
				margin: 0;
			}
			#header-cart-off-canvas .de-mini-cart__item-container{
				padding: 0;
				margin: 0;
				max-height:none;
				margin-top: 40px;
			}
			#header-cart-off-canvas .de-mini-cart__item-action-container{
				margin: 0;
			    margin-top: auto;
			}
			@media( max-width:959px ){
				#header-cart-off-canvas .de-header__mini-cart-container{
					padding-top:%2$spx;
				}
			}
			.de-header__wrapper .de-header__mini-cart > a{
				font-size:%3$s;
			}
			.de-header-mobile__wrapper .de-header__mini-cart > a{
				font-size:%4$s;
			}
			#header-section1 .de-header__mini-cart .de-header__mini-cart-btn .de-cart__total-item.uk-badge:not(.de-btn):not(.uk-icon):not(svg):not(path),
			#header-section2 .de-header__mini-cart .de-header__mini-cart-btn .de-cart__total-item.uk-badge:not(.de-btn):not(.uk-icon):not(svg):not(path),
			#header-section3 .de-header__mini-cart .de-header__mini-cart-btn .de-cart__total-item.uk-badge:not(.de-btn):not(.uk-icon):not(svg):not(path){
				color:%5$s !important;
				background-color:%6$s !important;
			}
			.de-header__mini-cart .de-header__mini-cart-btn.de-header__mini-cart--empty .de-cart__total-item:not(.de-cart__total-item--badge),.de-header__mini-cart .de-header__mini-cart-btn.de-header__mini-cart--empty .de-cart__total-price{
				display:none;
			}
			.de-cart__total-item.de-cart__total-item--badge {
				display: flex;
				width: 30px;
				height: 30px;
				align-items: center;
				justify-content: center;
				border: 1px solid;
				margin-left: 8px;
				position: relative;
			}
			.de-cart__total-item.de-cart__total-item--badge::before {
				content: "";
				position: absolute;
				bottom: 100%%;
				left: 50%%;
				transform: translateX(-50%%);
				width: 20px;
				height: 10px;
				border: 1px solid;
				border-top-right-radius: 100em;
				border-top-left-radius: 100em;
			}
			#header-section1 .de-header__mini-cart .de-header__mini-cart-btn .de-cart__total-item.uk-badge:not(.de-btn):not(.uk-icon):not(svg):not(path),
			#header-section2 .de-header__mini-cart .de-header__mini-cart-btn .de-cart__total-item.uk-badge:not(.de-btn):not(.uk-icon):not(svg):not(path),
			#header-section3 .de-header__mini-cart .de-header__mini-cart-btn .de-cart__total-item.uk-badge:not(.de-btn):not(.uk-icon):not(svg):not(path){
				color:%5$s !important;
			}
			.de-header__mini-cart .de-header__mini-cart-btn span:not(:first-child){
				margin-left: 10px;
			}
			.de-header__mini-cart .de-header__mini-cart-btn.de-header__mini-cart--empty .de-cart__total-item.de-cart__total-item--badge{
				margin-left: 0;
			}
			.de-header__mini-cart .de-header__mini-cart-btn .de-cart__total-price--divider::before{
				content:"/";
				margin-right:10px;
			}
			',
			( ( (float)$desktop_icon_ratio * 20 ) + 10 ), # 1
			( ( (float)$mobile_icon_ratio * 20 ) + 10 ), # 2
			dahz_framework_get_option( 'header_cart_desktop_font_size', '18px' ),
			dahz_framework_get_option( 'header_cart_mobile_font_size', '18px' ),
			dahz_framework_get_option( 'header_cart_counter_color', '#ffffff' ),
			dahz_framework_get_option( 'header_cart_counter_bg_color', '#ff0000' )
		);

		return $style;

	}

}

new Dahz_Framework_Header_Cart();
