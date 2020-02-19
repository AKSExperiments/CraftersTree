<?php
$image = $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array(
    'img' => '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="500" height="500" alt="bianco placeholder">');
$link   = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1 = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2 = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$text_3 = !empty( $atts['text_3'] ) ? $atts['text_3'] : '';
$text_4 = !empty( $atts['text_4'] ) ? $atts['text_4'] : '';
$text_5 = !empty( $atts['text_5'] ) ? $atts['text_5'] : '';
$html_group_texts = '';
if ( $text_1 )
    $html_group_texts .= '<span class="text-1">' . esc_html( $text_1 ) . '</span>';
if ( $text_2 )
    $html_group_texts .= '<b class="text-2">' . esc_html( $text_2 ) . '</b>';
if ( $text_3 )
    $html_group_texts .= '<h3 class="text-3">' . esc_html( $text_3 ) . '</h3>';
if ( $text_4 )
    $html_group_texts .= '<b class="text-4">' . esc_html( $text_4 ) . '</b>';
if ( $text_5 )
    $html_group_texts .= '<b class="text-5">' . esc_html( $text_5 ) . '</b>';
?>
<div class="inner-content">
    <span class="surface top"></span>
    <span class="surface bottom"></span>
    <div class="thumb-banner">
        <a class="wrap-img"
           style=" height: <?php echo esc_attr($image['height']);?>px;
                   width: 100%;
                   max-width:100%;
                   background-position:center center;
                   background-image: url(<?php echo esc_attr($image['url']);?>);"
           href="<?php echo esc_url( $link['url'] ); ?>">
        </a>
    </div>
    <div class="texts-container">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>