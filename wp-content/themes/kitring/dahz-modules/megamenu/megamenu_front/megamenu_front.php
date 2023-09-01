<?php
/**
	 * Custom Walker
	 * Class Dahz_Framework_Woo_Front_Mega_Menu
	 *
	 * @access public
	 * @since  1.0.0
	 * @return void
	*/

if ( !class_exists( 'Dahz_Framework_Woo_Front_Mega_Menu' ) ) {

	class Dahz_Framework_Woo_Front_Mega_Menu extends Walker_Nav_Menu {

		public $is_mega_menu_level_0 = false;

		public $mega_menu_width = 2;

		public $mega_menu_alignment = 'auto';

		public $style_background_level_0 = '';

		public $text_alignment_level_0 = 'left';

		public $text_alignment_level_1 = 'left';

		public $submenu_2_column_counter = 0;

		public $submenu_2_column_total_children = 0;

		public $submenu_2_column_divider = 0;

		public $total_children_level_1 = 0;

		public $enable_only_level_0 = true;

		public $header_section = 1;
		
		public $parent_id = '';
		
		public $full_width_container_class = '';

		function __construct( $enable_only_level_0 = true, $header_section ) {

			$this->enable_only_level_0 = $enable_only_level_0;

			$this->header_section = $header_section;
			
			$is_header_fullwidth = dahz_framework_get_option( 'logo_and_site_identity_is_header_fullwidth', false );
				
			if( $is_header_fullwidth ){
				
				$this->full_width_container_class = 'uk-container-expand';
				
			}

		}

		/**
		 * start_lvl
		 * @param &$output, $depth, $args
		 * @return
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			// depth dependent classes

			if ( $depth >= 0 && $this->enable_only_level_0 ) return;

			if ( $this->is_mega_menu_level_0 && $depth >= 2 ) return;

			$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent

			$display_depth = ( $depth + 1); // because it counts the first submenu as 0

			$inline_style = '';
			
			$classes = array(
				'uk-nav uk-dropdown-nav',
				'sub-menu',
				( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
				( $display_depth >= 2 ? 'sub-sub-menu' : '' ),
				'menu-depth-' . $display_depth,
				// start megamenu condition
				( $depth === 0 && $this->is_mega_menu_level_0 ? 'de-mega-menu__item-wrapper' : '' ),
				( $depth === 1 ? $this->text_alignment_level_1 : '' ),
				// end megamenu condition
			);

			// megamenu condition
			$inline_style = $depth === 0 && $this->is_mega_menu_level_0 && !empty( $this->style_background_level_0 ) ? 'style="' . $this->style_background_level_0 . '"' : '';

			$class_names = implode( ' ', $classes );
			
			if ( !$this->is_mega_menu_level_0 ) {

				$dropdown_container_attributes = array(
					'class'				=> array(),
					'data-uk-drop'	=> array(
						'flip: x;'
					)
				);
				
				if ( $depth === 0 ) {
										
					$dropdown_container_attributes = array(
						'class'	=> array(),
					);
					
					$data_uk_drop = array( 
						'flip' 				=> 'x',
						'pos'				=> 'bottom-left',
						'boundary'			=> '#header-section' . $this->header_section . ' .de-header__row',
						'boundaryAlign'		=> false,
					);
					
					$dropdown_container_attributes['style'] = 'display: none;';
					
					$dropdown_container_attributes['data-dahz-drop'] = json_encode( $data_uk_drop );
					
					$dropdown_container_attributes['data-container'] = 'auto';
					
				} else {

					$dropdown_container_attributes['data-uk-drop'][] = 'pos:right-top;';

					$dropdown_container_attributes['style'] = 'display: none;margin-top:20px;';

				}
				// megamenu condition
				$indent .= sprintf(
					'
					<div %1$s>
						<div class="uk-card uk-card-body uk-card-default uk-box-shadow-small">
					',
					dahz_framework_set_attributes(
						$dropdown_container_attributes,
						'dropdown_container',
						array(),
						false
					)
				);

			}
			// megamenu condition
			if ( $depth === 0 && $this->is_mega_menu_level_0 ) {
				
				$data_container = 'container';
				
				$data_uk_drop = array( 
					'flip' 				=> 'x', 
					'boundaryAlign' 	=> true,
					'boundary'			=> '#header-section' . $this->header_section . ' .uk-container',
					'pos'				=> 'bottom-left',
				);
				
				if( $this->mega_menu_width == 'full' ){
					
					$data_uk_drop['boundary'] = '#header-section' . $this->header_section;
					
					$data_uk_drop['pos'] = 'bottom-justify';
														
				} else {
					
					if( $this->mega_menu_alignment !== 'auto' ){
												
						if( $this->full_width_container_class == 'uk-container-expand' ){
							
							$data_container = 'row';
							
							$data_uk_drop['boundary'] = '#header-section' . $this->header_section . ' .de-header__row';
							
						}
						
						$data_uk_drop['pos'] = 'bottom-' . $this->mega_menu_alignment;
					
					} else {
						
						$data_container = 'auto';
						
						$data_uk_drop['boundaryAlign'] = false;
						
					}
				
				}
				
				$output .= sprintf(
					'
					<div %1$s>
						<div class="uk-card uk-card-body uk-card-default uk-box-shadow-small" %2$s>
							%3$s
							<div class="uk-drop-grid uk-grid" data-uk-grid>
					',
					dahz_framework_set_attributes(
						array(
							'class' 			=> array(
								$this->mega_menu_width == 'full' ? 'uk-width-1-1' : 'uk-width-' . $this->mega_menu_width,
								$this->text_alignment_level_0,
							),
							'style' 			=> 'display:none;margin-top:10px;',
							'data-dahz-drop'	=> json_encode( $data_uk_drop ),
							'data-container'	=> $data_container,
						),
						'dropdown_container',
						array(),
						false
					),
					$inline_style,
					$this->mega_menu_width == 'full' ? '<div class="uk-container ' . $this->full_width_container_class . '">' : ''
				);
				
			} else {
				$output .= sprintf(
					'
					%1$s%2$s<ul %4$s %3$s>%1$s
					',
					"\n",
					$indent,
					dahz_framework_set_attributes(
						array(
							'class'	=> $classes
						),
						'dropdown_start_level',
						array(),
						false
					),
					$inline_style
				);

			}

		}

		/**
		* end_lvl
		* @param &$output, $depth, $args
		* @return
		*/
		function end_lvl( &$output, $depth = 0, $args = array() ) {

			if ( $depth >= 0 && $this->enable_only_level_0 ) return;

			if ( $this->is_mega_menu_level_0 && $depth >= 2 ) return;

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {

				$t = '';

				$n = '';

			} else {

				$t = "\t";

				$n = "\n";

			}

			$after_ul = '';

			if ( !$this->is_mega_menu_level_0 ) {
				$after_ul .= '</div></div>';
			}

			$indent = str_repeat( $t, $depth );

			if ( $depth === 0 && $this->is_mega_menu_level_0 ) {
				$output .= '</div></div></div>';
				$output .= $this->mega_menu_width == 'full' ? '</div>' : '';
			} else {
				$output .= "$indent</ul>{$n}{$after_ul}";
			}

		}

		/**
		 * start_el
		 * @param &$output, $item, $depth, $args, $id
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			global $wp_query;
			// start megamenu condition
			$mega_menu_meta = get_post_meta( $item->ID, 'mega_menu', true );

			$walkerObj = $args->walker;

			$has_children_item_menu = $walkerObj->has_children;

			$before_element = '';
			
			if( $has_children_item_menu ){
				
				$this->parent_id = $item->ID;
				
			}

			if ( $depth === 0 ) {

				$this->is_mega_menu_level_0 = !empty( $mega_menu_meta['is_mega_menu'] ) ? true : false;

				$this->style_background_level_0 = $this->is_mega_menu_level_0 && !empty( $mega_menu_meta['submenu_background_image'] )
					?
						$this->dahz_framework_mega_menu_get_background(
							$mega_menu_meta['submenu_background_image'],
							!empty( $mega_menu_meta['background_position'] ) ? $mega_menu_meta['background_position'] : 'left top',
							!empty( $mega_menu_meta['background_repeat'] ) ? $mega_menu_meta['background_repeat'] : 'no-repeat',
							!empty( $mega_menu_meta['background_size'] ) ? $mega_menu_meta['background_size'] : 'cover'
						)
					:
					'';

				$this->text_alignment_level_0 = $this->is_mega_menu_level_0 ? $this->dahz_framework_mega_menu_get_text_alignment( !empty( $mega_menu_meta['submenu_text_align'] ) ? $mega_menu_meta['submenu_text_align'] : 'left' ) : '';

				$this->mega_menu_width = !empty( $mega_menu_meta['dropdown_width'] ) ? $mega_menu_meta['dropdown_width'] : 2;

				$this->mega_menu_alignment = !empty( $mega_menu_meta['dropdown_alignment'] ) ? $mega_menu_meta['dropdown_alignment'] : 'auto';

			}

			if ( $depth === 1 ) {

				$this->text_alignment_level_1 = $this->is_mega_menu_level_0 ? $this->dahz_framework_mega_menu_get_text_alignment( !empty( $mega_menu_meta['submenu_text_align'] ) ? $mega_menu_meta['submenu_text_align'] : 'left' ) : '';

			}

			if ( $depth > 0 && $this->enable_only_level_0 )return;

			$exclude_class = array_search( 'menu-item-has-children', (array) $item->classes );

			if ( $depth === 2 && $this->is_mega_menu_level_0 && !empty( $exclude_class ) ) {

				unset( $item->classes[$exclude_class] );

			}

			if ( $this->is_mega_menu_level_0 && $depth > 2  )return;
			// end megamenu condition

			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

			// depth dependent classes
			$depth_classes = array(
				'menu-item-depth-' . $depth,
				( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
				( $depth >= 2 ? 'sub-sub-menu-item' : '' ),
				( $depth  % 2 ? 'menu-item-odd' : 'menu-item-even' ),
				// start megamenu condition
				( $depth == 0 ? 'uk-flex uk-flex-middle' : '' ),
				( $depth == 0 && $this->is_mega_menu_level_0 && $has_children_item_menu ? 'de-mega-menu' : '' ),
				( $depth == 1 && $this->is_mega_menu_level_0 ? 'de-mega-menu__item' : '' ),
				( $depth == 1 && $this->is_mega_menu_level_0 && !empty( $mega_menu_meta['is_hide_title'] ) ? 'is-enable-hide-title' : '' ),
				( $depth == 1 && $this->is_mega_menu_level_0 && !empty( $mega_menu_meta['image_replace_link'] ) ? 'is-have-image' : '' )
				# end megamenu condition
			);

			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

			# passed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			# build html
			if ( $depth === 1 && $this->is_mega_menu_level_0 ) {
				$output .= sprintf(
					'
					%1$s
					<div class="uk-width-%2$s %3$s %4$s">
					',
					$indent,
					$this->dahz_framework_mega_menu_get_column_width( !empty( $mega_menu_meta['column_width'] ) ? $mega_menu_meta['column_width'] : '' ),
					$class_names,
					$depth_class_names
				);
			} else {
				$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
			}
			$attributes_classes = array(
				'menu-link',
				( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' )
			);
			$attributes_class_names = implode( ' ', $attributes_classes );
			# link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';

			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';

			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$attributes .= ' class="' . $attributes_class_names . '"';

			# start megamenu condition
			$image_link_parent = ( $depth === 1 || $depth === 2 ) && $this->is_mega_menu_level_0 && !empty( $mega_menu_meta['image_replace_link'] )
				?
					wp_get_attachment_image( $mega_menu_meta['image_replace_link'], 'large' )

				:
					'';

			$carousel_content = !empty( $mega_menu_meta['is_carousel'] ) && $depth === 1 && $this->is_mega_menu_level_0 && !empty( $mega_menu_meta['carousel_content'] )
				?
					$this->dahz_framework_mega_menu_carousel( $mega_menu_meta['source_carousel'], $mega_menu_meta['carousel_content'], !empty( $mega_menu_meta['column_carousel'] ) ? $mega_menu_meta['column_carousel'] : 1 )
				:
					'';
			$item_output = sprintf(
				( $depth === 1 || $depth === 2 ) && $this->is_mega_menu_level_0 && !empty( $mega_menu_meta['is_hide_title'] )
					?
					'
						%1$s
						<a%2$s>
							%7$s
						</a>
						%6$s%8$s
						'
					:
					'
						%1$s
						<a%2$s>
							%3$s%4$s%7$s%5$s
						</a>%6$s%8$s%9$s
					',
				$args->before,
				$attributes,
				$args->link_before,
				apply_filters( 'dahz_framework_dropdown_title', $item->title, $item->ID, $depth ),
				$args->link_after,
				$args->after,
				$image_link_parent,
				$carousel_content,
				$before_element
			);

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

			# end megamenu condition
			# build html

		}

		/**
		* end_lvl
		* @param &$output, $depth, $args
		* @return
		*/
		function end_el( &$output, $item, $depth = 0, $args = array() ) {

			if ( $depth > 0 && $this->enable_only_level_0 ) return;

			if ( $this->is_mega_menu_level_0 && $depth > 2 ) return;

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}

			if ( $depth === 1 && $this->is_mega_menu_level_0 ) {
				$output .= '</div>';
				return;
			}

			$output .= "</li>{$n}";

		}

		/**
		* dahz_framework_mega_menu_carousel
		* @param $source, $carousel_content, $column
		* @return carousel content
		*/
		public function dahz_framework_mega_menu_carousel( $source, $carousel_content, $column ) {

			$carousel = '';

			$query = $this->dahz_framework_mega_menu_get_carousel_query( $source, $carousel_content );

			if ( $query ) {

				$carousel .= dahz_framework_get_template_html(
					"megamenu-{$source}-carousel.php",
					array(
						'query'		=> $query,
						'column'	=> $column
					),
					'dahz-modules/megamenu/megamenu_front/'
				);

				wp_reset_postdata();

			}

			return $carousel;

		}

		/**
		* dahz_framework_mega_menu_product_carousel
		* @param $carousel_content
		* @return product carousel content
		*/
		public function dahz_framework_mega_menu_get_carousel_query( $source, $carousel_content ) {

			switch( $source ) {
				case 'product':
					$query = Dahz_Framework_Megamenu::dahz_framework_woo_get_query(
						array(
							'post_type'	=> 'product',
							'post__in'	=> explode( ',', $carousel_content )
						)
					);
					break;
				case 'post':
					$query = Dahz_Framework_Megamenu::dahz_framework_woo_get_query(
						array(
							'post_type'	=> 'post',
							'post__in'	=> explode( ',', $carousel_content )
						)
					);
					break;
				case 'product_category':
					$query = Dahz_Framework_Megamenu::dahz_framework_woo_get_taxonomy( explode( ',', $carousel_content ), 'product_cat' );
					break;
				case 'post_category':
					$query = Dahz_Framework_Megamenu::dahz_framework_woo_get_taxonomy( explode( ',', $carousel_content ), 'category' );
					break;
				case 'brand':
					$query = Dahz_Framework_Megamenu::dahz_framework_woo_get_taxonomy( explode( ',', $carousel_content ), 'brand' );
					break;
				default :
					$query = false;
					break;
			}

			return $query;

		}

		/**
		* dahz_framework_mega_menu_get_column_width
		* @param $column_width
		* @return column width class
		*/
		public function dahz_framework_mega_menu_get_column_width( $column_width ) {

			$column_width_class =  str_replace( "/", "-", $column_width );

			return $column_width_class;

		}

		/**
		* dahz_framework_mega_menu_get_text_alignment
		* @param $alignment
		* @return alignment class
		*/
		public function dahz_framework_mega_menu_get_text_alignment( $alignment ) {

			return "uk-text-{$alignment}";

		}

		/**
		* dahz_framework_mega_menu_get_background
		* @param $background, $background_position, $background_repeat, $background_size
		* @return inline style
		*/
		public function dahz_framework_mega_menu_get_background( $background, $background_position, $background_repeat, $background_size ) {

			$inline_style = "";

			$image_background = wp_get_attachment_image_src( $background, 'full' );

			if ( is_array( $image_background ) && !empty( $image_background ) ) {

				$inline_style = sprintf(
					'background-image:url(%1$s);background-position:%2$s;background-repeat:%3$s;background-size:%4$s;
					',
					$image_background[0],
					$background_position,
					$background_repeat,
					$background_size
				);

			}

			return $inline_style;

		}

	}

}
