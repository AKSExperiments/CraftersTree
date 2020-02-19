<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>

            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                <thead>
                <tr>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-name"><?php esc_html_e( 'Product', 'bianco' ); ?></th>
                    <th class="product-price"><?php esc_html_e( 'Price', 'bianco' ); ?></th>
                    <th class="product-quantity"><?php esc_html_e( 'Quantity', 'bianco' ); ?></th>
                    <th class="product-subtotal"><?php esc_html_e( 'Total', 'bianco' ); ?></th>
                    <th class="product-remove">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>

				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                            <td class="product-thumbnail">
								<?php
								$data_img = array();
								$data_thumbnail = '<figure></figure>';
								if ( has_post_thumbnail( $_product->get_id() ) ) {
									$data_img = wp_get_attachment_image_src( $_product->get_image_id(), array( '110', '110' ) );
									$data_thumbnail = '<figure><img width="110" height="110" src="' . esc_url( $data_img[0] ) . '"></figure>';
								}
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $data_thumbnail, $cart_item, $cart_item_key );
								if ( !$product_permalink ) {
									echo wp_kses_post( $thumbnail );
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
								}
								?>
                            </td>

                            <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'bianco' ); ?>">
								<?php
								if ( !$product_permalink ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
								} else {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
								}
								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
								// Meta data.
								echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
								// Backorder notification.
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'bianco' ) . '</p>' ) );
								}
								?>
                            </td>

                            <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'bianco' ); ?>">
								<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
                            </td>

                            <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'bianco' ); ?>">
								<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $_product->get_max_purchase_quantity(),
										'min_value'    => '0',
										'product_name' => $_product->get_name(),
									), $_product, false
									);
								}
								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
								?>
                            </td>

                            <td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'bianco' ); ?>">
								<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
                            </td>

                            <td class="product-remove">
								<?php
								// @codingStandardsIgnoreLine
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="bianco-icon icon-round-cancel">
                
                </span></a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_html__( 'Remove this item', 'bianco' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key
								);
								?>
                            </td>
                        </tr>
						<?php
					}
				}
				?>

				<?php do_action( 'woocommerce_cart_contents' ); ?>

                <tr>
                    <td colspan="6" class="actions">
                        <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"
                           class="btn btn-continue-shopping"><?php esc_html_e( 'continue Shopping', 'bianco' ) ?></a>
                        <a href="<?php echo add_query_arg( 'clear-cart', 'true', wc_get_cart_url()); ?>" class="btn btn-clear-cart"><?php esc_html_e( 'Clear cart', 'bianco' ) ?></a>
                        <button type="submit" class="button btn btn-update-cart" name="update_cart"
                                value="<?php esc_attr_e( 'Update cart', 'bianco' ); ?>"><?php esc_html_e( 'Update cart', 'bianco' ); ?></button>

						<?php if ( wc_coupons_enabled() ) { ?>
                            <div class="coupon">
                                <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'bianco' ); ?></label> <input
                                        type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
                                        placeholder="<?php esc_attr_e( 'Coupon code', 'bianco' ); ?>"/>
                                <button type="submit" class="button btn" name="apply_coupon"
                                        value="<?php esc_attr_e( 'Apply coupon', 'bianco' ); ?>"><?php esc_attr_e( 'Apply coupon', 'bianco' ); ?></button>
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
                            </div>
						<?php } ?>

						<?php do_action( 'woocommerce_cart_actions' ); ?>

						<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                    </td>
                </tr>

				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
                </tbody>
            </table>
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
        </form>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="cart-collaterals">
			<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
			?>
        </div>
    </div>

	<?php do_action( 'bianco_cross_sell_display' ); ?>

</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
