<?php
$image = $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array(
    'url'       => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==",
    'width'     => 1920,
    'height'    => 884,
    'img'       => '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="1920" height="884" alt="bianco placeholder">',
);
$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$text_3           = !empty( $atts['text_3'] ) ? $atts['text_3'] : '';
$text_4           = !empty( $atts['text_4'] ) ? $atts['text_4'] : '';
$btn_bgcolor      = !empty( $atts['btn_bgcolor'] ) ? "background-color:{$atts['btn_bgcolor']}" : '';
$text_color       = !empty( $atts['btn_bgcolor'] ) ? "color: {$atts['btn_bgcolor']}" : '';
$html_group_texts = '';

if ( $text_1 )
    $html_group_texts .= '<span class="text-1" style="'.esc_attr($text_color).'" >' . esc_html( $text_1 ) . '</span>';

if ( $text_2 )
    $html_group_texts .= '<b class="text-2">' . esc_html( $text_2 ) . '</b>';

if ( $text_3 )
    $html_group_texts .= '<b class="text-3">' . esc_html( $text_3 ) . '</b>';

if ( $text_4 )
    $html_group_texts .= '<p class="text-4">' . esc_html( $text_4 ) . '</p>';

/*show countdown*/
if($atts['countdown_date']){
    $time_stamp     = strtotime($atts['countdown_date']);
    $date           = date( 'm/d/Y H:i:s', $time_stamp);
    $txt_day        = esc_html__( 'Days', 'bianco' );
    $txt_hour       = esc_html__( 'Hrs', 'bianco' );
    $txt_min        = esc_html__( 'Mins', 'bianco' );
    $txt_sec        = esc_html__( 'Secs', 'bianco' );
    $html_group_texts .= '<div class="countdown-box"><div class="bianco-countdown" data-datetime="04/16/2019 12:00:33" data-txt_day="Days" data-txt_hour="Hrs" data-txt_min="Mins" data-txt_sec="Secs" data-label_position_top="false"><div class="countdown-item item-day"><span class="item-value">145</span><span class="item-label">Days</span></div><div class="countdown-item item-hour"><span class="item-value">02</span><span class="item-label">Hrs</span></div><div class="countdown-item item-min"><span class="item-value">08</span><span class="item-label">Mins</span></div><div class="countdown-item item-sec"><span class="item-value">15</span><span class="item-label">Secs</span></div></div></div>';
}

/*show product info*/
$product = false;

if($atts['ids']){
    $product = wc_get_product($atts['ids']);
}

if($product) {
    $label = __('Buy now', 'bianco');
    $html_group_texts .="<a class='bianco_buy_now btn' href='{$product->add_to_cart_url()}'  data-product_type='{$product->get_type()}' data-product_id='{$product->get_id()}' ><span class=\"price\">{$product->get_price_html()}</span>{$label}</a>";
}

if ( $link['title'] ) {
    $target = bianco_get_target_link($link);
    $html_group_texts .= '<a class="banner-link" href="' . esc_url( $link['url'] ) . '" ' . esc_attr( $target ) . ' style="'.esc_attr($btn_bgcolor).'" >' . esc_html( $link['title'] ) . '</a>';
}
?>
<div class="inner-content">
    <div class="thumb-banner" style=" height: <?php echo esc_attr($image['height'])?>px; background-image: url(<?php echo esc_url($image['url']) ?>); background-position: center; background-size: cover; "></div>
    <div class="texts-container">
        <div class="container">
            <div class="texts" ><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
        </div>
    </div>
</div>