<?php
/**
 * Name: Product Style 06
 * Slug: content-product-style-6
 * Shortcode: true
 * Theme Option: false
 **/
global $product;
$date_on_sale_to = $product->get_date_on_sale_to();
?>
<div class="product-inner btn-hover-main">
    <div class="product-thumb">
        <?php
        /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_before_shop_loop_item_title' );
        ?>
        <div class="group-button">
            <div class="inner">
                <div class="add-to-cart">
                    <?php do_action( 'bianco_template_shop_loop_add_to_cart' ); ?>
                </div>
                <?php do_action( 'bianco_wishlist_button' ); ?>
                <?php do_action( 'bianco_compare_button' ); ?>
            </div>
        </div>
    </div>
    <div class="product-info">
        <?php
        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );
        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action( 'woocommerce_shop_loop_item_title' );
        bianco_process_availability();
        ?>
        <?php if ( is_object( $date_on_sale_to ) ) : ?>
            <?php $date = $date_on_sale_to->date( 'm/d/Y H:i:s' ); ?>
            <div class="countdown-box">
                <div class="bianco-countdown"
                     data-datetime="<?php echo esc_attr( $date ); ?>"
                     data-txt_day="<?php echo esc_attr__( 'Days', 'bianco' ) ?>"
                     data-txt_hour="<?php echo esc_attr__( 'Hrs', 'bianco' ) ?>"
                     data-txt_min="<?php echo esc_attr__( 'Mins', 'bianco' ) ?>"
                     data-txt_sec="<?php echo esc_attr__( 'Secs', 'bianco' ) ?>"
                     data-label_position_top="false">
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
    /**
     * woocommerce_after_shop_loop_item hook.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     */
    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
</div>
