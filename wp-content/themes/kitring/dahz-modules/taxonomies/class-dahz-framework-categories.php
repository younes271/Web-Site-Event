<?php

if( !class_exists('Dahz_Framework_Categories') ){

	Class Dahz_Framework_Categories {

		public $terms;

		public $alphabet;

		public $brand_items_vsprintf = '';

		public $brand_items = array();

		public $letters_tab = '';

		function __construct(){

			add_action( 'dahz_framework_before_page_brand', array( $this, 'dahz_framework_set_brand') );

			add_action( 'dahz_framework_brand_indexes', array( $this, 'dahz_framework_render_brand_index') );

			add_action( 'dahz_framework_brand_categories', array( $this, 'dahz_framework_render_brand_categories') );

			add_action( 'dahz_framework_brand_items', array( $this, 'dahz_framework_render_brand_items') );

			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_page_brand_script' ), 20 );

		}

		public function dahz_framework_page_brand_script(){

			wp_register_script( 'dahz-framework-page-brand', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/taxonomies/assets/js/dahz-framework-page-brand.min.js', array( 'dahz-framework-script' ), null, true );

		}

		public function dahz_framework_set_brand() {

			$i = 1;

			$is_display_alphabet = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'display_alphabet_filter', 'on' );

			foreach ( range( 'A', 'Z' ) as $alphabet ) {

				if( $is_display_alphabet == 'on' ){

					$this->letters_tab .= sprintf(
						'
						<li>
							<a class="de-brands-index__item" href="#brand-item-index-%1$s">%2$s</a>
						</li>
						',
						$alphabet,
						esc_html( $alphabet )
					);

				}

				$this->brand_items_vsprintf .= '
					<div id="brand-item-index-'. $alphabet .'" class="de-brand-items__container de-brand-items__container--filter-active uk-text-capitalize">
						<h3>'. esc_html( $alphabet ) .'</h3>
							%' . $i . '$s
					</div>
				';

				$this->brand_items[] = '';

				$i++;

			}

			$this->brand_items_vsprintf .= '
				<div id="brand-item-index-0-9" class="de-brand-items__container de-brand-items__container--filter-active uk-text-capitalize">
					<h3>'. esc_html__( '0-9', 'kitring' ) .'</h3>
						%' . $i++ . '$s
				</div>
			';

			$this->brand_items[] = '';

		}

		public function dahz_framework_render_brand_index() {

			echo apply_filters(
				'dahz_framework_brand_letters',
				sprintf(
					'
					<ul class="uk-flex-center" data-uk-tab>
						%1$s
						<li>
							<a class="de-brands-index__item" href="#brand-item-index-0-9">%2$s</a>
						</li>
					</ul>
					',
					$this->letters_tab,
					__( '0-9', 'kitring' )
				)
			);

		}

		public function dahz_framework_render_brand_categories() {

			$product_categories = get_terms(
				'product_cat',
				array(
			    	'orderby' => 'name',
    				'parent'  => 0,
    				'hide_empty' => 0
				)
			);

			$product_categories_output = '';

			foreach( $product_categories as $cat ){

				$product_categories_output .= sprintf(
					'
					<li>
						<a data-category="%1$s" class="de-brands-categories__item button category uk-text-capitalize">%2$s</a>
					</li>
					',
					$cat->slug,
					$cat->name
				);

			}

			echo apply_filters(
				'dahz_framework_brand_letters_by_categories',
				sprintf(
					'
					<ul class="uk-flex-center" data-uk-tab>
						%1$s
						<li>
							<a class="de-brands-categories__item" data-category="*">%2$s</a>
						</li>
					</ul>
					',
					$product_categories_output,
					__( 'All', 'kitring' )
				)
			);

		}

		public function dahz_framework_filter_array( $term ){

			return substr( $term->name, 0, 1 ) == $this->alphabet;

		}

		public function dahz_framework_filter_array_numeric( $term ){

			return is_numeric( substr( $term->name, 0, 1 ) );

		}

		public function dahz_framework_render_brand_items() {

			wp_enqueue_script( 'dahz-framework-page-brand' );

			$brand_list = get_terms( array(
					'taxonomy'          => 'brand',
					'hide_empty'        => false,
					'orderby'           => 'name',
					'order'             => 'ASC'
				)
			);

			if( !is_wp_error( $brand_list ) && !empty( $brand_list ) ){

				foreach( $brand_list as $brand ){

					$first_alphabet = ( substr( $brand->name, 0, 1 ) );

					// find index alphabet from first letter of term name
					$index = ( ord( strtoupper( $first_alphabet ) ) - ord( 'A' ) + 1 ) - 1;

					$index = !isset( $this->brand_items[$index] ) ? 26 : $index;

					$is_enabled_label = dahz_framework_get_term_meta( 'brand', $brand->term_id, 'enable_new_brand', 'off' );

					$categories = dahz_framework_get_term_meta( 'brand', $brand->term_id, 'categories', '' );

					if( !empty( $categories ) ){

						$categories = explode( ',', $categories );

					}

					$this->brand_items[$index] .= sprintf(
						'
						<a class="de-brand-items__link%4$s" href="%1$s">
							%2$s
							%3$s
						</a>
						',
						get_term_link( $brand->term_id ),
						esc_html( $brand->name ),
						$is_enabled_label == 'on' ? '<span>' . esc_html__( 'New', 'kitring' ) . '</span>' : '',
						!empty( $categories ) && is_array( $categories ) ? ' ' . implode( ' ', $categories ) : ''
					);

				}

			}

			echo vsprintf( $this->brand_items_vsprintf, $this->brand_items );

		}

	}

	new Dahz_Framework_Categories();

}
