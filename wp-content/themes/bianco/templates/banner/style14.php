<?php
$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$text_3           = !empty( $atts['text_3'] ) ? $atts['text_3'] : '';
$text_4           = !empty( $atts['text_4'] ) ? $atts['text_4'] : '';
$btn_bgcolor      = !empty( $atts['btn_bgcolor'] ) ? "background-color:{$atts['btn_bgcolor']}" : '';
$html_group_texts = '';
if ( $text_1 )
    $html_group_texts .= '<span class="text-1">' . esc_html( $text_1 ) . '</span>';
if ( $text_2 )
    $html_group_texts .= '<p class="text-2">' . esc_html( $text_2 ) . '</p>';
if ( $text_3 )
    $html_group_texts .= '<b class="text-3">' . esc_html( $text_3 ) . '</b>';
if ( $text_4 )
    $html_group_texts .= '<b class="text-4">' . esc_html( $text_4 ) . '</b>';
if ( $link['title'] ) {
    $target = bianco_get_target_link($link);
    $html_group_texts .= '<a class="banner-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . ' style="'.esc_attr($btn_bgcolor).'" >' . esc_html( $link['title'] ) . '</a>';
}
?>
<div class="inner-content">
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>