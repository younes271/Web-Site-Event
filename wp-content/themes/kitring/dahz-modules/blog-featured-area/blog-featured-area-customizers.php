<?php

if ( !class_exists( 'Dahz_Framework_Modules_Blog_Featured_Area_Customizer' ) ) {
	Class Dahz_Framework_Modules_Blog_Featured_Area_Customizer extends Dahz_Framework_Customizer_Extend {
		public function dahz_framework_set_customizer() {
			$dv_field = array();

			$img_url = get_template_directory_uri() . '/assets/images/customizer/blog/';

			/**
			 * section featured_area
			 * add field featured_area_enable
			 */
			$dv_field[] = array(
				'type'     => 'switch',
				'settings' => 'enable',
				'label'    => __( 'Enable Featured Area', 'kitring' ),
				'default'  => 'off',
				'priority' => 10,
				'choices'  => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' ),
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section featured_area
			 * add field featured_area_layout
			 */
			$dv_field[] = array(
				'type'     => 'radio-image',
				'settings' => 'layout',
				'label'    => __( 'Layout', 'kitring' ),
				'default'  => 'featured-1',
				'choices'  => array(
					'featured-1' => $img_url . 'df_featured-1.svg',
					'featured-2' => $img_url . 'df_featured-2.svg',
					'featured-3' => $img_url . 'df_featured-3.svg',
					'featured-4' => $img_url . 'df_featured-4.svg',
					'featured-5' => $img_url . 'df_featured-5.svg',
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'     => 'select',
				'settings' => 'source',
				'label'    => __( 'Featured Area Source', 'kitring' ),
				'default'  => 'recent_post',
				'choices'  => array(
					'recent_post'	=> __( 'Recent Post', 'kitring' ),
					'category_post'	=> __( 'By Category', 'kitring' ),
					'post_ids'		=> __( 'Post ID', 'kitring' )
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section featured_area
			 * add field featured_area_category_slug
			 */
			$dv_field[] =  array(
				'type'        => 'select',
				'settings'    => 'category_slug',
				'label'       => __( 'Category Slug', 'kitring' ),
				'default'     => '',
				'multiple'    => 10,
				'choices'     => Kirki_Helper::get_terms( array( 'taxonomy' => 'category' ) ),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
				'active_callback'	=> array(
					array(
						'setting'	=> 'blog_featured_area_source',
						'operator'	=> '==',
						'value'		=> 'category_post',
					)
				),
			);

			/**
			 * section featured_area
			 * add field featured_area_category_slug
			 */
			$dv_field[] =  array(
				'type'        => 'text',
				'settings'    => 'post_ids',
				'label'       => __( 'Post Ids', 'kitring' ),
				'default'     => '',
				'description' => __('Input multiple post ids with coma separator eg: 1,2,3', 'kitring' ),
				'active_callback'	=> array(
					array(
						'setting'	=> 'blog_featured_area_source',
						'operator'	=> '==',
						'value'		=> 'post_ids',
					)
				),
			);

			/**
			 * section featured_area
			 * add field featured_area_total_post
			 */
			$dv_field[] = array(
				'type'        => 'text',
				'settings'    => 'total_post',
				'label'       => __( 'Total Post', 'kitring' ),
				'default'     => '8',
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
				'active_callback'	=> array(
					array(
						'setting'	=> 'blog_featured_area_source',
						'operator'	=> '!==',
						'value'		=> 'post_ids',
					)
				),
			);

			$dv_field[] = array(
				'type'     => 'select',
				'settings' => 'height',
				'label'    => __( 'Height', 'kitring' ),
				'default'  => 'viewport_minus_section',
				'choices'  => array(
					'viewport_minus_section'=> __( 'Viewport ( minus the following section )', 'kitring' ),
					'viewport'				=> __( 'Viewport', 'kitring' ),
					'viewport_minus_20'		=> __( 'Viewport ( minus 20% )', 'kitring' )
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			$dv_field[] = array(
				'type'     => 'dimension',
				'settings' => 'min_height',
				'label'    => __( 'Minimum Height (px)', 'kitring' ),
				'choices'  => array(
					'viewport_minus_section'=> __( 'Viewport ( minus the following section )', 'kitring' ),
					'viewport'				=> __( 'Viewport', 'kitring' ),
					'viewport_minus_20'		=> __( 'Viewport ( minus 20% )', 'kitring' )
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section featured_area
			 * add field featured _area_post_title
			 */
			$dv_field[] = array(
				'type'     => 'switch',
				'settings' => 'enable_uppercase_post_title',
				'label'    => __( 'Uppercase Title', 'kitring' ),
				'default'  => 'off',
				'choices'  => array(
					'on'  => __( 'On', 'kitring' ),
					'off' => __( 'Off', 'kitring' )
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);
			
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'heading',
				'label'       => esc_html__( 'Title Style', 'kitring' ),
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

			/**
			 * section featured_area
			 * add field featured_area_enable_auto_play
			 */
			$dv_field[] = array(
				'type'     => 'switch',
				'settings' => 'enable_auto_play',
				'label'    => __( 'Enable Auto Play', 'kitring' ),
				'default'  => 'on',
				'priority' => 10,
				'choices'  => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' ),
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);


			return $dv_field;
		}
	}
}