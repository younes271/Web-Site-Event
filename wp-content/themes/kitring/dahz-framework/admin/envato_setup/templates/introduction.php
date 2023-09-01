<?php
if( !$_this->dahz_framework_is_complete_setup() ){
	
	$_this->dahz_framework_load_default_setup();
	
}
?>
<h1><?php printf( esc_html__( 'Welcome to the setup wizard for %s.', 'kitring' ), wp_get_theme() ); ?></h1>
<p><?php printf( esc_html__( 'Thank you for choosing the %s theme from ThemeForest. This quick setup wizard will help you configure your new website. This wizard will install the required WordPress plugins, default content, color scheme and tell you a little about Help &amp; Support options. It should only take 5 minutes.', 'kitring' ), wp_get_theme() ); ?></p>
<p><?php esc_html_e( 'No time right now? If you don\'t want to go through the wizard, you can skip and return to the WordPress dashboard. Come back anytime if you change your mind!', 'kitring' ); ?></p>
<p class="envato-setup-actions step">
	<a href="<?php echo esc_url( $_this->get_next_step_link() ); ?>"
	   class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!', 'kitring' ); ?></a>
	<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
	   class="button button-large"><?php esc_html_e( 'Not right now', 'kitring' ); ?></a>
</p>