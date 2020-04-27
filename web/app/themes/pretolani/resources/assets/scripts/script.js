$(document).ready(function() {

    /* WOW START */

    wow = new WOW(
      {
        animateClass: 'animated',
       // offset:       0,
        callback:     function(box) {
          
        }
      }
    );
    wow.init();
    
    /* WOW END */



    var quotes = [];
    var lines = [];
    var letters = [];

    function sep_animate_dest(destination) {
        var lins = $(destination.item).find('.sep-lines');
        var lets = $(destination.item).find('.sep-letters');

        lines[destination.index] = new SplitText(lins, {type: "lines"});
        letters[destination.index] = new SplitText(lets, {type: "lines, chars"});
        
    	gsap.from(lines[destination.index].lines, {duration: 0.5, y: 100, opacity: 0, stagger: 0.3});
    	gsap.from(letters[destination.index].chars, {duration: 0.5, y: 50, opacity: 0, stagger: 0.1});
    }


    var logo_preloader = $(document).find('.section_logo');

    function init_fullpage() {

        new fullpage('#main', { 
            menu: '#menu',
            navigation: true,
            navigationPosition: 'right',
            navigationTooltips: ['01', '02', '03', '04', '05'],

            //Scrolling
            scrollingSpeed: 1500,
            /*autoScrolling: true,*/
            fitToSection: true,
            fitToSectionDelay: 4000,
            scrollBar: true,
    /*        paddingTop: '1em',
            paddingBottom: '1em',*/
            sectionSelector: '.section',
//            normalScrollElements: '.section-normal-scroll',

            afterLoad : function(origin, destination, direction){

                if(!$(destination.item).hasClass('animated')) {
                    $(destination.item).addClass('animated');

                    sep_animate_dest(destination);
                }

                if($(destination.item).hasClass('section-black')) {
                    $('header').addClass("alt");
                    $('#fp-nav').addClass("alt");
                } else {
                    $('header').removeClass("alt");
                    $('#fp-nav').removeClass("alt");
                }

                if($(document).find('.section_logo').length) {
                    if(destination.index == 1) {
                        logo_preloader.remove();
                        fullpage_api.destroy('all');
                        init_fullpage();
                        $('#fp-nav').addClass('visible');
                        $('.header').addClass('visible');
                    }
                } else {
                        $('#fp-nav').addClass('visible');
                        $('.header').addClass('visible');    
                }
            },
            onLeave : function(origin, destination, direction){
                $(origin.item).find('.fw-image_halfslide').addClass('active');
                $(destination.item).find('.fw-image_halfslide').removeClass('active');

                $(destination.item).find('.image-block').addClass('active');
                $(origin.item).find('.image-block').removeClass('active');

                if($(destination.item).hasClass('section-black')) {
                	$('header').addClass("alt");
                	$('#fp-nav').addClass("alt");
                } else {
                	$('header').removeClass("alt");
                	$('#fp-nav').removeClass("alt");
                }

                
            },
            afterSlideLoad  : function(origin, destination, direction){
                if(!$(origin.item).hasClass('animated')) {
                    $(origin.item).addClass('animated');
                	sep_animate_dest(origin);
                }
            }
        });
    }

    init_fullpage();

    $(window).load(function(){
        setTimeout(function(){
            if($(logo_preloader).length) {
                fullpage_api.moveTo(2);
            }
        }, 1000);
    });

    $(document).on('click', '.back-to-top', function(){
        fullpage_api.moveTo(1);
    });

 	$(document).on('click', '.menu-trigger', function(){
 		$(this).toggleClass("active");
 		$('.header').toggleClass("active");
 		$(document).find('.menu').toggleClass("active");
 	});

    $('.menu__nav li').hover(function(){
        var _ind = $(this).index();
        $(document).find('.menu__block_images img').removeClass('active');
        $(document).find('.menu__block_images img').eq(_ind).addClass("active");
    }, function(){
        $(document).find('.menu__block_images img').removeClass('active');
    });

    var mySwiper = new Swiper ('.section-slider', {
        loop: true,
        navigation: {
            nextEl: '.section-slider-nav__arrow-next',
            prevEl: '.section-slider-nav__arrow-prev',
        },
        slidesPerView: 1,
        speed: 2500
    });

    var gallery_slider = new Swiper ('.gallery-slider', {
        loop: true,
        navigation: {
            nextEl: '.gallery-slider-nav__arrow-next',
            prevEl: '.gallery-slider-nav__arrow-prev',
        },
        pagination: {
            el: '.gallery-slider-nav__scrollbar',
            type: 'progressbar',
        },
        slidesPerView: 'auto',
        spaceBetween: 130,
        speed: 1500
    });

    var gallery_slider_alt = new Swiper ('.gallery-slider-alt', {
        loop: true,
        navigation: {
            nextEl: '.gallery-slider-nav__arrow-next',
            prevEl: '.gallery-slider-nav__arrow-prev',
        },
        pagination: {
            el: '.gallery-slider-nav__scrollbar',
            type: 'progressbar',
        },
        slidesPerView: 'auto',
        spaceBetween: 25,
        speed: 1500
    });
    $(document).on('click', '.copy-trigger', function(){
        copyText();
    });
});

function copyText() {
  var copyText = document.getElementById("copytext");
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/
  document.execCommand("copy");
  alert(copyText.placeholder);
} 
