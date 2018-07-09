/*
 * 5sec Google Maps Pro
 * (c) Web factory Ltd, 2017
 * www.webfactoryltd.com
 */

jQuery(function($) {
  if (typeof wf_gmp_maps == 'undefined') {
    wf_gmp_maps = '';
  }
  if (typeof wf_gmp_autoload == 'undefined') {
    wf_gmp_autoload = 0;
  }

  wf_gmp_maps = wf_gmp_maps.replace(/&quot;/g, '"');
  wf_gmp_maps = $.parseJSON(wf_gmp_maps);

  // tabs fix
  if (Boolean(parseInt(wf_gmp_detect_visibility, 10))) {
    (function ($) {
        $.each(['show'], function (i, ev) {
          var el = $.fn[ev];
          $.fn[ev] = function () {
            this.trigger(ev);
            return el.apply(this, arguments);
          };
        });
    })(jQuery);

    $('.wf-gmp-canvas').parent().on('show', function() {
      id = $('.wf-gmp-canvas', this).attr('id');
      id = id.replace('wf-gmp_','');
      wf_gmp_load_map(id);
      setTimeout(function (){
        $(window).trigger('resize');
      }, 500); // how long do you want the delay to be?
    });
  } // if tabs fix

  // autload all maps?
  if (Boolean(parseInt(wf_gmp_autoload, 10))) {
    for(var i=0, len = wf_gmp_maps.length; i < len; i++){
      wf_gmp_load_map(i+1);
    } // for maps
  }

  // handle direction switch click in description
  $(document).on('click', '.gmp_directions .gmp_switch', function() {
    if ($(this).siblings('.gmp_start').is(':visible')) {
      $(this).siblings('.gmp_start').hide();
      $(this).siblings('.gmp_start').children('input').prop('disabled', true);

      $(this).siblings('.gmp_end').children('input').prop('disabled', false);
      $(this).siblings('.gmp_end').show();
    } else {
      $(this).siblings('.gmp_start').show();
      $(this).siblings('.gmp_start').children('input').prop('disabled', false);

      $(this).siblings('.gmp_end').hide();
      $(this).siblings('.gmp_end').children('input').prop('disabled', true);
    }

    return false;
  }); // directions switch

  // fullscreen button click
  $(document).on('click', '.wf_gmp_fullscreen a', function() {
    map_id = $(this).data('map-id');
    wf_gmp_toggle_fullscreen(map_id);

    return false;
  }); // fullscreen button
}); // onload

// load single map
function wf_gmp_load_map(map_number) {
  map = wf_gmp_maps[map_number - 1];
  map_obj = jQuery('#wf-gmp_' + map_number);

  // place pins
  tmp_pins = [];
  for(var i=0, len = map.pins.length; i < len; i++) {
    pin = map.pins[i];

    if (pin.latlng) {
      tmp_pins.push({latLng:[pin.lat, pin.lng], options:{title: pin.tooltip, icon: pin.icon, animation: parseInt(pin.bounce, 10), show_description: parseInt(pin.show_description, 10), data: pin.description }});
    } else {
      tmp_pins.push({address: pin.address,      options:{title: pin.tooltip, icon: pin.icon, animation: parseInt(pin.bounce, 10), show_description: parseInt(pin.show_description, 10), data: pin.description }});
    }
  } // for pins

  // add pins
  map_obj.gmap3({ marker:{ values: tmp_pins, events:{ click: function(marker, event, context){ wf_gmp_pin_click(map_number, marker, event, marker.data); } } }});


  // predefined skin
  if (map.skin && gmp_skins[map.skin] !== undefined) {
    map_obj.gmap3({ map:{ options: { styles: gmp_skins[map.skin]} } }) ;
  }

  // simple map color/hue
  if (map.color && map.color != '#ffffff') {
    map_obj.gmap3({ map:{ options:{styles: [{ "stylers": [{ "hue": map.color } ]} ] } } }) ;
  }

  // set zoom
  map_obj.gmap3({ map:{ options:{ zoom: map.zoom, cache: true } } });

  // disable mouse scroll wheel?
  if (map.disable_scrollwheel) {
    map_obj.gmap3({ map:{ options:{ scrollwheel: false } } });
  }

  // lock map?
  if (map.lock_map) {
    map_obj.gmap3({ map:{ options:{ scrollwheel: false,
                                  zoomControl: false,
                                  panControl: false,
                                  draggable: false,
                                  mapTypeControl: false,
                                  disableDoubleClickZoom: true,
                                  keyboardShortcuts: false,
                                  streetViewControl: false
  } } });
  }

  // set map type
  if (map.type == 'roadmap') {
    map_obj.gmap3({ map:{ options:{ mapTypeId: google.maps.MapTypeId.ROADMAP } } });
  } else if (map.type == 'satellite') {
    map_obj.gmap3({ map:{ options:{ mapTypeId: google.maps.MapTypeId.SATELLITE } } });
  } else if (map.type == 'hybrid') {
    map_obj.gmap3({ map:{ options:{ mapTypeId: google.maps.MapTypeId.HYBRID } } });
  } else if (map.type == 'terrain') {
    map_obj.gmap3({ map:{ options:{ mapTypeId: google.maps.MapTypeId.TERRAIN } } });
  }

  // autofit map based on pins
  if (map.autofit) {
    map_obj.gmap3({ autofit:{} });
  }

  // set various layers
  if (map.weather) {
    map_obj.gmap3({ weatherlayer:{} });
  }
  if (map.traffic) {
    map_obj.gmap3({ trafficlayer:{} });
  }
  if (map.clouds) {
    map_obj.gmap3({ cloudlayer:{} });
  }
  if (map.transit) {
    map_obj.gmap3({ transitlayer:{} });
  }
  if (map.bicycle) {
    map_obj.gmap3({ bicyclinglayer:{} });
  }

  // add fullscreen button markup
  if (map.fullscreen) {
    map_obj.gmap3({ panel:{
    options:{
      content: '<div class="wf_gmp_fullscreen" style="border: none; right: 100px; top: 5px; position: absolute;">' +
                  '<a data-map-id="' + map_number + '" href="#" title="Toggle fullscreen mode"><img src="' + wf_gmp_plugin_url + '/images/fullscreen.png" width="29" title="Toggle fullscreen mode"></a>' + '</div>'}
    }});
  }

  // show description onLoad
  map_obj.gmap3( {map: { events: { idle: function() {
    map_obj2 = jQuery('#wf-gmp_' + map_number);
    if (map_obj2.data('loaded')) {
      return;
    } else {
      map_obj2.data('loaded', true);
    }

    markers = map_obj2.gmap3({get:{name:'marker', all: true}});
    jQuery.each(markers, function(key, marker) {
      if (marker.show_description && marker.data) {
        wf_gmp_pin_click(map_number, marker, false, marker.data);
        return false;
      }
      if (!wf_gmp_maps[map_number - 1].autofit) {
        return false;
      }
    });
  }}}});

  // rebuild on resize
  jQuery(window).resize(function() {
    tmp = map_obj.gmap3('get').getCenter();
    map_obj.gmap3({trigger: 'resize'});
    if (tmp !== null) {
      map_obj.gmap3({map: { options: {center: [tmp.k, tmp.A] }}});
    }
  });

  return map_obj;
} // wf_gmp_load_map


