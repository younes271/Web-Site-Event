<?php
/*
 1. class : Dahz_Framework_Modules_Blog_Archive_Customizer
 */
if ( !class_exists( 'Dahz_Framework_Modules_Blog_Archive_Customizer' ) ) {

	Class Dahz_Framework_Modules_Blog_Archive_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer(){

			$dv_field = array();

			$img_url = get_template_directory_uri() . '/assets/images/customizer/blog/';

			$dv_field[] = array(
				'type'     => 'custom',
				'settings' => "custom_title_blog_archive_layout",
				'label'    => '',
				'default'  => '<div class="de-customizer-title">'. esc_html__( 'Layout', 'kitring' ) .'</div>',
			);

			/**
			 * section archive_layout
			 * add field archive_layout_sidebar
			 */
			$dv_field[] =  array(
				'type'        => 'radio-image',
				'settings'    => 'layout_sidebar',
				'label'       => __( 'Sidebar Layout', 'kitring' ),
				'default'     => 'sidebar-right',
				'choices'     => array(
					'fullwidth'		=> $img_url . 'df_body-full.svg',
					'sidebar-left'	=> $img_url . 'df_body-left-sidebar.svg',
					'sidebar-right'	=> $img_url . 'df_body-right-sidebar.svg',
				),
				'description' => __( 'To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section archive_layout
			 * add field archive_layout
			 */
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'heading',
				'label'       => esc_html__( 'Heading Style', 'kitring' ),
				'default'	  => 'uk-article-title',
				'choices'     => array(
					'uk-article-title'		=> __( 'Article', 'kitring' ),
					'uk-heading-primary'	=> __( 'Primary', 'kitring' ),
					'uk-heading-hero'		=> __( 'Hero', 'kitring' ),
					'uk-h1'					=> __( 'H1', 'kitring' ),
					'uk-h2'					=> __( 'H2', 'kitring' ),
					'uk-h3'					=> __( 'H3', 'kitring' ),
					'uk-h4'					=> __( 'H4', 'kitring' ),
					'uk-h5'					=> __( 'H5', 'kitring' ),
					'uk-h6'					=> __( 'H6', 'kitring' ),
				),
			); 
			
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'column',
				'label'       => esc_html__( 'Column', 'kitring' ),
				'description' => esc_html__( 'Select Column', 'kitring' ),
				'default'	  => 1,
				'choices'     => array(
					1		=> __( 'Column 1', 'kitring' ),
					2		=> __( 'Column 2', 'kitring' ),
					3		=> __( 'Column 3', 'kitring' ),
					4		=> __( 'Column 4', 'kitring' ),
				),
			);

			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'order',
				'label'       => esc_html__( 'Order', 'kitring' ),
				'description' => esc_html__( 'Select Order', 'kitring' ),
				'default'	  => 1,
				'choices'     => array(
					0			=> __( 'Down', 'kitring' ),
					1			=> __( 'Accross', 'kitring' ),
				),
			);

			$dv_field[] = array(
				'type'        => 'checkbox',
				'settings'    => 'larger',
				'label'       => esc_attr__( 'Larger Gutter', 'kitring' ),
				'default'     => true,
				'active_callback'	=> array(
					array(
						'setting'	=> 'blog_archive_column',
						'operator'	=> '!=',
						'value'		=> '1',
					)
				),
			);

			/**
			 * section archive_layout
			 * add field archive_layout_post_title
			 */
			$dv_field[] = array(
				'type'		=> 'switch',
				'settings'	=> 'layout_post_title',
				'label'		=> __( 'Uppercase Title', 'kitring' ),
				'default'	=> 'off',
				'choices'	=> array(
					'on'  => __( 'On', 'kitring' ),
					'off' => __( 'Off', 'kitring' )
				),
				'description' => __( 'To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section archive_layout
			 * add field archive_layout_pagination
			 */
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'layout_pagination',
				'label'       => __( 'Pagination', 'kitring' ),
				'default'     => 'prev_next',
				'choices'     => array(
					'number'	=> __( 'Number', 'kitring' ),
					'prev_next'	=> __( 'Prev Next', 'kitring' ),
				),
				'description' => __( 'To view the changes, go to your blog pages manually', 'kitring' ),
			);
			
			$dv_field[] = array(
				'type'        => 'sortable',
				'settings'    => 'post_meta',
				'label'       => esc_html__( 'Post Meta', 'kitring' ),
				'description' => esc_html__('Display and sort post meta', 'kitring' ),
				'multiple'    => 999,
				'default'	  => array(
					'date',
					'categories',
					'comment'
				),
				'choices'     => array(
					'categories'	=> __( 'Categories', 'kitring' ),
					'date'			=> __( 'Date', 'kitring' ),
					'comment'		=> __( 'Comment', 'kitring' ),
					'author'		=> __( 'Author', 'kitring' ),
				),
			);
			
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'button_style',
				'label'       => __( 'Button Style', 'kitring' ),
				'default'     => 'uk-button-default',
				'choices'     => array(
					'uk-button-default'		=> __( 'Default', 'kitring' ),
					'uk-button-primary'		=> __( 'Primary', 'kitring' ),
					'uk-button-secondary'	=> __( 'Secondary', 'kitring' ),
					'uk-button-danger'		=> __( 'Danger', 'kitring' ),
					'uk-button-text'		=> __( 'Text', 'kitring' ),
					'uk-button-link'		=> __( 'Link', 'kitring' ),
				),
				'description' => __( 'To view the changes, go to your blog pages manually', 'kitring' ),
			);
			
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'button_size',
				'label'       => __( 'Button Size', 'kitring' ),
				'default'     => '',
				'choices'     => array(
					''						=> __( 'Default', 'kitring' ),
					'uk-button-small'		=> __( 'Small', 'kitring' ),
					'uk-button-large'		=> __( 'Large', 'kitring' ),
				),
				'description' => __( 'To view the changes, go to your blog pages manually', 'kitring' ),
			);

			return $dv_field;

		}

	}

}