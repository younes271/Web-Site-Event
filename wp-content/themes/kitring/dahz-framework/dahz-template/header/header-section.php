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
		'id'	=> "header-section{$id_section}",
		'class'	=> 'de-header__section uk-flex uk-flex-middle ' . apply_filters( 'dahz_framework_header_section_class', '', 'header', $id_section ),
	),
	"header_section_{$id_section}_attributes"
); ?>>
	<div class="uk-width-1-1">
		<div <?php dahz_framework_set_attributes(
			array(
				'class'	=> array( 'uk-container' ),
			),
			"header_section_{$id_section}_container"
		);?>>
			<?php echo apply_filters( 'dahz_framework_builder_header_section', $row_html ); ?>
		</div>
	</div>
</div>