<?php

/**
 * Dahz_Framework_Header_Search
 */

class Dahz_Framework_Header_Search {

	function __construct() {

		add_action( 'init', array( $this, 'dahz_framework_header_search_init' ), 999 );

		add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_header_search_script' ), 10 );

		add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_header_search_style' ), 10, 1 );

		add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_header_item_search' ), 10, 3 );

		add_filter( 'dahz_framework_header_mobile_elements', array( $this, 'dahz_framework_header_item_mobile_search' ), 10, 3 );

		add_filter( 'dahz_framework_customize_headermobile_builder_items', array( $this, 'dahz_framework_header_item_mobile_search' ) );

		add_filter( 'dahz_framework_preset_required', array( $this, 'dahz_framework_exclude_preset_required' ) );

		add_action( 'wp_ajax_nopriv_dahz_framework_search_product_render', array( $this, 'dahz_framework_search_product_render' ), 10 );

		add_action( 'wp_ajax_dahz_framework_search_product_render', array( $this, 'dahz_framework_search_product_render' ), 10 );

		add_action( 'wp_footer', array( $this, 'dahz_framework_render_search_modal' ), 10 );

		# Unremark if search need autocomplete and suggestion

	}

	public function dahz_framework_header_search_init( $path ) {
		if ( is_customize_preview() ) dahz_framework_include( get_template_directory() . '/dahz-modules/header-search/header-search-customizer.php' );

		dahz_framework_register_customizer(
			'Dahz_Framework_Header_Search_Customizer',
			array(
				'id'	=> 'header_search',
				'title'	=> array( 'title' => esc_html__( 'Search', 'kitring' ), 'priority' => 14 ),
				'panel'	=> 'header'
			),
			array()
		);
	}

