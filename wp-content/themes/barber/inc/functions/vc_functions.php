<?php

function apr_iconpicker_type_pestrokefont( $icons ) {
    $pestrokefont_icons = array(
        array('pe-7s-helm' => 'Helm'),
        array( 'pe-7s-back-2' => 'Back 2' ),
        array( 'pe-7s-next-2' => 'Next 2'),
        array( 'pe-7s-piggy' => 'Piggy' ),
        array( 'pe-7s-gift' => 'Gift' ),
        array( 'pe-7s-arc' => 'Archor' ),
        array( 'pe-7s-plane' => 'Plane' ),
        array( 'pe-7s-help2' => 'Help' ),
        array( 'pe-7s-clock' => 'Clock' ),
        array( 'pe-7s-junk' => 'Junk' ),
        array( 'pe-7s-edit' => 'Edit' ),
        array( 'pe-7s-download' => 'Download' ),
        array( 'pe-7s-config' => 'Config' ),
        array( 'pe-7s-drop' => 'Drop' ),
        array( 'pe-7s-refresh' => 'Refresh' ),
        array( 'pe-7s-album' => 'Album' ),
        array( 'pe-7s-diamond' => 'Diamond' ),
        array( 'pe-7s-door-lock' => 'Door lock' ),
        array( 'pe-7s-photo' => 'Photo' ),
        array( 'pe-7s-settings' => 'Settings' ),
        array( 'pe-7s-volume' => 'Volumn' ),
        array( 'pe-7s-users' => 'Users' ),
        array( 'pe-7s-tools' => 'Tools' ),
        array( 'pe-7s-star' => 'Star' ),
        array( 'pe-7s-like2' => 'Like' ),
        array( 'pe-7s-map-2' => 'Map 2' ),
        array( 'pe-7s-call' => 'Call' ),
        array( 'pe-7s-mail' => 'Mail' ),
        array( 'pe-7s-way' => 'Way' ),
        array( 'pe-7s-edit' => 'Edit' ),
        array( 'pe-7s-drop' => 'Drop' ),
        array( 'pe-7s-download' => 'Download' ),
        array( 'pe-7s-config' => 'Config' ),
        array( 'pe-7s-junk' => 'Junk' ),
        array( 'pe-7s-magic-wand' => 'Magic' ),
        array( 'pe-7s-like' => 'Like' ),
        array( 'pe-7s-cup' => 'Cup' ),
        array( 'pe-7s-cash' => 'Cash' ),
        array( 'pe-7s-target' => 'Target' ),
    );

    return array_merge( $icons, $pestrokefont_icons );
}

