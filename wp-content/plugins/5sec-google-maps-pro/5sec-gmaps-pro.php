<?php
/*
Plugin Name: 5sec Google Maps Pro
Plugin URI: http://5sec-google-maps-pro.webfactoryltd.com/
Description: Effortlessly include highly customizable Google Maps on any site.
Author: Web factory Ltd
Version: 1.41
Author URI: http://www.webfactoryltd.com/
Text Domain: wf_gmp
Domain Path: lang
*/


if (!function_exists('add_action')) {
  die('Please don\'t open this file directly!');
}


define('WF_GMP_VER', '1.41');
define('WF_GMP_OPTIONS_KEY', 'wf_gmp');
define('WF_GMP_MAPS_KEY', 'wf_gmp_maps');
define('WF_GMP_PINS_FOLDER', '/images/pins/');


class wf_gmp {
  // init plugin
  static function init() {
    if (is_admin()) {
      if (!version_compare(get_bloginfo('version'), '4.2',  '>=')) {
        add_action('admin_notices', array(__CLASS__, 'min_version_error_wp'));
      }

      // aditional links in plugin description
      add_filter('plugin_action_links_' . basename(dirname(__FILE__)) . '/' . basename(__FILE__), array(__CLASS__, 'plugin_action_links'));
      add_filter('plugin_row_meta', array(__CLASS__, 'plugin_meta_links'), 10, 2);

      // enqueue scripts
      add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));

      // check and set default settings
      self::default_settings(false);

      // settings registration
      add_action('admin_init', array(__CLASS__, 'register_settings'));

      // add options menu
      add_action('admin_menu', array(__CLASS__, 'add_menus'));

      // add meta boxes
      add_action('add_meta_boxes', array(__CLASS__, 'add_meta_boxes'));

      // enqueue CSS and JS
      add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_scripts'));

