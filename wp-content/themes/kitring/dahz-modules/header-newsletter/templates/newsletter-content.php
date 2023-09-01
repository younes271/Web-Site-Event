<?php

/**
 * quickview-content-template
 * @params
 * $newsletter_images
 * $contact_form
 *
 * Template for product quickview: content
 *
 * @since 1.0.0
 * @author Dahz - KW
 *
 */

?>
<div class="uk-grid-match uk-height-large uk-grid" data-uk-grid>
	<div class="uk-width-2-3@m de-quickview-images">
		<div class="uk-position-relative uk-visible-toggle" data-uk-slideshow>
			<ul class="uk-slideshow-items" >
				<?php foreach( $newsletter_images as $images ):?>
				<li>
					<div itemprop="image" class="uk-position-relative uk-height-large">
						<?php
						echo wp_get_attachment_image(
							$images['image'],
							'large',
							false,
							array(
								'title'			=> get_post_field( 'post_title', $images['image'] ),
								'data-uk-cover'	=> ''
							)
						);
						?>
					</div>
				</li>
				<?php endforeach;?>
			</ul>
			<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous" aria-label="<?php esc_attr_e( 'Previous', 'kitring' ); ?>"></a>
			<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slideshow-item="next" aria-label="<?php esc_attr_e( 'Next', 'kitring' ); ?>"></a>
		</div>
	</div>
	<div class="uk-width-1-3@m de-quickview-content__summary uk-overflow-auto" data-uk-overflow-auto>
		<?php if( $enable_contact_form ):?>
			<?php echo do_shortcode( "[contact-form-7 id='{$contact_form}']" );?>
		<?php endif;?>
	</div>
</div>