<?php
if ( !class_exists( 'Shortcode_Ovic_Banner' ) ) {
	class Shortcode_Ovic_Banner extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_banner';

        static public function add_css_generate( $atts ){
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_banner', $atts ) : $atts;
            $css = '';
            if( !empty($atts['ovic_vc_custom_id'])) {
                $shortcode_class_name   = $atts['ovic_vc_custom_id'];
                $color                  = $atts['btn_color'];
                if ($atts['layout'] == 'style39') {
                    $css = ".wrap-bianco-banner.{$shortcode_class_name} .banner-link::before{
                                background-color: {$color};
                            }";
                }
            }
            return apply_filters( 'Shortcode_Ovic_Banner_css', $css, $atts );
        }

		public function output_html( $atts, $content = null ){
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_banner', $atts ) : $atts;
			$css_class    = array( 'wrap-bianco-banner' );
			$class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
			$css_class[]  = "banner-{$atts['layout']}";
			if( $atts['layout'] == 'style38'){
                $css_class[]  = $atts['banner_effect_3'];
                $css_class[]  = $atts['layout_type'];
            }elseif ( in_array( $atts['layout'], array( 'style36', 'style37') )){
                $css_class[]  = $atts['banner_effect_2'];
            }else{
                $css_class[]  = !empty( $atts['banner_effect'] ) ? $atts['banner_effect'] : 'no-effect';
            }
			$css_class[]  = $atts['el_class'];
			$css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_banner', $atts );

			/*Unify banners style 8,9,10,11 to the same banner structure*/
            $group_unify    = array( 'style8', 'style9', 'style10', 'style11' );
            $style = $atts['layout'];
            if(in_array( $style, $group_unify )){
                $style = 'unify';
            }
            elseif ($style == 'style31'){
                /*Banner style 31 has the same structure with banner style1*/
                $css_class[] = 'banner-style1';
                $style = 'style1';
            }
            elseif ($style == 'style32'){
                /*Banner style 32 has the same structure with banner style2*/
                $css_class[] = 'banner-style2';
                $style = 'style2';
            }
            elseif ($style == 'style33'){
                /*Banner style 33 has the same structure with banner style3*/
                $css_class[] = 'banner-style3';
                $style = 'style3';
            }
            /*remove empty elements*/
            array_filter($css_class);
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<?php bianco_get_template("templates/banner/{$style}.php", $atts); ?>
            </div>
			<?php
			return apply_filters( 'Shortcode_Ovic_Banner', ob_get_clean(), $atts, $content );
		}
	}
	new Shortcode_Ovic_Banner();
}