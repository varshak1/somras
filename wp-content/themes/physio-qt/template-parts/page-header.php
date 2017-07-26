<?php
/**
 * Page Header Template Part
 *
 * @package physio-qt
 */

$physio_header_attr = '';
$physio_head_tag 	= is_single() ? 'h2' : 'h1';
$physio_get_the_id 	= get_the_ID();

if ( is_home() || is_singular( 'post' ) ) {
	$physio_page_id 	= absint( get_option( 'page_for_posts' ) );
	$physio_get_the_id  = $physio_page_id;
}

if ( physio_qt_woocommerce_active() && is_woocommerce() ) {
	$physio_shop_id 	= absint( get_option( 'woocommerce_shop_page_id' ) );
	$physio_get_the_id  = $physio_shop_id;
}

$physio_header_attr = array();

if( get_field( 'header_bg', $physio_get_the_id ) ) {
	$physio_header_attr = array(
		'background-image'		=> get_field( 'header_bg', $physio_get_the_id ),
		'background-position'	=> get_field( 'header_bg_horizontal', $physio_get_the_id ) . ' ' . get_field( 'header_bg_vertical', $physio_get_the_id ),
		'background-size'		=> get_field( 'header_bg_size', $physio_get_the_id ),
		'background-attachment'	=> get_field( 'header_bg_attachment', $physio_get_the_id ),
	);
}
$physio_header_attr['background-color'] = get_field( 'header_bg_color', $physio_get_the_id );

// Text Align Setting
$physio_header_align = array(
	'text-align' => get_field( 'header_text_align', $physio_get_the_id ),
);

// Page title settings
$physio_title_attr = array(
	'color'	=> get_field( 'page_title_color', $physio_get_the_id ),
	'text-align' => get_field( 'header_text_align', $physio_get_the_id ),
);

// Sub title settings
$physio_subtitle_attr = array(
	'color'	=> get_field( 'subtitle_color', $physio_get_the_id ),
);

// Create the styles from the above arrays
$physio_header_styles   = physio_qt_create_style_array( $physio_header_attr );
$physio_header_align 	= physio_qt_create_style_array( $physio_header_align );
$physio_title_styles    = physio_qt_create_style_array( $physio_title_attr );
$physio_subtitle_styles = physio_qt_create_style_array( $physio_subtitle_attr );
?>

<?php if ( 'hide' !== get_theme_mod( 'page_header', 'show' ) && 'hide' !== get_field( 'page_header', $physio_get_the_id ) ) : ?>
	<div class="page-header" <?php echo wp_kses_post( $physio_header_styles ); ?>>
		<div class="container">
			<div class="page-header--wrap" <?php echo wp_kses_post( $physio_header_align ); ?>>

				<?php
					$physio_subtitle = '';

					if ( is_home() || ( is_single() && 'post' === get_post_type() ) ) {
						
						$physio_title = get_the_title( $physio_get_the_id );
						$physio_subtitle = get_field( 'subtitle', $physio_get_the_id );

					} elseif ( physio_qt_woocommerce_active() && is_woocommerce() ) {

						ob_start();
						woocommerce_page_title();
						$physio_title    = ob_get_clean();
						$physio_subtitle = get_field( 'subtitle', (int) get_option( 'woocommerce_shop_page_id' ) );

					} elseif ( is_category() || is_tag() || is_author() || is_year() || is_month() || is_day() || is_tax() ) {
						
						$physio_title = get_the_archive_title();

					} elseif ( is_search() ) {
						
						$physio_title = esc_html__( 'Search Results For', 'physio-qt' ) . ' &quot;' . get_search_query() . '&quot;';

					} elseif ( is_404() ) {
						
						$physio_title = esc_html__( 'Error 404', 'physio-qt');

					} else {
						
						$physio_title = get_the_title();
						$physio_subtitle = get_field( 'subtitle' );
					}
				?>

				<?php if ( 'hide' !== get_field( 'display_page_title', $physio_get_the_id ) ) : ?>
					<<?php echo esc_html( $physio_head_tag ); ?> class="page-header--title" <?php echo wp_kses_post( $physio_title_styles ) ?>><?php echo wp_kses_post( $physio_title ); ?></<?php echo esc_html( $physio_head_tag ); ?>>
				<?php endif; ?>

				<?php if ( $physio_subtitle ): ?>
					<h3 class="page-header--subtitle" <?php echo wp_kses_post( $physio_subtitle_styles ) ?>><?php echo wp_kses_post( $physio_subtitle ); ?></h3>
				<?php endif;?>

			</div>
		</div>
	</div>
<?php endif; ?>