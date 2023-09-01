<?php
/**
 * The Header section template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */
?>
<div <?php dahz_framework_set_attributes(
	array(
		'id'    => "footer-section{$id_section}",
		'class' => 'de-footer__section',
	),
	"footer_section_{$id_section}_attributes"
); ?>>
	<?php if ( dahz_framework_get_option( "footer_section{$id_section}_enable_mobile_toggle", false ) ) : ?>
		<a class="uk-padding uk-padding-remove-vertical footer-section__toggle-content--btn uk-hidden@m" href="#" data-uk-toggle="cls:footer-section__toggle-content--show;target:#footer-section-toggle-content-<?php echo esc_attr( $id_section ); ?>; mode: click;">
			<?php echo dahz_framework_get_option( "footer_section{$id_section}_mobile_section_title", '' ); ?>
		</a>
		<div class="footer-section__toggle-content" id="footer-section-toggle-content-<?php echo esc_attr( $id_section ); ?>">
			<div <?php dahz_framework_set_attributes(
				array(
					'class' => array( 'uk-container' ),
				),
				"footer_section_container"
			); ?>>
				<?php echo apply_filters( 'dahz_framework_footer_section_html', $row_html ); ?>
			</div>
		</div>
	<?php else : ?>
		<div <?php dahz_framework_set_attributes(
			array(
				'class' => array( 'uk-container' ),
			),
			"footer_section_container"
		); ?>>
			<?php echo apply_filters( 'dahz_framework_footer_section_html', $row_html ); ?>
		</div>
	<?php endif; ?>
</div>