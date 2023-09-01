<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kitring
 */
if ( ! is_active_sidebar( dahz_framework_get_static_option( 'sidebar_id' ) ) || ! dahz_framework_get_static_option( 'enable_sidebar' ) ) {
	return;
}
?>

<?php if ( dahz_framework_get_static_option( 'enable_sticky_sidebar' ) ): ?>
	<?php wp_enqueue_script( 'dahz-framework-sidebar' ); ?>
<?php endif; ?>

<div <?php dahz_framework_set_attributes( 
	array( 
		'class'	=> array( 
			'uk-width-1-4@m', 
			'sidebar',
			dahz_framework_get_static_option( 'sidebar_class' )
		),
	),
	'main_sidebar'
);?>>
	<?php dynamic_sidebar( dahz_framework_get_static_option( 'sidebar_id' ) ); ?>
</div>