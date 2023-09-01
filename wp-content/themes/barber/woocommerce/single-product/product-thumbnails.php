<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_image_ids();
$single_style =  get_post_meta(get_the_id(), 'single_style', true);
if($single_style == 'default' && isset($apr_settings['single-product-style']) ){
	$single_style =$apr_settings['single-product-style'];
}
if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?>
	
		
	<div class="views-block">
		<ul id="thumbs_list_frame" class="thumbs_list">
		<?php
		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array(  );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
			$image_title 	= esc_attr( get_the_title( $attachment_id ) );
						
			$image_title = esc_attr( get_the_title( $attachment_id ) );
			
			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
			'title'	=> $image_title,
			'alt'	=> $image_title
			) );
			$image_class = esc_attr( implode( ' ', $classes ) );
						$image_link_thumb = wp_get_attachment_image_src( $attachment_id , 'shop_single');

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li class="thumbnail_%d"><a href="#" class="%s view-img" data-image="'.$image_link.'" data-image-zoom="'.$image_link.'">%s</a>', $attachment_id, $image_class, $image ), $attachment_id, $post->ID, $image_class );

			$loop++;
		}

		?>
		</ul>
	</div>	
	<?php
}
