<?php
/**
 * Jumbotron Template Part
 *
 * @package physio-qt
 */
?>

<div class="jumbotron carousel slide <?php echo get_field( 'slide_animation' ); ?>" id="jumbotron-fullwidth" data-ride="carousel" <?php printf( 'data-interval="%s"', get_field( 'slide_autocycle' ) ? get_field( 'slide_interval' ) : 'false' ); ?>>

    <div class="carousel-inner">

        <?php $physio_qt_count_slides = count( get_field( 'slides' ) ); ?>
        <?php if ( $physio_qt_count_slides > 1 ) : ?>
            <a class="carousel-control left" href="#jumbotron-fullwidth" role="button" data-slide="prev"><i class="fa fa-caret-left"></i></a>
            <a class="carousel-control right" href="#jumbotron-fullwidth" role="button" data-slide="next"><i class="fa fa-caret-right"></i></a>
        <?php endif; ?>

        <?php 
            $i = -1;
            while ( have_rows( 'slides' ) ) : 
                the_row();
                $i++;

                // Get the url for the img src
                $slide_image = wp_get_attachment_image_src( get_sub_field( 'slide_image' ), 'physio-qt-slider-l' );

                // Get the srcset images
                $slide_image_srcset = physio_qt_srcset_sizes( get_sub_field( 'slide_image' ), array( 'physio-qt-slider-s', 'physio-qt-slider-m', 'physio-qt-slider-l' ) );

                // Get the caption option field
                $slide_caption = get_field( 'slide_captions' );

                // Get the caption alignment field
                $slide_caption_align = get_field( 'slide_caption_alignment' );
                
                // Get the link url field
                $slide_link = get_sub_field( 'slide_link' );

                // Get the link target field
                $slide_link_target = get_sub_field( 'slide_link_target' );
            ?>

            <div class="item <?php echo 0 === $i ? 'active' : ''; ?>">
                <?php if ( ! empty( $slide_link ) && 'no_captions' === $slide_caption ) : ?>
                    <a href="<?php echo esc_url( $slide_link ); ?>"<?php echo ( 'yes' === $slide_link_target ) ? ' target="_blank"' : ''; ?>>
                <?php endif; ?>
                <img src="<?php echo esc_url( $slide_image[0] ); ?>" srcset="<?php echo esc_html( $slide_image_srcset ); ?>" sizes="100vw" width="<?php echo esc_attr( $slide_image[1] ); ?>" height="<?php echo esc_attr( $slide_image[2] ); ?>" alt="<?php echo esc_attr( strip_tags( get_sub_field( 'slide_heading' ) ) ); ?>">
                <?php if ( ! empty( $slide_link ) && 'no_captions' === $slide_caption ) : ?>
                    </a>
                <?php endif; ?>
               
                <?php if ( 'use_captions' === $slide_caption && ( get_sub_field( 'slide_small_heading' ) || get_sub_field( 'slide_heading' ) || get_sub_field( 'slide_content' ) ) ) : ?>
                    <div class="container">
                        <div class="jumbotron-caption <?php echo esc_attr( $slide_caption_align ); ?>">
                            <?php if( get_sub_field( 'slide_small_heading' ) ) : ?>
                                <div class="caption-small-heading"><?php the_sub_field( 'slide_small_heading' ); ?></div>
                            <?php endif; ?>
                            <?php if( get_sub_field( 'slide_heading' ) ) : ?>
                                <div class="caption-heading"><h1><?php the_sub_field( 'slide_heading' ); ?></h1></div>
                                <?php endif; ?>
                            <?php if( get_sub_field( 'slide_content' ) ) : ?>
                                <div class="caption-content"><?php the_sub_field( 'slide_content' ); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        
        <?php endwhile; ?>

    </div>
</div>