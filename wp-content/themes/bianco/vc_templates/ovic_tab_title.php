<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Tab_Title"
 * @version 1.0.0
 */
if ( !class_exists( 'Shortcode_Ovic_Tab_Title' ) ) {
	class Shortcode_Ovic_Tab_Title extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_tab_title';

		static public function add_css_generate( $atts )
		{
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_tab_title', $atts ) : $atts;
			$css = 'body{bacground-color: red;}';
            $background_color = '#db4c52';
			extract( $atts );
            if ( $atts['type'] || $atts['tab_title']  ){
				$css .= "
				.{$atts['ovic_vc_custom_id']} .wrap-info-left .tab-title {
				    background-color: {$background_color};
				}
                .{$atts['ovic_vc_custom_id']} .wrap-info-left::after {
                	border-left-color: {$background_color};
                	border-bottom-color: {$background_color};
                }
				.{$atts['ovic_vc_custom_id']} {	
					border-bottom-color: {$background_color};
				}
                ";
			}
			
			return apply_filters( 'Ovic_Shortcode_Tab_Title_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_tab_title', $atts ) : $atts;
			$css_class   = array( 'ovic-tab-title' );
			$css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_tab_title', $atts );
            vc_icon_element_fonts_enqueue( $atts['type'] );
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
			<?php if ( $atts['type'] || $atts['tab_title']  ): ?>
				<div class="wrap-info-left">
                    <h3 class="tab-title">
                    <?php if ( $atts['type'] ): ?>
                        <?php $icon_name = $atts['type']; ?>
                        <span class="bainco_icon <?php echo esc_attr($atts["icon_{$icon_name}"]); ?>"></span>
                    <?php endif; ?>

                    <?php if ( $atts['tab_title'] ): ?>
                        <?php echo esc_html( $atts['tab_title'] ); ?>
                    <?php endif; ?>
                    </h3>
				</div>
			<?php endif; ?>
            </div>
			<?php
			$html = ob_get_clean();
			return apply_filters( 'Ovic_Shortcode_Tab_Title', $html, $atts, $content );
		}
	}

	new Shortcode_Ovic_Tab_Title();
}