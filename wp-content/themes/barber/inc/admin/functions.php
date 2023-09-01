<?php

if (!class_exists('ReduxFramework') && file_exists(APR_ADMIN . '/ReduxCore/framework.php')) {
    require_once( APR_ADMIN . '/ReduxCore/framework.php' );
}

require_once( APR_ADMIN . '/settings/settings.php' );
require_once( APR_ADMIN . '/settings/save_settings.php' );

function apr_check_theme_options() {
    // check default options
    global $apr_settings;
    if(!get_option('apr_settings')) {
        ob_start();
        //include(APR_PLUGINS . '/theme_options.php');
        $options = ob_get_clean();
        $apr_default_settings = json_decode($options, true);
        if (is_array($apr_default_settings) || is_object($apr_default_settings))
        {
            foreach ($apr_default_settings as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $key1 => $value1) {
                        if (!isset($apr_settings[$key][$key1]) || !$apr_settings[$key][$key1]) {
                            $apr_settings[$key][$key1] = $apr_default_settings[$key][$key1];
                        }
                    }
                } else {
                    if (!isset($apr_settings[$key])) {
                        $apr_settings[$key] = $apr_default_settings[$key];
                    }
                }
            }
        }
    }

    return $apr_settings;
}

if(!class_exists('ReduxFramework')) {
    apr_check_theme_options();
}
//get theme layout options
function apr_layouts() {
    return array(
        'default' => esc_html__('Default Layout', 'barber'),
        'wide' => esc_html__('Wide', 'barber'),
        'fullwidth' => esc_html__('Full width', 'barber'),
        'boxed' => esc_html__('Boxed', 'barber'),
    );
}
//get theme sidebar position options
function apr_sidebar_position() {
    return array(
        'default' => esc_html__('Default Position', 'barber'),
        'left-sidebar' => esc_html__('Left', 'barber'),
        'right-sidebar' => esc_html__('Right', 'barber'),
        'none' => esc_html__('None', 'barber')
    );
}
function apr_rev_sliders_in_array(){
    if (class_exists('RevSlider')) {
        $theslider     = new RevSlider();
        $arrSliders = $theslider->getArrSliders();
        $arrA     = array();
        $arrT     = array();
        foreach($arrSliders as $slider){
            $arrA[]     = $slider->getAlias();
            $arrT[]     = $slider->getTitle();
        }
        if($arrA && $arrT){
            $result = array_combine($arrA, $arrT);
        }
        else
        {
            $result = false;
        }
        return $result;
    }
}
//Apr popup
function apr_popup_layouts() {
    return array(
        'default' => esc_html__('Default Popup', 'barber'),
        '1' => esc_html__("Popup ", 'barber'),
    );
}
function apr_header_types() {
    return array(
        'default' => esc_html__('Default Header', 'barber'),
        '1' => esc_html__('Header Type 1', 'barber'),
        '2' => esc_html__('Header Type 2', 'barber'),
        '3' => esc_html__('Header Type 3', 'barber'),
        '4' => esc_html__('Header Type 4', 'barber'),
        '5' => esc_html__('Header Type 5', 'barber'),
        '6' => esc_html__('Header Type 6', 'barber'),
        '7' => esc_html__('Header Type 7', 'barber'),
        '8' => esc_html__('Header Type 8', 'barber'),
        '9' => esc_html__('Header Type 9', 'barber'),
        '10' => esc_html__('Header Type 10', 'barber'),
    );
}
function apr_seclect_slider(){
    $block_options = array();
    $args = array(
        'numberposts'       => -1,
        'post_type'         => 'block',
        'post_status'       => 'publish',
    );
    $posts = get_posts($args);
    foreach( $posts as $_post ){
        $block_options[$_post->ID] = $_post->post_title;

    }
    return $block_options;
}
function apr_header_positions() {
    return array(
        'default' => esc_html__('Default Position', 'barber'),
        '1' => esc_html__('Top', 'barber'),
        '2' => esc_html__('Bottom', 'barber'),
    );
}
function apr_preload_types() {
    return array(
        'default' => esc_html__('Default Preload', 'barber'),
        '1' => esc_html__('Preload Type 1', 'barber'),
        '2' => esc_html__('Preload Type 2', 'barber'),
        '3' => esc_html__('Preload Type 3', 'barber'),
        '4' => esc_html__('Preload Type 4', 'barber'),
        '5' => esc_html__('Preload Type 5', 'barber'),
        '6' => esc_html__('Preload Type 6', 'barber'),
        '7' => esc_html__('Preload Type 7', 'barber'),
        '8' => esc_html__('Preload Type 8', 'barber'),
        '9' => esc_html__('Preload Type 9', 'barber'),
    );
}
function apr_list_menu(){
    $menus = get_terms('nav_menu');
    $menu_list =array();
    foreach($menus as $menu){
      $menu_list[$menu->term_id] =  $menu->name . "";
    } 
    return $menu_list;
}
function apr_footer_types() {
    return array(
        'default' => esc_html__('Default Footer', 'barber'),
        '1' => esc_html__('Footer Type 1', 'barber'),
        '2' => esc_html__('Footer Type 2', 'barber'),
        '3' => esc_html__('Footer Type 3', 'barber'),
        '4' => esc_html__('Footer Type 4', 'barber'),
        '5' => esc_html__('Footer Type 5', 'barber'),
        '6' => esc_html__('Footer Type 6', 'barber'),
        '7' => esc_html__('Footer Type 7', 'barber'),
        '8' => esc_html__('Footer Type 8', 'barber'),
        '9' => esc_html__('Footer Type 9', 'barber'),
        '10' => esc_html__('Footer Type 10', 'barber'),
    );
}
function apr_page_blog_layouts(){
    return array(
        "grid" => esc_html__("Grid", 'barber'),
        "list" => esc_html__("List", 'barber'),
        "masonry" => esc_html__("Masonry", 'barber'),
    );
}
function apr_blog_list_style(){
    return array(
        "list_s1" => esc_html__("Standard", 'barber'),
        "list_s2" => esc_html__("Style 2", 'barber'),
        "list_s3" => esc_html__("Style 3", 'barber'),
    );
}
function apr_page_single_blog_layouts(){
    return array(
        "single-1" => esc_html__("Single 1", 'barber'),
        "single-2" => esc_html__("Single 2", 'barber'),
        "single-3" => esc_html__("Single 3", 'barber'),
        "single-4" => esc_html__("Single 4", 'barber'),
    );
}
function apr_page_blog_columns(){
    return array(
        "3" => esc_html__("3 Columns", 'barber'),
		"1" => esc_html__("1 Column", 'barber'),
        "2" => esc_html__("2 Columns", 'barber'),
        "4" => esc_html__("4 Columns", 'barber'),
    );
}
function apr_get_breadcrumbs_type(){
    return array(
        "type-1" => esc_html__("Type 1", 'barber'),
        "type-2" => esc_html__("Type 2", 'barber'),
        "type-3" => esc_html__("Type 3", 'barber'),
    );
}
function apr_get_align(){
    return array(
        "left" => esc_html__("Left", 'efarm'),
		"center" => esc_html__("Center", 'efarm'),
        "right" => esc_html__("Right", 'efarm'),
    );
}
function apr_product_columns() {
    return array(
		"5" => esc_html__("5", 'barber'),
		"4" => esc_html__("4", 'barber'),
		"3" => esc_html__("3", 'barber'),
		"2" => esc_html__("2", 'barber'),
		"1" => esc_html__("1", 'barber'), 
    );
}
function apr_product_type() {
    return array(
        "only-grid" => esc_html__("Grid", 'barber'),
        "only-list" => esc_html__("List", 'barber'),
        //"grid-default" => esc_html__("Grid (default) / List", 'barber'),
        //"list-default" => esc_html__("List (default) / Grid", 'barber'),
    );
}
function apr_blog_columns() {
    return array(
        "2" => esc_html__("2", 'barber'),
        "3" => esc_html__("3", 'barber'),
        "4" => esc_html__("4", 'barber'),
    );
}
function apr_gallery_columns() {
    return array(
        "3" => esc_html__("3", 'barber'),
        "2" => esc_html__("2", 'barber'),
        "4" => esc_html__("4", 'barber'),
        "5" => esc_html__("5", 'barber'),
    );
}
function apr_page_gallery_layouts(){
    return array(
        "1" => esc_html__("Grid", 'barber'),
        "2" => esc_html__("Masonry", 'barber'),
    );
}
function apr_gallery_style(){
    return array(
        "style1" => esc_html__("Style 1", 'barber'),
        "style2" => esc_html__("Style 2", 'barber'),
    );
}
function apr_pagination_types(){
    return array(
        "pagination" => esc_html__("Pagination", 'barber'),
        "loadmore" => esc_html__("Loadmore", 'barber'),
    );
}
function apr_get_block_name(){
    $block_options = array();
    $args = array(
        'numberposts'       => -1,
        'post_type'         => 'block',
        'post_status'       => 'publish',
    );
    $posts = get_posts($args);
    foreach( $posts as $_post ){
        $block_options[$_post->ID] = $_post->post_title;

    }
    return $block_options;
}