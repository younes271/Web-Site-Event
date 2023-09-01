<?php
/**
 * The Header column template file
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
		'id'    => "header-section-{$id_section}-row-{$id_row}-column-{$id_column}",
		'class' => array(
			$column_class,
			$column_align,
			$column_extraclass,
			'de-header__column uk-flex uk-flex-wrap uk-flex-row uk-flex-middle'
		)
	),
	"header_section_{$id_section}_row_column",
	array(
		'id_section' => $id_section,
		'id_row'     => $id_row,
		'id_column'  => $id_column
	)
); ?>>
	<div class="uk-grid uk-grid-medium uk-child-width-auto <?php echo esc_attr( $column_align ); ?>" data-uk-grid>
		<?php echo apply_filters( 'dahz_framework_builder_header_column', $item_html ); ?>
	</div>
</div>
