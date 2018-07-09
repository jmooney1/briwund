<?php
/**
 * Register shortcode into Visual Composer
 */
add_action( 'vc_before_init', 'themesflat_spacer_shortcode_params' );

/**
 * Register parameters for iconbox shortcode
 * 
 * @return  void
 */
function themesflat_spacer_shortcode_params() {
	vc_map( array(
		'base'        => 'flat_spacer',
		'name'        =>esc_html__( 'Themesflat: Spacer', 'finance' ),
		'icon'        => 'themesflat-shortcode',
		'category'    =>esc_html__( 'Themesflat', 'finance' ),
		'params'      => array(

			array(
				'type'             => 'textfield',
				'heading'          =>esc_html__( 'Desktop', 'finance' ),
				'param_name'       => 'desktop',
				'value'            => 80
			),

			array(
				'type'             => 'textfield',
				'heading'          =>esc_html__( 'Mobile', 'finance' ),
				'param_name'       => 'mobile',
				'value'            => 40
			),			

			array(
				'type'             => 'textfield',
				'heading'          =>esc_html__( 'SMobile', 'finance' ),
				'param_name'       => 'smobile',
				'value'            => 30
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

add_shortcode( 'flat_spacer', 'themesflat_shortcode_spacer' );

/**
 * Iconbox shortcode handle
 * 
 * @param   array  $atts  Shortcode attributes
 * @return  void
 */
function themesflat_shortcode_spacer( $atts, $content = null ) {

	$atts = vc_map_get_attributes( 'flat_spacer', $atts );

	$class = apply_filters( 'themesflat/shortcode/spacer', array( 'flat-spacer', $atts['class'] ), $atts );
	
	return sprintf( '
		<div class="%1$s" data-desktop="%2$s" data-mobile="%3$s" data-smobile="%4$s">			
		</div>', esc_attr( implode( ' ', $class ) ), $atts['desktop'], $atts['mobile'], $atts['smobile'] );
}



