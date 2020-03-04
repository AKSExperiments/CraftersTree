<?php
$image =  $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array(
    'img' => '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="500" height="500" alt="bianco placeholder">');

$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$text_3           = !empty( $atts['text_3'] ) ? $atts['text_3'] : '';
$text_4           = !empty( $atts['text_4'] ) ? $atts['text_4'] : '';
$html_group_texts = '';

if ( $text_1 )
    $html_group_texts .= '<h3 class="text-1">' . esc_html( $text_1 ) . '</h3>';

if ( $text_2 )
    $html_group_texts .= '<span class="text-2">' . esc_html( $text_2 ) . '</span>';

if ( $text_3 || $text_4 ){
    $text_3 = '<span class="tbt-bn">' . esc_html( $text_3 ) . '</span>';
    $html_group_texts .= '<b class="text-3">'.$text_3. esc_html( $text_4 ) . '</b>';
}

if ( $link['title'] ) {
    $target = bianco_get_target_link($link);
    $html_group_texts .= '<a class="banner-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . '>' . esc_html( $link['title'] ) . '</a>';
}
?>
<div class="inner-content">
    <div class="thumb-banner">
        <a class="wrap-img"
           href="<?php echo esc_url( $link['url'] ); ?>"><?php echo wp_specialchars_decode( $image['img'] ); ?></a>
    </div>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>