<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package themesflat
 */
?>

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- #content -->

    <?php if ( themesflat_choose_opt('enable_footer') == 1 ): ?>
        <!-- Footer -->
        <footer class="footer <?php (themesflat_meta( 'footer_class' ) != "" ? esc_attr( themesflat_meta( 'footer_class' ) ):'') ;?>">      
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="flat-before-footer">
                        <?php 
                            themesflat_dynamic_sidebar ( 'sidebar-before-footer' );
                        ?>   
                        </div><!-- /.flat-before-footer -->
                    </div><!-- /.col-md-12 -->  
                </div><!-- /.row -->  
                
                <div class="row"> 
                    <div class="footer-widgets">
                    <?php
                    $footer_column = get_theme_mod( 'footer_widget_areas', '3' );                
                    switch ( $footer_column ):                    
                        case 1:
                            $class = 'col-md-12';
                            break;
                        case 2:
                            $class = 'col-md-6';
                            break;
                        case 3:
                            $class = 'col-md-4';
                            break;
                        case 4:
                            $class = 'col-md-3';
                            break;
                    endswitch;
                    ?>
                    
                   <?php for ( $i = 1; $i <= $footer_column; $i++ ) : ?>
                    <div class="<?php echo esc_attr($class); ?>">
                        <?php
                            themesflat_dynamic_sidebar( "footer-$i" );
                        ?>
                    </div><!-- /.col-md- -->

                    <?php endfor; ?>                
                    </div><!-- /.footer-widgets -->  
                </div><!-- /.row -->    
            </div><!-- /.container -->   
        </footer>
    <?php endif; ?>

    <!-- Bottom -->
    <div class="bottom">
        <div class="container">           
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">                        
                        <?php echo wp_kses_post(themesflat_choose_opt( 'footer_copyright')); ?>
                    </div>

                    <div class="widget widget-custom-menu">
                        <?php                            
                            wp_nav_menu( array( 'theme_location' => 'bottom', 'fallback_cb' => 'themesflat_menu_fallback', 'container' => false ) );
                        ?>                        
                    </div>
                                     
                    <?php if ( themesflat_choose_opt( 'go_top') == 1 ) : ?>
                        <!-- Go Top -->
                        <a class="go-top show">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    <?php endif; ?>                    
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>    
</div><!-- /#boxed -->
<?php wp_footer(); ?>
</body>
</html>
