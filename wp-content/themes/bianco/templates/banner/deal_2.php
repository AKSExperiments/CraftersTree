<?php
$image = $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array(
    'url' 		=> "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==",
    'width' 	=> 1920,
    'height' 	=> 884,
    'img' 		=> '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="1920" height="884" alt="bianco placeholder">',
);
$link             = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$text_3           = !empty( $atts['text_3'] ) ? $atts['text_3'] : '';
$text_4           = !empty( $atts['text_4'] ) ? $atts['text_4'] : '';
$btn_lable        = !empty( $atts['btn_lable'] ) ? $atts['btn_lable'] : '';
$html_group_texts = '';

if ( $text_1 )
    $html_group_texts .= '<span class="text-1" >' . esc_html( $text_1 ) . '</span>';
if ( $text_2 )
    $html_group_texts .= '<b class="text-2">' . esc_html( $text_2 ) . '</b>';
if ( $text_3 )
    $html_group_texts .= '<b class="text-3">' . esc_html( $text_3 ) . '</b>';
if ( $text_4 )
    $html_group_texts .= '<p class="text-4">' . esc_html( $text_4 ) . '</p>';
/*show product info*/
$product = false;
if($atts['ids']){
    $product = wc_get_product($atts['ids']);
}
if($product) {
    $label = __('Buy now', 'bianco');
    $html_group_texts .="<a class='bianco_buy_now btn' href='{$product->add_to_cart_url()}'  data-product_type='{$product->get_type()}' data-product_id='{$product->get_id()}' ><span class=\"price\">{$product->get_price_html()}</span>{$label}</a>";
}
?>
<div class="inner-content">
    <div class="thumb-banner" style=" height: <?php echo esc_attr($image['height'])?>px; background-image: url(<?php echo esc_url($image['url']) ?>); background-position: center; background-size: cover; "></div>
    <div class="texts-container">
        <div class="texts" ><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
</div>