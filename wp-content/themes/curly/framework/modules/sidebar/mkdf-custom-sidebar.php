<?php

/**
 * Mikado Sidebar
 * Class for adding custom widget area and choose them on single pages/posts/portfolios
 */
if (!class_exists('CurlyMikadofSidebar')) {
    class CurlyMikadofSidebar
    {
        var $sidebars = array();
        var $stored = "";

        // load needed stuff on widget page
        function __construct() {
            $this->stored = 'mkdf_sidebars';
            $this->title = esc_html__('Custom Widget Area', 'curly');

            // Add custom sidebar form
            add_action( 'widgets_admin_page', array( $this, 'add_custom_sidebar_form' ) );

            add_action('load-widgets.php', array(&$this, 'load_assets'), 5);
            add_action('widgets_init', array(&$this, 'register_custom_sidebars'), 1000);
            add_action('wp_ajax_mkdf_ajax_delete_custom_sidebar', array(&$this, 'delete_sidebar_area'), 1000);
        }

        function add_custom_sidebar_form() {
            ob_start();
            $nonce = '<input type="hidden" name="edgtf-delete-sidebar" value="' . wp_create_nonce('edgtf-delete-sidebar') . '" />';
            echo "\n<script type='text/html' id='edgtf-add-widget'>";
            echo "\n  <form class='edgtf-add-widget wp-block' method='POST' data-type='core/widget-area'>";
            echo "\n  <h3>" . esc_html($this->title) . "</h3>";
            echo "\n    <span class='input_wrap'><input type='text' value='' placeholder = '" . esc_attr__('Enter Name of the new Widget Area', 'curly') . "' name='edgtf-add-widget' /></span>";
            echo "\n    <input class='button' type='submit' value='" . esc_attr__('Add Widget Area', 'curly') . "' />";
            echo "\n    " . $nonce;
            echo "\n  </form>";
            echo "\n</script>\n";
            echo ob_get_clean();
        }

        //load css, js and add hooks to the widget page
        function load_assets() {
            add_action('load-widgets.php', array(&$this, 'add_sidebar_area'), 100);

            wp_enqueue_script('curly-mkdf-sidebar', MIKADO_ROOT . '/framework/admin/assets/js/mkdf-ui/mkdf-sidebar.js');
            wp_enqueue_style('curly-mkdf-sidebar', MIKADO_ROOT . '/framework/admin/assets/css/mkdf-sidebar.css');

            wp_localize_script(
                'mkdf-admin-sidebar-script',
                'mikado',
                array(
                    'customSidebars' => get_option( $this->stored ),
                )
            );
        }

        //widget form template
        function template_add_widget_field() {
            $nonce = '<input type="hidden" name="mkdf-delete-sidebar" value="' . wp_create_nonce('mkdf-delete-sidebar') . '" />';

            echo "\n<script type='text/html' id='mkdf-add-widget'>";
            echo "\n  <form class='mkdf-add-widget wp-block' method='POST' data-type='core/widget-area'>";
            echo "\n  <h3>" . esc_html($this->title) . "</h3>";
            echo "\n    <span class='input_wrap'><input type='text' value='' placeholder = '" . esc_attr__('Enter Name of the new Widget Area', 'curly') . "' name='mkdf-add-widget' /></span>";
            echo "\n    <input class='button' type='submit' value='" . esc_attr__('Add Widget Area', 'curly') . "' />";
            echo "\n    " . $nonce;
            echo "\n  </form>";
            echo "\n</script>\n";
        }

        //add sidebar area to the db
        function add_sidebar_area() {
            if (!empty($_POST['mkdf-add-widget'])) {
                $this->sidebars = get_option($this->stored);
	            $name           = $this->get_name( sanitize_text_field( $_POST['mkdf-add-widget'] ) );

                if (empty($this->sidebars)) {
                    $this->sidebars = array($name);
                } else {
                    $this->sidebars = array_merge($this->sidebars, array($name));
                }

                update_option($this->stored, $this->sidebars);
                wp_redirect(admin_url('widgets.php'));
                die();
            }
        }

        //delete sidebar area from the db
        function delete_sidebar_area() {
            check_ajax_referer('mkdf-delete-sidebar');

            if (!empty($_POST['name'])) {
	            $name           = stripslashes( sanitize_text_field( $_POST['name'] ) );
                $this->sidebars = get_option($this->stored);

                if (($key = array_search($name, $this->sidebars)) !== false) {
                    unset($this->sidebars[$key]);
                    update_option($this->stored, $this->sidebars);
                    echo "sidebar-deleted";
                }
            }

            die();
        }

        //checks the user submitted name and makes sure that there are no colitions
        function get_name($name) {
            if (empty($GLOBALS['wp_registered_sidebars'])) {
                return $name;
            }

            $taken = array();
            foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
                $taken[] = $sidebar['name'];
            }

            if (empty($this->sidebars)) {
                $this->sidebars = array();
            }
            $taken = array_merge($taken, $this->sidebars);

            if (in_array($name, $taken)) {
                $counter = substr($name, -1);
                $new_name = !is_numeric($counter) ? $name . " 1" : substr($name, 0, -1) . ((int)$counter + 1);
                $name = $this->get_name($new_name);
            }

            return $name;
        }

        //register custom sidebar areas
        function register_custom_sidebars() {
            if (empty($this->sidebars)) {
                $this->sidebars = get_option($this->stored);
            }

            $args = array(
                'before_widget' => '<div class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="mkdf-widget-title-holder"><h4 class="mkdf-widget-title">',
                'after_title' => '</h4></div>'
            );

            $args = apply_filters('curly_mkdf_custom_widget_args', $args);

            if (is_array($this->sidebars)) {
                foreach ($this->sidebars as $sidebar) {
                    $args['name'] = $sidebar;
					$args['id']  = sanitize_title($sidebar);
                    $args['class'] = 'mkdf-custom';
                    register_sidebar($args);
                }
            }
        }
    }
}