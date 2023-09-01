<?php
/*
 * Mega Menu Product Carousel
 */

if ( !empty( $query ) ) : ?>
<div class="uk-position-relative uk-visible-toggle uk-light uk-margin" data-uk-slider>
	<ul class="uk-slider-items uk-child-width-1-<?php echo esc_attr( $column ); ?> uk-grid" data-uk-grid>
		<?php
			foreach( $query as $term ) {

				$img_id = dahz_framework_get_term_meta( $term->taxonomy, $term->term_id, 'brand_image_upload', '' );

				$brand_image = wp_get_attachment_image( $img_id, 'shop_catalog', array( 'class' => 'images-slick' ) );

				$the_link = get_term_link( $term );

				$the_title = $term->name;

				?>
				<li>
					<a href="<?php echo esc_url( $the_link ); ?>">
						<?php echo apply_filters( 'dahz_framework_megamenu_product_brand_image', $brand_image );?>
					</a>
					<h6><a href="<?php echo esc_url( $the_link ); ?>"><?php echo esc_html( $the_title ); ?></a></h6>
				</li>
				<?php
			}
		?>
	</ul>
	<a class="uk-position-center-left uk-position-small uk-hidden@m" href="#" data-uk-slidenav-previous data-uk-slider-item="previous" aria-label="<?php esc_attr_e( 'Previous', 'kitring' ); ?>"></a>
	<a class="uk-position-center-right uk-position-small uk-hidden@m" href="#" data-uk-slidenav-next data-uk-slider-item="next" aria-label="<?php esc_attr_e( 'Next', 'kitring' ); ?>"></a>
	<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slider-item="previous" aria-label="<?php esc_attr_e( 'Previous', 'kitring' ); ?>"></a>
	<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slider-item="next" aria-label="<?php esc_attr_e( 'Next', 'kitring' ); ?>"></a>
</div>
<?php endif; ?>