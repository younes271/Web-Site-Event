(function($) {
    'use strict';
    window.dahz = window.dahz || {};

    dahz.stickyHeader = {
        set: function(options) {
            _.extend(
                dahz.stickyHeader,
                _.pick(
                    options || {},
                    'elementDesktop',
                    'elementMobile',
                    'offsetTop',
                    'offsetTopMobile',
                    'offsetBottom',
                    'edgeY',
                    'firstWindowWidth',
					'framedWidth',
                    'headerOffsetTop'
                )
            );
        },
        init: function() {
			
			var defaultOffset = $( '#de-header-horizontal-desktop .de-header__sticky--wrapper' ).data( 'header-sticky-offset' );

            dahz.stickyHeader.set({
                elementDesktop: $( '#de-header-horizontal-desktop .de-header__sticky--wrapper' ),
                elementMobile: $('#de-header-horizontal-mobile .de-header__sticky--wrapper'),
                offsetTop: $('#wpadminbar').height(),
                offsetTopMobile: $(window).outerWidth() > 600 ? $('#wpadminbar').height() : 0,
                offsetBottom: $(window).height(),
                edgeY: 100,
                firstWindowWidth: $(window).outerWidth() > 600 ? 'desktop' : 'mobile',
				framedWidth: $(window).outerWidth() >= 960 ? typeof defaultOffset == 'number' ? defaultOffset : 0 : 0,
                headerOffsetTop: $('#de-site-header').length ? $('#de-site-header').offset().top : 0
            });
            dahz.stickyHeader.sticky(dahz.stickyHeader.elementDesktop, 'desktop');
            dahz.stickyHeader.sticky(dahz.stickyHeader.elementMobile, 'mobile');
            $('.de-header__sticky--wrapper').off('active');
            $('.de-header__sticky--wrapper').off('inactive');
            $('.de-header__sticky--wrapper').on('active', dahz.stickyHeader.onActive);
            $('.de-header__sticky--wrapper').on('inactive', dahz.stickyHeader.onInactive);

        },
        onActive: function() {
            if (typeof $('#de-header-horizontal').data('transparency') !== 'undefined') {
                $('#de-header-horizontal')
                    .addClass('no-transparency')
                    .removeClass($('#de-header-horizontal').data('transparency'));
            }
            if (
                typeof $(this).data('header-sticky-box-shadow') !== 'undefined' &&
                $(this).data('header-sticky-box-shadow') !== ''
            ) {
                $(this).addClass($(this).data('header-sticky-box-shadow'));
            }
        },
        onInactive: function() {
            if (typeof $('#de-header-horizontal').data('transparency') !== 'undefined') {
                $('#de-header-horizontal')
                    .removeClass('no-transparency')
                    .addClass($('#de-header-horizontal').data('transparency'));
            }
            if (
                typeof $(this).data('header-sticky-box-shadow') !== 'undefined' &&
                $(this).data('header-sticky-box-shadow') !== ''
            ) {
                $(this).removeClass($(this).data('header-sticky-box-shadow'));
            }
        },
        sticky: function($el, type) {

            var offsetTop = 0

            if (type == 'mobile') {
                offsetTop = dahz.stickyHeader.offsetTopMobile;
                dahz.stickyHeader.set({
                    offsetTopMobile: dahz.stickyHeader.offsetTopMobile + $($el).outerHeight()
                });
            } else {
                offsetTop = dahz.stickyHeader.offsetTop;
                dahz.stickyHeader.set({
                    offsetTop: dahz.stickyHeader.offsetTop + $($el).outerHeight()
                });
            }

            UIkit.sticky($el, {
                'offset': ( offsetTop + dahz.stickyHeader.framedWidth ),
                'top': ( ( $('#de-site-header').outerHeight() + dahz.stickyHeader.edgeY ) + ( $(window).outerHeight() ) ),
                'animation': 'uk-animation-slide-top',
                'cls-active': 'no-transparency',
            });
        },
    };

    dahz.wishlist = {
        init: function() {
            dahz.wishlist.set({
                totalItemContainer: $('.de-wishlist__total-item', $('[data-item-id="wishlist"]')),
                wishlistButton: $('.de-header__wishlist-btn', $('[data-item-id="wishlist"]'))
            });
            $(document).on('added_to_wishlist removed_from_wishlist', function() {
                dahz.wishlist.updateCount();
            });
        },
        set: function(options) {
            _.extend(
                dahz.wishlist,
                _.pick(
                    options || {},
                    'totalItemContainer',
                    'wishlistButton'
                )
            );
        },
        updateCount: function() {
            $.ajax({
                url: dahzFramework.ajaxURL,
                async: true,
                beforeSend: function() {
                    dahz.wishlist.wishlistButton.append('<div class="de-header__wishlist-btn--overlay uk-overlay-default uk-position-cover"><div class="uk-position-center" uk-spinner></div></div>');
                },
                data: {
                    action: 'dahz_framework_update_wishlist_count'
                },
                error: function() {
                    $('.de-header__wishlist-btn--overlay', dahz.wishlist.wishlistButton).remove();
                },
                dataType: 'json',
                success: function(data) {
                    $('.de-header__wishlist-btn--overlay', dahz.wishlist.wishlistButton).remove();
                    if (data.count > 0) {
                        dahz.wishlist.wishlistButton.removeClass('de-header__wishlist--empty');
                        dahz.wishlist.totalItemContainer.html(data.count);
                    } else {
                        dahz.wishlist.totalItemContainer.html('');
                        dahz.wishlist.wishlistButton.addClass('de-header__wishlist--empty');
                    }
                },
            });
        }
    };

    dahz.notices = {
        statuses: {
            error: 'danger',
            success: 'success',
            notice: 'warning'
        },
        positions: {
            error: 'top-right',
            success: 'top-right',
            notice: 'top-right'
        },
        init: function() {
            dahz.notices.set({
                $el: $('.de-notices'),
            });
            dahz.notices.show();
        },
        set: function(options) {
            _.extend(
                dahz.notices,
                _.pick(
                    options || {},
                    '$el'
                )
            );
        },
        show: function() {
            dahz.notices.$el.each(dahz.notices.showNotices);
        },
        showNotices: function(i, $el) {
            var status = $($el).data('notices-type');
            UIkit.notification({
                message: $($el).html(),
                status: dahz.notices.statuses[status],
                pos: dahz.notices.positions[status],
                timeout: 3000
            });
            $($el).remove();
        }
    };

    dahz.mobileMenu = {
        init: function() {
            dahz.mobileMenu.set({
                body: $('body')
            });
            $('#header-mobile-menu').on('shown', dahz.mobileMenu.lazyMenu);
        },
        set: function(options) {
            _.extend(
                dahz.mobileMenu,
                _.pick(
                    options || {},
                    'body'
                )
            );
        },
        renderMenu: function(data, $container) {
            $container.html(data).promise().done(function() {
                $(document).trigger('dahz_mobile_menu_loaded');
            });
        },
        lazyMenu: function() {
            var $container = $('.header-mobile-menu__container--content', $(this));
            if (!$container.data('mobile-menu-is-loaded')) {
                $.ajax({
                    url: dahzFramework.ajaxURL,
                    type: 'POST',
                    async: true,
                    beforeSend: function() {
                        $container.data('mobile-menu-is-loaded', true);
                        $container.append('<div class="header-mobile-menu__container--content--overlay uk-overlay-default uk-position-cover"><div class="uk-position-center" uk-spinner></div></div>');
                    },
                    error: function() {
                        $container.data('mobile-menu-is-loaded', false);
                    },
                    complete: function() {
                        $('.header-mobile-menu__container--content--overlay', $container).remove();
                    },
                    data: {
                        action: 'dahz_framework_render_mobile_menu_elements'
                    },
                    success: function(data) {
                        _.defer(dahz.mobileMenu.renderMenu, data, $container);
                    }
                });
            }
        },
    };

    dahz.share = {
        popup: {
            width: 600,
            height: 450
        },
        init: function() {
            $('body').on('click', 'a.ds-social-share', dahz.share.onClick);
        },
        onClick: function() {
            dahz.share.popup.top = ($(window).height() / 2) - (dahz.share.popup.height / 2);
            dahz.share.popup.left = ($(window).width() / 2) - (dahz.share.popup.width / 2);
            window.open(this.href, 'targetWindow', "\n toolbar=no,\n location=no,\n status=no,\n menubar=no,\n scrollbars=yes,\n resizable=yes,\n left=" + dahz.share.popup.left + ",\n top=" + dahz.share.popup.top + ",\n width=" + dahz.share.popup.width + ",\n height=" + dahz.share.popup.height + "\n");
            return false;
        }
    };

    dahz.backToTop = {
        scrollTop: 0,
        init: function() {
            if ($('body').hasClass('enable-back-to-top')) {
                $(window).on('scroll', dahz.backToTop.onScroll);
            }
        },
        onScroll: function() {

            dahz.backToTop.scrollTop = $(window).scrollTop();

            if (dahz.backToTop.scrollTop > 500) {
                $('.de-back-to-top').removeClass('uk-hidden uk-animation-fade uk-animation-reverse');
                $('.de-back-to-top').addClass('uk-animation-slide-right-small');
            } else {
                $('.de-back-to-top').addClass('uk-animation-slide-right-small uk-animation-fade uk-animation-reverse');
                $('.de-back-to-top').removeClass('uk-animation-slide-right-small');
            }

        }
    };

    dahz.wooPriceSlider = {
        init: function() {
            $(".price_slider").on("slidechange", dahz.wooPriceSlider.onChange);
        },
        onChange: function() {
            $(this).parents('form').trigger('submit');
        }
    };

    dahz.tableResponsive = {
        init: function() {
            $("table").wrap('<div class="uk-overflow-auto></div"');
        },
    };

    dahz.drop = {
        getBottomPosition: function($el, dataContainer) {
            var $parentMenu,
                positionTop;
			switch( dataContainer ){
				case "auto":
					$parentMenu = $el.parents('.main-menu-item');
					break;
				case "row":
					$parentMenu = $el.parents('.de-header__row');
					break;
				case "container":
					$parentMenu = $el.parents('.uk-container');
					break;
			}
			
			positionTop = $parentMenu.length ? $parentMenu.position().top : 0;
			
            return positionTop + $parentMenu.outerHeight() + parseInt($parentMenu.css('margin-top'));
        },
        getboundaryHeight: function($boundary) {
            var positionTop = $boundary.length ? $boundary.position().top : 0;
            return positionTop + $boundary.outerHeight()
        },
        getOffset: function($el, $boundary, dataContainer) {
            return dahz.drop.getboundaryHeight($boundary) - dahz.drop.getBottomPosition( $el, dataContainer );
        },
        init: function() {
            $('[data-dahz-drop]').each(function() {
                var $this = $(this),
                    dataUKDrop = $this.data('dahz-drop'),
					dataContainer = '';
                if ( ! dataUKDrop.boundaryAlign ) {
                    dataUKDrop.offset = dahz.drop.getOffset( $this, $this.parents('.de-header__section'), 'auto' );
                } else if( dataUKDrop.boundaryAlign && dataUKDrop.pos !== 'bottom-justify' ){
					dataContainer = $this.data('container');
					dataUKDrop.offset = dahz.drop.getOffset( $this, $this.parents('.de-header__section'), dataContainer );
				}
                UIkit.drop($this, dataUKDrop);
            });
        }
    };

    dahz.shop = {

        singleProduct: function() {
            $('.ds-single').each( function() {
             
                $('.woocommerce-product-gallery__trigger', this).addClass('uk-icon');

                UIkit.icon( $('.woocommerce-product-gallery__trigger', this), { icon : 'expand'});
                UIkit.icon( $('.woocommerce-product-gallery__trigger--popup-video', this), { icon : 'play'});

                UIkit.modal( $('#modal-media-video', this));
                
                UIkit.tooltip($('.tooltip', this), { pos: 'top-left' });

            });
        }

    };

    dahz.shopArchive = {
        init: function() {
            $('.de-product .de-product__item').each(function() {
                var getOuterHeightThumbAction = $('.de-product-thumbnail__action--add-to-cart a', this).width();
                var getOuterHeightThumbActionSvg = $('.de-product-thumbnail__action--add-to-cart a svg', this).width();
                var getOuterHeightThumbActionWish = $('.yith-wcwl-add-button a', this).width();
                var getOuterHeightThumbActionWishSVG = $('.yith-wcwl-add-button a svg', this).width();

                if ($('.yith-wcwl-wishlistexistsbrowse.show', this).length) {
                    var getOuterHeightThumbActionWish = $('.yith-wcwl-wishlistexistsbrowse.show a').width();
                    var getOuterHeightThumbActionWishSVG = $('.yith-wcwl-wishlistexistsbrowse.show a svg').width();
                } else if ($('.yith-wcwl-wishlistaddedbrowse.show', this).length) {
                    var getOuterHeightThumbActionWish = $('.yith-wcwl-wishlistaddedbrowse.show a').width();
                    var getOuterHeightThumbActionWishSVG = $('.yith-wcwl-wishlistaddedbrowse.show a svg').width();
                }

                $('.yith-wcwl-add-to-wishlist', this).css('right', -(getOuterHeightThumbActionWish - (getOuterHeightThumbActionWishSVG - 2)));
                $('.de-product-thumbnail__action--add-to-cart', this).css('right', -(getOuterHeightThumbAction - (getOuterHeightThumbActionSvg - 2)));
            });
        },
		updateButton:function( e, fragments, cart_hash, $button ){
			$button = typeof $button === 'undefined' ? false : $button;

			if ( $button && typeof wc_add_to_cart_params !== 'undefined' ) {

				if ( ! wc_add_to_cart_params.is_cart && $button.parent().find( '.added_to_cart' ).length === 0 ) {
					$button.attr( 'href', wc_add_to_cart_params.cart_url );
					$button.removeClass( 'ajax_add_to_cart' );
					$( 'span', $button ).html( wc_add_to_cart_params.i18n_view_cart );
				}

			}
		}
    };
	
	dahz.headerTransparent = {
		init:function(){
			
			var $headerTransparent = $( '#de-header-horizontal' ),
				$pageTitle = $( '.de-page-title' ),
				paddingPageTitle = 0;
			
			if( typeof $headerTransparent.data( 'transparency' ) !== 'undefined' && typeof $pageTitle !== 'undefined'  ){
				
				$pageTitle = $( '.de-page-title' );
				
				if( typeof $pageTitle.data( 'padding-default' ) == 'undefined' ){
					$pageTitle.data( 'padding-default', $pageTitle.css( 'padding-top' ) );
				}
				
				if( $( '#de-header-horizontal-desktop', $headerTransparent ).is( ':visible' ) ){
					
					paddingPageTitle = parseInt( $pageTitle.data( 'padding-default' ) ) + $( '#de-header-horizontal-desktop', $headerTransparent ).outerHeight();
				
					$pageTitle.css('padding-top',paddingPageTitle);
				
				} else {
					
					$pageTitle.css('padding-top','');
					
				}
				
			}
		}
	};

    dahz.widget = {

        calendar: function() {
            $('.sidebar').each(function() {
                if ( $( '.widget_calendar tfoot td a', this ).length == 0 ) {
                    $( '.widget_calendar tfoot' ).css( "display", "none" );
                }
            });
        }

    };
    
    $(document).on('ready', function() {
		
		dahz.headerTransparent.init();
		
        dahz.tableResponsive.init();
        
        dahz.drop.init();
        
        dahz.shop.singleProduct();
        
        dahz.widget.calendar();

        var docWidth = document.documentElement.offsetWidth;

        //dahz.notices.init();

        dahz.mobileMenu.init();

        dahz.share.init();

        dahz.backToTop.init();

        dahz.wooPriceSlider.init();

        $('iframe').each(function() {
            if ($(this).parents('.ds-video-cover').length) {
                UIkit.cover(this);
            }
        });

        dahz.stickyHeader.init();

        $('.footer-section__toggle-content').on('show', function() {
            $('.footer-section__toggle-content--btn', $(this).parents('.de-footer__section')).addClass('active');
        });
        $('.footer-section__toggle-content').on('hide', function() {
            $('.footer-section__toggle-content--btn', $(this).parents('.de-footer__section')).removeClass('active');
        });
        if ($('[data-item-id="wishlist"]').length) {
            dahz.wishlist.init();
        }


        $(window).on('resize', function() {
			_.defer(dahz.headerTransparent.init);
            _.defer(dahz.stickyHeader.init);
            _.defer(dahz.drop.init);
            dahz.shopArchive.init();
        });
    });

    $(document).on('ajaxComplete', function() {
       // dahz.notices.init();
    });
	
	$( document.body ).on( 'added_to_cart', dahz.shopArchive.updateButton );

    $(document).on('content_block_ready', function() {
        if (typeof dahz.stickyHeader == 'undefined' && dahz.stickyHeader.headerOffsetTop == 'undefined') return;
        var headerOffsetTop = $('#de-site-header').length ? $('#de-site-header').offset().top : 0;
        if (headerOffsetTop > dahz.stickyHeader.headerOffsetTop) {
            //dahz.stickyHeader.init();
        }
    });

    $(document).on('added_to_cart', function(e, fragments, hash, $button) {
        if (typeof fragments !== 'undefined' && typeof fragments.notice !== 'undefined') {
            //dahz.notices.showNotices(0, $(fragments.notice));
        }
    });

    $(window).on('load', function() {
        dahz.shopArchive.init();
    });

    $(document).ajaxComplete(function() {
        dahz.shopArchive.init();
    });
})(jQuery);