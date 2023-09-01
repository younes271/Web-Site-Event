(function ($) {
	'use strict'
	window.dahzWidget = {
		navMenu : function( $target ){
			this.$target = $target;
			this.$target.addClass( 'dahz-initialized' );
			$( 'li.menu-item-has-children > span', this.$target ).on( 'click', { _this : this }, this.navOpener );
		},
		woocommerceTitle:function( $target ){
			this.$target = $target;
			this.$target.addClass( 'dahz-initialized' );
		},
		productCategories:function( $target ){
			this.$target = $target;
			this.$target.addClass( 'dahz-initialized' );
			this.init();
		}
	};
	window.InitDahzWidget = function(){
		var amount, from, to, precision, results_obj, data;
		$( '.widget_nav_menu:not(.dahz-initialized)' ).each(function(){
			$( this ).dahzWidgetNav();
		});
		$( '.widget.woocommerce:not(.dahz-initialized)' ).each(function(){
			if( $('.widget-title', this ).length ){
				$( this ).dahzWidgetWooTitle();
			}
		});
		$('.widget_product_categories').each(function(){
			$( this ).dahzWidgetProductCategories();
		});
		if ($('.woocs_converter_shortcode').length) {
			$('.woocs_converter_shortcode_button').off('click');
			$('.woocs_converter_shortcode_button').on( 'click',function () {
				amount = $(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_amount').eq(0).val();
				from = $(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_from').eq(0).val();
				to = $(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_to').eq(0).val();
				precision = $(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_precision').eq(0).val();
				results_obj = $(this).parent('.woocs_converter_shortcode').find('.woocs_converter_shortcode_results').eq(0);
				$(results_obj).val(woocs_lang_loading + ' ...');
				data = {
					action: "woocs_convert_currency",
					amount: amount,
					from: from,
					to: to,
					precision: precision
				};

				$.post(woocs_ajaxurl, data, function (value) {
					$(results_obj).val(value);
				});

				return false;

			});
		}
	}
	dahzWidget.navMenu.prototype.navOpener = function( e ){

		var _this = e.data._this, $target = $( this );
		e.preventDefault();
		if( $target.hasClass('df-arrow-up') ) {
			$target.next( '.sub-menu' ).slideUp();
			$target.removeClass( 'df-arrow-up' );
			$target.addClass( 'df-arrow-down' );
		} else {
			$target.next( '.sub-menu' ).slideDown('slow',function(){
				$(window).trigger('dahzForceLazyload');
			});
			$target.removeClass( 'df-arrow-down' );
			$target.addClass( 'df-arrow-up' );
		}
	};

	dahzWidget.woocommerceTitle.prototype.titleOpener = function( e ){
		$(this).toggleClass('active');
		$(this).next().slideToggle('200',function(){
			$(window).trigger('dahzForceLazyload');
		}).css('display', 'flex');

	};

	dahzWidget.productCategories.prototype.init = function( e ){
		var _this = this, $selector = $( '.product-categories .cat-item.cat-parent', _this.$target );
		if ( $selector.find('.children').length ) {

			if ( $selector.find('.count').length ) {

				$('.count', $selector )
				.append('<span class="cat-toggle"><span data-uk-icon="df_dots-horizontal" class="df-arrow-down"></span></span>')
				.promise()
				.done( function(){
					$( '.count', $selector ).on( 'click',{ _this: _this }, _this.togglePCatList );
				});

			} else {

				$selector
				.append('<span class="count"><span class="cat-toggle"><span data-uk-icon="df_dots-horizontal" class="df-arrow-down"></span></span></span>')
				.promise()
				.done( function() {
					$('.count', $selector ).on( 'click',{ _this: _this }, _this.togglePCatList );
				});

			}

		}
	};

	dahzWidget.productCategories.prototype.togglePCatList = function( e ){
		$(window).trigger('dahzForceLazyload');
		$( this ).siblings('.children').slideToggle('200', function(){$(window).trigger('dahzForceLazyload');}).toggleClass('active');
	};


	$.fn.dahzWidgetNav = function(){
		new dahzWidget.navMenu( this );
		return this;
	}
	$.fn.dahzWidgetWooTitle = function(){
		new dahzWidget.woocommerceTitle( this );
		return this;
	}
	$.fn.dahzWidgetProductCategories = function(){
		new dahzWidget.productCategories( this );
		return this;
	}


	$( document ).on('ready',function(){
		InitDahzWidget();
	});
	$( document ).on('footer_widget_1_ready', function(){
		InitDahzWidget();
	});
	$( document ).on('footer_widget_2_ready', function(){
		InitDahzWidget();
	});
	$( document ).on('footer_widget_3_ready', function(){
		InitDahzWidget();
	});
	$( document ).on('footer_widget_4_ready', function(){
		InitDahzWidget();
	});

}(jQuery))
