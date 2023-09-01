<?php
if( !class_exists( 'Dahz_Framework_Breadcrumbs' ) ){
	
	Class Dahz_Framework_Breadcrumbs {
		
		public $taxonomies = array();
		
		public $queried_object = null;
		
		public $post_type = null;
		
		public $post_type_object = null;
		
		public $post_type_archive_link = null;
		
		public $output = '';
	
		function __construct(){
			
			$this->taxonomies = apply_filters(
				'dahz_framework_breadcrumbs_taxonomies',
				array(
					'portfolio'				=> array( 
						'taxonomies' 		=> get_object_taxonomies( 'portfolio' ), 
						'post_type'			=> 'portfolio',
						'primary_taxonomy'	=> 'portfolio_categories'
					),
					'product'				=> array(
						'taxonomies' 		=> get_object_taxonomies( 'product' ), 
						'post_type'			=> 'product',
						'primary_taxonomy'	=> 'product_cat'
					),
					'content-block'			=> array( 
						'taxonomies' 		=> get_object_taxonomies( 'content-block' ), 
						'post_type'			=> 'content-block',
						'primary_taxonomy'	=> 'content_block_categories'
					)
				)
			);
			
		}
		
		public function dahz_framework_breadcrumbs_init(){

			global $post,$wp_query;
			
			if ( is_front_page() && !apply_filters( 'dahz_framework_enable_breadcrumb_on_home', false ) ) {
				return;
			}

			$this->output .= sprintf(
				'<ul %1$s>',
				dahz_framework_set_attributes(
					array(
						'class' => array( 'uk-breadcrumb uk-text-small' )
					),
					'breadcrumbs',
					array(),
					false
				)
			);

			$this->output .= $this->dahz_framework_wrap_breadcrumbs(
				array(
					'url'	=> get_home_url(),
					'title'	=> esc_attr__( 'Home', 'kitring' ),
					'text'	=> esc_html__( 'Home', 'kitring' ),
				)
			);
			
			if ( $this->dahz_framework_is_archive_only() ) {

				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> esc_html( post_type_archive_title( '', false ) )
					),
					true
				);
				
			} else if ( $this->dahz_framework_is_archive_on_custom_taxonomy() ) {

				$this->post_type = get_post_type();
				
				$this->queried_object = get_queried_object();

				if( $this->post_type != 'post' ) {
					
					if( empty( $this->post_type ) ){

						$current_post_type = current( 
						
							array_filter( 
							
								$this->taxonomies, 
								
								array( $this, 'dahz_framework_find_cpt_of_taxonomy' ) 
								
							) 
						);
						
						$this->post_type = $current_post_type['post_type'];
					
					}
					
					$this->post_type_object = get_post_type_object( $this->post_type );
					
					$this->post_type_archive_link = get_post_type_archive_link( $this->post_type );
					
					$this->output .= $this->dahz_framework_wrap_breadcrumbs(
						array(
							'url'	=> esc_url( $this->post_type_archive_link ),
							'title'	=> esc_attr( $this->post_type_object->labels->name ),
							'text'	=> esc_html( $this->post_type_object->labels->name ),
						)
					);
				}

				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> esc_html( $this->queried_object->name )
					),
					true
				);
				
			} else if ( is_single() ) {

				$this->post_type = get_post_type();

				if( $this->post_type != 'post' ){
					
					$this->post_type_object = get_post_type_object( $this->post_type );
					
					$this->post_type_archive_link = get_post_type_archive_link( $this->post_type );
					
					$this->output .= $this->dahz_framework_wrap_breadcrumbs(
						array(
							'url'	=> esc_url( $this->post_type_archive_link ),
							'title'	=> esc_attr( $this->post_type_object->labels->name ),
							'text'	=> esc_html( $this->post_type_object->labels->name ),
						)
					);
				}

				$category = get_the_category();

				if( !empty( $category ) ){
					
					$values_of_array = array_values( $category );

					$last_category = end( $values_of_array );

					$get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
					
					$cat_parents = explode( ',', $get_cat_parents );

					$cat_display = '';
					
					foreach( $cat_parents as $parents ) {
						
						$cat_display .= sprintf( '<li class="bread-link">%1$s</li>', $parents );
						
					}
					
				}

				if( isset( $this->taxonomies[$this->post_type]['primary_taxonomy'] ) ){
					
					$taxonomy_exists = taxonomy_exists( $this->taxonomies[$this->post_type]['primary_taxonomy'] );
				
					if( empty( $last_category ) && !empty( $this->taxonomies[$this->post_type]['primary_taxonomy'] ) && $taxonomy_exists ) {
						
						$taxonomy_terms = get_the_terms( $post->ID, $this->taxonomies[$this->post_type]['primary_taxonomy'] );
						
						$cat_id         = !empty( $taxonomy_terms ) ? $taxonomy_terms[0]->term_id : '';
						
						$cat_nicename   = !empty( $taxonomy_terms ) ? $taxonomy_terms[0]->slug : '';
						
						$cat_link       = !empty( $taxonomy_terms ) ? get_term_link( $taxonomy_terms[0]->term_id, $this->taxonomies[$this->post_type]['primary_taxonomy'] ) : '';
						
						$cat_name       = !empty( $taxonomy_terms ) ? $taxonomy_terms[0]->name : '';
					
					}
					
				}
				
				if( !empty( $last_category ) ) {
					
					$this->output .= $cat_display;
					
					$this->output .= $this->dahz_framework_wrap_breadcrumbs(
						array(
							'text'	=> esc_html( get_the_title() ),
						),
						true
					);

				} else if( !empty( $cat_id ) ) {
					
					$this->output .= $this->dahz_framework_wrap_breadcrumbs(
						array(
							'url'	=> esc_url( $cat_link ),
							'title'	=> esc_attr( $cat_name ),
							'text'	=> esc_html( $cat_name ),
						)
					);
					$this->output .= $this->dahz_framework_wrap_breadcrumbs(
						array(
							'text'	=> esc_html( get_the_title() )
						),
						true
					);
					
				} else {
					
					$this->output .= $this->dahz_framework_wrap_breadcrumbs(
						array(
							'text'	=> esc_html( get_the_title() )
						),
						true
					);
				}

			} else if ( is_category() ) {
				
				$this->queried_object = get_queried_object();

				$get_cat_parents = rtrim( get_category_parents( $this->queried_object->term_id, true, ',' ), ',' );
				
				$cat_parents = explode( ',', $get_cat_parents );

				$cat_display = '';
				
				array_pop( $cat_parents );
				
				foreach( $cat_parents as $parents ) {
					
					$this->output .= sprintf( '<li class="bread-link">%1$s</li>', $parents );
					
				}
				
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> esc_html( single_cat_title( '', false ) )
					),
					true
				);
			
			} else if ( is_page() ) {

				if( $post->post_parent ){

					$anc = get_post_ancestors( get_the_ID() );

					$anc = array_reverse($anc);

					if ( !isset( $parents ) ) $parents = null;
					
					foreach ( $anc as $ancestor ) {
						
						$parents .= $this->dahz_framework_wrap_breadcrumbs(
							array(
								'url'	=> esc_url( get_permalink( $ancestor ) ),
								'title'	=> esc_attr( get_the_title( $ancestor ) ),
								'text'	=> esc_html( get_the_title( $ancestor ) ),
							)
						);
					
					}

					$this->output .= $parents;

					$this->output .= $this->dahz_framework_wrap_breadcrumbs(
						array(
							'text'	=> esc_html( get_the_title() ),
						),
						true
					);
					
				} else {

					$this->output .= $this->dahz_framework_wrap_breadcrumbs(
						array(
							'text'	=> esc_html( get_the_title() ),
						),
						true
					);
					
				}
			}else if ( is_tag() ) {
				
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> esc_html__( 'Tag', 'kitring' ),
					),
					true
				);
				
			} else if ( is_day() ) {
				// Day archive
				// Year link
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'url'	=> esc_url( get_year_link( get_the_time('Y') ) ),
						'title'	=> esc_attr( get_the_time('Y') ),
						'text'	=> esc_html( get_the_time('Y') ),
					)
				);
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'url'	=> esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ),
						'title'	=> esc_attr( get_the_time('F') ),
						'text'	=> esc_html( get_the_time('F') ),
					)
				);
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> sprintf(
							'%1$s %2$s', 
							esc_html__( 'Day:', 'kitring' ),
							get_the_date()
						),
					),
					true
				);
				
			} else if ( is_month() ) {
				// Month Archive
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'url'	=> esc_url( get_year_link( get_the_time('Y') ) ),
						'title'	=> esc_attr( get_the_time('Y') ),
						'text'	=> esc_html( get_the_time('Y') ),
					)
				);
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> sprintf('%3$s %1$s %2$s', esc_html( get_the_time('F') ), esc_html( get_the_time('Y') ), esc_html__( 'Month:', 'kitring' ) ),
					),
					true
				);

			} else if ( is_year() ) {
				// Display year archive
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> sprintf('%2$s %1$s', esc_html( get_the_time('Y') ), esc_html__( 'Year:', 'kitring' ) ),
					),
					true
				);
			} else if ( is_author() ) {
				// Auhor archive

				// Get the author information
				global $author;
				$userdata = get_userdata( $author );
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> sprintf('%2$s %1$s',esc_html( $userdata->display_name ), esc_html__( 'Author / ', 'kitring' ) ),
					),
					true
				);
				// Display author name
			} else if ( get_query_var('paged') ) {
				// Paginated archives
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> sprintf('%2$s %1$s', esc_html( get_query_var('paged' ) ), esc_html__('Page', 'kitring' ) ),
					),
					true
				);
			} else if ( is_search() ) {
				// Search results page
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> sprintf('%2$s %1$s', esc_html( get_search_query() ), esc_html__('Search results for: ', 'kitring' ) ),
					),
					true
				);
				
			} else if ( is_404() ) {
				// 404 page
				$this->output .= $this->dahz_framework_wrap_breadcrumbs(
					array(
						'text'	=> esc_html__('Error 404', 'kitring' ),
					),
					true
				);

			}
			
			$this->output .= '</ul>';
			
			return $this->output;
			
		}
		
		public function dahz_framework_wrap_breadcrumbs( $args = array(), $is_active = false ){
			
			return !$is_active 
				?
				sprintf(
					'<li>
						<a %1$s>
							%2$s
						</a>
					</li>',
					dahz_framework_set_attributes(
						array(
							'class' => array( 'uk-link' ),
							'href'	=> $args['url'],
							'title'	=> isset( $args['title'] ) ? $args['title'] : ''
						),
						'breadcrumbs_link',
						array(),
						false
					),
					isset( $args['text'] ) ? $args['text'] : ''
				)
				:
				sprintf(
					'<li>
						<span %2$s>
							%1$s
						</span>
					</li>', 
					isset( $args['text'] ) ? $args['text'] : '',
					dahz_framework_set_attributes(
						array(
							'class' => array( 'bread-current' )
						),
						'breadcrumbs_link',
						array(),
						false
					)
				);
			
		}
		
		public function dahz_framework_find_cpt_of_taxonomy( $item ){
			
			return in_array( $this->queried_object->taxonomy, $item['taxonomies'] ) ;
		
		}
		
		public function dahz_framework_is_archive_only(){
			
			return is_archive() && !is_tax() && !is_category() && !is_tag() && !is_author() && !is_day() && !is_month() && !is_year();
		
		}
		
		public function dahz_framework_is_archive_on_custom_taxonomy(){
			
			return is_archive() && is_tax() && !is_category() && !is_tag() && !is_author() && !is_day() && !is_month() && !is_year();
		
		}
		
	}
	
}