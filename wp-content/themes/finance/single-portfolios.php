<?php
/**
 * The template for displaying all single portfolio posts.
 *
 * @package themesflat
 */

get_header(); ?>
<div id="primary" class="single-cause-area">
		<main id="main" class="post-wrap" role="main">
			<div class="portfolio-single">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'portfolio' ); ?>
					<?php 
						if ( get_theme_mod( 'portfolio_show_post_navigator','1' ) == 1 ) :
							themesflat_post_navigation();
						endif;		 
					?>		
					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>
				<?php endwhile; // end of the loop. ?>	
			</div><!-- portfolio-single -->
	</main>
</div>

<?php get_template_part( 'tpl/portfolio-related' )?>
<?php get_footer(); ?>