<?php
/*
Template Name: Full width Page
*/
get_header(); ?>
<div class="col-md-12">

	<div id="primary" class="content-area-full-width">
		<main id="main" class="site-main" role="main">
			

			<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

			<?php endwhile; // end of the loop. ?>
<br />

		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_footer(); ?>

