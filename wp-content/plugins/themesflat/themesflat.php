<?php
/**
 * Plugin Name: ThemesFlat By Themesflat.com
 * Plugin URI:  http://themesflat.com/
 * Description: The theme's components
 * Author:      ThemesFlat
 * Version:     1.0.1
 * Author URI: http://themesflat.com/
 */

define( 'THEMESFLAT_VERSION', '1.0.1' );
define( 'THEMESFLAT_PATH', plugin_dir_path( __FILE__ ) );
define( 'THEMESFLAT_URL', plugin_dir_url( __FILE__ ) );

// Portfolio
require_once THEMESFLAT_PATH . '/includes/portfolio/func-setup.php';

// Shortcodes
if ( function_exists( 'visual_composer' ) ) {		
	require_once THEMESFLAT_PATH . '/includes/shortcodes/iconbox.php';
	require_once THEMESFLAT_PATH . '/includes/shortcodes/imagebox.php';	
	require_once THEMESFLAT_PATH . '/includes/shortcodes/testimonial.php';	
	require_once THEMESFLAT_PATH . '/includes/shortcodes/title-section.php';
	require_once THEMESFLAT_PATH . '/includes/shortcodes/flat-extend.php';
	require_once THEMESFLAT_PATH . '/includes/shortcodes/team-member.php';
	require_once THEMESFLAT_PATH . '/includes/shortcodes/maps.php';		
	require_once THEMESFLAT_PATH . '/includes/shortcodes/skillbar.php';		
	require_once THEMESFLAT_PATH . '/includes/shortcodes/spacer.php';
	require_once THEMESFLAT_PATH . '/includes/shortcodes/counter.php';
	require_once THEMESFLAT_PATH . '/includes/shortcodes/client.php';		
}

if ( ! function_exists( 'themesflat_shortcode_register_assets' ) ) {
	add_action( 'init', 'themesflat_shortcode_register_assets' );

	/**
	 * Register all needed scripts & styles for the plugin
	 * 
	 * @return  void
	 */
	function themesflat_shortcode_register_assets() {		
		wp_enqueue_style( 'vc_extend_shortcode', plugins_url('assets/css/shortcodes.css', __FILE__), array() );	
		wp_enqueue_style( 'vc_extend_style', plugins_url('assets/css/shortcodes-3rd.css', __FILE__),array() );
		wp_register_script( 'themesflat-carousel', plugins_url('assets/3rd/owl.carousel.js', __FILE__), array(), '1.0', true );
		wp_register_script( 'themesflat-flexslider', plugins_url('assets/3rd/jquery.flexslider-min.js', __FILE__), array(), '1.0', true );		
		wp_register_script( 'themesflat-manific-popup', plugins_url('assets/3rd/jquery.magnific-popup.min.js', __FILE__), array(), '1.0', true );		
		wp_register_script( 'themesflat-counter', plugins_url('assets/3rd/jquery-countTo.js', __FILE__), array(), '1.0', true );
		wp_enqueue_script( 'flat-shortcode', plugins_url('assets/js/shortcodes.js', __FILE__), array(), '1.0', true );
		wp_register_script( 'themesflat-google', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCIm1AxfRgiI_w36PonGqb_uNNMsVGndKo&v=3.7', array(), '1.0', true );
		wp_register_script( 'themesflat-gmap3', plugins_url('assets/3rd/gmap3.min.js', __FILE__), array(), '1.0', true );	
	}
}

// Show notice if your plugin is activated but Visual Composer is not
function showVcVersionNotice() {
    $plugin_data = get_plugin_data(__FILE__);
    echo '<div class="error">';
    echo '<p>' . wp_kses( __( $plugin_data['Name'] . ' - requires <a href="' . esc_url( admin_url( 'plugins.php') ) . '">Visual Composer</a>  plugin to be installed and activated on your site.', 'finance' ), array( 'a' => array( 'href' => array() ) ) ) . '</p>';
    echo '</div>';
}

if ( ! function_exists( 'themesflat_custom_shortcodes_class' ) ) {
	/**
	 * Helper function to append custom css class that
	 * generated from VisualComposer for shortcode
	 *
	 * @param   array  $classes  Shortcode classes
	 * @param   array  $atts     Shortcode attributes
	 * @param   string $tag      Shortcode tag name
	 *
	 * @return  array
	 */
	function themesflat_custom_shortcodes_class( $classes, $atts = array(), $tag = '' ) {
		if ( function_exists( 'vc_shortcode_custom_css_class' ) && ! empty( $atts['css'] ) ) {
			$classes[] = vc_shortcode_custom_css_class( $atts['css'], ' ' );
		}

		return $classes;
	}
}

