<?php

if ( !class_exists( 'Dahz_Framework_Init' ) ) {

	global $dahz_framework;

	Class Dahz_Framework_Init {

		private $include_path = '';

		private $framework_path = '';

		private $modules_path = '';

		public $available_modules = array();

		public $unavailable_modules = array();

		public $frontend_scripts = array();

		public function __construct() {

			global $dahz_framework;

			if ( function_exists( "__autoload" ) ) {

				spl_autoload_register( "__autoload" );

			}

			$dahz_framework->template_path = apply_filters( 'dahz_framework_template_path', 'dahz-framework/dahz-template/' );

			$dahz_framework->core_template_path = get_template_directory().'/dahz-framework/dahz-template/';

			spl_autoload_register( array( $this, 'dahz_framework_autoload' ) );

			$this->include_path = get_template_directory() . '/inc/';

			$this->framework_path = get_template_directory() . '/dahz-framework/';

			$this->modules_path = get_template_directory() . '/dahz-modules/';

			$this->dahz_framework_defines();

			$this->dahz_framework_includes();

			$this->dahz_framework_load_modules();

			$this->dahz_framework_initialize();

			$this->dahz_framework_admin_script();

		}

		private function dahz_framework_get_filename( $class ) {

			return 'class-' . str_replace( '_', '-', $class ) . '.php';

		}

		public function dahz_framework_get_class_directory( $class ) {

			$class_file = explode( '_', $class );

			$folder = '';

			if ( count( $class_file ) > 3 ) {

					switch( implode( '_', array( $class_file[0], $class_file[1], $class_file[2] ) ) ) {

						case "dahz_framework_modules":

							return $this->modules_path . implode( '_',array_slice($class_file, 3)) . '/';

							break;

						default:

							return false;

							break;

					}

			}

			return false;

		}

		public function dahz_framework_autoload( $class ) {

			$class = strtolower( $class );

			if ( 0 !== strpos( $class, 'dahz_framework_' ) ) {
				return;
			}

			$file = $this->dahz_framework_get_filename( $class );

			$directory = $this->dahz_framework_get_class_directory( $class );

			if ( $directory ) {

				$this->dahz_framework_load_file( $directory . $file );

			}

		}

		private function dahz_framework_load_file( $path, $args = array() ) {

			if ( $path && is_readable( $path ) ) {

				dahz_framework_include( $path, $args );

				return true;

			}

			return false;

		}

		private function dahz_framework_admin_script() {

			add_action( 'login_enqueue_scripts', array( $this, 'dahz_framework_enqueue_login_scripts' ), 10 );

		}

		public function dahz_framework_get_frontend_scripts() {

			return apply_filters(
				'dahz_framework_frontend_scripts',
				array(
					'slick'				=> array(
						'settings'		=> array( 'slick', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/slick.min.js' , array( 'jquery' ), null, true ),
						'enqueue'		=> false
					),
					'dahz'				=> array(
						'settings'		=> array( 'dahz-framework-script', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/dahz-framework.js', array( 'jquery', 'underscore' ), null, true ),
						'enqueue'		=> false
					),
					'sticky-sidebar'	=> array(
						'settings'		=> array( 'theia-script', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/theia-sticky-sidebar.min.js', array( 'jquery' ), null, true ),
						'enqueue'		=> false
					),
					'resize-sensor'		=> array(
						'settings'		=> array( 'resize-sensor', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/ResizeSensor.min.js', array( 'jquery' ), null, true ),
						'enqueue'		=> false
					),
					'isotope'			=> array(
						'settings'		=> array( 'isotope', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/isotope.pkgd.min.js', array( 'jquery' ), null, true ),
						'enqueue'		=> false
					),
					'lazyload'		=> array(
						'settings'		=> array( 'lazyload', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/jquery.lazyloadxt.min.js', array( 'jquery' ), null, true ),
						'enqueue'		=> false
					),
					'lazyload-srcset'		=> array(
						'settings'		=> array( 'lazyload-srcset', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/jquery.lazyloadxt.srcset.min.js', array( 'lazyload' ), null, true ),
						'enqueue'		=> false
					),
					'uikit'				=> array(
						'settings'		=> array( 'uikit', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/uikit.min.js', null, null, false ),
						'enqueue'		=> true
					),
					'uikit-icons'		=> array(
						'settings'		=> array( 'uikit-icons', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/uikit-icons.min.js', array( 'uikit' ), null, false ),
						'enqueue'		=> true
					),
					'zoom'				=> array(
						'settings'		=> array( 'jquery-zoom', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/jquery.zoom.min.js', array( 'jquery' ), null, true ),
						'enqueue'		=> false
					),
					'pagination'		=> array(
						'settings'		=> array( 'dahz-ajax-pagination', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/dahz-ajax-pagination.js', array( 'dahz-framework-script' ), null, true ),
						'enqueue'		=> false
					),
					'pace'		=> array(
						'settings'		=> array( 'pace', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/pace.min.js', array( 'jquery' ), null, false ),
						'enqueue'		=> false
					),
				)
			);

		}

		public function dahz_framework_get_frontend_styles() {

			return apply_filters(
				'dahz_framework_frontend_styles',
				array(
					'app'			=> array(
						'settings'	=> array( 'dahz-framework-app-style', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/css/app.min.css' ),
						'enqueue'	=> true
					),
				)
			);

		}

		private function dahz_framework_initialize() {

			add_action( 'after_setup_theme', array( $this, 'dahz_framework_setup' ), 15 );

			add_action( 'after_setup_theme', array( $this, 'dahz_framework_content_width' ), 10 );

			add_action( 'widgets_init', array( $this, 'dahz_framework_widgets_init' ), 1 );

			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_enqueue_scripts' ), 10 );

			add_action( 'admin_enqueue_scripts', array( $this, 'dahz_framework_enqueue_admin_scripts' ), 10 );

			add_action( 'wp_ajax_dahz_framework_get_lazyload_builder_item', array( $this, 'dahz_framework_get_lazyload_builder_item' ) );

			add_action( 'wp_ajax_nopriv_dahz_framework_get_lazyload_builder_item', array( $this, 'dahz_framework_get_lazyload_builder_item' ) );

			add_action( 'init', array( $this, 'dahz_framework_static_options' ), 10 );

			add_filter('body_class', array( $this, 'dahz_framework_dahz_body_class' ));

		}

		public function dahz_framework_static_options() {

			global $dahz_framework;

			$dahz_framework->static_options = array(
				'disabled_footer'								=> false,
				'global_wrapper_open_class'						=> '',
				'enable_sidebar'								=> true,
				'enable_sticky_sidebar'							=> false,
				'sidebar_class'									=> '',
				'sidebar_id'									=> 'sidebar-1',
				'pagination_column'								=> 'large-10 large-centered',
				'general_layout'								=> 'row',
				'global_wrapper_open_width'						=> '1-1',
				'sidebar_layout'								=> 'fullwidth',
				'content_class'									=> 'uk-width-1',
				'is_loop_product_shortcode'						=> false,
				'enable_loop_product_slider'					=> false,
				'loop_product_show_data_unit_sold'				=> false,
				'loop_product_desktop_column'					=> 1,
				'loop_product_gutter'							=> 'uk-grid-small',
				'loop_product_tablet_landscape_column'			=> 1,
				'loop_product_phone_potrait_column'				=> 1,
				'loop_product_phone_landscape_column'			=> 1,
				'loop_product_slider_show_slide_nav'			=> true,
				'loop_product_slider_slide_nav_position'		=> 'inside',
				'loop_product_slider_show_slide_nav_when_hover' => true,
				'loop_product_slider_slide_nav_breakpoint'		=> '@m',
				'loop_product_slider_show_dot_nav'				=> true,
				'loop_product_slider_dot_nav_breakpoint'		=> '@m',
				'loop_product_slider_auto_play_interval'		=> '',
				'loop_product_slider_enable_infinite'			=> true,
				'loop_product_slider_enable_slide'				=> true,
				'loop_product_slider_enable_center_active'		=> true,
				'loop_product_color_scheme'						=> '',
				'loop_product_class'							=> '',
				'enable_social_share'							=> true
			);

		}

		public function dahz_framework_get_lazyload_builder_item() {

			$data = $_POST;

			$item_id = $data['item_id'];

			$builder_type = $data['builder_type'];

			$section = $data['section'];

			$available_items = dahz_framework_get_builder_items( $builder_type );

			echo dahz_framework_render_builder_items( $available_items, $item_id, null, $section );

			die();

		}

		private function dahz_framework_includes() {

			global $dahz_framework;

			dahz_framework_include( $this->framework_path . 'dahz-framework-functions.php' );

			dahz_framework_include( $this->framework_path . 'dahz-framework-template-functions.php' );
			
			dahz_framework_include( $this->framework_path . 'class-dahz-framework-elements.php' );

			dahz_framework_include( $this->framework_path . 'admin/customizer/class-dahz-framework-customizer-init.php' );

			if ( $this->dahz_framework_request_type( 'admin' ) ) {

				dahz_framework_include( $this->framework_path . 'admin/class-dahz-framework-admin.php' );

			}

		}

		private function dahz_framework_load_modules() {

			global $dahz_framework, $dahz_framework_modules;

			$dahz_framework->available_modules = array();

			$dahz_framework->module = ( object ) array();

			do_action( 'dahz_framework_module_init', $this, $dahz_framework_modules );

			if ( !empty( $dahz_framework_modules ) ) {

				foreach( $dahz_framework_modules as $module_name => $module_option ) {

					$is_include = true;

					if ( is_array( $module_option ) && !empty( $module_option ) ) {

						if ( !empty( $module_option['class_dependencies'] ) ) {

							if ( !is_array( $module_option['class_dependencies'] ) && !empty( $module_option['class_dependencies'] ) ) {

								if ( !class_exists( $module_option['class_dependencies'] ) ) {

									$is_include = false;

								}

							} else {

								foreach( $module_option['class_dependencies'] as $class ) {

									if ( !class_exists( $class ) ) {

										$is_include = false;

										break;

									}

								}

							}

						}

					}

					if ( $is_include && $this->dahz_framework_load_file( $this->modules_path . $module_name . '/' . $module_name . '.php' ) ) {

						$this->available_modules[] = $module_name;

						do_action( "dahz_framework_module_{$module_name}_init", DAHZ_FRAMEWORK_MODULES_PATH . $module_name, DAHZ_FRAMEWORK_MODULES_URI . $module_name );

					} else {

						$this->unavailable_modules[] = $module_name;

					}

				}

				$dahz_framework->available_modules = $this->unavailable_modules;

			}

		}

		private function dahz_framework_defines() {

			define( 'DAHZ_FRAMEWORK_PATH', $this->framework_path );

			define( 'DAHZ_FRAMEWORK_THEME_URI', get_template_directory_uri() );

			define( 'DAHZ_FRAMEWORK_URI', DAHZ_FRAMEWORK_THEME_URI . '/dahz-framework/' );

			define( 'DAHZ_FRAMEWORK_MODULES_URI', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/' );

			define( 'DAHZ_FRAMEWORK_MODULES_PATH', $this->modules_path );

			define( 'DAHZ_FRAMEWORK_INCLUDE_PATH', $this->include_path );

			define( 'DAHZ_FRAMEWORK_DEVELOP_MODE', false );

		}

		public function dahz_framework_setup() {

			/*
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 * If you're building a theme based on dahz, use a find and replace
			 * to change 'dahz' to the name of your theme in all the template files.
			 */
			load_theme_textdomain( 'kitring', get_template_directory() . '/languages' );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support( 'title-tag' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			 */
			add_theme_support( 'post-thumbnails' );

			// This theme uses wp_nav_menu() in one location.
			register_nav_menus(
				array(
					'secondary_menu' => esc_html__( 'Secondary Menu', 'kitring' ),
				)
			);

			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );

			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );

			add_theme_support( 'woocommerce' );
			
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

		}

		public function dahz_framework_content_width() {

			$GLOBALS['content_width'] = apply_filters( 'dahz_framework_content_width', 640 );

		}

		public function dahz_framework_widgets_init() {

			$default_sidebar = apply_filters( 'dahz_framework_widgets', array ( 'default' =>

				array(

					'name'			=> esc_html__( 'Sidebar', 'kitring' ),
					'id'			=> 'sidebar-1',
					'description'	=> esc_html__( 'Add widgets here.', 'kitring' ),
					'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
					'after_widget'	=> '</div><hr class="de-sidebar__widget-separator uk-margin-medium" />',
					'before_title'	=> '<h6 class="widgettitle"><span>',
					'after_title'	=> '</span></h6>',

				)

			) );

			foreach( $default_sidebar as $sidebars => $sidebar ) {

				register_sidebar( $sidebar );

			}

		}

		private function dahz_framework_request_type( $type ) {

			switch( $type ) {

				case 'admin':
					return is_admin() && !is_customize_preview();
					break;

				case 'frontend':
					return ( !is_admin() || defined( 'DOING_AJAX' ) );
					break;

				case 'ajax':
					return defined( 'DOING_AJAX' );
					break;

				case 'customizer':
					return is_customize_preview();
					break;

			}

		}

		public function dahz_framework_enqueue_login_scripts() {

			wp_enqueue_style(	'dahz-framework-login', DAHZ_FRAMEWORK_THEME_URI . '/dahz-framework/admin/assets/css/dahz-admin.css', '1.0.0' );

		}

		public function dahz_framework_enqueue_admin_scripts() {

			wp_enqueue_style(	'dahz-framework-admin'		 , DAHZ_FRAMEWORK_THEME_URI . '/dahz-framework/admin/assets/css/dahz-admin.css', '1.0.0' );

			if ( is_customize_preview() ) return;

			wp_enqueue_style(	'dahz-framework-vc-template', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/css/dahz-vc-template.css' );

			wp_enqueue_style(	'flexdatalist'	 , DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/css/jquery.flexdatalist.css' );

			wp_enqueue_script(	'flexdatalist'	 , DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/jquery.flexdatalist.min.js', array( 'jquery' ), null, true );

			wp_enqueue_script(	'uikit'	 , DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/uikit.min.js', array( 'jquery' ), null, true );

			wp_enqueue_style(	'uikit', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/css/plugins/uikit.min.css' );

		}

		public function dahz_framework_enqueue_scripts() {

			$scripts = $this->dahz_framework_get_frontend_scripts();

			$styles = $this->dahz_framework_get_frontend_styles();

			foreach( $scripts as $key => $script ) {

				call_user_func_array( empty( $script['enqueue'] ) ? 'wp_register_script' : 'wp_enqueue_script', $script['settings'] );

			}

			foreach( $styles as $key => $style ) {

				call_user_func_array( empty( $style['enqueue'] ) ? 'wp_register_style' : 'wp_enqueue_style', $style['settings'] );

			}

			wp_localize_script(
				'dahz-framework-script',
				'dahzFramework',
				apply_filters(
					'dahz_framework_localize',
					array(
						'ajaxURL' 				=> admin_url( 'admin-ajax.php' ),
						'unavailableModules'	=> $this->unavailable_modules,
						'language'				=> array(
							'emptyMessage'		=> esc_html__( 'We can&rsquo;t find anything', 'kitring' )
						)
					)

				)
			);
			
			wp_enqueue_script( 'imagesloaded' );
			
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

				wp_enqueue_script( 'comment-reply' );

			}

		}

		public function dahz_framework_dahz_body_class($classes) {
			
			$bodyClass = '';
			
			if ( is_singular() ) {
				$bodyClass = 'ds-single';
			} elseif ( is_archive() ) {
				$bodyClass = 'ds-archive';
			} elseif ( is_home() ) {
				$bodyClass = 'ds-blog';
			} elseif ( is_front_page() ) {
				$bodyClass = 'ds-frontpage';
			}

			$id = get_current_blog_id();
			$slug = strtolower(str_replace(' ', '-', trim(get_bloginfo('name'))));
			$classes[] = $slug;
			$classes[] = $bodyClass;
			return $classes;

		}

	}

	new Dahz_Framework_Init();

}
