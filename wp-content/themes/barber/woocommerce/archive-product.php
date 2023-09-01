<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<?php
global $wp_query, $woocommerce_loop;
$apr_settings = apr_check_theme_options();
$apr_sidebar_left = apr_get_sidebar_left();
$apr_sidebar_right = apr_get_sidebar_right();
$apr_layout = apr_get_layout();
$cat = $wp_query->get_queried_object();
//only for demo
if (isset($_GET['sidebar']) && $_GET['sidebar']=="none") {
    $apr_sidebar_left = $_GET['sidebar'];
    $apr_sidebar_right = $_GET['sidebar'];
}
//end demo
if(isset($cat->term_id)){
	$woo_cat = $cat->term_id;
}else{
	$woo_cat = '';
}
$product_list_mode = get_metadata('product_cat', $woo_cat, 'list_mode_product', true);
$product_type_class = '';
if($product_list_mode == "only-grid-wrap"){
	$product_type_class = "product-grid-wrap";
}
else if($product_list_mode == "only-list-wrap"){
	$product_type_class = "product-list-wrap";
}
else{
	$product_type_class = "product-grid-wrap";
}
$product_layout = isset($apr_settings['product-layouts']) ? $apr_settings['product-layouts'] :'';
?>
<?php
	$class = '';
	if ($apr_sidebar_left && $apr_sidebar_right && is_active_sidebar($apr_sidebar_left) && is_active_sidebar($apr_sidebar_right)){
	 	$class .= 'col-md-6 col-sm-12 col-xs-12 main-sidebar'; 
	}elseif($apr_sidebar_left && (!$apr_sidebar_right|| $apr_sidebar_right=="none") && is_active_sidebar($apr_sidebar_left)){
		$class .= 'f-right col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
	}elseif((!$apr_sidebar_left || $apr_sidebar_left=="none") && $apr_sidebar_right && is_active_sidebar($apr_sidebar_right)){
		$class .= 'col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
	}else {
		$class .= 'content-primary'; 
		if($apr_layout == 'fullwidth'){
			$class .= ' col-md-12';
		}
	}
	$current_page = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
?>
<?php get_sidebar('left'); ?> 
	<div class="<?php echo esc_attr($class);?>">
		<?php if ( have_posts() ) : ?>
			<?php wc_print_notices(); ?>
			<div class="top_archive_product">
				<div class="col-md-9 col-sm-9 col-xs-12 no-padding">
					<div class="select-tooltbars">
					<?php
						/**
						 * woocommerce_before_shop_loop hook.
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
					?>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 text-right filter_count_view no-padding">
					<?php
						/**
						 * woocommerce_before_shop_loop_right hook.
						 *
						 * @hooked apr_view_count - 20
						 */
						do_action( 'woocommerce_before_shop_loop_right' );
					?>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 no-padding">
					<?php
						/**
						 * woocommerce_archive_description hook.
						 *
						 * @hooked woocommerce_taxonomy_archive_description - 10
						 * @hooked woocommerce_product_archive_description - 10
						 */
						
						do_action( 'woocommerce_archive_description' );
					?>
				</div>
			</div>	
	    	<?php 
	    	$category_cols = get_metadata('product_cat', $woo_cat, 'category_cols', true);
			$cols_md = 'columns-4';
			if(!is_product_category()){
			    switch ($apr_settings['product-cols']) {
					case 1: $cols_md = ' columns-1';
			            break;
			    	case 2: $cols_md = ' columns-2';
			            break;
			        case 3: $cols_md = ' columns-3';
			            break;
					case 4: $cols_md = ' columns-4';
			            break;
			        default: $cols_md = ' columns-5';
			            break;
			    }
			} else{
			    switch ($category_cols) {
			    	case 1: $cols_md = ' columns-1';
			            break;
					case 2: $cols_md = ' columns-2';
			            break;
			        case 3: $cols_md = ' columns-3';
			            break;
					case 4: $cols_md = ' columns-4';
			            break;
			        default: $cols_md = ' columns-5';
			            break;
			    }
			}
			$terms = get_terms( 'product_cat', array(
	        'hierarchical'  => false,
	        'hide_empty'        => true,
	        'order' => 'random'
	        ) );
	    	?>
			<div class="text-center product_archives isotope product-isotope woocommerce <?php echo esc_attr($cols_md);?> <?php echo esc_attr($product_type_class);?>">
				<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?> 
			</div>
			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>


		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
	</div>
<?php get_sidebar('right'); ?>
<?php get_footer( 'shop' ); ?>
