<?php

/**
 * Dahz_Framework_Header_Wishlist
 */

class Dahz_Framework_Header_Wishlist {

	function __construct() {

		add_action( 'dahz_framework_module_header-wishlist_init', array( $this, 'dahz_framework_header_wishlist_init' ) );

		add_filter( 'dahz_framework_localize', array( $this, 'dahz_framework_check_yith_wishlist' ) );

		if ( !class_exists( 'YITH_WCWL' ) ) return;

		add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_header_item_wishlist' ), 10, 3 );
		
		add_filter( 'dahz_framework_customize_headermobile_builder_items', array( $this, 'dahz_framework_header_item_wishlist' ), 10, 3 );
		
		add_filter( 'dahz_framework_header_mobile_elements', array( $this, 'dahz_framework_header_item_wishlist' ), 10, 3 );

		add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_header_wishlist_style' ), 10, 1 );

		add_action( 'wp_ajax_dahz_framework_update_wishlist_count', array( $this, 'dahz_framework_update_wishlist_count' ), 10 );

		add_action( 'wp_ajax_nopriv_dahz_framework_update_wishlist_count', array( $this, 'dahz_framework_update_wishlist_count' ), 10 );

	}

	public function dahz_framework_header_wishlist_init( $path ) {

		if ( is_customize_preview() ) dahz_framework_include( $path . '/header-wishlist-customizer.php' );

		dahz_framework_register_customizer(
			'Dahz_Framework_Header_Wishlist_Customizer',
			array(
				'id'	=> 'header_wishlist',
				'title'	=> array( 'title' => esc_html__( 'Wishlist', 'kitring' ), 'priority' => 15 ),
				'panel'	=> 'header'
			),
			array()
		);

	}

