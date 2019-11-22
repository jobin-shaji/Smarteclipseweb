/*global $, document, window, lightbox, jQuery, setTimeout, initEvents*/
$(document).ready(function () {

    
	// ---------------------------------------------- //
    // Navbar Dropdown sliding
    // ---------------------------------------------- //
 // Add slideDown animation to Bootstrap dropdown when expanding.
  $('.dropdown').on('show.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
  });

  // Add slideUp animation to Bootstrap dropdown when collapsing.
  $('.dropdown').on('hide.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
  });
    // ---------------------------------------------- //
    // Navbar Shrinking Behavior
    // ---------------------------------------------- //
    $(window).scroll(function () {
        if ($(window).scrollTop() > 150) {
            $('nav.navbar').addClass('shrink');
        } else {
            $('nav.navbar').removeClass('shrink');
        }
    });

    // ---------------------------------------------- //
    // Menu Section tabs
    // ---------------------------------------------- //
    $('.menu nav a').click(function (e) {
        e.preventDefault();
        $(this).tab('fadeIn');
    });

    // ---------------------------------------------- //
    // OWl Carousel
    // ---------------------------------------------- //
/*     $('.owl-carousel').owlCarousel({
        loop: false,
        nav: false,
        dots: true,
        navText: [
            "<i class='icon-arrow-left'></i>",
            "<i class='icon-arrow-right'></i>"
        ],
        margin: 15,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            757: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    }); */
	






    $('.banner').owlCarousel({
        items: 1,
        merge: true,
        loop: true,
        margin: 10,
        video: true,
        autoplay: true,
        lazyLoad: true,
        center: true,
        mouseDrag:false,

        responsive: {
            480: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1,
            }

        }
    })





	
	 $('.about-items ').owlCarousel({
		loop: true,
		margin: 10,
		items: 9,
		nav: true,
		dots: false,
		autoplay:true,
		 autoPlaySpeed: 10,
		autoplayTimeout:2000,
		autoplayHoverPause:true,
		responsiveClass: true,
		responsive: {
		  0: {
			items: 2,
		  },
		  600: {
			items: 5,
		  },
		  1000: {
			items:9,
		  }
		}
	 })






 $('.news').owlCarousel({
		loop: true,
		margin: 15,
		items: 6,
		 loop: true,
		  nav: false,
		  navText: false,
		  dots: false,
		  autoplay: true,
		  responsiveClass:true,
		  lazyLoad:true,
		  autoPlaySpeed: 1200,
		  autoplayTimeout:2200,
		responsive: {
		  0: {
			items: 1,
			nav: true
		  },
		  600: {
			items: 2,
			nav: false
		  },
		  1000: {
			items:5,
		  }
		}
	  })

	  
	 $('.award').owlCarousel({
		loop: true,
		margin: 15,
		items: 6,
		 loop: true,
		  nav: false,
		  navText: false,
		  dots: false,
		  autoplay: true,
		  responsiveClass:true,
		  lazyLoad:true,
		  autoPlaySpeed: 1500,
		  autoplayTimeout:2500,
		responsive: {
		  0: {
			items: 1,
			nav: true
		  },
		  600: {
			items: 2,
			nav: false
		  },
		  1000: {
			items:5,
		  }
		}
	  })
	  
	   $('.client-items ').owlCarousel({
		loop: true,
		margin: 15,
		items: 5,
		 loop: true,
		  nav: false,
		  navText: false,
		  dots: false,
		  autoplay: true,
		  responsiveClass:true,
		  lazyLoad:true,
		  autoPlaySpeed: 1000,
		  autoplayTimeout:2000,
		responsive: {
		  0: {
			items: 1,
			nav: true
		  },
		  600: {
			items: 2,
			nav: false
		  },
		  1000: {
			items:5,
		  }
		}
	  })
	  
$('.press-release-mobile ').owlCarousel({
		loop: true,
		margin: 15,
		items: 1,
		 loop: true,
		  nav: true,
		  navText: false,
		  dots: false,
		  autoplay: true,
		  responsiveClass:true,
		  lazyLoad:true,
		  autoPlaySpeed: 1000,
		  autoplayTimeout:4000,
		  
	  })
	  
	 //
      $('#customers-testimonials').owlCarousel({
		loop: true,
		center: true,
		items: 3,
		margin: 0,
		autoplay: true,
		dots:false,
		nav:true,
		autoplayTimeout: 8500,
		smartSpeed: 450,
		responsive: {
			0: {
			items: 1
			},
			768: {
			items: 2
			},
			1170: {
			items: 2
			}
		}
	});
	//  

	  
    // ---------------------------------------------- //
    // Moble image slider
    // ---------------------------------------------- //  
	  
