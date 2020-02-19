<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Person"
 * @version 1.0.0
 */
if ( !class_exists( 'Shortcode_Ovic_Person' ) ) {
	class Shortcode_Ovic_Person extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_person';

		static public function add_css_generate( $atts )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_person', $atts ) : $atts;
			// Extract shortcode parameters.
			extract( $atts );
			$css = '';

			return apply_filters( 'Shortcode_Ovic_Person_css', $css, $atts );
		}

		public function output_html( $atts, $content = null )
		{
			$atts   = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_person', $atts ) : $atts;
			$layout = $name = $title = $message = $avatar = '';

			extract( $atts );
			$css_class   = array( 'ovic-person', $layout );
			$css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_person', $atts );
			$person_link = vc_build_link( $atts['link'] );
			if ( $person_link['url'] ) {
				$link_url    = $person_link['url'];
				if($link_url == '' || $link_url= '#'){
                    $link_target = '';
                }else{
                    $link_target = "target=\"{$person_link['target']}\"";
                }

			} else {
				$link_target = 'target="_self"';
				$link_url    = '#';
			}
			ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<?php if ( $avatar ) : ?>
                    <div class="thumb-avatar">
                        <a href="<?php echo esc_url( $link_url ); ?>" <?php echo esc_attr( $link_target ); ?> >
							<?php
							$thumb_avatar = apply_filters( 'ovic_resize_image', $avatar, false, false, true, true );
							echo wp_specialchars_decode( $thumb_avatar['img'] );
							?>
                        </a>
                    </div>
				<?php endif; ?>
                <div class="person-info">
                    <?php if ( $message ) : ?>
                        <p class="message"><span>“</span><?php echo wp_specialchars_decode( $message ); ?></p>
                    <?php endif; ?>
					<?php if ( $name ) : ?>
                        <h3 class="name">
                            <a href="<?php echo esc_url( $link_url ); ?>" <?php echo esc_attr( $link_target ); ?> ><?php echo esc_html( $name ); ?></a>
                        </h3>
					<?php endif; ?>
					<?php if ( $title ) : ?>
                        <p class="title"><?php echo esc_html( $title ); ?></p>
					<?php endif; ?>
                </div>
            </div>
		    <?php
			$html = ob_get_clean();
			return apply_filters( 'Shortcode_Ovic_Person', $html, $atts, $content );
		}
	}
	new Shortcode_Ovic_Person();
}