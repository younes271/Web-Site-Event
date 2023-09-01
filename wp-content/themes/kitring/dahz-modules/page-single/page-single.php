<?php

if ( !class_exists( 'Dahz_Framework_Single_Page' ) ) {

	class Dahz_Framework_Single_Page {

		function __construct() {

			if ( is_admin() && !is_customize_preview() ) dahz_framework_include( get_template_directory() . '/dahz-modules/page-single/class-dahz-framework-metabox-page.php' );

			add_filter( 'dahz_framework_attributes_main_container_args', array( $this, 'dahz_framework_attributes_main_container_args' ) );
			
			add_filter( 'dahz_framework_attributes_main_args', array( $this, 'dahz_framework_attributes_main_args' ) );
			
			add_filter( 'dahz_framework_primary_menu_id', array( $this, 'dahz_framework_overrided_menu' ) );

			add_action( 'dahz_framework_scroller_default_page', array( $this, 'dahz_framework_scroller_default_page_metabox' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_page_style' ) );

		}
		
		public function dahz_framework_attributes_main_container_args( $args ){
			
			if( ! is_singular( 'page' ) ) { return $args; }
			
			global $post;
			
			$content = $post->post_content;
			
			$enable_sidebar = dahz_framework_get_static_option( 'enable_sidebar' );
			
			if ( ( strpos( $content, '[vc_row' ) !== false || strpos( $content, '[vc_section' ) !== false ) && ! $enable_sidebar ){
				
				$args['class'] = array( 'de-main-container' );
				
			}
			
			return $args;
			
		}
		
		public function dahz_framework_attributes_main_args( $args ){
			
			if( ! is_singular( 'page' ) ) { return $args; }
			
			$remove_padding_top = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'remove_default_padding_top', 'off' );
			
			$remove_padding_bottom = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'remove_default_padding_bottom', 'off' );
			
			if( $remove_padding_top == 'on' ){
				$args['class'][] = 'uk-padding-remove-top';
			}
			
			if( $remove_padding_bottom == 'on' ){
				$args['class'][] = 'uk-padding-remove-bottom';
			}
			
			return $args;
			
		}

		public function dahz_framework_overrided_menu( $override_menu ) {

			if ( is_singular( 'page' ) ) {

				$override_menu_meta = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'overide_main_menu', '' );

				$override_menu = $override_menu_meta !== 'inherit' ? $override_menu_meta : $override_menu;

			} else if ( is_home() && !is_front_page() ) {

				$page_id = get_option( 'page_for_posts' );

				$override_menu_meta = dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'overide_main_menu', '' );

				$override_menu = $override_menu_meta !== 'inherit' ? $override_menu_meta : $override_menu;

			}

			return $override_menu;

		}

		public function dahz_framework_scroller_default_page_metabox() {

			$scroller_is_enabled = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'page_section_scroller', 'off' );

			if ( $scroller_is_enabled === 'on' ) {

				$scroller_type = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'page_scroller_type', 'disable' );

				$tooltip_type = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'page_scroller_tooltip_type', 'disabled' );

				$tooltip_type_class = ' de-scroller--tooltip--' . $tooltip_type;

				switch ($scroller_type) {
					case 'dots':
						echo '<ul class="de-scroller ds-scroller de-scroller--dots ds-scroller--dots ' . $tooltip_type_class . '"></ul>';
						break;
					case 'line':
						echo '<ul class="de-scroller ds-scroller de-scroller--line ds-scroller--line ' . $tooltip_type_class . '"></ul>';
						break;
					case 'block':
						echo '<ul class="de-scroller ds-scroller de-scroller--block ds-scroller--block ' . $tooltip_type_class . '"></ul>';
						break;
					case 'disable':
						echo '<ul class="de-scroller ds-scroller"></ul>';
						break;
				}

			}

		}

		public function dahz_framework_page_style( $dv_default_styles ) {

			$header_remove_sticky_shadow = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'remove_shadow_sticky', 'off' );

			if ( $header_remove_sticky_shadow === 'on' ) {

				$dv_default_styles .= "

					#de-header-horizontal.site-header--is-sticky {
						box-shadow: none;
					}

				";
			}

			$main_accent_color = dahz_framework_get_option(
				"color_general_main_accent_color_regular",
				array(
					'regular'	=> '#333333',
					'hover'		=> '#999999'
				)
			);

			$divider_color = dahz_framework_get_option( 'color_general_divider_color', '#000000' );

			$main_accent_color_regular = !empty( $main_accent_color['regular'] ) ? $main_accent_color['regular'] : '#333333';

			$main_accent_color_hover = !empty( $main_accent_color['hover'] ) ? $main_accent_color['hover'] : '#999999';

			$dv_default_styles .= sprintf(
				'
				.de-page .de-social-share__list a {
					color: %1$s;
				}
				.de-page .de-social-share__list a:hover {
					color: %2$s;
				}
				.de-page .entry-social {
					border-color: %3$s;
				}
				',
				$main_accent_color_regular, # 1
				$main_accent_color_hover, # 2
				$divider_color # 3
			);

			return $dv_default_styles;

		}

	}

	new Dahz_Framework_Single_Page();

}
