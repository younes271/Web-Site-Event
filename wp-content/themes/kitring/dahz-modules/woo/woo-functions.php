<?php

if( ! function_exists( 'dahz_framework_woo_get_account_menu_item_icons' ) ){
	
	function dahz_framework_woo_get_account_menu_item_icons( $endpoint ){
		
		$icons = array(
			'dashboard'       => '<span class="uk-margin-small-right" data-uk-icon="user"></span>',
			'orders'          => '<span class="uk-margin-small-right" data-uk-icon="df_cart-bag"></span>',
			'downloads'       => '<span class="uk-margin-small-right" data-uk-icon="push"></span>',
			'edit-address'    => '<span class="uk-margin-small-right" data-uk-icon="home"></span>',
			'payment-methods' => '<span class="uk-margin-small-right" data-uk-icon="credit-card"></span>',
			'edit-account'    => '<span class="uk-margin-small-right" data-uk-icon="file-edit"></span>',
			'customer-logout' => '<span class="uk-margin-small-right" data-uk-icon="sign-out"></span>',
		);
		
		return isset( $icons[ $endpoint ] ) ? $icons[ $endpoint ] : '';
		
	}
	
}

if ( ! function_exists( 'dahz_framework_woo_custom_breadcrumbs_default' ) ) {

	add_filter( 'woocommerce_breadcrumb_defaults', 'dahz_framework_woo_custom_breadcrumbs_default' );
	/**
	 * Customize and add new class for breadcrumbs by ui-kit
	 * 
	 * @author Rama | Dahz
	 * @version 1.0
	 */
	function dahz_framework_woo_custom_breadcrumbs_default( $defaults ){

		if( class_exists('WooCommerce') && !is_shop() ){
			$breadcrumbClass = 'uk-margin uk-margin-top uk-padding-remove-left uk-padding-remove-right';
		} else {
			$breadcrumbClass = '';
		}

		return array(
            'delimiter'   => '',
            'wrap_before' => '<nav class="woocommerce-breadcrumb uk-breadcrumb uk-text-small '. esc_attr( $breadcrumbClass ) .'">',
            'wrap_after'  => '</nav>',
            'before'      => '<li>',
            'after'       => '</li>',
            'home'        => esc_html_x( 'Home', 'breadcrumb', 'kitring' ),
        );
	}


}