<div>
	<div itemprop="image" class="woocommerce-main-image uk-position-relative" title="%1$s">
		<?php if ( dahz_framework_get_option( 'single_woo_is_image_modal_gallery', true ) ) : ?>
		<a aria-label="<?php esc_attr_e( 'Lightbox Gallery', 'kitring' );?>" class="de-gallery__link uk-box-shadow-medium uk-position-top-right" href="%2$s">
			<span data-uk-icon="icon:expand;"></span>
		</a>
		<?php endif; ?>
		<?php if ( $is_with_image ) : ?>
			%3$s
		<?php else : ?>
			<img src="%2$s" alt="%1$s" class="primary-image" />
		<?php endif; ?>
	</div>
</div>
