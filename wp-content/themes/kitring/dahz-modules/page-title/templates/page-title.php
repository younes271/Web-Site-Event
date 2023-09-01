<?php

$offset_adminbar = is_admin_bar_showing() ? '92' : '60';

$remove_margin = dahz_framework_get_option( 'blog_template_remove_margin', false );

$remove_margin = $remove_margin ? ' uk-margin-remove ' : '';

$removePadding = $layout == 'tasia' ? ' uk-padding-remove-bottom' : '';

$page_title_container_atts = array(
	'class'					=> array( 'de-page-title uk-section' . $remove_margin . $removePadding ),
	'data-layout'			=> $layout,
	'data-render-location'	=> !empty( $render_location ) ? $render_location : 'home'
);
if( $layout != 'tasia' ) $page_title_container_atts['style'] = $background;

if( $layout == 'titania' ) $page_title_container_atts['data-uk-height-viewport'] = 'offset-top:true;';

?>
<div <?php dahz_framework_set_attributes(
	$page_title_container_atts,
	'page_title_container'
);?>>
	<?php do_action( 'dahz_framework_before_page_title', $layout ); ?>
	<div class="de-page-title__container uk-container">
		<?php if( !empty( $title ) ): ?>
			<h1 class="uk-heading-primary"><?php echo apply_filters( 'dahz_framework_page_title_title_html', $title ); ?></h1>
		<?php endif; ?>
		<?php if( !empty( $description ) && $layout != 'titania' ): ?>
			<?php echo apply_filters( 'dahz_framework_page_title_description_html', $description ); ?>
		<?php endif; ?>
		<?php if ( !empty( $breadcrumb ) ) : ?>
			<?php echo apply_filters( 'dahz_framework_page_title_breadcrumb_html', $breadcrumb ); ?>
		<?php endif; ?>
	</div>
	<?php if( !empty( $description ) && $layout == 'titania' ): ?>
		<a href="#page-subtitle" class="de-page-title__nav uk-icon-link" data-uk-icon="icon:arrow-down;ratio:2;" data-uk-scroll="<?php echo esc_attr( sprintf( 'offset: %s', $offset_adminbar ) ); ?>" aria-label="<?php esc_attr_e( 'Scroll down', 'kitring' ); ?>"></a>
	<?php endif; ?>
	<?php do_action( 'dahz_framework_after_page_title', $layout ); ?>
</div>

<?php if( !empty( $description ) && $layout == 'titania' ): ?>
	<div id="page-subtitle">
		<div class="de-page-subtitle uk-container">
			<div class="de-page-subtitle__container uk-margin-medium-top uk-child-width-1-2@m uk-grid" data-uk-grid>
				<div>
					<h2><?php echo apply_filters( 'dahz_framework_page_title_title_html', $title ); ?></h2>
				</div>
				<div>
					<?php echo apply_filters( 'dahz_framework_page_title_description_html', $description ); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>