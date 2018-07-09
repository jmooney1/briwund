<?php
if (  themesflat_choose_opt( 'show_related_portfolio') != 1)
	return;
$atts = array(
	'style'           => themesflat_choose_opt( 'related_portfolio_style' ),
	'columns'         => themesflat_choose_opt( 'grid_columns_portfolio_related' ),
	'limit'           => (int) themesflat_choose_opt( 'number_related_portfolio'),
	'content_length'  => 150,
	'show_filter'     => 'no'
);

if ( $tags = get_the_terms( get_the_ID(), 'portfolios_tag' ) ) {
	$atts['tag'] = array_values( wp_list_pluck( $tags, 'slug' ) );
}
elseif ( $categories = get_the_terms( get_the_ID(), 'portfolios_category' ) ) {
	$atts['category'] = array_values( wp_list_pluck( $categories, 'slug' ) );
}

if ( $atts['style'] == 'carousel' ) {
	$atts['style'] = 'grid';
	$atts['enable_carousel'] = 'yes';
}
elseif ( $atts['style'] == 'carousel-no-margin' ) {
	$atts['style'] = 'no-margin';
	$atts['enable_carousel'] = 'yes';
}

$atts['exclude'] = get_the_ID();
?>
<section class="related-portfolios">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php 				
				if( get_theme_mod( 'title_related_portfolio','Related Portfolio' ) != "" ) {
					echo '<div class="title_related_portfolio">'.get_theme_mod( 'title_related_portfolio','Related Portfolio' ).'</div>';
				}
				echo flat_VCExtend::themesflat_portfolio( $atts );
				?>
			</div>
		</div>
	</div>
</section>
