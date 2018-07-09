<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package themesflat
 */
?>

<div id="secondary" class="widget-area" role="complementary">
	<div class="sidebar">
	<?php
		$sidebar = themesflat_choose_opt( 'blog_sidebar_list' );

		if ( is_page() ) {			
			$sidebar= themesflat_choose_opt( 'page_sidebar_list' );			
		}	  

        themesflat_dynamic_sidebar ( $sidebar ); 
	?>
	</div>
</div><!-- #secondary -->
