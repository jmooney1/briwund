<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package themesflat
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	

	<?php get_template_part( 'tpl/feature-post'); ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'finance' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( esc_html__( 'Edit', 'finance' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
