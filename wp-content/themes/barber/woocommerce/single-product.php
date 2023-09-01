<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<?php
$apr_settings = apr_check_theme_options();
$apr_layout = apr_get_layout();
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
?>
	<?php get_sidebar('left'); ?>  
		<div class="<?php echo esc_attr($class);?>">
				<?php
					/**
					 * woocommerce_before_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
					 * @hooked woocommerce_breadcrumb - 20
					 */
					do_action( 'woocommerce_before_main_content' );
				?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'single-product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php
					/**
					 * woocommerce_after_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
				?>
		</div>
		<?php get_sidebar('right'); ?>  
		<div class="clearfix"></div>
		<?php 
			if(isset($apr_settings['product-related']) && $apr_settings['product-related']){
				/**
				 * woocommerce_related_after hook.
				 *
				 * @hooked woocommerce_output_related_products - 10
				 * @hooked apr_banner_single_product - 20
				 */
				do_action('woocommerce_related_after');
			}
		?>
<?php get_footer( 'shop' ); ?>
