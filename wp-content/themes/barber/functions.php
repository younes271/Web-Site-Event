<?php
$theme = wp_get_theme();
define('APR_VERSION', $theme->get('Version'));
define('APR_LIB', get_template_directory() . '/inc');
define('APR_ADMIN', APR_LIB . '/admin');
define('APR_PLUGINS', APR_LIB . '/plugins');
define('APR_FUNCTIONS', APR_LIB . '/functions');
define('APR_METABOXES', APR_FUNCTIONS . '/metaboxes');
define('APR_CSS', get_template_directory_uri() . '/css');
define('APR_JS', get_template_directory_uri() . '/js');

require_once(APR_ADMIN . '/functions.php');
require_once(APR_FUNCTIONS . '/functions.php');
require_once(APR_METABOXES . '/functions.php');
require_once(APR_PLUGINS . '/functions.php');
// Set up the content width value based on the theme's design and stylesheet.
if (!isset($content_width)) {
    $content_width = 1140;
}

if (!function_exists('apr_setup')) {

    function apr_setup() {
        load_theme_textdomain('barber', get_template_directory() . '/languages');
        add_editor_style( array( 'style.css', 'style_rtl.css' ) );
        add_theme_support( 'title-tag' );
        add_theme_support('automatic-feed-links');
        add_theme_support( 'post-formats', array(
            'image', 'video', 'audio', 'quote', 'link', 'gallery',
        ) );
        // register menus
        register_nav_menus( array(
            'primary' => esc_html__('Primary Menu', 'barber'),
            'header6' => esc_html__('Header type 6 Menu', 'barber'),
        ));
        add_theme_support( 'custom-header' );
        add_theme_support( 'custom-background' );
        add_theme_support( 'post-thumbnails' );
   
		add_image_size('apr_blog_grid', 768, 542, true);
		add_image_size('apr_blog_list', 1170, 691, true);
        add_image_size('apr_blog_masonry', 555, 449, true);
        add_image_size('apr_blog_masonry2', 555, 694, true);
        add_image_size('apr_blog_masonry1', 555, 540, true);
        add_image_size('apr_blog_fullwidth', 1170, 472, true);
        add_image_size('apr_blog_list_3', 1041, 390, true);
		add_image_size('apr_blog_detail', 1170, 691, true); 
        add_image_size('apr_blog_detail_2', 1920, 760, true); 
		add_image_size('apr_blog_home', 480, 257, true); 
		add_image_size('apr_blog_home_1', 480, 314, true); 
		add_image_size('apr_shop', 550, 430, true); 
        add_image_size('apr_gallery_detail', 1172, 877, true);
        add_image_size('apr_gallery_grid', 481, 400, true);
		add_image_size('apr_gallery_square', 480, 480, true);
        add_image_size('apr_gallery_packery', 500, 296, true);
        add_image_size('apr_gallery_packery1', 500, 640, true);
        add_image_size('apr_gallery_packery2', 500, 658, true);
		add_image_size('apr_gallery_packery3', 600, 360, true);
		add_image_size('apr_gallery_packery4', 960, 720, true);
		add_image_size('apr_gallery_packery5', 960, 360, true);
		add_image_size('apr_gallery_packery6', 480, 360, true);
		add_image_size('apr_gallery_packery7', 555, 555, true);
		add_image_size('apr_gallery_packery8', 555, 260, true);
		add_image_size('apr_gallery_packery9', 1140, 400, true);
		add_image_size('apr_gallery_packery10', 453, 268, true);
        add_image_size('apr_gallery_packery11', 453, 566, true);
        add_image_size('apr_gallery_packery12', 424, 536, true);
        add_image_size('apr_gallery_masonry_4', 500, 1024, true);
        add_image_size('apr_gallery_masonrys1', 480, 720, true);
        add_image_size('apr_gallery_masonry2_large', 652, 668, true);
        add_image_size('apr_gallery_masonry2_small', 556, 381, true);
        add_image_size('apr_gallery_packery3vertical', 600, 750, true);
        add_image_size('apr_gallery_packery3big', 1230, 750, true);
        add_image_size('apr_member_galley', 160, 197, true);
    }

}
add_action('after_setup_theme', 'apr_setup');

