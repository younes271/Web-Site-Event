<?php

if ( !class_exists( 'Dahz_Framework_Woo' ) ) {

	class Dahz_Framework_Woo {

		function __construct(){
			
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
			
			add_action( 'dahz_framework_module_woo_init', array( $this, 'dahz_framework_woo_init' ) );
			
			add_action( 'dahz_framework_module_woo_init', array( $this, 'dahz_framework_woo_single_init' ) );
			
			add_filter( 'dahz_framework_page_title_title_html', array( $this, 'dahz_framework_page_title_woo_endpoint' ) );
			
			add_filter( 'dahz_framework_page_title_breadcrumb_html', array( $this, 'dahz_framework_breadcrumb_woo_endpoint' ) );
			
			// Initialization Function for shop archive page & layout
			$this->dahz_framework_woo_shop();

			// Initialization Function for single product
			$this->dahz_framework_woo_single();
		}
		
		public function dahz_framework_woo_init( $path ){
			
			dahz_framework_include( $path . '/woo-functions.php' );
			dahz_framework_include( $path . '/woo-template-functions.php' );
			
		}

		public function dahz_framework_woo_shop() {

			add_filter( 'woocommerce_locate_template', array( $this, 'dahz_framework_woo_relocate_template' ), 10, 3 );

			add_filter( 'wc_get_template_part', array( $this, 'dahz_framework_woo_content_product' ), 10, 3 );

			add_action( 'dahz_framework_module_woo-shop_init', array( $this, 'dahz_framework_woo_shop_init' ) );

			add_action( 'widgets_init', array( $this, 'dahz_framework_register_shop_widget_area' ), 10 );
			
			add_action( 'woocommerce_before_shop_loop', array( $this, 'dahz_framework_set_loop_product_settings' ), 10 );
			
			add_action( 'dahz_framework_before_content', array( $this, 'dahz_framework_render_after_header' ), 20 );
			
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
			
			add_action( 'woocommerce_after_shop_loop', array( $this, 'dahz_framework_shop_pagination' ), 10 );
			
			add_filter( 'post_class', array( $this, 'dahz_framework_product_post_class' ), 20, 3 );
			
			add_filter( 'loop_shop_per_page', array( $this, 'dahz_framework_loop_shop_per_page' ), 20 );

			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_shop_script' ), 20 );
			
			add_filter( 'woocommerce_product_loop_start', array( $this, 'dahz_framework_remove_loop_product' ), 50 );

		}

		public function dahz_framework_woo_single(){
			add_filter( 'woocommerce_upsells_total', array( $this, 'dahz_framework_up_cross_sells_product_per_page' ), 10 );

			add_filter( 'woocommerce_cross_sells_total', array( $this, 'dahz_framework_up_cross_sells_product_per_page' ), 10 );

			add_filter( 'woocommerce_output_related_products_args', array( $this, 'dahz_framework_related_product_per_page' ), 10 );
		}
		
		public function dahz_framework_page_title_woo_endpoint( $title ){
			
			global $wp_query;
			
			if( ! is_null( $wp_query ) && is_page() && is_wc_endpoint_url() ){
				
				$endpoint       = WC()->query->get_current_endpoint();
				$endpoint_title = WC()->query->get_endpoint_title( $endpoint );
				$title          = $endpoint_title ? $endpoint_title : $title;
				
			}
			
			return $title;
			
		}
		
		public function dahz_framework_breadcrumb_woo_endpoint( $breadcrumb ){
			
			global $wp_query;
			
			if( ! is_null( $wp_query ) && is_page() && is_wc_endpoint_url() ){
				
				$breadcrumb = '';

				ob_start();
					woocommerce_breadcrumb();
					$breadcrumb = ob_get_contents();
				ob_end_clean();
				
			}
			
			return $breadcrumb;
			
		}

		/**
		 * Register Metabox Function For Single Product
		 * 
		 */
		public function dahz_framework_woo_single_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/functions/woo-single-customizers.php' );

			if( is_admin() && !is_customize_preview() ){
				dahz_framework_include( get_template_directory() . '/dahz-modules/woo/functions/woo-single-metabox.php' );
			}

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Woo_Single_Customizer',
				array(
					'id'	=> 'single_woo',
					'title'	=> esc_html__( 'Single Product', 'kitring' ),
					'panel'	=> 'woocommerce',
				),
				array()
			);

		}

		/**
		 * locate woocommerce template
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param $woo_template, $woo_template_name, $woo_template_path
		 * @return $woo_template
		 */
		public function dahz_framework_woo_relocate_template( $woo_template, $woo_template_name, $woo_template_path ) {

			if ( $woo_template_name === 'global/wrapper-start.php' && ( is_shop() || is_product_category() || is_product_tag() || is_tax( 'brand' ) ) ) {

				$woo_template = get_template_directory() . '/dahz-modules/woo/templates/global/wrapper-start.php';

			}

			if ( $woo_template_name === 'global/wrapper-end.php' && ( is_shop() || is_product_category() || is_product_tag() || is_tax( 'brand' ) ) ) {

				$woo_template = get_template_directory() . '/dahz-modules/woo/templates/global/wrapper-end.php';

			}

			if ( $woo_template_name === 'global/sidebar.php' && ( is_shop() || is_product_category() || is_product_tag() || is_tax( 'brand' ) ) ) {

				$woo_template = get_template_directory() . '/dahz-modules/woo/templates/global/sidebar.php';

			}

			if ( $woo_template_name === 'loop/loop-start.php' ) {

				$woo_template = get_template_directory() . '/dahz-modules/woo/templates/loop/loop-start.php';

			}
			
			if ( $woo_template_name === 'loop/loop-end.php' ) {

				$woo_template = get_template_directory() . '/dahz-modules/woo/templates/loop/loop-end.php';

			}

			if ( $woo_template_name === 'loop/rating.php' ) {

				$woo_template = get_template_directory() . '/dahz-modules/woo/templates/loop/rating.php';

			}
			
			if ( $woo_template_name === 'loop/no-products-found.php' ) {

				$woo_template = get_template_directory() . '/dahz-modules/woo/templates/loop/no-products-found.php';

			}

			return $woo_template;

		}

		/**
		 * override woocommerce template
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param $woo_template, $woo_slug, $woo_name
		 * @return $woo_template
		 */
		public function dahz_framework_woo_content_product( $woo_template, $woo_slug, $woo_name ) {

			if ( $woo_slug === 'content' && $woo_name === 'product' ) {

				$woo_template = get_template_directory() . '/dahz-modules/woo/templates/content-product.php';

			}

			return $woo_template;

		}

		/**
		 * Assign new customizer for WooCommerce
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return void
		 */
		public function dahz_framework_woo_shop_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/woo-shop-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Woo_Shop_Customizer',
				array(
					'id'	=> 'shop_woo',
					'title'	=> esc_html__( 'Shop', 'kitring' ),
					'panel'	=> 'woocommerce',
				),
				array()
			);

		}

		/**
		 * register new widget area on shop
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param -
		 * @return -
		 */
		public function dahz_framework_register_shop_widget_area() {
			register_sidebar( array(
				'name'			=> __( 'Shop Filter', 'kitring' ),
				'id'			=> 'shop-sidebar-1',
				'description'	=> __( 'Widgets in this area will ONLY be shown in the shop archive.', 'kitring' ),
				'before_widget'	=> '<section id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</section><hr class="de-sidebar__widget-separator uk-margin-medium" />',
				'before_title'	=> '<h6 class="widget-title">',
				'after_title'	=> '</h6>',
			) );
		}
		
		/**
		 * Set custom settings for loop product
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return -
		 */
		public function dahz_framework_set_loop_product_settings(){
		
			dahz_framework_override_static_option(
				array(
					'loop_product_gutter'							=> dahz_framework_get_option( 'shop_woo_column_gap' ),
					'loop_product_tablet_landscape_column'			=> dahz_framework_get_option( 'shop_woo_tablet_column', '2' ),
					'loop_product_phone_potrait_column'				=> dahz_framework_get_option( 'shop_woo_mobile_column', '1' ),
					'loop_product_phone_landscape_column'			=> dahz_framework_get_option( 'shop_woo_mobile_landscape_column', '2' ),
				)
			);
		
		}
		
		/**	
		 * Customize after header content if WooCommerce is active
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return string
		 */
		public function dahz_framework_render_after_header(){
			
			$content_block = dahz_framework_get_option( 'shop_woo_element_replace_homepage_title' );
			
			if( is_shop() && !empty( $content_block ) ){
				
				echo dahz_framework_do_content_block( apply_filters( 'dahz_framework_override_shop_after_header', $content_block ) );

			}
			
		}
		
		/**
		 * Set single product pagination
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return string
		 */
		public function dahz_framework_shop_pagination(){
			
			$pagination_type = dahz_framework_get_option( 'shop_woo_pagination', 'number' );
			
			if( $pagination_type !== 'number' )
				wp_enqueue_script( 'dahz-framework-woo-shop-pagination' );
			
			dahz_framework_pagination( $pagination_type, false, "ds-shop-pagination ds-shop-pagination-{$pagination_type}" );
			
		}
		
		/**
		 * Add new class for loop product 
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return string
		 * @param $classes, $class, $post_id
		 */
		public function dahz_framework_product_post_class( $classes, $class = '', $post_id = '' ) {
			
			if ( ! $post_id || ! in_array( get_post_type( $post_id ), array( 'product', 'product_variation' ) ) ) {
				return $classes;
			}
			
			$units_sold = get_post_meta( get_the_ID(), 'total_sales', true );
			
			if( $units_sold > 0 ) $classes[] = 'sold';
			
			return $classes;
		}
		
		/**
		 * Setting total of post appear on loop archive
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return int
		 * @param $product_per_page
		 */
		function dahz_framework_loop_shop_per_page( $product_per_page ) {
			
			$product_per_page = dahz_framework_get_option( 'shop_woo_product_per_page', '12' );

			return (int)$product_per_page;
		  
		}
		
		/**
		 * Dequeue and register script for shop archive
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return -
		 */
		public function dahz_framework_shop_script(){
			
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			
			wp_dequeue_style( 'yith-wcwl-main' );
			
			wp_dequeue_style( 'yith-wcwl-font-awesome' );
			
			wp_dequeue_style( 'jquery-selectBox' );
			
			wp_dequeue_script( 'prettyPhoto' );
			
			wp_dequeue_script( 'prettyPhoto-init' );
			
			wp_register_script( 'dahz-framework-woo-shop-pagination', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/woo-shop/assets/js/dahz-framework-woo-shop-pagination.min.js', array( 'dahz-framework-script' ), null, true );
			
		}
		
		/**
		 * -
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return string
		 */
		public function dahz_framework_remove_loop_product( $loop_html ){
			
			$home_page_content_block = dahz_framework_get_option( 'shop_woo_element_replace_homepage_content' );
			
			if( is_shop() && !empty( $home_page_content_block ) && !wc_get_loop_prop( 'is_search' ) && !wc_get_loop_prop( 'is_filtered' ) ){
				
				wc_set_loop_prop( 'total', 0 );

				// This removes pagination and products from display for themes not using wc_get_loop_prop in their product loops.  @todo Remove in future major version.
				global $wp_query;

				if ( $wp_query->is_main_query() ) {
					
					$wp_query->post_count    = 0;
					
					$wp_query->max_num_pages = 0;
					
				}
				
			}
			
			return $loop_html;
			
		}

		/**	
		 * Declare new post perpage for single Up-Sells and Cross-Sells product
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return int
		 */
		public function dahz_framework_up_cross_sells_product_per_page( $limit ){

			$limit = dahz_framework_get_option( 'single_woo_up_cross_sells_per_page', '12' );

			return (int)$limit;

		}

		/**	
		 * Declare new post perpage for related product
		 * 
		 * @since 1.0
		 * @author Dahz
		 * @return int
		 */
		public function dahz_framework_related_product_per_page( $args ){

			$limit = dahz_framework_get_option( 'single_woo_related_per_page', '12' );

			$args['posts_per_page'] = (int)$limit;

			return $args;

		}

	}

	new Dahz_Framework_Woo();

}