<?php
/**
 * Return the built-in header styles for this theme
 *
 * @return  array
 */
Class themesflat_options_helpers {
	public function recognize_control_class( $name ) {
        $segments = explode( '-', $name );
        $segments = array_map( 'ucfirst', $segments );
        
        return implode( '', $segments );
    }
}

function themesflat_predefined_header_styles() {
	static $styles;

	if ( empty( $styles ) ) {
		$styles = apply_filters( 'themesflat/header_styles', array(
			'header-v1' => esc_html__( 'Classic', 'finance' ),
			'header-v2' => esc_html__( 'Header style 02', 'finance' ),
			'header-v4' => esc_html__( 'Modern', 'finance' ),
		) );
	}

	return $styles;
}

/**
 * Render header style this theme
 *
 * @return  array
 */
function themesflat_render_header_styles() {
	static $header_style;
	
	if ( themesflat_meta( 'custom_header' ) == 1 ) {
		$header_style = themesflat_meta( 'header_style' );
	} else {
		$header_style = get_theme_mod( 'header_style', 'Header-v1' );
	}

	return $header_style;
}

if ( !function_exists('themesflat_social_array') ) {
    function themesflat_social_array(){
        return array(
            'facebook'      =>  esc_html__('Facebook','finance'),
            'twitter'       =>  esc_html__('Twitter','finance'),
            'google-plus'   =>  esc_html__('Google+','finance'),
            'linkedin'      =>  esc_html__('LinkedIn','finance'),
            'tumblr'        =>  esc_html__('Tumblr','finance'),
            'pinterest'     =>  esc_html__('Pinterest','finance'),
            'youtube'       =>  esc_html__('YouTube','finance'),
            'skype'         =>  esc_html__('Skype','finance'),
            'instagram'     =>  esc_html__('Instagram','finance'),
            'delicious'     =>  esc_html__('Delicious','finance'),
            'reddit'        =>  esc_html__('Reddit','finance'),
            'stumbleupon'   =>  esc_html__('StumbleUpon','finance'),
            'wordpress'     =>  esc_html__('Wordpress','finance'),
            'joomla'        =>  esc_html__('Joomla','finance'),
            'vimeo-square' 	=>  esc_html__('Vimeo','finance'),
            'yahoo'         =>  esc_html__('Yahoo!','finance'),
            'flickr'        =>  esc_html__('Flickr','finance'),
            'deviantart'    =>  esc_html__('DeviantArt','finance'),
            'github'        =>  esc_html__('GitHub','finance'),
            'stack-overflow' =>  esc_html__('StackOverFlow','finance'),
            'xing'          =>  esc_html__('Xing','finance'),
            'foursquare'    =>  esc_html__('Foursquare','finance'),
            'paypal'        =>  esc_html__('Paypal','finance'),
            'yelp'          =>  esc_html__('Yelp','finance'),
            'soundcloud'    =>  esc_html__('SoundCloud','finance'),
            'lastfm'        =>  esc_html__('Last.fm','finance'),
            'dribbble'      =>  esc_html__('Dribbble','finance'),
            'steam'         =>  esc_html__('Steam','finance'),
            'behance'       =>  esc_html__('Behance','finance'),
            'weibo'         =>  esc_html__('Weibo','finance'),
            'renren'        =>  esc_html__('Renren','finance'),
            'dropbox'       =>  esc_html__('Dropbox','finance'),
            'bitbucket'     =>  esc_html__('Bitbucket','finance'),
            'trello'        =>  esc_html__('Trello','finance'),
            'vk'            =>  esc_html__('VKontakte','finance'),
            'rss'           =>  esc_html__('RSS','finance'),
        );
    }
}

