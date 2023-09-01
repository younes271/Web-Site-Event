<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */
 
if( is_single() ) {
	$imageFlexCenter = 'uk-flex uk-flex-center uk-margin-medium-bottom uk-flex-middle';
} else {
	$imageFlexCenter = '';
}
$is_featured_disabled = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_post', 'disable_featured_image', 'off' );

if ( has_post_thumbnail() && $is_featured_disabled !== 'on' ) :

	?>
	<div class="entry-image de-single__entry-image <?php echo esc_attr($imageFlexCenter) ?>">
		<?php the_post_thumbnail( 'full' );?>
	</div>
	<?php

endif;
