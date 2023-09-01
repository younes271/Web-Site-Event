<li class="de-related-post__item de-related-post__item--<?php echo esc_attr( get_the_ID() ); ?> uk-width-1-3@m" data-id="<?php echo esc_attr( get_the_ID() ); ?>">
	<div class="de-related-post__media de-ratio de-ratio-4-3 uk-margin-bottom">
		<div class="de-ratio-content uk-cover-container" data-target-related-featured-image="related-image-<?php echo esc_attr( $id ); ?>">
			<a href="<?php echo esc_url( $link ) ?>" class="de-ratio-content--inner" aria-label=" <?php echo esc_attr( 'View Post', 'kitring' ) ?> " data-letter="<?php echo esc_attr( substr( get_the_title(), 0, 1 ) ); ?>">
				<?php echo apply_filters( 'dahz_framework_related_post_media', $media ); ?>
			</a>
		</div>
	</div>
	<div class="de-related-post__content">
		<?php dahz_framework_title( array( 'title_tag' => 'h4' ) );?>
		<div class="entry-meta uk-margin-remove">
			<?php echo get_the_date(); ?>
		</div>
	</div>
</li>
