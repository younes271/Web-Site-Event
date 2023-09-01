<?php
/**
 * 1. dahz_framework_header_lists
 * list of header element
 * @param - $items
 * @return - $items
 */
if ( !function_exists( 'dahz_framework_header_lists' ) ) {
	function dahz_framework_header_lists( $items ) {
		$items['logo'] = array(
			'title'				=> esc_html__( 'Logo', 'kitring' ),
			'description'		=> esc_html__( 'Display site logo', 'kitring' ),
			'render_callback'	=> 'dahz_framework_header_logo',
			'section_callback'	=> 'logo_and_site_identity',
			'is_repeatable'		=> false,
			'is_lazyload'		=> false
		);

		return $items;
	}
}

/**
 * 2. dahz_framework_footer_lists
 * list of footer element
 * @param - $items
 * @return - $items
 */
if ( !function_exists( 'dahz_framework_footer_lists' ) ) {
	function dahz_framework_footer_lists( $items ) {
		$items['site_copyright'] = array(
			'title'				=> esc_html__( 'Site Copyright', 'kitring' ),
			'description'		=> esc_html__( 'Display copyright info', 'kitring' ),
			'render_callback'	=> 'dahz_framework_footer_site_copyright',
			'section_callback'	=> 'footer_element',
			'is_repeatable'		=> false
		);

		$items['footer_description'] = array(
			'title'				=> esc_html__( 'Footer Description', 'kitring' ),
			'description'		=> esc_html__( 'Display description text', 'kitring' ),
			'render_callback'	=> 'dahz_framework_footer_description',
			'section_callback'	=> 'footer_element',
			'is_repeatable'		=> false
		);

		return $items;
	}
}

/**
 * 3. dahz_framework_headermobile_lists
 * list of header mobile element
 * @param - $items
 * @return - $items
 */
if ( !function_exists( 'dahz_framework_headermobile_lists' ) ) {
	function dahz_framework_headermobile_lists( $items ) {
		$items['logo_mobile'] = array(
			'title'				=> esc_html__( 'Logo', 'kitring' ),
			'description'		=> esc_html__( 'Display mobile site logo', 'kitring' ),
			'render_callback'	=> 'dahz_framework_header_logo',
			'section_callback'	=> 'logo_and_site_identity',
			'is_repeatable'		=> false
		);

		return $items;
	}
}

/**
 * 4. dahz_framework_skip_link
 * render skip link
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_skip_link' ) ) {
	function dahz_framework_skip_link() {
		echo '<a class="skip-link screen-reader-text de-skip-link" href="#de-archive-content">' . esc_html__( 'Skip to content', 'kitring' ).'</a>';
	}
}

/**
 * 5. dahz_framework_header_class
 * filter to add extra header class
 * @param -
 * @return - implode( ' ', $class );
 */
if ( !function_exists( 'dahz_framework_header_class' ) ) {
	function dahz_framework_header_class( $args = array() ) {
		$classes = array(
			'site-header',
			'no-transparency'
		);

		if ( !is_array( $args ) && !empty( $args ) ) {
			$classes[] = $args;
		} else if ( is_array( $args ) && !empty( $args ) ) {
			$classes = array_merge( $classes, $args );
		}

		switch( dahz_framework_get_option( 'logo_and_site_identity_header_style', 'horizontal' ) ) {
			case 'horizontal':
				$classes[] = 'no-vertical';
				break;

			case 'vertical':
				$classes[] = 'has-vertical';
				break;

			case 'hide':
				$classes[] = 'has-vertical-hide';
				break;

			default :
				$classes[] = 'no-vertical';
				break;
		}


		$class = apply_filters(
			'dahz_framework_header_class',
			$classes
		);

		if ( !empty( $class ) && is_array( $class ) ) {
			return implode( ' ', $class );
		}
	}
}


/**
 * 9. dahz_framework_get_header
 * render header & header mobile to front
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_get_header' ) ) {
	function dahz_framework_get_header() {
		global $dahz_framework;

		$header = dahz_framework_get_builder( 'header', true );

		$header_mobile = dahz_framework_get_builder( 'headermobile', true, 'mobile' );
		?>
		<header id="masthead" data-uk-scrollspy="cls:uk-animation-fade;delay:10;">
			<?php do_action( 'dahz_framework_before_header_content' ); ?>
			<div <?php dahz_framework_set_attributes(
				array(
					'id'	=> "de-header-horizontal",
					'class'	=> dahz_framework_header_class(),
				),
				"header_horizontal_wrapper"
			); ?>>
				<?php
					echo apply_filters( 'dahz_framework_header_content', sprintf( '
							<div class="uk-visible@m ds-header--wrapper de-header__wrapper de-header default uk-position-z-index">
								%s
							</div>
							',
							$header
						),
						$header
					);

					echo apply_filters( 'dahz_framework_headermobile_content', sprintf( '
							<div class="uk-hidden@m ds-header-mobile--wrapper de-header-mobile__wrapper de-header-mobile default">
								%s
							</div>
							',
							$header_mobile
						),
						$header_mobile
					);
				?>
			</div>
			<?php do_action( 'dahz_framework_after_header_content' ); ?>
		</header><!-- #masthead -->
		<?php
	}
}

add_action( 'dahz_framework_header', 'dahz_framework_get_header', 10 );

/**
 * 14. dahz_framework_get_footer
 * render footer to front
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_get_footer' ) ) {
	
	function dahz_framework_get_footer() {
		
		global $dahz_framework;

		$is_enable_fullwidth = dahz_framework_get_option( 'footer_element_is_footer_fullwidth', true );
		$footer_fullwidth = $is_enable_fullwidth ? 'de-footer--fullwidth' : '';
		?>
		<div id="de-site-footer" class="<?php echo dahz_classes('ds-site-footer') ?>">
			<?php dahz_framework_get_builder( 'footer' );?>
			<?php do_action( 'dahz_framework_footer_content' );?>
		</div><!-- #colophon -->
		<?php
	}
	
}

add_action( 'dahz_framework_footer', 'dahz_framework_get_footer', 10 );

/**
 * 15. dahz_framework_sort_builder
 * render footer to front
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_sort_builder' ) ) {
	
	function dahz_framework_sort_builder( $a, $b ) {
		
		return isset( $a['position'] ) && isset( $b['position'] ) ? $a['position'] > $b['position'] : 0;
		
	}
	
}

/**
 * 16. dahz_framework_get_builder
 * render builder element to front
 * @param - $builder_type, $device_type
 * @return -
 */
