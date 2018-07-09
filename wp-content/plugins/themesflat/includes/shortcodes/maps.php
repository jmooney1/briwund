<?php
add_shortcode( 'maps', 'themesflat_shortcode_maps' );

// Map render
function themesflat_shortcode_maps( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'name'		=>	'Themesflat Map',
		'address'		=>	'PO Box 16122 Collins Street West,Victoria 8007 Australia
',			
		'image'		=> '',
		'height'		=> '350px',
	), $atts ) );

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

	$img = "";
	if ( wp_get_attachment_url( $image ) ) {
		$img = wp_get_attachment_url( $image );
	}
	
	wp_enqueue_script('themesflat-google');
	wp_enqueue_script('themesflat-gmap3');

	$return = '<div class="flat-maps" data-address="' . esc_attr( $address ) . '" data-height="' . intval($height). '" data-images="' . esc_attr( $img ) . '" data-name="' . esc_attr( $name ) . '">
        <div id="map"></div>
    	</div><!-- /.flat-maps -->';

	return $return;
}


if ( function_exists( 'vc_map' ) ) {
	add_action( 'vc_before_init', 'themesflat_shortcode_maps_vc' );

	function themesflat_shortcode_maps_vc() {
		vc_map( array(			
			'name'                    =>esc_html__( 'Themesflat: Google Maps', 'themesflat' ),
			'base'                    => 'maps',	
			'icon'        => 'themesflat-shortcode',		
			'content_element'         => true,			
			'category'                =>esc_html__( 'Themesflat', 'themesflat' ),
			'params'                  => array(	

				// Name
				array(
					"type" => "textfield",
					"holder" => "h3",
					"heading" =>esc_html__("name", 'themesflat'),
					"param_name" => "name",
					"value" =>esc_html__("themesflat map", 'themesflat'),
					"description" =>esc_html__("Name display on map.", 'themesflat'),
				),	

				// Address
                array(
					"type" => "textfield",
					"holder" => "h3",
					"heading" =>esc_html__("address", 'themesflat'),
					"param_name" => "address",
					"value" =>esc_html__("3 London Rd London SE1 6JZ United Kingdom", 'themesflat'),
					"description" =>esc_html__("Address for map.", 'themesflat'),
				),	

                // Logo Company
              	array(
					"type" => "attach_image",
					"holder" => "img",
					"heading" =>esc_html__("Image", 'themesflat'),
					"param_name" => "image",
					"value" => '',
					"description" =>esc_html__("Choose logo company display on map", 'themesflat')
              	),

              	// Height Map
              	array(
					"type" => "textfield",
					"holder" => "h3",
					"heading" =>esc_html__("height", 'themesflat'),
					"param_name" => "height",
					"value" =>esc_html__("350px", 'themesflat'),
					"description" =>esc_html__("Set height for section map", 'themesflat'),
				),				
			)
		) );
	}
}
