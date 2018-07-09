/*
 * 5sec Google Maps Pro
 * (c) Web factory Ltd, 2017
 * www.webfactoryltd.com
 */

jQuery(document).ready(function($){
  gmp_tab_counter = 1;
  gmp_map_name = '';
  var gmp_pointer;

  $('#gmp_color').wpColorPicker();
  gmp_tabs = $('#gmp_tabs').tabs();
  $('#gmp_maps_box').tabs();
  gmp_load_maps_list();
  gmp_add_pin();

  // show help when tooltip icon is clicked
  gmp_tabs.delegate('.gmp_tooltip', 'click', function() {
    if ($(this).attr('data-for')) {
      attached_el = $('#' + $(this).attr('data-for'));
      help_id = $(this).attr('data-for');
      align = 'center';
    } else {
      align = 'left';
      attached_el = $(this).prevUntil('span', 'input, select, textarea');
      help_id = $(attached_el).attr('name');
      if (!help_id) {
        help_id = $(attached_el).attr('id');
      }
    }

    if(gmp_pointer !== undefined) {
      $(gmp_pointer).pointer('close');
    }
    gmp_pointer = $(attached_el).pointer({
        content: '<h3>5sec Google Maps Pro help</h3><p>' + gmp_gui_help[help_id] +'</p>',
        position: {
            edge: 'bottom',
            align: align
        },
        width: 320
      }).pointer('open');
  }); // tooltip click


  // load map from saved list
  $('#gmp_load_map').on('click', function() {
    map_name = $('#gmp_maps_list').val();
    if (!map_name) {
      alert('Please choose a map from the list of saved maps.');
      return false;
    }
    if (confirm('Load map "' + map_name + '"?\nAll unsaved changes on the current map will be lost.')) {
      gmp_load_map_data(map_name);
    }

    return false;
  }); // load saved map

  // delete map from list and DB
  $('#gmp_delete_map').on('click', function() {
    map_name = $('#gmp_maps_list').val();
    if (!map_name) {
      alert('Please select a map from the list.');
      return false;
    }

    if(!confirm('Are you sure you want to delete map "' + map_name + '"?')) {
      return false;
    }

    $.post(ajaxurl, {action: 'gmp_delete_map', map_name: map_name}, function(response) {
      if (!response) {
        alert('Unable to delete selected map. Please reload the page.');
      } else {
        gmp_load_maps_list();
        alert('Map "' + map_name + '" deleted!');

        if (gmp_map_name == map_name) {
          gmp_map_name = '';
        }
      }
   }, 'json');

    return false;
  }); // delete map

  // add new blank pin
  $('#gmp_add_pin').click(function() {
    gmp_add_pin();

    return false;
  }); // add new pin

  // delete pin
  gmp_tabs.delegate('span.gmp_del_pin', 'click', function() {
    if (!confirm('Are you sure you want to delete the selected pin?')) {
      return false;
    }

    var panelId = $(this).closest('li').remove().attr('aria-controls');
    $('#' + panelId ).remove();
    gmp_tabs.tabs('refresh');

    return false;
  }); // delete pin

  // build shortcode via AJAX and send to editor
  $('#gmp_send_shortcode').click(function(){
    if (!$('#gmp_tabs input[name=gmp_address]').length) {
      alert('Please add at least one pin to the map.');
      return false;
    }
    
    $('#gmp_tabs input[name=gmp_tooltip]').each(function(index, element){
      if ($(element).val().indexOf('"') != -1) {
        alert('Please note that, due to WP shortcode restrictions, double-quotes can\'t be used in shortcode parameters. You\'ve used a double-quote in one of the tooltips. Either replace them with a single-quote or &quot;');
      }
    });
    $('#gmp_tabs textarea[name=gmp_description]').each(function(index, element){
      if ($(element).val().indexOf('"') != -1) {
        alert('Please note that, due to WP shortcode restrictions, double-quotes can\'t be used in shortcode parameters. You\'ve used a double-quote in one of the descriptions. Either replace them with a single-quote (if you need them in HTML) or &quot; (if you just need to display them).');
      }
    });
    
    tmp = '';
    $('#gmp_tabs input[name=gmp_address]').each(function(index, element){
      tmp += $(element).val();
    });
    if (!tmp) {
      alert('Please define the address in at least one pin.');
      return false;
    }

    var data = {action: 'gmp_preview_map', 'map': gmp_serialize_map(), 'pins': gmp_serialize_pins()};
    $.post(ajaxurl, data, function(response) {
      send_to_editor(response.shortcode);
    }, 'json');

    return false;
  }); // send_shortcode

  // build shortcode via AJAX and show it in a dialog
  $('#gmp_view_shortcode').click(function(){
    if (!$('#gmp_tabs input[name=gmp_address]').length) {
      alert('Please add at least one pin to the map.');
      return false;
    }
    tmp = '';
    $('#gmp_tabs input[name=gmp_address]').each(function(index, element){
      tmp += $(element).val();
    });
    if (!tmp) {
      alert('Please define the address in at least one pin.');
      return false;
    }

    var data = {action: 'gmp_preview_map', 'map': gmp_serialize_map(), 'pins': gmp_serialize_pins()};
    $.post(ajaxurl, data, function(response) {
      //alert(response.shortcode);
      $("#gmp_dialog textarea").val(response.shortcode);
      $("#gmp_dialog").dialog({'dialogClass':'wp-dialog', modal: 1, width: '500', height: '250'});
    }, 'json');

    return false;
  }); // send_shortcode

  // build map via AJAX and preview
  $('#gmp_preview_map').click(function(){
    if (!$('#gmp_tabs input[name=gmp_address]').length) {
      alert('Please add at least one pin to the map.');
      return false;
    }
    
    $('#gmp_tabs input[name=gmp_tooltip]').each(function(index, element){
      if ($(element).val().indexOf('"') != -1) {
        alert('Please note that, due to WP shortcode restrictions, double-quotes can\'t be used in shortcode parameters. You\'ve used a double-quote in one of the tooltips. Either replace them with a single-quote or &quot;');
      }
    });
    $('#gmp_tabs textarea[name=gmp_description]').each(function(index, element){
      if ($(element).val().indexOf('"') != -1) {
        alert('Please note that, due to WP shortcode restrictions, double-quotes can\'t be used in shortcode parameters. You\'ve used a double-quote in one of the descriptions. Either replace them with a single-quote (if you need them in HTML) or &quot; (if you just need to display them).');
      }
    });
    
    tmp = '';
    $('#gmp_tabs input[name=gmp_address]').each(function(index, element){
      tmp += $(element).val();
    });
    if (!tmp) {
      alert('Please define the address in at least one pin.');
      return false;
    }

    var data = {action: 'gmp_preview_map', 'map': gmp_serialize_map(), 'pins': gmp_serialize_pins()};
    $.post(ajaxurl, data, function(response) {
      $('#gmp_test_map').html(response.html);
      wf_gmp_maps = response.js;
      wf_gmp_load_map(1);
    }, 'json');

    return false;
  }); // preview map

  // prompt for map name and save
  $('#gmp_save_map').click(function(){
    map_name = '';
    while (map_name !== null && $.trim(map_name) === '') {
      map_name = prompt('Please enter map name:', gmp_map_name);
    }
    if (map_name === null) {
      return false;
    }
    var data = {action: 'gmp_save_map', 'map': gmp_serialize_map(), 'pins': gmp_serialize_pins(), map_name: map_name};
    $.post(ajaxurl, data, function(response) {
      alert('Map "' + map_name + '" saved!');
      gmp_map_name = map_name;
      gmp_load_maps_list();
    });

    return false;
  }); // save map

  // get map data via AJAX and preview it
  function gmp_load_map_data(map_name) {
    var data = {action: 'gmp_load_map', map_name: map_name};
    $.post(ajaxurl, data, function(response) {
      gmp_unserialize($('#gmp_map_properties'), response.map);
      gmp_delete_all_pins();
      $.each(response.pins, function(index, pin) {
        gmp_add_pin();
        pin_id = $('#gmp_tabs li:last').attr('aria-controls');
        gmp_unserialize($('#' + pin_id), pin);
      });
      gmp_map_name = response.map_name;
      $('#gmp_preview_map').trigger('click');
    }, 'json');
  } // load_map_data

  // delete all pins
  function gmp_delete_all_pins() {
    $('#gmp_tabs li[aria-controls*=tabs-pin-]').each(function(index, element) {
      $('#' + $(this).attr('aria-controls')).remove();
      $(this).remove();
    });
    gmp_tabs.tabs('refresh');
    gmp_tab_counter = 1;
  } // gmp_delete_all_pins


  // uniformed function for unserialize
  function gmp_unserialize(form, data) {
    form = $(form).find('input, textarea, select');
    $(form).each(function(index, element) {
      element_id = $(element).attr('name');
      if (!element_id) {
        element_id = $(element).attr('id');
      }
      if (!element_id) {
        return;
      }

      if ($(element).is('input') && $(element).attr('type') == 'text'
          || $(element).is('textarea')
          || $(element).is('select')) {
        $(element).val(data[element_id]);
      } else if ($(element).is('input') && $(element).attr('type') == 'checkbox') {
        $(element).removeAttr('checked');
        if (data[element_id] !== undefined) {
          $(element).attr('checked', 'checked');
        }
      }

      if ($(element).attr('data-specialtype') == 'colorpicker') {
        $(element).wpColorPicker('color', data[element_id]);
      }
    });
  } // gmp_unserialize

  // serialize map properties, without pins
  function gmp_serialize_map() {
    map = $('#gmp_map_properties input, #gmp_map_properties select, #gmp_map_properties textarea').serialize();

    return map;
  } // gmp_serialize_map

  // serializes pins, without map properties
  function gmp_serialize_pins() {
    pins = new Array();

    $('.gmp_map_pin', gmp_tabs).each(function(index, pin) {
      pins[index] = $('input, select, textarea', pin).serialize();
    }); // foreach pins

    return pins;
  } // gmp_serialize_pins

  // fills up the map list <select>
  function gmp_load_maps_list() {
    $.post(ajaxurl, {action: 'gmp_get_maps_list'}, function(response) {
      $('#gmp_maps_list option').remove();
      $.each(response, function(index, value) {
        $('<option value="' + value + '">' + value +'</option>').appendTo('#gmp_maps_list');
      })
      }, 'json');
  } // gmp_load_maps_list

  // add new, blank pin
  function gmp_add_pin() {
    id = 'tabs-pin-' + gmp_tab_counter;
    label = 'Pin #' + gmp_tab_counter;
    li = '<li><a href="#' + id + '">' + label + '</a> <span class="dashicons dashicons-post-trash gmp_del_pin"></span></li>';
    gmp_tabs.find('.ui-tabs-nav').append(li);
    gmp_tabs.append('<div id="' + id + '"></div>');
    new_pin = $('#gmp_map_pin_master').clone().attr('id', '').show().appendTo('#' + id);
    $('input, select, textarea', new_pin).each(function(index, element){
      org_id = $(element).attr('id');
      new_id = org_id + '-' + Math.floor(Math.random()*9999);
      $(element).attr('id', new_id);
      $('label[for=' + org_id +']', new_pin).attr('for', new_id);
    });

    gmp_tabs.tabs('refresh');
    gmp_tab_counter++;
  } // gmp_add_pin
}); // onload

