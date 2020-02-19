<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Tabs"
 */
if ( !class_exists( 'Shortcode_Ovic_Tabs' ) ) {
	class Shortcode_Ovic_Tabs extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_tabs';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_tabs', $atts ) : $atts;
            $border_active_color = Bianco_Functions::get_option( 'ovic_main_color', '#63ab04' );
            $bg_active_color = $border_active_color;
            $style = $tab_title ='';
            $arr_except = array('on_right','on_right_2');
			extract( $atts );
			if(!in_array( $style, $arr_except)){
                $css = "
                .{$atts['ovic_vc_custom_id']} .tab-link li{
                    border-color: {$border_active_color};
                }
                .{$atts['ovic_vc_custom_id']} .tab-link li.active::before,
                .{$atts['ovic_vc_custom_id']} .tab-link li.active::after{
                    background-color: {$border_active_color};
                }
                ";
            }else{
                $css = "
                .{$atts['ovic_vc_custom_id']} .title-tab-right span::before,
                .{$atts['ovic_vc_custom_id']} .title-tab-right span::after,
                .{$atts['ovic_vc_custom_id']} .tab-link li.active{
                    background-color: {$bg_active_color};
                }
                ";
            }
			return apply_filters( 'Shortcode_Ovic_Tabs_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts  = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_tabs', $atts ) : $atts;
			$style = $tab_title ='';
			extract( $atts );
            $css_class = array('ovic-tabs');
			if($style == 'on_right_2'){
                $style = 'on_right';
                $css_class[] = 'remove-throw-line';
            }
            $css_class[] = $style;
			$css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_tabs', $atts );
			$sections    = self::get_all_attributes( 'vc_tta_section', $content );
            $link        = !empty( $atts['link_view_more'] ) ? vc_build_link( $atts['link_view_more'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
			$rand        = uniqid();
			ob_start(); ?>
			<div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                <?php if ( $style == 'on_right' && $tab_title) : ?>
                    <div class="wrap-tb-title title-tab-right">
                        <h2><span><?php echo esc_html($tab_title); ?></span></h2>
                    </div>
                <?php endif; ?>
                <?php if ( $sections && is_array( $sections ) && count( $sections ) > 0 ): ?>
                    <div class="tab-head ovic-dropdown">
                        <ul class="tab-link">
                            <?php foreach ( $sections as $key => $section ) : ?>
                                <?php
                                /* Get icon from section tabs */
                                $section['i_type'] = isset( $section['i_type'] ) ? $section['i_type'] : 'fontawesome';
                                $add_icon          = isset( $section['add_icon'] ) ? $section['add_icon'] : '';
                                $position_icon     = isset( $section['i_position'] ) ? $section['i_position'] : '';
                                $icon_html         = $this->constructIcon( $section );
                                $section_id        = $section['tab_id'] . '-' . $rand;
                                $class_active      = '';
                                $class_loaded      = '';
                                if ( $key == $atts['active_section'] ) {
                                    $class_active = 'active';
                                    $class_loaded = 'loaded';
                                }
                                ?>
                                <li class="<?php echo esc_attr( $class_active ); ?>">
                                    <a class="<?php echo esc_attr( $class_loaded ); ?>"
                                       data-ajax="<?php echo esc_attr( $atts['ajax_check'] ) ?>"
                                       data-animate="<?php echo esc_attr( $atts['css_animation'] ); ?>"
                                       data-section="<?php echo esc_attr( $section['tab_id'] ); ?>"
                                       data-id="<?php echo get_the_ID(); ?>"
                                       href="#<?php echo esc_attr( $section_id ); ?>">
                                        <?php if ( isset( $section['title_image'] ) ) : ?>
                                            <figure>
                                                <?php
                                                $image_thumb = apply_filters( 'ovic_resize_image', $section['title_image'], false, false, true, true );
                                                echo wp_specialchars_decode( $image_thumb['img'] );
                                                ?>
                                            </figure>
                                        <?php else : ?>
                                            <?php echo ( 'true' === $add_icon && 'right' !== $position_icon ) ? $icon_html : ''; ?>
                                            <span><?php echo esc_html( $section['title'] ); ?></span>
                                            <?php echo ( 'true' === $add_icon && 'right' === $position_icon ) ? $icon_html : ''; ?>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="tab-container">
                        <?php foreach ( $sections as $key => $section ): ?>
                            <?php
                            $section_id = $section['tab_id'] . '-' . $rand;
                            $active_tab = array( 'tab-panel' );
                            if ( $key == $atts['active_section'] )
                                $active_tab[] = 'active';
                            ?>
                            <div class="<?php echo esc_attr( implode( ' ', $active_tab ) ); ?>"
                                 id="<?php echo esc_attr( $section_id ); ?>">
                                <?php if ( $atts['ajax_check'] == '1' ) {
                                    if ( $key == $atts['active_section'] ) {
                                        echo do_shortcode( $section['content'] );
                                    }
                                } else {
                                    echo do_shortcode( $section['content'] );
                                } ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if ( $style == 'on_left' && $link['title'] ) {
                        $_target = '';
                        if ( $link['target'] )
                            $_target = 'target="' . $link["target"] . '"'; ?>
                    <div class="wrap-tab-link">
                        <a class="custom-tab-link btn-link btn" href="<?php echo esc_url( $link['url'] ); ?>" <?php echo esc_attr( $_target ); ?> "><?php echo esc_html( $link['title'] ); ?></a>
                    </div>
                <?php } ?>
            </div>

			<?php $html = ob_get_clean(); ?>
            <?php
			return apply_filters( 'Shortcode_Ovic_Tabs', $html, $atts, $content );
		}
	}

	new Shortcode_Ovic_Tabs();
}