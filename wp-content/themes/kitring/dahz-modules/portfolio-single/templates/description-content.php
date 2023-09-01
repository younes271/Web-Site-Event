<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

?>
<div <?php dahz_framework_set_attributes( 
	array( 
		'class'	=> array( 'uk-width-expand@m' ),
	),
	'portfolio_single_description_content'
);?>>
	<?php if( ! empty( $title ) ):?>
		<h3 class="uk-h3">
			<?php echo esc_html( $title );?>
		</h3>
	<?php endif;?>
	<?php if( ! empty( $description ) ):?>
		<p>
			<?php echo esc_html( $description );?>
		</p>
	<?php endif;?>
</div>