<?php

/**
 * Vamtam Theme Framework base class
 *
 * @author Nikolay Yordanov <me@nyordanov.com>
 * @package vamtam/coiffure
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * This is the first loaded framework file
 *
 * VamtamFramework does the following ( in this order ):
 *  - sets constants for the frequently used paths
 *  - loads translations
 *  - loads the plugins bundled with the theme
 *  - loads some functions and helpers used in various places
 *  - sets the custom post types
 *  - if this is wp-admin, load admin files
 *
 * This class also loads the custom widgets and sets what the theme supports ( + custom menus )
 */

class VamtamFramework {

	/**
	 * Cache the result of some operations in memory
	 *
	 * @var array
	 */
	private static $cache = array();

	/**
	 * Post types with double sidebars
	 */
	public static $complex_layout = array( 'page', 'post', 'product' );

	/**
	 * Initialize the Vamtam framework
	 * @param array $options framework options
	 */
	public function __construct( $options ) {
		// Autoload classes on demand
		if ( function_exists( '__autoload' ) )
			spl_autoload_register( '__autoload' );
		spl_autoload_register( array( $this, 'autoload' ) );

		self::$complex_layout = apply_filters( 'vamtam_complex_layout', self::$complex_layout );

		$this->set_constants( $options );
		$this->load_languages();
		$this->load_functions();
		$this->load_admin();

		require_once VAMTAM_DIR . 'classes/class-tgm-plugin-activation.php';
		require_once VAMTAM_SAMPLES_DIR . 'dependencies.php';

		add_action( 'after_setup_theme', array( __CLASS__, 'theme_supports' ) );
		add_action( 'widgets_init', array( __CLASS__, 'widgets_init' ) );
		add_filter( 'vamtam_purchase_code', array( __CLASS__, 'get_purchase_code' ) );
		add_filter( 'wpv_purchase_code', array( __CLASS__, 'get_purchase_code' ) );

		VamtamElementorBridge::get_instance();
	}

	/**
	 * Autoload classes when needed
	 *
	 * @param  string $class class name
	 */
	public function autoload( $class ) {
		$class = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', str_replace( '_', '', $class ) ) );

		if ( strpos( $class, 'vamtam-' ) === 0 ) {
			$path = trailingslashit( get_template_directory() ) . 'vamtam/classes/';
			$file = str_replace( 'vamtam-', '', $class ) . '.php';

			if ( is_readable( $path . $file ) ) {
				include_once( $path . $file );
				return;
			}

			if ( is_admin() ) {
				$admin_path = VAMTAM_ADMIN_DIR . 'classes/';

				if ( is_readable( $admin_path . $file ) ) {
					include_once( $admin_path . $file );
					return;
				}
			}
		}

	}

	/**
	 * Sets self::$cache[ $key ] = $value
	 *
	 * @param mixed $key
	 * @param mixed $value
	 */
	public static function set( $key, $value ) {
		self::$cache[ $key ] = $value;
	}

	/**
	 * Returns self::$cache[ $key ]
	 *
	 * @param  mixed $key
	 * @return mixed        value
	 */
	public static function get( $key, $default = false ) {
		return isset( self::$cache[ $key ] ) ? self::$cache[ $key ] : $default;
	}

	/**
	 * Get the theme version
	 *
	 * @return string theme version as defined in style.css
	 */
	public static function get_version() {
		if ( isset( self::$cache['version'] ) )
			return self::$cache['version'];

		$the_theme = wp_get_theme();
		if ( $the_theme->parent() ) {
			$the_theme = $the_theme->parent();
		}

		self::$cache['version'] = $the_theme->get( 'Version' );

		return self::$cache['version'];
	}

