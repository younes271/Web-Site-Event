<?php
/**
 * Main class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Ajax Navigation
 * @version 1.3.2
 */

if ( ! defined( 'YITH_WCAN' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'apr_reset_filter_YITH_WCAN_Reset_Navigation_Widget' ) ) {
    /**
     * YITH WooCommerce Ajax Navigation Widget
     *
     * @since 1.0.0
     */
    class apr_reset_filter_YITH_WCAN_Reset_Navigation_Widget extends WP_Widget {

        function __construct() {
            $widget_ops  = array( 'classname' => 'yith-woocommerce-ajax-product-filter yith-woo-ajax-reset-navigation yith-woo-ajax-navigation woocommerce widget_layered_nav', 'description' => esc_html__( 'Reset all filters set by YITH WooCommerce Ajax Product Filter', 'barber' ) );
            $control_ops = array( 'width' => 400, 'height' => 350 );
            parent::__construct( 'yith-woo-ajax-reset-navigation', esc_html__( 'YITH WooCommerce Ajax Reset Filter', 'barber' ), $widget_ops, $control_ops );
        }


        function widget( $args, $instance ) {
            global $_chosen_attributes, $woocommerce;

            extract( $args );

            $_attributes_array = yit_wcan_get_product_taxonomy();

            if ( apply_filters( 'yith_wcan_show_widget', ! is_post_type_archive( 'product' ) && ! is_tax( $_attributes_array ) ) ) {
                return;
            }

            // Price
            $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : 0;
            $min_price = number_format($min_price, 2, '.', ' ');
            $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : 0;
            $max_price = number_format($max_price, 2, '.', ' ');

            ob_start();

            if ( count( array($_chosen_attributes) ) > 0 || $min_price > 0 || $max_price > 0 || apply_filters( 'yith_woocommerce_reset_filters_attributes', false ) ) {
                $title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) : '';
                $label = isset( $instance['label'] ) ? apply_filters( 'yith-wcan-reset-navigation-label', $instance['label'], $instance, $this->id_base ) : '';

                $link = '';

                //clean the url
                if( ! isset( $_GET['source_id'] ) ){
                    $link = yit_curPageURL();
                    foreach ( (array) $_chosen_attributes as $taxonomy => $data ) {
                        $taxonomy_filter = str_replace( 'pa_', '', $taxonomy );
                        $link            = remove_query_arg( 'filter_' . $taxonomy_filter, $link );
                    }

                    $link = remove_query_arg( array( 'min_price', 'max_price', 'product_tag' ), $link );
                }

                else{
                    //Start filter from Product category Page
                    $term = get_term_by( 'id', $_GET['source_id'], 'product_cat' );
                    $link = get_term_link( $term, $term->taxonomy  );
                }


                $link = apply_filters( 'yith_woocommerce_reset_filter_link', $link );

                echo $before_widget;
                if ( $title ) {
                    echo $before_title . $title . $after_title;
                }
                $button_class = apply_filters( 'yith-wcan-reset-navigation-button-class', "yith-wcan-reset-navigation button" );
                echo '<div class="name_label widget-content">'.esc_html__('Price : ', 'barber').'<span>'.get_woocommerce_currency_symbol().$min_price.' - '.get_woocommerce_currency_symbol().$max_price.'</span></div>'; 
                echo "<div class='yith-wcan clear clear-all'><a class='{$button_class}' href='{$link}'>" .$label." ". "<i class='fa fa-trash-o' aria-hidden='true'></i></a></div>";
                echo $after_widget;
                echo ob_get_clean();
            }
            else {
                ob_end_clean();
                echo substr( $before_widget, 0, strlen( $before_widget ) - 1 ) . ' style="display:none">' . $after_widget;
            }
        }


        function form( $instance ) {
            global $woocommerce;

            $defaults = array(
                'title' => '',
                'label' => esc_html__( 'Reset All Filters', 'barber' )
            );

            $instance = wp_parse_args( (array) $instance, $defaults ); ?>

            <p>
                <label>
                    <strong><?php esc_html_e( 'Title', 'barber' ) ?>:</strong><br />
                    <input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
                </label>
            </p>
            <p>
                <label>
                    <strong><?php esc_html_e( 'Button Label', 'barber' ) ?>:</strong><br />
                    <input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'label' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'label' )); ?>" value="<?php echo esc_attr($instance['label']); ?>" />
                </label>
            </p>

        <?php
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags( $new_instance['title'] );
            $instance['label'] = strip_tags( $new_instance['label'] );

            return $instance;
        }

    }
}