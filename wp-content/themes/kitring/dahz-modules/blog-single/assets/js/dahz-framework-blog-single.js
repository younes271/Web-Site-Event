(function ($) {
	"use strict";
	window.dahz = window.dahz || {};

	dahz.blogSingle = {
		init: function(){
			dahz.blogSingle.set({
				$relatedItemContainer : $('[data-single-related-is-loaded="false"]'),
				$relatedContainer : $( '.ds-single__section-related' )
			});
			dahz.blogSingle.lazyRelated();			
		},
		set: function( options ){
			_.extend(
				dahz.blogSingle, 
				_.pick(
					options || {}, 
					'$relatedItemContainer',
					'$relatedItem',
					'$relatedContainer'
				)
			);
			dahz.blogSingle.relatedSlideToShow = 3;
		},
		renderRelated: function( data ){
			dahz.blogSingle.$relatedItemContainer.html( data.related_loop_html ).promise().done( function() {
				dahz.blogSingle.set({
					$relatedItem : $( '.de-related-post__item', dahz.blogSingle.$relatedItemContainer ),
					$relatedContainer : $( '.ds-single__section-related' )
				});
			});
		},
		getRelated : function(){
			$.ajax({
				url: dahzFramework.ajaxURL,
				beforeSend:function(){
					dahz.blogSingle.$relatedItemContainer.attr( 'data-single-related-is-loaded', 'true' );
					dahz.blogSingle.$relatedItemContainer.append( '<div class="uk-height-small"><div class="de-sc-lazy-load--overlay uk-overlay-default uk-position-cover"><div class="uk-position-center" uk-spinner></div></div></div>' );
					dahz.blogSingle.set({
						$relatedItemContainer : $('[data-single-related-is-loaded="true"]')
					});
				},
				type: 'POST',
				data: {
					action: 'dahz_framework_blog_single_lazy_related',
					id: dahz.blogSingle.$relatedItemContainer.data( 'id' ),
				},
				complete:function(){
					$( '.de-sc-lazy-load--overlay', dahz.blogSingle.$relatedItemContainer ).remove();
				},
				dataType:'json',
				success: function success(data) {
					_.defer( dahz.blogSingle.renderRelated, data );
				}
			});
		},
		lazyRelated: function(){
			UIkit.scrollspy( dahz.blogSingle.$relatedItemContainer, {});
			dahz.blogSingle.$relatedItemContainer.on( 'inview', dahz.blogSingle.getRelated );
		}
	};
	$( document ).on( 'ready', dahz.blogSingle.init );
	
})(jQuery);