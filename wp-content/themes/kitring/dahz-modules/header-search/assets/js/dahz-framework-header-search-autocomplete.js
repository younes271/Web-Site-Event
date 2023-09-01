(function ($) {
	"use strict";
	window.dahz = window.dahz || {};

	_.extend(dahz.headerSearch, {
		listener: function () {
			dahz.headerSearch.input.unbind('keyup');

			dahz.headerSearch.input
				.keyup(_.debounce(dahz.headerSearch.searchProcess, 1000))
				/* .autocomplete({
					source: function (request, response) {
						$.ajax({
							url: dahzFramework.ajaxURL,
							async: true,
							type: 'POST',
							data: {
								action: 'dahz_framework_search_autocomplete_src',
								keyword: request.term
							},
							beforeSend: function () {
								$('.ds-search__keyword-suggested-wrapper').html('');
							},
							success: function (data) {
								if (data) response(JSON.parse(data));
							}
						});
					},
					appendTo: '.ds-search__keyword-suggested',
					classes: {
						'ui-autocomplete': 'ds-search__keyword-suggested-wrapper'
					},
					delay: 0,
					minLength: 2,
				})
				.on('autocompletefocus', { _this: _self }, _self.autocompleteSearchFocus); */
		}
	});

})(jQuery);