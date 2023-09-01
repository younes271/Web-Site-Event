<?php

/** 
 * Place your template functions here
 */

add_action( 'woocommerce_before_main_content', 'dahz_framework_get_single_product_navigation_control_render', 30 );
/** 
 * 
 */
function dahz_framework_get_single_product_navigation_control_render() {

    dahz_framework_get_template(
         "single-product-navigation-control.php",
         array(),
         'dahz-modules/woo/templates/single-product/'
     );

}

add_action( 'dahz_woocommerce_before_main_content', 'dahz_framework_single_product_header_section_wrapper', 19 );
/**
 * 
 */
function dahz_framework_single_product_header_section_wrapper() {
    ?>

        <div class="ds-site-content__header">
            <div class="ds-site-content__header ds-site-content__header--wrapper">
                <div class="ds-site-content__header ds-site-content__header--wrapper-inner">

    <?php
}

add_action( 'dahz_woocommerce_before_main_content', 'dahz_framework_single_product_header_section_wrapper_end', 31 );
/**
 * 
 */
function dahz_framework_single_product_header_section_wrapper_end() {
    ?>
                </div>
            </div>
        </div>

    <?php
}

add_action( 'woocommerce_before_main_content', 'dahz_framework_shop_remove_before_main_content_part', 10 );
/**
 * 
 */
function dahz_framework_shop_remove_before_main_content_part() {
    
    if( class_exists( 'WooCommerce' ) ) {
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
        remove_action('woocommerce_before_main_content', 'dahz_framework_get_single_product_navigation_control_render', 30, 0);
    }
        

}

add_action( 'init', 'redeclare_woo_breadcrumbs' );
/**
 * 
 */
function redeclare_woo_breadcrumbs() {
    add_action( 'dahz_woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    add_action( 'dahz_woocommerce_before_main_content', 'dahz_framework_get_single_product_navigation_control_render', 20, 0);
}


add_action( 'woocommerce_after_single_product', 'dahz_framework_single_product_video_popup' );
/** 
 * 
 */
function dahz_framework_single_product_video_popup() {
    $video = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'video_content_modal', '' );
    ?>
        <div id="de-modal-media-video" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
                <button class="uk-modal-close-outside" type="button" uk-close></button>
                <?php if ( wp_oembed_get( $video ) ) : ?>
                    <?php echo wp_oembed_get( $video ); ?>
                <?php else : ?>
                    <?php printf( $video ); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php
}


if ( ! function_exists( 'dahz_framework_woo_change_loop_cart_button' ) ) {
    
    //add_filter( 'woocommerce_loop_add_to_cart_args', 'dahz_framework_woo_change_loop_cart_button', 10, 2 );

    function dahz_framework_woo_change_loop_cart_button( $wp_parse_args, $product ) {
        
        if( class_exists('WooCommerce') && ! is_product() ){
			return $wp_parse_args;
		}
        switch ($product->get_type()) {
            case 'variable':
                $dataUkIcon = 'settings';
                break;
                
            case 'external':
                $dataUkIcon = 'push';
                break;
                
            case 'grouped':
                $dataUkIcon = 'thumbnails';
                break;

            default:
                $dataUkIcon = 'df_cart-bag';
                break;
        }
        
        $wp_parse_args = array(
            'quantity'   => 1,
            'class'      => implode( ' ', array_filter( array(
                'button de-product__item--add-to-cart-button',
                'product_type_' . $product->get_type(),
                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
            ) ) ),
            'attributes' => array(
                'data-product_id'  => $product->get_id(),
                'data-product_sku' => $product->get_sku(),
                'aria-label'       => $product->add_to_cart_description(),
                'rel'              => 'nofollow',
                'data-uk-icon'     => $dataUkIcon
            ),
        );
		
        return $wp_parse_args;
    
    }

}

if ( !function_exists('dahz_framework_single_product_override_wc_print_notice') ) {
    
    add_action( 'init', 'dahz_framework_single_product_override_wc_print_notice' );

    function dahz_framework_single_product_override_wc_print_notice() {

        remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );

        add_action( 'dahz_woo_inside_single_product', 'wc_print_notices', 10 );

    }

}

