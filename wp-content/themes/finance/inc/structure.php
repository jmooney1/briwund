<?php
if ( ! function_exists( 'themesflat_body_classes' ) ) {
	add_filter( 'body_class', 'themesflat_body_classes' );

	function themesflat_body_classes( $classes ) {		

		if ( themesflat_meta('enable_custom_topbar') == 1 ) {
			if (themesflat_meta( 'topbar_enabled' ) == 1 )	{	
				$classes[] = 'has-topbar';
			}			
		}
		else {
			if ( themesflat_get_opt( 'topbar_enabled') == 1 )
				$classes[] = 'has-topbar';		
		}

		if ( themesflat_choose_opt('header_sticky') == 1 ) {	
			$classes[] = 'header_sticky';
		}

		/**
		 * Portfolio template
		 */
		if ( is_page_template( 'tpl/portfolio.php' ) ) $classes[] = 'page-portfolio';

		/**
		 * Full-Width layout template
		 */
		if ( is_page_template( 'tpl/page_fullwidth.php' ) ) $classes[] = 'page-fullwidth';
		$classes[] =  themesflat_choose_opt('layout_version');

		/**
		 * Full Width Sidebar Position
		 */
		$classes[] = themesflat_choose_opt( 'page_layout' );
		
		return $classes;
	}
}


