<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package themesflat
 */

if ( ! function_exists( 'themesflat_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time, post categories and author.
 */
function themesflat_posted_on() {
?>
	<ul>	
		<li class="entry-time">
			<a href="<?php esc_url( the_permalink() ) ?>">		
			<span class="entry-day">
				<?php echo esc_html( get_the_date( 'd' ) ) ?>
			</span>
			<span class="entry-month">
				<?php echo esc_html( get_the_date( 'M' ) ) ?>
				<?php echo esc_html( get_the_date( 'Y' ) ) ?>
			</span>	
			</a>		
		</li>

		<li class="post-author">
			<?php
			printf(
				'<span class="author vcard"><a class="url fn n" href="%s" title="%s" rel="author">%s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )),
				esc_attr( sprintf( esc_html__( 'View all posts by %s', 'finance' ), get_the_author() ) ),
				get_the_author()
			);
			?>
		</li>

		<?php
		echo '<li class="post-categories">';
			the_category( ', ' );
		echo '</li>';
		?>		

		<li class="post-comments">
	        <?php                                 
	        comments_popup_link( esc_html__( 'No comment', 'finance' ), esc_html__(  '1', 'finance' ), esc_html__( '% comments', 'finance' ) );
	        ?>
        </li>

		
<?php 	
	echo '</ul>';
}
endif;

if ( ! function_exists( 'themesflat_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function themesflat_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', ', ' );
		if ( $tags_list && is_single() ) {
			printf( '<div class="tags-links">' . esc_html__( 'Tags: %1$s', 'finance' ) . '</div>', 
				$tags_list );
		}
	}
	edit_post_link( esc_html__( 'Edit', 'finance' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'themesflat_post_navigation' ) ) :
function themesflat_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'finance' ); ?></h2>
		<ul class="nav-links clearfix">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '<li>%link</li>', sprintf( '<span class="meta-nav">%s</span> %%title', esc_html__( 'Published In', 'finance' ) ) );
			else :
				previous_post_link( '<li class="previous-post">%link</li>', sprintf( '<span class="meta-nav">%s</span> %%title', esc_html__( 'Previous Post', 'finance' ) ) );
				next_post_link( '<li class="next-post">%link</li>', sprintf( '<span class="meta-nav">%s</span> %%title', esc_html__( 'Next Post', 'finance' ) ) );
			endif;
			?>
		</ul><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;