	/**
	 * Defines constants used by the theme
	 *
	 * @param array $options framework options
	 */
	private function set_constants( $options ) {
		define( 'VAMTAM_THEME_NAME', $options['name'] );
		define( 'VAMTAM_THEME_SLUG', $options['slug'] );
		define( 'VAMTAM_THUMBNAIL_PREFIX', 'vamtam-' );

		// theme dir and uri
		define( 'VAMTAM_THEME_DIR', get_template_directory() . '/' );
		define( 'VAMTAM_THEME_URI', get_template_directory_uri() . '/' );

		// framework dir and uri
		define( 'VAMTAM_DIR', VAMTAM_THEME_DIR . 'vamtam/' );
		define( 'VAMTAM_URI', VAMTAM_THEME_URI . 'vamtam/' );

		// common assets dir and uri
		define( 'VAMTAM_ASSETS_DIR', VAMTAM_DIR . 'assets/' );
		define( 'VAMTAM_ASSETS_URI', VAMTAM_URI . 'assets/' );

		// common file paths
		define( 'VAMTAM_FONTS_URI',  VAMTAM_ASSETS_URI . 'fonts/' );
		define( 'VAMTAM_HELPERS',    VAMTAM_DIR . 'helpers/' );
		define( 'VAMTAM_JS',         VAMTAM_ASSETS_URI . 'js/' );
		define( 'VAMTAM_OPTIONS',    VAMTAM_DIR . 'options/' );
		define( 'VAMTAM_PLUGINS',    VAMTAM_DIR . 'plugins/' );
		define( 'VAMTAM_CSS',        VAMTAM_ASSETS_URI . 'css/' );
		define( 'VAMTAM_CSS_DIR',    VAMTAM_ASSETS_DIR . 'css/' );
		define( 'VAMTAM_FB_CSS_DIR', VAMTAM_ASSETS_DIR . 'css/src/fallback/' );
		define( 'VAMTAM_IMAGES',     VAMTAM_ASSETS_URI . 'images/' );
		define( 'VAMTAM_IMAGES_DIR', VAMTAM_ASSETS_DIR . 'images/' );

		// sample content
		define( 'VAMTAM_SAMPLES_DIR',   VAMTAM_THEME_DIR . 'samples/' );
		define( 'VAMTAM_SAMPLES_URI',   VAMTAM_THEME_URI . 'samples/' );

		// cache
		define( 'VAMTAM_CACHE_DIR', VAMTAM_THEME_DIR . 'cache/' );
		define( 'VAMTAM_CACHE_URI', VAMTAM_THEME_URI . 'cache/' );

		// admin
		define( 'VAMTAM_ADMIN_DIR', VAMTAM_DIR . 'admin/' );
		define( 'VAMTAM_ADMIN_URI', VAMTAM_URI . 'admin/' );

		define( 'VAMTAM_ADMIN_AJAX',       VAMTAM_ADMIN_URI . 'ajax/' );
		define( 'VAMTAM_ADMIN_AJAX_DIR',   VAMTAM_ADMIN_DIR . 'ajax/' );
		define( 'VAMTAM_ADMIN_ASSETS_URI', VAMTAM_ADMIN_URI . 'assets/' );
		define( 'VAMTAM_ADMIN_HELPERS',    VAMTAM_ADMIN_DIR . 'helpers/' );
		define( 'VAMTAM_ADMIN_METABOXES',  VAMTAM_ADMIN_DIR . 'metaboxes/' );
		define( 'VAMTAM_ADMIN_TEMPLATES',  VAMTAM_ADMIN_DIR . 'templates/' );
	}

	/**
	 * Register theme support for various features
	 */
	public static function theme_supports() {
		global $content_width;

		self::set( 'is_responsive', apply_filters( 'vamtam-theme-responsive-mode', true ) );

		/**
		 * the max content width the css is built for should equal the actual content width,
		 * for example, the width of the text of a page without sidebars
		 */
		if ( ! isset( $content_width ) ) $content_width = 1360;

		if ( is_customize_preview() ) {
			$content_width = 1400;
		}

		if ( VamtamElementorBridge::is_elementor_active() && VamtamElementorBridge::elementor_is_v3_or_greater() ) {
			$kits_manager = Elementor\Plugin::instance()->kits_manager;

			$kit_id = get_option( 'elementor_active_kit' );

			if ( $kit_id ) {
				$kit = get_post_meta( $kit_id, '_elementor_page_settings', true );

				if ( ! empty( $kit ) && isset( $kit[ 'container_width' ] ) ) {
					$content_width = (int)$kit[ 'container_width' ][ 'size' ];
				}
			}
		}

		add_theme_support( 'woocommerce', array(
			'thumbnail_image_width'         => $content_width / (int)get_option( 'woocommerce_catalog_columns', 4 ),
			'single_image_width'            => $content_width / 2,
			'gallery_thumbnail_image_width' => $content_width / 4,
		) );

		// HiDPI WC image sizes
		if ( function_exists( 'wc_get_image_size' ) ) {
			$thumbnail         = wc_get_image_size( 'thumbnail' );
			$single            = wc_get_image_size( 'single' );

			add_image_size( 'vamtam_woocommerce_thumbnail_2x', (int)$thumbnail['width'] * 2, (int)$thumbnail['height'] * 2, $thumbnail['crop'] );
			add_image_size( 'vamtam_woocommerce_single_2x', (int)$single['width'] * 2, (int)$single['height'] * 2, $single['crop'] );
		}

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'vamtam-ajax-siblings' );
		add_theme_support( 'vamtam-page-title-style' );
		add_theme_support( 'vamtam-tribe-events' );
		add_theme_support( 'vamtam-cart-dropdown' );

