<?php

echo do_shortcode( the_content() );

wc_get_template_part( 'global/wrapper', 'start' );

wc_get_template_part( 'loop/loop', 'start' );

$args = array(
			'post_type' => 'product'
		);

$loop = new WP_Query( $args );

if ( $loop->have_posts() ) {

	while ( $loop->have_posts() ) : $loop->the_post();

		wc_get_template_part( 'content', 'product' );

	endwhile;

} else {

	echo esc_html__( 'No products found', 'kitring' );

}

wp_reset_postdata();

wc_get_template_part( 'loop/loop', 'end' );

wc_get_template_part( 'global/wrapper', 'end' );

get_sidebar();

do_action( 'woocommerce_after_main_content' );
