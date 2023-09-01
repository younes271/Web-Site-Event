<?php
/**
 * Footer Default Section
 *
 * @package glamon
 */
?>

<?php
if ( 'footer-default' === glamon_global_var( 'footer-style', '', false ) ) {
	get_template_part( 'inc/footer/footer-style', 'one' );
} elseif ( 'footer-custom' === glamon_global_var( 'footer-style', '', false ) ) {
	get_template_part( 'inc/footer/footer', 'custom' );
} else {
	?>
<!-- wraper_footer -->
<footer class="wraper_footer style-default">
	<!-- wraper_footer_copyright -->
	<div class="wraper_footer_copyright">
		<div class="container">
			<!-- footer_copyright -->
			<div class="row footer_copyright">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- footer_copyright_item -->
					<div class="footer_copyright_item text-center">
						<p><?php echo esc_html__( '© ', 'glamon' ); ?><?php echo esc_html( date( 'Y' ) ); ?><?php echo esc_html__( ' Glamon Theme. RadiantThemes ', 'glamon' ); ?></p>
					</div>
					<!-- footer_copyright_item -->
				</div>
			</div>
			<!-- footer_copyright -->
		</div>
	</div>
	<!-- wraper_footer_copyright -->
</footer>
<!-- wraper_footer -->
	<?php
} ?>
