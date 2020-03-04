<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
if ( !class_exists( 'Ovic_Widget_Title' ) ) {
	class Ovic_Widget_Title extends WC_Widget
	{
		public function __construct()
		{
			$this->widget_cssclass    = 'widget-ovic-title';
			$this->widget_description = esc_html__( 'Make the title', 'bianco-toolkit' );
			$this->widget_id          = 'widget_ovic_title';
			$this->widget_name        = esc_html__( 'Ovic: Title', 'bianco-toolkit' );
			parent::__construct();
		}

		public function widget( $args, $instance )
		{
			$title = ( !empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Filter', 'bianco-toolkit' );
			ob_start();
			echo $args['before_widget'];
			if ( $instance['title'] ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo $args['after_widget'];
		}

		public function update( $new_instance, $old_instance )
		{
			$instance = $old_instance;
			if ( !empty( $new_instance['title'] ) )
				$instance['title'] = sanitize_title( $new_instance['title'] );
			return $instance;
		}

		public function form( $instance )
		{
			$defaults = array( 'title' => esc_html__( 'Filter', 'bianco' ), );
			$instance = wp_parse_args( (array)$instance, $defaults );
			?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'bianco-toolkit' ); ?></label>
                <input type="text" class="widefat " id="<?php echo $this->get_field_id( 'title' ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                       value="<?php echo esc_attr( $instance['title'] ); ?>"/>
            </p>
			<?php
		}
	}
}
add_action( 'widgets_init', 'register_ovic_title_widget' );
function register_ovic_title_widget()
{
	register_widget( 'Ovic_Widget_Title' );
}