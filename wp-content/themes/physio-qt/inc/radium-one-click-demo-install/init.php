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

    require_once( dirname( __FILE__ ) . '/importer/radium-importer.php' ); //load admin theme data importer

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
		public $theme_option_name  = 'my_theme_options_name'; // ignore
		public $theme_options_file_name = 'theme_options.txt'; // ignore
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
				'topbar-navigation' => $top_menu->term_id,
				'main-navigation'   => $main_menu->term_id,
			) );

			$this->flag_as_imported['menus'] = true;

		}
	}

	new Physio_Theme_Demo_Data_Importer;
}