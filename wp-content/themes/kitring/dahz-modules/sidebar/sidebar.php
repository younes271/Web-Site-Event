<?php

if ( !class_exists( 'Dahz_Framework_Sidebar' ) ) {

	Class Dahz_Framework_Sidebar {

		public function __construct() {

			add_action( 'dahz_framework_before_default_styles', array( $this, 'dahz_framework_render_sidebar' ), 1 );

			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_sidebar_enqueue_scripts' ), 9 );

		}

		public function dahz_framework_sidebar_enqueue_scripts() {

			wp_register_script( 'dahz-framework-sidebar', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/sidebar/assets/js/dahz-framework-sidebar.min.js', array( 'dahz-framework-script','theia-script' ), null, true );

		}

		public function dahz_framework_render_sidebar() {

			$is_shop = class_exists( 'Woocommerce' ) ? is_shop() : false;

			$is_product = class_exists( 'Woocommerce' ) ? is_product() : false;

			$is_product_category = class_exists( 'Woocommerce' ) ? is_product_category() : false;

			$is_product_brand = class_exists( 'Woocommerce' ) ? is_tax( 'brand' ) : false;

			$is_product_tag = class_exists( 'Woocommerce' ) ? is_product_tag() : false;
			
			$sidebar_options = array();

			if ( ( is_page() && ! $is_shop ) || ( is_home() && ! is_front_page() ) ) {

				$page_id = is_home() && !is_front_page() ? get_option( 'page_for_posts' ) : get_the_ID();

				$sidebar_meta = dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'layout', 'fullwidth' );

				$sidebar_layout = $sidebar_meta !== 'inherit' ? $sidebar_meta : dahz_framework_get_option( 'page_layout', 'fullwidth' );

				$sidebar_options['sidebar_layout'] = $sidebar_layout;

			} else if ( is_singular( 'post' ) ) {

				$sidebar_meta = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'single_sidebar_position', 'inherit' );

				$sidebar_layout = $sidebar_meta !== 'inherit' ? $sidebar_meta : dahz_framework_get_option( 'blog_single_sidebar', 'sidebar-right' );

				$sidebar_options['sidebar_layout'] = $sidebar_layout;

			} else if ( ( is_archive() && !$is_shop && !$is_product_category && !$is_product_tag && !$is_product_brand && !is_home() && !is_post_type_archive( 'portfolio' ) ) || ( is_search() ) ) {

				$sidebar_layout = dahz_framework_get_option( 'blog_archive_layout_sidebar', 'sidebar-right' );

				$sidebar_options['sidebar_layout'] = $sidebar_layout;

			} else if ( $is_shop || $is_product_category || $is_product_tag || $is_product_brand ) {

				$sidebar = dahz_framework_get_option( 'shop_woo_filter_sidebar_area', true );

				$sidebar_position = dahz_framework_get_option( 'shop_woo_sidebar_position', 'left' );

				$sidebar_layout = ! $sidebar ? 'fullwidth' : 'sidebar-' . $sidebar_position;

				$sidebar_options['sidebar_layout'] = $sidebar_layout;
				
				$sidebar_options['sidebar_id'] = 'shop-sidebar-1';

			} else if ( $is_product ) {

				$sidebar_layout = dahz_framework_get_option( 'woo_single_product_sidebar_layout', 'fullwidth' );
				
				$sidebar_options['sidebar_layout'] = $sidebar_layout;
				
				$sidebar_options['sidebar_id'] = 'shop-sidebar-1';

			} else if( is_home() && is_front_page() ){

				$sidebar_layout = dahz_framework_get_option( 'blog_template_sidebar', 'sidebar-right' );

				$sidebar_options['sidebar_layout'] = $sidebar_layout;

			}  else {

				$sidebar_options['sidebar_layout'] = 'fullwidth';

			}
			
			$this->dahz_framework_register_sidebar( $sidebar_options );

		}

		public function dahz_framework_register_sidebar( $args = array() ) {

			$override_static_option = array();
			
			$args = wp_parse_args( 
				$args,
				array(
					'sidebar_layout'	=> 'fullwidth',
					'sidebar_id'		=> 'sidebar-1',
					'class'				=> '',
					'is_sticky'			=> true,
				)
			);

			if ( !is_active_sidebar( $args['sidebar_id'] ) ) {

				$args['sidebar_layout'] = 'fullwidth';

			}

			$override_static_option['sidebar_layout'] = $args['sidebar_layout'];

			switch( $args['sidebar_layout'] ) {

				case 'fullwidth':
					$override_static_option['enable_sidebar'] = false;
					break;

				case 'sidebar-left':
					if ( dahz_framework_get_option( 'global_enable_sticky_sidebar', true ) && $args['is_sticky'] ) {
						$override_static_option['enable_sticky_sidebar'] = true;
					}
					$override_static_option['enable_sidebar'] = true;
					$override_static_option['sidebar_id'] = $args['sidebar_id'];
					$override_static_option['sidebar_class'] = 'uk-flex-first@m';
					break;

				case 'sidebar-right':
					if ( dahz_framework_get_option( 'global_enable_sticky_sidebar', true ) && $args['is_sticky'] ) {
						$override_static_option['enable_sticky_sidebar'] = true;
					}
					$override_static_option['enable_sidebar'] = true;
					$override_static_option['sidebar_id'] = $args['sidebar_id'];
					break;

				default:
					$override_static_option['enable_sidebar'] = false;
					break;

			}

			dahz_framework_override_static_option( $override_static_option );

		}

	}

	new Dahz_Framework_Sidebar();

}
