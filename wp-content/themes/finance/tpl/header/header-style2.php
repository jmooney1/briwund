<!-- Header -->
<header id="header" class="header widget-header <?php echo esc_attr( themesflat_choose_opt('header_style') ) ?>" >
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header-wrap clearfix">
                    <?php get_template_part( 'tpl/header/brand'); ?>

                    <div class="wrap-widget-header">
                        <?php themesflat_dynamic_sidebar ('sidebar-header');?>                      
                    </div><!-- wrap-widget-header -->
                </div>                
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->    
</header><!-- /.header -->

<!-- Mainnav -->
<div class="nav header-style2">
    <!-- <div class="container"> -->
        <div class="row">
            <div class="col-md-12">
                <?php get_template_part( 'tpl/header/navigator'); ?>

                <?php if ( themesflat_choose_opt('header_searchbox') == 1 ) :?>
                <div class="show-search">
                    <a href="#"><i class="fa fa-search"></i></a>         
                </div> 
                <?php endif;?>
                <div class="submenu top-search widget_search">
                    <?php get_search_form(); ?>
                </div> 
            </div>
        </div><!-- /.row -->       
    <!-- </div> --><!-- /.container -->    
</div>

