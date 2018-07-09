<!-- Header -->
<header id="header" class="header <?php echo esc_attr( themesflat_choose_opt('header_style') ) ?>" >
    <!-- <div class="container"> -->
        <div class="row">
            <div class="col-md-12">
                <div class="header-wrap clearfix">
                    <?php
                        get_template_part( 'tpl/header/brand');
                    ?>

                    <?php if ( themesflat_choose_opt('header_searchbox') == 1 ) :?>
                   <!--  <div class="show-search">
                        <a href="#"><i class="fa fa-search"></i></a>         
                    </div>  -->
                    <?php endif;?>

                    <?php
                        get_template_part( 'tpl/header/navigator');
                    ?>
                                    <!-- <div class="submenu top-search widget_search">
                    <?php get_search_form(); ?>
                </div>  -->
                <div class="nav-right" style="display: table; height: 90px; width: 15%;">
                <div class="facebook" style="display: table-cell; vertical-align: middle; text-align: center;padding-right: 20px;">
            <img src="/wp-content/uploads/2018/06/facebook.png" />
                </div>
                <div class="twitter" style="display: table-cell; vertical-align: middle; text-align: center">
                    <img src="/wp-content/uploads/2018/06/twitter.png" />
                </div>
                <div class="login_btn" style="display: table-cell; vertical-align: middle; text-align: center">
                    <img src="/wp-content/uploads/2018/06/login_btn.png"/>
                </div>
            </div>
                              
                </div><!-- /.header-wrap -->


            </div><!-- /.col-md-12 -->

        </div><!-- /.row -->
    <!-- </div> --><!-- /.container -->    
</header><!-- /.header -->