add_filter( 'wc_add_to_cart_message_html', 'dahz_framework_add_to_cart_message', 10, 2 );

function dahz_framework_add_to_cart_message( $message, $products ) {
    
	$titles = array();
	$count  = 0;
	$show_qty = true;
	if ( ! is_array( $products ) ) {
		$products = array( $products => 1 );
		$show_qty = false;
	}

	if ( ! $show_qty ) {
		$products = array_fill_keys( array_keys( $products ), 1 );
	}

	foreach ( $products as $product_id => $qty ) {
		/* translators: %s: product name */
		$titles[] = ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ) . sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'kitring' ), strip_tags( get_the_title( $product_id ) ) );
		$count   += $qty;
	}

	$titles = array_filter( $titles );

    /* translators: %s: product name */
	$added_text = sprintf( _n( '%s has been added to your cart.', '%s have been added to your cart.', $count, 'kitring' ), wc_format_list_of_items( $titles ) );

    if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) :
        $message = sprintf( '%s<a href="%s" class="uk-button uk-button-text">%s</a>', __( 'Successfully added to cart.', 'kitring' ), esc_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) ), __( 'Continue Shopping', 'kitring' ) );
    else :
        $message = sprintf( '<a href="%s" class="wc-forward uk-button uk-button-text">%s</a> %s', esc_url( wc_get_page_permalink( 'cart' ) ), esc_html__( 'View cart', 'kitring' ), esc_html( $added_text ) );
    endif;
    return $message;
}

/**
 * get single product image
 *
 * @author Dahz - EK
 * @since 1.0.0
 * @param - $class
 * @return - product images
 */
