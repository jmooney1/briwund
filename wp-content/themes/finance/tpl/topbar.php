<?php 
$top_status = themesflat_choose_opt('topbar_enabled');
$top_content = themesflat_choose_opt('top_content');
$top_content_right = themesflat_choose_opt('top_content_right');
if ( $top_status != 1 ) return;
?>
<!-- Top -->
<div class="flat-top <?php echo esc_attr( themesflat_choose_opt('header_style') ) ?>">    
    <div class="container">
        <div class="row">
        	<div class="col-md-6">
            <?php
            	echo wp_kses_post($top_content);
            ?>
            </div><!-- /.col-md-7 -->

            <div class="col-md-6 text-right">
            <?php                
                if ( themesflat_choose_opt('enable_content_right_top') == 1 ):
                    echo wp_kses_post( $top_content_right );
                endif;
                
                if ( themesflat_choose_opt('enable_social_link') == 1 ):
                    echo themesflat_render_social();    
                endif;   
            ?>           

            </div><!-- /.col-md-6 -->

        </div><!-- /.container -->
    </div><!-- /.container -->        
</div><!-- /.top -->
