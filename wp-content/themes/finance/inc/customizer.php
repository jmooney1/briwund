<?php
/**
 * finance Theme Customizer
 *
 * @package finance
 */

function themesflat_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_section( 'header_image' )->title = esc_html('Breadcrumbs & Page Title', 'finance');
    $wp_customize->get_section( 'header_image' )->priority = '22';   
    $wp_customize->get_section( 'title_tagline' )->priority = '1';
    $wp_customize->get_section( 'title_tagline' )->title = esc_html('General', 'finance');
    $wp_customize->get_section( 'colors' )->title = esc_html('Layout Type', 'finance');  

    //Heading
    class themesflat_Info extends WP_Customize_Control {
        public $type = 'heading';
        public $label = '';
        public function render_content() {
        ?>
            <h3 class="themesflat-title-control"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }    

    //Title
    class themesflat_Title_Info extends WP_Customize_Control {
        public $type = 'title';
        public $label = '';
        public function render_content() {
        ?>
            <h4><?php echo esc_html( $this->label ); ?></h4>
        <?php
        }
    }    

    //Desc
    class themesflat_Theme_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }    

    //Desc
    class themesflat_Desc_Info extends WP_Customize_Control {
        public $type = 'desc';
        public $label = '';
        public function render_content() {
        ?>
            <p class="themesflat-desc-control"><?php echo esc_html( $this->label ); ?></p>
        <?php
        }
    }       

    //  =============================
    //  // Socials              //
    //  =============================
    $wp_customize->add_section(
        'themesflat_socials',
        array(
            'title'         => esc_html('Socials', 'nah'),
            'priority'      => 2,
            'sanitize_callback' => 'themesflat_sanitize_text',
        )
    ); 


    // Social links
    foreach ( themesflat_social_array() as $s => $c ):
    $wp_customize->add_setting(
        'social_links' . $s,
        array(
            'default' => '',
            'sanitize_callback' => 'themesflat_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'social_links' . $s,
        array(
            'label' => $c,
            'section' => 'themesflat_socials',
            'type' => 'text',
            'priority' => 27
        )
    );
    endforeach;    

    //___Header___//
    $wp_customize->add_section(
        'themesflat_header',
        array(
            'title'         => esc_html('Header', 'finance'),
            'priority'      => 2,
        )
    );

    // Heading custom logo
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'custom-logo', array(
        'label' => esc_html('Custom Logo', 'finance'),
        'section' => 'themesflat_header',
        'settings' => 'themesflat_options[info]',
        'priority' => 2
        ) )
    );    

    // Desc custon logo
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc_customizer_logo', array(
        'label' => esc_html('In this section You can upload your own custom logo, change the way your logo can be displayed', 'finance'),
        'section' => 'themesflat_header',
        'settings' => 'themesflat_options[info]',
        'priority' => 3
        ) )
    );    

    //Logo
    $wp_customize->add_setting(
        'site_logo',
        array(
            'default' => THEMESFLAT_LINK . 'images/logo.png',
            'sanitize_callback' => 'esc_url_raw',
        )
    );    
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => esc_html( 'Upload your logo ', 'finance' ),
               'description'    => esc_html( 'The best size is 168x50px ( If you don\'t display logo please remove it your website display 
                Site Title default in General )', 'finance' ),
               'type'           => 'image',
               'section'        => 'themesflat_header',
               'priority'       => 5,
            )
        )
    );

    // Logo Retina
    $wp_customize->add_setting(
        'site_retina_logo',
        array(
            'default'           => THEMESFLAT_LINK . 'images/logo@2x.png',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_retina_logo',
            array(
               'label'          => esc_html( 'Upload your logo retina', 'finance' ),
               'description'    => esc_html( 'The best size is 372x90px', 'finance' ),
               'type'           => 'image',
               'section'        => 'themesflat_header',
               'priority'       => 6,
            )
        )
    );

     //Logo
    $wp_customize->add_setting(
        'site_logo_sticky',
        array(
            'default' => THEMESFLAT_LINK . 'images/logo.png',
            'sanitize_callback' => 'esc_url_raw',
        )
    );    
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo_sticky',
            array(
               'label'          => esc_html( 'Upload your logo sticky header', 'finance' ),
               'description'    => esc_html( 'The best size is 168x50px ( If you don\'t display logo please remove it your website display 
                Site Title default in General )', 'finance' ),
               'type'           => 'image',
               'section'        => 'themesflat_header',
               'priority'       => 6,
            )
        )
    );

    // Logo Retina
    $wp_customize->add_setting(
        'site_retina_logo_sticky',
        array(
            'default'           => THEMESFLAT_LINK . 'images/logo@2x.png',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_retina_logo_sticky',
            array(
               'label'          => esc_html( 'Upload your logo retina sticky header', 'finance' ),
               'description'    => esc_html( 'The best size is 372x90px', 'finance' ),
               'type'           => 'image',
               'section'        => 'themesflat_header',
               'priority'       => 6,
            )
        )
    );

    // Logo Size
    $wp_customize->add_control( new themesflat_Title_Info( $wp_customize, 'logo-size', array(
        'label' => esc_html('Logo Size', 'finance'),
        'section' => 'themesflat_header',
        'settings' => 'themesflat_options[info]',
        'priority' => 7
        ) )
    );  

    // width
    $wp_customize->add_setting(
        'logo_width',
        array(
            'default' => '175',
            'sanitize_callback' => 'themesflat_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'logo_width',
        array(
            'label' => esc_html( 'Width (px)', 'finance' ),
            'section' => 'themesflat_header',
            'type' => 'text',
            'priority' => 8
        )
    );  

    // Height
    $wp_customize->add_setting(
        'logo_height',
        array(
            'default' => '50',
            'sanitize_callback' => 'themesflat_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'logo_height',
        array(
            'label' => esc_html( 'Height (px)', 'finance' ),
            'section' => 'themesflat_header',
            'type' => 'text',
            'priority' => 9
        )
    );  

    // margin top
    $wp_customize->add_setting(
        'logo_margin_top',
        array(
            'default' => '21',
            'sanitize_callback' => 'themesflat_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'logo_margin_top',
        array(
            'label' => esc_html( 'Margin Top (px)', 'finance' ),
            'section' => 'themesflat_header',
            'type' => 'text',
            'priority' => 10
        )
    );  

    // Margin bottom
    $wp_customize->add_setting(
        'logo_margin_bottom',
        array(
            'default' => '21',
            'sanitize_callback' => 'themesflat_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'logo_margin_bottom',
        array(
            'label' => esc_html( 'Margin Bottom (px)', 'finance' ),
            'section' => 'themesflat_header',
            'type' => 'text',
            'priority' => 11
        )
    );  

    // Title Heading Style
    $wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'header_type', array(
        'label' => esc_html('Header Type', 'finance'),
        'section' => 'themesflat_header',
        'settings' => 'themesflat_options[info]',
        'priority' => 12
        ) )
    );  


    $wp_customize->add_setting(
        'header_style',
        array(
            'default'           => themesflat_get_opt('header_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control( new RadioImages($wp_customize,
        'header_style',
        array(
            'type'      => 'radio-images',           
            'section'   => 'themesflat_header',
            'priority'  => 14,
            'label'         => esc_html('Click the header style for your website', 'finance'),
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
        ))
    );      

    // Header Sticky
    $wp_customize->add_setting(
      'header_sticky',
        array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default_options2('header_sticky'),     
        )   
    );

    $wp_customize->add_control(
        'header_sticky',
        array(
            'type' => 'checkbox',
            'label' => esc_html('Enable sticky header', 'finance'),
            'section' => 'themesflat_header',
            'priority' => 15,
        )
    );      

    // Show search header
    $wp_customize->add_setting(
      'header_searchbox',
        array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default_options2('header_searchbox'),     
        )   
    );

    $wp_customize->add_control(
        'header_searchbox',
        array(
            'type' => 'checkbox',
            'label' => esc_html('Show search header', 'finance'),
            'section' => 'themesflat_header',
            'priority' => 16,
        )
    );      

    // Heading Top Bar 
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'top-bar', array(
        'label' => esc_html('Top Bar', 'finance'),
        'section' => 'themesflat_header',
        'settings' => 'themesflat_options[info]',
        'priority' => 16
        ) )
    );    

    // Desc Top Bar 
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc', array(
        'label' => esc_html('Turn on/off the top bar', 'finance'),
        'section' => 'themesflat_header',
        'settings' => 'themesflat_options[info]',
        'priority' => 17
        ) )
    );  

    // Top bar
    $wp_customize->add_setting(
      'topbar_enabled',
        array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default_options2('topbar_enabled'),     
        )   
    );

    $wp_customize->add_control(
        'topbar_enabled',
        array(
            'type' => 'checkbox',
            'label' => esc_html('Show Topbar', 'finance'),
            'section' => 'themesflat_header',
            'priority' => 18,
        )
    );      

    // Enable Socials Top
    $wp_customize->add_setting(
      'enable_social_link',
        array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default_options2('enable_social_link'),     
        )   
    );

    $wp_customize->add_control(
        'enable_social_link',
        array(
            'type' => 'checkbox',
            'label' => esc_html('Show Socials On Top', 'finance'),
            'section' => 'themesflat_header',
            'priority' => 19,
        )
    );      

    // Enable Content Right Top
    $wp_customize->add_setting(
      'enable_content_right_top',
        array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default_options2('enable_content_right_top'),     
        )   
    );

    $wp_customize->add_control(
        'enable_content_right_top',
        array(
            'type' => 'checkbox',
            'label' => esc_html('Show Content Right On Top', 'finance'),
            'section' => 'themesflat_header',
            'priority' => 20,
        )
    );         

    // Top Content
    $wp_customize->add_setting(
        'top_content',
        array(
            'default' => themesflat_customize_default_options2('top_content'),
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );
    $wp_customize->add_control(
        'top_content',
        array(
            'label' => esc_html( 'Content Left', 'finance' ),
            'section' => 'themesflat_header',
            'type' => 'textarea',
            'priority' => 23
        )
    );  

    // Top Content right
    $wp_customize->add_setting(
        'top_content_right',
        array(
            'default' => themesflat_customize_default_options2('top_content_right'),
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );
    $wp_customize->add_control(
        'top_content_right',
        array(
            'label' => esc_html( 'Content Right', 'finance' ),
            'section' => 'themesflat_header',
            'type' => 'textarea',
            'priority' => 24
        )
    );  

    //  =============================
    //  // Color              //
    //  ============================= 
    $wp_customize->add_panel('color_panel',array(
        'title'         => 'Color',
        'description'   => 'This is panel Description',
        'priority'      => 10,
    ));

    // ADD SECTION GENERAL
    $wp_customize->add_section('color_general',array(
        'title'         => 'General',
        'priority'      => 10,
        'panel'         => 'color_panel',
    ));

    // Heading Color Scheme
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'color_scheme', array(
        'label' => esc_html('SCHEME COLOR', 'finance'),
        'section' => 'color_general',
        'settings' => 'themesflat_options[info]',
        'priority' => 1
        ) )
    );    

    // Desc color scheme
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc_color_schemer', array(
        'label' => esc_html('Select the color that will be used for theme color.','finance'),
        'section' => 'color_general',
        'settings' => 'themesflat_options[info]',
        'priority' => 2
        ) )
    );   

    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => themesflat_customize_default_options2('primary_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'         => esc_html('Scheme color', 'finance'),
                'section'       => 'color_general',
                'settings'      => 'primary_color',
                'priority'      => 3
            )
        )
    );    

    // Body Color
    $wp_customize->add_setting(
        'body_text_color',
        array(
            'default'           => themesflat_customize_default_options2('body_text_color'),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_text_color',
            array(
                'label' => esc_html('Body Color', 'finance'),
                'section' => 'color_general',
                'priority' => 4
            )
        )
    );     

    // ADD SECTION HEADER COLOR
    $wp_customize->add_section('color_header',array(
        'title'=>'Header',
        'priority'=>11,
        'panel'=>'color_panel',
    ));

    // Title section portfolio
    $wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'topbar_color', array(
        'label' => esc_html('Top Color', 'finance'),
        'section' => 'color_header',
        'settings' => 'themesflat_options[info]',
        'priority' => 1
        ) )
    );  

    // Top bar background color
    $wp_customize->add_setting(
        'top_background_color',
        array(
            'default'           => themesflat_get_opt('top_background_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'top_background_color',
            array(
                'label'         => esc_html('Topbar Backgound', 'finance'),
                'section'       => 'color_header',
                'settings'      => 'top_background_color',
                'priority'      => 2
            )
        )
    );

    // Top bar text color
    $wp_customize->add_setting(
        'topbar_textcolor',
        array(
            'default'           => themesflat_get_opt('topbar_textcolor'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'topbar_textcolor',
            array(
                'label'         => esc_html('Topbar Text Color', 'finance'),
                'section'       => 'color_header',
                'settings'      => 'topbar_textcolor',
                'priority'      => 3
            )
        )
    );

    // MENU COLOR
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'menu_color', array(
        'label' => esc_html('MENU COLOR', 'finance'),
        'section' => 'color_header',
        'settings' => 'themesflat_options[info]',
        'priority' => 3
        ) )
    );    

    // Desc
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc_menu_color', array(
        'label' => esc_html('Select color for background menu, background submenu color menu a, color menu a:hover, background menu a:hover...','finance'),
        'section' => 'color_header',
        'settings' => 'themesflat_options[info]',
        'priority' => 4
        ) )
    );   

    // Menu Background
    $wp_customize->add_setting(
        'mainnav_backgroundcolor',
        array(
            'default'   => themesflat_customize_default_options2('mainnav_backgroundcolor'),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'mainnav_backgroundcolor',
            array(
                'label' => esc_html('Mainnav Background', 'finance'),
                'section' => 'color_header',
                'priority' => 5
            )
        )
    );   

    // Menu a color
    $wp_customize->add_setting(
        'mainnav_color',
        array(
            'default'           => themesflat_customize_default_options2('mainnav_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'mainnav_color',
            array(
                'label' => esc_html('Mainnav a color', 'finance'),
                'section' => 'color_header',
                'priority' => 6
            )
        )
    );

    // Menu a:hover color
    $wp_customize->add_setting(
        'mainnav_hover_color',
        array(
            'default'           => themesflat_customize_default_options2('mainnav_hover_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'mainnav_hover_color',
            array(
                'label' => esc_html('Mainnav a:hover color', 'finance'),
                'section' => 'color_header',
                'priority' => 7
            )
        )
    );

    // Sub menu a color
    $wp_customize->add_setting(
        'sub_nav_color',
        array(
            'default'           => themesflat_customize_default_options2('sub_nav_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sub_nav_color',
            array(
                'label' => esc_html('Sub nav a color', 'finance'),
                'section' => 'color_header',
                'priority' => 8
            )
        )
    );

    // Sub nav background
    $wp_customize->add_setting(
        'sub_nav_background',
        array(
            'default'           => themesflat_customize_default_options2('sub_nav_background'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sub_nav_background',
            array(
                'label' => esc_html('Sub nav background color', 'finance'),
                'section' => 'color_header',
                'priority' => 9
            )
        )
    );

    // Border color li sub nav
    $wp_customize->add_setting(
        'border_clor_sub_nav',
        array(
            'default'           => themesflat_customize_default_options2('border_clor_sub_nav'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'border_clor_sub_nav',
            array(
                'label' => esc_html('Border color sub nav', 'finance'),
                'section' => 'color_header',
                'priority' => 10
            )
        )
    );

    // Sub nav background hover
    $wp_customize->add_setting(
        'sub_nav_background_hover',
        array(
            'default'   => themesflat_customize_default_options2('sub_nav_background_hover'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sub_nav_background_hover',
            array(
                'label' => esc_html('Sub-menu background color hover', 'finance'),
                'section' => 'color_header',
                'priority' => 11
            )
        )
    );     

    // ADD SECTION COLOR FOOTER
    $wp_customize->add_section('color_footer',array(
        'title'=>'Footer',
        'priority'=>12,
        'panel'=>'color_panel',
    ));    

     // Footer background color
    $wp_customize->add_setting(
        'footer_background_color',
        array(
            'default' => themesflat_customize_default_options2('footer_background_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_background_color',
            array(
                'label'         => esc_html('Footer Backgound', 'finance'),
                'section'       => 'color_footer',
                'settings'      => 'footer_background_color',
                'priority'      => 12
            )
        )
    );

    // Footer text color
    $wp_customize->add_setting(
        'footer_text_color',
        array(
            'default'           => themesflat_customize_default_options2('footer_text_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_text_color',
            array(
                'label'         => esc_html('Footer Text Color', 'finance'),
                'section'       => 'color_footer',
                'settings'      => 'footer_text_color',
                'priority'      => 13
            )
        )
    ); 

    // bottom background color
    $wp_customize->add_setting(
        'bottom_background_color',
        array(
            'default'           => themesflat_customize_default_options2('bottom_background_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'bottom_background_color',
            array(
                'label'         => esc_html('Bottom Backgound', 'finance'),
                'section'       => 'color_footer',
                'settings'      => 'bottom_background_color',
                'priority'      => 18
            )
        )
    );

    // Bottom text color
    $wp_customize->add_setting(
        'bottom_text_color',
        array(
            'default'           => themesflat_customize_default_options2('bottom_text_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'bottom_text_color',
            array(
                'label'         => esc_html('Bottom Text Color', 'finance'),
                'section'       => 'color_footer',
                'settings'      => 'bottom_text_color',
                'priority'      => 19
            )
        )
    );   

   //___Footer___//
    $wp_customize->add_section(
        'themesflat_footer',
        array(
            'title'         => esc_html('Footer', 'finance'),
            'priority'      => 4,
        )
    );        

    $wp_customize->remove_control('display_header_text');
    $wp_customize->remove_control('header_textcolor'); 

    // Footer widget
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'custom-widget-footer', array(
        'label' => esc_html('footer widgets', 'finance'),
        'section' => 'themesflat_footer',
        'settings' => 'themesflat_options[info]',
        'priority' => 9
        ) )
    );    

    // Desc
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc_customizer_widget_footer', array(
        'label' => esc_html('This section allow to change columns footer', 'finance'),
        'section' => 'themesflat_footer',
        'settings' => 'themesflat_options[info]',
        'priority' => 10
        ) )
    );  

    // Footer column
    $wp_customize->add_setting(
        'footer_widget_areas',
        array(
            'default'           => '3',
            'sanitize_callback' => 'themesflat_sanitize_fw',
        )
    );
    $wp_customize->add_control(
        'footer_widget_areas',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Widgets Layout', 'finance'),
            'section'   => 'themesflat_footer',
            'priority'  => 12,
            'choices'   => array(
                '3'           => esc_html__( '3 Columns', 'finance' ),
                '1'           => esc_html__( '1 Column', 'finance' ),
                '2'           => esc_html__( '2 Columns', 'finance' ),                
                '4'           => esc_html__( '4 Columns', 'finance' ),
            ),
        )
    );   

    // Footer title
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'custom-footer-content', array(
        'label' => esc_html('CUSTOM FOOTER', 'finance'),
        'section' => 'themesflat_footer',
        'settings' => 'themesflat_options[info]',
        'priority' => 14
        ) )
    );    

    // Desc
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc_customizer_footer', array(
        'label' => esc_html('You can change the copyright text, show/hide the social icons on the footer.', 'finance'),
        'section' => 'themesflat_footer',
        'settings' => 'themesflat_options[info]',
        'priority' => 15
        ) )
    );   

    // Enable Socials Links footer
    $wp_customize->add_setting (
        'socials_link_footer',
        array (
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default_options2('socials_link_footer'),     
        )
    );

    $wp_customize->add_control( 
        'socials_link_footer',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html('Enable Social links', 'finance'),
            'section'   => 'themesflat_footer',
            'priority'  => 16
        )
    );

    // On Off Footer Area
    $wp_customize->add_setting (
        'enable_footer',
        array (
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default_options2('enable_footer'),     
        )
    );

    $wp_customize->add_control( 
        'enable_footer',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html('Show Footer Area', 'finance'),
            'section'   => 'themesflat_footer',
            'priority'  => 17
        )
    );

    // Footer Content
    $wp_customize->add_setting(
        'footer_copyright',
        array(
            'default' => themesflat_get_opt('footer_copyright'),
            'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control(
        'footer_copyright',
        array(
            'label' => esc_html( 'Copyright', 'finance' ),
            'section' => 'themesflat_footer',
            'type' => 'textarea',
            'priority' => 18
        )
    );      
   
    // Section Blog
    $wp_customize->add_section(
        'blog_options',
        array(
            'title' => esc_html('Post', 'finance'),
            'priority' => 13,
        )
    );

    // Title section blog
    $wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'bloglist', array(
        'label' => esc_html('Blog', 'finance'),
        'section' => 'blog_options',
        'settings' => 'themesflat_options[info]',
        'priority' => 1
        ) )
    );       

    $wp_customize->add_setting(
        'blog_layout',
        array(
            'default'           => themesflat_customize_default_options2('blog_layout'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'blog_layout',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Blog Layout Position', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 8,
            'choices'   => array(
                'sidebar-right'           => esc_html__( 'Sidebar Right', 'finance' ),
                'sidebar-left'           => esc_html__( 'Sidebar Left', 'finance' ),
                'fullwidth'           => esc_html__( 'Full Width', 'finance' )
            ),
        )
    );    

    $wp_customize->add_setting (
        'blog_sidebar_list',
        array(
            'default'           => themesflat_customize_default_options2('blog_sidebar_list'),
            'sanitize_callback' => 'esc_html',
        )
    );

    $wp_customize->add_control( new DropdownSidebars($wp_customize,
        'blog_sidebar_list',
        array(
            'type'      => 'radio-images',           
            'section'   => 'blog_options',
            'priority'  => 3,
            'label'         => esc_html('Select Sidebar Position', 'finance'),
            
        ))
    );

    // Style
    $wp_customize->add_setting(
        'blog_style',
        array(
            'default'           => themesflat_customize_default_options2('blog_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'blog_style',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Blog Style', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 4,
            'choices'   => array(
                'blog_list'           => esc_html__( 'List Style', 'finance' ),
                'blog_grid'           => esc_html__( 'Grid Style', 'finance' )
            ),
        )
    );    

    // Style grid columns
    $wp_customize->add_setting(
        'blog_grid_columns',
        array(
            'default'           => themesflat_customize_default_options2('blog_grid_columns'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'blog_grid_columns',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Blog Style', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 5,
            'choices'   => array(
                'two_columns'           => esc_html__( '2 Columns', 'finance' ),
                'three_columns'           => esc_html__( '3 Columns', 'finance' ),
                'four_columns'           => esc_html__( '4 Columns', 'finance' )
            ),
        )
    );    

    // Excerpt
    $wp_customize->add_setting(
        'blog_archive_post_excepts_length',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '51',
        )       
    );
    $wp_customize->add_control( 'blog_archive_post_excepts_length', array(
        'type'        => 'number',
        'priority'    => 6,
        'section'     => 'blog_options',
        'label'       => esc_html('Post Excepts Length', 'finance'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 200,
            'step'  => 5
        ),
    ) );

    // Show Post Meta
    $wp_customize->add_setting(
        'blog_archive_show_post_meta',
          array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default_options2('blog_archive_show_post_meta'),     
        )   
    );

    $wp_customize->add_control(
        'blog_archive_show_post_meta',
        array(
            'type' => 'checkbox',
            'label' => esc_html__('Show Post Meta', 'finance'),
            'section' => 'blog_options',
            'priority' => 7,
        )
    );    

    // Show Read More
    $wp_customize->add_setting(
        'blog_archive_readmore',
          array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => 0,     
        )   
    );

    $wp_customize->add_control(
        'blog_archive_readmore',
        array(
            'type' => 'checkbox',
            'label' => esc_html__('Show Read More', 'finance'),
            'section' => 'blog_options',
            'priority' => 8,
        )
    ); 

    // Read More Text
    $wp_customize->add_setting (
        'blog_archive_readmore_text',
        array(
            'default' => themesflat_customize_default_options2('blog_archive_readmore_text'),
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'blog_archive_readmore_text',
        array(
            'type'      => 'text',
            'label'     => esc_html('Read More Text', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 9
        )
    );

    // Pagination
    $wp_customize->add_setting(
        'blog_archive_pagination_style',
        array(
            'default'           => themesflat_customize_default_options2('blog_archive_pagination_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'blog_archive_pagination_style',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Pagination Style', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 10,
            'choices'   => array(
                'pager'           => esc_html__( 'Pager', 'finance' ),
                'numeric'           => esc_html__( 'Numeric', 'finance' ),
                'pager-numeric'           => esc_html__( 'Pager & Numeric', 'finance' ),
                'loadmore'           => esc_html__( 'Load More', 'finance' )
            ),
        )
    );    

    // Header Blog Single    
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'blogsingle', array(
        'label' => esc_html('Blog Single', 'finance'),
        'section' => 'blog_options',
        'settings' => 'themesflat_options[info]',
        'priority' => 11
        ) )
    );    

    // Desc Blog Single
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc_customizer_blogsingle', array(
        'label' => esc_html('Also, you can change the Type for blog single to make your site unique.','finance'),
        'section' => 'blog_options',
        'settings' => 'themesflat_options[info]',
        'priority' => 12
        ) )
    );   

    // Show Post Navigator
    $wp_customize->add_setting (
        'show_post_navigator',
        array (
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => 1,     
        )
    );

    $wp_customize->add_control( 
        'show_post_navigator',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html('Show Post Navigator', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 13
        )
    );    

    // Show Author Box
    $wp_customize->add_setting (
        'show_author_box',
        array (
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => 1,     
        )
    );

    $wp_customize->add_control(
        'show_author_box',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html('Show Author Meta', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 14
        )
    );

    // Show Related Posts
    $wp_customize->add_setting (
        'show_related_post',
        array (
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => 0,     
        )
    );

    $wp_customize->add_control(
        'show_related_post',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html('Show Related Posts', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 15
        )
    );

    //Related Posts Style
    $wp_customize->add_setting(
        'related_post_style',
        array(
            'default'           => themesflat_customize_default_options2('related_post_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'related_post_style',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Related Posts Type', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 16,
            'choices'   => array(
                'list'           => esc_html__( 'Simple List', 'finance' ),
                'grid'           => esc_html__( 'Grid', 'finance' )
            ),
        )
    ); 

    // Gird columns Related Posts
    $wp_customize->add_setting(
        'grid_columns_post_related',
        array(
            'default'           => 3,
            'sanitize_callback' => 'themesflat_sanitize_grid_post_related',
        )
    );

    $wp_customize->add_control(
        'grid_columns_post_related',
        array(
            'type'      => 'select',           
            'section'   => 'blog_options',
            'priority'  => 17,
            'label'     => esc_html('Related Posts Columns', 'finance'),
            'choices'   => array(                
                2     => esc_html( '2 Columns', 'finance' ),
                3     => esc_html( '3 Columns', 'finance' ),
                4     => esc_html( '4 Columns', 'finance' ),                
            )
        )
    );

    // Number Of Related Posts
    $wp_customize->add_setting (
        'number_related_post',
        array(
            'default' => esc_html('3', 'finance'),
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'number_related_post',
        array(
            'type'      => 'text',
            'label'     => esc_html('Related Posts Number', 'finance'),
            'section'   => 'blog_options',
            'priority'  => 18
        )
    );

    // Section portfolio
    $wp_customize->add_section(
        'portfolio_options',
        array(
            'title' => esc_html('Portfolio', 'finance'),
            'priority' => 14,
        )
    );

    // Title section portfolio
    $wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'portfolio', array(
        'label' => esc_html('Portfolio', 'finance'),
        'section' => 'portfolio_options',
        'settings' => 'themesflat_options[info]',
        'priority' => 1
        ) )
    );  
   
    // Show filter portfolio
    $wp_customize->add_setting (
        'show_filter_portfolio',
        array (
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_customize_default_options2('show_filter_portfolio'),     
        )
    );

    $wp_customize->add_control(
        'show_filter_portfolio',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html('Show filter ', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 3
        )
    );   

    // Portfolios Style
    $wp_customize->add_setting(
        'portfolio_style',
        array(
            'default'           => 'grid',
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'portfolio_style',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Portfolio Type', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 4,
            'choices'   => array(
                'grid'           => esc_html__( 'Grid', 'finance' ),
                'no-margin'           => esc_html__( 'Grid No Margin', 'finance' ),
                'portfolio-gallery'   => esc_html__( 'Gallery', 'finance' )
            ),
        )
    );    

    // Gird columns portfolio
    $wp_customize->add_setting(
        'portfolio_grid_columns',
        array(
            'default'           => themesflat_get_opt('portfolio_grid_columns'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'portfolio_grid_columns',
        array(
            'type'      => 'select',           
            'section'   => 'portfolio_options',
            'priority'  => 5,
            'label'     => esc_html('Grid Columns', 'finance'),
            'choices'   => array(
                'one-half'     => esc_html( '2 Columns', 'finance' ),
                'one-three'     => esc_html( '3 Columns', 'finance' ),
                'one-four'     => esc_html( '4 Columns', 'finance' ),
                'one-five'     => esc_html( '5 Columns', 'finance' )
            )
        )
    );

    // Pagination portfolio
    $wp_customize->add_setting(
        'portfolio_archive_pagination_style',
        array(
            'default'           => themesflat_get_opt('portfolio_archive_pagination_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'portfolio_archive_pagination_style',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Pagination Type', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 6,
            'choices'   => array(
                'pager-numeric'           => esc_html__( 'Pager & Numeric', 'finance' ),
                'loadmore'           => esc_html__( 'Load More', 'finance' )
            ),
        )
    );        

    // post per page portfolio
    $wp_customize->add_setting (
        'portfolio_post_perpage',
        array(
            'default' => esc_html('9', 'finance'),
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'portfolio_post_perpage',
        array(
            'type'      => 'text',
            'label'     => esc_html('Posts Per Page', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 7
        )
    );

    // Order By portfolio
    $wp_customize->add_setting(
        'portfolio_order_by',
        array(
            'default' => 'date',
            'sanitize_callback' => 'themesflat_sanitize_portfolio_order',
        )
    );

    $wp_customize->add_control(
        'portfolio_order_by',
        array(
            'type'      => 'select',
            'label'     => esc_html('Order By', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 8,
            'choices' => array(
                'date'          => esc_html( 'Date', 'finance' ),
                'id'            => esc_html( 'Id', 'finance' ),
                'author'        => esc_html( 'Author', 'finance' ),
                'title'         => esc_html( 'Title', 'finance' ),
                'modified'      => esc_html( 'Modified', 'finance' ),
                'comment_count' => esc_html( 'Comment Count', 'finance' ),
                'menu_order'    => esc_html( 'Menu Order', 'finance' )
            )        
        )
    ); 

    // Order Direction portfolio
    $wp_customize->add_setting(
        'portfolio_order_direction',
        array(
            'default' => 'ASC',
            'sanitize_callback' => 'themesflat_sanitize_portfolio_order_direction',
        )
    );

    $wp_customize->add_control(
        'portfolio_order_direction',
        array(
            'type'      => 'select',
            'label'     => esc_html('Order Direction', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 9,
            'choices' => array(
                'DESC' => esc_html( 'Descending', 'finance' ),
                'ASC'  => esc_html( 'Assending', 'finance' )
            )        
        )
    );     
    
    // Title section portfolio Single
    $wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'portfolio_single', array(
        'label' => esc_html('Portfolio Single', 'finance'),
        'section' => 'portfolio_options',
        'settings' => 'themesflat_options[info]',
        'priority' => 10
        ) )
    );    

    // Show Post Navigator portfolio
    $wp_customize->add_setting (
        'portfolio_show_post_navigator',
        array (
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => 1,     
        )
    );

    $wp_customize->add_control( 
        'portfolio_show_post_navigator',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html('Show Single Navigator', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 12
        )
    );

    // Show Related Portfolios
    $wp_customize->add_setting (
        'show_related_portfolio',
        array (
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => 1,     
        )
    );

    $wp_customize->add_control( 
        'show_related_portfolio',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html('Show Related Portfolios', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 13
        )
    );

    // Title widget reated
    $wp_customize->add_setting (
        'title_related_portfolio',
        array(
            'default' => esc_html('Related Portfolio', 'finance'),
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'title_related_portfolio',
        array(
            'type'      => 'text',
            'label'     => esc_html('Related Portfolio Title', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 14
        )
    );

    // Related Portfolios Style
    $wp_customize->add_setting(
        'related_portfolio_style',
        array(
            'default'           => 'grid',
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'related_portfolio_style',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Related Portfolio Type', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 15,
            'choices'   => array(
                'grid'           => esc_html__( 'Grid', 'finance' ),
                'no-margin'           => esc_html__( 'Grid No Margin', 'finance' ),
                'portfolio-gallery'           => esc_html__( 'Gallery', 'finance' ),
            ),
        )
    ); 

    // Gird columns portfolio related
    $wp_customize->add_setting(
        'grid_columns_portfolio_related',
        array(
            'default'           => 'one-half',
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'grid_columns_portfolio_related',
        array(
            'type'      => 'select',           
            'section'   => 'portfolio_options',
            'priority'  => 16,
            'label'     => esc_html('Related Portfolio Columns', 'finance'),
            'choices'   => array(
                'one-half'     => esc_html( '2 Columns', 'finance' ),
                'one-three'     => esc_html( '3 Columns', 'finance' ),
                'one-four'     => esc_html( '4 Columns', 'finance' ),
                'one-five'     => esc_html( '5 Columns', 'finance' )
            )
        )
    );
    
    // Number Of Related Portfolios
    $wp_customize->add_setting (
        'number_related_portfolio',
        array(
            'default' => 4,
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'number_related_portfolio',
        array(
            'type'      => 'text',
            'label'     => esc_html('Related Portfolio Number', 'finance'),
            'section'   => 'portfolio_options',
            'priority'  => 17
        )
    );
    
    // Section Typography
    $wp_customize->add_section(
        'themesflat_typography',
        array(
            'title' => esc_html('Typography', 'finance'),
            'priority' => 6,            
        )
    );    

    // Body font
    $wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'body_fonts', array(
        'label' => esc_html('Body fonts', 'finance'),
        'section' => 'themesflat_typography',
        'settings' => 'themesflat_options[info]',
        'priority' => 1
        ) )
    );    

    // Body fonts
    $wp_customize->add_setting(
        'body_font_name',
        array(
            'default' => themesflat_customize_default_options2('body_font_name'),
            'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'body_font_name',
        array(
            'label' => esc_html( 'Font name/style/sets', 'finance' ),
            'section' => 'themesflat_typography',
            'type' => 'typography',
            'fields' => array('family','style','line_height','size'),
            'priority' => 4
        ))
    );

    // Headings fonts
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'custom-heading-font', array(
        'label' => esc_html('Headings fonts', 'finance'),
        'section' => 'themesflat_typography',
        'settings' => 'themesflat_options[info]',
        'priority' => 8
        ) )
    );    

    // Desc font
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc_customizer_heading-font', array(
        'label' => esc_html('You can modify the font options for your headings. h1, h2, h3, h4, ...', 'finance'),
        'section' => 'themesflat_typography',
        'settings' => 'themesflat_options[info]',
        'priority' => 9
        ) )
    );   

    $wp_customize->add_setting(
        'headings_font_name',
        array(
            'default' => themesflat_customize_default_options2('headings_font_name'),
            'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'headings_font_name',
        array(
            'label' => esc_html( 'Font name/style/sets', 'finance' ),
            'section' => 'themesflat_typography',
            'type' => 'typography',
            'fields' => array('family','style'),
            'priority' => 11
        ))
    );

    // H1 size
    $wp_customize->add_setting(
        'h1_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => themesflat_customize_default_options2('h1_size'),
        )       
    );
    $wp_customize->add_control( 'h1_size', array(
        'type'        => 'number',
        'priority'    => 13,
        'section'     => 'themesflat_typography',
        'label'       => esc_html('H1 font size (px)', 'finance'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // H2 size
    $wp_customize->add_setting(
        'h2_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           =>  themesflat_customize_default_options2('h2_size'),
        )       
    );
    $wp_customize->add_control( 'h2_size', array(
        'type'        => 'number',
        'priority'    => 14,
        'section'     => 'themesflat_typography',
        'label'       => esc_html('H2 font size (px)', 'finance'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // H3 size
    $wp_customize->add_setting(
        'h3_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => themesflat_customize_default_options2('h3_size'),
        )       
    );
    $wp_customize->add_control( 'h3_size', array(
        'type'        => 'number',
        'priority'    => 15,
        'section'     => 'themesflat_typography',
        'label'       => esc_html('H3 font size (px)', 'finance'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // H4 size
    $wp_customize->add_setting(
        'h4_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           =>  themesflat_customize_default_options2('h4_size'),
        )       
    );
    $wp_customize->add_control( 'h4_size', array(
        'type'        => 'number',
        'priority'    => 16,
        'section'     => 'themesflat_typography',
        'label'       => esc_html('H4 font size (px)', 'finance'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // H5 size
    $wp_customize->add_setting(
        'h5_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           =>  themesflat_customize_default_options2('h5_size'),
        )       
    );
    $wp_customize->add_control( 'h5_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'themesflat_typography',
        'label'       => esc_html('H5 font size (px)', 'finance'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // H6 size
    $wp_customize->add_setting(
        'h6_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           =>  themesflat_customize_default_options2('h6_size'),
        )       
    );
    $wp_customize->add_control( 'h6_size', array(
        'type'        => 'number',
        'priority'    => 18,
        'section'     => 'themesflat_typography',
        'label'       => esc_html('H6 font size (px)', 'finance'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    // Heading Menu fonts
    $wp_customize->add_setting('themesflat_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'menu_fonts', array(
        'label' => esc_html('Menu fonts', 'finance'),
        'section' => 'themesflat_typography',
        'settings' => 'themesflat_options[info]',
        'priority' => 19
        ) )
    );

    $wp_customize->add_setting(
        'menu_font_name',
        array(
            'default' => themesflat_customize_default_options2('menu_font_name'),
                'sanitize_callback' => 'esc_html',
        )
    );
    $wp_customize->add_control( new Typography($wp_customize,
        'menu_font_name',
        array(
            'label' => esc_html( 'Font name/style/sets', 'finance' ),
            'section' => 'themesflat_typography',
            'type' => 'typography',
            'fields' => array('family','style','size','line_height'),
            'priority' => 20
        ))
    );

    /* Page title Style */
    // Title section page tite
    $wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'page_title', array(
        'label' => esc_html('Page Title Tyle', 'finance'),
        'section' => 'header_image',
        'settings' => 'themesflat_options[info]',
        'priority' => 21
        ) )
    );  


    $wp_customize->add_setting(
        'pagetitle_style',
        array(
            'default'           => themesflat_get_opt('pagetitle_style'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control( new RadioImages($wp_customize,
        'pagetitle_style',
        array(
            'type'      => 'radio-images',           
            'section'   => 'header_image',
            'priority'  => 22,
            'label'         => esc_html('Click the page title type for your website', 'finance'),
            'choices'   => array (
                'pagetitle_style_1'=> array (
                   'tooltip'   => esc_html('Page Title Style1','finance'),
                   'src'       => THEMESFLAT_LINK . 'images/controls/breadcrumbs_01.jpg'
                ) ,
                'pagetitle_style_2'=>  array (
                   'tooltip'   => esc_html('Page Title Style2','finance'),
                   'src'       => THEMESFLAT_LINK . 'images/controls/breadcrumbs_02.jpg'
                ) ,
                'pagetitle_style_3'=>  array (
                   'tooltip'   => esc_html('Page Title Style3','finance'),
                    'src'      => THEMESFLAT_LINK . 'images/controls/breadcrumbs_03.jpg'
                ),        
            ),
        ))
    );  

    // Enable Paget title overlay
    $wp_customize->add_setting(
      'page_title_overlay',
        array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_get_opt('page_title_overlay'),     
        )   
    );

    $wp_customize->add_control( 
        'page_title_overlay',
        array(
            'type' => 'checkbox',
            'label' => esc_html('Enable Page Title Overlay', 'finance'),
            'section' => 'header_image',
            'priority' => 23,
        )
    );    

    // Enable Paget title heading
    $wp_customize->add_setting(
      'page_title_heading',
        array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => themesflat_get_opt('page_title_heading'),     
        )   
    );

    $wp_customize->add_control( 
        'page_title_heading',
        array(
            'type' => 'checkbox',
            'label' => esc_html('Enable Page Title Heading', 'finance'),
            'section' => 'header_image',
            'priority' => 23,
        )
    );    

    /* Padding Down/Up Page title */
    $wp_customize->add_setting (
        'pagetitle_padding',
        array(
            'default' => themesflat_get_opt('pagetitle_padding'),
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'pagetitle_padding',
        array(
            'type'      => 'text',
            'label'     => esc_html('Padding Down/Up ( Px )', 'finance'),
            'section'   => 'header_image',
            'priority'  => 22
        )
    );     

    // Page Title background color
    $wp_customize->add_setting(
        'pagetitle_background_color',
        array(
            'default' => themesflat_customize_default_options2('pagetitle_background_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'pagetitle_background_color',
            array(
                'label'         => esc_html('Backgound', 'finance'),
                'section'       => 'header_image',
                'settings'      => 'pagetitle_background_color',
                'priority'      => 23
            )
        )
    );

    // Page Title text color
    $wp_customize->add_setting(
        'pagetitle_text_color',
        array(
            'default'           => themesflat_customize_default_options2('pagetitle_text_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'pagetitle_text_color',
            array(
                'label'         => esc_html('Text Color', 'finance'),
                'section'       => 'header_image',
                'settings'      => 'pagetitle_text_color',
                'priority'      => 24
            )
        )
    ); 

    // Page Title link color
    $wp_customize->add_setting(
        'pagetitle_link_color',
        array(
            'default'           => themesflat_customize_default_options2('pagetitle_link_color'),
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'pagetitle_link_color',
            array(
                'label'         => esc_html('Link Color', 'finance'),
                'section'       => 'header_image',
                'settings'      => 'pagetitle_link_color',
                'priority'      => 25
            )
        )
    ); 

    // Heading Color Scheme
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'color_scheme', array(
        'label' => esc_html('BREADCRUMB', 'finance'),
        'section' => 'header_image',
        'settings' => 'themesflat_options[info]',
        'priority' => 25
        ) )
    );    

    // Desc color scheme
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc_color_schemer', array(
        'label' => esc_html('Change settings for the breadcrumb.','finance'),
        'section' => 'header_image',
        'settings' => 'themesflat_options[info]',
        'priority' => 26
        ) )
    );   

    // Breadcrumb
    $wp_customize->add_setting(
      'breadcrumb_enabled',
        array(
            'sanitize_callback' => 'themesflat_sanitize_checkbox',
            'default' => 1,     
        )   
    );

    $wp_customize->add_control( 
        'breadcrumb_enabled',
        array(
            'type' => 'checkbox',
            'label' => esc_html('Enable Breadcrumb', 'finance'),
            'section' => 'header_image',
            'priority' => 27,
        )
    );    

    $wp_customize->add_setting (
        'breadcrumb_prefix',
        array(
            'default' => esc_html('You are here:', 'finance'),
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'breadcrumb_prefix',
        array(
            'type'      => 'text',
            'label'     => esc_html('Breadcrumb Prefix', 'finance'),
            'section'   => 'header_image',
            'priority'  => 28
        )
    );  

    $wp_customize->add_setting (
        'breadcrumb_separator',
        array(
            'default' => esc_html('>', 'finance'),
            'sanitize_callback' => 'themesflat_sanitize_text'
        )
    );

    $wp_customize->add_control(
        'breadcrumb_separator',
        array(
            'type'      => 'text',
            'label'     => esc_html('Breadcrumb Separator', 'finance'),
            'section'   => 'header_image',
            'priority'  => 29
        )
    );   

    // Layout & Style
    $wp_customize->add_setting(
        'layout_version',
        array(
            'default'           => themesflat_customize_default_options2('layout_version'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'layout_version',
        array(
            'type'      => 'select',
            'label'     => esc_html__('Widgets Layout', 'finance'),
            'section'   => 'colors',
            'priority'  => 7,
            'choices'   => array(
                'wide'           => esc_html__( 'Wide', 'finance' ),
                'boxed'           => esc_html__( 'Boxed', 'finance' )
            ),
        )
    );   

    // Sidebars
    $wp_customize->add_control( new themesflat_Info( $wp_customize, 'layout_body', array(
        'label' => esc_html('SIDEBAR', 'finance'),
        'section' => 'colors',
        'settings' => 'themesflat_options[info]',
        'priority' => 10
        ) )
    );    

    // Desc
    $wp_customize->add_control( new themesflat_Desc_Info( $wp_customize, 'desc_color_scheme', array(
        'label' => esc_html('Select the position of sidebar that you wish to display.','finance'),
        'section' => 'colors',
        'settings' => 'themesflat_options[info]',
        'priority' => 11
        ) )
    );   

     $wp_customize->add_setting(
        'page_layout',
        array(
            'default'           => themesflat_customize_default_options2('page_layout'),
            'sanitize_callback' => 'esc_attr',
        )
    );

    $wp_customize->add_control(
        'page_layout',
        array(
            'type'      => 'select',
            'label'     => esc_html__('List Sidebar Position', 'finance'),
            'section'   => 'colors',
            'priority'  => 12,
            'choices'   => array(
                'sidebar-right'           => esc_html__( 'Sidebar Right', 'finance' ),
                'sidebar-left'           => esc_html__( 'Sidebar Left', 'finance' )
            ),
        )
    );     

    $wp_customize->add_setting (
        'page_sidebar_list',
        array(
            'default'           => themesflat_customize_default_options2('page_sidebar_list'),
            'sanitize_callback' => 'esc_html',
        )
    );

    $wp_customize->add_control( new DropdownSidebars($wp_customize,
        'page_sidebar_list',
        array(
            'type'      => 'radio-images',           
            'section'   => 'colors',
            'priority'  => 13,
            'label'         => esc_html('List Sidebar Position', 'finance'),            
        ))
    );   

    
}
add_action( 'customize_register', 'themesflat_customize_register' );

/**
 * Sanitize
 */

// Text
function themesflat_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

// Background size
function themesflat_sanitize_bg_size( $input ) {
    $valid = array(
        'cover'     => esc_html('Cover', 'finance'),
        'contain'   => esc_html('Contain', 'finance'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Blog Layout
function themesflat_sanitize_blog( $input ) {
    $valid = array(
        'sidebar-right'    => esc_html( 'Sidebar right', 'finance' ),
        'sidebar-left'    => esc_html( 'Sidebar left', 'finance' ),
        'fullwidth'  => esc_html( 'Full width (no sidebar)', 'finance' )

    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// themesflat_sanitize_pagination
function themesflat_sanitize_pagination ( $input ) {
    $valid = array(
        'pager' => esc_html__('Pager', 'finance'),
        'numeric' => esc_html__('Numeric', 'finance'),
        'page_numeric' => esc_html__('Pager & Numeric', 'finance')                
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// themesflat_sanitize_pagination
function themesflat_sanitize_layout_version ( $input ) {
    $valid = array(
        'boxed' => esc_html__('Boxed', 'finance'),
        'wide' => esc_html__('Wide', 'finance')          
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// themesflat_sanitize_related_post
function themesflat_sanitize_related_post ( $input ) {
    $valid = array(
        'simple_list' => esc_html__('Simple List', 'finance'),
        'grid' => esc_html__('Grid', 'finance')        
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Footer widget areas
function themesflat_sanitize_fw( $input ) {
    $valid = array(
        '0' => esc_html__('footer_default', 'finance'),
        '1' => esc_html__('One', 'finance'),
        '2' => esc_html__('Two', 'finance'),
        '3' => esc_html__('Three', 'finance'),
        '4' => esc_html__('Four', 'finance')
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Header style sanitize
function themesflat_sanitize_headerstyle( $input ) {
    $valid = themesflat_predefined_header_styles();
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Checkboxes
function themesflat_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

// Pictor_sanitize_related_portfolio
function themesflat_sanitize_related_portfolio( $input ) {
    $valid = array(
        'grid'                 => esc_html( 'Grid', 'finance' ),
        'grid_masonry'         => esc_html( 'Grid Masonry', 'finance' ),
        'grid_nomargin'        => esc_html( 'Grid Masonry No Margin', 'finance' ),
        'carosuel'             => esc_html( 'Carosuel', 'finance' ),
        'carosuel_nomargin'    => esc_html( 'Carosuel No Margin', 'finance' )       
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Pictor_sanitize_portfolio_pagination
function themesflat_sanitize_portfolio_pagination( $input ) {
    $valid = array(
        'page_numeric'         => esc_html( 'Pager & Numeric', 'finance' ),
        'load_more'         => esc_html( 'Load More', 'finance' )     
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Pictor_sanitize_portfolio_order
function themesflat_sanitize_portfolio_order( $input ) {
    $valid = array(
        'date'          => esc_html( 'Date', 'finance' ),
        'id'            => esc_html( 'Id', 'finance' ),
        'author'        => esc_html( 'Author', 'finance' ),
        'title'         => esc_html( 'Title', 'finance' ),
        'modified'      => esc_html( 'Modified', 'finance' ),
        'comment_count' => esc_html( 'Comment Count', 'finance' ),
        'menu_order'    => esc_html( 'Menu Order', 'finance' )     
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Pictor_sanitize_portfolio_order_direction
function themesflat_sanitize_portfolio_order_direction( $input ) {
    $valid = array(
        'DESC' => esc_html( 'Descending', 'finance' ),
        'ASC'  => esc_html( 'Assending', 'finance' )       
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Pictor_sanitize_grid_portfolio
function themesflat_sanitize_grid_portfolio( $input ) {
    $valid = array(
        'portfolio-two-columns'     => esc_html( '2 Columns', 'finance' ),
        'portfolio-three-columns'     => esc_html( '3 Columns', 'finance' ),
        'portfolio-four-columns'     => esc_html( '4 Columns', 'finance' ),
        'portfolio-five-columns'     => esc_html( '5 Columns', 'finance' )
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// themesflat_sanitize_grid_portfolio_related
function themesflat_sanitize_grid_portfolio_related( $input ) {
    $valid = array(
        'portfolio-one-columns'     => esc_html( '1 Columns', 'finance' ),
        'portfolio-two-columns'     => esc_html( '2 Columns', 'finance' ),
        'portfolio-three-columns'     => esc_html( '3 Columns', 'finance' ),
        'portfolio-four-columns'     => esc_html( '4 Columns', 'finance' ),
        'portfolio-five-columns'     => esc_html( '5 Columns', 'finance' )
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Pictor_sanitize_grid_post_related
function themesflat_sanitize_grid_post_related( $input ) {
    $valid = array(        
        2     => esc_html( '2 Columns', 'finance' ),
        3   => esc_html( '3 Columns', 'finance' ),
        4    => esc_html( '4 Columns', 'finance' ),        
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// themesflat_sanitize_layout_product
function themesflat_sanitize_layout_product( $input ) {
    $valid = array(        
        'fullwidth'         => esc_html( 'No Sidebar', 'finance' ),
        'sidebar-right'           => esc_html( 'Sidebar Right', 'finance' ),
        'sidebar-left'         => esc_html( 'Sidebar Left', 'finance' )
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

function themesflat_load_customizer_style() {   
    wp_register_style( 'customizer_css', THEMESFLAT_LINK .'css/admin/customizer.css', false, '1.0.0' );
    wp_register_style( 'font_awesome', THEMESFLAT_LINK .'css/font-awesome.css', false, '1.0.0' );   
    wp_enqueue_style( 'customizer_css' );
    wp_enqueue_style( 'font_awesome' );     
    wp_enqueue_script( 
          'choosen',            
          THEMESFLAT_LINK .'js/admin/3rd/chosen.jquery.min.js',
          array( 'jquery'),    
          '',                      
          true                    
    );
    wp_enqueue_script( 
          'customizer_js',            
          THEMESFLAT_LINK .'js/admin/customizer.js',
          array( 'jquery','customize-preview' ),
          '',                       
          true                     
    );

    wp_enqueue_style( 'choosen', THEMESFLAT_LINK . 'css/chosen.css', array(), true );

}

add_action( 'admin_enqueue_scripts', 'themesflat_load_customizer_style' );