add_action('admin_enqueue_scripts', 'apr_admin_scripts_css');
function apr_admin_scripts_css() {
    if(is_rtl()){
        wp_enqueue_style('apr_admin_rtl_css', APR_CSS . '/admin-rtl.css', false);
    }
    else{
        wp_enqueue_style('apr_admin_css', APR_CSS . '/admin.css', false);
    }
}
add_action('admin_enqueue_scripts', 'apr_admin_scripts_js');
function apr_admin_scripts_js() {
    wp_register_script('apr_admin_js', APR_JS . '/un-minify/admin.js', array('common', 'jquery', 'media-upload', 'thickbox'), APR_VERSION, true);
    wp_enqueue_script('apr_admin_js');
    wp_localize_script('apr_admin_js', 'apr_params', array(
        'apr_version' => APR_VERSION,
    ));
}
function apr_fonts_url() {
    $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'barber' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Poppins:300,400,700|Open Sans:300,300i,400,400i,600,700|Oswald:300,400,500,600,700|Lato:300,400,700|Montserrat:300,400,500,600,700&subset=latin,latin-ext,vietnamese' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}

//Disable all woocommerce styles
add_filter('woocommerce_enqueue_styles', '__return_false');

function apr_scripts_js() {
    global $apr_settings, $wp_query;
    $cat = $wp_query->get_queried_object();
    if(isset($cat->term_id)){
    $woo_cat = $cat->term_id;
    }else{
        $woo_cat = '';
    }
    $shop_list = '';
    if ( class_exists( 'WooCommerce' ) ) {
    $shop_list = is_product_category();
    }
    $product_list_mode = get_metadata('product_cat', $woo_cat, 'list_mode_product', true);
    $header_sticky_mobile = isset($apr_settings['header-sticky-mobile'])? $apr_settings['header-sticky-mobile'] : '';   
    $apr_text_day = (isset($apr_settings['under-contr-day']) && $apr_settings['under-contr-day'] != '') ? $apr_settings['under-contr-day'] : 'Days'; 
    $apr_text_hour = (isset($apr_settings['under-contr-hour']) && $apr_settings['under-contr-hour'] != '') ? $apr_settings['under-contr-hour'] : 'Hours';  
    $apr_text_min = (isset($apr_settings['under-contr-min']) && $apr_settings['under-contr-min'] != '') ? $apr_settings['under-contr-min'] : 'Mins';  
    $apr_text_sec = (isset($apr_settings['under-contr-sec']) && $apr_settings['under-contr-sec'] != '') ? $apr_settings['under-contr-sec'] : 'Secs';   
    $apr_coming_subcribe_text = (isset($apr_settings['coming_subcribe_text']) && $apr_settings['coming_subcribe_text'] != '') ? $apr_settings['coming_subcribe_text'] : ''; 
    // comment reply
    if ( is_singular() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    // Loads our main js.
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), APR_VERSION, true);
    wp_enqueue_script('image-load', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array(), APR_VERSION, true);     
    wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array('jquery'), APR_VERSION, true);  
    wp_enqueue_script('isotope-packery', get_template_directory_uri() . '/js/packery-mode.pkgd.min.js', array('jquery'), APR_VERSION, true);
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array('jquery'), APR_VERSION, true);
    wp_enqueue_script('fancybox-thumbs', get_template_directory_uri() . '/js/jquery.fancybox-thumbs.js', array('jquery'), APR_VERSION, true);
    wp_enqueue_script('owlcarousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), APR_VERSION, true);
    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), APR_VERSION, true);
    
    wp_enqueue_script('countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), APR_VERSION, true);
    wp_enqueue_script('scrollreveal', get_template_directory_uri() . '/js/un-minify/scrollReveal.js', array('jquery'), APR_VERSION, true);
    wp_enqueue_script('elevate-zoom', get_template_directory_uri() . '/js/un-minify/jquery.elevatezoom.js', array('jquery'), APR_VERSION, true);
    wp_enqueue_script('appear', get_template_directory_uri() . '/js/un-minify/appear.js', array('jquery'), APR_VERSION, true);   
    
    wp_enqueue_script('validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), APR_VERSION);
    if(is_rtl()){
        wp_enqueue_script('apr-custom-rtl', get_template_directory_uri() . '/js/un-minify/custom-rtl.js', array('jquery'), APR_VERSION, true);
    }
    else{
        wp_enqueue_script('apr-custom', get_template_directory_uri() . '/js/un-minify/custom.js', array('jquery'), APR_VERSION, true);
    }
    wp_enqueue_script('apr-script', get_template_directory_uri() . '/js/un-minify/apr_theme.js', array('jquery'), APR_VERSION, true);
    if (isset($apr_settings['js-code'])){
        wp_add_inline_script( 'apr-script', $apr_settings['js-code'] ); 
    }  
    wp_localize_script('apr-script', 'apr_params', array(
        'ajax_url' => esc_js(admin_url( 'admin-ajax.php' )),
        'ajax_loader_url' => esc_js(str_replace(array('http:', 'https'), array('', ''), APR_CSS . '/images/ajax-loader.gif')),
        'ajax_cart_added_msg' => esc_html__('A product has been added to cart.', 'barber'),
        'ajax_compare_added_msg' => esc_html__('A product has been added to compare', 'barber'),
        'type_product' => $product_list_mode,
        'shop_list' => $shop_list,
        'under_end_date' => isset($apr_settings['under-end-date']) ? $apr_settings['under-end-date'] : '',
        'apr_text_day' => $apr_text_day,
        'apr_text_hour' => $apr_text_hour,
        'apr_text_min' => $apr_text_min,
        'apr_text_sec' => $apr_text_sec,
        'apr_like_text' => esc_html__('Like','barber'),
        'apr_unlike_text' => esc_html__('Unlike','barber'),
        'apr_coming_subcribe_text' => $apr_coming_subcribe_text,
        'header_sticky' => isset($apr_settings['header-sticky']) ? $apr_settings['header-sticky'] : '',
        'header_sticky_mobile' => $header_sticky_mobile,
        'request_error' => esc_html__('The requested content cannot be loaded. Please try again later.', 'barber'),
        'popup_close' => esc_html__('Close', 'barber'),
        'popup_prev' => esc_html__('Previous', 'barber'),
        'popup_next' => esc_html__('Next', 'barber'),
    ));
}
add_action('wp_enqueue_scripts', 'apr_scripts_js');
function apr_override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
} 
add_filter('tiny_mce_before_init', 'apr_override_mce_options'); 

