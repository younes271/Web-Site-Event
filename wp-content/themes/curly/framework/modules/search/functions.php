<?php

if (!function_exists('curly_mkdf_include_search_types_before_load')) {
    /**
     * Load's all header types before load files by going through all folders that are placed directly in header types folder.
     * Functions from this files before-load are used to set all hooks and variables before global options map are init
     */
    function curly_mkdf_include_search_types_before_load() {
        foreach (glob(MIKADO_FRAMEWORK_SEARCH_ROOT_DIR . '/types/*/before-load.php') as $module_load) {
            include_once $module_load;
        }
    }

    add_action('curly_mkdf_options_map', 'curly_mkdf_include_search_types_before_load', 1); // 1 is set to just be before header option map init
}

if (!function_exists('curly_mkdf_load_search')) {
    function curly_mkdf_load_search() {
        $search_type_meta = curly_mkdf_options()->getOptionValue('search_type');
        $search_type = !empty($search_type_meta) ? $search_type_meta : 'covers-header';

        if (curly_mkdf_active_widget(false, false, 'mkdf_search_opener')) {
            include_once MIKADO_FRAMEWORK_MODULES_ROOT_DIR . '/search/types/' . $search_type . '/' . $search_type . '.php';
        }
    }

    add_action('init', 'curly_mkdf_load_search');
}

if (!function_exists('curly_mkdf_get_holder_params_search')) {
    /**
     * Function which return holder class and holder inner class for blog pages
     */
    function curly_mkdf_get_holder_params_search() {
        $params_list = array();

        $layout = curly_mkdf_options()->getOptionValue('search_page_layout');
        if ($layout == 'in-grid') {
            $params_list['holder'] = 'mkdf-container';
            $params_list['inner'] = 'mkdf-container-inner clearfix';
        } else {
            $params_list['holder'] = 'mkdf-full-width';
            $params_list['inner'] = 'mkdf-full-width-inner';
        }

        /**
         * Available parameters for holder params
         * -holder
         * -inner
         */
        return apply_filters('curly_mkdf_search_holder_params', $params_list);
    }
}

if (!function_exists('curly_mkdf_get_search_page')) {
    function curly_mkdf_get_search_page() {
        $sidebar_layout = curly_mkdf_sidebar_layout();

        $params = array(
            'sidebar_layout' => $sidebar_layout
        );

        curly_mkdf_get_module_template_part('templates/holder', 'search', '', $params);
    }
}

if (!function_exists('curly_mkdf_get_search_page_layout')) {
    /**
     * Function which create query for blog lists
     */
    function curly_mkdf_get_search_page_layout() {
        global $wp_query;
        $path = apply_filters('curly_mkdf_search_page_path', 'templates/page');
        $type = apply_filters('curly_mkdf_search_page_layout', 'default');
        $module = apply_filters('curly_mkdf_search_page_module', 'search');
        $plugin = apply_filters('curly_mkdf_search_page_plugin_override', false);

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $params = array(
            'type' => $type,
            'query' => $wp_query,
            'paged' => $paged,
            'max_num_pages' => curly_mkdf_get_max_number_of_pages(),
        );

        $params = apply_filters('curly_mkdf_search_page_params', $params);

        curly_mkdf_get_module_template_part($path . '/' . $type, $module, '', $params, $plugin);
    }
}

if (!function_exists('curly_mkdf_get_search_submit_icon_class')) {
    /**
     * Loads search submit icon class
     */
    function curly_mkdf_get_search_submit_icon_class() {

        $search_icon_source = curly_mkdf_options()->getOptionValue('search_icon_source');

        $search_close_icon_class_array = array(
            'mkdf-search-submit'
        );

        $search_close_icon_class_array[] = $search_icon_source == 'icon_pack' ? 'mkdf-search-submit-icon-pack' : 'mkdf-search-submit-svg-path';

        return $search_close_icon_class_array;
    }
}

