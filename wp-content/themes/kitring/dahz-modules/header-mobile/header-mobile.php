<?php

if( !class_exists( 'Dahz_Framework_Header_Mobile' ) ){


	Class Dahz_Framework_Header_Mobile {

	    public function __construct(){

			add_action( 'dahz_framework_module_header-mobile_init', array( $this, 'dahz_framework_header_mobile_init' ) );

            add_filter( 'dahz_framework_customize_headermobile_builder_items', array( $this, 'dahz_framework_header_lists' ) );

			add_filter( 'dahz_framework_header_mobile_elements', array( $this, 'dahz_framework_header_mobile_elements' ) );

			add_filter( 'dahz_framework_default_styles'	, array( $this, 'dahz_framework_mobile_element_style' ) );

			add_action( 'wp_update_nav_menu', array($this, 'dahz_framework_update_menu_transient'), 10 );

			add_action( 'wp_footer', array( $this, 'dahz_framework_render_mobile_menu_container' ), 10 );

			add_action( 'wp_ajax_dahz_framework_render_mobile_menu_elements', array( $this, 'dahz_framework_render_mobile_menu_elements' ), 10 );

			add_action( 'wp_ajax_nopriv_dahz_framework_render_mobile_menu_elements', array( $this, 'dahz_framework_render_mobile_menu_elements' ), 10 );


		}

		public function dahz_framework_header_mobile_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-mobile-customizer.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Mobile_Customizer',
				array(
					'id'	=> 'mobile_header',
					'title'	=> array( 'title' => esc_html__( 'Mobile Element', 'kitring' ), 'priority' => 16 ),
					'panel'	=> 'header'
				),
				array()
			);

		}

		public function dahz_framework_update_menu_transient( $menu_id ){

			delete_transient( 'dahz_framework_secondary_menu_mobile' );

		}

		public function dahz_framework_header_mobile_elements( $items ) {

			$items['mobile_menu_content_block'] = array(
				'title'				=> esc_html__( 'Content Block', 'kitring' ),
				'description'		=> esc_html__( 'Display content block on menu mobile', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_render_mobile_menu_content_block' ),
				'section_callback'	=> 'mobile_header',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);

			$items['secondary_menu'] = array(
				'title'				=> esc_html__( 'Secondary Menu', 'kitring' ),
				'description'		=> esc_html__( 'Secondary Menu Description', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_render_mobile_secondary_menu' ),
				'section_callback'	=> 'menu_locations',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);

			$items['separator_1'] = array(
				'title'				=> esc_html__( 'Separator 1', 'kitring' ),
				'description'		=> esc_html__( 'Separator 1', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_separator' ),
				'section_callback'	=> 'mobile_header',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);

			$items['separator_2'] = array(
				'title'				=> esc_html__( 'Separator 2', 'kitring' ),
				'description'		=> esc_html__( 'Separator 2', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_separator' ),
				'section_callback'	=> 'mobile_header',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);

			$items['separator_3'] = array(
				'title'				=> esc_html__( 'Separator 3', 'kitring' ),
				'description'		=> esc_html__( 'Separator 3', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_separator' ),
				'section_callback'	=> 'mobile_header',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);

			$items['separator_4'] = array(
				'title'				=> esc_html__( 'Separator 4', 'kitring' ),
				'description'		=> esc_html__( 'Separator 4', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_separator' ),
				'section_callback'	=> 'mobile_header',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);

			$items['separator_5'] = array(
				'title'				=> esc_html__( 'Separator 5', 'kitring' ),
				'description'		=> esc_html__( 'Separator 5', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_separator' ),
				'section_callback'	=> 'mobile_header',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);

			$items['separator_6'] = array(
				'title'				=> esc_html__( 'Separator 6', 'kitring' ),
				'description'		=> esc_html__( 'Separator 6', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_separator' ),
				'section_callback'	=> 'mobile_header',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);

			$items['site_copyright'] = array(
				'title'				=> esc_html__( 'Site Copyright', 'kitring' ),
				'description'		=> esc_html__( 'Display copyright info', 'kitring' ),
				'render_callback'	=> 'dahz_framework_footer_site_copyright',
				'section_callback'	=> 'footer_element',
				'is_repeatable'		=> false
			);

			return 	$items;

		}

        public function dahz_framework_header_lists( $items ){

            $items['mobile_header_element'] = array(
				'title'				=> esc_html__( 'Mobile Element', 'kitring' ),
				'description'		=> esc_html__( 'Display burger menu', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_header_mobile_get_elements' ),
				'section_callback'	=> 'mobile_header',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);

      		return $items;
    	}

		public function dahz_framework_render_mobile_secondary_menu(){

			if ( !has_nav_menu( 'secondary_menu' ) )return;

			$nav_is_uppercase = dahz_framework_get_option( 'header_navigation_size_is_uppercase_nav', false );

			switch( $nav_is_uppercase ) {
				case true:
					$nav_is_uppercase = ' is-uppercase';
					break;

				case false:
					$nav_is_uppercase = ' normal';
					break;

				default:
					$nav_is_uppercase = ' normal';
					break;
			}

			dahz_framework_include( get_template_directory() . '/dahz-modules/header-mobile/secondary_menu_mobile_walker.php' );

			$megamenu_walker = new Dahz_Framework_Secondary_Menu_Mobile_Walker();

			$params_topbar = array(
				'theme_location'=> 'secondary_menu',
				'container'		=> '',
				'walker'		=> $megamenu_walker,
				'fallback_cb'	=> true,
				'items_wrap'	=> '<ul class="de-mobile-nav de-mobile-secondary__nav uk-nav-default" data-uk-nav="multiple:false;">%3$s</ul>',
				'echo'			=> false
			);

			$dahz_secondary_menu = wp_nav_menu( $params_topbar );


			echo apply_filters( 'dahz_framework_mobile_secondary_menu', $dahz_secondary_menu );

		}

		public function dahz_framework_mobile_element_style( $default_styles ){

			$uppercase_style = 'text-transform:uppercase;';

			$default_styles .= sprintf(
				'
				.de-header-mobile__item .de-header__site-branding .de-header__logo-media a img{
					height: %1$s;
				}
				.header-mobile-menu__elements hr.header-mobile-menu__elements--separator{
					border-top-color:%2$s;
				}
				.de-header-mobile__item .de-header__site-branding .de-header__logo-media{
					padding: %3$spx 0 %4$spx 0;
				}
				.header-mobile-menu__elements ul.de-mobile-primary__nav > li > a{
					font-size:%5$s;
					%6$s
				}
				.header-mobile-menu__elements ul.de-mobile-primary__nav ul.sub-menu > li.uk-parent > a{
					font-size:%12$s;
					%13$s
				}
				.de-header__section ul.sub-menu > li > a,
				.header-mobile-menu__elements ul.de-mobile-secondary__nav > li > a{
					font-size:%7$s;
					%8$s
				}
				.header-mobile-menu__elements .de-footer__site-info p{
					font-size:%7$s;
				}
				.header-mobile-menu__container *{
					color:%9$s!important;
				}
				.header-mobile-menu__container{
					background-color:%11$s;
				}
				.header-mobile-menu__container a:hover{
					color:%10$s!important;
				}
				',
				dahz_framework_get_option( 'mobile_header_logo_height', '30px' ),
				dahz_framework_get_option( 'mobile_header_divider_color', '#d4d2d2' ),
				(int)dahz_framework_get_option( 'mobile_header_logo_padding_top', '10' ),
				(int)dahz_framework_get_option( 'mobile_header_logo_padding_bottom', '10' ),
				dahz_framework_get_option( 'mobile_header_primary_menu_font_size', '14px' ),
				dahz_framework_get_option( 'mobile_header_enable_primary_menu_uppercase', true ) ? $uppercase_style : '',
				dahz_framework_get_option( 'mobile_header_dropdown_menu_font_size', '14px' ),
				dahz_framework_get_option( 'mobile_header_enable_dropdown_uppercase', false ) ? $uppercase_style : '',
				dahz_framework_get_option( 'mobile_header_color', '#000000' ),
				dahz_framework_get_option( 'mobile_header_hover_color', '#ffffff' ),
				dahz_framework_get_option( 'mobile_header_background_color', '#ffffff' ),
				dahz_framework_get_option( 'mobile_header_megamenu_title_font_size', '14px' ),
				dahz_framework_get_option( 'mobile_header_enable_megamenu_title_uppercase', true ) ? $uppercase_style : ''
			);

			return $default_styles;
		}

		public function dahz_framework_header_mobile_get_elements(){

			$mobile_icon_ratio = dahz_framework_get_option( 'mobile_header_icon_ratio', '1' );

			echo sprintf(
				'
				<a aria-label="%2$s" href="#" class="uk-hidden@m" data-uk-icon="icon:df_mobile-menu;ratio:%1$s;" data-uk-toggle="target: #header-mobile-menu"></a>
				',
				(float)$mobile_icon_ratio,
				__( 'Mobile Menu Button Open', 'kitring' )
			);

		}

		public function dahz_framework_render_mobile_menu_container() {

			global $dahz_framework;

			if ( isset( $dahz_framework->builder_items['mobile_header_element'] ) ) {

				$mobile_icon_ratio = dahz_framework_get_option( 'mobile_header_icon_ratio', '1' );

				$flip_right = dahz_framework_get_option( 'mobile_header_off_canvas_right', true );

				$is_uppercase = dahz_framework_get_option( 'mobile_header_enable_uppercase', false );

				$mobile_header_menu_style = dahz_framework_get_option( 'mobile_header_menu_style', 'off-canvas' );

				echo sprintf(

					$mobile_header_menu_style == 'off-canvas'
						?
					'
					<div class="uk-hidden@m%4$s" id="header-mobile-menu" data-uk-offcanvas="overlay: true;mode: %1$s;flip: %2$s;">
						<div class="uk-offcanvas-bar header-mobile-menu__container">
							<a aria-label="%5$s" href="#" class="uk-offcanvas-close" data-uk-icon="icon:close;ratio:%3$s;"></a>
							<div class="header-mobile-menu__container--content" data-mobile-menu-is-loaded="false">
							</div>
						</div>
					</div>
					'
						:
					'<div class="uk-hidden@m uk-modal-full%4$s" id="header-mobile-menu" data-uk-modal>
						<div class="uk-modal-dialog header-mobile-menu__container">
							<a aria-label="%5$s" href="#" class="uk-modal-close-full" data-uk-icon="icon:close;ratio:%3$s;"></a>
							<div class="uk-padding uk-width-1 header-mobile-menu__container--content" data-mobile-menu-is-loaded="false">
							</div>
						</div>
					</div>
					'
					,
					esc_attr( dahz_framework_get_option( 'mobile_header_off_canvas_animation', 'slide' ) ),
					$flip_right ? esc_attr( 'true' ) : esc_attr( 'false' ),
					(float)$mobile_icon_ratio,
					$is_uppercase ? ' uk-text-uppercase' : '',
					__( 'Mobile Menu Button Close', 'kitring' )
				);

			}

		}

		public function dahz_framework_render_mobile_menu_elements() {

			$mobile_header	= dahz_framework_get_option( 'mobile_header_mobile_menu_element', array() );

			$available_items = apply_filters( 'dahz_framework_header_mobile_elements', array() );

			$elements = '';

			if( is_array( $mobile_header ) && !empty( $mobile_header ) ){

				foreach ( $mobile_header as $key => $value ) {

					$elements .= sprintf(
						'
						<div class="uk-margin header-mobile-menu__elements">%s</div>
						',
						dahz_framework_render_builder_items( $available_items, $value, 'mobile_elements' )
					);
				}

			}

			echo apply_filters( 'dahz_framework_render_mobile_menu_elements', $elements, $mobile_header, $available_items );

			wp_die();

		}

		public function dahz_framework_separator() {
			echo '<hr class="header-mobile-menu__elements--separator">';
		}

		public function dahz_framework_render_mobile_menu_content_block(){

			$content_block = dahz_framework_get_option( 'mobile_header_content_block' );

			echo dahz_framework_do_content_block( apply_filters( 'dahz_framework_override_mobile_menu_content_block', $content_block ) );

		}


	}

  new Dahz_Framework_Header_Mobile();

}