if ( !function_exists( 'dahz_framework_get_builder' ) ) {
	
	function dahz_framework_get_builder( $builder_type, $is_return = false, $device_type = 'desktop' ) {
		
		global $dahz_framework;

		$before_section = dahz_framework_get_template_html(
			$builder_type . '/' . $builder_type . '-section.php',
			array(
				'id_section'	=> 'before-section',
				'row_html'		=> apply_filters( "dahz_framework_{$builder_type}_before_section", '' )
			)
		);

		$after_section = dahz_framework_get_template_html(
			
			$builder_type . '/' . $builder_type . '-section.php',
			array(
				'id_section'	=> 'after-section',
				'row_html'		=> apply_filters( "dahz_framework_{$builder_type}_after_section", '' )
			)
		);

		$section_html = '';

		if ( !apply_filters( "dahz_framework_{$builder_type}_builder_is_disable", false  ) ) {
			
			$available_items = dahz_framework_get_builder_items( $builder_type );

			$builder_element = apply_filters(

				'dahz_framework_builder_element_json',

				dahz_framework_get_option( "{$builder_type}_builder_element_{$device_type}" ),

				$builder_type,

				$device_type

			);

			$builder = apply_filters( 'dahz_framework_builder_element_array' , json_decode( $builder_element, true ), $builder_type, $device_type );

			$row_html = '';

			$column_html = '';

			$item_html ='';

			$sections_array = array();

			if ( !isset( $dahz_framework->builder_items ) ) {
				
				$dahz_framework->builder_items = array();
			
			}

			if ( !empty($builder) && is_array( $builder ) ) {
				
				ksort( $builder );

				foreach( $builder as $section => $rows ) {
					
					$row_html = '';
					
					$row_empty_length = 0;

					if ( !empty( $rows ) && $section !== 'dataSection' ) {
						
						usort( $rows, 'dahz_framework_sort_builder' );

						foreach( $rows as $row => $columns ) {
							
							$column_html = '';
							
							$column_empty_length = 0;

							if ( !empty( $columns['columns'] ) ) {
								
								usort( $columns['columns'], 'dahz_framework_sort_builder' );

								foreach( $columns['columns'] as $column => $items ) {
									
									$item_html ='';

									if ( !empty( $items['items'] ) ) {
										
										usort( $items['items'], 'dahz_framework_sort_builder' );
																				
										foreach( $items['items'] as $item => $content ) {
											
											$is_lazyload = isset( $available_items[$content['value']]['is_lazyload'] ) ? $available_items[$content['value']]['is_lazyload'] : false;

											if ( !isset( $dahz_framework->builder_items[$content['value']] ) ) {
												$dahz_framework->builder_items[$content['value']] = !$is_lazyload ? dahz_framework_render_builder_items( $available_items, $content, $builder_type, $section, $row, $column ) : '';
											}
											if( !empty( $dahz_framework->builder_items[$content['value']] ) ){

												$item_html .= dahz_framework_get_template_html(
													$builder_type . '/' . $builder_type . '-item.php',
													array(
														'id_section'	=> $section,
														'id_row'		=> $row,
														'id_column'		=> $column,
														'extra_class'	=> '',
														'id_item'		=> $item,
														'item_content'	=> $dahz_framework->builder_items[$content['value']],
														'is_lazyload'	=> $is_lazyload,
														'item_id'		=> isset( $content['value'] ) ? $content['value'] : '',
														'builder_type'	=> $builder_type,
														'section'		=> $section
													)
												);
												
											}

										}

									}
									
									if( empty( $item_html ) ){
										$column_empty_length++;
									}
										
									$column_html .= dahz_framework_get_template_html(
										$builder_type . '/' . $builder_type . '-column.php',
										array(
											'id_section'		=> $section,
											'id_row'			=> $row,
											'id_column'			=> $column,
											'column_class'		=> dahz_framework_convert_to_uikit_width( !empty( $items['columnWidth'] ) ? $items['columnWidth'] : '', $builder_type ),
											'column_align'		=> dahz_framework_convert_to_uikit_flex( !empty( $items['options']['alignment'] ) ? $items['options']['alignment'] : 'flex-start' ),
											'column_extraclass'	=> !empty( $items['options']['extraClass'] ) ? $items['options']['extraClass'] : '',
											'item_html'			=> $item_html
										)
									);

								}

							}
							
							if( !empty( $columns['columns'] && count( $columns['columns'] ) === $column_empty_length ) ){
								$row_empty_length++;							
							}

							$row_html .= dahz_framework_get_template_html(
								$builder_type . '/' . $builder_type . '-row.php',
								array(
									'id_section'	=> $section,
									'id_row'		=> $row,
									'column_html'	=> $column_html
								)
							);
						}
						
						$section_render = '';
						
						if( count( $rows ) !== $row_empty_length ){
							$section_render = dahz_framework_get_template_html(
								$builder_type . '/' . $builder_type . '-section.php',
								array(
									'id_section'	=> $section,
									'row_html'		=> $row_html
								)
							);
						}

						$section_html .= apply_filters( 'dahz_framework_builder_sections_render', $section_render, $builder_type, $section );
					
					} else {
						if ( !property_exists( $dahz_framework, "builder_empty_sections" ) ) {
							$dahz_framework->builder_empty_sections = array();
						}

						if ( !isset( $dahz_framework->builder_empty_sections[$builder_type] ) ) {
							$dahz_framework->builder_empty_sections[$builder_type] = array();
						}

						$dahz_framework->builder_empty_sections[$builder_type][] = $section;
					}
				}
			}
		}

		if ( !$is_return ) {
			echo apply_filters( 'dahz_framework_builder_html', $before_section . $section_html . $after_section, $builder_type, $device_type );
		} else {
			return apply_filters( 'dahz_framework_builder_html', $before_section . $section_html . $after_section, $builder_type, $device_type );
		}
	}
}

if ( !function_exists( 'dahz_framework_convert_to_uikit_width' ) ) {
	
	function dahz_framework_convert_to_uikit_width( $column_width = false, $builder_type ) {
		
		switch ( $column_width ) {
			case '1/2':
				$column_class = 'uk-width-1-2';
				break;
			case '1/3':
				$column_class = 'uk-width-1-3';
				break;
			case '1/4':
				$column_class = 'uk-width-1-4';
				break;
			case '1/5':
				$column_class = 'uk-width-1-5';
				break;
			case '1/6':
				$column_class = 'uk-width-1-6';
				break;
			case '2/3':
				$column_class = 'uk-width-2-3';
				break;
			case '2/5':
				$column_class = 'uk-width-2-5';
				break;
			case '3/4':
				$column_class = 'uk-width-3-4';
				break;
			case '3/5':
				$column_class = 'uk-width-3-5';
				break;
			case '5/6':
				$column_class = 'uk-width-5-6';
				break;
			default:
				$column_class = 'uk-width-1-1';
				break;
		}

		if ( $builder_type === 'footer' ) {
			return "uk-width-1-1 {$column_class}@m";
		} else {
			return $column_class;
		}
		
	}
	
}

if ( !function_exists( 'dahz_framework_convert_to_uikit_flex' ) ) {
	
	function dahz_framework_convert_to_uikit_flex( $alignment = '' ) {
		
		switch ( $alignment ) {
			case 'flex-start' :
				$flex_class = 'uk-flex-left';
				break;
			case 'flex-center' :
				$flex_class = 'uk-flex-center';
				break;
			case 'flex-end' :
				$flex_class = 'uk-flex-right';
				break;
			default:
				$flex_class = 'uk-flex-left';
				break;
		}

		return $flex_class;
	}
	
}

