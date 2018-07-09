<?php
/**
 * @package themesflat
 */
//Output all custom styles for this theme
function themesflat_custom_styles( $custom ) {
	$custom = '';

	$font = themesflat_get_json('body_font_name');
	$font_style = themesflat_font_style($font['style']);
	$body_fonts = $font['family'];
	$body_line_height = $font['line_height'];
	$body_font_weight = $font_style[0];
	$body_font_style = $font_style[1];
	$body_size = $font['size'];	
	
	$headings_fonts_ = themesflat_get_json('headings_font_name');
	$headings_fonts_family = $headings_fonts_['family'];	
	$headings_style = themesflat_font_style( $headings_fonts_['style'] );
	$headings_font_weight = $headings_style[0];
	$headings_font_style = $headings_style[1];

	$menu_fonts_ = themesflat_get_json('menu_font_name');
	$menu_fonts_family = $menu_fonts_['family'];
	$menu_fonts_size = $menu_fonts_['size'];
	$menu_line_height = $menu_fonts_['line_height'];
	$menu_style = themesflat_font_style( $menu_fonts_['style'] );
	$menu_font_weight = $menu_style[0];
	$menu_font_style = $menu_style[1];	

	// Body font family
	if ( $body_fonts !='' ) {
		$custom .= "body,button,input,select,textarea { font-family:" . $body_fonts . " ; }"."\n";
	}

	// Body font weight
	if ( $body_font_weight !='' ) {
		$custom .= "body,button,input,select,textarea { font-weight:" . $body_font_weight . ";}"."\n";
	}

	// Body font style
	if ( isset( $body_font_style ) ) {
        $custom .= "body,button,input,select,textarea { font-style:" . $body_font_style . "; }"."\n";        
	}

    // Body font size
    if ( $body_size !=''  ) {
        $custom .= "body,button,input,select,textarea { font-size:" . intval( $body_size ) . "px; }"."\n";        
    }

    // Body line height
    if ( $body_line_height != '' ) {
        $custom .= "body,button,input,select,textarea { line-height:" . intval( $body_line_height ) . "px !important; }"."\n";        
    }

	// Headings font family
	if ( $headings_fonts_family !='' ) {
		$custom .= "h1,h2,h3,h5,h6 { font-family:" . $headings_fonts_family . ";}"."\n";
	}

	//Headings font weight
	if ( $headings_font_weight !='' ) {
		$custom .= "h1,h2,h3,h4,h5,h6 { font-weight:" . $headings_font_weight . ";}"."\n";
	}

	// Headings font style
	if ( isset( $headings_font_style )) {
        $custom .= "h1,h2,h3,h4,h5,h6  { font-style:" . $headings_font_style . "; }"."\n";        
	}

	// Menu font family
	if ( $menu_fonts_family != '') {
		$custom .= "#mainnav > ul > li > a { font-family:" . $menu_fonts_family . ";}"."\n";
	}

	// Menu font weight
	if ( $menu_font_weight != '' ) {
		$custom .= "#mainnav > ul > li > a { font-weight:" . $menu_font_weight . ";}"."\n";
	}

	// Menu font style
	if ( isset( $menu_font_style )) {
        $custom .= "#mainnav > ul > li > a  { font-style:" . $menu_font_style . "; }"."\n";        
	}

    // Menu font size
    if ( $menu_fonts_size != '' ) {
        $custom .= "#mainnav ul li a { font-size:" . intval($menu_fonts_size) . "px;}"."\n";
    }

    // Menu line height
    if ( $menu_line_height != '' ) {
        $custom .= "#mainnav ul li a { line_height" . intval($menu_line_height) . "px;}"."\n";
    }
    
	// H1 font size
	if ( $h1_size = themesflat_get_opt( 'h1_size' ) ) {
		$custom .= "h1 { font-size:" . intval($h1_size) . "px; }"."\n";
	}

    // H2 font size
    if ( $h2_size = themesflat_get_opt( 'h2_size' ) ) {
        $custom .= "h2 { font-size:" . intval($h2_size) . "px; }"."\n";
    }

    // H3 font size
    if ( $h3_size = themesflat_get_opt( 'h3_size' ) ) {
        $custom .= "h3 { font-size:" . intval($h3_size) . "px; }"."\n";
    }

    // H4 font size
    if ( $h4_size = themesflat_get_opt( 'h4_size' ) ) {
        $custom .= "h4 { font-size:" . intval($h4_size) . "px; }"."\n";
    }

    // H5 font size
    if ( $h5_size = themesflat_get_opt( 'h5_size' ) ) {
        $custom .= "h5 { font-size:" . intval($h5_size) . "px; }"."\n";
    }

    // H6 font size
    if ( $h6_size = themesflat_get_opt( 'h6_size' ) ) {
        $custom .= "h6 { font-size:" . intval($h6_size) . "px; }"."\n";
    }

    // Page title text color
    if ( $pagetitle_text_color = themesflat_get_opt( 'pagetitle_text_color' ) ) {
        $custom .= ".page-title .page-title-heading h1, .breadcrumbs .trail-end, .breadcrumbs span { color:" . $pagetitle_text_color."; }"."\n";
    }

    // Page title link color
    if ( $pagetitle_link_color = themesflat_get_opt( 'pagetitle_link_color' ) ) {
        $custom .= ".breadcrumbs span a, .breadcrumbs a,.breadcrumbs span.sep { color:" . $pagetitle_link_color."; }"."\n";
    }

    // Page title Padding
    if ( $pagetitle_padding = themesflat_get_opt( 'pagetitle_padding' ) ) {
        $custom .= ".page-title { Padding:" . $pagetitle_padding."px 0; }"."\n";
    }  
   
    // Primary color    
    $primary_color = themesflat_get_opt( 'primary_color' );
    $links_color = get_theme_mod('links_color');
    if ( $primary_color !='' ) {
    	$custom .= "a:hover,.wrap-client-slide .owl-theme .owl-controls .owl-nav div.owl-prev:hover:before, .wrap-client-slide .owl-theme .owl-controls .owl-nav div.owl-next:hover:before,ul.flat-list li:before,.navigation.posts-navigation .nav-links li a .meta-nav,article h4.entry-time a,.author-post .info .name a,.flat-portfolio .portfolio-gallery .item .title-post a:hover,.flat-portfolio .portfolio-gallery .item .category-post a:hover,.footer-widgets ul li a:hover,.bottom #menu-bottom li a:hover,.flat-iconbox.flat-iconbox-style2:hover .box-icon span,.imagebox.style-2 .box-button a,.imagebox.style-2 .box-header .box-title a:hover,.imagebox.style-3 .box-header .box-title a:hover,.flat-iconbox.style-3 .box-header .box-icon span,.testimonial-slider.style-2 .testimonial-author .author-info,.blog-shortcode.blog-home3 article .read-more a,.blog-shortcode.blog-home3 article .read-more a:after,.flat-text-block-timeline .year,.imagebox.services-grid .box-button a,.imagebox.services-grid .box-header .box-title a:hover,.flat-portfolio .item .title-post a:hover,.portfolio-filter li a:hover,.breadcrumbs span a:hover, .breadcrumbs a:hover,.flat-imagebox.style-2 .flat-imagebox-button a,.flat-imagebox.style-2 .flat-imagebox-header .flat-imagebox-title a:hover,.flat-iconbox.style-3 .flat-iconbox-header .flat-iconbox-icon span,.flat-imagebox.services-grid .flat-imagebox-button a,article .entry-meta ul li a:hover,.breadcrumbs span a, .breadcrumbs a, .breadcrumbs span.sep { color:" . esc_attr($primary_color) . ";}"."\n";		

		// Background color
		$custom .= ".title-section .title:after,.flat-iconbox.rounded .box-icon,.owl-theme .owl-controls .owl-nav [class*=owl-],.blog-shortcode article .featured-post:after,.blog-shortcode article:hover .entry-meta,.flat-iconbox.circle .box-icon,.flat-progress .progress-animate,.flat-button,.flat-team .box-readmore a,.portfolio-filter li.active a:after,.portfolio-filter li a:after,.flat-socials li a,.imagebox.style-2 .box-image:after,.title-section.style3 .title:after,.imagebox.style-3 .box-image:before,.imagebox.style-3 .box-image:after,.testimonial-slider.style-2.owl-theme.owl-theme .owl-controls .owl-nav [class*=owl-]:hover,.btn-cons a:hover,.testimonials-sidebar .owl-theme .owl-dots .owl-dot span:hover, .testimonials-sidebar .owl-theme .owl-dots .owl-dot.active span,.imagebox.services-grid .box-image:after,.blog-shortcode article .read-more a:hover,input[type='submit'],.flat-imagebox .flat-imagebox-button a,.flat-iconbox.rounded .flat-iconbox-icon,.flat-imagebox.style-2 .flat-imagebox-image:after,.flat-iconbox.circle .flat-iconbox-icon,.testimonial-slider.style-1 .testimonial-content:before,.flat-imagebox.style-3 .flat-imagebox-image:before,.flat-imagebox.style-3 .flat-imagebox-image:after,.flat-imagebox.services-grid .flat-imagebox-image:after,article .entry-content .more-link { background-color:" . esc_attr($primary_color) . "; }"."\n";

		// Background color important
		$custom .= " .info-top-right a.appoinment,.imagebox .box-button a,.imagebox .box-header:before,.call-back-form .flat-button-form,.flat-before-footer .custom-info .icon,button, input[type='button'], input[type='reset'],.go-top:hover,.page-template-tpl .vc_toggle_active .vc_toggle_title,.wpb_gallery_slides .flex-direction-nav li a,.sidebar .widget.widget_nav_menu ul li:first-child a:before,.featured-post.blog-slider .flex-prev, .featured-post.blog-slider .flex-next,.vc_tta.vc_tta-accordion .vc_tta-controls-icon-position-left.vc_tta-panel-title>a,#flat-portfolio-carousel ul.flex-direction-nav li a,.navigation.posts-navigation .nav-links li a:after,.title_related_portfolio:after,.navigation.paging-navigation a:hover,.widget .widget-title:after,.widget.widget_tag_cloud .tagcloud a,.navigation.paging-navigation .current,.widget.widget_categories ul li:first-child > a:before,.blog-single .entry-footer .tags-links a,.comment-reply-title:after, .comment-title:after,#mc4wp-form-1 input[type='submit'] {
			background-color:" . esc_attr($primary_color) . ";
		}"."\n";		

		// Border color
		$custom .= "textarea:focus,
		input[type='text']:focus,
		input[type='password']:focus,
		input[type='datetime']:focus,
		input[type='datetime-local']:focus,
		input[type='date']:focus,
		input[type='month']:focus,
		input[type='time']:focus,
		input[type='week']:focus,
		input[type='number']:focus,
		input[type='email']:focus,
		input[type='url']:focus,
		input[type='search']:focus,
		input[type='tel']:focus,
		input[type='color']:focus,.testimonial-slider.owl-theme .owl-dots .owl-dot.active span:before,.navigation.paging-navigation .current,.flat-iconbox.flat-iconbox-style2:hover .box-icon,.testimonial-slider.style-2.owl-theme.owl-theme .owl-controls .owl-nav [class*=owl-]:hover { border-color:" . esc_attr($primary_color) . "!important}"."\n";

		// Border color important
		$custom .= " {
			border-color:" . esc_attr($primary_color) . "!important;
		}"."\n";	

		$custom .= ".loading-effect-2 > span, .loading-effect-2 > span:before, .loading-effect-2 > span:after {border: 2px solid" . esc_attr($primary_color) . ";}"."\n";
		$custom .= ".loading-effect-2 > span { border-left-color: transparent !important;}"."\n";

		// Color #fff
		$custom .= ".imagebox .box-button a:hover,.navigation.paging-navigation a:hover {
			color: #fff !important;
		}"."\n";	
		 
    }

    $custom .= ".info-top-right a.appoinment:hover,
    .imagebox .box-button a:hover,.call-back-form .flat-button-form:hover,button:hover, input[type='reset']:hover,.wpb_gallery_slides .flex-direction-nav li a:hover,.featured-post.blog-slider .flex-prev:hover, .featured-post.blog-slider .flex-next:hover,.vc_tta.vc_tta-accordion .vc_tta-controls-icon-position-left.vc_tta-panel-title>a:hover,#flat-portfolio-carousel ul.flex-direction-nav li a:hover,.navigation.posts-navigation .nav-links li:hover a:after,.widget.widget_tag_cloud .tagcloud a:hover,.blog-single .entry-footer .tags-links a:hover,#mc4wp-form-1 input[type='submit']:hover {
		background-color: #2e363a !important;
	}"."\n";	

	$custom .= ".show-search a i:hover,article h4.entry-time a:hover,
	.header-style2 .nav-wrap #mainnav > ul > li > a:hover,
	.header-style3 .nav-wrap #mainnav > ul > li > a:hover {
		color:  #2e363a !important;
	}"."\n";	

	// Body color
	$body_text = themesflat_get_opt( 'body_text_color' );
	$custom .= "body { color:" . esc_attr($body_text) . "!important}"."\n";

    if ( themesflat_choose_opt ('top_background_color') !='' ) {
		$custom .= ".flat-top { background-color:" . esc_attr(themesflat_choose_opt ('top_background_color')) ." !important; } "."\n";
    }	

    //Top text color
    $top_text_color = themesflat_choose_opt( 'topbar_textcolor' );
    if ( themesflat_choose_opt( 'topbar_textcolor' ) !='' ) {
		$custom .= ".flat-top,.info-top-right,.info-top-right a.appoinment { color:" . esc_attr( themesflat_choose_opt( 'topbar_textcolor' ) ) ."!important ;} "."\n";
    }	  

    // Menu Background
	$mainnav_backgroundcolor = themesflat_choose_opt( 'mainnav_backgroundcolor');
	if ( $mainnav_backgroundcolor !='' ) {
		$custom .= ".header.header-style1,.nav.header-style2,.wrap-header-style3 { background-color:" . esc_attr( $mainnav_backgroundcolor ) . ";}"."\n";
	} 
   
	// Menu mainnav a color
	$mainnav_color = themesflat_choose_opt( 'mainnav_color');
	if ( $mainnav_color !='' ) {
		$custom .= "#mainnav > ul > li > a { color:" . esc_attr( $mainnav_color ) . ";}"."\n";
	}

	// mainnav_hover_color
	$mainnav_hover_color = themesflat_get_opt( 'mainnav_hover_color');
	if ( $mainnav_hover_color !='' ) {
		$custom .= "#mainnav > ul > li > a:hover,#mainnav > ul > li.current-menu-item > a { color:" . esc_attr( $mainnav_hover_color ) . " !important;}"."\n";
	}

	//Subnav a color
	$sub_nav_color = themesflat_get_opt( 'sub_nav_color');
	if ( $sub_nav_color !='' ) {
		$custom .= "#mainnav ul.sub-menu > li > a { color:" . esc_attr( $sub_nav_color ) . "!important;}"."\n";
	}

	//Subnav background color
	$sub_nav_background = themesflat_get_opt( 'sub_nav_background');
	if ( $sub_nav_background !='' ) {
		$custom .= "#mainnav ul.sub-menu { background-color:" . esc_attr( $sub_nav_background ) . ";}"."\n";			
	}

	//sub_nav_background_hover
	$sub_nav_background_hover = themesflat_get_opt( 'sub_nav_background_hover');
	if ( $sub_nav_background_hover !='' ) {
		$custom .= "#mainnav ul.sub-menu > li > a:hover { background-color:" . esc_attr($sub_nav_background_hover) . "!important;}"."\n";
	}

	//border color sub nav
	$border_clor_sub_nav = themesflat_get_opt( 'border_clor_sub_nav');
	if ( $border_clor_sub_nav !='' ) {
		$custom .= "#mainnav ul.sub-menu > li { border-color:" . esc_attr($border_clor_sub_nav) . "!important;}"."\n";
	}	

	// Footer simple background color
	$footer_background_color = themesflat_choose_opt( 'footer_background_color');
	if ( $footer_background_color !='' ) {
		$custom .= ".footer { background-color:" . esc_attr($footer_background_color) . "!important;}"."\n";
	}

	// Footer simple text color
	$footer_text_color = themesflat_choose_opt( 'footer_text_color');
	if ( $footer_text_color !='' ) {
		$custom .= ".footer a, .footer, .flat-before-footer .custom-info > div,.footer-widgets ul li a { color:" . esc_attr($footer_text_color) . ";}"."\n";
	}

	// bottom_background_color
	$bottom_background_color = themesflat_choose_opt( 'bottom_background_color');
	if ( $bottom_background_color !='' ) {
		$custom .= ".bottom { background-color:" . esc_attr( $bottom_background_color ) . "!important;}"."\n";
	}

	// Bottom text color
	$bottom_text_color = themesflat_choose_opt( 'bottom_text_color');
	if ( $bottom_text_color !='' ) {
		$custom .= ".bottom .copyright p,.bottom #menu-bottom li a { color:" . esc_attr( $bottom_text_color ) . ";}"."\n";
	}

	wp_add_inline_style( 'themesflat-style', $custom );	
}

add_action( 'wp_enqueue_scripts', 'themesflat_custom_styles' );

