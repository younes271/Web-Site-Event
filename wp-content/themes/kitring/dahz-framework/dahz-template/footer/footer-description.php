
<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package kitring
 */
?>
<div class="<?php echo esc_attr( $footer_description_alignment ); ?>">
	<?php if ( !empty( $footer_description_title ) ) : ?>
		<h6><?php echo esc_html( $footer_description_title ); ?></h6>
	<?php endif; ?>
	<p class="uk-margin-remove">
		<?php echo esc_html( $footer_description ); ?>
	</p>
</div>