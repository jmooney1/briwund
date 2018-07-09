<?php
/*
Template Name: Portfolio
*/
get_header(); ?>

<div class="col-md-12">    
    <div class="flat-portfolio">
        <?php
        global $paging_style;
        $show_filter = themesflat_choose_opt('show_filter_portfolio');
        $columns = themesflat_choose_opt('portfolio_grid_columns');
        $limit = themesflat_choose_opt('portfolio_post_perpage');
        $style = themesflat_choose_opt('portfolio_style');
        $paging_style = themesflat_choose_opt('portfolio_archive_pagination_style');
        
        $orderby = themesflat_choose_opt('portfolio_order_by');
        $order = themesflat_choose_opt('portfolio_order_direction');
        
        $show_filter = ( $show_filter == 1 ) ? 'yes' : 'no';           
        
        $args = array(
            'style' => $style,
            'limit' => $limit,
            'columns' => $columns,
            'show_filter' => $show_filter,
            'orderby'   => $orderby,
            'order' => $order,  
            );       
        ?>

        <?php echo flat_VCExtend::themesflat_portfolio( $args ) ?>
    </div><!-- /.portfolio-container -->   
</div><!-- /.col-md-12 -->


<div class="col-md-12">
    <?php
    global $paging_for ;    
    $paging_for = 'portfolio';   
    get_template_part( 'tpl/pagination' );              
    ?>   
</div>
<?php get_footer(); ?>