	public function dahz_framework_header_search_script() {

		wp_register_script( 'dahz-framework-header-search', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/header-search/assets/js/dahz-framework-header-search.min.js', array( 'dahz-framework-script' ), null, true );

	}

	public function dahz_framework_exclude_preset_required( $preset_required ) {
		$preset_required['headermobile']['exclude_sections'][] = 'header_search';

		return $preset_required;
	}

	/**
	 * register header element: search
	 *
	 * @param $items
	 * @return $items
	 */
	public function dahz_framework_header_item_search( $items ) {
		$items['search'] = array(
			'title'				=> esc_html__( 'Search', 'kitring' ),
			'description'		=> esc_html__( 'Display ajax search', 'kitring' ),
			'render_callback'	=> array( $this, 'dahz_framework_header_elem_search' ),
			'section_callback'	=> 'header_search',
			'is_repeatable'		=> false
		);

		return $items;
	}

	/**
	 * register header mobile element: search
	 *
	 * @param $items
	 * @return $items
	 */
	public function dahz_framework_header_item_mobile_search( $items ) {
		$items['search_mobile'] = array(
			'title'				=> esc_html__( 'Search', 'kitring' ),
			'description'		=> esc_html__( 'Display ajax search', 'kitring' ),
			'render_callback'	=> array( $this, 'dahz_framework_header_elem_search' ),
			'section_callback'	=> 'header_search',
			'is_repeatable'		=> false
		);

		return $items;
	}

	/**
	 * render header element : search button
	 *
	 * @param -
	 * @return -
	 */
	public function dahz_framework_header_elem_search( $builder_type, $section, $row, $column ) {

		wp_enqueue_script( 'dahz-framework-header-search' );

		$search_style = dahz_framework_get_option( 'header_search_style', 'icon-text' );

		$search_icon = '';

		$search_link_content = '';

		if ( $search_style == 'icon' || $search_style == 'text-icon' ) {

			$icon_ratio = $builder_type == 'header' ? dahz_framework_get_option( 'header_search_desktop_icon_ratio', '1' ) : dahz_framework_get_option( 'header_search_mobile_icon_ratio', '1' );

			$search_icon = sprintf(
				'<span data-uk-icon="icon:df_search-flip;ratio:%1$s;"></span>',
				(float)$icon_ratio
			);

		} else if ( $search_style == 'icon-text' || $search_style == 'icon-right' ) {

			$icon_ratio = $builder_type == 'header' ? dahz_framework_get_option( 'header_search_desktop_icon_ratio', '1' ) : dahz_framework_get_option( 'header_search_mobile_icon_ratio', '1' );

			$search_icon = sprintf(
				'<span data-uk-icon="icon:df_search-flap;ratio:%1$s;"></span>',
				(float)$icon_ratio
			);

		}

		switch( $search_style ) {
			case 'text':
				$search_link_content = '<span>' . __( 'Search', 'kitring' ) . '</span>';
				break;
			case 'icon':
			case 'icon-right':
				$search_link_content = $search_icon;
				break;
			case 'icon-text':
				$search_link_content = '<span class="uk-margin-small-right">' . __( 'Search', 'kitring' ) . '</span>' . $search_icon;
				break;
			default:
				$search_link_content = $search_icon . '<span class="uk-margin-small-left">' . __( 'Search', 'kitring' ) . '</span>';
				break;
		}

		echo apply_filters(
			'dahz_framework_header_search_button',
			sprintf(
				'
				<div class="de-header__search">
					<a aria-label="%3$s" href="#" class="uk-flex uk-flex-middle de-header__search-btn%2$s" data-uk-toggle="target: #header-search-modal">
						%1$s
					</a>
				</div>
				',
				$search_link_content,
				dahz_framework_get_option( 'header_search_enable_uppercase', false ) ? ' uk-text-uppercase' : '',
				__( 'Search', 'kitring' )
			),
			$builder_type
		);

	}

	/**
	 * render header element : search modal
	 *
	 * @param $output
	 * @return $output
	 */
	public function dahz_framework_render_search_modal() {

		global $dahz_framework;

		$search_output = '';

		if ( isset( $dahz_framework->builder_items['search'] ) || isset( $dahz_framework->builder_items['search_mobile'] ) ) {

			$search_output = sprintf(
				'
				<div id="header-search-modal" data-uk-modal>
					<div class="de-header-search__body uk-modal-dialog uk-modal-body uk-container">
						<a class="uk-modal-close-default uk-close-large" data-uk-close></a>
						<div class="uk-grid" data-uk-grid>
							<div class="uk-width-1-1 uk-position-relative">
								<input type="text" class="uk-input uk-modal-title" placeholder="%s" name="keyword" />
								<div class="uk-position-center-right uk-position-large uk-invisible" data-uk-spinner></div>
							</div>
							<div class="de-header-search__result uk-width-1-1"></div>
						</div>
					</div>
				</div>
				',
				class_exists( 'WooCommerce' ) ? esc_attr__( 'Search by brand, name, etc', 'kitring' ) : esc_attr__( 'Search', 'kitring' )
			);

			echo apply_filters( 'dahz_framework_header_render_search_modal', $search_output );

		}

	}

	/**
	 * set header search style from customizer
	 *
	 * @param $style
	 * @return $style
	 */
	public function dahz_framework_header_search_style( $style ) {

		$style .= apply_filters( 'dahz_framework_header_render_search_style', sprintf(
			'
			.de-header__wrapper .de-header__search > a span{
				font-size:%1$s;
			}
			.de-header-mobile__wrapper .de-header__search > a span{
				font-size:%2$s;
			}
			',
			dahz_framework_get_option( 'header_search_desktop_font_size', '18px' ),
			dahz_framework_get_option( 'header_search_mobile_font_size', '18px' )
		) );

		return $style;

	}

	/**
	 * all in one query search
	 *
	 * @param -
	 * @return $query_return
	 */
	public function dahz_framework_search_query() {

		// Get selected list from customizer
		$brands     = dahz_framework_get_option( 'header_search_brand_taxonomies', '' );
		$categories = dahz_framework_get_option( 'header_search_category_taxonomies', '' );
		$search_post_types = dahz_framework_get_option( 'header_search_post_type', array( 'post', 'page' ) );

		// Get keyword from input
		$keyword   = strtolower( $_POST[ 'keyword' ] );
		// Count how many words on keyword
		$pre_count = preg_split( '/\s+/', $keyword );
		$key_count = count( $pre_count );
		// Set if result ONLY show categories and brands
		$is_cat_only     = '0' === $categories[0] && count($categories) == '1' ? false : true;
		$is_brand_only   = '0' === $brands[0] && count($brands) == '1' ? false : true;
		$result_cat_only = class_exists( 'WooCommerce' ) && '' === $keyword && ($is_cat_only || $is_brand_only) ? true : false;
		// Setup query for collecting all query result
		$search_query = new WP_Query();

		$pid_posts       = array();
		$sku_posts       = array();
		$name_posts      = array();
		$post_posts      = array();
		$portfolio_posts = array();
		$brand_posts     = array();
		$category_posts  = array();

		if ( class_exists( 'WooCommerce' ) && in_array( 'product', $search_post_types ) ) {
			if ( !$result_cat_only ) {
				# $args for product id
				$pid_args		= array(
					'post_type'	=> 'product',
					'p'			=> $keyword
				);
				$pid_query = new WP_Query( $pid_args );

				if ( count( $pid_query->posts ) <> 1 ) : $pid_query->posts = array(); endif;
				$pid_posts = $pid_query->posts;
				# $args for product sku
				$sku_args		= array(
					'post_type'	=> 'product',
				);
				$sku_args['meta_query'][] = array(
					'key'		=> '_sku',
					'value'		=> "{$keyword}",
					'compare'	=> 'LIKE'
				);
				$sku_query = new WP_Query( $sku_args );
				$sku_posts = $sku_query->posts;
				# $args for product name
				$name_args		= array(
					'post_type'	=> 'product',
					's'			=> $keyword
				);
				$name_query = new WP_Query( $name_args );
				$name_posts = $name_query->posts;
			}
			# $args for product brand
			$brand_args		= array(
				'post_type'	=> 'product',
				'tax_query'	=> array(
					array(
						'taxonomy'	=> 'brand',
						'field'		=> $result_cat_only ? 'id' : 'slug',
						'terms'		=> $result_cat_only ? $brands : $keyword
					)
				),
			);
			$brand_query = new WP_Query( $brand_args );
			$brand_posts = $brand_query->posts;
			# $args for product category
			$category_args	= array(
				'post_type'	=> 'product',
				'tax_query'	=> array(
					array(
						'taxonomy'	=> 'product_cat',
						'field'		=> $result_cat_only ? 'id' : 'slug',
						'terms'		=> $result_cat_only ? $categories : $keyword
					)
				),
			);
			$category_query = new WP_Query( $category_args );
			$category_posts = $category_query->posts;
		}

		# $args for post name
		if ( in_array( 'post', $search_post_types ) || in_array( 'portfolio', $search_post_types ) || in_array( 'page', $search_post_types ) ) {

			$post_type_to_query = array();

			if ( in_array( 'post', $search_post_types ) ) $post_type_to_query[] = 'post';

			if ( in_array( 'portfolio', $search_post_types ) && class_exists( 'DahzExtender_Portfolios' ) ) $post_type_to_query[] = 'portfolio';

			if ( in_array( 'page', $search_post_types ) ) $post_type_to_query[] = 'page';

			$post_args		= array(
				'post_type'	=> $post_type_to_query,
				's'			=> $keyword
			);
			$post_query = new WP_Query( $post_args );
			$post_posts = $post_query->posts;
		}
		# Collecting all query result into one array
		$search_query->posts = array_unique(
			array_merge(
				$pid_posts,
				$sku_posts,
				$name_posts,
				$post_posts,
				$portfolio_posts,
				$brand_posts,
				$category_posts
			)
		, SORT_REGULAR );
		# Count post for itterating post on render
		$search_query->post_count = count( $search_query->posts );

		$query_return   = array();
		$query_return[] = $key_count;
		$query_return[] = $search_query;
		$query_return[] = $keyword;

		return $query_return;

	}

	/**
	 * query with passed value from ajax after hovering on selected category
	 *
	 * @param -
	 * @return -
	 */
	public function dahz_framework_search_suggestion_query() {

		$pre_count = preg_split( '/\s+/', $_POST['keyword']);
		$key_count = count($pre_count);

		$in_args = array(
			'post_type'	=> 'product',
			's'			=> $_POST['keyword'],
			'tax_query'	=> array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'id',
					'terms' => $_POST['cat_id']
				)
			),
		);
		$in_query = new WP_Query( $in_args );

