<?php
namespace VamtamElementor\Widgets\NavMenu;

use \ElementorPro\Modules\NavMenu\Widgets\Nav_Menu as Elementor_Nav_Menu;

// Extending the Nav Menu widget.

// Is Pro Widget.
if ( ! \VamtamElementorIntregration::is_elementor_pro_active() ) {
	return;
}

// Theme preferences.
if ( ! \Vamtam_Elementor_Utils::is_widget_mod_active( 'nav-menu' ) ) {
	return;
}

if ( vamtam_theme_supports( 'nav-menu--underline-anim' ) ) {
	function add_underline_anim_controls( $controls_manager, $widget ) {
		$global_default = \Vamtam_Elementor_Utils::get_theme_global_widget_option( 'underline_anim_default' );

		// Pointer.
		\Vamtam_Elementor_Utils::add_control_options( $controls_manager, $widget, 'pointer', [
			'options' => [
				'theme-underline' => __( 'Underline (Theme)', 'vamtam-elementor-integration' ),
			],
		] );

		if ( ! empty( $global_default ) ) {
			\Vamtam_Elementor_Utils::replace_control_options( $controls_manager, $widget, 'pointer', [
				'default' => 'theme-underline',
			] );
		}

		$widget->start_injection( [
			'of' => 'pointer',
		] );
		// Underline Width
		$widget->add_control(
			'vamtam_underline_width',
			[
				'label' => __( 'Underline Width', 'vamtam-elementor-integration' ),
				'type' => $controls_manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 10,
						'min' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-item' => '--vamtam-underline-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'pointer' => 'theme-underline',
				]
			]
		);
		// Underline Spacing
		$widget->add_control(
			'vamtam_underline_spacing',
			[
				'label' => __( 'Underline Spacing', 'vamtam-elementor-integration' ),
				'type' => $controls_manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-item' => '--vamtam-underline-spacing: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'pointer' => 'theme-underline',
				]
			]
		);
		$widget->end_injection();
	}

	function update_controls_style_tab_main_section( $controls_manager, $widget ) {
		// Menu item pointer hover color.
		\Vamtam_Elementor_Utils::add_control_options( $controls_manager, $widget, 'pointer_color_menu_item_hover', [
			'selectors' => [
				'{{WRAPPER}}' => '--vamtam-pointer-color-hover: {{VALUE}}',
			],
		] );

		// Menu item pointer active color.
		\Vamtam_Elementor_Utils::add_control_options( $controls_manager, $widget, 'pointer_color_menu_item_active', [
			'selectors' => [
				'{{WRAPPER}}' => '--vamtam-pointer-color-active: {{VALUE}}',
			],
		] );
	}

	// Style - Main Menu section
	function section_style_main_menu_before_section_end( $widget, $args ) {
		$controls_manager = \Elementor\Plugin::instance()->controls_manager;
		update_controls_style_tab_main_section( $controls_manager, $widget );
	}
	add_action( 'elementor/element/nav-menu/section_style_main-menu/before_section_end', __NAMESPACE__ . '\section_style_main_menu_before_section_end', 10, 2 );
}

