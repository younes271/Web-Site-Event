<?php

if( !class_exists( 'Dahz_Framework_Footer_Widget' ) ){

	Class Dahz_Framework_Footer_Widget {

		public function __construct(){

			add_action( 'widgets_init', array( $this, 'dahz_framework_footer_register_area' ) );

			add_filter( 'dahz_framework_customize_footer_builder_items', array( $this, 'dahz_framework_footer_lists' ) );

		}

		public function dahz_framework_footer_lists( $items ){

			$dahz_widget_col = 4;

			for( $i = 1; $i <= $dahz_widget_col; $i++ ){

				$items["footer_widget_{$i}"] = array(
					'title'				=> sprintf( __( 'Footer Widget %1$s', 'kitring' ), $i ),
					'description'		=> sprintf( __( 'Diplay footer widget area %1$s', 'kitring' ), $i ),
					'render_callback'	=> array( $this, "dahz_framework_render_footer_widget_{$i}" ),
					'section_callback'	=> '',
					'is_repeatable'		=> false,
					'is_lazyload'		=> false,
				);

			}

			return $items;

		}

		public function dahz_framework_footer_register_area(){

			register_sidebars(
				4,
				array(
					'name'			=> 'Footer Area %d',
					'id'			=> 'de-footer-area',
					'before_widget'	=> '<div id="%1$s" class="widget %2$s de-footer-top-inner"> ',
					'after_widget'	=> '</div><hr class="de-sidebar__widget-separator uk-margin-medium" />',
					'before_title'	=> '<h6 class="widget-title widgettitle">',
					'after_title'	=> '</h6>',
					'description'	=> 'Footer Area. Add your widget here.'
				)

			);
			
		}

		public function dahz_framework_render_footer_widget_1(){

			if ( is_active_sidebar('de-footer-area') ){
				echo '<div class="uk-width-1-1 de-footer__widget">';
					dynamic_sidebar( 'de-footer-area' );
				echo '</div>';
			}

		}

		public function dahz_framework_render_footer_widget_2(){

			if ( is_active_sidebar('de-footer-area-2') ) {
				echo '<div class="uk-width-1-1 de-footer__widget">';
					dynamic_sidebar( 'de-footer-area-2' );
				echo '</div>';
			}

		}

		public function dahz_framework_render_footer_widget_3(){

			if ( is_active_sidebar('de-footer-area-3') ) {
				echo '<div class="uk-width-1-1 de-footer__widget">';
					dynamic_sidebar( 'de-footer-area-3' );
				echo '</div>';
			}

		}

		public function dahz_framework_render_footer_widget_4(){

			if ( is_active_sidebar('de-footer-area-4') ) {
				echo '<div class="uk-width-1-1 de-footer__widget">';
					dynamic_sidebar( 'de-footer-area-4' );
				echo '</div>';
			}

		}

	}

	new Dahz_Framework_Footer_Widget();

}