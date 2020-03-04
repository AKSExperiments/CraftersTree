<?php
/**
 * Name: Product Style 03
 * Slug: content-product-style-3
 * Shortcode: true
 * Theme Option: false
 **/
global $product;
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 25 );
add_action( 'woocommerce_after_shop_loop_item_title', 'bianco_custom_template_loop_detail_rating', 25 );
$main_title      = esc_html__( 'DAY OF THE DEALS', 'bianco' );
$_title          = apply_filters( 'bianco_sale_product_title_template', $main_title );
$date_on_sale_to = $product->get_date_on_sale_to();
if ( is_object( $date_on_sale_to ) ) : ?>
	<?php $date = $date_on_sale_to->date( 'm/d/Y H:i:s' ); ?>
    <div class="left-info">
        <h3 class="ovic-title"><span class="text"><?php echo esc_html( $_title ); ?></span></h3>
        <?php bianco_show_coundown_inside_product($date); ?>
    </div>
<?php endif; ?>
    <div class="product-inner">
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
        </div>
        <div class="product-info">
			<?php
			/**
			 * woocommerce_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );
			/**
			 * woocommerce_after_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
            <div class="group-button">
                <div class="add-to-cart">
					<?php do_action( 'bianco_template_shop_loop_add_to_cart' ); ?>
                </div>
            </div>
        </div>
		<?php
		/**
		 * woocommerce_after_shop_loop_item hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_close - 5
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' );
		?>
    </div>
<?php
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 25 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'bianco_custom_template_loop_detail_rating', 25 );