function themesflat_available_social_icons() {
	$icons = apply_filters( 'op_available_social_icons', array(
		'twitter'        => array( 'icon_class' => 'fa-twitter', 'title' => 'Twitter' ),
		'facebook'       => array( 'icon_class' => 'fa-facebook', 'title' => 'Facebook' ),
		'google-plus'    => array( 'icon_class' => 'fa-google-plus', 'title' => 'Google+' ),
		'pinterest'      => array( 'icon_class' => 'fa-pinterest', 'title' => 'Pinterest' ),
		'instagram'      => array( 'icon_class' => 'fa-instagram', 'title' => 'Instagram' ),
		'youtube'        => array( 'icon_class' => 'fa-youtube-play', 'title' => 'Youtube' ),
		'vimeo'          => array( 'icon_class' => 'fa-vimeo-square', 'title' => 'Vimeo' ),
		'linkedin'       => array( 'icon_class' => 'fa-linkedin', 'title' => 'LinkedIn' ),
		'behance'        => array( 'icon_class' => 'fa-behance', 'title' => 'Behance' ),
		'bitcoin'        => array( 'icon_class' => 'fa-bitcoin', 'title' => 'Bitcoin' ),
		'bitbucket'      => array( 'icon_class' => 'fa-bitbucket', 'title' => 'BitBucket' ),
		'codepen'        => array( 'icon_class' => 'fa-codepen', 'title' => 'Codepen' ),
		'delicious'      => array( 'icon_class' => 'fa-delicious', 'title' => 'Delicious' ),
		'deviantart'     => array( 'icon_class' => 'fa-deviantart', 'title' => 'DeviantArt' ),
		'digg'           => array( 'icon_class' => 'fa-digg', 'title' => 'Digg' ),
		'dribbble'       => array( 'icon_class' => 'fa-dribbble', 'title' => 'Dribbble' ),
		'flickr'         => array( 'icon_class' => 'fa-flickr', 'title' => 'Flickr' ),
		'foursquare'     => array( 'icon_class' => 'fa-foursquare', 'title' => 'Foursquare' ),
		'github'         => array( 'icon_class' => 'fa-github-alt', 'title' => 'Github' ),
		'jsfiddle'       => array( 'icon_class' => 'fa-jsfiddle', 'title' => 'JSFiddle' ),
		'reddit'         => array( 'icon_class' => 'fa-reddit', 'title' => 'Reddit' ),
		'skype'          => array( 'icon_class' => 'fa-skype', 'title' => 'Skype' ),
		'slack'          => array( 'icon_class' => 'fa-slack', 'title' => 'Slack' ),
		'soundcloud'     => array( 'icon_class' => 'fa-soundcloud', 'title' => 'SoundCloud' ),
		'spotify'        => array( 'icon_class' => 'fa-spotify', 'title' => 'Spotify' ),
		'stack-exchange' => array( 'icon_class' => 'fa-stack-exchange', 'title' => 'Stack Exchange' ),
		'stack-overflow' => array( 'icon_class' => 'fa-stack-overflow', 'title' => 'Stach Overflow' ),
		'steam'          => array( 'icon_class' => 'fa-steam', 'title' => 'Steam' ),
		'stumbleupon'    => array( 'icon_class' => 'fa-stumbleupon', 'title' => 'Stumbleupon' ),
		'tumblr'         => array( 'icon_class' => 'fa-tumblr', 'title' => 'Tumblr' ),
		'rss'            => array( 'icon_class' => 'fa-rss', 'title' => 'RSS' )
	) );

	$icons['__icons_ordering__'] = array_keys( $icons );

	return $icons;
}

function themesflat_shortcode_icon_name( $prefix,$icon_type ) {
    $icon_name = '';
    if ($icon_type != 'none') {
        $icon_name  = $prefix.$icon_type;
        wp_enqueue_style('vc_'.$icon_type);
    }
    return $icon_name;
}

function themesflat_add_icons($icon_name='fa',$url='') {
    $icons = '';
    if ( $url != '' ) {
       $fontContent = wp_remote_get( $url, array('sslverify'   => false) );
       if (!is_wp_error($fontContent)){
           $pattern = sprintf('/\.([\A%s].*?)\:/',$icon_name);
           preg_match_all($pattern, $fontContent['body'],$tmp_icons);
           $icons = $tmp_icons[1];
       }
    }
    return $icons;
}

/**
 * Register Backend and Frontend CSS Styles
 */
