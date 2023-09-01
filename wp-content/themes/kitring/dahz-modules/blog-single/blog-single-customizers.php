<?php
/*
	1. 	class : Dahz_Framework_Modules_Blog_Single_Customizer
*/
if( !class_exists( 'Dahz_Framework_Modules_Blog_Single_Customizer' ) ){

	Class Dahz_Framework_Modules_Blog_Single_Customizer extends Dahz_Framework_Customizer_Extend{

		public function dahz_framework_set_customizer(){

			$dv_field = array();

			$img_url = get_template_directory_uri() . '/assets/images/customizer/blog/';

			/**
			 * section single_layout
			 * add field single_layout_header_transparency
			 */
			$dv_field[] = array(
				'type'     => 'custom',
				'settings' => "custom_title_blog_single_layout",
				'label'    => '',
				'default'  => '<div class="de-customizer-title">'. esc_html__('Layout', 'kitring' ) .'</div>',
			);

			/**
			 * section single_layout
			 * add field single_layout_sidebar
			 */
			$dv_field[] = array(
				'type'        => 'radio-image',
				'settings'    => 'sidebar',
				'label'       => __( 'Sidebar layout', 'kitring' ),
				'default'     => 'sidebar-right',
				'choices'     => array(
					'fullwidth' 	=> $img_url . 'df_body-full.svg',
					'sidebar-left' 	=> $img_url . 'df_body-left-sidebar.svg',
					'sidebar-right' => $img_url . 'df_body-right-sidebar.svg',
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section single_layout
			 * add field single_post_title_alignment
			 */
			$dv_field[] = array(
				'type'     => 'select',
				'settings' => 'title_alignment',
				'label'    => __( 'Title Alignment', 'kitring' ),
				'default'  => 'prev_next',
				'choices'  => array(
					'left'	=> __( 'Left', 'kitring' ),
					'center'	=> __( 'Center', 'kitring' ),
				),
				'description'	=> __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section single_layout
			 * add field single_post_heading
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
				'type'        => 'sortable',
				'settings'    => 'post_meta',
				'label'       => esc_html__( 'Post Meta', 'kitring' ),
				'description' => esc_html__('Display and sort post meta', 'kitring' ),
				'multiple'    => 999,
				'default'	  => array(
					'date',
					'categories'
				),
				'choices'     => array(
					'categories'	=> __( 'Categories', 'kitring' ),
					'date'			=> __( 'Date', 'kitring' ),
					'comment'		=> __( 'Comment', 'kitring' ),
					'author'		=> __( 'Author', 'kitring' ),
				),
			);

			/**
			 * section single_layout
			 * add field single_layout_post_title
			 */
			$dv_field[] = array(
				'type' 		=> 'switch',
				'settings' 	=> 'enable_uppercase_post_title',
				'label' 	=> __( 'Uppercase Title', 'kitring' ),
				'default' 	=> 'off',
				'choices' 	=> array(
					'on'  => __( 'On', 'kitring' ),
					'off' => __( 'Off', 'kitring' )
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section global
			 * add field enable_dropcap
			 */
			$dv_field[] = array(
				'type'			=> 'switch',
				'settings'		=> 'enable_dropcap',
				'label'			=> __( 'Enable Dropcap', 'kitring' ),
				'description'	=> __( 'This option only available in single post', 'kitring' ),
				'default'		=> 'off',
				'choices'		=> array(
					'on'	=> __( 'On', 'kitring' ),
					'off'	=> __( 'Off', 'kitring' )
				)
			);

			/**
			 * section single_layout
			 * add field single_layout_enable_tags
			 */
			$dv_field[] = array(
				'type'        => 'switch',
				'settings'    => 'enable_tags',
				'label'       => __( 'Display Post Tags', 'kitring' ),
				'default'     => 'on',
				'priority'    => 10,
				'choices'     => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' ),
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section single_layout
			 * add field single_layout_enable_comment_counts
			 */
			$dv_field[] = array(
				'type'        => 'switch',
				'settings'    => 'enable_comment_counts',
				'label'       => __( 'Display Comment Counts', 'kitring' ),
				'default'     => 'on',
				'priority'    => 10,
				'choices'     => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' ),
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section single_layout
			 * add field single_layout_enable_author_box
			 */
			$dv_field[] = array(
				'type'        => 'switch',
				'settings'    => 'enable_author_box',
				'label'       => __( 'Display Author Box', 'kitring' ),
				'default'     => 'on',
				'priority'    => 10,
				'choices'     => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' ),
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section single_layout
			 * add field single_layout_enable_prev_next_button
			 */
			$dv_field[] = array(
				'type'        => 'switch',
				'settings'    => 'enable_prev_next_button',
				'label'       => __( 'Display Prev Next Button', 'kitring' ),
				'default'     => 'on',
				'priority'    => 10,
				'choices'     => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' ),
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			/**
			 * section single_layout
			 * add field single_layout_enable_related_article
			 */
			$dv_field[] = array(
				'type'        => 'switch',
				'settings'    => 'enable_related_article',
				'label'       => __( 'Display Related Article', 'kitring' ),
				'default'     => 'on',
				'priority'    => 10,
				'choices'     => array(
					'on'  => esc_attr__( 'On', 'kitring' ),
					'off' => esc_attr__( 'Off', 'kitring' ),
				),
				'description' => __('To view the changes, go to your blog pages manually', 'kitring' ),
			);

			return $dv_field;

		}

	}

}