/**
 * 18. dahz_framework_header_logo
 * render header element : logo
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_header_logo' ) ) {
	
	function dahz_framework_header_logo( $builder_type, $section, $row, $column ) {
		
		global $dahz_framework;

		if ( $builder_type == 'header' ) {
			$site_logo = dahz_framework_get_option( 'logo_and_site_identity_logo_default_normal', get_template_directory_uri() . '/assets/images/logo/default-logo.svg' );

			$site_logo_retina = dahz_framework_get_option( 'logo_and_site_identity_logo_default_retina', get_template_directory_uri() . '/assets/images/logo/default-logo.svg' );
		} else {
			$site_logo = dahz_framework_get_option( 'mobile_header_logo_normal', get_template_directory_uri() . '/assets/images/logo/default-logo.svg' );

			$site_logo_retina = dahz_framework_get_option( 'mobile_header_logo_retina', get_template_directory_uri() . '/assets/images/logo/default-logo.svg' );
		}

		dahz_framework_get_template(

			'header/logo.php',
			array(
				'site_logo'			=> $site_logo,
				'builder_type'		=> $builder_type,
				'section'			=> $section,
				'row'				=> $row,
				'column'			=> $column,
				'site_logo_image'	=> apply_filters( 'dahz_framework_logo_normal',
					!empty( $site_logo ) || !empty( $site_logo_retina ) ?
						sprintf(
							'
							<a href="%4$s" rel="home">
								<img src="%1$s" data-src-2x="%2$s" data-src-3x="%2$s" alt="%3$s" />
							</a>
							',
							!empty( $site_logo ) ? esc_url( $site_logo ) : esc_url( $site_logo_retina ),
							!empty( $site_logo_retina ) ? esc_url( $site_logo_retina ) : esc_url( $site_logo ),
							esc_html__( 'Site Logo', 'kitring' ),
							esc_url( home_url( '/' ) )
						)
					:
						sprintf(
							'
							<h3 class="site-title de-header__site-title">
								<a class="uk-link" href="%1$s" rel="home">
									%2$s
								</a>
							</h3>
							<p class="site-description de-header__site-description">
								%3$s
							</p>
							',
							esc_url( home_url( '/' ) ),
							esc_html( get_bloginfo( 'name' ) ),
							sprintf( esc_html__( '%s', 'kitring' ), get_bloginfo( 'description' ) )
						)
				)
			)

		);
	}
}

/**
 * 19. dahz_framework_footer_description
 * render footer element : footer description
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_footer_description' ) ) {
	function dahz_framework_footer_description() {
		dahz_framework_get_template(
			'footer/footer-description.php',
			array(
				'footer_description'			=> dahz_framework_get_option( 'footer_element_footer_description', '' ),
				'footer_description_title'		=> dahz_framework_get_option( 'footer_element_footer_description_title', '' ),
				'footer_description_alignment'	=> dahz_framework_get_option( 'footer_element_footer_description_alignment', 'uk-text-left' )
			)
		);
	}
}

/**
 * 20. dahz_framework_footer_site_copyright
 * render footer element : site copyright
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_footer_site_copyright' ) ) {
	function dahz_framework_footer_site_copyright() {
		dahz_framework_get_template(
			'footer/footer-copyright.php',
			array(
				'site_info' => dahz_framework_get_option( 'footer_element_footer_site_info', __( '&#169;2018 Kitring – Barber, Salon &amp; MUA WordPress Theme', 'kitring' ) ),
				'site_info_alignment' => dahz_framework_get_option( 'footer_element_footer_site_info_alignment', 'uk-text-left' )
			)
		);
	}
}

/**
 * 23. dahz_framework_pagination
 * render numeric pagination
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_pagination' ) ) {
	
	function dahz_framework_pagination( $pagination_type = "number", $masonry = false, $class="", $is_echo = true ) {
		
		if ( is_single() ) {
			return;
		}

		global $wp_query;

		$pagination_output = '';

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		/** Stop execution if there's only 1 page */
		if ( $wp_query->max_num_pages <= 1 ) return;

		$max = intval( $wp_query->max_num_pages );

		switch ( $pagination_type ) {
			case 'prev_next':
				$pagination_output .= '<ul class="de-pagination uk-pagination uk-flex-between uk-margin-large uk-margin-remove-bottom" data-pagination-type="prev-next"><li>';

				$pagination_output .= get_previous_posts_link( '<h6><span data-uk-icon="chevron-left"></span>' . __( 'Previous', 'kitring' ) . '</h6>' );

				$pagination_output .= '</li><li>';

				$pagination_output .= get_next_posts_link( '<h6>' . __( 'Next', 'kitring' ) . '<span data-uk-icon="chevron-right"></span></h6>' );

				$pagination_output .= '</li></ul>';
			break;
			case 'infinity-scroll':
				if ( $paged === $max ) return;

				$pagination_output = sprintf(
					'
					<div class="%6$sde-pagination uk-text-center uk-invisible" data-pagination-type="infinity">
						<div class="de-pagination__nav">
							<a href="%1$s" class="de-pagination__nav-btn uk-button uk-button-default ds-navigation__btn ds-navigation--load-more" data-paged="%2$s" data-max_num_pages="%3$s" data-layout-masonry="%4$s">%5$s</a>
						</div>
					</div>
					',
					esc_url( next_posts( $max, false ) ),
					esc_attr( $paged ),
					esc_attr( $max ),
					esc_attr( $masonry ),
					esc_html__( 'To Infinity and Beyond', 'kitring' ),
					!empty( $class ) ? "{$class} " : ''
				);
			break;
			case 'load-more':
				if ( $paged === $max ) return;

				$pagination_output = sprintf(
					'
					<div class="%6$sde-pagination uk-text-center" data-pagination-type="load-more">
						<div class="de-pagination__nav">
							<a href="%1$s" class="de-pagination__nav-btn uk-button uk-button-default ds-navigation__btn ds-navigation--load-more" data-paged="%2$s" data-max_num_pages="%3$s" data-layout-masonry="%4$s">%5$s</a>
						</div>
					</div>
					',
					esc_url( next_posts( $max, false ) ),
					esc_attr( $paged ),
					esc_attr( $max ),
					esc_attr( $masonry ),
					esc_html__( 'Load More', 'kitring' ),
					!empty( $class ) ? "{$class} " : ''
				);
			break;
			default:
				$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

				/**	Add current page to the array */
				if ( $paged >= 1 ) {
					$links[] = $paged;
				}

				/**	Add the pages around the current page to the array */
				if ( $paged >= 3 ) {
					$links[] = $paged - 1;
					$links[] = $paged - 2;
				}

				if ( ( $paged + 2 ) <= $max ) {
					$links[] = $paged + 2;
					$links[] = $paged + 1;
				}

				$pagination_output = sprintf( 
					'
						<ul class="de-pagination uk-pagination uk-margin-large uk-flex-center uk-margin-remove-bottom" data-pagination-type="number">
					', !empty( $class ) ? "{$class} " : '' ) . "\n";

				/**	Previous Post Link */
				$pagination_output .= '<li class="uk-margin-auto-right">';
				if ( get_previous_posts_link() ) {
					$pagination_output .= get_previous_posts_link( '<span data-uk-icon="chevron-left"></span>' );
				}
				$pagination_output .= '</li>';

				/**	Link to first page, plus ellipses if necessary */
				if ( ! in_array( 1, $links ) ) {
					$class = 1 == $paged ? ' class="active"' : '';

					$pagination_output .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( 1 ) ), '1' );

					if ( ! in_array( 2, $links ) ) $pagination_output .= '<li><span>...</span></li>';
				}

				/**	Link to current page, plus 2 pages in either direction if necessary */
				sort( $links );
				foreach ( (array) $links as $link ) {
					$class = $paged == $link ? ' class="active"' : '';
					$pagination_output .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $link ) ), $link );
				}

				/**	Link to last page, plus ellipses if necessary */
				if ( ! in_array( $max, $links ) ) {
					if ( ! in_array( $max - 1, $links ) )
						$pagination_output .= '<li><span>...</span></li>';

					$class = $paged == $max ? ' class="active"' : '';
					$pagination_output .= sprintf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $max ) ), $max );
				}

				/**	Next Post Link */
				$pagination_output .= '<li class="uk-margin-auto-left">';
				if ( get_next_posts_link() ) {
					$pagination_output .= get_next_posts_link( '<span data-uk-icon="chevron-right"></span>' );
				}
				$pagination_output .= '</li>';
				$pagination_output .= '</ul>';
			break;
		}

		if ( $is_echo ) {
			echo apply_filters( 'dahz_framework_pagination_output', $pagination_output, $pagination_type );
		} else {
			return apply_filters( 'dahz_framework_pagination_output', $pagination_output, $pagination_type );
		}
	}
	
}


/**
 * 25. dahz_framework_meta_post
 * render author time and comment
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_meta_post' ) ) {
	function dahz_framework_meta_post() {
		$comments_count = get_comments_number();
		$author_icon    = apply_filters( 'dahz_framework_render_author_icon', '' );
		$date_icon      = apply_filters( 'dahz_framework_render_date_icon', '<span data-uk-icon="clock"></span>' );
		$comment_icon   = apply_filters( 'dahz_framework_render_comment_icon', '<span data-uk-icon="comment"></span>' );
		$separator      = apply_filters( 'dahz_framework_render_meta_separator', '/' );
		$render_author  = apply_filters( 'dahz_framework_render_author', dahz_framework_get_option( 'blog_single_enable_author', true ) );
		$render_date    = apply_filters( 'dahz_framework_render_date', dahz_framework_get_option( 'blog_single_enable_date', true ) );
		$render_comment = apply_filters( 'dahz_framework_render_comment', dahz_framework_get_option( 'blog_single_enable_comment_counts', true ) );
		$option_comment = true;

		if ( is_single() ) {
			if ( comments_open() ) {
				$option_comment = true;
			} else {
				$option_comment = false;
			}
		}

		if ( is_home() || is_archive() ) {
			$post = get_post();

			$option_comment = 'open' == $post->comment_status ? true : false;
		}

		return dahz_framework_get_template_html( 'content/global/meta.php',
			array(
				'comments_count' => $comments_count,
				'author_icon'    => $author_icon,
				'date_icon'      => $date_icon,
				'comment_icon'   => $comment_icon,
				'separator'      => $separator,
				'render_author'  => $render_author,
				'render_date'    => $render_date,
				'render_comment' => $render_comment,
				'option_comment' => $option_comment
			)
		);
	}
}

/**
 * 26. dahz_framework_get_meta_author_link
 * get archive url time on post meta
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_get_meta_author_link' ) ) {
	function dahz_framework_get_meta_author_link() {
		/* Get date for meta link */
		return get_author_posts_url( get_the_author_meta( 'ID' ) );
	}
}

