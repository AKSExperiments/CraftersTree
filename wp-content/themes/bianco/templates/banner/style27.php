<?php
$product = false;
$btns = $link_start = $link_end = $pr_image = $html_thumb_banner = '';
if($atts['ids']){
    $product = wc_get_product($atts['ids']);
}
if($product) {
    $link = $product->get_permalink();
    $link_start = '<a class="wrap-img" href="'.esc_url( $link ).'">';
    $link_end = '</a>';
    $pr_image = $product->get_image_id();
    if ( defined( 'YITH_WCWL' ) ) {
        ob_start();
        echo do_shortcode("[yith_wcwl_add_to_wishlist product_id={$atts['ids']}]");
        $btns = ob_get_clean();
    }
}
$main_image = ( $atts['image'] ) ? $atts['image'] : $pr_image;
$image            = ( $main_image ) ? apply_filters( 'ovic_resize_image', $main_image, false, false, true, true ) : array();
$link_custom      = !empty( $atts['link'] ) ? vc_build_link( $atts['link'] ) : array( 'title' => '', 'url' => '#', 'target' => '_self', 'rel' => '' );
if($link_custom['title']){
    $link_start = '<a class="wrap-img" href="'.esc_url( $link_custom['url'] ).'" title="'.esc_attr($link_custom['title']).'" target="'.esc_attr($link_custom['target']).'" rel="'.esc_attr($link_custom['rel']).'">';
    $link_end = '</a>';
}
$html_thumb_banner .= $btns;
$html_thumb_banner .= $link_start;
$html_thumb_banner .= $image['img'];
$html_thumb_banner .= $link_end;
?>
<div class="inner-content">
    <?php if(isset($image['img'])): ?>
        <div class="thumb-banner">
            <?php echo wp_specialchars_decode($html_thumb_banner); ?>
        </div>
    <?php endif; ?>
</div>