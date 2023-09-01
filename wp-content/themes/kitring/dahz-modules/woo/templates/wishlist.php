<?php

/**
 * Template for product wishlist button
 *
 * @since 1.0.0
 * @author Dahz
 *
 */

if ( class_exists( 'YITH_WCWL' ) ) :

	echo do_shortcode( '[yith_wcwl_add_to_wishlist already_in_wishslist_text="" product_added_text=""]' );

endif;