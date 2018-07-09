<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package themesflat
 */

get_header(); ?>
<div class="col-md-12">

	<div id="primary" class="content-area fullwidth-404">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="title-404 nothing"><?php esc_html_e( '404', 'finance' ); ?></h1>
				</header><!-- .page-header -->

				<div class="sub-title-404">
					<?php esc_html_e( 'Looks Like Something Went Wrong!', 'finance' ); ?>
				</div><!-- .title-404 -->

				<div class="page-content">
					<p class="subtext-nothing">
					<?php 
					$allowed = array( 'br' => array() );
					echo wp_kses( esc_html__( 'It looks like nothing was found at this location.Click the link below to return home.', 'finance' ), 
						$allowed );
					?>
					</p>					
					<h4><a class="flat-button" href="<?php echo esc_url( home_url('/') ); ?>">
						<?php esc_html_e( 'Return home','finance' ) ?></a>
					</h4>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

</div><!-- /.col-md-12 -->
<?php get_footer(); ?>
