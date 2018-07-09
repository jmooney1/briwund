<?php
/**
 * @package themesflat
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post' ); ?>>
	<div class="main-post">	
		<div class="entry-box-title clearfix">
			<div class="wrap-entry-title">
				<?php
					if ( is_singular('post') ) :						
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
					endif;
				?>				

				<?php if ( 'post' == get_post_type() && themesflat_choose_opt('blog_archive_show_post_meta') != 0 ) : ?>
				<div class="entry-meta clearfix">
					<?php themesflat_posted_on(); ?>		
				</div><!-- /.entry-meta -->
				<?php endif; ?>	
			</div><!-- /.wrap-entry-title -->
		</div>		
		<?php get_template_part( 'tpl/feature-post'); ?>

		<div class="entry-content">
			<?php if ( (themesflat_choose_opt( 'blog_archive_readmore' ) == 1 && is_home() ) || (themesflat_choose_opt('blog_archive_readmore') == 1 && is_archive() ) ) : ?>
				<?php the_content( themesflat_choose_opt( 'blog_archive_readmore_text', 'Read More' ) ); ?>
			<?php else : ?>
				<?php the_excerpt(); ?>
			<?php endif; ?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'finance' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- /.entry-post -->
		
	</div><!-- /.main-post -->
</article><!-- #post-## -->