/**
 * 27. dahz_framework_get_meta_time_link
 * get archive url time on post meta
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_get_meta_time_link' ) ) {
	function dahz_framework_get_meta_time_link() {
		/* Get date for meta link */
		$archive_year  = get_the_time( 'Y' );
		$archive_month = get_the_time( 'm' );
		$archive_day   = get_the_time( 'd' );

		return esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) );
	}
}

/**
 * 28. dahz_framework_get_meta_comment_link
 * get archive url comment on post meta
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_get_meta_comment_link' ) ) {
	function dahz_framework_get_meta_comment_link() {
		/* Get comment link */
		if ( is_single() ) {
			$output = sprintf( '#comments' );
		} else {
			$output = sprintf( '%s#comments', esc_url( get_permalink() ) );
		}

		return $output;
	}
}

/**
 * 27. dahz_framework_post_navigation
 * render post navigation
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_post_navigation' ) ) {
	function dahz_framework_post_navigation() {
		if ( !apply_filters( 'dahz_framework_enable_post_navigation', true ) ) return;

		$prev = get_permalink( get_adjacent_post(false,'',true) );
		$next = get_permalink( get_adjacent_post(false,'',false) );
		$prev_post = get_previous_post();
		$next_post  = get_next_post();

		global $wp;

		$current_url = home_url( add_query_arg( array(), $wp->request ) );

		$dv_html = '';

		$dv_html .= $prev != $current_url . '/' || $next != $current_url . '/' ? '<ul class="de-post-navigation uk-width-1-1@m uk-flex uk-padding-remove-left">' : '';

		if ( ( !empty( $prev ) && $prev_post != '' ) && ( $prev != $current_url . '/' || $next != $current_url . '/' ) ) {
			$url      = esc_url( $prev );
			$icon     = dahz_framework_render_svg( 'left_arrow' );
			$title    = esc_html__( 'Previous Reading', 'kitring' );
			$dv_html .= apply_filters(
				'dahz_framework_post_navigation_prev',
				sprintf(
					'<li class="de-post-navigation__previous uk-width-1-1@s uk-width-1-2@m">
						<a href="%1$s" class="uk-link uk-link-heading uk-flex uk-flex-column">
							%2$s 
							<span class="uk-margin uk-margin-remove-top uk-text-small">%3$s</span>
							<h4 class="uk-margin-remove-top">%4$s</h4>
						</a>
					</li>',
					$url,
					$icon,
					$title,
					esc_html($prev_post->post_title)
				),
				$url,
				$icon,
				$title
			);
		}

		if ( ( !empty( $next ) && $next_post != '' ) && ( $prev != $current_url . '/' || $next != $current_url . '/' ) ) {
			$url      = esc_url( $next );
			$icon     = dahz_framework_render_svg( 'right_arrow' );
			$title    = esc_html__( 'Next Reading', 'kitring' );
			$dv_html .= apply_filters(
				'dahz_framework_post_navigation_next',
				sprintf(
					'<li class="de-post-navigation__next uk-width-1-1@s uk-width-1-2@m">
						<a href="%1$s" class="uk-link uk-link-heading uk-flex uk-flex-column">
							%2$s
							<span class="uk-margin uk-margin-remove-top uk-text-small">%3$s</span>
							<h4 class="uk-margin-remove-top">%4$s</h4>
						</a>
					</li>',
					$url,
					$icon,
					$title,
					esc_html($next_post->post_title)
				),
				$url,
				$icon,
				$title
			);
		}

		$dv_html .= $prev != $current_url . '/' || $next != $current_url . '/' ? '</ul>' : '';

		return $dv_html;
	}
}

/**
 * 28. dahz_framework_builder_use_preset
 * override builder element with template used
 * @param - $builder_element, $builder_type, $device_type
 * @return - $builder_element
 */
if ( !function_exists( 'dahz_framework_builder_use_preset' ) ) {
	function dahz_framework_builder_use_preset( $builder_element, $builder_type, $device_type ) {
		global $dahz_framework;

		$builder_is_use_preset = dahz_framework_get_option( "{$builder_type}_builder_element_{$device_type}_is_use_preset", false );

		if ( $builder_is_use_preset ) {
			$builder_preset_name = dahz_framework_get_option( "{$builder_type}_builder_element_{$device_type}_preset_used" );

			$builder_preset = get_option( "dahz_customize_{$builder_type}_builder_preset_{$builder_preset_name}" );

			if ( is_array( $builder_preset ) ) {
				$builder_element = json_encode( $builder_preset, true );
			}
		}

		return $builder_element;
	}

	add_filter( 'dahz_framework_builder_element_json', 'dahz_framework_builder_use_preset', 10, 3 );
}

