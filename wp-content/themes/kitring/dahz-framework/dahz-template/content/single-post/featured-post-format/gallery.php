<?php

	/**
	 * 	set layout option from theme option: full, framed, boxed
	 *	set bg fixed, scroll
	 */

	$galleries 					= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'image_upload' );
	$gallery_style 				= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'gallery_style' );
	$gallery_height 			= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'gallery_height' );
	$minimum_height 			= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'minimum_height' );
	$desktop_height 			= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'desktop_height' );
	$mobile_height 				= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'mobile_height' );
	$column_gap 				= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'column_gap' );
	$desktop_column 			= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'desktop_column' );
	$tablet_landscape_column 	= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'tablet_landscape_column' );
	$phone_landscape_column 	= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'phone_landscape_column' );
	$phone_potrait_column 		= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'phone_potrait_column' );
	$is_center_active_slide 	= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'is_center_active_slide' );
	$autoplay_gallery_area 		= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'autoplay_gallery_area' );
	$enable_lightbox 			= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'enable_lightbox' );
?>
<?php if( !empty( $galleries ) ):?>

	<div class="de-single__section-media gallery">
		<?php
		dahz_framework_get_template( 
			"content/single-post/featured-post-format/gallery-{$gallery_style}.php",
			array(
				'galleries'					=> $galleries,
				'gallery_style'				=> $gallery_style,
				'gallery_height'			=> $gallery_height,
				'minimum_height'			=> $minimum_height,
				'desktop_height'			=> $desktop_height,
				'mobile_height'				=> $mobile_height,
				'column_gap'				=> $column_gap,
				'desktop_column'			=> $desktop_column,
				'tablet_landscape_column'	=> $tablet_landscape_column,
				'phone_landscape_column'	=> $phone_landscape_column,
				'phone_potrait_column'		=> $phone_potrait_column,
				'enable_lightbox'			=> $enable_lightbox,
				'is_center_active_slide'	=> $is_center_active_slide,
				'autoplay_gallery_area'		=> $autoplay_gallery_area
			)
		);
		?>
	</div>

<?php endif;?>
