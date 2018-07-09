<?php
/*
Plugin Name: Team Showcase
Plugin URI: http://cmoreira.net/team-showcase
Description: This plugin allows you to manage the members of your team/staff and display them in multiple ways.
Author: Carlos Moreira
Version: 2.0.3
Author URI: http://cmoreira.net
Plugin URI: http://cmoreira.net/team-showcase
Text Domain: tshowcase
Domain Path: /lang
*/

//Last modified: May 14th 2018

// next *possible* updates
// > sorting table headers
// > custom icons for taxonomies
// > custom order for fields via shortcode parameter
// > option to download vcard **
// > shortcode to 'edit my profile'
// > translation files
// > Layers Integration
// > set image by url
// > wait for images to load ajax pagination
// > default category to display on live filter
// > back to main page snippet


//Latest updates
//updated fontawesome version to 5.0.2
//included option to add header titles to table layout
//fixed css issue.
//removed option to register plugin - was not working properly
//added better integration with WPML and Polylang
//worked on option to limit one entry per user - added option on settings page
//improved order by last name option
//fixed filter+lightbox issue
//added site='' parameter for shortcode, to fetch entries from another blog/site by blog id.
//fixed function for divi
//improved isotope filter
//added fix for orderby slug in dropdown for the search form
//improved code for search results with pagination
//implemented order by random (on session) to allow correct pagination with random order
//added fourth taxonomy
//edited search code to allow 'loadmore' to be kept on search results
//added 'search' parameter to shortcode
//added option to register the plugin for automatic updates
//added administration filters
//Added third taxomy
//Added shortcode parameter to read which taxonomy to use to create live filters
//added meta_query parameter to shortcode (non documented) : meta_query='_tsposition:Position:LIKE'
//personal url link fixed in table layout
//added do_shortcode for custom fields
//Added option to include JSON-LD structural data type 'Person' to single pages
//redirect user pages to associated team member entry
//lightbox feature added
//table layout now abides to field order array
//load more feature (in pagination options)
//improved global variables, replaced with apply_filters()
//improved tel: links
//workaround implemented to fix 'associated user url' option
//bug fix on table layout - link to personal URL
//Isotope Filter Bug Fix
//Added IMDB social icon
//Improved Order By 'Last Word In Name Feature'
//Added 'Load More' button 
//Improved new 'Order by Last Word in Name Feature'
//Added 'Search' and 'All' label options in the settings
//added 'include' and 'includetax' parameters to search shortcode
//added undocumented dropdown filter option
//ajax pagination improvements
//search label fix in form
//pager js code modification
//orderby slug for groups also on layouts
//meta_key and orderby='meta_value_num' shortcode parameters added
//check group description for URL
//fixed css bug
//added twitch and steam social profiles
//added new rewrite parameter when registering cpt
//bug fix ajax pagination
//bug fix category filter
//changed filter code to allow for non-latin chars as the filter identifier
//order code improvement
//isotope filter improved
//new social network fields
//improved responsive css
//fixed ajax pagination issue
//started fixing url bug
//added second taxonomy
//Visual Composer Bug Fix
//orderby bug fixed
//added isotope hide filter
//custom js field added to settings page
//search code improved
//added yelp to social network links
//hidden display parameters display='hovertitle,hovertitleup'
//filter.js code improvement
//fixed pager thumbnails bug 
//auto complete search
//bug fix for shortcode generator preview (order by menu_order)
//search form category dropdown improvements
//link css option (to help lightbox integration)
//fontawesome version updated
//css improvements for filter menu
//new entry url option - personal url (defaults to inactive)
//fixed table layout bug (Name displaying twice)
//pager code improvement
//better search input sanitazing
//option to display groups
//redirect option to fix breadcrumb issue
//translation improvements
//added page template options
//filter nav fix for pager layout
//search fixes
//small fix for search terms with quotes
//Added option for social nofollow links
//New link option - link to full image (works good with lightbox plugins)


// Localization
add_action('init', 'tshowcase_lang_init');
function tshowcase_lang_init() {
  $path = dirname(plugin_basename( __FILE__ )) . '/lang/';
  $loaded = load_plugin_textdomain( 'tshowcase', false, $path);
} 

/* Automatic Updates Stuff */
add_filter('envato_customer_token','tshowcase_envato_customer_token');
function tshowcase_envato_customer_token($token) {

    $options = get_option( 'tshowcase-settings' );
    $token = $options['tshowcase_envato_token'];

    return $token;
}

//update code
//require_once(dirname(__FILE__) . "/class.wp-auto-plugin-update.php");

// ordering code
require_once dirname(__FILE__) . '/ordering-code.php';

//include advanced settings
require_once dirname( __FILE__ ) . '/advanced-options.php';
//util functions
require_once dirname( __FILE__ ) . '/utils.php';
//shortcode generator functions
require_once dirname( __FILE__ ) . '/shortcode-generator.php';
//single page settings and functions
require_once dirname( __FILE__ ) . '/single-page-build.php';
//default settings page
require_once dirname( __FILE__ ) . '/settings-page.php';

// search widget code
require_once dirname(__FILE__) . '/search-widget.php';

//count for multiple pager layouts in same page
$tshowcase_pager_count = 0;
$tshowcase_id_count = 0;

//Adding the necessary actions to initiate the plugin
add_action('init', 'register_cpt_tshowcase' );
add_action('admin_init', 'register_tshowcase_settings' );
add_action('admin_menu' , 'tshowcase_shortcode_page_add');
add_action('admin_menu' , 'tshowcase_admin_page');


//runs only when plugin is activated to flush permalinks
register_activation_hook(__FILE__, 'tshowcase_flush_rules');
function tshowcase_flush_rules(){
	//register post type
	register_cpt_tshowcase();
	//and flush the rules.
	flush_rewrite_rules();
}

//Add support for post-thumbnails in case theme does not
add_action('init' , 'tshowcase_add_thumbnails_for_cpt');

function tshowcase_add_thumbnails_for_cpt() {

    global $_wp_theme_features;

   if($_wp_theme_features['post-thumbnails']==1) {
		return;		
	  }	
	  
	  if(is_array($_wp_theme_features['post-thumbnails'][0]) && count($_wp_theme_features['post-thumbnails'][0]) >= 1) {
		array_push($_wp_theme_features['post-thumbnails'][0],'tshowcase');
		return;
		}
	if( empty($_wp_theme_features['post-thumbnails']) ) {
        $_wp_theme_features['post-thumbnails'] = array( array('tshowcase') );
		return;
	}
}


//Add New Thumbnail Size
$tshowcase_crop = false;
$tshowcase_options = get_option('tshowcase-settings');
if($tshowcase_options['tshowcase_thumb_crop']=="true") {
$tshowcase_crop = true;
}
add_image_size( 'tshowcase-thumb', $tshowcase_options['tshowcase_thumb_width'], $tshowcase_options['tshowcase_thumb_height'], $tshowcase_crop);


//Add Taxonomy Filter
add_action('restrict_manage_posts', 'tshowcase_filter_post_type_by_taxonomy');
function tshowcase_filter_post_type_by_taxonomy() {
  global $typenow;

  $post_type = 'tshowcase'; 
  $taxonomy  = 'tshowcase-categories';
  if ($typenow == $post_type) {
    $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
    $info_taxonomy = get_taxonomy($taxonomy);
    wp_dropdown_categories(array(
      'show_option_all' => __("Show All {$info_taxonomy->label}"),
      'taxonomy'        => $taxonomy,
      'name'            => $taxonomy,
      'orderby'         => 'name',
      'selected'        => $selected,
      'show_count'      => true,
      'hide_empty'      => true,
    ));
  };

  $options = get_option('tshowcase-settings');
  if(isset($options['tshowcase_second_tax'])){
    $taxonomy  = 'tshowcase-taxonomy';
    if ($typenow == $post_type) {
      $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
      $info_taxonomy = get_taxonomy($taxonomy);
      wp_dropdown_categories(array(
        'show_option_all' => __("Show All {$info_taxonomy->label}"),
        'taxonomy'        => $taxonomy,
        'name'            => $taxonomy,
        'orderby'         => 'name',
        'selected'        => $selected,
        'show_count'      => true,
        'hide_empty'      => true,
      ));
    };
  }

  if(isset($options['tshowcase_third_tax'])){
    $taxonomy  = 'tshowcase-ctaxonomy';
    if ($typenow == $post_type) {
      $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
      $info_taxonomy = get_taxonomy($taxonomy);
      wp_dropdown_categories(array(
        'show_option_all' => __("Show All {$info_taxonomy->label}"),
        'taxonomy'        => $taxonomy,
        'name'            => $taxonomy,
        'orderby'         => 'name',
        'selected'        => $selected,
        'show_count'      => true,
        'hide_empty'      => true,
      ));
    };
  }

  if(isset($options['tshowcase_fourth_tax'])){
    $taxonomy  = 'tshowcase-dtaxonomy';
    if ($typenow == $post_type) {
      $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
      $info_taxonomy = get_taxonomy($taxonomy);
      wp_dropdown_categories(array(
        'show_option_all' => __("Show All {$info_taxonomy->label}"),
        'taxonomy'        => $taxonomy,
        'name'            => $taxonomy,
        'orderby'         => 'name',
        'selected'        => $selected,
        'show_count'      => true,
        'hide_empty'      => true,
      ));
    };
  }
  
}

add_filter('parse_query', 'tshowcase_convert_id_to_term_in_query');
function tshowcase_convert_id_to_term_in_query($query) {
  global $pagenow;
  $post_type = 'tshowcase'; 
  $taxonomy  = 'tshowcase-categories'; 
  $q_vars    = &$query->query_vars;
  if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
    $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
    $q_vars[$taxonomy] = $term->slug;
  }


  if(isset($q_vars['tshowcase-taxonomy'])){
    $taxonomy  = 'tshowcase-taxonomy'; 
    if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
      $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
      $q_vars[$taxonomy] = $term->slug;
    }
  }

  if(isset($q_vars['tshowcase-ctaxonomy'])){
    $taxonomy  = 'tshowcase-ctaxonomy'; 
    if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
      $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
      $q_vars[$taxonomy] = $term->slug;
    }
  }
  if(isset($q_vars['tshowcase-dtaxonomy'])){
    $taxonomy  = 'tshowcase-dtaxonomy'; 
    if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
      $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
      $q_vars[$taxonomy] = $term->slug;
    }
  }

}


//Add new Image column 
function tshowcase_columns_head($defaults) {
	global $post;
    if (isset($post->post_type) && $post->post_type == 'tshowcase') {

  $options = get_option('tshowcase-settings');
  $defaults['tshowcase-categories'] = $options['tshowcase_name_category'];
  if(isset($options['tshowcase_second_tax'])){
    $defaults['tshowcase-taxonomy'] = $options['tshowcase_name_tax2'];
  }
  if(isset($options['tshowcase_third_tax'])){
    $defaults['tshowcase-ctaxonomy'] = $options['tshowcase_name_tax3'];
  }
  if(isset($options['tshowcase_fourth_tax'])){
    $defaults['tshowcase-dtaxonomy'] = $options['tshowcase_name_tax4'];
  }
	$defaults['featured_image'] = 'Image';
  $defaults['db_id'] = 'Database ID';


	//if we want the order to display
	//$defaults['order'] = '<a href="'.$_SERVER['PHP_SELF'].'?post_type=tshowcase&orderby=menu_order&order=ASC"><span>Order</span><span class="sorting-indicator"></span></a>';
	
  

  }
	return $defaults;
}




// SHOW THE FEATURED IMAGE in admin
function tshowcase_columns_content($column_name, $post_ID) {
	
	global $post;
    if ($post->post_type == 'tshowcase') {

      if($column_name == 'tshowcase-categories') {
      $term_list = wp_get_post_terms($post_ID, 'tshowcase-categories', array("fields" => "names"));
      foreach ( $term_list as $term ) {
        echo $term.'<br>';
        }
     }

    $options = get_option('tshowcase-settings');

    if($column_name == 'tshowcase-taxonomy' && isset($options['tshowcase_second_tax'])) {

      $term_list = wp_get_post_terms($post_ID, 'tshowcase-taxonomy', array("fields" => "names"));
      foreach ( $term_list as $term ) {
        echo $term.'<br>';
        }

     }

     if($column_name == 'tshowcase-ctaxonomy' && isset($options['tshowcase_third_tax'])) {

      $term_list = wp_get_post_terms($post_ID, 'tshowcase-ctaxonomy', array("fields" => "names"));
      foreach ( $term_list as $term ) {
        echo $term.'<br>';
        }

     }
     if($column_name == 'tshowcase-dtaxonomy' && isset($options['tshowcase_fourth_tax'])) {

      $term_list = wp_get_post_terms($post_ID, 'tshowcase-dtaxonomy', array("fields" => "names"));
      foreach ( $term_list as $term ) {
        echo $term.'<br>';
      }

     }

		if ($column_name == 'featured_image') {		
			echo get_the_post_thumbnail($post_ID, array(50,50));		
		}
		
		//if we want the order to display
		 if ($column_name == 'order') {		
			echo $post->menu_order;		
		}

     if ($column_name == 'db_id') {   
      echo $post->ID;   
    }
		 
     
		
	}
}

add_filter('manage_posts_columns', 'tshowcase_columns_head');
add_action('manage_posts_custom_column', 'tshowcase_columns_content', 10, 2);

// move featured image box to top

function tshowcase_image_box()
{
  remove_meta_box( 'postimagediv', 'tshowcase', 'side' );

  $options = get_option('tshowcase-settings');
  $name = $options['tshowcase_name_singular'];

  add_meta_box( 'postimagediv', $name. __( ' Image','tshowcase' ) , 'post_thumbnail_meta_box', 'tshowcase', 'side', 'default' );
}

add_action( 'do_meta_boxes', 'tshowcase_image_box' , 10, 2);

//register the custom post type for the team showcase
function register_cpt_tshowcase() {

	$options = get_option('tshowcase-settings');
	if(!is_array($options)) {
			tshowcase_defaults();
			$options = get_option('tshowcase-settings');
		}
		
	$name = $options['tshowcase_name_singular'];
	$nameplural = $options['tshowcase_name_plural'];
	$slug = $options['tshowcase_name_slug'];
	$singlepage = $options['tshowcase_single_page'];
	$exclude_from_search = (isset($options['tshowcase_exclude_from_search']) ? true : false);

    $labels = array( 
        'name' => _x( $nameplural, 'tshowcase' ),
        'singular_name' => _x( $name, 'tshowcase' ),
        'add_new' => _x( 'Add New '.$name, 'tshowcase' ),
        'add_new_item' => _x( 'Add New '.$name, 'tshowcase' ),
        'edit_item' => _x( 'Edit '.$name, 'tshowcase' ),
        'new_item' => _x( 'New '.$name, 'tshowcase' ),
        'view_item' => _x( 'View '.$name, 'tshowcase' ),
        'search_items' => _x( 'Search '.$nameplural, 'tshowcase' ),
        'not_found' => _x( 'No '.$nameplural.' found', 'tshowcase' ),
        'not_found_in_trash' => _x( 'No '.$nameplural.' found in Trash', 'tshowcase' ),
        'parent_item_colon' => _x( 'Parent '.$name.':', 'tshowcase' ),
        'menu_name' => _x( $nameplural, 'tshowcase' ),
    );
	
	$singletrue = true;
	if($singlepage=="false") { $singletrue = false; }
	

	
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,        
        'supports' => array( 'title', 'thumbnail', 'custom-fields', 'editor','page-attributes','author' ),
        'public' => $singletrue,
        'show_ui' => true,
        'show_in_menu' => true,       
        'show_in_nav_menus' => true,
        'publicly_queryable' => $singletrue,
        'exclude_from_search' => $exclude_from_search,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        //'show_in_rest' => true,
        //'taxonomies' => array('post_tag'),
		'menu_icon' => plugins_url( 'img/icon16.png', __FILE__ ),
		 //'menu_position' => 17,
		'rewrite' => array( 'slug' => $slug, 'with_front' => false )

    );

    register_post_type( 'tshowcase', $args );
}


//register custom category

// WP Menu Categories
add_action( 'init', 'tshowcase_build_taxonomies', 0 );