if( !function_exists( 'dahz_framework_upscale_single_product_image' ) ){

	function dahz_framework_upscale_single_product_image( $layout, $post_thumbnail_id = false, $attachment_ids = false, $is_variation = false, $product_id = null, $is_cover = false ){

		global $post, $product;

		$id = !$is_variation ? get_the_ID() : $product_id;
		
		$enable_galleries = false;

		$uniqid = md5( uniqid(rand(), true) );

		$uniqid = "{$uniqid}-{$id}";

		$post_thumbnail_id = !$is_variation && has_post_thumbnail() ? get_post_thumbnail_id( $id ) : $post_thumbnail_id;

		$post_thumbnail_id = !empty( $post_thumbnail_id ) ? $post_thumbnail_id : false;

		$full_size_image = $post_thumbnail_id ? wp_get_attachment_image_url( $post_thumbnail_id, 'full' ) : '';

		$attachment_ids = !$attachment_ids ? $product->get_gallery_image_ids() : $attachment_ids;

		$galleries_html = '';

		$galleries_thumbnail_html = '';

		$image_primary_thumbnail_html = '';

		$image_primary_html = '';

		if ( $post_thumbnail_id ) {
			$image = apply_filters( 'dahz_framework_single_product_image_main_primary',
				wp_get_attachment_image(
					$post_thumbnail_id,
					'shop_single',
					false,
					!$is_cover ? array(
						'title'	 				=> get_post_field( 'post_title', $post_thumbnail_id ),
						'data-zoom-image'   	=> $full_size_image,
						'data-is-zoom-image'	=> true,
						'class'					=> 'primary-image'
					) : array(
						'title'	 				=> get_post_field( 'post_title', $post_thumbnail_id ),
						'data-zoom-image'   	=> $full_size_image,
						'data-is-zoom-image'	=> true,
						'class'					=> 'primary-image',
					)
				),
				$post_thumbnail_id,
				$product_id,
				$is_variation
			);
			$image_thumbnail = apply_filters( 'dahz_framework_single_product_image_main_thumbnail',
				wp_get_attachment_image(
					$post_thumbnail_id,
					'shop_thumbnail',
					false,
					!$is_cover ? array(
						'title'	=> get_post_field( 'post_title', $post_thumbnail_id )
					) : array(
						'title'			=> get_post_field( 'post_title', $post_thumbnail_id ),
					)
				),
				$post_thumbnail_id,
				$product_id,
				$is_variation
			);
			$image_primary_html = apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					dahz_framework_upscale_single_product_image_wrapper( $layout, true, false, "{$uniqid}-{$post_thumbnail_id}", $post_thumbnail_id ),
					esc_attr( get_post_field( 'post_excerpt', $post_thumbnail_id ) ),
					esc_url( $full_size_image ),
					$image
				),
				$post_thumbnail_id
			);
			$image_primary_thumbnail_html = apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					dahz_framework_upscale_single_product_image_wrapper( $layout, true, true, "{$uniqid}-{$post_thumbnail_id}", $post_thumbnail_id ),
					esc_attr( get_post_field( 'post_excerpt', $post_thumbnail_id ) ),
					$image_thumbnail
				),
				$post_thumbnail_id
			);
		} else {
			$image_primary_html = apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					dahz_framework_upscale_single_product_image_wrapper( $layout, false, false, "{$uniqid}-placeholder" ),
					__( 'Placeholder', 'kitring' ),
					esc_url( wc_placeholder_img_src() )
				),
				$post_thumbnail_id
			);
			$image_primary_thumbnail_html = apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					dahz_framework_upscale_single_product_image_wrapper( $layout, false, true, "{$uniqid}-placeholder" ),
					__( 'Placeholder', 'kitring' ),
					esc_url( wc_placeholder_img_src( 'shop_thumbnail' ) )
				),
				$post_thumbnail_id
			);
		}

		if ( $attachment_ids ) {
			
			$enable_galleries = true;
			
			foreach ( $attachment_ids as $index => $attachment_id ) {

				$full_size_image_gallery = wp_get_attachment_image_url( $attachment_id, 'full' );

				$image_gallery = wp_get_attachment_image(
					$attachment_id,
					'shop_single',
					false,
					!$is_cover ? array(
						'title'	 				=> get_post_field( 'post_title', $attachment_id ),
						'data-zoom-image'   	=> $full_size_image_gallery,
						'data-is-zoom-image'	=> true,
						'class'					=> 'primary-image'
					) : array(
						'title'	 				=> get_post_field( 'post_title', $attachment_id ),
						'data-zoom-image'   	=> $full_size_image_gallery,
						'data-is-zoom-image'	=> true,
						'class'					=> 'primary-image',
					)
				);

				$image_gallery_thumbnail = wp_get_attachment_image(
					$attachment_id,
					'shop_thumbnail',
					false,
					!$is_cover ? array(
						'title'	 => get_post_field( 'post_title', $attachment_id ),
					) : array(
						'title'	 		=> get_post_field( 'post_title', $attachment_id ),
					)
				);
				if( $image_gallery ){
					$galleries_html .= apply_filters(
						'woocommerce_single_product_image_thumbnail_html',
						sprintf(
							dahz_framework_upscale_single_product_image_wrapper( $layout, true, false, "{$uniqid}-{$attachment_id}", $attachment_id ),
							esc_attr( get_post_field( 'post_excerpt', $attachment_id ) ),
							esc_url( $full_size_image_gallery ),
							$image_gallery
						),
						$attachment_id
					);
				}
				if( $image_gallery_thumbnail ){
					$galleries_thumbnail_html .= apply_filters(
						'woocommerce_single_product_image_thumbnail_html',
						sprintf(
							dahz_framework_upscale_single_product_image_wrapper( $layout, true, true, "{$uniqid}-{$attachment_id}", $attachment_id, ( $index + 1 ) ),
							esc_attr( get_post_field( 'post_excerpt', $attachment_id ) ),
							$image_gallery_thumbnail
						),
						$attachment_id
					);
				}

			}
		}
		return array(
			'primary'			=> sprintf(
				'%1$s%2$s',
				$image_primary_html,
				$galleries_html
			),
			'thumbnail'			=> sprintf(
				'%1$s%2$s',
				$image_primary_thumbnail_html,
				$galleries_thumbnail_html
			),
			'enable_galleries'	=> $enable_galleries
		);

	}

}

