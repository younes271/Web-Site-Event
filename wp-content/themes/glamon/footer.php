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

		</div>
		<!-- #content -->
	</div>
	<!-- #page -->

<?php
if ( ! class_exists( 'ReduxFrameworkPlugin' ) || ( is_404() ) || ( is_search() ) ) {
	get_template_part( 'inc/footer/footer-style', 'default' );
} else {
	$footerBuilder_id      = esc_html( get_post_meta( $post->ID, 'custom_footer', true ) );
	$custom_footer_post_id = $footerBuilder_id;
	if ( $footerBuilder_id && ( is_numeric( $footerBuilder_id ) ) ) {
		$footerBuilder_id = esc_html( get_post_meta( $post->ID, 'custom_footer', true ) );
		$getFooterPost    = get_post( $footerBuilder_id );
		echo '<!-- wraper_footer -->';
		if ( true == glamon_global_var( 'footer_custom_stucking', '', false ) && ! wp_is_mobile() ) {
			echo '<div class="footer-custom-stucking-container"></div>
              <footer class="wraper_footer custom-footer footer-custom-stucking-mode">';
		} else {
			echo '<footer class="wraper_footer custom-footer">';
		}
		echo "<div class='container'>";
		$content = $getFooterPost->post_content;
		echo do_shortcode( $content );
		echo '</div>';
		echo '</footer>';
		echo '<!-- wraper_footer -->';
	} else {
		get_template_part( 'inc/footer/footer-style', 'default' );
	}
}
?>

</div>
<!-- radiantthemes-website-layout -->

<?php wp_footer(); ?>

</body>
</html>
