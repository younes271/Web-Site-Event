(function ($) {
    "use strict";
	//custom function showing current slide
    var $status = $('.pagingInfo');
    var $slickElement = $('.slick-counter-slide');
    $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
        //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
        var i = (currentSlide ? currentSlide : 0) + 1;
        $status.text(i + '/' + slick.slideCount);
    });
	
	//custom function showing current slick slide
	var $numbernext = $('.number-next');
	var $numberprev = $('.number-prev');
    var $slickElement = $('.slick-dot');

	$slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
		//currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
		var i = (currentSlide ? currentSlide : 0) + 2;
		$numbernext.text(i + ' / ' + slick.slideCount);
	});
	$slickElement.on('init reInit afterChange', function (event, slick, currentSlide, prevSlide) {
		//currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
		var i = (currentSlide ? currentSlide : 0) + 1;
		$numberprev.text(i + ' / ' + slick.slideCount);
	});
	// Media product details
    if(!!$.prototype.elevateZoom) {
        $("img.zoom").elevateZoom({ zoomType: "inner", cursor: "crosshair", gallery:'thumbs_list_frame', imageCrossfade: true });
    }
    $(document).ready(function() {
		if($('header').hasClass('header-v9')){
			var s = $(".header-v9");
			var pos = s.position();	
			$(window).scroll(function() {
				var windowpos = $(window).scrollTop();
				if (windowpos >= pos.top & windowpos <=10000) {
					s.addClass("stick_header9");
				} else {
					s.removeClass("stick_header9");	
				}
			});
			var heightHeader = $('.header-v9').height();
			var heightWd = $(window).height();
			$('.banner-type6 .banner-img').css('height', (heightWd - heightHeader) + 'px' );
		}
	});
	
    $(window).load(function() {
        /* Filter isotop */
		var $grid = $('.isotope');
		var container = $('.isotope').isotope({
            itemSelector: '.item',
            layoutMode: 'fitRows',
            getSortData: {
                name: '.item'
            }
        });
		
		var container = $('.isotope.gallery-masonry').isotope({
            itemSelector: '.item',
            layoutMode: 'masonry',
            getSortData: {
                name: '.item'
            }
        });
		var container = $('.isotope.gallery-masonry_2').isotope({
            itemSelector: '.item',
            layoutMode: 'masonry',
            getSortData: {
                name: '.item'
            }
        });
		var container = $('.isotope.gallery-masonry_3').isotope({
            itemSelector: '.item',
            layoutMode: 'packery',
            getSortData: {
                name: '.item'
            }
		});
		var container = $('.isotope.packery_layout').isotope({
            itemSelector: '.item',
            layoutMode: 'packery',
            getSortData: {
                name: '.item'
            }
		});
        $('.instagram_parkery').isotope({
          layoutMode: 'packery',
          itemSelector: '.instagram-img',
          percentPosition: true,
            getSortData: {
                name: '.instagram-img'
            },
            transitionDuration:"0.7s",
            masonry : {
                columnWidth:".instagram-img"
            }
        });
		$('.grid-isotope').isotope({
		  itemSelector: '.grid-item',
		  masonry: {
			columnWidth: '.grid-item'
		  }
		});
		
        $('.btn-filter').on( 'click', '.button', function() {
            var filterValue = $(this).attr('data-filter');
            container.isotope({ filter: filterValue });
        });
        $('.btn-filter').each( function( i, buttonGroup ) {
            var buttonGroup = $(buttonGroup);
            buttonGroup.on( 'click', '.button', function() {
                buttonGroup.find('.active').removeClass('active');
                $(this).addClass('active');
            });
        });
    });
	var $grid = $('.isotope');
	// filter items on button click
	$('.button-group').on( 'click', 'button', function() {
	  var filterValue = $(this).attr('data-filter');
	  $grid.isotope({ filter: filterValue });
	  $('.button-group button').removeClass('is-checked');
	  $(this).addClass('is-checked');
	}); 
    //like count gallery
    $('body').on('click', '.apr-post-like', function (event) {
        event.preventDefault();
        var heart = $(this);
        var post_id = heart.data("post_id");
        var like_type = heart.data('like_type') ? heart.data('like_type') : 'post';
        heart.html("<i id='icon-like' class='fa fa-heart-o'></i><i id='icon-spinner' class='fa fa-spinner fa-spin'></i>");
        $.ajax({
            type: "post",
            url: ajax_var.url,
            data: "action=apr-post-like&nonce=" + ajax_var.nonce + "&apr_post_like=&post_id=" + post_id + "&like_type=" + like_type,
            success: function (count) {
                if (count.indexOf("already") !== -1)
                {
                    var lecount = count.replace("already", "");
                    if (lecount === " 0")
                    {
                        lecount = " ".apr_params.apr_like_text;
                    }
                    heart.prop('title', apr_params.apr_like_text);
                    heart.removeClass("liked");
                    heart.html("<i id='icon-unlike' class='fa fa-heart-o'></i>" + ' ' + lecount);
                }
                else
                {
                    heart.prop('title', apr_params.apr_unlike_text);
                    heart.addClass("liked");
                    heart.html("<i id='icon-like' class='fa fa-heart-o'></i>" + ' ' + count);
                }
            }
        });
    });	
	// Fix Height menu vertical
	var height = $(window).height();
	var width = $(window).width();
	var heightNav = $('.header-sidebar').height();
	var heightNavMenu = $('.mega-menu').height();
	
	if( heightNav > height ){
		$('.header-ver').addClass('header-scroll');
	}
	if(width < 992){
		if( heightNavMenu > height ){
			$('.header-center').addClass('header-scroll');
		}
	}
		//Menu double
		if($(window).width() > 991){
			  var item = $('.mega-menu').children('li').length,
			  half = Math.round(item / 2),
			  mid = $('.mega-menu>li:nth-child(' + half + ')'),
			  logo = $('.kad-header-logo'),
			  menu = $('.kad-header-menu');
			  mid.after(logo);
			  menu.css('width', '100%');
		}  	
    $(document).ready(function () {
						// Instagram Fix Height
		var heightIns = $('.instagram-type1').height();
		$('.instagram-type1 .title-insta').css('height', heightIns + 120 + 'px' );
		
		// Submenu
		$(".mega-menu .caret-submenu").on('click', function(e){
		   $(this).toggleClass('active');
		   $(this).siblings('.sub-menu').toggle(300);
		});
		
		//Tooltip
        $('[data-toggle="tooltip"]').tooltip();
		
		// Preloader
		$('.preloader').delay(1200).fadeOut();
		
		// Fancybox
		$(".fancybox").on("click", function () {
            $.fancybox({
                href: this.href,
                type: $(this).data("type")
            }); // fancybox
            return false;
        }); // on
		
		$(".fancybox-thumb").fancybox({
			prevEffect	: 'none',
			nextEffect	: 'none',
			helpers	: {
				title	: {
					type: 'outside'
				},
				thumbs	: {
					width	: 70,
					height	: 50
				}
			}
		});
		$(".fancybox-thumb-member").fancybox({
			prevEffect	: 'none',
			nextEffect	: 'none',
			helpers	: {
				title	: {
					type: 'outside'
				},
				thumbs	: {
					width	: 70,
					height	: 50
				}
			}
		});
		
		var heightHeader = $('.site-header').height();
		var heightFooter = $('footer').height();
		if($(window).width() < 992){
			if($('.site-header').hasClass('header-bottom')){
				$('footer').css('margin-bottom', heightHeader + 'px');
			}
		}
		if($(window).width() > 767){
			if($('.footer').hasClass('footer-fixed')){
				$('#page').css('padding-bottom', heightFooter + 'px');
			}
		}
		
		if($('header').hasClass('header-v7')){
			$('.open-menu-mobile').on('click', function(){
				$('.overlay').css('display', 'none');
			});
			$('.open-menu').on('click', function(){
				$('.overlay').css('display', 'block');
			})
		}
		

		// Animate top
		$.browser = {
            msie: false,
            version: 0
        };
		if( navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || 
			navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || 
			navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || 
			navigator.userAgent.match(/Windows Phone/i) ){ 
			var arrowpress_touch_device = true; 
		}else{ 
			var arrowpress_touch_device = false; 
		}
		if( !arrowpress_touch_device && ( !$.browser.msie || (parseInt($.browser.version) > 8)) ){
			// item animate
			$('.animate-top').each(function(){
				var animate_item = $(this);
				if( animate_item.offset().top > $(window).scrollTop() + $(window).height() ){
					animate_item.css({ 'opacity':0, 'padding-top':20 });
				}else{ return; }	

				$(window).scroll(function(){
					if( $(window).scrollTop() + $(window).height() > animate_item.offset().top + 100 ){
						animate_item.animate({ 'opacity':1, 'padding-top':0 }, 1200);
					}
				});					
			});
			
		// do not animate on scroll in mobile
		}else{
			return;
		}	
		
        var color = $('.ultsl-stop').css("color");
        $('.ultsl-stop').css('background',color);

        $("a.grouped_elements").fancybox();
        $('img').hover(function(e){
            $(this).data("title", $(this).attr("title")).removeAttr("title");
        });    
        $("a.cart_label").click(function(event){
            event.preventDefault();
        }); 
        
        //validate form
        $('#commentform').validate();
		
        //animation
        $('.animated').appear(function() {
            var item = $(this);
            var animation = item.data('animation');
            if ( !item.hasClass('visible') ) {
                var animationDelay = item.data('animation-delay');
                if ( animationDelay ) {
                    setTimeout(function(){
                        item.addClass( animation + " visible" );
                    }, animationDelay);
                } else {
                    item.addClass( animation + " visible" );
                }
            }
        });
		
        //One page
        $('a[href*="#"]:not([href="#"]).scroll-down ,a[href*="#"]:not([href="#"]).scroll-to-bottom ').click(function(){
			$('a[href*="#"]:not([href="#"]).scroll-down ,a[href*="#"]:not([href="#"]).scroll-to-bottom').removeClass('active');
			$(this).addClass('active');
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
				|| location.hostname == this.hostname) {
				var target = $(this.hash),           
				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				   
				if (target.length){
					$('html,body').animate({
					  scrollTop: target.offset().top - 80
					}, 500);
					return false;
				}
			}
        });

        $('.main-navigation ul.mega-menu > li > a[href*="#"]:not([href="#"])').click(function(){
			$('.main-navigation ul.mega-menu > li > a[href*="#"]:not([href="#"])').removeClass('active');
			$(this).addClass('active');
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
				|| location.hostname == this.hostname){
				var target = $(this.hash),           
				target = target.length ? target : $('[name=' + this.hash.slice(1) +']'); 
				if (target.length){
					$('html,body').animate({
					  scrollTop: target.offset().top - 110
					}, 500);
					return false;
				}
			}
        });
                
    });
	
	//Coming-soon date
	$('#getting-started').countdown(apr_params.under_end_date).on('update.countdown', function(event) {
		var $this = $(this);
		if (event.elapsed) {
		  $this.html(event.strftime(''
         + '<div class="coming-timer"><span>%D</span><span>'+apr_params.apr_text_day+'</span></div> '
         + '<div class="coming-timer"><span>%H</span><span>'+apr_params.apr_text_hour+'</span></div>'
         + '<div class="coming-timer"><span>%M</span><span>'+apr_params.apr_text_min+'</span></div>'
         + '<div class="coming-timer"><span>%S</span><span>'+apr_params.apr_text_sec+'</span></div>'
		 + ''));
		} else {
		  $this.html(event.strftime(''
         + '<div class="coming-timer"><span>%D</span><span>'+apr_params.apr_text_day+'</span></div> '
         + '<div class="coming-timer"><span>%H</span><span>'+apr_params.apr_text_hour+'</span></div>'
         + '<div class="coming-timer"><span>%M</span><span>'+apr_params.apr_text_min+'</span></div>'
         + '<div class="coming-timer"><span>%S</span><span>'+apr_params.apr_text_sec+'</span></div>'
		 + ''));
		}
	});
	
	
	//Add class category
	$('.widget_categories ul').each(function(){
		if($(this).hasClass('children')) {
			$(this).parent().addClass('cat-item-parent');
		} 
	});

    $('.slick-carousel').slick({
      dots: true,
      infinite: true,
      speed: 800,
      slidesToShow: 1,
      adaptiveHeight: true,
      rtl:true,
    });
    
    $('body').on('added_to_cart', function () {
        $("a.added_to_cart").remove();
    });
	
	
    // Vertical Menu Search
	$(".search_button").click(function(){
	  $('.search-holder .searchform_wrap').addClass("opened");
	  $('html').addClass("search_opened");
	  $('.overlay').removeClass('overlay-menu');
	});
	$('.close_search_form').click(function(f){
	  f.preventDefault();
	  $('.search-holder .searchform_wrap').removeClass("opened");
	  $('html').removeClass("search_opened");
	});
	$('.overlay').click(function(f){
	  f.preventDefault();
	  $('.search-holder .searchform_wrap').removeClass("opened");
	  $('html').removeClass("search_opened");
	  $('.overlay').removeClass('overlay-menu');
	});
	
	// Vertical Menu Search
	$(".open-menu").click(function(){
	  $('html').addClass("nav-open");
	  $('.overlay').removeClass('overlay-menu');
	});
	$('.close-menu').click(function(f){
	  f.preventDefault();
	  $('html').removeClass("nav-open");
	});
	$('.overlay').click(function(f){
	  f.preventDefault();
	  $('html').removeClass("nav-open");
	});
		
	// Vertical Menu
	var $bdy = $('html');
	if ($('.site-header').hasClass('header-v5')){
		$('.open-menu-mobile').on('click',function(e){
			$(this).hide();
			$('.close-menu-mobile').show();
			if($bdy.hasClass('openmenu openmenu-hoz')) {
			  jsAnimateMenu1('close');
			} else {
			  jsAnimateMenu1('open');
			}
		});
		$('.close-menu-mobile').on('click',function(e){
			$(this).hide();
			$('.open-menu-mobile').show();
			if($bdy.hasClass('openmenu openmenu-hoz')) {
			  jsAnimateMenu1('close');
			} else {
			  jsAnimateMenu1('open');
			}
		});
		
	}else{
		$('.open-menu-mobile').on('click',function(e){
			$('.overlay').addClass('overlay-menu');
			if($bdy.hasClass('openmenu')) {
			  jsAnimateMenu2('close');
			} else {
			  jsAnimateMenu2('open');
			}
		});
		$('.close-menu-mobile').on('click',function(e){
			if($bdy.hasClass('openmenu')) {
			  jsAnimateMenu2('close');
			} else {
			  jsAnimateMenu2('open');
			}
		});	
		
		$('.overlay').click(function () {
			if($('html').hasClass('openmenu')){
				$('html').removeClass('openmenu');
			}
		});
	}
	
    //Scroll to top
    $(window).load(function () {
        var wd = $(window).width();
        if ($('.scroll-to-top').length) {
            $(window).scroll(function () {
                if ($(this).scrollTop() > $('#page:not(.fixed-header) .site-header').height() + 40) {
                    $('.scroll-to-top').css({bottom: "90px"});
                    if(apr_params.header_sticky_mobile != 1){
                        if(wd > 991){
                            if(apr_params.header_sticky == 1) {
                                $('html:not(.nav-open) .site-header').addClass("is-sticky");
                            }
                        } 
                    }else{
                        if(apr_params.header_sticky == 1) {
                            $('html:not(.nav-open) .site-header').addClass("is-sticky");
                            $('.not-found .site-header').removeClass("is-sticky");
                        }else{
                            $('.not-found .site-header').removeClass("is-sticky");
                        }
                    }
                } else {
                    $('.scroll-to-top').css({bottom: "-100px"});
                    $('.site-header').removeClass("is-sticky");
                    $('.not-found .site-header').addClass("none-sticky");
                }

				if ($(this).scrollTop() > $('#page.fixed-header .site-header').height() + 40) {
					$('html:not(.nav-open) .site-header').addClass("is-sticky");
				}
				
                if ($(this).scrollTop() > 500) {
                    $('.slide-section').addClass("active");
                }
                else {
                    $('.slide-section').removeClass("active");
                }
            });

            $('.scroll-to-top').click(function () {
                $('html, body').animate({scrollTop: '0px'}, 800);
                return false;
            });
            // $('.scroll-to-bottom').click(function () {
            //      $("html, body").animate({ scrollTop: $(document).height() }, 800);
            //     return false;
            // });
        }
        $(document).ready(function ($) {
		//Up to top
		$('.to-top').click(function () {
			$('html, body').animate({scrollTop: '0px'}, 800);
			return false;
		});
		
        var wd = $(window).width();
		$('.thumbs_list').slick({
			nextArrow: '<button class="btn-prev"><i class="fa fa-angle-down" aria-hidden="true"></i></button>',
	  		prevArrow: '<button class="btn-next"><i class="fa fa-angle-up" aria-hidden="true"></i></button>',
			slidesToShow: 3,
			slidesToScroll: 3,
			dots: false,
			arrows: true,
			vertical: true,
			infinite: true,
			speed: 300,
			responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
		});
		$(".thumbs_list a.view-img").click(function(event){
			event.preventDefault();
		});
        });       
        
    });
    
	//category sidebar  
    $("<p></p>").insertAfter(".widget_product_categories ul.product-categories > li > a");
    var $p = $(".widget_product_categories ul.product-categories > li p");
    $(".widget_product_categories ul.product-categories > li:not(.current-cat):not(.current-cat-parent) p").append('<span>+</span>');
    $(".widget_product_categories ul.product-categories > li.current-cat p").append('<span>-</span>');
    $(".widget_product_categories ul.product-categories > li.current-cat-parent p").append('<span>-</span>');
    $(".widget_product_categories ul.product-categories > li:not(.current-cat):not(.current-cat-parent) > ul").hide();

    $(".widget_product_categories ul.product-categories > li").each(function () {
        if ($(this).find("ul > li").length == 0) {
            $(this).find('p').remove();
        }

    });

    $p.click(function () {
        var $accordion = $(this).nextAll('ul');

        if ($accordion.is(':hidden') === true) {

            $(".widget_product_categories ul.product-categories > li > ul").slideUp();
            $accordion.slideDown();

            $p.find('span').remove();
            $p.append('<span>+</span>');
            $(this).find('span').remove();
            $(this).append('<span>-</span>');
        }
        else {
            $accordion.slideUp();
            $(this).find('span').remove();
            $(this).append('<span>+</span>');
        }
    });

	// Menu Lever 2
    $("<p></p>").insertAfter(".widget_product_categories ul.product-categories > li > ul > li > a");
    var $pp = $(".widget_product_categories ul.product-categories > li > ul > li p");
    $(".widget_product_categories ul.product-categories > li >ul >li > ul").hide();
    $(".widget_product_categories ul.product-categories > li > ul > li p").append('<span>+</span>');

    $(".widget_product_categories ul.product-categories > li > ul > li").each(function () {
        if ($(this).find("ul > li").length == 0) {
            $(this).find('p').remove();
        }
    });

    $pp.click(function () {
        var $accordions = $(this).nextAll('ul');

        if ($accordions.is(':hidden') === true) {

            $(".widget_product_categories ul.product-categories > li > ul > li > ul").slideUp();
            $accordions.slideDown();

            $pp.find('span').remove();
            $pp.append('<span>+</span>');
            $(this).find('span').remove();
            $(this).append('<span>-</span>');
        }
        else {
            $accordions.slideUp();
            $(this).find('span').remove();
            $(this).append('<span>+</span>');
        }
    });
	
	// Menu Lever 3
	$("<p></p>").insertAfter(".widget_product_categories ul.product-categories > li > ul > li > ul > li > a");
    var $ppp = $(".widget_product_categories ul.product-categories > li > ul > li > ul > li p");
    $(".widget_product_categories ul.product-categories > li > ul > li > ul > li > ul").hide();
    $(".widget_product_categories ul.product-categories > li > ul > li > ul > li p").append('<span>+</span>');
	
	$(".widget_product_categories ul.product-categories > li > ul > li > ul > li").each(function () {
        if ($(this).find("ul > li").length == 0) {
            $(this).find('p').remove();
        }
    });
	
	$ppp.click(function () {
        var $accordions = $(this).nextAll('ul');

        if ($accordions.is(':hidden') === true) {

            $(".widget_product_categories ul.product-categories > li > ul > li > ul > li > ul").slideUp();
            $accordions.slideDown();

            $ppp.find('span').remove();
            $ppp.append('<span>+</span>');
            $(this).find('span').remove();
            $(this).append('<span>-</span>');
        }
        else {
            $accordions.slideUp();
            $(this).find('span').remove();
            $(this).append('<span>+</span>');
        }
    });
    
    /*Animation scrollReveal*/
    window.scrollReveal = new scrollReveal({
        mobile: false
    });
  
    $('#commentform .form-submit .submit').addClass("btn btn-primary");
    //remove class
    $( ".megamenu .dropdown-menu.children > li > ul.children" ).removeClass( "dropdown-menu" )
    //woocommerce
    $('body').bind('added_to_cart', function (response) {
        $('body').trigger('wc_fragments_loaded');
    });

	//ajax search
	$(document).ready(function () {
		$('.woosearch-search-input').on('blur change paste keyup ', function (e) {
	        var $that = $(this);
	        var raw_data = $that.val(), // item container
	            category = $("#searchtype").val(),
	            number = $that.data("number"),
	            keypress = $that.data("keypress");
	            
	            if(typeof category == 'undefined'){
	                category = '';
	            }
	        if(raw_data.length >= keypress ){
	            $.ajax({
	                url: apr_params.ajax_url,
	                type: 'POST',
	                data: {action:'woosearch_search',raw_data: raw_data,category:category,number:number},
	                beforeSend: function(){
	                    if ( !$('#woosearch-search .fa-spin .fa-spinner').length ){
	                        $('#woosearch-search .fa-spin').addClass('spinner');
	                        $('<i class="fa fa-spinner fa-spin"></i>').appendTo( "#woosearch-search .fa-spin" ).fadeIn(100);
	                       // $('#moview-search .search-icon .themeum-moviewsearch').remove();
	                    }
	                    
	                },
	                complete:function(){
	                    $('#woosearch-search .fa-spin .fa-spinner ').remove();    
	                    $('#woosearch-search .fa-spin').removeClass('spinner');
	                }
	            })
	            .done(function(data) {
	                //console.log( data );
	                if(e.type == 'blur') {
	                   $( ".woosearch-results" ).html('');
	                }else{
	                    $( ".woosearch-results" ).html( data );
	                }
	            })
	            .fail(function() {
	                console.log("fail");
	            });
	        }
	    });
    });
    // Redirect On off
    $('#woosearch-search').on('submit', function (e) {
        if( $(this).data('redirect') == 1 ){
            e.preventDefault();    
        }
    });
    //end ajax search
    function woocommerce_add_cart_ajax_message() {
        if ($('.add_to_cart_button').length !== 0 && $('#cart_added_msg_popup').length === 0) {
            var message_div = $('<div>')
                    .attr('id', 'cart_added_msg'),
                    popup_div = $('<div>')
                    .attr('id', 'cart_added_msg_popup')
                    .html(message_div)
                    .hide();

            $('body').prepend(popup_div);
        }
    }

    woocommerce_add_cart_ajax_message();
    //Woocommerce update cart sidebar
    $('body').bind('added_to_cart', function (response) {
        $('body').trigger('wc_fragments_loaded');
        $('ul.products li .added_to_cart').remove();
        var msg = $('#cart_added_msg_popup');
        $('.mini-cart').addClass('active_minicart');
        $('#cart_added_msg').html(apr_params.ajax_cart_added_msg);
        msg.css('margin-left', '-' + $(msg).width() / 2 + 'px').fadeIn();
        window.setTimeout(function () {
            msg.fadeOut();
            $('.mini-cart').removeClass('active_minicart');
        }, 2000);
    });
	
    // tabs
    $("form.cart").on("change", "input.qty", function() {
        if (this.value === "0")
            this.value = "1";

        $(this.form).find("button[data-quantity]").data("quantity", this.value);
    });
	
    var h = $(window).height();
    $('.coming-soon-container').css('height', h + 'px');
	
    $(window).resize(function () {
		
		var heightHeader = $('.site-header').height();
		var heightFooter = $('footer').height();
		if($(window).width() < 992){
			if($('.site-header').hasClass('header-bottom')){
				$('footer').css('margin-bottom', heightHeader + 'px');
			}
		}
		if($('header').hasClass('header-v9')){
			var heightHeader = $('.header-v9').height();
			var heightWd = $(window).height();
			$('.banner-type6 .banner-img').css('height', (heightWd - heightHeader) + 'px' );
		}
		if($(window).width() > 767){
			if($('.footer').hasClass('footer-fixed')){
				$('#page').css('padding-bottom', heightFooter + 'px');
			}
		}
		//Menu double
		if($(window).width() > 991){
			  var item = $('.mega-menu').children('li').length,
			  half = Math.round(item / 2),
			  mid = $('.mega-menu>li:nth-child(' + half + ')'),
			  logo = $('.kad-header-logo'),
			  menu = $('.kad-header-menu');
			  mid.after(logo);
			  menu.css('width', '100%');
		}  
		// Instagram fix height
		var heightIns = $('.instagram-type1').height();
		$('.instagram-type1 .title-insta').css('height', heightIns + 120 + 'px' );
		
		// Fix height header vertical
		var height = $(window).height();
		var width = $(window).width();
		var heightNav = $('.header-sidebar').height();
		var heightNavMenu = $('.mega-menu').height();
		
		if( heightNav > height ){
			$('.header-ver').addClass('header-scroll');
		}
		if(width < 992){
			if( heightNavMenu > height ){
				$('.header-center').addClass('header-scroll');
			}
		}
		
        var hfooter = $('.side-breadcrumb').height();
        var h = $(window).height();
        $('.coming-soon-container').css('height', h + 'px');
    });
	// var heightMenu = $('.main-navigation .mega-menu').height(); 
	// if(w < 992){
	// 	$('.main-navigation .mega-menu').css('height', heightMenu + 20 + 'px'); 
	// }
    $('ul.mega-menu > li.megamenu .menu-bottom').hide();
    $('ul.mega-menu > li.megamenu .menu-bottom').each(function(){
        var className = $(this).parent().parent().attr('id');
            if($(this).hasClass(className)){
                $(this).show();
            }
    });
    $('ul.mega-menu > li.megamenu .menu-block1').hide();
    $('ul.mega-menu > li.megamenu .menu-block1').each(function(){
        var className = $(this).parent().parent().attr('id');
            if($(this).hasClass(className)){
                $(this).show();
            }
    });
    $('ul.mega-menu > li.megamenu .menu-block2').hide();
    $('ul.mega-menu > li.megamenu .menu-block2').each(function(){
        var className = $(this).parent().parent().attr('id');
            if($(this).hasClass(className)){
                $(this).show();
            }
    });
    //Check if Safari
    if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
        $('html').addClass('safari');
    }
    //Check if MAC
     if(navigator.userAgent.indexOf('Mac')>1){
       $('html').addClass('safari');
     }
    $(window).resize(function () {
        var h = $(window).height();
        //$('.coming-soon-container').css('height', h + 'px');
         $('.adapt-height .vc_column-inner').css('height', h + 'px'); 
        var wdw = $(window).width();
		// var heightMenu = $('.main-navigation .mega-menu').height();
		if(wdw > 767){
			var heightBlog = $('.blog-img').height();
			$('.blog-grid .blog-video').css('height', heightBlog - 1 + 'px'); 
			$('.blog-list .blog-video').css('height', heightBlog + 'px'); 
		}
        if(wdw > 991){
            var left_ser = $('.page-home-4 .left-services').height();
            $('.page-home-4 .right-services').height(left_ser);
        }
    });
