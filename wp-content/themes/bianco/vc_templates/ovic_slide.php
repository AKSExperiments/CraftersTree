<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Slide"
 */
if ( !class_exists( 'Shortcode_Ovic_Slide' ) ) {
	class Shortcode_Ovic_Slide extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_slide';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_slide', $atts ) : $atts;
			// Extract shortcode parameters.
			// extract( $atts );
			$css = '';
			if($atts['style'] == 'default'){
				$dot_color = (!empty($atts['dot_color'])) ? $atts['dot_color'] : '#03a9f4';
				$css = "
				.{$atts['ovic_vc_custom_id']}.ovic-slide .slick-arrow:hover,
				.{$atts['ovic_vc_custom_id']} .slick-dots li.slick-active button{
					background-color: {$dot_color};
				}
				";
			}
			

			return apply_filters( 'Shortcode_Ovic_Slide_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_slide', $atts ) : $atts;
			extract( $atts );
			$css_class   = array( 'ovic-slide', $atts['style'] );
			$css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_slide', $atts );
			/* START */
			$class_slide  = array( 'owl-slick', $atts['owl_rows_space'], $atts['owl_navigation_style'] );
			$owl_settings = Ovic_VC_Params::generate_slide_attr( $atts['carousel'] );
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<?php if ( $atts['slider_title'] ) {
					echo '<h3 class="ovic-title">';
					echo '<span class="text">' . esc_html( $atts['slider_title'] ) . '</span>';
					echo '</h3>';
				} ?>
                <div class="<?php echo esc_attr( implode( ' ', $class_slide ) ); ?>" <?php echo esc_attr( $owl_settings ); ?>>
					<?php echo wpb_js_remove_wpautop( $content ); ?>
                </div>
            </div>
			<?php
			$html = ob_get_clean();

			return apply_filters( 'Shortcode_Ovic_Slide', $html, $atts, $content );
		}
	}

	new Shortcode_Ovic_Slide();
}