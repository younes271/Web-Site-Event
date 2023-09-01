<?php
/**
 * Custom Walker
 * Class Dahz_Framework_Footer_Menu_Walker
 *
 * @access      public
 * @since       1.0.0
 * @return      void
 */

if ( !class_exists( 'Dahz_Framework_Footer_Menu_Walker' ) ) {

	class Dahz_Framework_Footer_Menu_Walker extends Walker_Nav_Menu {

		public $style_background_level_0 = '';

		public $text_alignment_level_0 = '';

		public $is_submenu_2_column = false;

		public $submenu_2_column_counter = 0;

		public $submenu_2_column_total_children = 0;

		public $submenu_2_column_divider = 0;

		public $total_children_level_1 = 0;

		public $enable_only_level_0 = false;

		function __construct( $enable_only_level_0 ){

			$this->enable_only_level_0 = $enable_only_level_0;

		}

		/**
		 * start_lvl
		 * @param &$output, $depth, $args
		 * @return
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {

			if( $depth >= 0 && $this->enable_only_level_0 )return;

			if( $depth >= 1 ) return;
			// depth dependent classes
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

			$display_depth = ( $depth + 1); // because it counts the first submenu as 0

			$classes = array(
				'sub-menu',
				( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
				( $display_depth >= 2 ? 'sub-sub-menu' : '' ),
				'menu-depth-' . $display_depth,
				// start megamenu condition
				( $depth === 0 ? $this->text_alignment_level_0  : '' )
				// end megamenu condition
			);


			$class_names = implode( ' ', $classes );
			// megamenu condition
			$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";

		}

		/**
		* end_lvl
		* @param &$output, $depth, $args
		* @return
		*/

		function end_lvl( &$output, $depth = 0, $args = array() ) {

			if( $depth >= 0  && $this->enable_only_level_0 )return;

			if( $depth >= 1 ) return;

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {

				$t = '';

				$n = '';

			} else {

				$t = "\t";

				$n = "\n";

			}

			$after_ul = '';

			if ( $depth === 0 && $this->is_submenu_2_column && $this->submenu_2_column_counter == $this->submenu_2_column_total_children ) {

				$after_ul = '</div>';

			}

			$indent = str_repeat( $t, $depth );

			$output .= "$indent</ul>{$n}{$after_ul}";

		}

		/**
		 * start_el
		 * @param &$output, $item, $depth, $args, $id
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			global $wp_query;

			if( $depth > 0 && $this->enable_only_level_0 )return;

			if( $depth > 1 ) return;

			# start megamenu condition
			$mega_menu_meta = get_post_meta( $item->ID, 'mega_menu', true );

			$walkerObj = $args->walker;

			$has_children_item_menu = $walkerObj->has_children;

			$before_element = '';


			if ( $depth === 0 ) {

				$this->text_alignment_level_0 = $this->dahz_framework_mega_menu_get_text_alignment( !empty( $mega_menu_meta['submenu_text_align'] ) ? $mega_menu_meta['submenu_text_align'] : 'left' );

				$this->is_submenu_2_column = !empty( $mega_menu_meta['submenu_column'] ) && $mega_menu_meta['submenu_column'] !== '1' ? true : false;

				if ( $this->is_submenu_2_column ) {

					$this->total_children_level_1 = count(
						get_posts(
							array(
								'post_type' 	=> 'nav_menu_item',
								'nopaging' 		=> true,
								'numberposts' 	=> 1,
								'meta_key' 		=> '_menu_item_menu_item_parent',
								'meta_value' 	=> $item->ID
							)
						)
					);
					$this->is_submenu_2_column = $this->total_children_level_1 > 1 ? true : false;

					$this->submenu_2_column_counter = 0;

					$this->submenu_2_column_total_children = $this->is_submenu_2_column ? $this->total_children_level_1 : false;

					$this->submenu_2_column_divider = $this->is_submenu_2_column ? ceil( $this->total_children_level_1 / 2 ) : 0;

					$before_element = $this->is_submenu_2_column && !$this->enable_only_level_0 ? '<div class="de-footer-menu__item-child-wrapper">' :'';

				}

			}

			$exclude_class = array_search( 'menu-item-has-children', (array) $item->classes );

			if( $depth === 0 && $this->enable_only_level_0 && !empty( $exclude_class ) ){

				unset( $item->classes[$exclude_class] );

			}

			if ( $depth === 1 && $this->is_submenu_2_column ) {

				$this->submenu_2_column_counter++;

			}

			# end megamenu condition

			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

			# depth dependent classes
			$depth_classes = array(
				'menu-item-depth-' . $depth,
				( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
				( $depth >= 2 ? 'sub-sub-menu-item' : '' ),
				( $depth  % 2 ? 'menu-item-odd' : 'menu-item-even' ),
				# start megamenu condition
				( $depth == 0 ? 'de-footer-menu__item' : '' ),
				( $depth == 0 && !$this->enable_only_level_0 ? $this->dahz_framework_mega_menu_get_column_width( !empty( $mega_menu_meta['column_width'] ) ? $mega_menu_meta['column_width'] : '' ) : '' ),
				( $depth == 0 && !$this->enable_only_level_0 && !empty( $mega_menu_meta['submenu_column'] ) && $mega_menu_meta['submenu_column'] !== '1' ? 'de-footer-menu__item--child-column-2' : '' ),
				( $depth == 0 ? $this->dahz_framework_mega_menu_get_text_alignment( !empty( $mega_menu_meta['submenu_text_align'] ) ? $mega_menu_meta['submenu_text_align'] : 'left' ) : '' )
				# end megamenu condition
			);

			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

			# passed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			# build html

			$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

			$image_link_parent = ( $depth === 1 || $depth === 2 ) && !empty( $mega_menu_meta['image_replace_link'] )
				?
					wp_get_attachment_image( $mega_menu_meta['image_replace_link'], 'medium' )
				:
					'';

			# link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';

			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';

			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . ' ' . ( ( $depth === 1 || $depth === 2 ) && !empty( $image_link_parent ) ? 'menu-link--has-image' : '' ) . '"';

			# start megamenu condition

			$carousel_content = '';
			$Myprovince = (
			 ($province == 6) ? "city-1" :
			  (($province == 7) ? "city-2" :
			   (($province == 8) ? "city-3" :
			    (($province == 30) ? "city-4" : "out of borders")))
			 );
			$item_output = sprintf( (
				( $depth === 0 )
					?
					'
					%1$s
					<a%2$s>
						<h5>%3$s%4$s%7$s%5$s</h5>
					</a>%6$s%8$s%9$s
				   '
				   :
				(( $depth === 1 || $depth === 2 ) && !empty( $mega_menu_meta['is_hide_title'] )
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
					')),
				$args->before,
				$attributes,
				$args->link_before,
				apply_filters( 'the_title', $item->title, $item->ID ),
				$args->link_after,
				$args->after,
				$image_link_parent,
				$carousel_content,
				$before_element
			);
			# end megamenu condition
			# build html

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		/**
		* end_lvl
		* @param &$output, $depth, $args
		* @return
		*/
		function end_el( &$output, $item, $depth = 0, $args = array() ) {

			if( $depth > 0 && $this->enable_only_level_0 )return;

			if( $depth > 1 ) return;

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}

			if ( $depth === 1 && $this->is_submenu_2_column && $this->submenu_2_column_counter == $this->submenu_2_column_divider ) {

				$indent = str_repeat( $t, $depth );

				$display_depth = ( $depth + 1 ); // because it counts the first submenu as 0

				$classes = array(
					'sub-menu',
					( $depth % 2  ? 'menu-odd' : 'menu-even' ),
					( $depth >=2 ? 'sub-sub-menu' : '' ),
					'menu-depth-' . $depth,
				);
				# megamenu condition

				$class_names = implode( ' ', $classes );

				$output .= "
					</li>{$n}
					{$indent}</ul>{$n}
					{$indent}<ul class='" . $class_names . " " . $this->text_alignment_level_0 . "'>{$n}";

			} else {
				
				$output .= "</li>{$n}";

			}

		}


		/**
		* dahz_framework_mega_menu_get_column_width
		* @param $column_width
		* @return column width class
		*/
		public function dahz_framework_mega_menu_get_column_width( $column_width ) {

			$column_width_class = "";

			switch( $column_width ){
				case '1':
					$column_width_class = 'de-footer-menu__item--column-1';
					break ;
				case '1/2' :
					$column_width_class = 'de-footer-menu__item--column-1-2';
					break ;
				case '1/3' :
					$column_width_class = 'de-footer-menu__item--column-1-3';
					break ;
				case '1/4' :
					$column_width_class = 'de-footer-menu__item--column-1-4';
					break ;
				case '1/5' :
					$column_width_class = 'de-footer-menu__item--column-1-5';
					break ;
				case '1/6' :
					$column_width_class = 'de-footer-menu__item--column-1-6';
					break ;
				case '2/3' :
					$column_width_class = 'de-footer-menu__item--column-2-3';
					break ;
				case '2/5' :
					$column_width_class = 'de-footer-menu__item--column-2-5';
					break ;
				case '3/4' :
					$column_width_class = 'de-footer-menu__item--column-3-4';
					break ;
				case '3/5' :
					$column_width_class = 'de-footer-menu__item--column-3-5';
					break ;
				case '4/5' :
					$column_width_class = 'de-footer-menu__item--column-4-5';
					break ;
				case '5/6' :
					$column_width_class = 'de-footer-menu__item--column-5-6';
					break ;
				default :
					$column_width_class = 'de-footer-menu__item--column-1';
					break;

			}

			return $column_width_class;

		}

		/**
		* dahz_framework_mega_menu_get_text_alignment
		* @param $alignment
		* @return alignment class
		*/
		public function dahz_framework_mega_menu_get_text_alignment( $alignment ) {

			$alignment_class = "";

			switch( $alignment ){
				case 'left':
					$alignment_class = 't-a--l';
					break ;
				case 'center' :
					$alignment_class = 't-a--c';
					break ;
				case 'right' :
					$alignment_class = 't-a--r';
					break ;
				default :
					$alignment_class = 't-a--l';
					break;

			}

			return $alignment_class;

		}

	}

}