/**
 * get single product image wrapper
 *
 * @author Dahz - EK
 * @since 1.0.0
 * @param - $class
 * @return - product images wrapper
 */
if( !function_exists( 'dahz_framework_upscale_single_product_image_wrapper' ) ){

	function dahz_framework_upscale_single_product_image_wrapper( $layout, $is_with_image = true, $is_thumbnail = false, $uniqid = '', $attachment_id = false, $index = 0 ){

		$directory = $is_thumbnail ? 'gallery' : 'primary';

		return dahz_framework_get_template_html(
			"{$layout}.php",
			array(
				'is_with_image'	=> $is_with_image,
				'attachment_id'	=> $attachment_id,
				'index'			=> $index,
				'uniqid'		=> $uniqid
			),
			"dahz-modules/woo/templates/product-image-wrapper/{$directory}/"
		);;

	}

}

/**
 * get shop sidebar
 *
 * @author Dahz - EK
 * @since 1.0.0
 * @param - $class
 * @return - shop sidebar
 */
if( !function_exists( 'dahz_framework_upscale_get_shop_sidebar' ) ){

	function dahz_framework_upscale_get_shop_sidebar(){
		$sidebar_content = '';

		if ( is_active_sidebar( 'shop-sidebar-1' ) ) {
			ob_start();
				dynamic_sidebar( 'shop-sidebar-1' );
				$sidebar_content =  ob_get_contents() ;
			ob_end_clean();
		}

		return $sidebar_content;

	}

}