      // ajax endpoints
      add_action('wp_ajax_gmp_preview_map', array(__CLASS__, 'ajax_preview_map'));
      add_action('wp_ajax_gmp_save_map', array(__CLASS__, 'ajax_save_map'));
      add_action('wp_ajax_gmp_load_map', array(__CLASS__, 'ajax_load_map'));
      add_action('wp_ajax_gmp_delete_map', array(__CLASS__, 'ajax_delete_map'));
      add_action('wp_ajax_gmp_get_maps_list', array(__CLASS__, 'ajax_get_maps_list'));
    } else { // if is_admin
      // add JS/CSS if needed
      add_action('wp_print_styles', array(__CLASS__, 'wp_print_styles'));
      add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));
      add_action('wp_footer', array(__CLASS__, 'footer_enqueue'));
    }

    // add shortcode support to text widget
    if (has_filter('widget_text', 'do_shortcode') === false) {
      add_filter('widget_text', 'do_shortcode');
    }

    self::add_shortcodes();
  } // init


  // textdomain has to be loaded earlier
  static function plugins_loaded() {
    load_plugin_textdomain('wf_gmp', false, basename(dirname(__FILE__)) . '/lang');
  } // plugins_loaded


  // add links to plugin's description in plugins table
  static function plugin_meta_links($links, $file) {
    $documentation_link = '<a target="_blank" href="' . plugin_dir_url(__FILE__) . 'documentation/' .
                          '" title="' . __('View documentation', 'wf_gmp') . '">' . __('Documentation', 'wf_gmp') . '</a>';
    $support_link = '<a target="_blank" href="http://codecanyon.net/user/WebFactory#from" title="' . __('Contact Web factory', 'wf_gmp') . '">' . __('Support', 'wf_gmp') . '</a>';

    if ($file == plugin_basename(__FILE__)) {
      $links[] = $documentation_link;
      $links[] = $support_link;
    }

    return $links;
  } // plugin_meta_links


  // add settings link to plugins page
  static function plugin_action_links($links) {
    $settings_link = '<a href="' . admin_url('options-general.php?page=wf_gmp') . '" title="' . __('Settings for 5sec Google Maps Pro', 'wf_gmp') . '">' . __('Settings', 'wf_gmp') . '</a>';
    array_unshift($links, $settings_link);

    return $links;
  } // plugin_action_links


  // check if we're on the Google Maps options page
  static function is_plugin_page() {
    $current_screen = get_current_screen();

    if ($current_screen->id == 'settings_page_wf_gmp') {
      return true;
    } else {
      return false;
    }
  } // is_plugin_page


  // add necessary files for map builder
  static function admin_enqueue_scripts() {
    $current_screen = get_current_screen();

    if ($current_screen->base == 'post') {
      $options = get_option(WF_GMP_OPTIONS_KEY);

      if ($options['api_key']) {
        wp_enqueue_script('wf_gmp_api', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=weather,places&key=' . $options['api_key'], array(), null, true);
      } else {
        wp_enqueue_script('wf_gmp_api', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=weather,places', array(), null, true);
      }
      wp_enqueue_script('jquery-ui-tabs');
      wp_enqueue_script('wf_gmp', plugins_url('/js/gmp.js', __FILE__), array(), WF_GMP_VER, true);
      wp_enqueue_script('wf_gmp_core', plugins_url('/js/gmp-core.js', __FILE__), array(), WF_GMP_VER, true);
      wp_enqueue_script('wf_gmp_admin', plugins_url('/js/gmp-admin.js', __FILE__), array('wp-color-picker'), WF_GMP_VER, true);
      wp_localize_script('wf_gmp', 'wf_gmp_plugin_url', plugin_dir_url(__FILE__));
      wp_localize_script('wf_gmp', 'wf_gmp_detect_visibility', (string) $options['detect_visibility']);
      wp_enqueue_style('wf_gmp_admin', plugins_url('css/gmp-admin.css', __FILE__), array(), WF_GMP_VER);
      wp_enqueue_style('wp-color-picker');
      wp_enqueue_style('wp-pointer');
      wp_enqueue_script('wp-pointer');
      wp_enqueue_style('wp-jquery-ui-dialog');
      wp_enqueue_script('jquery-ui-dialog');
    } // if post editor
  } // enqueue_scripts


  // register map building box
  static function add_meta_boxes() {
    $options = get_option(WF_GMP_OPTIONS_KEY);

    if (!isset($options['gui_post_types'])) {
      $options['gui_post_types'] = array('post', 'page');
    }

    foreach ($options['gui_post_types'] as $post_type) {
      add_meta_box('gmp-box', '5sec Google Maps Pro Map Builder', array(__CLASS__, 'build_map_box'), $post_type, 'normal', 'high');
    }
  } // add_meta_boxes


  // add plugin menus
  static function add_menus() {
    add_options_page(__('5sec Google Maps Pro', 'wf_gmp'), __('5sec Google Maps Pro', 'wf_gmp'), 'manage_options', 'wf_gmp', array(__CLASS__, 'settings_screen'));
  } // add_menus


  // complete options screen
  static function settings_screen() {
    $options = get_option(WF_GMP_OPTIONS_KEY);

    if (!isset($options['gui_post_types'])) {
      $options['gui_post_types'] = array('post', 'page');
    }

    echo '<div class="wrap">';
    screen_icon();
    echo '<h1>' . __('5sec Google Maps Pro Settings', 'wf_gmp') . '</h1>';
    echo '<form method="post" action="options.php">';
    settings_fields('wf_gmp');
    echo '<table class="form-table">';

    echo '<tr valign="top">
          <th scope="row"><label for="sc_map">' . __('Map Shortcode', 'wf_gmp') . '</label></th>
          <td><input class="regular-text" name="wf_gmp[sc_map]" type="text" id="sc_map" value="' . esc_attr($options['sc_map']) . '" class="regular-text" /><p class="description">If the default shortcode "map" is taken by another plugin change it to something else. Default: map.</p></td>
          </tr>';
    echo '<tr valign="top">
          <th scope="row"><label for="sc_pin">' . __('Pin Shortcode', 'wf_gmp') . '</label></th>
          <td><input class="regular-text" name="wf_gmp[sc_pin]" type="text" id="sc_pin" value="' . esc_attr($options['sc_pin']) . '" class="regular-text" /><p class="description">If the default shortcode for pins inside te map "pin" is taken by another plugin change it to something else. Default: pin.</p></td>
          </tr>';
    echo '<tr valign="top">
          <th scope="row"><label for="api_key">' . __('Google Maps API Key', 'wf_gmp') . '</label></th>
          <td><input name="wf_gmp[api_key]" type="text" id="api_key" value="' . esc_attr($options['api_key']) . '" class="regular-text" /><p class="description">API key is not required if you keep the map usage within <a href="https://developers.google.com/maps/documentation/business/articles/usage_limits" target="_blank">Google\'s limits</a>. If not please create a key using <a href="https://console.developers.google.com/project" target="blank">Google Developers Console</a>.</p></td>
          </tr>';
    echo '<tr valign="top">
          <th scope="row"><label for="include_jquery">' . __('Include jQuery', 'wf_gmp') . '</label></th>
          <td><input name="wf_gmp[include_jquery]" type="checkbox" id="include_jquery" value="1"' . checked('1', $options['include_jquery'], false) . '/><span class="description">If you\'re experiencing problems with double jQuery include disable this option. Default: checked.</span></td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="include_gmaps_api">' . __('Include Google Maps API JS', 'wf_gmp') . '</label></th>
          <td><input name="wf_gmp[include_gmaps_api]" type="checkbox" id="include_gmaps_api" value="1"' . checked('1', $options['include_gmaps_api'], false) . '/><span class="description">If your theme or other plugin already includes Maps JS disable this option. Default: checked.</span></td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="css_fix">' . __('Apply Map CSS Fixes', 'wf_gmp') . '</label></th>
          <td><input name="wf_gmp[css_fix]" type="checkbox" id="css_fix" value="1"' . checked('1', $options['css_fix'], false) . '/><span class="description">Unless you applied the fixes manually keep this option enabled. Default: checked.</span></td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="load_maps">' . __('Automatically Load Maps', 'wf_gmp') . '</label></th>
          <td><input name="wf_gmp[load_maps]" type="checkbox" id="load_maps" value="1"' . checked('1', $options['load_maps'], false) . '/><span class="description">If you want to load maps within another plugin disable this option and use wf_gmp_load_map( map number 1-N ) function to load them. Default: checked.</span></td></tr>';

    echo '<tr valign="top">
          <th scope="row"><label for="detect_visibility">' . __('Detect Visibility Fix', 'wf_gmp') . '</label></th>
          <td><input name="wf_gmp[detect_visibility]" type="checkbox" id="detect_visibility" value="1"' . checked('1', $options['detect_visibility'], false) . '/><span class="description">If you are using maps in tabs or some similar environment where they are initially hidden check this options. Default: unchecked.</span></td></tr>';

    $post_types_options[] = array('val' => 'post', 'label' => 'Posts');
    $post_types_options[] = array('val' => 'page', 'label' => 'Pages');
    $post_types = get_post_types( array('public' => true, '_builtin' => false), 'objects', 'and' );
    foreach ($post_types as $type_str => $type) {
      $post_types_options[] = array('val' => $type_str, 'label' => $type->labels->name);
    }

    echo '<tr valign="top">
          <th scope="row"><label for="map_builder">' . __('Map Builder GUI', 'wf_gmp') . '</label></th>
          <td><span class="description">Map builder GUI will only be shown on the edit screen for post types selected here (you can use the shortcode in all posts, regardless of this setting). Default: posts and pages.</span><br>';
    echo '<select id="gui_post_types" style="min-width: 200px;" name="wf_gmp[gui_post_types][]" multiple="multiple" size="6">';
    self::create_select_options($post_types_options, $options['gui_post_types'], true);
    echo '</select>';
    echo '</td></tr>';

    echo '</table>';
    submit_button(__('Save Settings', 'wf_gmp'));

    echo '</form>';
    echo '</div>'; // wrap
  } // settings_screen


  // enqueue CSS and JS scripts for frontend
  static function enqueue_scripts() {
    $options = get_option(WF_GMP_OPTIONS_KEY);

    if ($options['api_key']) {
      wp_register_script('wf_gmp_api', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=weather,places&key=' . $options['api_key'], array(), null, true);
    } else {
      wp_register_script('wf_gmp_api', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=weather,places', array(), null, true);
    }
    wp_register_script('wf_gmp', plugins_url('/js/gmp.js', __FILE__), array(), WF_GMP_VER, true);
    wp_register_script('wf_gmp_core', plugins_url('/js/gmp-core.js', __FILE__), array(), WF_GMP_VER, true);
  } // enqueue_scripts


  // print CSS fixes in header
  static function wp_print_styles() {
    $options = get_option(WF_GMP_OPTIONS_KEY);

    if ($options['css_fix']) {
      echo '<style type="text/css">.wf-gmp-canvas img{max-width:none!important;}.gmp_infowindow{min-width:100px;max-width:350px;}.wf-gmp-canvas>div:first-child{width:100%;} .gmp_directions{margin:5px}.gmp_directions input[type=submit]:hover{color:#000;font-weight:700}.gmp_switch img{margin:4px}.gmp_directions input[type=submit]{display:inline-block;text-transform:none;border:1px solid #dcdcdc;text-align:center;color:#444;font-size:13px;font-weight:400;padding:0 8px;line-height:27px;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;-webkit-transition:all .218s;-moz-transition:all .218s;-o-transition:all .218s;transition:all .218s;background-color:#f5f5f5;background-image:-webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));background-image:-webkit-linear-gradient(top,#f5f5f5,#f1f1f1);background-image:-moz-linear-gradient(top,#f5f5f5,#f1f1f1);background-image:-ms-linear-gradient(top,#f5f5f5,#f1f1f1);background-image:-o-linear-gradient(top,#f5f5f5,#f1f1f1);background-image:linear-gradient(top,#f5f5f5,#f1f1f1);filter:progid:DXImageTransform.Microsoft.gradient(startColorStr=\'#f5f5f5\', EndColorStr=\'#f1f1f1\')}.gmp_directions input[type=text]{width:160px;display:inline;background-color:#fff;padding:4px;border:1px solid #d9d9d9;-webkit-border-radius:1px;-moz-border-radius:1px;border-radius:1px;line-height:16px;margin:3px;color:#000;font-family:arial,helvetica,sans-serif;font-size:13px}</style>' . "\n";
    }
  } // wp_print_styles


  // include our JS only when needed
  static function footer_enqueue() {
    global $wf_gmp_maps;
    $options = get_option(WF_GMP_OPTIONS_KEY);

    if ($wf_gmp_maps) {
      if ($options['include_gmaps_api']) {
        wp_enqueue_script('wf_gmp_api');
      }
      if ($options['include_jquery']) {
        wp_enqueue_script('jquery');
      }

      wp_enqueue_script('wf_gmp');
      wp_enqueue_script('wf_gmp_core');
      wp_localize_script('wf_gmp', 'wf_gmp_maps', json_encode($wf_gmp_maps));
      wp_localize_script('wf_gmp', 'wf_gmp_autoload', (string) $options['load_maps']);
      wp_localize_script('wf_gmp', 'wf_gmp_detect_visibility', (string) $options['detect_visibility']);
      wp_localize_script('wf_gmp', 'wf_gmp_plugin_url', plugin_dir_url(__FILE__));
    }
  } // footer_enqueue


  // check if shortcodes have conflicts and register them
  static function add_shortcodes() {
    global $shortcode_tags;
    $options = get_option(WF_GMP_OPTIONS_KEY);

    if (isset($shortcode_tags[$options['sc_map']])) {
      add_action('admin_notices', array(__CLASS__, 'sc_conflict_error'));
    } else {
      add_shortcode($options['sc_map'], array(__CLASS__, 'do_sc_map'));
    }

    if (isset($shortcode_tags[$options['sc_pin']])) {
      add_action('admin_notices', array(__CLASS__, 'sc_conflict_error'));
    } else {
      add_shortcode($options['sc_pin'], array(__CLASS__, 'do_sc_pin'));
    }
  } // add_shortcodes


  // display notice in case of shortcode conflicts
  static function sc_conflict_error() {
    global $shortcode_tags;
    $out = '';
    $options = get_option(WF_GMP_OPTIONS_KEY);

    if (isset($shortcode_tags[$options['sc_map']])) {
      $out .= '[' . $options['sc_map'] . '], ';
    }
    if (isset($shortcode_tags[$options['sc_pin']])) {
      $out .= '[' . $options['sc_pin'] . '], ';
    }
    $out = trim($out, ', ');

    if (substr_count($out, '[') == 2) {
      echo '<div id="message" class="error"><p><strong>' . __('5sec Google Maps Pro is not active!', 'wf_gmp') . '</strong> Shortcodes <i>' . $out . '</i> are already in use by another plugin or theme. Please use <a href="' . admin_url('options-general.php?page=wf_gmp') .'">settings</a> to set different shortcodes.</p></div>';
    } else {
      echo '<div id="message" class="error"><p><strong>' . __('5sec Google Maps Pro is not active!', 'wf_gmp') . '</strong> Shortcode <i>' . $out . '</i> is already in use by another plugin or theme. Please use <a href="' . admin_url('options-general.php?page=wf_gmp') .'">settings</a> to set a different shortcode.</p></div>';
    }
  } // sc_conflict_error


  // set default options
  static function default_settings($force = false) {
    $defaults = array('sc_map'           => 'map',
                      'sc_pin'            => 'pin',
                      'api_key'           => '',
                      'include_jquery'    => '1',
                      'include_gmaps_api' => '1',
                      'css_fix'           => '1',
                      'load_maps'         => '1',
                      'detect_visibility' => '0',
                      'gui_post_types'    => array('post', 'page'));

    $options = get_option(WF_GMP_OPTIONS_KEY);

    if ($force || !$options || !$options['sc_map']) {
      update_option(WF_GMP_OPTIONS_KEY, $defaults);
    }
  } // default_settings


  // sanitize settings on save
  static function sanitize_settings($values) {
    $old_options = get_option(WF_GMP_OPTIONS_KEY);

    foreach ($values as $key => $value) {
      switch ($key) {
        case 'sc_map':
        case 'sc_pin':
        case 'api_key':
          $values[$key] = str_replace(' ', '', $value);
        break;
        case 'include_jquery':
        case 'include_gmaps_api':
        case 'css_fix':
        case 'load_maps':
        case 'detect_visibility':
          $values[$key] = (int) $value;
        break;
      } // switch
    } // foreach

    self::check_var_isset($values, array('include_jquery' => 0, 'include_gmaps_api' => 0, 'css_fix' => 0, 'load_maps' => 0, 'detect_visibility' => 0, 'gui_post_types' => array()));

    if (!$values['sc_map']) {
      $values['sc_map'] = 'map';
    }
    if (!$values['sc_pin']) {
      $values['sc_pin'] = 'pin';
    }

    return array_merge($old_options, $values);
  } // sanitize_settings


  // all settings are saved in one option key
  static function register_settings() {
    register_setting(WF_GMP_OPTIONS_KEY, WF_GMP_OPTIONS_KEY, array(__CLASS__, 'sanitize_settings'));
  } // register_settings


  // helper function for creating dropdowns
  static function create_select_options($options, $selected = null, $output = true) {
    $out = "\n";

    if(!is_array($selected)) {
      $selected = array($selected);
    }

    foreach ($options as $tmp) {
      if (in_array($tmp['val'], $selected)) {
        $out .= "<option selected=\"selected\" value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      } else {
        $out .= "<option value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      }
    } // foreach

    if ($output) {
      echo $out;
    } else {
      return $out;
    }
  } // create_select_options


  // helper function for $_POST checkbox handling
  static function check_var_isset(&$values, $variables) {
    foreach ($variables as $key => $value) {
      if (!isset($values[$key])) {
        $values[$key] = $value;
      }
    }
  } // check_var_isset


  // display warning if WP is outdated
  static function min_version_error_wp() {
    echo '<div id="message" class="error"><p>' . __('5sec Google Maps Pro <b>requires WordPress version 4.2</b> or higher to function properly.', 'wf_gmp') . ' You\'re using WordPress version ' . get_bloginfo('version') . '. Please <a href="' . admin_url('update-core.php') . '" title="Update WP core">update</a>.</p></div>';
  } // min_version_error_wp


  // clean-up when deactivated
  static function deactivate() {
    delete_option(WF_GMP_OPTIONS_KEY);
    delete_option(WF_GMP_MAPS_KEY);
  } // deactivate


  // parses the map shortcode
  static function do_sc_map($atts, $content = '') {
    global $wf_gmp_doing_sc, $wf_gmp_maps, $post, $map_id;
    $map = array();
    $out = '';
    $wf_gmp_doing_sc = true;
    if (!is_array($wf_gmp_maps)) {
      $wf_gmp_maps = array();
    }
    $map_id = sizeof($wf_gmp_maps) + 1;

    $atts = shortcode_atts(array('width'   => '100%',
                                 'height'  => '400px',
                                 'zoom' => '14',
                                 'color' => '',
                                 'skin' => '',
                                 'fullscreen' => false,
                                 'type' => 'road',
                                 'traffic' => false,
                                 'transit' => false,
                                 'weather' => false,
                                 'clouds' => false,
                                 'bicycle' => false,
                                 'disable_scrollwheel' => false,
                                 'lock_map' => false,
                                 'autofit' => false,
                                 'debug' => false,
                                 'post_id' => @$post->ID),
                           $atts);

    // if we're in a post, replace $value with custom field values
    $atts['post_id'] = (int) $atts['post_id'];
    if ($atts['post_id']) {
      foreach ($atts as $param => $val) {
        $tmp = '';
        $val = explode(' ', $val);
        foreach($val as $val2) {
          $val2 = trim($val2);
          if (substr($val2, 0, 1) == '$' && substr($val2, 0, 2) != '$$') {
            $tmp .= ' ' . get_post_meta($atts['post_id'], str_replace('$', '', $val2), true);
          } elseif (substr($val2, 0, 2) == '$$') {
            $tmp .= ' ' . substr($val2, 1);
          } else {
            $tmp .= ' ' . $val2;
          }
        } // foreach val arr
        $atts[$param] = trim($tmp);
      } // foreach atts
    } // if $post_id

    // width
    $atts['width'] = trim($atts['width']);
    if (empty($atts['width'])) {
      $atts['width'] = '100%';
    }
    if (is_numeric($atts['width'])) {
      $atts['width'] .= 'px';
    }

    // height
    $atts['height'] = trim($atts['height']);
    if (empty($atts['height'])) {
      $atts['height'] = '400px';
    }
    if (is_numeric($atts['height'])) {
      $atts['height'] .= 'px';
    }

    // zoom
    $atts['zoom'] = (int) $atts['zoom'];
    if ($atts['zoom'] < 0 || $atts['zoom'] > 21) {
      $atts['zoom'] = 17;
    }

    // color
    $atts['color'] = ltrim(trim($atts['color']), '#');
    if (strlen($atts['color']) == 6 && ctype_xdigit($atts['color'])) {
      $atts['color'] = '#' . $atts['color'];
    } else {
      $atts['color'] = '';
    }

    // skin
    $atts['skin'] = strtolower(trim($atts['skin']));

    // fullscreen
    $atts['fullscreen'] = (bool) $atts['fullscreen'];

    // autofit all pins on the map
    $atts['autofit'] = (bool) $atts['autofit'];

    // map type
    switch (strtolower($atts['type'])) {
      case 'satellite':
      case 'satelite':
      case 'sat':
        $atts['type'] = 'satellite';
      break;
      case 'hybrid':
      case 'hybride':
      case 'hy':
      case 'hyb':
        $atts['type'] = 'hybrid';
      break;
      case 'terrain':
      case 'terra':
      case 'terr':
      case 'terraine':
        $atts['type'] = 'terrain';
      break;
      case 'roadmap':
      case 'road':
      case 'roads':
      default:
        $atts['type'] = 'roadmap';
    }

    // traffic layer
    $atts['traffic'] = (bool) $atts['traffic'];

    // transit layer
    $atts['transit'] = (bool) $atts['transit'];

    // bicycle layer
    $atts['bicycle'] = (bool) $atts['bicycle'];

    // weather layer
    $atts['weather'] = (bool) $atts['weather'];

    // clouds layer
    $atts['clouds'] = (bool) $atts['clouds'];

    // disable mouse wheel on map
    $atts['disable_scrollwheel'] = (bool) $atts['disable_scrollwheel'];

    // completely lock map
    $atts['lock_map'] = (bool) $atts['lock_map'];

    // misc
    $atts['debug'] = (bool) $atts['debug'];
    $atts['pins'] = array();

    $wf_gmp_maps[$map_id - 1] = $atts;
    do_shortcode($content);

    // pin that's used for the map center has to be first in array
    $tmp = false;
    $pins = $wf_gmp_maps[$map_id - 1]['pins'];
    for ($i = 0; $i < sizeof($pins); $i++) {
      if ((bool) $pins[$i]['center']) {
        $tmp = $pins[$i];
        unset($pins[$i]);
        break;
      }
    }
    if ($tmp) {
      array_unshift($pins, $tmp);
      $wf_gmp_maps[$map_id - 1]['pins'] = $pins;
    }
    unset($pins);

    // add debug info
    if ($atts['debug']) {
      $out .= '<pre>';
      $out .= var_export($wf_gmp_maps[$map_id - 1], true) . '<br />';
      $out .= '</pre>';
    }

    $out .= '<div class="wf-gmp-canvas" id="wf-gmp_' . $map_id . '" style="width:' . $atts['width'] . '; height:' . $atts['height'] . ';"></div>' . "\n";

    $wf_gmp_doing_sc = $map_id = false;
    return $out;
  } // do_sc_map


  // parse individual map pins
  static function do_sc_pin($atts, $content = '') {
    global $wf_gmp_doing_sc, $wf_gmp_maps, $post, $map_id;
    $pin = array();

    if(!$wf_gmp_doing_sc || !$map_id) {
      echo '<span style="color: red;">' . __('Please don\'t use the 5sec Google Maps Pro [pin] shortcode outside the [map] shortcode.', 'wf_gmp') . '</span>';
      return false;
    }

    $map = $wf_gmp_maps[$map_id - 1];

    $atts = shortcode_atts(array('address' => '',
                                 'description' => '',
                                 'tooltip' => '',
                                 'center' => false,
                                 'bounce' => false,
                                 'latlng' => false,
                                 'disable_cache' => false,
                                 'lat' => 0,
                                 'lng' => 0,
                                 'directions' => false,
                                 'show_description' => false,
                                 'icon' => ''),
                           $atts);

    if (!empty($content)) {
      $atts['address'] = trim($content);
    } else {
      $atts['address'] = trim($atts['address']);
    }

    if (!$atts['address']) {
      return false;
    }

    // parse custom vars
    if ($map['post_id']) {
      foreach ($atts as $param => $val) {
        $tmp = '';
        $val = explode(' ', $val);
        foreach($val as $val2) {
          $val2 = trim($val2);
          if (substr($val2, 0, 1) == '$' && substr($val2, 0, 2) != '$$') {
            $tmp .= ' ' . get_post_meta($map['post_id'], str_replace('$', '', $val2), true);
          } elseif (substr($val2, 0, 2) == '$$') {
            $tmp .= ' ' . substr($val2, 1);
          } else {
            $tmp .= ' ' . $val2;
          }
        } // foreach val arr
        $atts[$param] = trim($tmp);
      } // foreach
    } // if $post_id

    // icon
    switch (strtolower($atts['icon'])) {
      case 'blue':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'blue-pin.png', __FILE__);
      break;
      case 'blue2':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'blue-dot.png', __FILE__);
      break;
      case 'blue3':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'ltblue-dot.png', __FILE__);
      break;
      case 'red':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'red-pin.png', __FILE__);
      break;
      case 'red2':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'red-dot.png', __FILE__);
      break;
      case 'yellow':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'yellow-pin.png', __FILE__);
      break;
      case 'yellow2':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'yellow-dot.png', __FILE__);
      break;
      case 'green':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'green-pin.png', __FILE__);
      break;
      case 'green2':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'green-dot.png', __FILE__);
      break;
      case 'pink':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'pink-dot.png', __FILE__);
      break;
      case 'purple':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'purple-dot.png', __FILE__);
      break;
      case 'orange':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'orange-dot.png', __FILE__);
      break;
      case 'grey':
      case 'gray':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'grey-pin.png', __FILE__);
      break;
      case 'black':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'black-pin.png', __FILE__);
      break;
      case 'white':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'white-pin.png', __FILE__);
      break;
      case 'house':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'house.png', __FILE__);
      break;
      case 'shop':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'shop.png', __FILE__);
      break;
      case 'chat':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'chat.png', __FILE__);
      break;
      case 'flag':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'flag.png', __FILE__);
      break;
      case 'star':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'star.png', __FILE__);
      break;
      case 'food':
      case 'restaurant':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'restaurant.png', __FILE__);
      break;
      case 'nuclear':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'nuclear.png', __FILE__);
      break;
      case 'none':
      case 'empty':
      case 'clear':
      case 'hidden':
        $atts['icon'] = plugins_url(WF_GMP_PINS_FOLDER . 'clear.gif', __FILE__);
      break;
      case 'default':
        $atts['icon'] = '';
      break;
      default:
    }

    // set title / tooltip
    if (empty($atts['tooltip'])) {
      $atts['tooltip'] = $atts['address'];
    } elseif ($atts['tooltip'] == 'false') {
      $atts['tooltip'] = '';
    }

    // autodetect lat/lng in address
    $atts['latlng'] = (bool) $atts['latlng'];
    if ($atts['latlng'] === false) {
      if (preg_match('|^([-+]?\d{1,2}([.]\d+)?),\s*([-+]?\d{1,3}([.]\d+)?)$|', $atts['address'])) {
        $atts['latlng'] = true;
        $tmp = explode(',', $atts['address']);
        $atts['lat'] = trim($tmp[0]);
        $atts['lng'] = trim($tmp[1]);
      }
    }

    // pull geocoding from cache
    if (!$atts['disable_cache'] && !$atts['lat'] && !$atts['lng']) {
      $cache = self::get_coordinates($atts['address'], false);
      if ($cache) {
        $atts['lat'] = $cache['lat'];
        $atts['lng'] = $cache['lng'];
        $atts['cache_address'] = $cache['address'];
        $atts['from_cache'] = true;
        $atts['latlng'] = true;
      } else {
        $atts['from_cache'] = false;
      }
    } else {
      $atts['from_cache'] = false;
    }

    // show description on load
    $atts['show_description'] = (int) (bool) $atts['show_description'];

    // description / bubble
    if (is_numeric($atts['description'])) {
      $tmp = get_post($atts['description']);
      $tmp = apply_filters('the_content', $tmp->post_content);
      $atts['description'] = $tmp;
    }

    // show description on load
    $atts['directions'] = (bool) $atts['directions'];
    if ($atts['directions']) {
      $atts['description'] .= '<div class="gmp_directions">';
      $atts['description'] .= '<form action="http://maps.google.com/maps" method="get" target="_blank">';
$atts['description'] .= ' <a href="#" class="gmp_switch"><img src="' . plugin_dir_url(__FILE__) . '/images/switch.png" alt="Switch start/destination addresses" title="Switch start/destination addresses"></a>';
      $atts['description'] .= '<span class="gmp_start">';
      $atts['description'] .= ' <input type="text" placeholder="' . __('Start address', 'wf_gmp') . '" name="saddr" value="" />';
      $atts['description'] .= ' <input type="hidden" name="daddr" value="' . $atts['address'] . '" />';
      $atts['description'] .= ' <input value="' . __('Get directions from entered address', 'wf_gmp') . '" type="submit" />';
      $atts['description'] .= '</span>';
      $atts['description'] .= '<span class="gmp_end" style="display: none;">';
      $atts['description'] .= ' <input disabled="disabled" type="text" placeholder="' . __('Destination address', 'wf_gmp') . '" name="daddr" value="" />';
      $atts['description'] .= ' <input disabled="disabled" type="hidden" name="saddr" value="' . $atts['address'] . '" />';
      $atts['description'] .= ' <input value="' . __('Get directions to entered address', 'wf_gmp') . '" type="submit" />';
      $atts['description'] .= '</span>';
      $atts['description'] .= '</div>';
    }

    // add bounce animation to pin
    $atts['bounce'] = (bool) $atts['bounce'];

    $wf_gmp_maps[$map_id - 1]['pins'][] = $atts;
    return false;
  } // do_sc_pin


  // fetch coordinates based on the address
  static function get_coordinates($address, $force_refresh = false) {
    $address_hash = md5('gmp' . $address);

    if ($force_refresh || ($coordinates = get_transient($address_hash)) === false) {
      $url = 'http://maps.googleapis.com/maps/api/geocode/xml?address=' . urlencode($address) . '&sensor=false';
      $result = wp_remote_get($url);

      if (!is_wp_error($result) && $result['response']['code'] == 200) {
        $data = new SimpleXMLElement($result['body']);

        if ($data->status == 'OK') {
          $cache_value['lat']     = (string) $data->result->geometry->location->lat;
          $cache_value['lng']     = (string) $data->result->geometry->location->lng;
          $cache_value['address'] = (string) $data->result->formatted_address;

          // cache coordinates for 3 months
          set_transient($address_hash, $cache_value, DAY_IN_SECONDS * 30);
          $data = $cache_value;
        } elseif (!$data->status) {
          return false;
        } else {
          return false;
        }
      } else {
         return false;
      }
    } else {
       // data is cached, get it
       $data = get_transient($address_hash);
    }

    return $data;
  } // get_coordinates


  // complete map builder markup
  static function build_map_box() {
    echo '<div id="gmp_maps_box">';
    echo '<ul><li><a href="#gmp_maps_box_inner">Saved maps</a></li></ul>';
    echo '<div id="gmp_maps_box_inner">';
    echo '<select id="gmp_maps_list" size="5"></select><br>';
    echo '<a href="#" class="button button-secondary" id="gmp_load_map">Load map</a> ';
    echo '<a href="#" class="button button-secondary" id="gmp_save_map">Save map</a> ';
    echo '<a href="#" class="button button-secondary delete-theme" id="gmp_delete_map">Delete map</a> ';

    echo '<hr><a href="#" class="button button-primary" id="gmp_preview_map">Preview current map settings</a> ';
    echo '<a href="#" class="button button-secondary" id="gmp_send_shortcode">Send shortcode to editor</a>';
    echo '<a href="#" class="button button-secondary" id="gmp_view_shortcode">View shortcode</a>';
    echo '</div>';
    echo '</div>'; // maps_box

    echo '<div id="gmp_single_map">';
    echo '<a class="button button-small" href="#" id="gmp_add_pin">Add new pin <div class="dashicons dashicons-plus"></div></a>';
    echo '<div id="gmp_tabs"><ul id="gmp_tabs_list"><li><a href="#gmp_map_properties">Map properties</a></li></ul>';

    echo '<div id="gmp_map_properties">';
    echo '<span class="gmp_textbox"><label for="gmp_width">Width: </label><input placeholder="100%" type="text" id="gmp_width" name="gmp_width" /><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_textbox"><label for="gmp_height">Height: </label><input type="text" placeholder="400px" name="gmp_height" id="gmp_height" /><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_textbox"><label for="gmp_zoom">Zoom: </label><select id="gmp_zoom" name="gmp_zoom"><option value=""> default </option><option value="0"> 0 </option><option value="1"> 1 </option><option value="2"> 2 </option><option value="3"> 3 </option><option value="4"> 4 </option><option value="5"> 5 </option><option value="6"> 6 </option><option value="7"> 7 </option><option value="8"> 8 </option><option value="9"> 9 </option><option value="10"> 10 </option><option value="11"> 11 </option><option value="12"> 12 </option><option value="13"> 13 </option><option value="14"> 14 </option><option value="15"> 15 </option><option value="16"> 16 </option><option value="17"> 17 </option><option value="18"> 18 </option><option value="19"> 19 </option><option value="20"> 20 </option><option value="21"> 21 </option></select><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';

    echo '<b class="gmp_title">Appearance:</b>';

    echo '<span class="gmp_textbox"><label for="gmp_type">Type: </label><select id="gmp_type" name="gmp_type"><option value=""> default </option><option value="hybrid">hybrid</option><option value="roadmap">roadmap</option><option value="satellite">satellite</option><option value="terrain">terrain</option></select><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_textbox"><label for="gmp_skin">Skin: </label><select id="gmp_skin" name="gmp_skin"><option value="">default</option><option value="apple">apple</option><option value="blue">blue</option><option value="bright">bright</option><option value="gowalla">gowalla</option><option value="gray">gray</option><option value="gray2">gray2</option><option value="light">light</option><option value="mapbox">mapbox</option><option value="pale">pale</option><option value="paper">paper</option></select><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_textbox"><label for="gmp_color">Map hue: </label><input data-specialtype="colorpicker" type="text" id="gmp_color" name="gmp_color" /><div id="gmp_color_help" data-for="gmp_color_help" class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" id="gmp_fullscreen" name="gmp_fullscreen" value="1" /> <label for="gmp_fullscreen">Fullscreen button</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';

    echo '<b class="gmp_title">Layers:</b>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_traffic" id="gmp_traffic" value="1" /> <label for="gmp_traffic">Traffic layer</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_transit" id="gmp_transit" value="1" /> <label for="gmp_transit">Transit layer</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_weather" id="gmp_weather" value="1" /> <label for="gmp_weather">Weather layer</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_clouds" id="gmp_clouds" value="1" /> <label for="gmp_clouds">Clouds layer</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_bicycle" id="gmp_bicycle" value="1" /> <label for="gmp_bicycle">Bicycle tracks layer</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';

    echo '<b class="gmp_title">Miscellaneous options:</b>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_autofit" id="gmp_autofit" value="1" /> <label for="gmp_autofit">Auto-zoom to fit all pins</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_disable_scrollwheel" id="gmp_disable_scrollwheel" value="1" /> <label for="gmp_disable_scrollwheel">Disable mouse scrollwheel</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_lock_map" id="gmp_lock_map" value="1" /> <label for="gmp_lock_map">Lock map</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_textbox"><label for="gmp_post_id">Post ID: </label><input placeholder="0" type="text" name="gmp_post_id" id="gmp_post_id" /><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_debug" id="gmp_debug" value="1" /> <label for="gmp_debug">Debug</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '</div>'; // map_properties
    echo '</div>'; // tabs
    echo '</div>'; // single map

    // master pin
    echo '<div class="gmp_map_pin" style="display: none;" id="gmp_map_pin_master">';
    echo '<span class="gmp_textbox"><label for="gmp_address">Address: </label><input class="regular-text" type="text" name="gmp_address" id="gmp_address" /><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_textbox"><label for="gmp_icon">Icon: </label><select id="gmp_icon" name="gmp_icon"><option value="">default</option><option value="blue">blue</option> <option value="blue2">blue2</option> <option value="blue3">blue3</option> <option value="red">red</option> <option value="red2">red2</option> <option value="yellow">yellow</option> <option value="yellow2">yellow2</option> <option value="green">green</option> <option value="green2">green2</option> <option value="pink">pink</option> <option value="purple">purple</option> <option value="orange">orange</option> <option value="grey">grey</option> <option value="black">black</option> <option value="white">white</option> <option value="house">house</option> <option value="shop">shop</option> <option value="chat">chat</option> <option value="flag">flag</option> <option value="star">star</option> <option value="food">food</option> <option value="nuclear">nuclear</option> <option value="none">hiden/none</option></select><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span><br>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_center" id="gmp_center" value="1" /> <label for="gmp_center">Center map over this pin</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_bounce" id="gmp_bounce" value="1" /> <label for="gmp_bounce">Bounce pin</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_directions" id="gmp_directions" value="1" /> <label for="gmp_directions">Show directions form in description</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_checkbox"><input type="checkbox" name="gmp_show_description" id="gmp_show_description" value="1" /> <label for="gmp_show_description">Auto-open description bubble</label><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_textbox"><label for="gmp_tooltip">Tooltip: </label><input class="regular-text" type="text" name="gmp_tooltip" id="gmp_tooltip" /><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '<span class="gmp_textbox"><label for="gmp_description">Description: </label><textarea rows="3" id="gmp_description" name="gmp_description"></textarea><div class="dashicons dashicons-editor-help gmp_tooltip"></div></span>';
    echo '</div>'; // pin
    echo '<div id="gmp_separator"></div>';

    echo '<div id="gmp_test_map"></div>';
    echo '<a target="_blank" href="' . plugin_dir_url(__FILE__) . 'documentation/' . '" title="' . __('View documentation', 'wf_gmp') . '">' . __('View documentation', 'wf_gmp') . '</a>';;
    echo '<div id="gmp_dialog" class="wp-dialog" style="display: none;" title="5sec Google Maps Pro"><textarea style="width: 100%; height: 98%; padding: 15px;"></textarea></div>';
  } // build_map_box


  // build map from received params
  static function ajax_preview_map() {
    global $wf_gmp_maps;
    $options = get_option(WF_GMP_OPTIONS_KEY);
    $out = array();
    $pins = '';

    $map = '[' . $options['sc_map'] . ' ';
    parse_str($_POST['map'], $map_raw);
    foreach ($map_raw as $param => $val) {
      if ($val === '') {
        continue;
      }
      $param = str_replace('gmp_', '', $param);
      $map .= $param . '="' . $val . '" ';
    }
    $map = trim($map) . ']' . "\n";

    $pins_raw = $_POST['pins'];
    foreach ($pins_raw as $pins_tmp) {
      $pin_single = '';
      parse_str($pins_tmp, $pins_tmp);
      foreach ($pins_tmp as $param => $val) {
        if ($val === '') {
          continue;
        }
        $val = stripcslashes($val);
        $param = str_replace('gmp_', '', $param);
        if ($param == 'address') {
          $address = $val;
          continue;
        }
        $pin_single .= $param . '="' . $val . '" ';
      }
      if ($pin_single || $address) {
        $pin_single = '[' . $options['sc_pin'] . ' ' . $pin_single;
        $pins .= '  ' . trim($pin_single) . ']' . $address . '[/' . $options['sc_pin'] . ']' . "\n";
      }
    } // foreach pins

    $shortcode = $map . $pins . '[/' . $options['sc_map'] . ']';

    $out['html'] = do_shortcode($shortcode);
    $out['js'] = $wf_gmp_maps;
    $out['shortcode'] = $shortcode;

    die(json_encode($out));
  } // ajax_build_map


  // save map details to DB
  static function ajax_save_map() {
    $out = array();
    $pins = '';
    $saved_maps = get_option(WF_GMP_MAPS_KEY);

    $map_name = substr($_POST['map_name'], 0, 20);
    if (empty($map_name)) {
      $map_name = 'map-' . rand(1, 99);
    }

    parse_str($_POST['map'], $map);

    $pins = $_POST['pins'];
    for($i = 0; $i < sizeof($pins); $i++) {
      parse_str($pins[$i], $pins_tmp);
      foreach($pins_tmp as $tmp_key => $tmp_val) {
        $pins_tmp[$tmp_key] = stripcslashes($tmp_val);
      }
      $pins[$i] = $pins_tmp;
    } // for pins

    $out['map'] = $map;
    $out['pins'] = $pins;
    $saved_maps[$map_name] = $out;
    update_option(WF_GMP_MAPS_KEY, $saved_maps);

    die('1');
  } // ajax_save_map


  // retreive map list (only names)
  static function ajax_get_maps_list() {
    $saved_maps = get_option(WF_GMP_MAPS_KEY);

    if (is_array($saved_maps)) {
      $maps = array_keys($saved_maps);
    } else {
      $maps = array();
    }

    die(json_encode($maps));
  } // ajax_get_maps_list


  // retreive map details from DB
  static function ajax_load_map() {
    $saved_maps = get_option(WF_GMP_MAPS_KEY);
    $map_name = substr($_POST['map_name'], 0, 20);

    $out = $saved_maps[$map_name];
    $out['map_name'] = $map_name;

    die(json_encode($out));
  } // ajax_load_map


  // delete map from DB
  static function ajax_delete_map() {
    $out = false;
    $saved_maps = get_option(WF_GMP_MAPS_KEY);
    $map_name = substr($_POST['map_name'], 0, 20);

    if (isset($saved_maps[$map_name])) {
      unset($saved_maps[$map_name]);
      update_option(WF_GMP_MAPS_KEY, $saved_maps);
      $out = true;
    }

    die(json_encode($out));
  } // ajax_load_map
} // wf_gmp class


// hook everything up
add_action('init', array('wf_gmp', 'init'));

// texdomain has to be loaded earlier
add_action('plugins_loaded', array('wf_gmp', 'plugins_loaded'));

// when deativated clean up
register_deactivation_hook( __FILE__, array('wf_gmp', 'deactivate'));
