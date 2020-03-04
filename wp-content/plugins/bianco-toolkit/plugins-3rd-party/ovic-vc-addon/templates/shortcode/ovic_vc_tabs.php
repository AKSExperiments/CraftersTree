<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Vc_Tabs"
 */
if ( class_exists( 'Ovic_VC_Shortcode' ) ) {
	class Ovic_VC_Shortcode_Tabs extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'tabs';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_vc_tabs', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = '';

			return apply_filters( 'Ovic_VC_Shortcode_Tabs_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_vc_tabs', $atts ) : $atts;
			extract( $atts );
			$css_class   = array( 'ovic-vc-tabs' );
			$css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_vc_tabs', $atts );
			$sections    = $this->get_all_attributes( 'vc_tta_section', $content );
			$rand        = uniqid();
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<?php if ( $sections && is_array( $sections ) && count( $sections ) > 0 ): ?>
                    <div class="tab-head ovic-vc-dropdown">
						<?php if ( $atts['tab_title'] ) : ?>
                            <h3 class="ovic_vc-title">
                                <span class="text"><?php echo esc_html( $atts['tab_title'] ); ?></span>
                            </h3>
						<?php endif; ?>
                        <ul class="tab-link">
							<?php foreach ( $sections as $key => $section ) : ?>
								<?php
								/* Get icon from section tabs */
								$section['i_type'] = isset( $section['i_type'] ) ? $section['i_type'] : 'fontawesome';
								$add_icon          = isset( $section['add_icon'] ) ? $section['add_icon'] : '';
								$position_icon     = isset( $section['i_position'] ) ? $section['i_position'] : '';
								$icon_html         = $this->constructIcon( $section );
								$section_id        = $section['tab_id'] . '-' . $rand;
								?>
                                <li class="<?php echo ( $key == $atts['active_section'] ) ? esc_attr( 'active' ) : '' ?>">
                                    <a class="<?php echo ( $key == $atts['active_section'] ) ? esc_attr( 'loaded' ) : ''; ?>"
                                       data-ajax="<?php echo esc_attr( $atts['ajax_check'] ) ?>"
                                       data-animate="<?php echo esc_attr( $atts['css_animation'] ); ?>"
                                       data-section="<?php echo esc_attr( $section['tab_id'] ); ?>"
                                       data-id="<?php echo get_the_ID(); ?>"
                                       href="#<?php echo esc_attr( $section_id ); ?>">
										<?php if ( isset( $section['title_image'] ) ) : ?>
                                            <figure>
												<?php
												$image_thumb = apply_filters( 'ovic_resize_image', $section['title_image'], false, false, true, true );
												echo htmlspecialchars_decode( $image_thumb['img'] );
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
								<?php if ( $atts['ajax_check'] == '1' ) :
									echo $key == $atts['active_section'] ? do_shortcode( $section['content'] ) : '';
								else :
									echo do_shortcode( $section['content'] );
								endif; ?>
                            </div>
						<?php endforeach; ?>
                    </div>
				<?php endif; ?>
            </div>
			<?php
			$html = ob_get_clean();

			return apply_filters( 'Ovic_VC_Shortcode_Tabs', $html, $atts, $content );
		}
	}

	new Ovic_VC_Shortcode_Tabs();
}