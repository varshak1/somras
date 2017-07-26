<?php
/**
 * Theme Specific Filters
 *
 * @package physio-qt
 */

/**
 * Add shortcodes in widgets
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Custom font size for tags
 */
if( ! function_exists( 'physio_qt_tag_font_size' ) ) {
	function physio_qt_tag_font_size( $args ) {
		$args['number'] = 12;
		$args['largest'] = 11;
		$args['smallest'] = 9;

		return $args;
	}
	add_filter( 'widget_tag_cloud_args', 'physio_qt_tag_font_size' );
}

/**
 * Wrap embeds in a wrapper
 */
if ( ! function_exists( 'thelandscaper_oembed_html' ) ) {
    function thelandscaper_oembed_html( $html, $url, $attr, $post_id ) {
        return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
    }
    add_filter( 'embed_oembed_html', 'thelandscaper_oembed_html', 99, 4 );
}

/**
 * Adds custom classes to the array of body classes.
 */
if( ! function_exists( 'physio_qt_body_classes' ) ) {
	function physio_qt_body_classes( $class ) {


		// If boxed layout theme mod isset to boxed add class to body
		if ( 'boxed' === get_theme_mod( 'boxed_layout', 'wide' ) ) {
			$class[] = 'boxed';
		}

		// If sticky navigation theme mod isset to sticky add class to body
		if ( 'sticky' === get_theme_mod( 'nav_position', 'static' ) ) {
			$class[] = 'sticky-navigation';
		}

		// If widget bar overlay position isset add class to body
		if ( 'overlay' === get_theme_mod( 'header_widgets_absolute', 'overlay' ) ) {
			$class[] = 'widget-bar-overlay';
		}

		// If page header isset to hidden add class to body
		if ( 'hide' === get_theme_mod( 'page_header', 'show' ) || 'hide' === get_field( 'page_header' ) ) {
			$class[] = 'hide-page-header';
		}

		// If page header isset to hidden add class to body
		if ( 'hide' !== get_field( 'sidebar' ) && 'pull' === get_field( 'pull_sidebar' ) ) {
			$class[] = 'pull-sidebar';
		}

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$class[] = 'group-blog';
		}

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$class[] = 'group-blog';
		}

		return $class;
	}
	add_filter( 'body_class', 'physio_qt_body_classes' );
}

/**
 * Get selected Google fonts from the customizer
 */
if ( ! function_exists( 'physio_qt_get_customizer_fonts' ) ) {
    function physio_qt_get_customizer_fonts( $fonts ) {

        // Get the customizer font type settings
        $primary_font = get_theme_mod( 'theme_primary_font', 'Open Sans' );
        $secondary_font = get_theme_mod( 'theme_secondary_font', 'Nunito' );

        // Get selected fonts and set default font weight (400 is regular)
        $font_primary = array( $primary_font => array( '400', '700' ) );
        $font_secondary = array( $secondary_font => array( '400', '700' ) );

        // Merge everything and remove duplicated
        $fonts = array_merge( $font_primary, $font_secondary );
        $fonts = array_map( 'array_unique', $fonts );

        return $fonts;
    }
    add_filter( 'pre_google_web_fonts', 'physio_qt_get_customizer_fonts' );
}

/**
 * Custom read more link
 */
if( ! function_exists( 'physio_qt_read_more_link' ) ) {
	function physio_qt_read_more_link() {

		$read_more = get_theme_mod( 'blog_read_more', 'Read More' );

        if ( !$read_more ) {
            $read_more = esc_html__( 'Read More', 'physio-qt' );
        }

		return '<a href="'. esc_url( get_permalink() ) .'" class="hentry--more">'. esc_html( $read_more ) .'</a>';
	}
	add_filter( 'the_content_more_link', 'physio_qt_read_more_link' );
}

/**
 * Allow skype in URLS to protocol
 **/
if( ! function_exists( 'physio_qt_allow_skype_protocol' ) ) {
	function physio_qt_allow_skype_protocol( $protocols ){
	    $protocols[] = 'skype';
	    return $protocols;
	}
	add_filter( 'kses_allowed_protocols' , 'physio_qt_allow_skype_protocol' );
}

/*
 * Enable font sizes in the TinyMCE editor
 */
if ( ! function_exists( 'physio_qt_enable_mce_fontsize' ) ) {
	function physio_qt_enable_mce_fontsize( $buttons ) {

	        array_shift( $buttons );
	        array_unshift( $buttons, 'fontsizeselect');
	        array_unshift( $buttons, 'formatselect');

	        return $buttons;
	}    
	add_filter('mce_buttons_2', 'physio_qt_enable_mce_fontsize');
}

/*
 * Change font sizes default points to pixels
 */
if ( ! function_exists( 'physio_qt_change_text_sizes' ) ) {
	function physio_qt_change_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}
	add_filter( 'tiny_mce_before_init', 'physio_qt_change_text_sizes' );
}

/**
 * Define the custom options for the SiteOrigin Page Builder
 */
