<?php
// Register action to declare required plugins
add_action( 'tgmpa_register', 'themesflat_recommend_plugin' );
function themesflat_recommend_plugin() {
 
    $plugins = array(
        array(
           'name'               => 'ThemesFlat',
           'slug'               => 'themesflat',
           'source'             => THEMESFLAT_DIR . 'inc/plugins/themesflat.zip',
           'required'           => true,           
        ),        

        array(
           'name'               => 'Revslider',
           'slug'               => 'revslider',
           'source'             => THEMESFLAT_DIR . 'inc/plugins/revslider.zip',
           'version'            => '5.4.6.3.1',
           'required'           => true,           
        ),

        array(
            'name'               => 'WPBakery Visual Composer',
            'slug'               => 'js_composer',
            'source'             => THEMESFLAT_DIR . 'inc/plugins/js_composer.zip',
            'version'            => '5.4.7',
            'required'           => true,            
        ), 

        array(
            'name'               => 'Contact Form 7',
            'slug'               => 'contact-form-7',
            'required'           => false,            
        ),  

        array(
            'name'               => 'Mailchimp',
            'slug'               => 'mailchimp-for-wp',            
            'version'            => '4.1.11',
            'required'           => false,            
        ),   

           
    );  
 
    finance( $plugins);
 }