add_action( 'vc_base_register_front_css', 'themesflat_vc_iconpicker_base_register_css' );
add_action( 'vc_base_register_admin_css', 'themesflat_vc_iconpicker_base_register_css' );
function themesflat_vc_iconpicker_base_register_css(){
    wp_register_style('vc_iconsfo', THEMESFLAT_LINK. 'css/fo.css');
    wp_register_style('vc_simpleline', THEMESFLAT_LINK. 'css/simple-line-icons.css');
    wp_register_style('vc_ionicons', THEMESFLAT_LINK. 'css/ionicons.min.css');
}

/**
 * Enqueue Backend and Frontend CSS Styles
 */
add_action( 'vc_backend_editor_enqueue_js_css', 'themesflat_vc_iconpicker_editor_jscss' );
add_action( 'vc_frontend_editor_enqueue_js_css', 'themesflat_vc_iconpicker_editor_jscss' );
function themesflat_vc_iconpicker_editor_jscss(){
    wp_enqueue_style( 'vc_iconsfo' );
    wp_enqueue_style( 'vc_simpleline' );
    wp_enqueue_style( 'vc_ionicons' );
}

// Load sinple-line-icon
function themesflat_iconpicker_type_simpleline($icons) {
    $tmp_icon = themesflat_add_icons('icon',THEMESFLAT_LINK.'css/simple-line-icons.css');
    foreach ($tmp_icon as $icon) {
        $iconname = str_replace('icon-', '', $icon);
        $iconname = ucwords(str_replace("-", " ", $iconname));
        $_icons[] = array($icon => $iconname);
    }
    return array_merge( $icons, $_icons );

}

add_filter( 'vc_iconpicker-type-simpleline', 'themesflat_iconpicker_type_simpleline' );

// Load iconsfo
function themesflat_iconpicker_type_iconsfo( $icons ) {
    $tmp_icon = themesflat_add_icons('icon',THEMESFLAT_LINK.'css/fo.css');
    foreach ($tmp_icon as $icon) {
        $iconname = str_replace('icon-', '', $icon);
        $iconname = ucwords(str_replace("-", " ", $iconname));
        $_icons[] = array($icon => $iconname);
    }
    return array_merge( $icons, $_icons );

}

add_filter( 'vc_iconpicker-type-iconsfo', 'themesflat_iconpicker_type_iconsfo' );

// ionicons
function themesflat_iconpicker_type_ionicons($icons) {
    $tmp_icon = themesflat_add_icons('icon',THEMESFLAT_LINK.'css/ionicons.min.css');
    foreach ($tmp_icon as $icon) {
        $iconname = str_replace('icon-', '', $icon);
        $iconname = ucwords(str_replace("-", " ", $iconname));
        $_icons[] = array($icon => $iconname);
    }
    return array_merge( $icons, $_icons );

}

add_filter( 'vc_iconpicker-type-ionicons', 'themesflat_iconpicker_type_ionicons' );