if ( ! function_exists( 'physio_qt_custom_pagebuilder_widget_styles' ) ) {
	function physio_qt_custom_pagebuilder_widget_styles( $fields ) {
	
		$fields['big_widget_title'] = array(
			'name'			=> esc_html__( 'Big Widget Title', 'physio-qt' ),
			'type'			=> 'checkbox',
			'group'			=> 'design',
			'label'			=> esc_html__( 'Use bigger widget title', 'physio-qt' ),
			'priority'		=> 16,
		);

		$fields['small_widget_title'] = array(
			'name'			=> esc_html__( 'Small Widget Title', 'physio-qt' ),
			'type'			=> 'checkbox',
			'group'			=> 'design',
			'label'			=> esc_html__( 'Use smaller widget title', 'physio-qt' ),
			'priority'		=> 17,
		);

		$fields['white_widget_title'] = array(
			'name'			=> esc_html__( 'White Widget Title', 'physio-qt' ),
			'type'			=> 'checkbox',
			'group'			=> 'design',
			'label'			=> esc_html__( 'Use white colored title', 'physio-qt' ),
			'priority'		=> 18,
		);

		$fields['featured_box'] = array(
			'name'			=> esc_html__( 'Featured Box', 'physio-qt' ),
			'type'			=> 'checkbox',
			'group'			=> 'design',
			'label'			=> esc_html__( 'Set widget in color featured box', 'physio-qt' ),
			'priority'		=> 19,
		);

		$fields['white_featured_box'] = array(
			'name'			=> esc_html__( 'White Featured Box', 'physio-qt' ),
			'type'			=> 'checkbox',
			'group'			=> 'design',
			'label'			=> esc_html__( 'Set widget in white featured box', 'physio-qt' ),
			'priority'		=> 20,
		);

		return $fields;
	}

	add_filter( 'siteorigin_panels_widget_style_fields', 'physio_qt_custom_pagebuilder_widget_styles' );
}

/**
 * Add some custom option to the SiteOrigin Page Builder widget styles panel
 */
if ( ! function_exists( 'physio_qt_output_custom_pagebuilder_widget_styles' ) ) {
	function physio_qt_output_custom_pagebuilder_widget_styles( $attributes, $args ) {

		if ( ! empty( $args['big_widget_title'] ) ) {
			array_push( $attributes['class'], 'bigger-widget-title' );
		}

		if ( ! empty( $args['small_widget_title'] ) ) {
			array_push( $attributes['class'], 'smaller-widget-title' );
		}

		if ( ! empty( $args['white_widget_title'] ) ) {
			array_push( $attributes['class'], 'white-title' );
		}

		if ( ! empty( $args['featured_box'] ) ) {
			array_push( $attributes['class'], 'featured-box' );
		}

		if ( ! empty( $args['white_featured_box'] ) ) {
			array_push( $attributes['class'], 'white-featured-box' );
		}

		return $attributes;
	}
	add_filter( 'siteorigin_panels_widget_style_attributes', 'physio_qt_output_custom_pagebuilder_widget_styles', 10, 2 );
}

/**
 * Change some default SiteOrigin Page Builder settings
 */
if ( ! function_exists( 'physio_qt_siteorigin_default_settings' ) ) {
	function physio_qt_siteorigin_default_settings( $settings ) {
		$settings['mobile-width'] = '991';

		return $settings;
	}
	add_filter( 'siteorigin_panels_settings_defaults', 'physio_qt_siteorigin_default_settings' );
}

/**
 * Set default active SiteOrigin Widgets from the Bundle Plugin
 */
if ( ! function_exists( 'physio_qt_filter_active_siteorigin_widgets' ) ) {
	function physio_qt_filter_active_siteorigin_widgets( $active ){
	    $active['so-button-widget'] = false;
	    $active['so-image-widget'] = false;
	    $active['so-post-carousel-widget'] = false;
	    $active['so-google-map-widget'] = true;
	    $active['so-slider-widget'] = true;
	    $active['so-editor-widget'] = true;

	    return $active;
	}
	add_filter('siteorigin_widgets_active_widgets', 'physio_qt_filter_active_siteorigin_widgets');
}

/**
 * Unset SiteOrigin Widgets in pagebuilder widget list
 */
if ( ! function_exists( 'physio_qt_remove_site_origin_widgets' ) ) {
	function physio_qt_remove_site_origin_widgets( $widgets ){
	    unset( $widgets['SiteOrigin_Widget_Button_Widget'] );
	    unset( $widgets['SiteOrigin_Widget_Image_Widget'] );
	    unset( $widgets['SiteOrigin_Widget_Features_Widget'] );
	    unset( $widgets['SiteOrigin_Widget_PostCarousel_Widget'] );
	    unset( $widgets['SiteOrigin_Widget_Simple_Masonry_Widget'] );

	    return $widgets;
	}
	add_filter( 'siteorigin_panels_widgets', 'physio_qt_remove_site_origin_widgets' );
}

/**
 * Remove the SiteOrigin page builder premium teaser
 */
add_filter( 'siteorigin_premium_upgrade_teaser', '__return_false' );