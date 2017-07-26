<?php
/**
 * Template for displaying search forms
 *
 * @package physio-qt
 */
?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_e( 'Search for:', 'physio-qt' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_e( 'Search &hellip;', 'physio-qt' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_e( 'Search for:', 'physio-qt' ); ?>" />
	</label>
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo esc_html_e( 'Search', 'physio-qt' ); ?></span></button>
</form>