if (window.innerWidth > 768) { 
				$('.carousel').carousel({
				directionNav:true,
				shadow:false,
				hAlign: 'center',
				vAlign: 'center',	
				hMargin: 0.9,
				vMargin: 0.4,
				carouselWidth: 1000,
				before: function(carousel) {},
				after: function(carousel) {},
				backOpacity: 0.2,
				left: 0,
				right: 0,
				top: 0,
				bottom: 0,						
			});
			
}	

if (window.innerWidth > 318) { 
				$('.carousel').carousel({
				directionNav:true,
				shadow:false,
				hAlign: 'center',
				vAlign: 'center',	
				hMargin: 0.9,
				vMargin: 0.4,
				carouselWidth: 300,
				before: function(carousel) {},
				after: function(carousel) {},
				backOpacity: 0.2,
				left: 0,
				right: 0,
				top: 0,
				bottom: 0,						
			});
			
}	


			
			
    // ---------------------------------------------- //
    // What do you Slide
    // ---------------------------------------------- //	
		$(".left").on('click', function (e) {
			e.stopPropagation();
			e.preventDefault();
			$('.footer-form1').hide("slide", { direction: "left" }, 500).removeClass('show').addClass(('hide'), function () {
			$('.footer-form2').show("slide", { direction: "right" }, 500).addClass('show');
			});
		});
		
		$(".left-first").on('click', function (e) {
			e.stopPropagation();
			e.preventDefault();
			$('.footer-form2').hide("slide", { direction: "right" }, 500).removeClass('show').addClass(('hide'), function () {
			$('.footer-form1').show("slide", { direction: "left" }, 500).removeClass('hide').addClass('show');
			});
		});

	 $(".right").on('click', function (e) {
			e.stopPropagation();
			e.preventDefault();
			$('.footer-form2').hide("slide", { direction: "left" }, 500).removeClass('show').addClass(('hide'), function () {
			$('.footer-form3').show("slide", { direction: "right" }, 500).addClass('show');
			});
		});
	
	 $(".left-second").on('click', function (e) {
			e.stopPropagation();
			e.preventDefault();
			$('.footer-form3').hide("slide", { direction: "right" }, 500).removeClass('show').addClass(('hide'), function () {
			$('.footer-form2').show("slide", { direction: "left" }, 500).removeClass('hide').addClass('show');
			});
		});

    // ---------------------------------------------- //
    // Label color changing on focus
    // ---------------------------------------------- //
    $('input, textarea').focus(function () {
        $(this).parent('label').addClass('active');
    });
    $('input, textarea').blur(function () {
        $(this).parent('label').removeClass('active');
    });

    // ---------------------------------------------- //
    // Date picker initialization
    // ---------------------------------------------- //
    $('#date').datepicker({
        todayButton: new Date()
    });

    // ---------------------------------------------- //
    // Time picker initialization
    // ---------------------------------------------- //
    $('.timepicker').timepicki();

    // ---------------------------------------------- //
    // Time picker initialization
    // ---------------------------------------------- //
    $('body').scrollspy({
        target: '.navbar',
        offset: 80
    });

    // ---------------------------------------------- //
    // Preventing URL update on navigation link click
    // ---------------------------------------------- //
    //$('.navbar-nav a, #scroll-down').bind('click', function (e) {
		$('#scroll-down').bind('click', function (e) {
        var anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top
        }, 1000);
        e.preventDefault();
    });

    // ---------------------------------------------- //
    // Scroll to top button
    // ---------------------------------------------- //
    $('#scrollTop').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1000);
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() >= 1500) {
            $('#scrollTop').fadeIn();
        } else {
            $('#scrollTop').fadeOut();
        }
    });

    // ---------------------------------------------- //
    // Reservation Modal Opening & Closing
    // ---------------------------------------------- //
    $('#open-reservation').click(function (e) {
        e.preventDefault();
        $('.reservation-overlay').fadeIn();
        $('body').css({'overflow': 'hidden'});

        setTimeout(function () {
            $('#reservation-modal').addClass('is-visible');
        }, 100);
    });

    $('#close').click(function () {
        $('.reservation-overlay').fadeOut();
        setTimeout(function () {
            $('body').css('overflow', 'auto');
        }, 400);
        $('#reservation-modal').removeClass('is-visible');
    });


    // ---------------------------------------------- //
    // Lightbox initialization
    // ---------------------------------------------- //
/*     lightbox.option({
        'resizeDuration': 400,
        'fadeDuration': 400,
        'alwaysShowNavOnTouchDevices': true
    }); */

    // ---------------------------------------------- //
    // Booking form validation
    // ---------------------------------------------- //
