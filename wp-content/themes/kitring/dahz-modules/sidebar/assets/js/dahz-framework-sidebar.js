(function ($) {
	"use strict";
	window.dahz = window.dahz || {};
	dahz.sidebar = {
		init: function () {
			var admin = $('#wpadminbar').length ? 52 : 20;
			$('.de-main-content, .sidebar').theiaStickySidebar({
				additionalMarginTop: $('#de-header-horizontal-desktop .de-header__sticky--wrapper').length ? ($('.de-header__section--show-on-sticky').height() + admin) : admin
			});
		},
	};
	$(document).on('ready', function() {
		dahz.sidebar.init();
	});
})(jQuery);