<?php
/**
 * Return the default options of the theme
 * 
 * @return  void
 */

function themesflat_customize_default_options2($key) {
	$default = array(
		'footer_widget_areas3_layout' => array(
            array( 12 ),
            array( 8, 4 ),
            array( 4, 4, 4 ),
            array( 3, 3, 3, 3 )
        ),
		'footer_widget_areas3'	=> array(
			0 => 4,
			1 => 4,
			2 => 4
		),
		'social_links'	=> array ("facebook" => 'facebook.com/themesflat', "twitter"=>"#", "google-plus"=>"#", "linkedin"=>"#"),
		'socials_link_footer' => 0,
		'enable_social_link'  => 1,
		'enable_content_right_top'  => 0,
		'top_background_color'	=> '#3a526a',
		'topbar_textcolor'	=> '#ffffff',
		'mainnav_backgroundcolor'=>'#fff',
		'mainnav_color'		=> '#424242',
		'mainnav_hover_color'=>'#18ba60',
		'sub_nav_color'		=>'#fff',
		'sub_nav_background'=>'#1d2738',
		'border_clor_sub_nav'=>'#2d374a',
		'sub_nav_background_hover'=>'#18ba60',
		'primary_color'=>'#18ba60',
		'body_text_color'=>'#666',
		'body_font_name'	=> array(
			'family' => 'Poppins',
			'style'  => '400',
			'size'   => '14',
			'line_height'=>'24'
		),
		'headings_font_name'	=> array(
			'family' => 'Poppins',
			'style'  => '600'			
		),
		'h1_size' => 50,
		'h2_size' => 30,
		'h3_size' => 24,
		'h4_size' => 20,
		'h5_size' => 15,
		'h6_size' => 13,
		'blog_grid_columns' => 3,
		'blog_layout' => 'sidebar-right',
		'page_layout' => 'sidebar-right',
		'blog_style'  => 'blog_list',
		'blog_grid_columns' => 'three_columns',
		'blog_archive_post_excepts_length' => 51,
		'related_post_style'	=> 'list',
		'blog_sidebar_list'		  => 'sidebar-blog',
		'blog_archive_show_post_meta'	=> 1,		
		'blog_archive_readmore' => 0,
		'blog_archive_readmore_text' => 'Read More',
		'blog_archive_pagination_style' => 'pager-numeric',
		'blog_posts_per_page'	=> 9,
		'blog_order_by'	=> 'date',
		'blog_order_direction' => 'DESC',
		'page_sidebar_list'	=> 'sidebar-page',
		'menu_font_name'	=> array(
			'family' => 'Poppins',
			'style'  => '600',
			'size'   => '14',
			'line_height'=>'92',
		),

		/* Page title */
		'pagetitle_background_color'	=> '#f7f7f7',
		'pagetitle_text_color'	=> '#2e363a',
		'pagetitle_link_color'  => '#18ba60',
		'pagetitle_style'		=>  'pagetitle_style_1',
		'pagetitle_padding'     =>  15,
		'page_title_heading'	=>  0,
		'page_title_overlay'	=>  0,

		'show_readmore'	  => 0,
		'show_filter_portfolio' => 1,
		'portfolio_style'		=>'grid',
		'grid_columns_portfolio' => 'one-three',
		'portfolio_archive_pagination_style' => 'pager-numeric',
		'portfolio_grid_columns' => 'one-three',		
		'portfolio_post_perpage'	=> 9,
		'portfolio_order_by'	=> 'date',
		'portfolio_order_direction' => 'DESC',
		'related_portfolio_style' => 'grid',
		'grid_columns_portfolio_related' => 'one-half',
		'number_related_portfolio' => 2,
		'show_related_portfolio' => 1,		
		'enable_custom_topbar'  => 0,
		'enable_page_callout'	=> 0,
		'topbar_enabled' => 1,
		'header_sticky' => 1,
		'header_style'=>'header-style1',
		'header_searchbox' => 1,		
		'footer_background_color'	=> '#2e363a',
		'footer_text_color'			=> '#e5e5e5',
		'bottom_background_color'	=> '#2e363a',
		'enable_footer'				=> 1,
		'bottom_text_color'			=> '#e5e5e5',
		'go_top'					=> 1,
		'layout_version'			=> 'wide',		
		'footer_copyright'			=> '<p>Copyright 2017 Finance. Theme by Themesflat.</p>',
		'top_content' => '<div class="custom-info">
            <ul><li class="phone"><i class="fa fa-phone"></i>Call us: +61 3 8376 6284</li>
            	<li class="mail"><i class="fa fa-envelope"></i>Email: support24-7@gmail.com</li>
            </ul>
            </div>',
        'top_content_right' => '<div class="info-top-right">
            <span><i class="fa fa-question-circle"></i>Have any questions?</span>
            <a class="appoinment" href="#">Get An Appointment</a>
            </div>',
	);
	return $default[$key];
}