if (!function_exists('curly_mkdf_get_search_close_icon_class')) {
    /**
     * Loads search close icon class
     */
    function curly_mkdf_get_search_close_icon_class() {

        $search_icon_source = curly_mkdf_options()->getOptionValue('search_icon_source');

        $search_close_icon_class_array = array(
            'mkdf-search-close'
        );

        $search_close_icon_class_array[] = $search_icon_source == 'icon_pack' ? 'mkdf-search-close-icon-pack' : 'mkdf-search-close-svg-path';

        return $search_close_icon_class_array;
    }
}

if (!function_exists('curly_mkdf_get_search_icon_html')) {
    /**
     * Loads search close icon HTML
     */
    function curly_mkdf_get_search_icon_html() {

        $search_icon_source = curly_mkdf_options()->getOptionValue('search_icon_source');
        $search_icon_pack = curly_mkdf_options()->getOptionValue('search_icon_pack');
        $search_icon_svg_path = curly_mkdf_options()->getOptionValue('search_icon_svg_path');

        $search_icon_html = '';

        if (($search_icon_source == 'icon_pack') && isset($search_icon_pack)) {
            $search_icon_html .= curly_mkdf_icon_collections()->getSearchIcon($search_icon_pack, false);
        } else if (isset($search_icon_svg_path)) {
            $search_icon_html .= $search_icon_svg_path;
        }

        return $search_icon_html;
    }
}

if (!function_exists('curly_mkdf_get_search_close_icon_html')) {
    /**
     * Loads search close icon HTML
     */
    function curly_mkdf_get_search_close_icon_html() {

        $search_icon_source = curly_mkdf_options()->getOptionValue('search_icon_source');
        $search_icon_pack = curly_mkdf_options()->getOptionValue('search_icon_pack');
        $search_close_icon_svg_path = curly_mkdf_options()->getOptionValue('search_close_icon_svg_path');

        $search_close_icon_html = '';

        if (($search_icon_source == 'icon_pack') && isset($search_icon_pack)) {
            $search_close_icon_html .= curly_mkdf_icon_collections()->getSearchClose($search_icon_pack, false);
        } else if (isset($search_close_icon_svg_path)) {
            $search_close_icon_html .= $search_close_icon_svg_path;
        }

        return $search_close_icon_html;
    }
}

// Block widget functions
if ( ! function_exists( 'curly_mkdf_override_search_block_templates' ) ) {
    /**
     * Function that override `core/search` block template
     *
     * @see register_block_core_search()
     */
    function curly_mkdf_override_search_block_templates( $atts ) {
        if ( ! empty( $atts ) && isset( $atts['render_callback'] ) && 'render_block_core_search' === $atts['render_callback'] && function_exists( 'styles_for_block_core_search' ) ) {
            $atts['render_callback'] = 'curly_mkdf_render_block_core_search';
        }

        return $atts;
    }

    add_filter( 'block_type_metadata_settings', 'curly_mkdf_override_search_block_templates' );
}


