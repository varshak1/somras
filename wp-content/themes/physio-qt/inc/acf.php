<?php
/**
 * Functions for ACF
 */

/**
 * Hide ACF from admin menu, just for safety
 */
add_filter('acf/settings/show_admin', '__return_false');

/**
 * Load all the ACF options from this file
 */
require_once( get_template_directory() . '/inc/acf-fields.php' );

/**
 * Fix if ACF is not activated after theme install
 * No function prefixing here because ACF get_field function
 */
if ( ! is_admin() && ! function_exists( 'get_field' ) ) {
    function get_field( $key ) {
        return get_post_meta( get_the_ID(), $key, true );
    }
    function have_rows( $value = false ) {
    	return false;
	}
}

/**
 * Remove the notification when a update is available for ACF PRO
 * customers cant update the plugin themself because it is a premium plugin
 * new versions of ACF PRO will be included in the theme updates
 */
if ( ! function_exists( 'physio_qt_hide_acf_update_notifications' ) ) {
	function physio_qt_hide_acf_update_notifications( $value ) {
		if ( isset( $value ) && is_object( $value ) ) {
			unset( $value->response[ 'advanced-custom-fields-pro/acf.php' ] );
		}
		return $value;
	}
	add_filter( 'site_transient_update_plugins', 'physio_qt_hide_acf_update_notifications' );
}