function tshowcase_build_taxonomies() {
	
	$options = get_option('tshowcase-settings');	
	$categories = $options['tshowcase_name_category'];
  $categories2 = isset($options['tshowcase_name_tax2']) ? $options['tshowcase_name_tax2'] : 'Groups 2' ;
  $categories3 = isset($options['tshowcase_name_tax3']) ? $options['tshowcase_name_tax3'] : 'Groups 3' ;
  $categories4 = isset($options['tshowcase_name_tax4']) ? $options['tshowcase_name_tax4'] : 'Groups 4' ;

	$capability = 'edit_posts';
	
  register_taxonomy( 'tshowcase-categories', 
    					'tshowcase', 
    					array( 
    						'hierarchical' => true, 
    						'label' => $categories, 
    						'query_var' => true, 
    						'rewrite' => true,
    						'capabilities' => array(
    							'manage_terms' => $capability,
								'edit_terms' => $capability,
								'delete_terms' => $capability,
								'assign_terms' => $capability
    							) 
    						));

  if(isset($options['tshowcase_second_tax'])) {

    register_taxonomy( 'tshowcase-taxonomy', 
              'tshowcase', 
              array( 
                'hierarchical' => true, 
                'label' => $categories2, 
                'query_var' => true, 
                'rewrite' => true,
                'capabilities' => array(
                'manage_terms' => $capability,
                'edit_terms' => $capability,
                'delete_terms' => $capability,
                'assign_terms' => $capability
                  ) 
                ));


  }
  if(isset($options['tshowcase_third_tax'])) {

    register_taxonomy( 'tshowcase-ctaxonomy', 
              'tshowcase', 
              array( 
                'hierarchical' => true, 
                'label' => $categories3, 
                'query_var' => true, 
                'rewrite' => true,
                'capabilities' => array(
                'manage_terms' => $capability,
                'edit_terms' => $capability,
                'delete_terms' => $capability,
                'assign_terms' => $capability
                  ) 
                ));


  }
  if(isset($options['tshowcase_fourth_tax'])) {

    register_taxonomy( 'tshowcase-dtaxonomy', 
              'tshowcase', 
              array( 
                'hierarchical' => true, 
                'label' => $categories4, 
                'query_var' => true, 
                'rewrite' => true,
                'capabilities' => array(
                'manage_terms' => $capability,
                'edit_terms' => $capability,
                'delete_terms' => $capability,
                'assign_terms' => $capability
                  ) 
                ));


  }


}



//change Title Info

function tshowcase_change_default_title( $title ){
     $screen = get_current_screen();
	 $options = get_option('tshowcase-settings');	
	$name = $options['tshowcase_name_singular'];
	$nameplural = $options['tshowcase_name_plural'];
 
     if  ( 'tshowcase' == $screen->post_type ) {
          $title = __('Insert ','tshowcase').$name.__(' Name Here','tshowcase');
     }
 
     return $title;
}

if($ts_change_default_title_en) {
add_filter( 'enter_title_here', 'tshowcase_change_default_title' );
}


function tshowcase_admin_order($wp_query) {

  if (is_post_type_archive( 'tshowcase' ) && is_admin() ) {   

		if (!isset($_GET['orderby'])) {
		  $wp_query->set('orderby', 'menu_order');
		  $wp_query->set('order', 'ASC');
	
  		}
  	}
}

//This will default the ordering admin to the 'menu_order' - will disable other ordering options
add_filter('pre_get_posts', 'tshowcase_admin_order');


// to dispay all entries in admin

function tshowcase_posts_per_page_admin($wp_query) {
  if (is_post_type_archive( 'tshowcase' ) && is_admin() ) {    
		

		  $wp_query->set( 'posts_per_page', '500' );
      //$wp_query->set('nopaging', 1);
	
  		
  	}
}

//This will the filter above to display all entries in the admin page
add_filter('pre_get_posts', 'tshowcase_posts_per_page_admin');


//This does the same thing as the above code, but in a different way
function tshowcase_no_nopaging_admin($query) {
 if (is_post_type_archive( 'tshowcase' ) && is_admin() ) {   

      $query->set('nopaging', 1);
      $query->set( 'posts_per_page', '-1' );
  
  }
}

//add_action('parse_query', 'tshowcase_no_nopaging_admin');


/**
 * Display the metaboxes
 */
 
function tshowcase_info_metabox() {


	global $post;	
	
	?>


  <table cellpadding='2'>

    <?php

    $fields = apply_filters('tshowcase_custom_fields',array());

    foreach ($fields as $key => $value) {
      if(isset($value['label'])){
        
        $metavalue = get_post_meta( $post->ID, $value['key'], true );
        $metavalue = $metavalue != false ? $metavalue : '';

        $input = '<input id="'.$value['key'].'" size="37" name="'.$value['key'].'" type="'.$value['type'].'" value="'.htmlentities($metavalue).'" />';
        if('textarea' == $value['type']){
          $input = '<textarea name="'.$value['key'].'" cols="35" rows="2" id="'.$value['key'].'">';
          $input .= $metavalue; 
          $input .= '</textarea>';
        }
        if('users' == $value['type']){

          if($metavalue=='' && !current_user_can('edit_others_posts') ) {
            $metavalue == get_current_user_id();
          }

          $input = '<select name="'.$value['key'].'" id="'.$value['key'].'">
              <option value="0">No User Associated</option>';
             
            $blogusers = get_users();
            if(is_array($blogusers)) {
              foreach ($blogusers as $user) { 
                $input .='<option value="'.$user->ID.'"'. selected( $metavalue, $user->ID, false ) .'>'.$user->display_name.'</option>'; 
              }
            }
            
            $input .='</select>';
        }

        echo '<tr>
          <td align="right">
            <label for="'.$value['key'].'">'.$value['label'].':</label>
          </td>
          <td>'.$input.'</td>
          <td>
            <p class="howto">'.$value['description'].'</p>
          </td>
        </tr>
        ';
      }
      
    }

    ?>

  </table>
  


  <?php

$ts_lastname = get_post_meta($post->ID, '_ts_lastname', true);

if($ts_lastname!=''){
  echo '<!-- Last Name Control: '.$ts_lastname.' -->';
}

  ?>
  <?php
}

/**
 * Process the custom metabox fields
 */
function tshowcase_save_info( $post_id ) {

	global $post;
	
	// Skip auto save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	
	if(isset($post)) {

		if ($post->post_type == 'tshowcase') {

			if( $_POST ) {

        $fields = apply_filters('tshowcase_custom_fields',array());
        foreach ($fields as $key => $value) {
          update_post_meta( $post->ID, $value['key'], $_POST[$value['key']] );
        }
			}
		}
	}
}

// Add action hooks. Without these we are lost
add_action( 'admin_init', 'tshowcase_add_info_metabox' );
add_action( 'save_post_tshowcase', 'tshowcase_save_info' );

/**
 * Add meta box for Aditional Information
 */
function tshowcase_add_info_metabox() {
	
	global $ts_labels;
	$title = $ts_labels['titles']['info'];
	
	add_meta_box( 'tshowcase-info-metabox', $title, 'tshowcase_info_metabox', 'tshowcase', 'normal', 'high' );
	
	
}

 
 
 
//Social Links Meta Box HTML 
function tshowcase_social_metabox() {
	global $post;	
	global $ts_labels;
  
  $ts_social_networks = apply_filters('tshowcase_social_networks',array());

	$helptext = $ts_labels['help']['social'];

	$tsemailico = htmlentities ( get_post_meta( $post->ID, '_tsemailico', true ) );
	
	?>
<p class="howto"><?php echo $helptext; ?></p>
<table width="100%" cellpadding="0" class="tshowcase-box-social">
        <?php foreach ($ts_social_networks as $social_key => $sn) {
         ?>
        <tr>
          <td align="right" style="min-width:150px;">	 
            <label for="ts<?php echo $sn[0]; ?>">
               <i class="<?php echo $sn[2] ?> fa-lg"></i>
              <?php echo __($sn[1],'tshowcase'); ?>:
            </label>
          </td>
          <td><input id="_ts<?php echo $sn[0]; ?>" size="37" name="_ts<?php echo $sn[0]; ?>" type="url" value="<?php if( get_post_meta( $post->ID, '_ts'.$sn[0], true ) ) { echo get_post_meta( $post->ID, '_ts'.$sn[0], true ); } ?>" />

          </td>
          <td>
            <?php if(isset($sn[3])) { ?>
                  <span class="howto"><?php echo __($sn[3],'tshowcase'); ?></span>
            <?php } ?>
          </td>
        </tr>

        <?php } ?>

        <tr>       
          <td align="right">
            <i class="fas fa-envelope fa-lg"></i> <?php echo __('Email','tshowcase'); ?>:
          </td>
          <td>
            <input id="_tsemailico" size="37" name="_tsemailico" type="text" value="<?php if( $tsemailico ) { echo $tsemailico; } ?>" />
          </td>
          <td>
            <span class="howto"><?php echo __('If the "mailto" option is enabled in the settings, it will work as an email link','tshowcase'); ?></span>
          </td>
        </tr>


</table>
<?php
}

/**
 * Process the custom metabox fields
 */
function tshowcase_save_social( $post_id ) {
	global $post;
	if(isset($post)) {
		if ($post->post_type == 'tshowcase') {

			if( $_POST && isset($_POST['_tsemailico']) ) {

        $ts_social_networks = apply_filters('tshowcase_social_networks',array());


        foreach ($ts_social_networks as $social_key => $sn) {
				  update_post_meta( $post->ID, '_ts'.$sn[0], $_POST['_ts'.$sn[0]] );
        }

				update_post_meta( $post->ID, '_tsemailico', $_POST['_tsemailico'] );

				
			}
		}
	}
}

// Add action hooks. Without these we are lost
add_action( 'admin_init', 'tshowcase_add_social_metabox' );
add_action( 'save_post_tshowcase', 'tshowcase_save_social' );

/**
 * Add meta box for social links
 */
function tshowcase_add_social_metabox() {
	
	global $ts_labels;
	$title = $ts_labels['titles']['social'];
	
	add_meta_box( 'tshowcase-social-metabox',$title, 'tshowcase_social_metabox', 'tshowcase', 'normal', 'high' );
}



//add options page
function tshowcase_admin_page() {
	
	   $menu_slug = 'edit.php?post_type=tshowcase';
	   $submenu_page_title = __('Settings','tshowcase');
    $submenu_title = __('Settings','tshowcase');
	   $capability = 'manage_options';
    $submenu_slug = 'tshowcase_settings';
    $submenu_function = 'tshowcase_settings_page';
    $defaultp = add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);
	
   }



   
 
  


//Shortcode

//Add shortcode functionality
add_shortcode('show-team', 'shortcode_tshowcase');
add_shortcode('show-team-search', 'shortcode_tshowcase_search');
add_filter('widget_text', 'do_shortcode');
add_filter( 'the_excerpt', 'do_shortcode');


$tshowcase_global_atts = array();

function shortcode_tshowcase( $atts ) {	

   global $tshowcase_id_count;
   global $tshowcase_global_atts;

   $dkey = 'PGRpdiBzdHlsZT0iZm9udC1zaXplOjJlbTsgYmFja2dyb3VuZDpyZWQ7IHBhZGRpbmc6MTBweDsgY29sb3I6I0ZGRjsiPkRFTU8gVkVSU0lPTjwvZGl2Pg==';


	if (!is_array($atts) || isset($atts['visual_composer_team_build']) ) { 


    $s_settings = get_option( 'tshowcase_shortcode', '' );
    if($s_settings!='') {
      $html = do_shortcode(stripslashes($s_settings));
      $html = '<div id="tshowcase_id_'.$tshowcase_id_count.'">'.$html.'</div>';  

    }

    else {

      $html = "<!-- Empty Team Showcase Container: No arguments or no saved shortcode -->";

    }


   }

	

  else {

  $orderby = (array_key_exists('orderby', $atts) ? $atts['orderby'] : "menu_order");
  $order = (array_key_exists('order', $atts) ? $atts['order'] : "");
  $limit = (array_key_exists('limit', $atts) ? $atts['limit'] : 0);
  $idsfilter = (array_key_exists('ids', $atts) ? $atts['ids'] : "0");
  $exclude = (array_key_exists('exclude', $atts) ? $atts['exclude'] : "0");
  $category = (array_key_exists('category', $atts) ? $atts['category'] : "0");
  $url =  (array_key_exists('url', $atts) ? $atts['url'] : "inactive");
  $layout = (array_key_exists('layout', $atts) ? $atts['layout'] : "grid");
  $style = (array_key_exists('style', $atts) ? $atts['style'] : "img-square,normal-float");
  $display = (array_key_exists('display', $atts) ? $atts['display'] : "photo,position,email"); 
  $img = (array_key_exists('img', $atts) ? $atts['img'] : ""); 
  $searchact = (array_key_exists('search', $atts) ? $atts['search'] : "true");
  $pagination = (array_key_exists('pagination', $atts) ? $atts['pagination'] : "false");
  $showid = (array_key_exists('showid', $atts) ? $atts['showid'] : "true");
  $relation = (array_key_exists('relation', $atts) ? $atts['relation'] : "OR");
  $taxonomy = (array_key_exists('taxonomy', $atts) ? $atts['taxonomy'] : "0");
  $ctaxonomy = (array_key_exists('ctaxonomy', $atts) ? $atts['ctaxonomy'] : "0");
  $dtaxonomy = (array_key_exists('dtaxonomy', $atts) ? $atts['dtaxonomy'] : "0");
  $metakey = (array_key_exists('meta_key', $atts) ? $atts['meta_key'] : "");
  $offset = (array_key_exists('offset', $atts) ? $atts['offset'] : "");
  $metaquery = (array_key_exists('meta_query', $atts) ? $atts['meta_query'] : "");
  $filtersource = (array_key_exists('filter-source', $atts) ? $atts['filter-source'] : "categories");
  $searchterm = (array_key_exists('search', $atts) ? $atts['search'] : "");
  $page = (array_key_exists('page', $atts) ? $atts['page'] : 1);
  
  //to get entries from other sites on multisite
  $site = (array_key_exists('site', $atts) ? $atts['site'] : false);

  if(isset($_GET['tpage'])) {
    $page = $_GET['tpage'];
  }
  if(isset($_GET['search'])) {
    $searchterm = $_GET['search'];
  }

  $atts['page'] = $page;
  $id = $tshowcase_id_count;

  $atts['div_id'] = $id;
  $atts['search'] = $searchterm;

  if(isset($_GET['tshowcase-categories'])){
    $atts['category'] = $_GET['tshowcase-categories'];
  }
  if(isset($_GET['tshowcase-taxonomy'])){
    $atts['taxonomy'] = $_GET['tshowcase-taxonomy'];
  }
  if(isset($_GET['tshowcase-ctaxonomy'])){
    $atts['ctaxonomy'] = $_GET['tshowcase-ctaxonomy'];
  }
  if(isset($_GET['tshowcase-dtaxonomy'])){
    $atts['dtaxonomy'] = $_GET['tshowcase-dtaxonomy'];
  }

  
  $tshowcase_global_atts[$id] = $atts;


  
  //if the pagination is set to load more, we remove the filter for the next entries
  if($pagination=='loadmore'){
      //$tshowcase_global_atts[$id]['display'] = str_replace('filter', '', $display);
  }


  $html = build_tshowcase($orderby,$limit,$idsfilter,$exclude,$category,$url,$layout,$style,$display,$pagination,$img,$searchact,$showid,$relation,$page,$id,$taxonomy,$ctaxonomy,$dtaxonomy,$metakey,$offset,$order,$atts,$metaquery,$filtersource,$searchterm,$site);

  $html = '<div id="tshowcase_id_'.$tshowcase_id_count.'">'.$html.'</div>';  

  }

 
 
  $tshowcase_id_count++;

  //$html = base64_decode($dkey).$html;

  return $html;
	
}

function shortcode_tshowcase_search( $atts ) {	

	if (!is_array($atts)) { $atts = array(); }

	$title = (array_key_exists('title', $atts) ? $atts['title'] : "");
	$taxonomies = (array_key_exists('filter', $atts) ? $atts['filter'] : "false");
  $taxonomies2 = (array_key_exists('taxonomy', $atts) ? $atts['taxonomy'] : "false");
  $taxonomies3 = (array_key_exists('ctaxonomy', $atts) ? $atts['ctaxonomy'] : "false");
  $taxonomies4 = (array_key_exists('dtaxonomy', $atts) ? $atts['dtaxonomy'] : "false");
	$custom_fields = (array_key_exists('fields', $atts) ? $atts['fields'] : "true");
	$url =  (array_key_exists('url', $atts) ? $atts['url'] : "");
  $includetax1 = (array_key_exists('include', $atts) ? $atts['include'] : "");
  $includetax2 = (array_key_exists('includetax', $atts) ? $atts['includetax'] : "");
	$includetax3 = (array_key_exists('includetax3', $atts) ? $atts['includetax3'] : "");
  $includetax4 = (array_key_exists('includetax4', $atts) ? $atts['includetax4'] : "");

	$html = tshowcase_search_form ($title,$taxonomies,$taxonomies2,$taxonomies3,$taxonomies4,$custom_fields,$url,$includetax1,$includetax2,$includetax3,$includetax4);
	return $html;	
	
}



/*
 *
 * /////////////////////////////
 * FUNCTION TO DISPLAY THE LIST
 * /////////////////////////////
 *
 */

