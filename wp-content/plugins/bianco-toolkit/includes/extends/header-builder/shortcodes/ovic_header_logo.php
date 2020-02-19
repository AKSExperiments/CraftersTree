<?php
if ( !class_exists( 'Ovic_Shortcode_HeaderLogo' ) ) {
    class Ovic_Shortcode_HeaderLogo extends Ovic_Shortcode{
        /**
         * Shortcode name.
         *
         * @var  string
         */
        public $shortcode = 'headerlogo';

        static public function add_css_generate( $atts ){
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_headerlogo', $atts ) : $atts;

            // Extract shortcode parameters.
            extract( $atts );
            $class ='.'.$atts['ovic_custom_id'];
            $css ='';
            $css .= $class.' .logo-link{display: inline-block;}';

            if( $atts['logo_type'] =='text' && $atts['use_theme_fonts']!='yes'){
                $google_fonts_data = self::get_font_data($atts);
                if ( ( ! isset( $atts['use_theme_fonts'] ) || 'yes' !== $atts['use_theme_fonts'] ) && ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
                    $google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
                    $styles[] = 'font-family:' . $google_fonts_family[0];
                    $google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
                    $styles[] = 'font-weight:' . $google_fonts_styles[1];
                    $styles[] = 'font-style:' . $google_fonts_styles[2];
                    if( !empty($styles)){
                        foreach ($styles as $style){
                            $css .= $class.' {'.$style.';}';
                        }
                    }
                }

                // Font Size
                if( isset($atts['fontsize']) && $atts['fontsize']!=""){
                    if( is_numeric($atts['fontsize'])){
                        $css .= $class.' .logo-link{font-size:'.$atts['fontsize'].'px;}';
                    }else{
                        $css .= $class.' .logo-link{font-size:'.$atts['fontsize'].';}';
                    }
                }
                // Color
                if( isset($atts['textcolor']) && $atts['textcolor']!=""){
                    $css .= $class.' .logo-link{color:'.$atts['textcolor'].';}';
                }
                // letter_spacing
                if( isset($atts['letter_spacing']) && $atts['letter_spacing']!=""){
                    if( is_numeric($atts['letter_spacing'])){
                        $css .= $class.' .logo-link{letter-spacing:'.$atts['letter_spacing'].'px;}';
                    }else{
                        $css .= $class.' .logo-link{letter-spacing:'.$atts['letter_spacing'].';}';
                    }
                }

            }

            return $css;

            return apply_filters( 'Ovic_Shortcode_HeaderLogo_Css', $css, $atts );
        }

        public static function get_font_data( $atts){
            extract( $atts );
            $google_fonts_field = self::getParamData( 'google_fonts' );
            $google_fonts_obj = new Vc_Google_Fonts();
            $google_fonts_field_settings = isset( $google_fonts_field['settings'], $google_fonts_field['settings']['fields'] ) ? $google_fonts_field['settings']['fields'] : array();
            $google_fonts_data = strlen( $google_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings, $google_fonts ) : '';
            return $google_fonts_data;
        }
        /**
         * Get param value by providing key
         *
         * @param $key
         *
         * @since 4.4
         * @return array|bool
         */
        protected static function getParamData( $key ) {
            return WPBMap::getParam( 'ovic_headerlogo', 'google_fonts' );
        }

        public function output_html( $atts, $content = null )
        {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_headerlogo', $atts ) : $atts;
            // Extract shortcode parameters.
            extract( $atts );
            $css_class    = array( 'ovic-header-logo' );
            $css_class[]  = $atts['el_class'];
            $class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
            $css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_headerlogo', $atts );
            $logo_tyle = isset($atts['logo_type'])? $atts['logo_type']:'image';
            $logo = isset($atts['logo']) ? $atts['logo'] :0;
            $logo_text = isset($atts['logo_text']) ? $atts['logo_text'] : 'Logo';

            $google_fonts_data = self::get_font_data($atts);

            $settings = get_option( 'wpb_js_google_fonts_subsets' );
            if ( is_array( $settings ) && ! empty( $settings ) ) {
                $subsets = '&subset=' . implode( ',', $settings );
            } else {
                $subsets = '';
            }
            if ( ( ! isset( $atts['use_theme_fonts'] ) || 'yes' !== $atts['use_theme_fonts'] ) && isset( $google_fonts_data['values']['font_family'] ) ) {
                wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
            }
            ob_start();

            ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                <a href="<?php echo esc_url( home_url( '/' ));?>" class="logo-link">
                    <?php if( $logo_tyle =='image'):?>
                        <?php echo wp_get_attachment_image($logo,'full');?>
                    <?php endif;?>
                    <?php if( $logo_tyle =='text'):?>
                        <span class="logo-text"><?php echo esc_html( $logo_text);?></span>
                    <?php endif;?>
                </a>
            </div>
            <?php
            $html = ob_get_clean();

            return apply_filters( 'Ovic_Shortcode_HeaderLogo', $html, $atts, $content );
        }
    }

    new Ovic_Shortcode_HeaderLogo();
}