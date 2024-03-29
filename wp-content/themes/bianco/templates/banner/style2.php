<?php
$image = $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array(
	'img' => '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="500" height="500" alt="bianco placeholder">');
$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$inner_class      = array( 'bianco-banner' );
$inner_class[]    = "banner-style-{$atts['layout']}";
$inner_class[]    = !empty( $atts['banner_effect'] ) ? $atts['banner_effect'] : 'no-effect';
$html_group_texts = '';

if ( $text_1 )
	$html_group_texts .= '<h3 class="text-1">' . esc_html( $text_1 ) . '</h3>';

if ( $text_2 )
	$html_group_texts .= '<p class="text-2">' . esc_html( $text_2 ) . '</p>';

if ( $link['title'] ) {
    $target = bianco_get_target_link($link);
	$html_group_texts .= '<a class="banner-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . '>' . esc_html( $link['title'] ) . '</a>';
}
?>
<div class="inner-content">
    <span class="surface top"></span>
    <span class="surface bottom"></span>
    <div class="thumb-banner">
        <a class="wrap-img"
           href="<?php echo esc_url( $link['url'] ); ?>"><?php echo wp_specialchars_decode( $image['img'] ); ?></a>
    </div>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>