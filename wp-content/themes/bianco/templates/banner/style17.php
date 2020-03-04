<?php
$image = $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array(
    'url' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==",
    'width' => 575,
    'height' => 300,
    'img' => '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="575" height="300" alt="bianco placeholder">',
);
$img_title        = ( $atts['img_title'] ) ? apply_filters( 'ovic_resize_image', $atts['img_title'], false, false, true, true ) : array( 'img' => '');
$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$btn_bgcolor      = !empty( $atts['btn_bgcolor'] ) ? "background-color:{$atts['btn_bgcolor']}" : '';
$html_group_texts = '';
if(!empty($img_title['img'])){
    $html_group_texts .= "<figure class='img-title'>{$img_title['img']}</figure>";
}
if ( $text_1 )
    $html_group_texts .= '<b class="text-1">' . esc_html( $text_1 ) . '</b>';
if ( $link['title'] ) {
    $target = bianco_get_target_link($link);
    $html_group_texts .= '<a class="banner-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . ' style="'.esc_attr($btn_bgcolor).'" >' . esc_html( $link['title'] ) . '</a>';
}
?>
<div class="inner-content">
    <div class="thumb-banner" style=" height: <?php echo esc_attr($image['height'])?>px;">
        <a class="wrap-img" href="<?php echo esc_url( $link['url'] ); ?>" style="background-image: url(<?php echo esc_url($image['url']); ?>); display: block; height: 100%;"></a>
    </div>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>