		add_post_type_support( 'page', 'excerpt' );

		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'vamtam-elementor-widgets' );
		function vamtam_elementor_widgets_support( bool $supports, array $args, string $feature ) {
			if ( ! $args ) {
				// Empty array here is essentially a check for 'vamtam-elementor-widgets' (>=WP6.0).
				// Documented in /wp-includes/theme.php->current_theme_supports().
				return $supports;
			}

			// Features carried over from previous themes or ported to next ones.
			// These are features that, for the most part, after defined on a theme,
			// continue being enabled for all themes after that.
			$base_features = [
				// Incoming.
				'woocommerce-product-images--disable-image-link',  // All Themes.
				'woocommerce-menu-cart--close-cart-theme-icon',    // Bijoux-after.
				'archive-posts.classic--box-section',              // Estudiar-after.
				'form--updated-fields-style-section',              // Fitness-after.
				'section--vamtam-sticky-header-controls',          // Ativo-after.
				'posts-base--extra-pagination-controls',           // Ativo-after.
				'woocommerce-product-images--sale-flash-section',  // Ativo-after.
				'woocommerce-product-images--no-border-controls',  // Fiore-after.
				// To be ported.
			];

			// Theme-specific features.
			// These are featrures that change from theme to theme.
			// They are usually cleared on a new theme, to avoid having active features, which are not really used.
			$theme_features = [
				'posts-base--load-more-masonry-fix',
				'posts-base--display-categories',
				'testimonial-carousel--slide-triggers-inner-anims',
				'woocommerce-product-images--full-sized-gallery',
				'popup--absolute-position',
				'image--foreground-layer',
				'products-base--new-badge-section',
				'woocommerce-product-images--new-badge-section',
				'products-base--horizontal-layout',
				'posts-base--horizontal-layout',
				'woocommerce-menu-cart--theme-cart-icon',
				'nav-menu--disable-scroll-on-mobile',
				'posts-base--404-handling-fix',
				'posts-base--display-tags',
				'button--underline-anim',
				'nav-menu--underline-anim',
				'posts-base--title-underline-anim',
				'button--icon-size-control',
				'popup--open-on-selector-hover',
				'form--underline-anim',
			];

			// Supported features for "vamtam-elementor-widgets" theme support.
			$supported_features = array_merge( $base_features, $theme_features );

			return in_array( $args[0], $supported_features );
		}
		add_filter( 'current_theme_supports-vamtam-elementor-widgets', 'vamtam_elementor_widgets_support', 10, 3 );

		add_theme_support( 'wc-product-gallery-slider' );

		if ( vamtam_get_option( 'wc-product-gallery-zoom' ) === 'enabled' ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}

		if ( ! vamtam_extra_features() ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-zoom' );
		}

		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus(
				array(
					'primary-menu'     => esc_html__( 'Menu Header', 'coiffure' ),
				)
			);
		}
	}

	/**
	 * Load interface translations
	 */
	private function load_languages() {
		load_theme_textdomain( 'coiffure', VAMTAM_THEME_DIR . 'languages' );
	}

	/**
	 * Loads the main php files used by the framework
	 */
	private function load_functions() {
		global $vamtam_defaults, $vamtam_fonts;
		$vamtam_defaults = include VAMTAM_SAMPLES_DIR . 'default-options.php';
		$vamtam_fonts    = include VAMTAM_HELPERS . 'fonts.php';

		require_once VAMTAM_HELPERS . 'init.php';

		$vamtam_custom_fonts = get_option( 'vamtam_custom_font_families', '' );
		if ( defined( 'ELEMENTOR_VERSION' ) && defined( 'ELEMENTOR_PRO_VERSION' ) && class_exists( 'ElementorPro\Modules\AssetsManager\AssetTypes\Fonts_Manager' ) ) {
			$elementor_custom_fonts = get_option( ElementorPro\Modules\AssetsManager\AssetTypes\Fonts_Manager::FONTS_OPTION_NAME, false );
		}

		// Custom Vamtam Fonts
		if ( ! empty( $vamtam_custom_fonts ) ) {
			$vamtam_custom_fonts = explode( "\n", $vamtam_custom_fonts );

			$vamtam_fonts['-- Custom fonts --'] = array(
				'family' => '',
			);

			foreach ( $vamtam_custom_fonts as $font ) {
				$font = preg_replace( '/["\']+/', '', trim( $font ) );

				$vamtam_fonts[ $font ] = array(
					'family' => '"' . $font . '"',
					'weights' => array( '300', '300 italic', 'normal', 'italic', '600', '600 italic', 'bold', 'bold italic', '800', '800 italic' ),
				);
			}
		}

		//Custom Elementor Fonts
		if ( ! empty( $elementor_custom_fonts ) ) {

			if ( empty( $vamtam_custom_fonts ) ) {
				$vamtam_fonts['-- Custom fonts --'] = array(
					'family' => '',
				);
			}

			foreach ( $elementor_custom_fonts as $font_name => $font ) {
				$font = preg_replace( '/["\']+/', '', trim( $font_name ) );

				$vamtam_fonts[ $font ] = array(
					'family' => '"' . $font_name . '"',
					'weights' => array( '300', '300 italic', 'normal', 'italic', '600', '600 italic', 'bold', 'bold italic', '800', '800 italic' ),
				);
			}
		}

		require_once VAMTAM_HELPERS . 'icons.php';

		require_once VAMTAM_HELPERS . 'base.php';
		require_once VAMTAM_HELPERS . 'template.php';
		require_once VAMTAM_HELPERS . 'css.php';

		require_once VAMTAM_HELPERS . 'woocommerce-integration.php';
		require_once VAMTAM_HELPERS . 'the-events-calendar-integration.php';

		// frontend wrappers
		require_once VAMTAM_HELPERS . 'frontend-wrappers.php';

		VamtamOverrides::filters();
		VamtamEnqueues::actions();

		if ( file_exists( VAMTAM_HELPERS . 'migrations.php' ) ) {
			require_once VAMTAM_HELPERS . 'migrations.php';
		}
	}

	/**
	 * Register sidebars
	 */
	public static function widgets_init() {

		if ( ! VamtamElementorBridge::is_elementor_pro_active() ) {
			$vamtam_sidebars = VamtamSidebars::get_instance();
			$vamtam_sidebars->register_sidebars();
		}
	}

	/**
	 * Loads the theme administration code
	 */
	private function load_admin() {
		if ( ! is_admin() ) return;

		VamtamAdmin::actions();
	}

	/**
	 * Return the option_name used for the purchase code option
	 * Backwards-compatible with the old option_name used before July 2018
	 */
	public static function get_purchase_code_option_key() {
		return defined( 'VAMTAM_ENVATO_THEME_ID' ) ? 'envato_purchase_code_' . VAMTAM_ENVATO_THEME_ID : 'vamtam-envato-license-key';
	}

	/**
	 * Return the purchase code, if set
	 * Also, automatically migrate the old option to use the new option_name
	 */
	public static function get_purchase_code() {
		$purchase_code_option_key = self::get_purchase_code_option_key();

		// if the old purchase code option is present and a THEME ID is set - migrate to the new purchase code option key
		if ( defined( 'VAMTAM_ENVATO_THEME_ID' ) && get_option( 'vamtam-envato-license-key', false ) !== false ) {
			update_option( $purchase_code_option_key, get_option( 'vamtam-envato-license-key' ) );
			delete_option( 'vamtam-envato-license-key' );
		}

		return get_option( $purchase_code_option_key );
	}

	public static function license( $state = '' ) {
		if ( ! empty( $state ) ) {
			// Set.
			update_option( '_vamtam_license', $state );
		} else {
			// Get.
			return get_option( '_vamtam_license' );
		}
	}

	public static function license_valid() {
		echo '<span id="success">';
		esc_html_e( 'Valid Purchase Key.', 'coiffure' );
		echo '<p>';
		esc_html_e( 'Congratulations! You have succesfully registered your product.', 'coiffure' );
		echo '</p>';
		echo '</span>';
	}

	public static function license_invalid() {
		echo '<span id="fail">';
		esc_html_e( 'Incorrect Purchase Key.', 'coiffure' );
		echo '<p>';
		esc_html_e( 'Please check your purchase code and re-enter.', 'coiffure' );
		echo '</p>';
		echo '</span>';
	}

	public static function license_failed() {
		echo '<span class="fail">';
		esc_html_e( 'Cannot validate Purchase Key. Please try again later. If the problem persists your server might not have the curl PHP extension enabled.', 'coiffure' );
		echo '</span>';
	}

	public static function license_unregister() {
		esc_html_e( 'Unregistered Key.', 'coiffure' );
	}
}


