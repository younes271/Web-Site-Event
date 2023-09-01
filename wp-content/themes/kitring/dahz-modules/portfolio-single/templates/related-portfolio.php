<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */
global $post; 

$id = get_the_ID();

$related = get_posts(
	array(
		'category__in' 			=> wp_get_post_categories( $id ),
		'ignore_sticky_posts'	=> 1,
		'post__not_in' 			=> array( $id ),
		'post_type'				=> 'portfolio'
	)
);

if ( ! $related ){ return; }

$column_gap = dahz_framework_get_option( 'portfolio_single_column_gap' );

$related_title = dahz_framework_get_option( 'portfolio_single_title_related');

?>
<div class="uk-container uk-margin-medium">
	<hr class="uk-margin-medium">
	<h4><?php echo esc_html( $related_title );?></h4>
	<div class="uk-position-relative uk-visible-toggle" data-uk-slider>
		<ul <?php dahz_framework_set_attributes( 
			array( 
				'class'			=> array(
					'de-related__portfolio',
					'uk-slider-items',
					'uk-grid',
					$column_gap,
				),
			),
			'related_portfolio'
		);?>>
			<?php

			foreach( $related as $post ) {
				
				setup_postdata( $post );

				dahz_framework_get_template_part( 'content/archive/content', 'related-portfolio' );

			}
			wp_reset_postdata();
			?>
		</ul>
		<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
		<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
	</div>
 </div>

