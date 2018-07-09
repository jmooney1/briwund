<?php
$feature_post = '';
switch ( get_post_format() ) {	
	case 'gallery':
		$size = 'themesflat-blog';
		$images = themesflat_decode(themesflat_meta( 'gallery_images'));

		if ( empty( $images ) )
			break;

		wp_enqueue_script( 'jquery-flexslider' );
		?>		
		<div class="featured-post blog-slider" data-auto="false" data-effect="slide" data-direction="horizotal">
	        <div class="flexslider">
	            <ul class="slides">
	            	<?php 
				        if ( !empty( $images ) && is_array( $images ) ) {
				           foreach ( $images as $image ) {
				              echo '<li>';             
				              echo wp_get_attachment_image($image,'themesflat-blog');
				              echo '</li>';                                 
				           }
				        } 
	        		?> 
	            </ul>
	        </div>
    	</div><!-- /.feature-post -->
    	<?php 
		break;
	case 'video':	
		$video = themesflat_meta('video_url');
		if ( !$video ) 
			break;

		if ( filter_var( $video, FILTER_VALIDATE_URL ) ) { // display oEmbed HTML if a url exists
			if ( $oembed = @wp_oembed_get( $video,array('heigh'=>400) ) )
				$feature_post .= $oembed;
		} else { // display oEmbed HTML if a embed code exists
			$feature_post = $video;
		}
		break;
	default:
		$size = 'themesflat-blog';
		
		$thumb = get_the_post_thumbnail( get_the_ID(), $size );
		if ( empty( $thumb ) )
			return;

		$feature_post .= '<a href="' . esc_url( get_permalink() ) . '">';
		$feature_post .= get_the_post_thumbnail( get_the_ID(), $size );
		$feature_post .= '</a>';
}

if ( $feature_post )
	echo '<div class="featured-post">' . $feature_post . '</div>';
?>