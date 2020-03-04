<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Ovic instagram
 *
 * Displays instagram widget.
 *
 * @author   Khanh
 * @category Widgets
 * @package  Ovic/Widgets
 * @version  1.0.0
 * @extends  OVIC_Widget
 */
if ( !class_exists( 'Ovic_Instagram_Widget' ) ) {
	class Ovic_Instagram_Widget extends OVIC_Widget
	{
		/**
		 * Constructor.
		 */
		public function __construct()
		{
			$array_settings           = apply_filters( 'ovic_filter_settings_instagram_contact',
				array(
					'title'            => array(
						'type'  => 'text',
						'title' => esc_html__( 'Title', 'bianco-toolkit' ),
					),
					'image_source'     => array(
						'type'       => 'select',
						'title'      => esc_html__( 'Image Source', 'bianco-toolkit' ),
						'options'    => array(
							'instagram' => esc_html__( 'From Instagram', 'bianco-toolkit' ),
							'gallery'   => esc_html__( 'From Local Image', 'bianco-toolkit' ),
						),
						'default'    => 'instagram',
						'attributes' => array(
							'data-depend-id' => 'image_source',
						),
					),
					'image_gallery'    => array(
						'type'       => 'gallery',
						'title'      => esc_html__( 'Image Gallery', 'bianco-toolkit' ),
						'dependency' => array( 'image_source', '==', 'gallery' ),
					),
					'image_resolution' => array(
						'type'       => 'select',
						'title'      => esc_html__( 'Image Resolution', 'bianco-toolkit' ),
						'options'    => array(
							'thumbnail'           => esc_html__( 'Thumbnail', 'bianco-toolkit' ),
							'low_resolution'      => esc_html__( 'Low Resolution', 'bianco-toolkit' ),
							'standard_resolution' => esc_html__( 'Standard Resolution', 'bianco-toolkit' ),
						),
						'default'    => 'thumbnail',
						'dependency' => array( 'image_source', '==', 'instagram' ),
					),
					'id_instagram'     => array(
						'type'       => 'text',
						'title'      => esc_html__( 'ID Instagram', 'bianco-toolkit' ),
						'dependency' => array( 'image_source', '==', 'instagram' ),
					),
					'token'            => array(
						'type'       => 'text',
						'title'      => esc_html__( 'Token Instagram', 'bianco-toolkit' ),
						'dependency' => array( 'image_source', '==', 'instagram' ),
						'desc'       => wp_kses( sprintf( '<a href="%s" target="_blank">' . esc_html__( 'Get Token Instagram Here!', 'bianco-toolkit' ) . '</a>', 'http://instagram.pixelunion.net' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
					),
					'items_limit'      => array(
						'type'       => 'number',
						'default'    => '5',
						'dependency' => array( 'image_source', '==', 'instagram' ),
						'title'      => esc_html__( 'Items Instagram', 'bianco-toolkit' ),
					),
				)
			);
			$this->widget_cssclass    = 'widget-ovic-instagram ovic-instagram';
			$this->widget_description = esc_html__( 'Display the customer Instagram.', 'bianco-toolkit' );
			$this->widget_id          = 'widget_ovic_instagram';
			$this->widget_name        = esc_html__( 'Ovic: Instagram', 'bianco-toolkit' );
			$this->settings           = $array_settings;
			parent::__construct();
		}

		/**
		 * Output widget.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance )
		{
			$this->widget_start( $args, $instance );
			$items = array();
			$class = array( 'content-instagram' );
			if ( $instance['image_source'] == 'instagram' ) {
				$instagram = get_transient( 'ovic_instagram_media_' . intval( $instance['id_instagram'] ) );
				if ( empty($instagram) ) {
					$response  = wp_remote_get( 'https://api.instagram.com/v1/users/' . esc_attr( intval( $instance['id_instagram'] ) ) . '/media/recent/?access_token=' . esc_attr( $instance['token'] ) . '&count=' . esc_attr( $instance['items_limit'] ) );
					if ( !is_wp_error( $response ) && $response != '' ) {
						$response_body = json_decode( $response['body'] );
						$response_code = json_decode( $response['response']['code'] );
						if ( $response_code != 200 ) {
							echo '<p>' . esc_html__( 'User ID and access token do not match. Please check again.', 'bianco-toolkit' ) . '</p>';
						} else {
							$items_as_objects = isset( $response_body->data ) ? $response_body->data : array();
							if ( !empty( $items_as_objects ) ) {
								foreach ( $items_as_objects as $item_object ) {
									$item['link']        = $item_object->link;
									$item['user']        = $item_object->user;
									$item['type']        = $item_object->type;
									$item['time']        = $item_object->created_time;
									$item['description'] = $item_object->caption;
									$item['likes']       = $item_object->likes;
									$item['comments']    = $item_object->comments;
									$item['src']         = $item_object->images->{$instance['image_resolution']}->url;
									$item['width']       = $item_object->images->{$instance['image_resolution']}->width;
									$item['height']      = $item_object->images->{$instance['image_resolution']}->height;
									$items[]             = $item;
								}
							}
						}
						set_transient( 'ovic_instagram_media_' . intval( $instance['id_instagram'] ), $items, 12 * HOUR_IN_SECONDS );
					}
				} else {
					$items = $instagram;
				}
			} else {
				if ( $instance['image_gallery'] ) {
					$class[]       = 'ovic-gallery-image';
					$image_gallery = explode( ',', $instance['image_gallery'] );
					foreach ( $image_gallery as $image ) {
						$image_thumb = wp_get_attachment_image_src( $image, 'full' );
						$items[]     = array(
							'link'   => $image_thumb[0],
							'src'    => $image_thumb[0],
							'width'  => $image_thumb[1],
							'height' => $image_thumb[2],
						);
					}
				}
			}
			if ( isset( $items ) && !empty( $items ) ):
				ob_start(); ?>
                <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
					<?php foreach ( $items as $item ):
						$img_lazy = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%20" . $item['width'] . "%20" . $item['height'] . "%27%2F%3E";
						?>
                        <a href="<?php echo esc_url( $item['link'] ) ?>" class="item image-link">
                            <figure>
                                <img class="img-responsive lazy" src="<?php echo esc_attr( $img_lazy ); ?>"
                                     data-src="<?php echo esc_url( $item['src'] ); ?>"
									<?php echo image_hwstring( $item['width'], $item['height'] ); ?>
                                     alt="<?php echo get_the_title(); ?>"/>
                            </figure>
                        </a>
					<?php endforeach; ?>
                </div>
				<?php
				echo apply_filters( 'ovic_filter_widget_instagram', ob_get_clean(), $instance, $items );
			endif;
			$this->widget_end( $args );
		}
	}
}
/**
 * Register Widgets.
 *
 * @since 2.3.0
 */
function Ovic_Instagram_Widget()
{
	register_widget( 'Ovic_Instagram_Widget' );
}

add_action( 'widgets_init', 'Ovic_Instagram_Widget' );