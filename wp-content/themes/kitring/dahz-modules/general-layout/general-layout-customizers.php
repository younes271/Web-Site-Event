<?php

if ( !class_exists( 'Dahz_Framework_Modules_General_Layout_Customizer' ) ) {

	Class Dahz_Framework_Modules_General_Layout_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer() {
			$dv_field = array();

			$img_url = get_template_directory_uri() . '/assets/images/customizer/general/';

			/**
			 * section general_layout
			 * add field general layout
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'radio-image',
				'settings'	=> 'general_layout',
				'label'		=> esc_html__( 'Layout', 'kitring' ),
				'default'	=> 'fullwidth',
				'choices'	=> array(
					'fullwidth'	=> get_template_directory_uri() . '/assets/images/customizer/df_body-full.svg',
					'boxed'		=> get_template_directory_uri() . '/assets/images/customizer/df_body-boxed.svg',
					'framed'	=> get_template_directory_uri() . '/assets/images/customizer/df_body-framed.svg',
				),
			);

			/**
			 * section general_layout
			 * add field site content width
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'text',
				'settings'	=> 'site_content_width',
				'label'		=> __( 'Site Content Width (px)', 'kitring' ),
				'default'	=> '1200',
			);

			/**
			 * section general_layout
			 * add field site boxed framed width
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'text',
				'settings'	=> 'site_boxed_width',
				'label'		=> __( 'Site Boxed Width (px)', 'kitring' ),
				'default'	=> '1400',
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'		=> 'boxed',
					),
				),
			);

			/**
			 * section general_layout
			 * add field site boxed framed width
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'text',
				'settings'	=> 'site_framed_width',
				'label'		=> __( 'Framed Width (px)', 'kitring' ),
				'default'	=> '40',
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'		=> 'framed',
					),
				),
			);

			/**
			 * section general_layout
			 * add field shadow background
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'select',
				'settings'	=> 'box_shadow',
				'label'		=> esc_html__( 'Shadow Background', 'kitring' ),
				'default'	=> '',
				'choices'	=> array(
					''						=> __( 'None', 'kitring' ),
					'uk-box-shadow-small'	=> __( 'Small', 'kitring' ),
					'uk-box-shadow-medium'	=> __( 'Medium', 'kitring' ),
					'uk-box-shadow-large'	=> __( 'Large', 'kitring' ),
					'uk-box-shadow-xlarge'	=> __( 'Extra Large', 'kitring' ),
				),
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'		=> 'boxed',
					),
				),
			);

			/**
			 * section general_layout
			 * add field framed_color
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'color',
				'choices'	=> array(
					'alpha'	=> true,
				),
				'settings'	=> 'framed_color',
				'label'		=> __( 'Framed Color', 'kitring' ),
				'default'	=> '#ffffff',
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'		=> 'framed',
					),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '.de-featured-area,.de-archive__header,.de-page__header,#de-archive-content.de-content-boxed,#de-archive-content.de-content-framed,#de-archive-content.de-content-fullwidth,#page.de-content-fullwidth,.de-page.de-content-boxed,.de-page.de-content-framed,.de-page.de-content-fullwidth,.de-single.de-content-boxed,.de-single.de-content-framed,.de-single.de-content-fullwidth,.de-404.de-content-boxed,.de-404.de-content-framed,.de-404.de-content-fullwidth,.calista,.coralie,.centaur,.catalina,.cloe,.de-portfolio-single,.de-sc-post-carousel__content,#de-product-container',
						'function'	=> 'css',
						'property'	=> 'background-color'
					),
				)
			);

			/**
			 * section general_layout
			 * add field body_bg_color
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'color',
				'choices'	=> array(
					'alpha'	=> true,
				),
				'settings'	=> 'body_bg_color',
				'label'		=> __( 'Body Background Color', 'kitring' ),
				'default'	=> '#ffffff',
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '.de-featured-area,.de-archive__header,.de-page__header,#de-archive-content.de-content-boxed,#de-archive-content.de-content-framed,#de-archive-content.de-content-fullwidth,#page.de-content-fullwidth,.de-page.de-content-boxed,.de-page.de-content-framed,.de-page.de-content-fullwidth,.de-single.de-content-boxed,.de-single.de-content-framed,.de-single.de-content-fullwidth,.de-404.de-content-boxed,.de-404.de-content-framed,.de-404.de-content-fullwidth,.calista,.coralie,.centaur,.catalina,.cloe,.de-portfolio-single,.de-sc-post-carousel__content,#de-product-container',
						'function'	=> 'css',
						'property'	=> 'background-color'
					),
				)
			);

			/**
			 * section general_layout
			 * add field body_bg_image
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'			=> 'image',
				'settings'		=> 'body_bg_image',
				'label'			=> __( 'Body Background Image', 'kitring' ),
				'default'		=> '',
				'transport'		=> 'postMessage',
				'js_vars'		=> array(
					array(
						'element'	=> '.de-featured-area,.de-archive__header,.de-page__header,#de-archive-content.de-content-boxed,#de-archive-content.de-content-framed,#de-archive-content.de-content-fullwidth,#page.de-content-fullwidth,.de-page.de-content-boxed,.de-page.de-content-framed,.de-page.de-content-fullwidth,.de-single.de-content-boxed,.de-single.de-content-framed,.de-single.de-content-fullwidth,.de-404.de-content-boxed,.de-404.de-content-framed,.de-404.de-content-fullwidth,.calista,.coralie,.centaur,.catalina,.cloe,.de-portfolio-single,.de-sc-post-carousel__content,#de-product-container',
						'function'	=> 'css',
						'property'	=> 'background-image'
					)
				),
			);

			/**
			 * section general_layout
			 * add field body_bg_size
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'select',
				'settings'	=> 'body_bg_size',
				'label'		=> __( 'Background Size', 'kitring' ),
				'default'	=> 'cover',
				'choices'	=> array(
					'auto'		=> __( 'Auto', 'kitring' ),
					'cover'		=> __( 'Cover', 'kitring' ),
					'contain'	=> __( 'Contain', 'kitring' ),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '.de-featured-area,.de-archive__header,.de-page__header,#de-archive-content.de-content-boxed,#de-archive-content.de-content-framed,#de-archive-content.de-content-fullwidth,#page.de-content-fullwidth,.de-page.de-content-boxed,.de-page.de-content-framed,.de-page.de-content-fullwidth,.de-single.de-content-boxed,.de-single.de-content-framed,.de-single.de-content-fullwidth,.de-404.de-content-boxed,.de-404.de-content-framed,.de-404.de-content-fullwidth,.calista,.coralie,.centaur,.catalina,.cloe,.de-portfolio-single,.de-sc-post-carousel__content,#de-product-container',
						'function'	=> 'css',
						'property'	=> 'background-size'
					)
				)
			);

			/**
			 * section general_layout
			 * add field body_bg_repeat
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'select',
				'settings'	=> 'body_bg_repeat',
				'label'		=> __( 'Background Repeat', 'kitring' ),
				'default'	=> 'no-repeat',
				'choices'	=> array(
					'repeat'	=> __( 'Repeat', 'kitring' ),
					'repeat-x'	=> __( 'Repeat-X', 'kitring' ),
					'repeat-y'	=> __( 'Repeat-Y', 'kitring' ),
					'no-repeat'	=> __( 'No-Repeat', 'kitring' ),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '.de-featured-area,.de-archive__header,.de-page__header,#de-archive-content.de-content-boxed,#de-archive-content.de-content-framed,#de-archive-content.de-content-fullwidth,#page.de-content-fullwidth,.de-page.de-content-boxed,.de-page.de-content-framed,.de-page.de-content-fullwidth,.de-single.de-content-boxed,.de-single.de-content-framed,.de-single.de-content-fullwidth,.de-404.de-content-boxed,.de-404.de-content-framed,.de-404.de-content-fullwidth,.calista,.coralie,.centaur,.catalina,.cloe,.de-portfolio-single,.de-sc-post-carousel__content,#de-product-container',
						'function'	=> 'css',
						'property'	=> 'background-repeat'
					)
				)
			);

			/**
			 * section general_layout
			 * add field body_bg_position
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'select',
				'settings'	=> 'body_bg_position',
				'label'		=> __( 'Background Position', 'kitring' ),
				'default'	=> 'left top',
				'choices'	=> array(
					'left top'		=> __( 'Left Top', 'kitring' ),
					'center top'	=> __( 'Center Top', 'kitring' ),
					'right top'		=> __( 'Right Top', 'kitring' ),
					'left center'	=> __( 'Left Center', 'kitring' ),
					'center center'	=> __( 'Center Center', 'kitring' ),
					'right center'	=> __( 'Right Center', 'kitring' ),
					'left bottom'	=> __( 'Left Bottom', 'kitring' ),
					'center bottom'	=> __( 'Center Bottom', 'kitring' ),
					'right bottom'	=> __( 'Right Bottom', 'kitring' ),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '.de-featured-area,.de-archive__header,.de-page__header,#de-archive-content.de-content-boxed,#de-archive-content.de-content-framed,#de-archive-content.de-content-fullwidth,#page.de-content-fullwidth,.de-page.de-content-boxed,.de-page.de-content-framed,.de-page.de-content-fullwidth,.de-single.de-content-boxed,.de-single.de-content-framed,.de-single.de-content-fullwidth,.de-404.de-content-boxed,.de-404.de-content-framed,.de-404.de-content-fullwidth,.calista,.coralie,.centaur,.catalina,.cloe,.de-portfolio-single,.de-sc-post-carousel__content,#de-product-container',
						'function'	=> 'css',
						'property'	=> 'background-position'
					)
				)
			);

			/**
			 * section general_layout
			 * add field body_bg_attachment
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'select',
				'settings'	=> 'body_bg_attachment',
				'label'		=> __( 'Background Attachment', 'kitring' ),
				'default'	=> 'scroll',
				'choices'	=> array(
					'scroll'=> __( 'Scroll', 'kitring' ),
					'fixed'	=> __( 'Fixed', 'kitring' )
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '.de-featured-area,.de-archive__header,.de-page__header,#de-archive-content.de-content-boxed,#de-archive-content.de-content-framed,#de-archive-content.de-content-fullwidth,#page.de-content-fullwidth,.de-page.de-content-boxed,.de-page.de-content-framed,.de-page.de-content-fullwidth,.de-single.de-content-boxed,.de-single.de-content-framed,.de-single.de-content-fullwidth,.de-404.de-content-boxed,.de-404.de-content-framed,.de-404.de-content-fullwidth,.calista,.coralie,.centaur,.catalina,.cloe,.de-portfolio-single,.de-sc-post-carousel__content,#de-product-container',
						'function'	=> 'css',
						'property'	=> 'background-attachment'
					)
				)
			);

			/**
			 * section general_layout
			 * add field outer_bg_color
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'color',
				'choices'	=> array(
					'alpha'	=> true,
				),
				'settings'	=> 'outer_bg_color',
				'label'		=> __( 'Outer Background Color', 'kitring' ),
				'default'	=> '#f2f2f2',
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'		=> 'boxed',
					),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '#page.de-content-boxed, #page.de-content-framed',
						'function'	=> 'css',
						'property'	=> 'background-color'
					)
				)
			);

			/**
			 * section general_layout
			 * add field outer_bg_image
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'image',
				'settings'	=> 'outer_bg_image',
				'label'		=> __( 'Outer Background Image', 'kitring' ),
				'section'	=> 'general_layout',
				'default'	=> '',
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'	=> 'boxed',
					),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '#page.de-content-boxed, #page.de-content-framed',
						'function'	=> 'css',
						'property'	=> 'background-image'
					)
				),
			);

			/**
			 * section general_layout
			 * add field outer_bg_size
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'select',
				'settings'	=> 'outer_bg_size',
				'label'		=> __( 'Background Size', 'kitring' ),
				'default'	=> 'cover',
				'choices'	=> array(
					'auto'		=> __( 'Auto', 'kitring' ),
					'cover'		=> __( 'Cover', 'kitring' ),
					'contain'	=> __( 'Contain', 'kitring' ),
				),
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'		=> 'boxed',
					),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '#page.de-content-boxed, #page.de-content-framed',
						'function'	=> 'css',
						'property'	=> 'background-size'
					)
				),
			);

			/**
			 * section general_layout
			 * add field outer_bg_repeat
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'select',
				'settings'	=> 'outer_bg_repeat',
				'label'		=> __( 'Background Repeat', 'kitring' ),
				'default'	=> 'no-repeat',
				'choices'	=> array(
					'repeat'	=> __( 'Repeat', 'kitring' ),
					'repeat-x'	=> __( 'Repeat-X', 'kitring' ),
					'repeat-y'	=> __( 'Repeat-Y', 'kitring' ),
					'no-repeat'	=> __( 'No-Repeat', 'kitring' ),
				),
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'		=> 'boxed',
					),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '#page.de-content-boxed, #page.de-content-framed',
						'function'	=> 'css',
						'property'	=> 'background-repeat'
					)
				),
			);

			/**
			 * section general_layout
			 * add field outer_bg_position
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'select',
				'settings'	=> 'outer_bg_position',
				'label'		=> __( 'Background Position', 'kitring' ),
				'default'	=> 'left top',
				'choices'	=> array(
					'left top'		=> __( 'Left Top', 'kitring' ),
					'center top'	=> __( 'Center Top', 'kitring' ),
					'right top'		=> __( 'Right Top', 'kitring' ),
					'left center'	=> __( 'Left Center', 'kitring' ),
					'center center'	=> __( 'Center Center', 'kitring' ),
					'right center'	=> __( 'Right Center', 'kitring' ),
					'left bottom'	=> __( 'Left Bottom', 'kitring' ),
					'center bottom'	=> __( 'Center Bottom', 'kitring' ),
					'right bottom'	=> __( 'Right Bottom', 'kitring' ),
				),
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'		=> 'boxed',
					),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '#page.de-content-boxed, #page.de-content-framed',
						'function'	=> 'css',
						'property'	=> 'background-position'
					),
				),
			);

			/**
			 * section general_layout
			 * add field outer_bg_attachment
			 */
			$dv_field[] = array(
				'priority'	=> 10,
				'type'		=> 'select',
				'settings'	=> 'outer_bg_attachment',
				'label'		=> __( 'Background Attachment', 'kitring' ),
				'default'	=> 'scroll',
				'choices'	=> array(
					'scroll'	=> __( 'Scroll', 'kitring' ),
					'fixed'		=> __( 'Fixed', 'kitring' )
				),
				'active_callback'	=> array(
					array(
						'setting'	=> 'general_layout_general_layout',
						'operator'	=> '==',
						'value'		=> 'boxed',
					),
				),
				'transport'	=> 'postMessage',
				'js_vars'	=> array(
					array(
						'element'	=> '#page.de-content-boxed, #page.de-content-framed',
						'function'	=> 'css',
						'property'	=> 'background-attachment'
					)
				),
			);

			return $dv_field;
		}

	}

}