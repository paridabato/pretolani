$(document).ready(function() {

    /* SEP LETTERS START */
/*    var $div = $('.sep-letters').clone().html('');
    $('.sep-letters').contents().each(function(){
      var spanClass = '';

      if ($(this).is('span')) {
        spanClass = $(this).attr('class');
      }

      $textArray = $(this).text().split('');

      for (var i = 0; i < $textArray.length; i++) {
        if($textArray[i] == ' ') {
            $('<span style="transition-delay: '+(1+i*0.15)+'s">').text($textArray[i]).addClass('empty-space').appendTo($div);
        } else {
            $('<span style="transition-delay: '+(1+i*0.15)+'s">').text($textArray[i]).appendTo($div);
        }
      }

    });

    $('.sep-letters').replaceWith($div);*/
    /* SEP LETTERS END */

    /* SEP LINE START */

/*    var tl = gsap.timeline(), 
        mySplitText = new SplitText(".quote-text", {type:"words,chars, lines"}), 
        chars = mySplitText.chars; //an array of all the divs that wrap each character

    gsap.set(".quote-text", {perspective: 0});*/


    //gsap.fromTo(split.lines, {opacity: 0, y: 500, transformOrigin:"0% 50% -50",  ease:"back"}, {opacity: 1, y: 0, duration: 5});



/*    document.getElementById("animate").onclick = function() {
      tl.restart();
    }*/

    /* SEP LINE END */

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
});