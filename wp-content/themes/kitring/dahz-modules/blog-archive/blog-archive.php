<?php

if ( !class_exists( 'Dahz_Framework_Blog_Archive' ) ) {

	Class Dahz_Framework_Blog_Archive {

		public function __construct() {

			add_action( 'dahz_framework_module_blog-archive_init', array( $this, 'dahz_framework_blog_archive_init' ) );
			
			add_filter( 'excerpt_more', array( $this, 'dahz_framework_excerpt_more' ) );
			
			add_action( 'dahz_framework_after_main_content', array( $this, 'dahz_framework_blog_archive_pagination' ) );

			add_filter( 'dahz_framework_css_styles', array( $this, 'dahz_framework_archive_style' ) );
			
			add_filter( 'dahz_framework_post_metas', array( $this, 'dahz_framework_post_metas' ) );
			
			add_filter( 'dahz_framework_attributes_content_args', array( $this, 'dahz_framework_attributes_content_args' ) );
			
			add_filter( 'dahz_framework_attributes_loop_post_title_args', array( $this, 'dahz_framework_attributes_loop_post_title_args' ) );
			
			add_filter( 'dahz_framework_blog_readmore_button_type', array( $this, 'dahz_framework_blog_readmore_button_type' ) );
			
			add_filter( 'dahz_framework_blog_readmore_button_size', array( $this, 'dahz_framework_blog_readmore_button_size' ) );

		}
		
		public function dahz_framework_excerpt_more( $more ){
			
			return ' ' . '&hellip;';
			
		}
		
		private function dahz_framework_is_blog_archive(){
			
			return ( is_post_type_archive( 'post' ) || is_category() || is_tag() || ( is_search() && have_posts() ) || is_author() || is_year() || is_month() || is_day() );
			
		}
		
		/**
		 * register blog & archive panel on customizer
		 *
		 * @author Dahz
		 * @since 1.0.0
		 * @param - $path
		 * @return -
		 */
		public function dahz_framework_blog_archive_init( $path ) {

			if ( is_customize_preview() ){ 
				
				dahz_framework_include( $path . '/blog-archive-customizers.php' );
				
				dahz_framework_include( $path . '/blog-layout-customizers.php' );
			
			}

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Blog_Archive_Customizer',
				array(
					'id'	=> 'blog_archive',
					'title'	=> array( 'title' => esc_html__( 'Blog Archive', 'kitring' ), 'priority' => 2 ),
					'panel'	=> 'blog'
				),
				array()
			);
			
			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Blog_Layout_Customizer',
				array(
					'id'	=> 'blog_template',
					'title'	=> array( 'title' => esc_html__( 'Blog Layout', 'kitring' ), 'priority' => 1 ),
					'panel'	=> 'blog'
				),
				array()
			);

		}
		
		public function dahz_framework_attributes_loop_post_title_args( $args ){
			
			$is_uppercase = false;
			
			if( $this->dahz_framework_is_blog_archive() ){
				
				$is_uppercase = dahz_framework_get_option( 'blog_archive_layout_post_title', 0 );
								
				$args['class'][] = dahz_framework_get_option( 'blog_archive_heading', 'uk-article-title uk-link-heading' );
				
			} elseif( is_home() ){
				
				$is_uppercase = dahz_framework_get_option( 'blog_template_enable_uppercase_post_title', 0 );
								
				$args['class'][] = dahz_framework_get_option( 'blog_template_heading', 'uk-article-title uk-link-heading' );

			}
			
			if( $is_uppercase ){
				
				$args['class'][] = 'uk-text-uppercase';
				
			}
			
			return $args;
			
		}
		
		public function dahz_framework_attributes_content_args( $args ){
			
			$larger = false;
			
			if( $this->dahz_framework_is_blog_archive() ){
				
				$larger = dahz_framework_get_option( 'blog_archive_larger', 0 );
				
				$args['class'][] = 'uk-child-width-1-' . dahz_framework_get_option( 'blog_archive_column', 1 ) . '@m';
				
			} elseif( is_home() ){
				
				$larger = dahz_framework_get_option( 'blog_template_larger', 0 );
				
				$args['class'][] = 'uk-child-width-1-' . dahz_framework_get_option( 'blog_template_column', 1 ) . '@m';

			}
			
			if( $larger ){
				
				$args['class'][] = 'uk-grid-large';
				
			}
			
			return $args;
			
		}
		
		public function dahz_framework_post_metas( $metas ){
			
			$default = array(
				'date',
				'categories',
				'comment',
			);
			
			if( $this->dahz_framework_is_blog_archive() ){
				
				$metas = dahz_framework_get_option( 'blog_archive_post_meta', $default );
				
			} elseif( is_home() ){
				
				$metas = dahz_framework_get_option( 'blog_template_post_meta', $default );

			}
			
			return $metas;
			
		}

		public function dahz_framework_blog_archive_pagination() {
			
			if( ! is_home() && ! ( $this->dahz_framework_is_blog_archive() ) ){ return; }
			
			$pagination = 'number';

			if ( is_home() ) {

				$pagination = dahz_framework_get_option( 'blog_template_pagination', 'number' );

			} else if ( $this->dahz_framework_is_blog_archive() ) {

				$pagination = dahz_framework_get_option( 'blog_archive_layout_pagination', 'number' );

			}

			echo dahz_framework_pagination( $pagination );

		}
		
		public function dahz_framework_blog_readmore_button_type( $button_type ){
			
			if( $this->dahz_framework_is_blog_archive() ){
				
				$button_type = dahz_framework_get_option( 'blog_archive_button_style', 'uk-button-default' );
				
			} elseif( is_home() ){
				
				$button_type = dahz_framework_get_option( 'blog_template_button_style', 'uk-button-default' );

			}
			
			return $button_type;
			
		}
		
		public function dahz_framework_blog_readmore_button_size( $button_size ){
			
			if( $this->dahz_framework_is_blog_archive() ){
				
				$button_size = dahz_framework_get_option( 'blog_archive_button_size', '' );
				
			} elseif( is_home() ){
				
				$button_size = dahz_framework_get_option( 'blog_template_button_size', '' );

			}
			
			return $button_size;
			
		}

		/**
		 * render post affiliate on blog & archive
		 *
		 * @author Dahz
		 * @since 1.0.0
		 * @param -
		 * @return -
		 */
		public function dahz_framework_blog_archive_affiliate() {

			$affiliate_content_block = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'affiliate_content_block', '' );

			if ( !empty( $affiliate_content_block ) ) {

				printf(
					'
					<div class="entry-affiliate">
						<h3>%1$s</h3>
						%2$s
					</div>
					',
					dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'affiliate_title', '' ),
					dahz_framework_do_content_block( $affiliate_content_block )
				);

			}

		}

		public function dahz_framework_archive_style( $dv_default_styles ) {

			$button_solid_bg = dahz_framework_get_option(
				'color_button_button_solid_color_bg',
				array(
					'bg_regular'=> '#333333',
					'bg_hover'	=> '#999999'
				)
			);

			$button_solid_regular	= $button_solid_bg['bg_regular'];

			$button_solid_text = dahz_framework_get_option(
				'color_button_button_solid_color_text',
				array(
					'text_regular'	=> '#333333',
					'text_hover'	=> '#999999'
				)
			);

			$button_solid_text_regular	= $button_solid_text['text_regular'];

			$main_accent_color = dahz_framework_get_option(
				"color_general_main_accent_color_regular",
				array(
					'regular'	=> '#333333',
					'hover'		=> '#999999'
				)
			);

			$divider_color = dahz_framework_get_option( 'color_general_divider_color', '#000000' );

			$main_accent_color_regular = !empty( $main_accent_color['regular'] ) ? $main_accent_color['regular'] : '#333333';

			$dv_default_styles .= sprintf(
				'
				.entry-sticky {
					border-color: %3$s;
					background-color:%5$s;
					color:%6$s;
				}
				.de-archive .entry-sticky::after {
					border-top-color: %1$s;
				}
				.layout-1 .de-archive .entry-content,
				.layout-2 .de-archive .entry-content,
				.layout-3 .de-archive .entry-item::after {
					border-color: %4$s;
				}
				',
				$button_solid_regular, # 1
				$button_solid_text_regular, # 2
				get_theme_mod( 'color_button_modifier_default_border', '#000000' ), # 3
				$divider_color, # 4
				get_theme_mod( 'color_button_modifier_default_background', '#000000' ),
				get_theme_mod( 'color_button_modifier_default_color', '#ffffff' )
			);

			return $dv_default_styles;

		}

	}

	new Dahz_Framework_Blog_Archive();

}
