<?php
$logo_site = get_theme_mod('site_logo', THEMESFLAT_LINK . 'images/logo.png' );
$logo_width = get_theme_mod('logo_width', 175 );
$logo_height = get_theme_mod('logo_height', 50 );
$logo_margin_top = get_theme_mod('logo_margin_top', 21 );
$logo_margin_bottom = get_theme_mod('logo_margin_bottom', 21 );
$logo_retina_site = get_theme_mod('site_retina_logo', THEMESFLAT_LINK . 'images/logo@2x.png' );		

$site_logo_sticky = get_theme_mod('site_logo_sticky', THEMESFLAT_LINK . 'images/logo.png' );
$site_retina_logo_sticky = get_theme_mod('site_retina_logo_sticky', THEMESFLAT_LINK . 'images/logo@2x.png' );	
	        
if ( $logo_site ) : ?>
	<div id="logo" class="logo" style="margin-top: <?php echo esc_attr( $logo_margin_top ) ?>px; margin-bottom: <?php echo esc_attr( $logo_margin_bottom ) ?>px;">		        	
		<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php bloginfo('name'); ?>">
			<img class="site-logo" src="<?php echo esc_url($logo_site); ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" data-retina="<?php echo esc_url( $logo_retina_site ); ?>" data-logo_site="<?php echo esc_url( $logo_site ); ?>" data-logo_sticky="<?php echo esc_url( $site_logo_sticky ); ?>" data-site_retina_logo_sticky="<?php echo esc_url( $site_retina_logo_sticky ); ?>" data-retina_base="<?php echo esc_url( $logo_retina_site ); ?>" />
		</a>
	</div>
<?php else : ?>
    <div class="site-infomation">
    	<h1 class="site-title"><a href="<?php echo esc_url( home_url('/') ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>			
		<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>	
    </div><!-- /.site-infomation -->          
<?php endif; ?>
