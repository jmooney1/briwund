<?php
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	/**
	 * Extended class to integrate testimonial slider with
	 * visual composer
	 */
    class WPBakeryShortCode_client_slider extends WPBakeryShortCodesContainer {
    }
}

add_action( 'vc_before_init', 'themesflat_client_shortcode_params' );

function themesflat_client_shortcode_params() {
	/**
	 * Map the client slider shortcode
	 */
	vc_map( array(
		'name'                    => esc_html__( 'Themesflat: Client Slider', 'finance' ),
		'base'                    => 'client_slider',
		'as_parent'               => array( 'only' => 'client' ), 
		'content_element'         => true,
		'show_settings_on_create' => false,
		'category'                => esc_html__( 'Themesflat', 'finance' ),
		'params'                  => array(		
			// Margin
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Margin', 'finance' ),
				'param_name' => 'margin',
				'value' => '30',
				'description' => esc_html__( 'Margin-right(px) on item.', 'finance' )
			),

			// Items
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Items', 'finance' ),
				'param_name' => 'slides_per_view',
				'description' => esc_html__( 'The number of items you want to see on the screen.','finance' ),
				'value' => '6'
			),

			// Autoplay
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Autoplay', 'finance' ),
				'param_name' => 'autoplay',
				'description' => esc_html__( 'Disable Autoplay', 'finance' ),
				'value' => array( esc_html__( 'Yes, please', 'finance' ) => 'yes' )
			),

			// Navigation
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide dots navigation.', 'finance' ),
				'param_name' => 'hide_control',
				'description' => esc_html__( 'If YES dots navigation will be removed.', 'finance' ),
				'value' => array( esc_html__( 'Yes, please', 'finance' ) => 'yes' )
			),

			// Next/Prev
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide next/prev buttons', 'finance' ),
				'param_name' => 'hide_buttons',
				'description' => esc_html__( 'If "YES" next/prev buttons will be removed.', 'finance' ),
				'value' => array( esc_html__( 'Yes, please', 'finance' ) => 'yes' )
			),	

			// Extra Class	
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'finance' ),
				'param_name' => 'class',
				'description' => esc_html__( 'Add class name for your design', 'finance' )
			),

			array(
				'type' => 'css_editor',
				'param_name' => 'css',
				'group' => esc_html__( 'Design Options', 'finance' )
			)
		),
		'js_view' => 'VcColumnView'
	) );

	/**
	 * Map the client item
	 */
	vc_map( array(
		'base'        => 'client',
		'name'        => esc_html__( 'Themesflat: Client', 'finance' ),
		'icon'        => 'themesflat-shortcode',
		'category'    => esc_html__( 'Themesflat', 'finance' ),
		'params'      => array(	
			array(
				'type'       => 'attach_image',
				'heading'    => esc_html__( 'Image', 'finance' ),
				'param_name' => 'image'
			),
		
			array(
				'type' => 'css_editor',
				'param_name' => 'css',
				'group' => esc_html__( 'Design Options', 'finance' )
			)
		)
	) );
}

add_shortcode( 'client', 'themesflat_shortcode_client' );
add_shortcode( 'client_slider', 'themesflat_shortcode_client_slider' );

function themesflat_shortcode_client( $atts, $content = null ) {
	$atts = vc_map_get_attributes( 'client', $atts );

	if ( ! empty( $atts['image'] ) ) {
		if ( is_numeric( $atts['image'] ) && $images = wp_get_attachment_image_src( $atts['image'], 'full' ) )
			$atts['image'] = array_shift( $images );
	}

	$flat_client =  sprintf( '
		<div class="client-image">
			<img src="%s" alt="images" />
		</div>'
	,esc_attr( $atts['image'] ) );

	return $flat_client;
}

function themesflat_shortcode_client_slider( $atts, $content = null ) {	
	$atts = vc_map_get_attributes( 'client_slider', $atts );

	$config = $atts;

	unset( $config['class'] );
	unset( $config['css'] );

	$class = apply_filters( 'themesflat/shortcode/client_slider_class', array( 'client-slide', $atts['class'] ), $atts );

	// Enqueue shortcode assets
	wp_enqueue_script( 'themesflat-carousel' );

	$flat_client_slide = sprintf( '
		<div class="wrap-client-slide">
			<div class="%s" data-margin="%s" data-slides_per_view="%s" data-autoplay="%s" data-hide_control="%s" data-hide_buttons="%s">			
				%s				
			</div>
		</div>
	', implode( ' ', $class ), esc_attr( $atts['margin'] ) , esc_attr( $atts['slides_per_view'] ), esc_attr( $atts['autoplay'] ), esc_attr( $atts['hide_control'] ), esc_attr( $atts['hide_buttons'] ),  do_shortcode( $content ) );
	
	return $flat_client_slide;
}

