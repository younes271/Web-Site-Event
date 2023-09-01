<?php

	/**
	 * 	set layout option from theme option: full, framed, boxed
	 *	set bg fixed, scroll
	 */
	$media_video = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'video_url' );
	if( empty( $media_video ) ):
		dahz_framework_get_template( "content/single-post/featured-post-format/standard.php" );
		return;
	endif;
?>
<?php if( !empty( 'media_video' ) ):?>
<div class="de-single__section-media uk-margin-medium-bottom">
	<div class="de-single__media de-single__media--video de-aspect-ratio de-aspect-ratio--16-by-9">
		<div class="de-aspect-ratio__content uk-text-center">
			<?php echo wp_oembed_get( $media_video );?>
		</div>
	</div>
</div>
<?php endif;?>
