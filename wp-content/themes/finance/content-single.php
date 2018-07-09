<?php
/**
 * @package themesflat
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post blog-single' ); ?>>
	<div class="entry-box-title clearfix">
		<div class="wrap-entry-title">
			<?php
				the_title( '<h1 class="entry-title">', '</h1>' );				
			?>			

			<?php if ( 'post' == get_post_type() && themesflat_choose_opt('blog_archive_show_post_meta') != 0 ) : ?>		
			<div class="entry-meta clearfix">
				<?php themesflat_posted_on(); ?>		
			</div><!-- /.entry-meta -->
			<?php endif; ?>	
		</div><!-- /.wrap-entry-title -->
	</div>	

	<?php get_template_part( 'tpl/feature-post' ); ?>
	
	<div class="main-post">		
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'finance' ),
					'after'  => '</div>',
					'link_before' => '<span>',
	    			'link_after'  => '</span>'
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php themesflat_entry_footer(); ?>
		</footer><!-- .entry-footer -->

		<?php if ( get_theme_mod( 'show_author_box', 1 ) != 0 ) : ?>
			<?php if ( get_the_author_meta( 'description' ) ): ?>
			<div class="author-post">			
				<div class="author-body">
					<div class="author-avatar">					
						<?php				
						echo esc_url( get_avatar(get_the_author_meta('user_email'),$size='150',$default='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=80' ) );
						?>		

						<?php echo get_avatar( 'email@example.com', 32 ); ?>			
					</div><!--/.author-avatarr -->

					<div class="info">
						<div class="name">
					        <h6><?php the_author_posts_link(); ?></h6>		        
					    </div>			
						<p class="intro">
						<?php 
						echo esc_attr ( get_the_author_meta( 'description' ) );
						?>			
						</p>			
					</div><!--/.author-info -->
				</div><!--/.author-info -->
			</div><!--/.author-body -->
			<?php endif; ?>
		<?php endif; ?>
		
		<?php get_template_part( 'tpl/related-post' )?>
	    
	    <div class="clearfix"></div>
	</div><!-- /.main-post -->
</article><!-- #post-## -->
