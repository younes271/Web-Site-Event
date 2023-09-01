<?php
function apr_post_meta_data() {
    $apr_page_single_blog_layouts = apr_page_single_blog_layouts();
    $apr_page_single_blog_layouts['default'] ='Default';
    return array( 
        array(
            "name" => "single-post-layout-version",
            'type' => 'select',
            'title' => esc_html__('Single Blog Layout', 'barber'),
            'options' => $apr_page_single_blog_layouts,
            'default' => 'default'
        ),  
        "highlight" => array(
            "name" => "highlight",
            "title" => esc_html__("Short Description", 'barber'),
            "desc" => esc_html__("Content", 'barber'),
            "type" => "editor"
        ),
    );
}
function apr_post_format(){
    return array(
        "video_code" => array(
            "name" => "video_code",
            "title" => esc_html__("Video & Audio Embed Code", 'barber'),
            "desc" => esc_html__('Enter the embed link (Youtube or Vimeo). ', 'barber'),
            "type" => "textarea",
            'display_condition' => 'post-type-video', 
        ),
        "link_code" => array(
            "name" => "link_code",
            "title" => esc_html__("Link", 'barber'),
            "desc" => esc_html__('Enter link. ', 'barber'),
            "type" => "textfield",
            'display_condition' => 'post-type-link', 
        ),
        "link_title" => array(
            "name" => "link_title",
            "title" => esc_html__("Link title", 'barber'),
            "desc" => esc_html__('Enter link title. ', 'barber'),
            "type" => "textfield",
            'display_condition' => 'post-type-link', 
        ),
        "quote_code" => array(
            "name" => "quote_code",
            "title" => esc_html__("Quote", 'barber'),
            "desc" => esc_html__('Enter quote. ', 'barber'),
            "type" => "textarea",
            'display_condition' => 'post-type-quote', 
        ),
        "quote_author" => array(
            "name" => "quote_author",
            "title" => esc_html__("Quote author", 'barber'),
            "desc" => esc_html__('Enter quote author. ', 'barber'),
            "type" => "textfield",
            'display_condition' => 'post-type-quote', 
        ),
    );
}
function apr_view_post_meta_option() {
    $meta_box = apr_post_meta_data();
    apr_show_meta_box($meta_box);
}
function apr_view_post_format_meta_option() {
    $meta_box = apr_post_format();
    apr_show_meta_box($meta_box);
}

function apr_show_post_meta_option() {
    $meta_box = apr_default_meta_data();
    apr_show_meta_box($meta_box);
}
function apr_save_post2_meta_option($post_id) {
    $meta_box_post = apr_post_meta_data();
    $meta_box_format = apr_post_format();
    $meta_box = array_merge($meta_box_post,$meta_box_format); 
    return apr_save_meta_data($post_id, $meta_box);
}
function apr_save_post_meta_option($post_id) {
    $meta_box = apr_default_meta_data();
    return apr_save_meta_data($post_id, $meta_box);
}

function apr_add_post_metaboxes() {
    if (function_exists('add_meta_box')) {
        add_meta_box('view-format-boxes', esc_html__('Post Format', 'barber'), 'apr_view_post_format_meta_option', 'post', 'normal', 'low');        
        add_meta_box('show-meta-boxes', esc_html__('Blog Options', 'barber'), 'apr_view_post_meta_option', 'post', 'normal', 'low');
        add_meta_box('view-meta-boxes', esc_html__('Layout Options', 'barber'), 'apr_show_post_meta_option', 'post', 'normal', 'low');
    }
}

add_action('add_meta_boxes', 'apr_add_post_metaboxes');
add_action('save_post', 'apr_save_post_meta_option');
add_action('save_post', 'apr_save_post2_meta_option');

