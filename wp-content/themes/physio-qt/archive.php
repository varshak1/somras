<?php
/**
 * The template for displaying archive pages.
 *
 * @package physio-qt
 */

get_header();

// Set the sidebar to right
$physio_sidebar = get_field( 'sidebar', (int) get_option( 'page_for_posts' ) );
if ( ! $physio_sidebar ) :
	$physio_sidebar = 'right';
endif;

// Set the sidebar pull to no pull
$physio_sidebar_pull = get_field( 'pull_sidebar', (int) get_option( 'page_for_posts' ) );
if ( ! $physio_sidebar_pull || ( 'hide' === $physio_sidebar && 'pull' === $physio_sidebar_pull ) ) :
	$physio_sidebar_pull = 'no_pull';	
endif;

// Get the page header template
get_template_part( 'template-parts/page-header' );

if ( 'pull' !== $physio_sidebar_pull && 'hide' !== get_theme_mod( 'breadcrumbs', 'show' ) && 'hide' !== get_field( 'breadcrumbs' ) ) : ?>
	<div class="breadcrumbs">
		<div class="container">
			<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
		</div>
	</div>
<?php endif; ?>

<div id="primary" class="content-area container">
	<div class="row">
			
			<main id="main" class="content col-xs-12 <?php echo 'left' === $physio_sidebar ? 'col-md-9 col-md-push-3' : ''; echo 'right' === $physio_sidebar ? 'col-md-9' : ''; ?>">

				<?php if ( 'no_pull' !== $physio_sidebar_pull && 'hide' !== get_theme_mod( 'breadcrumbs', 'show' ) && 'hide' !== get_field( 'breadcrumbs' ) ) : ?>
					<div class="breadcrumbs">
						<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( have_posts() ) : ?>

					<?php 
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						?>
						<div class="hentry--border">
							<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
						</div>

					<?php endwhile;

					// Previous/next page navigation.
					the_posts_pagination( array(
						'prev_text' => '<i class="fa fa-caret-left"></i>',
						'next_text' => '<i class="fa fa-caret-right"></i>',
					) );

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

		</main><!-- #main -->

		<?php if ( 'hide' !== $physio_sidebar ) : ?>
			<div class="col-xs-12 col-md-3<?php echo 'left' === $physio_sidebar ? ' col-md-pull-9' : ''; ?>">
				<aside class="sidebar<?php echo 'pull' === $physio_sidebar_pull ? ' pull--sidebar' : ''; ?>">
					<?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
						<?php dynamic_sidebar( 'blog-sidebar' ); ?>
					<?php endif; ?>
				</aside>
			</div>
		<?php endif; ?>
		
	</div>
</div><!-- #primary -->

<?php get_footer(); ?>