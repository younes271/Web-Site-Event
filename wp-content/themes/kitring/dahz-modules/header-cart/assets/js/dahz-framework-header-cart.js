(function ($) {
	"use strict";
	window.dahz = window.dahz || {};

	dahz.headerCart = {
		init: function () {
			dahz.headerCart.set({
				miniCart: $('.ds-mini-cart__item'),
				miniCartContainer: $('.de-header__mini-cart-container')
			});

			$( document ).on( 'wc_fragments_loaded', dahz.headerCart.loadMiniCart );
			$( document ).on( 'wc_fragments_refreshed', dahz.headerCart.loadMiniCart );
			$( document ).on( 'dahz_mobile_menu_loaded', dahz.headerCart.loadMiniCart );
		},
		loadMiniCart:function(){
			dahz.headerCart.miniCartContainer.attr( 'data-mini-cart-is-loaded', 'false' );
			dahz.headerCart.lazyCart();
		},
		set: function (options) {
			_.extend(
				dahz.headerCart,
				_.pick(
					options || {},
					'miniCart',
					'miniCartContainer'
				)
			);
		},
		decodeUrlParameter: function(str){
			return decodeURIComponent((str+'').replace(/\+/g, '%20'));
		},
		renderCart: function (data) {
			
			var $itemContainer = $( '.de-mini-cart__item-outer-container', $( data ) ),
				totalPrice = '',
				totalItems = '';
			$( '.de-header__mini-cart-btn--overlay', $( '.de-header__mini-cart-btn' ) ).remove();
			if( $itemContainer.length && !$itemContainer.hasClass( 'de-mini-cart__item-outer-container--empty' ) ){
				totalPrice = dahz.headerCart.decodeUrlParameter( $itemContainer.data( 'total-price' ) ),
				totalItems = $itemContainer.data( 'total-items' );
				$( '.de-header__mini-cart-btn .de-cart__total-price' ).html( totalPrice );
				$( '.de-header__mini-cart-btn .de-cart__total-item' ).html( totalItems );
				$( '.de-header__mini-cart-btn' ).removeClass( 'de-header__mini-cart--empty' );
			} else {
				$( '.de-header__mini-cart-btn .de-cart__total-price' ).html( '' );
				$( '.de-header__mini-cart-btn .de-cart__total-item' ).html( '' );
				$( '.de-header__mini-cart-btn' ).addClass( 'de-header__mini-cart--empty' );
			}
			
			dahz.headerCart.miniCartContainer.html(data).promise().done(function () {
				$( document ).trigger( 'dahz_mini_cart_ready' );
			});
		},
		lazyCart: function () {
			if ( dahz.headerCart.miniCartContainer.attr( 'data-mini-cart-is-loaded' ) === 'false' ) {
				$.ajax({
					url: dahzFramework.ajaxURL,
					type: 'POST',
					async: true,
					beforeSend: function () {
						dahz.headerCart.miniCartContainer.attr( 'data-mini-cart-is-loaded', 'true' );
						$( '.de-header__mini-cart-btn' ).append( '<div class="de-header__mini-cart-btn--overlay uk-overlay-default uk-position-cover"><div class="uk-position-center" uk-spinner></div></div>' );
					},
					error:function(){
						dahz.headerCart.miniCartContainer.attr( 'data-mini-cart-is-loaded', 'false' );
						$( '.de-header__mini-cart-btn--overlay', $( '.de-header__mini-cart-btn' ) ).remove();
					},
					data: {
						action: 'dahz_framework_header_lazy_mini_cart'
					},
					success: function (data) {
						_.defer(dahz.headerCart.renderCart, data);
					}
				});
			}
		},
	};

	dahz.headerCart.init();

})(jQuery);