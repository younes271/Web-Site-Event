<?php

/**
 * set layout option from theme option: full, framed, boxed
 * set bg fixed, scroll
 */

$layout = dahz_framework_get_option( 'blog_single_layout', 'stevie' );

$galleries = json_decode( urldecode( $galleries ), true );

$viewport_width_classess = '';

$viewport_width_classess .= "{$column_gap} uk-child-width-{$phone_potrait_column} uk-child-width-{$phone_landscape_column}@s uk-child-width-{$tablet_landscape_column}@m uk-child-width-{$desktop_column}@l";

$grid_attributes = array(
	'class'			=> array(
		$viewport_width_classess
	),
	'data-uk-grid'	=> 'masonry:true;',
);

if ( $enable_lightbox === "on" ) {
	$grid_attributes['data-uk-lightbox'] = '';
}
?>
<div class="uk-position-relative uk-margin-medium-bottom">
	<div class="de-post-gallery">
		<ul <?php dahz_framework_set_attributes( $grid_attributes );?>>
			<?php
				
			$is_featured_disabled = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'disable_featured_image', 'off' );

			if ( has_post_thumbnail() && $is_featured_disabled !== 'on' ) :
				$image          = wp_get_attachment_image( get_post_thumbnail_id(), 'large', false, array( 'class' => 'uk-height-1-1' ) );
				$image_url      = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
				$image_object   = get_post( get_post_thumbnail_id() );
				$image_caption  = $image_object->post_excerpt;
				$lightbox_url   = '#';

				if ( $enable_lightbox === "on" ) {
					$lightbox_url = $image_url;
				}
				?>
				<li>
					<a class="uk-flex uk-flex-center" href="<?php echo esc_url( $lightbox_url ) ?>" caption="<?php echo esc_attr( $image_caption ); ?>">
						<?php echo apply_filters( 'dahz_framework_gallery_carousel_image', $image ); ?>
					</a>
				</li>
				
			<?php endif;
			
			foreach ( $galleries as $gallery ) : ?>
			<?php
				$image          = wp_get_attachment_image( $gallery['values']['image'], 'large', false, array( 'class' => 'uk-height-1-1' ) );
				$image_url      = wp_get_attachment_image_url( $gallery['values']['image'], 'full' );
				$image_object   = get_post($gallery['values']['image']);
				$image_caption  = $image_object->post_excerpt;
				$lightbox_url   = '#';

				if ( $enable_lightbox === "on" ) {
					$lightbox_url = $image_url;
				}
			?>
				<?php if ( !empty( $image ) ) : ?>
					<li>
						<a class="uk-flex uk-flex-center" href="<?php echo esc_url( $lightbox_url ) ?>" caption="<?php echo esc_attr( $image_caption ); ?>">
							<?php echo apply_filters( 'dahz_framework_gallery_carousel_image', $image ); ?>
						</a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>