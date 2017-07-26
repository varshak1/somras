<?php
/**
 * The template for displaying all single posts.
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

				<?php while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'single' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() && 'hide' !== get_theme_mod( 'blog_comments', 'show' ) ) :
						comments_template();
					endif;

				endwhile; // End of the loop. ?>

			</main>

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
	</div>

<?php get_footer(); ?>