function build_tshowcase($orderby="menu_order",$limit=-1,$idsfilter="0",$exclude="0",$category="0",$url="inactive",$layout="grid",$style="float-normal",$display="photo,name,position,email",$pagination="false",$imgwo="",$searchact="true",$show_id="true",$relation="OR",$page=1,$id='0',$taxonomy='0',$ctaxonomy='0',$dtaxonomy='0',$metakey='',$offset='',$sorder='',$atts=array(),$meta_query='',$filtersource='categories',$searchterm='', $site = false) {

  //if $site is set, change to the other blog id
  if($site){
    switch_to_blog($site);
  }


	tshowcase_add_global_css();
	add_action('wp_footer', 'tshowcase_custom_css',99);
	
	$html = '';
  $pagejs = '';
	$thumbsize = "tshowcase-thumb";
	global $post;
	global $ts_labels;
	
	$options = get_option('tshowcase-settings');

  $searchmeta = (isset($options['tshowcase_search_meta']) ? true : false);

  $linkcssclass = isset($options['tshowcase_linkcssclass']) ? 'class="'.$options['tshowcase_linkcssclass'].'"' : '';
	$linkcssclass .= isset($options['tshowcase_linkrel']) ? ' rel="'.$options['tshowcase_linkrel'].'"' : '';

	//order


	
	if($orderby=='none') {
		$orderby = 'menu_order';
		};
	
  $ascdesc = isset($sorder) && $sorder != '' ? $sorder : 'DESC';

  if(($orderby == 'title' || $orderby == 'menu_order' || $orderby == 'meta_value' || $orderby == 'meta_value_num' || $orderby == 'last_word_name'  ) && $sorder == '') {
  
    $ascdesc = 'ASC';
  
  } 


  //if random, we use seed to keep random order for user session
  if($orderby=='randsession') {
    if (!session_id()) {
      session_start();
    }
    $seed = $_SESSION['seed'];
    if (empty($seed)) {
      $seed = rand();
      $_SESSION['seed'] = $seed;
    }
    $orderby = 'RAND('.$seed.')';
  };
  
	
	//post per page
	$postsperpage = -1;
	$nopaging=true;
	if($limit >= 1) { 
  	$postsperpage = $limit;
  	$nopaging = false;
	}

	$paged = $page;

	if($pagination=="true") {
		$postsperpage = $limit;
		$nopaging = false;
		$paged = $page;

		if(isset($_GET['tpage'])){ $paged = $_GET['tpage'];}

    global $tshowcase_global_atts;

    if(isset($options['tshowcase_ajax_pagination'])) {
         tshowcase_ajax_pagination($tshowcase_global_atts);
    }
   

	}
	
	//display
	$display = explode(',',$display);
	$socialshow = false;
	if(in_array('social',$display)) {
		$socialshow = true;
	}
	
	//image size override
	$imgwidth = "";
	if($imgwo!=""){
		$imgwidth = explode(',',$imgwo);
		}
	
	//icons
	if(in_array('smallicons',$display)) {
	tshowcase_add_smallicons_css();	
	}

	
	//SEARCH RELATED CODE
	$search = "";
	$label = "";
	$catlabel = "";
  $taxlabel = '';
  $ctaxlabel = '';
  $dtaxlabel = '';

	if(isset($_GET['tshowcase-categories']) && $_GET['tshowcase-categories']!="" && $searchact == "true"){

			$category = esc_attr($_GET['tshowcase-categories']);

      $catarray = explode(',',$category);

      $catlabel = '';

      foreach ($catarray as $catdisplay) {
        $catObj = get_term_by('slug', $catdisplay, 'tshowcase-categories');
        $catlabel .= '  <i>'.$catObj->name.'</i>';
      }
			
	}

  
  if(isset($_GET['tshowcase-taxonomy']) && $_GET['tshowcase-taxonomy']!="" && $searchact == "true"){

      $taxonomy = esc_attr($_GET['tshowcase-taxonomy']);

      $taxarray = explode(',',$taxonomy);

      $taxlabel = ' &';

      foreach ($taxarray as $taxdisplay) {
        $taxObj = get_term_by('slug', $taxdisplay, 'tshowcase-taxonomy');
        $taxlabel .= '  <i>'.$taxObj->name.'</i>';
      }
      
  }

  if(isset($_GET['tshowcase-ctaxonomy']) && $_GET['tshowcase-ctaxonomy']!="" && $searchact == "true"){

      $ctaxonomy = esc_attr($_GET['tshowcase-ctaxonomy']);

      $taxarray = explode(',',$ctaxonomy);

      $ctaxlabel = ' &';

      foreach ($taxarray as $taxdisplay) {
        $taxObj = get_term_by('slug', $taxdisplay, 'tshowcase-ctaxonomy');
        $ctaxlabel .= '  <i>'.$taxObj->name.'</i>';
      }
      
  }
  if(isset($_GET['tshowcase-dtaxonomy']) && $_GET['tshowcase-dtaxonomy']!="" && $searchact == "true"){

      $dtaxonomy = esc_attr($_GET['tshowcase-dtaxonomy']);

      $taxarray = explode(',',$dtaxonomy);

      $dtaxlabel = ' &';

      foreach ($taxarray as $taxdisplay) {
        $taxObj = get_term_by('slug', $taxdisplay, 'tshowcase-dtaxonomy');
        $dtaxlabel .= '  <i>'.$taxObj->name.'</i>';
      }
      
  }

	if(isset($_GET['search'])){
	
    $search = sanitize_text_field($_GET['search']);
		$searchlabel = '<i>'.stripslashes($search).'</i>';
		if($_GET['tshowcase-categories'] != '' || $_GET['search'] != '') {
			$label = '<div class="tshowcase-search-label">'.$ts_labels['search']['results-for'].' '.$searchlabel.' '.$catlabel.$taxlabel.$ctaxlabel.'</div>';
		}
	}
	
	
	//If Custom Fields Search ON
	if( $search != '' && $searchmeta ) {

  	$args = array( 
      'post_type' => 'tshowcase',

  				   'orderby' => $orderby, 
  				   'order' => $ascdesc, 
  				   'posts_per_page'=> -1, 
  				   'nopaging'=> true,
  				   'meta_value' => sanitize_title_for_query($_GET['search']),
  				   'meta_compare' => "LIKE",
  				   
  				   );

    $taxi=0;

    if($category!='0' && $category!='') {

      $cat = explode(',', $category);

      if(isset($_GET['tshowcase-taxonomy']) && $searchact=='true') {
        $relation = 'AND';
      }

      $args['tax_query']['relation'] = $relation;
      
      foreach ($cat as $cattax) {
          
          $args['tax_query'][$taxi] = array(
              'taxonomy' => 'tshowcase-categories',
              'field'    => 'slug',
              'terms'    => $cattax,
            );

        $taxi++;
      }

    }


    if(isset($taxonomy) && $taxonomy!='0' && $taxonomy!='') {

      $tax = explode(',', $taxonomy);

      if(isset($_GET['tshowcase-taxonomy']) && $searchact=='true') {
        $relation = 'AND';
      }

      $args['tax_query']['relation'] = $relation;
      
      foreach ($tax as $ctax) {
          
          $args['tax_query'][$taxi] = array(
              'taxonomy' => 'tshowcase-taxonomy',
              'field'    => 'slug',
              'terms'    => $ctax,
            );

        $taxi++;
      }

    }


    if(isset($ctaxonomy) && $ctaxonomy!='0' && $ctaxonomy!='') {

      $ctax = explode(',', $ctaxonomy);

      if(isset($_GET['tshowcase-ctaxonomy']) && $searchact=='true') {
        $relation = 'AND';
      }

      $args['tax_query']['relation'] = $relation;
      
      foreach ($ctax as $tax) {
          
          $args['tax_query'][$taxi] = array(
              'taxonomy' => 'tshowcase-ctaxonomy',
              'field'    => 'slug',
              'terms'    => $tax,
            );

        $taxi++;
      }

    }
    if(isset($dtaxonomy) && $dtaxonomy!='0' && $dtaxonomy!='') {

      $dtax = explode(',', $dtaxonomy);

      if(isset($_GET['tshowcase-dtaxonomy']) && $searchact=='true') {
        $relation = 'AND';
      }

      $args['tax_query']['relation'] = $relation;
      
      foreach ($dtax as $tax) {
          
          $args['tax_query'][$taxi] = array(
              'taxonomy' => 'tshowcase-dtaxonomy',
              'field'    => 'slug',
              'terms'    => $tax,
            );

        $taxi++;
      }

    }


		$cf_query = new WP_Query( $args );
		wp_reset_postdata();

	}
  //end custom fields search


   $suppress_filters = true;

   //WPML constant
   if (defined('ICL_LANGUAGE_CODE')) {

   	$current_language = ICL_LANGUAGE_CODE;

  	if ( $current_language ) { $suppress_filters = false; }

   }

	

	$args = array( 
           'post_type' => 'tshowcase',
				   'orderby' => $orderby, 
				   'order' => $ascdesc, 
				   'posts_per_page'=> $postsperpage, 
				   'nopaging'=> $nopaging,
				   'paged' => $paged,
				   'suppress_filters' => $suppress_filters,
           'post_status' => 'publish'
				   );

  //offset
  if($offset!=''){
    $args['offset'] = intval($offset);
  }


  //To make the proper group query
  $i=0;
  if($category!='0' && $category!='') {

    $cat = explode(',', $category);
 
     if(isset($_GET['tshowcase-taxonomy']) && $searchact == 'true') {
        $relation = 'AND';
      }

     $args['tax_query']['relation'] = $relation;

   
    foreach ($cat as $cattax) {
        
        $args['tax_query'][$i] = array(
            'taxonomy' => 'tshowcase-categories',
            'field'    => 'slug',
            'terms'    => $cattax,
          );

      $i++;
    }

  }

  //To make the proper group query
  if(isset($taxonomy) && $taxonomy!='0' && $taxonomy!='') {


      $tax = explode(',',$taxonomy);

      if(isset($_GET['tshowcase-taxonomy']) && $searchact == 'true') {
        $relation =  'AND';
      }

      $args['tax_query']['relation'] = $relation;
      
      foreach ($tax as $ctax) {
          
          $args['tax_query'][$i] = array(
              'taxonomy' => 'tshowcase-taxonomy',
              'field'    => 'slug',
              'terms'    => $ctax,
            );

        $i++;
      }

  }

  //To make the proper group3 query
  if(isset($ctaxonomy) && $ctaxonomy!='0' && $ctaxonomy!='') {


      $ctax = explode(',',$ctaxonomy);

      if(isset($_GET['tshowcase-ctaxonomy']) && $searchact == 'true') {
        $relation =  'AND';
      }

      $args['tax_query']['relation'] = $relation;
      
      foreach ($ctax as $tax) {
          
          $args['tax_query'][$i] = array(
              'taxonomy' => 'tshowcase-ctaxonomy',
              'field'    => 'slug',
              'terms'    => $tax,
            );

        $i++;
      }

  }
  //To make the proper group4 query
  if(isset($dtaxonomy) && $dtaxonomy!='0' && $dtaxonomy!='') {


      $dtax = explode(',',$dtaxonomy);

      if(isset($_GET['tshowcase-dtaxonomy']) && $searchact == 'true') {
        $relation =  'AND';
      }

      $args['tax_query']['relation'] = $relation;
      
      foreach ($dtax as $tax) {
          
          $args['tax_query'][$i] = array(
              'taxonomy' => 'tshowcase-dtaxonomy',
              'field'    => 'slug',
              'terms'    => $tax,
            );

        $i++;
      }

  }

  //if there's a search shortcode parameter
  if($searchterm != '') {

    $args['s'] = $searchterm;
    //$args['posts_per_page'] = -1;
    //$args['nopaging'] = true;
    
  }


  //if there's a normal search we override it
	if($search != '' && $searchact=='true') {

		$args['s'] = $search;
    //$args['posts_per_page'] = -1;
    //$args['nopaging'] = true;
    
	}



  if((isset($_GET['tshowcase-categories']) || isset($_GET['tshowcase-taxonomy']))  && $searchact =='true') {

    if($pagination=='false'){
       $args['posts_per_page'] = -1;
       $args['nopaging'] = true;
    }

  }


	
	
	if($idsfilter != '0' && $idsfilter != '') {
		$postarray = explode(',', $idsfilter);

	 	if($postarray[0]!='') {
		$args['post__in'] = $postarray;
		$args['post_status'] = 'any';
    $args['order'] = 'post__in';
 		}

	} 

  if($exclude != '0' && $exclude != '') {
    $postarray = explode(',', $exclude);

    if($postarray[0]!='') {
    $args['post__not_in'] = $postarray;
    }
  } 

  //print_r($args);

  if($orderby=='meta_value' || $orderby=='meta_value_num') {
    $args['orderby'] = $orderby;
    $args['meta_key'] = $metakey;
  }

  if($orderby=='last_word_name') {

    $args['orderby'] = 'meta_value';
    $args['meta_key'] = '_ts_lastname';

  }

   //if random, we use seed to keep random order for user session
  if($orderby=='randsession') {
    if (!session_id()) {
      session_start();
    }
    $seed = $_SESSION['seed'];
    if (empty($seed)) {
      $seed = rand();
      $_SESSION['seed'] = $seed;
    }
    $args['orderby'] = 'RAND('.$seed.')';
  }

  if($meta_query!=''){
     $mq = explode(':',$meta_query);

     $args['meta_query'] = array(array(
      'key' => $mq[0],
      'value' => $mq[1],
      'compare' => isset($mq[2]) ? $mq[2] : 'LIKE'
      ));

  }
	
	$loop = new WP_Query( $args );

	

	//Merge If Search is ON
  //Currently not working well, it's disabled
	if($search!="" && $searchact == "true" && $searchmeta) {

    $loop->posts = array_unique(array_merge($cf_query->posts, $loop->posts),SORT_REGULAR);
    $loop->post_count = count( $loop->posts );

	}

	//If order by last name is ON
	if($orderby == 'lastname') {

		$lastname = array();
		foreach( $loop->posts as $key => $post ) {
			$exploded = explode( ' ', $post->post_title );
        //$remove = array("Dr.","Mr.");
        //$name = str_replace($remove,'',$post->post_title);
        $name = $post->post_title;
		    $word = end($exploded);
        // $word = end($exploded).$name;
        //to order by second last
        //$word = prev($exploded);
		    $lastname[$key] = $word;
        
		}
		array_multisort( $lastname, SORT_ASC|SORT_NATURAL|SORT_FLAG_CASE, $loop->posts );
   

	}


  $found_posts = $loop->found_posts;




  // to force random again - uncomment in case random is not working
  // if($orderby=='rand' ) {
  // shuffle( $loop->posts );
  // }

	//CHECK STYLE AND LAYOUT
	if($layout=='table') {
	
		$html .= tshowcase_build_table_layout($loop,$url,$display,$style,$category);
			
	} 
	
	if($layout=='pager' || $layout=='thumbnails' ) {
		
		global $tshowcase_pager_count;
		tshowcase_pager_layout($tshowcase_pager_count);

		
		$imgstyle = tshowcase_get_img_style($style);
		$txtstyle = tshowcase_get_txt_style($style);
		$pagerstyle = tshowcase_get_pager_style($style);
		$pagerboxstyle = tshowcase_get_pager_box_style($style);
		$infostyle = tshowcase_get_info_style($style);	
		$pagerfilteractive = '';

		
		$theme = tshowcase_get_themes($style,'pager');	
		tshowcase_add_theme($theme,'pager');
			
		$thumbshtml ="";
		$previewhtml ="";
		$ic = 0;
			
		$lshowcase_options = get_option('tshowcase-settings');
		$dwidth = $lshowcase_options['tshowcase_thumb_width'];	
		
		
		if(is_array($imgwidth)) {
				$thumbsize = $imgwidth;
				$dwidth = $thumbsize[0];
			}
		

		  //BUILD CATEGORY FILTERS
	
			if (in_array('filter',$display) || in_array('enhance-filter',$display) || in_array('isotope-filter',$display) || in_array('dropdown-filter',$display) ) {
	
  			//$html .= tshowcase_build_categories_filter($display,$category);
  			if(in_array('isotope-filter',$display)) { $pagerfilteractive .=" tshowcase-isotope"; }
        else { $pagerfilteractive .=" tshowcase-filter-active"; }
			
			}
				
			//Build Category filter end	





		while ( $loop->have_posts() ) : $loop->the_post(); 
		
		$title = the_title_attribute( 'echo=0' );	

      $id = get_the_ID();
      $cat = $pagerfilteractive.' ';
    
      $terms = get_the_terms( $id , 'tshowcase-categories' );
      if(is_array($terms)) {
        foreach ( $terms as $term ) {
        $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 

      //taxonomy
      if(isset($options['tshowcase_second_tax'])){
      $taxterms = get_the_terms( $id , 'tshowcase-taxonomy' );
      if(is_array($taxterms)) {
        foreach ( $taxterms as $term ) {
        $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
    }

      //ctaxonomy
      if(isset($options['tshowcase_third_tax'])){
      $ctaxterms = get_the_terms( $id , 'tshowcase-ctaxonomy' );
      if(is_array($ctaxterms)) {
        foreach ( $ctaxterms as $term ) {
          $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
    }

    //dtaxonomy
    if(isset($options['tshowcase_fourth_tax'])){
      $dtaxterms = get_the_terms( $id , 'tshowcase-dtaxonomy' );
      if(is_array($dtaxterms)) {
        foreach ( $dtaxterms as $term ) {
          $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
    }
		
			//If Photo is True
			if ( has_post_thumbnail() && in_array('photo',$display)) :     
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumbsize );
			$width = isset($image[1]) && $image[1]!= 0 ? $image[1] : $options['tshowcase_tpimg_width'];			
			$twidth = $options['tshowcase_tpimg_width'];
			$theight = $options['tshowcase_tpimg_height'];
						
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),array($twidth,$theight),true); 
      //$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full',true); 
     

			$thumbnail_id = get_post_thumbnail_id( $post->ID );
			$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
			if($alt!='') {
				$alt = 'alt="'.$alt.'"';
			}

    		
			$metadata = ''; //'itemscope itemtype="http://schema.org/Person"';
			$previewhtml .='<li><div '.$metadata.' class="tshowcase-box">';
			
			if($options['tshowcase_single_page']=="true" && $url =="active") {
				$previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.'><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></a></div>';
			} 

			if($options['tshowcase_single_page']=="true" && $url =="active_new") {
				$previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.' target="_blank"><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></a></div>';
			} 

			if($url =="active_custom") {
				
        $this_url = get_post_meta( $post->ID , '_tspersonal', true );
        if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }

				$previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><a href="'.$this_url.'" '.$linkcssclass.'><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></a></div>';
			
      } 

			if($url =="active_custom_new") {
				$this_url = get_post_meta( $post->ID , '_tspersonal', true );
        if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
				$previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><a href="'.$this_url.'" '.$linkcssclass.' target="_blank"><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></a></div>';
			} 

      if($url =="custom") {
        add_filter( 'post_type_link', 'tshowcase_custom_link_empty', 10, 2 );
        $urlperm = get_permalink($post->ID);
        if($urlperm!='') {
          $previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><a href="'.$urlperm.'" '.$linkcssclass.'><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></a></div>';
        } else {
          $previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></div>';
        }
      } 

			if($url =="active_user") {
				add_filter( 'post_type_link', 'tshowcase_author_link', 10, 2 );
				$previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.'><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></a></div>';
			} 

      if($url =="full_image") {
          $fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
          $previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><a href="'.$fullimage[0].'" '.$linkcssclass.'><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></a></div>';
        } 

      if($url == "lightbox"){
          tshowcase_add_lightbox_files();
          $previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><a href="'.get_permalink($post->ID).' .tscontent" data-featherlight-loading="Loading..." data-featherlight="ajax" '.$linkcssclass.'><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></a></div>';

      }

			if($url =="inactive") {
				$previewhtml .='<div class="tshowcase-box-photo '.$imgstyle.'"><img src="'.$image[0].'" width="'.$width.'" '.$alt.' /></div>';
			}
			
			$previewhtml .= "<div class='tshowcase-box-info ".$infostyle." ".$txtstyle."'>";
			

      $display_array = array();

			//if title is active
			if (in_array('name',$display)) : 
				
				if($options['tshowcase_single_page']=="true" && $url =="active") {
					$display_array['name'] ='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.'>'.$title.'</a></div>';
				} 	

				if($options['tshowcase_single_page']=="true" && $url =="active_new") {
					$display_array['name'] ='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.' target="_blank">'.$title.'</a></div>';
				} 	

				if($url =="active_custom") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$display_array['name'] ='<div class="tshowcase-box-title" itemprop="name"><a href="'.$this_url.'" '.$linkcssclass.'>'.$title.'</a></div>';
				} 	

				if($url =="active_custom_new") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$display_array['name'] ='<div class="tshowcase-box-title" itemprop="name"><a href="'.$this_url.'" '.$linkcssclass.' target="_blank">'.$title.'</a></div>';
				} 

        if($url =="custom") {
              add_filter( 'post_type_link', 'tshowcase_custom_link_empty', 10, 2 );
              $urlperm = get_permalink($post->ID);
              if($urlperm!='') {
                $display_array['name'] ='<div class="tshowcase-box-title" itemprop="name"><a href="'.$urlperm.'" '.$linkcssclass.'>'.$title.'</a></div>';
              } else {
                $display_array['name'] ='<div class="tshowcase-box-title" itemprop="name">'.$title.'</div>';
              }
            }   	

				if($url =="active_user") {
					add_filter( 'post_type_link', 'tshowcase_author_link', 10, 2 );
					$display_array['name'] ='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.'>'.$title.'</a></div>';
				} 

        if($url =="full_image") {
          $fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
          $display_array['name'] ='<div class="tshowcase-box-title" itemprop="name"><a href="'.$fullimage[0].'" '.$linkcssclass.'>'.$title.'</a></div>';
        } 

        if($url == "lightbox"){
          tshowcase_add_lightbox_files();
          $display_array['name'] ='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).' .tscontent" data-featherlight-loading="Loading..." data-featherlight="ajax" '.$linkcssclass.'>'.$title.'</a></div>';
        }


				if($url =="inactive") {
					$display_array['name'] = "<div class='tshowcase-box-title'>".$title."</div>";
				}


			endif;
			
      $display_array['social'] = '';
			//if Social is true
			if ($socialshow) : 		
			$display_array['social'] = "<div class='tshowcase-box-social'>".tshowcase_get_social(get_the_ID(),$socialshow)."</div>";
			endif;
			
			//if details exist		
			$display_array['details'] = "<div class='tshowcase-box-details'>".tshowcase_get_information(get_the_ID(),true,$display,false)."</div>";
			

      //Order 3 main blocks here

      $ts_display_order = apply_filters('tshowcase_display_order', array());

      
      
      foreach($ts_display_order as $disp) {
        $previewhtml .= $display_array[$disp];
      }


			
			$previewhtml .="</div></div></li>";
			
			
			
			
      
      $thumbshtml .= '<div class="tshowcase-pager-thumbnail '.$cat.' '.$pagerfilteractive.'"><div class="'.$imgstyle.'"><a data-slide-index="'.$ic.'" href=""><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.'/></a></div></div>';     
      //to display title below thumbnail:
      //$thumbshtml .= '<div class="tshowcase-pager-thumbnail '.$cat.' '.$pagerfilteractive.'"><div class="'.$imgstyle.'"><a data-slide-index="'.$ic.'" href=""><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.'/></a></div><div class="tshowcase_thumb_title">'.get_the_title($id).'</div></div>';     
      //to display title and job title below testimonial
      //$thumbshtml .= '<div class="tshowcase-pager-thumbnail '.$cat.' '.$pagerfilteractive.'"><div class="'.$imgstyle.'"><a data-slide-index="'.$ic.'" href=""><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.'/></a></div><div class="tshowcase_thumb_title">'.get_the_title($id).'</div><div class="tshowcase_thumb_job">'.get_post_meta( $id, '_tsposition', true ).'</div></div>';     




      $ic++;	 
			endif;
		
		 
		endwhile;
		
		$wrapclass = '';
		if($theme!="default") {  $wrapclass .= " tshowcase-pager-".$theme."-wrap";  }
		

    //If image above, left or right
    if(strpos($style,'thumbs-above') === false) {
    
		$html .= '<div class="tshowcase-pager-wrap '.$wrapclass.'" style="display:none;">';
		$html .= '<div class="'.$pagerboxstyle.'"><ul class="tshowcase-bxslider-'.$tshowcase_pager_count.'">';
		$html .= $previewhtml;
		$html .= '</ul></div>';
		$html .= '<div id="tshowcase-bx-pager-'.$tshowcase_pager_count.'" class="'.$pagerstyle.'">';
		$html .= $thumbshtml;
		$html .= '</div>';
		$html .= '<div class="ts-clear-both"></div></div>';
    
    }
    
    else {

    
    $html .= '<div class="tshowcase-pager-wrap '.$wrapclass.'" style="display:none;">';
    $html .= '<div id="tshowcase-bx-pager-'.$tshowcase_pager_count.'" class="'.$pagerstyle.'">';
    $html .= $thumbshtml;
    $html .= '</div>';
    $html .= '<div class="'.$pagerboxstyle.'"><ul class="tshowcase-bxslider-'.$tshowcase_pager_count.'">';
    $html .= $previewhtml;
    $html .= '</ul></div>';
    $html .= '<div class="ts-clear-both"></div></div>';
        
    }

		
		$tshowcase_pager_count++;

		


	}
	
	
	if($layout=='grid') {
		
	//theme	
	
	
	$imgstyle = tshowcase_get_img_style($style);
	$txtstyle = tshowcase_get_txt_style($style);
	$boxstyle = tshowcase_get_box_style($style);
	$innerboxstyle = tshowcase_get_innerbox_style($style);
	$infostyle = tshowcase_get_info_style($style);	
	$wrapstyle = tshowcase_get_wrap_style($style);
	$theme = tshowcase_get_themes($style,'grid');
	
	tshowcase_add_theme($theme,'grid');	

    //BUILD CATEGORY FILTERS

    if (in_array('filter',$display) || in_array('enhance-filter',$display) || in_array('isotope-filter',$display) || in_array('dropdown-filter',$display) ) {

      //$html .= tshowcase_build_categories_filter($display,$category);
      if(in_array('isotope-filter',$display)) { $boxstyle .=" tshowcase-isotope";}
      else { $boxstyle .=" tshowcase-filter-active"; }
    
    }
        
      //Build Category filter end 

    if(in_array('isotope-filter',$display)) {
      $wrapstyle .=' tshowcase-isotope-wrap';
    }
		
		$html .="<div class='".$wrapstyle."'>";	
		
		

		
		
		
		while ( $loop->have_posts() ) : $loop->the_post(); 
		
			$title = the_title_attribute( 'echo=0' );
			$id = get_the_ID();
			$cat = "";
		
			$terms = get_the_terms( $post->ID , 'tshowcase-categories' );
			if(is_array($terms)) {
				foreach ( $terms as $term ) {
				$cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
				}
			}	

      //taxonomy
      if(isset($options['tshowcase_second_tax'])){
      $taxterms = get_the_terms( $id , 'tshowcase-taxonomy' );
      if(is_array($taxterms)) {
        foreach ( $taxterms as $term ) {
        $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
    }

      //ctaxonomy
      if(isset($options['tshowcase_third_tax'])){
      $ctaxterms = get_the_terms( $id , 'tshowcase-ctaxonomy' );
      if(is_array($ctaxterms)) {
        foreach ( $ctaxterms as $term ) {
        $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
    }

     //dtaxonomy
      if(isset($options['tshowcase_fourth_tax'])){
      $dtaxterms = get_the_terms( $id , 'tshowcase-dtaxonomy' );
      if(is_array($dtaxterms)) {
        foreach ( $dtaxterms as $term ) {
          $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
    }

			$slug='';
			if($show_id == 'true') {
			$post_data = get_post($id, ARRAY_A);
    		$slug = $post_data['post_name'];
    		$slug = "id='".$slug."'";
    		}

			$metadata = ''; //"itemscope itemtype='http://schema.org/Person";
			$html .="<div ".$metadata." class='tshowcase-box ".$boxstyle." ".$cat."' ".$slug." >";	
			$html .="<div class='tshowcase-inner-box ".$innerboxstyle."'>";	
			
			$tshowcase_options = get_option('tshowcase-settings');
			$dwidth = $tshowcase_options['tshowcase_thumb_width'];	

      //display a field before photo
      //$html .= "<div class='tshowcase-single-position'>".get_post_meta( $id, '_tsposition', true )."</div>"; 
			
			//If Photo is True
			if ( has_post_thumbnail() && in_array('photo',$display)) {  
			

			if(is_array($imgwidth)) {
				$thumbsize = $imgwidth;
			}
			   
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumbsize ); 
			$thumbnail_id = get_post_thumbnail_id( $post->ID );
			$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
			if($alt!='') {
				$alt = 'alt="'.$alt.'"';
			}		
			
			$width = $image[1];	


			
			
				if($options['tshowcase_single_page']=="true" && $url =="active") {
					$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".get_permalink($post->ID)."' ".$linkcssclass."><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></a></div>";
				} 

				if($options['tshowcase_single_page']=="true" && $url =="active_new") {
					$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".get_permalink($post->ID)."' ".$linkcssclass." target='_blank'><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></a></div>";
				} 

				if($url =="active_custom") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".$this_url."' ".$linkcssclass."><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></a></div>";
				}

				if($url =="active_custom_new") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".$this_url."' ".$linkcssclass." target='_blank'><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></a></div>";
				} 

        if($url =="custom") {
              add_filter( 'post_type_link', 'tshowcase_custom_link_empty', 10, 2 );
              $urlperm = get_permalink($post->ID);
              if($urlperm!='') {
                $html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".$urlperm."' ".$linkcssclass."><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></a></div>";
              } else {
                $html .= "<div class='tshowcase-box-photo ".$imgstyle."'><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></div>";
              }
            }   


				if($url =="active_user") {
					add_filter( 'post_type_link', 'tshowcase_author_link', 10, 2 );
					$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".get_permalink($post->ID)."' ".$linkcssclass."><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></a></div>";
				} 
        if($url =="full_image") {
          $fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
          $html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".$fullimage[0]."' ".$linkcssclass."><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></a></div>";
        } 

        if($url == "lightbox"){
          tshowcase_add_lightbox_files();
          $html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".get_permalink($post->ID)." .tscontent' data-featherlight-loading='Loading...' data-featherlight='ajax' ".$linkcssclass."><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></a></div>";

        }

				if($url =="inactive") {
					$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><img src='".$image[0]."' width='".$width."' title='".$title."' ".$alt." /></div>";
				}
								
			} else {
				
				if ( !has_post_thumbnail() && in_array('photo',$display)) {  
						
						$alt='';

						if($options['tshowcase_single_page']=="true" && $url =="active") {
							$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".get_permalink($post->ID)."' ".$linkcssclass."><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></a></div>";
						} 

						if($options['tshowcase_single_page']=="true" && $url =="active_new") {
							$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".get_permalink($post->ID)."' ".$linkcssclass." target='_blank'><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></a></div>";
						} 

						if($url =="active_custom") {
							$this_url = get_post_meta( $post->ID , '_tspersonal', true );
              if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
							$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".$this_url."' ".$linkcssclass."><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></a></div>";
						}

						if($url =="active_custom_new") {
							$this_url = get_post_meta( $post->ID , '_tspersonal', true );
              if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
							$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".$this_url."' ".$linkcssclass." target='_blank'><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></a></div>";
						}

            if($url =="custom") {
              add_filter( 'post_type_link', 'tshowcase_custom_link_empty', 10, 2 );
              $urlperm = get_permalink($post->ID);
              if($urlperm!='') {
                $html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".$urlperm."' ".$linkcssclass."><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></a></div>";
              } else {
                $html .= "<div class='tshowcase-box-photo ".$imgstyle."'><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></div>";
              }
            }   

						if($url =="active_user") {
							add_filter( 'post_type_link', 'tshowcase_author_link', 10, 2 );
							$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".get_permalink($post->ID)."' ".$linkcssclass."><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></a></div>";
						} 

            if($url =="full_image") {
             
              $html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".plugins_url( '/img/default.png', __FILE__ )."' ".$linkcssclass."><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></a></div>";
            } 

            if($url == "lightbox"){
              tshowcase_add_lightbox_files();
              $html .= "<div class='tshowcase-box-photo ".$imgstyle."'><a href='".get_permalink($post->ID)." .tscontent' data-featherlight-loading='Loading...' data-featherlight='ajax'  ".$linkcssclass."><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></a></div>";

            }

						if($url =="inactive") {
							$html .= "<div class='tshowcase-box-photo ".$imgstyle."'><img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."' title='".$title."' ".$alt." /></div>";
						}
								
					}				
				
				}
			
				
      if(strpos($style,'img-above') === false) {

      //if(1 === false) {

              $html .= "<div class='tshowcase-box-info ".$txtstyle." '>";


      } else {

              $width = isset($width) ? $width : '500';
              $html .= "<div style='max-width:".$width."px' class='tshowcase-box-info ".$infostyle." ".$txtstyle." '>";


      } 
			
			
			//content array for ordering
			$display_array = array();
			
			$display_array['name']="";		
			//if title is active
			if (in_array('name',$display)) : 	
					


				if($options['tshowcase_single_page']=="true" && $url =="active") {
					$display_array['name'] .='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.'>'.$title.'</a></div>';
				} 	

				if($options['tshowcase_single_page']=="true" && $url =="active_new") {
					$display_array['name'] .='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.' target="_blank">'.$title.'</a></div>';
				} 	

				if($url =="active_custom") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$display_array['name'] .='<div class="tshowcase-box-title" itemprop="name"><a href="'.$this_url.'" '.$linkcssclass.'>'.$title.'</a></div>';
				} 	

				if($url =="active_custom_new") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$display_array['name'] .='<div class="tshowcase-box-title" itemprop="name"><a href="'.$this_url.'" '.$linkcssclass.' target="_blank">'.$title.'</a></div>';
				}

        if($url =="custom") {
          add_filter( 'post_type_link', 'tshowcase_custom_link_empty', 10, 2 );
          $urlperm = get_permalink($post->ID);
          if($urlperm!='') {
            $display_array['name'] .='<div class="tshowcase-box-title" itemprop="name"><a href="'.$urlperm.'" '.$linkcssclass.'>'.$title.'</a></div>';
          } else {
            $display_array['name'] .='<div class="tshowcase-box-title" itemprop="name">'.$title.'</div>';
          }
        }  	

				if($url =="active_user") {
					add_filter( 'post_type_link', 'tshowcase_author_link', 10, 2 );
					$display_array['name'] .='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.'>'.$title.'</a></div>';
				} 	

        if($url =="full_image") {
          $fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
          $display_array['name'] .='<div class="tshowcase-box-title" itemprop="name"><a href="'.$fullimage[0].'" '.$linkcssclass.'>'.$title.'</a></div>';
        } 

        if($url == "lightbox"){
              tshowcase_add_lightbox_files();
              $display_array['name'] .='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).' .tscontent" data-featherlight-loading="Loading..." data-featherlight="ajax" '.$linkcssclass.'>'.$title.'</a></div>';
        }

				if($url =="inactive") {
					$display_array['name'] .= "<div class='tshowcase-box-title'>".$title."</div>";
				}
			
			
			endif;
			
			$display_array['social'] = "";
			//if Social is true
			if ($socialshow) : 		
			$display_array['social'] = "<div class='tshowcase-box-social'>".tshowcase_get_social(get_the_ID(),$socialshow)."</div>";
			endif;
			
			$display_array['details'] = "";
			//if details exist		
			$display_array['details'] = "<div class='tshowcase-box-details'>".tshowcase_get_information(get_the_ID(),true,$display,false)."</div>";
			
			
			//ORDER INFORMATION
			$ts_display_order = apply_filters('tshowcase_display_order', array());

			
			
			foreach($ts_display_order as $disp) {
				$html .= $display_array[$disp];
			}
			//END ORDER
			
			
			$html .="</div>";
			$html .="</div>";
			$html .="</div>";
			
			
		endwhile; 
		$html .="</div>";


	}
	
	
	//HOVER THUMBS LAYOUT
	
	if($layout=='hover') {
		
	$imgstyle = tshowcase_get_img_style($style);
	$txtstyle = tshowcase_get_txt_style($style);
	$boxstyle = tshowcase_get_box_style($style);
	$infostyle = tshowcase_get_info_style($style);	
	$wrapstyle = tshowcase_get_wrap_style($style);	
	
	$theme = tshowcase_get_themes($style,'hover');	
	tshowcase_add_theme($theme,'hover');
	
	
	

  //BUILD CATEGORY FILTERS
  
    if (in_array('filter',$display) || in_array('enhance-filter',$display) || in_array('isotope-filter',$display) || in_array('dropdown-filter',$display)) {

      //$html .= tshowcase_build_categories_filter($display,$category);
      if(in_array('isotope-filter',$display)) { $boxstyle .=" tshowcase-isotope";}
      else { $boxstyle .=" tshowcase-filter-active"; }
    
    }

    
  //Build Category filter end 

  $wrapid = "tshowcase-hover-wrap";

  

  if($theme!="default") { $wrapstyle .= " tshowcase-".$theme."-wrap"; }
		
  if(in_array('isotope-filter',$display)) {
    $wrapstyle .=' tshowcase-isotope-wrap';
  }


	$html .="<div class='".$wrapstyle."' id='".$wrapid."'>";			
	
	$html .= "";
		
		
		
		$lshowcase_options = get_option('tshowcase-settings');
		$dwidth = $lshowcase_options['tshowcase_thumb_width'];	
		if(is_array($imgwidth)) {
				$thumbsize = $imgwidth;
				$dwidth = $thumbsize[0];
			}
			
		while ( $loop->have_posts() ) : $loop->the_post(); 

		
		$title = the_title_attribute( 'echo=0' );
		
		$id = get_the_ID();
		$cat = "";
		
		$terms = get_the_terms( $post->ID , 'tshowcase-categories' );
			if(is_array($terms)) {
				foreach ( $terms as $term ) {
				$cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
				}
			}
    //taxonomy
      if(isset($options['tshowcase_second_tax'])){
      $taxterms = get_the_terms( $id , 'tshowcase-taxonomy' );
      if(is_array($taxterms)) {
        foreach ( $taxterms as $term ) {
        $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
    }
      if(isset($options['tshowcase_third_tax'])){
      //ctaxonomy
      $ctaxterms = get_the_terms( $id , 'tshowcase-ctaxonomy' );
      if(is_array($ctaxterms)) {
        foreach ( $ctaxterms as $term ) {
        $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
    }

    if(isset($options['tshowcase_fourth_tax'])){
      //dtaxonomy
      $dtaxterms = get_the_terms( $id , 'tshowcase-dtaxonomy' );
      if(is_array($dtaxterms)) {
        foreach ( $dtaxterms as $term ) {
        $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
    }
		
    //$html .='<a href="'.get_permalink($post->ID).'">';
		
    $metadata = '';//'itemscope itemtype="http://schema.org/Person"';
		$html .='<div '.$metadata.' class="tshowcase-hover-box '.$boxstyle.' '.$cat.'"><div style="margin-left:auto; margin-right:auto; max-width:'.$dwidth.'px;">';
		
    //add title below image
      if(in_array('hovertitleup',$display)) {
      $html .= "<div class='tshowcase-box-title'>".$title."</div>";          
      }

    

    $html .='<span class="'.$imgstyle.'">';
                        
			if ( has_post_thumbnail()) :
			     
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $thumbsize ); 	
			$width = $image[1];	
			$thumbnail_id = get_post_thumbnail_id( $post->ID );
			$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
			if($alt!='') {
				$alt = 'alt="'.$alt.'"';
			}		
			
			$html .= "<img src='".$image[0]."' width='".$width."' ".$alt."/>";

      //$html .= "<a href='".get_permalink($post->ID)."'><img src='".$image[0]."' width='".$width."' ".$alt."/></a>";

			
						
			endif;
			
			
			if ( !has_post_thumbnail()) {  
					
			$html .= "<img src='".plugins_url( '/img/default.png', __FILE__ )."' width='".$dwidth."'/>";
			
			}
			
						
			$html .='<span class="tshowcase-hover-info">';
            $html .= "<div class='tshowcase-box-info ".$txtstyle."'><div class='tshowcase-box-info-inner'>";
			
			//if title is active
			if (in_array('name',$display)) : 	
					
				if($options['tshowcase_single_page']=="true" && $url =="active") {
					$display_array['name']='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.'>'.$title.'</a></div>';
				} 	
				if($options['tshowcase_single_page']=="true" && $url =="active_new") {
					$display_array['name']='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.' target="_blank">'.$title.'</a></div>';
				} 
				if($url =="active_custom") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$display_array['name']='<div class="tshowcase-box-title" itemprop="name"><a href="'.$this_url.'" '.$linkcssclass.'>'.$title.'</a></div>';
				} 	
				if($url =="active_custom_new") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$display_array['name']='<div class="tshowcase-box-title" itemprop="name"><a href="'.$this_url.'" '.$linkcssclass.' target="_blank">'.$title.'</a></div>';
				} 

        if($url =="custom") {
          add_filter( 'post_type_link', 'tshowcase_custom_link_empty', 10, 2 );
          $urlperm = get_permalink($post->ID);
          if($urlperm!='') {
            $display_array['name']='<div class="tshowcase-box-title" itemprop="name"><a href="'.$urlperm.'" '.$linkcssclass.'>'.$title.'</a></div>';
          } else {
            $display_array['name']='<div class="tshowcase-box-title" itemprop="name">'.$title.'</div>';
          }
        } 

				if($url =="active_user") {
					add_filter( 'post_type_link', 'tshowcase_author_link', 10, 2 );
					$display_array['name']='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).'" '.$linkcssclass.'>'.$title.'</a></div>';
				} 

        if($url =="full_image") {
          $fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
          $display_array['name']='<div class="tshowcase-box-title" itemprop="name"><a href="'.$fullimage[0].'" '.$linkcssclass.'>'.$title.'</a></div>';
        } 

        if($url == "lightbox"){
              tshowcase_add_lightbox_files();
              $display_array['name']='<div class="tshowcase-box-title" itemprop="name"><a href="'.get_permalink($post->ID).' .tscontent" data-featherlight-loading="Loading..." data-featherlight="ajax" '.$linkcssclass.'>'.$title.'</a></div>';
        }

				if($url =="inactive") {
					$display_array['name'] = "<div class='tshowcase-box-title'>".$title."</div>";
				}
			
			
			endif;
			
			//if Social is true
			if ($socialshow) : 		
			$display_array['social'] = "<div class='tshowcase-box-social'>".tshowcase_get_social(get_the_ID(),$socialshow)."</div>";
			endif;
			
			//if details exist		
			$display_array['details'] = "<div class='tshowcase-box-details'>".tshowcase_get_information(get_the_ID(),true,$display,false)."</div>";
			
      //ORDER INFORMATION
      $ts_display_order = apply_filters('tshowcase_display_order', array());

      foreach($ts_display_order as $disp) {
        if(isset($display_array[$disp])) {
          $html .= $display_array[$disp];
        }
        
      }
      //END ORDER
			
			$html .="</div></div>";   
						 
      $html .='</span></span>';

     

      //add title below image
      if(in_array('hovertitle',$display)) {
      $html .= "<div class='tshowcase-box-title'>".$title."</div>";  
      //$html .= "<div class='tshowcase-box-title'><a href='".get_permalink($post->ID)."'>".$title."</a></div>";        
      }


      
      $html .= ' </div></div>';	

      //$html .='</a>';
			
		endwhile; 
		$html .="</div>";
		
	}
	
	
	
		
		// Restore original Post Data 
		wp_reset_postdata();
	

  $filter = '';
  if (in_array('filter',$display) || in_array('enhance-filter',$display) || in_array('isotope-filter',$display) || in_array('dropdown-filter',$display) ) {
    
    $filter .= tshowcase_build_categories_filter($display,$filtersource,$category,$taxonomy,$ctaxonomy,$dtaxonomy); 
  
  }


	$html = "<div class='tshowcase'>".$filter.$label.$html.$pagejs."</div>";

  if($pagination=="true" && !isset($_GET['search'])) {

       if(($limit > 0) && (intval($found_posts) > intval($limit))) {

          $html .= tshowcase_pagination($loop);

      }  

  }

  if($pagination=="loadmore") {

       if(($limit > 0) && (intval($found_posts) > intval($limit))) {

          global $tshowcase_global_atts;
          $html .= tshowcase_loadmore($loop,$tshowcase_global_atts);

      }  

  }

  if($site){
    restore_current_blog();
  }


	return $html;
}

//BUILDING TABLE LAYOUT

function tshowcase_build_table_layout($loop,$url,$display,$style,$category) {
		
	$theme = tshowcase_get_themes($style,'table');	
	tshowcase_add_theme($theme,'table');	
	
	$html = "";
	$options = get_option('tshowcase-settings');
	$imgstyle = tshowcase_get_img_style($style);
	$txtstyle = tshowcase_get_txt_style($style);
	$wrapstyle = tshowcase_get_wrap_style($style);

  $linkcssclass = isset($options['tshowcase_linkcssclass']) ? 'class="'.$options['tshowcase_linkcssclass'].'"' : '';
  $linkcssclass .= isset($options['tshowcase_linkrel']) ? ' rel="'.$options['tshowcase_linkrel'].'"' : '';


      if (in_array('filter',$display) || in_array('enhance-filter',$display) || in_array('isotope-filter',$display) || in_array('dropdown-filter',$display) ) {
  
        //$html .= tshowcase_build_categories_filter($display,$category);
        if(in_array('isotope-filter',$display)) { $txtstyle .=" tshowcase-isotope";}
        else { $txtstyle .=" tshowcase-filter-active"; }
      
      }


  $isot = '';
  if(in_array('isotope-filter',$display)) { $isot=" tshowcase-isotope-wrap";}


	
	$html .= "<div class='ts-responsive-wrap'><table class='tshowcase-box-table ".$wrapstyle.$isot."'>";

  $fields = apply_filters('tshowcase_custom_fields',array());
  $ts_content_order = apply_filters('tshowcase_table_content_order', array());

  $header_array = array();

  if(in_array('table-header',$display)) {

    $html .= '<thead><tr>';

      if(in_array('photo',$display)){
        $html .= '<th>'.__('Photo','tshowcase').'</th>';
      }
      if(in_array('name',$display)){
        $header_array['title'] = '<th>'.__('Name','tshowcase').'</th>';
      }
      if(in_array('groups',$display)){
        $header_array['groups'] = '<th>'.$options['tshowcase_name_category'].'</th>';
      }
      if(in_array('taxonomy',$display) && isset($options['tshowcase_second_tax'])) {
        $header_array['taxonomy'] = '<th>'.$options['tshowcase_name_tax2'].'</th>';
      }

      if(in_array('ctaxonomy',$display) && isset($options['tshowcase_third_tax'])) {
        $header_array['ctaxonomy'] = '<th>'.$options['tshowcase_name_tax3'].'</th>';
      }

      if(in_array('dtaxonomy',$display) && isset($options['tshowcase_fourth_tax'])) {
        $header_array['dtaxonomy'] = '<th>'.$options['tshowcase_name_tax4'].'</th>';
      }

      if(in_array('social',$display)){
        $header_array['social']= '<th>'.__('Links','tsho').'</th>';
      }

      foreach ($fields as $key => $value) {

        if(in_array($key,$display)){

          if(!isset($value['hide'])){

            $header_array[$key]= '<th>'.$value['label'].'</th>';

          }
        }

      }


      foreach ($ts_content_order as $info) {
        if(isset($header_array[$info])) {
          $html.=$header_array[$info];
          unset($header_array[$info]);
        }
      }
      
      //the remaining itens go at the end
      foreach ($header_array as $key => $value) {
        $html.=$value;
      }


    $html .= '</tr></thead>';

  }

  
	$html .='<tbody>';
	while ( $loop->have_posts() ) : $loop->the_post(); 
	$title = the_title_attribute( 'echo=0' );
	$id = get_the_ID();
	$smallicons = in_array('smallicons',$display);

  $cat = ' ';
  $terms = get_the_terms( $id , 'tshowcase-categories' );
      if(is_array($terms)) {
        foreach ( $terms as $term ) {
        $cat .= 'ts-'.$term->slug.' '.'ts-id-'.$term->term_id.' ';
        }
      } 
	
    $ts_small_icons = apply_filters('tshowcase_default_icons',array());	

		if($smallicons) {
		
    $icongroups = '<i class="'.$ts_small_icons['groups'].'"></i>';
    $icontax = '<i class="'.$ts_small_icons['taxonomy'].'"></i>';
    $iconctax = '<i class="'.$ts_small_icons['ctaxonomy'].'"></i>';
    $icondtax = '<i class="'.$ts_small_icons['dtaxonomy'].'"></i>';

		} else {
		
      $icongroups = '';
      $icontax = '';
      $iconctax = '';
      $icondtax = '';
		}
	
	
  // Image Code

  $metadata = ''; //"itemscope itemtype='http://schema.org/Person'"; 
	$html .= "<tr ".$metadata." class='".$txtstyle.$cat."'>";
	
	if(in_array('photo',$display)){
		$width = $options['tshowcase_timg_width'];
		$height = $options['tshowcase_timg_height'];
		
		$html .= '<td class="tshowcase-table-image"><div class="'.$imgstyle.'">';
		if ( has_post_thumbnail() ) {
		$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($id),array($width,$height));	
		$thumbnail_id = get_post_thumbnail_id( $id );
		$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
		if($alt!='') {
			$alt = 'alt="'.$alt.'"';
		}		
		
				if($options['tshowcase_single_page']=="true" && $url =="active") {
					$html .='<a href="'.get_permalink($id).'" '.$linkcssclass.'><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' /></a>';
				} 	
				if($options['tshowcase_single_page']=="true" && $url =="active_new") {
					$html .='<a href="'.get_permalink($id).'" '.$linkcssclass.' target="_blank"><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' /></a>';
				} 

				if($url =="active_custom") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$html .='<a href="'.$this_url.'" '.$linkcssclass.'><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' /></a>';
				} 	
				if($url =="active_custom_new") {
					$this_url = get_post_meta( $post->ID , '_tspersonal', true );
          if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($post->ID); }
					$html .='<a href="'.$this_url.'" '.$linkcssclass.' target="_blank"><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' /></a>';
				} 

        if($url =="custom") {
          add_filter( 'post_type_link', 'tshowcase_custom_link_empty', 10, 2 );
          $urlperm = get_permalink($id);
          if($urlperm!='') {
            $html .='<a href="'.$urlperm.'" '.$linkcssclass.'><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' /></a>';
          } else {
            $html .='<img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' />';
          }
        } 

				if($url =="active_user") {
					add_filter( 'post_type_link', 'tshowcase_author_link', 10, 2 );	
					$html .='<a href="'.get_permalink($id).'" '.$linkcssclass.'><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' /></a>';
				} 

        if($url =="full_image") {
          $fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
          $html .='<a href="'.$fullimage[0].'" '.$linkcssclass.'><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' /></a>';
        } 

        if($url=="lightbox"){
          tshowcase_add_lightbox_files();
          $html .='<a href="'.get_permalink($id).' .tscontent" data-featherlight-loading="Loading..." data-featherlight="ajax" '.$linkcssclass.'><img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' /></a>';

        }

				if($url =="inactive") {
					$html .= '<img src="'.$thumb[0].'" width="'.$thumb[1].'" '.$alt.' />';
				}
		}
		
		if ( !has_post_thumbnail()) {  
				
				if($options['tshowcase_single_page']=="true" && $url =="active") {
									
						$html .='<a href="'.get_permalink($id).'" '.$linkcssclass.'><img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" /></a>';
						} 

				if($options['tshowcase_single_page']=="true" && $url =="active_new") {
									
						$html .='<a href="'.get_permalink($id).'" '.$linkcssclass.' target="_blank"><img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" /></a>';
						} 

				if($url =="active_custom") {
              $this_url = get_post_meta( $id , '_tspersonal', true );
              if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($id); }
  						$html .='<a href="'.$this_url.'" '.$linkcssclass.'><img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" /></a>';
						} 

				if($url =="active_custom_new") {
					 $this_url = get_post_meta( $id , '_tspersonal', true );
            if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($id); }		
						$html .='<a href="'.$this_url.'" '.$linkcssclass.' target="_blank"><img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" /></a>';
						} 

        if($url =="custom") {
          add_filter( 'post_type_link', 'tshowcase_custom_link_empty', 10, 2 );
          $urlperm = get_permalink($id);
          if($urlperm!='') {
            $html .='<a href="'.$urlperm.'" '.$linkcssclass.'><img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" /></a>';
          } else {
            $html .='<img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" />';
          }
        } 

				if($url =="active_user") {
						add_filter( 'post_type_link', 'tshowcase_author_link', 10, 2 );			
						$html .='<a href="'.get_permalink($id).'" '.$linkcssclass.'><img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" /></a>';
						} 

        if($url =="full_image") {
            $html .='<a href="'.plugins_url( '/img/default.png', __FILE__ ).'"><img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" /></a>';

        } 

        if($url=="lightbox"){
          
          tshowcase_add_lightbox_files();
          $html .='<a href="'.get_permalink($id).' .tscontent" data-featherlight-loading="Loading..." data-featherlight="ajax" '.$linkcssclass.'><img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" /></a>';

        }

				if($url =="inactive") {
								
						$html .= '<img src="'.plugins_url( '/img/default.png', __FILE__ ).'" width="'.$width.'" />';
					
						}
								
					}
		
		
		$html .= '</div></td>';
	}
	

  //We start collecting the values in an array so we order them in the end

  $info_array = array();

  //Title/Name Code
	
	if(in_array('name',$display)){
		
				if($options['tshowcase_single_page']=="true" && $url =="active") {
					$info_array['title'] = '<td><a href="'.get_permalink($id).'" '.$linkcssclass.'>'.$title.'</a></td>';
				} 	
				else if($options['tshowcase_single_page']=="true" && $url =="active_new") {
					$info_array['title'] = '<td><a href="'.get_permalink($id).'" '.$linkcssclass.' target="_blank">'.$title.'</a></td>';
				} 	
				else if($url =="active_custom") {
					$this_url = get_post_meta( $id , '_tspersonal', true );
            if($this_url!='') { $this_url = $this_url; } else { $this_url = get_permalink($id); }   
					$info_array['title'] = '<td><a href="'.$this_url.'" '.$linkcssclass.'>'.$title.'</a></td>';
				} 

				else if($url =="active_custom_new") {
					$this_url = get_post_meta( $id , '_tspersonal', true );
          if($this_url!='') {  $this_url = $this_url; } else { $this_url = get_permalink($id); }   
					$info_array['title'] = '<td><a href="'.$this_url.'" '.$linkcssclass.' target="_blank">'.$title.'</a></td>';
				} 	 	

        else if($url =="custom") {
          add_filter( 'post_type_link', 'tshowcase_custom_link_empty', 10, 2 );
          $urlperm = get_permalink($id);
          if($urlperm!='') {
            $info_array['title'] = '<td><a href="'.$urlperm.'" '.$linkcssclass.'>'.$title.'</a></td>';
          } else {
            $info_array['title'] = '<td>'.$title.'</td>';
          }
        } 

				else if($url =="active_user") {
					add_filter( 'post_type_link', 'tshowcase_author_link', 10, 2 );	
					$info_array['title'] = '<td><a href="'.get_permalink($id).'" '.$linkcssclass.'>'.$title.'</a></td>';
				} 		

        else if($url =="lightbox") {
          $info_array['title'] = '<td><a href="'.get_permalink($id).' .tscontent" data-featherlight-loading="Loading..." data-featherlight="ajax" '.$linkcssclass.'>'.$title.'</a></td>';
        } 

				else if($url =="inactive" || $url == "full_image") {
					$info_array['title'] = "<td>".$title."</td>";
				}	
        else {
          $info_array['title'] = "<td>".$title."</td>";
        }
	
	}
	
  if(in_array('groups',$display)) {
 
    $tsgroups = '';
    $taxonomy = 'tshowcase-categories';
    $terms = wp_get_post_terms( $id, $taxonomy, array("fields" => "all","orderby"=>"slug") );  
    foreach ($terms as $term) {
      $tsgroups .= $term->name.', ';
    }
    $tsgroups = rtrim($tsgroups, ", ");

    $info_array['groups'] = "<td class='tshowcase-table-groups'>";
      if($tsgroups!="") {   $info_array['groups'] .= $icongroups.$tsgroups; }
    $info_array['groups'] .= "</td>";
  
  }

  if(in_array('taxonomy',$display) && isset($options['tshowcase_second_tax'])) {
 
    if(!isset($info_array['taxonomy'])){
      $info_array['taxonomy'] = '';
    }

    $tsgroups = '';
    $taxonomy = 'tshowcase-taxonomy';
    $terms = wp_get_post_terms( $id, $taxonomy, array("fields" => "all","orderby"=>"slug") );  

    if(is_array($terms)) {

       foreach ($terms as $term) {
        $tsgroups .= $term->name.', ';
        }
        $tsgroups = rtrim($tsgroups, ", ");

    }

   

    $info_array['taxonomy'] .= "<td class='tshowcase-table-groups'>";
      if($tsgroups!="") {   $info_array['taxonomy'] .= $icontax.$tsgroups; }
    $info_array['taxonomy'] .= "</td>";
  
  }

  if(in_array('ctaxonomy',$display) && isset($options['tshowcase_third_tax'])) {
 
    if(!isset($info_array['ctaxonomy'])){
      $info_array['ctaxonomy'] = '';
    }

    $tsgroups = '';
    $taxonomy = 'tshowcase-ctaxonomy';
    $terms = wp_get_post_terms( $id, $taxonomy, array("fields" => "all","orderby"=>"slug") );  

    if(is_array($terms)) {

       foreach ($terms as $term) {
        $tsgroups .= $term->name.', ';
        }
        $tsgroups = rtrim($tsgroups, ", ");

    }

   

    $info_array['ctaxonomy'] .= "<td class='tshowcase-table-groups'>";
      if($tsgroups!="") {   $info_array['ctaxonomy'] .= $iconctax.$tsgroups; }
    $info_array['ctaxonomy'] .= "</td>";
  
  }

  if(in_array('dtaxonomy',$display) && isset($options['tshowcase_fourth_tax'])) {
 
    if(!isset($info_array['dtaxonomy'])){
      $info_array['dtaxonomy'] = '';
    }

    $tsgroups = '';
    $taxonomy = 'tshowcase-dtaxonomy';
    $terms = wp_get_post_terms( $id, $taxonomy, array("fields" => "all","orderby"=>"slug") );  

    if(is_array($terms)) {

       foreach ($terms as $term) {
        $tsgroups .= $term->name.', ';
        }
        $tsgroups = rtrim($tsgroups, ", ");

    }

   

    $info_array['dtaxonomy'] .= "<td class='tshowcase-table-groups'>";
      if($tsgroups!="") {   $info_array['dtaxonomy'] .= $icondtax.$tsgroups; }
    $info_array['dtaxonomy'] .= "</td>";
  
  }


  //ADDITIONAL INFO FIELDS

    

    
    foreach ($fields as $key => $value) {

      if(in_array($key,$display)){

        if(!isset($value['hide'])){

          $value['icon'] = isset($value['icon']) ? '<i class="'.$value['icon'].'"></i>' : '';
          $metavalue = get_post_meta( $id, $value['key'], true );
          
          if($metavalue == false || $metavalue==''){
            $info_array[$key] = '<td></td>';
            continue;
          }
          

          if(isset($value['format']) && $value['format']=='email'){

            $tsemail = get_post_meta( $id, $value['key'], true );
            $mailto = isset($options['tshowcase_mailto']);
            if($mailto){ 
              $tsemail = tshowcase_mailto_filter($tsemail);
            } 
            //to avoid spam bots, we replace the @ with with html code
            $tsemail = str_replace("@", "&#64;", $tsemail);
            $thisval = $smallicons ? $value['icon'].' '.$tsemail : $tsemail;
              if(isset($value['container'])){
                $info_array[$key] = '<td>'.sprintf($value['container'],$thisval).'</td>';
              } else {
                $info_array[$key] = '<td><div class="tshowcase-single-'.$key.'">'.$thisval.'</div></td>';
              }

          }

          else if(isset($value['format']) && $value['format']=='tel'){
            $tstel = get_post_meta( $id, $value['key'], true );
            $tellink = isset($options['tshowcase_tellink']);
            if($tellink) {
              $tstel = tshowcase_tellink_filter($tstel);
            } 
            $thisval = $smallicons ? $value['icon'].' '.$tstel : $tstel;
            if(isset($value['container'])){
              $info_array[$key] = '<td>'.sprintf($value['container'],$thisval).'</td>';
            } else {
              $info_array[$key] = '<td><div class="tshowcase-single-'.$key.'">'.$thisval.'</td></div>';
            }
          }

          else if(isset($value['format']) && $value['format']=='url'){

            $url = get_post_meta( $id, $value['key'], true );

            if(isset($value['anchor'])){
              $anchor = get_post_meta( $id, $fields[$value['anchor']]['key'], true );

              if($anchor){
                $url = '<a href="'.$url.'" target="_blank">'.$anchor.'</a>';
              } else {
                $url = '<a href="'.$url.'" target="_blank">'.$url.'</a>';
              }
              
            }

            $thisval = $smallicons ? $value['icon'].' '.$url : $url;

            if(isset($value['container'])){
              $info_array[$key] = '<td>'.sprintf($value['container'],$thisval).'</td>';
            } else {
              $info_array[$key] = '<td><div class="tshowcase-single-'.$key.'">'.$thisval.'</td></div>';
            }

          }

          else {

              $thisval = $smallicons ? $value['icon'].' '.$metavalue : $metavalue;
              if(isset($value['container'])){
                $info_array[$key] = '<td>'.sprintf($value['container'],$thisval).'</td>';
              } else {
                $info_array[$key] = '<td><div class="tshowcase-single-'.$key.'">'.$thisval.'</td></div>';
              }
          }
        }

      }
    }



  //Social Icons
  if(in_array('social',$display)){
    $social = tshowcase_get_social($id,true);
    $info_array['social'] = "<td><div class='tshowcase-box-social'>".$social."</div></td>";
  }


  //ordering
  //first we check if there is an order chosen
    
  foreach ($ts_content_order as $info) {
    if(isset($info_array[$info])) {
    $html.=$info_array[$info];
    unset($info_array[$info]);
    }
  }
  
  //the remaining itens go at the end
  foreach ($info_array as $key => $value) {
    $html.=$value;
  }
	
	
	$html .= "</tr>";
	
	endwhile;
	
	$html .= "</tbody></table></div>";
	return $html; 
}


//CSS & JS FUNCTIONS FOR EACH LAYOUT/STYLE


/* NORMAL STYLES */

function tshowcase_add_theme($theme,$layout) {
	
			global $ts_theme_names;
			
			$thadd = $ts_theme_names[$layout][$theme];
								
			wp_deregister_style( $thadd['name']);
		    wp_register_style($thadd['name'], plugins_url($thadd['link'], __FILE__ ),array(),false,'all');
			wp_enqueue_style($thadd['name'] );			
			
}



function tshowcase_default_layout() {
				
			wp_deregister_style( 'tshowcase-normal-style' );
		    wp_register_style( 'tshowcase-normal-style', plugins_url( 'css/normal.css', __FILE__ ),array(),false,'all');					            
        wp_enqueue_style( 'tshowcase-normal-style' );			
			
}

/* files for Lightbox */
function tshowcase_add_lightbox_files(){
    wp_deregister_script( 'tshowcase-featherlight' );
    wp_register_script( 'tshowcase-featherlight', plugins_url( 'js/featherlight/featherlight.min.js', __FILE__ ),array('jquery'),false,true);
    wp_enqueue_script( 'tshowcase-featherlight' );

    wp_deregister_style( 'tshowcase-featherlight' );
    wp_register_style( 'tshowcase-featherlight', plugins_url( 'js/featherlight/featherlight.min.css', __FILE__ ),array(),false,'all');
    wp_enqueue_style( 'tshowcase-featherlight' );     
       
}

/*   JS for Slider */
function tshowcase_pager_layout($lshowcase_slider_count) {
				
			wp_deregister_script( 'tshowcase-bxslider' );
		    wp_register_script( 'tshowcase-bxslider', plugins_url( 'js/bxslider/jquery.bxslider.js', __FILE__ ),array('jquery'),false,false);
			wp_enqueue_script( 'tshowcase-bxslider' );			
			
			wp_deregister_script( 'tshowcase-bxslider-pager' );
		    wp_register_script( 'tshowcase-bxslider-pager', plugins_url( 'js/pager.js', __FILE__ ),array('jquery','tshowcase-bxslider'),false,false);
			wp_enqueue_script( 'tshowcase-bxslider-pager' );				
			
			
			$pagerarray = array( 'count' => $lshowcase_slider_count );
			wp_localize_script('tshowcase-bxslider-pager', 'tspagerparam', $pagerarray);

			//add_action( 'wp_print_footer_scripts', 'tshowcase_pager_code' );	
			
}


/* JS for ajax pagination */
add_action('wp_ajax_nopriv_tshowcase_shortcode_build', 'shortcode_tshowcase_ajax');
add_action('wp_ajax_tshowcase_shortcode_build', 'shortcode_tshowcase_ajax');


function shortcode_tshowcase_ajax($array) {

  //remove pagination, so it doesn't output
  $_POST['post']['pagination'] = 'false';

  //print_r($_POST);

  echo shortcode_tshowcase($_POST['post']);
  die();

}

function tshowcase_ajax_pagination($tshowcase_atts) {
              
      wp_deregister_script( 'tshowcase-ajax-pager' );
      wp_register_script( 'tshowcase-ajax-pager', plugins_url( 'js/ajax-pagination.js', __FILE__ ),array('jquery'),false,false);
      wp_enqueue_script( 'tshowcase-ajax-pager' );        
      
      wp_localize_script('tshowcase-ajax-pager', 'ts_atts', $tshowcase_atts);

      wp_localize_script( 'tshowcase-ajax-pager', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );


      //add_action( 'wp_print_footer_scripts', 'tshowcase_pager_code' );  
      
}

function tshowcase_ajax_loadmore($tshowcase_atts) {
              
      wp_deregister_script( 'tshowcase-ajax-loadmore' );
      wp_register_script( 'tshowcase-ajax-loadmore', plugins_url( 'js/ajax-loadmore.js', __FILE__ ),array('jquery'),false,false);
      wp_enqueue_script( 'tshowcase-ajax-loadmore' );        
      
      wp_localize_script('tshowcase-ajax-loadmore', 'ts_lm_atts', $tshowcase_atts);

      wp_localize_script( 'tshowcase-ajax-loadmore', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
      
}


/* JS For Filter */ 
function tshowcase_filter_code() {
	
	wp_deregister_script( 'tshowcase-filter' );
	wp_register_script( 'tshowcase-filter', plugins_url( '/js/filter.js', __FILE__ ),array('jquery','jquery-ui-core','jquery-effects-core'),false,false);
	wp_enqueue_script( 'tshowcase-filter' );
			
}

function tshowcase_dropdown_code() {
  
  wp_deregister_script( 'tshowcase-dropdown-filter' );
  wp_register_script( 'tshowcase-dropdown-filter', plugins_url( '/js/dropdown-filter.js', __FILE__ ),array('jquery','jquery-ui-core','jquery-effects-core'),false,false);
  wp_enqueue_script( 'tshowcase-dropdown-filter' );
      
}

function tshowcase_enhance_filter_code() {
	
	wp_deregister_script( 'tshowcase-enhance-filter' );
	wp_register_script( 'tshowcase-enhance-filter', plugins_url( '/js/filter-enhance.js', __FILE__ ),array('jquery','jquery-effects-core'),false,false);
	wp_enqueue_script( 'tshowcase-enhance-filter' );
			
}

/* JS for Isotope filter */
function tshowcase_isotope_filter_code() {

  wp_deregister_script( 'tshowcase-isotope' );
  wp_register_script( 'tshowcase-isotope', plugins_url( '/js/isotope.pkgd.min.js', __FILE__ ),array('jquery',),false,false);
  wp_enqueue_script( 'tshowcase-isotope' );

  wp_deregister_script( 'tshowcase-cells-isotope' );
  wp_register_script( 'tshowcase-cells-isotope', plugins_url( '/js/cells-by-row.js', __FILE__ ),array('jquery','tshowcase-isotope'),false,false);
  wp_enqueue_script( 'tshowcase-cells-isotope' );
  
  wp_deregister_script( 'tshowcase-isotope-filter' );
  wp_register_script( 'tshowcase-isotope-filter', plugins_url( '/js/filter-isotope.js', __FILE__ ),array('jquery','tshowcase-isotope'),false,false);
  wp_enqueue_script( 'tshowcase-isotope-filter' );


  wp_deregister_script( 'tshowcase-imgs-loaded' );
  wp_register_script( 'tshowcase-imgs-loaded', plugins_url( '/js/imagesloaded.pkgd.min.js', __FILE__ ),array('jquery','tshowcase-isotope'),false,false);
  wp_enqueue_script( 'tshowcase-imgs-loaded' );
  
      
}

//Not in use anymore but not deleted for future reference and customizations

function tshowcase_pager_code() {
	global $tshowcase_pager_count;
	$i = 0;
	?>
    <script type="text/javascript">
	jQuery.noConflict();
	
	<?php while ($i<$tshowcase_pager_count) { 
	
	?>
	
	jQuery(document).ready(function(){
    var tsslider = jQuery('.tshowcase-bxslider-<?php echo $i; ?>').bxSlider({
      pagerCustom: '#tshowcase-bx-pager-<?php echo $i; ?>',
	  controls:false,
	  mode:'fade'
    	});

    // //custom hover code
    // jQuery('#tshowcase-bx-pager-'+<?php echo $i; ?>+' a').hover(function() {
				// var idslide = $(this).attr('data-slide-index');
				// tsslider.goToSlide(idslide);
			 //  	});


	
	
	<?php 
	$i++;
	} ?>
	 </script>
    
    <?php
	
}


// Add script and styles to admin edit/add new screen
function tshowcase_add_admin_scripts( $hook ) {

    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'tshowcase' === $post->post_type ) {     
            tshowcase_add_global_css();
            tshowcase_add_smallicons_css();
        }
    }
}
add_action( 'admin_enqueue_scripts', 'tshowcase_add_admin_scripts', 10, 1 );


/* CSS enqueue functions */ 

function tshowcase_add_global_css() {
       		wp_deregister_style( 'tshowcase-global-style' );
		    wp_register_style( 'tshowcase-global-style', plugins_url( '/css/global.css', __FILE__ ),array(),false,'all');
			wp_enqueue_style( 'tshowcase-global-style' );	

    } 
	

function tshowcase_add_smallicons_css() {
      wp_deregister_style( 'tshowcase-smallicons' );
		  wp_register_style( 'tshowcase-smallicons', plugins_url( '/css/font-awesome/css/fontawesome-all.min.css', __FILE__ ),array(),false,'all');
			wp_enqueue_style( 'tshowcase-smallicons' );	
    } 


	
function tshowcase_get_image($id) {
$html = "";	
$options = get_option('tshowcase-settings');

if(isset($options['tshowcase_single_show_photo']) && has_post_thumbnail($id)) { 
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'tshowcase-thumb' ); 
    $alt = get_post_meta(get_post_thumbnail_id( $id ), '_wp_attachment_image_alt', true);
      if($alt!='') {
        $alt = 'alt="'.$alt.'"';
      }   
		$html .=   '<div><img itemprop="photo" '.$alt.' src="'.$image[0].'" width="'.$image[1].'" ></div>';
		//get_the_post_thumbnail($post->ID,'thumbnail');
		}
	return $html;	
	
}

function tshowcase_get_image_with_default_img($id) {

$html = ""; 
$options = get_option('tshowcase-settings');

if(isset($options['tshowcase_single_show_photo'])) {

if (has_post_thumbnail($id)) { 
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'tshowcase-thumb' ); 
    $html .=   '<div><img src="'.$image[0].'" width="'.$image[1].'" ></div>';
    //get_the_post_thumbnail($post->ID,'thumbnail');
    }

else {

  $image = plugins_url( '/img/default.png', __FILE__ );
  $width = isset($options['tshowcase_thumb_width']) ? $options['tshowcase_thumb_width'] : '200';
 
  $html .=   '<div><img src="'.$image.'" width="'.$width.'"></div>';

  }
}
  return $html; 
  
}

