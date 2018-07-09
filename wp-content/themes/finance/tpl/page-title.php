<?php 
    if ( is_page() && is_page_template( 'tpl/front-page.php' ) )
        return;

    $title = esc_html__( 'Archives', 'finance' );

    if ( is_home() ) {
        $title = esc_html__( 'Home', 'finance' );
    } elseif ( is_singular() ) {
        $title = get_the_title();
    } elseif ( is_search() ) {
        $title = sprintf( esc_html__( 'Search results for &quot;%s&quot;', 'finance' ), get_search_query() );
    } elseif ( is_404() ) {
        $title = esc_html__( 'Not Found', 'finance' );
    } elseif ( is_author() ) {
        the_post();
        $title = sprintf( esc_html__( 'Author Archives: %s', 'finance' ), get_the_author() );
        rewind_posts();
    } elseif ( is_day() ) {
        $title = sprintf( esc_html__( 'Daily Archives: %s', 'finance' ), get_the_date() );
    } elseif ( is_month() ) {
        $title = sprintf( esc_html__( 'Monthly Archives: %s', 'finance' ), get_the_date( 'F Y' ) );
    } elseif ( is_year() ) {
        $title = sprintf( esc_html__( 'Yearly Archives: %s', 'finance' ), get_the_date( 'Y' ) );
    } elseif ( is_tax() || is_category() || is_tag() ) {
        $title = single_term_title( '', false );
    }
?>

<!-- Page title -->
<?php if( is_home()){
    
}
else{?>
<div class="page-title <?php echo esc_attr( themesflat_choose_opt('pagetitle_style') ); ?>">
<?php } ?>
    <div class="overlay"></div>   
    <div class="container"> 
        <div class="row">
            <div class="col-md-12 page-title-container">
                <?php if ( themesflat_get_opt( 'page_title_heading' ) == 1 ): ?>
                    <div class="page-title-heading">
                        <h1 class="title"><?php echo esc_html( $title ); ?></h1>
                    </div><!-- /.page-title-captions --> 
                <?php endif; ?>

                <?php 
                if ( get_theme_mod( 'breadcrumb_enabled', 1 ) == 1 ):

                    themesflat_breadcrumb_trail( array(
                        'separator'   => get_theme_mod( 'breadcrumb_separator', '>' ),
                        'show_browse' => true,
                        'labels'      => array(
                        'browse'  => get_theme_mod( 'breadcrumb_prefix', esc_html__( 'You are here:', 'finance' ) ),
                            'home'    => esc_html__( 'Home', 'finance' )
                        )
                    ) );
                
                endif;                       
               ?>                 
            </div><!-- /.col-md-12 -->  
        </div><!-- /.row -->  
    </div><!-- /.container -->    
    <?php if(is_home()){

}                
else{ 
    ?>

 </div><!-- /.page-title --> 
    <?php  } ?>   
