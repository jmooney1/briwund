<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package finance
 */

get_header(); ?>
<div class="col-md-12">

	<div id="primary" class="content-area">
		<main id="main" class="post-wrap" role="main">
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_type() );
				?>

			<?php endwhile; ?>			
		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		</main><!-- #main -->
		<div class="clearfix">
		<?php
			global $paging_style, $paging_for;
			$paging_for = 'blog';
	        $paging_style = themesflat_choose_opt('blog_archive_pagination_style');		        
			get_template_part( 'tpl/pagination' );				
		?>
		</div>
	</div><!-- #primary -->

	<?php 
	if ( themesflat_choose_opt( 'blog_layout') != 'fullwidth' ) :
	get_sidebar();
	endif;
	?>
</div><!-- /.col-md-12 -->

<?php get_footer(); ?>