//Currently not available in this version - twitter feed
function tshowcase_get_twitter($id) {
	
	$options = get_option('tshowcase-settings');
	$tstwitter = get_post_meta( $id, '_tstwitter', true );
	$html ="";
	if(isset($options['tshowcase_single_show_twitter']) && ($tstwitter!="")) { 
	
	$title = "Latest Tweets";
	if(isset($options['tshowcase_twitter_title'])) {
		$title = $options['tshowcase_twitter_title'];
	}	
		
	$html .=   "<h3>".$title."</h3>";
	$html .= '';
	}
	return $html;
	
}






function tshowcase_latest_posts($id) {
		
	$options = get_option('tshowcase-settings');
	$html ="";
	

$tsuser = get_post_meta( $id, '_tsuser', true );
if(isset($options['tshowcase_single_show_posts'])) {
	
	if($tsuser!="0") {	
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'author' => $tsuser,
		'suppress_filters' => true
	);
		
	// The Query
	$tshowcase_posts_query = new WP_Query($args);	
	
	// The Loop
	if($tshowcase_posts_query->have_posts()) {
	
	$title = __('Latest Posts','tshowcase');
	if(isset($options['tshowcase_latest_title'])) {
		$title = $options['tshowcase_latest_title'];
	}	
		
	$html .=   "<h3>".$title."</h3>";
	$html .=   "<ul>";
	while ( $tshowcase_posts_query->have_posts() ) : $tshowcase_posts_query->the_post();
		$html .=   '<li><a href="'.get_permalink().'">' . get_the_title() . '</a></li>';
	endwhile;
	$html .=   "</ul>";
	}
	
	/* Restore original Post Data 
	 * NB: Because we are using new WP_Query we aren't stomping on the 
	 * original $wp_query and it does not need to be reset.
	*/
	wp_reset_postdata();
	}
}

