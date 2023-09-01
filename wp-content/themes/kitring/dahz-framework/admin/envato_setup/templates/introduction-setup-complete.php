<h1><?php printf( esc_html__( 'Welcome to the setup wizard for %s.', 'kitring' ), wp_get_theme() ); ?></h1>
<p><?php esc_html_e( 'It looks like you have already run the setup wizard. Below are some options: ', 'kitring' ); ?></p>
<ul class="setup-completed">
	<li>
		<a href="<?php echo esc_url( $_this->get_next_step_link() ); ?>" class="button-primary button button-next button-large"><?php esc_html_e( 'Run Setup Wizard Again', 'kitring' ); ?></a>
	</li>
	<li>
		<form method="post">
			<input type="hidden" name="reset-font-defaults" value="yes">
			<input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Reset font style and colors', 'kitring' ); ?>" name="save_step"/>
			<?php wp_nonce_field( 'envato-setup' ); ?>
		</form>
	</li>
	<li>
		<p class="envato-setup-actions step">
			<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>" class="button button-large"><?php esc_html_e( 'Cancel', 'kitring' ); ?></a>
		</p>
	</li>
</ul>