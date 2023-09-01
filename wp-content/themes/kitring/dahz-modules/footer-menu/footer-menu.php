<?php

if( !class_exists( 'Dahz_Framework_Footer_Menu' ) ){

	Class Dahz_Framework_Footer_Menu {

		public function __construct(){

			add_filter( 'dahz_framework_customize_footer_builder_items', array( $this, 'dahz_framework_footer_menu_builder' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_footer_menu_style' ) );

			add_action( 'after_setup_theme', array( $this, 'dahz_framework_setup_footer_menu' ), 20 );

			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'dahz_framework_custom_nav_menu_parameter' ), 10, 2 );

			if( is_admin() && !is_customize_preview() ){

				dahz_framework_include( get_template_directory() . '/dahz-modules/footer-menu/class-dahz-framework-footer-menu-admin.php' );

			}

			add_action( 'wp_update_nav_menu', array($this, 'dahz_framework_update_menu_transient'), 10 );

		}

		public function dahz_framework_update_menu_transient( $menu_id ){

			delete_transient( 'dahz_framework_footer_menu' );

		}

		/**
		* dahz_framework_custom_nav_menu_parameter
		* @param $walker, $menu_id
		* @return $walker || 'Dahz_Framework_Megamenu_Admin'
		*/
		function dahz_framework_custom_nav_menu_parameter( $walker, $menu_id ){

			$menu_locations = get_nav_menu_locations();

			if( isset( $menu_locations['footer_menu'] ) ){

				$primary_nav_obj = get_term( $menu_locations['footer_menu'], 'nav_menu' );

				if( !is_wp_error( $primary_nav_obj ) && $primary_nav_obj->term_id == $menu_id ){

					dahz_framework_include( get_template_directory() . '/dahz-modules/footer-menu/class-dahz-framework-footer-menu-admin-walker.php' );

					$walker = 'Dahz_Framework_Footer_Menu_Admin_Walker';

				}

			}

			return $walker;

		}

		public function dahz_framework_setup_footer_menu(){

			register_nav_menus(
				array(
					'footer_menu' => esc_html__( 'Footer Menu', 'kitring' )
				)
			);

		}

		public function dahz_framework_footer_menu_builder( $items ){

			$items['footer_menu'] = array(
				'title'				=> esc_html__( 'Footer Menu', 'kitring' ),
				'description'		=> esc_html__( 'Display footer menu', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_render_footer_menu' ),
				'section_callback'	=> 'menu_locations',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false,
			);

			return $items;

		}

		public function dahz_framework_render_footer_menu(){

			if ( !has_nav_menu( 'footer_menu' ) ) return;


			dahz_framework_include( get_template_directory() . '/dahz-modules/footer-menu/footer_menu_walker.php' );

			$footer_menu_hover = dahz_framework_get_option( 'footer_element_menu_hover_style', 'style-2' );

			$params_topbar = array(
				'theme_location'=> 'footer_menu',
				'container'		=> '',
				'menu_class'	=> 'de-footer-menu de-footer-menu--' . $footer_menu_hover,
				'depth'			=> 1,
				'fallback_cb'	=> true,
				'echo'			=> false,
				'items_wrap'	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

			$overrided_menu = apply_filters( 'dahz_framework_footer_menu_id', 0 );

			if( dahz_framework_get_option( 'footer_element_enable_only_level_0', false ) ) {

				$params_topbar['menu_class'] .= ' de-footer-menu--0-enabled';

			}

			$dahz_footer_menu = wp_nav_menu( $params_topbar );

			echo apply_filters( 'dahz_framework_footer_menu_html', $dahz_footer_menu );

		}

		/**
		* dahz_framework_footer_menu_style
		* set header search style from customizer
		* @param $dv_default_styles
		* @return $dv_default_styles
		*/
		public function dahz_framework_footer_menu_style( $dv_default_styles ) {

			global $dahz_framework;

			$footer_parent_font_size = dahz_framework_get_option( 'footer_element_menu_parent_font_size', '12' );

			$footer_child_font_size  = dahz_framework_get_option( 'footer_element_menu_child_font_size', '12' );

			$footer_section1_bghover = !empty( $dahz_framework->mods['footer_section1_section_color']['hover'] ) ? $dahz_framework->mods['footer_section1_section_color']['hover'] : '#999';

			$footer_section2_bghover = !empty( $dahz_framework->mods['footer_section2_section_color']['hover'] ) ? $dahz_framework->mods['footer_section2_section_color']['hover'] : '#999';

			$footer_section3_bghover = !empty( $dahz_framework->mods['footer_section3_section_color']['hover'] ) ? $dahz_framework->mods['footer_section3_section_color']['hover'] : '#999';

			$dv_default_styles .= sprintf(
									'
									.de-footer-menu .menu-item-depth-0 > a {
										font-size: %1$spx;
									}
									.de-footer-menu .menu-item-depth-1 > a {
										font-size: %2$spx;
									}
									',
									$footer_parent_font_size,
									$footer_child_font_size
								);

			$dv_default_styles .= sprintf(
									'
									#footer-section1 .de-footer-menu--style-2 a::after {
										background-color: %1$s;
									}
									#footer-section2 .de-footer-menu--style-2 a::after {
										background-color: %2$s;
									}
									#footer-section3 .de-footer-menu--style-2 a::after {
										background-color: %3$s;
									}
									',
									$footer_section1_bghover,
									$footer_section2_bghover,
									$footer_section3_bghover
								);

			return $dv_default_styles;

		}

	}

	new Dahz_Framework_Footer_Menu();

}
