<?php
/**
 * Register shortcode into Visual Composer
 */
add_action( 'vc_before_init', 'themesflat_title_section_shortcode_params' );

/**
 * Register parameters for iconbox shortcode
 * 
 * @return  void
 */
function themesflat_title_section_shortcode_params() {
	vc_map( array(
		'base'        => 'title-section',
		'name'        =>esc_html__( 'Themesflat: Title Section', 'finance' ),
		'icon'        => 'themesflat-shortcode',
		'category'    =>esc_html__( 'Themesflat', 'finance' ),
		'params'      => array(
			array(
				'type'        => 'textfield',
				'heading'     =>esc_html__( 'Title', 'finance' ),
				'param_name'  => 'title'
			),

			array(
				'type'       => 'textarea',
				'heading'    =>esc_html__( 'Content', 'finance' ),
				'param_name' => 'content'
			),

			array(
				'type'       => 'dropdown',
				'heading'    =>esc_html__( 'Style', 'finance' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Style1', 'finance' ) => 'style1',
					__( 'Style2', 'finance' ) => 'style2',
					__( 'Style3', 'finance' ) => 'style3'
				)
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

add_shortcode( 'title-section', 'themesflat_title_section_shortcode_render' );

// Title section render
function themesflat_title_section_shortcode_render( $atts, $content = null ) {
	$atts = shortcode_atts( apply_filters( 'themesflat/shortcode/title_section_atts', array(		
		// Icon style
		'class' => '',
		'title'  => 'Why choose us',
		'style'	  => 'style1',
		'css'   => ''		
	) ), $atts );

	$class = apply_filters( 'themesflat/shortcode/title_section_class', array( 'title-section', $atts['class'] ), $atts );
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

	$title_content = '';

	if ( ! empty( $content ) ) {
		$title_content = sprintf( '
			<div class="title-content">
				%s
			</div>', $content );
	}

	return sprintf( '<div class="%1$s %4$s">
		<h1 class="title">
			%2$s			
		</h1>		
		%3$s

	</div>', esc_attr( implode( ' ', $class ) ), wp_kses_post( $atts['title'] ), $title_content, esc_attr( $atts['style'] ) );
	
}

