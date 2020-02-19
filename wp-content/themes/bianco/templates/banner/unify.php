<?php
$image = $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array(
	'img' => '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="500" height="500" alt="bianco placeholder">');
$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$html_group_texts = '';

if ( $text_1 )
	$html_group_texts .= '<h3 class="text-1">' . esc_html( $text_1 ) . '</h3>';

if ( $text_2 )
	$html_group_texts .= '<span class="text-2">' . esc_html( $text_2 ) . '</span>';

if ( $link['title'] ) {
    $target = bianco_get_target_link($link);
	$html_group_texts .= '<a class="banner-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . '>' . esc_html( $link['title'] ) . '</a>';
}
$bn_css_inline	 = array();
$bn_css_inline[] = "height: {$image['height']}px";
$bn_css_inline[] = "background-image: url({$image['url']})";
$bn_css_inline[] = 'display: block';
$bn_css_inline[] = 'width: 100%';
$bn_css_inline[] = 'max-width:100%';
$bn_css_inline[] = 'background-position:top right';
?>
<div class="inner-content">
    <div class="thumb-banner">
        <a class="wrap-img" style="<?php echo implode('; ',$bn_css_inline)?>" href="<?php echo esc_url( $link['url'] ); ?>"></a>
    </div>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>