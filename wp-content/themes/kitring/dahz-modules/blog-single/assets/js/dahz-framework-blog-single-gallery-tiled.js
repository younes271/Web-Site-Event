(function ($) {
	"use strict";
	window.DahzPostGallery = function ($target) {
		this.$target = $target;

		this.init();
	}

	DahzPostGallery.prototype.init = function () {
		if ($(this.$target).data('view') === 'masonry' && $(window).outerWidth() >= 1200) {
			this.setSize();
		} else {
			this.resetSize();
		}

		this.setTilt();

	}

	DahzPostGallery.prototype.setSize = function () {
		var _self = this, count, gutter, gutterData, parentwidth, elementwidth, elementheight, width, height, sizer;
		gutterData = $(this.$target).data('gutter');
		count = $('.de-post-gallery__inner-item', this.$target).length;
		gutter = 20;

		if (typeof gutterData !== 'undefined') {
			switch (gutterData) {
				case 'uk-grid-small':
					gutter = 10;
					break;
				case 'uk-grid-medium':
					gutter = 30;
					break;
				case 'uk-grid-large':
					gutter = 40;
					break;
				case 'uk-grid-collapse':
					gutter = 0;
					break;
			}
		}

		$(this.$target).css({
			'margin-left': -gutter
		});

		parentwidth = $(this.$target).outerWidth();

		$('.de-post-gallery__inner-item', this.$target).each(function (index, element) {
			elementwidth = $(element).data('width');

			elementheight = $(element).data('height');

			sizer = parentwidth * 1 / 6;

			width = parentwidth * elementwidth / 6;

			height = parentwidth * elementheight / 6;

			$(element).parent().css({
				'width': width,
				'height': height - gutter,
				'padding-left': gutter,
				'margin-top': 0,
				'margin-bottom': gutter,
			});

			$(element).css({
				'height': '100%',
				'padding-bottom': '0'
			});

			if (index + 1 === count) _self.setIsotope(sizer);
		});
	}

	DahzPostGallery.prototype.resetSize = function () {
		var _self = this, count;

		count = $('.de-post-gallery__inner-item', this.$target).length;

		$('.de-post-gallery__inner-item', this.$target).each(function (index, element) {
			$(element).parent().attr('style', '');

			$(element).attr('style', '');

			if (index + 1 === count) _self.resetIsotope();
		});
	}

	DahzPostGallery.prototype.setIsotope = function (sizer) {
		$(this.$target).isotope({
			itemSelector: '.de-post-gallery--tiled__item',
			masonry: {
				columnWidth: sizer,
				horizontalOrder: true,
				fitWidth: true
			}
		});
	}

	DahzPostGallery.prototype.resetIsotope = function () {
		$(this.$target).isotope('destroy');
	}

	DahzPostGallery.prototype.setTilt = function () {
		if ($(this.$target).data('hover-effect') === 'parallax-tilt' || $(this.$target).data('hover-effect') === 'parallax-tilt-glare') {
			$('.de-post-gallery--tiled__item', this.$target).tilt({
				'perspective': '4000'
			});
		}
	}

	$.fn.DahzPostGallery = function () {
		new DahzPostGallery(this);

		return this;
	};

	$(document).on('ready',function () {
		$('.de-post-gallery--tiled').each(function () {
			$(this).DahzPostGallery();
		});
	});

	$(window).resize(function () {
		console.log($(this).outerWidth())
		$('.de-post-gallery--tiled').each(function () {
			$(this).DahzPostGallery();
		});
	});

}(jQuery));
