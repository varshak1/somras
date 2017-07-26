<?php
/**
 * Widget: Count Box
 *
 * @package physio-qt
 */

if ( ! class_exists( 'QT_Counter' ) ) {
	class QT_Counter extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false,
				esc_html__( 'QT: Counter', 'physio-qt' ),
				array(
					'description' => esc_html__( 'Count widget for Page Builder', 'physio-qt' ),
					'classname'   => 'widget-counter',
				)
			);
		}

		/**
		 * Enqueue the JS and CSS files for the widget
		 */
		public static function enqueue_js_css() {
			wp_enqueue_script( 'physio-qt-waypoints', get_template_directory_uri() . '/assets/js/jquery.waypoints.min.js', array( 'jquery' ), '3.1.1', true );
			wp_enqueue_script( 'physio-qt-countbox', get_template_directory_uri() . '/assets/js/countbox.js', array( 'jquery' ), '', true );
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			?>

			<div class="counter <?php echo empty ( $instance['light_counter'] ) ? '' : 'light-counter'; ?>">
				<?php if( esc_attr( $instance['count_icon'] ) ) : ?>
					<div class="counter--icon">
						<i class="fa <?php echo esc_attr( $instance['count_icon'] ); ?>"></i>
					</div>
				<?php endif; ?>
				<div class="counter--text">
					<?php if ( $instance['count_unit_before'] ) : ?>
						<span class="counter--before"><?php echo esc_attr( $instance['count_unit_before'] ); ?></span>
					<?php endif; ?>
					<span class="counter--number" data-to="<?php echo esc_attr( $instance['count_number'] ); ?>" data-speed="<?php echo esc_attr( $instance['count_speed'] ); ?>"></span>
					<?php if ( $instance['count_unit_after'] ) : ?>
						<span class="counter--after"><?php echo esc_attr( $instance['count_unit_after'] ); ?></span>
					<?php endif; ?>
					<span class="counter--title"><?php echo esc_attr( $instance['count_title'] ); ?></span>
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

			$instance['count_number'] 		 = absint( $new_instance['count_number'] );
			$instance['count_icon'] 		 = sanitize_html_class( $new_instance['count_icon'] );
			$instance['count_title']		 = sanitize_text_field( $new_instance['count_title'] );
			$instance['count_speed']		 = absint( $new_instance['count_speed'] );
			$instance['count_unit_before']	 = sanitize_text_field( $new_instance['count_unit_before'] );
			$instance['count_unit_after']	 = sanitize_text_field( $new_instance['count_unit_after'] );
			$instance['light_counter']		 = ! empty( $new_instance['light_counter'] ) ? sanitize_key( $new_instance['light_counter'] ) : '';

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
			$count_number 		 = empty( $instance['count_number'] ) ? '' : $instance['count_number'];
			$count_unit_before	 = empty( $instance['count_unit_before'] ) ? '' : $instance['count_unit_before'];
			$count_unit_after	 = empty( $instance['count_unit_after'] ) ? '' : $instance['count_unit_after'];
			$count_icon   		 = empty( $instance['count_icon'] ) ? '' : $instance['count_icon'];
			$count_title  		 = empty( $instance['count_title'] ) ? '' : $instance['count_title'];
			$count_speed  		 = empty( $instance['count_speed'] ) ? '2000' : $instance['count_speed'];
			$light_counter		 = empty( $instance['light_counter'] ) ? '' : $instance['light_counter'];
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_number' ) ); ?>"><?php esc_html_e( 'Number', 'physio-qt' ); ?>:</label> <br />
				<input id="<?php echo esc_attr( $this->get_field_id( 'count_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count_number' ) ); ?>" type="number" value="<?php echo esc_attr( $count_number ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_unit_before' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count_unit_before' ) ); ?>"><?php esc_html_e( 'Before Number', 'physio-qt' ); ?></label> <br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'count_unit_before' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count_unit_before' ) ); ?>" value="<?php echo esc_attr( $count_unit_before ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_unit_after' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count_unit_after' ) ); ?>"><?php esc_html_e( 'After Number', 'physio-qt' ); ?></label> <br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'count_unit_after' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count_unit_after' ) ); ?>" value="<?php echo esc_attr( $count_unit_after ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_icon' ) ); ?>"><?php esc_html_e( 'Icon', 'physio-qt' ); ?></label><br/><small><em><?php printf( esc_html__( 'See %s for all icon classes (example: fa-home)', 'physio-qt' ), '<a href="'. esc_url( 'http://fontawesome.io/icons/' ) . '" target="_blank">FontAwesome</a>' ); ?></em></small></label> <br />
				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'count_icon' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count_icon' ) ); ?>" value="<?php echo esc_attr( $count_icon ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_title' ) ); ?>"><?php esc_html_e( 'Title', 'physio-qt' ); ?>:</label> <br />
				<input id="<?php echo esc_attr( $this->get_field_id( 'count_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count_title' ) ); ?>" type="text" value="<?php echo esc_attr( $count_title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count_speed' ) ); ?>"><?php esc_html_e( 'Speed (1000 = 1s)', 'physio-qt' ); ?>:</label> <br />
				<input id="<?php echo esc_attr( $this->get_field_id( 'count_speed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count_speed' ) ); ?>" type="text" value="<?php echo esc_attr( $count_speed ); ?>" />
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $light_counter, 'on'); ?> id="<?php echo esc_attr( $this->get_field_id( 'light_counter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'light_counter' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'light_counter' ) ); ?>"><?php esc_html_e( 'Use light text for the counter?', 'physio-qt' ); ?></label>
			</p>

			<?php
		}
	}
	add_action( 'wp_enqueue_scripts', array( 'QT_Counter', 'enqueue_js_css' ), 50 );
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Counter" );' ) );
}