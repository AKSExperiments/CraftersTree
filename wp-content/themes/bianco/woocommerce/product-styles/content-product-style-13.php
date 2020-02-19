<?php
/**
 * Name: Product Style 13
 * Slug: content-product-style-13
 * Shortcode: true
 * Theme Option: false
 **/


remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',25);
add_action('woocommerce_after_shop_loop_item_title','bianco_custom_template_loop_rating',25);
add_action('woocommerce_after_shop_loop_item_title','bianco_show_coundown_inside_product',30);
?>
<div class="product-inner st2 style-13 btn-hover-main">
    <div class="product-thumb">
        <?php
        do_action('bianco_quickview_button');
        /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action('woocommerce_before_shop_loop_item_title');
        ?>
        <div class="group-button">
            <div class="inner">
                <div class="add-to-cart">
                    <?php do_action('bianco_template_shop_loop_add_to_cart'); ?>
                </div>
                <?php do_action('bianco_wishlist_button'); ?>
                <?php do_action('bianco_compare_button'); ?>
            </div>
        </div>

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
</div>
<?php
remove_action('woocommerce_after_shop_loop_item_title','bianco_custom_template_loop_rating',25);
remove_action('woocommerce_after_shop_loop_item_title','bianco_show_coundown_inside_product',30);
add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',25);