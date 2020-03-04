<?php
/**
 * Ovic Shop Ajax Setup
 *
 * @author   KHANH
 * @category API
 * @package  Ovic_Shop_Ajax
 * @since    1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( !class_exists( 'Ovic_Shop_Ajax' ) ) {
	class Ovic_Shop_Ajax
	{
		public $options;

		public function __construct()
		{
			$this->options = apply_filters( 'ovic_get_option', 'ovic_woo_enable_ajax' );
			add_action( 'woocommerce_before_main_content', array( $this, 'woocommerce_filter' ), 30 );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		}

		function scripts()
		{
			if ( $this->options == 1 && class_exists( 'WooCommerce' ) && !is_product() && is_woocommerce() ) {
				wp_register_style( 'ovic-shop-ajax', plugin_dir_url( __FILE__ ) . 'shop.css', array(), '1.0' );
				wp_register_script( 'ovic-shop-ajax', plugin_dir_url( __FILE__ ) . 'shop.js', '1.0', true );
			}
		}

		function woocommerce_filter()
		{
			if ( $this->options == 1 && !is_product() && is_woocommerce() ):
				$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
				$classes = array(
					'ul.products',
					'.ovic-responsive-filter',
					'.widget_product_categories',
					'.widget_product_tag_cloud',
					'.widget_layered_nav',
					'.grid-view-mode',
					'.widget_price_filter',
					'.ovic-product-price-filter',
					'.woocommerce-result-count',
					'.woocommerce-products-header__title',
					'.page-header',
					'.woocommerce-pagination',
					'.sub-categories',
					'.woocommerce-products-header',
				);
				$script = array( WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js' );
				wp_enqueue_style( 'ovic-shop-ajax' );
				wp_enqueue_script( 'ovic-shop-ajax' );
				wp_localize_script( 'ovic-shop-ajax', 'ovic_shop_ajax', array(
						'response_class'  => !empty( $classes ) ? array_unique( $classes ) : array(),
						'response_script' => !empty( $script ) ? array_values( $script ) : array(),
						'woo_shop_link'   => get_permalink( wc_get_page_id( 'shop' ) ),
					)
				);
				?>
                <div class="ovic-shop-filter">
                    <div class="inner-content">
                        <span><?php echo esc_html__( 'Fitered by: ', 'kuteshop' ); ?></span>
                        <div class="ovic-responsive-filter">
							<?php the_widget( 'WC_Widget_Layered_Nav_Filters', 'title=' ); ?>
                        </div>
                        <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"
                           class="filter-item reset">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </div>
                </div>
			<?php
			endif;
		}
	}

	new Ovic_Shop_Ajax;
}