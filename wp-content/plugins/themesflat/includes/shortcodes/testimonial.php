<?php
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	/**
	 * Extended class to integrate testimonial slider with
	 * visual composer
	 */
    class WPBakeryShortCode_Testimonial_Slider extends WPBakeryShortCodesContainer {
    }
}

add_filter( 'themesflat/shortcode/testimonial_class', 'themesflat_custom_shortcodes_class', 10, 2 );
add_filter( 'themesflat/shortcode/testimonial_slider_class', 'themesflat_custom_shortcodes_class', 10, 2 );
add_action( 'vc_before_init', 'themesflat_testimonial_shortcode_params' );

function themesflat_testimonial_shortcode_params() {
	/**
	 * Map the testimonial slider shortcode
	 */
	vc_map( array(
		'name'                    =>esc_html__( 'Themesflat: Testimonial Slider', 'finance' ),
		'base'                    => 'testimonial_slider',
		'as_parent'               => array( 'only' => 'testimonial' ), 
		'content_element'         => true,
		'show_settings_on_create' => false,
		'category'                =>esc_html__( 'Themesflat', 'finance' ),
		'params'                  => array(			
			array(
				'type' => 'textfield',
				'heading' =>esc_html__( 'Margin', 'finance' ),
				'param_name' => 'margin',
				'value' => '30',
				'description' =>esc_html__( 'Margin item for slide', 'finance' )
			),
			array(
				'type' => 'textfield',
				'heading' =>esc_html__( 'Slides per view', 'finance' ),
				'param_name' => 'slides_per_view',
				'value' => '2',
				'description' =>esc_html__( 'Set numbers of slides you want to display', 'finance' )
			),
			array(
				'type' => 'checkbox',
				'heading' =>esc_html__( 'Slider autoplay', 'finance' ),
				'param_name' => 'autoplay',
				'description' =>esc_html__( 'Disable autoplay mode.', 'finance' ),
				'value' => array(esc_html__( 'Yes, please', 'finance' ) => 'yes' )
			),
			array(
				'type' => 'checkbox',
				'heading' =>esc_html__( 'Hide pagination control', 'finance' ),
				'param_name' => 'hide_control',
				'description' =>esc_html__( 'If YES pagination control will be removed.', 'finance' ),
				'value' => array(esc_html__( 'Yes, please', 'finance' ) => 'yes' )
			),
			array(
				'type' => 'checkbox',
				'heading' =>esc_html__( 'Hide prev/next buttons', 'finance' ),
				'param_name' => 'hide_buttons',
				'description' =>esc_html__( 'If "YES" prev/next control will be removed.', 'finance' ),
				'value' => array(esc_html__( 'Yes, please', 'finance' ) => 'yes' )
			),			
			array(
				'type' => 'textfield',
				'heading' =>esc_html__( 'Extra class name', 'finance' ),
				'param_name' => 'class',
				'description' =>esc_html__( 'Add class for your design', 'finance' )
			),

			array(
				'type' => 'css_editor',
				'param_name' => 'css',
				'group' =>esc_html__( 'Design Options', 'finance' )
			)
		),
		'js_view' => 'VcColumnView'
	) );

	/**
	 * Map the single testimonial item
	 */
	vc_map( array(
		'base'        => 'testimonial',
		'name'        =>esc_html__( 'Themesflat: Testimonial', 'finance' ),
		'icon'        => 'finance-shortcode',
		'category'    =>esc_html__( 'Themesflat', 'finance' ),
		'params'      => array(
			array(
				'type'        => 'textfield',
				'heading'     =>esc_html__( 'Name', 'finance' ),
				'param_name'  => 'name'
			),

			array(
				'type'       => 'attach_image',
				'heading'    =>esc_html__( 'Image', 'finance' ),
				'param_name' => 'image'
			),

			array(
				'type'             => 'textfield',
				'heading'          =>esc_html__( 'Subtitle', 'finance' ),
				'param_name'       => 'subtitle',
			),

			array(
				'type'             => 'textfield',
				'heading'          =>esc_html__( 'Company', 'finance' ),
				'param_name'       => 'company',
			),

			array(
				'type'             => 'textfield',
				'heading'          =>esc_html__( 'Link', 'finance' ),
				'param_name'       => 'link'
			),

			array(
				'type'       => 'textarea',
				'heading'    =>esc_html__( 'Content', 'finance' ),
				'param_name' => 'content'
			),

			array(
				'type'       => 'textfield',
				'heading'    =>esc_html__( 'Extra Class', 'finance' ),
				'param_name' => 'class'
			),

			array(
				'type' => 'css_editor',
				'param_name' => 'css',
				'group' =>esc_html__( 'Design Options', 'finance' )
			)
		)
	) );
}

