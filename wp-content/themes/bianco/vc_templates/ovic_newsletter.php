<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this "Ovic_Newsletter"
 */
if ( !class_exists( 'Shortcode_Ovic_Newsletter' ) ) {
	class Shortcode_Ovic_Newsletter extends Ovic_VC_Shortcode
	{
		/**
		 * Shortcode name.
		 *
		 * @var  string
		 */
		public $shortcode = 'ovic_newsletter';

		public function output_html( $atts, $content = null )
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'ovic_newsletter', $atts ) : $atts;
            $title = $subtitle = $show_list = $field_name = $fname_text = $lname_text = $placeholder = $button_text = '';
			extract( $atts );
			$css_class   = array( 'widget-ovic-mailchimp' );
			$css_class[] = $atts['style'];
			$css_class[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '', 'ovic_newsletter', $atts );
			$shortcode   = '';
            $shortcode .= ($title) ? " title=\"{$title}\"" : '';
            $shortcode .= ($subtitle) ? " subtitle=\"{$subtitle}\"" : '';
            $shortcode .= ($show_list) ? " show_list=\"{$show_list}\"" : '';
            $shortcode .= ($field_name) ? " field_name=\"{$field_name}\"" : '';
            $shortcode .= ($fname_text) ? " fname_text=\"{$fname_text}\"" : '';
            $shortcode .= ($lname_text) ? " lname_text=\"{$lname_text}\"" : '';
            $shortcode .= ($placeholder) ? " placeholder=\"{$placeholder}\"" : '';
            $shortcode .= ($button_text) ? " button_text=\"{$button_text}\"" : '';
            /*---------------------------------*/
            ob_start(); ?>
            <div class="<?php echo esc_attr( implode( ' ', $css_class ) ); ?>">
				<?php if ( $title): ?>
                    <h3 class="title"><?php echo wp_specialchars_decode( $title ); ?></h3>
				<?php endif; ?>
				<?php if ( $subtitle ): ?>
                    <p class="subtitle"><?php echo wp_specialchars_decode( $subtitle ); ?></p>
				<?php endif; ?>
				<?php echo do_shortcode( '[ovic_mailchimp' . $shortcode . ']' ); ?>
            </div>
			<?php
            $html = ob_get_clean();
            /*---------------------------------*/
            return apply_filters( 'Shortcode_Ovic_Newsletter', $html, $atts, $content );
		}
	}
	new Shortcode_Ovic_Newsletter();
}