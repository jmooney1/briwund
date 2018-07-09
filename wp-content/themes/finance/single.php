<?php
/**
 * The template for displaying all single posts.
 *
 * @package themesflat
 */

get_header(); ?>
<div class="col-md-12">

	<div id="primary" class="content-area">
		<main id="main" class="post-wrap" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<div class="main-single">
			<?php 
			if ( 'post' == get_post_type() && get_theme_mod('show_post_navigator', 1 ) != 0 ) : 
				themesflat_post_navigation(); 				
			endif;
			?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
			</div><!-- /.main-single -->

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php 
	if ( get_theme_mod( 'blog_layout','sidebar-right' ) != 'fullwidth' ) :
		get_sidebar();
	endif;
	?>
</div><!-- /.col-md-12 -->
<?php get_footer(); ?>
