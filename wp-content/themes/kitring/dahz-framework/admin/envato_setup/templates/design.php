<h1><?php esc_html_e( 'Site Style', 'kitring' ); ?></h1>
<form method="post">
	<p><?php esc_html_e( 'Please choose your site style below.', 'kitring' ); ?></p>
<?php

?>
	<div class="dahz-theme-presets">
		<ul>
			<?php
			$current_style = get_theme_mod( 'dtbwp_site_style', 'style_1' );
			foreach ( $styles as $style_id => $style_data ) {
				?>
				<li class="<?php echo esc_attr( $style_id == $current_style ? 'current' : '' );?>">
					<a href="#" data-style="<?php echo esc_attr( $style_id ); ?>" data-is-local-file="<?php echo esc_attr( $style_data['is_local_file'] );?>">
						<img src="<?php echo esc_url( $style_data['image'] );?>">
						<h3><?php echo esc_html( $style_data['name'] ); ?></h3>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>

	<input type="hidden" name="style" id="style" value="">
	<input type="hidden" name="is_local_file" id="is_local_file" value="">
	<p><em>Please Note: Advanced changes to website graphics/colors may require extensive PhotoShop and Web
			Development knowledge. We recommend hiring an expert from <a
					href="http://studiotracking.envato.com/aff_c?offer_id=4&aff_id=1564&source=DemoInstall"
					target="_blank">Envato Studio</a> to assist with any advanced website changes.</em></p>


	<p class="envato-setup-actions step">
		<input type="submit" class="button-primary button button-large button-next"
			   value="<?php esc_attr_e( 'Continue', 'kitring' ); ?>" name="save_step"/>
		<a href="<?php echo esc_url( $_this->get_next_step_link() ); ?>"
		   class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'kitring' ); ?></a>
		<?php wp_nonce_field( 'envato-setup' ); ?>
	</p>
</form>