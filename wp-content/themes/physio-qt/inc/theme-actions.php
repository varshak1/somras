<?php
/**
 * Theme Specific Actions
 *
 * @package physio-qt
 */

/**
 * Check if WooCommerce is active
 */
if( ! function_exists( 'physio_qt_woocommerce_active' ) ) {
	function physio_qt_woocommerce_active() {
		return class_exists( 'Woocommerce' );
	}
}

/**
 * Return the Google Font URL
 */
if ( ! function_exists( 'physio_qt_font_slug' ) ) {
	function physio_qt_font_slug() {

		$fonts_url = '';
		$fonts = array();

		$fonts = apply_filters( 'pre_google_web_fonts', $fonts );

		foreach ( $fonts as $key => $value ) {
			$fonts[$key] = $key . ':' . implode( ',', $value );
		}

		if ( $fonts ) {
			$query_args = array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		}
		 
		return $fonts_url;
	}
}

/**
 * Creates the style from the array for the page headers
 */
if ( ! function_exists( 'physio_qt_create_style_array' ) ) {
    function physio_qt_create_style_array( $settings ) {

        // Begin of the style tag
        $array_style = 'style="';
        
        foreach ( $settings as $key => $value ) {

            if( $value ) {
            
                // If background isset add url()
                if( 'background-image' === $key ) {
                    $array_style .= $key . ': url(\'' . esc_url( $value ) . '\'); ';
                }
                else {
                    $array_style .= $key . ': ' . esc_attr( $value ) . '; ';
                }
            }
        }

        // End of the style tag
        $array_style .= '"';

        // Return the array
        return $array_style;
    }
}

/**
 * Get the sizes for the image srcset where used
 */
if( ! function_exists( 'physio_qt_srcset_sizes' ) ) {
	function physio_qt_srcset_sizes( $img_id, $sizes ) {
		$srcset = array();

		foreach ( $sizes as $size ) {
			$img = wp_get_attachment_image_src( $img_id, $size );
			$srcset[] = sprintf( '%s %sw', $img[0], $img[1] ); //
		}

		return implode( ', ' , $srcset );
	}
}

/**
 * Get the correct page/post ID
 */
if( ! function_exists( 'physio_qt_get_the_ID' ) ) {
	function physio_qt_get_the_ID() {

		$get_the_id = get_the_ID();

		if ( is_home() || is_singular( 'post' ) ) {
			$get_page_id = absint( get_option( 'page_for_posts' ) );
			$get_the_id  = $get_page_id;
		}

		if ( physio_qt_woocommerce_active() && is_woocommerce() ) {
			$get_shop_id = absint( get_option( 'woocommerce_shop_page_id' ) );
			$get_the_id  = $get_shop_id;
		}

		return $get_the_id;
	}
}