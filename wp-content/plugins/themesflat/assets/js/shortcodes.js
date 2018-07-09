/**
* testimonialCarousel
* portfolioIsotope
* portfolioMasory
* portfolioCarousel
* blogCarousel
* blogMasory
* logoClient
* googleMap
* flatCounter
* progressBar
* rowStyling
* spacer
*/

;(function($) {

    'use strict'
    
    var testimonialCarousel = function() {   
        $('.vc_row').each(function() {            
            if ( $().owlCarousel ) {                  
                $(this).find('.testimonial-slider').owlCarousel({
                    loop: true,
                    margin: parseInt( $(this).find('.testimonial-slider').data('margin') ),
                    nav: Boolean( $(this).find('.testimonial-slider').data('hide_buttons') )? false: true, 
                    dots: Boolean( $(this).find('.testimonial-slider').data('hide_control') )? false: true,                   
                    autoplay: Boolean( $(this).find('.testimonial-slider').data('autoplay') )? true: false,                
                    responsive:{
                        0:{
                            items: 1
                        },
                        767:{
                            items: 2
                        },
                        991:{
                            items: 2
                        },
                        1200: {
                            items: parseInt( $(this).find('.testimonial-slider').data('slides_per_view') )
                        }
                    }
                });
            }
        });
    };     

    var portfolioIsotope = function() { 
        if ( $( '.portfolio-container' ).hasClass('show_filter_portfolio') ) {
            if ( $().isotope ) {           
                var $container = $('.portfolio-container');
                $container.imagesLoaded(function(){
                    $container.isotope({
                        itemSelector: '.item',
                        transitionDuration: '1s'
                    });
                });

                $('.portfolio-filter li').on('click',function() {                           
                    var selector = $(this).find("a").attr('data-filter');
                    $('.portfolio-filter li').removeClass('active');
                    $(this).addClass('active');
                    $container.isotope({ filter: selector });
                    return false;
                });            
            };
        };        
    };

    var portfolioMasory = function() {         
        if ( $().isotope ) {           
            var $container = $('.portfolio-container.masonry');
            $container.imagesLoaded(function(){
                $container.masonry({
                    itemSelector: '.item',
                    transitionDuration: '0.5s',                    
                    layoutMode: 'masonry',                 
                    masonry: { columnWidth: $container.width() / 12 }
                }); // isotope
             });

            $(window).resize(function() {
                $container.masonry({
                   masonry: { columnWidth: $container.width() / 12 }
                });
            }); // relayout        
            
        };
    };   

    var portfolioCarousel = function() {
        if ( $( ".flat-portfolio" ).hasClass( "yes" ) ) {            
            if ( $().owlCarousel ) { 
                $('.flat-portfolio.yes').find('.portfolio-container').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: true,
                    dots: true,                   
                    autoplay: false,                
                    responsive:{
                        0:{
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        767:{
                            items: 2
                        },
                        991:{
                            items: 2
                        },
                        1200: {
                            items: 3
                        }
                    }
                });
            }
        }
    };    

    var blogCarousel = function() {
        if ( $( ".blog-shortcode" ).hasClass( "has-carousel" ) ) {            
            if ( $().owlCarousel ) {                
                $('.blog-shortcode.has-carousel').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: true,
                    dots: false,                   
                    autoplay: false,                
                    responsive:{
                        0:{
                            items: 1
                        },
                        767:{
                            items: 1
                        },
                        991:{
                            items: 1
                        },
                        1200: {
                            items: 3
                        }
                    }
                });
            }
        }
    };  

    var blogMasory = function() {         
        if ( $().isotope ) {           
            var $container = $('.blog-shortcode.blog-masonry');
            $container.imagesLoaded(function(){
                $container.masonry({
                    itemSelector: '.entry',
                    transitionDuration: '0.5s',                    
                    layoutMode: 'masonry',                 
                    masonry: { columnWidth: $container.width() / 12 }
                }); // isotope
             });

            $(window).resize(function() {
                $container.masonry({
                   masonry: { columnWidth: $container.width() / 12 }
                });
            }); // relayout        
            
        };
    };

    var logoClient = function() {
        $('.wrap-client-slide').each(function() {             
            if ( $().owlCarousel ) {                
                $('.client-slide ').owlCarousel({
                    loop: true,
                    margin: parseInt( $(this).find('.client-slide ').data('margin') ),
                    nav: Boolean( $(this).find('.client-slide ').data('hide_buttons') )? false: true, 
                    dots: Boolean( $(this).find('.client-slide ').data('hide_control') )? false: true,                   
                    autoplay: Boolean( $(this).find('.client-slide ').data('autoplay') )? true: false,                        
                    responsive:{
                        0:{
                            items: 2
                        },                                              
                        480:{
                            items: 3
                        }, 
                        767:{
                            items: 4
                        },
                        991:{
                            items: 5
                        },
                        1200: {
                            items: parseInt( $(this).find('.client-slide').data('slides_per_view') )
                        }
                    }
                });
            }
        });
    };  

    var googleMap = function() {            
        if ( $().gmap3 ) {  
            $("#map").gmap3({
                map:{
                    options:{
                        zoom: 14,
                        mapTypeId: 'themesflat_style',
                        mapTypeControlOptions: {
                            mapTypeIds: ['themesflat_style', google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID]
                        },
                        scrollwheel: false
                    }
                },
                getlatlng:{
                    address:  $('.flat-maps').data('address'),
                    callback: function(results) {
                        if ( !results ) return;
                        $(this).gmap3('get').setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
                        $(this).gmap3({
                            marker:{
                                latLng:results[0].geometry.location,
                                options:{
                                    icon: $('.flat-maps').data('images')
                                }
                            }
                        });
                    }
                },
                styledmaptype:{
                    id: "themesflat_style",
                    options:{
                        name: "Themesflat Map"
                    },
                    styles:[
                        {
                            "featureType": "administrative",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#444444"
                                }
                            ]
                        },
                        {
                            "featureType": "landscape",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "color": "#f2f2f2"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 45
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "labels.icon",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "transit",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "color": "#46bcec"
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        }
                    ]
                },  
            });
        }
        $('#map').css( 'height', $('.flat-maps').data('height') );
    };
    
    var flatCounter = function() {
        $('.counter').on('on-appear', function() { 
            $(this).find('.numb-count').each(function() { 
                var to = parseInt( ($(this).attr('data-to')),10 ), speed = parseInt( ($(this).attr('data-speed')),10 );
                if ( $().countTo ) {
                    $(this).countTo({
                        to: to,
                        speed: speed
                    });
                }
            });
       });
    };
   
    var progressBar = function() {        
        $('.progress-bar').on('on-appear', function() {
            $(this).each(function() {
                var percent = $(this).data('percent');                
                $(this).find('.progress-animate').animate({
                    "width": percent + '%'
                }, $(this).find('.progress-animate').data('duration') );

                $(this).parent('.flat-progress').find('.perc').addClass('show').animate({
                    "width": percent + '%'
                }, $(this).find('.progress-animate').data('duration') );
            });
        });
    };

    var rowStyling = function() {
        $(".vc_row").each(function( idx, el ) {
            if ($(this).hasClass('flat-overlay')) {
                var class_mask ='<div class="overlay"></div>';
                $(this).append(class_mask);
            }          

        });       
    };

    var spacer = function() {
        $(".flat-spacer").each(function() {

            var spacer_size = $(this).data( 'desktop' );
            if ( matchMedia( 'only screen and (max-width: 991px)' ).matches ) {
                spacer_size = $(this).data( 'mobile' )
            }

            if ( matchMedia( 'only screen and (max-width: 479px)' ).matches ) {
                spacer_size = $(this).data( 'smobile' )
            }
            
            $(this).css( "height", spacer_size );
        });       
    };       
        
    // Dom Ready
    $(function() {        
        testimonialCarousel();        
        portfolioIsotope();
        portfolioMasory();       
        portfolioCarousel();
        blogCarousel();             
        flatCounter();
        blogMasory();
        logoClient();
        googleMap();
        progressBar();
        rowStyling();   
        spacer();            
    });

})(jQuery);