if ( ! function_exists( 'curly_mkdf_render_block_core_search' ) ) {
    /**
     * Function that dynamically renders the `core/search` block
     *
     * @param array $attributes - the block attributes
     *
     * @return string - the search block markup
     *
     * @see render_block_core_search()
     */
    function curly_mkdf_render_block_core_search( $attributes ) {
        static $instance_id = 0;

        $attributes = wp_parse_args(
            $attributes,
            array(
                'label'      => esc_html__( 'Search', 'curly' ),
                'buttonText' => esc_html__( 'Search', 'curly' ),
            )
        );

        $input_id        = 'mkdf-search-form-' . ++ $instance_id;
        $classnames      = classnames_for_block_core_search( $attributes );
        $show_label      = ! empty( $attributes['showLabel'] );
        $use_icon_button = ! empty( $attributes['buttonUseIcon'] );
        $show_input      = ! ( ( ! empty( $attributes['buttonPosition'] ) && 'button-only' === $attributes['buttonPosition'] ) );
        $show_button     = ! ( ( ! empty( $attributes['buttonPosition'] ) && 'no-button' === $attributes['buttonPosition'] ) );
        $input_markup    = '';
        $button_markup   = '';
        $inline_styles   = styles_for_block_core_search( $attributes );
        // function get_color_classes_for_block_core_search doesn't exist in wp 5.8 and below
        $color_classes    = function_exists( 'get_color_classes_for_block_core_search' ) ? get_color_classes_for_block_core_search( $attributes ) : '';
        $is_button_inside = ! empty( $attributes['buttonPosition'] ) && 'button-inside' === $attributes['buttonPosition'];
        // border color classes need to be applied to the elements that have a border color
        // function get_border_color_classes_for_block_core_search doesn't exist in wp 5.8 and below
        $border_color_classes = function_exists( 'get_border_color_classes_for_block_core_search' ) ? get_border_color_classes_for_block_core_search( $attributes ) : '';

        $label_markup = sprintf(
            '<label for="%1$s" class="mkdf-search-form-label screen-reader-text">%2$s</label>',
            $input_id,
            empty( $attributes['label'] ) ? esc_html__( 'Search', 'curly' ) : esc_html( $attributes['label'] )
        );
        if ( $show_label && ! empty( $attributes['label'] ) ) {
            $label_markup = sprintf(
                '<label for="%1$s" class="mkdf-search-form-label">%2$s</label>',
                $input_id,
                esc_html( $attributes['label'] )
            );
        }

        if ( $show_input ) {
            $input_classes = ! $is_button_inside ? $border_color_classes : '';
            $input_markup  = sprintf(
                '<input type="search" id="%s" class="mkdf-search-form-field %s" name="s" value="%s" placeholder="%s" %s required />',
                $input_id,
                esc_attr( $input_classes ),
                esc_attr( get_search_query() ),
                esc_attr( $attributes['placeholder'] ),
                // key input doesn't exist in wp 5.8 and below
                array_key_exists( 'input', $inline_styles ) ? $inline_styles['input'] : ''
            );
        }

        if ( $show_button ) {
            $button_internal_markup = '';
            $button_classes         = $color_classes;
            $button_classes         .= ! empty( $attributes['buttonPosition'] ) ? ' mkdf--' . $attributes['buttonPosition'] : '';

            if ( ! $is_button_inside ) {
                $button_classes .= ' ' . $border_color_classes;
            }
            if ( ! $use_icon_button ) {
                if ( ! empty( $attributes['buttonText'] ) ) {
                    $button_internal_markup = esc_html( $attributes['buttonText'] );
                }
            } else {
                $button_classes         .= ' mkdf--has-icon';
                $button_internal_markup = '<i class="mkdf-icon-font-awesome fa fa-search "></i>';
            }

            $button_markup = sprintf(
                '<button type="submit" class="mkdf-search-form-button %s" %s>%s</button>',
                esc_attr( $button_classes ),
                // key button doesn't exist in wp 5.8 and below
                array_key_exists( 'button', $inline_styles ) ? $inline_styles['button'] : '',
                $button_internal_markup
            );
        }

        $field_markup_classes = $is_button_inside ? $border_color_classes : '';
        $field_markup         = sprintf(
            '<div class="mkdf-search-form-inner %s"%s>%s</div>',
            $field_markup_classes,
            $inline_styles['wrapper'],
            $input_markup . $button_markup
        );
        $classnames           .= ' mkdf-search-form';
        $wrapper_attributes   = get_block_wrapper_attributes( array( 'class' => $classnames ) );

        return sprintf(
            '<form role="search" method="get" %s action="%s">%s</form>',
            $wrapper_attributes,
            esc_url( home_url( '/' ) ),
            $label_markup . $field_markup
        );
    }
}