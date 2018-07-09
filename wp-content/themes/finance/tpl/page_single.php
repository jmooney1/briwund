<?php
/*
Template Name: Single Page
*/
get_header(); ?>
	<div class="col-md-12">
		<div class="single-page">
			<div id="primary" class="content-area <?php  echo esc_attr ( get_theme_mod( 'product_single_layout', 'fullwidth' ) ) ?>">
				<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php the_content(); ?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php 
			get_sidebar();
			?>
		</div>
	</div>
<?php get_footer(); ?>

