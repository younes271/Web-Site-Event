<?php
if( !class_exists( 'Dahz_Framework_Footer_Before_And_After_Customizer' ) ){

	Class Dahz_Framework_Footer_Before_And_After_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer(){

			$dv_field = array();

			$transport = array(
				'selector' 		  => '#de-site-footer',
				'render_callback' => 'dahz_framework_get_footer'
			);
			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'before_footer',
				'label'       => esc_html__( 'Before Footer Content Block', 'kitring' ),
				'description' => esc_html__('Display a custom area before footer area. You can use custom content block to display globally', 'kitring' ),
				'default'     => '',
				'priority'    => 11,
				'multiple'    => 1,
				'choices'     => dahz_framework_get_content_block(),
				'partial_refresh' => array(
					'before_and_after_footer_before_footer' => $transport
				)
			);

			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'after_footer',
				'label'       => esc_html__( 'After Footer Content Block', 'kitring' ),
				'description' => esc_html__('Display a custom area after footer area. You can use custom content block to display globally', 'kitring' ),
				'default'     => '',
				'priority'    => 11,
				'multiple'    => 1,
				'choices'     => dahz_framework_get_content_block(),
				'partial_refresh' => array(
					'before_and_after_footer_after_footer' => $transport
				)
			);

			return $dv_field;

		}

	}

}