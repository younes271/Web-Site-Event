<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
 
 $after_end = '';
 
 $is_loop_product_shortcode = dahz_framework_get_static_option( 'is_loop_product_shortcode' );
 
 $enable_loop_product_slider = dahz_framework_get_static_option( 'enable_loop_product_slider' );

if( $is_loop_product_shortcode && $enable_loop_product_slider ){
	
	$show_slide_nav = dahz_framework_get_static_option( 'loop_product_slider_show_slide_nav', true );
	
	$slide_nav_position = dahz_framework_get_static_option( 'loop_product_slider_slide_nav_position', 'inside' );
	
	$show_slide_nav_when_hover = dahz_framework_get_static_option( 'loop_product_slider_show_slide_nav_when_hover', true );
	
	$slide_nav_breakpoint = dahz_framework_get_static_option( 'loop_product_slider_slide_nav_breakpoint', '@s' );
	
	$show_dot_nav = dahz_framework_get_static_option( 'loop_product_slider_show_dot_nav', false );
	
	$dot_nav_breakpoint = dahz_framework_get_static_option( 'loop_product_slider_dot_nav_breakpoint', '@s' );
	
	$after_end = sprintf( 
		'
			%1$s
			%2$s
		</div>
		',
		$show_slide_nav 
			? 
			sprintf( 
				'
				<a class="uk-position-center-left%2$s uk-position-small%1$s%3$s" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
				<a class="uk-position-center-right%2$s uk-position-small%1$s%3$s" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
				',
				$show_slide_nav_when_hover && $slide_nav_position !== 'outside' ? ' uk-hidden-hover' : '',
				$slide_nav_position == 'outside' ? '-out' : '',
				!empty( $slide_nav_breakpoint ) ? ' uk-visible' . $slide_nav_breakpoint : ''
			)
			: 
			'',
		$show_dot_nav 
			?
			sprintf(
				'
				<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin%1$s"></ul>
				',
				!empty( $dot_nav_breakpoint ) ? ' uk-visible' . $dot_nav_breakpoint : ''
			)
			:
			''
	);
	
}
?>
</ul>
<?php echo apply_filters( 'dahz_framework_woo_after_loop_end', $after_end );?>