/**
 * 29. dahz_framework_format_comment
 * format comment html5
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_format_comment' ) ) {
	function dahz_framework_format_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<li <?php comment_class( 'uk-visible-toggle' ); ?> id="comment-<?php comment_ID(); ?>">
			<article class="comment-wrapper uk-comment">
					<header class="uk-comment-header uk-grid-medium uk-flex-middle uk-grid" data-uk-grid>
						<div class="uk-width-auto">
							<?php echo get_avatar( $comment, 80, '', '', array( 'class' => 'uk-comment-avatar' ) ); ?>
						</div>
						<div class="uk-width-expand">
								<?php printf(
									'
									<h5 class="uk-comment-title">
										<a class="uk-link uk-link-reset" href="%s" class="comment-name">%s</a>
									</h5>
									', esc_url( get_comment_author_url() ),
									get_comment_author( get_comment_ID() )
								); ?>
								<ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
									<li>
										<a class="uk-link uk-link-muted comment-permalink" href="<?php echo esc_url( htmlspecialchars ( get_comment_link( $comment->comment_ID ) ) ); ?>">
											<?php printf( '%1$s %2$s', get_comment_date(), get_comment_time() ); ?>
										</a>
									</li>
									<li>
										<?php
										comment_reply_link(
											array_merge( $args, array(
													'reply_text' => esc_html__( 'Reply', 'kitring' ),
													'add_below'  => 'comment',
													'depth'      => $depth,
													'max_depth'  => $args['max_depth']
												)
											)
										);
										?>
									</li>
									<?php if ( is_user_logged_in() ) { ?>
										<li>
											<?php edit_comment_link( __( 'Edit', 'kitring' ), '<span class="de-comments__edit-btn">', '</span>' ); ?>
										</li>
									<?php }	?>
								</ul>
						</div>
					</header>
					<div class="comment-content uk-comment-body">
						<?php comment_text(); ?>
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<p><?php esc_html_e( 'Your comment is awaiting moderation.', 'kitring' ); ?></p>
						<?php endif; ?>
					</div>
			</article>
		</li>
		<?php
	}
}

/**
 * 17. dahz_framework_render_svg
 * render svg
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_svg' ) ) {
	function dahz_framework_render_svg($svg_type) {
		global $dahz_framework_svg_lists;

		return isset( $dahz_framework_svg_lists[$svg_type] ) ? $dahz_framework_svg_lists[$svg_type] : '';
	}
}

/**
 * 11. dahz_framework_breadcrumbs
 * render breadcrumbs
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_breadcrumbs' ) ) {
	function dahz_framework_breadcrumbs() {
		dahz_framework_include( get_template_directory() . '/dahz-framework/class-dahz-framework-breadcrumbs.php' );

		$breadcrumb = new Dahz_Framework_Breadcrumbs();

		return $breadcrumb->dahz_framework_breadcrumbs_init();
	}
}

if ( !function_exists( 'dahz_framework_render_breadcrumbs' ) ) {
	function dahz_framework_render_breadcrumbs() {
		printf( '%s %s %s',
			apply_filters( 'dahz_framework_breadcrumbs_open', '<div class="entry-breadcrumbs de-single__entry-breadcrumbs">' ),
			dahz_framework_breadcrumbs(),
			apply_filters( 'dahz_framework_breadcrumbs_close', '</div>' )
		);
	}
}

if ( !function_exists( 'dahz_framework_render_backtotop' ) ) {
	function dahz_framework_render_backtotop() {
		if ( dahz_framework_get_option( 'global_enable_back_to_top', false ) ) {
			echo sprintf(
				'
				<a class="uk-hidden de-back-to-top uk-box-shadow-hover-medium ds-btt--btn" data-uk-totop data-uk-scroll="offset: 46;" data-uk-scrollspy="target: > de-site-after-footer;cls:uk-animation-fade">
					<i data-uk-icon="arrow-up"></i>
				</a>
				',
				esc_html__( 'TOP', 'kitring' )
			);
		}
	}
}

/**
 * 17. dahz_framework_render_tags
 * render tags
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_tags' ) ) {
	function dahz_framework_render_tags() {
		$dv_html  = '<ul class="de-tags">';
		$dv_html .= sprintf( '<li class="de-tags__svg">%1$s</li>', dahz_framework_render_svg( 'coupun' ) );
		$dv_html .= get_the_tag_list( '<li>', '</li><li>', '</li>' );
		$dv_html .= '</ul>';

		return apply_filters( 'dahz_framework_render_tags', $dv_html );
	}
}

/**
 * 18. dahz_framework_render_post_thumbnail
 * render tags
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_post_thumbnail' ) ) {
	
	function dahz_framework_render_post_thumbnail( $id ) {
		
		$post_format = get_post_format( get_the_ID() );

		$post_format = empty( $post_format ) ? 'standard' : $post_format;
		
		dahz_framework_get_template( "content/single-post/featured-post-format/{$post_format}.php" );
	}
	
}


/**
 * 20. dahz_framework_render_post_title
 * render post title
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_post_title' ) ) {
	function dahz_framework_render_post_title( $id ) {
		dahz_framework_get_template( 'content/single-post/title.php' );
	}
}


/**
 * 21. dahz_framework_render_post_content
 * render post title
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_post_content' ) ) {
	function dahz_framework_render_post_content( $id ) {
		the_content( sprintf(
			esc_html__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'kitring' ),
			get_the_title()
		) );

		wp_link_pages( array(
			'before'      => '<div class="page-links de-pagination de-pagination__post uk-pagination uk-margin-remove-left" data-pagination-type="number">',
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) );
	}
}

add_action( 'dahz_framework_single_post_content', 'dahz_framework_render_post_content', 10 );

/**
 * render tags
 *
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_get_tags' ) ) {
	
	function dahz_framework_get_tags( $args = array() ) {
		
		$tags = get_the_tags( get_the_ID() );

		$tag_links = '';

		if ( !empty( $tags ) ) {
			
			$args = wp_parse_args( 
				$args, 
				array(
					'before'		=> '<li class="uk-width-auto">',
					'after'			=> '</li>',
					'items_wrap'	=> '<a href="%1$s" title="%2$s" class="%3$s uk-button uk-button-small uk-button-secondary">%4$s</a>',
				) 	
			);
			
			foreach ( $tags as $tag ) {
				
				$tag_link = get_tag_link( $tag->term_id );
				
				$tag_links .= $args['before'];
				
				$tag_links .= sprintf(
					$args['items_wrap'],
					esc_url( $tag_link ),
					esc_attr( $tag->name ),
					esc_attr( $tag->slug ),
					esc_html( $tag->name )
				);
				
				$tag_links .= $args['after'];
			
			}
			
		}

		return $tag_links;
	}
	
}

/**
 * 22. dahz_framework_render_post_tags
 * render post title
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_post_tags' ) ) {
	
	function dahz_framework_render_post_tags( $id ) {
		
		$tag_list = dahz_framework_get_tags();
		
		$enable_single_tags = dahz_framework_get_option( 'blog_single_enable_tags', false );
		
		if ( !empty( $tag_list ) &&  $enable_single_tags ) {
			
			dahz_framework_get_template( 
				'content/single-post/tags.php',
				array(
					'tag_list'	=> $tag_list,
				)
			);
		
		}
		
	}
	
}

add_action( 'dahz_framework_single_post_content', 'dahz_framework_render_post_tags', 20 );


/**
 * 22. dahz_framework_render_post_navigation
 * render post navigation
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_post_navigation' ) ) {
	
	function dahz_framework_render_post_navigation() {
		
		$enable_single_navigation = dahz_framework_get_option( 'blog_single_enable_prev_next_button', false );
		
		if( is_attachment() || ! $enable_single_navigation ){return;}

		dahz_framework_get_template( 'content/single-post/pagination.php' );

	}

	add_action( 'dahz_framework_single_post_after_content', 'dahz_framework_render_post_navigation' );

}

/**
 * 23. dahz_framework_site_width_class
 * render global general layout site width
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_site_width_class' ) ) {
	function dahz_framework_site_width_class( $class ) {
		$layout_site_width = dahz_framework_get_option( 'layout_site_width', '1200px' );

		$class .= !empty( $layout_site_width ) ? ' de-content--has-width' : '';

		return $class;
	}
}

add_filter( 'dahz_framework_de_content_class', 'dahz_framework_site_width_class' );

/**
 * 24. dahz_framework_general_layout_outer_width
 * render global general layout outer width
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_general_layout_outer_width' ) ) {
	function dahz_framework_general_layout_outer_width( $class ) {
		global $dahz_framework;
		$layout_outer_width = dahz_framework_get_option( 'layout_outer_width' );
		$class .= !empty( $layout_outer_width ) ? ' de-site__has-outer-width' : '';

		return $class;
	}
}

add_filter( 'dahz_framework_site_wrapper_class', 'dahz_framework_general_layout_outer_width' );

/**
 * 25. dahz_framework_general_layout_background_color
 * render global general layout background color
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_general_layout_background_color' ) ) {
	function dahz_framework_general_layout_background_color( $class ) {
		global $dahz_framework;
		$layout_background_color = dahz_framework_get_option( 'layout_background_color', '#ffffff' );
		$class .= !empty( $layout_background_color ) ? ' de-site__general-background-color' : '';

		return $class;
	}
}

if ( !function_exists( 'dahz_framework_get_post_content_block' ) ) {
	function dahz_framework_get_post_content_block( $slug, $is_object = false ) {
		global $dahz_framework_content_blocks;

		if ( !is_array( $dahz_framework_content_blocks ) ) {
			$dahz_framework_content_blocks = array();
		}

		$post_content = '';

		if ( !isset( $dahz_framework_content_blocks[$slug] ) ) {
			$transient_key = "dahz_framework_content_blocks_{$slug}";

			$dahz_framework_content_blocks[$slug] = get_transient( $transient_key );

			if ( false === $dahz_framework_content_blocks[$slug] ) {
				$dahz_framework_content_blocks[$slug] = get_posts(
					array(
						'name'			=> $slug,
						'post_type'		=> 'content-block',
						'post_status'	=> 'publish',
						'numberposts'	=> 1
					)
				);

				set_transient( $transient_key, $dahz_framework_content_blocks[$slug], MONTH_IN_SECONDS );
			}
		}

		if ( $dahz_framework_content_blocks[$slug] ) {
			$post_content = $is_object ? $dahz_framework_content_blocks[$slug][0] : $dahz_framework_content_blocks[$slug][0]->post_content;
		} else {
			$post_content = $is_object ? false : '';
		}

		return $post_content;
	}
}

if ( !function_exists( 'dahz_framework_get_vc_style' ) ) {
	function dahz_framework_get_vc_style( $id ) {
		global $dahz_framework_vc_styles;

		$vc_style = '';

		if ( !is_array( $dahz_framework_vc_styles ) ) {
			$dahz_framework_vc_styles = array();
		}

		if ( !isset( $dahz_framework_vc_styles[ $id ] ) ) {
			$dahz_framework_vc_styles[ $id ] = get_post_meta( $id, '_wpb_shortcodes_custom_css', true ) ;

			$vc_style = $dahz_framework_vc_styles[ $id ];
		}

		return $vc_style;
	}
}

add_filter( 'dahz_framework_site_wrapper_class', 'dahz_framework_general_layout_background_color' );

if ( !function_exists( 'dahz_framework_render_search_form' ) ) {
	function dahz_framework_render_search_form() {
		get_search_form();
	}
}

if ( !function_exists( 'dahz_framework_render_most_categories' ) ) {
	function dahz_framework_render_most_categories() {
		if ( dahz_framework_categorized_blog() ) {
			dahz_framework_get_template( 'content/404/most-categories.php' );
		}
	}
}

if ( !function_exists( 'dahz_framework_render_404_widget' ) ) {
	function dahz_framework_render_404_widget() {
		the_widget( 'WP_Widget_Recent_Posts' );

		/* translators: %1$s: smiley */
		$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'kitring' ), convert_smilies( ':)' ) ) . '</p>';
		the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

		the_widget( 'WP_Widget_Tag_Cloud' );
	}
}