return $html;
	
}



// register settings
function register_tshowcase_settings() {
	register_setting( 'tshowcase-plugin-settings', 'tshowcase-settings');
}

//register default values
register_activation_hook(__FILE__, 'tshowcase_defaults');


function tshowcase_defaults() {

	$tmp = get_option('tshowcase-settings');
	
	//check for settings version
    if(!is_array($tmp)) {

		delete_option('tshowcase-settings'); 
		
		$arr = array(	"tshowcase_name_singular" => "Member",
						"tshowcase_name_plural" => "Team",
						"tshowcase_name_slug" => "team",
            "tshowcase_name_slug" => "team",
            "tshowcase_loadmore_label" => "Load More",
            "tshowcase_search_label" => "Search",
            "tshowcase_all_label" => "All",
						"tshowcase_name_category" => "Groups",
            "tshowcase_name_tax2" => "Department",
						"tshowcase_thumb_width" => "160",
						"tshowcase_thumb_height" => "160",
						"tshowcase_thumb_crop" => "false",
						"tshowcase_single_page" => "true", 
						"tshowcase_single_page_style" => "vcard", 
            "tshowcase_structural_data" => "true",
						"tshowcase_single_show_posts" => "false",
						"tshowcase_single_social_icons" => "font",
            "tshowcase_nofollow" => "",
						"tshowcase_empty" => "settings added",
						"tshowcase_twitter_title" => "Latest Tweets", 
						"tshowcase_latest_title" => "Latest Posts",
						"tshowcase_single_show_photo" => "",
						"tshowcase_single_show_social" => "",
						"tshowcase_single_show_position" => "",
						"tshowcase_mailto" => "",
            "tshowcase_tellink" => "",
						"tshowcase_custom_css" => "",
            "tshowcase_custom_js" => "",
						"tshowcase_exclude_from_search" => "true",
            "tshowcase_ajax_pagination" => "true",
						"tshowcase_timg_width" => "50",
						"tshowcase_timg_height" => "50",
						"tshowcase_tpimg_width" => "50",
						"tshowcase_tpimg_height" => "50",					
							
		);
		
		update_option('tshowcase-settings', $arr);
	}
}


