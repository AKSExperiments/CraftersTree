<?php
/**
 * Name: Product Style List
 * Slug: content-product-style-list
 * Shortcode: true
 * Theme Option: false
 **/
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',25);
add_action('woocommerce_shop_loop_item_title','bianco_custom_template_loop_rating',20);

remove_action( 'woocommerce_after_shop_loop_item_title', 'bianco_template_loop_product_title', 15 );
add_action( 'woocommerce_shop_loop_item_title', 'bianco_template_loop_product_title', 15 );

?>
<div class="product-content content-detail-in-loop">
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

        <div class="product-attr-info">
            <?php
            /**
             * woocommerce_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_product_title - 10
             */

            do_action('woocommerce_shop_loop_item_title');
            do_action('bianco_advance_product_attribute');
            ?>

        </div>

        <div class="product-info">
            <?php

            /**
             * woocommerce_after_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */

            do_action('woocommerce_after_shop_loop_item_title');

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

    </div>
</div>
<?php

remove_action('woocommerce_shop_loop_item_title','bianco_custom_template_loop_rating',20);
add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',25);

remove_action( 'woocommerce_shop_loop_item_title', 'bianco_template_loop_product_title', 15 );
add_action( 'woocommerce_after_shop_loop_item_title', 'bianco_template_loop_product_title', 15 );