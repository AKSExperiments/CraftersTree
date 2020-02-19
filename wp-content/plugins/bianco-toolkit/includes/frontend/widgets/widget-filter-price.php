<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
if ( !class_exists( 'Price_Filters_Widget' ) ) {
	class Price_Filters_Widget extends WC_Widget
	{
		public function __construct()
		{
			$this->widget_cssclass    = 'ovic-price-filters';
			$this->widget_description = esc_html__( 'Make the price filters list in shop sidebar', 'bianco-toolkit' );
			$this->widget_id          = 'widget_price_filter';
			$this->widget_name        = esc_html__( 'Ovic: Price Filters List', 'bianco-toolkit' );
			parent::__construct();
			add_action( 'admin_print_scripts', array( $this, 'enqueue_resource' ) );
		}

		public function enqueue_resource()
		{
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'price-filter-js', OVIC_FRAMEWORK_URI . 'widgets/wg-resources/admin.js', array( 'jquery' ), '0.1', true );
			wp_enqueue_style( 'price-filter-css', OVIC_FRAMEWORK_URI . 'widgets/wg-resources/admin.css', array(), '1.0', 'all' );
		}

		protected function get_price_filter_link( $min = 0, $max = 0, $base_url )
		{
			if ( absint( $max ) >= 1 ) {
				$base_url = add_query_arg( 'max_price', wc_clean( $max ), $base_url );
			}
			if ( absint( $min ) >= 0 ) {
				$base_url = add_query_arg( 'min_price', wc_clean( $min ), $base_url );
			}

			return $base_url;
		}

		public function widget( $args, $instance )
		{
			if ( !is_product() && is_woocommerce() ) {
				$arr_data = array();
				if ( $instance['content'] ) {
					$arr_data = explode( '/', $instance['content'] );
					$arr_data = array_filter( $arr_data );
				}
				$value    = array( 'min' => '0', 'max' => 0 );
				$base_url = $this->get_page_base_url();
				$currency_symbol = get_woocommerce_currency_symbol();
				$price_format    = get_woocommerce_price_format();
				ob_start();
				echo $args['before_widget'];
				if ( $instance['title'] ) {
					echo $args['before_title'] . $instance['title'] . $args['after_title'];
				} ?>

                <div class="price-filter-inner">
                    <div class="wrap-input-form">
                        <form class="woocommerce-price" method="get">
                            <p class="form-row">
                            	<?php printf( $price_format, '<span class="woocommerce-Price-currencySymbol" for="'.esc_attr( $args['widget_id'] ).'-min-price">' . $currency_symbol . '</span>', '<input type="text" name="min_price" pattern="[0-9]*" value=""
                                       id="'.esc_attr( $args['widget_id'] ).'-min-price"/>' ); ?>
                            </p>
                            <p class="form-row wp-seprater"><span class="seprater"><?php esc_html_e( 'to', 'bianco-toolkit' ); ?></span></p>
                            <p class="form-row">
                            	<?php printf( $price_format, '<span class="woocommerce-Price-currencySymbol" for="'.esc_attr( $args['widget_id'] ).'-max-price">' . $currency_symbol . '</span>', '<input type="text" name="max_price" pattern="[0-9]*" value=""
                                       id="'.esc_attr( $args['widget_id'] ).'-max-price"/>' ); ?>
							</p>
                            <button class="btn btn-submit" type="submit"
                                    value=""><?php esc_html_e( 'go', 'bianco-toolkit' ); ?></button>
                        </form>
                    </div>
					<?php if ( !empty( $arr_data ) ): ?>
                        <ul class="list-filter">
							<?php foreach ( $arr_data as $item ) : ?>
								<?php
								$_val         = explode( '-', $item );
								$value['min'] = $_val[0];
								$value['max'] = $_val[1];
								$selected     = isset( $_GET['min_price'] ) && isset( $_GET['max_price'] ) && $_GET['min_price'] == $value['min'] && $_GET['max_price'] == $value['max'] ? 'selected' : '';
								?>
                                <li class="filter-item <?php echo esc_attr( $selected ); ?>">
                                    <a href="<?php echo $this->get_price_filter_link( $value['min'], $value['max'], $base_url ); ?>" class="filter-link">
                                    	<?php printf( '%s - %s', wc_price( $value['min']), wc_price( $value['max'] )) ?></a>
                                </li>
							<?php endforeach; ?>
                        </ul>
					<?php endif; ?>
                </div>

				<?php echo $args['after_widget']; ?>

				<?php
				echo apply_filters( 'ovic_filter_widget_product_slide', ob_get_clean(), $instance );
			}
		}

		public function update( $new_instance, $old_instance )
		{
			$instance = $old_instance;
			if ( !empty( $new_instance['content'] ) )
				$instance['content'] = $new_instance['content'];
			if ( !empty( $new_instance['title'] ) )
				$instance['title'] = $new_instance['title'];

			return $instance;
		}

		public function form( $instance )
		{
			$defaults = array(
				'content' => '',
				'title'   => esc_html__( 'By Price', 'bianco-toolkit' ),
			);
			$instance = wp_parse_args( (array)$instance, $defaults );
			$arr_data = explode( '/', $instance['content'] );
			$arr_data = array_filter( $arr_data );
			?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'bianco-toolkit' ); ?></label>
                <input type="text" class="widefat " id="<?php echo $this->get_field_id( 'title' ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                       value="<?php echo esc_attr( $instance['title'] ); ?>"/>
            </p>
            <p class="frm_input prices-filters">
                <span class="frm-title"><?php esc_html_e( 'Create new fillter item:','bianco-toolkit' ); ?></span>
                <label for="<?php echo $this->get_field_id( 'from' ); ?>"><?php esc_html_e( 'From:', 'bianco-toolkit' ); ?></label>
                <input type="number" class="wide" id="<?php echo $this->get_field_id( 'from' ); ?>" name="int_from"
                       value=""/>

                <label for="<?php echo $this->get_field_id( 'to' ); ?>"><?php esc_html_e( 'To:', 'bianco-toolkit' ); ?></label>
                <input type="number" class="wide" id="<?php echo $this->get_field_id( 'to' ); ?>" name="int_to"
                       value=""/>

                <input type="hidden" class="input_content" id="<?php echo $this->get_field_id( 'content' ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>"
                       value="<?php echo esc_attr( $instance['content'] ); ?>">

                <a class="button btn_save"><?php esc_html_e( 'Add item', 'bianco-toolkit' ); ?></a>
                <a class="button btn_clear" style="margin-left: 10px"><?php esc_html_e( 'Clear All', 'bianco-toolkit' ); ?></a>
            </p>
            <ul class="results">
                <li class="title"><?php esc_html_e( 'Filter List', 'bianco-toolkit' ); ?></li>
				<?php if ( !empty( $arr_data ) ): ?>
					<?php foreach ( $arr_data as $item ): ?>
						<?php $array_filter_item = explode( '-', $item ); ?>
                        <li class="list-item" data-value="<?php echo esc_attr( $item ); ?>">
                            <span class="min-value"><?php echo wc_price( $array_filter_item[0] ); ?></span><span class="break-line">-</span><span class="max-value"><?php echo wc_price( $array_filter_item[1] ); ?></span>
                        </li>
					<?php endforeach; ?>
				<?php endif; ?>
            </ul>
			<?php
		}

		protected function get_page_base_url()
		{
			if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
				$link = home_url( '/' );
			} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
				$link = get_post_type_archive_link( 'product' );
			} elseif ( is_product_category() ) {
				$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
			} elseif ( is_product_tag() ) {
				$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
			} else {
				$link = get_term_link( get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			}
			// Min/Max
			if ( isset( $_GET['min_price'] ) ) {
				$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
			}
			if ( isset( $_GET['max_price'] ) ) {
				$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
			}
			// Orderby
			if ( isset( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
			}
			/**
			 * Search Arg.
			 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
			 */
			if ( get_search_query() ) {
				$link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
			}
			// Post Type Arg
			if ( isset( $_GET['post_type'] ) ) {
				$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
			}
			// Min Rating Arg
			if ( isset( $_GET['min_rating'] ) ) {
				$link = add_query_arg( 'min_rating', wc_clean( $_GET['min_rating'] ), $link );
			}
			// All current filters
			if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
				foreach ( $_chosen_attributes as $name => $data ) {
					$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
					if ( !empty( $data['terms'] ) ) {
						$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
					}
					if ( 'or' == $data['query_type'] ) {
						$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
					}
				}
			}

			return $link;
		}
	}
}
add_action( 'widgets_init', 'register_price_filters_widget' );
function register_price_filters_widget()
{
	register_widget( 'Price_Filters_Widget' );
}