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
		'class'	=> array( 'uk-width-1-4@m' ),
	),
	'portfolio_single_description_details'
);?>>
	<ul class="uk-list" data-uk-margin="margin:uk-margin;">
	<?php foreach( $details as $detail ):?>
		<li>
			<?php if( empty( $detail['values']['item_title'] ) ){continue;}?>
			<h5 class="uk-margin-remove uk-h5">
				<?php echo esc_html( $detail['values']['item_title'] );?>
			</h5>
			<?php if( ! empty( $detail['values']['item_url'] ) ):?>
				<a class="uk-link uk-margin-remove" href="<?php echo esc_url( $detail['values']['item_url'] );?>">
			<?php endif;?>
			<?php if( ! empty( $detail['values']['item_text'] ) ):?>
				<p class="uk-margin-remove">
					<?php echo esc_html( $detail['values']['item_text'] );?>
				</p>
			<?php endif;?>
			<?php if( ! empty( $detail['values']['item_url'] ) ):?>
				</a>
			<?php endif;?>
		</li>
	<?php endforeach;?>
	</ul>
</div>