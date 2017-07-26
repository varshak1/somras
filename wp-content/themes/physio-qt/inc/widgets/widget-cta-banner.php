<?php
/**
 * Widget: Call To Action
 *
 * @package physio-qt
 */

if ( ! class_exists( 'QT_Call_To_Action' ) ) {
	class QT_Call_To_Action extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
		 		false,
				esc_html__( 'QT: Call To Action', 'physio-qt' ),
				array( 
					'description' => esc_html__( 'Call to Action Banner widget for Page Builder', 'physio-qt' ),
					'classname'   => 'widget-cta-banner',
				)
			);

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_color_picker' ) );
		}

		/**
		 * Enqueue the color picker for the text
		 */
		public function enqueue_color_picker() {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			$instance['title_color'] = empty( $instance['title_color'] ) ? '#ffffff' : $instance['title_color'];
			$instance['subtitle_color'] = empty( $instance['subtitle_color'] ) ? '#ffffff' : $instance['subtitle_color'];

			echo $args['before_widget'];
			?>

			<div class="call-to-action <?php echo esc_attr( $instance['layout'] ); ?><?php echo empty ( $instance['subtitle'] ) ? '' : ' with-subtitle'; ?>">
				<div class="call-to-action--content">
					<div class="call-to-action--title" style="color: <?php echo esc_attr( $instance['title_color'] ); ?>;">
						<?php echo wp_kses_post( $instance['title'] ); ?>
					</div>
					<?php if( $instance['subtitle'] ) : ?>
						<div class="call-to-action--subtitle" style="color: <?php echo esc_attr( $instance['subtitle_color'] ); ?>;">
							<?php echo esc_attr( $instance['subtitle'] ); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="call-to-action--buttons">
					<?php echo do_shortcode( $instance['buttons'] ); ?>
				</div>
			</div>

			<?php
			echo $args['after_widget'];
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['title'] 			= wp_kses_post( $new_instance['title'] );
			$instance['title_color'] 	= sanitize_text_field( $new_instance['title_color'] );
			$instance['subtitle']		= wp_kses_post( $new_instance['subtitle'] );
			$instance['subtitle_color'] = sanitize_text_field( $new_instance['subtitle_color'] );
			$instance['buttons'] 		= wp_kses_post( $new_instance['buttons'] );
			$instance['layout'] 		= sanitize_key( $new_instance['layout'] );

			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {

			$title 			 = empty( $instance['title'] ) ? '' : $instance['title'];
			$title_color 	 = empty( $instance['title_color'] ) ? '' : $instance['title_color'];
			$subtitle 	  	 = empty( $instance['subtitle'] ) ? '' : $instance['subtitle'];
			$subtitle_color  = empty( $instance['subtitle_color'] ) ? '' : $instance['subtitle_color'];
			$buttons 		 = empty( $instance['buttons'] ) ? '' : $instance['buttons'];
			$layout 		 = empty( $instance['layout'] ) ? '' : $instance['layout'];
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'physio-qt' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title_color' ) ); ?>"><?php esc_html_e( 'Text color:', 'physio-qt' ); ?></label><br>
				<input class="qt-color-picker" id="<?php echo esc_attr( $this->get_field_id( 'title_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_color' ) ); ?>" type="text" value="<?php echo esc_attr( $title_color ); ?>" data-default-color="#ffffff" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Subtitle:', 'physio-qt' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle_color' ) ); ?>"><?php esc_html_e( 'Subtitle color:', 'physio-qt' ); ?></label><br>
				<input class="qt-color-picker" id="<?php echo esc_attr( $this->get_field_id( 'subtitle_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle_color' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle_color ); ?>" data-default-color="#999999" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'buttons' ) ); ?>"><?php esc_html_e( 'Buttons:', 'physio-qt' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'buttons' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'buttons' ) ); ?>" type="text" value="<?php echo esc_attr( $buttons ); ?>" /><br><br>
				<span>
					A example to use a button is: [button href="/services"]text[/button]<br/>
					<?php printf( esc_html__( 'See %s how to use all button attributes', 'physio-qt' ), '<a href="'. esc_url( 'http://www.qreativethemes.com/docs/physio/#buttons' ) .'" target="_blank">the documentation</a>' ); ?>
				</span>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Layout:', 'physio-qt' ); ?></label> <br>
				<select id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>">
					<option value="cta-inline" <?php selected( $layout, 'cta-inline' ); ?>><?php esc_html_e( 'Inline (Text left, buttons right)', 'physio-qt' ); ?></option>
					<option value="cta-block" <?php selected( $layout, 'cta-block' ); ?>><?php esc_html_e( 'Block (Text top, button bottom)', 'physio-qt' ); ?></option>
				</select>
			</p>

			<div style="display: inline-block; padding: 5px 15px; background-color: #f9f9f9; border-radius: 2px; border: 1px solid #d8d8d8;">
				<p>
					<?php printf( esc_html__( "Please add the background image to the page builder row, instead of the widget settings. See %s how-to.", 'physio-qt'  ), '<a href="'. esc_url( 'https://qreativethemes.ticksy.com/article/7775/' ) .'" target="_blank">this article</a>' ); ?>
				</p>
			</div>

			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Call_To_Action" );' ) );
}