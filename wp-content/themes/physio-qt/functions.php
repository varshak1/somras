<?php
/**
 * Physio-qt functions and definitions.
 *
 * @package physio-qt
 * @author QreativeThemes
 */

/**
 * Define the version of the theme css and js files
 *
 */
define( 'PHYSIO_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

/**
 * Set the content width in pixels
 *
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140;
}

/**
 * Include the ACF functions
 *
 */
require_once( get_template_directory() . '/inc/acf.php' );

if ( ! function_exists( 'physio_qt_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function physio_qt_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on physio-qt, use a find and replace
		 * to change 'physio-qt' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'physio-qt', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * WooCommerce Support
		 */
		add_theme_support( 'woocommerce' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );

		// Jumbotron
		add_image_size( 'physio-qt-slider-l', 1920, 715, true );
		add_image_size( 'physio-qt-slider-m', 960, 358, true );
		add_image_size( 'physio-qt-slider-s', 480, 179, true );

		// Featured Page
		add_image_size( 'physio-qt-featured-l', 850, 567, true );
		add_image_size( 'physio-qt-featured-s', 360, 240, true );

		// News Widget
		add_image_size( 'physio-qt-news-l', 848, 448, true );
		add_image_size( 'physio-qt-news-s', 360, 180, true );

		/*
		 * This theme uses wp_nav_menu() in one location.
		 */
		add_theme_support( 'menus' );
		register_nav_menu( 'primary', esc_html__( 'Main Navigation', 'physio-qt' ) );
		register_nav_menu( 'top-nav', esc_html__( 'Topbar Navigation', 'physio-qt' ) );
		register_nav_menu( 'footer-nav', esc_html__( 'Footer Navigation', 'physio-qt' ) );
		register_nav_menu( 'service-nav', esc_html__( 'Services Navigation', 'physio-qt' ) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'physio_qt_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		/*
		 * Add excerpt support for pages
		 */
		add_post_type_support( 'page', 'excerpt' );

		/*
		 * Support CSS for TinyMCE
		 */
		add_editor_style();

	}
	add_action( 'after_setup_theme', 'physio_qt_setup' );
}

/**
 * Enqueue CSS files
 */
if ( ! function_exists( 'physio_qt_enqueue_styles' ) ) {
	function physio_qt_enqueue_styles() {

		// Main CSS stylesheet
		wp_enqueue_style( 'physio-qt-style', get_stylesheet_uri(), array(), PHYSIO_THEME_VERSION, null );

		// If WooCommerce is active enqueue custom CSS stylesheet
		if ( physio_qt_woocommerce_active() ) {
			wp_enqueue_style( 'physio-qt-woocommerce', get_template_directory_uri() . '/woocommerce.css', array( 'physio-qt-style' ), PHYSIO_THEME_VERSION );
		}
	}
	add_action( 'wp_enqueue_scripts', 'physio_qt_enqueue_styles' );
}

/**
 * Enqueue Google Fonts
 * 
 */
if ( ! function_exists( 'physio_qt_google_font' ) ) {
	function physio_qt_google_font() {
		wp_enqueue_style( 'google-fonts', physio_qt_font_slug(), array(), null );
	}
	add_action( 'wp_enqueue_scripts', 'physio_qt_google_font' );
}

/**
 * Enqueue JS files
 */
if ( ! function_exists( 'physio_qt_enqueue_scripts' ) ) {
	function physio_qt_enqueue_scripts() {

		wp_enqueue_script( 'physio-qt-modernizr', get_template_directory_uri() . '/assets/js/modernizr-custom.js', array(), null );
		wp_enqueue_script( 'picturefill', get_template_directory_uri() . '/bower_components/picturefill/dist/picturefill.min.js', array( 'physio-qt-modernizr' ), null, false );
		wp_enqueue_script( 'physio-qt-main', get_template_directory_uri() . '/assets/js/main.min.js', array('jquery', 'underscore'), PHYSIO_THEME_VERSION, true );

		// Get Theme path, used for requirejs
		wp_localize_script( 'physio-qt-main', 'physio_qt', array(
			'themePath'  => get_template_directory_uri(),
		) );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'physio_qt_enqueue_scripts' );
}

/**
 * Enqueue admin CSS & JS files
 */
if ( ! function_exists( 'physio_qt_admin_enqueue_scripts' ) ) {
	function physio_qt_admin_enqueue_scripts( $hook ) {

		// Only include the JS on specific pages
		if ( in_array( $hook, array( 'post-new.php', 'post.php', 'widgets.php' ) ) ) {
			// JS files
			wp_enqueue_script( 'physio-qt-admin', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery', 'underscore', 'backbone' ) );
		}

		// CSS files
		wp_enqueue_style( 'physio-qt-admin', get_template_directory_uri() . '/assets/css/admin.css' );
	}
	add_action( 'admin_enqueue_scripts', 'physio_qt_admin_enqueue_scripts' );
}

/**
 * Get all the theme files from the /inc folder
 */

/* Theme add_filter functions */
require_once( get_template_directory() . '/inc/theme-filters.php' );

/* Theme add_action functions  */
require_once( get_template_directory() . '/inc/theme-actions.php' );

/* Theme Sidebars init */
require_once( get_template_directory() . '/inc/theme-sidebars.php' );

/* Theme Widgets */
require_once( get_template_directory() . '/inc/theme-widgets.php' );

/* Theme Customizer */
require_once( get_template_directory() . '/inc/theme-customizer.php' );

/* Theme Custom Comments  */
require_once( get_template_directory() . '/inc/theme-custom-comments.php' );

/* Aria Walker Menu  */
require_once( get_template_directory() . '/inc/aria_walker_nav_menu.php' );

/* WooCommerce Integration  */
require_once( get_template_directory() . '/inc/woocommerce.php' );

// Following files only gets included in the admin area
if ( is_admin() ) {

	/* One Click Demo Installer Init */
	require_once( get_template_directory() . '/inc/demo-import.php' );

	/* Class TGM Plugin Activation */
	require_once( get_template_directory() . '/inc/tgmpa/class-tgm-plugin-activation.php' );

	/* TGM Plugin Init */
	require_once( get_template_directory() . '/inc/tgm-plugin-activation.php' );
}