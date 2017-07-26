<?php
/**
 * Version 0.0.3
 *
 * This file is just an example you can copy it to your theme and modify it to fit your own needs.
 * Watch the paths though.
 */

if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'Physio_Theme_Demo_Data_Importer' ) ) {

	//load admin theme data importer
    require_once( dirname( __FILE__ ) . '/radium-one-click-demo-install/importer/radium-importer.php' );

	class Physio_Theme_Demo_Data_Importer extends Radium_Theme_Importer {

        /**
		 * Set framewok
		 *
		 * options that can be used are 'default', 'radium' or 'optiontree'
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $theme_options_framework = 'radium';

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_option_name  = ''; // ignore
		public $theme_options_file_name = ''; // ignore
		public $widgets_file_name = 'widgets.json';
		public $content_demo_file_name = 'content.xml';

		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widget_import_results;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */
		public function __construct() {

			$this->demo_files_path = trailingslashit( get_template_directory() . '/demo-files/' );

			self::$instance = $this;
			parent::__construct();

		}

		/**
		 * Add menus - the menus listed here largely depend on the ones registered in the theme
		 *
		 * @since 0.0.1
		 */
		public function set_demo_menus(){

			// Menus to Import and assign
			$top_menu  = get_term_by( 'name', 'Topbar Navigation', 'nav_menu' );
			$main_menu = get_term_by('name', 'Main Navigation', 'nav_menu');

			set_theme_mod( 'nav_menu_locations', array(
				'top-nav' => $top_menu->term_id,
				'primary' => $main_menu->term_id,
			) );

			// Set the front page and blog page
			$set_front_page = get_page_by_title( 'Home' )->ID;
			$set_blog_page  = get_page_by_title( 'News' )->ID;

			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $set_front_page );
			update_option( 'page_for_posts', $set_blog_page );

			// Update Booked Plugin default colors
			update_option( 'booked_light_color','#9a65a5' );
			update_option( 'booked_dark_color','#535961' );
			update_option( 'booked_button_color','#9560a0' );

			// Empty default breadcrumbs seperator
			add_option( 'bcn_options', array( 'hseparator' => '' ) );

			// Force the featured button text in the customizer
			set_theme_mod( 'featured_button_text', 'Book Appointment' );
			set_theme_mod( 'featured_button_url', '#' );

			// Force the bottom footer text in the customizer
			set_theme_mod( 'bottom_footer_left', 'Copyright 2017 Physio WP by Qreativethemes' );
			set_theme_mod( 'bottom_footer_right', 'Change text via Customize > Theme Options > Bottom Footer' );

		}
	}

	new Physio_Theme_Demo_Data_Importer;
}