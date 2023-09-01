<?php

/**
 * set layout option from theme option: full, framed, boxed
 * set bg fixed, scroll
 */

$layout = dahz_framework_get_option( 'blog_single_layout', 'stevie' );

$galleries = json_decode( urldecode( $galleries ), true );

$viewport_width_classess = '';

$slider_attr = '';

if ( $is_center_active_slide === "on" ) {
	$slider_attr .= 'center:true;';
}

if ( $autoplay_gallery_area === "on" ) {
	$slider_attr .= 'autoplay:true;';
}

$viewport_width_classess .= "{$column_gap} uk-child-width-{$phone_potrait_column} uk-child-width-{$phone_landscape_column}@s uk-child-width-{$tablet_landscape_column}@m uk-child-width-{$desktop_column}@l";

$grid_attributes = array(
	'class'			=> array(
		'uk-slider-items',
		$viewport_width_classess
	),
	'data-uk-grid'	=> '',
);

# GALLERY HEIGHT SETTING
switch ( $gallery_height ) {
	case 'viewport-minus-section':
		$grid_attributes['data-uk-height-viewport'] = 'offset-top: true;offset-bottom: !.de-row +;min-height: ' . esc_attr( $minimum_height ) . ';';

		break;
	case 'viewport':
		$grid_attributes['data-uk-height-viewport'] = 'offset-top: true;min-height: ' . esc_attr( $minimum_height ) . ';';

		break;
	case 'viewport-minus-percent':
		$grid_attributes['data-uk-height-viewport'] = 'offset-top: true;offset-bottom: 20;min-height: ' . esc_attr( $minimum_height ) . ';';
		break;
}
if ( $enable_lightbox === "on" ) {
	$grid_attributes['data-uk-lightbox'] = '';
}
?>
<div class="uk-position-relative uk-transition-toggle uk-margin-medium-bottom">
	<div class="de-post-gallery" data-uk-slider="<?php echo esc_attr( $slider_attr ); ?>">
		<div class="uk-slider-container">
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
			<div class="uk-slidenav-container">
				<a class="uk-box-shadow-large uk-width-auto uk-padding uk-card uk-card-body uk-card-default uk-position-center-left uk-position-small uk-transition-fade" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
				<a class="uk-box-shadow-large uk-width-auto uk-padding uk-card uk-card-body uk-card-default uk-position-center-right uk-position-small uk-transition-fade" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
			</div>
		</div>
	</div>
</div>