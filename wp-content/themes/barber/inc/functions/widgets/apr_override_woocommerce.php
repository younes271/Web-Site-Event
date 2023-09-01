<?php
add_action( 'widgets_init', 'apr_override_woocommerce_widgets', 15 );
function apr_override_woocommerce_widgets() {
    if ( class_exists( 'WC_Widget_Recent_Reviews' ) ) {
         unregister_widget( 'WC_Widget_Recent_Reviews' );
         include get_template_directory() . '/woocommerce/classes/class-wc-widget-recent-reviews.php';
         register_widget( 'WC_Widget_Recent_Reviews_Custom' );
     }
     
    if ( class_exists( 'WC_Widget_Price_Filter' ) ) {
         unregister_widget( 'WC_Widget_Price_Filter' );
         include get_template_directory() . '/woocommerce/classes/class-wc-widget-price-filter.php';
         register_widget( 'apr_filter_WC_Widget_Price_Filter' );
    }

    if ( class_exists( 'YITH_Woocompare_Widget' ) ) {
         unregister_widget( 'YITH_Woocompare_Widget' );
         include get_template_directory() . '/woocommerce/classes/class.yith-woocompare-widget.php';
         register_widget( 'apr_compare_YITH_Woocompare_Widget' );
    }

    if ( class_exists( 'WC_Widget_Products' ) ) {
         unregister_widget( 'WC_Widget_Products' );
         include get_template_directory() . '/woocommerce/classes/class-wc-widget-products.php';
         register_widget( 'apr_WC_Widget_Products' );
    }

    if ( class_exists( 'WC_Widget_Top_Rated_Products' ) ) {
         unregister_widget( 'WC_Widget_Top_Rated_Products' );
         include get_template_directory() . '/woocommerce/classes/class-wc-widget-top-rated-products.php';
         register_widget( 'apr_WC_Widget_Top_Rated_Products' );
    }
    if ( class_exists( 'YITH_WCAN_Reset_Navigation_Widget' ) ) {
         unregister_widget( 'YITH_WCAN_Reset_Navigation_Widget' );
         include get_template_directory() . '/woocommerce/classes/class.yith-wcan-reset-navigation-widget.php';
         register_widget( 'apr_reset_filter_YITH_WCAN_Reset_Navigation_Widget' );
    }
} 