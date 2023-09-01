(function ($) {
	'use strict'
	window.dahz = window.dahz || {};
	dahz.blogAgnes = {
		init: function(){
			$( '.agnes' ).each( dahz.blogAgnes.createObject );
		},
		createObject: function (i, $el) {
			return new dahz.blogAgnes({
				target: this,
				$target: $el
			});
		},
	};
	dahz.blogAgnes = _.extend( function( options ){
		_.extend( this, _.pick( options || {}, 'target', '$target' ) );
		this.init();
	}, dahz.blogAgnes );

	_.extend( dahz.blogAgnes.prototype, {
		init: function () {
			var _this = this;
			$('.de-archive', _this.$target).imagesLoaded(function () {
				$('.de-archive', _this.$target).isotope({
					itemSelector: '.entry-item'
				});
			});
		}
	});
	dahz.blogAgnes.init();
})(jQuery);