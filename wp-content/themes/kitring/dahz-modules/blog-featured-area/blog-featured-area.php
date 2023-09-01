<?php

if ( !class_exists( 'Dahz_Framework_Blog_Featured_Area' ) ) {

	class Dahz_Framework_Blog_Featured_Area {

		public $registered_featured_area = array();

		public function __construct() {

			add_action( 'dahz_framework_module_blog-featured-area_init', array( $this, 'dahz_framework_blog_featured_area_init' ) );

			add_action( 'dahz_framework_before_content', array( $this, 'dahz_framework_render_featured_area' ), 15 );

			add_filter( 'dahz_framework_attributes_featured_area_inner_wrapper_args', array( $this, 'dahz_framework_featured_area_inner_wrapper_attributes' ), 10 );

			add_filter( 'dahz_framework_attributes_featured_area_slider_wrapper_args', array( $this, 'dahz_framework_featured_area_slider_wrapper_attributes' ), 10 );

		}

		public function dahz_framework_featured_area_inner_wrapper_attributes( $atts ) {

			if ( dahz_framework_get_option( 'blog_featured_area_enable_auto_play', true ) ) {

				$atts['data-uk-slider'][] = 'autoplay:true;autoplay-interval:4000;';

			}

			return $atts;

		}

		public function dahz_framework_featured_area_slider_wrapper_attributes( $atts ) {

			$height_viewport = dahz_framework_get_option( 'blog_featured_area_height', 'viewport_minus_section' );

			switch ( $height_viewport ) {
				case 'viewport_minus_section':
					$atts['data-uk-height-viewport'][] = 'offset-bottom:true;';
					break;
				case 'viewport_minus_20':
					$atts['data-uk-height-viewport'][] = 'offset-bottom:20;';
					break;
			}

			return $atts;

		}

		public function dahz_framework_blog_featured_area_init( $path ) {

			if ( is_customize_preview() ) dahz_framework_include( $path . '/blog-featured-area-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Blog_Featured_Area_Customizer',
				array(
					'id'	=> 'blog_featured_area',
					'title'	=> array( 'title' => esc_html__( 'Featured Area', 'kitring' ), 'priority' => 4 ),
					'panel'	=> 'blog'
				),
				array()
			);

		}

		public function dahz_framework_render_featured_area() {

			if ( is_home() || is_page() ) {

				$enable_on_page = 'off';

				if ( is_page() ) {
					$enable_on_page = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'enable_featured_area', 'off' );

					if ( $enable_on_page === 'off' ) return;
				}

				$enable_featured_area = dahz_framework_get_option( 'blog_featured_area_enable', false );

				if ( ( is_home() && $enable_featured_area ) || ( is_page() && $enable_on_page == 'on' ) ) {

					$layout = dahz_framework_get_option( 'blog_featured_area_layout', 'featured-1' );

					$source = dahz_framework_get_option( 'blog_featured_area_source', 'recent_post' );

					$enable_auto_play = dahz_framework_get_option( 'blog_featured_area_enable_auto_play', true );

					$total_post = dahz_framework_get_option( 'blog_featured_area_total_post', 10 );

					$args = array(
						'exclude'		=> get_option( 'sticky_posts' ),
						'post_type'		=> 'post',
						'post_status'	=> 'publish',
					);

					switch( $source ) {
						case 'post_ids':
							$post_ids = dahz_framework_get_option( 'blog_featured_area_post_ids' );
							if ( !empty( $post_ids ) ) {
								$args['include'] = explode( ',', $post_ids );
								$args['orderby'] = 'post__in';
								$args['order'] = 'ASC';
							}
							break;
						case 'category_post':
							$category = dahz_framework_get_option( 'blog_featured_area_category_slug', array() );
							$category = !empty( $category ) && is_array( $category ) ? implode( ',', $category ) : 0;
							$args['category'] = $category;
							$args['numberposts'] = (int)$total_post;
							break;
						default:
							$args['numberposts'] = (int)$total_post;
							break;
					}

					$posts_featured = get_posts( $args );

					if ( $posts_featured ) {
						dahz_framework_get_template(
							'featured-area.php',
							array(
								'enable_uppercase'	=> dahz_framework_get_option( 'blog_featured_area_enable_uppercase_post_title', false ),
								'posts_featured'	=> $posts_featured,
								'layout'			=> $layout
							),
							'dahz-modules/blog-featured-area/templates/'
						);
					}
				}
			}
		}
	}

	new Dahz_Framework_Blog_Featured_Area();
}