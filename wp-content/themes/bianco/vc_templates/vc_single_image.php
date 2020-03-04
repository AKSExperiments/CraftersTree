<?php
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $image
 * @var $custom_src
 * @var $onclick
 * @var $img_size
 * @var $external_img_size
 * @var $caption
 * @var $img_link_large
 * @var $link
 * @var $img_link_target
 * @var $alignment
 * @var $el_class
 * @var $el_id
 * @var $css_animation
 * @var $style
 * @var $external_style
 * @var $border_color
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Single_image
 */
$title = $source = $image = $image_effect= $_effect_color = $custom_src = $onclick = $img_size = $external_img_size =
$caption = $img_link_large = $link = $img_link_target = $alignment = $el_class = $el_id = $css_animation = $style = $external_style = $border_color = $css = '';
$atts  = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$default_src = vc_asset_url( 'vc/no_image.png' );
// backward compatibility. since 4.6
if ( empty( $onclick ) && isset( $img_link_large ) && 'yes' === $img_link_large ) {
	$onclick = 'img_link_large';
} elseif ( empty( $atts['onclick'] ) && ( !isset( $atts['img_link_large'] ) || 'yes' !== $atts['img_link_large'] ) ) {
	$onclick = 'custom_link';
}
if ( 'external_link' === $source ) {
	$style        = $external_style;
	$border_color = $external_border_color;
}
$lazy_load_class = Bianco_Functions::get_option( 'ovic_theme_lazy_load' ) == 1 ? 'lazy' : '';
$border_color    = ( '' !== $border_color ) ? ' vc_box_border_' . $border_color : '';
$img             = false;
switch ( $source ) {
	case 'media_library':
	case 'featured_image':
		if ( 'featured_image' === $source ) {
			$post_id = get_the_ID();
			if ( $post_id && has_post_thumbnail( $post_id ) ) {
				$img_id = get_post_thumbnail_id( $post_id );
			} else {
				$img_id = 0;
			}
		} else {
			$img_id = preg_replace( '/[^\d]/', '', $image );
		}
		// set rectangular
		if ( preg_match( '/_circle_2$/', $style ) ) {
			$style    = preg_replace( '/_circle_2$/', '_circle', $style );
			$img_size = $this->getImageSquareSize( $img_id, $img_size );
		}
		if ( !$img_size ) {
			$img_size = 'medium';
		}
		$image            = wp_get_attachment_image_src( $img_id, $img_size );
		$lazy_placeholder = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%20" . $image[1] . "%20" . $image[2] . "%27%2F%3E";
		$lazy_url         = $lazy_load_class == 'lazy' ? $lazy_placeholder : $image[0];
		$data_src         = $lazy_load_class == 'lazy' ? 'data-src="' . $image[0] . '"' : '';
		$hwstring         = $img_size ? image_hwstring( $image[1], $image[2] ) : '';
		$image_thumb      = '<img class="vc_single_image-img ' . $lazy_load_class . ' attachment-' . $img_size . '" src="' . $lazy_url . '" ' . $data_src . ' ' . $hwstring . ' alt="' . get_the_title() . '"/>';
		$img              = array(
			'thumbnail'   => $image_thumb,
			'p_img_large' => $image,
		);
		// don't show placeholder in public version if post doesn't have featured image
		if ( 'featured_image' === $source ) {
			if ( !$img && 'page' === vc_manager()->mode() ) {
				return;
			}
		}
		break;
	case 'external_link':
		$dimensions       = vcExtractDimensions( $external_img_size );
		$hwstring         = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
		$custom_src       = $custom_src ? esc_attr( $custom_src ) : $default_src;
		$lazy_placeholder = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%20" . $dimensions[0] . "%20" . $dimensions[1] . "%27%2F%3E";
		$lazy_url         = $lazy_load_class == 'lazy' ? $lazy_placeholder : $custom_src;
		$data_src         = $lazy_load_class == 'lazy' ? 'data-src="' . $custom_src . '"' : '';
		$img              = array(
			'thumbnail' => '<img class="vc_single_image-img ' . $lazy_load_class . '" ' . $hwstring . ' src="' . $lazy_url . '" ' . $data_src . ' alt="' . get_the_title() . '"/>',
		);
		break;
	default:
		$img = false;
}
if ( !$img ) {
	$img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . $default_src . '" />';
}
$el_class = $this->getExtraClass( $el_class );
// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
	$onclick = 'link_image';
}
// backward compatibility. will be removed in 4.7+
if ( !empty( $atts['img_link'] ) ) {
	$link = $atts['img_link'];
	if ( !preg_match( '/^(https?\:\/\/|\/\/)/', $link ) ) {
		$link = 'http://' . $link;
	}
}
// backward compatibility
if ( in_array( $link, array( 'none', 'link_no' ) ) ) {
	$link = '';
}
$a_attrs = array();
switch ( $onclick ) {
	case 'img_link_large':
		if ( 'external_link' === $source ) {
			$link = $custom_src;
		} else {
			$link = wp_get_attachment_image_src( $img_id, 'large' );
			$link = $link[0];
		}
		break;
	case 'link_image':
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );
		$a_attrs['class']    = 'prettyphoto';
		$a_attrs['data-rel'] = 'prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']';
		// backward compatibility
		if ( vc_has_class( 'prettyphoto', $el_class ) ) {
			// $link is already defined
		} elseif ( 'external_link' === $source ) {
			$link = $custom_src;
		} else {
			$link = wp_get_attachment_image_src( $img_id, 'large' );
			$link = $link[0];
		}
		break;
	case 'custom_link':
		// $link is already defined
		break;
	case 'zoom':
		wp_enqueue_script( 'vc_image_zoom' );
		if ( 'external_link' === $source ) {
			$large_img_src = $custom_src;
		} else {
			$large_img_src = wp_get_attachment_image_src( $img_id, 'large' );
			if ( $large_img_src ) {
				$large_img_src = $large_img_src[0];
			}
		}
		$img['thumbnail'] = str_replace( '<img ', '<img data-vc-zoom="' . $large_img_src . '" ', $img['thumbnail'] );
		break;
}
// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
	$el_class = vc_remove_class( 'prettyphoto', $el_class );
}
$wrapperClass = 'vc_single_image-wrapper ' . $style . ' ' . $border_color;
$_style_efftect_css='';
if ( $image_effect != 'none' ) {
	$wrapperClass .= ' ' . $image_effect . ' ';
	if($image_effect == 'effect border-zoom'){
        $css_added =' ';
        $css_added .=" background-color: {$_effect_color}; border-color: {$_effect_color};";
        $_style_efftect_css ='style="'.$css_added.'"';
    }
}
if ( $link ) {
	$a_attrs['href']   = $link;
	$a_attrs['target'] = $img_link_target;
	if ( !empty( $a_attrs['class'] ) ) {
		$wrapperClass .= ' ' . $a_attrs['class'];
		unset( $a_attrs['class'] );
	}
	$html = '<a '.$_style_efftect_css.' '. vc_stringify_attributes( $a_attrs ) . ' class="' . $wrapperClass . '">' . $img['thumbnail'] . '</a>';
} else {
	$html = '<div class="' . $wrapperClass . '">' . $img['thumbnail'] . '</div>';
}
$class_to_filter = 'wpb_single_image wpb_content_element vc_align_' . $alignment . ' ' . $this->getCSSAnimation( $css_animation );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
if ( in_array( $source, array( 'media_library', 'featured_image' ) ) && 'yes' === $add_caption ) {
	$post    = get_post( $img_id );
	$caption = $post->post_excerpt;
} else {
	if ( 'external_link' === $source ) {
		$add_caption = 'yes';
	}
}
if ( 'yes' === $add_caption && '' !== $caption ) {
	$html .= '<figcaption class="vc_figure-caption">' . esc_html( $caption ) . '</figcaption>';
}
$wrapper_attributes = array();
if ( !empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
$title_html = '';
if ( $title ) {
	$title_html = '
	<h2 class="bianco-title wpb_heading wpb_singleimage_heading">
		<span class="text">' . $title . '</span>
	</h2>
	';
}
$output = '
	<div ' . implode( ' ', $wrapper_attributes ) . ' class="' . esc_attr( trim( $css_class ) ) . '">
		' . $title_html . '
		<figure class="wpb_wrapper vc_figure">
			' . $html . '
		</figure>
	</div>
';
echo wp_specialchars_decode( $output );