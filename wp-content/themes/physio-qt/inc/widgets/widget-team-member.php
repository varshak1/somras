<?php
/**
 * Widget: Team Member
 *
 * @package physio-qt
 */

if ( ! class_exists( 'QT_Team_Member' ) ) {
	class QT_Team_Member extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false,
				esc_html__( 'QT: Team Member', 'physio-qt' ),
				array(
					'description' => esc_html__( 'Team member widget for Page Builder or Sidebar', 'physio-qt' ),
					'classname'   => 'widget-team-member',
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
		 	?>

			<div class="team-member">
				<?php if ( $instance['person_image'] ) : ?>
					<div class="team-member--image">
						<img src="<?php echo esc_url( $instance['person_image'] ); ?>" alt="<?php echo esc_attr( $instance['person_name'] ); ?>">
						<div class="team-member--social">
							<div class="overlay--center">
								<?php if ( $instance['facebook'] ) : ?>
									<a href="<?php echo esc_url( $instance['facebook'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>><i class="fa fa-facebook"></i></a>
								<?php endif; ?>
								<?php if ( $instance['twitter'] ) : ?>
									<a href="<?php echo esc_url( $instance['twitter'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>><i class="fa fa-twitter"></i></a>
								<?php endif; ?>
								<?php if ( $instance['linkedin'] ) : ?>
									<a href="<?php echo esc_url( $instance['linkedin'] ); ?>" <?php echo empty ( $instance['new_tab'] ) ? '' : 'target="_blank"'; ?>><i class="fa fa-linkedin"></i></a>
								<?php endif; ?>
								<?php if ( $instance['email'] ) : ?>
									<a href="mailto:<?php echo sanitize_email( $instance['email'] ); ?>"><i class="fa fa-envelope"></i></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<div class="team-member--content">
					<h4 class="team-member--name">
						<?php if ( ! empty ( $instance['person_link_url'] ) ) : ?>
							<a href="<?php echo esc_url( $instance['person_link_url'] ); ?>">
						<?php endif; ?>
						<?php echo esc_attr( $instance['person_name'] ); ?>
						<?php echo empty ( $instance['person_link_url'] ) ? '' : '</a>'; ?>
					</h4>
					<?php if ( ! empty ( $instance['person_tag'] ) ) : ?>
						<span class="team-member--tag"><?php echo esc_attr( $instance['person_tag'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty ( $instance['person_description'] ) ) : ?>
						<p class="team-member--description"><?php echo wp_kses_post( $instance['person_description'] ); ?></p>
					<?php endif; ?>
					<?php if ( $instance['person_link_text'] ) : ?>
						<a href="<?php echo esc_url( $instance['person_link_url'] ); ?>" class="text-link"><?php echo esc_attr( $instance['person_link_text'] ); ?></a>
					<?php endif; ?>
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

			$instance['person_name']		= sanitize_text_field( $new_instance['person_name'] );
			$instance['person_tag']			= sanitize_text_field( $new_instance['person_tag'] );
			$instance['person_description']	= wp_kses_post( $new_instance['person_description'] );
			$instance['person_image']		= esc_url_raw( $new_instance['person_image'] );
			$instance['facebook']			= sanitize_text_field( $new_instance['facebook'] );
			$instance['twitter']			= sanitize_text_field( $new_instance['twitter'] );
			$instance['linkedin']			= sanitize_text_field( $new_instance['linkedin'] );
			$instance['email']				= sanitize_text_field( $new_instance['email'] );
			$instance['new_tab']			= ! empty( $new_instance['new_tab'] ) ? sanitize_key( $new_instance['new_tab'] ) : '';

			$instance['person_link_url']	= sanitize_text_field( $new_instance['person_link_url'] );
			$instance['person_link_text']	= sanitize_text_field( $new_instance['person_link_text'] );
			
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
			$person_name		= empty( $instance['person_name'] ) ? '' : $instance['person_name'];
			$person_tag			= empty( $instance['person_tag'] ) ? '' : $instance['person_tag'];
			$person_description	= empty( $instance['person_description'] ) ? '' : $instance['person_description'];
			$person_image		= empty( $instance['person_image'] ) ? '' : $instance['person_image'];
			$facebook 			= empty( $instance['facebook'] ) ? '' : $instance['facebook'];
			$twitter 			= empty( $instance['twitter'] ) ? '' : $instance['twitter'];
			$linkedin 			= empty( $instance['linkedin'] ) ? '' : $instance['linkedin'];
			$email 				= empty( $instance['email'] ) ? '' : $instance['email'];
			$new_tab     		= empty( $instance['new_tab'] ) ? '' : $instance['new_tab'];

			$person_link_url	= empty( $instance['person_link_url'] ) ? '' : $instance['person_link_url'];
			$person_link_text	= empty( $instance['person_link_text'] ) ? '' : $instance['person_link_text'];
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'person_name' ) ); ?>"><?php esc_html_e( 'Person Name', 'physio-qt'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'person_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'person_name' ) ); ?>" type="text" value="<?php echo esc_attr( $person_name ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'person_tag' ) ); ?>"><?php esc_html_e( 'Person Tag', 'physio-qt'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'person_tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'person_tag' ) ); ?>" type="text" value="<?php echo esc_attr( $person_tag ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'person_image' ) ); ?>"><?php esc_html_e( 'Person Image URL', 'physio-qt' ); ?>:</label><br />
				<input class="widefat upload-file-url" id="<?php echo esc_attr( $this->get_field_id( 'person_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'person_image' ) ); ?>" type="text" value="<?php echo esc_attr( $person_image ); ?>" style="margin-bottom: 5px;" />
				<input type="button" class="qt-upload-file-button button" value="Upload File" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'person_description' ) ); ?>"><?php esc_html_e( 'Person Description', 'physio-qt'   ); ?>:</label><br>
				<textarea class="widefat" rows="3" id="<?php echo esc_attr( $this->get_field_id( 'person_description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'person_description' ) ); ?>"><?php echo esc_attr( $person_description ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'person_link_url' ) ); ?>"><?php esc_html_e( 'Link to URL (optional)', 'physio-qt'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'person_link_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'person_link_url' ) ); ?>" type="text" value="<?php echo esc_attr( $person_link_url ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'person_link_text' ) ); ?>"><?php esc_html_e( 'Link to Text (optional)', 'physio-qt'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'person_link_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'person_link_text' ) ); ?>" type="text" value="<?php echo esc_attr( $person_link_text ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>">Facebook <?php esc_html_e( 'URL', 'physio-qt'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>">Twitter <?php esc_html_e( 'URL', 'physio-qt'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>">LinkedIn <?php esc_html_e( 'URL', 'physio-qt'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" type="text" value="<?php echo esc_attr( $linkedin ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email Address', 'physio-qt'   ); ?>:</label><br>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $new_tab, 'on'); ?> id="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'new_tab' ) ); ?>" value="on" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'new_tab' ) ); ?>"><?php esc_html_e('Open social links in new browser tab?', 'physio-qt'   ); ?></label>
			</p>

			<?php 
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "QT_Team_Member" );' ) );
}