/**
 * Return an array that used to declare options
 * for the page
 * 
 * @return  array
 */
function themesflat_portfolio_options_fields() {
	$options['cover_heading'] = array(
		'type' => 'heading',
		'section' => 'general',
		'title' => esc_html__( 'Portfolio', 'finance' )
	);

	$options['port_client'] = array(
		'type'    => 'text',
		'section' => 'general',
		'title' => esc_html__( 'Client', 'finance' ),
		'default' => ''
	);

	$options['port_value'] = array(
		'type'    => 'text',
		'section' => 'general',
		'title' => esc_html__( 'Value', 'finance' ),
		'default' => ''
	);

	$options['gallery_portfolio'] = array(
		'type'    => 'image-control',
		'section' => 'general',
		'title' => esc_html__( 'Images', 'finance' ),
		'default' => ''
	);

	themesflat_prepare_options($options);
	return $options;
}

function themesflat_post_options_fields() {
	$options['blog_heading'] = array(
		'type' => 'heading',
		'section' => 'blog',
		'title' => esc_html__( 'Dear friends,', 'finance' )
	);
	$options['gallery_images_heading'] = array(
		'type' => 'heading',
		'section' => 'blog',
		'title' => esc_html__( 'Post Format: Gallery .', 'finance' ),
		'description' => esc_html__( '', 'finance' )
	);

	$options['gallery_images'] = array(
		'type'    => 'image-control',
		'section' => 'blog',
		'title' => esc_html__( 'Images', 'finance' ),
		'default' => ''
	);

	$options['video_url_heading'] = array(
		'type' => 'heading',
		'section' => 'blog',
		'title' => esc_html__( 'Post Format: Video ( Embeded video from youtube, vimeo ...).', 'finance' ),
		'description' => esc_html__( '', 'finance' )
	);

	$options['video_url'] = array(
		'type'    => 'textarea',
		'section' => 'blog',
		'title' => esc_html__( 'iframe video link', 'finance' ),
		'default' => ''
	);
	themesflat_prepare_options($options);
	return $options;
}

