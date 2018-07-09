<?php
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	/**
	 * Extended class to integrate testimonial slider with
	 * visual composer
	 */
    class WPBakeryShortCode_Imagebox_Slider extends WPBakeryShortCodesContainer {
    }
}

/**
 * Register shortcode into Visual Composer
 */
add_action( 'vc_before_init', 'themesflat_imagebox_shortcode_params' );

function themesflat_imagebox_shortcode_params() {
	/**
	 * Map the imagebox slider shortcode
	 */
	vc_map( array(
		'name'                    =>esc_html__( 'Themesflat: ImageBox Slider', 'finance' ),
		'base'                    => 'imagebox_slider',
		'as_parent'               => array( 'only' => 'imagebox' ), 
		'content_element'         => true,
		'show_settings_on_create' => false,
		'category'                =>esc_html__( 'Themesflat', 'finance' ),
		'params'                  => array(		

			// Margin
			array(
				'type' => 'textfield',
				'heading' =>esc_html__( 'Margin', 'finance' ),
				'param_name' => 'margin',
				'value' => '30',
				'description' =>esc_html__( 'Margin-right(px) on item.', 'finance' )
			),

			// Items
			array(
				'type' => 'textfield',
				'heading' =>esc_html__( 'Items', 'finance' ),
				'param_name' => 'slides_per_view',
				'value' => '2',
				'description' =>esc_html__( 'The number of items you want to see on the screen.', 'finance' )
			),

			// Autoplay
			array(
				'type' => 'checkbox',
				'heading' =>esc_html__( 'Autoplay', 'finance' ),
				'param_name' => 'autoplay',
				'description' =>esc_html__( 'Disable Autoplay', 'finance' ),
				'value' => array(esc_html__( 'Yes, please', 'finance' ) => 'yes' )
			),

			// Navigation
			array(
				'type' => 'checkbox',
				'heading' =>esc_html__( 'Hide dots navigation', 'finance' ),
				'param_name' => 'hide_control',
				'description' =>esc_html__( 'If YES dots navigation will be removed.', 'finance' ),
				'value' => array(esc_html__( 'Yes, please', 'finance' ) => 'yes' )
			),

			// Next/Prev
			array(
				'type' => 'checkbox',
				'heading' =>esc_html__( 'Hide next/prev buttons', 'finance' ),
				'param_name' => 'hide_buttons',
				'description' =>esc_html__( 'If "YES" next/prev buttons will be removed', 'finance' ),
				'value' => array(esc_html__( 'Yes, please', 'finance' ) => 'yes' )
			),		

			// Extra Class	
			array(
				'type' => 'textfield',
				'heading' =>esc_html__( 'Extra class name', 'finance' ),
				'param_name' => 'class',
				'description' =>esc_html__( 'Add class name for your design', 'finance' )
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
	 * Map the single imagebox item
	 */
	vc_map( array(
		'base'        => 'imagebox',
		'name'        =>esc_html__( 'finance: Image Box', 'finance' ),
		'icon'        => 'finance-shortcode',
		'category'    =>esc_html__( 'Themesflat', 'finance' ),
		'params'      => array(
			// Title
			array(
				'type'             => 'textfield',
				'heading'          =>esc_html__( 'Title', 'finance' ),
				'param_name'       => 'title'
			),

			array(
				'type'             => 'textfield',
				'heading'          =>esc_html__( 'Sub Title', 'finance' ),
				'param_name'       => 'subtitle'
			),

			array(
				'type'       => 'textarea_html',
				'heading'    =>esc_html__( 'Content', 'finance' ),
				'param_name' => 'content'
			),

			array(
				'type'       => 'attach_image',
				'heading'    =>esc_html__( 'Image', 'finance' ),
				'param_name' => 'image'
			),

			array(
				'type'       => 'textfield',
				'heading'    =>esc_html__( 'Image Size ( Enter your image size Ex: 70x70 Default: Full )', 'finance' ),
				'param_name' => 'image_size',
				'value'		 => 'full'
			),			

			array(
				'type'       => 'textfield',
				'heading'    =>esc_html__( 'Link', 'finance' ),
				'param_name' => 'link'
			),

			array(
				'type'       => 'dropdown',
				'heading'    =>esc_html__( 'Show Button Link ?', 'finance' ),
				'param_name' => 'show_button',
				'value'      => array(
					__( 'No', 'finance' ) => 'no',
					__( 'Yes', 'finance' ) => 'yes'					
				)
			),

			array(
				'type'             => 'textfield',
				'heading'          =>esc_html__( 'Button Text', 'finance' ),
				'param_name'       => 'button_text',
				'value'			   => 'Read More'
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

add_shortcode( 'imagebox_slider', 'themesflat_shortcode_imagebox_slider' );
add_shortcode( 'imagebox', 'themesflat_shortcode_imagebox' );

/**
 * Iconbox shortcode handle
 * 
 * @param   array  $atts  Shortcode attributes
 * @return  void
 */

function themesflat_shortcode_imagebox( $atts, $content = null ) {
	ob_start();

	$atts = vc_map_get_attributes( 'imagebox', $atts );

	// Preparing the shortcode attributes	
	$atts['show_button'] = $atts['show_button'] == 'yes';
	$atts['button_text'] = empty( $atts['button_text'] ) ?esc_html__( 'Continue', 'finance' ) : $atts['button_text'];

	// Build the element classes
	$classes = array( 'flat-imagebox' );
	$classes[] = $atts['class'];

	if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
		$classes[] = vc_shortcode_custom_css_class( $atts['css'], ' ' );
	}

	// Preparing image for the box
	if ( is_numeric( $atts['image'] ) ) {
		$image = wpb_getImageBySize( array( 'attach_id' => $atts['image'], 'thumb_size' => $atts['image_size'] ) );
		$image = $image['thumbnail'];
	}
	elseif ( filter_var( $atts['image'], FILTER_VALIDATE_URL ) ) {
		$image = sprintf( '<img src="%s" />', esc_url( $atts['image'] ) );
	}	
	?>	
	<div class="<?php echo esc_attr( join( ' ', $classes ) ) ?>">
		<div class="flat-imagebox-inner">
			<?php if ( ! empty( $image ) ): ?>
				<div class="flat-imagebox-image">
					<?php
						if ( ! $atts['show_button'] ) {
							printf( '<a href="%s" target="_blank">%s</a>',
								esc_url( $atts['link'] ), $image );
						}
						else {
							print( $image );
						}						
					?>
				</div>

			<?php endif ?>

			<div class="flat-imagebox-header">
				<h3 class="flat-imagebox-title">
					<a href="<?php echo esc_url( $atts['link'] ) ?>" target="_blank">
						<?php echo wp_kses_post( $atts['title'] ) ?>
					</a>	
				</h3>

				<?php if ( ! empty( $atts['subtitle'] ) ): ?>
					<div class="flat-imagebox-subtitle"><?php echo wp_kses_post( $atts['subtitle'] ) ?></div>
				<?php endif ?>
			</div>

			<div class="flat-imagebox-content">
				<?php if ( ! empty( $content ) ): ?>
					<div class="flat-imagebox-desc">
						<?php echo wp_kses( $content, array ( "ul"=>array(),"li"=>array() ) ) ?>
					</div>
				<?php endif ?>
				
				<?php if ( $atts['show_button'] ): ?>
					
					<div class="flat-imagebox-button">
						<a href="<?php echo esc_url( $atts['link'] ) ?>" target="_blank">
							<?php echo esc_html( $atts['button_text'] ) ?>
						</a>
					</div>

				<?php endif ?>
			</div>
		</div>
	</div>	
<?php 
return ob_get_clean();
}

function themesflat_shortcode_imagebox_slider( $atts, $content = null ) {
	$atts = shortcode_atts( array(		
		'margin'           => '30',
		'slides_per_view' => '2',
		'autoplay'        => '',
		'hide_control'    => '',
		'hide_buttons'    => '',		
		'class'           => '',
		'css'             => ''
	), $atts );
	
	$config = $atts;

	unset( $config['class'] );
	unset( $config['css'] );

	$class = apply_filters( 'themesflat/shortcode/imagebox_slider_class', array( 'testimonial-slider', $atts['class'] ), $atts );

	// Enqueue shortcode assets
	wp_enqueue_script( 'themesflat-carousel' );
	
	return sprintf( '
		<div class="%s" data-margin="%s" data-slides_per_view="%s" data-autoplay="%s" data-hide_control="%s" data-hide_buttons="%s">			
			%s				
		</div>
	', implode( ' ', $class ), esc_attr( $atts['margin'] ) , esc_attr( $atts['slides_per_view'] ), esc_attr( $atts['autoplay'] ), esc_attr( $atts['hide_control'] ), esc_attr( $atts['hide_buttons'] ),  do_shortcode( $content ) );
}