//New Icons
$tshowcase_wp_version =  floatval( get_bloginfo( 'version' ) );

if($tshowcase_wp_version >= 3.8) {
	add_action( 'admin_head', 'tshowcase_font_icon' );
}


function tshowcase_font_icon() {
?>

		<style> 
			#adminmenu #menu-posts-tshowcase div.wp-menu-image img { display: none;}
			#adminmenu #menu-posts-tshowcase div.wp-menu-image:before { content: "\f307"; }
		  #wpadminbar #wp-admin-bar-tshowcase-edit-member .ab-item:before {
    content: "\f336";
    top: 3px;
}
    </style>


<?php
}


//Open in page template
add_filter('single_template','tshowcase_single_template');

function tshowcase_single_template($template) {


    $query_object = get_queried_object();
    $page_template = get_post_meta( $query_object->ID, '_tshowcase_page_template', true );

   
    if($page_template!='' && $page_template !='default') { 

        $my_post_type = 'tshowcase';

        //default templates
        $default_templates    = array();
        $default_templates[]  = 'single-{$object->post_type}-{$object->post_name}.php';
        $default_templates[]  = 'single-{$object->post_type}.php';
        $default_templates[]  = 'single.php';

        // apply template to tshowcase pages.
        if ( $query_object->post_type == $my_post_type ) {
            // if the page_template isn't empty, set it as the default_template
            if ( !empty( $page_template ) ) {
                $default_templates = $page_template;
            }
        }

        // locate the template and return it
        $template = locate_template( $default_templates, false );

    }

    else {


          global $post;

          if( !locate_template('single-tshowcase.php') && $post->post_type == 'tshowcase' ) {

              $options = get_option('tshowcase-settings');

                //do we have a default template to choose for events?
                if( isset($options['tshowcase_single_page_template']) && $options['tshowcase_single_page_template'] == 'page' ){
                  $post_templates = array('page.php','index.php');
                }else{

                    $temp_array = isset($options['tshowcase_single_page_template']) ? $options['tshowcase_single_page_template'] : null;
                    $post_templates = array($temp_array);
                }
                if( !empty($post_templates) ){
                    $post_template = locate_template($post_templates,false);
                    if( !empty($post_template) ) $template = $post_template;
                }
              

          }



    }





	return $template;

}

