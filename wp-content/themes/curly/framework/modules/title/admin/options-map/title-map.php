<?php

if (!function_exists('curly_mkdf_get_title_types_options')) {
    function curly_mkdf_get_title_types_options() {
        $title_type_options = apply_filters('curly_mkdf_title_type_global_option', $title_type_options = array());

        return $title_type_options;
    }
}

if (!function_exists('curly_mkdf_get_title_type_default_options')) {
    function curly_mkdf_get_title_type_default_options() {
        $title_type_option = apply_filters('curly_mkdf_default_title_type_global_option', $title_type_option = '');

        return $title_type_option;
    }
}

foreach (glob(MIKADO_FRAMEWORK_MODULES_ROOT_DIR . '/title/types/*/admin/options-map/*.php') as $options_load) {
    include_once $options_load;
}

if (!function_exists('curly_mkdf_title_options_map')) {
    function curly_mkdf_title_options_map() {
        $title_type_options = curly_mkdf_get_title_types_options();
        $title_type_default_option = curly_mkdf_get_title_type_default_options();

        curly_mkdf_add_admin_page(
            array(
                'slug' => '_title_page',
                'title' => esc_html__('Title', 'curly'),
                'icon' => 'fa fa-list-alt'
            )
        );

        $panel_title = curly_mkdf_add_admin_panel(
            array(
                'page' => '_title_page',
                'name' => 'panel_title',
                'title' => esc_html__('Title Settings', 'curly')
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'show_title_area',
                'type' => 'yesno',
                'default_value' => 'yes',
                'label' => esc_html__('Show Title Area', 'curly'),
                'description' => esc_html__('This option will enable/disable Title Area', 'curly'),
                'parent' => $panel_title
            )
        );

        $show_title_area_container = curly_mkdf_add_admin_container(
            array(
                'parent' => $panel_title,
                'name' => 'show_title_area_container',
                'dependency' => array(
                    'show' => array(
                        'show_title_area' => 'yes'
                    )
                )
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'title_area_type',
                'type' => 'select',
                'default_value' => $title_type_default_option,
                'label' => esc_html__('Title Area Type', 'curly'),
                'description' => esc_html__('Choose title type', 'curly'),
                'parent' => $show_title_area_container,
                'options' => $title_type_options
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'title_area_in_grid',
                'type' => 'yesno',
                'default_value' => 'yes',
                'label' => esc_html__('Title Area In Grid', 'curly'),
                'description' => esc_html__('Set title area content to be in grid', 'curly'),
                'parent' => $show_title_area_container
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'title_area_height',
                'type' => 'text',
                'label' => esc_html__('Height', 'curly'),
                'description' => esc_html__('Set a height for Title Area', 'curly'),
                'parent' => $show_title_area_container,
                'args' => array(
                    'col_width' => 2,
                    'suffix' => 'px'
                )
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'title_area_background_color',
                'type' => 'color',
                'label' => esc_html__('Background Color', 'curly'),
                'description' => esc_html__('Choose a background color for Title Area', 'curly'),
                'parent' => $show_title_area_container
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'title_area_background_image',
                'type' => 'image',
                'label' => esc_html__('Background Image', 'curly'),
                'description' => esc_html__('Choose an Image for Title Area', 'curly'),
                'parent' => $show_title_area_container
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'title_area_background_image_behavior',
                'type' => 'select',
                'default_value' => '',
                'label' => esc_html__('Background Image Behavior', 'curly'),
                'description' => esc_html__('Choose title area background image behavior', 'curly'),
                'parent' => $show_title_area_container,
                'options' => array(
                    '' => esc_html__('Default', 'curly'),
                    'responsive' => esc_html__('Enable Responsive Image', 'curly'),
                    'parallax' => esc_html__('Enable Parallax Image', 'curly'),
                    'parallax-zoom-out' => esc_html__('Enable Parallax With Zoom Out Image', 'curly')
                )
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'title_area_vertical_alignment',
                'type' => 'select',
                'default_value' => 'header-bottom',
                'label' => esc_html__('Vertical Alignment', 'curly'),
                'description' => esc_html__('Specify title vertical alignment', 'curly'),
                'parent' => $show_title_area_container,
                'options' => array(
                    'header-bottom' => esc_html__('From Bottom of Header', 'curly'),
                    'window-top' => esc_html__('From Window Top', 'curly')
                )
            )
        );

        /***************** Additional Title Area Layout - start *****************/

        do_action('curly_mkdf_additional_title_area_options_map', $show_title_area_container);

        /***************** Additional Title Area Layout - end *****************/


        $panel_typography = curly_mkdf_add_admin_panel(
            array(
                'page' => '_title_page',
                'name' => 'panel_title_typography',
                'title' => esc_html__('Typography', 'curly')
            )
        );

        curly_mkdf_add_admin_section_title(
            array(
                'name' => 'type_section_title',
                'title' => esc_html__('Title', 'curly'),
                'parent' => $panel_typography
            )
        );

        $group_page_title_styles = curly_mkdf_add_admin_group(
            array(
                'name' => 'group_page_title_styles',
                'title' => esc_html__('Title', 'curly'),
                'description' => esc_html__('Define styles for page title', 'curly'),
                'parent' => $panel_typography
            )
        );

        $row_page_title_styles_1 = curly_mkdf_add_admin_row(
            array(
                'name' => 'row_page_title_styles_1',
                'parent' => $group_page_title_styles
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'title_area_title_tag',
                'type' => 'selectsimple',
                'default_value' => 'h1',
                'label' => esc_html__('Title Tag', 'curly'),
                'options' => curly_mkdf_get_title_tag(),
                'parent' => $row_page_title_styles_1
            )
        );

        $row_page_title_styles_2 = curly_mkdf_add_admin_row(
            array(
                'name' => 'row_page_title_styles_2',
                'parent' => $group_page_title_styles
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'colorsimple',
                'name' => 'page_title_color',
                'label' => esc_html__('Text Color', 'curly'),
                'parent' => $row_page_title_styles_2
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'textsimple',
                'name' => 'page_title_font_size',
                'default_value' => '',
                'label' => esc_html__('Font Size', 'curly'),
                'parent' => $row_page_title_styles_2,
                'args' => array(
                    'suffix' => 'px'
                )
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'textsimple',
                'name' => 'page_title_line_height',
                'default_value' => '',
                'label' => esc_html__('Line Height', 'curly'),
                'parent' => $row_page_title_styles_2,
                'args' => array(
                    'suffix' => 'px'
                )
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'selectblanksimple',
                'name' => 'page_title_text_transform',
                'default_value' => '',
                'label' => esc_html__('Text Transform', 'curly'),
                'options' => curly_mkdf_get_text_transform_array(),
                'parent' => $row_page_title_styles_2
            )
        );

        $row_page_title_styles_3 = curly_mkdf_add_admin_row(
            array(
                'name' => 'row_page_title_styles_3',
                'parent' => $group_page_title_styles,
                'next' => true
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'fontsimple',
                'name' => 'page_title_google_fonts',
                'default_value' => '-1',
                'label' => esc_html__('Font Family', 'curly'),
                'parent' => $row_page_title_styles_3
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'selectblanksimple',
                'name' => 'page_title_font_style',
                'default_value' => '',
                'label' => esc_html__('Font Style', 'curly'),
                'options' => curly_mkdf_get_font_style_array(),
                'parent' => $row_page_title_styles_3
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'selectblanksimple',
                'name' => 'page_title_font_weight',
                'default_value' => '',
                'label' => esc_html__('Font Weight', 'curly'),
                'options' => curly_mkdf_get_font_weight_array(),
                'parent' => $row_page_title_styles_3
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'textsimple',
                'name' => 'page_title_letter_spacing',
                'default_value' => '',
                'label' => esc_html__('Letter Spacing', 'curly'),
                'parent' => $row_page_title_styles_3,
                'args' => array(
                    'suffix' => 'px'
                )
            )
        );

        curly_mkdf_add_admin_section_title(
            array(
                'name' => 'type_section_subtitle',
                'title' => esc_html__('Subtitle', 'curly'),
                'parent' => $panel_typography
            )
        );

        $group_page_subtitle_styles = curly_mkdf_add_admin_group(
            array(
                'name' => 'group_page_subtitle_styles',
                'title' => esc_html__('Subtitle', 'curly'),
                'description' => esc_html__('Define styles for page subtitle', 'curly'),
                'parent' => $panel_typography
            )
        );

        $row_page_subtitle_styles_1 = curly_mkdf_add_admin_row(
            array(
                'name' => 'row_page_subtitle_styles_1',
                'parent' => $group_page_subtitle_styles
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'name' => 'title_area_subtitle_tag',
                'type' => 'selectsimple',
                'default_value' => 'var',
                'label' => esc_html__('Subtitle Tag', 'curly'),
                'options' => curly_mkdf_get_title_tag(),
                'parent' => $row_page_subtitle_styles_1
            )
        );

        $row_page_subtitle_styles_2 = curly_mkdf_add_admin_row(
            array(
                'name' => 'row_page_subtitle_styles_2',
                'parent' => $group_page_subtitle_styles
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'colorsimple',
                'name' => 'page_subtitle_color',
                'label' => esc_html__('Text Color', 'curly'),
                'parent' => $row_page_subtitle_styles_2
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'textsimple',
                'name' => 'page_subtitle_font_size',
                'default_value' => '',
                'label' => esc_html__('Font Size', 'curly'),
                'parent' => $row_page_subtitle_styles_2,
                'args' => array(
                    'suffix' => 'px'
                )
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'textsimple',
                'name' => 'page_subtitle_line_height',
                'default_value' => '',
                'label' => esc_html__('Line Height', 'curly'),
                'parent' => $row_page_subtitle_styles_2,
                'args' => array(
                    'suffix' => 'px'
                )
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'selectblanksimple',
                'name' => 'page_subtitle_text_transform',
                'default_value' => '',
                'label' => esc_html__('Text Transform', 'curly'),
                'options' => curly_mkdf_get_text_transform_array(),
                'parent' => $row_page_subtitle_styles_2
            )
        );

        $row_page_subtitle_styles_3 = curly_mkdf_add_admin_row(
            array(
                'name' => 'row_page_subtitle_styles_3',
                'parent' => $group_page_subtitle_styles,
                'next' => true
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'fontsimple',
                'name' => 'page_subtitle_google_fonts',
                'default_value' => '-1',
                'label' => esc_html__('Font Family', 'curly'),
                'parent' => $row_page_subtitle_styles_3
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'selectblanksimple',
                'name' => 'page_subtitle_font_style',
                'default_value' => '',
                'label' => esc_html__('Font Style', 'curly'),
                'options' => curly_mkdf_get_font_style_array(),
                'parent' => $row_page_subtitle_styles_3
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'selectblanksimple',
                'name' => 'page_subtitle_font_weight',
                'default_value' => '',
                'label' => esc_html__('Font Weight', 'curly'),
                'options' => curly_mkdf_get_font_weight_array(),
                'parent' => $row_page_subtitle_styles_3
            )
        );

        curly_mkdf_add_admin_field(
            array(
                'type' => 'textsimple',
                'name' => 'page_subtitle_letter_spacing',
                'default_value' => '',
                'label' => esc_html__('Letter Spacing', 'curly'),
                'args' => array(
                    'suffix' => 'px'
                ),
                'parent' => $row_page_subtitle_styles_3
            )
        );

        /***************** Additional Title Typography Layout - start *****************/

        do_action('curly_mkdf_additional_title_typography_options_map', $panel_typography);

        /***************** Additional Title Typography Layout - end *****************/
    }

    add_action('curly_mkdf_options_map', 'curly_mkdf_title_options_map', 6);
}