		$query_return	= array();
		$query_return[] = $key_count;
		$query_return[] = $in_query;

		$this->dahz_framework_search_product_render($query_return);

	}

	/**
	 * render search result
	 *
	 * @param $query
	 * @return -
	 */
	public function dahz_framework_search_product_render( $query = false ) {
		$search_query = !$query ? $this->dahz_framework_search_query() : $query;

		$search_result = $search_query[1];

		$list_output = '';

		if ( $search_result->have_posts() ) :
			while ( $search_result->have_posts() ) : $search_result->the_post();
				$post_type = get_post_type();

				$title = get_the_title();

				$thumbnail = get_the_post_thumbnail( get_the_ID(), 'shop_catalog', array( 'class' => 'de-ratio-content' ) );

				$post_link = get_permalink();

				$categories = dahz_framework_get_post_meta_categories();

				$list_output = sprintf(
					'
					<li class="entry-item">
						<div class="entry-image de-ratio de-ratio-4-3 uk-margin-small-bottom" style="background-color: #eee;">
							%s
						</div>
						<h6 class="entry-title"><a href="%s">%s</a></h6>
						<div class="entry-categories">
							%s
						</div>
					</li>
					',
					$thumbnail,
					$post_link,
					$title,
					$categories
				);

				echo apply_filters( 'dahz_framework_header_search_list', $list_output, $thumbnail, $post_link, $title, $categories );

			endwhile;
		endif;

		wp_reset_postdata();

		die();
	}

	/**
	 * render search suggestion
	 *
	 * @param -
	 * @return -
	 */
	public function dahz_framework_search_suggestion_render() {

		$search_query = $this->dahz_framework_search_query();

		$search_result = $search_query[1];

		if ( $search_result->have_posts() ) :

			$search_searched = array();

			echo '<ul class="row m-b--0">';

			echo '<li class="ui-menu-item"><div class="ds-search--cat-hover-keyword"><span class="ds-search__keyword"></span></div></li>';

			while ( $search_result->have_posts() ) : $search_result->the_post();

				global $product;

				if ( $product ) {

					foreach( $product->get_category_ids() as $id ) {

						if ( !in_array( $id, $search_searched ) ) {

							$search_searched[] = $id;

						}

					}

				}

			endwhile;

			foreach( $search_searched as $id ) {

				$term = get_term_by( 'id', $id, 'product_cat' );

				echo '<li class="ui-menu-item ui-menu-item-category"><div class="ds-search--cat-hover-search" data-suggest-id="'. $id .'"><span class="ds-search__keyword-extra"></span><span class="de-header-search__keyword-category">'. $term->name . '</span></div></li>';

			}

			echo '</ul>';

		endif;

		wp_reset_postdata();

		die();

	}

	/**
	 * get data for search suggestion
	 *
	 * @param -
	 * @return -
	 */
	public function dahz_framework_search_autocomplete_src() {

		$search_suggested = array();

		$search_query  = $this->dahz_framework_search_query();

		$search_countd = $search_query[0] + 1;

		$search_result = $search_query[1];

		$keyword = $search_query[2];

		if ( $search_result->have_posts() ) :

			while ( $search_result->have_posts() ) : $search_result->the_post();

				$post_type = get_post_type();

				if ( $post_type == 'product' ) {

					global $product;

					$text = $product->get_short_description();

					$cnt = $search_countd;

					$words = explode( ' ', $text);

					$result = array();

					$icnt = count($words) - ($cnt-1);

					for ($i = 0; $i < $icnt; $i++) {

						$str = '';

						for ($o = 0; $o < $cnt; $o++) {

							$str .= $words[$i + $o] . ' ';

						}

						if ( preg_match( '#' . $keyword . '#', $str, $matches ) ) {

							$search_suggested[] = trim( strtr( $str, array( '.' => '', ',' => '', '"' => '' ) ) );

						}

					}

					if ( preg_match( '#' . $keyword . '#', get_cat_name( $cat_id ), $matches ) ) {

						$search_suggested[] = get_cat_name( $cat_id );

					}

					$search_suggested[] =  $product->get_name();

				}

			endwhile;

			$search_suggested = array_values( array_unique( array_map( 'strtolower', $search_suggested ) ) );

			echo json_encode( $search_suggested );

		endif;

		wp_reset_postdata();

		die();

	}

}

new Dahz_Framework_Header_Search();
