<?php
/*
Template Name: Front Page
*/
get_header(); ?>
<div class="col-md-12">
	<div id="primary" class="content-area-front-page">
		<main id="main" class="site-main" role="main">


			<div class="entry-content">
				<div class="top-cover"></div>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div><!-- .entry-content -->

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- /.col-md-12 -->
<?php get_footer(); ?>
