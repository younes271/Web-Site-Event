<?php
if ( !class_exists( 'Dahz_Framework_Portfolio_Archive' ) ) {
	
	class Dahz_Framework_Portfolio_Archive {
		
		static $collected_categories = array();

		public function __construct() {
			
			
			add_action( 'dahz_framework_module_portfolio-archive_init', array( $this, 'dahz_framework_portfolio_archive_init' ) );
			
			add_filter( 'dahz_framework_attributes_content_portfolio_args', array( $this, 'dahz_framework_attributes_content_args' ) );
			
			add_filter( 'dahz_framework_attributes_loop_portfolio_args', array( $this, 'dahz_framework_attributes_loop_portfolio_args' ) );
			
			add_filter( 'dahz_framework_attributes_loop_portfolio_content_args', array( $this, 'dahz_framework_attributes_loop_portfolio_content_args' ) );
			
			add_filter( 'dahz_framework_attributes_loop_post_title_args', array( $this, 'dahz_framework_attributes_loop_post_title_args' ) );
			
			add_filter( 'dahz_framework_attributes_loop_portfolio_filter_args', array( $this, 'dahz_framework_attributes_loop_portfolio_filter_args' ) );
			
			add_action( 'dahz_framework_loop_portfolio', array( $this, 'dahz_framework_loop_portfolio' ) );
			
			add_action( 'dahz_framework_after_loop_portfolio', array( $this, 'dahz_framework_after_loop_portfolio' ) );
			
			add_action( 'dahz_framework_after_main_content', array( $this, 'dahz_framework_portfolio_archive_pagination' ) );
			
			add_filter( 'loop_portfolio_per_page', array( $this, 'dahz_framework_loop_portfolio_per_page' ) );
			
			add_filter( 'dahz_framework_attributes_portfolio_featured_image_args', array( $this, 'dahz_framework_attributes_portfolio_featured_image_args' ) );
			
		}
			
		public function dahz_framework_portfolio_archive_init( $path ) {
			
			if ( is_customize_preview() ) dahz_framework_include( $path . '/portfolio-archive-customizers.php' );
			
			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Portfolio_Archive_Customizer',
				array(
					'id'	=> 'portfolio_archive',
					'title'	=> esc_html__( 'Portfolio Archive', 'kitring' ),
					'panel'	=> array(
						'id'			=> 'portfolio',
						'title'			=> esc_html__( 'Portfolio', 'kitring' ),
						'description'	=> '',
						'priority'		=> 7,
					)
				),
				array()
			);
			
		}
		
		public function dahz_framework_attributes_content_args( $args ){

			if( ! is_post_type_archive( 'portfolio' ) && ! is_tax( 'portfolio_categories' ) ){ return $args; }
			
			$desktop_column = dahz_framework_get_option( 'portfolio_archive_desktop_column', '3' );
			
			$tablet_landscape_column = dahz_framework_get_option( 'portfolio_archive_tablet_landscape_column', '2' );
			
			$phone_landscape_column = dahz_framework_get_option( 'portfolio_archive_phone_landscape_column', '2' );
			
			$phone_portrait_column = dahz_framework_get_option( 'portfolio_archive_phone_portrait_column', '1' );
			
			$column_gap = dahz_framework_get_option( 'portfolio_archive_column_gap', '' );
			
			$enable_masonry = dahz_framework_get_option( 'portfolio_archive_enable_masonry', false );
			
			$enable_parallax = dahz_framework_get_option( 'portfolio_archive_enable_parallax', false );
			
			$args['data-uk-grid'] = array();
			
			$args['class'] = array(
				'de-content__portfolio',
				$column_gap,
				"uk-child-width-1-{$phone_portrait_column}",
				"uk-child-width-1-{$phone_landscape_column}@s",
				"uk-child-width-1-{$tablet_landscape_column}@m",
				"uk-child-width-1-{$desktop_column}@l",
			);
			
			if( $enable_masonry ){ $args['data-uk-grid'][] = 'masonry:true;'; }
			
			if( $enable_parallax ){
				
				$parallax_speed = dahz_framework_get_option( 'portfolio_archive_parallax_speed', 0 );
				$args['data-uk-grid'][] = "parallax:{$parallax_speed};";
			
			}
			
			return $args;
			
		}
		
		public function dahz_framework_attributes_loop_portfolio_args( $args ){
			
			if( ! is_post_type_archive( 'portfolio' ) && ! is_tax( 'portfolio_categories' ) ){ return $args; }
			
			$layout = dahz_framework_get_option( 'portfolio_archive_layout', 'layout-1' );
			
			if( $layout == 'layout-2' ){
				
				$args['class'][] = 'uk-inline-clip uk-transition-toggle';
				
			}
						
			return $args;
			
		}
		
		public function dahz_framework_attributes_loop_portfolio_content_args( $args ){

			if( ! is_post_type_archive( 'portfolio' ) && ! is_tax( 'portfolio_categories' ) ){ return $args; }
			
			$layout = dahz_framework_get_option( 'portfolio_archive_layout', 'layout-1' );
			
			if( $layout == 'layout-2' ){
				
				$args['class'][] = 'uk-transition-slide-bottom uk-position-bottom uk-overlay uk-overlay-default';
				
			}
						
			return $args;
			
		}
		
		public function dahz_framework_attributes_loop_post_title_args( $args ){
			
			if( ! is_post_type_archive( 'portfolio' ) && ! is_tax( 'portfolio_categories' ) ){ return $args; }
			
			$args['class'][] = dahz_framework_get_option( 'portfolio_archive_heading', 'uk-article-title' );
			
			return $args;
			
		}
		
		public function dahz_framework_attributes_loop_portfolio_filter_args( $args ){
			
			$filter_style = dahz_framework_get_option( 'portfolio_archive_filter_style', 'pills' );
			
			if( $filter_style == 'tabs' ){
				
				$args['class'] = array();
				
				$args['data-uk-tab'] = array();
				
			}
			
			$args['class'][] = dahz_framework_get_option( 'portfolio_archive_filter_alignment', 'uk-flex-left' );
			
			return $args;
			
		}
		
		public function dahz_framework_loop_portfolio(){
			
			if( ! is_post_type_archive( 'portfolio' ) ){ return; }
			
			$categories = get_the_terms( get_the_ID(), 'portfolio_categories' );
					
			self::$collected_categories = dahz_framework_collect_terms( $categories, self::$collected_categories );
			
		}
		
		public function dahz_framework_after_loop_portfolio(){
			
			if( ! is_post_type_archive( 'portfolio' ) ){ return; }
			
			if( empty( self::$collected_categories ) ) { return; }
			
			dahz_framework_get_template(
				'filter-portfolio-categories.php',
				array(
					'categories'	=> self::$collected_categories,
				),
				'dahz-modules/portfolio-archive/templates/'
			);
			
		}
		
		public function dahz_framework_portfolio_archive_pagination(){
			
			if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_categories' ) ) {

				$pagination = dahz_framework_get_option( 'portfolio_archive_pagination', 'number' );
				
				echo dahz_framework_pagination( $pagination );

			}

		}
		
		public function dahz_framework_loop_portfolio_per_page( $per_page ){
			
			$per_page = dahz_framework_get_option( 'portfolio_archive_per_page', 12 );
			
			return (int)$per_page;
			
		}
		
		public function dahz_framework_attributes_portfolio_featured_image_args( $args ){
			
			$image_ratio = dahz_framework_get_option( 'portfolio_archive_image_ratio', '' );
			
			if( !empty( $image_ratio ) ){
				
				$args['class'][] = "de-ratio de-ratio-{$image_ratio}";
				
			}
			
			return $args;
			
		}
		
		
	}
	
	new Dahz_Framework_Portfolio_Archive();
	
}