if ( !function_exists( 'dahz_framework_page_title' ) ) {
	function dahz_framework_page_title() {

	}
}

if ( !function_exists( 'dahz_framework_overrides_header_preset' ) ) {
	function dahz_framework_overrides_header_preset( $source, $preset_name, $active_callback ) {
		global $dahz_framework_header_preset_registered;

		if ( !is_array( $dahz_framework_header_preset_registered ) ) {
			$dahz_framework_header_preset_registered = array();
		}

		$builder_preset = '';

		$builder_preset = dahz_framework_get_preset( $source, 'header', $preset_name  );

		if ( is_array( $builder_preset ) && isset( $builder_preset[ 'dataSection' ] ) ) {

			dahz_framework_override_theme_mods( $builder_preset[ 'dataSection' ] );

		}

		$dahz_framework_header_preset_registered[] = array(
			'is_active'			=> true,
			'source'			=> $source,
			'preset_name'		=> $preset_name,
			'builder_preset'	=> $builder_preset
		);
	}
}

if ( !function_exists( 'dahz_framework_overrides_footer_preset' ) ) {
	function dahz_framework_overrides_footer_preset( $source, $preset_name, $active_callback ) {
		global $dahz_framework_footer_preset_registered;

		if ( !is_array( $dahz_framework_footer_preset_registered ) ) {
			$dahz_framework_footer_preset_registered = array();
		}

		$builder_preset = '';

		$builder_preset = dahz_framework_get_preset( $source, 'footer', $preset_name  );
		if ( is_array( $builder_preset ) && isset( $builder_preset[ 'dataSection' ] ) ) {
			dahz_framework_override_theme_mods( $builder_preset[ 'dataSection' ] );
		}

		$dahz_framework_footer_preset_registered[] = array(
			'is_active'			=> true,
			'source'			=> $source,
			'preset_name'		=> $preset_name,
			'builder_preset'	=> $builder_preset
		);
	}
}
/**
 * dahz_framework_overrides_header_preset
 * set value for overridden header from customizer
 * @param $builder_element, $builder_type, $device_type
 * @return $builder_element
 */

add_filter( 'dahz_framework_builder_element_json', 'dahz_framework_filter_overrides_header_preset' , 50, 3 );

if ( !function_exists( 'dahz_framework_filter_overrides_header_preset' ) ) {
	function dahz_framework_filter_overrides_header_preset( $builder_element, $builder_type, $device_type ) {
		if ( $builder_type !== 'header' ) return $builder_element;

		global $dahz_framework_header_preset_registered;

		if ( is_array( $dahz_framework_header_preset_registered ) ) {
			foreach( $dahz_framework_header_preset_registered as $header_preset ) {
				if ( $header_preset['is_active'] ) {
					if ( is_array( $header_preset['builder_preset'] ) ) {
						$builder_element = json_encode( $header_preset['builder_preset'], true );
					}
				}
			}
		}

		return $builder_element;
	}
}

/**
 * dahz_framework_overrides_footer_preset
 * set value for overridden footer from customizer
 * @param $builder_element, $builder_type, $device_type
 * @return $builder_element
 */

add_filter( 'dahz_framework_builder_element_json', 'dahz_framework_filter_overrides_footer_preset' , 50, 3 );

if ( !function_exists( 'dahz_framework_filter_overrides_footer_preset' ) ) {
	function dahz_framework_filter_overrides_footer_preset( $builder_element, $builder_type, $device_type ) {
		global $dahz_framework_footer_preset_registered;

		if ( $builder_type !== 'footer' ) return $builder_element;

		if ( is_array( $dahz_framework_footer_preset_registered ) ) {
			foreach( $dahz_framework_footer_preset_registered as $footer_preset ) {
				if ( $footer_preset['is_active'] ) {
					if ( is_array( $footer_preset['builder_preset'] ) ) {
						$builder_element = json_encode( $footer_preset['builder_preset'], true );
					}
				}
			}
		}

		return $builder_element;
	}
}

if ( !function_exists( 'dahz_framework_do_content_block' ) ) {
	function dahz_framework_do_content_block( $content_block ) {
		if ( empty( $content_block ) || !class_exists( 'DahzExtender_Content_Blocks' ) ) return '';

		return do_shortcode( shortcode_unautop( "[dahz-block id='{$content_block}']" ) );
	}
}

if ( !function_exists( 'dahz_framework_set_attributes' ) ) {
	function dahz_framework_set_attributes( $attributes = array(), $key = '', $atts = array(), $is_echo = true ) {
		if ( !is_array( $attributes ) ) return;

		$attribute_output = array();

		$key = !empty( $key ) ? "_{$key}" : '';

		$attributes = apply_filters( "dahz_framework_attributes{$key}_args", $attributes, $atts );

		foreach( $attributes as $attribute => $attribute_value ) {
			$attribute_output[] = sprintf(
				'%1$s="%2$s"',
				$attribute,
				is_array( $attribute_value ) ? esc_attr( trim( preg_replace( '!\s+!', ' ', implode( ' ', $attribute_value ) ) ) ) : esc_attr( trim( preg_replace( '!\s+!', ' ', $attribute_value ) ) )
			);
		}

		if ( $is_echo ) {
			echo apply_filters( "dahz_framework_attributes{$key}_output", implode( ' ', $attribute_output ) );
		} else {
			return apply_filters( "dahz_framework_attributes{$key}_output", implode( ' ', $attribute_output ) );
		}
	}
}

if ( !function_exists( 'dahz_framework_edit_link' ) ) {
	function dahz_framework_edit_link() {
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit', 'kitring' ),
				get_the_title()
			)
		);
	}
}

if ( !function_exists( 'dahz_framework_sub_meta' ) ) {
	function dahz_framework_sub_meta() {
		$author_icon   = apply_filters( 'dahz_framework_render_author_icon', '' );
		$render_author = apply_filters( 'dahz_framework_render_author', dahz_framework_get_option( 'blog_single_enable_author', true ) );
		$category_link = '';

		$categories = get_the_category( get_the_ID() );

		return dahz_framework_get_template_html( 'content/global/sub-meta.php',
			array(
				'author_icon'	=> $author_icon,
				'render_author'	=> $render_author,
				'category_link'	=> $category_link,
				'categories'	=> $categories
			)
		);
	}
}

/*
New Function
*/
if( ! function_exists( 'dahz_framework_get_post_columns' ) ){
	
	function dahz_framework_get_post_columns( $count, $mode = 1 ) {

		global $wp_query;

		$posts = $wp_query->posts;
		
		$count = max( 1, $count );
		
		$columns = [];

		if ($mode == 0) {

			while ( $posts ) {
				
				$columns[] = array_splice( $posts, 0, ceil( count( $posts ) / ( $count - count( $columns ) ) ) );
			
			}

		} else {

			foreach ( $posts as $i => $post ) {
				
				$columns[$i % $count][] = $post;
			
			}
			
		}

		return $columns;
	
	}

}