/**
 * render new badge in product archive
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param - $class
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_badge_new' ) ) {

	function dahz_framework_render_badge_new( $class = 'entry-badge' ) {

		global $product;

		$product_id = '';

		if ( is_object( $product ) ) {

			if ( method_exists( $product, 'get_id' ) ) {

				$product_id = $product->get_id();

			} else {

				$product_id = $product->id;

			}

		}

		$product_new = dahz_framework_get_meta( $product_id, 'dahz_meta_product', 'is_custom_badge', 'off' );

		$badge_type = dahz_framework_get_option( 'shop_woo_custom_badge_new', 'default' );

		if ( $product_new !== 'on' || $badge_type === 'disable' ) return;

		if ( 'default' == $badge_type ) {

			$product_filter = __( 'New', 'kitring' );

		} else {

			$product_meta_text = dahz_framework_get_meta( $product_id, 'dahz_meta_product', 'user_custom_badge', '' );

			if ( !empty( $product_meta_text ) ){

				$product_filter = $product_meta_text;

			} else {

				$product_filter = dahz_framework_get_option( 'shop_woo_custom_badge_text', '' );

			}

		}

		printf( '<p class="%s new">%s</p>', esc_attr( $class ), esc_html( $product_filter ) );

	}

}

/**
 * render sale badge in product archive
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param - $class
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_badge_sale' ) ) {

	function dahz_framework_render_badge_sale( $class = 'entry-badge' ) {

		global $post, $product;

		$product_type = '';

		if ( is_object( $product ) ) {

			if ( method_exists( $product, 'get_type' ) ) {

				$product_type = $product->get_type();

			} else {

				$product_type = $product->product_type;

			}

		}

		$badge_type = dahz_framework_get_option( 'shop_woo_sale_flash', 'text' );

		if ( 'disable' == $badge_type ) return false;

		if ( $product->is_on_sale() ) {

			if ( 'text' == $badge_type ) {

				echo apply_filters( 'woocommerce_sale_flash', sprintf( '<p class="%s sale">%s</p>', esc_attr( $class ), esc_html__( 'Sale', 'kitring' ) ), $post, $product );

			} else {

				if ( $product_type == 'variable' ) {

					$variation_prices = $product->get_variation_prices();

					$highest_sale     = 0;

					foreach( $variation_prices['regular_price'] as $key => $regular_price ) {

						$sale_price = $variation_prices['sale_price'][$key];

						if ( $sale_price < $regular_price ) {
							if ( 0 != $regular_price ) {
								$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100, 0 );
							}
							if ( $percentage > $highest_sale ) {
								$highest_sale = $percentage;
							}
						}

					}

				} else if ( $product_type == 'simple' ) {

					$regular_price = 0;

					$sale_price    = 0;

					if ( is_object( $product ) ) {
						if ( method_exists( $product,'get_regular_price' ) ) {
							$regular_price = $product->get_regular_price();
						} else {
							$regular_price = $product->regular_price;
						}

						if ( method_exists( $product,'get_sale_price' ) ) {
							$sale_price = $product->get_sale_price();
						} else {
							$sale_price = $product->sale_price;
						}
					}

					if ( 0 != $regular_price ) {
						$highest_sale = round( ( ($regular_price - $sale_price) / $regular_price ) * 100, 0 );
					}

				} else {
					return false;
				}

				echo apply_filters( 'woocommerce_sale_flash', sprintf( '<p class="%s sale">- %s &#37;</p>', esc_attr( $class ), esc_html( $highest_sale ) ), $post, $product );

			}

		}

	}
}

/**
 * render out of stock badge in product archive
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param - $class
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_badge_outofstock' ) ) {

	function dahz_framework_render_badge_outofstock( $class = 'entry-badge' ) {

		global $product;

		if ( !$product->is_in_stock() ) {

			echo sprintf( '<p class="%s out-of-stock">%s</p>', esc_attr( $class ), esc_html__( 'Out of Stock', 'kitring' ) );

		}

	}
}

/**
 * render product category/brand in product archive
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_product_category_brand' ) ) {

	function dahz_framework_render_product_category_brand() {

		global $product;

		$product_id = '';

		if ( is_object( $product ) ) {

			if ( method_exists( $product, 'get_id' ) ) {

				$product_id = $product->get_id();

			} else {

				$product_id = $product->id;

			}

		}

		$category_brand_html = '';

		$display_type = dahz_framework_get_option( 'shop_woo_display_brand_category', true );

		if ( $display_type ) {

			$terms = get_the_terms( $product_id, 'product_cat' );

			if ( !empty( $terms ) && !is_wp_error( $terms ) ) {

				$counter = count( $terms ) - 1;

				$category_brand_html = sprintf(
					"
					<a class='uk-link de-product-detail__category' href='%s'>%s</a>
					",
					esc_url( get_term_link( $terms[$counter] ) ),
					esc_html( $terms[$counter]->name )
				);

			}

		}

		echo apply_filters( 'dahz_framework_upscale_product_brand_category', $category_brand_html );

	}

}

/**
 * render secondary product thumbnail in product archive
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_product_thumbnail_secondary' ) ) {

	function dahz_framework_render_product_thumbnail_secondary( $size = 'shop_catalog' ) {

		global $product;

		$layout_archive = dahz_framework_get_option( 'shop_woo_layout', 'elaina' );

		$image = '';

		if( 'esmeralda' == $layout_archive ){

			$landscape_img_id  = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'single_image_landscape', '' );

			if( !empty( $landscape_img_id ) ){

				$landscape_img_ids = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'single_gallery_landscape', '' );

				$landscape_img_ids = !empty( $landscape_img_ids ) ? explode( ',', $landscape_img_ids ) : array();

				$first_landscape_img_id = isset( $landscape_img_ids[0] ) ? $landscape_img_ids[0] : '';

				$image = !empty( $first_landscape_img_id ) ? wp_get_attachment_image( $first_landscape_img_id, $size, false, array( 'class' => sprintf( 'attachment-%1$s size-%1$s wp-post-image', $size ) ) ) : '';

			} else {

				if( has_post_thumbnail() ){

					$galleries_img_ids = $product->get_gallery_image_ids();

					$first_galleries_img_id = isset( $galleries_img_ids[0] ) ? $galleries_img_ids[0] : false;

					$image = wp_get_attachment_image( $first_galleries_img_id, $size, false, array( 'class' => sprintf( 'attachment-%1$s size-%1$s wp-post-image', $size ) ) );

				}

			}

		} else {

			if( has_post_thumbnail() ){

				$galleries_img_ids = $product->get_gallery_image_ids();

				$first_galleries_img_id = isset( $galleries_img_ids[0] ) ? $galleries_img_ids[0] : false;

				$image = wp_get_attachment_image( $first_galleries_img_id, $size, false, array( 'class' => sprintf( 'attachment-%1$s size-%1$s wp-post-image', $size ) ) );

			}

		}

		echo apply_filters( 'dahz_framework_product_thumbnail_secondary', $image );

	}

}

/**
 * render landscape product thumbnail in product archive
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_product_thumbnail_landscape' ) ) {

	function dahz_framework_render_product_thumbnail_landscape( $size = 'shop_layout' ) {

		$landscape_img_id = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_product', 'single_image_landscape', '' );

		echo wp_get_attachment_image( $landscape_img_id, $size, false, array( 'class', sprintf( 'attachment-%1$s size-%1$s wp-post-image', $size ) ) );

	}
}

/**
 * render view all button in product archive
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_product_view_all' ) ) {

	function dahz_framework_render_product_view_all() {

		printf( '<p><a class="uk-link" href="%s">%s</a></p>', esc_url( add_query_arg( 'view', 'all' ) ), esc_html( 'View All', 'kitring' ) );

	}
}

/**
 * render filter button in product archive
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_product_filter_button' ) ) {

	function dahz_framework_render_product_filter_button() {

		printf( '<p class="de-shop__filter-button ds-filter-button--open"><a href="#" data-uk-toggle="target: .sidebar--header;cls: sidebar--visible">%s</a></p>', esc_html( 'Filter', 'kitring' ) );

	}

}

/**
 * render wishlist button in product archive
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_render_product_wishlist' ) ) {

	function dahz_framework_render_product_wishlist() {

		dahz_framework_get_template( 'wishlist.php', '', 'dahz-modules/woo/templates/' );

	}

}

/**
 * render Prev Next button on single product
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param -
 * @return -
 */
