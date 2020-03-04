<?php
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'Without_OvicToolkit' ) ) {
	class  Without_OvicToolkit{
		private static $instance;
		public static function instance(){
			if ( !isset( self::$instance ) && !( self::$instance instanceof Without_OvicToolkit ) ) {
				self::$instance = new Without_OvicToolkit;
				add_action( 'wp_footer', array( self::$instance, 'wth_toolkit_footer_content'));
				add_action( 'wp_ajax_nopriv_wth_add_cart_single_ajax', array( self::$instance, 'wth_add_cart_single_ajax'));
				add_action( 'wp_ajax_wth_add_cart_single_ajax', array( self::$instance, 'wth_add_cart_single_ajax'));

				add_filter( 'ovic_carousel_data_attributes', array( self::$instance, 'wth_toolkit_carousel_data_attributes'), 10, 2);
				add_filter( 'wp_nav_menu_args', array( self::$instance, 'wth_toolkit_change_nav_menu_args') , 150, 1 );
				add_action( 'wp_enqueue_scripts', array( self::$instance, 'enqueue_scripts' ) );
			}

			return self::$instance;
		}

		public function enqueue_scripts(){
			wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/vendor/bootstrap/bootstrap.min.css'), array(), '3.3.7' );
			wp_enqueue_style( 'chosen', get_theme_file_uri( '/assets/vendor/chosen/chosen.min.css'), array(), '1.8.2');
			wp_enqueue_style( 'slick', get_theme_file_uri( '/assets/vendor/slick/slick.min.css'), array(), '3.3.7');
			wp_enqueue_style( 'growl', get_theme_file_uri( '/assets/vendor/growl/jquery.growl.min.css'), array(), '1.0.0');
			wp_enqueue_style( 'ovic-style', get_theme_file_uri( '/assets/css/without-toolkit.css' ), array(), '1.0.0' );
			wp_enqueue_style( 'menu-frontend-css', get_theme_file_uri( '/assets/vendor/menu-frontend.css' ), array(), '1.0.0' );

			wp_enqueue_script('lazyload', get_theme_file_uri( '/assets/vendor/lazyload.min.js' ), array(), '1.7.9', true);
			wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/assets/vendor/bootstrap/bootstrap.min.js'), array(), '3.3.7', true );
			wp_enqueue_script( 'chosen', get_theme_file_uri( '/assets/vendor/chosen/chosen.min.js'), array(), '1.8.7', true );
			wp_enqueue_script( 'slick', get_theme_file_uri( '/assets/vendor/slick/slick.min.js'), array(), '1.0.0', true);
			wp_enqueue_script( 'growl', get_theme_file_uri( '/assets/vendor/growl/growl.min.js'), array(), '1.7.6', true);
			wp_enqueue_script( 'ovic-script', get_theme_file_uri( '/assets/vendor/frontend.js'), array(), '1.0.0', true);
			wp_enqueue_script( 'menu-frontend', get_theme_file_uri( '/assets/vendor/menu-frontend.js'), array(), '1.0.0', true);
			
			$slick_data = Array(
	            'slidesMargin' => 10,
	            'slidesToShow' => Bianco_Functions::get_option('ovic_product_thumbnail_ls_items', 3),
	            'vertical' => true,
	            'responsive' => array(
	                Array(
	                    'breakpoint' => 1500,
	                    'settings' => Array(
	                        'slidesToShow' => Bianco_Functions::get_option('ovic_product_thumbnail_ls_items', 3),
	                        'vertical' => true,
	                    )
	                ),
	                Array(
	                    'breakpoint' => 1200,
	                    'settings' => Array(
	                        'slidesToShow' => Bianco_Functions::get_option('ovic_product_thumbnail_lg_items', 3),
	                        'vertical' => true,
	                    )
	                ),
	                Array(
	                    'breakpoint' => 992,
	                    'settings' => Array(
	                        'slidesToShow' => Bianco_Functions::get_option('ovic_product_thumbnail_md_items', 3),
	                        'vertical' => false,
	                    )
	                ),
	                Array(
	                    'breakpoint' => 768,
	                    'settings' => Array(
	                        'slidesToShow' => Bianco_Functions::get_option('ovic_product_thumbnail_sm_items', 3),
	                        'vertical' => false,
	                    )
	                ),
	                Array(
	                    'breakpoint' => 480,
	                    'settings' => Array(
	                        'slidesToShow' => Bianco_Functions::get_option('ovic_product_thumbnail_xs_items', 2),
	                        'vertical' => false,
	                    )
	                )
	            )
	        );
			wp_localize_script('ovic-script', 'ovic_ajax_frontend', array(
	                'ajaxurl' => admin_url('admin-ajax.php', 'relative'),
	                'ovic_ajax_url' => admin_url('admin-ajax.php', 'relative'),
	                'security' => wp_create_nonce('ovic_ajax_frontend'),
	                'added_to_cart_notification_text' => apply_filters('tools_added_to_cart_notification_text', esc_html__('has been added to cart!', 'bianco')),
	                'view_cart_notification_text' => apply_filters('tools_view_cart_notification_text', esc_html__('View Cart', 'bianco')),
	                'added_to_cart_text' => apply_filters('tools_adding_to_cart_text', esc_html__('Product has been added to cart!', 'bianco')),
	                'wc_cart_url' => (function_exists('wc_get_cart_url') ? esc_url(wc_get_cart_url()) : ''),
	                'added_to_wishlist_text' => get_option('yith_wcwl_product_added_text', esc_html__('Product has been added to wishlist!', 'bianco')),
	                'wishlist_url' => (function_exists('YITH_WCWL') ? esc_url(YITH_WCWL()->get_wishlist_url()) : ''),
	                'browse_wishlist_text' => get_option('yith_wcwl_browse_wishlist_text', esc_html__('Browse Wishlist', 'bianco')),
	                'growl_notice_text' => esc_html__('Notice!', 'bianco'),
	                'growl_duration' => 6000,
	                'removed_cart_text' => esc_html__('Product Removed', 'bianco'),
	                'wp_nonce_url' => (function_exists('wc_get_cart_url') ? wp_nonce_url(wc_get_cart_url()) : ''),
	                'data_slick' => $slick_data,
	                'lbl_email_to_friend' => __('Email to friend', 'bianco'),
	            )
	        );
		}

		public function wth_toolkit_change_nav_menu_args( $args ){
			if ( is_admin() ) {
				return $args;
			}
			$locations = get_nav_menu_locations();
			if ( !empty( $locations[$args['theme_location']] ) ) {
				$menu = wp_get_nav_menu_object( $locations[$args['theme_location']] );
			} elseif ( !empty( $args['menu'] ) ) {
				$menu = wp_get_nav_menu_object( $args['menu'] );
			} else {
				$menus = (array)wp_get_nav_menus();
				if ( $menus ) {
					foreach ( $menus as $menu ) {
						$has_items = wp_get_nav_menu_items( $menu->term_id, array(
								'update_post_term_cache' => false,
							)
						);
						if ( $has_items ) {
							break;
						}
					}
				}
			}
			if ( !isset( $menu ) || is_wp_error( $menu ) || !is_object( $menu ) ) {
				return $args;
			}
			$megamenu_layout         = get_term_meta( $menu->term_id, '_megamenu_layout', true );
			$megamenu_layout         = $megamenu_layout != "" ? $megamenu_layout : 'horizontal'; //vertical
			$megamenu_layout         = isset( $args['megamenu_layout'] ) ? $args['megamenu_layout'] : $megamenu_layout;
			$container_class         = $args['container_class'] . ' ovic-menu-wapper ' . $megamenu_layout;
			$args['container']       = 'div';
			$args['container_class'] = $container_class;
			$args['menu_class']      = $args['menu_class'] . ' ovic-menu';
			if ( isset( $args['mobile_enable'] ) && $args['mobile_enable'] == 1 ) {
				$args['menu_class']      = $args['menu_class'] . ' ovic-clone-mobile-menu';
				$args['container_class'] = $args['container_class'] . ' support-mobile-menu';
			}

			return $args;
		}

		public function wth_toolkit_carousel_data_attributes($prefix, $atts){
		    $responsive = array();
		    $slick = array();
		    $results = '';
		    if (isset($atts[$prefix . 'autoplay']) && $atts[$prefix . 'autoplay'] == 'true') {
		        $slick['autoplay'] = true;
		        if (isset($atts[$prefix . 'autoplayspeed']) && $atts[$prefix . 'autoplay'] == 'true') {
		            $slick['autoplaySpeed'] = intval($atts[$prefix . 'autoplayspeed']);
		        }
		    }
		    if (isset($atts[$prefix . 'navigation'])) {
		        $slick['arrows'] = $atts[$prefix . 'navigation'] == 'true' ? true : false;
		    }
		    if (isset($atts[$prefix . 'slide_margin'])) {
		        $slick['slidesMargin'] = intval($atts[$prefix . 'slide_margin']);
		    }
		    if (isset($atts[$prefix . 'dots'])) {
		        $slick['dots'] = $atts[$prefix . 'dots'] == 'true' ? true : false;
		    }
		    if (isset($atts[$prefix . 'loop'])) {
		        $slick['infinite'] = $atts[$prefix . 'loop'] == 'true' ? true : false;
		    }
		    if (isset($atts[$prefix . 'fade'])) {
		        $slick['fade'] = $atts[$prefix . 'fade'] == 'true' ? true : false;
		    }
		    if (isset($atts[$prefix . 'slidespeed'])) {
		        $slick['speed'] = intval($atts[$prefix . 'slidespeed']);
		    }
		    if (isset($atts[$prefix . 'ls_items'])) {
		        $slick['slidesToShow'] = intval($atts[$prefix . 'ls_items']);
		    }
		    if (isset($atts[$prefix . 'vertical']) && $atts[$prefix . 'vertical'] == 'true') {
		        $slick['vertical'] = true;
		        if (isset($atts[$prefix . 'verticalswiping']) && $atts[$prefix . 'verticalswiping'] == 'true') {
		            $slick['verticalSwiping'] = true;
		        }
		    }
		    if (isset($atts[$prefix . 'center_mode']) && $atts[$prefix . 'center_mode'] == 'true') {
		        $slick['centerMode'] = true;
		        if (isset($atts[$prefix . 'center_padding'])) {
		            $slick['centerPadding'] = $atts[$prefix . 'center_padding'] . 'px';
		        }
		    }
		    if (isset($atts[$prefix . 'focus_select']) && $atts[$prefix . 'focus_select'] == 'true') {
		        $slick['focusOnSelect'] = true;
		    }
		    if (isset($atts[$prefix . 'number_row'])) {
		        $slick['rows'] = intval($atts[$prefix . 'number_row']);
		    }
		    $slick = apply_filters('ovic_filter_carousel_slick_attributes', $slick, $prefix, $atts);
		    $results .= ' data-slick = ' . json_encode($slick) . ' ';
		    /* RESPONSIVE */
		    $slick_responsive = self::wth_toolkit_data_responsive_carousel();
		    foreach ($slick_responsive as $key => $item) {
		        if (isset($atts[$prefix . $item['name']]) && intval($atts[$prefix . $item['name']]) > 0) {
		            $responsive[$key] = array(
		                'breakpoint' => $item['screen'],
		                'settings' => array(
		                    'slidesToShow' => intval($atts[$prefix . $item['name']]),
		                ),
		            );
		            if (!empty($item['settings']))
		                $responsive[$key]['settings'] = array_merge($responsive[$key]['settings'], $item['settings']);
		            if (isset($atts[$prefix . 'responsive_rows']) && $atts[$prefix . 'responsive_rows'] >= $item['screen']) {
		                $responsive[$key]['settings']['rows'] = 1;
		            }
		            /* RESPONSIVE MARGIN */
		            if (isset($atts[$prefix . 'responsive_margin']) && $atts[$prefix . 'responsive_margin'] >= $item['screen']) {
		                if (isset($atts[$prefix . 'slide_margin']) && $atts[$prefix . 'slide_margin'] > 10) {
		                    $responsive[$key]['settings']['slidesMargin'] = 10;
		                }
		            }
		        }
		    }
		    $responsive = apply_filters('ovic_filter_carousel_responsive_attributes', $responsive, $prefix, $atts);
		    $results .= 'data-responsive = ' . json_encode(array_values($responsive)) . ' ';

		    return wp_specialchars_decode($results);
		}

		public function wth_toolkit_data_responsive_carousel(){
		    $responsive = array(
		        'desktop' => array(
		            'screen' => 1500,
		            'name' => 'lg_items',
		            'title' => esc_html__('The items on desktop (Screen resolution of device >= 1200px and < 1500px )', 'bianco'),
		            'settings' => array(),
		        ),
		        'laptop' => array(
		            'screen' => 1200,
		            'name' => 'md_items',
		            'title' => esc_html__('The items on desktop (Screen resolution of device >= 992px < 1200px )', 'bianco'),
		            'settings' => array(),
		        ),
		        'tablet' => array(
		            'screen' => 992,
		            'name' => 'sm_items',
		            'title' => esc_html__('The items on tablet (Screen resolution of device >=768px and < 992px )', 'bianco'),
		            'settings' => array(),
		        ),
		        'mobile_landscape' => array(
		            'screen' => 768,
		            'name' => 'xs_items',
		            'title' => esc_html__('The items on mobile landscape(Screen resolution of device >=480px and < 768px)', 'bianco'),
		            'settings' => array(),
		        ),
		        'mobile' => array(
		            'screen' => 480,
		            'name' => 'ts_items',
		            'title' => esc_html__('The items on mobile (Screen resolution of device < 480px)', 'bianco'),
		            'settings' => array(),
		        ),
		    );

		    return apply_filters('ovic_filter_carousel_responsive_screen', $responsive);
		}

		public function wth_toolkit_footer_content(){
			$html_result  = esc_html__( 'Copyright © ', 'bianco' );
			$html_result .= date("Y");
			$html_result .= '<span class="theme-name">'.esc_html__( ' Bianco', 'bianco' ).'</span>. ';
			$html_result .= esc_html__( 'All rights reserved', 'bianco' );
			?>
		        <div class="bianco_default_footer">
		        	<div class="container"><p class="txt-ftd"><?php echo wp_specialchars_decode($html_result) ?></p></div>
		        </div>
			<?php
		}

		public function wth_add_cart_single_ajax(){
			if(!class_exists( 'WooCommerce' )) wp_die('no find out WooCommerce class');
			$product_id        = isset( $_POST['product_id'] ) ? apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) ) : 0;
			$product           = wc_get_product( $product_id );
			$quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
			$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
			$product_status    = get_post_status( $product_id );
			$variation_id      = isset( $_POST['variation_id'] ) ? $_POST['variation_id'] : 0;
			$variation         = array();
			if ( $product && 'variation' === $product->get_type() ) {
				$variation_id = $product_id;
				$product_id   = $product->get_parent_id();
				$variation    = $product->get_variation_attributes();
			}
			if ( $product && $passed_validation && 'publish' === $product_status ) {
				if ( 'variation' === $product->get_type() && $variation_id > 0 && $product_id > 0 ) {
					WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );
				} elseif ( is_array( $quantity ) && !empty( $quantity ) && 'group' === $product->get_type() ) {
					foreach ( $quantity as $product_id => $qty ) {
						if ( $qty > 0 )
							WC()->cart->add_to_cart( $product_id, $qty );
					}
				} elseif ( !is_array( $quantity ) && is_numeric( $quantity ) && 'simple' === $product->get_type() ) {
					WC()->cart->add_to_cart( $product_id, $quantity );
				}
				do_action( 'woocommerce_ajax_added_to_cart', $product_id );
				if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
					wc_add_to_cart_message( array( $product_id => $quantity ), true );
				}
				/*Return fragments*/
				WC_AJAX::get_refreshed_fragments();
			} else {
				/*If there was an error adding to the cart, redirect to the product page to show any errors*/
				$data = array(
					'error'       => true,
					'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
				);
				wp_send_json( $data );
			}
			wp_die();
		}

	}
}else{
	die('"Without_OvicToolkit" class is exsisted');
}
if ( !function_exists( 'create_wth_toolkit_instance' ) ) {
	function create_wth_toolkit_instance()
	{
		return Without_OvicToolkit::instance();
	}
	create_wth_toolkit_instance();
}