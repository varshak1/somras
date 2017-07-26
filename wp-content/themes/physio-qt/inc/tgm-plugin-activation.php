<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.5.0-alpha
 * @author     Thomas Griffin, Gary Jones
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Register the required plugins for this theme.
 */
function physio_qt_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        array(
            'name'               => 'Advanced Custom Fields Pro',
            'slug'               => 'advanced-custom-fields-pro',
            'source'             => get_template_directory() . '/bundled-plugins/advanced-custom-fields-pro.zip',
            'required'           => true,
            'version'            => '5.3.',
            // 'force_activation'   => true,
            'force_deactivation' => true,
            'external_url'       => 'http://www.advancedcustomfields.com/pro/'
        ),
        array(
            'name'               => 'Page Builder by SiteOrigin',
            'slug'               => 'siteorigin-panels',
            'required'           => true,
        ),
        array(
            'name'               => 'SiteOrigin Widgets Bundle',
            'slug'               => 'so-widgets-bundle',
            'required'           => true,
        ),
        array(
            'name'               => 'QreativeShortcodes',
            'slug'               => 'qreativeshortcodes',
            'source'             => get_template_directory() . '/bundled-plugins/qreativeshortcodes.zip',
            'required'           => true,
            'version'            => '1.0.1',
            'external_url'       => 'http://themeforest.net/user/qreativethemes/portfolio?ref=QreativeThemes'
        ),
        array(
            'name'               => 'Booked - Appointment Booking for WordPress',
            'slug'               => 'booked',
            'source'             => get_template_directory() . '/bundled-plugins/booked.zip',
            'required'           => false,
            'version'            => '1.6.20',
            'external_url'       => 'http://codecanyon.net/item/booked-appointment-booking-for-wordpress/9466968?ref=QreativeThemes'
        ),
        array(
            'name'               => 'Breadcrumb NavXT',
            'slug'               => 'breadcrumb-navxt',
            'required'           => false,
        ),
        array(
            'name'               => 'Simple Page Sidebars',
            'slug'               => 'simple-page-sidebars',
            'required'           => false,
        ),
        array(
            'name'               => 'Contact Form 7',
            'slug'               => 'contact-form-7',
            'required'           => false,
        ),
        array(
            'name'               => 'Easy Fancybox',
            'slug'               => 'easy-fancybox',
            'required'           => false,
        ),
        array(
            'name'               => 'WooCommerce - excelling eCommerce',
            'slug'               => 'woocommerce',
            'required'           => false,
        ),
    );

    tgmpa( $plugins );

}
add_action( 'tgmpa_register', 'physio_qt_register_required_plugins' );