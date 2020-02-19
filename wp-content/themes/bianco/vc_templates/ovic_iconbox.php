<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Shortcode_Ovic_Iconbox"
 * @version 1.0.0
 */
if ( !class_exists( 'Shortcode_Ovic_Iconbox' ) ) {
	class Shortcode_Ovic_Iconbox extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_iconbox';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_iconbox', $atts ) : $atts;
			// Extract shortcode parameters.
			//extract( $atts );
			$css = '';

			return apply_filters( 'Shortcode_Ovic_Iconbox_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_iconbox', $atts ) : $atts;
			// Extract shortcode parameters.
			$icon             = '';
			$title            = '';
			$subtitle         = '';
			$s_title          = '';
			$style            = 'default';
			$type             = '';
			$gutter_group     = '';
			$s_subtitle       = '';
			$image            = '';
			$background_color = '';
			$icon_group       = '';
			$icon_group_2     = '';
			$list_icons       = array();
			$image_atch       = array( 'url' => '', 'width' => 0, 'height' => 0, 'img' => '' );
			extract( $atts );
			$css_class   = array( 'ovic-iconbox equal-container better-height' );
			$css_class[] = 'layout-' . $style;
			$css_class[] = $gutter_group;
            $css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_iconbox', $atts );
            if ( $type && $type != 'image' ) {
				$icon = $atts['icon_' . $type];
				vc_icon_element_fonts_enqueue( $type );
			} else {
				if ( $image ) {
					$image_atch = apply_filters( 'ovic_resize_image', $image, false, false, true, true );
				}
			}
			ob_start(); ?>
			<?php if ( $style == 'group'): ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<?php $list_icons = vc_param_group_parse_atts( $icon_group ); ?>
				<?php if ( !empty( $list_icons ) ) { ?>
                    <ul class="lst-item">
						<?php foreach ( $list_icons as $index => $value ) { ?>
							<?php
							$inline = '';
                            $inline .= !empty($value['background_color'])? "background-color:{$value['background_color']};" : '';
                            $inline .= !empty($value['border_color'])    ? " border-color:{$value['border_color']};" : '';
							?>
                            <li class="ion-item <?php echo esc_attr( "item-{$index}" ); ?> equal-elem"
                                style="<?php echo esc_attr( $inline ); ?>">
                                <div class="content-left">
									<?php if ( $value['type'] && $value['type'] != 'image' ) { ?>
										<?php $icon = $value["icon_{$type}"]; ?>
										<?php vc_icon_element_fonts_enqueue( $value['type'] ); ?>
                                        <span class="icon <?php echo esc_attr( $icon ); ?>"></span>
									<?php } else { ?>
										<?php if ( $image ) { ?>
											<?php $image_atch = apply_filters( 'ovic_resize_image', $image, false, false, true, true ); ?>
											<?php echo wp_specialchars_decode( $image_atch['img'] ); ?>
										<?php } ?>
									<?php } ?>
                                </div>
                                <div class="content-right">
									<?php if ( $value['title'] ) { ?>
                                        <b class="box-title"><?php echo esc_html( $value['title'] ); ?></b>
									<?php } ?>
									<?php if ( $value['subtitle'] ) { ?>
                                        <p class="desc"><?php echo esc_html( $value['subtitle'] ); ?></p>
									<?php } ?>
                                </div>
                            </li>
						<?php } ?>
                    </ul>
				<?php } ?>
            </div>
            <?php elseif($style == 'group-t2'): ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                <?php $list_icons = vc_param_group_parse_atts( $icon_group_2 ); ?>
                <?php if ( !empty( $list_icons ) ) { ?>
                    <ul class="lst-item">
                        <?php foreach ( $list_icons as $index => $value ) { ?>
                            <?php $inline = !empty($value['bg_color'])? "background-color:{$value['bg_color']};" : ''; ?>
                            <li class="ion-item <?php echo esc_attr( "item-{$index}" ); ?> equal-elem" >
                                <div class="content-left">
                                    <?php if ( $value['type'] && $value['type'] != 'image' ) { ?>
                                        <?php $icon = $value["icon_{$type}"]; ?>
                                        <?php vc_icon_element_fonts_enqueue( $value['type'] ); ?>
                                        <span class="icon <?php echo esc_attr( $icon ); ?>" style="<?php echo esc_attr( $inline ); ?>"></span>
                                    <?php } else { ?>
                                        <?php if ( $image ) { ?>
                                            <?php $image_atch = apply_filters( 'ovic_resize_image', $image, false, false, true, true ); ?>
                                            <?php echo wp_specialchars_decode( $image_atch['img'] ); ?>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="content-right">
                                    <?php if ( $value['title'] ) { ?>
                                        <b class="box-title"><?php echo esc_html( $value['title'] ); ?></b>
                                    <?php } ?>
                                    <?php if ( $value['subtitle'] ) { ?>
                                        <p class="desc"><?php echo esc_html( $value['subtitle'] ); ?></p>
                                    <?php } ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
            <?php else: ?>
                <?php $css_class[] = 'default'; ?>
                <?php  $style = ($style == '04' || $style == '05')? "" : "background-color: {$background_color};"; ?>
                <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
                    <div class="iconbox-inner">
                        <?php if ( $icon ): ?>
                            <div class="icon">
                                <span class="<?php echo esc_attr( $icon ) ?>" style="<?php echo esc_attr( $style ) ?>;"></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( $image_atch['img'] ): ?>
                            <?php echo wp_specialchars_decode( $image_atch['img'] ); ?>
                        <?php endif; ?>
                        <div class="content">
                            <?php if ( $atts['title'] ): ?>
                                <h3 class="title"><?php echo esc_html( $title ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $atts['subtitle'] ): ?>
                                <p class="subtitle"><?php echo wp_specialchars_decode( $subtitle ); ?></p>
                            <?php endif; ?>
                            <?php if ( $atts['s_title'] ): ?>
                                <h4 class="second-title"><?php echo esc_html( $s_title ); ?></h4>
                            <?php endif; ?>
                            <?php if ( $atts['s_subtitle'] ): ?>
                                <p class="second-subtitle"><?php echo wp_specialchars_decode( $s_subtitle ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
			<?php
			$html = ob_get_clean();

			return apply_filters( 'Shortcode_Ovic_Iconbox', $html, $atts, $content );
		}
	}

	new Shortcode_Ovic_Iconbox();
}