add_filter( 'vc_iconpicker-type-pestrokefont', 'apr_iconpicker_type_pestrokefont' );
function apr_iconpicker_type_aprfont( $icons ) {
    $aprfont_icons = array(
        array( 'icon-1' => '' ),
        array( 'icon-2' => '' ),
        array( 'icon-3' => '' ),
        array( 'icon-4' => '' ),
        array( 'icon-5' => '' ),
        array( 'icon-6' => '' ),
        array( 'icon-7' => '' ),
        array( 'icon-8' => '' ),
        array( 'icon-9' => '' ),
        array( 'icon-10' => '' ),
        array( 'icon-11' => '' ),
        array( 'icon-12' => '' ),
        array( 'icon-13' => '' ),
        array( 'icon-14' => '' ),
        array( 'icon-15' => '' ),
        array( 'icon-16' => '' ),
        array( 'icon-17' => '' ),
        array( 'icon-18' => '' ),
        array( 'icon-19' => '' ),
    );
    return array_merge( $icons, $aprfont_icons );
}
add_filter( 'vc_iconpicker-type-aprfont', 'apr_iconpicker_type_aprfont' );
function apr_vc_icon() {
    $attributes = array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon library', 'barber'),
            'value' => array(
                esc_html__('Font Awesome', 'barber') => 'fontawesome',
                esc_html__('Stroke Icons 7', 'barber') => 'pestrokefont',
                esc_html__('Apr Icon', 'barber') => 'aprfont',
                esc_html__('Open Iconic', 'barber') => 'openiconic',
                esc_html__('Typicons', 'barber') => 'typicons',
                esc_html__('Entypo', 'barber') => 'entypo',
                esc_html__('Linecons', 'barber') => 'linecons',
            ),
            'admin_label' => true,
            'param_name' => 'type',
            'weight' => 10,
            'description' => esc_html__('Select icon library.', 'barber'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'barber'),
            'param_name' => 'icon_pestrokefont',
            'settings' => array(
                'emptyIcon' => false,
                'type' => 'pestrokefont',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'pestrokefont',
            ),
            'weight' => 9,
            'description' => esc_html__('Select icon from library.', 'barber'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'barber'),
            'param_name' => 'icon_aprfont',
            'settings' => array(
                'emptyIcon' => false,
                'type' => 'aprfont',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'aprfont',
            ),
            'weight' => 9,
            'description' => esc_html__('Select icon from library.', 'barber'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'barber'),
            'param_name' => 'icon_fontawesome',
            'value' => 'fa fa-adjust',
            'settings' => array(
                'emptyIcon' => false,
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'fontawesome',
            ),
            'description' => esc_html__('Select icon from library.', 'barber'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'barber'),
            'param_name' => 'icon_openiconic',
            'value' => 'vc-oi vc-oi-dial', 
            'settings' => array(
                'emptyIcon' => false, 
                'type' => 'openiconic',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'openiconic',
            ),
            'description' => esc_html__('Select icon from library.', 'barber'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'barber'),
            'param_name' => 'icon_typicons',
            'value' => 'typcn typcn-adjust-brightness',
            'settings' => array(
                'emptyIcon' => false,
                'type' => 'typicons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'typicons',
            ),
            'description' => esc_html__('Select icon from library.', 'barber'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'barber'),
            'param_name' => 'icon_entypo',
            'value' => 'entypo-icon entypo-icon-note', 
            'settings' => array(
                'emptyIcon' => false,
                'type' => 'entypo',
                'iconsPerPage' => 4000, 
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'entypo',
            ),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__('Icon', 'barber'),
            'param_name' => 'icon_linecons',
            'value' => 'vc_li vc_li-heart', 
            'settings' => array(
                'emptyIcon' => false,
                'type' => 'linecons',
                'iconsPerPage' => 4000,
            ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'linecons',
            ),
            'description' => esc_html__('Select icon from library.', 'barber'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon alignment', 'barber' ),
            'param_name' => 'align',
            'value' => array(
                esc_html__( 'Left', 'barber' ) => 'left',
                esc_html__( 'Right', 'barber' ) => 'right',
                esc_html__( 'Center', 'barber' ) => 'center',
                esc_html__( 'Inline', 'barber' ) => 'inline',
            ),
            'description' => esc_html__( 'Select icon alignment.', 'barber' ),
             "group"     => "Icon Style",
        ),
        array(
            'type' => 'number',
            'heading' => esc_html__( 'Size', 'barber' ),
            'param_name' => 'size',
            "value" => "14",
            'description' => esc_html__( 'Icon size (px)', 'barber' ),
             "group"     => "Icon Style",
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => esc_html__("Border Style", "barber"),
            "param_name" => "icon_border_style",
            "value" => array(
                esc_html__("None","barber") => "none",
                esc_html__("Solid","barber")   => "solid",
                esc_html__("Dashed","barber") => "dashed",
                esc_html__("Dotted","barber") => "dotted",
                esc_html__("Double","barber") => "double",
                esc_html__("Inset","barber") => "inset",
                esc_html__("Outset","barber") => "outset",
            ),
            "description" => esc_html__("Select the border style for icon.","barber"),
            "dependency" => Array("element" => "background_style", "value" => array("rounded-outline","boxed-outline", "rounded-less-outline")),
            "group"     => "Icon Style",
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Enable hover state for icon', 'barber' ),
            'param_name' => 'icon_hover',
            'value' => true,
             "group"     => "Icon Style",
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "class" => "",
            "heading" => esc_html__( "Content", "barber" ),
            "param_name" => "content", 
            "description" => esc_html__( "Enter your content.", "barber" ),
            'group' => esc_html__( 'Content', 'barber' )
        )
    );

    vc_add_params('vc_icon', $attributes);

}

add_action('vc_before_init', 'apr_vc_icon');

function apr_vc_column() {
    $attributes = array(
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Add overlay background", "barber"),
            'param_name' => 'overlay',
            'value' => array( esc_html__( 'Yes', 'barber' ) => 'yes' ),
            'weight' => 5,
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Align inside element center horizontally and vertically", "barber"),
            'param_name' => 'center_element',
            'value' => array( esc_html__( 'Yes', 'barber' ) => 'yes' ),
            'weight' => 5,
        ),        
    );
    vc_add_params('vc_column', $attributes); 
}
add_action('vc_before_init', 'apr_vc_column'); 
function apr_vc_row() {
    $attributes = array(
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Wrap inside column in container", "barber"),
            'param_name' => 'wrap_container',
            'value' => array( esc_html__( 'Yes', 'barber' ) => 'yes' ),
            'weight' => 5,
            'admin_label'=> true,
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Hide background in mobile", "barber"),
            'param_name' => 'hide_bg_mobile',
            'value' => array( esc_html__( 'Yes', 'barber' ) => 'yes' ),
            'weight' => 5,
            'admin_label'=> true,
        ),
    );
    vc_add_params('vc_row', $attributes); 
}
add_action('vc_before_init', 'apr_vc_row'); 
function apr_vc_row_inner() {
    $attributes = array(
        array(
            'type' => 'checkbox',
            'heading' => esc_html__("Wrap inside column in container", "barber"),
            'param_name' => 'wrap_container',
            'value' => array( esc_html__( 'Yes', 'barber' ) => 'yes' ),
            'weight' => 5,
        ),
    );
    vc_add_params('vc_row_inner', $attributes); 
}
add_action('vc_before_init', 'apr_vc_row_inner'); 

