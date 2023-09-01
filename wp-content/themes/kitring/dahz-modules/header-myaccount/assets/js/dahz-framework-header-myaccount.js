(function ($) {
	"use strict";
	window.dahz = window.dahz || {};

	dahz.headerMyaccount = {
		init: function(){
			$( '#header-myaccount-dropdown' ).on( 'shown', dahz.headerMyaccount.lazyAccount );
			$( '#header-my-account-modal' ).on( 'shown', dahz.headerMyaccount.lazyAccount );
		},
		renderAccount: function( data, $container ){
			
			$container.html( data ).promise().done( function() {
				$( document ).trigger( 'dahz_header_myaccount_loaded' );
			});
			
		},
		lazyAccount: function(){
			var layout = $( this ).data( 'myaccount-style' ), $container;

			if( layout == 'as-popup' ){
				$container = $( '.header-myaccount__modal-content--container', $( this ) );
			} else {
				$container = $( this );
			}
			if( !$container.data('header-my-account-is-loaded') ){
				$.ajax({
					url: dahzFramework.ajaxURL,
					type: 'POST',
					async: true,
					beforeSend: function () {
						$container.data( 'header-my-account-is-loaded', true );
						$container.append( '<div class="uk-height-small header-my-account--overlay uk-overlay-default uk-position-cover"><div class="uk-position-center" data-uk-spinner></div></div>' );
					},
					error:function(){
						$container.data( 'header-my-account-is-loaded', false );
					},
					complete:function(){
						$( '.header-my-account--overlay', $container ).remove();
					},
					data: {
						action: 'dahz_framework_header_lazy_myaccount',
						data: {
							'myaccount_content_style': layout
						}
					},
					success: function (data) {
						_.defer( dahz.headerMyaccount.renderAccount, data, $container );
					}
				});
			}
		},
	};
	
	dahz.headerMyaccount.init();
	
})(jQuery);