if( !function_exists( 'dahz_framework_upscale_woo_single_prev_next' ) ){

	function dahz_framework_upscale_woo_single_prev_next(){

		if( !dahz_framework_get_option( 'single_woo_is_prev_next_product', false ) ) return;

		$prev_post_link = get_previous_post_link( '%link', '<i class="oi-arrow-left"></i>' );

		$next_post_link = get_next_post_link( '%link', '<i class="oi-arrow-right"></i>' );

		if( !empty( $prev_post_link ) ){

			$prev_post = get_previous_post();

			$prev_post_link = sprintf(
				'
				<div class="de-product-single__nav--left">
					%1$s
					<div data-uk-drop="pos: bottom-justify;boundary:.de-product-single__nav;boundary-align:true;offset:-20;">
						%2$s
					</div>
				</div>
				',
				$prev_post_link,
				get_the_post_thumbnail( $prev_post->ID, 'shop_thumbnail' )
			);

		}

		if( !empty( $next_post_link ) ){

			$next_post = get_next_post();

			$next_post_link = sprintf(
				'
				<div class="de-product-single__nav--left">
					%1$s
					<div data-uk-drop="pos: bottom-justify;boundary-align:true;boundary:.de-product-single__nav;offset:-20;">
						%2$s
					</div>
				</div>
				',
				$next_post_link,
				get_the_post_thumbnail( $next_post->ID, 'shop_thumbnail' )
			);

		}

		echo sprintf(
			'
			<div class="de-product-single__nav">
				%1$s
				%2$s
			</div>
			',
			$prev_post_link,
			$next_post_link
		);

	}

}

/**
 * render brand logo
 *
 * @author Dahz - KW
 * @since 1.0.0
 * @param -
 * @return -
 */
