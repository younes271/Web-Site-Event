<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

global $dahz_framework;

$parent_brands_attr = array();

$columns 					= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'brand_column_desktop', '1-5' );

$tablet_landscape_columns 	= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'brand_column_tablet', '1-4' );

$phone_landscape_columns 	= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'brand_column_phone_landscape', '1-2' );

$phone_potrait_columns 		= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'brand_column_phone_potrait', '1-1' );

$is_display_alphabet 		= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'display_alphabet_filter', 'on' );

$is_display_category 		= dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'display_category_filter', 'on' );

# Set phone portrait column

$phone_potrait_columns = sprintf( 'uk-child-width-%s', $phone_potrait_columns );

# Set phone landscape & tablet portrait column

$phone_landscape_columns = sprintf( 'uk-child-width-%s@s', $phone_landscape_columns );

# Set tablet landscape column

$tablet_landscape_columns = sprintf( 'uk-child-width-%s@m', $tablet_landscape_columns );

# Set desktop column

$columns = sprintf( 'uk-child-width-%s@l', $columns );

$classes = $phone_potrait_columns . ' ' . $phone_landscape_columns . ' ' . $tablet_landscape_columns . ' ' . $columns;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content de-row uk-container uk-position-relative">
		<?php do_action( 'dahz_framework_before_page_brand' ); ?>
		<?php the_content(); ?>
		
		<ul class="de-brands-controls uk-flex-center" data-uk-tab data-uk-switcher>
		<?php if ( $is_display_alphabet === 'on' ): ?>
			<li>
				<a data-brand-control="letters" href="#"><?php esc_html_e( 'A - Z', 'kitring' );?></a>
			</li>
		<?php endif; ?>
		<?php if ( $is_display_category === 'on' ): ?>
			<li>
				<a data-brand-control="categories" href="#"><?php esc_html_e( 'CATEGORIES', 'kitring' );?></a>
			</li>
		<?php endif; ?>
		</ul>
		
		<div class="uk-switcher">

			<?php if ( $is_display_alphabet === 'on' ): ?>

				<div class="de-brands-index ds-scroller">

					<?php do_action( 'dahz_framework_brand_indexes' ) ?>

				</div>

			<?php endif; ?>

			<?php if ( $is_display_category === 'on' ): ?>

				<div class="de-brands-categories ds-scroller">

					<?php do_action( 'dahz_framework_brand_categories' ) ?>

				</div>
			<?php endif; ?>
		</div>
		<div class="de-brand <?php echo esc_attr( $classes ) ?>" data-uk-grid>
			<?php do_action( 'dahz_framework_brand_items' ) ?>
		</div>
	</div><!-- .entry-content -->


</article><!-- #post-## -->
