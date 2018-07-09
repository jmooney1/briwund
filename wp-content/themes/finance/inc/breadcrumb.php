<?php
if ( ! function_exists( 'themesflat_breadcrumb_trail' ) )
	require_once trailingslashit( get_template_directory() ) . 'inc/breadcrumb-trail/breadcrumb-trail.php';

if ( ! function_exists( 'themesflat_breadcrumb_items' ) ) {
	add_filter( 'breadcrumb_trail_items', 'themesflat_breadcrumb_items', 10, 2 );

	/**
	 * Add breadcrumb item when post title is empty
	 * 
	 * @param   array  $items  Breadcrumb items
	 * @param   array  $args   Arguments
	 * @return  array
	 */
	function themesflat_breadcrumb_items( $items, $args ) {
		if ( is_singular() ) {
			$post = get_post();
			
			if ( empty( $post->post_title ) ) {
				$items[] = get_the_title();
			}
		}

		return $items;
	}
}
