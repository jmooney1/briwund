/**
 * isMobile
 * flatSearch
 * responsiveMenu
 * detectViewport
 * blog_slider
 * portfolioLoadMore
 * portfolioSingle
 * blogLoadMore
 * goTop
 * removePreloader
*/

;(function($) {

   'use strict'

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    }; 

    var headerFixed = function() { 
        if ( $('body').hasClass('header_sticky') ) {
            var top_height = $('.flat-top').height(),
            hd_height = $('#header').height(),             
            injectSpace = $('<div />', { height: hd_height }).insertAfter(header);   
            injectSpace.hide();           
            var header_style = $('.flat_header_wrap').data('header_style');                 
                switch (header_style) {
                    case 'header-style2':
                        var hd_height_2 = $('.header.header-style2').height(),
                            nav_height = $('.nav.header-style2').height(),
                            injectSpace_2 = $('<div />', { height: nav_height }).insertAfter( ".nav" ); 
                            injectSpace_2.hide(); 
                        $(window).on('load scroll', function() { 
                            if ( $(window).scrollTop() >= top_height + hd_height_2 + 20 ) {  
                                $('.nav.header-style2').addClass('header-sticky');
                                injectSpace_2.show(); 
                                                  
                            } else {   
                                $('.nav.header-style2').removeClass('header-sticky'); 
                                injectSpace_2.hide(); 
                                          
                            } 
                        })      
                        break;                        
                    case 'header-style3':
                        var hd_height_3 = $('.header.header-style3').height(),
                            nav_height = $('.nav.header-style3').height(),
                            injectSpace_3 = $('<div />', { height: nav_height }).insertAfter( ".nav" ); 
                            injectSpace_3.hide(); 
                        $(window).on('load scroll', function() {
                            if ( $(window).scrollTop() >= top_height + hd_height_3 + 16 ) {  
                                $('.nav.header-style3').addClass('header-sticky');  
                                injectSpace_3.show();                     
                            } else {    
                                $('.nav.header-style3').removeClass('header-sticky'); 
                                injectSpace_3.hide();            
                            } 
                        })      
                        break;
                    case 'header-style4':                                          
                        $(window).on('load scroll', function() {
                            if ( $(window).scrollTop() >= top_height ) {  
                                $('.header.header-style4').addClass('header-sticky'); 
                            } else {    
                                $('.header.header-style4').removeClass('header-sticky'); 
                            } 
                        })      
                        break;
                    default:
                        $(window).on('load scroll', function() { 
                            if ( $(window).scrollTop() >= top_height ) {  
                                $('.header').addClass('header-sticky'); 
                                injectSpace.show();                     
                            } else {    
                                $('.header').removeClass('header-sticky'); 
                                injectSpace.hide();           
                            }     
                        }) 
                }      
        }   
    }

    var  headerStickyLogo = function() { 
        if ( $('body').hasClass('header_sticky') ) {
            var top_height = $('.flat-top').height();
            $(window).on('load scroll', function() { 
                if ( $(window).scrollTop() >= top_height ) {
                    var logo_sticky = $('#logo').find('img').data('logo_sticky');
                    var site_retina_logo_sticky = $('#logo').find('img').data('site_retina_logo_sticky');
                    $('#logo').find('img').attr('src', logo_sticky);
                    $('#logo').find('img').attr('data-retina', site_retina_logo_sticky);                     
                } else {     
                    var logo_site = $('#logo').find('img').data('logo_site');
                    var retina_base = $('#logo').find('img').data('retina_base');   
                    $('#logo').find('img').attr('src', logo_site);   
                    $('#logo').find('img').attr('data-retina', retina_base);        
                }     
            })
        }
    }

    var flatSearch = function () {
        $(document).on('click', function(e) {   
            var clickID = e.target.id;   
            if ( ( clickID != 's' ) ) {
                $('.top-search').removeClass('show');   
                $('.show-search').removeClass('active');             
            } 
        });

        $('.show-search').on('click', function(event){
            event.stopPropagation();
        });

        $('.search-form').on('click', function(event){
            event.stopPropagation();
        });        

        $('.show-search').on('click', function (e) {           
            if( !$( this ).hasClass( "active" ) )
                $( this ).addClass( 'active' );
            else
                $( this ).removeClass( 'active' );
             e.preventDefault();

            if( !$('.top-search' ).hasClass( "show" ) )
                $( '.top-search' ).addClass( 'show' );
            else
                $( '.top-search' ).removeClass( 'show' );
        });
    }  
    
    var responsiveMenu = function() {
        var menuType = 'desktop';

        $(window).on('load resize', function() {
            var currMenuType = 'desktop';

            if ( matchMedia( 'only screen and (max-width: 991px)' ).matches ) {
                currMenuType = 'mobile';
            }

            if ( currMenuType !== menuType ) {
                menuType = currMenuType;

                if ( currMenuType === 'mobile' ) {
                    var $mobileMenu = $('#mainnav').attr('id', 'mainnav-mobi').hide();
                    var hasChildMenu = $('#mainnav-mobi').find('li:has(ul)');

                    $('#header').after($mobileMenu);
                    hasChildMenu.children('ul').hide();
                    hasChildMenu.children('a').after('<span class="btn-submenu"></span>');
                    $('.btn-menu').removeClass('active');
                } else {
                    var $desktopMenu = $('#mainnav-mobi').attr('id', 'mainnav').removeAttr('style');
                    $desktopMenu.find('.sub-menu').removeAttr('style');
                    $('#header').find('.nav-wrap').append($desktopMenu);
                    $('.nav.header-style2').find('.nav-wrap').append($desktopMenu);
                    $('.nav.header-style3').find('.nav-wrap').append($desktopMenu);                    
                    $('.btn-submenu').remove();
                }
            }
        });

        $('.btn-menu').on('click', function() {         
            $('#mainnav-mobi').slideToggle(300);
            $(this).toggleClass('active');
        });

        $(document).on('click', '#mainnav-mobi li .btn-submenu', function(e) {
            $(this).toggleClass('active').next('ul').slideToggle(300);
            e.stopImmediatePropagation()
        });
    }  

    var detectViewport = function() {
        $('[data-waypoint-active="yes"]').waypoint(function() {
            $(this).trigger('on-appear');
        }, { offset: '90%', triggerOnce: true });
    };   

    var blog_slider = function() { 
        if ( $().flexslider ) { 
            $('.featured-post.blog-slider').flexslider({
                animation      :  "slide",
                direction      :  "horizontal", // vertical
                pauseOnHover   :  true,
                useCSS         :  false,
                easing         :  "swing",
                animationSpeed :  500,
                slideshowSpeed :  5000,
                controlNav     :  false,
                directionNav   :  true,
                slideshow      :  true,
                prevText       :  '<i class="fa fa-angle-left"></i>',
                nextText       :  '<i class="fa fa-angle-right"></i>',
                smoothHeight   :  true
            }); // flexslider            
        }
    };     

    var portfolioLoadMore = function() {       
        var $container = $('.portfolio-container') 
        var $nav = ".navigation.portfolio.loadmore a";
        $($nav).on('click', function(e) {
            e.preventDefault();  
            $('<span/>', {
                class: 'infscr-loading',
                text: 'Loading...',
            }).appendTo($container);

            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                dataType: "html",
                success: function( out ) {
                    var result = $(out).find('.item');                        
                    var nextlink = $(out).find($nav).attr('href');
                    result.css({ opacity: 0 });                        
                    $container.append(result).imagesLoaded(function () {
                        result.css({ opacity: 1 });
                        $container.isotope('appended', result);
                    });
                    if ( nextlink != undefined && result != undefined) {
                        $($nav).attr('href', nextlink);
                        $container.find('.infscr-loading').remove();
                    } else {
                        $container.find('.infscr-loading').addClass('no-ajax').text('All posts loaded.').delay(2000).queue(function() {$(this).remove();});
                        $($nav).remove();
                    }
                },
                error: function() {
                     $container.find('.infscr-loading').addClass('no-ajax').text('All posts loaded.').delay(2000).queue(function() {$(this).remove();});
                        $($nav).remove();
                }
            })
        })        
    }

    var portfolioSingle = function() {
        $('.flat-portfolio-single-slider').each(function(){
            $(this).children('#flat-portfolio-carousel').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: true,
                slideshow: true,
                itemWidth: 277,                
                itemMargin: 20,
                asNavFor: $(this).children('#flat-portfolio-flexslider'),
                prevText: '<i class="fa fa-angle-left"></i>',
                nextText: '<i class="fa fa-angle-right"></i>'
            });
            $(this).children('#flat-portfolio-flexslider').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: true,
                slideshow: true,                
                sync: $(this).children('#flat-portfolio-carousel'),
                prevText: '<i class="fa fa-angle-left"></i>',
                nextText: '<i class="fa fa-angle-right"></i>'
            });
        });
    }; 

    var blogLoadMore = function() { 
        var $container = $('.post-wrap');
        if ( $('body').hasClass('page-template') ) {
            var $container = $('.blog-shortcode');
        }        
        $('.navigation.loadmore a').on('click', function(e) {
            e.preventDefault();          

            $('<span/>', {
                class: 'infscr-loading',
                text: 'Loading...',
            }).appendTo($container);

            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                dataType: "html",
                success: function( out ) {
                    var result = $(out).find('article');                        
                    var nextlink = $(out).find('.navigation.loadmore a').attr('href');

                    result.css({ opacity: 0 });
                    $container.append(result).imagesLoaded(function () {
                        result.css({ opacity: 1 });
                        $container.isotope('appended', result);
                    });
                    
                    if ( nextlink != undefined ) {
                        $('.navigation.loadmore a').attr('href', nextlink);
                        $container.find('.infscr-loading').remove();
                    } else {
                        $container.find('.infscr-loading').addClass('no-ajax').text('All posts loaded.').delay(2000).queue(function() {$(this).remove();});
                        $('.navigation.loadmore a').remove();
                    }
                }
            })
        })       
    }  

    var testimonialsServices = function() {
        $('.testimonials-sidebar').each(function() {             
            if ( $().owlCarousel ) {                
                $('.testimonial03').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: false, 
                    dots: true,                   
                    autoplay: false,                        
                    responsive:{
                        0:{
                            items: 1
                        },                                              
                        480:{
                            items: 1
                        }, 
                        767:{
                            items: 1
                        },
                        991:{
                            items: 1
                        },
                        1200: {
                            items: 1
                        }
                    }
                });
            }
        });
    };  

    var goTop = function() {
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 800 ) {
                $('.go-top').addClass('show');
            } else {
                $('.go-top').removeClass('show');
            }
        }); 

        $('.go-top').on('click', function() {            
            $("html, body").animate({ scrollTop: 0 }, 1000 , 'easeInOutExpo');
            return false;
        });
    };

    // Retina Logos
    var retinaLogos = function() {
        var retina = window.devicePixelRatio > 1 ? true : false;
        var img_retina = $('.logo .site-logo').data('retina');       
        if( retina ) {
            $('#logo').find('img').attr({src:img_retina,width:'175',height:'50'});           
        }
    };

    var removePreloader = function() {        
        $('.preloader').css('opacity', 0);
        setTimeout(function() {
            $('.preloader').hide(); }, 1000           
        );   
    };


    // Dom Ready
    $(function() {
    responsiveMenu(); 
    if ( matchMedia( 'only screen and (min-width: 991px)' ).matches ) {
        headerFixed();
        headerStickyLogo();
    } 
    blog_slider();    
    goTop();   
    blogLoadMore();
    portfolioLoadMore();
    portfolioSingle();  
    flatSearch();  
    detectViewport(); 
    testimonialsServices(); 
    retinaLogos();
    removePreloader(); 
    });
})(jQuery);