function apr_vc_gallery() {
    $attributes = array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Number of columns', 'barber' ),
            'param_name' => 'col_num',
            'value' => array(
                esc_html__( 'Default', 'barber' ) => 'default',
                esc_html__( '2', 'barber' ) => '2',
                esc_html__( '3', 'barber' ) => '3',
                esc_html__( '4', 'barber' ) => '4',
                esc_html__( '5', 'barber' ) => '5',
            ),
            'description' => esc_html__( 'Select number of columns to display images.', 'barber' ),
             "group"     => esc_html__( "Column numbers", 'barber' ),
            'dependency' => array(
                'element' => 'type',
                'value' => 'image_grid',
            ),
        ),
    );

    vc_add_params('vc_gallery', $attributes);

}

add_action('vc_before_init', 'apr_vc_gallery');

function apr_vc_progress_bar() {
    $attributes = array(
        array(
            'type' => 'param_group',
            'heading' => esc_html__( 'Values', 'barber' ),
            'param_name' => 'values',
            'description' => esc_html__( 'Enter values for graph - value, title and color.', 'barber' ),
            'value' => urlencode( json_encode( array(
                array(
                    'label' => esc_html__( 'Development', 'barber' ),
                    'value' => '90',
                ),
                array(
                    'label' => esc_html__( 'Design', 'barber' ),
                    'value' => '80',
                ),
                array(
                    'label' => esc_html__( 'Marketing', 'barber' ),
                    'value' => '70',
                ),
            ) ) ),

            'params' => array(
                
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Label', 'barber' ),
                    'param_name' => 'label',
                    'description' => esc_html__( 'Enter text used as title of bar.', 'barber' ),
                    'admin_label' => true,
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Value', 'barber' ),
                    'param_name' => 'value',
                    'description' => esc_html__( 'Enter value of bar.', 'barber' ),
                    'admin_label' => true,
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Color', 'barber' ),
                    'param_name' => 'color',
                    'value' => array(
                            esc_html__( 'Default', 'barber' ) => '',
                        ) + array(
                            esc_html__( 'Classic Grey', 'barber' ) => 'bar_grey',
                            esc_html__( 'Classic Blue', 'barber' ) => 'bar_blue',
                            esc_html__( 'Classic Turquoise', 'barber' ) => 'bar_turquoise',
                            esc_html__( 'Classic Green', 'barber' ) => 'bar_green',
                            esc_html__( 'Classic Orange', 'barber' ) => 'bar_orange',
                            esc_html__( 'Classic Red', 'barber' ) => 'bar_red',
                            esc_html__( 'Classic Black', 'barber' ) => 'bar_black',
                        ) + getVcShared( 'colors-dashed' ) + array(
                            esc_html__( 'Custom Color', 'barber' ) => 'custom',
                        ),
                    'description' => esc_html__( 'Select single bar background color.', 'barber' ),
                    'admin_label' => true,
                    'param_holder_class' => 'vc_colored-dropdown',
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Custom color', 'barber' ),
                    'param_name' => 'customcolor',
                    'description' => esc_html__( 'Select custom single bar background color.', 'barber' ),
                    'dependency' => array(
                        'element' => 'color',
                        'value' => array( 'custom' ),
                    ),
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Custom text color', 'barber' ),
                    'param_name' => 'customtxtcolor',
                    'description' => esc_html__( 'Select custom single bar text color.', 'barber' ),
                    'dependency' => array(
                        'element' => 'color',
                        'value' => array( 'custom' ),
                    ),
                ),
            ),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Layout", 'barber'),
            "param_name" => "layout",
            'std' => 'layout1',
            'value' => array(
                esc_html__('Layout 1', 'barber') => 'layout1',
                esc_html__('Layout 2', 'barber') => 'layout2',
            ),
        ),
    );

    vc_add_params('vc_progress_bar', $attributes);

}

add_action('vc_before_init', 'apr_vc_progress_bar');


