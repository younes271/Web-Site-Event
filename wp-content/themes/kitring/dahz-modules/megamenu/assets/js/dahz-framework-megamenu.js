(function ($) {
	"use strict";
	window.dahz = window.dahz || {};

	dahz.megamenu = {
		init: function(){
			dahz.megamenu.set({
				megaMenuContainer : $( 'ul[data-megamenu-loaded="false"]' ),
				megaMenuElement : $( '.de-megamenu-sub' ),
				viewPort : $( '.de-site' ),
				document : $( document )
			});
			dahz.megamenu.megaMenuContainer.on( 'mouseenter', dahz.megamenu.lazyRenderring );
		},
		set: function( options ){
			_.extend(
				dahz.megamenu, 
				_.pick(
					options || {}, 
					'megaMenuContainer', 
					'megaMenuElement', 
					'viewPort', 
					'document'
				) 
			);
		},
		render: function( data ){
			dahz.megamenu.megaMenuContainer.replaceWith( data ).promise().done( function(){
				dahz.megamenu.set({
					megaMenuContainer : $( 'ul[data-megamenu-loaded="false"]' ),
					megaMenuElement : $( '.de-megamenu-sub' ),
					viewPort : $( '.de-site' )
				});
			});
			dahz.megamenu.document.trigger('mega_menu_ready');
		},
		lazyRenderring:_.debounce( function(){
			$.ajax({
				url: dahzFramework.ajaxURL,
				type: 'POST',
				async: true,
				beforeSend: function() {
					dahz.megamenu.megaMenuContainer.off( 'mouseenter' );
					dahz.megamenu.megaMenuContainer.attr( 'data-megamenu-loaded','true' );
				},
				data: {
					action: 'dahz_framework_get_lazy_menu',
					menu: dahz.megamenu.megaMenuContainer.data( 'menu' ),
					header_section: dahz.megamenu.megaMenuContainer.data( 'header-section' )
				},
				success: function( data ) {
					_.defer( dahz.megamenu.render, data );
				}
			});
		}),
	};
	
	dahz.megamenu.init();
	
})(jQuery);