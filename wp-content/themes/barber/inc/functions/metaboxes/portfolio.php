<?php
function apr_show_gallery_page_meta_option() {
    $meta_box = apr_default_meta_data();
    $meta_box['single_gallery_layout'] = array(
        'name'  => 'single_gallery_style',
        'type' => 'select',
        'title' => esc_html__('Single gallery layout', 'barber'),
        'options' => array(
            "default" => esc_html__("Default","barber"),
                    "1" => esc_html__("Wide","barber"),
                    "2" => esc_html__("Slider","barber"),
                    "3" => esc_html__("Side Information","barber"),
                ),
        'default' => 'default' 
    );
    apr_show_meta_box($meta_box);
}
function apr_save_gallery_page_meta_option($post_id) {
    $meta_box = apr_default_meta_data();
    $meta_box['single_gallery_layout'] = array(
        'name'  => 'single_gallery_style',
        'type' => 'select',
        'title' => esc_html__('Single gallery layout', 'barber'),
        'options' => array(
            "default" => esc_html__("Default","barber"),
                "1" => esc_html__("Wide","barber"),
                "2" => esc_html__("Slider","barber"),
                "3" => esc_html__("Side Information","barber"),
            ),
        'default' => 'default' 
    );    
    return apr_save_meta_data($post_id, $meta_box);
}
function apr_add_gallery_metaboxes() {
    if (function_exists('add_meta_box')) {
        add_meta_box('view-meta-boxes', esc_html__('Layout Options', 'barber'), 'apr_show_gallery_page_meta_option', 'gallery', 'side', 'low');
    }
}

add_action('add_meta_boxes', 'apr_add_gallery_metaboxes');
add_action('save_post', 'apr_save_gallery_page_meta_option');
function apr_add_categorymeta_gallery_table() {
// Create Gallery Cat Meta
global $wpdb;
$type = 'gallery_cat';
$table_name = $wpdb->prefix . $type . 'meta';
$variable_name = $type . 'meta';
$wpdb->$variable_name = $table_name;

// Create Gallery Cat Meta Table
apr_create_metadata_table($table_name, $type);
}
add_action( 'init', 'apr_add_categorymeta_gallery_table' );
//Taxonomy
function apr_default_gallery_tax_meta_data() {
    $apr_layout = apr_layouts();
    $apr_sidebar_position = apr_sidebar_position();
    $apr_sidebars = apr_sidebars();   
    $apr_header_layout = apr_header_types();
    $apr_footer_layout = apr_footer_types(); 
    $gallery_style= apr_page_gallery_layouts();
    $gallery_style['default'] ='Default';
    $gallery_cols = apr_gallery_columns();
    $gallery_cols['default'] ='Default';
    $apr_style = apr_gallery_style();
    $apr_style['default'] ='Default';
    return array(
                // layout
        'layout' => array(
            'name' => 'layout',
            'title' => esc_html__('Layout', 'barber'),
            'type' => 'select',
            'options' => $apr_layout,
            'default' => 'default'
        ),
        'left-sidebar' => array(
            'name' => 'left-sidebar',
            'type' => 'select',
            'title' => esc_html__('Left Sidebar', 'barber'),
            'options' => $apr_sidebars,
            'default' => 'default'
        ),
        'right-sidebar' => array(
            'name' => 'right-sidebar',
            'type' => 'select',
            'title' => esc_html__('Right Sidebar', 'barber'),
            'options' => $apr_sidebars,
            'default' => 'default'
        ),    
        'gallery_filter' => array(
            'name'  => 'gallery_filter',
            'type'  => 'select',
            'title' => esc_html__('Gallery filter','barber'),
            'options'   => array(
                'default' => esc_html__('Default','barber'),
                '1' => esc_html__('Yes','barber'),
                '2' => esc_html__('No','barber'),
                ),
            'default' => 'default',
        ),
        'gallery-style-version' => array(
            'name' => 'gallery-style-version',
            'type' => 'select',
            'title' => esc_html__('Gallery Layouts', 'barber'),
            'options' => $gallery_style,
            'default' => 'default'
        ),
        'gallery-loadmore-style' => array(
            'name'  => 'gallery-loadmore-style',
            'type'  => 'select',
            'title' => esc_html__('Gallery loadmore style','barber'),
            'options'   => array(
                                'default' => esc_html__('Default','barber'),
                                '1' => esc_html__('Button style 1','barber'),
                                '2' => esc_html__('Button style 2','barber'),
                                ),
            'default' => 'default',
        ),
        'gallery-cols' => array(
            'name' => 'gallery-cols',
            'type' => 'select',
            'title' => esc_html__('Gallery columns', 'barber'),
            'options' => $gallery_cols,
            'default' => 'default'
        ), 
        'gallery-style' => array(
            'name'  => 'gallery-style',
            'type'  => 'select',
            'title' => esc_html__('Gallery Style','barber'),
            'options'   => $apr_style,
            'default' => 'default',
        ),
         'gallery-space' => array(
            'name'  => 'gallery-space',
            'type'  => 'select',
            'title' => esc_html__('Remove Space Items','barber'),
            'options'   => array(
                'default' => esc_html__('Default','barber'),
                '1' => esc_html__('Yes','barber'),
                '2' => esc_html__('No','barber'),
                ),
            'default' => 'default',
        ),
        'gallery_per_page' => array(
            'name' => 'gallery_per_page',
            'type' => 'number',
            'title' => esc_html__('Post show per page', 'barber'),
            'default' => 'default',
        ),                
    );
}

add_action( 'gallery_cat_add_form_fields', 'apr_add_gallery_cat', 10, 2);
function apr_add_gallery_cat() {
    $gallery_cat_meta_boxes = apr_default_gallery_tax_meta_data();

    apr_show_tax_add_meta_boxes($gallery_cat_meta_boxes);
}

add_action( 'gallery_cat_edit_form_fields', 'apr_edit_gallery_cat', 10, 2);
function apr_edit_gallery_cat($tag, $taxonomy) {
    $gallery_cat_meta_boxes = apr_default_gallery_tax_meta_data();

    apr_show_tax_edit_meta_boxes($tag, $taxonomy, $gallery_cat_meta_boxes);
}

add_action( 'created_term', 'apr_save_gallery_cat', 10,3 );
add_action( 'edit_term', 'apr_save_gallery_cat', 10,3 );

function apr_save_gallery_cat($term_id, $tt_id, $taxonomy) {
    if (!$term_id) return;
    
    $gallery_cat_meta_boxes = apr_default_gallery_tax_meta_data();
    return apr_save_taxdata( $term_id, $tt_id, $taxonomy, $gallery_cat_meta_boxes );
}