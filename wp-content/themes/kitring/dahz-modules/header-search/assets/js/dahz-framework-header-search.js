(function ($) {
	"use strict";
	window.dahz = window.dahz || {};

	dahz.headerSearch = {
		init: _.once(function ($target) {
			dahz.headerSearch.set({
				modal: $target,
				input: $('input[name="s"]', $target),
				loader: $('[data-uk-spinner]', $target),
				result: $('.de-header-search__result', $target)
			});

			dahz.headerSearch.input.focus();

			dahz.headerSearch.listener();

			dahz.headerSearch.modal.on('hide', this.searchFlush);
		}),
		set: function (options) {
			_.extend(
				dahz.headerSearch,
				_.pick(
					options || {},
					'modal',
					'input',
					'loader',
					'result'
				)
			);
		},
		listener: function () {
			dahz.headerSearch.input.unbind('keyup');

			dahz.headerSearch.input.keyup(_.debounce(dahz.headerSearch.searchProcess, 1000));
		},
		searchProcess: function () {
			var keyword = $(this).val();

			if (keyword.length >= 2) {
				dahz.headerSearch.searchContentRender(keyword);
			} else {
				dahz.headerSearch.searchFlush();
			}
		},
		searchContentRender: function (keyword) {
			$.ajax({
				url: dahzFramework.ajaxURL,
				type: 'POST',
				data: {
					action: 'dahz_framework_search_product_render',
					keyword: keyword
				},
				beforeSend: function () {
					dahz.headerSearch.loader.removeClass('uk-invisible');

					dahz.headerSearch.result.removeClass('de-header-search__result--found');
				},
				success: function (response) {
					if (response === '') {
						dahz.headerSearch.loader.addClass('uk-invisible');

						dahz.headerSearch.result.html('<span class="uk-modal-title">' + dahzFramework.language.emptyMessage + '</span>');
					} else {
						dahz.headerSearch.loader.addClass('uk-invisible');

						dahz.headerSearch.result.html(response).addClass('de-header-search__result--found');
					}
				}
			});
		},
		searchFlush: function () {
			dahz.headerSearch.input.val('');

			dahz.headerSearch.result
				.html('')
				.removeClass('de-header-search__result--found');
		},
	};

	$('#header-search-modal').on('show', function () {
		dahz.headerSearch.init($(this));
	});

})(jQuery);