function themesflat_page_options_fields() {
	global $wp_registered_sidebars;
	
	$options  = array();
	$sidebars = array();

	// Retrieve all registered sidebars
	foreach( $wp_registered_sidebars as $params )
		$sidebars[$params['id']] = $params['name'];

	/**
	 * General
	 */	
	$options['layout_heading'] = array(
		'type' => 'heading',
		'section' => 'general',
		'title' => esc_html__( 'Layout', 'finance' ),
		'description' => esc_html__( 'Select layout for page ( Wide/Boxed )', 'finance' )
	);

	$options['enable_custom_layout'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'On Custom Layout', 'finance' ),
		'section' => 'general',
		'children'=> array('layout_version','sidebar_layout','sidebar_default','page_sidebar_list'),
		'default' => false
	);

	$options['layout_version'] = array(
		'type'    => 'select',
		'title'   => esc_html__( 'Display Type', 'finance' ),
		'section' => 'general',
		'default' => 'wide',
		'choices'   => array(
            'wide'     => esc_html( 'Wide', 'finance' ),
            'boxed'     => esc_html( 'Boxed', 'finance' )
        )	
	);

	$options['sidebar_layout'] = array(
		'type'    => 'select',
		'title'   => esc_html__( 'Select Sidebar For This Page', 'finance' ),
		'section' => 'general',
		'default' => 'sidebar-right',
		'choices'   => array(
            'fullwidth'     => esc_html( 'No Sidebar', 'finance' ),
            'sidebar-left'     => esc_html( 'Sidebar Left', 'finance' ),
            'sidebar-right'     => esc_html( 'Sidebar Righ', 'finance' )
        )		
	);

	$options['page_sidebar_list'] = array(
		'type'    => 'dropdown-sidebar',
		'title'   => esc_html__( 'Custom Sidebar', 'finance' ),
		'section' => 'general',
		'default' => 'sidebar-page'
	);

	/**
	 * Footer
	 */	
	$options['footer_widgets_heading'] = array(
		'type'        => 'heading',
		'section'     => 'general',
		'title'       => esc_html__( 'Footer Widgets', 'finance' ),
		'description' => esc_html__( 'All option for footer on this page', 'finance' )
	);

	$options['enable_custom_footer_widgets'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Enable Custom Footer Layout', 'finance' ),
		'section' => 'general',
		'children'=> array('footer_background_color','footer_text_color'),
		'default' => false
	);

	$options['footer_background_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Footer Background', 'finance' ),
		'section' => 'general',
		'default' => themesflat_get_opt( 'footer_background_color' )
	);

	$options['footer_text_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Footer Text Color', 'finance' ),
		'section' => 'general',
		'default' => themesflat_get_opt( 'footer_text_color' )
	);
	
	$options['footer_heading'] = array(
		'type'        => 'heading',
		'class'       => 'no-border',
		'section'     => 'general',
		'title'       => esc_html__( 'Custom Footer', 'finance' ),
		'description' => esc_html__( 'You can change text, socials link', 'finance' )
	);

	$options['enable_custom_footer'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'On Custom Footer Content', 'finance' ),
		'section' => 'general',
		'children'=>array('socials_link_footer','footer_copyright','bottom_text_color','bottom_background_color'),
		'default' => false
	);

	$options['socials_link_footer'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Show Social Links On This Page', 'finance' ),
		'section' => 'general',
		'default' => themesflat_get_opt( 'socials_link_footer' )
	);

	$options['footer_copyright'] = array(
		'type'    => 'textarea',
		'title'   => esc_html__( 'Copyright', 'finance' ),
		'section' => 'general',
		'default' => ( 'footer_copyright' )
	);

	$options['bottom_background_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Bottom Background Color', 'finance' ),
		'section' => 'general',
		'default' => themesflat_get_opt( 'bottom_background_color' )
	);

	$options['bottom_text_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Bottom Text Color', 'finance' ),
		'section' => 'general',
		'default' => themesflat_get_opt( 'bottom_text_color' )
	);

	/**
	 * Header
	 */
	$options['topbar_heading'] = array(
		'type' => 'heading',
		'section' => 'header',
		'title' => esc_html__( 'Top Bar', 'finance' ),
		'description' => esc_html__( 'Turn on/off the top bar and change it styles.', 'finance' )
	);

	$options['enable_custom_topbar'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'On Custom Topbar', 'finance' ),
		'section' => 'header',
		'children' => array('topbar_enabled','enable_content_right_top','top_background_color','topbar_textcolor','top_content','top_content_right','enable_social_link'),
		'default' => false
	);

	$options['topbar_enabled'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Show Topbar on this page', 'finance' ),
		'section' => 'header',
		'default' => ( 'topbar_enabled' )
	);

	$options['enable_social_link'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Show Social Links', 'finance' ),
		'section' => 'header',
		'default' => ( 'enable_social_link' )
	);

	$options['enable_content_right_top'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Show Content Right Top', 'finance' ),
		'section' => 'header',
		'default' => ( 'enable_content_right_top' )
	);

	$options['top_background_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Topbar Background', 'finance' ),
		'section' => 'header',
		'default' => themesflat_get_opt( 'top_background_color' )
	);

	$options['topbar_textcolor'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Topbar Text Color', 'finance' ),
		'section' => 'header',
		'default' => themesflat_get_opt( 'topbar_textcolor' )
	);

	$options['top_content'] = array(
		'type'    => 'textarea',
		'title'   => esc_html__( 'Content Left', 'finance' ),
		'section' => 'header',
		'default' => themesflat_get_opt( 'top_content' )
	);

	$options['top_content_right'] = array(
		'type'    => 'textarea',
		'title'   => esc_html__( 'Content Right', 'finance' ),
		'section' => 'header',
		'default' => themesflat_get_opt( 'top_content_right' )
	);

	$options['header_style_heading'] = array(
		'type'        => 'heading',
		'section'     => 'header',
		'title'       => esc_html__( 'Custom Header', 'finance' ),
		'description' => esc_html__( 'Change header style on/off Search , Cart, Menu Extra', 'finance' )
	);

	$options['enable_custom_header_style'] = array(
		'type'    => 'power',		
		'title'   => esc_html__( 'Enable Custom Header', 'finance' ),
		'section' => 'header',
		'children' => array('header_sticky','header_searchbox','header_show_offcanvas','header_image','header_style'),
		'default' => false
	);

	$options['header_style'] = array(
        'type'      => 'radio-images',           
        'section'   => 'header',        
        'label'         => esc_html('List Header Type', 'finance'),
        'choices'   => array (
            'header-style1'=> array (
               'tooltip'   => esc_html('Header Type1','finance'),
               'src'       => THEMESFLAT_LINK . 'images/controls/header.png'
            ) ,
            'header-style2'=>  array (
               'tooltip'   => esc_html('Header Type2','finance'),
               'src'       => THEMESFLAT_LINK . 'images/controls/header-2.png'
            ) ,
            'header-style3'=>  array (
               'tooltip'   => esc_html('Header Type3','finance'),
                'src'      => THEMESFLAT_LINK . 'images/controls/header-3.png'
            ) ,
            'header-style4'=>  array (
               'tooltip'   => esc_html('Header Type4','finance'),
                'src'      => THEMESFLAT_LINK . 'images/controls/header-4.png'
            ) ,
        ),
    );

	
	$options['header_sticky'] = array(
		'type'    => 'power',
		'section' => 'header',
		'title'   => esc_html__( 'On Sticky Header', 'finance' )
	);

	$options['header_searchbox'] = array(
		'type'    => 'power',
		'section' => 'header',
		'title'   => esc_html__( 'Show Search Form', 'finance' ),
		'default' => ( 'header_searchbox' )
	);

	$options['navigator_heading'] = array(
		'type'        => 'heading',
		'section'     => 'header',
		'title'       => esc_html__( 'Menu', 'finance' )
	);

	$options['enable_custom_navigator'] = array(
		'type'    => 'power',
		'section' => 'header',
		'title'   => esc_html__( 'On Custom Menu', 'finance' ),
		'children' => array('onepage_nav_script','mainnav_color','mainnav_backgroundcolor'),
		'default' => false
	);

	$options['mainnav_backgroundcolor'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Mainnav Background', 'finance' ),
		'section' => 'header',
		'default' => themesflat_get_opt( 'mainnav_backgroundcolor' )
	);

	$options['mainnav_color'] = array(
		'type'    => 'color-picker',
		'title'   => esc_html__( 'Mainnav Color', 'finance' ),
		'section' => 'header',
		'default' => themesflat_get_opt( 'mainnav_color' )
	);

	$options['onepage_nav_script'] = array(
		'type'    => 'power',
		'section' => 'header',
		'title'   => esc_html__( 'Load One Page Navigator Script ( Comming Soon New Versions )', 'finance' ),
		'default' => ( 'onepage_nav_script' )
	);
	
	

	/**
	 * Portfolio
	 */
	$options['portfolio_list_heading'] = array(
		'type'        => 'heading',
		'class'       => 'no-border',
		'section'     => 'portfolio',
		'title'       => esc_html__( 'Portfolio', 'finance' )		
	);

	$options['enable_custom_portfolio'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Enable Custom Portfolio layout', 'finance' ),
		'section' => 'portfolio',
		'children'=> array('portfolio_grid_columns','show_filter_portfolio','portfolio_archive_pagination_style','portfolio_post_perpage','portfolio_order_by','portfolio_order_direction','portfolio_pagination_style','portfolio_style'),		
		'default' => false
	);


	$options['portfolio_grid_columns'] = array(
		'type'    => 'select',
		'section' => 'portfolio',
		'title'   => esc_html__( 'Grid Columns', 'finance' ),
		'default' => themesflat_get_opt('portfolio_grid_columns'),
		'choices'   => array(
            'one-half'     => esc_html( '2 Columns', 'finance' ),
            'one-three'     => esc_html( '3 Columns', 'finance' ),
            'one-four'     => esc_html( '4 Columns', 'finance' ),
            'one-five'     => esc_html( '5 Columns', 'finance' )
        )
	);

	$options['show_filter_portfolio'] = array(
		'type'    => 'power',
		'section' => 'portfolio',
		'title'   => esc_html__( 'Show Filter', 'finance' ),
		'default' => themesflat_get_opt('show_filter_portfolio')
	);	

	$options['portfolio_style'] = array(
		'type'    => 'select',
		'title'   => esc_html__( 'Portfolio Style', 'finance' ),
		'section' => 'portfolio',
		'default' => 'grid',		
        'choices' => array(	
			'grid'          => esc_html__( 'Grid', 'finance' ),
			'no-margin'          => esc_html__( 'Grid No Margin', 'finance' ),
			'portfolio-gallery'          => esc_html__( 'Gallery', 'finance' )
		)
	);

	$options['portfolio_post_perpage'] = array(
		'type'     => 'spinner',
		'section'  => 'portfolio',
		'title'    => esc_html__( 'Posts Per Page', 'finance' ),
		'default'  => themesflat_get_opt( 'portfolio_post_perpage' )
	);

	$options['portfolio_archive_pagination_style'] = array(
		'type'    => 'select',
		'title'   => esc_html__( 'Pagination Portfolio Style', 'finance' ),
		'section' => 'portfolio',
		'default' => 'pager-numeric',
		'choices' => array(	
			'pager-numeric'          => esc_html__( 'Numeric', 'finance' ),
			'loadmore'          => esc_html__( 'loadmore', 'finance' )
		)
	);	

	$options['portfolio_order_by'] = array(
		'type'     => 'select',
		'section'  => 'portfolio',
		'title'    => esc_html__( 'Order By', 'finance' ),
		'default'  => 'date',
		'choices'  => array(
			'date'          => esc_html__( 'Date', 'finance' ),
			'ID'            => esc_html__( 'ID', 'finance' ),
			'author'        => esc_html__( 'Author', 'finance' ),
			'title'         => esc_html__( 'Title', 'finance' ),
			'modified'      => esc_html__( 'Modified', 'finance' ),
			'rand'          => esc_html__( 'Random', 'finance' ),
			'comment_count' => esc_html__( 'Comment count', 'finance' ),
			'menu_order'    => esc_html__( 'Menu order', 'finance' ),
		)
	);

	$options['portfolio_order_direction'] = array(
		'type'     => 'select',
		'section'  => 'portfolio',
		'title'    => esc_html__( 'Order Direction', 'finance' ),
		'default'  => 'DESC',
		'choices'  => array(
			'ASC'  => esc_html__( 'Ascending', 'finance' ),
			'DESC' => esc_html__( 'Descending', 'finance' )
		)
	);

	/**
	 * Blog Options
	 */
	$options['blog_list_heading'] = array(
		'type'        => 'heading',
		'class'       => 'no-border',
		'section'     => 'blog',
		'title'       => esc_html__( 'Blog', 'finance' )
	);

	$options['enable_custom_blog'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Enable Custom Blog layout', 'finance' ),
		'section' => 'blog',
		'children'=> array('blog_grid_columns','blog_archive_post_excepts','blog_archive_post_excepts_length','blog_archive_show_post_meta','blog_archive_readmore','blog_archive_readmore_text','blog_posts_per_page','blog_order_by','blog_order_direction','blog_archive_pagination_style','blog_show_content'),		
		'default' => false
	);

	$options['blog_grid_columns'] = array(
		'type'    => 'select',
		'section' => 'blog',
		'title'   => esc_html__( 'Grid Columns', 'finance' ),
		'default' => themesflat_customize_default_options2('blog_grid_columns'),
		'choices' => array(
			2 => esc_html__( '2 Columns', 'finance' ),
			3 => esc_html__( '3 Columns', 'finance' ),
			4 => esc_html__( '4 Columns', 'finance' )
		)
	);	

	$options['blog_archive_post_excepts_length'] = array(
		'type'    => 'text',
		'title'   => esc_html__( 'Post Excepts Length', 'finance' ),
		'section' => 'blog',
		'default' => themesflat_customize_default_options2('blog_archive_post_excepts_length')
	);	

	$options['blog_archive_readmore'] = array(
		'type'    => 'power',
		'title'   => esc_html__( 'Show Read More', 'finance' ),
		'section' => 'blog',
		'default' => true,
		'children' => array ('blog_archive_readmore_text')
	);

	$options['blog_archive_readmore_text'] = array(
		'type'    => 'text',
		'title'   => esc_html__( 'Read More Text', 'finance' ),
		'section' => 'blog',
		'default' =>themesflat_customize_default_options2('blog_archive_readmore_text')
	);

	$options['blog_posts_per_page'] = array(
		'type'     => 'spinner',
		'section'  => 'blog',
		'title'    => esc_html__( 'Posts Per Page', 'finance' ),
		'default'  => get_option( 'posts_per_page' )
	);

	$options['blog_archive_pagination_style'] = array(
		'type'    => 'select',
		'title'   => esc_html__( 'Pagination Style', 'finance' ),
		'section' => 'blog',
		'default' => themesflat_customize_default_options2('blog_archive_pagination_style'),	
		'choices' => array(	
			'pager'          => esc_html__( 'Pager', 'finance' ),
			'numeric'          => esc_html__( 'Numeric', 'finance' ),
			'pager-numeric'          => esc_html__( 'Pager & Numeric', 'finance' ),
			'loadmore'          => esc_html__( 'Load More', 'finance' )
		)	
	);
	
	themesflat_prepare_options($options);
	
	return $options;
}
function themesflat_prepare_options($options) {
	$themesflat_data = get_option('themesflatopts');
	$themesflatopts = array();
	if(!is_array($themesflat_data)) $themesflat_data = array();
	$children = array_map(function ($ar) {if (isset($ar['children'])){ return $ar['children'];}}, $options);
	$children = array_filter($children);
	foreach ($children as $key => $value) {
		if (is_array($value)) {
			foreach ($value as $_key => $_value) {
				$themesflatopts[$_value] = $key;
			}
		}
		else {
			$themesflatopts[$value] = $key;
		}
	}
	$themesflat_data = array_merge($themesflat_data,$themesflatopts);
	update_option('themesflatopts',$themesflat_data);
}
