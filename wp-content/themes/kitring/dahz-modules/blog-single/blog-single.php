<?php

if ( !class_exists( 'Dahz_Framework_Blog_Single' ) ){

	Class Dahz_Framework_Blog_Single{

		public function __construct() {

			if ( is_admin() && !is_customize_preview() ) dahz_framework_include( get_template_directory() . "/dahz-modules/blog-single/class-dahz-framework-single-post-metabox.php" );

			$this->dahz_framework_blog_breadcrumb();

			add_action( 'after_setup_theme', array( $this, 'dahz_framework_blog_single_post_formats' ), 11 );

			add_action( 'dahz_framework_module_blog-single_init', array( $this, 'dahz_framework_blog_single_init' ) );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_gallery_styles' ) );

			add_action( 'dahz_framework_blog_single_content', array( $this, 'dahz_framework_blog_single_content' ) );

			add_action( 'dahz_framework_single_post_after_content', array( $this, 'dahz_framework_blog_single_get_related_post' ) );

			add_action( 'dahz_framework_single_post_after_content', array( $this, 'dahz_framework_blog_single_get_author_box' ) );

			add_action( 'dahz_framework_single_post_after_content', array( $this, 'dahz_framework_blog_single_comments' ) );
			
			add_action( 'wp_enqueue_scripts', array( $this, 'dahz_framework_blog_single_script' ), 20 );

			add_action( 'wp_ajax_dahz_framework_blog_single_lazy_related', array( $this, 'dahz_framework_blog_single_lazy_related' ), 10 );

			add_action( 'wp_ajax_nopriv_dahz_framework_blog_single_lazy_related', array( $this, 'dahz_framework_blog_single_lazy_related' ), 10 );

			add_filter( 'comment_form_submit_button', array( $this, 'dahz_framework_blog_single_comment_button' ), 10 );

			add_filter( 'the_content_more_link', array( $this, 'dahz_framework_blog_single_read_more' ), 10 );

			add_filter( 'dahz_framework_primary_menu_id', array( $this, 'dahz_framework_primary_menu_id' ) );

			add_filter( 'the_content', array( $this, 'dahz_framework_set_dropcap_content' ) );

			add_filter( 'comment_text', array( $this, 'dahz_framework_set_dropcap_content' ) );
			
			add_filter( 'dahz_framework_post_metas', array( $this, 'dahz_framework_post_metas' ) );

		}

		public function dahz_framework_primary_menu_id( $menu_id ){

			if ( is_singular( 'post' ) ){

				$menu_id = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'overide_main_menu' );

			}

			return $menu_id;

		}

		public function dahz_framework_blog_single_script() {

			wp_enqueue_script( 'dahz-framework-blog-single', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/blog-single/assets/js/dahz-framework-blog-single.min.js', array( 'dahz-framework-script', 'lazyload' ), null, true );

			wp_register_script( 'dahz-framework-blog-single-gallery-tiled', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/blog-single/assets/js/dahz-framework-blog-single-gallery-tiled.min.js', array( 'dahz-framework-blog-single', 'isotope', 'imagesloaded' ), null, true );

		}

		public function dahz_framework_blog_single_post_formats() {

			add_theme_support( 'post-formats',
				array(
					'video',
					'audio',
					'gallery',
				)
			);

		}

		public function dahz_framework_gallery_styles( $default_styles ){

			$gallery_height = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'gallery_height' );

			if ( ( is_singular( 'post' ) || is_attachment() ) && $gallery_height === 'match-height' ) {

				$default_styles .= sprintf(
					'
					@media only screen and (min-width: 1200px) {
						body.postid-%1$s .de-post-gallery .uk-slider-items {
							height: %2$s
						}
					}
					@media only screen and (max-width: 1200px) {
						body.postid-%1$s .de-post-gallery .uk-slider-items {
							height: %3$s
						}
					}
					',
					get_the_ID(),
					dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'desktop_height' ),
					dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'mobile_height' )
				);

			}

			$heading = dahz_framework_get_option( 'color_general_heading_text_color', '#000000' );

			if ( is_singular( 'post' ) || is_attachment() ) {
				$default_styles .= sprintf(
					'
					.de-single .de-related-post__media .de-ratio-content--inner {
						background-color: %1$s;
						color: %2$s;
					}
					',
					dahz_framework_hex2rgba( $heading, 0.05 ), # 1
					dahz_framework_hex2rgba( $heading, 0.2 ) # 2
				);
			}


			return $default_styles;

		}

		public function dahz_framework_blog_single_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/blog-single-customizers.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Modules_Blog_Single_Customizer',
				array(
					'id'	=> 'blog_single',
					'title' => array( 'title' => esc_html__( 'Single Post', 'kitring' ), 'priority' => 3 ),
					'panel'	=> 'blog'
				),
				array()
			);

		}

		public function dahz_framework_blog_single_category() {
			if ( !dahz_framework_get_option( 'blog_single_enable_categories', true ) ) return;
			echo sprintf(
				'<div class="entry-category">%1$s</div>',
				dahz_framework_get_post_meta_categories()
			);

		}

		public function dahz_framework_blog_single_content() {
			$enableDropcap = dahz_framework_get_option( 'blog_single_enable_dropcap', false );

			$dataFirstLetter = '';

			if ( $enableDropcap === true ) {
				$dataFirstLetter = 'uk-dropcap';
			}

			echo "<div class='de-single__content-post-wrapper uk-width-1-1@m " . esc_attr( $dataFirstLetter )."'>";
				the_content(
					sprintf(
					/* translators: %s: Name of current post. */
						wp_kses(
							__( 'Read More %s <span class="meta-nav">&rarr;</span>', 'kitring' ),
							array( 'span' => array( 'class' => array() ) )

						),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					)
				);
			echo "</div>";

		}

		/**
		 * dahz_framework_load_single_author_box
		 * load author box in single
		 * @param $dv_enable_author_box
		 * @return void
		 */
		public function dahz_framework_blog_single_get_author_box() {

			if ( !dahz_framework_get_option( 'blog_single_enable_author_box', true ) ) return;

			$author_description = get_the_author_meta( 'description' );

			if ( empty( $author_description ) ) return '';

			$author_id = get_the_author_meta( 'ID' );

			$author_url = get_author_posts_url( $author_id );

			$author_name = get_the_author();

			$author_job = get_the_author_meta( 'job_title' );

			dahz_framework_get_template(
				"author-box.php",
				array(
					'author_id' 			=> $author_id,
					'author_url'			=> $author_url,
					'author_name'			=> $author_name,
					'author_job'			=> $author_job,
					'author_description'	=> $author_description
				),
				'dahz-modules/blog-single/templates/global/'
			);

		}

		public function dahz_framework_blog_single_get_related_post( $id = null ){
			
			if( is_attachment() ){return;}

			$id = !empty( $id ) ? $id : get_the_ID();

			if ( dahz_framework_get_option( 'blog_single_enable_related_article', true ) ){

				echo sprintf(
					'
					<div class="uk-position-relative uk-margin-remove-top" data-single-related-is-loaded="false" data-id="%1$s"></div>
					',
					$id
				);

			}

		}

		public function dahz_framework_blog_single_lazy_related(){

			if ( empty( $_POST['id'] ) ) die();

			global $post;

			$id = $_POST['id'];

			$image_cover = '';

			$related_html = '';

			$related_loop_html = '';

			$related = get_posts(
				array(
					'category__in' 			=> wp_get_post_categories( $id ),
					'ignore_sticky_posts'	=> 1,
					'post__not_in' 			=> array( $id )
				)
			);

			if ( $related ){

				$i = 1;

				$count = count( $related );

				$end = '';

				foreach( $related as $post ) {

					$image = '';

					$media = '';

					setup_postdata( $post );

					$end = $i === $count ? 'end' : '';

					$id = get_the_ID();

					if ( has_post_thumbnail( $id ) ) {

						$media = get_the_post_thumbnail(
							$id,
							'dahz_framework_upscale_medium'
						);

						$image_cover .= sprintf(
							'
							<div class="uk-position-cover uk-animation-fade uk-background-norepeat uk-background-cover" data-related-featured-image="%1$s" style="background-image: url(%2$s);">
							</div>
							',
							"related-image-{$id}",
							get_the_post_thumbnail_url( $id, 'full' )
						);

					}

					$related_loop_html .= dahz_framework_get_template_html(
						"related-post.php",
						array(
							'index'	=> $i,
							'count'	=> $count,
							'end'	=> $end,
							'media'	=> $media,
							'id'	=> $id,
							'link'	=> esc_url( get_permalink() )
						),
						'dahz-modules/blog-single/templates/global/'
					);

					$i++;
				}

				$related_html = sprintf(
					'
					<div class="de-single__section-related ds-single__section-related uk-flex uk-flex-center uk-flex-middle">
						<div class="uk-width-1-1">
							<div class="uk-container uk-transition-toggle">
								<div class="%4$s uk-margin-auto">
									<hr class="uk-margin-medium uk-margin-medium-top uk-width-1-1@m uk-grid-margin uk-first-column" />
								</div>
								<div class="uk-position-relative uk-position-z-index" data-uk-slider>
									<div class="uk-slider-container">
										<h4>%1$s</h4>
										<ul class="uk-slider-items uk-grid" data-uk-grid>
											%2$s
										</ul>
										<div class="uk-slidenav-container">
											<a class="uk-width-auto uk-padding uk-card uk-card-body uk-card-default uk-position-center-left uk-position-small uk-transition-fade" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
											<a class="uk-width-auto uk-padding uk-card uk-card-body uk-card-default uk-position-center-right uk-position-small uk-transition-fade" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					',
					sprintf( _n( 'Related Article', 'Related Articles', $count, 'kitring' ), $count ),//esc_html__( 'Related Posts', 'kitring' ),
					$related_loop_html,
					$image_cover,
					!dahz_framework_get_static_option( 'enable_sidebar' ) ? esc_attr( 'uk-width-5-6' ) : esc_attr( 'uk-width-1-1' )
				);

				wp_reset_postdata();

			}

			echo json_encode(
				array(
					'related_loop_html'	=> $related_html
				)
			);

			die();

		}

		public function dahz_framework_blog_single_comments(){

			echo dahz_framework_upscale_get_comments();

		}

		public function dahz_framework_set_dropcap_content( $content ){

			$content = preg_replace( '#\<table\>(.+?)\<\/table\>#s', '<div class="uk-overflow-auto">$0</div>', $content );

			return $content;

		}

		/**
		 * filter comment button
		 *
		 * @param -
		 * @return -
		 */
		public function dahz_framework_blog_single_comment_button() {
			return '<button type="submit" id="submit" class="uk-button uk-button-default">'. esc_html__( 'Submit', 'kitring' ) .'</button>';
		}

		/**
		 * filter read more button
		 *
		 * @param -
		 * @return -
		 */
		public function dahz_framework_blog_single_read_more() {
			return '<a class="uk-button uk-button-default" href="' . get_permalink() . '">'. esc_html__( 'Read More', 'kitring' ) .'</a>';
		}

		/** */
		public function dahz_framework_blog_breadcrumb(){

			include( get_template_directory() . '/dahz-modules/blog-single/breadcrumb-trail.php' );
		
		}
		
		public function dahz_framework_post_metas( $metas ){
						
			if( is_single() ){
				
				$metas = dahz_framework_get_option( 
					'blog_single_post_meta', 
					array(
						'date',
						'categories',
					) 
				);
				
			}
			
			return $metas;
			
		}

	}

	new Dahz_Framework_Blog_Single();

}
