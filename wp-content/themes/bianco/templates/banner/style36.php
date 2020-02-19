<?php
$image            = $atts['obj_image'] ? apply_filters( 'ovic_resize_image', $atts['obj_image'], false, false, true, true ) : array();
$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$text_3           = !empty( $atts['text_3'] ) ? $atts['text_3'] : '';
$main_bg          = !empty( $atts['main_bgcolor'] ) ? "background-color: {$atts['main_bgcolor']};" : '';

$html_group_texts = '';
if ( $text_1 )
    $html_group_texts .= '<span class="text-1">' . esc_html( $text_1 ) . '</span>';
if ( $text_2 )
    $html_group_texts .= '<b class="text-2">' . esc_html( $text_2 ) . '</b>';
if ( $text_3 )
    $html_group_texts .= '<p class="text-3">' . esc_html( $text_3 ) . '</p>';
?>
<div class="inner-content" style="<?php echo esc_attr($main_bg); ?>">
    <?php if($image['url']): ?>
    <div class="thumb-banner">
        <a class="wrap-img" href="<?php echo esc_url( $link['url'] ); ?>"><?php echo wp_specialchars_decode($image['img']); ?></a>
    </div>
    <?php endif; ?>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>