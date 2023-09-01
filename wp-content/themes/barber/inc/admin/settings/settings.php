<?php

/**
 * Apr Settings Options
 */
if (!class_exists('Apr_Framework_Settings')) {

    class Apr_Framework_Settings {

        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( Redux_Helpers::isTheme(__FILE__) || Redux_Helpers::is_theme(get_template_directory())) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }

        public function initSettings() {
            $this->ReduxFramework = new ReduxFramework($this->apr_get_setting_sections(), $this->apr_get_setting_arguments());
        }

        public function apr_get_setting_sections() {
            $page_layout = apr_layouts();
            $sidebar_positions = apr_sidebar_position();
            $block_name = apr_get_block_name();
            $breadcrumbs_type = apr_get_breadcrumbs_type();
            unset($page_layout['default']);
            unset($sidebar_positions['default']);
            $menus = get_terms('nav_menu');
            $menu_list =apr_list_menu();            
            $sections = array(
                array(
                    'icon' => 'el-icon-edit',
                    'icon_class' => 'icon',
                    'title' => esc_html__('General', 'barber'),
                    'fields' => array(
                    )
                ),
                array(
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Layout', 'barber'),
                'fields' => array(
                        array(
                            'id' => 'layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'barber'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        array(
                            'id' => 'left-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                    )
                ),
                array(
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Logo, Favicon, Js Custom', 'barber'),
                'fields' => array(
                        array(
                            'id' => 'logo',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Logo', 'barber'),
                            'required' => array(
                                        array('header-type', 'equals', array(
                                        '1','5'
                                    )),
                                ),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo.png',
                                'height' => 88,
                                'wide' => 107
                            )
                        ),
                        array(
                            'id' => 'logo_sticky',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Logo Sticky', 'barber'),
                            'required' => array(
                                        array('header-type', 'equals', array(
                                        '1','5'
                                    )),
                                ),
                            'default' => ''
                        ),   
                        array(
                            'id' => 'favicon',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Favicon', 'barber'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/favicon.ico'
                            )
                        ),
                        array(
                            'id' => 'js-code',
                            'type' => 'ace_editor',
                            'title' => esc_html__('JS Code', 'barber'),
                            'subtitle' => esc_html__('Paste your JS code here.', 'barber'),
                            'mode' => 'javascript',
                            'theme' => 'chrome',
                            'default' => "jQuery(document).ready(function(){});"
                        )
                    )
                ),
                array(
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Preloader', 'barber'),
                'fields' => array(
                        array(
                            'id'            => 'preload',
                            'type'          => 'button_set',
                            'title'         => esc_html__('Preload ', 'barber'),
                            'description'   => esc_html__('Enable Preload site', 'barber'), 
                            'options'       => array(
                                'enable'  => esc_html__( 'Enable', 'barber' ), 
                                'disable'  => esc_html__( 'Disable', 'barber' ),   
                            ),
                            'default'       => 'enable', 
                        ),
                        array(
                            'id'            => 'preload-type',
                            'type'          => 'image_select',
                            'title'         => esc_html__('Preload Type', 'barber'),
                            'subtitle' => esc_html__('Each page will have option for select preload type. Preload selection in each page will have higher priority than this general selection.','barber'),
                            'options' => $this->apr_preload_types(),
                            'default' => '3',
                            'required' => array(
                                    array('preload', 'equals', array(
                                    'enable'
                                )),
                            ),
                        ),
                        array(
                            'id' => 'logo-preload',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Logo', 'barber'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo-8.png'
                            ),
                            'required' => array(
                                    array('preload-type', 'equals', array(
                                    '2','5'
                                )),
                            ),
                        ),
                        array(
                            'id' => 'preloader-bg',
                            'type' => 'color',
                            'title' => esc_html__('Preload background color', 'barber'),
                            'validate' => 'color',
                            'default' => '', 
                            'required' => array(
                                    array('preload', 'equals', array(
                                    'enable'
                                )),
                            ),
                        ), 
                        array(
                            'id' => 'preloader-color',
                            'type' => 'color',
                            'title' => esc_html__('Preload color icon', 'barber'),
                            'validate' => 'color',
                            'default' => '', 
                            'required' => array(
                                    array('preload', 'equals', array(
                                    'enable'
                                )),
                            ),
                        ), 
                    )
                ),
                array(
                    'icon' => 'el-icon-css',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Skin', 'barber'),
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('General', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'general-bg',
                            'type' => 'background',
                            'title' => esc_html__('General Background', 'barber'),
                            'default' => array(
                                'background-color' => '#ffffff',
                                'background-image' => '',
                                'background-size' => 'inherit',
                                'background-repeat' => 'no-repeat',
                                'background-position' => 'center center',
                                'background-attachment' => 'inherit'
                            ),
                            'output'      => array('body','#error-page','#main'),
                        ),
                        array(
                            'id' => 'general-font',
                            'type' => 'typography',
                            'title' => esc_html__('General Font', 'barber'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'default' => array(
                                'color' => "#555555",
                                'google' => true,
                                'font-weight' => '400',
                                'font-family' => 'Open Sans',
                                'font-size' => '15px',
                                'line-height' => '24px'
                            ),
                            'output'      => array('body','#error-page'),
                        ),
                        array(
                            'id' => 'primary-color',
                            'type' => 'color',
                            'title' => esc_html__('Primary color', 'barber'),
                            'default' => '#d19f68',
                            'validate' => 'color',
                            'transparent' => false
                        ),
                        array(
                            'id' => 'highlight-color',
                            'type' => 'color',
                            'title' => esc_html__('Highlight color', 'barber'),
                            'default' => '#000000',
                            'validate' => 'color',
                            'transparent' => false
                        ),                        
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Breadcrumbs', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'breadcrumbs_style',
                            'type' => 'button_set',
                            'title' => esc_html__('Breadcrumbs Layout', 'barber'),
                            'options' => apr_get_breadcrumbs_type(),
                            'default' => 'type-1'
                        ),
                         array(

                            'id' => 'breadcrumbs-bg',
                            'type' => 'background',
                            'title' => esc_html__('Background', 'barber'),
                            'background-color' => true, 
                            'default' => array(
                                'background-image' => get_template_directory_uri() . '/images/bg-breadcrumb.jpg',
                                'background-size' => 'cover',
                                'background-repeat' => 'no-repeat',
                                'background-position' => 'center center',
                                'background-attachment' => 'fixed',
                                'background-color' => 'none'
                            ),
                            'required' => array('breadcrumbs_style', 'equals', array(
                                    'type-1'
                            )),
                            'output'    => array(
                                'background-image' =>'.side-breadcrumb.use_bg_image',
                                'background-size' => '.side-breadcrumb.use_bg_image',
                                'background-repeat' => '.side-breadcrumb.use_bg_image',
                                'background-position' => '.side-breadcrumb.use_bg_image',
                                'background-attachment' => '.side-breadcrumb.use_bg_image',
                                'background-color' =>'.side-breadcrumb.use_bg_image',
                            ),                                                               
                        ),
                         array(

                            'id' => 'breadcrumbs2-bg',
                            'type' => 'background',
                            'title' => esc_html__('Background', 'barber'),
                            'background-color' => true, 
                            'default' => array(
                                'background-image' => 'none',
                                'background-size' => 'cover',
                                'background-repeat' => 'no-repeat',
                                'background-position' => 'center center',
                                'background-attachment' => 'fixed',
                                'background-color' => '#f5f5f5',
                            ),
                            'required' => array('breadcrumbs_style', 'equals', array(
                                    'type-2'
                            )),
                            'output'    => array(
                                'background-image' =>'.side-breadcrumb.type-2.use_bg_image',
                                'background-size' => '.side-breadcrumb.type-2.use_bg_image',
                                'background-repeat' => '.side-breadcrumb.type-2.use_bg_image',
                                'background-position' => '.side-breadcrumb.type-2.use_bg_image',
                                'background-attachment' => '.side-breadcrumb.type-2.use_bg_image',
                                'background-color' =>'.side-breadcrumb.type-2.use_bg_image',
                            ),                                                               
                        ), 
                        array(

                            'id' => 'breadcrumbs3-bg',
                            'type' => 'background',
                            'title' => esc_html__('Background', 'barber'),
                            'background-color' => true, 
                            'default' => array(
                                'background-image' => get_template_directory_uri() . '/images/bg-breadcrumb2.jpg',
                                'background-size' => 'cover',
                                'background-repeat' => 'no-repeat',
                                'background-position' => 'center center',
                                'background-attachment' => 'fixed',
                                'background-color' => 'none'
                            ),
                            'required' => array('breadcrumbs_style', 'equals', array(
                                    'type-3'
                            )),
                            'output'    => array(
                                'background-image' =>'.side-breadcrumb.type-3.use_bg_image',
                                'background-size' => '.side-breadcrumb.type-3.use_bg_image',
                                'background-repeat' => '.side-breadcrumb.type-3.use_bg_image',
                                'background-position' => '.side-breadcrumb.type-3.use_bg_image',
                                'background-attachment' => '.side-breadcrumb.type-3.use_bg_image',
                                'background-color' =>'.side-breadcrumb.type-3.use_bg_image',
                            ),                                                               
                        ),
						array(
                            'id' => 'breadcrumbs-overlay-color',
                            'type' => 'color',
                            'title' => esc_html__('Background Overlay Color', 'barber'),
                            'validate' => 'color',
                            'default' => '#000000',
                        ), 
						array(
                            'id' => 'breadcrumbs_align',
                            'type' => 'button_set',
                            'title' => esc_html__('Breadcrumbs Align', 'barber'),
                            'options' => apr_get_align(),
                            'default' => 'center'
                        ),
						array(
                            'id'             => 'breadcrumbs_padding',
                            'type'           => 'spacing',
                            'mode'           => 'padding',
                            'units'          => array('px'),
                            'units_extended' => 'false',
                            'title'          => esc_html__('Set padding for breadcrumb in desktop', 'barber'),
                            'subtitle'       => esc_html__('Allow users to ajust breadcrumb spacing', 'barber'),                            
                        ),
						array(
                            'id' => 'title-breadcrumbs-font',
                            'type' => 'typography',
                            'title' => esc_html__('Title Page', 'barber'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => true,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#ffffff",
                                'google' => true,
                                'font-family' => 'Oswald',
                                'font-size' => '32px',
								'font-weight' => '400',
                            )
                        ),
						array(
							'id' => 'breadcrumbs-icon',
							'type' => 'text',
							'title' => esc_html__('Icon Home Breadcrumb', 'barber'),  
							'placeholder' => esc_html__('fa fa-home', 'barber'),
							'desc' => wp_kses(__('Add icon class you want here. You can find a lot of icons in these links <a target="_blank" href="http://fontawesome.io/icons/">Awesome icon</a> or <a target="_blank" href="https://linearicons.com/free">Linearicons </a>, and <a target="_blank" href="http://themes-pixeden.com/font-demos/7-stroke/">Pe stroke icon7 </a>','barber'),array(
									'a' => array(
										'href'=>array(),
										'target' => array(),
										),
								))                         
						),
						array(
                            'id' => 'link-breadcrumbs-font',
                            'type' => 'typography',
                            'title' => esc_html__('Link Breadcrumb Option', 'barber'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => true,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#ffffff",
                                'google' => true,
                                'font-family' => 'Open Sans',
                                'font-size' => '16px',
                            )
                        ), 
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Typography', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'h1-font',
                            'type' => 'typography',
                            'title' => esc_html__('H1 Font', 'barber'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#000000",
                                'google' => true,
                                'font-family' => 'Oswald',
                                'font-size' => '40px',
                            ),
                            'output'      => array('h1'),
                        ),
                        array(
                            'id' => 'h2-font',
                            'type' => 'typography',
                            'title' => esc_html__('H2 Font', 'barber'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#000000",
                                'google' => true,
                                'font-family' => 'Oswald',
                                'font-size' => '30px',
                            ),
                            'output'      => array('h2'),
                        ),
                        array(
                            'id' => 'h3-font',
                            'type' => 'typography',
                            'title' => esc_html__('H3 Font', 'barber'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#000000",
                                'google' => true,
                                'font-family' => 'Oswald',
                                'font-size' => '20px',
                            ),
                            'output'      => array('h3'),
                        ),
                        array(
                            'id' => 'h4-font',
                            'type' => 'typography',
                            'title' => esc_html__('H4 Font', 'barber'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#000000",
                                'google' => true,
                                'font-family' => 'Oswald',
                                'font-size' => '18px',
                            ),
                            'output'      => array('h4'),
                        ),
                        array(
                            'id' => 'h5-font',
                            'type' => 'typography',
                            'title' => esc_html__('H5 Font', 'barber'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#000000",
                                'google' => true,
                                'font-family' => 'Oswald',
                                'font-size' => '16px',
                            ),
                            'output'      => array('h5'),
                        ),
                        array(
                            'id' => 'h6-font',
                            'type' => 'typography',
                            'title' => esc_html__('H6 Font', 'barber'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#000000",
                                'google' => true,
                                'font-family' => 'Oswald',
                                'font-size' => '14px',
                            ),
                            'output'      => array('h6'),
                        ),
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Custom', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'custom-css-code',
                            'type' => 'ace_editor',
                            'title' => esc_html__('CSS', 'barber'),
                            'subtitle' => esc_html__('Enter CSS code here.', 'barber'),
                            'mode' => 'css',
                            'theme' => 'monokai',
                            'default' => ""
                        ),
                    )
                ),
                $this->apr_add_header_section_options(),
                array(
                    'icon_class' => 'el-icon-edit',
                    'subsection' => true,
                    'title' => esc_html__('Side Header Information', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'header-info',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Side Header Information', 'barber'),                        
                            'default' => true,
                        ), 
                        array(
                            'id' => 'header6-info',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Side Header Information', 'barber'),                        
                            'default' => false,
                            'required' => array('header-type', 'equals', array(
                                6
                            )),  
                        ), 
                        array(
                            'id' => 'header-info-icon',
                            'type' => 'text',
                            'title' => esc_html__('Icon Information', 'barber'),   
                            'default' => 'lnr lnr-indent-increase',
                            'placeholder' => esc_html__('lnr lnr-indent-increase', 'barber'),
                            'required' => array('header-info', 'equals', array(
                                true
                            )), 
                            'desc' => wp_kses(__('Add icon class you want here. You can find a lot of icons in these links <a target="_blank" href="http://fontawesome.io/icons/">Awesome icon</a> or <a target="_blank" href="https://linearicons.com/free">Linearicons </a>, <a target="_blank" href="http://themes-pixeden.com/font-demos/7-stroke/">Pe stroke icon7 </a> and <a target="_blank" href="https://www.dropbox.com/s/oy8lsb7u4eli7rt/barber_font.png?dl=0">Barber icon list </a>','barber'),array(
                                'a' => array(
                                    'href'=>array(),
                                    'target' => array(),
                                    ),
                            ))                            
                        ),
                        array(
                            'id' => 'header-slogan',
                            'type' => 'textarea',
                            'title' => esc_html__('Slogan', 'barber'),                        
                            'default' => wp_kses( __('Lorem ipsum dolor sit amet gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci. Proin gravida nibh vel veliau ctor aliquenean.','barber'), 
                            array(
                                'span' => array('class' => array()),
                                'br' => array(),
                                'a' => array(),
                                'h4' => array(),
                                'ul' => array(),
                                'li' => array(),
                                'p' => array()
                            )), 
                        ), 
                        array(
                            'id' => 'side-contact',
                            'type' => 'switch',
                            'title' => esc_html__('Show Contact Form', 'barber'),
                            'default' => false,
                            'required' => array('header-info', 'equals', true),
                        ),
                        array(
                            'id' => 'form_contact',
                            'type' => 'textarea',
                            'title' => esc_html__('Contact form shortcode', 'barber'),
                            'default' => '',
                            'required' => array('side-contact', 'equals', true),
                            'desc' => esc_html__('Get contact form shortcode in Contact > Contact Forms','barber'),                        
                        ),
                        array(
                            'id' => 'header-contact',
                            'type' => 'switch',
                            'title' => esc_html__('Show Contact Us', 'barber'),                        
                            'default' => true,
                        ), 
                        array(
                            'id' => 'header-callto',
                            'type' => 'text',
                            'title' => esc_html__('Callto', 'barber'),                        
                            'default' => '+84437955813',
                            'required' => array('header-contact', 'equals', array(
                                true
                            )),
                        ), 
                        array(
                            'id' => 'header-mailto',
                            'type' => 'text',
                            'title' => esc_html__('Mailto', 'barber'),                        
                            'default' => 'arrowpress@arrowhitech.com',
                            'required' => array('header-contact', 'equals', array(
                                true
                            )),
                        ),                        
                    )
                ),
                array(
                    'icon_class' => 'el-icon-edit',
                    'subsection' => true,
                    'title' => esc_html__('Header Styling', 'barber'),
                    'fields' => array(
                        array(
                            'id'       => 'logo_width',
                            'type'     => 'dimensions',
                            'units'    => array('em','px','%'),
                            'title'    => esc_html__('Set logo image width', 'barber'),
                            'subtitle' => esc_html__('Allow users to set width for header logo image', 'barber'),
                            'height'   => false,
                        ),                        
                        array(
                            'id'             => 'menu_spacing',
                            'type'           => 'spacing',
                            'mode'           => 'margin',
                            'units'          => array('px'),
                            'units_extended' => 'false',
                            'title'          => esc_html__('Set padding for menu items', 'barber'),
                            'subtitle'       => esc_html__('Allow users to ajust menu item spacing', 'barber'),
                            'required' => array('header-style', 'equals', array(
                                    '1','6','2'
                                )),                              
                        ),
                        array(
                            'id'             => 'bg_header_sidebar',
                            'type'           => 'color',
                            'title'          => esc_html__('Set background color for sidebar header', 'barber'),
                            'default' => '#ffffff',
                            'validate' => 'color',
                            'transparent' => false,                            
                        ),                         
                        array(
                            'id' => 'header-style',
                            'type' => 'select',
                            'title' => esc_html__('Select header for styling', 'barber'),
                            'options' => apr_header_types(),
                            'default' => '1',
                        ),      
                    //Header 1, 5, 7 
                        array(
                            'id' => 'header-bg-image',
                            'type' => 'background',
                            'title' => esc_html__('Background Image', 'barber'),
                            'background-color' => false, 
                            'default' => array(
                                'background-image' => '',
                                'background-size' => 'cover',
                                'background-repeat' => 'no-repeat',
                                'background-position' => 'center center',
                                'background-attachment' => 'fixed',
                            ),
                            'output'    => array('header.site-header', 
                                '.fixed-header header.site-header.is-sticky',
                            ),                                                               
                        ),    
						array(
                            'id' => 'header-overlay-color',
                            'type' => 'color',
                            'title' => esc_html__('Header Background Overlay Color', 'barber'),
                            'validate' => 'color',
                            'default' => 'transparent',                                                           
                        ),
						array(
                            'id' => 'header-opacity',
                            'type' => 'text',
							'placeholder' => esc_html__('0.6', 'barber'),
                            'title' => esc_html__('Header Background Opacity', 'barber'),
							'default' => '0.6',
                        ),
                        array(
                            'id' => 'header-bg',
                            'type' => 'color',
                            'title' => esc_html__('Header background color', 'barber'),
                            'validate' => 'color',
                            'default' => '#202020',
                            'required' => array('header-style', 'equals', array(
                                    '1','5','7'
                                )),                                
                        ),   
                        array(
                            'id' => 'header-menu-color',
                            'type' => 'color',
                            'title' => esc_html__('Header Menu Color', 'barber'),
                            'default' => '#ffffff',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '1', '5','7'                     
                                )),                            
                        ),  
                        array(
                            'id' => 'header-bg-hover',
                            'type' => 'color',
                            'title' => esc_html__('Header background color hover submenu', 'barber'),
                            'validate' => 'color',
                            'default' => '#151515',
                            'required' => array('header-style', 'equals', array(
                                    '1','5','7'
                                )),                                
                        ), 
                        array(
                            'id' => 'header-border-color',
                            'type' => 'color',
                            'title' => esc_html__('Header Submenu Border Color', 'barber'),
                            'default' => '#2c2c2c',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '1','5','7'                     
                                )),                            
                        ),  
                    //Header 2, 3, 4, 8  
                        array(
                            'id' => 'header2-bg',
                            'type' => 'color',
                            'title' => esc_html__('Header Background Color', 'barber'),
                            'default' => '#ffffff',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '2','3','4','8'
                                )),                                
                        ),  
                        array(
                            'id' => 'header2-menu-color',
                            'type' => 'color',
                            'title' => esc_html__('Header Menu Color', 'barber'),
                            'default' => '#000000',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '2','3','4','8'                           
                                )),                            
                        ),  
                        array(
                            'id' => 'header2-bg-hover',
                            'type' => 'color',
                            'title' => esc_html__('Header background color hover submenu', 'barber'),
                            'validate' => 'color',
                            'default' => '#f7f6f6',
                            'required' => array('header-style', 'equals', array(
                                    '2','3','4','8'
                                )),                                
                        ), 
                        array(
                            'id' => 'header2-border-color',
                            'type' => 'color',
                            'title' => esc_html__('Header Submenu Border Color', 'barber'),
                            'default' => '#f0efef',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '2','3','4','8','10'                
                                )),                            
                        ),   
                    //Header 6
                        array(
                            'id' => 'header6-bg',
                            'type' => 'color',
                            'title' => esc_html__('Header Background Color', 'barber'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '6',
                                )),                                
                        ),  
                        array(
                            'id' => 'header6-stickybg',
                            'type' => 'color',
                            'title' => esc_html__('Header Sticky Background Color', 'barber'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '6',
                                )),                                
                        ),                          
                        array(
                            'id' => 'header6-menu-color',
                            'type' => 'color',
                            'title' => esc_html__('Header Menu and icon Color', 'barber'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '6',                           
                                )),                            
                        ),  
                        array(
                            'id' => 'header6-border-color',
                            'type' => 'color',
                            'title' => esc_html__('Header Bottom Border Color', 'barber'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '6',                
                                )),                            
                        ),   
                    // Header 10
                        array(
                            'id' => 'header10-bg',
                            'type' => 'color',
                            'title' => esc_html__('Header Background Color', 'barber'),
                            'validate' => 'color',
                            'default' => '#f5f5f5',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '10',
                                )),                                
                        ),                      
                        array(
                            'id' => 'header10-menu-color',
                            'type' => 'color',
                            'title' => esc_html__('Header Menu Color', 'barber'),
                            'validate' => 'color',
                            'default' => '#282828',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '10',                           
                                )),                            
                        ),  
                        array(
                            'id' => 'header10-icon-color',
                            'type' => 'color',
                            'title' => esc_html__('Header Icon Color', 'barber'),
                            'validate' => 'color',
                            'default' => '#000000',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '10',                           
                                )),                            
                        ),                                           
                    )
                ),                
                array(
                    'icon' => 'el-icon-edit',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Footer', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'footer-type',
                            'type' => 'image_select',
                            'title' => esc_html__('Footer Type', 'barber'),
                            'options' => $this->apr_footer_types(),
                            'subtitle' => esc_html__('Each page will have option for select footer type. Footer selection in each page will have higher priority than this general selection.','barber'),
                            'default' => '1'
                        ),
                        array(
                            'id' => 'footer-position',
                            'type' => 'switch',
                            'title' => esc_html__('Footer Fixed', 'barber'),                        
                            'default' => false,
                        ),
                        array(
                            'id' => 'logo_footer',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Footer logo', 'barber'),
                            'required' => array('footer-type', 'equals', array(
                                    '1', '2', '3'
                                )),                            
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo.png',
                            )
                        ),  
                         array(
                            'id' => 'logo_footer9',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Footer logo', 'barber'),
                            'required' => array('footer-type', 'equals', array(
                                    '9'
                                )),                            
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo-footer9.png',
                            )
                        ),    
                          array(
                            'id' => 'logo_footer10',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Footer logo', 'barber'),
                            'required' => array('footer-type', 'equals', array(
                                    '10'
                                )),                            
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo-footer10.png',
                            )
                        ),
                        array(
                            'id' => "footer-info_title",
                            'type' => 'text',
                            'title' => esc_html__('Footer info title', 'barber'),
                            'default' => wp_kses( __('About us', 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array('callto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'h4' => array(
                                    'class' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '1'
                                )
                            ),                            
                        ),  
                        array(
                            'id' => "footer2-info_title",
                            'type' => 'text',
                            'title' => esc_html__('Footer title for info column ', 'barber'),
                            'default' => wp_kses( __('Contact us', 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array('callto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'h4' => array(
                                    'class' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '4','5'
                                )
                            ),                            
                        ),                                                
                        array(
                            'id' => "footer-info",
                            'type' => 'textarea',
                            'title' => esc_html__('Footer Description', 'barber'),
                            'default' => wp_kses( __('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry', 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array('callto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'h4' => array(
                                    'class' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '1'
                                )
                            ),                            
                        ), 
                        array(
                            'id' => "footer2-info",
                            'type' => 'textarea',
                            'title' => esc_html__('Footer Description', 'barber'),
                            'default' => wp_kses( __('Vestibulum varius, velit sit amet tempor efficitur, ligula mi lacinia libero, vehicula dui nisi eget purus. Integer cursus nibh non risus maximus dictum. Suspendisse potenti. Nunc rutrum sed purus eget sagittis. In eleifend vulputate nunc ac pretium', 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array('callto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '2','3','4','5'
                                )
                            ),                            
                        ), 
                        array(
                            'id' => "footer-address",
                            'type' => 'textarea',
                            'title' => esc_html__('Footer Address', 'barber'),
                            'default' => wp_kses( __('<i class="lnr lnr-map-marker"></i>123 Lorem ipsum dolor sit amet, consectetur' , 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array('callto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                'span' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                'p' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '1','3','4'
                                )
                            ),                            
                        ),  
                        array(
                            'id' => "footer-email",
                            'type' => 'textarea',
                            'title' => esc_html__('Email Contact', 'barber'),
                            'default' => wp_kses( __('<i class="lnr lnr-envelope"></i><span>Email: </span><a href="mailto:contact@barber.com">contact@barber.com</a> ', 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array('mailto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                'span' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '1','3','4'
                                )
                            ),                            
                        ),
                        array(
                            'id' => "footer-phone",
                            'type' => 'textarea',
                            'title' => esc_html__('Phone Number', 'barber'),
                            'default' => wp_kses( __('<i class="lnr lnr-phone"></i><spam>Phone 01:</span> <a href="tel:+841234567891">+84 (1) 234 567 891 ', 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array('callto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                'span' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '1','3','4'
                                )
                            ),                            
                        ),
                        array(
                            'id' => "footer-fax",
                            'type' => 'textarea',
                            'title' => esc_html__('Fax Number', 'barber'),
                            'default' => wp_kses( __('<i class="lnr lnr-printer"></i><span>Fax:</span><a href="tel:+841234567891"> +84 (1) 234 567 891 ', 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array('callto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                'span' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '1','4'
                                )
                            ),                            
                        ),
                        array(
                            'id' => 'social-twitter',
                            'type' => 'text',
                            'title' => esc_html__('Twitter', 'barber'),
                            'default' => 'https://twitter.com/arrowpress1',
                            'placeholder' => esc_html__('https://twitter.com/arrowpress1', 'barber'), 
                        ),
                        
                        array(
                            'id' => 'social-facebook',
                            'type' => 'text',
                            'title' => esc_html__('Facebook', 'barber'),
                            'default' => 'https://facebook.com/arrowpress',
                            'placeholder' => esc_html__('https://facebook.com/arrowpress', 'barber')
                        ),
                        array(
                            'id' => 'social-google',
                            'type' => 'text',
                            'title' => esc_html__('Google', 'barber'),
                            'default' => '#',
                            'placeholder' => esc_html__('http://', 'barber')
                        ), 
                        array(
                            'id' => 'social-instagram',
                            'type' => 'text',
                            'title' => esc_html__('Instagram', 'barber'),
                            'default' => 'https://www.instagram.com/aprbaber/',
                            'placeholder' => esc_html__('https://www.instagram.com/aprbaber/', 'barber')
                        ),       
                        array(
                            'id' => 'social-pinterest',
                            'type' => 'text',
                            'title' => esc_html__('Pinterest', 'barber'),
                            'default' => '#',
                            'placeholder' => esc_html__('http://', 'barber')
                        ),
                        array(
                            'id' => 'social-dribbble',
                            'type' => 'text',
                            'title' => esc_html__('Dribbble', 'barber'),
                            'default' => '#',
                            'placeholder' => esc_html__('http://', 'barber')
                        ),
                        array(
                            'id' => 'social-linkedin',
                            'type' => 'text',
                            'title' => esc_html__('Linkedin', 'barber'),
                            'default' => '#',
                            'placeholder' => esc_html__('http://', 'barber')
                        ),                   
                        array(
                            'id' => 'social-behance',
                            'type' => 'text',
                            'title' => esc_html__('Behance', 'barber'),
                            'default' => '#',
                            'placeholder' => esc_html__('http://', 'barber')
                        ),
                        array(
                            'id' => "footer-copyright",
                            'type' => 'textarea',
                            'title' => esc_html__('Copyright', 'barber'),
                            'default' => wp_kses( __(' Design by AHT Studio. @2017 All Rights Reserved ', 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array(),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                            )),                         
                        ),
                    )
                ),

                array(
                    'icon_class' => 'el-icon-edit',
                    'subsection' => true,
                    'title' => esc_html__('Footer Styling', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'footer-style',
                            'type' => 'select',
                            'title' => esc_html__('Select footer for styling', 'barber'),
                            'options' => apr_footer_types(),
                            'default' => '1',
                        ),
                        array(
                            'id' => 'bg_img_footer',
                            'type' => 'background',
                            'title' => esc_html__('Background footer', 'barber'),
                            'background-color' => true, 
                            'default' => array(
                                'background-image' => get_template_directory_uri() . '/images/bg-footer.jpg',
                                'background-size' => 'cover',
                                'background-repeat' => 'no-repeat',
                                'background-position' => 'center center',
                                'background-attachment' => 'fixed'
                            ),
                            'required' => array('footer-style', 'equals', array(
                                    '1'
                            )), 
                            'output'    => array(
                                '.footer-v1 .footer-content'
                            ),                                                              
                        ),
                        array(
                            'id'        => 'bg_overlay_color',
                            'type'      => 'color_rgba',
                            'title'     => esc_html__('Background overlay color', 'barber'),                       
                            'output'    => array('background' => '.footer-v1 .has-overlay:before'),
                            'options'       => array(
                                'show_input'                => true,
                                'show_initial'              => true,
                                'show_alpha'                => true,
                                'show_palette'              => true,
                                'show_palette_only'         => false,
                                'show_selection_palette'    => true,
                                'max_palette_size'          => 10,
                                'allow_empty'               => true,
                                'clickout_fires_change'     => false,
                                'show_buttons'              => true,
                                'use_extended_classes'      => true,
                                'palette'                   => null,  // show default
                            ), 
                            'required' => array('footer-style', 'equals', array(
                                    '1'
                                )),                                               
                        ),                                                                        
                        array(
                            'id' => 'footer-bg',
                            'type' => 'background',
                            'title' => esc_html__('Footer Background', 'barber'),
                            'background-color' => true, 
                            'default' => array(
                                'background-color' => '#222324'
                            ),
                            'required' => array('footer-style', 'equals', array(
                                    '2','3','4'
                                )),
                            'output'    => array('.footer-v2,.footer-v3,.footer-v4'),                             
                        ),  
                        array(
                            'id' => 'footer5-bg',
                            'type' => 'background',
                            'title' => esc_html__('Footer Background', 'barber'),
                            'background-color' => true, 
                            'default' => array(
                                'background-color' => '#f5f5f5'
                            ),
                            'required' => array('footer-style', 'equals', array(
                                    '5'
                                )),
                            'output'    => array('.footer-v5'),                             
                        ), 
                        array(
                            'id' => 'footer5-bottom-bg',
                            'type' => 'color',
                            'title' => esc_html__('Bottom Footer background color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '5','7'
                                )),
                            'validate' => 'color',
                            'output' => array(
                                'background-color'=> '.footer-v5 .footer-bottom,.footer-v7 .footer-bottom',
                            ),
                        ),                       
                        array(
                            'id' => 'footer5-title-color',
                            'type' => 'color',
                            'title' => esc_html__('Title color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '5','7','8'
                                )),
                            'default' => '',
                            'validate' => 'color',
                            'output' => array(
                                'color'=> '.footer-v5 .footer-title, .footer-v5 .list-item-info span,
                                .footer-v7 .footer-title, .footer-v7 .list-item-info span,
                                .footer-v8 .footer-title',
                            ),
                        ), 
                        array(
                            'id' => 'footer8-titleborder-color',
                            'type' => 'color',
                            'title' => esc_html__('Bottom footer & title border color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '8'
                                )),
                            'default' => '',
                            'validate' => 'color',
                            'output' => array(
                                'border-color'=> '.footer-title.border,.footer-v8 .footer-bottom',
                            ),
                        ),                        
                        array(
                            'id' => 'footer5-tcolor',
                            'type' => 'color',
                            'title' => esc_html__('Text & link  color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '5',
                                )),
                            'validate' => 'color',
                            'transparent' =>false,
                            'output' => array(
                                'color'=> '.footer-v5 .info-address > p, .footer-v5 .contact-form label,
                                .footer-v5 .list-item-info .info-mail a, .footer-v5 .list-item-info .info-number a,.footer-v5 .list-item-info .info-time .list-items-time li span,.footer-v5 .list-items-time li',
                            ),                          
                        ),                         
                        array(
                            'id' => 'footer5-contacticon_border',
                            'type' => 'color',
                            'title' => esc_html__('Contact icon border color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '5','7'
                                )),
                            'hint' => 
                                array(
                                    'title'   => '',
                                    'content' => esc_html__('Check the box transparent to hide the icon border.','barber')
                                ), 
                            'validate' => 'color',
                            'output' => array(
                                'border-color'=> '.footer-v5 .list-item-info .icon, .footer-v5 .list-item-info .icon:before, .footer-v5 .list-item-info .icon:after,
                                .footer-v7 .list-item-info .icon, .footer-v7 .list-item-info .icon:before, .footer-v7 .list-item-info .icon:after',
                            ),
                        ),                     
                        array(
                            'id' => 'footer-t-color',
                            'type' => 'color',
                            'title' => esc_html__('Title color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '1','4'
                                )),
                            'default' => '#ffffff',
                            'validate' => 'color',
                            'transparent' =>false,
                        ), 
                        array(
                            'id' => 'footer-color',
                            'type' => 'color',
                            'title' => esc_html__('Footer text color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '1','4'
                                )),
                            'default' => '#d6d6d6',
                            'validate' => 'color',
                            'transparent' =>false,
                        ),  
                        
                        array(
                            'id' => 'footer2-linkcolor',
                            'type' => 'color',
                            'title' => esc_html__('Footer link color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '2',
                                )),
                            'validate' => 'color',
                            'transparent' =>false,
                            'output'    => array(
                                'color'            => '.footer-v2 .footer-content .widget_nav_menu ul li a'
                            ), 
                        ),                        
                         array(
                            'id' => 'footer-copyright-color',
                            'type' => 'color',
                            'title' => esc_html__('Footer copyright color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '1','2','3','4','5'
                                )),
                            'default' => '#d6d6d6',
                            'validate' => 'color',
                            'transparent' =>false,
                        ),
                        array(
                            'id' => 'footer-social-color',
                            'type' => 'color',
                            'title' => esc_html__('Footer social color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '1','2','3','4','5','7','8'
                                )),
                            'default' => '#d6d6d6',
                            'validate' => 'color',
                            'transparent' =>false,
                        ), 
                         array(
                            'id' => 'footer-desc-color',
                            'type' => 'color',
                            'title' => esc_html__('Footer description color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '2','3','5'
                                )),
                            'default' => '#555555',
                            'validate' => 'color',
                            'transparent' =>false,
                        ),
                        array(
                            'id' => 'footer3-color',
                            'type' => 'color',
                            'title' => esc_html__('Footer text color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '3','7','8'
                                )),
                            'default' => '#535352',
                            'validate' => 'color',
                            'transparent' =>false,
                        ),
                        array(
                            'id' => 'footer6-bg',
                            'type' => 'background',
                            'title' => esc_html__('Background', 'barber'),
                            'background-color' => true, 
                            'default' => array(
                                'background-image' => '',
                                'background-size' => 'cover',
                                'background-repeat' => 'no-repeat',
                                'background-position' => 'center center',
                                'background-attachment' => 'fixed'
                            ),
                            'output'    => array(
                                'background-image' =>'.footer-v6,.footer-v7,.footer-v8,.footer-v9,.footer-v10',
                                'background-size' => '.footer-v6,.footer-v7,.footer-v8,.footer-v9,.footer-v10',
                                'background-repeat' => '.footer-v6,.footer-v7,.footer-v8,.footer-v9,.footer-v10',
                                'background-position' => '.footer-v6,.footer-v7,.footer-v8,.footer-v9,.footer-v10',
                                'background-attachment' => '.footer-v6,.footer-v7,.footer-v8,.footer-v9,.footer-v10',
                                'background-color' =>'.footer-v6,.footer-v7,.footer-v8,.footer-v9,.footer-v10',
                            ), 
                            'required' => array('footer-style', 'equals', array(
                                    '6','7','8','9','10'
                                )),                            
                        ),                         
                        array(
                            'id' => 'footer6-color',
                            'type' => 'color',
                            'title' => esc_html__('Text & link color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '6',
                                )),
                            'default' => '#696969',
                            'validate' => 'color',
                            'transparent' =>false,
                        ),    
                        array(
                            'id' => 'footer8-color',
                            'type' => 'color',
                            'title' => esc_html__('Copyright text color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '8','9','10'
                                )),
                            'validate' => 'color',
                            'transparent' =>false,
                            'output' => array(
                                'color' => '.footer-v8 .footer-copyright p,.footer-v9 .footer-copyright p,
                                .footer-v10 .footer-copyright p',
                            ),
                        ),
                        array(
                            'id' => 'footer9-socialcolor',
                            'type' => 'color',
                            'title' => esc_html__('Link color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '9','10'
                                )),
                            'validate' => 'color',
                            'transparent' =>false,
                            'output' => array(
                                'color' => '.footer-v9 .footer-social li a,.footer-v10 .footer-social li a,
                                .footer-v10 a.to-top',
                            ),
                        ),  
                        array(
                            'id' => 'footer10-linkcolor',
                            'type' => 'color',
                            'title' => esc_html__('Top link color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '10'
                                )),
                            'validate' => 'color',
                            'transparent' =>false,
                            'output' => array(
                                'color' => '.footer-v10 .widget_nav_menu li a',
                            ),
                        ),                         
                        array(
                            'id' => 'footer9-inputcolor',
                            'type' => 'color',
                            'title' => esc_html__('Input form color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '9','5'
                                )),
                            'validate' => 'color',
                            'transparent' =>false,
                            'output' => array(
                                'color' => '.footer-v9 .footer-newsletter .mc4wp-form input[type="email"].placeholder, .footer-v9 .footer-newsletter .mc4wp-form input[type="email"]:focus, .footer-v9 .footer-newsletter .mc4wp-form input[type="email"]:active,footer .wpcf7-form-control, footer input[type="email"],
                                    footer input[type="text"],footer textarea',
                            ),
                        ), 
                        array(
                            'id' => 'footer5-inputbg',
                            'type' => 'color',
                            'title' => esc_html__('Input background', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '5'
                                )),
                            'validate' => 'color',
                            'transparent' =>false,
                            'output' => array(
                                'background' => 'footer input[type="text"], footer input[type="email"], footer textarea',
                                'border-color' => 'footer input[type="text"], footer input[type="email"], footer textarea, footer .wpcf7-form-control'
                            ),
                        ),                         
                        array(
                            'id' => 'footer9-inputborder',
                            'type' => 'color',
                            'title' => esc_html__('MailChimp form border & icon color', 'barber'),
                            'required' => array('footer-style', 'equals', array(
                                    '9',
                                )),
                            'validate' => 'color',
                            'transparent' =>false,
                            'output' => array(
                                'border-color' => '.footer-v9 .footer-newsletter .submit:before, .footer-v9 .footer-newsletter .mc4wp-form input[type="email"]',
                            ),
                        ),                                                                                                 
                    )
                ),                
                array(
                    'icon' => 'el-icon-th',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Blog archive', 'barber'),
                    'fields' => array(
                        array(
                            'id' => '1',
                            'type' => 'info',
                            'desc' => esc_html__('Blog layout default', 'barber')
                        ),
                        array(
                            'id' => 'blog-title',
                            'type' => 'text',
                            'title' => esc_html__('Page Title', 'barber'),
                            'default' => 'Blog'
                        ),                        
                        array(
                            'id' => 'post-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'barber'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        array(
                            'id' => 'left-post-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-post-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'post-layout-version',
                            'type' => 'button_set',
                            'title' => esc_html__('Blog Layout', 'barber'),
                            'options' => apr_page_blog_layouts(),
                            'default' => 'list'
                        ),
                        array(
                            'id' => 'post-layout-columns',
                            'type' => 'button_set',
                            'title' => esc_html__('Blog Columns', 'barber'),
                            'options' => apr_page_blog_columns(),
                            'default' => '3',
                            'required' => array('post-layout-version', 'equals', array(
                                    'grid','masonry',
                                )),                            
                        ),
                        array(
                            'id' => 'post-list-style',
                            'type' => 'button_set',
                            'title' => esc_html__('Blog List Style', 'barber'),
                            'options' => apr_blog_list_style(),
                            'default' => 'list_s1',
                            'required' => array('post-layout-version', 'equals', array(
                                    'list'
                                )),                            
                        ),
                        array(
                            'id' => 'post_desc',
                            'type' => 'button_set',
                            'title' => esc_html__('Post Description', 'barber'),
                            'options' => array(
                                '1' => esc_html__('Hide','barber'), 
                                '2' => esc_html__('Display','barber'), 
                             ),
                            'default' => '1',
                            'required' => array('post-layout-version', 'equals', array(
                                    'masonry'
                                )),                            
                        ),                          
                        array(
                            'id'       => 'post_per_page',
                            'type'     => 'spinner', 
                            'title'    => esc_html__('Post show per page', 'barber'),
                            'default'  => '9',
                            'min'      => '1',
                            'step'     => '1',
                            'max'      => '50',
                            'required' => array('post-layout-version', 'equals', array(
                                    'masonry',
                                )),                             
                        ),                                                
                        array(
                            'id' => 'post_pagination',
                            'type' => 'button_set',
                            'title' => esc_html__('Pagination type', 'barber'),
                            'options' => array(
                                '1' => esc_html__('Load more','barber'), 
                                '2' => esc_html__('Next/Prev','barber'),
                                '3' => esc_html__('Number','barber'),  
                             ),
                            'default' => '3'
                        ), 
                        array(
                            'id'=>'post-meta',
                            'type' => 'button_set',
                            'title' => esc_html__('Post Meta', 'barber'),
                            'multi' => true,
                            'options'=> array(
                                'author' => esc_html__('Author', 'barber'),    
                                'comment' => esc_html__('Comment', 'barber'),
                                'date' => esc_html__('Date', 'barber'),
                                'like' => esc_html__('Like', 'barber'),
                                'cat' => esc_html__('Categories', 'barber'),
                                'tag' => esc_html__('Tags', 'barber'),
                            ),
                            'default' => array('cat','comment','date','like','tag'),
                            'required' => array('post-layout-version', 'equals', array(
                                    'list',
                                )),                            
                        ),  
                        array(
                            'id'=>'post-meta2',
                            'type' => 'button_set',
                            'title' => esc_html__('Post Meta', 'barber'),
                            'multi' => true,
                            'options'=> array(
                                'author' => esc_html__('Author', 'barber'),    
                                'comment' => esc_html__('Comment', 'barber'),
                                'date' => esc_html__('Date', 'barber'),
                                'like' => esc_html__('Like', 'barber'),
                                'cat' => esc_html__('Categories', 'barber'),
                                'tag' => esc_html__('Tags', 'barber'),
                            ),
                            'default' => array('cat','date'),
                            'required' => array('post-layout-version', 'equals', array(
                                    'masonry','grid'
                                )),                            
                        ),                                                                                     
                    )
                ),
                array(
                    'subsection' => true,
                    'title' => esc_html__('Single Blog', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'single-post-layout-version',
                            'type' => 'button_set',
                            'title' => esc_html__('Single Blog Layout', 'barber'),
                            'options' => apr_page_single_blog_layouts(),
                            'default' => 'single-1'
                        ),  
                        array(
                            'id'=>'post-share',
                            'type' => 'button_set',
                            'title' => esc_html__('Post Share Links', 'barber'),
                            'multi' => true,
                            'options'=> array(
                                'facebook' => esc_html__('Facebook', 'barber'),    
                                'twitter' => esc_html__('Twitter', 'barber'),
                                'pin' => esc_html__('Pinterest', 'barber'),
                                'insta' => esc_html__('Instagram', 'barber'),
                            ),
                            'default' => array('facebook','twitter','pin','insta')
                        ), 
                    )
                ),
                array(
                    'icon' => 'el-icon-picture',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Portfolio', 'barber'),
                    'fields' => array(
                        array(
                            'id' => '2',
                            'type' => 'info',
                            'desc' => esc_html__('Portfolio Archive Page', 'barber')
                        ),                                               
                        array(
                           'id' => 'section-start',
                           'type' => 'section',
                           'title' => esc_html__('Changing portfolio slug', 'barber'),
                           'indent' => true,                    
                        ),                        
                        array(
                            'id'        => 'gallery_slug',
                            'type'      => 'text',
                            'title'     => esc_html__('Custom Slug', 'barber'),
                            'subtitle'  => esc_html__('If you want your gallery post type to have a custom slug in the url, please enter it here.', 'barber'),
                            'desc'      => esc_html__('You will still have to refresh your permalinks after saving this! 
    This is done by going to Settings > Permalinks and clicking save.', 'barber'),
                            'validate'  => 'str_replace',
                            'str'       => array(
                                'search'        => ' ', 
                                'replacement'   => '-'
                            ),
                            'default'   => 'gallery',                    
                        ),  
                        array(
                            'id'        => 'gallery_cat_slug',
                            'type'      => 'text',
                            'title'     => esc_html__('Custom Slug for Portfolio category', 'barber'),
                            'subtitle'  => esc_html__('If you want your gallery category to have a custom slug in the url, please enter it here.', 'barber'),
                            'desc'      => esc_html__('You will still have to refresh your permalinks after saving this! 
    This is done by going to Settings > Permalinks and clicking save.', 'barber'),
                            'validate'  => 'str_replace',
                            'str'       => array(
                                'search'        => ' ', 
                                'replacement'   => '-'
                            ),
                            'default'   => 'gallery_cat',                    
                        ), 
                        array(
                            'id'     => 'section-end',
                            'type'   => 'section',
                            'indent' => false,                        
                        ),
                        array(
                            'id' => '3',
                            'type' => 'info',
                            'desc' => esc_html__('The below options is also available in each Gallery Category. Please go to Gallery > Gallery Category and edit a category for more detail. The selections in each category will have higher priority than below general selections', 'barber')
                        ),     
                        array(
                            'id' => 'gallery_filter',
                            'type' => 'switch',
                            'title' => esc_html__('Show Filter', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber')
                        ),                                                                       
                        array(
                            'id' => 'gallery-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('General Layout', 'barber'),
                            'options' => $page_layout,
                            'default' => 'wide'
                        ),
                        array(
                            'id' => 'left-gallery-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-gallery-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'gallery-cols',
                            'type' => 'button_set',
                            'title' => esc_html__('Portfolio Columns', 'barber'),
                            'options' => apr_gallery_columns(),
                            'default' => '4',
                        ),
                        array(
                            'id' => 'gallery-space',
                            'type' => 'switch',
                            'title' => esc_html__('Remove space', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber')
                        ), 
                        array(
                            'id' => 'gallery-style',
                            'type' => 'button_set',
                            'title' => esc_html__('Portfolio Style', 'barber'),
                            'options' => apr_gallery_style(),
                            'default' => 'style1',                
                        ), 
                        array(
                            'id' => 'gallery-style-version',
                            'type' => 'button_set',
                            'title' => esc_html__('Portfolio layouts', 'barber'),
                            'options' => apr_page_gallery_layouts(),
                            'default' => '1'
                        ),                        
                        array(
                            'id' => 'gallery-loadmore-style',
                            'type' => 'button_set',
                            'title' => esc_html__('Portfolio loadmore style', 'barber'),
                            'options' => array(
                                '1' => esc_html__('Button style 1','barber'),
                                '2' => esc_html__('Button style 2','barber'),
                                ),
                            'default' => '1',                         
                        ), 
                        array(
                            'id'       => 'gallery_per_page',
                            'type'     => 'spinner', 
                            'title'    => esc_html__('Post show per page', 'barber'),
                            'default'  => '12',
                            'min'      => '1',
                            'step'     => '1',
                            'max'      => '20',
                        ) 
                    )                      
                ),
               array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Single Portfolio', 'barber'),
                    'fields' => array(
                        array(
                            'id' => '1',
                            'type' => 'info',
                            'desc' => esc_html__('Portfolio detail page', 'barber')
                        ),
                        array(
                            'id' => 'single_gallery_style',
                            'type' => 'button_set',
                            'title' => esc_html__('Single gallery layout', 'barber'),
                            'options' => array(
                                    "1" => esc_html__("Wide","barber"),
                                    "2" => esc_html__("Slider","barber"),
                                    "3" => esc_html__("Side Information","barber"),
                                ),
                            'default' => '2',                         
                        ), 
                    )
                ),
                array(
                    'icon' => 'el-icon-shopping-cart',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Shop', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'product-cart',
                            'type' => 'switch',
                            'title' => esc_html__('Show Add to Cart button', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber')
                        ),
                        array(
                            'id' => 'product-price',
                            'type' => 'switch',
                            'title' => esc_html__('Show Product Price', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber')
                        ),                        
                        array(
                            'id' => 'product-label',
                            'type' => 'switch',
                            'title' => esc_html__('Show Product Label', 'barber'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Product listing', 'barber'),
                    'fields' => array(
                        array(
                            'id' => '1',
                            'type' => 'info',
                            'desc' => esc_html__('Product listing', 'barber')
                        ),  
                        array(
                            'id' => 'shop-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'barber'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        array(
                            'id' => 'left-shop-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-shop-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'category-item',
                            'type' => 'text',
                            'title' => esc_html__('Products per Page', 'barber'),
                            'desc' => esc_html__('Comma separated list of product counts.', 'barber'),
                            'default' => '8,16,24'
                        ),
                        array(
                            'id' => 'product-layouts',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Layouts', 'barber'),
                            'options' => apr_product_type(),
                            'default' => 'only-grid',
                        ),
                        array(
                            'id' => 'product-cols',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Columns', 'barber'),
                            'options' => apr_product_columns(),
                            'default' => '4',
                            'required' => array('product-layouts', 'equals', array(
                                    'only-grid'
                                )),                             
                        ),
                        array(
                            'id' => 'product-quickview',
                            'type' => 'switch',
                            'title' => esc_html__('Show Quickview', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),
                        array(
                            'id' => 'product-compare',
                            'type' => 'switch',
                            'title' => esc_html__('Show Compare', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber')
                        ),
                        array(
                            'id' => 'product-wishlist',
                            'type' => 'switch',
                            'title' => esc_html__('Show Wishlist', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ), 
                        array(
                            'id' => 'product-rating',
                            'type' => 'switch',
                            'title' => esc_html__('Show Rating', 'barber'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ), 
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Single Product', 'barber'),
                    'fields' => array(
                        array(
                            'id' => 'single-product-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'barber'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        array(
                            'id' => 'left-single-product-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-single-product-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'barber'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'product-share',
                            'type' => 'switch',
                            'title' => esc_html__('Show Product share link', 'barber'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),   
                        array(
                            'id' => 'product-related',
                            'type' => 'switch',
                            'title' => esc_html__('Show Related Products', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),
                        array(
                            'id' => 'product-reviewtab',
                            'type' => 'switch',
                            'title' => esc_html__('Remove Product Review tab', 'barber'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),                                                    
                        array(
                            'id' => 'product-destab',
                            'type' => 'switch',
                            'title' => esc_html__('Remove Product Description tab', 'barber'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),                          
                        array(
                            'id' => 'product-infotab',
                            'type' => 'switch',
                            'title' => esc_html__('Remove Additional Information tab', 'barber'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),     
                        array(
                            'id' => 'product_tagtab',
                            'type' => 'switch',
                            'title' => esc_html__('Remove Tag Tab', 'barber'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),  
                        array(
                            'id' => 'product-reviewtab-name',
                            'type' => 'text',
                            'title' => esc_html__('Rename Product Review Tab', 'barber'),
                            'default' => esc_html__('Reviews', 'barber')
                        ), 
                        array(
                            'id' => 'product-destab-name',
                            'type' => 'text',
                            'title' => esc_html__('Rename Product Description Tab', 'barber'),
                            'default' => esc_html__('Description', 'barber')
                        ), 
                        array(
                            'id' => 'product-infotab-name',
                            'type' => 'text',
                            'title' => esc_html__('Rename Additional Information Tab', 'barber'),
                            'default' => esc_html__('Additional Information', 'barber')
                        ),  
                        array(
                            'id' => 'product-tagtab-name',
                            'type' => 'text',
                            'title' => esc_html__('Rename Tag Tab', 'barber'),
                            'default' => esc_html__('Tags', 'barber')
                        ),                                                                                                                                                                                      
                    )
                ),
                array(
                    'icon' => 'el-icon-cog',
                    'icon_class' => 'icon',
                    'title' => esc_html__('404 Page', 'barber'),
                    'fields' => array(
                        array(
                            'id' => '404-bg-image',
                            'type' => 'media',
                            'url' => true,    
                            'readonly' => false,
                            'title' => esc_html__('Background image', 'barber'),
                            'desc' => esc_html__('Background image for 404 page', 'barber'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/404.jpg',
                            )                            
                        ),
                        array(
                            'id' => '404-title',
                            'type' => 'text',
                            'title' => esc_html__('404 title', 'barber'),
                            'default' => esc_html__("404", 'barber')
                        ),                         
                        array(
                            'id' => '404-content',
                            'type' => 'text',
                            'title' => esc_html__('404 content', 'barber'),
                            'default' => esc_html__("The page you're looking for cannot be found", 'barber')
                        ),  
                        array(
                            'id' => '404-color',
                            'type' => 'color',
                            'title' => esc_html__('Text color', 'barber'),
                            'default' => '#ffffff',
                            'validate' => 'color',
                            'transparent' => false,
                        ),                         
                        array(
                            'id' => '404_header',
                            'type' => 'image_select',
                            'options' => $this->apr_header_types(),
                            'default' => '3',
                            'title' => esc_html__('Header Type', 'barber'),
                        ),  
                        array(
                            'id' => '404_footer',
                            'type' => 'image_select',
                            'options' => $this->apr_footer_types(),
                            'default' => '1',
                            'title' => esc_html__('Footer Type', 'barber'),
                        ),                                                                                                                    
                    )
                ),                        
                array(
                    'icon' => 'el-icon-cog',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Coming soon', 'barber'),
                    'fields' => array(                      
                        array(
                            'id' => 'coming_header_display',
                            'type' => 'switch',
                            'title' => esc_html__('Display header in coming soon page', 'barber'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),                        
                        array(
                            'id' => 'coming_header',
                            'type' => 'image_select',
                            'options' => $this->apr_header_types(),
                            'default' => '6',
                            'title' => esc_html__('Header Type', 'barber'),
                            'required' => array('coming_header_display', 'equals', true),
                        ), 
                        array(
                            'id' => 'coming_footer_display',
                            'type' => 'switch',
                            'title' => esc_html__('Display footer in coming soon page', 'barber'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),
                        array(
                            'id' => 'coming_footer',
                            'type' => 'image_select',
                            'options' => $this->apr_footer_types(),
                            'default' => '1',
                            'title' => esc_html__('Footer Type', 'barber'),
                            'required' => array('coming_footer_display', 'equals', true),
                        ),                                     
                       array(
                            'id' => 'under-bg-image',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Background image', 'barber'),
                            'desc' => esc_html__('Background image for coming soon page', 'barber'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/coming-soon.jpg',
                            ),
                        ),
                        array(
                            'id' => 'coming-overlay-color',
                            'type' => 'color',
                            'title' => esc_html__('Background overlay color', 'barber'),
                            'default' => '#000000',
                            'validate' => 'color',
                            'transparent' => true,
                        ),                        
                        array(
                            'id' => "under-contr-title",
                            'type' => 'textarea',
                            'title' => esc_html__('Big Title', 'barber'),
                            'default' => wp_kses( __('<h3>Launching</h3><h2>Very soon</h2>' , 'barber'), 
                                array(
                                'a' => array(
                                    'href' => array('callto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                'h2' => array(
                                    'class' => array(),
                                ),
                                'h3' => array(
                                    'class' => array(),
                                ),
                            )),
                        ),
                        array(
                            'id' => '1',
                            'type' => 'info',
                            'desc' => esc_html__('Countdown Timer', 'barber')
                        ),
                        array(
                            'id' => 'under-display-countdown',
                            'type' => 'switch',
                            'title' => esc_html__('Display countdown timer', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),
                         array(
                            'id' => "under-end-date",
                            'type' => 'date',
                            'title' => esc_html__('End date', 'barber'),
                            'default' => '12/28/2017',
                            'required' => array('under-display-countdown', 'equals', true),
                        ),
                        array(
                            'id' => "under-contr-day",
                            'type' => 'text',
                            'title' => esc_html__('Text display under day number', 'barber'),
                            'default' => esc_html__('D', 'barber')
                        ),  
                        array(
                            'id' => "under-contr-hour",
                            'type' => 'text',
                            'title' => esc_html__('Text display under hour number', 'barber'),
                            'default' => esc_html__('H', 'barber')
                        ),
                        array(
                            'id' => "under-contr-min",
                            'type' => 'text',
                            'title' => esc_html__('Text display under minute number', 'barber'),
                            'default' => esc_html__('M', 'barber')
                        ),
                        array(
                            'id' => "under-contr-sec",
                            'type' => 'text',
                            'title' => esc_html__('Text display under secs number', 'barber'),
                            'default' => esc_html__('S', 'barber')
                        ),                                                                           
                        array(
                            'id' => 'under-mail',
                            'type' => 'switch',
                            'title' => esc_html__('Display subcribe form', 'barber'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'barber'),
                            'off' => esc_html__('No', 'barber'),
                        ),
                        array(
                            'id' => "coming_subcribe_text",
                            'type' => 'text',
                            'title' => esc_html__('Submit button text in subcribe form', 'barber'),
                            'default' =>  esc_html__('Notify me' , 'barber'), 
                        ),                        
                    )
                ),
            );
            return $sections;
        }

        protected function apr_add_header_section_options() {
            $apr_seclect_slider = apr_seclect_slider();
            unset($apr_seclect_slider['default']);
            $header = array(
                'icon' => 'el-icon-edit',
                'icon_class' => 'icon',
                'title' => esc_html__('Header', 'barber'),
                'fields' => array(
                    array(
                        'id' => 'header-type',
                        'type' => 'image_select',
                        'title' => esc_html__('Header Type', 'barber'),
                        'subtitle' => esc_html__('Each page will have option for select header type. Header selection in each page will have higher priority than this general selection.','barber'),
                        'options' => $this->apr_header_types(),
                        'default' => '1'
                    ), 
                    array(
                        'id' => 'logo6',
                        'type' => 'media',
                        'url' => true,
                        'readonly' => false,
                        'title' => esc_html__('Logo', 'barber'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '6'
                                )),
                            ),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo6.png',
                            'height' => 50,
                            'wide' => 50
                        )
                    ),                    
                    array(
                        'id' => 'logo2',
                        'type' => 'media',
                        'url' => true,
                        'readonly' => false,
                        'title' => esc_html__('Logo', 'barber'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '2', '4'
                                )),
                            ),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo2.png',
                            'height' => 88,
                            'wide' => 107
                        )
                    ),                            
                    array(
                        'id' => 'logo3',
                        'type' => 'media',
                        'url' => true,
                        'readonly' => false,
                        'title' => esc_html__('Logo', 'barber'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '3'
                                )),
                            ),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo3.png',
                            'height' => 50,
                            'wide' => 50
                        )
                    ), 
                    array(
                        'id' => 'logo8',
                        'type' => 'media',
                        'url' => true,
                        'readonly' => false,
                        'title' => esc_html__('Logo', 'barber'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '8','9'
                                )),
                            ),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo-8.png',
                            'height' => 50,
                            'wide' => 50
                        )
                    ),   
                    array(
                        'id' => 'logo7',
                        'type' => 'media',
                        'url' => true,
                        'readonly' => false,
                        'title' => esc_html__('Logo', 'barber'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '7'
                                )),
                            ),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo7.png',
                            'height' => 228,
                            'wide' => 151
                        )
                    ),
                    array(
                        'id' => 'logo10',
                        'type' => 'media',
                        'url' => true,
                        'readonly' => false,
                        'title' => esc_html__('Logo', 'barber'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '10'
                                )),
                            ),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo10.png',
                            'height' => 86,
                            'wide' => 86
                        )
                    ),
                    array(
                        'id' => 'select-slider',
                        'type' => 'select',
                        'title' => esc_html__('Select Top Slider', 'barber'),
                        'options' => $apr_seclect_slider,
                        'desc' => esc_html__('Choose a slider to display at the top of pages. You can create a block in Static Block/Add New.', 'barber'),
                        'default' => '',
                        'required' => array(
                                array('header-type', 'equals', array(
                                '9'
                            )),
                        ),
                    ),
                    array(
                        'id' => 'header-fixed',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Fixed Header (Header displays over content)', 'barber'),
                        'default' => false,
                    ),
                    array(
                        'id' => 'header_layout_style',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Layout Style', 'barber'),
                        'options' => array(
                                "1" => esc_html__("Wide","barber"),
                                "2" => esc_html__("FullWidth","barber"),
                                "3" => esc_html__("Boxed","barber"),
                            ),
                        'default' => '2',
                        'required' => array(
                                array('header-type', 'equals', array(
                                '1', '2','9','10',
                            )),
                        ),
                    ), 
                    array(
                        'id' => 'header_layout_style_2',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Layout Style', 'barber'),
                        'options' => array(
                                "1" => esc_html__("Wide","barber"),
                                "2" => esc_html__("FullWidth","barber"),
                                "3" => esc_html__("Boxed","barber"),
                            ),
                        'default' => '3',
                        'required' => array(
                                array('header-type', 'equals', array(
                                '3', '4','6','8'
                            )),
                        ),
                    ),
                    array(
                        'id' => 'header_layout_style_3',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Layout', 'barber'),
                        'options' => array(
                                "1" => esc_html__("Wide","barber"),
                                "2" => esc_html__("FullWidth","barber"),
                                "3" => esc_html__("Boxed","barber"),
                            ),
                        'default' => '1',
                        'required' => array(
                                array('header-type', 'equals', array(
                                '5','7'
                            )),
                        ),
                    ),  
                    array(
                        'id' => 'header-search',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search', 'barber'),                        
                        'default' => true,
                        'required' => array(
                                array('header-type', 'equals', array(
                                '1', '2','3','4','5','7','9','10'
                            )), 
                        ),                            
                    ), 
                    array(
                        'id' => 'header-search-icon',
                        'type' => 'text',
                        'title' => esc_html__('Icon Search', 'barber'),   
                        'default' => 'lnr lnr-magnifier',
                        'placeholder' => esc_html__('lnr lnr-magnifier', 'barber'),
                        'required' => array('header-search', 'equals', array(
                            true
                        )), 
                        'desc' => wp_kses(__('Add icon class you want here. You can find a lot of icons in these links <a target="_blank" href="http://fontawesome.io/icons/">Awesome icon</a> or <a target="_blank" href="https://linearicons.com/free">Linearicons </a>, <a target="_blank" href="http://themes-pixeden.com/font-demos/7-stroke/">Pe stroke icon7 </a> and <a target="_blank" href="https://www.dropbox.com/s/oy8lsb7u4eli7rt/barber_font.png?dl=0">Barber icon list </a>','barber'),array(
                                'a' => array(
                                    'href'=>array(),
                                    'target' => array(),
                                    ),
                            )) 
                    ),
                     array(
                        'id' => 'header6-search',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search', 'barber'),                        
                        'default' => false,
                        'required' => array(
                                array('header-type', 'equals', array(
                                '6'
                            )),  
                        ),                       
                    ),    
                    array(
                        'id' => 'header-search-hidden',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search', 'barber'),                        
                        'default' => false,
                        'required' => array(
                                array('header-type', 'equals', array(
                                '8'
                            )),  
                        ),                       
                    ),
                    array(
                        'id' => 'header-search-icon-hidden',
                        'type' => 'text',
                        'title' => esc_html__('Icon Search', 'barber'),  
                        'default' => 'lnr lnr-magnifier',
                        'placeholder' => esc_html__('lnr lnr-magnifier', 'barber'),
                        'required' => array('header-search-hidden', 'equals', array(
                            true
                        )), 
                        'desc' => wp_kses(__('Add icon class you want here. You can find a lot of icons in these links <a target="_blank" href="http://fontawesome.io/icons/">Awesome icon</a> or <a target="_blank" href="https://linearicons.com/free">Linearicons </a>, <a target="_blank" href="http://themes-pixeden.com/font-demos/7-stroke/">Pe stroke icon7 </a> and <a target="_blank" href="https://www.dropbox.com/s/oy8lsb7u4eli7rt/barber_font.png?dl=0">Barber icon list </a>','barber'),array(
                                'a' => array(
                                    'href'=>array(),
                                    'target' => array(),
                                    ),
                            ))                         
                    ),
                    array(
                        'id' => 'header_search_style',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Search Style', 'barber'),
                        'options' => array(
                                "1" => esc_html__("Standard","barber"),
                                "2" => esc_html__("Sidebar","barber"),
                            ),
                        'default' => '1', 
                        'required' => array(
                                array('header-type', 'equals', array(
                                '1', '3','5','9'
                            )),
                        ),
                    ), 
                    array(
                        'id' => 'header_search_style_2',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Search Style', 'barber'),
                        'options' => array(
                                "1" => esc_html__("Standard","barber"),
                                "2" => esc_html__("Sidebar","barber"),
                            ),
                        'default' => '2',  
                        'required' => array(
                                array('header-type', 'equals', array(
                                '2', '4','8'
                            )),
                        ),
                    ),   
                    array(
                        'id' => 'header_search_type',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Search Type', 'barber'),
                        'options' => array(
                                "1" => esc_html__("Product (if Woocommerce enable)","barber"),
                                "2" => esc_html__("Blog","barber"),
                            ),
                        'default' => '1',                         
                    ),
                    array(
                        'id' => 'header-minicart',
                        'type' => 'switch',
                        'title' => esc_html__('Show Mini Cart', 'barber'),                      
                        'default' => true,
                        'required' => array(
                                array('header-type', 'equals', array(
                                '1', '2','3','4','5','7','9'
                            )), 
                        ),                           
                    ),
                    array(
                        'id' => 'header-cart-icon',
                        'type' => 'text',
                        'title' => esc_html__('Icon Mini Cart', 'barber'),  
                        'default' => 'icon-10',
                        'placeholder' => esc_html__('icon-10', 'barber'),
                        'required' => array('header-minicart', 'equals', array(
                            true
                        )), 
                        'desc' => wp_kses(__('Add icon class you want here. You can find a lot of icons in these links <a target="_blank" href="http://fontawesome.io/icons/">Awesome icon</a> or <a target="_blank" href="https://linearicons.com/free">Linearicons </a>, <a target="_blank" href="http://themes-pixeden.com/font-demos/7-stroke/">Pe stroke icon7 </a> and <a target="_blank" href="https://www.dropbox.com/s/oy8lsb7u4eli7rt/barber_font.png?dl=0">Barber icon list </a>','barber'),array(
                                'a' => array(
                                    'href'=>array(),
                                    'target' => array(),
                                    ),
                            ))                         
                    ),
                    array(
                        'id' => 'header-minicart-hidden',
                        'type' => 'switch',
                        'title' => esc_html__('Show Mini Cart', 'barber'),                      
                        'default' => false,
                        'required' => array(
                                array('header-type', 'equals', array(
                                '8','10'
                            )), 
                        ),                           
                    ),
                    array(
                        'id' => 'header-cart-icon-hidden',
                        'type' => 'text',
                        'title' => esc_html__('Icon Mini Cart', 'barber'),   
                        'placeholder' => esc_html__('icon-10', 'barber'),
                        'default' => 'icon-10',
                        'required' => array('header-minicart-hidden', 'equals', array(
                            true
                        )), 
                        'desc' => wp_kses(__('Add icon class you want here. You can find a lot of icons in these links <a target="_blank" href="http://fontawesome.io/icons/">Awesome icon</a> or <a target="_blank" href="https://linearicons.com/free">Linearicons </a>, <a target="_blank" href="http://themes-pixeden.com/font-demos/7-stroke/">Pe stroke icon7 </a> and <a target="_blank" href="https://www.dropbox.com/s/oy8lsb7u4eli7rt/barber_font.png?dl=0">Barber icon list </a>','barber'),array(
                                'a' => array(
                                    'href'=>array(),
                                    'target' => array(),
                                    ),
                            ))                         
                    ),
                    array(
                        'id' => 'header6-minicart',
                        'type' => 'switch',
                        'title' => esc_html__('Show Mini Cart', 'barber'),                      
                        'default' => true,
                        'required' => array(
                                array('header-type', 'equals', array(
                                '6'
                            )), 
                        ),                           
                    ),  
                    array(
                        'id' => 'header-myaccount',
                        'type' => 'switch',
                        'title' => esc_html__('Show My Account', 'barber'),                        
                        'default' => false,
                        'required' => array(
                                array('header-type', 'equals', array(
                                '1','2','3','4','5','7','8','9'
                            )), 
                        ),                            
                    ),
                    array(
                        'id' => 'header-myaccount-icon',
                        'type' => 'text',
                        'title' => esc_html__('Icon My Account', 'barber'),   
                        'placeholder' => esc_html__('lnr lnr-user', 'barber'),
                        'default' => 'lnr lnr-user',
                        'required' => array('header-myaccount', 'equals', array(
                            true
                        )),
                        'desc' => wp_kses(__('Add icon class you want here. You can find a lot of icons in these links <a target="_blank" href="http://fontawesome.io/icons/">Awesome icon</a> or <a target="_blank" href="https://linearicons.com/free">Linearicons </a>, <a target="_blank" href="http://themes-pixeden.com/font-demos/7-stroke/">Pe stroke icon7 </a> and <a target="_blank" href="https://www.dropbox.com/s/oy8lsb7u4eli7rt/barber_font.png?dl=0">Barber icon list </a>','barber'),array(
                                'a' => array(
                                    'href'=>array(),
                                    'target' => array(),
                                    ),
                            ))                          
                    ),
                    array(
                        'id' => 'header6-myaccount',
                        'type' => 'switch',
                        'title' => esc_html__('Show My Account', 'barber'),                        
                        'default' => false,
                        'required' => array(
                                array('header-type', 'equals', array(
                                '6'
                            )), 
                        ),                            
                    ),    
                    array(
                        'id' => 'header-social',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Link', 'barber'),                        
                        'default' => true,
                    ), 
                    array(
                        'id' => 'social-header-twitter',
                        'type' => 'text',
                        'title' => esc_html__('Twitter', 'barber'),
                        'default' => 'https://twitter.com/arrowpress1',
                        'placeholder' => esc_html__('http://', 'barber'), 
                        'required' => array('header-social', 'equals', array(
                            true
                        )),  
                    ),
                    array(
                        'id' => 'social-header-instagram',
                        'type' => 'text',
                        'title' => esc_html__('Instagram', 'barber'),
                        'default' => 'https://instagram.com/arrowpress',
                        'placeholder' => esc_html__('http://', 'barber'),
                        'required' => array('header-social', 'equals', array(
                            true
                        )),
                    ),
                    array(
                        'id' => 'social-header-facebook',
                        'type' => 'text',
                        'title' => esc_html__('Facebook', 'barber'),
                        'default' => 'https://facebook.com/arrowpress',
                        'placeholder' => esc_html__('http://', 'barber'),
                        'required' => array('header-social', 'equals', array(
                            true
                        )),
                    ),
                    array(
                        'id' => 'social-header-google',
                        'type' => 'text',
                        'title' => esc_html__('Google Plus', 'barber'),
                        'default' => '#',
                        'placeholder' => esc_html__('http://', 'barber'),
                        'required' => array('header-social', 'equals', array(
                            true
                        )),
                    ),        
                    array(
                        'id' => 'social-header-pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Pinterest', 'barber'),
                        'default' => '#',
                        'placeholder' => esc_html__('http://', 'barber'),
                        'required' => array('header-social', 'equals', array(
                            true
                        )),
                    ),                                
                    array(
                        'id' => 'header-sticky',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Sticky', 'barber'),
                        'default' => true
                    ),   
                    array(
                        'id' => 'header-sticky-mobile',
                        'type' => 'switch',
                        'required' => array('header-sticky', 'equals', 1,),
                        'title' => esc_html__('Enable Sticky On Mobile ', 'barber'),
                        'default' => true
                    ),      
                    array(
                        'id' => 'header_postion',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Mobile Position', 'barber'),
                        'options' => array(
                                "1" => esc_html__("Top","barber"),
                                "2" => esc_html__("Bottom","barber"),
                            ),
                        'default' => '1',                         
                    ),   
                    array(
                        'id' => 'mobile_account_tab',
                        'type' => 'switch',
                        'title' => esc_html__('[Mobile] Enable Account tab ', 'barber'),
                        'default' => true
                    ),                     
                    // array( 
                    //     'id'       => 'header_mobile_type',
                    //     'type'     => 'select_image',
                    //     'title'    => esc_html__('[Mobile] Header Mobile Type', 'barber'),
                    //     'subtitle' => esc_html__('Select header menu mobile appearance','barber'),
                    //     'desc'     => esc_html__('By default, each header will have their own mobile menu style.', 'barber'),
                    //     'options'  => Array(
                    //         Array (
                    //              'alt'  => 'Type 1',
                    //              'img'  => get_template_directory_uri() . '/inc/admin/settings/headers/header-mobile1.png',
                    //         )
                    //     ),
                    //     'default'  => '',
                    // ),                    
                ),
            );

            return $header;
        }

        public function apr_get_setting_arguments() {
            $theme = wp_get_theme();
            $args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'apr_settings',
                'display_name' => esc_html__('Apr', 'barber'),
                'display_version' => $theme->get('Version'),
                'menu_type' => 'menu',
                'allow_sub_menu' => true,
                'menu_title' => esc_html__('Apr Options', 'barber'),
                'page_title' => esc_html__('Apr', 'barber'),
                'google_api_key' => '',
                'google_update_weekly' => false,
                'async_typography' => true,
                'admin_bar' => true,
                'admin_bar_icon' => 'dashicons-admin-generic',
                'admin_bar_priority' => 50,
                'global_variable' => '',
                'dev_mode' => false,
                'update_notice' => true,
                'customizer' => true,
                'page_priority' => null,
                'page_parent' => 'themes.php',
                'page_permissions' => 'manage_options',
                'menu_icon' => '',
                'last_tab' => '',
                'page_icon' => 'icon-themes',
                'page_slug' => '',
                'save_defaults' => true,
                'default_show' => false,
                'default_mark' => '',
                'show_import_export' => true,
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                'output_tag' => true,
                'database' => '',
                'use_cdn' => true,
                // HINTS
                'hints' => array(
                    'icon' => 'el el-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'red',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => '',
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover',
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave',
                        ),
                    ),
                )
            );
            return $args;
        }

        protected function apr_header_types() {
            return array(
                '1' => array('alt' => esc_html__('Header Type 1', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-1.jpg'),
                '2' => array('alt' => esc_html__('Header Type 2', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-2.jpg'),
                '3' => array('alt' => esc_html__('Header Type 3', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-3.jpg'),
                '4' => array('alt' => esc_html__('Header Type 4', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-4.jpg'),
                '5' => array('alt' => esc_html__('Header Type 5', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-5.jpg'), 
                '6' => array('alt' => esc_html__('Header Type 6', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-6.jpg'),                                               
                '7' => array('alt' => esc_html__('Header Type 7', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-7.jpg'),                                               
                '8' => array('alt' => esc_html__('Header Type 8', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-8.jpg'),                                               
                '9' => array('alt' => esc_html__('Header Type 9', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-9.jpg')
                , 
                '10' => array('alt' => esc_html__('Header Type 10', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-10.jpg'),                                                 
            );
        }

        protected function apr_footer_types() {
            return array(
                '1' => array('alt' => esc_html__('Footer Type 1', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-1.jpg'),
                '2' => array('alt' => esc_html__('Footer Type 2', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-2.jpg'),
                '3' => array('alt' => esc_html__('Footer Type 3', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-3.jpg'),
                '4' => array('alt' => esc_html__('Footer Type 4', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-4.jpg'),
                '5' => array('alt' => esc_html__('Footer Type 5', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-5.jpg'),          
                '6' => array('alt' => esc_html__('Footer Type 6', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-6.jpg'),          
                '7' => array('alt' => esc_html__('Footer Type 7', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-7.jpg'),    
                '8' => array('alt' => esc_html__('Footer Type 8', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-8.jpg'),                
                '9' => array('alt' => esc_html__('Footer Type 9', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-9.jpg'),                
                '10' => array('alt' => esc_html__('Footer Type 10', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-10.jpg'),                
            );
        }
        
        protected function apr_preload_types() {
            return array(
                '1' => array('alt' => esc_html__('Preload Type 1', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/preload/preload-1.jpg'),
                '2' => array('alt' => esc_html__('Preload Type 2', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/preload/preload-2.jpg'),
                '3' => array('alt' => esc_html__('Preload Type 3', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/preload/preload-3.jpg'),
                '4' => array('alt' => esc_html__('Preload Type 4', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/preload/preload-4.jpg'),
                '5' => array('alt' => esc_html__('Preload Type 5', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/preload/preload-5.jpg'),                                                
                '6' => array('alt' => esc_html__('Preload Type 6', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/preload/preload-6.jpg'),                                                
                '7' => array('alt' => esc_html__('Preload Type 7', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/preload/preload-7.jpg'),                                                
                '8' => array('alt' => esc_html__('Preload Type 8', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/preload/preload-8.jpg'),                                                
                '9' => array('alt' => esc_html__('Preload Type 9', 'barber'), 'img' => get_template_directory_uri() . '/inc/admin/settings/preload/preload-9.jpg'),                                                   
            );
        }

    }

    
    function apr_get_framework_settings() {
        global $aprReduxSettings;
        $aprReduxSettings = new Apr_Framework_Settings();
        return $aprReduxSettings;
    }
    apr_get_framework_settings();
}