if( !function_exists( 'dahz_framework_upscale_brand_logo' ) ){

	function dahz_framework_upscale_brand_logo( $product_id = null ){

		if ( !class_exists('Dahz_Framework_Woo_Extender_Brand') ) return;

		global $product;

		$product_id = "";

		if( is_object( $product ) ){

			if( method_exists( $product,'get_id' ) ){

				$product_id = $product->get_id();

			} else {

				$product_id = $product->id;

			}

		}

		$show_brand = dahz_framework_get_option( 'single_woo_show_brand', 'logo-brand' );

		if( $show_brand === 'no-brand' ) return;

		$brands = get_the_terms( $product_id, 'brand' );

		if( empty( $brands ) || !is_array( $brands ) || is_wp_error( $brands ) ) return;

		$brand_html = '';

		switch( $show_brand ){

			case 'text-brand':

				foreach( $brands as $brand ){
					$brand_html .= sprintf(
						'
						<a href="%1$s">%2$s</a>
						',
						esc_url( get_term_link( $brand->term_id ) ),
						esc_html( $brand->name )
					);
				}

				break;
			case 'logo-brand':

				foreach( $brands as $brand ){

					$brand_logo_id = dahz_framework_get_term_meta( $brand->taxonomy, $brand->term_id, 'logo_upload', '' );

					$brand_logo = wp_get_attachment_image( $brand_logo_id, 'medium' );

					if( !empty( $brand_logo ) ){

						$brand_html .= sprintf(
							'
							<a href="%1$s" class="de-brand-product--logo" style="width:100px;">%2$s</a>
							',
							esc_url( get_term_link( $brand->term_id ) ),
							$brand_logo
						);

					} else {

						$brand_html .= sprintf(
							'
							<a href="%1$s">%2$s</a>
							',
							esc_url( get_term_link( $brand->term_id ) ),
							esc_html( $brand->name )
						);

					}


				}

				break;
			default:

				foreach( $brands as $brand ){
					$brand_html .= sprintf(
						'
						<a href="%1$s">%2$s</a>
						',
						esc_url( get_term_link( $brand->term_id ) ),
						esc_html( $brand->name )
					);
				}

				break;

		}

		echo sprintf(
			'
			<div class="uk-flex uk-flex-left">
				%1$s
			</div>
			',
			$brand_html
		);

	}

}

/**
 * render Upsell product
 *
 * @author Dahz - EK
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_uppsell_display' ) ) {

	function dahz_framework_uppsell_display() {

		global $product, $woocommerce_loop;

		if ( ! $product ) {
			return;
		}

		dahz_framework_get_template(
			'upsells-wrapper.php',
			array(
				'upsell_ids' => $product->get_upsell_ids(),

			),
			'dahz-modules/woo/templates/'
		);

	}

}

/**
 * render Related product
 *
 * @author Dahz - EK
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_framework_output_related_products' ) ) {

	function dahz_framework_output_related_products() {

		global $product, $woocommerce_loop;

		if ( ! $product || !dahz_framework_get_option( 'single_woo_is_show_related_product', true ) ) {
			return;
		}

		$upsell_ids = $product->get_upsell_ids();

		$product_id = $product->get_id();

		$args = array(
			'posts_per_page' 	=> 4,
			'columns' 			=> 4,
			'orderby' 			=> 'rand',
			'order'          	=> 'desc',
		);

		$args = apply_filters( 'woocommerce_output_related_products_args', $args );

		// Get visible related products then sort them at random.
		$related_products = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product_id, $args['posts_per_page'], $upsell_ids ) ), 'wc_products_array_filter_visible' );

		// Handle orderby.
		$related_products = wc_products_array_orderby( $related_products, $args['orderby'], $args['order'] );

		// Set global loop values.
		$woocommerce_loop['name']    = 'related';
		$woocommerce_loop['columns'] = apply_filters( 'woocommerce_related_products_columns', $args['columns'] );

		dahz_framework_get_template(
			'related.php',
			array(
				'related_products' 			=> $related_products,
				'title'						=> dahz_framework_get_option( 'single_woo_related_title', '' ),
				'desktop_column'			=> dahz_framework_get_option( 'single_woo_related_desktop_column', '1-4' ),
				'tablet_column'				=> dahz_framework_get_option( 'single_woo_related_tablet_column', '1-4' ),
				'mobile_landscape_column'	=> dahz_framework_get_option( 'single_woo_related_phone_landscape_column', '3-5' ),
				'mobile_column'				=> dahz_framework_get_option( 'single_woo_related_phone_potrait_column', '3-5' ),
			),
			'dahz-modules/woo/templates/'
		);

	}

}