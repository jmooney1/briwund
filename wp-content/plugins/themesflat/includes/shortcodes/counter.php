<?php
/**
 * Register shortcode into Visual Composer
 */
add_action( 'vc_before_init', 'themesflat_counter_shortcode_params' );

/**
 * Register parameters for counter shortcode
 * 
 * @return  void
 */
function themesflat_counter_shortcode_params() {
	vc_map( array(
		'base'        => 'counter',
		'name'        => esc_html__( 'Themesflat: Counter', 'finance' ),
		'icon'        => 'themesflat-shortcode',
		'category'    => esc_html__( 'Themesflat', 'finance' ),
		'params'      => array(			
			// Title
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Title', 'finance' ),
				'param_name'       => 'title'
			),

			// Value
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Value', 'finance' ),
				'param_name'       => 'value',
				'value'            => 100
			),
			
			// Duration
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Duration', 'finance' ),
				'param_name'       => 'duration',
				'value'            => 1000
			),

			// Extra Class
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Extra Class', 'finance' ),
				'param_name' => 'class'
			),

			array(
				'type' => 'css_editor',
				'param_name' => 'css',
				'group' => esc_html__( 'Design Options', 'finance' )
			)
		)
	) );
}

add_shortcode( 'counter', 'themesflat_shortcode_counter' );

/**
 * Function Counter shortcode handle
 * 
 * @param   array  $atts  Shortcode attributes
 * @return  void
 */
function themesflat_shortcode_counter( $atts, $content = null ) {
	
	$atts = vc_map_get_attributes( 'counter', $atts );

	$class = apply_filters( 'themesflat/shortcode/counter_class', array( 'counter', $atts['class'] ), $atts );
	$flat_counter = sprintf( '<div class="%1$s">', implode( ' ', $class ) );

	$flat_counter.= sprintf( '
		<div class="counter-content">
			
			<div class="numb-counter">
				<p class="numb-count" data-from="0" data-to="%1$d" data-speed="%2$s" data-waypoint-active="yes">%1$d</p>				
			</div>
		</div>
	', $atts['value'], $atts['duration'] );

	if ( ! empty( $atts['title'] ) )
		$flat_counter.= sprintf( '<p class="name">%s</p>', $atts['title'] );

	$flat_counter.= '</div>';

	// Enqueue shortcode assets		
	wp_enqueue_script( 'themesflat-counter' );	
	return $flat_counter;
}