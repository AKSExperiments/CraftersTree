<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Title"
 * @version 1.0.0
 */
if ( !class_exists( 'Shortcode_Ovic_Title' ) ) {
	class Shortcode_Ovic_Title extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_title';

		static public function add_css_generate( $atts ){
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_title', $atts ) : $atts;
            $css = '';
			if( !empty($atts['ovic_vc_custom_id'])){
                $ovic_vc_custom_id  = $atts['ovic_vc_custom_id'];
                $color              = $atts['under_color'];
                $css .= "
                .{$ovic_vc_custom_id} .ovic-title .title::after{
                    background-color: {$color};
                }
                .{$ovic_vc_custom_id} .ovic-title .title::before{
                    border-right-color: {$color};
                    border-bottom-color: {$color};
                }";
            }
			return apply_filters( 'Shortcode_Ovic_Title_css', $css, $atts );
		}

		public function output_html( $atts, $content = null ){
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_title', $atts ) : $atts;
			$css_class       = array( 'ovic-block-title', "type-{$atts['style']}" );
			$css_class[]     = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_title', $atts );
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                <?php if($atts['style'] == 'style-02' && $atts['sm_title']) :?>
                    <span class="sub-title"><span class="text"><?php echo esc_html( $atts['sm_title'] ); ?></span></span>
                <?php endif;?>
                <?php if ( $atts['title'] ) : ?>
                    <h3 class="ovic-title"><span class="title"><?php echo esc_html( $atts['title'] ); ?></span></h3>
                <?php endif; ?>
            </div>
			<?php
			$html = ob_get_clean();
			return apply_filters( 'Shortcode_Ovic_Title', $html, $atts, $content );
		}
	}
	new Shortcode_Ovic_Title();
}