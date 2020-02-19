<?php
/**
 * Name: Product Style 10
 * Slug: content-product-style-10
 * Shortcode: true
 * Theme Option: true
 **/

remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',25);
add_action('woocommerce_after_shop_loop_item_title','bianco_custom_template_loop_rating',25);
?>
<div class="product-inner">
    <div class="product-thumb">
        <?php
        /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action('woocommerce_before_shop_loop_item_title');
        ?>
    </div>
    <div class="product-info">
        <?php
        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action('woocommerce_shop_loop_item_title');

        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action('woocommerce_after_shop_loop_item_title');
        ?>
    </div>
    <?php
    /**
     * woocommerce_after_shop_loop_item hook.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>
    <div class="group-button">
        <div class="inner">
            <div class="add-to-cart">
                <?php do_action('bianco_template_shop_loop_add_to_cart'); ?>
            </div>
        </div>
    </div>
</div>
<?php
remove_action('woocommerce_after_shop_loop_item_title','bianco_custom_template_loop_rating',25);
add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',25);