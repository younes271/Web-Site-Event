<?php
/*
	1. 	class 		: Dahz_Framework_Modules_Typography
		description : portfolio archive customizer

*/

if( !class_exists( 'Dahz_Framework_Modules_Typography') ){

    Class Dahz_Framework_Modules_Typography extends Dahz_Framework_Customizer_Extend {


        public function dahz_framework_set_customizer(){

            $dv_field = array();

            $dv_field[] = array(
                'type'        => 'select',
                'settings'    => 'source_font',
                'label'       => esc_html__( 'Source Font', 'kitring' ),
                'description' => esc_html__('Choose a font source to use, you can use google font or adobe typekit', 'kitring' ),
                'priority'    => 10,
                'default'     => 'google-fonts',
                'choices'     => array(
                    'google-fonts'  => esc_attr__( 'Google Fonts', 'kitring' ),
                    'adobe-typekit' => esc_attr__( 'Adobe Typekit', 'kitring' ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'typekit_id_main',
                'label'       => esc_html__( 'Typekit ID For Main Font', 'kitring' ),
                'description' => esc_html__('Will be used on heading', 'kitring' ),
                'priority'    => 10,
                'active_callback'   => array(
                    array(
                        'setting'   => 'typography_source_font',
                        'operator'  => '==',
                        'value'     => 'adobe-typekit',
                    ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'typekit_font_face_main',
                'label'       => esc_html__( 'Typekit Font Face for Main Font', 'kitring' ),
                'description' => esc_html__('Will be used on heading', 'kitring' ),
                'priority'    => 10,
                'active_callback'   => array(
                    array(
                        'setting'   => 'typography_source_font',
                        'operator'  => '==',
                        'value'     => 'adobe-typekit',
                    ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'typography',
                'settings'    => 'main_font',
                'label'       => esc_html__( 'Main Font', 'kitring' ),
                'description' => esc_html__('Will be used on heading', 'kitring' ),
                'priority'    => 10,
                'default'     => array(
                    'font-family'    => 'Poppins',
                    'variant'        => '600',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'active_callback'   => array(
                    array(
                        'setting'   => 'typography_source_font',
                        'operator'  => '==',
                        'value'     => 'google-fonts',
                    ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'main_font_size',
                'label'       => esc_html__( 'Main Font Size', 'kitring' ),
                'description' => esc_html__('insert your base font to generate size for main font size', 'kitring' ),
                'priority'    => 10,
                'default'     => '16px',
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'main_letter_spacing',
                'label'       => esc_html__( 'Main Font Letter Spacing', 'kitring' ),
                'priority'    => 10,
                'default'     => '1px',
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'typekit_id_secondary',
                'label'       => esc_html__( 'Typekit ID for Secondary Font', 'kitring' ),
                'priority'    => 10,
                'active_callback'   => array(
                    array(
                        'setting'   => 'typography_source_font',
                        'operator'  => '==',
                        'value'     => 'adobe-typekit',
                    ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'typekit_font_face_secondary',
                'label'       => esc_html__( 'Typekit Font Face for Secondary Font', 'kitring' ),
                'priority'    => 10,
                'active_callback'   => array(
                    array(
                        'setting'   => 'typography_source_font',
                        'operator'  => '==',
                        'value'     => 'adobe-typekit',
                    ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'typography',
                'settings'    => 'secondary_font',
                'label'       => esc_html__( 'Secondary Font', 'kitring' ),
                'priority'    => 10,
                'default'     => array(
                    'font-family'    => 'Lato',
                    'variant'        => '400',
                    'subsets'        => array( 'latin-ext' ),
                ),
                'active_callback'   => array(
                    array(
                        'setting'   => 'typography_source_font',
                        'operator'  => '==',
                        'value'     => 'google-fonts',
                    ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'secondary_font_size',
                'label'       => esc_html__( 'Secondary Font Size', 'kitring' ),
                'description' => esc_html__('insert your base font to generate size for main font size', 'kitring' ),
                'priority'    => 10,
                'default'     => '15px',
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'secondary_letter_spacing',
                'label'       => esc_html__( 'Secondary Font Letter Spacing', 'kitring' ),
                'priority'    => 10,
                'default'     => '0',
            );

            $dv_field[] = array(
                'type'        => 'select',
                'settings'    => 'header_element',
                'label'       => esc_html__( 'Header Element and Megamenu Title', 'kitring' ),
                'priority'    => 10,
                'default'     => 'main-font',
                'choices'     => array(
                    'main-font'         => esc_attr__( 'Main Font', 'kitring' ),
                    'secondary-font'    => esc_attr__( 'Secondary Font', 'kitring' ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'select',
                'settings'    => 'dropdown_font',
                'label'       => esc_html__( 'Dropdown Font', 'kitring' ),
                'priority'    => 10,
                'default'     => 'secondary-font',
                'choices'     => array(
                    'main-font'         => esc_attr__( 'Main Font', 'kitring' ),
                    'secondary-font'    => esc_attr__( 'Secondary Font', 'kitring' ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'select',
                'settings'    => 'button_font',
                'label'       => esc_html__( 'Button Font', 'kitring' ),
                'priority'    => 10,
                'default'     => 'main-font',
                'choices'     => array(
                    'main-font'         => esc_attr__( 'Main Font', 'kitring' ),
                    'secondary-font'    => esc_attr__( 'Secondary Font', 'kitring' ),
                ),
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'button_size',
                'label'       => esc_html__( 'Button Font Size', 'kitring' ),
                'priority'    => 10,
                'default'     => '16px',
            );

            $dv_field[] = array(
                'type'        => 'text',
                'settings'    => 'button_letter_spacing',
                'label'       => esc_html__( 'Button Letter Spacing', 'kitring' ),
                'priority'    => 10,
                'default'     => '1px',
            );

            return $dv_field;

        }

    }



}
