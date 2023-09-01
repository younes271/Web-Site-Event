<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Ajax Navigation
 * @version 1.1.4
 */

if ( !defined( 'YITH_WOOCOMPARE' ) ) { exit; } // Exit if accessed directly

    /**
     * YITH WooCommerce Ajax Navigation Widget
     *
     * @since 1.0.0
     */
    class apr_compare_YITH_Woocompare_Widget extends WP_Widget {

        function __construct() {
            $widget_ops = array (
	            'classname' => 'yith-woocompare-widget',
	            'description' => esc_html__( 'The widget shows the list of products added in the comparison table.', 'barber'
	            )
            );

	        parent::__construct( 'yith-woocompare-widget', esc_html__( 'YITH WooCommerce Compare Widget', 'barber' ), $widget_ops );
        }


        function widget( $args, $instance ) {
            global $yith_woocompare;

            /**
             * WPML Support
             */
            $lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : false;

            extract( $args );

            do_action ( 'wpml_register_single_string', 'Widget', 'widget_yit_compare_title_text', $instance['title'] );
            $localized_widget_title = apply_filters ( 'wpml_translate_single_string', $instance['title'], 'Widget', 'widget_yit_compare_title_text' );

            echo $before_widget . $before_title . $localized_widget_title . $after_title; ?>

            <ul class="products-list" data-lang="<?php echo esc_attr($lang) ?>">
                <?php echo $yith_woocompare->obj->list_products_html(); ?>
            </ul>

            <?php echo $after_widget;
        }


        function form( $instance ) {
            global $woocommerce;

            $defaults = array(
                'title' => '',
            );

            $instance = wp_parse_args( (array) $instance, $defaults ); ?>

            <p>
                <label>
                    <?php echo esc_html__( 'Title', 'barber' ) ?>:<br />
                    <input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_html($instance['title']); ?>" />
                </label>
            </p>
        <?php
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title'] = strip_tags( $new_instance['title'] );

            return $instance;
        }

    }
