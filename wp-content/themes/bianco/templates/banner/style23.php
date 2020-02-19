<?php
$image = $atts['image'] ? apply_filters( 'ovic_resize_image', $atts['image'], false, false, true, true ) : array(
    'url' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==",
    'width' => 1170,
    'height' => 464,
    'img' => '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAE0lEQVQImWP4////f4bLly//BwAmVgd1/w11/gAAAABJRU5ErkJggg==" width="575" height="150" alt="bianco placeholder">',
);
$product_image    = ( $atts['prd_img'] ) ? apply_filters( 'ovic_resize_image', $atts['prd_img'], false, false, true, true ) : '';
$text_1           = !empty( $atts['text_1'] ) ? $atts['text_1'] : '';
$text_2           = !empty( $atts['text_2'] ) ? $atts['text_2'] : '';
$text_3           = !empty( $atts['text_3'] ) ? $atts['text_3'] : '';
$text_4           = !empty( $atts['text_4'] ) ? $atts['text_4'] : '';
$text_5           = !empty( $atts['text_5'] ) ? $atts['text_5'] : '';
$link_product     ='#';
/*show product info*/
$product = false;
if($atts['ids']){
    $product = wc_get_product($atts['ids']);
}
$html_group_texts = '';
if ( $text_1 )
    $html_group_texts .= '<span class="text-1">' . esc_html( $text_1 ) . '</span>';
if ( $text_2 )
    $html_group_texts .= '<b class="text-2">' . esc_html( $text_2 ) . '</b>';
if($product) {
    $view_detail_label = __('View Products Detail', 'bianco');
    $add_to_cart_label = __('Add to cart', 'bianco');
    $link_product = $product->get_permalink();
    $html_group_texts .="<a class='add-to-cart btn' href='{$product->add_to_cart_url()}'  data-product_type='{$product->get_type()}' data-product_id='{$product->get_id()}' >{$add_to_cart_label}</a>";
    $html_group_texts .="<a class='view-detail btn' href='{$link_product}' >{$view_detail_label}</a>";
}
if ( $text_3 )
    $html_group_texts .= '<b class="text-3">' . esc_html( $text_3 ) . '</b>';
if ( $text_4 )
    $html_group_texts .= '<b class="text-4">' . esc_html( $text_4 ) . '</b>';
if ( $text_5 )
    $html_group_texts .= '<span class="text-5">' . esc_html( $text_5 ) . '</span>';
?>
<div class="inner-content">
    <div class="thumb-banner" style=" height: <?php echo esc_attr($image['height'])?>px;">
        <a class="wrap-img" href="<?php echo esc_url( $link_product ); ?>" style="background-image: url(<?php echo esc_url($image['url']); ?>); display: block; height: 100%;"></a>
    </div>
    <div class="texts-container wpb_animate_when_almost_visible wpb_fadeInRight fadeInRight" style="animation-duration: 800ms;">
        <div class="texts"><?php echo wp_specialchars_decode( $html_group_texts ); ?></div>
    </div>
    <?php if($product_image['img']): ?>
        <?php $pr_represent_css_animation = bianco_getCSSAnimation($atts['css_animation']); ?>
        <div class="img-represent-pr">
            <figure class="<?php echo esc_attr($pr_represent_css_animation)?>" style="animation-duration: 1200ms;"><?php echo wp_specialchars_decode( $product_image['img'] ); ?></figure>
        </div>
    <?php endif; ?>
</div>