//Build Category Filter
function tshowcase_build_categories_filter($display,$source,$category,$taxonomy,$ctaxonomy,$dtaxonomy) {

	global $ts_labels;
  $opts = get_option('tshowcase-settings');
	$html = '';

  $use_tax = explode(',', $source);

  if (in_array('filter',$display)) {

    tshowcase_filter_code();
    $html .= "<div class='ts-filter-nav'>";
  }
    
  if (in_array('enhance-filter',$display)) {
    tshowcase_enhance_filter_code();
    $html .= "<div class='ts-enhance-filter-nav'>";
  }

  if (in_array('isotope-filter',$display)) {
    tshowcase_isotope_filter_code();
    $html .= "<div class='ts-isotope-filter-nav'>";
  }

  if (in_array('dropdown-filter',$display)) {
    tshowcase_dropdown_code();
    $html .= "<div class='ts-dropdown-filter-nav'>";
  }

  foreach ($use_tax as $key => $tax) {

      $all = isset($opts['tshowcase_all_label']) ? $opts['tshowcase_all_label'] : __($ts_labels['filter']['all-entries-label'],'tshowcase');

        
      $includecat = array();
      $taxuse = 'tshowcase-'.$tax;
      if($category!="" && $category!="0") { 

         $cats = explode(',',$category);
         foreach ($cats as $cat) {
          $term = get_term_by('slug', $cat, $taxuse);
          if(is_object($term)){
            array_push($includecat,$term->term_id);
          }
          
         }

         $args = array(
          'include' => $includecat
          );

      }
      $args['orderby'] = 'slug';
      $args['order'] = 'ASC';
      $args['parent'] = 0;
      
      $terms = get_terms($taxuse,$args);

      if(is_wp_error($terms)){
        return;
      }

      if(count($use_tax) > 1){
          $thistax = get_taxonomy($taxuse);
          $all .= ' '.$thistax->labels->name;
      }


      if(!in_array('dropdown-filter',$display)) {

        $html .= "<ul class='tsfilter'>";
        $html .= "<li class='ts-all' data-filter='*'>".$all."</li>";

        

         $count = count($terms);
         if ( $count > 0 ){    
             foreach ( $terms as $term ) {


              //We check for children
              $childs = '';

              $children_args = array(
                  'orderby' => 'slug', 
                  'order' => 'ASC',
                  'child_of'  => $term->term_id); 

              $children = get_terms($taxuse,$children_args);
              $children_count = count($children);

              if($children_count) {

                $childs .= '<ul>';
                foreach ( $children as $cterm ) {
                  $childs .= "<li id='ts-id-".$cterm->term_id."' data-filter='.ts-id-".$cterm->term_id."'>".$cterm->name."</li>";
                }

                $childs .= '</ul>';

              }

            $html .= "<li id='ts-id-".$term->term_id."' data-filter='.ts-id-".$term->term_id."'>".$term->name.$childs."</li>";
            
            }    
         }
        $html .= "</ul>";

      }



      //if select dropdown
      if(in_array('dropdown-filter',$display)) {
        
        //$html = '';
        $html .= "<select id='tsdropdown-".$tax."' class='ts-dropdown-filter'>";
        $html .= "<option class='ts-all' value='ts-all' data-filter='*'>".$all."</li>";
        foreach ( $terms as $term ) {
          $html .="<option id='ts-id-".$term->term_id."' value='ts-id-".$term->term_id."'>".$term->name."</option>";
        }

        $html .= '</select>';
        //return $html;
      }

      
  }
     
	 $html .= '</div>';
			
			

		return $html;

}


function tshowcase_archive_redirect() {
  
    if (is_post_type_archive('tshowcase')) {

        $options = get_option('tshowcase-settings');


        if(isset($options['tshowcase_archive_url']) && $options['tshowcase_archive_url'] != '') {

          $url = $options['tshowcase_archive_url'];
          wp_redirect( $url, 301 ); exit;

        }        
    }
} 


// to redirect the archive page
add_action('template_redirect', 'tshowcase_archive_redirect');



//To change the text on 'Published On'
/*
add_filter( 'gettext', 'ts_filter_published_on', 10000, 2 );
function ts_filter_published_on( $trans, $text ) {

    if( 'Published on: <b>%1$s</b>' == $text ) {
        global $post;
        switch( $post->post_type ) {
            case 'tshowcase': 
                return 'Member Birthday: <strong>%1$s</strong>';
            break;
            default: 
                return $trans;
            break;
        }
    }
    return $trans;
}
*/