// Load icon type
function themesflat_map_icons($name='icon',$heading_name = 'Icon') {
	return array(
			array(
				'type' => 'dropdown',
				'heading' => esc_attr( $heading_name.' library'),
				'value' => array(
                    esc_html__( 'None', 'finance' ) => 'none',
					esc_html__( 'Font Awesome', 'finance' ) => 'fontawesome',
					esc_html__( 'Open Iconic', 'finance' ) => 'openiconic',
					esc_html__( 'Typicons', 'finance' ) => 'typicons',
					esc_html__( 'Entypo', 'finance' ) => 'entypo',
					esc_html__( 'Linecons', 'finance' ) => 'linecons',
					esc_html__( 'Mono Social', 'finance' ) => 'monosocial',
                    esc_html__( 'Material', 'finance' ) => 'material',
					esc_html__( 'Simple Line', 'finance' ) => 'simpleline',
					esc_html__( 'Fo Icons', 'finance' ) => 'iconsfo',
					esc_html__( 'Ionicons', 'finance' ) => 'ionicons',
				),
                'std' => 'none',
				'admin_label' => true,
				'param_name' => $name.'_type',
				'description' => esc_html__( 'Select icon library.', 'finance' ),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_attr( $heading_name ),
				'param_name' => $name.'_fontawesome',
				'value' => 'fa fa-adjust',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
                    'type' => 'fontawesome',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'fontawesome',
				),
				'description' => esc_html__( 'Select icon from library.', 'finance' ),
				'integrated_shortcode_field' => $name.'_'
			),
            array(
                'type' => 'iconpicker',
                'heading' => esc_attr( $heading_name),
                'param_name' => $name.'_simpleline',
                'value' => 'icon-user',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'simpleline',

                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                    'element' => $name.'_type',
                    'value' => 'simpleline',
                ),
                'description' => esc_html__( 'Select icon from library.', 'finance' ),
                'integrated_shortcode_field' => $name.'_'
            ),
            
			array(
				'type' => 'iconpicker',
				'heading' => esc_attr( $heading_name ),
				'param_name' => $name.'_iconsfo',
				'value' => 'ifco ifco-bank',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'iconsfo',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'iconsfo',
				),
				'description' => esc_html__( 'Select icon from library.', 'finance' ),
				'integrated_shortcode_field' => $name.'_'
			),

			array(
                'type' => 'iconpicker',
                'heading' => esc_attr( $heading_name),
                'param_name' => $name.'_ionicons',
                'value' => 'icon-user',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'ionicons',

                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                    'element' => $name.'_type',
                    'value' => 'ionicons',
                ),
                'description' => esc_html__( 'Select icon from library.', 'finance' ),
                'integrated_shortcode_field' => $name.'_'
            ),
            
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'finance' ),
				'param_name' => $name.'_openiconic',
				'value' => 'vc-oi vc-oi-dial',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'openiconic',
				),
				'description' => esc_html__( 'Select icon from library.', 'finance' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'finance' ),
				'param_name' => $name.'_typicons',
				'value' => 'typcn typcn-adjust-brightness',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'typicons',
				),
				'description' => esc_html__( 'Select icon from library.', 'finance' ),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'finance' ),
				'param_name' => $name.'_entypo',
				'value' => 'entypo-icon entypo-icon-note',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'entypo',
				),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'finance' ),
				'param_name' => $name.'_linecons',
				'value' => 'vc_li vc_li-heart',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'linecons',
				),
				'description' => esc_html__( 'Select icon from library.', 'finance' ),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'finance' ),
				'param_name' => $name.'_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'monosocial',
				),
				'description' => esc_html__( 'Select icon from library.', 'finance' ),
				'integrated_shortcode_field' => $name.'_'
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'finance' ),
				'param_name' => $name.'_material',
				'value' => 'vc-material vc-material-cake',
				// default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => $name.'_type',
					'value' => 'material',
				),
				'description' => esc_html__( 'Select icon from library.', 'finance' ),
				'integrated_shortcode_field' => $name.'_'
			),
		);
}

/**
 * Menu fallback
 */
function themesflat_menu_fallback() {
	echo '<a class="menu-fallback" href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__( 'Create a Menu', 'finance' ) . '</a>';
}

function themesflat_esc_attr($attr) {
	echo esc_attr($attr);
}

function themesflat_esc_html($attr) {
	echo esc_html($attr);
}

/**
 * Change the excerpt length
 */
function themesflat_excerpt_length( $length ) {  
  	$excerpt = themesflat_choose_opt('blog_archive_post_excepts_length');
  	return $excerpt;
}

add_filter( 'excerpt_length', 'themesflat_excerpt_length', 999 );

/**
 * Blog layout
 */
function themesflat_blog_layout() {
	if ( themesflat_meta('enable_custom_layout') == 1 ) {
		$blog_layout = themesflat_meta('sidebar_layout');
	}
	else {
		if ( is_home() ) {
			$blog_layout = themesflat_get_opt( 'blog_layout' );
		} else {
			$blog_layout = themesflat_get_opt( 'page_layout' );
		}
		
	}
	return $blog_layout;
}

function themesflat_font_style($style) {
	if (strlen($style) > 4) {
	  	switch (substr($style, 0,3)) {
			case 'reg':
			    $a[0] = '400';
			    $a[1] = 'normal';
			break;
			case 'ita':
			    $a[0] = '400';
			    $a[1] = 'italic';			    
			break;
			default:
			    $a[0] = substr($style, 0,3);
			    $a[1] = substr($style, 4);
			break;
		}
		  
	}
	else {
	  	$a[0] = $style;
	  	$a[1] = 'normal';
	}
	return $a;
}

