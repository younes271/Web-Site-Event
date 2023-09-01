<div class="ds-product-single__navigation-control">
	<?php if ( dahz_framework_get_option( 'single_woo_is_prev_next_product', true ) ) : ?>
		<div class="ds-product-single__navigation-control__post">
			<?php
				$prev_post = get_adjacent_post( false, '', true );
				$next_post = get_adjacent_post( false, '', false );
			?>
			<?php if ( $prev_post ) : ?>
			<a aria-label="<?php echo esc_attr_e( 'Previous Product', 'kitring' ); ?>" href="<?php echo esc_attr( get_permalink( $prev_post->ID ) ); ?>" class="uk-icon-link left" data-uk-icon="icon: chevron-left;ratio: 1">
				<?php if ( has_post_thumbnail( $prev_post->ID ) ) : $prev_img_src = wp_get_attachment_image_url( get_post_thumbnail_id( $prev_post->ID ), 'thumbnail' ); ?>
				<img class="uk-box-shadow-large" src="<?php echo esc_url( $prev_img_src ); ?>" alt="<?php echo esc_attr( get_the_title( $prev_post->ID ) ); ?>">
				<?php endif; ?>
			</a>
			<?php endif; ?>
			<?php if ( $next_post ) : ?>
			<a aria-label="<?php echo esc_attr_e( 'Next Product', 'kitring' ); ?>" href="<?php echo esc_attr( get_permalink( $next_post->ID ) ); ?>" class="uk-icon-link right" data-uk-icon="icon: chevron-right;ratio: 1">
				<?php if ( has_post_thumbnail( $next_post->ID ) ) : $next_img_src = wp_get_attachment_image_url( get_post_thumbnail_id( $next_post->ID ), 'thumbnail' ); ?>
				<img class="uk-box-shadow-large" src="<?php echo esc_url( $next_img_src ); ?>" alt="<?php echo esc_attr( get_the_title( $next_post->ID ) ); ?>">
				<?php endif;?>
			</a>
			<?php endif;?>
		</div>
	<?php endif; ?>
</div>