if( ! function_exists( 'dahz_framework_get_sticky_post' ) ){
	
	function dahz_framework_get_sticky_post( $id = null ) {
		
		$id = $id ? $id : get_the_ID();

		return is_sticky( $id ) ? '<span data-uk-icon="bell"></span>' : '';

	}
	
}

if( ! function_exists( 'dahz_framework_sticky_post' ) ){
	
	function dahz_framework_sticky_post( $id = null ) {
		
		$id = $id ? $id : get_the_ID();
		
		echo dahz_framework_get_sticky_post( $id );

	}
	
}

if ( !function_exists( 'dahz_framework_get_post_meta_author' ) ) {
	
	function dahz_framework_get_post_meta_author( $id = null ) {
		
		$id = $id ? $id : get_the_ID();
		
		return sprintf(
			'
			<a href="%1$s" class="uk-link de-post-meta__author">
				%2$s
			</a>
			',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
		
	}

}

if ( !function_exists( 'dahz_framework_post_meta_author' ) ) {
	
	function dahz_framework_post_meta_author( $id = null ) {
		
		$id = $id ? $id : get_the_ID();
		
		echo dahz_framework_get_post_meta_author( $id );
		
	}

}

if ( !function_exists( 'dahz_framework_get_post_meta_categories' ) ) {
	
	function dahz_framework_get_post_meta_categories( $id = null, $taxonomy = 'category' ) {
		
		$category_link = '';
		
		$id = $id ? $id : get_the_ID();

		$categories = get_the_terms( $id, $taxonomy );
		
		if( is_wp_error( $categories ) || ! $categories ){ return '';}
		
		$categories_html = '';

		foreach( $categories as $category ) {
			
			$categories_html .= sprintf(
				'
				<a class="uk-link" href="%1$s">
					%2$s
				</a>
				',
				esc_url( get_category_link( $category->term_id ) ),
				esc_html( $category->name )
			);
		
		}
		
		if( empty( $categories_html ) ){ return '';}

		return sprintf(
			'<div class="uk-flex uk-width-1 de-post-meta__categories">%1$s</div>',
			$categories_html 
		);
		
	}

}

if ( !function_exists( 'dahz_framework_post_meta_categories' ) ) {
	
	function dahz_framework_post_meta_categories( $id = null, $taxonomy = 'category' ) {
		
		echo dahz_framework_get_post_meta_categories( $id, $taxonomy );
		
	}

}

if ( !function_exists( 'dahz_framework_get_post_meta_date' ) ) {
	
	function dahz_framework_get_post_meta_date( $id = null ) {
		
		return sprintf(
			'
			<a href="%1$s" class="uk-link de-post-meta__date">
				%2$s
			</a>
			',
			get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ),
			get_the_date()
		);
		
	}
	
}

if ( !function_exists( 'dahz_framework_post_meta_date' ) ) {
	
	function dahz_framework_post_meta_date( $id = null ) {
		
		echo dahz_framework_get_post_meta_date( $id );
		
	}
	
}

if ( !function_exists( 'dahz_framework_get_post_meta_comment' ) ) {
	
	function dahz_framework_get_post_meta_comment( $id = null ) {
		
		$id = $id ? $id : get_the_ID();
		
		$allow_comment = comments_open( $id );
		
		if( ! $allow_comment ){
			return '';
		}
		
		$comment_link = '';
		
		$comments_count = get_comments_number();
		
		if ( is_single() ) {
			
			$comment_link = sprintf( '#comments' );
		
		} else {
			
			$comment_link = sprintf( '%s#comments', esc_url( get_permalink() ) );
		
		}
						
		return sprintf(
			'
			<a href="%1$s" class="uk-link de-post-meta__comment">
				%2$s
			</a>
			',
			$comment_link,
			$comments_count > 0 
				?
				sprintf(
					esc_html( _nx( '%1$s Comment', '%2$s Comments', $comments_count, 'approved comments count ', 'kitring' ) ),
					'1',
					number_format_i18n( $comments_count )
				)
				:
				esc_html__( 'Leave a reply', 'kitring' )
		);
				
	}

}

if ( !function_exists( 'dahz_framework_post_meta_comment' ) ) {
	
	function dahz_framework_post_meta_comment() {
		
		dahz_framework_get_post_meta_comment();
		
	}

}

if( ! function_exists( 'dahz_framework_get_post_meta' ) ){
	
	function dahz_framework_get_post_meta( $id = null, $args = array() ) {
		
		$postTitleAlignment = dahz_framework_get_option( 'blog_single_title_alignment', 'left' );

		$singlePostTitleLayout = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'post_title_alignment', 'left' );
		
		$postAlignmentClass = '';
		
		if( is_single() ) {
		
			if ( $postTitleAlignment == 'left' ) {
				
				if ( $singlePostTitleLayout == 'left' ) {
		
					$postAlignmentClass = '';
		
				} elseif ( $singlePostTitleLayout == 'center' ) {
		
					$postAlignmentClass = 'uk-flex uk-flex-center';
		
				} else {
					$postAlignmentClass = '';
				}
		
			} elseif ( $postTitleAlignment == 'center' ) {
				
				if ( $singlePostTitleLayout == 'left' ) {
		
					$postAlignmentClass = '';
		
				} elseif ( $singlePostTitleLayout == 'center' ) {
		
					$postAlignmentClass = 'uk-flex uk-flex-center';
		
				} else {
					$postAlignmentClass = 'uk-flex uk-flex-center';
				}
		
			}
		
			$uikitSinglePostTitleClass = 'de-post-meta uk-margin-remove-top ' . $postAlignmentClass;
		
		} else {
			$uikitSinglePostTitleClass = 'de-post-meta';
		}

		$metas_html = '';
		
		$id = $id ? $id : get_the_ID();
		
		$args = wp_parse_args( 
			$args, 
			array(
				'before'		=> '<li class="uk-width-auto">',
				'after'			=> '</li>',
				'items_wrap'	=> '<ul class="uk-text-small uk-subnav uk-subnav-divider uk-margin %2$s" data-uk-margin>%1$s</ul>',
				'metas'			=> apply_filters( 
					'dahz_framework_post_metas', 
					array(
						'date',
						'categories',
						'comment',
					) 
				),
				'meta_params'	=> array(
					'date'		=> array( $id ),
					'categories'=> array( $id ),
					'comment'	=> array( $id ),
				)
			) 	
		);
		
		if( isset( $args['metas'] ) && is_array( $args['metas'] ) ){
			
			foreach( $args['metas'] as $meta ){
				
				if( function_exists( "dahz_framework_get_post_meta_{$meta}" ) ){
					
					$params = isset( $args['meta_params'][$meta] ) && is_array( $args['meta_params'][$meta] ) ? $args['meta_params'][$meta] : array( $id );
											
					$meta_content = call_user_func_array( "dahz_framework_get_post_meta_{$meta}", $params );

					if( $meta_content ){
						
						$metas_html .= $args['before'] . $meta_content . $args['after'];
						
					}			
					
				}
				
			}
			
		}
		
		return $metas_html ? sprintf(
			$args['items_wrap'],
			$metas_html,
			esc_attr( $uikitSinglePostTitleClass )
		) : '';

	}
	
}

if( ! function_exists( 'dahz_framework_post_meta' ) ){
	
	function dahz_framework_post_meta( $id = null, $args = array() ) {
		
		echo dahz_framework_get_post_meta( $id, $args );

	}
	
}

if( ! function_exists( 'dahz_framework_get_title' ) ){
	
	function dahz_framework_get_title( $args = array() ) {
		
		$args = wp_parse_args(
			$args,
			array(
				'title_tag'		=> 'h2',
				'title_length'	=> 0,
				'class'			=> 'uk-margin-remove'
			)
		);
		
		$title = $args['title_length'] > 0 ? wp_trim_words( get_the_title(), $args['title_length'], ' ...' ) : get_the_title();
		
		return sprintf( '<%1$s %2$s><a class="uk-link" href="%3$s">%4$s</a></%1$s>',
			$args['title_tag'],
			dahz_framework_set_attributes( 
				array( 
					'class' => array( $args['class'] ),
				),
				'loop_post_title',
				array(),
				false
			),
			esc_url( get_permalink() ),
			$title
		);

	}
	
}