/**
 * Get post meta, using rwmb_meta() function from Meta Box class
 */
function themesflat_meta( $key) {
	global $post;
	if (!is_null($post)) :
	    return get_post_meta( $post->ID,$key, true );
	endif;
}

/**
 * Move_comment_field_to_bottom
 */
function themesflat_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}

add_filter( 'comment_form_fields', 'themesflat_move_comment_field_to_bottom' );

if ( ! function_exists( 'themesflat_favicon' ) ) {
	add_action( 'wp_head', 'themesflat_favicon' );

	/**
	 * Display the custom favicon setup for the theme
	 *	 
	 * @return  void
	 */
	 
	function themesflat_favicon() {
		if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {		
			printf ('<link rel="shortcut icon" href="'.esc_url( THEMESFLAT_LINK . 'icon/favicon.png').'" />');		
		}
	}
}

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function themesflat_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'finance' ), max( $paged, $page ) );
		}

		return $title;
	}

	add_filter( 'wp_title', 'themesflat_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	if ( ! function_exists( '_wp_render_title_tag' ) ) {
		function themesflat_render_title() {
			?>
			<title><?php wp_title( '|', true, 'right' ); ?></title>
			<?php
		}
		add_action( 'wp_head', 'themesflat_render_title' );
	}
	
endif;

	function themesflat_get_json($key) {
		if ( get_theme_mod($key) == '' ) return themesflat_customize_default_options2($key);
		if (!is_array(get_theme_mod($key))) {
        $decoded_value = json_decode(str_replace('&quot;', '"',  get_theme_mod( $key )), true );
	    }
	    else {
	    	$decoded_value = get_theme_mod($key);
	    }
        return $decoded_value;
	}

	function themesflat_decode($value) {
		if (!is_array($value)) {
            $decoded_value = json_decode(str_replace('&quot;', '"',  $value) , true );
        }
        else {
            $decoded_value = $value;
        }
        return $decoded_value;
	}

	function themesflat_get_opt( $key ) {
		return get_theme_mod( $key, themesflat_customize_default_options2( $key ) );
	}

	function themesflat_dynamic_sidebar($sidebar) {
	if ( is_active_sidebar ( $sidebar ) ) {
	            dynamic_sidebar( $sidebar );        
	        } else {         
            if ( is_user_logged_in() ) { 
            	printf( __( 'This is the %s widget area.Please go to <a href="%s">Admin</a>.', 'finance' ), esc_attr($sidebar), esc_url( admin_url( 'widgets.php' ) ) );
            }
	    }
	}

	function themesflat_choose_opt ($key) {
		$flatopts = ( get_option('flatopts') );
		if ( isset( $flatopts[$key] ) && themesflat_meta( $flatopts[$key]) == 1 ) {
			return themesflat_meta( $key );			
		}
		else 
			return themesflat_get_opt( $key );
	}


	function themesflat_load_page_menu($params) {
		if ( themesflat_meta( 'enable_custom_navigator' ) == 1 && themesflat_meta('menu_location_primary') != false ) {
			if ($params['theme_location'] == 'primary') {
				$params['menu'] = (int)themesflat_meta('menu_location_primary');
			}
		}
		return ($params);
	}

	add_filter( 'wp_nav_menu_args', 'themesflat_load_page_menu' );

 	function themesflat_render_social() {
 		ob_start();  		
		?>
        <ul class="flat-socials">
        	<?php
            foreach ( themesflat_social_array() as $key => $val ) {            	
                if ( get_theme_mod('social_links' . $key) != '' ) {
                    printf(
                        '<li>
                            <a href="%s" target="_blank" rel="alternate" title="%s">
                                <i class="fa fa-%s"></i>
                            </a>
                        </li>',
                        esc_url( get_theme_mod('social_links' . $key) ),
                        esc_attr( $val ),
                        esc_attr( $key ),
                        esc_attr( $val )
                    );
                }
            }            
            ?>
        </ul><!-- /.social -->       
 	<?php }
