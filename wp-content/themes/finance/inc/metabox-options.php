<?php
add_action( 'admin_init', 'themesflat_page_options_init' );

function themesflat_page_options_init() {   

    new themesflat_meta_boxes(array(
    	// Portfolio
    	'id'	 => 'portfolio-options',
		'label'  => esc_html__( 'Causes Settings', 'finance' ),
		'post_types'  => 'portfolios',
	    'context'     => 'normal',
        'priority'    => 'default',
		'sections' => array(
            'general'   => array( 'title' => esc_html__( 'General', 'finance' ) ),
			),
		'options' => themesflat_portfolio_options_fields()
	));	

	new themesflat_meta_boxes(array( 
        'id'          => 'page-options',
        'label'       => esc_html__( 'Page Options', 'finance' ),
        'post_types'  => 'page',
        'context'     => 'normal',
        'priority'    => 'default',       

        'sections' => array(
            'general'   => array( 'title' => esc_html__( 'General', 'finance' ) ),
            'header'    => array( 'title' => esc_html__( 'Header Options', 'finance' ) ),            
            'portfolio' => array( 'title' => esc_html__( 'Portfolio Page', 'finance' ) ),
            'blog'      => array( 'title' => esc_html__( 'Blog Post', 'finance' ) )
        ),

        'options' => themesflat_page_options_fields()
    ) );

    new themesflat_meta_boxes(array(
		// event
		'id' 	=> 'blog-options',
		'label'	=> esc_html__( 'Post settings', 'finance' ),
		'post_types'	=> 'post',
		'context'     => 'normal',
        'priority'    => 'default',
		'sections' => array(
            'blog'   => array( 'title' => esc_html__( 'Blog', 'finance' ) ),
			),
		'options' => themesflat_post_options_fields()
	));
}

add_action( 'admin_enqueue_scripts', 'themesflat_admin_script_meta_box' );

/**
 * Enqueue script for handling actions with meta boxes
 *
 * @return void
 * @since 1.0
 */
function themesflat_admin_script_meta_box() {
	$screen = get_current_screen();	
	wp_enqueue_script( 'themesflat-meta-box', THEMESFLAT_LINK . 'js/admin/meta-boxes.js', array('customize-preview'), '1.1' );
}

function themesflat_load_custom_wp_admin_style() {
    wp_register_style( 'custom_wp_admin_css', THEMESFLAT_LINK .'js/admin/style.css', false, '1.0.0' );       
    wp_enqueue_style( 'custom_wp_admin_css' );
}

add_action( 'admin_enqueue_scripts', 'themesflat_load_custom_wp_admin_style' );