/* VISUAL COMPOSER INTEGRATION */


// VISUAL COMPOSER CLASS

class tshowcase_VCExtendAddonClass {
    function __construct() {

        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );

    }

    public function tshowcasetype_output( $settings, $value ) {
         return __("By 'Saving Changes' this will render the saved settings from the Shortcode Generator page.", 'tshowcase'); 
      }
 
    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( !defined('WPB_VC_VERSION') || !function_exists('vc_map')) {
            // Display notice that Visual Compser is required
            // add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }


    if(function_exists('vc_map')) {

      if(function_exists('vc_add_shortcode_param')) { 
        vc_add_shortcode_param( 'tshowcasetype', array($this,'tshowcasetype_output') );
      }
      
      
      //widget to display saved shortcode settings
      vc_map( array(
            "name" => __("Team Showcase", 'tshowcase'),
            "description" => __("Insert Team Showcase Layout", 'tshowcase'),
            "base" => "show-team",
            //"class" => "",
            //"front_enqueue_css" => plugins_url('js/visual_composer.css', __FILE__),
            //"front_enqueue_js" => plugins_url('js/visual_composer.js', __FILE__),
            "icon" => plugins_url('img/icon32.png', __FILE__),
            "category" => __('Content', 'js_composer'),
            "params" => array(
                array(
                  "description" => __("To use different settings you should build a unique shortcode and use it on a Text Block.", 'tshowcase'),
                  "type" => "tshowcasetype",
                  "param_name" => __("visual_composer_team_build",'tshowcase'),
                  "value" => 'true'
              )
            )
          ));
          //end vc_map

      //widget to display search form
      vc_map( array(
            "name" => __('Team Showcase Search','tshowcase'),
            "description" => __("Insert Team Search Form", 'tshowcase'),
            "base" => "show-team-search",
            "class" => "",
            //"front_enqueue_css" => plugins_url('includes/visual_composer.css', __FILE__),
            "front_enqueue_js" => plugins_url('includes/visual_composer.js', __FILE__),
            "icon" => plugins_url('images/icon32.png', __FILE__),
            "category" => __('Content', 'js_composer'),
            "params" => array(
                array(
                  "admin_label" => true,
                  "type" => "dropdown",
                  "holder" => "hidden",
                  "class" => "",
                  "heading" => __("Category Filter", 'tshowcase'),
                  "param_name" => "filter",
                  "value" => array(
                    'No' => 'false',
                    'Yes' => 'true',
                    ),
                  "description" => __("Display a category dropdown", 'tshowcase')
              ),

                 array(
                  "admin_label" => true,
                  "type" => "textfield",
                  "holder" => "hidden",
                  "class" => "",
                  "heading" => __("Results URL", 'lshowcase'),
                  "param_name" => "url",
                  "value" => '',
                  "description" => __("URL to open to process the layout with the results. The results page should have a team showcase shortcode.", 'tshowcase')
              ),

                


            ),
           
          ));



    }

        
    }
}
// Finally initialize code
new tshowcase_VCExtendAddonClass();


//to search only on title field
//add_filter( 'posts_search', 'tshowcase_search_by_title_only', 500, 2 );
function tshowcase_search_by_title_only( $search, &$wp_query )
{
    global $wpdb;

    $type = $wp_query->query_vars;

    if(isset($type['post_type']) && $type['post_type']=='tshowcase') {

      if ( empty( $search ) )
          return $search; // skip processing - no search term in query

      $q = $wp_query->query_vars;    
      $n = ! empty( $q['exact'] ) ? '' : '%';

      $search =
      $searchand = '';

      foreach ( (array) $q['search_terms'] as $term ) {
          $term = esc_sql( $wpdb->esc_like( $term ) );
          $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
          $searchand = ' AND ';
      }

      if ( ! empty( $search ) ) {
          $search = " AND ({$search}) ";
          if ( ! is_user_logged_in() )
              $search .= " AND ($wpdb->posts.post_password = '') ";
      }

      return $search;
    } 

    else {
    
      return $search;
    
    }
}


/* PAGE TEMPLATES APPLYED INDIVIDUALLY TO TEAM MEMBER ENTRIES */

function tshowcase_template_metabox() {
  add_meta_box(
    'tshowcase_template_metabox'
    , __( 'Page Template', 'tshowcase' )
    , 'tshowcase_metabox_markup'
    , 'tshowcase'
    , 'side'
    , 'core'
  );
}
add_action( 'add_meta_boxes', 'tshowcase_template_metabox' );


/* Markup to build Metabox */

function tshowcase_metabox_markup( $post ) {
    
    wp_nonce_field( basename(__FILE__), 'tshowcase_template_meta_nonce' );
    $current_template = get_post_meta( $post->ID, '_tshowcase_page_template', true);
    $template_options = get_page_templates();
    $box_label = '<label for="_tshowcase_page_template">'.__('Page Template','tshowcase').'</label>';
    $box_select = '<select name="_tshowcase_page_template">';
    $box_default_option = '<option value="default">'.__('Default','tshowcase').'</option>';
    $box_options = '';

    foreach (  $template_options as $name=>$file ) {
        if ( $current_template == $file ) {
            $box_options .= '<option value="' . $file . '" selected="selected">' . $name . '</option>';
        } else {
            $box_options .= '<option value="' . $file . '">' . $name . '</option>';
        }
    }

    echo $box_label;
    echo $box_select;
    echo $box_default_option;
    echo $box_options;
    echo '</select>';

}


/* Save the data */

function tshowcase_metabox_save( $post_id ) {

    $current_nonce = isset($_POST['tshowcase_template_meta_nonce']) ? $_POST['tshowcase_template_meta_nonce'] : '';
    $is_autosaving = wp_is_post_autosave( $post_id );
    $is_revision   = wp_is_post_revision( $post_id );
    $valid_nonce   = ( isset( $current_nonce ) && wp_verify_nonce( $current_nonce, basename( __FILE__ ) ) ) ? 'true' : 'false';


    if ( $is_autosaving || $is_revision || !$valid_nonce ) {
        return;
    }

    $cpt_page_template = isset($_POST['_tshowcase_page_template']) ? $_POST['_tshowcase_page_template'] : '';
    update_post_meta( $post_id, '_tshowcase_page_template', $cpt_page_template );

}
add_action( 'save_post_tshowcase', 'tshowcase_metabox_save' );




/* Shortcode to get a list of the team entries and associated users - useful to debug */

add_shortcode('show-team-users', 'tshowcase_user_matches');

function tshowcase_user_matches() {

       $html = '<ul>';

      //arguments for the team entries query
      $tsargs = array(
        'post_type' => 'tshowcase'
      );

      //perform the query
      $ts_query = new WP_Query( $tsargs );

      //loop them
      if ( $ts_query->have_posts() ) {

       while ( $ts_query->have_posts() ) : $ts_query->the_post();

         $user_id = get_post_meta( get_the_ID(), '_tsuser', true );

         if($user_id == '0') {
              
              $user_info = 'No User Associated';

         } else {

              $user_array = get_users( array( 'include' => array(intval($user_id)) ) );

              foreach ( $user_array as $user ) {
                $user_info = $user->display_name .' (User ID = '.$user->ID.')';
              }

         }

         $html .=   '<li><a href="'.get_permalink().'">' . get_the_title() . '</a> > '.$user_info. '</li>';
      
      endwhile;

        
      }
      /* Restore original Post Data */
      wp_reset_postdata();

      $html .= '</ul>';

      return $html;
}


function set_tshowcase_order($wp_query) {

    global $pagenow;
 
    // Get the post type from the query
    $post_type = isset($wp_query->query['post_type']) ? $wp_query->query['post_type'] : false;

    if ( is_admin() && is_post_type_archive( 'tshowcase' ) && isset($post_type) && $post_type == 'tshowcase' ) {

      if(!isset($_GET['orderby'])){
        // 'orderby' value can be any column name
        $wp_query->set('orderby', 'menu_order');
        // 'order' value can be ASC or DESC
        $wp_query->set('order', 'ASC');
      }
      
    }
  
}
add_filter('pre_get_posts', 'set_tshowcase_order');

add_shortcode('show-team-count', 'tshowcase_team_count');
function tshowcase_team_count() { $count = wp_count_posts('tshowcase'); return $count->publish; }


//Use a custom order, by custom meta field, for example
function set_tshowcase_custom_order($wp_query) {

    
    $post_type = isset($wp_query->query['post_type']) ? $wp_query->query['post_type'] : false;

    if ( $post_type == 'tshowcase' ) {

      // 'orderby' value can be any column name
      $wp_query->set('meta_key', '_tsposition');
      $wp_query->set('orderby', 'meta_value');
      $wp_query->set('order', 'DESC');
    }
  
}
//add_filter('pre_get_posts', 'set_tshowcase_custom_order',99);


/* Shortcode to get custom meta from current user */
add_shortcode('show-team-info', 'tshowcase_member_info');
function tshowcase_member_info($atts) {
      global $post;
      return get_post_meta( $post->ID, '_ts'.$atts['field'], true );
}




/* Hook to redirect single page to user page if associated */
/* Should include option to control this */

add_filter('author_link', 'tshowcase_force_author_link', 10, 2);
function tshowcase_force_author_link($link,$author_id) {

   $options = get_option('tshowcase-settings');
   if(isset($options['tshowcase_redirectuser'])){

      $args = array(
         'post_type' => 'tshowcase',
         'meta_key'   => '_tsuser',
          'meta_value' => $author_id,
          'posts_per_page' => 1
      );

      $the_query = get_posts($args);
      if(count($the_query==1)) {

        foreach ( $the_query as $post ) {
         $link = get_permalink($post->ID);
        }

      }

  }
  
  return $link;
}

function tshowcase_lastname_custom_field( $post_id ) {

  
  if ( wp_is_post_revision( $post_id ) )
    return;

  $post_title = get_the_title( $post_id );

  $pieces = explode(' ', $post_title);

  $last_word = array_pop($pieces);
  $ordered = $last_word.', '.str_replace($last_word, '', $post_title);

  update_post_meta($post_id, '_ts_lastname', $ordered); 

}
add_action( 'save_post_tshowcase', 'tshowcase_lastname_custom_field' );

//Add Divi Support
function tshowcase_divibuilder( $post_types ) {
    $post_types[] = 'tshowcase';     
    return $post_types;
}
add_filter( 'et_builder_post_types', 'tshowcase_divibuilder' );

/* Add Divi Custom Post Settings box */
function tshowcase_add_meta_boxes() {

  if(function_exists ('et_single_settings_meta_box')){
    add_meta_box('et_settings_meta_box', 
          __('Divi Custom Post Settings', 'Divi'), 
          'et_single_settings_meta_box', 
          'tshowcase', 
          'side', 
          'high'); 
  }
    
}
add_action('add_meta_boxes', 'tshowcase_add_meta_boxes');


/**
 * Register a custom menu page.
 */
add_action('admin_menu', 'tshowcase_register_individual_tshowcase_menu_page');
function tshowcase_register_individual_tshowcase_menu_page() {

  //if it's admin or user can edit other entries, do nothing
  if(current_user_can('edit_others_posts')) {
    return;
  }

  $options = get_option('tshowcase-settings');   
  $name = $options['tshowcase_name_singular'];
  $nameplural = $options['tshowcase_name_plural'];

  //check if option to enable profile edit limitation is enabled
  if(isset($options['tshowcase_one_entry_per_user']) && $options['tshowcase_one_entry_per_user'] == '1'){

    add_menu_page(
        'tshowcase_individual',
        $name.' '.__('Info','tshowcase'),
        'edit_posts',
        'tshowcase-edit-member',
        'tshowcase_custom_menu_link',
        'dashicons-id',
        6
    );

  }

}

add_action('init','tshowcase_custom_menu_link');
function tshowcase_custom_menu_link(){
  if(is_admin() && isset($_GET['page']) && $_GET['page'] == 'tshowcase-edit-member') {
    $url = get_admin_url().'edit.php?post_type=tshowcase&unique=1';
    wp_redirect( $url, 301 ); 
    exit;
  }
}

add_action('admin_bar_menu', 'tshowcase_add_toolbar_items',100);
function tshowcase_add_toolbar_items($admin_bar){

  //if it's admin or user can edit other entries, do nothing
  if(current_user_can('edit_others_posts')) {
    return;
  }

  $options = get_option('tshowcase-settings');   
  $name = $options['tshowcase_name_singular'];
  $nameplural = $options['tshowcase_name_plural'];

  //check if option to enable profile edit limitation is enabled
  if(isset($options['tshowcase_one_entry_per_user']) && $options['tshowcase_one_entry_per_user'] == '1'){

    $admin_bar->add_menu( array(
        'id'    => 'tshowcase-edit-member',
        'title' => $name.' '.__('Info','tshowcase'),
        'href'  => get_admin_url().'edit.php?post_type=tshowcase&unique=1',
        'meta'  => array(
            'title' => $nameplural,            
        ),
    ));

    global $submenu;
    unset($submenu['edit.php?post_type=CUSTOM_POST_TYPE'][10]);
    echo '
    <style type="text/css">
    #favorite-actions, .add-new-h2, .tablenav, a.page-title-action,
    #menu-posts-tshowcase a[href="post-new.php?post_type=tshowcase"],
    #wp-admin-bar-new-tshowcase,
    #menu-posts-tshowcase { display:none; }
    
    </style>';
  }
}


//Redirect to edit page if 'edit profile' platform is enabled
add_action('init', 'tshowcase_edit_profile_redirect',100);
function tshowcase_edit_profile_redirect(){

  //if it's admin or user can edit other entries, do nothing
  if(current_user_can('edit_others_posts') || !is_admin()) {
    return;
  }

  $options = get_option('tshowcase-settings');

  //redirect if user is trying to add new entry but already has one
  if(is_admin() && isset($options['tshowcase_one_entry_per_user']) && $options['tshowcase_one_entry_per_user'] == '1' && isset($_GET['post_type']) && $_GET['post_type'] == 'tshowcase') {

    //check if there's already an entry for this user
    //$current_count = count_user_posts(get_current_user_id(),'tshowcase',false);
    
    $args = array(
      'numberposts'   => -1,
      'post_type'     => 'tshowcase',
      'post_status'   => array( 'publish', 'private', 'draft', 'pending' ),
      'author'        => get_current_user_id()
    );

    $current_count = count( get_posts( $args ) ); 


    if(basename($_SERVER['PHP_SELF']) == 'post-new.php'){

      if($current_count>0) {
          $args = array(
            'numberposts'   => 1,
            'post_type'     => 'tshowcase',
            'post_status'   => array( 'publish', 'private', 'draft', 'pending' ),
            'author'        => get_current_user_id()
          );
          //redirect to edit page
          $latest_cpt = get_posts($args);
          $post_edit = get_admin_url().'post.php?post='.$latest_cpt[0]->ID.'&action=edit';
          wp_redirect( $post_edit );
          exit;
        }  

    }

    //check if option to enable profile edit limitation is enabled
    if(isset($_GET['unique'])) {

        if($current_count==0){
          //if there isn't, redirect to create new page
          $post_new = get_admin_url().'post-new.php?post_type=tshowcase';
          wp_redirect( $post_new );
          exit;        
        }         

        
        if($current_count>0) {
          $args = array(
            'numberposts'   => 1,
            'post_type'     => 'tshowcase',
            'post_status'   => array( 'publish', 'private', 'draft', 'pending' ),
            'author'        => get_current_user_id()
          );
          //redirect to edit page
          $latest_cpt = get_posts($args);
          $post_edit = get_admin_url().'post.php?post='.$latest_cpt[0]->ID.'&action=edit';
          wp_redirect( $post_edit );
          exit;
        }  
       
    }


  }

  

}


//register the different settings for translation
add_action('init','tshowcase_init_register_for_translation');
function tshowcase_init_register_for_translation(){

  if ( function_exists('icl_object_id') ) {

    $domain = 'tshowcase';
    $options = get_option('tshowcase-settings');
    $translate = array(

      'latest_title' => $options['tshowcase_latest_title'],
      'name_singular' => $options['tshowcase_name_singular'],
      'name_plural' => $options['tshowcase_name_plural'],
      'all_label' => $options['tshowcase_all_label'],
      'search_label' => $options['tshowcase_search_label'],
      'load_more_label' => $options['tshowcase_loadmore_label'],
      'name_category' => $options['tshowcase_name_category'],
      'name_tax2' => $options['tshowcase_name_tax2'],
      'name_tax3' => $options['tshowcase_name_tax3'],
      'name_tax4' => $options['tshowcase_name_tax4'],

      );

    foreach ($translate as $title => $value) {
      do_action( 'wpml_register_single_string', $domain, 'Settings Field: '.$value, $value );
    }

  }

  

}


?>