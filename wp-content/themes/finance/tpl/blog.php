<?php
/*
Template Name: Blog
*/
get_header(); ?>
<div class="col-md-12">    
    <div class="flat-portfolio">
        <?php
        global $paging_style;
        $layout = themesflat_choose_opt('blog_grid_columns');
        $paging_style = themesflat_choose_opt('blog_archive_pagination_style');
        $total = themesflat_choose_opt('blog_posts_per_page');
        $content_length = themesflat_choose_opt('blog_archive_post_excepts_length');        
        $show_readmore = themesflat_choose_opt('blog_archive_readmore');
        $readmore_text = themesflat_choose_opt('blog_archive_readmore_text');
        $hide_readmore = 'no';
        if ( $show_readmore == 0 ) {
            $hide_readmore = 'yes';
        }
        $orderby = themesflat_choose_opt('blog_order_by');
        $order = themesflat_choose_opt('blog_order_direction');
        
        $args = array(
            'style' => 'grid',
            'grid_columns' => $layout,
            'content_length' => $content_length,
            'hide_readmore' => $hide_readmore,           
            'readmore_text' => $readmore_text,
            'order'     => $order,
            'orderby'   => $orderby,
            'limit' => $total
            );       
        ?>

        <?php echo flat_VCExtend::themesflat_posts( $args ) ?>
    </div><!-- /.portfolio-container -->    
    <div class="clearfix">
    <?php
    global $paging_for ;    
    $paging_for = 'blog';   
    get_template_part( 'tpl/pagination' );              
    ?>
    </div>       
</div><!-- /.col-md-12 -->
<?php get_footer(); ?>
