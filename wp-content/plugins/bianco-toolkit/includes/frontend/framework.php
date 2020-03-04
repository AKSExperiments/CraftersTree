<?php
/**
 * Ovic Framework setup
 *
 * @author   KHANH
 * @category API
 * @package  Ovic_Framework_Options
 * @since    1.0.1 : <span class="spinner is-active"></span>
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
if ( !class_exists( 'Ovic_Framework_Options' ) ) {
	class Ovic_Framework_Options
	{
		public  $version = '1.0.0';
		private $thems_options;

		public function __construct()
		{
			$this->define_constants();
			add_action( 'plugins_loaded', array( $this, 'includes' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
			add_action( 'after_setup_theme', array( $this, 'load_after_setup' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			if ( !is_admin() ) {
				/* CUSTOM IMAGE ELEMENT */
				add_filter( 'post_thumbnail_html', array( $this, 'ovic_post_thumbnail_html' ), 10, 5 );
				add_filter( 'vc_wpb_getimagesize', array( $this, 'ovic_vc_wpb_getimagesize' ), 10, 3 );
				add_filter( 'wp_kses_allowed_html', array( $this, 'ovic_wp_kses_allowed_html' ), 10, 2 );
				add_filter( 'wp_get_attachment_image_attributes', array( $this, 'ovic_lazy_attachment_image' ), 10, 3 );
			}
			/* FILTER */
			add_filter( 'ovic_get_option', array( $this, 'ovic_get_option' ), 10, 2 );
			add_filter( 'ovic_carousel_data_attributes', array( $this, 'ovic_carousel_data_attributes' ), 10, 2 );
			add_filter( 'ovic_getProducts', array( $this, 'ovic_getProducts' ), 10, 3 );
			add_filter( 'ovic_get_theme_options', array( $this, 'get_theme_options' ), 10, 3 );
			/* CUSTOM IMAGE ELEMENT */
			add_filter( 'ovic_resize_image', array( $this, 'ovic_resize_image' ), 10, 6 );
			add_action( 'get_template_blog', array( $this, 'get_template_blog' ) );
			/* REGISTER POSTTYPE */
			add_action( 'init', array( $this, 'register_post_type' ), 999 );
			add_action( 'yith_woocompare_popup_head', array( $this, 'custom_css_yith_compare' ) );
		}

		/**
		 * Define Ovic Constants.
		 */
		private function define_constants()
		{
			if ( !defined( 'OVIC_FRAMEWORK_VERSION' ) ) {
				define( 'OVIC_FRAMEWORK_VERSION', $this->version );
			}
			if ( !defined( 'OVIC_FRAMEWORK_URI' ) ) {
				define( 'OVIC_FRAMEWORK_URI', plugin_dir_url( __FILE__ ) );
			}
			if ( !defined( 'OVIC_FRAMEWORK_THEME_PATH' ) ) {
				define( 'OVIC_FRAMEWORK_THEME_PATH', get_template_directory() );
			}
			if ( !defined( 'OVIC_FRAMEWORK_PATH' ) ) {
				define( 'OVIC_FRAMEWORK_PATH', plugin_dir_path( __FILE__ ) );
			}
			if ( !defined( 'OVIC_PRODUCT_PATH' ) ) {
				define( 'OVIC_PRODUCT_PATH', apply_filters( 'ovic_woocommece_path', '/woocommerce/product-styles/' ) );
			}
			if ( !defined( 'OVIC_BLOG_PATH' ) ) {
				define( 'OVIC_BLOG_PATH', apply_filters( 'ovic_template_blog_style', '/templates/blog/blog-style/' ) );
			}
		}

		public function custom_css_yith_compare()
		{
			?>
            <link rel="stylesheet" href="<?php printf( "%sassets/css/custom-css-yith-compare.css", OVIC_FRAMEWORK_URI ) ?>"/>
			<?php
		}

		public function includes()
		{
			include_once( 'theme-options/theme-options.php' );
			include_once( 'includes/ovic-ajax.php' );
			include_once( 'includes/ovic-abstracts-widget.php' );
			include_once( 'includes/ovic-helpers.php' );
			include_once( 'includes/ovic-add-share.php' );
			/* WIDGET */
			$this->ovic_includes_widgets_template();
			$this->setup_theme_options();
		}

		public function ovic_includes_widgets_template()
		{
			$directory_widget = '';
			$widgets_name     = array(
				'widget-socials.php',
				'widget-instagram.php',
				'widget-newsletter.php',
				'widget-iconbox.php',
				'widget-custommenu.php',
				'widget-recent-blog.php',
			);
			if ( class_exists( 'WooCommerce' ) ) {
				$widgets_name[] = 'widget-filter-price.php';
				$widgets_name[] = 'widget-product-slide.php';
				$widgets_name[] = 'widget-attribute-product.php';
				$widgets_name[] = 'widget-ovic-title.php';
			}
			$widgets_name   = apply_filters( 'ovic_name_widgets_template', $widgets_name );
			$path_templates = apply_filters( 'ovic_templates_widgets', 'framework/widgets' );
			if ( !empty( $widgets_name ) ) {
				foreach ( $widgets_name as $widget ) {
					if ( is_file( plugin_dir_path( __FILE__ ) . 'widgets/' . $widget ) ) {
						$directory_widget = 'widgets/' . $widget;
					}
					if ( is_file( get_template_directory() . '/' . $path_templates . '/' . $widget ) ) {
						$directory_widget = get_template_directory() . '/' . $path_templates . '/' . $widget;
					}
					if ( $directory_widget != '' )
						include_once( $directory_widget );
				}
			}
		}

		private function setup_theme_options()
		{
			$cs_option = array();
			if ( defined( 'OVIC_CUSTOMIZE' ) ) {
				$cs_option = get_option( OVIC_CUSTOMIZE );
			}
			$this->thems_options = ( has_filter( 'ovic_theme_option_data' ) ) ? apply_filters( 'ovic_theme_option_data', $cs_option ) : $cs_option;
		}

		public function get_theme_options()
		{
			return $this->thems_options;
		}

		public function ovic_get_option( $option_name = '', $default = '' )
		{
			$cs_option = null;
			if ( defined( 'OVIC_CUSTOMIZE' ) ) {
				$cs_option = get_option( OVIC_CUSTOMIZE );
			}
			$options = apply_filters( 'ovic_get_customize_option', $cs_option, $option_name, $default );
			if ( !empty( $options ) && isset( $options[$option_name] ) ) {
				$option = $options[$option_name];
				if ( is_array( $option ) && isset( $option['multilang'] ) && $option['multilang'] == true ) {
					if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
						if ( isset( $option[ICL_LANGUAGE_CODE] ) ) {
							return $option[ICL_LANGUAGE_CODE];
						}
					} else {
						$option = reset( $option );
					}
				}

				return ( has_filter( 'ovic_get_demo_option' ) ) ? apply_filters( 'ovic_get_demo_option', $option_name, $option ) : $option;
			} else {
				return $default;
			}
		}

		public function widgets_init()
		{
			$multi_sidebar = $this->ovic_get_option( 'multi_sidebar', '' );
			if ( is_array( $multi_sidebar ) && count( $multi_sidebar ) > 0 ) {
				foreach ( $multi_sidebar as $sidebar ) {
					if ( $sidebar ) {
						register_sidebar( array(
								'name'          => $sidebar['add_sidebar'],
								'id'            => 'custom-sidebar-' . sanitize_key( $sidebar['add_sidebar'] ),
								'before_widget' => '<div id="%1$s" class="widget %2$s">',
								'after_widget'  => '</div>',
								'before_title'  => '<h2 class="widgettitle">',
								'after_title'   => '<span class="arrow"></span></h2>',
							)
						);
					}
				}
			}
		}

		public function admin_scripts()
		{
			wp_enqueue_style( 'font-awesome', OVIC_FRAMEWORK_URI . 'assets/css/font-awesome.min.css' );
			wp_enqueue_style( 'chosen', OVIC_FRAMEWORK_URI . 'assets/css/chosen.min.css' );
			wp_enqueue_style( 'themify', OVIC_FRAMEWORK_URI . 'assets/css/themify-icons.css' );
			wp_enqueue_style( 'ovic-backend', OVIC_FRAMEWORK_URI . 'assets/css/backend.css' );
			/* SCRIPTS */
			wp_enqueue_script( 'chosen', OVIC_FRAMEWORK_URI . 'assets/js/libs/chosen.min.js', array(), null, true );
			wp_enqueue_script( 'ovic-backend', OVIC_FRAMEWORK_URI . 'assets/js/backend.js', array(), null, true );
		}

		public function front_scripts()
		{
			global $wp_query;
			$posts = $wp_query->posts;
			foreach ( $posts as $post ) {
				if ( is_a( $post, 'WP_Post' ) && !has_shortcode( $post->post_content, 'contact-form-7' ) ) {
					wp_dequeue_script( 'contact-form-7' );
				}
			}

			if ( !is_admin() ){
                wp_dequeue_style( 'woocommerce_admin_styles' );
            }
			wp_enqueue_style( 'animate-css' );
			wp_enqueue_style( 'magnific-popup', BIANCO_TOOLKIT_PLUGIN_URL . 'assets/css/magnific-popup.css' );
			wp_enqueue_style( 'bootstrap', OVIC_FRAMEWORK_URI . 'assets/css/bootstrap.min.css' );
			wp_enqueue_style( 'font-awesome', OVIC_FRAMEWORK_URI . 'assets/css/font-awesome.min.css' );
			wp_enqueue_style( 'pe-icon-7-stroke', OVIC_FRAMEWORK_URI . 'assets/css/pe-icon-7-stroke.min.css' );
			wp_enqueue_style( 'slick', OVIC_FRAMEWORK_URI . 'assets/css/slick.min.css', array(), '3.3.7' );
			wp_enqueue_style( 'themify', OVIC_FRAMEWORK_URI . 'assets/css/themify-icons.css', array(), '1.8.2' );
			wp_enqueue_style( 'chosen', OVIC_FRAMEWORK_URI . 'assets/css/chosen.min.css', array(), '1.8.2' );
			wp_enqueue_style( 'growl', OVIC_FRAMEWORK_URI . 'assets/css/jquery.growl.min.css', array(), '1.0.0' );
			/* SCRIPTS */
			$ovic_gmap_api_key = $this->ovic_get_option( 'ovic_gmap_api_key' );
			if ( $ovic_gmap_api_key ) {
				wp_enqueue_script( 'ovic-api-map', esc_url( '//maps.googleapis.com/maps/api/js?key=' . trim( $ovic_gmap_api_key ) ), array(), false, true );
			}
			wp_enqueue_script( 'threesixty', OVIC_FRAMEWORK_URI . 'assets/js/libs/threesixty.min.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'serialize-object', OVIC_FRAMEWORK_URI . 'assets/js/libs/serialize-object.min.js', array( 'jquery' ), '2.5.0', true );
			wp_enqueue_script( 'magnific-popup', BIANCO_TOOLKIT_PLUGIN_URL . 'assets/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'bootstrap', OVIC_FRAMEWORK_URI . 'assets/js/libs/bootstrap.min.js', array(), '3.3.7', true );
			wp_enqueue_script( 'slick', OVIC_FRAMEWORK_URI . 'assets/js/libs/slick.min.js', array(), '1.0.0', true );
			/* http://hilios.github.io/jQuery.countdown/documentation.html */
			wp_enqueue_script( 'countdown', OVIC_FRAMEWORK_URI . 'assets/js/libs/countdown.min.js', array(), '1.0.0', true );
			wp_enqueue_script( 'chosen', OVIC_FRAMEWORK_URI . 'assets/js/libs/chosen.min.js', array(), '1.8.7', true );
			/* http://jquery.eisbehr.de/lazy */
			wp_enqueue_script( 'lazyload', OVIC_FRAMEWORK_URI . 'assets/js/libs/lazyload.min.js', array(), '1.7.9', true );
			wp_enqueue_script( 'growl', OVIC_FRAMEWORK_URI . 'assets/js/libs/growl.min.js', array(), '1.7.6', true );
			wp_enqueue_script( 'ovic-script', OVIC_FRAMEWORK_URI . 'assets/js/frontend.js', array(), '1.0', true );
			/* Custom js */
			$ovic_custom_js = $this->ovic_get_option( 'ovic_ace_script', '' );
			$content        = preg_replace( '/\s+/', ' ', $ovic_custom_js );
			wp_add_inline_script( 'ovic-script', $content );
			/* ATTRIBUTE SLIDE THUMB PRODUCT */
            $ovic_product_thumbnail_ls_items = $this->ovic_get_option( 'ovic_product_thumbnail_ls_items', 3 );
            $ovic_product_thumbnail_md_items = $this->ovic_get_option( 'ovic_product_thumbnail_md_items', 3 );
            $ovic_product_thumbnail_sm_items = $this->ovic_get_option( 'ovic_product_thumbnail_sm_items', 3 );
            $ovic_product_thumbnail_xs_items = $this->ovic_get_option( 'ovic_product_thumbnail_xs_items', 2 );
			$slick_data = Array(
				'slidesMargin' => 10,
				'slidesToShow' => (int) $ovic_product_thumbnail_ls_items,
				'vertical'     => true,
                'infinite'     => false,
				'responsive'   => array(
					Array(
						'breakpoint' => 1500,
						'settings'   => Array(
							'slidesToShow' => (int) $ovic_product_thumbnail_ls_items,
							'vertical'     => true,
						),
					),
					Array(
						'breakpoint' => 1200,
						'settings'   => Array(
							'slidesToShow' => (int) $ovic_product_thumbnail_ls_items,
							'vertical'     => true,
						),
					),
					Array(
						'breakpoint' => 992,
						'settings'   => Array(
							'slidesToShow' => (int) $ovic_product_thumbnail_md_items,
							'vertical'     => false,
						),
					),
					Array(
						'breakpoint' => 768,
						'settings'   => Array(
							'slidesToShow' => (int) $ovic_product_thumbnail_sm_items,
							'vertical'     => false,
						),
					),
					Array(
						'breakpoint' => 480,
						'settings'   => Array(
							'slidesToShow' => (int) $ovic_product_thumbnail_xs_items,
							'vertical'     => false,
						),
					),
				),
			);
			/* AJAX VALUE GLOBAL */
			wp_localize_script( 'ovic-script', 'ovic_ajax_frontend', array(
					'ajaxurl'                         => admin_url( 'admin-ajax.php', 'relative' ),
					'ovic_ajax_url'                   => class_exists( 'OVIC_AJAX' ) ? OVIC_AJAX::get_endpoint( '%%endpoint%%' ) : admin_url( 'admin-ajax.php', 'relative' ),
					'security'                        => wp_create_nonce( 'ovic_ajax_frontend' ),
					'added_to_cart_notification_text' => apply_filters( 'tools_added_to_cart_notification_text', esc_html__( 'has been added to cart!', 'bianco-toolkit' ) ),
					'view_cart_notification_text'     => apply_filters( 'tools_view_cart_notification_text', esc_html__( 'View Cart', 'bianco-toolkit' ) ),
					'added_to_cart_text'              => apply_filters( 'tools_adding_to_cart_text', esc_html__( 'Product has been added to cart!', 'bianco-toolkit' ) ),
					'wc_cart_url'                     => ( function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '' ),
					'added_to_wishlist_text'          => get_option( 'yith_wcwl_product_added_text', esc_html__( 'Product has been added to wishlist!', 'bianco-toolkit' ) ),
					'wishlist_url'                    => ( function_exists( 'YITH_WCWL' ) ? esc_url( YITH_WCWL()->get_wishlist_url() ) : '' ),
					'browse_wishlist_text'            => get_option( 'yith_wcwl_browse_wishlist_text', esc_html__( 'Browse Wishlist', 'bianco-toolkit' ) ),
					'growl_notice_text'               => esc_html__( 'Notice!', 'bianco-toolkit' ),
					'growl_duration'                  => 6000,
					'removed_cart_text'               => esc_html__( 'Product Removed', 'bianco-toolkit' ),
					'wp_nonce_url'                    => ( function_exists( 'wc_get_cart_url' ) ? wp_nonce_url( wc_get_cart_url() ) : '' ),
					'data_slick'                      => $slick_data,
					'lbl_email_to_friend'             => __( 'Email to friend', 'bianco-toolkit' ),
				)
			);
		}

		public function ovic_google_fonts()
		{
			$enable_typography = $this->ovic_get_option( 'ovic_enable_typography' );
			$typography_group  = $this->ovic_get_option( 'typography_group' );
			$settings          = get_option( 'wpb_js_google_fonts_subsets' );
			$font_families     = array();
			if ( $enable_typography == 1 && !empty( $typography_group ) ) {
				foreach ( $typography_group as $typography ) {
					$font_families[] = str_replace( ' ', '+', $typography['ovic_typography_font_family']['family'] );
				}
			}
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
			);
			if ( is_array( $settings ) && !empty( $settings ) )
				$query_args['subset'] = implode( ',', $settings );
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

			return esc_url_raw( $fonts_url );
		}

		public function ovic_custom_inline_css()
		{
			$ace_style         = $this->ovic_get_option( 'ovic_ace_style', '' );
			$enable_typography = $this->ovic_get_option( 'ovic_enable_typography' );
			$typography_group  = $this->ovic_get_option( 'typography_group' );
			$custom_css        = $ace_style;
			if ( $enable_typography == 1 && !empty( $typography_group ) ) {
				foreach ( $typography_group as $typography ) {
					$custom_css .= "{$typography['ovic_element_tag']}{";
					if ( $typography['ovic_typography_font_family']['family'] )
						$custom_css .= "font-family: {$typography['ovic_typography_font_family']['family']};";
					if ( $typography['ovic_typography_font_family']['weight'] )
						$custom_css .= "font-weight: {$typography['ovic_typography_font_family']['weight']};";
					$custom_css .= "font-size: {$typography['ovic_typography_font_size']}px;";
					$custom_css .= "line-height: {$typography['ovic_typography_line_height']}px;";
					$custom_css .= "color: {$typography['ovic_body_text_color']};";
					$custom_css .= "}";
				}
			}
			$css     = apply_filters( 'ovic_main_custom_css', $custom_css );
			$content = preg_replace( '/\s+/', ' ', $css );
			wp_enqueue_style( 'ovic-style', OVIC_FRAMEWORK_URI . 'assets/css/frontend.css', array(), '1.0.0' );
			wp_add_inline_style( 'ovic-style', $content );
		}

		public function load_after_setup()
		{
			add_action( 'wp_enqueue_scripts', array( $this, 'ovic_custom_inline_css' ) );
		}

		public function get_template_blog( $style )
		{
			if ( is_file( get_template_directory() . OVIC_BLOG_PATH . 'content-blog-' . $style . '.php' ) ) {
				get_template_part( OVIC_BLOG_PATH . 'content-blog', $style );
			} else {
				echo '<div class="post-thumb">' . get_the_post_thumbnail( get_the_ID(), 'full' ) . '</div>';
				echo '<div class="post-info">
					<ul class="post-meta">
						<li class="date">
							<i class="fa fa-calendar" aria-hidden="true"></i>
							' . get_the_date() . '
						</li>
						<li class="author">
							<i class="fa fa-user" aria-hidden="true"></i>
							<span>' . esc_html__( 'By: ', 'bianco-toolkit' ) . '</span>
							<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">
								' . get_the_author() . '
							</a>
						</li>
					</ul>
					<h2 class="post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>
					</div>';
			}
		}

		public function ovic_default_products( $product_name )
		{
			$product_path = OVIC_PRODUCT_PATH . 'content-product';
			if ( is_file( get_template_directory() . $product_path . '-' . $product_name . '.php' ) ) {
				get_template_part( $product_path, $product_name );
			} else {
				do_action( 'ovic_default_products' );
			}
		}

		public function register_post_type()
		{
			$enable_posttype = $this->ovic_get_option( 'ovic_enable_posttype' );
			$posttype_group  = $this->ovic_get_option( 'posttype_group', array() );
			$taxonomy_group  = $this->ovic_get_option( 'taxonomy_group', array() );
			if ( $enable_posttype == 1 ) {
				if ( !empty( $posttype_group ) ) {
					foreach ( $posttype_group as $posttype ) {
						ovic_register_post_type( $posttype );
					}
				}
				if ( !empty( $taxonomy_group ) ) {
					foreach ( $taxonomy_group as $taxonomy ) {
						ovic_register_taxonomy( $taxonomy );
					}
				}
			}
		}

		public static function ovic_data_responsive_carousel()
		{
			$responsive = array(
				'desktop'          => array(
					'screen'   => 1500,
					'name'     => 'lg_items',
					'title'    => esc_html__( 'The items on desktop (Screen resolution of device >= 1200px and < 1500px )', 'bianco-toolkit' ),
					'settings' => array(),
				),
				'laptop'           => array(
					'screen'   => 1200,
					'name'     => 'md_items',
					'title'    => esc_html__( 'The items on desktop (Screen resolution of device >= 992px < 1200px )', 'bianco-toolkit' ),
					'settings' => array(),
				),
				'tablet'           => array(
					'screen'   => 992,
					'name'     => 'sm_items',
					'title'    => esc_html__( 'The items on tablet (Screen resolution of device >=768px and < 992px )', 'bianco-toolkit' ),
					'settings' => array(),
				),
				'mobile_landscape' => array(
					'screen'   => 768,
					'name'     => 'xs_items',
					'title'    => esc_html__( 'The items on mobile landscape(Screen resolution of device >=480px and < 768px)', 'bianco-toolkit' ),
					'settings' => array(),
				),
				'mobile'           => array(
					'screen'   => 480,
					'name'     => 'ts_items',
					'title'    => esc_html__( 'The items on mobile (Screen resolution of device < 480px)', 'bianco-toolkit' ),
					'settings' => array(),
				),
			);

			return apply_filters( 'ovic_filter_carousel_responsive_screen', $responsive );
		}

		public function ovic_carousel_data_attributes( $prefix, $atts )
		{
			$responsive = array();
			$slick      = array();
			$results    = '';
			if ( isset( $atts[$prefix . 'autoplay'] ) && $atts[$prefix . 'autoplay'] == 'true' ) {
				$slick['autoplay'] = true;
				if ( isset( $atts[$prefix . 'autoplayspeed'] ) && $atts[$prefix . 'autoplay'] == 'true' ) {
					$slick['autoplaySpeed'] = intval( $atts[$prefix . 'autoplayspeed'] );
				}
			}
			if ( isset( $atts[$prefix . 'navigation'] ) ) {
				$slick['arrows'] = $atts[$prefix . 'navigation'] == 'true' ? true : false;
			}
			if ( isset( $atts[$prefix . 'slide_margin'] ) ) {
				$slick['slidesMargin'] = intval( $atts[$prefix . 'slide_margin'] );
			}
			if ( isset( $atts[$prefix . 'dots'] ) ) {
				$slick['dots'] = $atts[$prefix . 'dots'] == 'true' ? true : false;
			}
			if ( isset( $atts[$prefix . 'loop'] ) ) {
				$slick['infinite'] = $atts[$prefix . 'loop'] == 'true' ? true : false;
			}
			if ( isset( $atts[$prefix . 'fade'] ) ) {
				$slick['fade'] = $atts[$prefix . 'fade'] == 'true' ? true : false;
			}
			if ( isset( $atts[$prefix . 'slidespeed'] ) ) {
				$slick['speed'] = intval( $atts[$prefix . 'slidespeed'] );
			}
			if ( isset( $atts[$prefix . 'ls_items'] ) ) {
				$slick['slidesToShow'] = intval( $atts[$prefix . 'ls_items'] );
			}
			if ( isset( $atts[$prefix . 'vertical'] ) && $atts[$prefix . 'vertical'] == 'true' ) {
				$slick['vertical'] = true;
				if ( isset( $atts[$prefix . 'verticalswiping'] ) && $atts[$prefix . 'verticalswiping'] == 'true' ) {
					$slick['verticalSwiping'] = true;
				}
			}
			if ( isset( $atts[$prefix . 'center_mode'] ) && $atts[$prefix . 'center_mode'] == 'true' ) {
				$slick['centerMode'] = true;
				if ( isset( $atts[$prefix . 'center_padding'] ) ) {
					$slick['centerPadding'] = $atts[$prefix . 'center_padding'] . 'px';
				}
			}
			if ( isset( $atts[$prefix . 'focus_select'] ) && $atts[$prefix . 'focus_select'] == 'true' ) {
				$slick['focusOnSelect'] = true;
			}
			if ( isset( $atts[$prefix . 'number_row'] ) ) {
				$slick['rows'] = intval( $atts[$prefix . 'number_row'] );
			}
			$slick   = apply_filters( 'ovic_filter_carousel_slick_attributes', $slick, $prefix, $atts );
			$results .= ' data-slick = ' . json_encode( $slick ) . ' ';
			/* RESPONSIVE */
			$slick_responsive = $this->ovic_data_responsive_carousel();
			foreach ( $slick_responsive as $key => $item ) {
				if ( isset( $atts[$prefix . $item['name']] ) && intval( $atts[$prefix . $item['name']] ) > 0 ) {
					$responsive[$key] = array(
						'breakpoint' => $item['screen'],
						'settings'   => array(
							'slidesToShow' => intval( $atts[$prefix . $item['name']] ),
						),
					);
					if ( !empty( $item['settings'] ) )
						$responsive[$key]['settings'] = array_merge( $responsive[$key]['settings'], $item['settings'] );
					if ( isset( $atts[$prefix . 'responsive_rows'] ) && $atts[$prefix . 'responsive_rows'] >= $item['screen'] ) {
						$responsive[$key]['settings']['rows'] = 1;
					}
					/* RESPONSIVE MARGIN */
					if ( isset( $atts[$prefix . 'responsive_margin'] ) && $atts[$prefix . 'responsive_margin'] >= $item['screen'] ) {
						if ( isset( $atts[$prefix . 'slide_margin'] ) && $atts[$prefix . 'slide_margin'] > 10 ) {
							$responsive[$key]['settings']['slidesMargin'] = 10;
						}
					}
				}
			}
			$responsive = apply_filters( 'ovic_filter_carousel_responsive_attributes', $responsive, $prefix, $atts );
			$results    .= 'data-responsive = ' . json_encode( array_values( $responsive ) ) . ' ';

			return wp_specialchars_decode( $results );
		}

		public function ovic_getProducts( $atts, $args = array(), $ignore_sticky_posts = 1 )
		{
			extract( $atts );
			$target            = isset( $target ) ? $target : 'recent-product';
			$meta_query        = WC()->query->get_meta_query();
			$tax_query         = WC()->query->get_tax_query();
			$args['post_type'] = 'product';
			if ( isset( $atts['taxonomy'] ) and $atts['taxonomy'] ) {
				$tax_query[] = array(
					'taxonomy' => 'product_cat',
					'terms'    => is_array( $atts['taxonomy'] ) ? array_map( 'sanitize_title', $atts['taxonomy'] ) : array_map( 'sanitize_title', explode( ',', $atts['taxonomy'] ) ),
					'field'    => 'slug',
					'operator' => 'IN',
				);
			}
			$args['post_status']         = 'publish';
			$args['paged']               = 1;
			$args['ignore_sticky_posts'] = $ignore_sticky_posts;
			$args['suppress_filter']     = true;
			if ( isset( $atts['per_page'] ) && $atts['per_page'] ) {
				$args['posts_per_page'] = $atts['per_page'];
			}
			$ordering_args = WC()->query->get_catalog_ordering_args();
			$orderby       = isset( $atts['orderby'] ) ? $atts['orderby'] : $ordering_args['orderby'];
			$order         = isset( $atts['order'] ) ? $atts['order'] : $ordering_args['order'];
			$meta_key      = isset( $atts['meta_key'] ) ? $atts['meta_key'] : $ordering_args['meta_key'];
			switch ( $target ):
				case 'best-selling' :
					$args['meta_key'] = 'total_sales';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = $order;
					break;
				case 'top-rated' :
					$args['meta_key'] = '_wc_average_rating';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = $order;
					break;
				case 'product-category' :
					$args['orderby']  = $orderby;
					$args['order']    = $order;
					$args['meta_key'] = $meta_key;
					break;
				case 'products' :
					$args['posts_per_page'] = -1;
					if ( !empty( $ids ) ) {
						$args['post__in'] = array_map( 'trim', explode( ',', $ids ) );
						$args['orderby']  = 'post__in';
					}
					if ( !empty( $skus ) ) {
						$meta_query[] = array(
							'key'     => '_sku',
							'value'   => array_map( 'trim', explode( ',', $skus ) ),
							'compare' => 'IN',
						);
					}
					break;
				case 'featured_products' :
					$tax_query[] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					);
					break;
				case 'product_attribute' :
					$tax_query[] = array(
						array(
							'taxonomy' => strstr( $atts['attribute'], 'pa_' ) ? sanitize_title( $atts['attribute'] ) : 'pa_' . sanitize_title( $atts['attribute'] ),
							'terms'    => $atts['filter'] ? array_map( 'sanitize_title', explode( ',', $atts['filter'] ) ) : array(),
							'field'    => 'slug',
							'operator' => 'IN',
						),
					);
					break;
				case 'on_new' :
					$newness            = $this->ovic_get_option( 'ecome_product_newness', 7 );    // Newness in days as defined by option
					$args['date_query'] = array(
						array(
							'after'     => '' . $newness . ' days ago',
							'inclusive' => true,
						),
					);
					if ( $orderby == '_sale_price' ) {
						$orderby = 'date';
						$order   = 'DESC';
					}
					$args['orderby'] = $orderby;
					$args['order']   = $order;
					break;
				case 'on_sale' :
					$product_ids_on_sale = wc_get_product_ids_on_sale();
					$args['post__in']    = array_merge( array( 0 ), $product_ids_on_sale );
					if ( $orderby == '_sale_price' ) {
						$orderby = 'date';
						$order   = 'DESC';
					}
					$args['orderby'] = $orderby;
					$args['order']   = $order;
					break;
				default :
					$args['orderby'] = $orderby;
					$args['order']   = $order;
					if ( isset( $ordering_args['meta_key'] ) ) {
						$args['meta_key'] = $ordering_args['meta_key'];
					}
					WC()->query->remove_ordering_args();
					break;
			endswitch;
			$args['meta_query'] = $meta_query;
			$args['tax_query']  = $tax_query;

			return $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts , 'product') );
		}

		public function ovic_wp_kses_allowed_html( $allowedposttags, $context )
		{
			$allowedposttags['img']['data-src']    = true;
			$allowedposttags['img']['data-srcset'] = true;
			$allowedposttags['img']['data-sizes']  = true;

			return $allowedposttags;
		}

		public function ovic_lazy_attachment_image( $attr, $attachment, $size )
		{
			$enable_lazy = $this->ovic_get_option( 'ovic_theme_lazy_load' );
			if ( $enable_lazy == 1 ) {
				$data_img         = wp_get_attachment_image_src( $attachment->ID, $size );
				$img_lazy         = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%20" . $data_img[1] . "%20" . $data_img[2] . "%27%2F%3E";
				$attr['data-src'] = $attr['src'];
				$attr['src']      = $img_lazy;
				$attr['class']    .= ' lazy';
				if ( isset( $attr['srcset'] ) && $attr['srcset'] != '' ) {
					$attr['data-srcset'] = $attr['srcset'];
					$attr['data-sizes']  = $attr['sizes'];
					unset( $attr['srcset'] );
					unset( $attr['sizes'] );
				}
			}

			return $attr;
		}

		public function ovic_post_thumbnail_html( $html, $post_ID, $post_thumbnail_id, $size, $attr )
		{
			$enable_lazy = $this->ovic_get_option( 'ovic_theme_lazy_load' );
			if ( $enable_lazy == 1 ) {
				$html = '<figure>' . $html . '</figure>';
			}

			return $html;
		}

		public function ovic_vc_wpb_getimagesize( $img, $attach_id, $params )
		{
			$enable_lazy = $this->ovic_get_option( 'ovic_theme_lazy_load' );
			if ( $enable_lazy == 1 ) {
				$img['thumbnail'] = '<figure>' . $img['thumbnail'] . '</figure>';
			}

			return $img;
		}

		public function ovic_get_attachment_image( $attachment_id, $src, $width, $height, $lazy )
		{
			$image    = '';
			$img_lazy = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%20" . $width . "%20" . $height . "%27%2F%3E";
			if ( $src ) {
				$hwstring   = image_hwstring( $width, $height );
				$size_class = $width . 'x' . $height;
				$attachment = get_post( $attachment_id );
				$attr       = array(
					'src'   => $src,
					'class' => "wp-post-image attachment-$size_class size-$size_class",
					'alt'   => trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
				);
				if ( $lazy == true ) {
					$attr['src']      = $img_lazy;
					$attr['data-src'] = $src;
					$attr['class']    .= ' lazy';
				}
				$attr  = apply_filters( 'ovic_get_attachment_image_attributes', $attr, $attachment );
				$attr  = array_map( 'esc_attr', $attr );
				$image = rtrim( "<img $hwstring" );
				foreach ( $attr as $name => $value ) {
					$image .= " $name=" . '"' . $value . '"';
				}
				$image .= ' />';
			}

			return array(
				'url'    => $src,
				'width'  => $width,
				'height' => $height,
				'img'    => $image,
			);
		}

		public function ovic_resize_image( $attachment_id, $width, $height, $crop = false, $use_lazy = false, $placeholder = true )
		{
			$actual_file_path = '';
			$original         = false;
			$image_src        = array();
			$enable_lazy      = $this->ovic_get_option( 'ovic_theme_lazy_load' );
			if ( $enable_lazy != 1 && $use_lazy == true )
				$use_lazy = false;
			if ( is_singular() && !$attachment_id ) {
				if ( has_post_thumbnail() && !post_password_required() ) {
					$attachment_id = get_post_thumbnail_id();
				}
			}
			if ( is_numeric( $attachment_id ) ) {
				$image_src        = wp_get_attachment_image_src( $attachment_id, 'full' );
				$actual_file_path = get_attached_file( $attachment_id );
			} elseif ( filter_var( $attachment_id, FILTER_VALIDATE_URL ) == true ) {
				$attachment_url = $attachment_id;
				if ( !function_exists( 'get_home_path' ) )
					require_once ABSPATH . 'wp-admin/includes/file.php';
				$file_path        = str_replace( get_site_url(), get_home_path(), $attachment_url );
				$actual_file_path = rtrim( $file_path, '/' );
				if ( !file_exists( $actual_file_path ) ) {
					$file_path        = parse_url( $attachment_url );
					$actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
				}
				if ( file_exists( $actual_file_path ) ) {
					@list( $orig_width, $orig_height ) = getimagesize( $actual_file_path );
					$image_src[0] = $attachment_url;
					$image_src[1] = $orig_width;
					$image_src[2] = $orig_height;
				} else {
					$image_src[0] = '';
					$image_src[1] = 0;
					$image_src[2] = 0;
				}
			}
			if ( $width == false && $height == false ) {
				$original = true;
			}
			if ( !empty( $image_src ) || file_exists( $actual_file_path ) ) {
				if ( $original == false ) {
					if ( file_exists( $actual_file_path ) ) {
						$file_info        = pathinfo( $actual_file_path );
						$extension        = '.' . $file_info['extension'];
						$no_ext_path      = $file_info['dirname'] . '/' . $file_info['filename'];
						$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;
						if ( ( $image_src[1] > $width || $image_src[2] > $height ) ) {
							/* start */
							if ( $crop !== true ) {
								$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
								$resized_img_path  = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;
								if ( file_exists( $resized_img_path ) ) {
									$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

									return $this->ovic_get_attachment_image( $attachment_id, $resized_img_url, $proportional_size[0], $proportional_size[1], $use_lazy );
								}
							}
							if ( file_exists( $cropped_img_path ) ) {
								$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );

								return $this->ovic_get_attachment_image( $attachment_id, $cropped_img_url, $width, $height, $use_lazy );
							}
							/* no cache files - let's finally resize it */
							$img_editor = wp_get_image_editor( $actual_file_path );
							if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
								return array(
									'url'    => '',
									'width'  => '',
									'height' => '',
									'img'    => '',
								);
							}
							$new_img_path = $img_editor->generate_filename();
							if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
								return array(
									'url'    => '',
									'width'  => '',
									'height' => '',
									'img'    => '',
								);
							}
							if ( !is_string( $new_img_path ) ) {
								return array(
									'url'    => '',
									'width'  => '',
									'height' => '',
									'img'    => '',
								);
							}
							@list( $new_width, $new_height ) = getimagesize( $new_img_path );
							$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

							return $this->ovic_get_attachment_image( $attachment_id, $new_img, $new_width, $new_height, $use_lazy );
						}
					} else {
						$image_src = wp_get_attachment_image_src( $attachment_id, array( $width, $height ) );
					}
				}

				return $this->ovic_get_attachment_image( $attachment_id, $image_src[0], $image_src[1], $image_src[2], $use_lazy );
			} else {
				if ( $original == false ) {
					$width           = intval( $width );
					$height          = intval( $height );
					$url_placeholder = esc_url( 'https://via.placeholder.com/' . $width . 'x' . $height );
					$vt_image        = $this->ovic_get_attachment_image( $attachment_id, $url_placeholder, $width, $height, $use_lazy );
					if ( $placeholder == false )
						$vt_image['img'] = '';

					return $vt_image;
				} else {
					return array(
						'url'    => '',
						'width'  => '',
						'height' => '',
						'img'    => '',
					);
				}
			}
		}
	}

	new Ovic_Framework_Options();
}