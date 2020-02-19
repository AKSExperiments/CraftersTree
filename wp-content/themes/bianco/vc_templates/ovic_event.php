<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Event"
 * @version 1.0.0
 */
if ( !class_exists( 'Shortcode_Ovic_Event' ) ) {
	class Shortcode_Ovic_Event extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_event';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_event', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = '';

			return apply_filters( 'Shortcode_Ovic_Event_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_event', $atts ) : $atts;
			// Extract shortcode parameters.
			$year              = 'event';
			$arr_convert_month = array(
				'01' => 'Jan',
				'02' => 'Feb',
				'03' => 'Mar',
				'04' => 'Apr',
				'05' => 'May',
				'06' => 'Jun',
				'07' => 'Jul',
				'08' => 'Aug',
				'09' => 'Sep',
				'10' => 'Oct',
				'11' => 'Nov',
				'12' => 'Dec',
			);
			extract( $atts );
			$css_class   = array( 'ovic-event' );
			$css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_event', $atts );
			$events         = vc_param_group_parse_atts( $atts['events'] );
			$contentt_empty = empty( $events );
			if ( $contentt_empty ) {
				$css_class[] = 'emty_content';
			}
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                <span class="event-title"><?php echo esc_html( $year ); ?></span>
				<?php if ( !$contentt_empty ): ?>
					<?php $offset = 42; ?>
                    <ul class="events">
						<?php foreach ( $events as $event ): ?>
							<?php $class_ev = 'event media-type-' . $event['type']; ?>
							<?php $class_ev .= ' el-level-' . $event['month']; ?>
                            <li class="<?php echo esc_attr( $class_ev ); ?>">
                                <div class="event-month">
                                    <span class="text"><?php echo esc_html( $arr_convert_month[$event['month']] ); ?></span>
                                    <div class="dot"><span></span></div>
                                    <div class="string"><span
                                                style="height: <?php echo esc_attr( $offset ) ?>px;"></span></div>
                                </div>
                                <div class="content-event">
									<?php if ( $event['type'] == 'image' ): ?>
										<?php
										$image_atch = array( 'url' => '', 'width' => 0, 'height' => 0, 'img' => '' );
										if ( !empty( $event['image'] ) ):
											$image_atch = apply_filters( 'ovic_resize_image', $event['image'], false, false, true, true );
										endif;
										?>
										<?php if ( $image_atch['img'] ): ?>
											<?php echo wp_specialchars_decode( $image_atch['img'] ); ?>
										<?php endif; ?>
									<?php else: ?>
                                        <p class="text-content"><?php echo wp_specialchars_decode( $event['desc'] ); ?></p>
									<?php endif; ?>
                                </div>
                            </li>
							<?php $offset += 183; ?>
						<?php endforeach; ?>
                    </ul>
				<?php endif; ?>
            </div>
			<?php
			$html = ob_get_clean();

			return apply_filters( 'Shortcode_Ovic_Event', $html, $atts, $content );
		}
	}

	new Shortcode_Ovic_Event();
}