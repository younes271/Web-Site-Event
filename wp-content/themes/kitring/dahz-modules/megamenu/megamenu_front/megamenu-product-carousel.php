<?php
/*
 * Mega Menu Product Carousel
 */

if ( $query->have_posts() ) : ?>
<div class="uk-position-relative uk-visible-toggle uk-light uk-margin" data-uk-slider>
	<ul class="uk-slider-items uk-child-width-1-<?php echo esc_attr( $column ); ?> uk-grid" data-uk-grid>
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<?php
				$current_product = wc_get_product( get_the_ID() );

				$regular_price = $current_product->get_price_html();
			?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'shop_catalog' ); endif; ?>
				</a>
				<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
				<?php echo sprintf( '<p class="smaller">%1$s</p>', $regular_price );?>
			</li>
		<?php endwhile; ?>
	</ul>
	<a class="uk-position-center-left uk-position-small uk-hidden@m" href="#" data-uk-slidenav-previous data-uk-slider-item="previous" aria-label="<?php esc_attr_e( 'Previous', 'kitring' ); ?>"></a>
	<a class="uk-position-center-right uk-position-small uk-hidden@m" href="#" data-uk-slidenav-next data-uk-slider-item="next" aria-label="<?php esc_attr_e( 'Next', 'kitring' ); ?>"></a>
	<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slider-item="previous" aria-label="<?php esc_attr_e( 'Previous', 'kitring' ); ?>"></a>
	<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slider-item="next" aria-label="<?php esc_attr_e( 'Next', 'kitring' ); ?>"></a>
</div>
<?php endif; ?>