<?php
$image = $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array(
    'url' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==",
    'width' => 425,
    'height' => 221,
    'img' => '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="425" height="221" alt="bianco placeholder">',
);
$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$text_3           = !empty( $atts['text_3'] ) ? $atts['text_3'] : '';
$text_4           = !empty( $atts['text_4'] ) ? $atts['text_4'] : '';
$text_5           = !empty( $atts['text_5'] ) ? $atts['text_5'] : '';
$text_6           = !empty( $atts['text_6'] ) ? $atts['text_6'] : '';

if($text_4)
    $text_4  =  '<sup class="text-4">'.esc_html( $text_4 ).'</sup>';

$html_group_texts = '';
if ( $text_1 )
    $html_group_texts .= '<b class="text-1">' . esc_html( $text_1 ) . '</b>';
if ( $text_2 )
    $html_group_texts .= '<span class="text-2">' . esc_html( $text_2 ) . '</span>';
if ( $text_3 )
    $html_group_texts .= '<span class="text-3">' . esc_html( $text_3 ).$text_4. '</span>';
if ( $text_5 )
    $html_group_texts .= '<span class="text-5">' . esc_html( $text_5 ) . '</span>';
if ( $text_6 )
    $html_group_texts .= '<span class="text-6">' . esc_html( $text_6 ) . '</span>';
if ( $link['title'] ) {
    $target = bianco_get_target_link($link);
    $html_group_texts .= '<a class="banner-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ).' >' . esc_html( $link['title'] ) . '</a>';
}
?>
<div class="inner-content">
    <div class="thumb-banner" style=" height: <?php echo esc_attr($image['height'])?>px;">
        <a class="wrap-img" href="<?php echo esc_url( $link['url'] ); ?>" style="background-image: url(<?php echo esc_url($image['url']); ?>); display: block; height: 100%; background-size: cover;"></a>
    </div>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>