//product list view mode
if(apr_params.type_product == 'list-default' || apr_params.type_product == 'grid-default' || apr_params.shop_list != true || apr_params.type_product == ''){
    $('#grid_mode').unbind('click').click(function () {
        var $toggle = $('.viewmode-toggle');
        var $parent = $toggle.parent();
        var $products = $parent.find('ul.products');
        $('.product_types').addClass('product-grid').removeClass('product-list');
        $('.product_archives').addClass('product-grid-wrap').removeClass('product-list-wrap');
        $products.find('li').removeClass('col-md-12 col-sm-12');
        $('this').addClass('active');
        $('#list_mode').removeClass('active');
        if (($.cookie && $.cookie('viewmodecookie') == 'list') || !$.cookie) {
            if ($toggle.length) {
                $products.fadeOut(300, function () {
                    $products.addClass('grid').removeClass('list').fadeIn(300);
                });
            }
        }
        if ($.cookie)
            $.cookie('viewmodecookie', 'grid', {
                path: '/'
            });
        return false;
    });

    $('#list_mode').unbind('click').click(function () {
        var $toggle = $('.viewmode-toggle');
        var $parent = $toggle.parent();
        var $products = $parent.find('ul.products');
        $('.product_types').addClass('product-list').removeClass('product-grid');
        $('.product_archives').addClass('product-list-wrap').removeClass('product-grid-wrap');
        $products.find('li').addClass('col-md-12 col-sm-12');
        $(this).addClass('active');
        $('#grid_mode').removeClass('active');
        if (($.cookie && $.cookie('viewmodecookie') == 'grid') || !$.cookie) {
            if ($toggle.length) {
                $products.fadeOut(300, function () {
                    $products.addClass('list').removeClass('grid').fadeIn(300);
                });
            }
        }
        if ($.cookie)
            $.cookie('viewmodecookie', 'list', {
                path: '/'
            });
        return false;
    });

    if ($.cookie && $.cookie('viewmodecookie')) {
        var $toggle = $('.viewmode-toggle');
        if ($toggle.length) {
            var $parent = $toggle.parent();
            if ($parent.find('ul.products').hasClass('grid')) {
                $.cookie('viewmodecookie', 'grid', {
                    path: '/'
                });
            } else if ($parent.find('ul.products').hasClass('list')) {
                $.cookie('viewmodecookie', 'list', {
                    path: '/'
                });
            } else {
                $parent.find('ul.products').addClass($.cookie('viewmodecookie'));
            }
        }
    }
    if ($.cookie && $.cookie('viewmodecookie') == 'grid') {
        var $toggle = $('.viewmode-toggle');
        var $parent = $toggle.parent();
        var $products = $parent.find('ul.products');
        $('.viewmode-toggle #grid_mode').addClass('active');
        $('.product_types').addClass('product-grid').removeClass('product-list');
        $('.product_archives').addClass('product-grid-wrap').removeClass('product-list-wrap');
        $('.viewmode-toggle #list_mode').removeClass('active');
    }
    if ($.cookie && $.cookie('viewmodecookie') == 'list') {
        var $toggle = $('.viewmode-toggle');
        var $parent = $toggle.parent();
        var $products = $parent.find('ul.products');
        $('.viewmode-toggle #grid_mode').addClass('active');
        $('.product_types').addClass('product-grid').removeClass('product-list');
        $('.product_archives').addClass('product-grid-wrap').removeClass('product-list-wrap');
        $('.viewmode-toggle #list_mode').removeClass('active');
    }
    if(apr_params.type_product == 'grid-default' || apr_params.shop_list != true){
        if ($.cookie && $.cookie('viewmodecookie') == null) {
            var $toggle = $('.viewmode-toggle');
            if ($toggle.length) {
                var $parent = $toggle.parent();
                $parent.find('ul.products').addClass('grid');
                $('.product_types').addClass('product-grid');
                $('.product_archives').addClass('product-grid-wrap');
            }
            $('.viewmode-toggle #grid_mode').addClass('active');
            if ($.cookie)
                $.cookie('viewmodecookie', 'grid', {
                    path: '/'
                });
        }
    }  
    if(apr_params.type_product == 'list-default' || apr_params.shop_list != true){
        if ($.cookie && $.cookie('viewmodecookie') == null) {
            var $toggle = $('.viewmode-toggle');
            if ($toggle.length) {
                var $parent = $toggle.parent();
                $parent.find('ul.products').addClass('list');
                $('.product_types').addClass('product-list');
                $('.product_archives').addClass('product-list-wrap');
            }
            $('.viewmode-toggle #list_mode').addClass('active');
            if ($.cookie)
                $.cookie('viewmodecookie', 'list', {
                    path: '/'
                });
        }
    }      
}
	$('.btn_togglefilter').on('click', function(e){
        toggleFilter(this);
    });    
    $('.btn-open').on('click', function(e){
        toggleFilter(this);
    });
    $('.btn-search').on('click', function(e){
        toggleFilter(this);
    });
    $('.cart_label').on('click', function(e){
        toggleFilter(this);
    });
    $('.current-open').on('click', function(e){
        toggleFilter(this);
    });
    // fix placeholder IE 9
    $('[placeholder]').focus(function () {
        var input = $(this);
        if (input.val() === input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
        }
    }).blur(function () {
        var input = $(this);
        if (input.val() === '' || input.val() === input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
        }
    }).blur().parents('form').submit(function () {
        $(this).find('[placeholder]').each(function () {
            var input = $(this);
            if (input.val() === input.attr('placeholder')) {
                input.val('');
            }
        });
    });

    //quantily
    $('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<div class="qty-number"><span class="increase-qty plus" onclick="">+</span></div>').prepend('<div class="qty-number"><span class="increase-qty minus" onclick="">-</span></div>');

    // Target quantity inputs on product pages
    $('input.qty:not(.product-quantity input.qty)').each(function () {
        var min = parseFloat($(this).attr('min'));

        if (min && min > 0 && parseFloat($(this).val()) < min) {
            $(this).val(min);
        }
    });

    $(document).off('click', '.plus, .minus').on('click', '.plus, .minus', function () {

        // Get values
        var $qty = $(this).closest('.quantity').find('.qty'),
                currentVal = parseFloat($qty.val()),
                max = parseFloat($qty.attr('max')),
                min = parseFloat($qty.attr('min')),
                step = $qty.attr('step');

        // Format values
        if (!currentVal || currentVal === '' || currentVal === 'NaN')
            currentVal = 0;
        if (max === '' || max === 'NaN')
            max = '';
        if (min === '' || min === 'NaN')
            min = 1;
        if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN')
            step = 1;

        // Change the value
        if ($(this).is('.plus')) {

            if (max && (max === currentVal || currentVal > max)) {
                $qty.val(max);
            } else {
                $qty.val(currentVal + parseFloat(step));
            }

        } else {

            if (min && (min === currentVal || currentVal < min)) {
                $qty.val(min);
            } else if (currentVal > 0) {
                $qty.val(currentVal - parseFloat(step));
            }

        }

        // Trigger change event
        $qty.trigger('change');
    });
    if($('input.qty:not(.product-quantity input.qty)').val() < 10){
      $('input.qty:not(.product-quantity input.qty)').val('0'+$('input.qty:not(.product-quantity input.qty)').val());  
    }
    $('input.qty:not(.product-quantity input.qty)').on('change', function() {
        if($(this).val() < 10 && $(this).val() > 0) {
            $(this).val('0'+$(this).val());
        }
    });
	
    //wishlist
    $( document ).ready( function($){
        if(typeof yith_wcwl_l10n != 'undefined') {
            var update_wishlist_count = function() {
                var data = {
                    action: 'update_wishlist_count'
                };
                $.ajax({
                    type: 'POST',
                    url: yith_wcwl_l10n.ajax_url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {

                    },
                    success   : function (data) {
                        $('a.update-wishlist span').html('('+data+')');
                    }
                });
            };

            $('body').on( 'added_to_wishlist removed_from_wishlist', update_wishlist_count );
        }
    } );
    $('.ult_acord').remove();

    // Viewby
    $( '.woocommerce-viewing' ).off( 'change' ).on( 'change', 'select.count', function() {
        $( this ).closest( 'form' ).submit();
    });
    //gallery
    var gallery_paged = $('#gallery-loadmore').data('paged');
    var gallery_page = gallery_paged ? gallery_paged + 1 : 2;
    var Gallery = {
        _initialized: false,
        init: function () {
            if (this._initialized)
                return false;
            this._initialized = true;
            this.galleryLoadmore();
        },
        galleryLoadmore: function () {
            $('#gallery-loadmore').click(function (event) {
                event.preventDefault();
                var el = $(this);
                var gallery_wrap = $('.gallery-entries-wrap');
                var url = $(this).attr('href');
                
                $('#gallery-loadmore').after('<i class="fa fa-refresh fa-spin"></i>');
                el.addClass('hide-loadmore');
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {paged: gallery_page},
                    success: function (response) {
                        $('.load-more').find('.fa-spin').remove();
                        el.removeClass('hide-loadmore');
                        var result = $(response).find('.gallery-entries-wrap').html();
                        if ($().isotope) {
                            $(result).imagesLoaded(function () {
                                if (gallery_wrap.data('isotope')) {
                                    gallery_wrap.isotope('insert', $(result));
                                }
                            });
                        }
                        gallery_page++;
                        if (gallery_page > parseInt(el.data('totalpage'))) {
                            el.parent().remove();
                        }
                    }
                });
            });
        }
    };
	
	// Blog Load More
    var blog_paged = $('#blog-loadmore').data('paged');
    var blog_page = blog_paged ? blog_paged + 1 : 2;
    var Blog = {
        _initialized: false,
        init: function () {
            if (this._initialized)
                return false;
            this._initialized = true;
            this.blogLoadmore();
        },
        blogLoadmore: function () {
            $('#blog-loadmore').click(function (event) {
                event.preventDefault();
                var el = $(this);
                var blog_wrap = $('.blog-entries-wrap');
                var url = $(this).attr('href');
                $('.load-more').append('<i class="fa fa-refresh fa-spin"></i>');
                el.addClass('hide-loadmore');
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {paged: blog_page},
                    success: function (response) {
                        $('.load-more').find('.fa-spin').remove();
                        el.removeClass('hide-loadmore');
                        var result = $(response).find('.blog-entries-wrap').html();
						if ($().isotope) {
                            $(result).imagesLoaded(function () {
                                if (blog_wrap.data('isotope')) {
                                    blog_wrap.isotope('insert', $(result));
                                }
                            });
                        }
                        blog_page++;
                        if (blog_page > parseInt(el.data('totalpage'))) {
                            el.parent().remove();
                        }
                    }
                });
            });
        }
    };
	
	// Product Load More
    var Product = {
        _initialized :false,
        init: function(){
            if(this._initialized)
                return false;
            this._initialized = true;
            this.isotopeChangeLayout();
        },
        isotopeChangeLayout : function(){

            var button = $('[data-isotope-container]');

            button.each(function(){

                var $this = $(this),

                    container = $($this.data('isotope-container')),

                    layout = $this.data('isotope-layout');

                $this.on('click',function(){

                    $(this).addClass('black_button_active').siblings().removeClass('black_button_active').addClass('black_hover');

                    if(layout == "list"){

                        container.children("[class*='isotope_item']").addClass('list_view_type');

                    }

                    else{

                        container.children("[class*='isotope_item']").removeClass('list_view_type');

                    }

                    container.isotope('layout');

                    container.find('.tooltip_container').tooltip('.tooltip').tooltip('.tooltip');

                });

            });

        },

    };

    $(document).ready(function () {
        Gallery.init();
        Product.init();
        Blog.init();
    });

})(jQuery);
function jsAnimateMenu1(tog) {
			if(tog == 'open') {
			  jQuery('html').addClass('openmenu openmenu-hoz');
			}
			if(tog == 'close') {
			  jQuery('html').removeClass('openmenu openmenu-hoz');
			}
		}