	public function dahz_framework_header_wishlist_style( $style ) {

		$style .= sprintf(
			'
			.de-header__wrapper .de-header__wishlist > a{
				font-size:%1$s;
			}
			.de-header-mobile__wrapper .de-header__wishlist > a{
				font-size:%2$s;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist--empty .de-wishlist__total-item{
				display:none;
			}
			.de-header__wishlist .de-header__wishlist-btn .de-wishlist__total-item.uk-badge{
				color:%3$s !important;
				background-color:%4$s !important;
			}
			.de-header__wishlist .de-header__wishlist-btn span{
				padding:0 5px 0 5px;
			}
			.de-header__wishlist .de-header__wishlist-btn{
				display:flex;
				margin:0 -5px 0 -5px;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-1 .de-wishlist__text{
				order:1;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-1 .de-wishlist__total-item{
				order:2;
			}
			
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-2 .de-wishlist__icon{
				order:1;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-2 .de-wishlist__text{
				order:2;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-2 .de-wishlist__total-item{
				order:3;
			}
			
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-3 .de-wishlist__text{
				order:1;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-3 .de-wishlist__total-item{
				order:2;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-3 .de-wishlist__icon{
				order:3;
			}
			
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-4 .de-wishlist__icon{
				order:1;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-4 .de-wishlist__text{
				order:2;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-4 .de-wishlist__total-item{
				order:3;
			}
			
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-5 .de-wishlist__text{
				order:1;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-5 .de-wishlist__total-item{
				order:2;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-5 .de-wishlist__icon{
				order:3;
			}
			
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-6 .de-wishlist__text{
				order:1;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-6 .de-wishlist__total-item{
				order:2;
			}
			
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-7 .de-wishlist__total-item{
				order:1;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-7 .de-wishlist__text{
				order:2;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-9 .de-wishlist__total-item{
				order:1;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-9 .de-wishlist__icon{
				order:2;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-11 .de-wishlist__total-item{
				order:1;
			}
			.de-header__wishlist .de-header__wishlist-btn.de-header__wishlist-btn--style-11 .de-wishlist__icon{
				order:2;
			}
			',
			dahz_framework_get_option( 'header_wishlist_desktop_font_size', '18px' ),
			dahz_framework_get_option( 'header_wishlist_mobile_font_size', '18px' ),
			dahz_framework_get_option( 'header_wishlist_counter_color', '#ffffff' ),
			dahz_framework_get_option( 'header_wishlist_counter_bg_color', '#ff0000' )
		);
		
		return $style;

	}

	public function dahz_framework_check_yith_wishlist( $localize ) {
		$localize['isYithWishlistActive'] = class_exists( 'YITH_WCWL' );

		return $localize;
	}

	public function dahz_framework_header_item_wishlist( $items ) {
		$items['wishlist'] = array(
			'title'				=> esc_html__( 'Wishlist', 'kitring' ),
			'description'		=> esc_html__( 'Display wishlist', 'kitring' ),
			'render_callback'	=> array( 'Dahz_Framework_Header_Wishlist', 'dahz_framework_header_elem_wishlist' ),
			'section_callback'	=> 'header_wishlist',
			'is_repeatable'		=> false
		);

		return $items;
	}

	/**
	 * dahz_framework_update_wishlist_count
	 * send wishlist data for ajax wishlist count
	 * @param -
	 * @return -
	 */
	public function dahz_framework_update_wishlist_count() {

		wp_send_json( array( 'count' => yith_wcwl_count_all_products() ) );

	}

	/**
	* dahz_framework_header_elem_wishlist
	* render header element : wishlist
	* @param -
	* @return -
	*/
	static function dahz_framework_header_elem_wishlist( $builder_type, $section, $row, $column ) {

		$wishlist_icon = '';

		$wishlist_text = '';
		
		$total_items = yith_wcwl_count_all_products();
		
		$wishlist_total_item = '<span class="de-wishlist__total-item">'. $total_items .'</span>';
		
		$wishlist_icon_display = dahz_framework_get_option( 'header_wishlist_style', 'style-3' );
		
		if( $wishlist_icon_display == 'style-1' || $wishlist_icon_display == 'style-2' || $wishlist_icon_display == 'style-3' || $wishlist_icon_display == 'style-4' || $wishlist_icon_display == 'style-5' || $wishlist_icon_display == 'style-6' || $wishlist_icon_display == 'style-7' ){
			
			$wishlist_text = '<span class="de-wishlist__text">' . __( 'Wishlist', 'kitring' ) . '</span>';
			
		}
		
		if( $wishlist_icon_display == 'style-2' || $wishlist_icon_display == 'style-3' || $wishlist_icon_display == 'style-8' || $wishlist_icon_display == 'style-9' ){
			
			$wishlist_icon = '<span class="uk-hidden@m de-wishlist__icon" data-uk-icon="icon:df_wishlist-outline;ratio:%2$s;"></span><span class="uk-visible@m de-wishlist__icon" data-uk-icon="icon:df_wishlist-outline;ratio:%1$s;"></span>';
			
		} else if( $wishlist_icon_display == 'style-4' || $wishlist_icon_display == 'style-5' || $wishlist_icon_display == 'style-10' || $wishlist_icon_display == 'style-11' ){
			
			$wishlist_icon = '<span class="uk-hidden@m de-wishlist__icon" data-uk-icon="icon:df_wishlist-bag;ratio:%2$s;"></span><span class="uk-visible@m de-wishlist__icon" data-uk-icon="icon:df_wishlist-bag;ratio:%1$s;"></span>';
			
		}
		
		if( $wishlist_icon_display == 'style-11' || $wishlist_icon_display == 'style-10' || $wishlist_icon_display == 'style-9' || $wishlist_icon_display == 'style-8' || $wishlist_icon_display == 'style-6' || $wishlist_icon_display == 'style-7' ){
			
			$wishlist_total_item = '<span class="de-wishlist__total-item uk-badge uk-text-top">' . $total_items . '</span>';
			
		}

		if( !empty( $wishlist_icon ) ){
			
			$desktop_icon_ratio = dahz_framework_get_option( 'header_wishlist_desktop_icon_ratio', '1' );
			
			$mobile_icon_ratio = dahz_framework_get_option( 'header_wishlist_mobile_icon_ratio', '1' );
			
			$wishlist_icon = sprintf(
				$wishlist_icon,
				(float)$desktop_icon_ratio,
				(float)$mobile_icon_ratio
			);
			
		}
		
		echo sprintf(
			'
			<div class="de-header__wishlist">
				<a aria-label="%7$s" class="uk-flex uk-flex-middle uk-inline de-header__wishlist-btn de-header__wishlist-btn--%5$s%6$s" href="%1$s">
					%2$s%3$s%4$s
				</a>
			</div>
			',
			get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ),
			$wishlist_text,
			$wishlist_icon,
			$wishlist_total_item,
			$wishlist_icon_display,
			$total_items <= 0 ? ' de-header__wishlist--empty' : '',
			__( 'Wishlist', 'kitring' )
		);

	}


}

new Dahz_Framework_Header_Wishlist();