// handle fullscreen button click
function wf_gmp_toggle_fullscreen(map_number) {
  map = jQuery('#wf-gmp_' + map_number);

  if (!map.data('backup_style')) {
    map.data('backup_style', map.attr('style'));
  }

  if (map.data('fullscreen') == true) {
    map.attr('style', map.data('backup_style'));
    map.data('fullscreen', false);
    map.toggleClass('gmp_fullscreen');
    jQuery(document).unbind('keyup.wf_gmp_fullscreen');
    jQuery(window).scrollTop(parseInt(map.data('scroll_backup'), 10));
  } else {
    map.data('fullscreen', true);
    map.data('scroll_backup', jQuery(window).scrollTop());
    map.toggleClass('gmp_fullscreen');
    map.css('position', 'fixed').css('z-index', parseInt(90000 + map_number, 10));
    map.css('width', '100%').css('height', '100%');
    map.css('top', '0').css('left', '0');
    jQuery(document).bind('keyup.wf_gmp_fullscreen', function(e){
      if (e.keyCode === 27) {
        wf_gmp_toggle_fullscreen(map_number);
      }
    });
  }

  tmp = map.gmap3('get').getCenter();
  map.gmap3({trigger: 'resize'});
  if (tmp !== null) {
    map.gmap3({map: { options: {center: [tmp.k, tmp.A] }}});
  }

  return false;
} // wf_gmp_toggle_fullscreen

// handle pin click - description show/hide
function wf_gmp_pin_click(map_number, marker, event, data) {
   var map = jQuery('#wf-gmp_' + map_number).gmap3('get');
   var infowindow = jQuery('#wf-gmp_' + map_number).gmap3({get:{name:'infowindow', tag: 'info-' + map_number}});

   if (!data) {
     return;
   }

   data = '<div class="gmp_infowindow">' + data + '</div>';

   if (infowindow){
     infowindow.open(map, marker);
     infowindow.setContent(data);
   } else {
     jQuery('#wf-gmp_' + map_number).gmap3({ infowindow:{tag: 'info-' + map_number, anchor: marker, options:{content: data} } });
   }
} // wf_gmp_pin_click

gmp_skins = {
'pale': [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}],
'blue': [{"featureType":"water","stylers":[{"color":"#46bcec"},{"visibility":"on"}]},{"featureType":"landscape","stylers":[{"color":"#f2f2f2"}]},{"featureType":"road","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]}],
'light': [{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]}],
'bright': [{"featureType":"water","stylers":[{"color":"#19a0d8"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"weight":6}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#e85113"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-40}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-20}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"road.highway","elementType":"labels.icon"},{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"lightness":20},{"color":"#efe9e4"}]},{"featureType":"landscape.man_made","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"hue":"#11ff00"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"hue":"#4cff00"},{"saturation":58}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#f0e4d3"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-10}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"simplified"}]}],
'apple': [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.business","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]}],
'gray': [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}],
'gowalla': [{"featureType":"road","elementType":"labels","stylers":[{"visibility":"simplified"},{"lightness":20}]},{"featureType":"administrative.land_parcel","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#a1cdfc"},{"saturation":30},{"lightness":49}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#f49935"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"hue":"#fad959"}]}],
'gray2': [{"featureType":"all","stylers":[{"saturation":-100},{"gamma":0.5}]}],
'mapbox': [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}],
'paper': [{"featureType":"landscape","stylers":[{"hue":"#F1FF00"},{"saturation":-27.4},{"lightness":9.4},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#0099FF"},{"saturation":-20},{"lightness":36.4},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#00FF4F"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FFB300"},{"saturation":-38},{"lightness":11.2},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00B6FF"},{"saturation":4.2},{"lightness":-63.4},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#9FFF00"},{"saturation":0},{"lightness":0},{"gamma":1}]}]};
