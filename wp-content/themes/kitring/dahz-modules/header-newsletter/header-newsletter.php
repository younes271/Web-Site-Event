<?php

if( !class_exists( 'Dahz_Framework_Header_Newsletter' ) ){

	Class Dahz_Framework_Header_Newsletter {

		public function __construct(){

			add_action( 'dahz_framework_module_header-newsletter_init', array( $this, 'dahz_framework_header_newsletter_init' ) );

			add_filter( 'dahz_framework_customize_header_builder_items', array( $this, 'dahz_framework_header_item_newsletter' ), 10, 3 );

			add_filter( 'dahz_framework_customize_headermobile_builder_items', array( $this, 'dahz_framework_header_item_newsletter_mobile' ), 10, 3 );

			add_action( 'wp_footer', array( $this, 'dahz_framework_render_myaccount_popup' ), 10 );

			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_header_newsletter_default_styles' ) );

		}

		public function dahz_framework_header_item_newsletter( $items ) {

			$items['newsletter'] = array(
				'title'				=> esc_html__( 'Newsletter', 'kitring' ),
				'description'		=> esc_html__( 'Display Newsletter in Header', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_header_newsletter_element' ),
				'section_callback'	=> 'header_newsletter',
				'is_repeatable'		=> false
			);

			return $items;

		}

		public function dahz_framework_header_item_newsletter_mobile( $items ) {

			$items['newsletter_mobile'] = array(
				'title'				=> esc_html__( 'Newsletter', 'kitring' ),
				'description'		=> esc_html__( 'Display Newsletter in Mobile Menu', 'kitring' ),
				'render_callback'	=> array( $this, 'dahz_framework_header_newsletter_element' ),
				'section_callback'	=> 'header_newsletter',
				'is_repeatable'		=> false
			);

			return $items;

		}

		public function dahz_framework_header_newsletter_init( $path ){

			if ( is_customize_preview() ) dahz_framework_include( $path . '/header-newsletter-customizer.php' );

			dahz_framework_register_customizer(
				'Dahz_Framework_Header_Newsletter_Customizer',
				array(
					'id'	=> 'header_newsletter',
					'title'	=> array( 'title' => esc_html__( 'Newsletter', 'kitring' ), 'priority' => 19 ),
					'panel'	=> 'header'
				),
				array()
			);

		}

		public function dahz_framework_header_newsletter_element( $builder_type, $section, $row, $column ){

			$newsletter_text = '';

			$text = dahz_framework_get_option( 'header_newsletter_text' );

			$icon_ratio = $builder_type == 'mobile_elements' ? dahz_framework_get_option( 'header_newsletter_mobile_icon_ratio', '1' ) : dahz_framework_get_option( 'header_newsletter_desktop_icon_ratio', '1' );

			$link_content = sprintf(
				'
				<span data-uk-icon="icon:df_mail-open;ratio:%1$s;"></span> %2$s
				',
				(float)$icon_ratio,
				!empty( $text ) ? '<span class="uk-margin-left">' . esc_html( $text ) . '</span>' : ''
			);

			dahz_framework_get_template(
				"newsletter-link.php",
				array(
					'link_content' => $link_content
				),
				'dahz-modules/header-newsletter/templates/'
			);

		}

		public function dahz_framework_render_myaccount_popup() {

			global $dahz_framework;

			$mobile_header	= dahz_framework_get_option( 'mobile_header_mobile_menu_element', array() );

			$enable_myaccount_mobile = in_array( 'newsletter_mobile', $mobile_header );

			if ( isset( $dahz_framework->builder_items['newsletter'] ) || $enable_myaccount_mobile ) {

				$newsletter_images = dahz_framework_get_option( 'header_newsletter_images' );

				$contact_form = dahz_framework_get_option( 'header_newsletter_contact_form' );

				echo sprintf(
					'
					<div id="header-newsletter-modal" class="uk-flex-top uk-modal-container" data-uk-modal>
						<div class="uk-modal-dialog uk-width-xxlarge uk-margin-auto-vertical">
							<button class="uk-modal-close-default" type="button" data-uk-close></button>
							<div class="woo-quickview-modal-container uk-position-relative" data-layout="quickview">
								%1$s
							</div>
						</div>
					</div>
					',
					dahz_framework_get_template_html(
						"newsletter-content.php",
						array(
							'newsletter_images' 	=> dahz_framework_get_option( 'header_newsletter_images' ),
							'contact_form'			=> dahz_framework_get_option( 'header_newsletter_contact_form' ),
							'enable_images'			=> ( !empty( $newsletter_images ) && is_array( $newsletter_images ) ),
							'enable_contact_form'	=> ( class_exists( 'WPCF7' ) && !empty( $contact_form ) )
						),
						'dahz-modules/header-newsletter/templates/'
					)
				);

			}

		}

		public function dahz_framework_header_newsletter_default_styles( $default_styles ) {
			$header_newsletter_desktop_font_size = dahz_framework_get_option( 'header_newsletter_desktop_font_size', '18px' );
			$header_newsletter_mobile_font_size = dahz_framework_get_option( 'header_newsletter_mobile_font_size', '18px' );

			$default_styles = sprintf(
				'
				#header-newsletter-modal .de-quickview-content__summary {
					font-size: %1$s;
				}
				@media only screen and ( max-width: 768px ) {
					#header-newsletter-modal .de-quickview-content__summary {
						font-size: %2$s;
					}
				}
				',
				esc_attr( $header_newsletter_desktop_font_size ),
				esc_attr( $header_newsletter_mobile_font_size )
			) . $default_styles;

			return $default_styles;
		}

	}

	new Dahz_Framework_Header_Newsletter();

}
