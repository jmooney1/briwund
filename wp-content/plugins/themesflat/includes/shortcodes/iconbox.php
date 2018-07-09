<?php
/**
 * Register shortcode into Visual Composer
 */
add_action( 'vc_before_init', 'themesflat_iconbox_shortcode_params' );

/**
 * Register parameters for iconbox shortcode
 * 
 * @return  void
 */
function themesflat_iconbox_shortcode_params() {
	$icons_params = themesflat_map_icons('icon','IconBox');

	$params = array_merge( $icons_params, array(
		// Title
		array(
			'type'             => 'textfield',
			'heading'          =>esc_html__( 'Title iconbox ', 'finance' ),
			'param_name'       => 'title'
		),

		// Sub Title
		array(
			'type'             => 'textfield',
			'heading'          =>esc_html__( 'Sub Title iconbox', 'finance' ),
			'param_name'       => 'sub_title'
		),

		// Size title
		array(
			'type'       => 'dropdown',
			'heading'    =>esc_html__( 'Size for title', 'finance' ),
			'param_name' => 'tag',
			'value'      => array(
				'h3' => 'h3',
				'h2' => 'h2',					
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6'
			)
		),

		// Content
		array(
			'type'       => 'textarea_html',
			'heading'    =>esc_html__( 'Content', 'finance' ),
			'param_name' => 'content'
		),

		// Button link
		array(
			'type' => 'textfield',
			'heading' =>esc_html__( 'Button Link', 'finance' ),
			'param_name' => 'link',
			'description' =>esc_html__( 'Enter your url for read more button', 'finance' )
		),

		// Button text
		array(
			'type' => 'textfield',
			'heading' =>esc_html__( 'Button Text', 'finance' ),
			'param_name' => 'text',
			'description' =>esc_html__( 'Enter custom text for read more button', 'finance' ),
			'value' =>esc_html__( 'Read More ...', 'finance' )
		),		

		// Icon align
		array(
			'type'       => 'dropdown',
			'heading'    =>esc_html__( 'Icon align', 'finance' ),
			'param_name' => 'icon_position',
			'value' => array(
				__( 'Top', 'finance' ) => 'top',
				__( 'Left', 'finance' ) => 'left',
				__( 'Left Inline', 'finance' ) => 'inline-left',
				__( 'Right', 'finance' ) => 'right'
			)
		),

		// Icon type
		array(
			'type'       => 'dropdown',
			'heading'    =>esc_html__( 'Icon Type', 'finance' ),
			'param_name' => 'icon_style',
			'value' => array(
				__( 'Default', 'finance' )         => 'default',
				__( 'Circle', 'finance' )          => 'circle',
				__( 'Circle Background', 'finance' )  => 'circle-outlined',
				__( 'Square Radius Background', 'finance' )         => 'rounded',
				__( 'Square Radius Border', 'finance' ) => 'outlined',
				__( 'Square Background', 'finance' )          => 'square',
				__( 'Square Border', 'finance' )  => 'square-outlined'
			)
		),

		// Extra Class
		array(
			'type'       => 'textfield',
			'heading'    =>esc_html__( 'Extra Class', 'finance' ),
			'param_name' => 'class'
		),

		array(
			'type' => 'css_editor',
			'param_name' => 'css',
			'group' =>esc_html__( 'Design Options', 'finance' )
		),		
	));	

	vc_map( array(
		'base'        => 'iconbox',
		'name'        =>esc_html__( 'Themesflat: Icon Box', 'finance' ),
		'icon'        => 'finance-shortcode',
		'category'    =>esc_html__( 'Themesflat', 'finance' ),
		'params'      => $params
	) );
}

add_shortcode( 'iconbox', 'themesflat_shortcode_iconbox' );

/**
 * Iconbox shortcode handle
 * 
 * @param   array  $atts  Shortcode attributes
 * @return  void
 */
function themesflat_shortcode_iconbox( $atts, $content = null ) {
	$atts = vc_map_get_attributes( 'iconbox', $atts );
	$icon_name = themesflat_shortcode_icon_name('icon_',$atts['icon_type']);
   	$icon_value = !empty( $icon_name ) ? $atts[$icon_name] : '';

	$flat_icon = sprintf( '<span class="%s"></span>', $icon_value );

	$flat_box_icon = $flat_icon ? sprintf( '<div class="flat-iconbox-icon">%s</div>', $flat_icon ) : '';
	$flat_box_readmore = '';

	if ( ! empty( $atts['link'] ) && ! empty( $atts['text'] ) ) {
		$flat_box_readmore = sprintf( '
			<p class="box-readmore">
				<a href="%s">%s</a>
			</p>', esc_url( $atts['link'] ), esc_html( $atts['text'] ) );
	}

	$sub_title = '';

	if ( ! empty( $atts['sub_title'] ) ) {
		$sub_title = sprintf( '
			<div class="sub-title">
				%s
			</div>', esc_html( $atts['sub_title'] ) );
	}	

	return sprintf( '<div class="flat-iconbox %2$s %8$s %9$s">
		<div class="flat-iconbox-header">
			%1$s
			<%4$s class="flat-iconbox-title">%3$s</%4$s>
			%7$s
		</div>
		<div class="flat-iconbox-content">
			%5$s
			%6$s
		</div>
	</div>', $flat_box_icon, esc_attr( $atts['class'] ), esc_html( $atts['title'] ), $atts['tag'], wp_kses_post ($content), $flat_box_readmore, $sub_title, esc_attr( $atts['icon_position'] ), esc_attr( $atts['icon_style'] ) );
}


