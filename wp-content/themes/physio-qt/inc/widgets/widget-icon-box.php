<?php
/**
 * Widget: Icon Box
 *
 * @package physio-qt
 */

if ( ! class_exists( 'QT_Icon_Box' ) ) {
	class QT_Icon_Box extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false,
				esc_html__( 'QT: Icon Box', 'physio-qt' ),
				array(
					'description' => esc_html__( 'Icon Box widget for Header and Page Builder', 'physio-qt' ),
					'classname'   => 'widget-icon-box',
				)
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
			echo $args['before_widget'];

			// Open Link in new tab option
			$link_new_tab = empty( $instance['new_tab'] ) ? true : false;

			if ( ! empty ( $instance['link'] ) ) :
			?>
				<a class="icon-box" href="<?php echo esc_url_raw( $instance['link'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>>
			<?php else : ?>
				<div class="icon-box">
			<?php endif; ?>
				<div class="icon-box--icon">
					<i class="fa <?php echo esc_attr( $instance['icon'] ); ?>"></i>
				</div>
				<div class="icon-box--text">
					<h6 class="icon-box--title"><?php echo wp_kses_post( $instance['title'] ); ?></h6>
					<span class="icon-box--description"><?php echo wp_kses_post( $instance['text'] ); ?></span>
				</div>
			</<?php echo empty ( $instance['link'] ) ? 'div' : 'a'; ?>>

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

			$instance['title']   = wp_kses_post( $new_instance['title'] );
			$instance['text']    = wp_kses_post( $new_instance['text'] );
			$instance['link']    = esc_url_raw( $new_instance['link'] );
			$instance['icon']    = sanitize_key( $new_instance['icon'] );
			$instance['new_tab'] = ! empty( $new_instance['new_tab'] ) ? sanitize_key( $new_instance['new_tab'] ) : '';

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
			$title  = empty( $instance['title'] ) ? '' : $instance['title'];
			$text   = empty( $instance['text'] ) ? '' : $instance['text'];
			$link   = empty( $instance['link'] ) ? '' : $instance['link'];
			$icon   = empty( $instance['icon'] ) ? '' : $instance['icon'];
			$new_tab = empty( $instance['new_tab'] ) ? '' : $instance['new_tab'];
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon', 'physio-qt' ); ?>: <small><em><?php printf( esc_html__( 'See %s for all icon classes (example: fa-home)', 'physio-qt' ), '<a href="'. esc_url( 'http://fontawesome.io/icons/' ) .'" target="_blank">FontAwesome</a>' ); ?></em></small></label><br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'physio-qt' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text', 'physio-qt' ); ?>:</label> <br />
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Link', 'physio-qt' ); ?>: <small><em><?php esc_html_e( 'Optional', 'physio-qt' ); ?></em></small></label> <br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_url( $link ); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $new_tab, 'on'); ?> id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e( 'Open link in new browser tab?', 'physio-qt' ); ?></label>
			</p>
			<?php
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Icon_Box" );' ) );
}