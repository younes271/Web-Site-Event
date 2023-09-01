(function ($) {
    "use strict";
    $(document).ready(function () {
        $('.blog-gallery').slick({         
          dots: false,
          arrows: true,
          nextArrow: '<button class="btn-prev"><span class="lnr lnr-chevron-left"></span></button>',
          prevArrow: '<button class="btn-next"><span class="lnr lnr-chevron-right"></span></button>',
          infinite: true,
          autoplay: false,
          autoplaySpeed: 2000,
          slidesToShow: 1,
          slidesToScroll: 1
        });
        $(".tes-slider").slick({
          autoplay: false,
          dots: true,
          arrows:false,
           slidesToShow: 2,
          slidesToScroll: 2,
          customPaging : function(slider, i) {
          var thumb = $(slider.$slider[i]).data();
          return '<a>'+ 0 +(i+1)+'</a>';
                  },
          responsive: [
          {
              breakpoint: 767,
              settings: {
                autoplay: false,
              }
          },
          { 
              breakpoint: 600,
              settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
              } 
          }
          ]
        });
        $(".tes-slider2").slick({
            autoplay: false,
            dots: true,
            arrows:false,
             slidesToShow: 1,
            slidesToScroll: 1,
            customPaging : function(slider, i) {
            var thumb = $(slider.$slider[i]).data();
            return '<a>'+ 0 +(i+1)+'</a>';
                    },
            responsive: [
            {
                breakpoint: 767,
                settings: {
                  autoplay: false,
                }
            },
            { 
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                } 
            }
            ]
        });
        if(apr_params.apr_coming_subcribe_text){
            if(apr_params.apr_coming_subcribe_text.trim() && apr_params.apr_coming_subcribe_text.length > 0){
                $('.page-coming-soon .mc4wp-form input[type="submit"]').attr("value", apr_params.apr_coming_subcribe_text);
            }
        }        
    });
	// Slick slide
	$('.img-list').slick({
	  dots: false,
	  arrows: true,
	  nextArrow: '<button class="btn-prev"><i class="lnr lnr-arrow-right"></i></button>',
	  prevArrow: '<button class="btn-next"><i class="lnr lnr-arrow-left"></i></button>',
	  infinite: false,
	  speed: 300,
	  slidesToShow: 3,
	  slidesToScroll: 1,
	  responsive: [
		{
		  breakpoint: 1024,
		  settings: {
			slidesToShow: 3,
			slidesToScroll: 1,
		  }
		},
		{
		  breakpoint: 600,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 1 
		  }
		}
	  ]
	});
	
	$('.instagram-slider').slick({
	  centerMode: true,
	  dots: false,
	  arrows: false,
	  centerPadding: '220px',
	  slidesToShow: 3,
	  responsive: [
		{
		  breakpoint: 1200,
		  settings: {
			centerPadding: '250px',
			centerMode: true,
			slidesToShow: 1
		  }
		},
		{
		  breakpoint: 768,
		  settings: {
			centerPadding: '100px',
			centerMode: true,
			slidesToShow: 1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			centerPadding: '0px',
			centerMode: true,
			slidesToShow: 1
		  }
		}
	  ]
	});
	$('.instagram-slider-3').slick({
	  centerMode: true,
	  dots: false,
	  arrows: false,
	  centerPadding: '238px',
	  slidesToShow: 3,
	  responsive: [
		{
		  breakpoint: 1920,
		  settings: {
			centerPadding: '170px',
			centerMode: true,
			slidesToShow: 3
		  }
		},
		{
		  breakpoint: 1200,
		  settings: {
			centerPadding: '200px',
			centerMode: true,
			slidesToShow: 1
		  }
		},
		{
		  breakpoint: 768,
		  settings: {
			centerPadding: '100px',
			centerMode: true,
			slidesToShow: 1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			centerPadding: '0px',
			centerMode: true,
			slidesToShow: 1
		  }
		}
	  ]
	});
	
	$('.instagram-slider-1').slick({
	  centerMode: false,
	  dots: false,
	  arrows: false,
	  slidesToShow: 5,
	  slidesToScroll: 1,
	  responsive: [
		{
		  breakpoint: 1367,
		  settings: {
			slidesToShow: 4
		  }
		},
		{
		  breakpoint: 1200,
		  settings: {
			slidesToShow: 3
		  }
		},
		{
		  breakpoint: 1025,
		  settings: {
			slidesToShow: 2
		  }
		},
		{
		  breakpoint: 768,
		  settings: {
			slidesToShow: 2
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			slidesToShow: 1
		  }
		}
	  ]
	});

})(jQuery);
// Active Cart, Search