function jsAnimateMenu2(tog) {
			if(tog == 'open') {
			  jQuery('html').addClass('openmenu');
			}
			if(tog == 'close') {
			  jQuery('html').removeClass('openmenu');
			}
		}		
// Active Cart, Search
function toggleFilter(obj){
    if(jQuery(window).width() < 1199){
		if(jQuery(obj).parent().find('> .content-filter').hasClass('active')){
			jQuery(obj).parent().find('> .content-filter').removeClass('active');  
			jQuery(obj).removeClass('btn-active');                         
		}else{
			jQuery('.btn-open,.cart_label,.btn-search, .languges-flags > a').removeClass('btn-active');
			jQuery('.content-filter').removeClass('active');
			jQuery(obj).parent().find(' > .content-filter').addClass('active');   
			jQuery(obj).addClass('btn-active');           
		}
    }
}

// Add class IE
var ms_ie = false;
var ua = window.navigator.userAgent;
var old_ie = ua.indexOf('MSIE ');
var new_ie = ua.indexOf('Trident/');
if ((old_ie > -1) || (new_ie > -1)) {
	ms_ie = true;
}
if ( ms_ie ) {
   jQuery('body').addClass('ie-11');
}

//Check if Safari
function isSafari() {
  return /^((?!chrome).)*safari/i.test(navigator.userAgent);
}
//Check if MAC
if(navigator.userAgent.indexOf('Mac')>1){
   jQuery('html').addClass('macbook');
}

function menu_tab(evt, tabTitle) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabTitle).style.display = "block";
    evt.currentTarget.className += " active";
}
if(document.getElementById("defaultOpen")){
 // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();   
}
function is_Rirefox(){
 return /^((?!firefox).)*firefox/i.test(navigator.userAgent);
}
if(navigator.userAgent.indexOf('Firefox') > -1) {
    jQuery('body').addClass('firefox');
}