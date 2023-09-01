<?php

if ( !class_exists( 'Dahz_Framework_Page_Title' ) ) {

	Class Dahz_Framework_Page_Title {

		public $registered_page_title = array();

		public $content_block = false;

		public function __construct() {

			add_action( 'dahz_framework_module_page-title_init', array( $this, 'dahz_framework_page_title_init' ) );

			add_action( 'dahz_framework_before_content', array( $this, 'dahz_framework_render_page_title' ), 10 );

			add_filter( 'dahz_framework_register_page_title', array( $this, 'dahz_framework_archive_category_page_title' ), 20 );

			add_filter( 'dahz_framework_register_page_title', array( $this, 'dahz_framework_archive_portfolio_page_title' ), 10 );

			add_filter( 'dahz_framework_register_page_title', array( $this, 'dahz_framework_shop_page_title' ), 10 );

			add_filter( 'get_the_archive_title', array( $this, 'dahz_framework_remove_label_title' ), 10 );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_set_page_title' ) );

		}

		public function dahz_framework_remove_label_title( $title ) {

			if ( is_category() ) {

				$title = single_cat_title( '', false );

			} elseif ( is_tag() ) {

				$title = single_tag_title( '', false );

			} elseif ( is_author() ) {

				$title = '<span class="vcard">' . get_the_author() . '</span>';

			} elseif ( is_post_type_archive() ) {

				$title = post_type_archive_title( '', false );

			} elseif ( is_tax() ) {

				$title = single_term_title( '', false );

			} elseif ( is_year() ) {

				$title = get_the_date( _x( 'Y', 'yearly archives date format', 'kitring' ) );

			} elseif ( is_month() ) {

				$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'kitring' ) );

			} elseif ( is_day() ) {

				$title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'kitring' ) );

			}

			return $title;

		}

		public function dahz_framework_page_title_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/page-title-customizers.php' );

			if ( is_admin() ) dahz_framework_include( $path . '/page-title-metaboxes.php' );

		}

		public function dahz_framework_set_page_title( $styles = '' ) {

			$site_width = dahz_framework_get_option( 'layout_site_width', '1200px' );

			# Page Title on Page
			if ( is_page() || ( is_home() && !is_front_page() ) ) {

				$page_id = is_home() && !is_front_page() ? get_option( 'page_for_posts' ) : get_the_ID();

				$enable_breadcrumb = dahz_framework_get_option( 'general_breadcrumbs_on_page', false );

				$this->dahz_framework_register_page_title(
					array(
						'render_location'			=> 'page',
						'layout'					=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_style', 'tasia' ),
						'breadcrumb'				=> $enable_breadcrumb && dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_enable_breadcrumbs', 'on' ) !== 'off' ? dahz_framework_breadcrumbs() : '',
						'title'						=> get_the_title( $page_id ),
						'description'				=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_subtitle', '' ),
						'background'				=> array(
							'background_color'		=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_bg', '' ),
							'background_image'		=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_img', '' ),
							'background_size'		=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_bg_size', 'cover' ),
							'background_repeat'		=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_bg_repeat', 'no-repeat' ),
							'background_position'	=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_bg_position', 'left top' ),
							'background_attachment'	=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_bg_attachment', 'scroll' ),
						),
						'color'					=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_text_color', '#000000' ),
						'color_scheme'			=> dahz_framework_get_meta( $page_id, 'dahz_meta_page', 'page_title_color', 'custom-color' )
					)
				);

			} elseif ( ( ( is_search() || is_archive() ) && !is_tax( 'brand' ) ) && !is_home() && have_posts() ) {

				$this->dahz_framework_register_page_title(
					array(
						'render_location'			=> 'archive',
						'layout'					=> dahz_framework_get_option( 'blog_archive_page_title', 'default' ),
						'breadcrumb'				=> dahz_framework_breadcrumbs(),
						'title'						=> is_search() ? get_search_query() : get_the_archive_title(),
						'description'				=> is_search() ? '' : get_the_archive_description(),
						'background'				=> array(
							'background_color'		=> dahz_framework_get_option( 'blog_archive_background_color', '#fff' ),
							'background_image'		=> dahz_framework_get_option( 'blog_archive_background_image', '' ),
							'background_size'		=> dahz_framework_get_option( 'blog_archive_background_size', 'cover' ),
							'background_repeat'		=> dahz_framework_get_option( 'blog_archive_background_repeat', 'no-repeat' ),
							'background_position'	=> dahz_framework_get_option( 'blog_archive_background_position', 'left top' ),
							'background_attachment'	=> dahz_framework_get_option( 'blog_archive_background_attachment', 'scroll' ),
						),
						'color'					=> dahz_framework_get_option( 'blog_archive_text_color', '#000000' ),
						'color_scheme'			=> 'custom-color'
					)
				);

			} elseif ( is_home() && is_front_page() ) {

				$this->dahz_framework_register_page_title(
					array(
						'render_location'			=> 'home',
						'layout'					=> dahz_framework_get_option( 'blog_template_page_title', 'default' ),
						'breadcrumb'				=> dahz_framework_breadcrumbs(),
						'title'						=> __( 'Posts', 'kitring' ),
						'description'				=> is_search() ? '' : get_the_archive_description(),
						'background'				=> array(
							'background_color'		=> dahz_framework_get_option( 'blog_template_background_color', '#fff' ),
							'background_image'		=> dahz_framework_get_option( 'blog_template_background_image', '' ),
							'background_size'		=> dahz_framework_get_option( 'blog_template_background_size', 'cover' ),
							'background_repeat'		=> dahz_framework_get_option( 'blog_template_background_repeat', 'no-repeat' ),
							'background_position'	=> dahz_framework_get_option( 'blog_template_background_position', 'left top' ),
							'background_attachment'	=> dahz_framework_get_option( 'blog_template_background_attachment', 'scroll' ),
						),
						'color'					=> dahz_framework_get_option( 'blog_template_text_color', '#000000' ),
						'color_scheme'			=> 'custom-color'
					)
				);

			} elseif ( class_exists( 'Woocommerce' ) && is_product_category() ) {
				# Page Title on Product Category
				$woocommerce_breadcrumb = '';

				if ( dahz_framework_get_option( 'breadcrumbs_is_on_archive_product', true ) ) {
					ob_start();
						woocommerce_breadcrumb();
						$woocommerce_breadcrumb = ob_get_contents();
					ob_end_clean();
				}

				$this->dahz_framework_register_page_title(
					array(
						'render_location'			=> 'archive_product_category',
						'layout'					=> dahz_framework_get_option( 'shop_woo_cat_page_title', 'default' ),
						'breadcrumb'				=> $woocommerce_breadcrumb,
						'title'						=> is_search() ? get_search_query() : get_the_archive_title(),
						'description'				=> is_search() ? '' : get_the_archive_description(),
						'background'				=> array(
							'background_color'		=> dahz_framework_get_option( 'shop_woo_cat_background_color', '#fff' ),
							'background_image'		=> dahz_framework_get_option( 'shop_woo_cat_background_image', '' ),
							'background_size'		=> dahz_framework_get_option( 'shop_woo_cat_background_size', 'cover' ),
							'background_repeat'		=> dahz_framework_get_option( 'shop_woo_cat_background_repeat', 'no-repeat' ),
							'background_position'	=> dahz_framework_get_option( 'shop_woo_cat_background_position', 'left top' ),
							'background_attachment'	=> dahz_framework_get_option( 'shop_woo_cat_background_attachment', 'scroll' ),
						),
						'color'					=> dahz_framework_get_option( 'shop_woo_cat_text_color', '#000000' ),
						'color_scheme'			=> 'custom-color'
					)
				);

			} elseif ( class_exists( 'Woocommerce' ) && is_tax( 'brand' ) ){

				$woocommerce_breadcrumb = '';

				if ( dahz_framework_get_option( 'breadcrumbs_is_on_archive_product', true ) ) {
					ob_start();
						woocommerce_breadcrumb();
						$woocommerce_breadcrumb = ob_get_contents();
					ob_end_clean();
				}

				$this->dahz_framework_register_page_title(
					array(
						'render_location'			=> 'archive_product_brand',
						'layout'					=> dahz_framework_get_option( 'shop_woo_brand_page_title', 'default' ),
						'breadcrumb'				=> $woocommerce_breadcrumb,
						'title'						=> is_search() ? get_search_query() : get_the_archive_title(),
						'description'				=> is_search() ? '' : get_the_archive_description(),
						'background'				=> array(
							'background_color'		=> dahz_framework_get_option( 'shop_woo_brand_background_color', '#fff' ),
							'background_image'		=> dahz_framework_get_option( 'shop_woo_brand_background_image', '' ),
							'background_size'		=> dahz_framework_get_option( 'shop_woo_brand_background_size', 'cover' ),
							'background_repeat'		=> dahz_framework_get_option( 'shop_woo_brand_background_repeat', 'no-repeat' ),
							'background_position'	=> dahz_framework_get_option( 'shop_woo_brand_background_position', 'left top' ),
							'background_attachment'	=> dahz_framework_get_option( 'shop_woo_brand_background_attachment', 'scroll' ),
						),
						'color'					=> dahz_framework_get_option( 'shop_woo_brand_text_color', '#000000' ),
						'color_scheme'			=> 'custom-color'
					)
				);

			} elseif( is_singular( 'portfolio' ) ){

				$page_id = get_the_ID();

				$enable_breadcrumb = dahz_framework_get_option( 'general_breadcrumbs_on_portfolio', false );

				$this->dahz_framework_register_page_title(
					array(
						'render_location'			=> 'portfolio',
						'layout'					=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_style', 'tasia' ),
						'breadcrumb'				=> $enable_breadcrumb && dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_enable_breadcrumbs', 'off' ) !== 'off' ? dahz_framework_breadcrumbs() : '',
						'title'						=> get_the_title( $page_id ),
						'description'				=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_subtitle', '' ),
						'background'				=> array(
							'background_color'		=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_bg', '' ),
							'background_image'		=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_img', '' ),
							'background_size'		=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_bg_size', 'cover' ),
							'background_repeat'		=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_bg_repeat', 'no-repeat' ),
							'background_position'	=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_bg_position', 'left top' ),
							'background_attachment'	=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_bg_attachment', 'scroll' ),
						),
						'color'					=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_text_color', '#000000' ),
						'color_scheme'			=> dahz_framework_get_meta( $page_id, 'dahz_meta_portfolio', 'page_title_color', 'custom-color' )
					)
				);

			} 

			$this->registered_page_title = apply_filters( 'dahz_framework_register_page_title', $this->registered_page_title );

			$color_scheme = isset( $this->registered_page_title['color_scheme'] ) ? $this->registered_page_title['color_scheme'] : 'custom-color';

			switch ( $color_scheme ) {
				case 'light':
					$page_title_color = dahz_framework_get_option( 'color_transparent_global_color_light', '#ffffff' );
					break;
				case 'dark':
					$page_title_color = dahz_framework_get_option( 'color_transparent_global_color_dark', '#000000' );
					break;
				default:
					$page_title_color = !empty( $this->registered_page_title['color'] ) ? $this->registered_page_title['color'] : '#000000';

			}

			$styles .= sprintf('
				.page-header .de-page-title__row {
					max-width: %s;
				}
				.de-page-title:not([data-layout="tasia"]) *{
					color: %s!important;
				}
				',
				esc_attr( $site_width ),
				esc_attr( $page_title_color )
			);

			return $styles;
		}

		public function dahz_framework_archive_category_page_title( $page_title ) {
			# Page Title on Archive Taxonomy
			if ( ( ( is_archive() && is_category() ) || ( is_archive() && is_tax() ) ) && !is_post_type_archive( 'portfolio' ) ) {

				$term = get_queried_object();

				if ( !empty( $term ) && dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_style', 'inherit' ) !== 'inherit' ) {
					$page_title['layout']			= dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_style', 'inherit' );
					$page_title['breadcrumb']		= dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_breadcrumbs', 'off' ) == 'off' ? '' : $page_title['breadcrumb'];
					$page_title['background']		= $this->dahz_framework_page_title_background(
						array(
							'background_color'		=> dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_bg', '' ),
							'background_image'		=> dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_img', '' ),
							'background_size'		=> dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_bg_size', 'cover' ),
							'background_repeat'		=> dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_bg_repeat', 'no-repeat' ),
							'background_position'	=> dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_bg_position', 'left top' ),
							'background_attachment'	=> dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_bg_attachment', 'scroll' ),
						)
					);
					$page_title['color'] = dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_text_color', '#000000' );
					$page_title['color_scheme'] = dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'page_title_color', 'custom-color' );
				}

			}

			return $page_title;
		}

		public function dahz_framework_archive_portfolio_page_title( $page_title ) {

			# Page Title on Archive Portfolio
			if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_categories' ) ) {
				$page_title['render_location']	= 'archive-portfolio';
				$page_title['layout']			= dahz_framework_get_option( 'portfolio_archive_page_title', 'default' );
				$page_title['breadcrumb']		= dahz_framework_breadcrumbs();
				$page_title['background']		= $this->dahz_framework_page_title_background(
					array(
						'background_color'		=> dahz_framework_get_option( 'portfolio_archive_background_color', '#fff' ),
						'background_image'		=> dahz_framework_get_option( 'portfolio_archive_background_image', '' ),
						'background_size'		=> dahz_framework_get_option( 'portfolio_archive_background_size', 'cover' ),
						'background_repeat'		=> dahz_framework_get_option( 'portfolio_archive_background_repeat', 'no-repeat' ),
						'background_position'	=> dahz_framework_get_option( 'portfolio_archive_background_position', 'left top' ),
						'background_attachment'	=> dahz_framework_get_option( 'portfolio_archive_background_attachment', 'scroll' ),
					)
				);
				$page_title['color'] = dahz_framework_get_option( 'portfolio_archive_text_color', '#000000' );
				$page_title['color_scheme']	= 'custom-color';

			}

			return $page_title;
		}

		public function dahz_framework_shop_page_title( $page_title ) {
			# Page Title on Product Archive
			if ( class_exists( 'Woocommerce' ) && is_shop() ) {

				$shop = get_option( 'woocommerce_shop_page_id' );

				$woocommerce_breadcrumb = '';

				ob_start();
					/**
					 * woocommerce_archive_description hook.
					 *
					 * @hooked woocommerce_taxonomy_archive_description - 10
					 * @hooked woocommerce_product_archive_description - 10
					 */
					do_action( 'woocommerce_archive_description' );
					$woocommerce_description = ob_get_contents();
				ob_end_clean();

				ob_start();
					woocommerce_breadcrumb();
					$woocommerce_breadcrumb = ob_get_contents();
				ob_end_clean();

				$page_title = array(
					'render_location'				=> 'page_home',
					'layout'						=> dahz_framework_get_option( 'shop_woo_home_page_page_title', 'default' ),
					'breadcrumb'					=> $woocommerce_breadcrumb,
					'title'							=> !empty( $shop ) ? get_the_title( $shop ) : __( 'Shop', 'kitring' ),
					'description'					=> !empty( $shop ) ? $woocommerce_description : '',
					'background'					=> $this->dahz_framework_page_title_background(
						array(
							'background_color'		=> dahz_framework_get_option( 'shop_woo_home_page_background_color', '#fff' ),
							'background_image'		=> dahz_framework_get_option( 'shop_woo_home_page_background_image', '' ),
							'background_size'		=> dahz_framework_get_option( 'shop_woo_home_page_background_size', 'cover' ),
							'background_repeat'		=> dahz_framework_get_option( 'shop_woo_home_page_background_repeat', 'no-repeat' ),
							'background_position'	=> dahz_framework_get_option( 'shop_woo_home_page_background_position', 'left top' ),
							'background_attachment'	=> dahz_framework_get_option( 'shop_woo_home_page_background_attachment', 'scroll' ),
						)
					),
					'color'					=> dahz_framework_get_option( 'shop_woo_home_page_text_color', '#000000' ),
					'color_scheme'			=> 'custom-color'
				);

			}

			return $page_title;

		}

		public function dahz_framework_render_page_title() {

			$layout = '';

			$page_titles = $this->registered_page_title;

			if ( is_array( $page_titles ) && !empty( $page_titles ) ) {
				$layout = $page_titles['layout'];

				if ( $layout !== 'disable' ) {
					dahz_framework_get_template(
						"page-title.php",
						array(
							'render_location'	=> $page_titles['render_location'],
							'layout'			=> $layout,
							'title'				=> $page_titles['title'],
							'description'		=> $page_titles['description'],
							'background'		=> $page_titles['background'],
							'breadcrumb'		=> $page_titles['breadcrumb'],
						),
						'dahz-modules/page-title/templates/'
					);
				}
			}

		}

		public function dahz_framework_page_title_background( $background ) {

			if ( !is_array( $background ) || empty( $background ) ) return;

			$inline_style = '';

			$image_url = '';

			$inline_style = sprintf(
				'background-color:%1$s;',
				isset( $background['background_color'] ) ? $background['background_color'] : '#ffffff'
			);

			if ( !empty( $background['background_image'] ) ){

				if ( strpos( $background['background_image'], 'http' ) !== false ) {

					$image_url = $background['background_image'];

				} else {

					$image_url = wp_get_attachment_image_src( $background['background_image'], 'full' );

					$image_url = isset( $image_url[0] ) ? $image_url[0] : '';

				}

				if ( !empty( $image_url ) ) {

					$inline_style .= sprintf(
						'background-image:url(%1$s);background-position:%2$s;background-repeat:%3$s;background-size:%4$s;background-attachment:%5$s;',
						$image_url,
						isset( $background['background_position'] ) ? esc_attr( $background['background_position'] ) : 'left top',
						isset( $background['background_repeat'] ) ? esc_attr( $background['background_repeat'] ) : 'no-repeat',
						isset( $background['background_size'] ) ? esc_attr( $background['background_size'] ) : 'cover',
						isset( $background['background_attachment'] ) ? esc_attr( $background['background_attachment'] ) : 'scroll'
					);

				}
			}

			return $inline_style;
		}

		public function dahz_framework_register_page_title( $args = array() ) {

			$this->registered_page_title = array(
				'render_location'	=> isset( $args['render_location'] ) ? $args['render_location']	: 'home',
				'layout'			=> isset( $args['layout'] )			 ? $args['layout']			: 'default',
				'breadcrumb'		=> isset( $args['breadcrumb'] )		 ? $args['breadcrumb']		: '',
				'title'				=> isset( $args['title'] )			 ? $args['title']			: '',
				'description'		=> isset( $args['description'] )	 ? $args['description']		: '',
				'color_scheme'		=> isset( $args['color_scheme'] )	 ? $args['color_scheme']	: 'custom-color',
				'color'				=> isset( $args['color'] )	 		 ? $args['color']			: '#000000',
				'background'		=> $this->dahz_framework_page_title_background( isset( $args['background'] ) ? $args['background'] : array() )
			);

		}

	}

	new Dahz_Framework_Page_Title();

}
