<?php
if( !class_exists('Dahz_Framework_Secondary_Menu') ){


	Class Dahz_Framework_Secondary_Menu {

		function __construct(){
			
			add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_secondary_menu_item_builder' ) );

			add_action( 'dahz_framework_module_secondary-menu_init', array( $this, 'dahz_framework_secondary_menu_init' ), 1, 2 );
			
		}
		
		public function dahz_framework_secondary_menu_init( $path, $uri ){

			$this->path = $path;

			$this->uri = $uri;

		}
		
		public function dahz_framework_secondary_menu_item_builder( $items ){
			
			$items['secondary_menu'] = array(
				'title'				=> esc_html__( 'Secondary Menu', 'kitring' ),
				'description'		=> esc_html__( 'Display secondary menu', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_render_secondary_menu' ),
				'section_callback'	=> 'menu_locations',
				'is_repeatable'		=> false,
				'is_lazyload'		=> false
			);
			
			return $items;
			
		}
		
		public function dahz_framework_render_secondary_menu( $builder_type, $section, $row, $column ){
			
			if ( !has_nav_menu( 'secondary_menu' ) ) return;
			
			dahz_framework_include( $this->path . '/secondary-menu-walker.php' );

			$params_topbar = array(
				'theme_location'=> 'secondary_menu',
				'container'		=> '',
				'menu_class'	=> 'uk-navbar-nav uk-flex uk-flex-wrap',
				'walker'		=> new Dahz_Framework_Secondary_Menu_Walker( false, $section ),
				'fallback_cb'	=> true,
				'items_wrap'	=> '<ul ' . dahz_framework_set_attributes( array( 'class' => array( 'uk-navbar-nav' ) ), 'secondary_menu_container', array(), false ) . '>%3$s</ul>',
				'echo'			=> false
			);

			$dahz_secondary_menu = wp_nav_menu( $params_topbar );

			echo sprintf(
				'<nav %2$s>
					%1$s
				</nav>
				' ,
				$dahz_secondary_menu,
				dahz_framework_set_attributes(
					array(
						'class' 			=> array( 'secondary-menu' ),
						'data-uk-navbar'	=> 'delay-hide:100;'
					),
					'secondary_menu_wrapper',
					array(),
					false
				)
			);
			
		}

	}

	new Dahz_Framework_Secondary_Menu();

}
