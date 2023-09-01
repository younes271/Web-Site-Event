<?php
/**
	 * Custom Walker
	 * Class Dahz_Framework_Secondary_Menu_Walker
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      void
	*/

if( !class_exists( 'Dahz_Framework_Secondary_Menu_Walker' ) ){

	class Dahz_Framework_Secondary_Menu_Walker extends Walker_Nav_Menu {

		public $enable_only_level_0 = true;

		public $header_section = 1;

		function __construct( $enable_only_level_0 = true, $header_section ){

			$this->enable_only_level_0 = $enable_only_level_0;

			$this->header_section = $header_section;

		}

		/**
		 * start_lvl
		 * @param &$output, $depth, $args
		 * @return
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			// depth dependent classes

			$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent

			$display_depth = ( $depth + 1); // because it counts the first submenu as 0

			$inline_style = '';

			$classes = array(
				'uk-nav uk-navbar-dropdown-nav',
				'sub-menu',
				( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
				( $display_depth >=2 ? 'sub-sub-menu' : '' ),
				'menu-depth-' . $display_depth,
			);
			$class_names = implode( ' ', $classes );

			$dropdown_container_attributes = array(
				'class'			=> array( 'uk-navbar-dropdown' ),
				'data-uk-drop'	=> array(
					'flip: x;'
				)
			);

			if( $depth === 0 ){

				$dropdown_offset = 0;

				$header_section_height = dahz_framework_get_option( 'header_section' . $this->header_section . '_section_height', '12' );

				$dropdown_offset = (int)$header_section_height / 2;

				$header_section_border_style = dahz_framework_get_option( 'header_section' . $this->header_section . '_section_border_style', 'solid' );

				if( $header_section_border_style == 'solid' ){

					$header_section_border_bottom = dahz_framework_get_option( 'header_section' . $this->header_section . '_section_border_bottom', '0' );

					$dropdown_offset += (int)$header_section_border_bottom;

				}

				// $dropdown_container_attributes['data-uk-drop'][] = 'offset:' . $dropdown_offset . ';';

				$dropdown_container_attributes['data-uk-drop'][] = 'pos:bottom-left;';

				$dropdown_container_attributes['data-uk-drop'][] = 'boundary:#header-section' . $this->header_section . ';';

				$dropdown_container_attributes['data-uk-drop'][] = 'cls-drop:uk-navbar-dropdown;';

				$dropdown_container_attributes['style'] = 'margin-top: -5px;';

			} else {

				$dropdown_container_attributes['data-uk-drop'][] = 'cls-drop:de-dropdown__dropped;';

				$dropdown_container_attributes['data-uk-drop'][] = 'pos:right-top;';

				$dropdown_container_attributes['style'] = 'margin-top: -5px;';

			}
			// megamenu condition
			$indent .= sprintf(
				'
				<div %1$s>
				',
				dahz_framework_set_attributes(
					$dropdown_container_attributes,
					'dropdown_container',
					array(),
					false
				)
			);
			// megamenu condition
			$output .= sprintf(
				'
				%1$s%2$s<ul %3$s>%1$s
				',
				"\n",
				$indent,
				dahz_framework_set_attributes(
					array(
						'class' => $classes
					),
					'dropdown_start_level',
					array(),
					false
				)
			);

		}

		/**
		* end_lvl
		* @param &$output, $depth, $args
		* @return
		*/

		function end_lvl( &$output, $depth = 0, $args = array() ) {

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {

				$t = '';

				$n = '';

			} else {

				$t = "\t";

				$n = "\n";

			}

			$after_ul = '</div>';

			$indent = str_repeat( $t, $depth );

			$output .= "$indent</ul>{$n}{$after_ul}";

		}

		/**
		 * start_el
		 * @param &$output, $item, $depth, $args, $id
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			global $wp_query;

			$walkerObj = $args->walker;

			$has_children_item_menu = $walkerObj->has_children;

			$before_element = '';

			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

			// depth dependent classes
			$depth_classes = array(
				'menu-item-depth-' . $depth,
				( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
				( $depth >= 2 ? 'sub-sub-menu-item' : '' ),
				( $depth  % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			);

			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

			// passed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			// build html
			$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

			$attributes_classes = array(
				'menu-link',
				( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' )
			);
			$attributes_class_names = implode( ' ', $attributes_classes );
			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';

			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';

			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$attributes .= ' class="' . $attributes_class_names . '"';

			$item_output = sprintf(
				'
					%1$s
					<a%2$s>
						%3$s%4$s%5$s
					</a>%6$s%7$s
				',
				$args->before,
				$attributes,
				$args->link_before,
				apply_filters( 'dahz_framework_dropdown_title', $item->title, $item->ID, $depth ),
				$args->link_after,
				$args->after,
				$before_element
			);
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

			// build html
		}

		/**
		* end_lvl
		* @param &$output, $depth, $args
		* @return
		*/
		function end_el( &$output, $item, $depth = 0, $args = array() ) {

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}

			$output .= "</li>{$n}";

		}

	}

}
