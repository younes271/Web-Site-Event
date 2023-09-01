<?php

if( !class_exists( 'Dahz_Framework_General_Transition' ) ){

	Class Dahz_Framework_General_Transition{

		public function __construct(){

			add_action( 'dahz_framework_module_general-transition_init', array( $this, 'dahz_framework_general_transition_init' ) );
			
			add_filter( 'body_class', array( $this, 'dahz_framework_body_transition_class' ) );
			
			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_transition_enqueue_scripts' ), 25 );
			
			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_loader_style' ) );
			
		}
		

		public function dahz_framework_general_transition_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/general-transition-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_General_Transition_Customizer',
				array(
					'id'	=> 'general_transition',
					'title' => array( 'title' => esc_html__( 'Transition', 'kitring' ), 'priority' => 6 ),
					'panel'	=> 'general'
				),
				array()
			);

		}
		
		public function dahz_framework_body_transition_class( $classes ){

			if( dahz_framework_get_option( 'general_transition_enable_transitions', false ) ){
				
				$loader_style = dahz_framework_get_option( 'general_transition_transitions_loader', 'loader-1' );
				
				$classes[] = "de-page--transition-{$loader_style}";
				
			}
			
			return $classes;
			
		}
		
		public function dahz_framework_transition_enqueue_scripts(){
			
			if( dahz_framework_get_option( 'general_transition_enable_transitions', false ) ){
				
				wp_enqueue_script( 'pace', DAHZ_FRAMEWORK_THEME_URI . '/assets/dist/js/plugins/pace.min.js', array( 'jquery' ), null, false );
			
			}
							
		}
		
		public function dahz_framework_loader_style( $styles ) {
			
			$styles .= sprintf(
				'
				.de-page--transition-loader-5 .pace {
					pointer-events: none;
					-webkit-user-select: none;
					 -moz-user-select: none;
					  -ms-user-select: none;
						  user-select: none;
				}

				.de-page--transition-loader-5 .pace-inactive {
					animation-name: uk-fade;
					animation-duration: .3s;
					animation-direction: reverse;
					animation-timing-function: ease-in-out;
					animation-fill-mode: both;
				}

				.de-page--transition-loader-5 .pace-activity {
					display: block;
					background-image:url( %1$s );
					background-position: center center;
					background-repeat: no-repeat;
					background-size: cover;
					width:%2$s;
					height:%3$s;
					position: fixed;
					z-index: 2000;
					top: calc( 50vh - ( %2$s / 2 ) );
					right: calc( 50vw - ( %3$s / 2 ) );
				}
				',
				dahz_framework_get_option( 'general_transition_transition_image', '' ),
				dahz_framework_get_option( 'general_transition_transition_image_width', '100px' ),
				dahz_framework_get_option( 'general_transition_transition_image_height', '100px' )
			);
			
			return $styles;
			
		}

	}

	new Dahz_Framework_General_Transition();

}