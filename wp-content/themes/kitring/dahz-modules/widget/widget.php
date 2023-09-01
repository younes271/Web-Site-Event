<?php

if ( !class_exists( 'Dahz_Framework_Widget' ) ) {

	Class Dahz_Framework_Widget {

		function __construct() {

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_widget_default_style' ), 1 );

			add_filter( 'get_archives_link', array( $this, 'dahz_framework_archive_count_span' ) );

			add_filter( 'wp_list_categories', array( $this, 'dahz_framework_categories_count_span' ) );

			add_filter( 'get_calendar', array($this, 'dahz_framework_cal_count_span' ) );

			add_filter( 'widget_nav_menu_args', array( $this, 'dahz_framework_custom_menu_rebuild' ) );

			add_filter( 'woocommerce_layered_nav_term_html', array( $this, 'dahz_framework_override_layered_nav_html' ), 10, 4 );

			add_filter( 'get_product_search_form', array( $this, 'dahz_framework_override_product_search_html' ), 10, 1 );

			add_filter( 'woocommerce_rating_filter_count', array( $this, 'dahz_framework_override_rating_html' ), 10, 3 );

			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_enqueue_scripts' ), 10 );

			add_action( 'admin_enqueue_scripts', array( $this, 'dahz_framework_widget_admin_enqueue_scripts' ) );

		}

		public function dahz_framework_widget_admin_enqueue_scripts( $hook ) {

			if ( $hook != 'widgets.php' )
				return;

			//enque Javasript Media API
			wp_enqueue_media();

			wp_enqueue_script( 'dahz-widget-backend', get_template_directory_uri() . '/dahz-modules/widget/assets/js/dahz-widget-backend.js', array( 'jquery' ), null, true );

		}

		public function dahz_framework_enqueue_scripts() {

			wp_enqueue_script( 'dahz-framework-widget', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/widget/assets/js/dahz-framework-widget.min.js', array( 'dahz-framework-script' ), null, true );

		}

		public function dahz_framework_widget_default_style( $style ) {

			$main_accent_color = dahz_framework_get_option(
				"color_general_main_accent_color_regular",
				array(
					'regular'	=> '#333333',
					'hover'		=> '#999999'
				)
			);

			$main_accent_color_hover = !empty( $main_accent_color['hover'] ) ? $main_accent_color['hover'] : '#999999';

			$style .= sprintf(
				'
				.widget.widget_product_search input[type="search"] {
					border-color: %1$s;
				}
				.widget.widget_product_search button {
					color: %2$s;
				}
				.widget_tag_cloud .tagcloud a,
				.widget_product_tag_cloud .tagcloud a,
				.widget_layered_nav a,
				.widget_product_categories a,
				.de-widget.widget_swatches a {
					color: %2$s;
				}
				.widget_tag_cloud .tagcloud a:hover,
				.widget_product_tag_cloud .tagcloud a:hover,
				.widget_layered_nav a:hover,
				.widget_product_categories a:hover,
				.de-widget.widget_swatches a:hover {
					color: %3$s;
				}
				.de-content__sidebar .widget.widget_shopping_cart .woocommerce-mini-cart,
				.de-footer__item .widget.widget_shopping_cart .woocommerce-mini-cart,
				.woocommerce .widget_product_tag_cloud .tagcloud a,
				.widget.widget_tag_cloud .tagcloud a,
				.woocommerce .widget_product_search form:after {
					border-color: %1$s;
				}
				',
				esc_attr( dahz_framework_get_option( 'color_general_divider_color', '#000000' ) ),
				esc_attr( dahz_framework_get_option( 'color_general_body_text_color', '#000000' ) ),
				esc_attr( $main_accent_color_hover )
			);

			return $style;

		}

		public function dahz_framework_override_rating_html( $html, $count, $rating ) {

			return $count;

		}

		public function dahz_framework_override_product_search_html( $html ) {

			$html = sprintf(
				'
				<div class="uk-flex-row">
				<form role="search" method="get" class="woocommerce-product-search" action="%1$s">
				<input type="search" id="woocommerce-product-search-field-%2$s" class="search-field" placeholder="%3$s" value="" name="s">
				<button class="uk-button" type="submit" name="submit" value="Search" aria-label="submit">
					<span data-uk-icon="icon:df_search-flap"></span>
				</button>
				<input type="hidden" name="post_type" value="product">
				</form>

				</div>

				',
				esc_url( site_url() ),
				esc_attr( uniqid() ),
				esc_attr__( 'Search products...', 'kitring' )
			);

			return $html;

		}

		public function dahz_framework_override_layered_nav_html( $term_html, $term, $link, $count ) {

			$term_html = sprintf( '<a href="%1$s"><span class="term">%2$s</span><span class="count">%3$s</span></a>',
				esc_url( $link ),
				esc_html( $term->name ),
				esc_html( $count )
			);

			return $term_html;

		}

		public function dahz_framework_archive_count_span( $links ) {
			$links = str_replace( '</a>&nbsp;( ', '</a><span>', $links);
			$links = str_replace( ' )</li>', '</span></li>', $links);
			return $links;
		}

		public function dahz_framework_categories_count_span( $links ) {
			$links = str_replace( '( ', '<span>', $links);
			$links = str_replace( ' )', '</span>', $links);
			return $links;
		}

		function dahz_framework_cal_count_span( $links ) {
			$links = str_replace( '">&laquo;', '"><span data-uk-icon="arrow-left"></span>', $links);
			$links = str_replace( '&raquo;</a>', '<span data-uk-icon="arrow-right"></span></a>', $links);
			return $links;
		}

		public function dahz_framework_custom_menu_rebuild( $args ) {
			$args['after'] = '<span data-uk-icon="chevron-down"></span>';

			return $args;
		}
	}

	new Dahz_Framework_Widget();

}