if ( vamtam_theme_supports( 'nav-menu--disable-scroll-on-mobile' ) ) {
	function add_disable_scroll_on_mobile_control( $controls_manager, $widget ) {
		$widget->add_control(
			'vamtam_disable_scroll_on_mobile',
			[
				'label' => __( 'Disable Page Scroll', 'vamtam-elementor-integration' ),
				'description' => __( 'Disables the page scroll when the mobile dropdown menu is toggled.', 'vamtam-elementor-integration' ),
				'type' => $controls_manager::SWITCHER,
				'prefix_class' => 'vamtam-has-',
				'return_value' => 'mobile-disable-scroll',
				'default' => 'mobile-disable-scroll',
			]
		);
		$widget->add_control(
			'vamtam_mobile_menu_use_max_height',
			[
				'label' => __( 'Enforce Max Height', 'vamtam-elementor-integration' ),
				'description' => __( 'Use this option if the mobile dropdown menu is getting cut and items become unreachable.', 'vamtam-elementor-integration' ),
				'type' => $controls_manager::SWITCHER,
				'prefix_class' => 'vamtam-has-',
				'return_value' => 'mobile-menu-max-height',
				'condition' => [
					'vamtam_disable_scroll_on_mobile!' => '',
				]
			]
		);
		$widget->add_responsive_control(
			'vamtam_mobile_menu_max_height',
			[
				'label' => esc_html__( 'Max Height (vh)', 'vamtam-elementor-integration' ),
				'description' => __( 'Adjust this value until all items are scroll-reachable. Test this on the frontend as on the editor there can be elements that take up space which are hidden on the frontend.<i>Please ignore the desktop variant of this option as its value is not used.</i>', 'vamtam-elementor-integration' ),
				'type' => $controls_manager::SLIDER,
				'devices' => [ 'desktop', 'tablet', 'mobile' ], // 'desktop' we don't really need (and is not applied anywhere), but it breaks the editor when the "Additional Custom Breakpoints" feature is enabled.
				'size_units' => [ 'vh' ],
				'range' => [
					'vh' => [
						'min' => 50,
						'max' => 100,
					],
				],
				'tablet_default' => [
					'size' => 80,
					'unit' => 'vh',
				],
				'mobile_default' => [
					'size' => 80,
					'unit' => 'vh',
				],
				'selectors' => [
					'{{WRAPPER}}' => "--vamtam-mobile-menu-max-height: {{SIZE}}vh",
				],
				'condition' => [
					'vamtam_disable_scroll_on_mobile!' => '',
					'vamtam_mobile_menu_use_max_height!' => '',
				],
			]
		);
	}
}

if ( vamtam_theme_supports( [ 'nav-menu--disable-scroll-on-mobile', 'nav-menu--underline-anim' ] ) ) {
	// Content - Layout section
	function section_layout_before_section_end( $widget, $args ) {
		$controls_manager = \Elementor\Plugin::instance()->controls_manager;
		if ( vamtam_theme_supports( 'nav-menu--underline-anim' ) ) {
			add_underline_anim_controls( $controls_manager, $widget );
		}
		if ( vamtam_theme_supports( 'nav-menu--disable-scroll-on-mobile' ) ) {
			add_disable_scroll_on_mobile_control( $controls_manager, $widget );
		}
	}
	add_action( 'elementor/element/nav-menu/section_layout/before_section_end', __NAMESPACE__ . '\section_layout_before_section_end', 10, 2 );

	// Vamtam_Widget_Nav_Menu.
	function widgets_registered() {
		class Vamtam_Widget_Nav_Menu extends \ElementorPro\Modules\NavMenu\Widgets\Nav_Menu {
			public $extra_depended_scripts = [
				'vamtam-nav-menu',
			];

			// Extend constructor.
			public function __construct($data = [], $args = null) {
				parent::__construct($data, $args);

				$this->register_assets();

				$this->add_extra_script_depends();
			}

			// Register the assets the widget depends on.
			public function register_assets() {
				$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

				wp_register_script(
					'vamtam-nav-menu',
					VAMTAM_ELEMENTOR_INT_URL . '/assets/js/widgets/nav-menu/vamtam-nav-menu' . $suffix . '.js',
					[
						'elementor-frontend'
					],
					\VamtamElementorIntregration::PLUGIN_VERSION,
					true
				);
			}

			// Assets the widget depends upon.
			public function add_extra_script_depends() {
				// Scripts
				foreach ( $this->extra_depended_scripts as $script ) {
					$this->add_script_depends( $script );
				}
			}

			/*
				We override the get_script_depends method directly because Elementor's
				Nav_Menu class returns the array directly, like so:

					public function get_script_depends() {
						return [ 'smartmenus' ];
					}

				If this changes, we should update this and probably filter the script in the
				add_extra_script_depends method.
			*/
			public function get_script_depends() {
				$script_depends = [
					'smartmenus',
				];

				// Add our handler.
				$script_depends[] = 'vamtam-nav-menu';

				return $script_depends;
			}
		}

		// Replace current divider widget with our extended version.
		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;
		$widgets_manager->unregister( 'nav-menu' );
		$widgets_manager->register( new Vamtam_Widget_Nav_Menu );
	}
	add_action( \Vamtam_Elementor_Utils::get_widgets_registration_hook(), __NAMESPACE__ . '\widgets_registered', 100 );
}
