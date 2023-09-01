<?php
/**
 * RadiantThemes functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package RadiantThemes
 */

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_parent_theme_file_path( '/inc/jetpack.php' );
}

/**
 * Load TGMPA file.
 */
require get_parent_theme_file_path( '/inc/tgmpa/tgmpa.php' );

// Admin pages.
if ( is_admin() ) {
	include_once get_template_directory() . '/inc/radiantthemes-dashboard/rt-admin.php';
}

if ( ! function_exists( 'glamon_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function glamon_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Glamon, use a find and replace
		 * to change 'glamon' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'glamon', get_template_directory() . '/languages' );

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

		/*
		 * Enable support for woocommerce lightbox gallery.
		*/
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'top'             => esc_html__( 'Primary', 'glamon' ),
				'side-panel-menu' => esc_html__( 'Side Panel Menu', 'glamon' ),
				'flyout-menu'     => esc_html__( 'Flyout Menu', 'glamon' ),
				'slideout-menu'   => esc_html__( 'Slideout Menu', 'glamon' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		$glamon_args = array(
			'default-color' => 'ffffff',
			'default-image' => '',
		);
		add_theme_support( 'custom-background', $glamon_args );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add post formats support.
		add_theme_support(
			'post-formats',
			array(
				'image',
				'quote',
				'status',
			)
		);
		add_post_type_support( 'post', 'post-formats' );

		// Registers an editor stylesheet for the theme.
		add_editor_style( 'assets/css/radiantthemes-editor-styles.css' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Gutenberg Start.
		// Adding support for core block visual styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'editor-styles' );

		// Gutenberg End.

		// Require Redux Framework.
		require_once get_parent_theme_file_path( '/inc/redux-framework/admin-init.php' );

		/**
		 * Redux custom css
		 */
		function glamon_custom_redux_css() {
			/**
			 * [glamon_custom_redux_css description]
			 */
			function glamon_override_css_fonts_url() {
				$google_font_url = '';

				/*
				Translators          : If there are characters in your language that are not supported
				by chosen font(s), translate this to 'off'. Do not translate into your own language.
				*/
				if ( 'off' !== _x( 'on', 'Google font: on or off', 'glamon' ) ) {
					$google_font_url = add_query_arg( 'family', rawurlencode( 'Poppins: 300,400,500,600,700' ), '//fonts.googleapis.com/css' );
				}
				return $google_font_url;
			}
			wp_enqueue_style(
				'radiantthemes-google-fonts',
				glamon_override_css_fonts_url(),
				array(),
				'1.0.0'
			);
			wp_register_style(
				'simple-dtpicker',
				get_parent_theme_file_uri( '/inc/redux-framework/css/jquery.simple-dtpicker.min.css' ),
				array(),
				time(),
				'all'
			);
			wp_enqueue_style( 'simple-dtpicker' );

			wp_register_style(
				'radiantthemes-redux-custom',
				get_parent_theme_file_uri( '/inc/redux-framework/css/radiantthemes-redux-custom.css' ),
				array(),
				time(),
				'all'
			);
			wp_enqueue_style( 'radiantthemes-redux-custom' );

			wp_enqueue_script(
				'simple-dtpicker',
				get_parent_theme_file_uri( '/inc/redux-framework/js/jquery.simple-dtpicker.min.js' ),
				array( 'jquery' ),
				time(),
				true
			);
			wp_enqueue_script(
				'radiantthemes-redux-custom',
				get_parent_theme_file_uri( '/inc/redux-framework/js/radiantthemes-redux-custom.js' ),
				array( 'jquery' ),
				time(),
				true
			);

		}
		// This example assumes your opt_name is set to glamon_theme_option, replace with your opt_name value.
		add_action( 'redux/page/glamon_theme_option/enqueue', 'glamon_custom_redux_css', 2 );
	}
endif;
add_action( 'after_setup_theme', 'glamon_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function glamon_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'glamon_content_width', 2000 );
}
add_action( 'after_setup_theme', 'glamon_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function glamon_widgets_init() {

	// ADD MAIN SIDEBAR.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'glamon' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'glamon' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// ADD PRODUCT SIDEBAR.
	if ( class_exists( 'woocommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Product | Sidebar', 'glamon' ),
				'id'            => 'radiantthemes-product-sidebar',
				'description'   => esc_html__( 'Add widgets here.', 'glamon' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h5 class="widget-title">',
				'after_title'   => '</h5>',
			)
		);
	}

	// ADD HAMBURGER WIDGET AREA.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Hamburger | Sidebar', 'glamon' ),
			'id'            => 'radiantthemes-hamburger-sidebar',
			'description'   => esc_html__( 'Add widgets for "Hamburger" menu from here. To turn it on/off please navigate to "Theme Options > Header" and select "Hamburger" for respetive header styles.', 'glamon' ),
			'before_widget' => '<div id="%1$s" class="widget matchHeight %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<p class="widget-title">',
			'after_title'   => '</p>',
		)
	);

}
add_action( 'widgets_init', 'glamon_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function glamon_scripts() {

	// DEREGISTER STYLESHEETS.
	wp_deregister_style( 'font-awesome' );
	wp_deregister_style( 'font-awesome-css' );

	// ENQUEUE RADIANTTHEMES ALL STYLES.
	wp_enqueue_style(
		'radiantthemes-all',
		get_parent_theme_file_uri( '/assets/css/radiantthemes-all.min.css' ),
		array(),
		time()
	);
	wp_enqueue_style( 'js-composer-front' );

	// ENQUEUE ANIMATE CSS.
	wp_enqueue_style( 'animate-css' );

	// ENQUEUE RADIANTTHEMES CUSTOM CSS.
	wp_enqueue_style(
		'radiantthemes-custom',
		get_parent_theme_file_uri( '/assets/css/radiantthemes-custom.css' ),
		array(),
		time()
	);

	// ENQUEUE RADIANTTHEMES RESPONSIVE CSS.
	wp_enqueue_style(
		'radiantthemes-responsive',
		get_parent_theme_file_uri( '/assets/css/radiantthemes-responsive.css' ),
		array(),
		time()
	);

	// CALL RESET CSS IF REDUX NOT ACTIVE.
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) {
		wp_enqueue_style(
			'radiantthemes-reset',
			get_parent_theme_file_uri( '/assets/css/radiantthemes-reset.css' ),
			array(),
			time()
		);

		/**
		 * Load Montserrat Google Font when redux framework is not installed.
		 */
		function radiantthemes_default_google_fonts_url() {
			$google_font_url = '';

			/*
			Translators          : If there are characters in your language that are not supported
			by chosen font(s), translate this to 'off'. Do not translate into your own language.
			*/
			if ( 'off' !== _x( 'on', 'Google font: on or off', 'glamon' ) ) {
				$google_font_url = add_query_arg( 'family', rawurlencode( 'Montserrat:400,500,600,700,800|Poppins:400,500,600,700,800' ), '//fonts.googleapis.com/css' );
			}
			return $google_font_url;
		}
		wp_enqueue_style(
			'radiantthemes-google-fonts',
			radiantthemes_default_google_fonts_url(),
			array(),
			'1.0.0'
		);
	}

	// ENQUEUE STYLE.CSS.
	wp_enqueue_style(
		'radiantthemes-style',
		get_stylesheet_uri(),
		array(),
		time()
	);

	// ENQUEUE RAIDNATTHEMES USER CUSTOM - GERERATED FROM REDUX CUSTOM CSS.
	wp_enqueue_style(
		'radiantthemes-user-custom',
		get_parent_theme_file_uri( '/assets/css/radiantthemes-user-custom.css' ),
		array(),
		time()
	);

	// ENQUEUE RADIANTTHEMES DYNAMIC - GERERATED FROM REDUX FRAMEWORK.
	wp_enqueue_style(
		'radiantthemes-dynamic',
		get_parent_theme_file_uri( '/assets/css/radiantthemes-dynamic.css' ),
		array(),
		time()
	);
	// ENQUEUE RADIANTTHEMES CUSTOM FOOTER.
	$custom_footer              = get_posts( 'post_type="radiant_footer"&post_status="private"&numberposts=-1' );
	$custom_footer_inline_style = '';
	if ( $custom_footer ) {

		foreach ( $custom_footer as $cf ) {
				$custom_footer_inline_style .= get_post_meta( $cf->ID, '_wpb_shortcodes_custom_css', true ) . get_post_meta( $cf->ID, '_wpb_post_custom_css', true );
		}

		wp_add_inline_style( 'radiantthemes-dynamic', wp_strip_all_tags( $custom_footer_inline_style ) );

	}

	/**
	 * ENQUEUE SCRIPTS
	 */

	// ENQUEUE BOOTSTRAP JQUERY.
	wp_enqueue_script(
		'bootstrap',
		get_parent_theme_file_uri( '/assets/js/bootstrap.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE SIDR JQUERY.
	wp_enqueue_script(
		'sidr',
		get_parent_theme_file_uri( '/assets/js/jquery.sidr.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE ONEPAGENAV JQUERY.
	wp_enqueue_script(
		'onepagenav',
		get_parent_theme_file_uri( '/assets/js/jquery.onePageNav.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE MATCHHEIGHT JQUERY.
	wp_enqueue_script(
		'matchheight',
		get_parent_theme_file_uri( '/assets/js/jquery.matchHeight-min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE WOW JQUERY.
	wp_enqueue_script(
		'wow',
		get_parent_theme_file_uri( '/assets/js/wow.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE NICESCROLL JQUERY.
	wp_enqueue_script(
		'nicescroll',
		get_parent_theme_file_uri( '/assets/js/jquery.nicescroll.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE STICKY JQUERY.
	wp_enqueue_script(
		'sticky',
		get_parent_theme_file_uri( '/assets/js/jquery.sticky.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE RETINA JQUERY.
	wp_enqueue_script(
		'retina',
		get_parent_theme_file_uri( '/assets/js/retina.min.js' ),
		false,
		true
	);

	// ENQUEUE FANCYBOX JQUERY.
	wp_enqueue_script(
		'fancybox',
		get_parent_theme_file_uri( '/assets/js/jquery.fancybox.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE ISOTOPE JQUERY.
	wp_enqueue_script(
		'isotope-pkgd',
		get_parent_theme_file_uri( '/assets/js/isotope.pkgd.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE ODOMETER JQUERY.
	wp_enqueue_script(
		'odometer',
		get_parent_theme_file_uri( '/assets/js/odometer.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE JQUERY COOKIE.
	wp_enqueue_script(
		'jquery-cookie',
		get_parent_theme_file_uri( '/assets/js/jquery.cookie.min.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// ENQUEUE RADIANTTHEMES CUSTOM JQUERY.
	wp_enqueue_script(
		'radiantthemes-custom',
		get_parent_theme_file_uri( '/assets/js/radiantthemes-custom.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	// Load comment-reply.js into footer.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		// enqueue the javascript that performs in-link comment reply fanciness.
		wp_enqueue_script( 'comment-reply' );
	}

	// Load Countdown JS and Coming Soon JS.
	if ( ! is_user_logged_in() && ! empty( glamon_global_var( 'coming_soon_switch', '', false ) ) ) {
		wp_enqueue_script(
			'countdown',
			get_parent_theme_file_uri( '/assets/js/jquery.countdown.min.js' ),
			array( 'jquery' ),
			true
		);
		wp_enqueue_script(
			'radiantthemes-comingsoon',
			get_parent_theme_file_uri( '/assets/js/radiantthemes-comingsoon.js' ),
			array( 'jquery' ),
			true
		);
	}

}
add_action( 'wp_enqueue_scripts', 'glamon_scripts' );

/**
 * RadiantThemes Dynamic CSS.
 */
global $wp_filesystem;

if ( defined( 'FS_CHMOD_FILE' ) ) {
	$chmod = FS_CHMOD_FILE;
} else {
	$chmod = 0644;
}

$radiantthemes_theme_options = get_option( 'glamon_theme_option' );
ob_start();
require_once get_parent_theme_file_path( '/inc/dynamic-style/radiantthemes-dynamic-style.php' );
$css      = ob_get_clean();
$filename = get_parent_theme_file_path( '/assets/css/radiantthemes-dynamic.css' );

if ( empty( $wp_filesystem ) ) {
	require_once ABSPATH . '/wp-admin/includes/file.php';
	WP_Filesystem();
}

if ( $wp_filesystem ) {
	$wp_filesystem->put_contents(
		$filename,
		$css,
		$chmod // predefined mode settings for WP files.
	);
}

/**
 * Woocommerce Support
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * [glamon_wrapper_start description]
 */
function glamon_wrapper_start() {
	echo wp_kses_post( '<section id="main">' );
}
add_action( 'woocommerce_before_main_content', 'glamon_wrapper_start', 10 );

/**
 * [glamon_wrapper_end description]
 */
function glamon_wrapper_end() {
	echo wp_kses_post( '</section>' );
}
add_action( 'woocommerce_after_main_content', 'glamon_wrapper_end', 10 );

/**
 * [woocommerce_support description]
 */
function glamon_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'glamon_woocommerce_support' );

// Remove the product rating display on product loops.
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

// Ajax cart basket.
add_filter( 'woocommerce_add_to_cart_fragments', 'glamon_iconic_cart_count_fragments', 10, 1 );

// Woocommerce product per page.
add_filter( 'loop_shop_per_page', 'glamon_shop_per_page', 20 );

/**
 * Undocumented function
 *
 * @param [type] $cols Column.
 */
function glamon_shop_per_page( $cols ) {
	// $cols contains the current number of products per page based on the value stored on Options -> Reading
	// Return the number of products you wanna show per page.
	$cols = esc_html( glamon_global_var( 'shop-products-per-page', '', false ) );
	return $cols;
}
/**
 * [glamon_iconic_cart_count_fragments description]
 *
 * @param  [type] $fragments description.
 * @return [type]            [description]
 */
function glamon_iconic_cart_count_fragments( $fragments ) {
	$fragments['span.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
	return $fragments;
}

// Woocommerce wishlist button immediately after the add to cart button.
add_action( 'woocommerce_after_add_to_cart_button', 'glamon_custom_action', 5 );

/**
 * Wistlist Button Beside Add To Cart Function.
 */

function glamon_custom_action() {
	if ( class_exists( 'YITH_WCWL_Init' ) ) {
		echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	}
}

/**
 * Change Proceed to Checkout text in WooCommerce via text replacement
 */
function woocommerce_button_proceed_to_checkout() {
	?>
<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward"><?php echo esc_html__( 'Checkout', 'glamon' ); ?></a>
	<?php
}

/**
 * Set Site Icon
 */
function glamon_site_icon() {
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		if ( glamon_global_var( 'favicon', 'url', true ) ) :
			?>
			<link rel="icon" href="<?php echo esc_url( glamon_global_var( 'favicon', 'url', true ) ); ?>" sizes="32x32" />
			<link rel="icon" href="<?php echo esc_url( glamon_global_var( 'apple-icon', 'url', true ) ); ?>" sizes="192x192">
			<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url( glamon_global_var( 'apple-icon', 'url', true ) ); ?>" />
			<meta name="msapplication-TileImage" content="<?php echo esc_url( glamon_global_var( 'apple-icon', 'url', true ) ); ?>" />
		<?php else : ?>
			<link rel="icon" href="<?php echo esc_url( get_parent_theme_file_uri( '/assets/images/Favicon-Default.ico' ) ); ?>" sizes="32x32" />
			<link rel="icon" href="<?php echo esc_url( get_parent_theme_file_uri( '/assets/images/Favicon-Default.ico' ) ); ?>" sizes="192x192">
			<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url( get_parent_theme_file_uri( '/assets/images/Favicon-Default.ico' ) ); ?>" />
			<meta name="msapplication-TileImage" content="<?php echo esc_url( get_parent_theme_file_uri( '/assets/images/Favicon-Default.ico' ) ); ?>" />
		<?php endif; ?>
		<?php
	}
}
add_filter( 'wp_head', 'glamon_site_icon' );

add_filter(
	'wp_prepare_attachment_for_js',
	function( $response, $attachment, $meta ) {
		if (
			'image/x-icon' === $response['mime'] &&
			isset( $response['url'] ) &&
			! isset( $response['sizes']['full'] )
		) {
			$response['sizes'] = array(
				'full' => array(
					'url' => $response['url'],
				),
			);
		}
		return $response;
	},
	10,
	3
);

if ( ! function_exists( 'glamon_pagination' ) ) {

	/**
	 * Displays pagination on archive pages
	 */
	function glamon_pagination() {

		global $wp_query;

		$big = 999999999; // need an unlikely integer.

		$paginate_links = paginate_links(
			array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $wp_query->max_num_pages,
				'next_text' => '<span class="animated-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="7" height="29" viewbox="0 0 7 29"><path fill="none" d="M7 25l-3 3H3l-3-3M3.5 0v29"></path></svg></span>',
				'prev_text' => '<span class="animated-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="7" height="29" viewbox="0 0 7 29"><path fill="none" d="M7 25l-3 3H3l-3-3M3.5 0v29"></path></svg></span>',
				'end_size'  => 5,
				'mid_size'  => 5,
				'add_args'  => false,
			)
		);

		// Display the pagination if more than one page is found.
		if ( $paginate_links ) :
			?>

			<div class="pagination clearfix">
				<?php
				$kses_defaults = wp_kses_allowed_html( 'post' );

				$svg_args = array(
					'svg'   => array(
						'class'           => true,
						'aria-hidden'     => true,
						'aria-labelledby' => true,
						'role'            => true,
						'xmlns'           => true,
						'width'           => true,
						'height'          => true,
						'viewbox'         => true, // <= Must be lower case!
					),
					'g'     => array( 'fill' => true ),
					'title' => array( 'title' => true ),
					'path'  => array(
						'd'    => true,
						'fill' => true,
					),
				);

				$allowed_tags = array_merge( $kses_defaults, $svg_args );
				echo wp_kses( $paginate_links, $allowed_tags );
				?>
			</div>

			<?php
		endif;
	}
}


/**
 * Display the breadcrumbs.
 */
function glamon_breadcrumbs() {

	$show_on_home = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	if ( ! glamon_global_var( 'breadcrumb_arrow_style', '', false ) ) {
		$delimiter = '<span class="gap"><i class="el el-chevron-right"></i></span>';
	} else {
		$delimiter = '<span class="gap"><i class="' . glamon_global_var( 'breadcrumb_arrow_style', '', false ) . '"></i></span>';
	}

	$home         = esc_html__( 'Home', 'glamon' ); // text for the 'Home' link.
	$show_current = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$before       = '<span class="current">'; // tag before the current crumb.
	$after        = '</span>'; // tag after the current crumb.

	global $post;
	$home_link = get_home_url( 'url' );

	if ( is_home() && is_front_page() ) {

		if ( 1 === $show_on_home ) {
			echo '<div id="crumbs"><a href="' . esc_url( $home_link ) . '">' . esc_html__( 'Home', 'glamon' ) . '</a></div>';
		}
	} elseif ( class_exists( 'woocommerce' ) && ( is_shop() || is_singular( 'product' ) || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
		/**
		 * Undocumented function
		 *
		 * @return array
		 */
		function my_woocommerce_breadcrumbs() {
			if ( ! glamon_global_var( 'breadcrumb_arrow_style', '', false ) ) {
				$delimiter = '<span class="gap"><i class="el el-chevron-right"></i></span>';
			} else {
				$delimiter = '<span class="gap"><i class="' . glamon_global_var( 'breadcrumb_arrow_style', '', false ) . '"></i></span>';
			}
			return array(
				'delimiter'   => $delimiter,
				'wrap_before' => '<div id="crumbs" itemprop="breadcrumb">',
				'wrap_after'  => '</div>',
				'before'      => '',
				'after'       => '',
				'home'        => _x( 'Home', 'breadcrumb', 'glamon' ),
			);
		}
		add_filter( 'woocommerce_breadcrumb_defaults', 'my_woocommerce_breadcrumbs' );
		woocommerce_breadcrumb();
	} else {

		echo '<div id="crumbs"><a href="' . esc_url( $home_link ) . '">' . esc_html__( 'Home', 'glamon' ) . '</a> ' . wp_kses_post( $delimiter ) . ' ';
		if ( is_home() ) {
			echo wp_kses_post( $before ) . get_the_title( get_option( 'page_for_posts', true ) ) . wp_kses_post( $after );
		} elseif ( is_category() ) {
			$this_cat = get_category( get_query_var( 'cat' ), false );
			if ( 0 != $this_cat->parent ) {
				echo wp_kses_post( get_category_parents( $this_cat->parent, true, ' ' . wp_kses_post( $delimiter ) . ' ' ) );
			}
			echo wp_kses_post( $before ) . esc_html__( 'Archive by category "', 'glamon' ) . single_cat_title( '', false ) . '"' . wp_kses_post( $after );
		} elseif ( is_search() ) {
			echo wp_kses_post( $before ) . esc_html__( 'Search results for "', 'glamon' ) . get_search_query() . '"' . wp_kses_post( $after );
		} elseif ( is_day() ) {
			echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . '</a> ' . wp_kses_post( $delimiter ) . ' ';
			echo '<a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . esc_html( get_the_time( 'F' ) ) . '</a> ' . wp_kses_post( $delimiter ) . ' ';
			echo wp_kses_post( $before ) . esc_html( get_the_time( 'd' ) ) . wp_kses_post( $after );
		} elseif ( is_month() ) {
			echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . '</a> ' . wp_kses_post( $delimiter ) . ' ';
			echo wp_kses_post( $before ) . esc_html( get_the_time( 'F' ) ) . wp_kses_post( $after );
		} elseif ( is_year() ) {
			echo wp_kses_post( $before ) . esc_html( get_the_time( 'Y' ) ) . wp_kses_post( $after );
		} elseif ( class_exists( 'Tribe__Events__Main' ) && ( is_singular( 'tribe_events' ) || ( tribe_is_past() || tribe_is_upcoming() && ! is_tax() ) || ( tribe_is_month() && ! is_tax() ) || ( tribe_is_day() && ! is_tax() ) ) ) {
			echo wp_kses_post( $before ) . esc_html( glamon_global_var( 'event_banner_title', '', false ) ) . wp_kses_post( $after );
		} elseif ( is_single() && ! is_attachment() ) {
			if ( 'post' != get_post_type() ) {
				$post_type = get_post_type_object( get_post_type() );
				$slug      = $post_type->rewrite;

				$cpost_label = $slug['slug'];
				$cpost_label = implode( '-', array_map( 'ucfirst', explode( '-', $cpost_label ) ) );
				$cpost_label = str_replace( '-', ' ', $cpost_label );

				if ( 'team' == get_post_type() || 'portfolio' == get_post_type() || 'case-studies' == get_post_type() ) {
					echo '<a href="' . esc_url( $home_link ) . '/' . esc_attr( $slug['slug'] ) . '/">' . esc_html( $cpost_label ) . '</a>';
				} else {
					echo '<a href="' . esc_url( $home_link ) . '/' . esc_attr( $slug['slug'] ) . '/">' . esc_html( $post_type->labels->singular_name ) . '</a>';
				}

				if ( 1 == $show_current ) {
					echo ' ' . wp_kses_post( $delimiter ) . ' ' . wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
				}
			} else {
				$cat  = get_the_category();
				$cat  = $cat[0];
				$cats = get_category_parents( $cat, true, ' ' . wp_kses_post( $delimiter ) . ' ' );
				if ( 0 == $show_current ) {
					$cats = preg_replace( "#^(.+)\s$delimiter\s$#", '$1', $cats );
				}
				echo wp_kses_post( $cats );
				if ( 1 == $show_current ) {
					echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
				}
			}
		} elseif ( ! is_single() && ! is_page() && 'post' != get_post_type() && ! is_404() ) {
			$post_type = get_post_type_object( get_post_type() );
			echo wp_kses_post( $before ) . esc_html( $post_type->labels->singular_name ) . wp_kses_post( $after );
		} elseif ( is_attachment() ) {
			$parent = get_post( $post->post_parent );
			$cat    = get_the_category( $parent->ID );
			$cat    = $cat[0];
			echo wp_kses_post( get_category_parents( $cat, true, ' ' . $delimiter . ' ' ) );
			echo '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( $parent->post_title ) . '</a>';
			if ( 1 == $show_current ) {
				echo ' ' . wp_kses_post( $delimiter ) . ' ' . wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
			}
		} elseif ( is_page() && ! $post->post_parent ) {
			if ( 1 == $show_current ) {
				echo wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
			}
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id   = $post->post_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
				$page          = get_page( $parent_id );
				$breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
				$parent_id     = $page->post_parent;
			}
			$breadcrumbs       = array_reverse( $breadcrumbs );
			$count_breadcrumbs = count( $breadcrumbs );
			for ( $i = 0; $i < $count_breadcrumbs; $i++ ) {
				echo wp_kses_post( $breadcrumbs[ $i ] );
				if ( ( count( $breadcrumbs ) - 1 ) != $i ) {
					echo ' ' . wp_kses_post( $delimiter ) . ' ';
				}
			}
			if ( 1 == $show_current ) {
				echo ' ' . wp_kses_post( $delimiter ) . ' ' . wp_kses_post( $before ) . get_the_title() . wp_kses_post( $after );
			}
		} elseif ( is_tag() ) {
			echo wp_kses_post( $before ) . esc_html__( 'Posts tagged "', 'glamon' ) . single_tag_title( '', false ) . '"' . wp_kses_post( $after );
		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );
			echo wp_kses_post( $before ) . esc_html__( 'Articles posted by ', 'glamon' ) . esc_html( $userdata->display_name ) . wp_kses_post( $after );
		} elseif ( is_404() ) {
			echo wp_kses_post( $before ) . esc_html__( 'Error 404', 'glamon' ) . wp_kses_post( $after );
		}

		if ( get_query_var( 'paged' ) ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
				echo ' (';
			}
			echo esc_html_e( 'Page', 'glamon' ) . ' ' . get_query_var( 'paged' );
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
				echo ')';
			}
		}

		echo '</div>';
	}
}

if ( ! function_exists( 'glamon_import_files' ) ) :

	/**
	 * [glamon_import_files description]
	 */
	function glamon_import_files() {

		return array(
			array(
				'import_file_name'         => esc_html__( 'Demo One', 'glamon' ),
				'import_file_key'          => 'demo-one',
				'local_import_file'        => get_parent_theme_file_path( '/inc/import/content.xml' ),
				'local_import_widget_file' => get_parent_theme_file_path( '/inc/import/widgets.wie' ),
				'local_import_redux'       => array(
					array(
						'file_path'   => get_parent_theme_file_path( '/inc/import/redux.json' ),
						'option_name' => 'glamon_theme_option',
					),
				),
				'import_notice'            => wp_kses_post( 'By clicking import button, you’re sending a file download request to our server which might get stored in server log. Also, by clicking import button, you’re giving consent to download demo content data from our server.' ),
				'preview_url'              => 'https://glamon.radiantthemes.com/',
			),
		);

	}
	add_filter( 'pt-ocdi/import_files', 'glamon_import_files' );
endif;

if ( ! function_exists( 'glamon_after_import' ) ) :
	/**
	 * [glamon_after_import description]
	 *
	 * @param  [type] $selected_import description.
	 */
	function glamon_after_import( $selected_import ) {

		// Set Menu.
		$main_menu       = get_term_by( 'name', 'Header Menu', 'nav_menu' );
		$flyout_menu     = get_term_by( 'name', 'Pages', 'nav_menu' );
		$side_panel_menu = get_term_by( 'name', 'Side Panel Menu', 'nav_menu' );
		$slideout_menu   = get_term_by( 'name', 'Slideout Menu', 'nav_menu' );
		set_theme_mod(
			'nav_menu_locations',
			array(
				'top'             => $main_menu->term_id,
				'flyout-menu'     => $flyout_menu->term_id,
				'side-panel-menu' => $side_panel_menu->term_id,
				'slideout-menu'   => $slideout_menu->term_id,
			)
		);

		// Set Front page.
		$home_page = get_page_by_title( 'Home' );
		if ( isset( $home_page->ID ) ) :
			update_option( 'page_on_front', $home_page->ID );
			update_option( 'show_on_front', 'page' );
		endif;

		// Set Blog page.
		$blog_page = get_page_by_title( 'Blog' );
		if ( isset( $blog_page->ID ) ) {
			update_option( 'page_for_posts', $blog_page->ID );
		}
	}
	add_action( 'pt-ocdi/after_import', 'glamon_after_import' );
endif;

add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/**
 * Change slug of custom post types
 *
 * @param  [type] $args      description.
 * @param  [type] $post_type description.
 * @return [string]
 */
function glamon_register_post_type_args( $args, $post_type ) {

	if ( 'portfolio' === $post_type ) {
		$args['rewrite']['slug'] = glamon_global_var( 'change_slug_portfolio', '', false );
	}

	if ( 'team' === $post_type ) {
		$args['rewrite']['slug'] = glamon_global_var( 'change_slug_team', '', false );
	}

	if ( 'case-studies' === $post_type ) {
		$args['rewrite']['slug'] = glamon_global_var( 'change_slug_casestudies', '', false );
	}

	return $args;
}
add_filter( 'register_post_type_args', 'glamon_register_post_type_args', 10, 2 );

/**
 * Add new mimes for custom font upload
 */
if ( ! function_exists( 'glamon_upload_mimes' ) ) {
	/**
	 * [glamon_upload_mimes description]
	 *
	 * @param array $existing_mimes description.
	 */
	function glamon_upload_mimes( $existing_mimes = array() ) {
		$existing_mimes['woff']  = 'application/x-font-woff';
		$existing_mimes['woff2'] = 'application/x-font-woff2';
		$existing_mimes['ttf']   = 'application/x-font-ttf';
		$existing_mimes['svg']   = 'image/svg+xml';
		$existing_mimes['eot']   = 'application/vnd.ms-fontobject';
		return $existing_mimes;
	}
}
add_filter( 'upload_mimes', 'glamon_upload_mimes' );

/**
 * Undocumented function
 *
 * @return void
 */
function glamon_enqueue_scripts() {

	$validate_old_theme = get_option( 'radiant_purchase' ) && ! get_option( 'radiant_purchase_validation' ) ? true : false;

	wp_enqueue_style(
		'radiantthemes-admin-styles',
		get_template_directory_uri() . '/inc/radiantthemes-dashboard/css/admin-pages.css',
		array(),
		time()
	);

	wp_enqueue_script(
		'radiantthemes-admin-script',
		get_parent_theme_file_uri( '/inc/radiantthemes-dashboard/js/admin-pages.js' ),
		array( 'jquery' ),
		time(),
		true
	);

	wp_localize_script(
		'radiantthemes-admin-script',
		'ajaxObject',
		array(
			'ajaxUrl'            => admin_url( 'admin-ajax.php' ),
			'colornonce'         => wp_create_nonce( 'colorCategoriesNonce' ),
			'validate_old_theme' => $validate_old_theme,
		)
	);
}
add_action( 'admin_enqueue_scripts', 'glamon_enqueue_scripts' );

/**
 * Undocumented function
 *
 * @return void
 */
function radiantthemes_dashboard_submenu_page() {
	add_submenu_page(
		'themes.php',
		'RadiantThemes Dashboard',
		'RadiantThemes Dashboard',
		'manage_options',
		'radiantthemes-dashboard',
		'radiantthemes_screen_welcome'
	);
}
add_action( 'admin_menu', 'radiantthemes_dashboard_submenu_page' );

/**
 * Undocumented function
 *
 * @return void
 */
function radiantthemes_screen_welcome() {
	echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
	require_once get_parent_theme_file_path( '/inc/radiantthemes-dashboard/welcome.php' );
}

/**
 * Undocumented function
 *
 * @return void
 */
function radiantthemes_plugins_submenu_page() {

	add_submenu_page(
		'themes.php',
		'Radiantthemes Install Plugins',
		'Radiantthemes Install Plugins',
		'manage_options',
		'radiantthemes-admin-plugins',
		'radiantthemes_screen_plugin'
	);

}
add_action( 'admin_menu', 'radiantthemes_plugins_submenu_page' );

/**
 * Undocumented function
 *
 * @return void
 */
function radiantthemes_screen_plugin() {
	echo '<div class="wrap" style="height:0;overflow:hidden;"><h2></h2></div>';
	require_once get_parent_theme_file_path( '/inc/radiantthemes-dashboard/install-plugins.php' );
}

/**
 * Redirect to welcome page
 *
 * @return void
 */
function glamon_after_switch_theme() {
	if ( current_user_can( 'manage_options' ) ) {
		wp_safe_redirect( admin_url( 'themes.php?page=radiantthemes-dashboard' ) );
	}
}
add_action( 'after_switch_theme', 'glamon_after_switch_theme' );

if ( ! get_option( 'wpb_js_content_types' ) ) {
	update_option( 'wpb_js_content_types', array( 'post', 'page', 'radiant_footer' ) );
}

/**
 * Define the redux/<parent_args_opt_name>/field/typography/custom_fonts callback
 *
 * @param [type] $array Array.
 * @return array
 */
function glamon_custom_fonts( $array ) {
	$theme_options = get_option( 'glamon_theme_option' );
	$font_names    = array();
	for ( $i = 1; $i <= 50; $i++ ) {
		if ( ! empty( $theme_options[ 'webfontName' . $i ] ) ) {
			$font_names[] = $theme_options[ 'webfontName' . $i ];
		}
	}

	$final_custom_fonts = array_combine( $font_names, $font_names );
	// make filter magic happen here...
	$array = array(
		'Custom Fonts' => $final_custom_fonts,
	);
	return $array;
};

// add the filter.
add_filter( 'redux/glamon_theme_option/field/typography/custom_fonts', 'glamon_custom_fonts', 10, 1 );

/**
 * Our hooked in function – $fields is passed via the filter!
 *
 * @param [type] $variablen Description.
 */
function radiantthemes_custom_override_woocommerce_paypal_express_checkout_button_img_url( $variablen ) {
	return get_template_directory_uri() . '/assets/images/Paypal-Checkout.png';
}
add_filter( 'woocommerce_paypal_express_checkout_button_img_url', 'radiantthemes_custom_override_woocommerce_paypal_express_checkout_button_img_url' );
add_filter( 'woocommerce_output_related_products_args', 'radiantthemes_change_number_related_products', 9999 );

function radiantthemes_change_number_related_products( $args ) {
	$theme_options = get_option( 'glamon_theme_option' );
	$chk           = $theme_options['shop-style'];
	if ( 'shop-style-three-column' == $chk ) {
		$args['posts_per_page'] = 3; // # of related products
		$args['columns']        = 3; // # of columns per row
	} elseif ( 'shop-style-five-column' == $chk ) {
		$args['posts_per_page'] = 5; // # of related products
		$args['columns']        = 5; // # of columns per row
	} elseif ( 'shop-style-six-column' == $chk ) {
		$args['posts_per_page'] = 6; // # of related products
		$args['columns']        = 6; // # of columns per row
	}

	return $args;
}

// GET AUTHOR ROLE.
function radiantthemes_get_author_role() {
	global $authordata;
	$author_roles = $authordata->roles;
	$author_role  = array_shift( $author_roles );
	return $author_role;
}

/**
 * Disable redirection after plugin activation in Woocommerce.
 *
 * @param boolean $boolean Redirect true/false.
 * @return boolean
 */
function wc_subscriber_auto_redirect( $boolean ) {
	return true;
}
add_filter( 'woocommerce_prevent_automatic_wizard_redirect', 'wc_subscriber_auto_redirect', 20, 1 );
