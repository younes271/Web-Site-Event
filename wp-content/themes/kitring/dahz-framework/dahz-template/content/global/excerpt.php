<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kitring
 * @since 1.0
 * @version 1.0
 */
?>
<?php if( ! empty( $content ) ):?>
	<p class="uk-margin-remove">
		<?php echo apply_filters( 'dahz_framework_filter_get_the_excerpt', $content );?>
	</p>
<?php endif;?>
<?php
	wp_link_pages(
		array(
			'before'			=> '<ul class="de-pagination de-pagination__post uk-pagination uk-margin-remove-left" data-pagination-type="number">',
			'after' 			=> '</ul>',
			'link_before'       => '',
			'link_after'        => '',
			'nextpagelink'		=> __( 'Next', 'kitring' ) . '<span data-uk-pagination-next></span>',
			'previouspagelink'	=> '<span data-uk-pagination-previous></span>' . __( 'Prev', 'kitring' ),
			'pagelink'			=> '%',
			'echo'				=> 1,

		)
	);
?>
<?php if( $is_read_more ):?>
	<a <?php dahz_framework_set_attributes( 
		array( 
			'class' 		=> array( 'uk-margin-medium-top uk-button', $button_type, $button_size ),
			'href'			=> get_the_permalink(),
		),
		'button'
	);?>>
		<?php _e( 'Continue Reading', 'kitring' );?>
	</a>
<?php endif;?>