gmp_gui_help = {
  gmp_width: 'Map canvas width. Enter any acceptable CSS value, ie: 200px, 300em, 60%. If you want the map to be responsive keep it on 100%.',
  gmp_height: 'Map canvas height. Any acceptable CSS value, ie: 200px, 300em, 60%. If a percentage value is used the container has to have a defined height.',
  gmp_zoom: 'Map zoom level. If auto-zoom option is enabled zoom level is ignored.',
  gmp_type: 'Usual map types you can use when viewing Google Maps.',
  gmp_skin: 'Predefined map color scheme that completely transforms the map appearance.',
  gmp_color_help: 'Paints the whole map in defined color (basically ads hue). It partially overrides the skin option.',
  gmp_fullscreen: 'Adds the fullscreen toggle button in the top-righ corner of the map.',
  gmp_traffic: 'Adds the traffic layer to the map. Please note that certain layers are not available on all locations.',
  gmp_transit: 'Adds the transit layer to the map. Please note that certain layers are not available on all locations.',
  gmp_weather: 'Adds the weather layer to the map. Please note that certain layers are not available on all locations.',
  gmp_clouds: 'Adds the clouds layer to the map. Please note that certain layers are not available on all locations.',
  gmp_bicycle: 'Adds the bicycle layer to the map. Please note that certain layers are not available on all locations.',
  gmp_autofit: 'Automatically adjusts zoom level and map center to make all pins visible on the map.',
  gmp_disable_scrollwheel: 'If enabled mouse wheel is disabled on the map.',
  gmp_lock_map: 'Completely locks map and removes all controls (pan, zoom, map type). Great if you use the map in fullscreen on responsive sites.',
  gmp_post_id: 'If you are using custom field values in a widget or want to force another post ID different from the post you are currently in then set this option.',
  gmp_debug: 'Displays various variables used in the process of map building.',
  gmp_address: 'You can enter the address in a normal human readable form or as <i>lat, lng</i> coordinates. Any address in the world that can be understood by Google Geocoding API will work. If the pin is not placed where you expected it, write the address a bit differently. Be sure to include all details such as country name.',
  gmp_icon: 'Pin icon/marker. You can also enter the full URL to any image (size about 35*35px). Please do that once the shortcode is generated and inserted into post.',
  gmp_center: 'Centers map over the pin. If map\'s autofit option is enabled this is ignored. By default first pin is used as center.',
  gmp_bounce: 'Bounces (animates) the pin.',
  gmp_directions: 'Add directions form (to and from pin\'s address) into description bubble.',
  gmp_show_description: 'Open description bubble immediately after map is loaded. Only one pin at a time can have the description open.',
  gmp_tooltip: 'Small, text-only tooltip shown when mouse hovers over pin. Default value is the same as the address.',
  gmp_description: 'Large bubble/popup available on pin click. If you want to style it, target it with "gmp_infowindow" class. Only one description can be open at a time.<br>Any text or HTML can be used. If you put in just the ID of a page/post then its content will be shown in the description. Please use that solution if you have a lot of text.'
};
