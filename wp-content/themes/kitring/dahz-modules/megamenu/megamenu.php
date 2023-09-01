<?php
if( !class_exists('Dahz_Framework_Megamenu') ){


	Class Dahz_Framework_Megamenu {

		public $id   = '';

		public $path = '';

		public $uri  = '';

		public $mega_menu_meta = array();

		public $typo_style = '';

		function __construct(){

			add_filter( 'dahz_framework_default_styles'	, array( $this, 'dahz_framework_header_megamenu_style' ), 20, 1 );

			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'dahz_framework_custom_nav_menu_parameter' ), 10, 2 );

			add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_megamenu_builder' ) );

			add_filter( 'dahz_framework_header_item_class', array( $this, 'dahz_framework_add_header_item_class' ) );

			add_filter( 'dahz_framework_header_mobile_elements', array( $this, 'dahz_framework_megamenu_mobile_builder' ) );

			add_action( 'admin_enqueue_scripts', array( $this,'dahz_framework_megamenu_admin_script' ), 10 );

			add_action( 'dahz_framework_module_megamenu_init', array( $this, 'dahz_framework_megamenu_init' ), 1, 2 );

			add_action( 'after_setup_theme', array( $this, 'dahz_framework_setup_megamenu' ), 10 );

			add_action( 'wp_ajax_dahz_framework_get_lazy_menu', array( $this, 'dahz_framework_get_lazy_menu' ) );

			add_action( 'wp_ajax_nopriv_dahz_framework_get_lazy_menu', array( $this, 'dahz_framework_get_lazy_menu' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_megamenu_script' ), 10 );

		}

		public function dahz_framework_get_lazy_menu(){

			$menu = isset( $_POST['menu'] ) ? $_POST['menu'] : '';
			
			$header_section = isset( $_POST['header_section'] ) ? $_POST['header_section'] : '1';

			dahz_framework_include( $this->path . '/megamenu_front/megamenu_front.php' );

			$params_topbar = array(
				'theme_location'=> 'primary_menu',
				'container'		=> '',
				'menu_class'	=> 'uk-navbar-nav',
				'walker'		=> new Dahz_Framework_Woo_Front_Mega_Menu( false, $header_section ),
				'fallback_cb'	=> true,
				'items_wrap'	=> '<ul ' . dahz_framework_set_attributes(
					array(
						'class' 				=> array( 'uk-navbar-nav uk-flex uk-flex-wrap' ),
						'data-menu'				=> $menu,
						'data-megamenu-loaded'	=> 'true'
					),
					'primary_menu_container',
					array(),
					false
				) . '>%3$s</ul>',
				'echo'			=> false
			);
			

			if( !empty( $menu ) ){

				$params_topbar['menu'] = $menu;

			}

			$dahz_primary_menu = wp_nav_menu( $params_topbar );

			echo sprintf( '<div>%1$s</div>', $dahz_primary_menu );

			die();

		}

		public function dahz_framework_setup_megamenu(){

			register_nav_menus(
				array(
					'primary_menu' => 'Primary Menu'
				)
			);

		}

		public function dahz_framework_megamenu_init( $path, $uri ){

			$this->path = $path;

			$this->uri = $uri;

			if( is_admin() && !is_customize_preview() ){

				dahz_framework_include( $path . '/megamenu_admin/class-dahz-framework-megamenu-admin.php' );

			}

		}

		/**
		* dahz_framework_custom_nav_menu_parameter
		* @param $walker, $menu_id
		* @return $walker || 'Dahz_Framework_Megamenu_Admin'
		*/
		function dahz_framework_custom_nav_menu_parameter( $walker, $menu_id ){

			$menu_locations = get_nav_menu_locations();

			if( isset( $menu_locations['primary_menu'] ) ){

				$primary_nav_obj = get_term( $menu_locations['primary_menu'], 'nav_menu' );

				if( !is_wp_error( $primary_nav_obj ) && !empty( $primary_nav_obj ) && $primary_nav_obj->term_id == $menu_id ){

					dahz_framework_include( $this->path . '/megamenu_admin/class-dahz-framework-megamenu-admin-walker.php' );

					$walker = 'Dahz_Framework_Megamenu_Admin_Walker';

				}

			}

			return $walker;
		}

		/**
		* dahz_framework_megamenu_admin_script
		* @param $hook
		* @return void
		*/
		function dahz_framework_megamenu_admin_script( $hook ){

			wp_register_script( 'dahz-framework-autocomplete-script', $this->uri . '/assets/js/jquery.flexdatalist.min.js');

			wp_register_style( 'flexdatalist', $this->uri .'/assets/css/jquery.flexdatalist.css' );

			if( $hook == 'nav-menus.php' ){

				wp_enqueue_style( 'flexdatalist' );

				wp_register_script( 'dahz-framework-megamenu-admin', $this->uri . '/assets/js/dahz-framework-megamenu-admin.min.js');

				$localize_array = array();

				$localize_array = array(
					'templateUrl'				=> get_template_directory_uri(),
					'product_category_list'		=> array(),//$product_category_list,
					'product_brand_list'		=> array(),//$product_brand_list,
					'post_category_list'		=> array(),//$post_category_list
				);

				wp_localize_script( 'dahz-framework-megamenu-admin', 'dfCommerceMegaMenu', $localize_array );

				wp_enqueue_script( 'dahz-framework-megamenu-admin' );

				wp_enqueue_media();

				wp_enqueue_script( 'media-lib-uploader-js' );

				wp_enqueue_script( 'dahz-framework-autocomplete-script' );

			}

		}

		public function dahz_framework_megamenu_script() {

			wp_register_script( 'dahz-framework-megamenu', $this->uri . '/assets/js/dahz-framework-megamenu.min.js', array( 'dahz-framework-script' ), null, true );

		}

		/**
		* dahz_framework_megamenu_builder
		* @param
		* @return $items
		*/
		public function dahz_framework_megamenu_builder( $items ){

			$items['mega_menu'] = array(
				'title'				=> esc_html__( 'Primary Menu', 'kitring' ),
				'description'		=> esc_html__( 'Display megamenu', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_render_megamenu' ),
				'section_callback'	=> 'menu_locations',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false,
			);

			return $items;

		}

		public function dahz_framework_megamenu_mobile_builder( $items ){

			$items['mega_menu_mobile'] = array(
				'title'				=> esc_html__( 'Primary Menu', 'kitring' ),
				'description'		=> esc_html__( 'Display megamenu', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_render_mobile_megamenu' ),
				'section_callback'	=> 'menu_locations',
				'is_repeatable'		=> false,
				'is_lazyload'		=> !is_customize_preview() ? true : false,
			);

			return $items;

		}

		public function dahz_framework_render_mobile_megamenu(){

			if ( !has_nav_menu( 'primary_menu' ) ) return;
			
			$overrided_menu = apply_filters( 'dahz_framework_primary_menu_id', '' );

			$nav_is_uppercase = dahz_framework_get_option( 'header_navigation_size_is_uppercase_nav', false );

			switch( $nav_is_uppercase ) {
				case true:
					$nav_is_uppercase .= ' is-uppercase';
					break;

				case false:
					$nav_is_uppercase .= ' normal';
					break;

				default:
					$nav_is_uppercase .= ' normal';
					break;
			}

			dahz_framework_include( $this->path . '/megamenu_front/megamenu_front_mobile.php' );

			$megamenu_walker = new Dahz_Framework_Woo_Front_Mega_Menu_Mobile();

			$params_topbar = array(
				'theme_location'=> 'primary_menu',
				'container'		=> '',
				'menu_class'	=> 'de-primary-menu--modified de-primary-menu__mobile' . $nav_is_uppercase,
				'walker'		=> $megamenu_walker,
				'fallback_cb'	=> true,
				'items_wrap'	=> '<ul id="%1$s" class="de-mobile-nav de-mobile-primary__nav uk-nav-default uk-nav-parent-icon" data-uk-nav="multiple:false;">%3$s</ul>',
				'echo'			=> false,
			);

			if( !empty( $overrided_menu ) ){

				$params_topbar['menu'] = $overrided_menu;

			}

			$dahz_primary_menu = wp_nav_menu( $params_topbar );

			echo apply_filters( 'dahz_framework_mobile_mega_menu', $dahz_primary_menu );

		}

		/**
		* dahz_framework_render_megamenu
		* @param
		* @return $items
		*/
		public function dahz_framework_render_megamenu( $builder_type, $section, $row, $column ){

			if ( !has_nav_menu( 'primary_menu' ) ) return;

			$header_type  = dahz_framework_get_option( 'logo_and_site_identity_header_style', 'horizontal' );

			$overrided_menu = apply_filters( 'dahz_framework_primary_menu_id', '' );

			if( ( $header_type == 'vertical' || $header_type == 'hide' ) && ( $section == '2' || $section == '3' ) ){

				$dahz_primary_menu = get_transient( "dahz_framework_primary_menu_vertical_{$overrided_menu}" );

				if( false === $dahz_primary_menu ){

					$params_topbar = array(
						'theme_location'=> 'primary_menu',
						'container'		=> '',
						'menu_class'	=> 'de-primary-menu de-primary-menu--vertical',
						'fallback_cb'	=> true,
						'items_wrap'	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'echo'			=> false
					);

					if( !empty( $overrided_menu ) ){

						$params_topbar['menu'] = $overrided_menu;

						$menu_overrides = get_option( 'dahz_framework_primary_menu_overrides', array() );

						if( !in_array( $overrided_menu, $menu_overrides  ) ){

							$menu_overrides[] = $overrided_menu;

							update_option( 'dahz_framework_primary_menu_overrides', $menu_overrides, 'no' );

						}

					}

					$dahz_primary_menu = wp_nav_menu( $params_topbar );

					set_transient( "dahz_framework_primary_menu_vertical_{$overrided_menu}", $dahz_primary_menu, MONTH_IN_SECONDS );

				}



			} else {
				
				// wp_enqueue_script( 'dahz-framework-megamenu' );
				
				// $params_topbar = array(
					// 'theme_location'=> 'primary_menu',
					// 'container'		=> '',
					// 'menu_class'	=> 'uk-navbar-nav',
					// 'depth'			=> 1,
					// 'fallback_cb'	=> true,
					// 'items_wrap'	=> '<ul ' . dahz_framework_set_attributes(
						// array(
							// 'class' 				=> array( 'uk-navbar-nav uk-flex uk-flex-wrap' ),
							// 'data-header-section'	=> $section,
							// 'data-menu'				=> $overrided_menu,
							// 'data-megamenu-loaded'	=> 'false'
						// ),
						// 'primary_menu_container',
						// array(),
						// false
					// ) . '>%3$s</ul>',
					// 'echo'			=> false
				// );
					
				// if( !empty( $overrided_menu ) ){

					// $params_topbar['menu'] = $overrided_menu;

				// }

				// $dahz_primary_menu = wp_nav_menu( $params_topbar );
				
				dahz_framework_include( $this->path . '/megamenu_front/megamenu_front.php' );

				$params_topbar = array(
					'theme_location'=> 'primary_menu',
					'container'		=> '',
					'menu_class'	=> 'uk-child-width-auto',
					'walker'		=> new Dahz_Framework_Woo_Front_Mega_Menu( false, $section ),
					'fallback_cb'	=> true,
					'items_wrap'	=> '<ul ' . dahz_framework_set_attributes(
						array(
							'class' 				=> array( 'uk-flex uk-flex-wrap uk-flex-middle uk-grid-medium' ),
							'data-uk-grid'			=> ''
						),
						'primary_menu_container',
						array(),
						false
					) . '>%3$s</ul>',
					'echo'			=> false
				);
				

				if( !empty( $overrided_menu ) ){

					$params_topbar['menu'] = $overrided_menu;

				}

				$dahz_primary_menu = wp_nav_menu( $params_topbar );

			}
			
			echo sprintf( 
				'<div %2$s>
					%1$s
				</div>
				' ,
				$dahz_primary_menu,
				dahz_framework_set_attributes(
					array(
						'class' 			=> array( 'primary-menu' ),
						//'data-uk-grid'	=> 'delay-hide:100;'
					),
					'primary_menu_wrapper',
					array(),
					false
				)
			);

		}

		public function dahz_framework_add_header_item_class(){

			global $dahz_framework;

			$nav_class = '';

			$nav_hover_style = dahz_framework_get_option( 'header_navigation_size_hover_style', 'style-2' );

			$nav_is_uppercase = dahz_framework_get_option( 'header_navigation_size_is_uppercase_nav', false );

			switch( $nav_hover_style ) {
				case 'style-1':
					$nav_class .= 'hover-1';
					break;

				case 'style-2':
					$nav_class .= 'hover-2';
					break;

				default:
					$nav_class .= 'hover-2';
					break;
			}

			switch( $nav_is_uppercase ) {
				case true:
					$nav_class .= ' is-uppercase';
					break;

				case false:
					$nav_class .= ' normal';
					break;

				default:
					$nav_class .= ' normal';
					break;
			}

			return $nav_class;

		}

		static function dahz_framework_woo_get_taxonomy( $terms, $taxonomy ){

			$terms_selected = array();

			foreach( $terms as $selected ){

				if( $selected !== '' ){

					$get_term = get_term_by( 'id', $selected, $taxonomy );

					if( $get_term ){

						$terms_selected[] = $get_term;

					}

				}

			}

			return $terms_selected;

		}

		/**
		* dahz_framework_woo_get_query
		* @param $atts = array()
		* @return $query
		*/
		static function dahz_framework_woo_get_query( $atts = array() ){

			$orderby         = isset($atts['orderby']) && !empty($atts['orderby']) ? $atts['orderby'] : 'date';
			$order           = isset($atts['order']) && !empty($atts['order']) ? $atts['order'] : 'DESC';
			$post_per_page   = isset($atts['post_per_page']) && !empty($atts['post_per_page']) ? $atts['post_per_page'] : -1;
			$filter          = isset($atts['filter']) && !empty($atts['filter']) ? $atts['filter'] : '';
			$taxonomy        = isset($atts['taxonomy']) && !empty($atts['taxonomy']) ? $atts['taxonomy'] : false;
			$post__in        = !empty($atts['post__in']) ? is_array($atts['post__in']) ? $atts['post__in'] : array() : array();
			$terms           = !empty($atts['terms']) ? is_array($atts['terms']) ? $atts['terms'] : array() : array();
			$relation        = !empty($atts['relation']) ? $atts['relation'] : 'or';
			$isSKU           = !empty($atts['isSKU']) ? $atts['isSKU'] : false;
			$args            = array();
			$args['orderby'] = $orderby;
			$args['order']   = $order;

			isset($atts['keyword']) && !empty($atts['keyword']) ? $args['s'] = $atts['keyword'] : false;

			$keyword = !empty($atts['keyword'])? $atts['keyword'] : '';

			if(!empty($filter)){
				$args['meta_query'] = array('relation' => $relation );
				switch($filter){
					case 'sale_products':
						$args['meta_query'] = WC()->query->get_meta_query();
						$args['post__in']   = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
						break;
					case 'new_product':
						$args['meta_query'][] = array(
													'key' => 'de_product_New',
													'value' => 'on',
													'compare' => '='
												);
						break;
					case 'featured_product':
						$args['meta_query'][] = array(
													'key' => '_featured',
													'value' => 'yes',
													'compare' => '='
												);
						break;
					case 'top_rated':
						$args['meta_query'][] = array(
													'key' => '_wc_average_rating',
													'value' => 0,
													'compare' => '>='
												);
						$args['meta_key'] = '_wc_average_rating';
						$args['orderby']  = 'meta_value_num';
						break;
					case 'best_sellers':
						$args['meta_key'] = 'total_sales';
						$args['orderby']  = 'meta_value_num';
						$args['meta_query'][] = array(
													'key' 		=> '_visibility',
													'value' 	=> array( 'catalog', 'visible' ),
													'compare' 	=> 'IN'
												);
						break;
					case 'latest_product':
						$args['meta_query'] = WC()->query->get_meta_query();
						break;
				}
			}

			if($taxonomy){
				if(!empty($terms[0])){
					$args['tax_query']   = array();
					$args['tax_query'][] = array(
												'taxonomy'	=> $taxonomy,
												'field'		=> 'term_id',
												'terms'		=> $terms,
												'operator' 	=> 'IN'
											);

				}
			}

			if(!empty($post__in)){
				if(is_array($post__in)){
					$args['post__in'] = $post__in;
				} else {
					$args['post'] = $post__in;
				}
			}
			if($isSKU){
				if(isset($args['s'])){
					unset($args['s']);
				}
				$args['meta_query'][] = array(
					'key' 		=> '_sku',
					'value' 	=> "{$keyword}",
					'compare' 	=> 'LIKE'
				);
			}
			$args['post_type'] = !empty($atts['post_type']) ? $atts['post_type'] : 'post';
			$args['post_status'] = 'publish';
			$args['ignore_sticky_posts'] = 1;
			$args['posts_per_page'] = $post_per_page;
			$query = new WP_Query( $args );
			return $query;
		}

		/**
		* dahz_framework_header_megamenu_style
		* set header megamenu style from customizer
		* @param $dv_default_styles
		* @return $dv_default_styles
		*/
		public function dahz_framework_header_megamenu_style( $dv_default_styles ) {

			$dv_layout_site_width = dahz_framework_get_option( 'layout_site_width', '1200px' );

			$dv_header_dropdown_color_hover = dahz_framework_get_option( 'header_dropdown_color_hover', '#999' );

			$dv_default_styles .= sprintf(
				'
				#masthead .de-header .de-primary-menu .sub-menu li.de-mega-menu__item > a:hover {
					color: %1$s;
				}'
				,
				$dv_header_dropdown_color_hover
			);

			# SETTING FOR MOBILE DISPLAY

			$dv_default_styles .= sprintf(
				'
				.de-header__mobile-menu--elements,
				.de-header__mobile-menu--elements *,
				.de-header__mobile-element  {
					background-color: %1$s;
					color: %2$s!important;
				}
				.de-header__mobile-element a.de-dropdown__parent-link,
				.de-header-mobile__item .de-primary-menu--modified .megamenu__item,
				.de-header__mobile-element .de-social-accounts,
				.de-header__mobile-element .de-header__search,
				.de-header__mobile-element .de-header__wishlist,
				.de-header__mobile-element .menu-toggle.de-header-mobile__menu,
				.de-header__mobile-element .de-account-content__wrapper,
				.de-header-mobile__item .megamenu__container .megamenu__parent .megamenu__item,
				.de-header-mobile__item .de-header__main-navigation .megamenu__item,
				.de-header-mobile__item .de-primary-menu--modified .megamenu__item,
				.de-header-mobile__item .de-header__main-navigation.megamenu__container .megamenu__item {
					border-bottom: 1px solid %3$s;
				}
				.de-header-mobile__item .megamenu__container .megamenu__parent .opened > .megamenu__item,
				.de-header-mobile__item .megamenu__container .megamenu__parent.opened > .megamenu__item {
					border-bottom: none;
				}
				.de-header__mobile-element .de-separator {
					background-color: %3$s;
				}
				',
				dahz_framework_get_option( 'mobile_header_background_color', '#fff' ),
				dahz_framework_get_option( 'mobile_header_color_normal', '#000' ),
				dahz_framework_get_option( 'mobile_header_color_border_and_separator', '#F8F8F8' )

			);

			return $dv_default_styles . $this->typo_style;

		}

	}

	new Dahz_Framework_Megamenu();

}