if( ! function_exists( 'dahz_framework_title' ) ){
	
	function dahz_framework_title( $args = array() ) {
				
		echo dahz_framework_get_title( $args );
		
	}
	
}

if( ! function_exists( 'dahz_framework_get_featured_image' ) ){
	
	function dahz_framework_get_featured_image( $id = null, $args = array() ) {
		
		$image = "";
		
		$id = ! empty( $id ) ? $id : get_the_ID();
		
		if ( has_post_thumbnail( $id ) ) {
			
			$args = wp_parse_args(
				$args, 
				array(
					'size'			=> 'full',
					'attributes'	=> array( 'class' => 'img-responsive de-img-thumbnail' ),
					'items_wrap'	=> '<a href="%1$s" class="entry-thumbnail" aria-label="%2$s">%3$s</a>',
				) 	
			);

			$image = get_the_post_thumbnail( get_the_ID(), $args['size'] , $args['attributes'] );

			$image = sprintf( 
				$args['items_wrap'],
				esc_url( get_permalink() ),
				__( 'View Post', 'kitring' ),
				$image
			);

		}
		return $image;

	}
	
}

if( ! function_exists( 'dahz_framework_featured_image' ) ){
	
	function dahz_framework_featured_image( $id = null, $args = array() ) {

		echo dahz_framework_get_featured_image( $id, $args );

	}
	
}

if( ! function_exists( 'dahz_framework_excerpt_is_read_more' ) ){
	
	function dahz_framework_excerpt_is_read_more( $content = '', $num_words = 40 ) {

		$text = wp_strip_all_tags( $content );

		if ( strpos( _x( 'words', 'Word count type. Do not translate!', 'kitring' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
			
			$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
			
			preg_match_all( '/./u', $text, $words_array );
			
			$words_array = array_slice( $words_array[0], 0, $num_words + 1 );
		
		} else {
			
			$words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
		
		}
		
		return ( count( $words_array ) > $num_words ) ? true : false;
		
	}
	
}

if( ! function_exists( 'dahz_framework_get_excerpt' ) ){
	
	function dahz_framework_get_excerpt( $args = array() ) {
				
		$read_more = '';
		
		$args = wp_parse_args(
			$args, 
			array(
				'show_readmore'		=> true,
				'num_words'			=> 40,
				'button_type'		=> 'uk-button-default',
				'button_size'		=> '',
				'readmore_content'	=> ' &hellip;',
			) 	
		);
		
		if ( $args['num_words'] >= 0 ) {
			
			$content = get_the_excerpt();
			
			$content = !empty( $content ) ? $content : get_the_content();
			
			$content = wp_trim_words(
				strip_shortcodes( $content ),
				$args['num_words'],
				$args['readmore_content']
			);
			
		} else {
			
			$content = get_the_content();

			$content = !empty( $content ) ? $content : get_the_content();

			$content = apply_filters( 'the_content', $content );

			$content = do_shortcode( $content );
		}
		
		return dahz_framework_get_template_html(
			'content/global/excerpt.php',
			array(
				'content'		=> $content,
				'is_read_more'	=> $args['show_readmore'] && dahz_framework_excerpt_is_read_more( get_the_content(), $args['num_words'] ) ? true : false,
				'button_type'	=> $args['button_type'],
				'button_size'	=> $args['button_size'],
			)
		);

	}
	
}

if( ! function_exists( 'dahz_framework_excerpt' ) ){
	
	function dahz_framework_excerpt( $args = array() ) {
		
		echo dahz_framework_get_excerpt( $args );
		
	}
	
}

if( ! function_exists('dahz_framework_before_content_switcher') ) {

	function dahz_framework_before_content_switcher( $id ) {

		$singlePostLayout = dahz_framework_get_meta( $id, 'dahz_meta_post', 'single_content_post_featured_image' );

		if ( $singlePostLayout == 'top' ) {
			dahz_framework_render_post_thumbnail( $id );
	
			dahz_framework_post_meta( $id = null );
	
			dahz_framework_render_post_title( $id );
		} else {
			dahz_framework_post_meta( $id = null );
			
			dahz_framework_render_post_title( $id );
			
			dahz_framework_render_post_thumbnail( $id );
		}


	}

}

add_action( 'dahz_framework_single_post_before_content', 'dahz_framework_before_content_switcher' );

if( ! function_exists( 'dahz_framework_collect_terms' ) ){
	
	function dahz_framework_collect_terms( $terms, $collected_categories ) {
		
		$collected_terms = array();
		
		if( is_wp_error( $terms ) || ! $terms || !is_array( $terms ) ){ return $collected_categories; }
		
		foreach( $terms as $term ){
			
			if( ! isset( $collected_categories[ $term->term_id ] ) ){
				
				$collected_categories[ $term->term_id ] = $term;
				
			}
			 
		}
		
		return $collected_categories;
		
	}
	
}

if ( ! function_exists( 'dahz_classes' ) ) {
	
	function dahz_classes( $class = '' ) {
		return join( ' ', dahz_framework_add_custom_wrapper_class( $class ) );
	}

}

if ( ! function_exists( 'dahz_framework_add_custom_wrapper_class' ) ) {
	
	add_action( 'dahz_wrapper_class', 'dahz_framework_add_custom_wrapper_class', '', 1 );
	
	/**
	 * Add new filter for wrapper class, print it depends on where the function is called 
	 */
	function dahz_framework_add_custom_wrapper_class( $class = '' ) {
		global $wp_query;

		$wrapperClass = array();

		if ( is_singular() ) {
			$wrapperClass[] = 'ds-single-' . get_post_type();
		} elseif ( is_archive() ) {
			if( is_post_type_archive() ) {
				$wrapperClass[] = 'ds-archive-' . get_post_type() ;
			} elseif ( is_author() ) {
				$author = $wp_query->get_queried_object();
				if ( isset( $author->user_nicename ) ) {

					$wrapperClass[] = 'ds-archive-author-' . sanitize_html_class( $author->user_nicename, $author->ID ) . ' ds-archive-author-' . $author->ID;
				}
			} elseif ( is_category() ) {
				$cat = $wp_query->get_queried_object();
				if ( isset( $cat->term_id ) ) {
					$cat_class = sanitize_html_class( $cat->slug, $cat->term_id );
					if ( is_numeric( $cat_class ) || ! trim( $cat_class, '-' ) ) {
						$cat_class = $cat->term_id;
					}

					$wrapperClass[] = 'ds-archive-category ds-archive-category-' . $cat_class . ' ds-archive-category-' . $cat->term_id;
				}
			} elseif ( is_tag() ) {
				$tag = $wp_query->get_queried_object();
				if ( isset( $tag->term_id ) ) {
					$tag_class = sanitize_html_class( $tag->slug, $tag->term_id );
					if ( is_numeric( $tag_class ) || ! trim( $tag_class, '-' ) ) {
						$tag_class = $tag->term_id;
					}
					
					$wrapperClass[] = 'ds-archive-tag ds-archive-tag-' . $tag_class . ' ds-archive-tag-' . $tag->term_id;
				}
			} elseif ( is_tax() ) {
				$term = $wp_query->get_queried_object();
				if ( isset( $term->term_id ) ) {
					$term_class = sanitize_html_class( $term->slug, $term->term_id );
					if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
						$term_class = $term->term_id;
					}
	
					$wrapperClass[] = 'ds-archive-tax-' . sanitize_html_class( $term->taxonomy ) .' ds-archive-term-' . $term_class . ' ds-archive-term-' . $term->term_id;
					
				}
			}
		}

		if ( ! empty( $class ) ) {
			if ( !is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$wrapperClass = array_merge( $wrapperClass, $class );
		} else {
			$class = array();
		}

		$wrapperClass = array_map( 'esc_attr', $wrapperClass );

		/**
		 * filter class for wrapper / component and used by depending on where it will be called
		 */
		$wrapperClass = apply_filters( 'dahz_framework_classes', $wrapperClass, $class );

		return array_unique( $wrapperClass );

	}

}