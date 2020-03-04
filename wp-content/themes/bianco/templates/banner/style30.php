<?php
$image            = $atts['image']   ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array();
$_prd_img         = $atts['prd_img'] ? apply_filters( 'ovic_resize_image', $atts['prd_img'], false, false, true, true ) : array();
$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$btn_bgcolor      = !empty( $atts['btn_bgcolor'] ) ? "background-color:{$atts['btn_bgcolor']}" : '';
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$text_3           = !empty( $atts['text_3'] ) ? $atts['text_3'] : '';
$text_4           = !empty( $atts['text_4'] ) ? $atts['text_4'] : '';
$html_group_texts = '';
if ( $text_1 )
    $html_group_texts .= '<span class="text-1">' . esc_html( $text_1 ) . '</span>';
if ( $text_2 )
    $html_group_texts .= '<b class="text-2">' . esc_html( $text_2 ) . '</b>';
if ( $text_3 || $text_4 ){
    $html_group_texts .= '<span class="text-3">' . esc_html( $text_3 );
    if ( $text_4 )
        $html_group_texts .= '<span class="text-3-inside">' . esc_html( $text_4 ) . '</span>';
    $html_group_texts .= '</span>';
}
if ( $link['title'] ) {
    $target = bianco_get_target_link($link);
    $html_group_texts .= '<a class="banner-link btn" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . ' style="'.esc_attr($btn_bgcolor).'" >' . esc_html( $link['title'] ) . '</a>';
}
?>
<div class="inner-content">
    <div class="thumb-banner" style=" height: <?php echo esc_attr($image['height'])?>px;">
        <a class="wrap-img" href="<?php echo esc_url( $link['url'] ); ?>" style="background-image: url(<?php echo esc_url($image['url']); ?>); display: block; height: 100%;">
            <?php if($_prd_img['img']) echo wp_specialchars_decode($_prd_img['img']); ?>
        </a>
    </div>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>