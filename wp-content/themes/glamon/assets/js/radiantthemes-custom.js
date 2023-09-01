(function($){
	"use strict";
	jQuery(document).on("ready", function(){
		// SCROLL TO TOP
		jQuery(window).on("scroll", function(){
			if (jQuery(this).scrollTop()>100){
				jQuery(".scrollup").addClass("active");
			}else{
				jQuery(".scrollup").removeClass("active");
			}
		});
		jQuery(".scrollup").on("click", function(){
	   		jQuery("html, body").animate({scrollTop:0},600);
	  		return false;
		});
		// FLYOUT SEARCH BAR
		jQuery(".header-flyout-searchbar i, .header-flyout-searchbar span[class*='ti-']").on("click", function(){
			jQuery("body").toggleClass("flyout-searchbar-active");
		});
		jQuery(".flyout-search-close").on("click", function(){
			jQuery("body").removeClass("flyout-searchbar-active");
		});
		// SIDEBAR SEARCH BUTTON CHANGE
		jQuery(".search-form, .woocommerce-product-search").each(function(){
			jQuery(this).find("input[type=submit]").replaceWith("<button type='submit'><i class='fa fa-search'></i></button>");
		});
		// BLOG COMMENT BUTTON CHANGE
		jQuery(".comments-area .comment-form > p input[type='submit']").each(function(){
			jQuery(this).replaceWith("<button type='submit'><span>" + jQuery(this).attr("value") + "</span></button>");
		});
		jQuery(".comments-area .comment-form > p input[type='reset']").each(function(){
			jQuery(this).replaceWith("<button type='reset'><span>" + jQuery(this).attr("value") + "</span></button>");
		});
		// TOOLTIP
		jQuery("[data-toggle='tooltip']").tooltip();
		// GDPR NOTICE
		jQuery(".gdpr-notice .close").on("click", function(){
			jQuery.cookie("gdpr-notice", "closed", {
				expires: 3, // 3 DAYS
				path: '/',
			});
		});
		if( jQuery.cookie("gdpr-notice") === "closed" ){
		} else {
			jQuery(".gdpr-notice").removeClass("i-am-hidden");
		}
		// HEADER RESPONSIVE NAV / MOBILE MENU
		jQuery(".header-responsive-nav").each(function(){
			jQuery(this).sidr({
				side: 'right',
				speed: 600,
				displace: false,
				renaming: false,
				source: '.mobile-menu',
				name: 'mobile-menu',
				onOpen: function(){
					jQuery("body").addClass("mobile-menu-open");
				},
				onClose: function(){
					jQuery("body").removeClass("mobile-menu-open");
				},
			});
			jQuery(".mobile-menu-close, .overlay").on("click", function(){
				jQuery.sidr('close', 'mobile-menu');
			});
		});
		// HAMBURGER SIDR
		jQuery(".header-hamburger-menu").each(function(){
			jQuery(this).sidr({
				side: 'right',
				speed: 400,
				displace: false,
				renaming: false,
				source: '.hamburger-menu-holder',
				name: 'hamburger-menu',
				onOpen: function(){
					jQuery("body").addClass("hamburger-menu-open");
				},
				onClose: function(){
					jQuery("body").removeClass("hamburger-menu-open");
				},
			});
			jQuery(".hamburger-menu-close-lines").on("click", function(){
				jQuery.sidr('close', 'hamburger-menu');
			});
		});
		// SIDEBAR MENU
		jQuery("body[data-header-style='header-style-three']").each(function(){
			jQuery(this).find(".vc_section, .vc_row").removeAttr("style data-vc-full-width data-vc-full-width-init data-vc-stretch-content");
		});
		jQuery(".responsive-sidemenu-open").each(function(){
			jQuery(this).sidr({
				side: 'left',
				speed: 600,
				displace: false,
				renaming: false,
				source: '.sidemenu-holder',
				name: 'sidemenu',
				onOpen: function(){
					jQuery("body").addClass("sidemenu-open");
				},
				onClose: function(){
					jQuery("body").removeClass("sidemenu-open");
				},
			});
			jQuery(".responsive-sidemenu-close").on("click", function(){
				jQuery.sidr('close', 'sidemenu');
			});
		});
		jQuery("body[data-header-style='header-style-three'] .nav li").on("click", function(){
			jQuery(this).children("ul").slideToggle(500);
		});
		// SIDEMENU SIDR
		jQuery(".header-sidebar-menu-open, .mobile-sidebar-menu-open").each(function(){
			jQuery(this).sidr({
				side: 'left',
				speed: 300,
				displace: false,
				renaming: false,
				source: '.sidemenu-holder',
				name: 'sidemenu',
				onOpen: function(){
					jQuery("body").addClass("sidemenu-open");
				},
				onClose: function(){
					jQuery("body").removeClass("sidemenu-open");
				},
			});
			jQuery(".sidemenu-close").on("click", function(){
				jQuery.sidr('close', 'sidemenu');
			});
		});
		jQuery("body[data-header-style='header-style-four'] .nav li").on("click", function(){
			jQuery(this).children("ul").slideToggle(500);
		});
		// ANIOPEN MENU BAR
		jQuery(".header-aniopen-menu").on("click", function(){
			jQuery("body").toggleClass("aniopen-menu-active");
		});
		// FLYOUT MENU BAR
		jQuery(".header-flyout-menu").on("click", function(){
			jQuery("body").addClass("flyout-menu-active");
		});
		jQuery(".flyout-menu-close").on("click", function(){
			jQuery("body").removeClass("flyout-menu-active");
		});
		jQuery("body[data-header-style='header-style-five'] .flyout-menu-nav li").on("click", function(){
			jQuery(this).children("ul").slideToggle(500);
		});
		// SLIDEOUT MENU BAR
		jQuery(".header-slideout-menu").on("click", function(){
			jQuery("body").addClass("slideout-menu-active");
		});
		jQuery(".slideout-menu-close").on("click", function(){
			jQuery("body").removeClass("slideout-menu-active");
		});
		jQuery("body[data-header-style='header-style-fourteen'] .slideout-menu-nav li").on("click", function(){
			jQuery(this).children("ul").slideToggle(500);
		});
		// FLEXI MENU BAR
		jQuery(".header-flexi-menu").on("click", function(){
			jQuery("body").addClass("flexi-menu-active");
		});
		jQuery(".flexi-menu-close").on("click", function(){
			jQuery("body").removeClass("flexi-menu-active");
		});
		jQuery("body[data-header-style='header-style-seven'] .flexi-menu-nav li").on("click", function(){
			jQuery(this).children("ul").slideToggle(500);
		});
		// RADIANTTHEMES MEGA MENU
		jQuery(".sidr .menu-item-has-children").each(function(){
			jQuery(this).children("ul, .rt-mega-menu").css({
				"display": "none",
			});
			jQuery(this).append("<span class='radiantthemes-open-submenu'></span>");
			jQuery(this).find(".radiantthemes-open-submenu").on("click", function(){
				jQuery(this).parent(".menu-item-has-children").toggleClass("radiantthemes-menu-open");
				jQuery(this).parent(".menu-item-has-children").children("ul, .rt-mega-menu").slideToggle(700);
			});
		});
		// PAGE TRANSITION
		jQuery("body[data-page-transition='1'] a:not(.fancybox):not(.video-link):not([data-fancybox])").each(function(){
			jQuery(this).on("click", function(event){
				let PageLink = jQuery(this).attr("href");
				if ( "#" == PageLink ) {
				} else if ( PageLink.startsWith("#") ) {
				} else {
					event.preventDefault();
					jQuery("body").addClass("page-transition-active");
					setTimeout(function(){
						window.location.href = PageLink ;
					}, 700);
				}
			});
		});
		// PRODUCT QUANTITY
		jQuery(".shop_single .quantity input[type=number]").each(function(){
			jQuery(this).addClass("form-control");
			jQuery(this).parent().addClass("input-group");
			jQuery(this).before("<div class='input-group-addon quantity-decrease'>-</div>");
			jQuery(this).after("<div class='input-group-addon quantity-increase'>+</div>");
			jQuery(this).parent().find(".quantity-decrease").on("click", function(){
				if ( jQuery(this).parent().find("input[type=number]").val() == jQuery(this).parent().find("input[type=number]").attr("min") ) {
					alert("Sorry! You're already on lowest value.");
				} else {
					jQuery(this).parent().find("input[type=number]").val( +jQuery(this).parent().find("input[type=number]").val() - 1 );
				}
			});
			jQuery(this).parent().find(".quantity-increase").on("click", function(){
				jQuery(this).parent().find("input[type=number]").val( +jQuery(this).parent().find("input[type=number]").val() + 1 );
			});
		});
		// MATCHHEIGHT
		jQuery(".matchHeight").matchHeight();
		// ONEPAGENAV
		jQuery("ul.menu.single-page-mode").onePageNav({
			currentClass: "current-menu-item",
			changeHash: true,
			scrollSpeed: 1000,
			easing: "swing",
		});
		// WOW
		var wow = new WOW({
			boxClass: 'wow',
			animateClass: 'animated',
			mobile: true,
			live: true,
			scrollContainer: null,
		});
		wow.init();
		// NICESCROLL
		if( jQuery(window).width() > 767 ){
			jQuery(".infinity-scroll").niceScroll({
				cursorcolor: jQuery("body").data("nicescroll-cursorcolor"),
				cursorwidth: jQuery("body").data("nicescroll-cursorwidth"),
				cursorborder: "none",
				cursorborderradius: "0",
			});
		}
		// STICKY
		jQuery(".radiantthemes-sticky-style-one").sticky();
		jQuery(window).on("scroll", function(){
			jQuery(".radiantthemes-sticky-style-two").each(function(){
				if ( jQuery(window).scrollTop() > ( jQuery(this).innerHeight() + 75 ) ) {
					jQuery(this).addClass("delayed-sticky-mode");
				} else {
					jQuery(this).removeClass("delayed-sticky-mode");
				}
				if ( jQuery(window).scrollTop() > ( jQuery(this).innerHeight() + 150 ) ) {
					jQuery(this).addClass("delayed-sticky-mode-acivate");
					jQuery(".wraper_header").css({
						"padding-bottom" : jQuery(this).innerHeight() + "px",
					});
				} else {
					jQuery(this).removeClass("delayed-sticky-mode-acivate");
					jQuery(".wraper_header").css({
						"padding-bottom" : "0",
					});
				}
				if ( jQuery(window).scrollTop() > jQuery(this).data("delay") ) {
					jQuery(this).addClass("i-am-delayed-sticky");
				} else {
					jQuery(this).removeClass("i-am-delayed-sticky");
				}
			});
		});
		// RATINA
		jQuery("img").attr("data-no-retina", "");
		jQuery(".radiantthemes-retina img").removeAttr("data-no-retina");
		// FANCYBOX
        jQuery(".fancybox").fancybox({
            animationEffect: "zoom-in-out",
            animationDuration: 500,
            zoomOpacity: "auto",
        });
	});
	jQuery(window).on("load", function(){
		// PROLOADER
		setTimeout(function(){
			jQuery(".preloader").addClass("loaded");
	    }, jQuery(".preloader").data("preloader-timeout") );
	    // PAGE TRANSITION
		setTimeout(function(){
			jQuery(".page-transition-layer").removeClass("i-am-active");
		}, 700);
		// MATCHHEIGHT
		setTimeout(function(){
			jQuery(".matchHeight").matchHeight();
	    }, 2000);
	    // ISOTOPE
		setTimeout(function(){
			jQuery(".isotope-blog-style").isotope({
				itemSelector: '.isotope-blog-style-item',
				layoutMode: 'masonry',
			});
		}, 100);
		// STUCKING FOOTER
		if ( jQuery(window).width() > 768 ) {
			jQuery(document).ready( StuckingFooter );
			jQuery(window).resize( StuckingFooter );
			function StuckingFooter(){
				jQuery(".footer-custom-stucking-container").css({
					"height" : jQuery(".footer-custom-stucking-mode").innerHeight() ,
				});
			};
		}
		// RADIANTTHEMES COUNTER
		setTimeout(function(){
			jQuery(".radiantthemes-counterup").each(function(){
				jQuery(this).text( jQuery(this).data("counterup-value") );
			});
		}, 1);
	});
})(jQuery);