<?php

remove_filter('the_content', 'wpautop');




/**
 * themesflat functions and definitions
 *
 * @package themesflat
 */
//remove_theme_mods();

define( 'THEMESFLAT_DIR', trailingslashit( get_template_directory() )) ;
define( 'THEMESFLAT_LINK', trailingslashit( get_template_directory_uri() ) );
if ( ! function_exists( 'themesflat_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

function themesflat_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on burger, use a find and replace
	 * to change 'finance' to the name of your theme in all the template files
	 */

	load_theme_textdomain( 'finance', THEMESFLAT_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Content width
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 1170; /* pixels */
	}	

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );	
	add_image_size( 'themesflat-recent-news-thumb', 106, 73, true );		
	add_image_size( 'themesflat-portfolio-thumb', 370, 245, true );	
	add_image_size( 'themesflat-blog', 770, 367, true );	
	add_image_size( 'themesflat-gallery-portfolio', 570, 320, true );
	add_image_size( 'themesflat-blog-shortcode', 370, 247, true );

	//Get thumbnail url
	function themesflat_thumbnail_url($size){
	    global $post;
	    if( $size== '' ) {
	        $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	        return esc_url($url);
	    } else {
	        $url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $size);
	        return esc_url($url[0]);
	    }
	}

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'finance' ),
		'footer' => esc_html__( 'Footer Menu', 'finance' ),
		'bottom' => esc_html__( 'Bottom Menu', 'finance' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'gallery', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	add_theme_support( 'custom-background', $args );

	// Custom stylesheet to the TinyMCE visual editor
	function themesflat_add_editor_styles() {
	    add_editor_style( 'css/editor-style.css' );
	}
	add_action( 'admin_init', 'themesflat_add_editor_styles' );	
}
endif; // themesflat_setup

add_action( 'after_setup_theme', 'themesflat_setup' );

