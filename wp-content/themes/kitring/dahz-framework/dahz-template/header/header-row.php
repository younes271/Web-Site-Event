<?php
/**
 * The Header row template file
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
		'id'			=> "header-section-{$id_section}-row-{$id_row}",
		'class'			=> 'de-header__row uk-grid uk-grid-small',
		// 'data-uk-grid'	=> ''
	),
	"header_section_{$id_section}_row_attributes",
	$id_row
);?>>
	<?php echo apply_filters( 'dahz_framework_builder_header_row', $column_html );?>
</div>