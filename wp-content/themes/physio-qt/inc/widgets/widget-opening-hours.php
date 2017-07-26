<?php
/**
 * Widget: Opening Hours
 *
 * @package physio-qt
 */

if ( ! class_exists( 'QT_Opening_Hours' ) ) {
	class QT_Opening_Hours extends WP_Widget {

		// Set variable so we only need to declare the $weekdays in the __construct
		private $weekdays;

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false,
				esc_html__( "QT: Opening Hours" , 'physio-qt' ),
				array(
					'description' => esc_html__( 'Opening Hours widget for Page Builder or Sidebar', 'physio-qt' ),
					'classname' => 'widget-opening-hours'
				)
			);

			// Define all weekdays
			$this->weekdays = array(
				'Monday'	=> esc_html__( 'Monday', 'physio-qt' ),
				'Tuesday'	=> esc_html__( 'Tuesday', 'physio-qt' ),
				'Wednesday'	=> esc_html__( 'Wednesday', 'physio-qt' ),
				'Thursday'	=> esc_html__( 'Thursday', 'physio-qt' ),
				'Friday'	=> esc_html__( 'Friday', 'physio-qt' ),
				'Saturday'	=> esc_html__( 'Saturday', 'physio-qt' ),
				'Sunday'	=> esc_html__( 'Sunday', 'physio-qt' ),
			);
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
			extract( $args );
			echo $before_widget;

			// Show widget title if isset
			$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

			if( !empty( $instance['title'] ) ) :
				echo $before_title . wp_kses_post( $instance['title'] ) . $after_title;
			endif;

			// Get the current time
			$get_the_time = current_time( 'timestamp' ) + get_option( 'gmt_offset' ) * 3600;

			$return = '';
			$return .= '<div class="opening-hours">';
			$return .= '<ul>';

			// Get the current time
			$get_the_time = current_time( 'timestamp', 1 ) + get_option('gmt_offset') * 3600;
				
			foreach( $this->weekdays as $key => $day ) {
				
				// If day is today, add today class
				$is_today = date( 'l', $get_the_time ) == $key ? ' today' : '';
				$return .= '<li class="weekday'. esc_attr( $is_today ) .'">';
				$return .= esc_attr( $day );

				if( ! empty( $instance[ $key . '_from' ] ) && ! empty( $instance[ $key . '_to' ] ) ) {
					
					// Display opening time from, time seperator, to
					$return .= '<span class="right">';
					$return .= esc_attr( $instance[$key . '_from'] . $instance['separator'] . $instance[$key . '_to'] );
				} else {

					// If highlight is checked display the label
					$class = empty( $instance['highlight'] ) ? '' : ' label';
					$return .= '<span class="right'. $class .'">';
					// Display closed text
					$return .= esc_attr( $instance['closed'] );
				}

				$return .= '</span>';
				$return .= '</li>';
			}

			$return .= '</ul>';

			// Extra information
			if ( $instance['extra_info'] ) :
				$return .= '<span class="extra">';
				$return .= esc_attr( $instance['extra_info'] );
				$return .= '</span>';
			endif;

			$return .= '</div>';

			echo wp_kses_post( $return );
			echo $after_widget;
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

			$instance['title'] = wp_kses_post( $new_instance['title'] );

			foreach( $this->weekdays as $key => $day ) {
				$instance[$key . '_from'] = sanitize_text_field( $new_instance[$key . '_from'] );
				$instance[$key . '_to']   = sanitize_text_field( $new_instance[$key . '_to'] );
			}

			$instance['separator']  = esc_html( $new_instance['separator'] );
			$instance['closed']	    = sanitize_text_field( $new_instance['closed'] );
			$instance['highlight']  = sanitize_key( $new_instance['highlight'] );
			$instance['today'] 		= sanitize_key( $new_instance['today'] );
			$instance['extra_info'] = sanitize_text_field( $new_instance['extra_info'] );

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
			
			$title = isset( $instance['title'] ) ?  $instance['title'] : '';

			foreach ( $this->weekdays as $key => $day ) {
				$from[$key] = isset( $instance[$key . '_from'] ) ? $instance[$key . '_from'] : '07:00';
				$to[$key]   = isset( $instance[$key . '_to'] ) ? $instance[$key . '_to'] : '17:00';
			}

			$separator  = isset( $instance['separator'] ) ?  $instance['separator'] : '-';
			$closed     = isset( $instance['closed'] ) ?  $instance['closed'] : esc_html__( 'We are closed', 'physio-qt' );
			$highlight  = empty( $instance['highlight'] ) ? '' : $instance['highlight'];
			$today 		= empty( $instance['today'] ) ? '' : $instance['today'];
			$extra_info = isset( $instance['extra_info'] ) ?  $instance['extra_info'] : '';
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'physio-qt' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<strong><?php esc_html_e( "Leave both fields empty to display the closed message", 'physio-qt' ); ?></strong>
			</p>

			<?php foreach ( $this->weekdays as $key => $day ) : ?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( $key . '_opened' ) ); ?>"><?php echo esc_html( $day ); ?></label><br>
					<label for="<?php echo esc_attr( $this->get_field_id( $key . '_from' ) ); ?>"><?php esc_html_e( 'From', 'physio-qt' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( $key . '_from' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key . '_from' ) ); ?>" value="<?php echo esc_attr( $from[$key] ); ?>" size="8" />
					<label for="<?php echo esc_attr( $this->get_field_id( $key . '_to' ) ); ?>"><?php esc_html_e( 'To', 'physio-qt' ); ?>:</label>
					<input type="text" id="<?php echo esc_attr( $this->get_field_id( $key . '_to' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key . '_to' ) ); ?>" value="<?php echo esc_attr( $to[$key] ) ?>" size="8" />
				</p>
			<?php endforeach; ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'separator' ) ); ?>"><?php esc_html_e( 'Separator between opening hours', 'physio-qt' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'separator' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'separator' ) ); ?>" type="text" value="<?php echo esc_attr( $separator ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'closed' ) ); ?>"><?php esc_html_e( 'Display text on closed days', 'physio-qt' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'closed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'closed' ) ); ?>" type="text" value="<?php echo esc_attr( $closed ); ?>" />
			</p>
			
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $highlight, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'highlight' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'highlight' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'highlight' ) ); ?>"><?php esc_html_e( 'Highlight closed text?', 'physio-qt' ); ?></label>
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $today, 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'today' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'today' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'today' ) ); ?>"><?php esc_html_e( 'Highlight today?', 'physio-qt' ); ?></label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'extra_info' ) ); ?>"><?php esc_html_e( 'Additional Information', 'physio-qt' ); ?>:</label><br />
				<small><?php esc_html_e( 'Describe lunchbreaks, holidays or vacantions for example', 'physio-qt' ); ?></small>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'extra_info' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'extra_info' ) ); ?>" type="text" value="<?php echo esc_attr( $extra_info ); ?>" />
			</p>
			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Opening_Hours" );' ) );
}