/*     $('#booking-form, #booking-form-alternative').validate({
        messages: {
            name: 'please enter your name',
            email: 'please enter your email address',
            number: 'please enter your phone number',
            people: 'please enter how many people',
            date: 'please enter booking date',
            time: 'please enter booking time',
            request: 'please enter your special request'
        }
    }); */

    // ---------------------------------------------- //
    // Modal booking form validation
    // ---------------------------------------------- //
/*     $('#booking-form-alternative').validate({
        messages: {
            clientname: 'please enter your name',
            clientemail: 'please enter your email address',
            clientnumber: 'please enter your phone number',
            clientpeople: 'please enter how many people',
            clientdate: 'please enter booking date',
            clienttime: 'please enter booking time',
            clientrequest: 'please enter your special request'
        }
    }); */


    // ---------------------------------------------- //
    // Contact form validation
    // ---------------------------------------------- //
/*     $('#contact-form').validate({
        messages: {
            username: 'please enter your name',
            useremail: 'please enter your email address',
            message: 'please enter your message'
        }
    }); */

    // ---------------------------------------------- //
    // Hero Carousel initialization
    // ---------------------------------------------- //
/*     var Page = (function () {
        var $navArrows = $('#nav-arrows'),
            $nav       = $('#nav-dots > span'),
            slitslider = $('#slider').slitslider({
                onBeforeChange : function (slide, pos) {
                    $nav.removeClass('nav-dot-current');
                    $nav.eq(pos).addClass('nav-dot-current');
                }
            }),
            init = function () {
                initEvents();
            },
            initEvents = function () {
                // add navigation events
                $navArrows.children(':last').on('click', function () {
                    slitslider.next();
                    return false;
                });
                $navArrows.children(':first').on('click', function () {
                    slitslider.previous();
                    return false;
                });
                $nav.each(function (i) {
                    $(this).on('click', function (event) {
                        var $dot = $(this);
                        if (!slitslider.isActive()) {
                            $nav.removeClass('nav-dot-current');
                            $dot.addClass('nav-dot-current');
                        }
                        slitslider.jump(i + 1);
                        return false;
                    });
                });
            };
        return { init : init };
    })();
    Page.init(); */
	
	
	
	
	
$(window).scroll(function(){
  $('.rdx-carousel').each(function(){
    if(isScrolledIntoView($(this))){
      $(this).addClass('classOne');
    }
    else{
      $(this).addClass('classTwo');
    }
  });
});

function isScrolledIntoView(elem){
    var $elem = $(elem);
    var $window = $(window);

    var docViewTop = $window.scrollTop();
    var docViewBottom = docViewTop + $window.height();

    var elemTop = $elem.offset().top;
    var elemBottom = elemTop + $elem.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

$('.navbar-toggle').click(function() {
  $( this ).toggleClass( 'openmenu' );
  $( 'body' ).toggleClass( 'fixedmenu' );
});

    $(document).on('click', ".mobile-collapse__title", function() {
        $(".mobile-collapse").not($(this).parent()).removeClass('open');
        if ($(this).parent().hasClass('open')) {
            $(".mobile-collapse__content").slideUp();
            $(this).parent().removeClass('open');
            $(this).parent().find('.mobile-collapse__content').slideUp();
        } else {
            $(".mobile-collapse__content").slideUp();
            $(this).parent().addClass('open');
            $(this).parent().find('.mobile-collapse__content').slideDown();
        }
    }); 
	
});

(function($) {
    $(document).ready(function() {
        var $chatbox = $('.chatbox'),
            $chatboxTitle = $('.chatbox__title'),
            $chatboxTitleClose = $('.chatbox__title__close'),
            $chatboxCredentials = $('.chatbox__credentials');
        $chatboxTitle.on('click', function() {
            $chatbox.toggleClass('chatbox--tray');
        });
        $chatboxTitleClose.on('click', function(e) {
            e.stopPropagation();
            $chatbox.addClass('chatbox--closed');
        });
        $chatbox.on('transitionend', function() {
            if ($chatbox.hasClass('chatbox--closed')) $chatbox.remove();
        });
        $chatboxCredentials.on('submit', function(e) {
            e.preventDefault();
            $chatbox.removeClass('chatbox--empty');
        });
    });
})(jQuery);
// sandeep checkbox active
$(document).on('click','.radio-div li input', function(){ 
    if ($(this).is(':checked'))
    {
        $(this).parents(".radio-div").find("li").removeClass("active");
        $(this).parent("li").addClass("active");
    }
})