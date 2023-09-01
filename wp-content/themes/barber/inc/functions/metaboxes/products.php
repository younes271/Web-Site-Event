<?php
function apr_product_meta_data(){
    return array(
        // Custom Tab Title
        "custom_tab_title" => array(
            "name" => "custom_tab_title",
            "title" => esc_html__("Custom Tab Title", 'barber'),
            "desc" => esc_html__("Input the custom tab title.", 'barber'),
            "type" => "textfield"
        ),
        // Content Tab Content
        "custom_tab_content" => array(
            "name" => "custom_tab_content",
            "title" => esc_html__("Custom Tab Content", 'barber'),
            "desc" => esc_html__("Input the custom tab content.", 'barber'),
            "type" => "editor"
        )
    );
}

function apr_show_product_tab_meta_option() {
    $meta_box = apr_product_meta_data();
    apr_show_meta_box($meta_box);
}

function apr_save_product_tab_meta_option($post_id) {
    $meta_box = apr_product_meta_data();
    return apr_save_meta_data($post_id, $meta_box);
}

function apr_add_product_tab_metaboxes() {
    if (function_exists('add_meta_box')) {
        add_meta_box('view-meta-boxes', esc_html__('Custom Tab', 'barber'), 'apr_show_product_tab_meta_option', 'product', 'normal', 'low');
    }
}

add_action('add_meta_boxes', 'apr_add_product_tab_metaboxes');
add_action('save_post', 'apr_save_product_tab_meta_option');
function apr_product_sidebar_option(){
    $apr_sidebar_position = apr_sidebar_position();
    $apr_sidebars = apr_sidebars();
    $apr_header_layout = apr_header_types();
    $apr_footer_layout = apr_footer_types();
    $apr_layout = apr_layouts();
    return array(
        'header' => array(
            'name' => 'header',
            'title' => esc_html__('Header Layout', 'barber'),
            'type' => 'select',
            'options' => $apr_header_layout,
            'default' => 'default'
        ),
        //footer
        'footer' => array(
            'name' => 'footer',
            'title' => esc_html__('Footer Layout', 'barber'),
            'type' => 'select',
            'options' => $apr_footer_layout,
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
        // layout
        'layout' => array(
            'name' => 'layout',
            'title' => esc_html__('Layout', 'barber'),
            'type' => 'select',
            'options' => $apr_layout,
            'default' => 'default'
        ),
		'related_col' => array(
            'name'  => 'related_col',
            'type' => 'select',
            'title' => esc_html__('Related product columns', 'barber'),
            'options' => array(
                "default" => esc_html__("Default","barber"),
                "2" => esc_html__("2","barber"),
                "3" => esc_html__("3","barber"),
                "4" => esc_html__("4","barber"),
            ),
            'default' => 'default'            
        ),
    );
}
function apr_show_product_default_meta_option() {
    $meta_box = apr_product_sidebar_option();
    apr_show_meta_box($meta_box);
}


function apr_save_product_meta_option($post_id) {
    $meta_box = apr_product_sidebar_option();
    return apr_save_meta_data($post_id, $meta_box);
}

function apr_add_product_metaboxes() {
    if (function_exists('add_meta_box')) {
        add_meta_box('show-meta-boxes', esc_html__('Sidebar Options', 'barber'), 'apr_show_product_default_meta_option', 'product', 'side', 'low');
    }
}

add_action('add_meta_boxes', 'apr_add_product_metaboxes');
add_action('save_post', 'apr_save_product_meta_option');
function apr_add_categorymeta_product_table() {
// Create Product Cat Meta
global $wpdb;
$type = 'product_cat';
$table_name = $wpdb->prefix . $type . 'meta';
$variable_name = $type . 'meta';
$wpdb->$variable_name = $table_name;

// Create Product Cat Meta Table
apr_create_metadata_table($table_name, $type);
}
add_action( 'init', 'apr_add_categorymeta_product_table' );
//Taxonomy
function apr_default_product_tax_meta_data() {
    $apr_sidebar_position = apr_sidebar_position();
    $apr_sidebars = apr_sidebars();   
    $apr_list_mode = apr_product_type();
    $apr_header_layout = apr_header_types();
    $apr_footer_layout = apr_footer_types(); 
    return array(
        // Breadcrumbs
        'breadcrumbs' => array(
            'name' => 'breadcrumbs',
            'title' => esc_html__('Breadcrumbs', 'barber'),
            'desc' => esc_html__('Hide breadcrumbs', 'barber'),
            'type' => 'checkbox'
        ),
        'page_title' => array(
            'name' => 'page_title',
            'title' => esc_html__('Page Title', 'barber'),
            'desc' => esc_html__('Hide Page Title', 'barber'),
            'type' => 'checkbox'
        ),
        'show_header' => array(
            'name' => 'show_header',
            'title' => esc_html__('Header', 'barber'),
            'desc' => esc_html__('Hide header', 'barber'),
            'type' => 'checkbox'
        ),
        //  Show Footer
        'show_footer' => array(
            'name' => 'show_footer',
            'title' => esc_html__('Footer', 'barber'),
            'desc' => esc_html__('Hide footer', 'barber'),
            'type' => 'checkbox'
        ),
        //sidebar position
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
		'category-item-count' => array(
			'name' => 'category-item-count',
			'type' => 'text',
			'title' => esc_html__('Products per Page', 'barber'),
			'default' => ''
		),
        'list_mode_product' => array(
            'name' => 'list_mode_product',
            'type' => 'select',
            'title' => esc_html__('List mode', 'barber'),
            'options' => $apr_list_mode,
            'default' => 'only-grid'
        ),
        'category_cols' => array(
            'name' => 'category_cols',
            'type' => 'select',
            'title' => esc_html__('Number of grid column', 'barber'),
            'options' =>  
                    array(
                    "3" => esc_html__("3 columns", 'barber'),
                    "1" => esc_html__("1 columns", 'barber'),
                    "2" => esc_html__("2 columns", 'barber'),
                    "4" => esc_html__("4 columns", 'barber'),
                    "5" => esc_html__("5 columns", 'barber'),
                    "column-default" => esc_html__("Default", 'barber'),
                    ),
            'default' => 'column-default'
        ),
    );
}

add_action( 'product_cat_add_form_fields', 'apr_add_product_cat', 10, 2);
function apr_add_product_cat() {
    $product_cat_meta_boxes = apr_default_product_tax_meta_data();

    apr_show_tax_add_meta_boxes($product_cat_meta_boxes);
}

add_action( 'product_cat_edit_form_fields', 'apr_edit_product_cat', 10, 2);
function apr_edit_product_cat($tag, $taxonomy) {
    $product_cat_meta_boxes = apr_default_product_tax_meta_data();

    apr_show_tax_edit_meta_boxes($tag, $taxonomy, $product_cat_meta_boxes);
}

add_action( 'created_term', 'apr_save_product_cat', 10,3 );
add_action( 'edit_term', 'apr_save_product_cat', 10,3 );

function apr_save_product_cat($term_id, $tt_id, $taxonomy) {
    if (!$term_id) return;
    
    $product_cat_meta_boxes = apr_default_product_tax_meta_data();
    return apr_save_taxdata( $term_id, $tt_id, $taxonomy, $product_cat_meta_boxes );
}