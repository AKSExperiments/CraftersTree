<?php
/**
 * Name: Product Style WGT
 * Slug: content-product-style-wgt
 * Shortcode: true
 * Theme Option: false
 **/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;
?>
<div class="product-inner style-wgt">
    <div class="product-thumb">
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
            <?php echo wp_specialchars_decode($product->get_image()); ?>
        </a>
    </div>
    <div class="product-info">
        <?php echo wp_specialchars_decode($product->get_price_html()); ?>
        <a class="product-title" href="<?php echo esc_url( $product->get_permalink() ); ?>" ><?php echo wp_kses_post( $product->get_name() ); ?></a>
    </div>
</div>