function themesflat_wpfilesystem() {
	include_once (ABSPATH . '/wp-admin/includes/file.php');
	WP_Filesystem();
}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function themesflat_widgets_init() {
	//Sidebar for Blog
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'finance' ),
		'id'            => 'sidebar-blog',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'finance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	//Sidebar for Page
	register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'finance' ),
		'id'            => 'sidebar-page',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar Page.', 'finance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	

	//Header Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Header Sidebar', 'finance' ),
		'id'            => 'sidebar-header',
		'description'   => esc_html__( 'Add widgets here to appear in your Header Sidebar.', 'finance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	

	//Sidebar for Home
	register_sidebar( array(
		'name'          => esc_html__( 'Home Sidebar', 'finance' ),
		'id'            => 'sidebar-home',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar Home.', 'finance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	

	//Sidebar for before footer
	register_sidebar( array(
		'name'          => esc_html__( 'Before Footer Sidebar', 'finance' ),
		'id'            => 'sidebar-before-footer',
		'description'   => esc_html__( 'Add widgets here to appear in your Before Footer Sidebar.', 'finance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	

	//Sidebar footer
	register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget 1', 'finance' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Footer1.', 'finance' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget 2', 'finance' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Footer2.', 'finance' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget 3', 'finance' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Footer3.', 'finance' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget 4', 'finance' ),
        'id'            => 'footer-4',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Footer4.', 'finance' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );    

    register_sidebar( array(
        'name'          => esc_html__( 'Footer custom menu', 'finance' ),
        'id'            => 'fb-custom-menu',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Footer custom menu.', 'finance' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );    

    register_sidebar( array(
        'name'          => esc_html__( 'Services siderbar', 'finance' ),
        'id'            => 'services',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar Services', 'finance' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );    
	
	//Register the front page widgets	
	register_widget( 'Themesflat_Flicker' );
	register_widget( 'Themesflat_Recent_Post' );
	register_widget( 'Themesflat_Categories' );
		
}
add_action( 'widgets_init', 'themesflat_widgets_init' );

/**
 * Load the front page widgets.
 */
require THEMESFLAT_DIR . "widgets/themesflat_flickr.php";
require THEMESFLAT_DIR . "widgets/themesflat_recent_post.php";	
require THEMESFLAT_DIR . "widgets/themesflat_categories.php";
require THEMESFLAT_DIR . "inc/options/options.php";
require THEMESFLAT_DIR . "inc/options/options-definition.php";
require_once(THEMESFLAT_DIR .'inc/options/controls/dropdown-sidebars.php');
require_once(THEMESFLAT_DIR .'inc/options/controls/typography.php');
require_once(THEMESFLAT_DIR .'inc/options/controls/radio-images.php');
require THEMESFLAT_DIR . "inc/admin/sample-data.php";	

function themesflat_get_style($style) {
	return str_replace('italic', 'i', $style);
}

function themesflat_fonts_url() {
    $fonts_url = ''; 

    $body_font_name =  themesflat_get_json('body_font_name');
    $headings_font_name = themesflat_get_json('headings_font_name');
    $menu_font_name = themesflat_get_json('menu_font_name');
    $font_families = array(); 

    /*
	 * Translators: If there are characters in your language that are not supported
	 * by Poppins, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'finance' ) ) {
		if ( '' != $body_font_name ) {
	        $font_families[] = $body_font_name['family'].':'.themesflat_get_style($body_font_name['style']);
	    } else {
	    	$font_families[] = 'Poppins:300,400,500,600,700';
	    }    
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Poppins, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'finance' ) ) {
	    if ( '' != $headings_font_name ) {
	        $font_families[] = $headings_font_name['family'].':'.themesflat_get_style($headings_font_name['style']);
	    }

	    else {
	    	$font_families[] = 'Poppins:300,400,500,600,700';
	    }    
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Poppins, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'finance' ) ) {
	    if ( '' != $menu_font_name ) {
	        $font_families[] = $menu_font_name['family'].':'.themesflat_get_style($menu_font_name['style']);
	    } else {
	    	$font_families[] = 'Poppins:300,400,500,600,700';
	    }   

    }     
    
    $query_args = array(
        'family' => urlencode( implode( '|', $font_families ) ),        
    );

    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

    return esc_url_raw( $fonts_url );
}

function themesflat_scripts_styles() {
    wp_enqueue_style( 'themesflat-theme-slug-fonts', themesflat_fonts_url(), array(), null );
}

add_action( 'wp_enqueue_scripts', 'themesflat_scripts_styles' );

/**
 * Enqueue scripts and styles.
 */

function themesflat_scripts() {

	// Theme stylesheet.
	wp_enqueue_style( 'themesflat-main', THEMESFLAT_LINK . 'css/main.css' );
	wp_enqueue_style( 'themesflat-style', get_stylesheet_uri() );
	wp_enqueue_style( 'font-fontawesome', THEMESFLAT_LINK . 'css/font-awesome.css' );
	wp_enqueue_style( 'font-ionicons', THEMESFLAT_LINK . 'css/ionicons.min.css' );	
	wp_enqueue_style( 'flexslider', THEMESFLAT_LINK . 'css/flexslider.css' );
	
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'ie9', THEMESFLAT_LINK . 'css/ie.css');
	wp_style_add_data( 'ie9', 'conditional', 'lte IE 9' );

	wp_enqueue_style( 'animate', THEMESFLAT_LINK . 'css/animate.css' );	
	wp_enqueue_style( 'responsive', THEMESFLAT_LINK . 'css/responsive.css' );
	
	wp_enqueue_script( 'themesflat-flexslider', THEMESFLAT_LINK . 'js/jquery.flexslider-min.js', array(),'2.5.0', true );
	
	// Load the html5 shiv..	
	wp_enqueue_script( 'html5', THEMESFLAT_LINK . 'js/html5shiv.js', array('jquery'), '1.3.0' ,true);	
	wp_enqueue_script( 'respond', THEMESFLAT_LINK . 'js/respond.min.js', array(), '1.3.0',true);
	wp_enqueue_script( 'easing', THEMESFLAT_LINK . 'js/jquery.easing.js', array(),'1.3' ,true);
	wp_enqueue_script( 'waypoints', THEMESFLAT_LINK . 'js/jquery-waypoints.js', array(),'1.3' ,true);		
	wp_enqueue_script( 'match', THEMESFLAT_LINK . 'js/matchMedia.js', array(),'1.2',true);

	wp_enqueue_script( 'fitvids', THEMESFLAT_LINK . 'js/jquery.fitvids.js', array(),'1.1',true);
	wp_enqueue_script( 'popup', THEMESFLAT_LINK . 'js/jquery.magnific-popup.min.js', array(),'1.1',true);	
	wp_enqueue_script( 'carousel', THEMESFLAT_LINK . 'js/owl.carousel.js', array(),'1.1',true);
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply', array(),'2.0.4',true );
	}

	// Load the main js
	wp_enqueue_script( 'themesflat-main', THEMESFLAT_LINK . 'js/main.js', array(),'2.0.4',true);
}

add_action( 'wp_enqueue_scripts', 'themesflat_scripts' );
/**
 * Enqueue Bootstrap
 */
function themesflat_enqueue_bootstrap() {
	wp_enqueue_style( 'bootstrap', THEMESFLAT_LINK . 'css/bootstrap.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'themesflat_enqueue_bootstrap', 9 );

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses themesflat_header_style()
 */
function themesflat_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'themesflat_custom_header_args', array(
		'default-image'          => '',
		'width'                  => 1920,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'themesflat_header_style'
	) ) );
}
add_action( 'after_setup_theme', 'themesflat_custom_header_setup' );

if ( ! function_exists( 'themesflat_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see themesflat_custom_header_setup().
 */
function themesflat_header_style() {	
	
	if (themesflat_meta('enable_custom_header_style') == 1):
		$images = themesflat_decode(themesflat_meta( 'header_image'));
		$header_images = '.page-title { background-image: url('. wp_get_attachment_image_src($images[0],'flat-page-title')[0].');}';
	else:		
		if ( get_header_image() != "" ) {
			$header_images = '.page-title { background-image: url('. get_header_image().');}';	
		} else {
			$header_images = '.page-title { background-image: url('.THEMESFLAT_LINK.'images/page-title.jpg) ; }';
		}
	endif;
	wp_add_inline_style( 'themesflat-style', $header_images );
}

add_action( 'wp_enqueue_scripts', 'themesflat_header_style' );


endif; // themesflat_header_style

// Customizer additions.
require THEMESFLAT_DIR . 'inc/customizer.php';

// Revo Slider
require THEMESFLAT_DIR . 'inc/revo-slider.php';

// metabox-options
require THEMESFLAT_DIR . 'inc/metabox-options.php';

// Helpers
require THEMESFLAT_DIR . 'inc/helpers.php';
// Struct
require THEMESFLAT_DIR . 'inc/structure.php';

// Breadcrumbs additions.
require THEMESFLAT_DIR . 'inc/breadcrumb.php';

// Pagination additions.
require THEMESFLAT_DIR . 'inc/pagination.php';

// Custom template tags for this theme.
require THEMESFLAT_DIR . 'inc/template-tags.php';

// Style.
require THEMESFLAT_DIR . 'inc/styles.php';

// Required plugins
require_once THEMESFLAT_DIR . 'inc/plugins/class-tgm-plugin-activation.php';

// Plugin Activation
require_once THEMESFLAT_DIR . 'inc/plugins/plugins.php';

function CorrectDBTransfer(){
global $wpdb;    
$result = $wpdb->get_results( "UPDATE wp_options set option_value ='http://s27407.p20.sites.pressdns.com' WHERE option_value='http://wunderlich.dev.signature901.com'");
}
//CorrectDBTransfer();





