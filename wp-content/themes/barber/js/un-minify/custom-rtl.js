(function ($) {
    "use strict";
    $(document).ready(function () {
        $('.blog-gallery').slick({ 
          rtl: true,        
          dots: false,
          arrows: true,
          nextArrow: '<button class="btn-prev"><i class="pe-7s-angle-left"></i></button>',
          prevArrow: '<button class="btn-next"><i class="pe-7s-angle-right"></i></button>',
          infinite: true,
          autoplay: false,
          autoplaySpeed: 2000,
          slidesToShow: 1,
          slidesToScroll: 1
        });
        $(".tes-slider").slick({
          rtl: true,
          autoplay: true,
          dots: true,
          arrows:false,
          slidesToShow: 2,
          slidesToScroll: 2,
          customPaging : function(slider, i) {
          var thumb = $(slider.$slider[i]).data();
          return '<a>'+ 0 +(i+1)+'</a>';
                  },
          responsive: [{ 
              breakpoint: 600,
              settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
              } 
          }]
      });
      $(".tes-slider2").slick({
          rtl: true,
          autoplay: true,
          dots: true,
          arrows:false,
           slidesToShow: 1,
          slidesToScroll: 1,
          customPaging : function(slider, i) {
          var thumb = $(slider.$slider[i]).data();
          return '<a>'+ 0 +(i+1)+'</a>';
                  },
          responsive: [{ 
              breakpoint: 500,
              settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
              } 
          }]
      });
		// Slick slide
		$('.img-list').slick({
		  dots: false,
		  rtl: true,
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
		  rtl: true,
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
		  rtl: true,
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
		  rtl: true,
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
    });

})(jQuery);
// Active Cart, Search