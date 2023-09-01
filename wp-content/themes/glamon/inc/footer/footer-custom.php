<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package glamon
 */
?>

	<?php
        $footerBuilder_id = glamon_global_var('footer_list_text', '', false);
        $getFooterPost = get_post($footerBuilder_id);
        $content = $getFooterPost->post_content;
    ?>
    <!-- wraper_footer -->
    <?php if ( true == glamon_global_var( 'footer_custom_stucking', '', false ) && ! wp_is_mobile() ) { ?>
        <div class="footer-custom-stucking-container"></div>
        <footer class="wraper_footer custom-footer footer-custom-stucking-mode">
    <?php } else { ?>
        <footer class="wraper_footer custom-footer">
    <?php } ?>
        <div class="container">
            <?php echo do_shortcode( $content ); ?>
        </div>
    </footer>
    <!-- wraper_footer -->