function apr_default_post_tax_meta_data() {
    $apr_sidebar_position = apr_sidebar_position();
    $apr_sidebars = apr_sidebars();
    $apr_header_layout = apr_header_types();
    $apr_footer_layout = apr_footer_types();
    $apr_blog_layout = apr_page_blog_layouts();
    $apr_blog_columns = apr_page_blog_columns();
    $apr_blog_layout['default']= esc_html__('Default','barber');
    $apr_list_style = apr_blog_list_style();
    $apr_list_style['default']= esc_html__('Default','barber');
    $apr_block_name = apr_get_block_name();
    $apr_block_name['default'] ='default';   
    $apr_block_name['none'] ='none';  
    return array(
        // header
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
        'top_banner' => array(
            'name' => 'top_banner',
            'title' => esc_html__('Select Top Banner', 'barber'),
            'desc' => esc_html__('Choose a block to display at the top of pages (after header). You should create a block in Static Block/Add New', 'barber'),
            'type' => 'select',
            'options' => $apr_block_name,
            'default' => 'default'
        ),  
        'block_bottom' => array(
            'name' => 'block_bottom',
            'title' => esc_html__('Select Bottom Banner', 'barber'),
            'desc' => esc_html__('Choose a block to display at the bottom of pages. You can create a block in Static Block/Add New.', 'barber'),
            'type' => 'select',
            'options' => $apr_block_name,
            'default' => 'default'
        ),           
        // Breadcrumbs
        'page_title' => array(
            'name' => 'page_title',
            'title' => esc_html__('Page Title', 'barber'),
            'desc' => esc_html__('Hide Page Title', 'barber'),
            'type' => 'checkbox'
        ),
        // Breadcrumbs
        'breadcrumbs' => array(
            'name' => 'breadcrumbs',
            'title' => esc_html__('Breadcrumbs', 'barber'),
            'desc' => esc_html__('Hide breadcrumbs', 'barber'),
            'type' => 'checkbox',
        ),        
        'show_header' => array(
            'name' => 'show_header',
            'title' => esc_html__('Header', 'barber'),
            'desc' => esc_html__('Hide header', 'barber'),
            'type' => 'checkbox'
        ),
        'blog_layout' => array(
            'name' => 'blog_layout',
            'title' => esc_html__('Blog layout', 'barber'),
            'desc' => esc_html__('Select blog layout', 'barber'),
            'type' => 'select',
            'options' => $apr_blog_layout,
            'default' => 'default'            
        ),
        'blog_list_style' => array(
            'name' => 'blog_list_style',
            'title' => esc_html__('[List Layout] Blog list style', 'barber'),
            'desc' => esc_html__('Select blog list style', 'barber'),
            'type' => 'select',
            'options' => $apr_list_style,
            'default' => 'default'            
        ),
		'blog_columns' => array(
            'name' => 'blog_columns',
            'title' => esc_html__('Blog columns', 'barber'),
            'desc' => esc_html__('Select blog columns', 'barber'),
            'type' => 'select',
            'options' => $apr_blog_columns,
            'default' => 'default'            
        ),
        'post_desc' => array(
            'name' => 'post_desc',
            'title' => esc_html__('Post Description', 'barber'),
            'type' => 'select',
            'options' => array(
                'default' => esc_html__('Default','barber'), 
                '1' => esc_html__('Hide','barber'), 
                '2' => esc_html__('Display','barber'), 
             ),
            'default' => 'default'            
        ),        
        'post_pagination' => array(
            'name' => 'post_pagination',
            'title' => esc_html__('Pagination type', 'barber'),
            'desc' => esc_html__('Select blog pagination', 'barber'),
            'type' => 'select',
            'options' => array(
                'default' => esc_html__('Default','barber'), 
                '1' => esc_html__('Load more','barber'), 
                '2' => esc_html__('Next/Prev','barber'),
                '3' => esc_html__('Number','barber'),
             ),
            'default' => 'default'            
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
    );
}
//category taxonomy
function apr_add_categorymeta_table() {
    // Create Product Cat Meta
    global $wpdb;
    $type = 'category';
    $table_name = $wpdb->prefix . $type . 'meta';
    $variable_name = $type . 'meta';
    $wpdb->$variable_name = $table_name;

    // Create Category Meta Table
    apr_create_metadata_table($table_name, $type);
}
add_action( 'init', 'apr_add_categorymeta_table' );

// category meta
add_action( 'category_add_form_fields', 'apr_add_category', 10, 2);
function apr_add_category() {
    $category_meta_boxes = apr_default_post_tax_meta_data();
    apr_show_tax_add_meta_boxes($category_meta_boxes);
}

add_action( 'category_edit_form_fields', 'apr_edit_category', 10, 2);
function apr_edit_category($tag, $taxonomy) {
    $category_meta_boxes = apr_default_post_tax_meta_data();
    apr_show_tax_edit_meta_boxes($tag, $taxonomy, $category_meta_boxes);
}

add_action( 'created_term', 'apr_save_category', 10,3 );
add_action( 'edit_term', 'apr_save_category', 10,3 );
function apr_save_category($term_id, $tt_id, $taxonomy) {
    if (!$term_id) return;
    
    $category_meta_boxes = apr_default_post_tax_meta_data();
    return apr_save_taxdata( $term_id, $tt_id, $taxonomy, $category_meta_boxes );
}

 