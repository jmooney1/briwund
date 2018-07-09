<?php
/**
 * @package themesflat
 */
?>

<section class="portfolio-detail">	
	<div class="container">
		<div class="row">
			<div class="col-md-6 padr-45">
				<div class="content-portfolio-detail">
					<?php the_title( '<h1 class="single-portfolio-title">', '</h1>' ); ?>
            		<?php the_content(); ?>
            	</div>
            	<ul class="entry-portfolio-details">
            		<li>
            			<span><?php esc_html_e( 'Date:','finance' );  ?></span>
            			<?php echo esc_attr( the_date() ); ?>
            		</li>
            		<?php if ( themesflat_meta( 'port_client' ) != "" ) : ?>
						<li><span><?php esc_html_e( 'Client:','finance' ) ?></span>
							<?php echo esc_attr( themesflat_meta( 'port_client' ) )?>
						</li>
					<?php endif;  ?>
					
					<li><span><?php esc_html_e( 'Category:','finance' ) ?></span>
						<?php echo esc_attr ( the_terms( get_the_ID(), 'portfolios_category', 
                            '', ', ', '' ) ); ?>
					</li>								

					<?php if ( themesflat_meta( 'port_value' ) != "" ) : ?>
						<li><span><?php esc_html_e( 'Value:','finance' ) ?></span>
							<?php echo esc_attr( themesflat_meta( 'port_value' ) )?>
						</li>
					<?php endif;  ?>	
				</ul>
				<?php get_template_part( 'tpl/social-share' ); ?>	
				
            </div>
            <div class="col-md-6">
            	<div class="flat-portfolio-single-slider">
                    <div id="flat-portfolio-flexslider">
                        <ul class="slides">
                        <?php 
		            		$images = themesflat_decode(themesflat_meta( 'gallery_portfolio'));
					        if ( !empty( $images ) && is_array( $images ) ) {
					           foreach ( $images as $image ) {
					              echo '<li>';             
					              echo wp_get_attachment_image( $image,'themesflat-gallery-portfolio');
					              echo '</li>';                                 
					           }
					        } 
		        		?>                         
                        </ul>
                    </div>
                    <div id="flat-portfolio-carousel">
                        <ul class="slides">
                        <?php 
		            		$images = themesflat_decode(themesflat_meta( 'gallery_portfolio'));
					        if ( !empty( $images ) && is_array( $images ) ) {
					           foreach ( $images as $image ) {
					              echo '<li>';             
					              echo wp_get_attachment_image($image,'charry-blog-single');
					              echo '</li>';                                 
					           }
					        } 
		        		?>                    
                        </ul>
                    </div>
                </div><!-- /.flat-portfolio-single-slider --> 
            </div>            
		</div>
	</div>
</section>



