<?php

if ( !class_exists( 'Dahz_Framework_Header_Myaccount' ) ) {

	Class Dahz_Framework_Header_Myaccount {

		public $content_block = false;

		function __construct() {

			add_action( 'dahz_framework_module_header-myaccount_init', array( $this, 'dahz_framework_header_myaccount_init' ) );

			add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_header_myaccount_builder' ) );

			add_filter( 'dahz_framework_customize_headermobile_builder_items', array( $this, 'dahz_framework_header_mobile_myaccount_builder' ) );

			add_filter( 'dahz_framework_header_mobile_elements', array( $this, 'dahz_framework_header_mobile_menu_myaccount_builder' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_header_myaccount_style' ), 1000  );

			add_action( 'dahz_framework_woo_before_login', array( $this, 'dahz_framework_render_content_block' ) );

			add_action( 'wp_ajax_dahz_framework_header_lazy_myaccount', array( $this, 'dahz_framework_header_lazy_myaccount' ), 10 );

			add_action( 'wp_ajax_nopriv_dahz_framework_header_lazy_myaccount', array( $this, 'dahz_framework_header_lazy_myaccount' ), 10 );

			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_header_myaccount_script' ), 20 );

			add_action( 'wp_footer', array( $this, 'dahz_framework_render_myaccount_popup' ), 10 );

		}

		public function dahz_framework_header_myaccount_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-myaccount-customizer.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Myaccount_Customizer',
				array(
					'id'	=> 'header_myaccount',
					'title'	=> array( 'title' => esc_html__( 'My Account', 'kitring' ), 'priority' => 12 ),
					'panel'	=> 'header'
				),
				array()
			);

		}

		public function dahz_framework_header_myaccount_script() {

			wp_register_script( 'dahz-framework-header-myaccount', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/header-myaccount/assets/js/dahz-framework-header-myaccount.min.js', array( 'dahz-framework-script' ), null, true );

		}

		public function dahz_framework_header_lazy_myaccount() {

			$myaccount_content_style = isset( $_POST['data']['myaccount_content_style'] ) ? $_POST['data']['myaccount_content_style'] : 'as-dropdown' ;

			$enable_default_woo_account = dahz_framework_get_option( 'header_myaccount_enable_woo_account', true );

			$myaccount_register = dahz_framework_get_option( 'header_myaccount_show_login_register', true );

			$uniqid = uniqid();

			dahz_framework_get_template(
				"{$myaccount_content_style}.php",
				array(
					'is_signed_in'					=> is_user_logged_in(),
					'myaccount_content_style'		=> $myaccount_content_style,
					'myaccount_register'			=> $myaccount_register,
					'enable_default_woo_account'	=> $enable_default_woo_account,
					'uniqid'						=> $uniqid
				),
				'dahz-modules/header-myaccount/templates/'
			);
			die();

		}

		public function dahz_framework_render_content_block() {

			if ( $this->content_block ) {

				echo do_shortcode( $this->content_block->post_content );

			}

		}

		public function dahz_framework_header_myaccount_style( $styles ) {

			$styles .= sprintf('

				.de-header__wrapper .de-account-content__wrapper > a{
					font-size: %1$s;
				}
				.de-header-mobile__wrapper .de-account-content__wrapper > a{
					font-size: %2$s;
				}
				',
				dahz_framework_get_option( 'header_myaccount_desktop_font_size', '18px' ),
				dahz_framework_get_option( 'header_myaccount_mobile_font_size', '18px' )
			);

			return $styles;


		}

		/**
		* dahz_framework_header_myaccount_builder
		* @param
		* @return $items
		*/
		public function dahz_framework_header_myaccount_builder( $items ) {

			$items['my_account'] = array(
				'title'				=> esc_html__( 'My Account', 'kitring' ),
				'description'		=> esc_html__( 'Woo account menu', 'kitring' ),
				'render_callback'	=> array( 'Dahz_Framework_Header_Myaccount', 'dahz_framework_render_header_myaccount' ),
				'section_callback'	=> 'header_myaccount',
				'is_repeatable'		=> false
			);

			return $items;

		}
		public function dahz_framework_header_mobile_myaccount_builder( $items ) {

			$items['my_account_headermobile'] = array(
				'title'				=> esc_html__( 'My Account', 'kitring' ),
				'description'		=> esc_html__( 'Woo account menu', 'kitring' ),
				'render_callback'	=> array( 'Dahz_Framework_Header_Myaccount', 'dahz_framework_render_header_myaccount' ),
				'section_callback'	=> 'header_myaccount',
				'is_repeatable'		=> false
			);

			return $items;

		}
		/**
		* dahz_framework_header_myaccount_builder
		* @param
		* @return $items
		*/
		public function dahz_framework_header_mobile_menu_myaccount_builder( $items ) {

			$items['my_account_mobile'] = array(
				'title'				=> esc_html__( 'My Account', 'kitring' ),
				'description'		=> esc_html__( 'Woo account menu', 'kitring' ),
				'render_callback'	=> array( 'Dahz_Framework_Header_Myaccount', 'dahz_framework_render_header_myaccount' ),
				'section_callback'	=> 'header_myaccount',
				'is_repeatable'		=> false
			);

			return $items;

		}

		/**
		* dahz_framework_render_header_myaccount
		* @param
		* @return $content
		*/
		static function dahz_framework_render_header_myaccount( $builder_type, $section, $row, $column ) {

			global $dahz_framework, $current_user;

			$myaccount_link_style = dahz_framework_get_option( 'header_myaccount_style', 'icon_text' );

			$myaccount_icon = dahz_framework_get_option( 'header_myaccount_custom_icon', '' );

			$myaccount_text = dahz_framework_get_option( 'header_myaccount_custom_text' );

			$is_uppercase = dahz_framework_get_option( 'header_myaccount_enable_uppercase', false );

			$myaccount_register = dahz_framework_get_option( 'header_myaccount_show_login_register', false );

			$myaccount_content_style = dahz_framework_get_option( 'header_myaccount_login_style', 'as-dropdown' );

			$account_link = 'my-account-link.php';

			if( $builder_type == 'mobile_elements' && is_user_logged_in() ){

				$myaccount_content_style = 'as-dropdown-mobile';

				$account_link = 'my-account-link-mobile.php';

			} else if( $builder_type == 'header' && is_user_logged_in() && $myaccount_content_style == 'as-popup' ){

				$myaccount_content_style = 'as-dropdown';

			} else if( $builder_type == 'headermobile' && is_user_logged_in() ){

				$myaccount_content_style = 'as-link';

			} else if( ( $builder_type == 'headermobile' || $builder_type == 'mobile_elements' ) && $myaccount_content_style == 'as-dropdown' && !is_user_logged_in() ){

				$myaccount_content_style = 'as-popup';

			}
			$enable_default_woo_account = dahz_framework_get_option( 'header_myaccount_enable_woo_account', false );

			$uniqid = uniqid();

			$is_lazy_myaccount = true;

			$class = dahz_framework_get_option( 'header_myaccount_enable_uppercase', false ) ? 'uk-text-uppercase' : '';

			switch( $myaccount_content_style ) {
				case 'as-link':
					$class .= ' de-account-content-link';
					$is_lazy_myaccount = false;
					break;
				case 'as-dropdown':
					$class .= ' de-dropdown__parent-link closed ds-account-content de-account-content--hover';
					break;
				case 'as-popup':
					$class .= ' ds-account-content--popup';
					break;
			}

			$nav_text = '';

			$icon = '';

			if( $myaccount_link_style == 'text' || $myaccount_link_style == 'icon_text' || $myaccount_link_style == 'text_icon' ){

				if( is_user_logged_in() ){

					$nav_text = sprintf( __( 'Hi, %1$s', 'kitring' ), $current_user->user_login );

				} else {

					$nav_text = $myaccount_register && get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ? __( 'Login / Register', 'kitring' ) : __( 'Login', 'kitring' );

				}

			}

			if( $myaccount_link_style == 'icon' || $myaccount_link_style == 'icon_text' || $myaccount_link_style == 'text_icon' ){

				$icon_ratio = $builder_type !== 'mobile_elements' && $builder_type !== 'headermobile' ? dahz_framework_get_option( 'header_myaccount_desktop_icon_ratio', '1' ) : dahz_framework_get_option( 'header_myaccount_mobile_icon_ratio', '1' );

				$icon = sprintf(
					'<span data-uk-icon="icon:df_my-account;ratio:%1$s;"%2$s></span>',
					$icon_ratio,
					$myaccount_link_style !== 'icon' ? $myaccount_link_style !== 'icon_text' ? ' class="uk-margin-small-left"' : ' class="uk-margin-small-right"' : ''
				);

			}

			$nav_text = $myaccount_link_style == 'icon_text' ? $icon . $nav_text : $nav_text . $icon;

			if ( $myaccount_content_style !== 'as-link' ) {

				wp_enqueue_script( 'dahz-framework-header-myaccount' );

			}

			dahz_framework_get_template(
				$account_link,
				array(
					'nav_text'					=> $nav_text,
					'is_signed_in'				=> is_user_logged_in(),
					'myaccount_content_style'	=> $myaccount_content_style,
					'class'						=> $class,
					'is_lazy_myaccount'			=> $is_lazy_myaccount,
					'header_section'			=> $section
				),
				'dahz-modules/header-myaccount/templates/'
			);

		}

		public function dahz_framework_render_myaccount_popup() {

			global $dahz_framework;
			// dahz_framework_debug
			$mobile_header	= dahz_framework_get_option( 'mobile_header_mobile_menu_element', array() );

			$enable_myaccount_mobile = in_array( 'my_account_mobile', $mobile_header );

			if ( isset( $dahz_framework->builder_items['my_account'] ) || $enable_myaccount_mobile || isset( $dahz_framework->builder_items['my_account_headermobile'] ) ) {

				$myaccount_content_style = dahz_framework_get_option( 'header_myaccount_login_style', 'as-dropdown' );

				if( ( $enable_myaccount_mobile && !isset( $dahz_framework->builder_items['my_account_headermobile'] ) ) || is_user_logged_in() || $myaccount_content_style == 'as-link' ) return;

				echo sprintf(
					'
					<div data-myaccount-style="as-popup" id="header-my-account-modal" class="uk-modal-full" data-uk-modal>
						<div class="uk-modal-dialog">
							<button class="uk-modal-close-full uk-close-large" type="button" data-uk-close></button>
							<div class="uk-padding-large uk-flex uk-flex-middle" data-uk-height-viewport>
								<div data-header-my-account-is-loaded="false" class="header-myaccount__modal-content--container uk-width-1-3@m uk-width-1-2@s uk-margin-auto">
								</div>
							</div>
						</div>
					</div>
					'
				);

			}

		}

	}

	new Dahz_Framework_Header_Myaccount();

}
