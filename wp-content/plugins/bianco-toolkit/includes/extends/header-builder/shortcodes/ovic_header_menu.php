<?php
if (!class_exists('Ovic_Shortcode_HeaderMenu')) {
    class Ovic_Shortcode_HeaderMenu extends Ovic_Shortcode
    {
        /**
         * Shortcode name.
         *
         * @var  string
         */
        public $shortcode = 'headermenu';

        static public function add_css_generate($atts)
        {
            $atts = function_exists('vc_map_get_attributes') ? vc_map_get_attributes('ovic_headermenu', $atts) : $atts;

            // Extract shortcode parameters.
            extract($atts);
            $class = '.' . $atts['ovic_custom_id'];
            $css = '';
            $css .= $class . ' .ovic-header-menu{margin:0; padding:0;}';
            $css .= $class . ' .ovic-header-menu li{list-style: none; position: relative;}';
            $css .= $class . ' .ovic-header-menu>li{display:inline-block;}';
            $css .= $class . ' .ovic-header-menu>li>a{display:inline-block;}';
            $css .= $class . ' .ovic-header-menu .sub-menu{
                                position: absolute;
                                top: 100%;
                                padding: 0;
                                margin: 0;
                                min-width: 200px;
                                z-index: 100;
                                background-color: #fff;
                                -webkit-transition: opacity .5s,-webkit-transform .5s;
                                transition: opacity .3s,transform .3s;
                                -webkit-transform: translate(0, 30px);
                                -moz-transform: translate(0, 30px);
                                -o-transform: translate(0, 30px);
                                -ms-transform: translate(0, 30px);
                                transform: translate(0, 30px);
                                opacity: 0;
                                display: block;
                                visibility: hidden;}';
            $css .= $class . ' .ovic-header-menu .sub-menu >li>a{
                                display:block;}';
            $css .= $class . ' .ovic-header-menu .sub-menu .sub-menu{
                                top: 0;
                                left:100%}';

            $css .= $class . ' .ovic-header-menu .menu-item:hover>.sub-menu{
                                -webkit-transform: translate(0, 0);
                                -moz-transform: translate(0, 0);
                                -o-transform: translate(0, 0);
                                -ms-transform: translate(0, 0);
                                transform: translate(0, 0);
                                opacity: 1;
                                visibility: visible;}';

            if( isset($atts['menu_align']) && $atts['menu_align'] != "" ){
                if($atts['menu_align']=='right'){
                    $css .= $class . ' .ovic-header-menu {float:right;}';
                }
                if($atts['menu_align']=='left'){
                    $css .= $class . ' .ovic-header-menu {float:left;}';
                }
                if($atts['menu_align']=='center'){
                    $css .= $class . ' .ovic-header-menu { display:table; margin:0 auto;}';
                }
            }


            $google_fonts_data = self::get_font_data($atts);
            if ((!isset($atts['use_theme_fonts']) || 'yes' !== $atts['use_theme_fonts']) && !empty($google_fonts_data) && isset($google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'])) {
                $google_fonts_family = explode(':', $google_fonts_data['values']['font_family']);
                $styles = array();
                $styles[] = 'font-family:' . $google_fonts_family[0];
                $google_fonts_styles = explode(':', $google_fonts_data['values']['font_style']);
                $styles[] = 'font-weight:' . $google_fonts_styles[1];
                $styles[] = 'font-style:' . $google_fonts_styles[2];
                if (!empty($styles)) {
                    foreach ($styles as $style) {
                        $css .= $class . ' .ovic-header-menu>li>a {' . $style . ';}';
                    }
                }
            }

            // Font Size
            if (isset($atts['fontsize']) && $atts['fontsize'] != "") {
                if (is_numeric($atts['fontsize'])) {
                    $css .= $class . ' .ovic-header-menu>li>a{font-size:' . $atts['fontsize'] . 'px;}';
                } else {
                    $css .= $class . ' .ovic-header-menu>li>a{font-size:' . $atts['fontsize'] . ';}';
                }
            }
            // Color
            if (isset($atts['textcolor']) && $atts['textcolor'] != "") {
                $css .= $class . ' .ovic-header-menu>li>a{color:' . $atts['textcolor'] . ';}';
            }
            // letter_spacing
            if (isset($atts['letter_spacing']) && $atts['letter_spacing'] != "") {
                if (is_numeric($atts['letter_spacing'])) {
                    $css .= $class . ' .ovic-header-menu>li>a{letter-spacing:' . $atts['letter_spacing'] . 'px;}';
                } else {
                    $css .= $class . ' .ovic-header-menu>li>a{letter-spacing:' . $atts['letter_spacing'] . ';}';
                }
            }
            // text_transform
            if (isset($atts['text_transform']) && $atts['text_transform'] != "") {
                $css .= $class . ' .ovic-header-menu>li>a{text-transform:' . $atts['text_transform'] . ';}';
            }
            // text_decoration
            if (isset($atts['text_decoration']) && $atts['text_decoration'] != "") {
                $css .= $class . ' .ovic-header-menu>li>a{text-decoration:' . $atts['text_decoration'] . ';}';
            }
            // Design item
            $class_editor = isset($atts['css_design_item']) ? vc_shortcode_custom_css_class($atts['css_design_item'], ' ') : '';
            $class_editor = trim($class_editor);
            $css_item_design = str_replace('.'.$class_editor, '', $atts['css_design_item']);
            if( $css_item_design!=""){
                $css .= $class . ' .ovic-header-menu>li>a'.$css_item_design;
            }

            /*Hover Settings*/
            // Color Hover
            if (isset($atts['textcolor_hover']) && $atts['textcolor_hover'] != "") {
                $css .= $class . ' .ovic-header-menu>li:hover>a{color:' . $atts['textcolor_hover'] . ';}';
                $css .= $class . ' .ovic-header-menu>li.active>a{color:' . $atts['textcolor_hover'] . ';}';
                $css .= $class . ' .ovic-header-menu>li.current-menu-item>a{color:' . $atts['textcolor_hover'] . ';}';
                $css .= $class . ' .ovic-header-menu>li.current-menu-parent>a{color:' . $atts['textcolor_hover'] . ';}';
            }
            // text_decoration
            if (isset($atts['text_decoration_hover']) && $atts['text_decoration_hover'] != "") {
                $css .= $class . ' .ovic-header-menu>li:hover>a{text-decoration:' . $atts['text_decoration_hover'] . ';}';
                $css .= $class . ' .ovic-header-menu>li.active>a{text-decoration:' . $atts['text_decoration_hover'] . ';}';
                $css .= $class . ' .ovic-header-menu>li.current-menu-item>a{text-decoration:' . $atts['text_decoration_hover'] . ';}';
                $css .= $class . ' .ovic-header-menu>li.current-menu-parent>a{text-decoration:' . $atts['text_decoration_hover'] . ';}';
            }

            $class_editor = isset($atts['css_design_item_hover']) ? vc_shortcode_custom_css_class($atts['css_design_item_hover'], ' ') : '';
            $class_editor = trim($class_editor);
            $css_item_design = str_replace('.'.$class_editor, '', $atts['css_design_item_hover']);
            if( $css_item_design!=""){
                $css .= $class . ' .ovic-header-menu>li:hover>a'.$css_item_design;
                $css .= $class . ' .ovic-header-menu>li.active>a'.$css_item_design;
                $css .= $class . ' .ovic-header-menu>li.current-menu-item>a'.$css_item_design;
                $css .= $class . ' .ovic-header-menu>li.current-menu-parent>a'.$css_item_design;
            }

            /* SUBMENU SETTINGS*/
            $submenu_width = (isset($atts['submenu_width']) && $atts['submenu_width']!="") ? $atts['submenu_width'] :200;
            if(is_numeric($submenu_width)){
                $css .= $class . ' .ovic-header-menu .sub-menu{min-width:'.$submenu_width.'px}';
            }else{
                $css .= $class . ' .ovic-header-menu .sub-menu{min-width:'.$submenu_width.'}';
            }

            // Color wapper
            if (isset($atts['submenu_textcolor_wapper']) && $atts['submenu_textcolor_wapper'] != "") {
                $css .= $class . ' .ovic-header-menu .sub-menu a{color:' . $atts['submenu_textcolor_wapper'] . ';}';
                $css .= $class . ' .ovic-header-menu .sub-menu{color:' . $atts['submenu_textcolor_wapper'] . ';}';
            }
            if (isset($atts['submenu_textcolor_wapper_hover']) && $atts['submenu_textcolor_wapper_hover'] != "") {
                $css .= $class . ' .ovic-header-menu .sub-menu a:hover{color:' . $atts['submenu_textcolor_wapper_hover'] . ';}';
            }

            $class_editor = isset($atts['css_design_sumenu']) ? vc_shortcode_custom_css_class($atts['css_design_sumenu'], ' ') : '';
            $class_editor = trim($class_editor);
            $css_design_sumenu = str_replace('.'.$class_editor, '', $atts['css_design_sumenu']);
            if( $css_design_sumenu!=""){
                $css .= $class . ' .ovic-header-menu .sub-menu'.$css_design_sumenu;
            }

            /*Item submenu*/

            $google_fonts_data = self::get_font_data($atts ,'google_fonts_submenu');


            if ((!isset($atts['use_theme_fonts_submenu']) || 'yes' !== $atts['use_theme_fonts_submenu']) && !empty($google_fonts_data) && isset($google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'])) {
                $google_fonts_family = explode(':', $google_fonts_data['values']['font_family']);
                $styles = array();
                $styles[] = 'font-family:' . $google_fonts_family[0];
                $google_fonts_styles = explode(':', $google_fonts_data['values']['font_style']);
                $styles[] = 'font-weight:' . $google_fonts_styles[1];
                $styles[] = 'font-style:' . $google_fonts_styles[2];
                if (!empty($styles)) {
                    foreach ($styles as $style) {
                        $css .= $class . ' .ovic-header-menu .sub-menu>li>a {' . $style . ';}';
                    }
                }
            }

            // Font Size
            if (isset($atts['fontsize_submenu']) && $atts['fontsize_submenu'] != "") {
                if (is_numeric($atts['fontsize_submenu'])) {
                    $css .= $class . ' .ovic-header-menu .sub-menu>li>a{font-size:' . $atts['fontsize_submenu'] . 'px;}';
                } else {
                    $css .= $class . ' .ovic-header-menu .sub-menu>li>a{font-size:' . $atts['fontsize_submenu'] . ';}';
                }
            }
            // Color
            if (isset($atts['textcolor_submenu']) && $atts['textcolor_submenu'] != "") {
                $css .= $class . ' .ovic-header-menu .sub-menu>li>a{color:' . $atts['textcolor_submenu'] . ';}';
            }

            // letter_spacing
            if (isset($atts['letter_spacing_submnu']) && $atts['letter_spacing_submnu'] != "") {
                if (is_numeric($atts['letter_spacing_submnu'])) {
                    $css .= $class . ' .ovic-header-menu .sub-menu>li>a{letter-spacing:' . $atts['letter_spacing_submnu'] . 'px;}';
                } else {
                    $css .= $class . ' .ovic-header-menu .sub-menu>li>a{letter-spacing:' . $atts['letter_spacing_submnu'] . ';}';
                }
            }
            // text_transform
            if (isset($atts['text_transform_submenu']) && $atts['text_transform_submenu'] != "") {
                $css .= $class . ' .ovic-header-menu .sub-menu>li>a{text-transform:' . $atts['text_transform_submenu'] . ';}';
            }
            // text_decoration
            if (isset($atts['text_decoration_submenu']) && $atts['text_decoration_submenu'] != "") {
                $css .= $class . ' .ovic-header-menu .sub-menu>li>a{text-decoration:' . $atts['text_decoration_submenu'] . ';}';
            }
            // Design item
            $class_editor = isset($atts['css_design_item_submenu']) ? vc_shortcode_custom_css_class($atts['css_design_item_submenu'], ' ') : '';
            $class_editor = trim($class_editor);
            $css_item_design = str_replace('.'.$class_editor, '', $atts['css_design_item_submenu']);
            if( $css_item_design!=""){
                $css .= $class . ' .ovic-header-menu .sub-menu>li>a'.$css_item_design;
            }

            /*Submenu Hover*/
            // Color
            if (isset($atts['textcolor_submenu_hover']) && $atts['textcolor_submenu_hover'] != "") {
                $css .= $class . ' .ovic-header-menu .sub-menu>li:hover>a{color:' . $atts['textcolor_submenu_hover'] . ';}';
                $css .= $class . ' .ovic-header-menu .sub-menu>li.current-menu-item>a{color:' . $atts['textcolor_submenu_hover'] . ';}';
            }
            // text_decoration
            if (isset($atts['text_decoration_submenu_hover']) && $atts['text_decoration_submenu_hover'] != "") {
                $css .= $class . ' .ovic-header-menu .sub-menu>li:hover>a{text-decoration:' . $atts['text_decoration_submenu_hover'] . ';}';
                $css .= $class . ' .ovic-header-menu .sub-menu>li.current-menu-item>a{text-decoration:' . $atts['text_decoration_submenu_hover'] . ';}';
            }
            // Design item hover
            $class_editor = isset($atts['css_design_item_submenu_hover']) ? vc_shortcode_custom_css_class($atts['css_design_item_submenu_hover'], ' ') : '';
            $class_editor = trim($class_editor);
            $css_item_design = str_replace('.'.$class_editor, '', $atts['css_design_item_submenu_hover']);
            if( $css_item_design!=""){
                $css .= $class . ' .ovic-header-menu .sub-menu>li:hover>a'.$css_item_design;
                $css .= $class . ' .ovic-header-menu .sub-menu>li.current-menu-item>a'.$css_item_design;
            }


            return apply_filters('Ovic_Shortcode_HeaderMenu_Css', $css, $atts);
        }

        public static function get_font_data($atts ,$key ='google_fonts')
        {
            extract($atts);
            $google_fonts_field = self::getParamData($key);
            $google_fonts_obj = new Vc_Google_Fonts();
            $google_fonts_field_settings = isset($google_fonts_field['settings'], $google_fonts_field['settings']['fields']) ? $google_fonts_field['settings']['fields'] : array();
            $google_fonts_data = strlen($atts[$key]) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes($google_fonts_field_settings, $atts[$key]) : '';
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
        protected static function getParamData($key)
        {
            return WPBMap::getParam('ovic_headermenu', $key);
        }

        public function output_html($atts, $content = null)
        {
            $atts = function_exists('vc_map_get_attributes') ? vc_map_get_attributes('ovic_headermenu', $atts) : $atts;
            // Extract shortcode parameters.
            extract($atts);
            $css_class = array('ovic-header-menu-wapper');
            $css_class[] = $atts['el_class'];
            $class_editor = isset($atts['css']) ? vc_shortcode_custom_css_class($atts['css'], ' ') : '';
            $css_class[] = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_headermenu', $atts);

            $google_fonts_data = self::get_font_data($atts);

            $settings = get_option('wpb_js_google_fonts_subsets');
            if (is_array($settings) && !empty($settings)) {
                $subsets = '&subset=' . implode(',', $settings);
            } else {
                $subsets = '';
            }
            if ((!isset($atts['use_theme_fonts']) || 'yes' !== $atts['use_theme_fonts']) && isset($google_fonts_data['values']['font_family'])) {
                wp_enqueue_style('vc_google_fonts_' . vc_build_safe_css_class($google_fonts_data['values']['font_family']), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets);
            }

            $google_fonts_data = self::get_font_data($atts,'google_fonts_submenu');
            // Load font sub menu
            if ((!isset($atts['use_theme_fonts_submenu']) || 'yes' !== $atts['use_theme_fonts_submenu']) && isset($google_fonts_data['values']['font_family'])) {
                wp_enqueue_style('vc_google_fonts_' . vc_build_safe_css_class($google_fonts_data['values']['font_family']), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets);
            }

            $nav_menu = !empty($atts['nav_menu']) ? wp_get_nav_menu_object($atts['nav_menu']) : false;

            if (!$nav_menu) {
                return;
            }

            $nav_menu_args = array(
                'fallback_cb' => '',
                'menu'        => $nav_menu,
                'megamenu'    => true,
                'menu_class'  => 'ovic-header-menu'
            );



            ob_start();

            ?>
            <div class="<?php echo esc_attr(implode(' ', $css_class)); ?>">
                <?php wp_nav_menu($nav_menu_args); ?>
            </div>
            <?php
            if( isset($atts['enable_my_account']) && $atts['enable_my_account']=='yes'){
               // add_filter('wp_nav_menu_items',array($this,'my_account_link'),10,2);
            }
            $html = ob_get_clean();

            return apply_filters('Ovic_Shortcode_HeaderMenu', $html, $atts, $content);
        }
        public function my_account_link( $items, $args){
            $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
            $myaccount_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
            $woocommerce_enable_myaccount_registration = get_option('woocommerce_enable_myaccount_registration');
            $login_text = esc_html__('Login','bianco-toolkit');
            if( $woocommerce_enable_myaccount_registration == "yes" ){
                $login_text .= esc_html__(' or Register','bianco-toolkit');
            }
            $logout_url = "#";

            if ( $myaccount_page_id ) {
                if( function_exists( 'wc_get_page_id' ) ){
                    $logout_url = wp_logout_url( get_permalink( wc_get_page_id( 'shop' ) ) );
                }
                if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ){
                    $logout_url = str_replace( 'http:', 'https:', $logout_url );
                }
            }
            ob_start();
            if(is_user_logged_in()){
                $currentUser = wp_get_current_user();
                ?>
                <li class="menu-item-has-children menu-item">
                    <a href="<?php echo esc_url( $myaccount_link );?>">
                        <span class="icon fa fa-user" aria-hidden="true"></span>
                        <?php esc_html_e('Hi, ','bianco-toolkit'); echo esc_html($currentUser->display_name); ?>
                    </a>
                    <?php if( function_exists( 'wc_get_account_menu_items' )):?>
                        <ul class="sub-menu">
                            <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                                <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif;?>
                </li>
                <?php
            }else{
                ?>
                <li class="menu-item">
                    <a href="<?php echo esc_url( $myaccount_link );?>">
                        <span class="icon fa fa-user" aria-hidden="true"></span>
                        <?php echo esc_html($login_text);?>
                    </a>
                </li>
                <?php
            }
            $html =  ob_get_contents();
            return $items.$html;
        }
    }

    new Ovic_Shortcode_HeaderMenu();
}