<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$radiantthemes_my_theme = wp_get_theme();
if ( $radiantthemes_my_theme->parent_theme ) {
	$radiantthemes_my_theme = wp_get_theme( basename( get_template_directory() ) );
}

?>

<div class="wrap about-wrap rt-admin-wrap">

	<h1><?php echo esc_html__( 'Welcome to ', 'glamon' ) . $radiantthemes_my_theme->Name; ?></h1>
	<div class="about-text"><?php echo esc_html( $radiantthemes_my_theme->Name ) . esc_html__( ' is now installed and ready to use!', 'glamon' ); ?></div>
	<div class="wp-badge"><?php printf( esc_html__( 'Version %s', 'glamon' ), esc_html( $radiantthemes_my_theme->Version ) ); ?></div>

	<h2 class="nav-tab-wrapper wp-clearfix">
		<a class="nav-tab" href="<?php echo esc_url( self_admin_url( 'themes.php?page=radiantthemes-dashboard' ) ); ?>"><?php esc_html_e( 'Dashboard', 'glamon' ); ?></a>
		<a class="nav-tab nav-tab-active" href="<?php echo esc_url( self_admin_url( 'themes.php?page=radiantthemes-admin-plugins' ) ); ?>"><?php esc_html_e( 'Install Plugins', 'glamon' ); ?></a>
		<?php if ( class_exists( 'OCDI_Plugin' ) ) { ?>
			<a class="nav-tab" href="<?php echo esc_url( self_admin_url( 'themes.php?page=pt-one-click-demo-import' ) ); ?>"><?php esc_html_e( 'Demo Importer', 'glamon' ); ?></a>
		<?php } ?>
		<?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
			<a class="nav-tab" href="<?php echo esc_url( self_admin_url( 'admin.php?page=_options' ) ); ?>"><?php esc_html_e( 'Theme Options', 'glamon' ); ?></a>
		<?php } ?>
	</h2>
	<div id="radiantthemes-dashboard" class="wrap about-wrap">
		<div class="welcome-content w-clearfix extra">
			<div class="radiantthemes-plugins radiantthemes-theme-browser-wrap">
				<div class="theme-browser rendered">
					<div class="whi-install-plugins-wrap">
						<h3><?php echo esc_html__( 'These below plugins are required', 'glamon' ); ?></h3>
						<a href="#" class="radiantthemes-admin-btn whi-install-plugins"><?php echo esc_html__( 'Activate all plugins', 'glamon' ); ?></a>
					</div>
					<div class="radiantthemes-plugins-wrap radiantthemes-plugins">

					<?php

					$tgmpa_list_table = new TGMPA_List_Table();
					$plugins          = TGM_Plugin_Activation::$instance->plugins;

					foreach ( $plugins as $plugin ) :

						$plugin_status              = '';
						$plugin['type']             = isset( $plugin['type'] ) ? $plugin['type'] : 'recommended';
						$plugin['sanitized_plugin'] = $plugin['name'];

						$plugin_action = $tgmpa_list_table->actions_plugin( $plugin );

						if ( strpos( $plugin_action, 'deactivate' ) !== false ) {
							$plugin_status = 'active';
							$plugin_action = '<div class="row-actions visible active"><span class="activate"><a class="button radiantthemes-admin-btn">' . esc_html__( 'Activated', 'glamon' ) . '</a></span></div>';
						}

						?>
						<div class="radiantthemes-plugin wp-clearfix <?php echo esc_attr( $plugin_status ); ?>" data-plugin-name="<?php echo esc_html( $plugin['name'] ); ?>">
							<h4><?php echo esc_html( $plugin['name'] ); ?></h4>
							<?php echo '' . $plugin_action; ?>
						</div>

					<?php endforeach; ?>

					</div>
				</div>
			</div>
			<div class="radiantthemes-notice radiantthemes-notice-success plugin-install-success" style="display: none;">
				<p><a href="<?php echo esc_url( self_admin_url( 'themes.php?page=pt-one-click-demo-import' ) ); ?>"><?php echo esc_html__( 'Click Here to continue with Demo Import process.', 'glamon' ); ?></a></p>
			</div>
		</div>
	</div>

</div> <!-- end wrap -->
