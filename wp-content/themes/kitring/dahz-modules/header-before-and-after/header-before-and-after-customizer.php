<?php
if( !class_exists( 'Dahz_Framework_Header_Before_And_After_Customizer' ) ){

	Class Dahz_Framework_Header_Before_And_After_Customizer extends Dahz_Framework_Customizer_Extend {

		public function dahz_framework_set_customizer(){
			
			$transport = array(
				'selector' 		  => '#de-site-header',
				'render_callback' => 'dahz_framework_get_header'
			);

			$dv_field = array();

			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'before_header',
				'label'       => esc_html__( 'Before Header Content Block', 'kitring' ),
				'description' => esc_html__('Display a custom area before header area. You can use custom content block to display globally', 'kitring' ),
				'default'     => '',
				'priority'    => 11,
				'multiple'    => 1,
				'choices'     => dahz_framework_get_content_block(),
				'partial_refresh' => array(
					'before_and_after_header_before_header' => $transport
				)
			);

			$dv_field[] = array(
				'type'        => 'select',
				'settings'    => 'after_header',
				'label'       => esc_html__( 'After Header Content Block', 'kitring' ),
				'description' => esc_html__('Display a custom area after header area. You can use custom content block to display globally', 'kitring' ),
				'default'     => '',
				'priority'    => 11,
				'multiple'    => 1,
				'choices'     => dahz_framework_get_content_block(),
				'partial_refresh' => array(
					'before_and_after_header_after_header' => $transport
				)
			);

			return $dv_field;

		}

	}

}