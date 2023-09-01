<?php

if ( !class_exists( 'Dahz_Framework_Portfolio_Single' ) ) {

	Class Dahz_Framework_Portfolio_Single {

		public function __construct() {

			if ( is_admin() && !is_customize_preview() ) dahz_framework_include( get_template_directory() . '/dahz-modules/portfolio-single/class-dahz-framework-metabox-portfolio.php' );

			add_action( 'dahz_framework_module_portfolio-single_init', array( $this, 'dahz_framework_portfolio_single_init' ) );

			add_filter( 'dahz_framework_primary_menu_id', array( $this, 'dahz_framework_primary_menu_id' ) );

			add_action( 'dahz_framework_single_portfolio_description', array( $this, 'dahz_framework_single_portfolio_description_content' ), 10 );
			
			add_action( 'dahz_framework_single_portfolio_description', array( $this, 'dahz_framework_single_portfolio_description_details' ), 15 );
			
			add_filter( 'dahz_framework_attributes_portfolio_single_description_args', array( $this, 'dahz_framework_attributes_portfolio_single_description_args' ) );
			
			add_filter( 'dahz_framework_attributes_portfolio_single_content_container_args', array( $this, 'dahz_framework_attributes_portfolio_single_content_container_args' ) );
			
			add_filter( 'dahz_framework_attributes_portfolio_single_description_container_args', array( $this, 'dahz_framework_attributes_portfolio_single_description_container_args' ) );
			
			add_filter( 'dahz_framework_attributes_portfolio_single_description_details_args', array( $this, 'dahz_framework_attributes_portfolio_single_description_details_args' ) );
			
			add_filter( 'dahz_framework_attributes_main_container_args', array( $this, 'dahz_framework_attributes_main_container_args' ) );

			add_action( 'dahz_framework_after_main_content', array( $this, 'dahz_framework_after_main_content_related') );

			add_action( 'dahz_framework_after_main_content', array( $this, 'dahz_framework_portfolio_navigation' ), 5 );
			
			add_action( 'dahz_framework_after_main_content', array( $this, 'dahz_framework_portfolio_comment' ), 5 );
			
		}
		
		/**
		 * register portfolio panel on customizer
		 *
		 * @author Dahz - KW
		 * @since 1.0.0
		 * @param - $path
		 * @return -
		 */
		public function dahz_framework_portfolio_single_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/portfolio-single-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Portfolio_Single_Customizer',
				array(
					'id'	=> 'portfolio_single',
					'title'	=> esc_html__( 'Portfolio Single', 'kitring' ),
					'panel'	=> 'portfolio',
				),
				array()
			);

		}

		public function dahz_framework_primary_menu_id( $menu_id ){

			if( is_singular( 'portfolio' ) ){

				$menu_id = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'overide_main_menu' );

			}

			return $menu_id;

		}
		
		public function dahz_framework_single_portfolio_description_content(){
			
			$title = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'description_title' );
			
			$description = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'description_content' );
			
			$disable_details = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'disable_portfolio_details', 'off' );
			
			if( ( ! empty( $title ) || ! empty( $description ) ) && $disable_details == 'off' ){

				dahz_framework_get_template(
					'description-content.php', 
					array(
						'title'			=> $title,
						'description'	=> $description
					), 
					'dahz-modules/portfolio-single/templates/' 
				);
				
			}
			
		}
		
		public function dahz_framework_single_portfolio_description_details(){
			
			$details = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'portfolio_details' );
			
			$details = !empty( $details ) ? dahz_framework_get_metabox_repeater_values( $details ) : array();
			
			$disable_details = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'disable_portfolio_details', 'off' );
			
			if( ! empty( $details ) && is_array( $details ) && $disable_details == 'off' ){

				dahz_framework_get_template(
					'description-details.php', 
					array(
						'details'	=> $details,
					), 
					'dahz-modules/portfolio-single/templates/' 
				);
				
			}
			
		}
		
		public function dahz_framework_attributes_portfolio_single_description_args( $args ){
			
			if( ! is_singular( 'portfolio' ) ) { return $args; }
			
			$details = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'portfolio_details_layout', 'right' );
			
			switch( $details ){
				
				case 'left':
					$args['class'] = array( 'uk-width-1-4@m uk-flex-first de-portfolio-single__description' );
					break;
				case 'top':
					$args['class'] = array( 'uk-width-1-1 uk-flex-first de-portfolio-single__description' );
					break;
				case 'bottom':
					$args['class'] = array( 'uk-width-1-1 de-portfolio-single__description' );
					break;
				default:
					$args['class'] = array( 'uk-width-1-4@m de-portfolio-single__description' );
					break;
				
			}
			
			return $args;
			
		}
		
		public function dahz_framework_attributes_portfolio_single_content_container_args( $args ){
			
			if( ! is_singular( 'portfolio' ) ) { return $args; }
			
			$details = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'portfolio_details_layout', 'right' );
			
			$is_sticky = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'sticky_sidebar', 'off' );
			
			if( ( $details == 'right' || $details == 'left' ) && $is_sticky == 'on' ){
				
				$args['data-uk-sticky'] = 'bottom:#post-' . get_the_ID() . ';media:@m;';
				
			}
						
			return $args;
			
		}
		
		public function dahz_framework_attributes_portfolio_single_description_container_args( $args ){
			
			if( ! is_singular( 'portfolio' ) ) { return $args; }
			
			$details = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'portfolio_details_layout', 'right' );
			
			$is_sticky = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'sticky_sidebar', 'off' );
			
			if( ( $details == 'right' || $details == 'left' ) && $is_sticky == 'on' ){
				
				$args['data-uk-sticky'] = 'bottom:#post-' . get_the_ID() . ';media:@m;';
				
			}
						
			return $args;
			
		}
		
		public function dahz_framework_attributes_portfolio_single_description_details_args( $args ){
			
			if( ! is_singular( 'portfolio' ) ) { return $args; }
			
			$details = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'portfolio_details_layout', 'right' );
			
			switch( $details ){
				
				case 'left':
				case 'right':
					$args['class'] = array( 'uk-width-1-1' );
					break;
				case 'top':
				case 'bottom':
					$args['class'] = array( 'uk-width-1-4@m' );
					break;
				default:
					break;
				
			}
			
			return $args;
			
		}
		
		public function dahz_framework_attributes_main_container_args( $args ){
			
			if( ! is_singular( 'portfolio' ) ) { return $args; }
			
			global $post;
			
			$content = $post->post_content;
			
			$details = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_portfolio', 'portfolio_details_layout', 'right' );
			
			if ( ( strpos( $content, '[vc_row' ) !== false || strpos( $content, '[vc_section' ) !== false ) && ( $details !== 'right' && $details !== 'left' ) ){
				
				$args['class'] = array( 'de-main-container' );
				
			}
			
			return $args;
			
		}
		
		public function dahz_framework_portfolio_navigation(){
			
			if( ! is_singular( 'portfolio' ) ) { return; }
			
			dahz_framework_get_template(
				'pagination.php', 
				array(), 
				'dahz-modules/portfolio-single/templates/' 
			);
			
		}
		
		public function dahz_framework_portfolio_comment(){
			
			if( ! is_singular( 'portfolio' ) ) { return; }
			
			dahz_framework_get_template(
				'comment.php', 
				array(), 
				'dahz-modules/portfolio-single/templates/' 
			);
			
		}

		public function dahz_framework_after_main_content_related(){
			
			if( ! is_singular( 'portfolio' ) ) { return; }
			
			dahz_framework_get_template(
				'related-portfolio.php', 
				array(), 
				'dahz-modules/portfolio-single/templates/' 
			);
			
		}


	}

	new Dahz_Framework_Portfolio_Single();

}
