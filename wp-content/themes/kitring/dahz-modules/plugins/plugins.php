<?php
if( !class_exists( 'Dahz_Framework_Plugins' ) ){

	Class Dahz_Framework_Plugins{
		
		public $path = '';
		
		public function __construct(){

			add_action( 'dahz_framework_module_plugins_init', array( $this, 'dahz_framework_plugins_init' ) );

		}

		public function dahz_framework_plugins_init( $path ){
			
			$this->path = $path;
			
			dahz_framework_include( $path . '/class-tgm-plugin-activation.php' );
			
			add_action( 'tgmpa_register', array( $this, 'dahz_framework_required_plugins' ) );

		}
		
		public function dahz_framework_required_plugins(){
			
			/**
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$plugins = array(
				
				array(
					'name'               => 'WPBakery Visual Composer',
					'slug'               => 'js_composer',
					'source'             => $this->path . '/js_composer.zip',
					'required'           => false,
					'version'            => '6.10.0',
					'force_activation'   => false,
					'force_deactivation' => false,
					'is_callable'        => '',
				),
				array(
					'name'               => 'Booked',
					'slug'               => 'booked',
					'source'             => $this->path . '/booked.zip',
					'required'           => false,
					'version'            => '2.4',
					'force_activation'   => false,
					'force_deactivation' => false,
					'is_callable'        => '',
				),
				array(
					'name'               => 'Classic Widgets',
					'slug'               => 'Classic Widgets',
					'source'             => $this->path . '/classic-widgets.zip',
					'required'           => false,
					'version'            => '0.3',
					'force_activation'   => false,
					'force_deactivation' => false,
					'is_callable'        => '',
				),
				array(
					'name'               => 'Slider Revolution',
					'slug'               => 'revslider',
					'source'             => $this->path . '/revslider.zip',
					'required'           => false,
					'version'            => '6.6.4',
					'force_activation'   => false,
					'force_deactivation' => false,
					'is_callable'        => '',
				),
				array(
					'name'               => 'Kitring Extender',
					'slug'               => 'kitring-extender',
					'source'             => $this->path . '/kitring-extender.zip',
					'required'           => false,
					'version'            => '2.1.7',
					'force_activation'   => false,
					'force_deactivation' => false,
					'is_callable'        => '',
				),
				array(
					'name'               => 'Contact Form 7', // The plugin name.
					'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
					'required'           => false, // If false, the plugin is only 'recommended' instead of required.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => 'https://downloads.wordpress.org/plugin/contact-form-7.zip', // If set, overrides default API URL and points to an external URL.
					'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
				),
				array(
					'name'               => 'Contact Form 7 MailChimp Extension', // The plugin name.
					'slug'               => 'contact-form-7-mailchimp-extension', // The plugin slug (typically the folder name).
					'required'           => false, // If false, the plugin is only 'recommended' instead of required.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => 'https://downloads.wordpress.org/plugin/contact-form-7-mailchimp-extension.zip', // If set, overrides default API URL and points to an external URL.
					'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
				),
				array(
					'name'               => 'Instagram Feed', // The plugin name.
					'slug'               => 'instagram-feed', // The plugin slug (typically the folder name).
					'required'           => false, // If false, the plugin is only 'recommended' instead of required.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => 'https://downloads.wordpress.org/plugin/instagram-feed.zip', // If set, overrides default API URL and points to an external URL.
					'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
				),
				
			);

			/**
			 * Array of configuration settings. Amend each line as needed.
			 * If you want the default strings to be available under your own theme domain,
			 * leave the strings uncommented.
			 * Some of the strings are added into a sprintf, so see the comments at the
			 * end of each line for what each argument will be.
			 */
			$config = array(
				'default_path' => '',                      // Default absolute path to pre-packaged plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
				'strings'      => array(
					'page_title'                      => esc_html__( 'Install Required Plugins', 'kitring' ),
					'menu_title'                      => esc_html__( 'Install Plugins', 'kitring' ),
					'installing'                      => esc_html__( 'Installing Plugin: %s', 'kitring' ), // %s = plugin name.
					'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'kitring' ),
					'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'kitring' ), // %1$s = plugin name(s).
					'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'kitring' ), // %1$s = plugin name(s).
					'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'kitring' ), // %1$s = plugin name(s).
					'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'kitring' ), // %1$s = plugin name(s).
					'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'kitring' ), // %1$s = plugin name(s).
					'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'kitring' ), // %1$s = plugin name(s).
					'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'kitring' ), // %1$s = plugin name(s).
					'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'kitring' ), // %1$s = plugin name(s).
					'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'kitring' ),
					'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'kitring' ),
					'return'                          => esc_html__( 'Return to Required Plugins Installer', 'kitring' ),
					'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'kitring' ),
					'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'kitring' ), // %s = dashboard link.
					'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
				)
			);

			tgmpa( $plugins, $config );
			
		}

	}

	if( is_admin() )
		new Dahz_Framework_Plugins();

}
