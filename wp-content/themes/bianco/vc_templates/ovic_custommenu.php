<?php
if ( !class_exists( 'Shortcode_Ovic_Custommenu' ) ) {
	class Shortcode_Ovic_Custommenu extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_custommenu';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_custommenu', $atts ) : $atts;
			// Extract shortcode parameters.
            // extract( $atts );
            $css = '';
			if($atts['style_menu'] =='twice-inline'){
                $hover_color = (!empty($atts['hover_color'])) ? $atts['hover_color'] : '#03a9f4';
				$css = ".{$atts['ovic_vc_custom_id']}.ovic-custommenu.twice-inline .ovic-menu li a:hover{
					color: {$hover_color};
				}";
			}
            if($atts['style_menu'] =='vertical-mega'){
                $url = get_template_directory_uri().'/assets/images/vertical-menu.png';
                $css = ".{$atts['ovic_vc_custom_id']} .widget_nav_menu .widgettitle::before{
					content: '';
					background-image: url({$url});
				}";
            }
			return apply_filters( 'Shortcode_Ovic_Custommenu_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_custommenu', $atts ) : $atts;
			$style_menu ='';
			// Extract shortcode parameters.
			$show_count_items = '';
			extract( $atts );
			$css_class    = array( 'ovic-custommenu vc_wp_custommenu wpb_content_element', $style_menu );
			$css_class[]  = $atts['el_class'];
			$class_editor = isset( $atts['css'] ) ? vc_shortcode_custom_css_class( $atts['css'], ' ' ) : '';
			$css_class[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_editor, 'ovic_custommenu', $atts );
			if($style_menu == 'mega-child-02' || $style_menu == 'mega-child-01'){
                $css_class[] = 'mega-child-style';
            }
			$type = 'WP_Nav_Menu_Widget';
			$args = array();
			global $wp_widget_factory;
            ob_start();
			?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>" data-show_count_items="<?php echo intval($show_count_items); ?>" data-text_more="<?php echo esc_attr__('All Categories', 'bianco')?>">
                <?php
                if($style_menu == 'mega-child-02' && $atts['lbl_top']) {
                    $image = apply_filters('ovic_resize_image', $atts['lbl_top'], false, false, true, true);
                    $image['img'] = (empty($image['img']))?  '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="50" height="52" alt="bianco placeholder">': $image['img'];
                    echo wp_specialchars_decode("<div class='top-icon'>{$image['img']}</div>");
                }
                if($style_menu == 'vertical-mega'){
                    $current_menu = $atts['nav_menu'];
                    add_filter('widget_nav_menu_args',function ($nav_menu_args, $nav_menu, $args, $instance ) use($current_menu){
                        if($current_menu == $instance['nav_menu']) $nav_menu_args['menu_class']='ovic-clone-mobile-menu';
                        return $nav_menu_args;
                    } ,10,4);
                }
                ?>
                <?php
                if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[$type] ) ) {
                    the_widget( $type, $atts, $args );
                } else {
                    echo esc_html__( 'No Content.', 'bianco' );
                }
                ?>
                <?php
                if($style_menu == 'vertical-mega'){
                    remove_all_filters('widget_nav_menu_args');
                    if($atts['menu_banner']){
                        $image = apply_filters('ovic_resize_image',$atts['menu_banner'] , false, false, true, true);
                        $image['img'] = (empty($image['img']))?  '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="270" height="198" alt="bianco placeholder">': $image['img'];
                        echo wp_specialchars_decode("<div class='menu-banner'>{$image['img']}</div>");
                    }
                }
                ?>
            </div>
			<?php
			$html = ob_get_clean();
			return apply_filters( 'Shortcode_Ovic_Custommenu', $html, $atts, $content );
		}
	}
	new Shortcode_Ovic_Custommenu();
}