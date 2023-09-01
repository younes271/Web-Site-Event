(function ($) {
	"use strict";
	window.dahzWidget = window.dahzWidget || {};
	dahzWidget.uploader = {
		meta_image_frame: false,
		init: function () {
			$(document).on('click', '.dahz-widget-image-uploader--upload', dahzWidget.uploader.upload);
			$(document).on('click', '.dahz-widget-image-uploader--remove', dahzWidget.uploader.remove);
		},
		upload: function (e) {
			e.preventDefault();
			var _this = this,
				$container = $(_this).parents('.dahz-widget-image-uploader');
			// If the frame already exists, re-open it.
			if (dahzWidget.uploader.meta_image_frame) {
				dahzWidget.uploader.meta_image_frame.open();
			} else {
				// Sets up the media library frame
				dahzWidget.uploader.meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
					title: 'Image',
					button: {
						text: 'Select Image'
					},
					library: {
						type: 'image'
					}
				});
			}
			dahzWidget.uploader.meta_image_frame.off('select');
			// Runs when an image is selected.
			dahzWidget.uploader.meta_image_frame.on('select', function () {

				var attachment = dahzWidget.uploader.meta_image_frame.state().get('selection').first().toJSON(),
					attachment_url, attachment_width, attachment_height;

				if (typeof attachment !== 'object') return;

				if (typeof attachment.sizes !== 'undefined') {
					if (typeof attachment.sizes.medium !== 'undefined') {
						attachment_url = attachment.sizes.medium.url;
						attachment_width = attachment.sizes.medium.width;
						attachment_height = attachment.sizes.medium.height;
					} else if (typeof attachment.sizes.medium !== 'undefined') {
						attachment_url = attachment.sizes.medium.url;
						attachment_width = attachment.sizes.medium.width;
						attachment_height = attachment.sizes.medium.height;
					} else if (typeof attachment.sizes.full !== 'undefined') {
						attachment_url = attachment.sizes.full.url;
						attachment_width = attachment.sizes.full.width;
						attachment_height = attachment.sizes.full.height;
					} else {
						attachment_url = attachment.url;
						attachment_width = attachment.width;
						attachment_height = attachment.height;
					}
				} else {
					attachment_url = attachment.url;
					attachment_width = attachment.width;
					attachment_height = attachment.height;
				}

				dahzWidget.uploader.setImage($container, attachment_url, attachment_width, attachment_height);
				dahzWidget.uploader.setValue($container, attachment.id);

			});

			// Opens the media library frame.
			dahzWidget.uploader.meta_image_frame.open();
		},
		remove: function (e) {
			e.preventDefault();
			var _this = this,
				$container = $(_this).parents('.dahz-widget-image-uploader');
			$('.dahz-widget-image-uploader--image img', $container).remove();
			dahzWidget.uploader.setValue($container, '');
		},
		setImage: function ($container, url, width, height) {
			var imageUpload = $('.dahz-widget-image-uploader--image img', $container);
			if (imageUpload.length) {
				imageUpload.attr('src', url);
				imageUpload.attr('width', width);
				imageUpload.attr('height', height);
			} else {
				$('.dahz-widget-image-uploader--image', $container).prepend(
					'<img src="' + url + '" width="' + width + '" height="' + height + '" >'
				);
			}
		},
		setValue: function ($container, value) {
			$('.dahz-widget-image-uploader--value', $container)
				.val(value)
				.change();
		}
	}
	$(document).on('ready', function () {
		dahzWidget.uploader.init();
	});
})(jQuery);