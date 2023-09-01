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

$classes = explode( ' ', $column_extraclass );

# ROW
$row_attr = array();

$row_classes = array( 'uk-flex uk-flex-wrap uk-flex-row' );

$row_classes[] = $column_class;

foreach ($classes as $key => $value) {
	if ( !preg_match( '#uk-flex-left#', $value, $matches ) && !preg_match( '#uk-flex-center#', $value, $matches ) && !preg_match( '#uk-flex-right#', $value, $matches ) ) {
		$row_classes[] = $value;
	}
}

$row_attr['id'] = "footer-section-{$id_section}-row-{$id_row}-column-{$id_column}";

$row_attr['class'] = $row_classes;
# END OF ROW

# GRID
$grid_attr = array();

$grid_classes = array( 'uk-grid uk-child-width-auto uk-flex-1' );

$grid_classes[] = $column_align;

foreach ($classes as $key => $value) {
	if ( preg_match( '#uk-flex-left#', $value, $matches ) || preg_match( '#uk-flex-center#', $value, $matches ) || preg_match( '#uk-flex-right#', $value, $matches ) ) {
		$grid_classes[] = $value;
	}
}

$grid_attr['class'] = $grid_classes;

$grid_attr['data-uk-grid'] = '';
# END OF GRID

?>
<div <?php dahz_framework_set_attributes(
	$row_attr,
	"footer_section_{$id_section}_row_column",
	array(
		'id_section' => $id_section,
		'id_row'     => $id_row,
		'id_column'  => $id_column
	)
); ?>>
	<div <?php dahz_framework_set_attributes( $grid_attr ); ?>>
		<?php echo apply_filters( 'dahz_framework_footer_column_html', $item_html ); ?>
	</div>
</div>