add_shortcode( 'testimonial', 'themesflat_shortcode_testimonial' );
add_shortcode( 'testimonial_slider', 'themesflat_shortcode_testimonial_slider' );

/**
 * Testimonial shortcode handle
 * 
 * @param   string  $atts  Shortcode attributes
 * @return  void
 */
function themesflat_shortcode_testimonial( $atts, $content = null ) {

	$atts = vc_map_get_attributes( 'testimonial', $atts );

	$testimonial_image = '';
	$author_info = array();

	$class = apply_filters( 'themesflat/shortcode/testimonial_class', array( 'testimonial', $atts['class'] ), $atts );

	if ( ! empty( $atts['image'] ) ) {
		if ( is_numeric( $atts['image'] ) ) {
			$image_src = wp_get_attachment_image_src( $atts['image'], 'full' );
			$atts['image'] = array_shift( $image_src );
		}

		$class[] = 'has-image';
		$testimonial_image = sprintf( '
			<div class="testimonial-image">
				<img src="%s" alt="%s" />
			</div>
		', esc_attr( $atts['image'] ), esc_attr( $atts['name'] ) );
	}

	if ( ! empty( $atts['subtitle'] ) )
		$author_info[] = sprintf( '<span class="subtitle">%s</span>', wp_kses_post( $atts['subtitle'] ) );

	if ( ! empty( $atts['company'] ) ) {
		if ( ! empty( $atts['link'] ) )
			$author_info[] = sprintf( '<a href="%s" class="company">%s</a>', esc_url( $atts['link'] ), esc_html( $atts['company'] ) );
		else
			$author_info[] = sprintf( '<span class="company">%s</span>', esc_html( $atts['company'] ) );
	}

	return sprintf( '
		<div class="%1$s">
			%5$s
			<div class="testimonial-content">
				<blockquote>
					%2$s
				</blockquote>
				<div class="testimonial-author">
					<div class="author-name">%3$s</div>
					<div class="author-info">%4$s</div>
				</div>
			</div>	
		</div>
	',
	esc_attr( implode( ' ', $class ) ),
	wp_kses_post( $content ),	
	esc_html( $atts['name'] ),
	implode( $author_info ),
	wp_kses_post( $testimonial_image ) );
}

/**
 * This function will be use to handle testimonial slider
 * shortcode
 * 
 * @param   string  $atts     Shortcode attributes
 * @param   string  $content  Shortcode content
 * @return  string
 */
function themesflat_shortcode_testimonial_slider( $atts, $content = null ) {

	$atts = vc_map_get_attributes( 'testimonial_slider', $atts );
	
	$config = $atts;

	unset( $config['class'] );
	unset( $config['css'] );

	$class = apply_filters( 'themesflat/shortcode/testimonial_slider_class', array( 'testimonial-slider', $atts['class'] ), $atts );

	// Enqueue shortcode assets
	wp_enqueue_script( 'themesflat-carousel' );
	
	return sprintf( '
		<div class="%s" data-margin="%s" data-slides_per_view="%s" data-autoplay="%s" data-hide_control="%s" data-hide_buttons="%s">			
			%s				
		</div>
	', implode( ' ', $class ), esc_attr( $atts['margin'] ) , esc_attr( $atts['slides_per_view'] ), esc_attr( $atts['autoplay'] ), esc_attr( $atts['hide_control'] ), esc_attr( $atts['hide_buttons'] ),  do_shortcode( $content ) );
}

