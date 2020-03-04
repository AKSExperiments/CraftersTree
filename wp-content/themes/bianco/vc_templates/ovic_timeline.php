<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Timeline"
 * @version 1.0.0
 */
if ( !class_exists( 'Shortcode_Ovic_Timeline' ) ) {
	class Shortcode_Ovic_Timeline extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_timeline';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_timeline', $atts ) : $atts;
			$css = '';
			return apply_filters( 'Shortcode_Ovic_Timeline_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_timeline', $atts ) : $atts;
			// Extract shortcode parameters.
			$style = '';
			extract( $atts );
			$css_class   = array( 'ovic-timeline', $style );
			$css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_timeline', $atts );
			/* START */
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<?php if ( $atts['title'] ): ?>
                    <h3 class="box-title"><?php echo esc_html( $atts['title'] ); ?></h3>
				<?php endif; ?>
                <div class="inner-content">
                    <div class="wrap-events">
						<?php echo wpb_js_remove_wpautop( $content ); ?>
                    </div>
                </div>
            </div>
			<?php
			$html = ob_get_clean();

			return apply_filters( 'Shortcode_Ovic_Timeline', $html, $atts, $content );
		}
	}

	new Shortcode_Ovic_Timeline();
}