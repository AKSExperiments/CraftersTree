<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*==========================================================================
HOOK TEMPLATE FUNCTIONS
===========================================================================*/
/**
 * REMOVE CSS
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'bianco_custom_template_single_meta', 40 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_before_main_content', 'bianco_woocommerce_before_main_content', 20 );
add_action( 'woocommerce_before_main_content', 'bianco_woocommerce_before_loop_content', 52 );
add_action( 'woocommerce_after_main_content', 'bianco_woocommerce_after_loop_content', 50 );
add_action( 'bianco_function_shop_loop_process_available', 'bianco_function_shop_loop_process_available' );
add_action( 'bianco_function_shop_loop_countdown', 'bianco_function_shop_loop_countdown' );

/**
 * MINI CART
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'bianco_cart_link_fragment' );
add_action( 'bianco_header_mini_cart', 'bianco_header_mini_cart' );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
add_action( 'woocommerce_widget_shopping_cart_buttons', 'bianco_widget_shopping_cart_button_view_cart', 30 );
add_action( 'bianco_shop_loop_item_price', 'bianco_shop_loop_item_price' );
add_action( 'bianco_shop_loop_item_countdown', 'bianco_shop_loop_item_countdown' );

/**
 * WISHLIST, COMPARE
 */
add_action( 'bianco_compare', 'bianco_compare' );
add_action( 'bianco_wishlist', 'bianco_wishlist' );
add_action( 'bianco_compare_url', 'bianco_compare_url' );
add_action( 'bianco_wishlist_url', 'bianco_wishlist_url' );
add_action( 'bianco_display_wishlist_block', 'bianco_display_wishlist_block' );
add_action( 'bianco_display_compare_block', 'bianco_display_compare_block' );
add_action( 'bianco_loop_item_categories', 'bianco_loop_item_categories' );
add_action( 'bianco_shop_loop_item_price', 'bianco_shop_loop_item_price', 10, 1 );
add_filter( 'woocommerce_show_page_title', 'bianco_woocommerce_show_page_title' );
add_action( 'woocommerce_register_form_start', 'bianco_show_register_top_message', 10 );

/**
 * Custom change position of add-to-cart button
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'bianco_template_shop_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 );

/**
 * CUSTOM PRODUCT NAME
 */
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'bianco_template_loop_product_title', 15 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 25 );
add_filter( 'woocommerce_catalog_orderby', 'bianco_custom_odering_products_category' );

/**
 * SINGLE PRODUCT
 */
add_filter( 'ovic_single_product_style', 'bianco_single_product_style' );
add_action( 'woocommerce_before_single_product_summary', 'bianco_single_gallery_add_start_wrap_tag', 1 );
add_action( 'woocommerce_before_single_product_summary', 'bianco_single_gallery_add_end_wrap_tag', 50 );
add_action( 'woocommerce_single_product_summary', 'bianco_brand_taxonomy_info', 8 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );
add_action( 'woocommerce_single_product_summary', 'bianco_get_product_availability', 18 );
add_filter( 'woocommerce_get_stock_html', 'bianco_custom_stock_template', 15, 2 );
add_filter( 'woocommerce_output_related_products_args', 'bianco_change_max_output_related_product_number', 10, 1 );

/**
 * add filter wishlist added label
 */
add_filter( 'yith-wcwl-browse-wishlist-label', 'bianco_wishlist_added_label' );

/**
 * PRODUCT RATING
 */
add_filter( 'woocommerce_product_get_rating_html', 'bianco_product_get_rating_html', 10, 3 );

/**
 * Custom sidebar
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_sidebar', 'bianco_woocommerce_sidebar', 15 );
add_action( 'bianco_control_before_content', 'bianco_shop_display_mode_tmp', 40 );

/**
 * SHOP LOOP
 */
add_action( 'woocommerce_before_shop_loop', 'bianco_before_shop_control', 20 );
add_action( 'woocommerce_before_shop_loop', 'bianco_before_woocommerce_content', 50 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_after_shop_loop', 'bianco_after_shop_control', 100 );
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'bianco_after_woocommerce_content', 50 );
add_action( 'bianco_show_product_group_flash', 'bianco_woocommerce_group_flash', 10 );

/**
 * PRODUCT THUMBNAIL
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'bianco_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_main_content', 'bianco_show_hero_section', 5 );

/**
 * BREADCRUMB
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_main_content', 'bianco_woocommerce_breadcrumb', 10 );
add_filter( 'bianco_hero_content', 'bianco_rewrite_hero_banner_content', 10 );

/**
 * REMOVE DESCRIPTION HEADING, INFOMATION HEADING
 */
add_filter( 'woocommerce_product_description_heading', 'bianco_product_description_heading' );
add_filter( 'woocommerce_product_additional_information_heading', 'bianco_product_additional_information_heading' );

/**
 * FILTER PRODUCT SINGE THUMB VERTICAL
 */
add_action( 'wp_ajax_bianco_ajax_product_variation_add_to_cart', 'bianco_ajax_product_variation_add_to_cart' );
add_action( 'wp_ajax_nopriv_bianco_ajax_product_variation_add_to_cart', 'bianco_ajax_product_variation_add_to_cart' );
add_filter( 'yith_wc_social_login_icon', 'bianco_yith_wc_social_login_icon', 10, 3 );

/**
 * LOAD MORE PRODUCTS
 */
add_action( 'wp_ajax_bianco_loadmore_products', 'bianco_loadmore_products' );
add_action( 'wp_ajax_nopriv_bianco_loadmore_products', 'bianco_loadmore_products' );

if ( defined( 'YITH_WCWL' ) ) {
	add_action( 'bianco_shop_loop_item_wishlist', 'bianco_shop_loop_item_wishlist' );
}

/**
 * UPSELL
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'bianco_woo_related', 15 );

/**
 * RELATED
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'bianco_related_products', 20 );

/**
 * CROSS SELL
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'bianco_cross_sell_products' );

/**
 * CUSTOM PRODUCT POST PER PAGE
 */
add_filter( 'loop_shop_per_page', 'bianco_loop_shop_per_page', 20 );
add_filter( 'woof_products_query', 'bianco_woof_products_query', 20 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'wp_ajax_bianco_handle_buy_now_button', 'bianco_handle_buy_now_button' );
add_action( 'wp_ajax_nopriv_bianco_handle_buy_now_button', 'bianco_handle_buy_now_button' );
add_filter( 'woocommerce_format_sale_price','bianco_re_format_sale_price',10,3);
add_action( 'init', 'bianco_woocommerce_clear_cart_via_url' );

/**
 * ADD COUNTDOWN PRODUCT
 */
add_action( 'bianco_function_shop_loop_item_countdown', 'bianco_function_shop_loop_item_countdown' );
add_action( 'ovic_woocommerce_action_attributes', 'ovic_action_attributes' );
add_action( 'bianco_advance_product_attribute', 'woocommerce_template_single_excerpt', 20 );
add_action( 'bianco_advance_product_attribute', 'bianco_get_vendor_user_from_dokan', 10 );
add_action( 'wp_ajax_popup_email_service_via_ajax', 'kt_wcss_popup_email_service_via_ajax' );
add_action( 'wp_ajax_nopriv_popup_email_service_via_ajax', 'kt_wcss_popup_email_service_via_ajax' );

/**
 * Remove Tab More Seller Product
 */
add_filter( 'woocommerce_product_tabs', 'bainco_remove_tab_more_seller_product', 98 );
add_action( 'bianco_single_product_thumnail', 'bianco_single_product_thumnail' );

add_filter( 'woocommerce_product_review_comment_form_args', 'bianco_overwrite_single_product_review', 10 );
/*==========================================================================
TEMPLATE FUNCTIONS
===========================================================================*/
/* WISH LIST */
if ( defined( 'YITH_WCWL' ) ) {
	if ( !function_exists( 'bianco_wishlist_button' ) ) {
		function bianco_wishlist_button()
		{
			echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
		}
	}
	add_action( 'bianco_wishlist_button', 'bianco_wishlist_button', 1 );
	add_action( 'woocommerce_after_add_to_cart_button', 'bianco_wishlist_button', 10 );
}
/* COMPARE */
if ( class_exists( 'YITH_Woocompare' ) && get_option( 'yith_woocompare_compare_button_in_products_list' ) == 'yes' ) {
	global $yith_woocompare;
	$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
	if ( $yith_woocompare->is_frontend() || $is_ajax ) {
		if ( $is_ajax ) {
			if ( !class_exists( 'YITH_Woocompare_Frontend' ) && file_exists( YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php' ) ) {
				require_once YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php';
			}
			$yith_woocompare->obj = new YITH_Woocompare_Frontend();
		}
		/* Remove button */
		remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
		/* Add compare button */
		if ( !function_exists( 'bianco_compare_btn' ) ) {
			function bianco_compare_btn()
			{
				if ( shortcode_exists( 'yith_compare_button' ) ) {
					echo do_shortcode( '[yith_compare_button product_id="' . get_the_ID() . '"]' );
				} else {
					if ( class_exists( 'YITH_Woocompare_Frontend' ) ) {
						echo do_shortcode( '[yith_compare_button product_id="' . get_the_ID() . '"]' );
					}
				}
			}
		}
		add_action( 'bianco_compare_button', 'bianco_compare_btn', 1 );
	}
}
/* QUICK VIEW */
if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
	// Class frontend
	$enable           = get_option( 'yith-wcqv-enable' ) == 'yes' ? true : false;
	$enable_on_mobile = get_option( 'yith-wcqv-enable-mobile' ) == 'yes' ? true : false;
	// Class frontend
	if ( ( !wp_is_mobile() && $enable ) || ( wp_is_mobile() && $enable_on_mobile && $enable ) ) {
		remove_action( 'woocommerce_after_shop_loop_item', array( YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button' ), 15 );
		add_action( 'bianco_quickview_button', array( YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button' ), 5 );
	}
    /**
     * Custom quickview template
     */
    remove_action( 'yith_wcqv_product_image', 'woocommerce_show_product_sale_flash', 10 );
    remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_meta', 30 );

    add_action( 'yith_wcqv_product_summary', 'bianco_custom_template_loop_rating', 10 );
    add_action( 'yith_wcqv_product_summary', 'bianco_socail_share_in_quickview', 30 );

//    add_action( 'yith_wcqv_product_summary', 'bianco_get_stock', 16 );
//    add_action( 'yith_wcqv_product_summary', 'bianco_loop_item_categories', 4 );

    add_action( 'wp_enqueue_scripts', function(){
        wp_enqueue_script('photoswipe');
        wp_enqueue_script('flexslider');
        wp_enqueue_script('zoom');
        wp_enqueue_script('wc-single-product');
    });

    add_action( 'yith_wcqv_product_image', function(){
        add_action('woocommerce_product_thumbnails','woocommerce_show_product_thumbnails',30);
    }, 15 );

    add_action( 'yith_wcqv_product_image', function(){
        remove_action('woocommerce_product_thumbnails','woocommerce_show_product_thumbnails',30);
    }, 25 );
}

if ( class_exists( 'YITH_WC_Social_Login_Frontend' ) ) {
    $instance = YITH_WC_Social_Login_Frontend();
    remove_action('woocommerce_after_template_part', array( $instance, 'social_buttons_in_checkout'));
}

if ( !function_exists( 'bianco_product_review_comment_form_args' ) ) {
	function bianco_product_review_comment_form_args( $comment_form )
	{
		$commenter     = wp_get_current_commenter();
		$title_reply   = esc_html__( 'Leave a review', 'bianco' );
		$fields        = array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'bianco' ) . '&nbsp;<span class="required">*</span></label> ' .
				'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required placeholder="' . esc_attr__( 'Your name', 'bianco' ) . '" /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'bianco' ) . '&nbsp;<span class="required">*</span></label> ' .
				'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required placeholder="' . esc_attr__( 'Email address', 'bianco' ) . '" /></p>',
		);
		$comment_field = '';
		if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
			$comment_field = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'bianco' ) . '</label><select name="rating" id="rating" aria-required="true" required>
							<option value="">Rate&hellip;</option>
							<option value="5">Perfect</option>
							<option value="4">Good</option>
							<option value="3">Average</option>
							<option value="2">Not that bad</option>
							<option value="1">Very poor</option>
						</select></div>';
		}
		$comment_field                 .= '<p class="comment-form-comment"><textarea id="comment" placeholder="' . esc_attr__( 'Your review', 'bianco' ) . '" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';
		$comment_form['title_reply']   = have_comments() ? $title_reply : $comment_form['title_reply'];
		$comment_form['fields']        = $fields;
		$comment_form['comment_field'] = $comment_field;

		return $comment_form;
	}
}

if ( !function_exists( 'kt_wcss_popup_email_service_via_ajax' ) ) {
	function kt_wcss_popup_email_service_via_ajax()
	{
		check_ajax_referer( 'ovic_ajax_frontend', 'security' );
		$id       = $_POST['post_id'];
		$_product = wc_get_product( $id );
		$title    = $_product->get_title();
		$desc         = strip_tags($_product->get_short_description());
		$url          = '&nbsp;&rArr;Link:'.$_product->get_permalink();
		$gmail_link   = 'https://mail.google.com/mail/u/0/?view=cm&su=' . $title . '&body=' . $desc . '%0D%0A%0D%0A' . $url . '&fs=1&tf=1';
		$yahoo_link   = '//compose.mail.yahoo.com/?Subject=' . $title . '&body=' . $desc . '%0D%0A%0D%0A' . $url . '';
		$outlook_link = 'https://outlook.live.com/owa/?subject=' . $title . '&to=&body=' . $desc . '%0D%0A%0D%0A' . $url . '&path=/mail/action/compose';
		$mailto_link  = 'mailto:?subject=' . $title . '&body=' . $desc . '%0D%0A%0D%0A' . $url . '';
		ob_start();
		?>
        <div class="kt-wccc-email-service">
            <div class="inner">
                <div class='kt-wccc-content-wapper'>
                    <div class="list-services">
                        <a href="<?php echo esc_url( $gmail_link ); ?>" class="email-service gmail" >
                        	<?php esc_html_e( 'Gmail', 'bianco' ); ?>
                        </a>
                        <a href="<?php echo esc_url( $yahoo_link ); ?>" class="email-service yahoo" >
                        	<?php esc_html_e( 'Yahoo', 'bianco' ); ?>
						</a>
                        <a href="<?php echo esc_url( $outlook_link ); ?>" class="email-service outlook" >
                        	<?php esc_html_e( 'Outlook', 'bianco' ); ?>
                		</a>
                        <a href="<?php echo esc_url( $mailto_link ); ?>" class="email-service mailto">
                        	<?php esc_html_e( 'Mailto', 'bianco' ); ?>
                		</a>
                    </div>
                    <div class="content-message">
                        <h3 class="title"><?php echo esc_html( $title ); ?></h3>
                        <div class="desc"><?php echo esc_html( $desc ); ?></div>
                        <a href="<?php echo esc_url( $url ) ?>"><?php echo esc_html( $url ) ?></a>
                    </div>
                </div>
            </div>
        </div>
		<?php
		$content = ob_get_clean();
		echo wp_specialchars_decode( $content );
		die();
	}
}

if ( !function_exists( 'bianco_custom_template_single_meta' ) ) {
	function bianco_custom_template_single_meta()
	{
        $enable_social_follow = Bianco_Functions::get_option('ovic_single_product_used_social_follow',0);
		global $product;
		$share_link_url  = $product->get_permalink();
		$share_summary   = $product->get_short_description();
		$twitter         = 'https://twitter.com/share?url=' . $share_link_url . '&text=' . $share_summary;
		$facebook        = 'https://www.facebook.com/sharer.php?u=' . $share_link_url;
		$sku             = esc_html__( 'N/A', 'bianco' );
		if ( $product->get_sku() ) {
			$sku = $product->get_sku();
		}
		?>
        <div class="product_meta">
			<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-cats"><span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'bianco' ) . ' ', '</span></div>' ); ?>
			<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
            <div class="product-sku">
                <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'bianco' ); ?></span>
                <span class="sku"><?php echo esc_html( $sku ); ?></span>
            </div>
			<?php endif; ?>
			<?php if($enable_social_follow): ?>
            <div class="wrap-social-shares">
                <ul class="list-socials">
                    <li>
                        <a class="facebook" href="<?php echo esc_url( $facebook ); ?>" title="<?php echo esc_attr__( 'Facebook', 'bianco' ) ?>" onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a class="twitter" href="<?php echo esc_url( $twitter ); ?>" title="<?php echo esc_attr__( 'Twitter', 'bianco' ) ?>" onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                            <i class="fa fa-twitter-square" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a class="print" href="javascript:void(0)" title="<?php echo esc_attr__( 'Print Page', 'bianco' ) ?>" onclick='window.print();'>
                            <i class="fa fa-print" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a data-post_id="<?php echo esc_attr( $product->get_id() ); ?>" target="_blank" class="email-to-friend link-popup" data-target="#emailBox" data-toggle="modal" href="#" title="<?php esc_html_e( 'Email to friend', 'bianco' ) ?>">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_custom_stock_template' ) ) {
	function bianco_custom_stock_template( $html, $product )
	{
		$result       = $html;
		$availability = $product->get_availability();
		if ( !empty( $availability['availability'] ) ) {
			$text   = esc_html__( 'Availability:', 'bianco' );
			$status = $availability['availability'];
			if ( $availability['class'] == 'in-stock' ) {
				$status = esc_html__( 'In Stock', 'bianco' );
			}
			$text .= '<span>' . $status . '</span>';
			ob_start();
			wc_get_template( 'single-product/stock.php', array(
					'product'      => $product,
					'class'        => $availability['class'],
					'availability' => $text,
				)
			);
			$result = ob_get_clean();
		}

		return $result;
	}
}

if ( !function_exists( 'bianco_get_product_availability' ) ) {
	function bianco_get_product_availability()
	{
		global $product;
		$html = '<div id="bianco-availability" class="bianco-availability">' . wc_get_stock_html( $product ) . '</div>';
		echo wp_specialchars_decode( $html );
	}
}

if ( !function_exists( 'bianco_single_gallery_add_start_wrap_tag' ) ) {
	function bianco_single_gallery_add_start_wrap_tag()
	{
		$html = '<div class="wrap-woocommerce-product-gallery bianco-wrap-product-gallery">';
		echo wp_specialchars_decode( $html );
	}
}

if ( !function_exists( 'bianco_single_gallery_add_end_wrap_tag' ) ) {
	function bianco_single_gallery_add_end_wrap_tag()
	{
		$html = '</div>';
		echo wp_specialchars_decode( $html );
	}
}

if ( !function_exists( 'bianco_brand_taxonomy_info' ) ) {
	function bianco_brand_taxonomy_info()
	{
		global $product;
		$html  = '';
		$terms = get_the_terms( $product->get_id(), 'product_brand' );
		if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
			$html .= '<div class="wrap-binaco-brand-taxonomy"><span>' . esc_html__( 'Brand:', 'bianco' ) . '</span>';
			foreach ( $terms as $term ) {
				$html .= '<a class="brand-term" href="' . get_term_link( $term->term_id, $term->taxonomy ) . '" title="' . esc_attr( $term->name ) . '">' . esc_html( $term->name ) . '</a>';
			}
			$html .= '</div>';
		}
		echo wp_specialchars_decode( $html );
	}
}

if ( !function_exists( 'bianco_get_shortdesc_product' ) ) {
	function bianco_get_shortdesc_product()
	{
		global $product;
		$pr_desc = $product->get_short_description();
		if ( $pr_desc ) {
			echo wp_specialchars_decode( $pr_desc );
		}
	}
}

if ( !function_exists( 'ovic_action_attributes' ) ) {
	function ovic_action_attributes()
	{
		global $product;
		if ( $product->get_type() == 'variable' ) : ?>
			<?php
			if ( !wp_script_is( 'wc-add-to-cart-variation', 'enqueued' ) ) {
				wp_enqueue_script( 'wc-add-to-cart-variation' );
			}
			$attributes           = $product->get_variation_attributes();
			$get_variations       = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
			$available_variations = $get_variations ? $product->get_available_variations() : false;
			$attribute_keys       = array_keys( $attributes );
			if ( !empty( $attributes ) ):?>
                <form class="variations_form cart" method="post" enctype='multipart/form-data'
                      data-product_id="<?php echo absint( $product->get_id() ); ?>"
                      data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ); ?>">
                    <table class="variations">
                        <tbody>
						<?php foreach ( $attributes as $attribute_name => $options ) : ?>
                            <tr>
                                <td class="label">
                                    <label><?php echo wc_attribute_label( $attribute_name ); ?></label>
                                </td>
                                <td class="value">
									<?php
									wc_dropdown_variation_attribute_options(
										array(
											'options'   => $options,
											'attribute' => $attribute_name,
											'product'   => $product,
										)
									);
									echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'bianco' ) . '</a>' ) ) : '';
									?>
                                </td>
                            </tr>
						<?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
			<?php
			endif;
		endif;
	}
}

if ( !function_exists( 'bianco_template_loop_product_thumbnail' ) ) {
	function bianco_template_loop_product_thumbnail()
	{
		global $product;
		// GET SIZE IMAGE SETTING
		$width  = 300;
		$height = 300;
		$crop   = true;
		$size   = wc_get_image_size( 'shop_catalog' );
		if ( $size ) {
			$width  = $size['width'];
			$height = $size['height'];
			if ( !$size['crop'] ) {
				$crop = false;
			}
		}
		$lazy_load          = true;
		$thumbnail_id       = $product->get_image_id();
		$default_attributes = $product->get_default_attributes();
		$width              = apply_filters( 'ovic_shop_product_thumb_width', $width );
		$height             = apply_filters( 'ovic_shop_product_thumb_height', $height );
		if ( !empty( $default_attributes ) )
			$lazy_load = false;
		$image_thumb = apply_filters( 'ovic_resize_image', $thumbnail_id, $width, $height, $crop, $lazy_load );
		?>
        <a class="thumb-link woocommerce-product-gallery__image" href="<?php the_permalink(); ?>">
            <figure>
				<?php echo wp_specialchars_decode( $image_thumb['img'] ); ?>
            </figure>
        </a>
		<?php
	}
}

if ( !function_exists( 'bianco_get_max_date_sale' ) ) {
	function bianco_get_max_date_sale( $product_id )
	{
		$date_now = current_time( 'timestamp', 0 );
		// Get variations
		$args          = array( 'post_type' => 'product_variation', 'post_status' => array( 'private', 'publish' ), 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'asc', 'post_parent' => $product_id, );
		$variations    = get_posts( $args );
		$variation_ids = array();
		if ( $variations ) {
			foreach ( $variations as $variation ) {
				$variation_ids[] = $variation->ID;
			}
		}
		$sale_price_dates_to = false;
		if ( !empty( $variation_ids ) ) {
			global $wpdb;
			$sale_price_dates_to = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_sale_price_dates_to' and post_id IN(" . join( ',', $variation_ids ) . ") ORDER BY meta_value DESC LIMIT 1" );
			if ( $sale_price_dates_to != '' ) {
				return $sale_price_dates_to;
			}
		}
		if ( !$sale_price_dates_to ) {
			$sale_price_dates_to   = get_post_meta( $product_id, '_sale_price_dates_to', true );
			$sale_price_dates_from = get_post_meta( $product_id, '_sale_price_dates_from', true );
			if ( $sale_price_dates_to == '' || $date_now < $sale_price_dates_from ) {
				$sale_price_dates_to = '0';
			}
		}

		return $sale_price_dates_to;
	}
}

if ( !function_exists( 'bianco_function_shop_loop_item_countdown' ) ) {
	function bianco_function_shop_loop_item_countdown()
	{
		global $product;
		$date = bianco_get_max_date_sale( $product->get_id() );
		ob_start();
		if ( $date > 0 ) {
			?>
            <div class="ovic-countdown"
                 data-datetime="<?php echo date( 'm/j/Y g:i:s', $date ); ?>">
            </div>
			<?php
		}
		$html = ob_get_clean();
		echo apply_filters( 'ovic_custom_html_countdown', $html, $date );
	}
}

if ( !function_exists( 'bianco_custom_new_flash' ) ) {
	function bianco_custom_new_flash()
	{
		global $post, $product;
		$postdate      = get_the_time( 'Y-m-d' );
		$postdatestamp = strtotime( $postdate );
		$newness       = Bianco_Functions::get_option( 'ovic_product_newness', 7 );
		if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) :
			echo apply_filters( 'bianco_new_flash', '<span class="onnew">' . esc_html__( 'New', 'bianco' ) . '</span>', $post, $product );
		endif;
	}
}

if ( !function_exists( 'bianco_custom_sale_flash' ) ) {
	function bianco_custom_sale_flash()
	{
		global $product;
		if ( $product->is_on_sale() ) :
			$maximumper = 0;
			$percentage = 0;
			$result     = '';
			if ( $product->is_type( 'variable' ) ) {
				$available_variations = $product->get_available_variations();
				for ( $i = 0; $i < count( $available_variations ); ++$i ) {
					$variation_id      = $available_variations[$i]['variation_id'];
					$variable_product1 = new WC_Product_Variation( $variation_id );
					$regular_price     = $variable_product1->get_regular_price();
					$sales_price       = $variable_product1->get_sale_price();
					if ( $regular_price > 0 && $sales_price > 0 ) {
						$percentage = round( ( ( $regular_price - $sales_price ) ), 0 );
					}
					$maximumper = ( $percentage > $maximumper ) ? $percentage : $maximumper;
				}
				$result = '<span class="onsale">- ' . wc_price( $maximumper, array( 'decimals' => 0 ) ) . '</span>';
			} else {
				if ( $product->get_regular_price() > 0 && $product->get_sale_price() > 0 ) {
					$maximumper = round( ( $product->get_regular_price() - $product->get_sale_price() ), 0 );
					$result     = '<span class="onsale">-' . wc_price( $maximumper, array( 'decimals' => 0 ) ) . '</span>';
				}
			}
			echo apply_filters( 'bianco_custom_sale_flash', $result );
		endif;
	}
}

if ( !function_exists( 'bianco_woocommerce_group_flash' ) ) {
	function bianco_woocommerce_group_flash()
	{
		?>
        <div class="flash">
			<?php bianco_custom_new_flash(); ?>
			<?php bianco_custom_sale_flash(); ?>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_after_shop_control' ) ) {
	function bianco_after_shop_control()
	{
		?>
        <div class="shop-control shop-after-control">
            <?php bianco_paging_nav(); ?>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_before_shop_control' ) ) {
	function bianco_before_shop_control()
	{
		?>
        <div class="shop-control shop-before-control">
			<?php
			bianco_custom_result_count();
			bianco_product_per_page_tmp();
			bianco_catalog_ordering();
			bianco_shop_display_mode_tmp();
			?>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_before_woocommerce_content' ) ) {
	function bianco_before_woocommerce_content()
	{
		$class         = array( 'row auto-clear ovic-products' );
		$product_style = bianco_get_store_display_mode();
		if ( $product_style != 'list' ) {
			$class[] = 'equal-container better-height';
		}
		$class = apply_filters( 'bianco_before_woocommerce_content', $class );
		echo '<div class="' . implode( ' ', $class ) . '">';
	}
}

if ( !function_exists( 'bianco_after_woocommerce_content' ) ) {
	function bianco_after_woocommerce_content()
	{
		echo '</div>';
	}
}

if ( !function_exists( 'bianco_woof_products_query' ) ) {
	function bianco_woof_products_query( $wr )
	{
		$ovic_woo_products_perpage = Bianco_Functions::get_option( 'ovic_product_per_page', '12' );
		$wr['posts_per_page']      = $ovic_woo_products_perpage;

		return $wr;
	}
}

if ( !function_exists( 'bianco_loop_shop_per_page' ) ) {
	function bianco_loop_shop_per_page()
	{
		$ovic_woo_products_perpage = Bianco_Functions::get_option( 'ovic_product_per_page', '12' );

		return $ovic_woo_products_perpage;
	}
}

if ( !function_exists( 'bianco_cross_sell_products' ) ) {
	function bianco_cross_sell_products( $limit = 2, $columns = 2, $orderby = 'rand', $order = 'desc' )
	{
		if ( is_checkout() ) {
			return;
		}
		// Get visible cross sells then sort them at random.
		$cross_sells = array_filter( array_map( 'wc_get_product', WC()->cart->get_cross_sells() ), 'wc_products_array_filter_visible' );
		wc_set_loop_prop( 'name', 'cross-sells' );
		wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_cross_sells_columns', $columns ) );
		// Handle orderby and limit results.
		$orderby     = apply_filters( 'woocommerce_cross_sells_orderby', $orderby );
		$order       = apply_filters( 'woocommerce_cross_sells_order', $order );
		$cross_sells = wc_products_array_orderby( $cross_sells, $orderby, $order );
		$limit       = apply_filters( 'woocommerce_cross_sells_total', $limit );
		$cross_sells = $limit > 0 ? array_slice( $cross_sells, 0, $limit ) : $cross_sells;
		bianco_carousel_products( 'ovic_woo_crosssell', $cross_sells, '2' );
	}
}

if ( !function_exists( 'bianco_woo_related' ) ) {
	function bianco_woo_related( $orderby = 'rand', $order = 'desc', $limit = '-1', $columns = 4 )
	{
		global $product;
		if ( !$product ) {
			return;
		}
		// Handle the legacy filter which controlled posts per page etc.
		$args = apply_filters( 'woocommerce_upsell_display_args', array(
				'posts_per_page' => $limit,
				'orderby'        => $orderby,
				'columns'        => $columns,
			)
		);
		wc_set_loop_prop( 'name', 'up-sells' );
		wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_upsells_columns', isset( $args['columns'] ) ? $args['columns'] : $columns ) );
		$orderby = apply_filters( 'woocommerce_upsells_orderby', isset( $args['orderby'] ) ? $args['orderby'] : $orderby );
		$limit   = apply_filters( 'woocommerce_upsells_total', isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : $limit );
		// Get visible upsells then sort them at random, then limit result set.
		$upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $product->get_upsell_ids() ), 'wc_products_array_filter_visible' ), $orderby, $order );
		$upsells = $limit > 0 ? array_slice( $upsells, 0, $limit ) : $upsells;
		bianco_carousel_products( 'ovic_woo_upsell', $upsells, '2' );
	}
}

if ( !function_exists( 'bianco_change_max_output_related_product_number' ) ) {
	function bianco_change_max_output_related_product_number( $args )
	{
		$ovic_woo_related_max_product_number = Bianco_Functions::get_option( 'ovic_woo_related_max_product_number', 8 );
		if ( $ovic_woo_related_max_product_number ) {
			$args['posts_per_page'] = $ovic_woo_related_max_product_number;
		}

		return $args;
	}
}

if ( !function_exists( 'bianco_related_products' ) ) {
	function bianco_related_products()
	{
		global $product;
		if ( !$product ) return;
		$args = apply_filters( 'woocommerce_output_related_products_args', array(
				'posts_per_page' => 4,
				'columns'        => 4,
				'orderby'        => 'rand', // @codingStandardsIgnoreLine.
				'order'          => 'desc',
			)
		);
		// Set global loop values.
		wc_set_loop_prop( 'name', 'related' );
		wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );
		// Get visible related products then sort them at random.
		$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
		// Handle orderby.
		$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
		bianco_carousel_products( 'ovic_woo_related', $args['related_products'], '2' );
	}
}

if ( !function_exists( 'bianco_woocommerce_options_sidebar' ) ) {
	function bianco_woocommerce_options_sidebar()
	{
		$shop_layout  = Bianco_Functions::get_option( 'ovic_sidebar_shop_layout', 'left' );
		$shop_sidebar = Bianco_Functions::get_option( 'ovic_shop_used_sidebar', 'shop-widget-area' );
		if ( is_product() ) {
			$shop_layout  = Bianco_Functions::get_option( 'ovic_sidebar_single_product_layout', 'full' );
			$shop_sidebar = Bianco_Functions::get_option( 'ovic_single_product_used_sidebar', 'product-widget-area' );
		}
		if ( !is_active_sidebar( $shop_sidebar ) || !is_woocommerce() ) {
			$shop_layout = 'full';
		}
		return array(
			'layout'  => $shop_layout,
			'sidebar' => $shop_sidebar,
		);
	}
}

if ( !function_exists( 'bianco_woocommerce_before_main_content' ) ) {
	function bianco_woocommerce_before_main_content()
	{
		/*Main container class*/
		$option_layout        = bianco_woocommerce_options_sidebar();
		$html                 = '';
		$main_container_class = array();
		if ( is_product() ) {
			$thumbnail_layout       = Bianco_Functions::get_option( 'ovic_single_product_thumbnail', 'vertical' );
			$main_container_class[] = 'single-thumb-' . $thumbnail_layout;
		}
		$shop_layout = $option_layout['layout'];
		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			$option_layout['layout'] = 'full';
		}
		$main_container_class[] = 'main-container shop-page';
		if ( $shop_layout == 'full' ) {
			$main_container_class[] = 'no-sidebar';
		} else {
			$main_container_class[] = $shop_layout . '-sidebar';
		}
		ob_start();
		do_action( 'ovic_hero_before_main_content' );
		$hero_before_main_content = ob_get_clean();
		$main_container_class     = apply_filters( 'ovic_class_before_main_content_product', $main_container_class, $shop_layout );
		/* CONTENT */
		$html .= '<div class="' . esc_attr( implode( ' ', $main_container_class ) ) . '">';
		$html .= $hero_before_main_content;
		$html .= '<div class="container">';
		$html .= '<div class="row">';
		echo apply_filters( 'bianco_woocommerce_before_main_content', $html );
	}
}

if ( !function_exists( 'bianco_woocommerce_after_main_content' ) ) {
	function bianco_woocommerce_after_main_content()
	{
		$html = '</div></div></div>';
		echo apply_filters( 'bianco_woocommerce_after_main_content', $html );
	}
}

if ( !function_exists( 'bianco_woocommerce_before_loop_content' ) ) {
	function bianco_woocommerce_before_loop_content()
	{
		/*Shop layout*/
		$option_layout = bianco_woocommerce_options_sidebar();
		$shop_layout   = $option_layout['layout'];
		if ( !is_woocommerce() ) {
			$shop_layout = 'full';
		}
		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			$option_layout['layout'] = 'full';
		}
		$main_content_class   = array();
		$main_content_class[] = 'main-content';
		if ( $shop_layout == 'full' ) {
			$main_content_class[] = 'col-sm-12';
		} else {
			$main_content_class[] = 'col-lg-9 col-md-8 has-sidebar';
			$main_content_class[] = $option_layout['sidebar'];
		}
		$main_content_class = apply_filters( 'ovic_class_archive_content', $main_content_class, $shop_layout );
		echo '<div class="' . esc_attr( implode( ' ', $main_content_class ) ) . '">';
	}
}

if ( !function_exists( 'bianco_woocommerce_after_loop_content' ) ) {
	function bianco_woocommerce_after_loop_content()
	{
		echo '</div>';
	}
}

if ( !function_exists( 'bianco_product_description_heading' ) ) {
	function bianco_product_description_heading()
	{
		return '';
	}
}

if ( !function_exists( 'bianco_product_additional_information_heading' ) ) {
	function bianco_product_additional_information_heading()
	{
		return '';
	}
}

if ( !function_exists( 'bianco_rewrite_hero_banner_content' ) ) {
	function bianco_rewrite_hero_banner_content( $hero_content )
	{
		$result                             = $hero_content;
		$ovic_show_categories_on_hero_baner = Bianco_Functions::get_option( 'ovic_show_categories_on_hero_baner', 0 );
		if ( !$ovic_show_categories_on_hero_baner ) return $result;
		$ovic_chose_category_for_hero_banner = Bianco_Functions::get_option( 'ovic_chose_category_for_hero_banner', 0 );
		if ( is_woocommerce() && !empty( $ovic_chose_category_for_hero_banner ) ) {
			$result = '<div class="wrap-product-categories">';
			$result .= '<ul class="categories">';
			foreach ( $ovic_chose_category_for_hero_banner as $cat_id ) {
				if ( term_exists( intval( $cat_id ), 'product_cat' ) ) {
					$term      = get_term_by( 'id', $cat_id, 'product_cat', 'ARRAY_A', 'raw' );
					$term_meta = get_term_meta( $term['term_id'] );
					$term_link = get_term_link( $term['term_id'], 'product_cat' );
					$result    .= '<li class="cat-item cate-name-' . $term['slug'] . ' cate-id-' . $term['term_id'] . '">';
					$result    .= '<div class="cat-info">';
					if ( !empty( $term_meta['thumbnail_id'][0] ) ) {
						$result .= '<a class="cate-thumb" href="' . $term_link . '"><figure>';
						$result .= wp_get_attachment_image( $term_meta['thumbnail_id'][0], 'full' );
						$result .= '</figure></a>';
					}
					$result .= '<div class="details">';
					$result .= '<h4 class="cate-name"><a class="cate-title" href="' . $term_link . '">' . $term['name'] . '</a></h4>';
					$result .= '<span class="cat-count">' . $term['count'] . '  ' . esc_html__( 'Product', 'bianco' ) . '</span>';
					$result .= '</div>';
					$result .= '</div>';
					$result .= '</li>';
				}
			}
			$result .= '</ul>';
			$result .= '</div>';
			$result .= $hero_content;
		}

		return $result;
	}
}

if ( !function_exists( 'bianco_woocommerce_sidebar' ) ) {
	function bianco_woocommerce_sidebar()
	{
		$sidebar_class   = array();
		$option_layout   = bianco_woocommerce_options_sidebar();
		$shop_layout     = $option_layout['layout'];
		$shop_sidebar    = $option_layout['sidebar'];
		$sidebar_class[] = 'sidebar';
		if ( $shop_layout != 'full' ) {
			$sidebar_class[] = 'col-lg-3 col-md-4';
		}
		$sidebar_class = apply_filters( 'ovic_class_sidebar_content_product', $sidebar_class, $shop_layout, $shop_sidebar );
		if ( $shop_layout != "full" ): ?>
            <div class="<?php echo esc_attr( implode( ' ', $sidebar_class ) ); ?>">
                <div class="sidebar-head">
                    <span class="text"><?php esc_html_e( 'Sidebar', 'bianco' ); ?></span>
                    <a href="#" class="close-block-sidebar"><span class="ti-close"></span></a>
                </div>
                <div id="widget-area" class="widget-area shop-sidebar">
					<?php dynamic_sidebar( $shop_sidebar ); ?>
                </div><!-- .widget-area -->
            </div>
		<?php endif;
	}
}

if ( !function_exists( 'bianco_woocommerce_breadcrumb' ) ) {
	function bianco_woocommerce_breadcrumb()
	{
		$args = array(
			'delimiter'   => '',
			'wrap_before' => '<div class="bianco-wrap-breadcrumb wrap-breadcrumb"><div class="container"><ul class="woocommerce-breadcrumb breadcrumb">',
			'wrap_after'  => '</ul></div></div>',
			'before'      => '<li>',
			'after'       => '</li>',
		);
		woocommerce_breadcrumb( $args );
	}
}

if ( !function_exists( 'bianco_yith_wc_social_login_icon' ) ) {
	function bianco_yith_wc_social_login_icon( $social, $key, $args )
	{
		$socials = array(
			'facebook' => array(
				'label' => esc_html__( 'Facebook', 'bianco' ),
				'icon'  => 'fa fa-facebook',
			),
			'google'   => array(
				'label' => esc_html__( 'Googole+', 'bianco' ),
				'icon'  => 'fa fa-google-plus',
			),
			'twitter'  => array(
				'label' => esc_html__( 'Twitter', 'bianco' ),
				'icon'  => 'fa fa-twitter',
			),
		);

		return sprintf( '<span class="login-social-item"><a class="%s" href="%s"><i class="' . $socials[$key]['icon'] . '"></i>' . $socials[$key]['label'] . '</a></span>', $args['class'], $args['url'] );
	}
}

if ( !function_exists( 'bianco_woocommerce_format_sale_price' ) ) {
	function bianco_woocommerce_format_sale_price( $price, $regular_price, $sale_price )
	{
		return '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins>' . '<del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
	}
}

if ( !function_exists( 'bianco_loop_item_images' ) ) {
	function bianco_loop_item_images()
	{
		global $product;
		$image_ids = $product->get_gallery_image_ids();
		$i         = 0;
		$selected  = '';
		if ( !empty( $image_ids ) ) { ?>
            <div class="product-images">
                <div class="primary-image-container">
					<?php foreach ( $image_ids as $image_id ): ?>
						<?php
						$image_catalog = wp_get_attachment_image_src( $image_id, 'shop_catalog' );
						$image_alt     = trim( strip_tags( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) );
						?>
                        <img class="primary-image" src="<?php echo esc_url( $image_catalog[0] ); ?>"
                             width="<?php echo esc_attr( $image_catalog[1] ); ?>"
                             height="<?php echo esc_attr( $image_catalog[2] ) ?>"
                             alt="<?php echo esc_attr( $image_alt ); ?>"/>
						<?php break; ?>
					<?php endforeach; ?>
                </div>
                <div class="product-image-thumbs">
					<?php foreach ( $image_ids as $image_id ): ?>
						<?php
						if ( $i == 0 ) {
							$selected    = 'selected';
							$image_thumb = apply_filters( 'ovic_resize_image', $image_id, 47, false, true, false );
						} else {
							$selected      = '';
							$image_thumb   = apply_filters( 'ovic_resize_image', $image_id, 47, false, true, false );
							$image_catalog = wp_get_attachment_image_src( $image_id, 'shop_catalog' );
							$image_alt     = trim( strip_tags( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ) );
						}
						$i++;
						?>
                        <a href="javascript:void(0)"
                           class="js-image-thumb image-thumb <?php echo esc_attr( $selected ); ?>"
                           data-src="<?php echo esc_url( $image_catalog[0] ) ?>"
                           data-alt="<?php echo esc_attr( $image_alt ); ?>">
							<?php echo wp_specialchars_decode( $image_thumb['img'] ); ?>
                        </a>
					<?php endforeach; ?>
                </div>
            </div>
			<?php
		}
	}
}

if ( !function_exists( 'bianco_ajax_product_variation_add_to_cart' ) ) {
	function bianco_ajax_product_variation_add_to_cart()
	{
		$products = isset( $_POST['data'] ) ? $_POST['data'] : array();
		if ( !empty( $products ) ) {
			if ( isset( $products['variation_id'] ) && isset( $products['product_id'] ) ) {
				WC()->cart->add_to_cart( $products['product_id'], $products['quantity'], $products['variation_id'] );
			} elseif ( isset( $products['quantity'] ) && is_array( $products['quantity'] ) && !empty( $products['quantity'] ) ) {
				foreach ( $products['quantity'] as $product_id => $quantity ) {
					if ( $quantity > 0 )
						WC()->cart->add_to_cart( $product_id, $quantity );
				}
			} else {
				if ( isset( $products['product_id'] ) && isset( $products['quantity'] ) && is_numeric( $products['quantity'] ) )
					WC()->cart->add_to_cart( $products['product_id'], $products['quantity'] );
			}
			WC_AJAX::get_refreshed_fragments();
		}
		wp_die();
	}
}

if ( !function_exists( 'bianco_loop_item_categories' ) ) {
	function bianco_loop_item_categories()
	{
		global $product;
		$product_cat = $product->get_category_ids();
		if ( !empty( $product_cat ) ) { ?>
            <div class="item-categories">
				<?php
				foreach ( $product_cat as $cat_id ) {
					if ( $term = get_term_by( 'id', $cat_id, 'product_cat' ) ) {
						?>
                        <a class="product-cat" title="<?php echo esc_attr( $term->name ); ?>"
                           href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
						<?php
					}
				} ?>
            </div>
			<?php
		}
	}
}

if ( !function_exists( 'bianco_shop_loop_item_price' ) ) {
	function bianco_shop_loop_item_price( $text )
	{
		global $product;
		if ( $product->is_type( 'variable' ) ) {
			$min_variation_price = $product->get_variation_regular_price( 'min' );
			if ( $min_variation_price ) {
				?>
                <div class="group-price">
                    <span class="text-label"><?php echo esc_html( $text ) ?></span>
                    <span class="text-value"><?php echo wc_price( $min_variation_price ); ?></span>
                </div>
				<?php
			}
		} elseif ( $product->is_type( 'grouped' ) ) {
			$tax_display_mode = get_option( 'woocommerce_tax_display_shop' );
			$child_prices     = array();
			$children         = array_filter( array_map( 'wc_get_product', $product->get_children() ), 'wc_products_array_filter_visible_grouped' );
			foreach ( $children as $child ) {
				if ( '' !== $child->get_price() ) {
					$child_prices[] = 'incl' === $tax_display_mode ? wc_get_price_including_tax( $child ) : wc_get_price_excluding_tax( $child );
				}
			}
			if ( !empty( $child_prices ) ) {
				$min_price = min( $child_prices );
			} else {
				$min_price = '';
			}
			if ( $min_price ) {
				?>
                <div class="group-price">
                    <span class="text-label"><?php echo esc_html( $text ) ?></span>
                    <span class="text-value"><?php echo wc_price( $min_price ); ?></span>
                </div>
				<?php
			}
		} else {
			woocommerce_template_loop_price();
		}
	}
}

if ( !function_exists( 'bianco_shop_loop_item_variation_form' ) ) {
	function bianco_shop_loop_item_variation_form()
	{
		global $product;
		$html = '';
		wp_enqueue_script( 'wc-add-to-cart-variation' );
		ob_start();
		if ( $product->get_type() == 'variable' ) {
			$get_variations       = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
			$available_variations = $get_variations ? $product->get_available_variations() : false;
			$attributes           = $product->get_variation_attributes();
			$selected_attributes  = $product->get_default_attributes();
			$attribute_keys       = array_keys( $attributes );
			?>
            <form class="variations_form cart" action="<?php echo esc_url( get_permalink() ); ?>" method="post"
                  enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>"
                  data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
                <div class="product-loop-variations variations">
					<?php foreach ( $attributes as $attribute_name => $options ) { ?>
                        <div class="value">
							<?php
							$selected = isset( $_REQUEST['attribute_' . sanitize_title( $attribute_name )] ) ? wc_clean( stripslashes( urldecode( $_REQUEST['attribute_' . sanitize_title( $attribute_name )] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
							wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
							?>
                        </div>
					<?php } ?>
                </div>
				<?php do_action( 'woocommerce_single_variation' ); ?>
            </form>
			<?php
			$html = ob_get_clean();
		}
		echo apply_filters( 'bianco_shop_loop_item_variation_form', $html );
	}
}

if ( !function_exists( 'bianco_shop_loop_item_variation_price2' ) ) {
	function bianco_shop_loop_item_variation_price2()
	{
		global $product;
		if ( $product->is_type( 'variable' ) ) {
			$attributes_name    = '';
			$default_attributes = $product->get_default_attributes();
			$data_attributes    = array(
				'product_id' => $product->get_id(),
			);
			if ( $default_attributes ) {
				foreach ( $default_attributes as $key => $value ) {
					$term            = get_term_by( 'slug', $value, $key );
					$attributes_name .= '/' . $term->name;
					if ( strpos( $key, 'attribute_' ) === 0 ) {
						continue;
					}
					unset( $default_attributes[$key] );
					$default_attributes[sprintf( 'attribute_%s', $key )] = $value;
					$data_attributes[sprintf( 'attribute_%s', $key )]    = $value;
				}
				$data_store           = WC_Data_Store::load( 'product' );
				$product_variation_id = $data_store->find_matching_product_variation( $product, $default_attributes );
				$product_variation    = $product->get_available_variation( $product_variation_id );
			} else {
				$product_variations = $product->get_available_variations();
				if ( $product_variations ) {
					$product_variation = $product_variations[0];
					if ( $product_variation['attributes'] ) {
						foreach ( $product_variation['attributes'] as $key => $value ) {
							$term                  = get_term_by( 'slug', $value, str_replace( 'attribute_', '', $key ) );
							$attributes_name       .= '/' . $term->name;
							$data_attributes[$key] = $value;
						}
					}
				}
			}
			if ( $product_variation ) {
				$data_attributes['quantity']     = $product_variation['min_qty'];
				$data_attributes['variation_id'] = $product_variation['variation_id'];
				?>
                <div class="variation_price"><?php echo wp_specialchars_decode( $product_variation['price_html'] . '<span class="attributes">' . $attributes_name . '</span>' ); ?></div>
                <div class="group-button">
                    <div class="inner">
                        <div class="add-to-cart">
                            <a href="javascript:void(0)"
                               class="button product_type_simple add_to_cart_button variation_ajax_add_to_cart"
                               data-attributes='<?php echo json_encode( $data_attributes ) ?>' rel="nofollow"
                               tabindex="0"><?php echo esc_html__( 'Add to cart', 'bianco' ) ?>
                            </a>
                        </div>
                        <div class="wishlist-container">
							<?php do_action( 'bianco_wishlist_button' ); ?>
							<?php do_action( 'bianco_compare_button' ); ?>
                        </div>
                    </div>
                </div>
			<?php } else { ?>
				<?php woocommerce_template_loop_price(); ?>
                <div class="group-button">
                    <div class="inner">
                        <div class="add-to-cart">
							<?php woocommerce_template_loop_add_to_cart(); ?>
                        </div>
                        <div class="wishlist-container">
							<?php do_action( 'bianco_wishlist_button' ); ?>
							<?php do_action( 'bianco_compare_button' ); ?>
                        </div>
                    </div>
                </div>
			<?php } ?>
		<?php } else { ?>
			<?php woocommerce_template_loop_price(); ?>
            <div class="group-button">
                <div class="inner">
                    <div class="add-to-cart">
						<?php woocommerce_template_loop_add_to_cart(); ?>
                    </div>
                    <div class="wishlist-container">
						<?php do_action( 'bianco_wishlist_button' ); ?>
						<?php do_action( 'bianco_compare_button' ); ?>
                    </div>
                </div>
            </div>
			<?php
		}
	}
}

if ( !function_exists( 'bianco_shop_loop_item_variation_price' ) ) {
	function bianco_shop_loop_item_variation_price()
	{
		global $product;
		if ( $product->is_type( 'variable' ) ) {
			$attributes_name    = '';
			$default_attributes = $product->get_default_attributes();
			$data_attributes    = array(
				'product_id' => $product->get_id(),
			);
			if ( $default_attributes ) {
				foreach ( $default_attributes as $key => $value ) {
					$term            = get_term_by( 'slug', $value, $key );
					$attributes_name .= '/' . $term->name;
					if ( strpos( $key, 'attribute_' ) === 0 ) {
						continue;
					}
					unset( $default_attributes[$key] );
					$default_attributes[sprintf( 'attribute_%s', $key )] = $value;
					$data_attributes[sprintf( 'attribute_%s', $key )]    = $value;
				}
				$data_store           = WC_Data_Store::load( 'product' );
				$product_variation_id = $data_store->find_matching_product_variation( $product, $default_attributes );
				$product_variation    = $product->get_available_variation( $product_variation_id );
			} else {
				$product_variations = $product->get_available_variations();
				if ( $product_variations ) {
					$product_variation = $product_variations[0];
					if ( $product_variation['attributes'] ) {
						foreach ( $product_variation['attributes'] as $key => $value ) {
							$term                  = get_term_by( 'slug', $value, str_replace( 'attribute_', '', $key ) );
							$attributes_name       .= '/' . $term->name;
							$data_attributes[$key] = $value;
						}
					}
				}
			}
			if ( $product_variation ) {
				$data_attributes['quantity']     = $product_variation['min_qty'];
				$data_attributes['variation_id'] = $product_variation['variation_id'];
				?>
                <div class="variation_price"><?php echo wp_specialchars_decode( $product_variation['price_html'] . '<span class="attributes">' . $attributes_name . '</span>' ); ?></div>
                <a href="javascript:void(0)"
                   class="button product_type_simple add_to_cart_button variation_ajax_add_to_cart"
                   data-attributes='<?php echo json_encode( $data_attributes ) ?>' rel="nofollow"
                   tabindex="0"><?php echo esc_html__( 'Add to cart', 'bianco' ) ?></a>
				<?php
			} else {
				woocommerce_template_loop_price();
				woocommerce_template_loop_add_to_cart();
			}
		} else {
			woocommerce_template_loop_price();
			woocommerce_template_loop_add_to_cart();
		}
	}
}

if ( !function_exists( 'bianco_shop_loop_item_variation' ) ) {
	function bianco_shop_loop_item_variation()
	{
		global $product;
		if ( $product->is_type( 'variable' ) ) {
			$product_variations = $product->get_available_variations();
			$html_images        = '';
			$html_attributes    = '';
			if ( $product_variations ) {
				$product_id           = $product->get_id();
				$default_attributes   = $product->get_default_attributes();
				$product_variation_id = 0;
				if ( $default_attributes ) {
					$data_store           = WC_Data_Store::load( 'product' );
					$product_variation_id = $data_store->find_matching_product_variation( $product, $default_attributes );
				}
				$default_data_attributes = array();
				foreach ( $product_variations as $index => $product_variation ) {
					if ( !$product_variation_id ) {
						if ( $index == 0 ) {
							$product_variation_id = $product_variation['variation_id'];
						}
					}
					$attributes_name = '';
					$data_attributes = array(
						'product_id'   => $product_id,
						'variation_id' => $product_variation['variation_id'],
						'quantity'     => $product_variation['min_qty'],
					);
					if ( $product_variation['attributes'] ) {
						foreach ( $product_variation['attributes'] as $key => $value ) {
							$term                  = get_term_by( 'slug', $value, str_replace( 'attribute_', '', $key ) );
							$attributes_name       .= '/' . $term->name;
							$data_attributes[$key] = $value;
						}
					}
					if ( $product_variation['image_id'] ) {
						$image      = apply_filters( 'ovic_resize_image', $product_variation['image_id'], 60, false, true, false );
						$image_full = apply_filters( 'ovic_resize_image', $product_variation['image_id'], false, false, false, true );
					} else {
						$image      = apply_filters( 'ovic_resize_image', $product['image_id'], 60, false, false, true );
						$image_full = apply_filters( 'ovic_resize_image', $product_variation['image_id'], false, false, false, true );
					}
					if ( $product_variation['variation_id'] == $product_variation_id ) {
						$default_data_attributes = $data_attributes;
						$html_attributes         .= '<div class="variation-price selected variation-' . $product_id . '-' . $product_variation['variation_id'] . '">' . $product_variation['price_html'] . '<span class="attributes">' . $attributes_name . '</span></div>';
						$html_images             .= '<a href="javascript:void(0)" class="js-select-variation selected" data-image="' . $image_full['url'] . '" data-product_id="' . $product_id . '" data-variation_id="' . $product_variation['variation_id'] . '"  data-attributes=\'' . json_encode( $data_attributes ) . '\' >' . $image['img'] . '</a>';
					} else {
						$html_attributes .= '<div class="variation-price variation-' . $product_id . '-' . $product_variation['variation_id'] . '">' . $product_variation['price_html'] . '<span class="attributes">' . $attributes_name . '</span></div>';
						$html_images     .= '<a href="javascript:void(0)" class="js-select-variation" data-image="' . $image_full['url'] . '" data-product_id="' . $product_id . '" data-variation_id="' . $product_variation['variation_id'] . '"  data-attributes=\'' . json_encode( $data_attributes ) . '\' >' . $image['img'] . '</a>';
					}
				}
				?>
                <div class="product-is-variation">
                    <div class="variation-prices">
						<?php echo wp_specialchars_decode( $html_attributes ); ?>
                    </div>
                    <div class="variation-images">
						<?php echo wp_specialchars_decode( $html_images ); ?>
                    </div>
                    <a href="javascript:void(0)"
                       class="button product_type_simple add_to_cart_button variation_ajax_add_to_cart"
                       data-attributes='<?php echo json_encode( $default_data_attributes ) ?>' rel="nofollow"
                       tabindex="0"><?php echo esc_html__( 'Add to cart', 'bianco' ) ?></a>
                </div>
				<?php
			} else {
				woocommerce_template_loop_price();
				woocommerce_template_loop_add_to_cart();
			}
		} else {
			woocommerce_template_loop_price();
			woocommerce_template_loop_add_to_cart();
		}
	}
}

if ( !function_exists( 'bianco_get_product_variation' ) ) {
	function bianco_get_product_variation()
	{
		global $product;
		if ( $product->is_type( 'variable' ) ) {
			$default_attributes = $product->get_default_attributes();
			foreach ( $default_attributes as $key => $value ) {
				if ( strpos( $key, 'attribute_' ) === 0 ) {
					continue;
				}
				unset( $default_attributes[$key] );
				$default_attributes[sprintf( 'attribute_%s', $key )] = $value;
			}
			$data_store           = WC_Data_Store::load( 'product' );
			$product_variation_id = $data_store->find_matching_product_variation( $product, $default_attributes );
			$product_variation    = $product->get_available_variation( $product_variation_id );

			return $product_variation;
		}

		return array();
	}
}

if ( !function_exists( 'bianco_function_shop_loop_countdown' ) ) {
	function bianco_function_shop_loop_countdown()
	{
		$date = bianco_get_max_date_sale();
		if ( $date ) {
			?>
            <div class="countdown-container">
                <div class="bianco-countdown" data-datetime="<?php echo date( 'm/j/Y g:i:s', $date ); ?>"
                     data-txt_day="<?php echo esc_attr__( 'Days', 'bianco' ) ?>"
                     data-txt_hour="<?php echo esc_attr__( 'Hrs', 'bianco' ) ?>"
                     data-txt_min="<?php echo esc_attr__( 'Mins', 'bianco' ) ?>"
                     data-txt_sec="<?php echo esc_attr__( 'Secs', 'bianco' ) ?>" data-value_first="1">
                </div>
            </div>
			<?php
		}
	}
}

if ( !function_exists( 'bianco_function_shop_loop_process_available' ) ) {
	function bianco_function_shop_loop_process_available()
	{
		global $product;
		$units_sold   = get_post_meta( $product->get_id(), 'total_sales', true );
		$availability = $product->get_stock_quantity();
		if ( $availability == '' ) {
			$percent = 0;
		} else {
			$total_percent = $availability + $units_sold;
			$percent       = round( ( ( $units_sold / $total_percent ) * 100 ), 0 );
		}
		?>
        <div class="process-valiable">
            <div class="valiable-text">
                <span class="text-availavle">
                    <?php echo wp_specialchars_decode( sprintf( esc_html( 'Availavle: <strong>%d</strong>', 'bianco' ), $units_sold ) ); ?>
                </span>
                <span class="text-quantity">
                    <?php if ( !$availability ): ?>
						<?php echo esc_html__( 'Unlimit', 'bianco' ) ?>
					<?php else: ?>
						<?php echo wp_specialchars_decode( sprintf( esc_html( 'Already sold: <strong>%d</strong>', 'bianco' ), $availability ) ); ?>
					<?php endif; ?>
                </span>
            </div>
            <span class="valiable-total total">
                <span class="process" style="width: <?php echo esc_attr( $percent ) . '%' ?>"></span>
            </span>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_get_product_image_ids' ) ) {
	function bianco_get_product_image_ids()
	{
		global $product;

		return $product->get_gallery_image_ids();
	}
}

if ( !function_exists( 'bianco_get_max_date_sale' ) ) {
	function bianco_get_max_date_sale( $product_id = 0 )
	{
		global $product;
		if ( !$product_id )
			$product_id = $product->get_id();
		$date_now = current_time( 'timestamp', 0 );
		// Get variations
		$args          = array( 'post_type' => 'product_variation', 'post_status' => array( 'private', 'publish' ), 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'asc', 'post_parent' => $product_id, );
		$variations    = get_posts( $args );
		$variation_ids = array();
		if ( $variations ) {
			foreach ( $variations as $variation ) {
				$variation_ids[] = $variation->ID;
			}
		}
		$sale_price_dates_to = false;
		if ( !empty( $variation_ids ) ) {
			global $wpdb;
			$sale_price_dates_to = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_sale_price_dates_to' and post_id IN(" . join( ',', $variation_ids ) . ") ORDER BY meta_value DESC LIMIT 1" );
			if ( $sale_price_dates_to != '' ) {
				return $sale_price_dates_to;
			}
		}
		if ( !$sale_price_dates_to ) {
			$sale_price_dates_to   = get_post_meta( $product_id, '_sale_price_dates_to', true );
			$sale_price_dates_from = get_post_meta( $product_id, '_sale_price_dates_from', true );
			if ( $sale_price_dates_to == '' || $date_now < $sale_price_dates_from ) {
				$sale_price_dates_to = '0';
			}
		}

		return $sale_price_dates_to;
	}
}

if ( !function_exists( 'bianco_get_product_images' ) ) {
	function bianco_get_product_images()
	{
		global $product;
		$attachment_ids = $product->get_gallery_image_ids();
		$results        = array();
		foreach ( $attachment_ids as $attachment_id ) {
			$results[$attachment_id] = array(
				'full'           => wp_get_attachment_image_src( $attachment_id, 'full' ),
				'shop_thumbnail' => wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' ),
				'shop_catalog'   => wp_get_attachment_image_src( $attachment_id, 'shop_catalog' ),
				'shop_single'    => wp_get_attachment_image_src( $attachment_id, 'shop_single' ),
			);
		}

		return $results;
	}
}

if ( !function_exists( 'bianco_get_stock' ) ) {
	add_action( 'bianco_get_stock', 'bianco_get_stock' );
	function bianco_get_stock()
	{
		global $product;
		$stock = $product->get_stock_status();
		if ( $stock == 'instock' ) {
			$class = 'in-stock available-product';
			$text  = $product->get_stock_quantity() . ' In Stock';
		} elseif ( $stock == 'outofstock' ) {
			$class = 'out-stock available-product';
			$text  = 'Out stock';
		} else {
			$class = 'onbackorder available-product';
			$text  = 'On backorder';
		}
		?>
        <p class="stock <?php echo esc_attr( $class ); ?>">
			<?php echo esc_html__( 'Availability:', 'bianco' ); ?>
            <span> <?php echo esc_html( $text ); ?></span>
        </p>

		<?php
	}
}

if ( !function_exists( 'bianco_get_sku' ) ) {
	function bianco_get_sku()
	{
		global $product;
		$product_sku = $product->get_sku();
		if ( !empty( $product_sku ) ) : ?>
            <p class="product-code">
				<?php echo esc_html__( 'Sku:', 'bianco' ); ?>
                <span><?php echo esc_html( $product_sku ); ?></span>
            </p>
		<?php endif;
	}
}

if ( !function_exists( 'bianco_template_single_available' ) ) {
	function bianco_template_single_available()
	{
		global $product;
		if ( $product->is_in_stock() ) {
			$class = 'in-stock available-product';
			$text  = $product->get_stock_quantity() . ' In Stock';
		} else {
			$class = 'out-stock available-product';
			$text  = 'Out stock';
		}
		$sku = esc_html__( 'N/A', 'bianco' );
		if ( $product->get_sku() ) {
			$sku = $product->get_sku();
		}
		?>
        <div class="product-sku-stock">
			<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
                <div class="product-sku">
					<?php esc_html_e( 'SKU:', 'bianco' ); ?>
                    <span class="sku"><?php echo esc_html( $sku ); ?></span>
                </div>
			<?php endif; ?>
            <p class="stock <?php echo esc_attr( $class ); ?>">
				<?php echo esc_html__( 'Availability:', 'bianco' ); ?>
                <span> <?php echo esc_html( $text ); ?></span>
            </p>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_show_attributes' ) ) {
	function bianco_show_attributes()
	{
		global $product;
		$attribute_name = Bianco_Functions::get_option( 'ovic_attribute_product', '' );
		if ( !is_woocommerce() )
			$attribute_name = apply_filters( 'bianco_attribute_name', $attribute_name );
		$terms = wc_get_product_terms( $product->get_id(), 'pa_' . $attribute_name, array( 'fields' => 'all' ) );
		if ( !empty( $terms ) ) : ?>
            <ul class="list-attribute">
				<?php foreach ( $terms as $term ) : ?>
					<?php $link = get_term_link( $term->term_id, 'pa_' . $attribute_name ); ?>
                    <li>
                        <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $term->name ); ?></a>
                    </li>
				<?php endforeach; ?>
            </ul>
		<?php
		else:
			?>
            <div class="short-description"><?php echo wp_specialchars_decode( $product->get_short_description() ) ?></div>
		<?php
		endif;
	}
}
/* AJAX UPDATE WISH LIST */
if ( !function_exists( 'bianco_update_wishlist_count' ) ) {
	function bianco_update_wishlist_count()
	{
		if ( function_exists( 'YITH_WCWL' ) ) {
			wp_send_json( YITH_WCWL()->count_products() );
		}
	}

	// Wishlist ajaxify update
	add_action( 'wp_ajax_bianco_update_wishlist_count', 'bianco_update_wishlist_count' );
	add_action( 'wp_ajax_nopriv_bianco_update_wishlist_count', 'bianco_update_wishlist_count' );
}

if ( !function_exists( 'bianco_update_compare_count' ) ) {
	function bianco_update_compare_count()
	{
		if ( class_exists( 'YITH_Woocompare' ) ) {
			global $yith_woocompare;
			wp_send_json( count( $yith_woocompare->obj->products_list ) );
		}
	}

	// Wishlist ajaxify update
	add_action( 'wp_ajax_bianco_update_compare_count', 'bianco_update_compare_count' );
	add_action( 'wp_ajax_nopriv_bianco_update_compare_count', 'bianco_update_compare_count' );
}
/* COMPARE */
if ( !function_exists( 'bianco_compare_url' ) ) {
	function bianco_compare_url()
	{
		if ( class_exists( 'YITH_Woocompare' ) ) :
			global $yith_woocompare;
			$href = '#';
			if ( count( $yith_woocompare->obj->products_list ) > 0 ) {
				$href = add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() );
			}
			?>
            <a href="<?php echo esc_url( $href ); ?>"
               rel="nofollow"><?php echo esc_html__( 'My Compare', 'bianco' ); ?></a>
		<?php endif;
	}
}

if ( !function_exists( 'bianco_compare' ) ) {
	function bianco_compare()
	{
		if ( class_exists( 'YITH_Woocompare' ) ) :
			global $yith_woocompare;
			$href = '#';
			if ( count( $yith_woocompare->obj->products_list ) > 0 ) {
				$href = add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() );
			}
			?>
            <div class="block-compare">
                <a href="<?php echo esc_url( $href ); ?>"
                   class="compare added" rel="nofollow">
                    <span class="bianco-icon icon-user"></span>
                    <span class="text"><?php echo esc_html__( 'Compare', 'bianco' ); ?></span>
                </a>
            </div>
		<?php endif;
	}
}

if ( !function_exists( 'bianco_display_compare_block' ) ) {
	function bianco_display_compare_block()
	{
		if ( class_exists( 'YITH_Woocompare' ) ) :
			global $yith_woocompare;
			?>
			
            <div class="block-compare">
                <a href="<?php echo add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() ) ?>"
                   class="compare added" rel="nofollow">
                    <i class="bianco-icon icon-compare"></i>
					<!-- <img src="/wp-content/uploads/2020/03/compare-icon.ico" alt="compare icon"/> -->
                    <span class="compare-count"><?php echo count( $yith_woocompare->obj->products_list ); ?></span>
                </a>
            </div>
		<?php endif;
	}
}
/* WISHLIST */
if ( !function_exists( 'bianco_wishlist_url' ) ) {
	function bianco_wishlist_url()
	{
		if ( defined( 'YITH_WCWL' ) ) :
			$wishlist_url = '#';
			if ( YITH_WCWL()->count_all_products() > 0 ) {
				$yith_wcwl_wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
				$wishlist_url               = get_page_link( $yith_wcwl_wishlist_page_id );
			}
			if ( $wishlist_url != '' ) : ?>
                <a href="<?php echo esc_url( $wishlist_url ); ?>"><?php echo esc_html__( 'My wishlist', 'bianco' ); ?></a>
			<?php endif;
		endif;
	}
}

if ( !function_exists( 'bianco_wishlist' ) ) {
	function bianco_wishlist()
	{
		if ( defined( 'YITH_WCWL' ) ) :
			$wishlist_url = '#';
			if ( YITH_WCWL()->count_all_products() > 0 ) {
				$yith_wcwl_wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
				$wishlist_url               = get_page_link( $yith_wcwl_wishlist_page_id );
			}
			if ( $wishlist_url != '' ) : ?>
                <div class="block-wishlist">
                    <a class="woo-wishlist-link" href="<?php echo esc_url( $wishlist_url ); ?>">
                        <span class="bianco-icon icon-heart"></span>
                        <span class="text"><?php echo esc_html__( 'Favorites', 'bianco' ); ?></span>
                    </a>
                </div>
			<?php endif;
		endif;
	}
}

if ( !function_exists( 'bianco_display_wishlist_block' ) ) {
	function bianco_display_wishlist_block()
	{
		if ( defined( 'YITH_WCWL' ) ) :
			$yith_wcwl_wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
			$wishlist_url = !$yith_wcwl_wishlist_page_id ? '#' : get_page_link( $yith_wcwl_wishlist_page_id ); 
			?>
            <div class="block-wishlist">
                <a class="woo-wishlist-link" href="<?php echo esc_url( $wishlist_url ); ?>">
                    <i class="bianco-icon icon-heart"></i>
                    <span class="wishlist-count"><?php echo intval( YITH_WCWL()->count_all_products() ); ?></span>
                </a>
            </div>
		<?php endif; ?>
		<?php
	}
}
/* MINI CART */
if ( !function_exists( 'bianco_header_cart_link' ) ) {
	function bianco_header_cart_link()
	{
		global $woocommerce;
		?>
        <a class="link-dropdown block-cart-link" href="<?php echo wc_get_cart_url(); ?>" data-ovic="ovic-dropdown">
            <span class="bianco-icon icon-handbag">
                <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </span>
            <span class="bianco-group cart-name"><?php esc_html_e('MY CART','bianco')?></span>
            <span class="bianco-group price">
				<?php echo wp_specialchars_decode( $woocommerce->cart->get_cart_subtotal() ); ?>
            </span>
        </a>
		<?php
	}
}

if ( !function_exists( 'bianco_header_mini_cart' ) ) {
	function bianco_header_mini_cart()
	{
	    $mini_cart_title = esc_html('Order Summary','bianco');
		?>
        <div class="block-minicart ovic-mini-cart ovic-dropdown">
			<?php bianco_header_cart_link(); ?>
			<?php the_widget( 'WC_Widget_Cart', "title={$mini_cart_title}" ); ?>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_cart_link_fragment' ) ) {
	function bianco_cart_link_fragment( $fragments )
	{
		ob_start();
		    bianco_header_cart_link();
		$fragments['a.block-cart-link'] = ob_get_clean();
		return $fragments;
	}
}

if ( !function_exists( 'bianco_shop_loop_item_countdown' ) ) {
	function bianco_shop_loop_item_countdown()
	{
		global $product;
		$date = bianco_get_max_date_sale( $product->get_id() );
		if ( $date ) {
			?>
            <div class="ovic-countdown" data-datetime="<?php echo date( 'm/j/Y g:i:s', $date ); ?>"
                 data-txt_day="<?php echo esc_attr__( 'Days', 'bianco' ) ?>"
                 data-txt_hour="<?php echo esc_attr__( 'Hours', 'bianco' ) ?>"
                 data-txt_min="<?php echo esc_attr__( 'Mins', 'bianco' ) ?>"
                 data-txt_sec="<?php echo esc_attr__( 'Secs', 'bianco' ) ?>" data-value_first="1"></div>
			<?php
		}
	}
}

if ( !function_exists( 'bianco_custom_result_count' ) ) {
	function bianco_custom_result_count()
	{
		if ( !wc_get_loop_prop( 'is_paginated' ) || !woocommerce_products_will_display() ) {
			return;
		}
		$total = wc_get_loop_prop( 'total' );
		?>
        <div class="shop-control-item result-count">
            <p class="woocommerce-result-count"><span
                        class="index"><?php echo esc_html( $total ); ?></span> <?php esc_html_e( 'Products found', 'bianco' ); ?>
            </p>
        </div>
		<?php
	}
}

if ( !function_exists('bianco_get_store_display_mode')){
	function bianco_get_store_display_mode(){
        if(is_product())  return 'grid';
		$shop_display_mode = Bianco_Functions::get_option( 'ovic_shop_list_style', 'grid' );
        if( isset($_SESSION['ovic_shop_list_style'])){
            $shop_display_mode = $_SESSION['ovic_shop_list_style'];
        }
        if(isset( $_GET['ovic_shop_list_style'] )){
            $shop_display_mode = $_GET['ovic_shop_list_style'];
            $_SESSION['ovic_shop_list_style'] = $_GET['ovic_shop_list_style'];
        }
        return $shop_display_mode;
	}
}

if ( !function_exists( 'bianco_shop_display_mode_tmp' ) ) {
	function bianco_shop_display_mode_tmp()
	{
		$shop_display_mode = bianco_get_store_display_mode();
		?>
        <div class="grid-view-mode">
            <span class="text-item"><?php esc_html_e( 'View mode:', 'bianco' ) ?></span>
            <form method="get">
                <button type="submit"
                        class="modes-mode mode-grid display-mode <?php if ( $shop_display_mode == 'grid' ): ?>active<?php endif; ?>"
                        value="grid"
                        name="ovic_shop_list_style">
                        <span class="button-inner">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                </button>
                <button type="submit"
                        class="modes-mode mode-list display-mode <?php if ( $shop_display_mode == 'list' ): ?>active<?php endif; ?>"
                        value="list"
                        name="ovic_shop_list_style">
                        <span class="button-inner">
                            <span></span>
                            <span></span>
                        </span>
                </button>
				<?php wc_query_string_form_fields( null, array( 'ovic_shop_list_style', 'submit', 'paged', 'product-page' ) ); ?>
            </form>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_custom_odering_products_category' ) ) {
	function bianco_custom_odering_products_category( $options )
	{
		$span                                  = '<span>' . esc_html__( 'Sort by', 'bianco' ) . '</span>';
		$catalog_orderby_options               = array(
			'menu_order' => esc_html__( 'Default sorting', 'bianco' ),
		);
		$catalog_orderby_options['popularity'] = esc_html__( 'popularity', 'bianco' );
		$catalog_orderby_options['rating']     = esc_html__( 'average rating', 'bianco' );
		$catalog_orderby_options['date']       = esc_html__( 'newness', 'bianco' );
		$catalog_orderby_options['price']      = esc_html__( 'price: low to high', 'bianco' );
		$catalog_orderby_options['price-desc'] = esc_html__( 'price: high to low', 'bianco' );
		$return                                = array_merge( $options, $catalog_orderby_options );

		return $return;
	}
}

if ( !function_exists( 'bianco_product_per_page_tmp' ) ) {
	function bianco_product_per_page_tmp()
	{
		$perpage          = Bianco_Functions::get_option( 'ovic_product_per_page', '12' );
		$translate_string = esc_html__( ' Products/Page', 'bianco' );
		$arr_number       = array(
			'5'  => '05',
			'10' => '10',
			'12' => '12',
			'15' => '15',
			'18' => '18',
			'24' => '24',
		);
		if ( !in_array( $perpage, $arr_number ) && $perpage > 0 ) {
			$arr_number[$perpage] = $perpage;
		}
		ksort( $arr_number );
		?>
        <div class="shop-control-item showing">
            <span class="text-item"><?php esc_html_e( 'Show:', 'bianco' ); ?></span>
            <form class="per-page-form" method="get">
                <select name="ovic_product_per_page" class="option-perpage">
					<?php foreach ( $arr_number as $nber => $value ): ?>
						<?php $text = $value . $translate_string; ?>
                        <option value="<?php echo esc_attr( $nber ); ?>" <?php selected( $perpage, $nber ); ?>>
							<?php echo esc_html( $text ); ?>
                        </option>
					<?php endforeach; ?>
                    <option value="-1" <?php selected( $perpage, '-1' )?>><?php echo esc_html__( 'Show All', 'bianco' ); ?></option>
                </select>
				<?php wc_query_string_form_fields( null, array( 'ovic_product_per_page', 'submit', 'paged', 'product-page' ) ); ?>
            </form>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_catalog_ordering' ) ) {
	function bianco_catalog_ordering()
	{
		?>
        <div class="shop-control-item ordering">
            <span class="text-item"><?php esc_html_e( 'Sort by:', 'bianco' ); ?></span>
			<?php woocommerce_catalog_ordering(); ?>
        </div>
		<?php
	}
}

if ( !function_exists( 'bianco_paging_nav' ) ) {
	function bianco_paging_nav()
	{
		global $wp_query;
		/* Don't print empty markup if there's only one page.*/
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}
		echo get_the_posts_pagination( array(
				'screen_reader_text' => '&nbsp;',
				'before_page_number' => '',
			)
		);
	}
}

if ( !function_exists( 'bianco_template_single_stock' ) ) {
	function bianco_template_single_stock()
	{
		global $product;
		if ( $product->is_in_stock() ) {
			$class = 'in-stock available-product';
			$text  = $product->get_stock_quantity() . ' ' . esc_html__( 'In Stock', 'bianco' );
		} else {
			$class = 'out-stock available-product';
			$text  = esc_html__( 'Out stock', 'bianco' );
		}
		?>
        <p class="stock <?php echo esc_attr( $class ); ?>">
			<?php echo esc_html__( 'Availability:', 'bianco' ); ?>
            <span> <?php echo esc_html( $text ); ?></span>
        </p>
		<?php
	}
}

if ( !function_exists( 'bianco_shop_loop_item_wishlist' ) ) {
	function bianco_shop_loop_item_wishlist()
	{
		global $product;
		$product_id        = yit_get_product_id( $product );
		$default_wishlists = is_user_logged_in() ? YITH_WCWL()->get_wishlists( array( 'is_default' => true ) ) : false;
		if ( !empty( $default_wishlists ) ) {
			$default_wishlist = $default_wishlists[0]['ID'];
		} else {
			$default_wishlist = false;
		}
		/* exists in default wishlist*/
		if ( YITH_WCWL()->is_product_in_wishlist( $product_id, $default_wishlist ) ) {
			$added_class = 'added';
		} else {
			$added_class = '';
		}
		$html = '<div class="ovic-wishlist ' . $added_class . '">';
		$html .= '<a href="' . esc_url( add_query_arg( 'add_to_wishlist', $product_id ) ) . '" data-product-id="' . $product_id . '" data-product-type="' . $product->get_type() . '" class="add_to_wishlist"></a>';
		$html .= '<a href="' . esc_url( YITH_WCWL()->get_wishlist_url() ) . '" class="wishlist-url"></a>';
		$html .= '<i class="ajax-loading fa fa-spinner fa-spin"></i>';
		$html .= '</div>';
		echo wp_specialchars_decode( $html );
	}
}

if ( !function_exists( 'bianco_show_register_top_message' ) ) {
	function bianco_show_register_top_message()
	{
		$register_message = Bianco_Functions::get_option( 'ovic_register_top_message', '' ); ?>

		<?php if ( $register_message ) { ?>
        <div class="message frm-message">
            <p class="txt"><?php echo esc_html( $register_message ); ?></p>
        </div>
	<?php } ?>

		<?php
	}
}

if ( !function_exists( 'bianco_woocommerce_show_page_title' ) ) {
	function bianco_woocommerce_show_page_title()
	{
		return false;
	}
}

if ( !function_exists( 'bianco_template_loop_product_title' ) ) {
	function bianco_template_loop_product_title()
	{
		?>
        <h3 class="product-name product_title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
		<?php
	}
}

if ( !function_exists( 'bianco_custom_template_loop_rating' ) ) {
	function bianco_custom_template_loop_rating()
	{
		global $product;
		$html = '';
		if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
			return;
		}
		$rating_count = $product->get_rating_count();
		if ( $rating_count ) {
			$html = '<div class="rating-wapper"><div class="star-rating">';
			$html .= wc_get_star_rating_html( $product->get_average_rating() );
			$html .= '</div><span class="rating-count">(' . $rating_count . ')</span></div>';
		}
		echo wp_specialchars_decode( $html );
	}
}

if ( !function_exists( 'bianco_custom_template_loop_detail_rating' ) ) {
	function bianco_custom_template_loop_detail_rating()
	{
		global $product;
		$html = '';
		if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
			return;
		}
		$review       = esc_html__( 'review', 'bianco' );
		$reviews      = esc_html__( 'reviews', 'bianco' );
		$rating_count = $product->get_rating_count();
		if ( $rating_count == 1 ) {
			$reviews = $review;
		}
		if ( $rating_count ) {
			$html = '<div class="rating-wapper"><div class="star-rating">';
			$html .= wc_get_star_rating_html( $product->get_average_rating() );
			$html .= "</div><span class='rating-count'>({$rating_count} {$reviews})</span></div>";
		}
		echo wp_specialchars_decode( $html );
	}
}

if ( !function_exists( 'bianco_single_product_style' ) ) {
	function bianco_single_product_style()
	{
		$ovic_single_product_style = Bianco_Functions::get_option( 'ovic_single_product_style', 1 );
		if ( $ovic_single_product_style )
			return $ovic_single_product_style;

		return 1;
	}
}

if ( !function_exists( 'bianco_wishlist_added_label' ) ) {
	function bianco_wishlist_added_label()
	{
		return esc_html__( 'Browse', 'bianco' );
	}
}

if ( !function_exists( 'bianco_product_get_rating_html' ) ) {
	function bianco_product_get_rating_html( $html, $rating, $count )
	{
		if ( 0 < $rating ) {
			$html = '<div class="rating-wapper"><div class="star-rating">';
			$html .= wc_get_star_rating_html( $rating, $count );
			$html .= '</div></div>';
		} else {
			$html = '';
		}

		return $html;
	}
}

if ( !function_exists( 'bianco_related_title_product' ) ) {
	function bianco_related_title_product( $prefix )
	{
		if ( $prefix == 'ovic_woo_crosssell' ) {
			$default_text = esc_html__( 'Cross Sell Products', 'bianco' );
		} elseif ( $prefix == 'ovic_woo_related' ) {
			$default_text = esc_html__( 'Related Products', 'bianco' );
		} else {
			$default_text = esc_html__( 'Upsell Products', 'bianco' );
		}
		$title = Bianco_Functions::get_option( "{$prefix}_products_title", $default_text);
		ob_start();
		if ( $title ): ?>
            <h2 class="product-grid-title"><span><?php echo esc_html( $title ); ?></span></h2>
		<?php
		endif;
		$html = ob_get_clean();
		echo apply_filters( 'bianco_filter_related_title_product', $html, $prefix );
	}
}

if ( !function_exists( 'bianco_carousel_products' ) ) {
	function bianco_carousel_products( $prefix, $product_args, $layout = '' )
	{
		$enable_product = Bianco_Functions::get_option( $prefix . '_enable', 'enable' );
		if ( $enable_product == 'disable' )
			return;
		$ovic_woo_product_style = apply_filters( 'ovic_single_product_style', 1 );
		$ovic_woo_product_style = !empty( $layout ) ? $layout : $ovic_woo_product_style;
		$template_style         = 'style-' . $ovic_woo_product_style;
		$classes                = array( 'product-item' );
		$classes_contain        = array( 'products product-grid ovic-products equal-container better-height' );
		$classes[]              = $template_style;
		$classes[]              = apply_filters( 'ovic_single_product_class', '' );
		$woo_ls_items           = Bianco_Functions::get_option( $prefix . '_ls_items', 3 );
		$woo_lg_items           = Bianco_Functions::get_option( $prefix . '_lg_items', 3 );
		$woo_md_items           = Bianco_Functions::get_option( $prefix . '_md_items', 3 );
		$woo_sm_items           = Bianco_Functions::get_option( $prefix . '_sm_items', 2 );
		$woo_xs_items           = Bianco_Functions::get_option( $prefix . '_xs_items', 1 );
		$woo_ts_items           = Bianco_Functions::get_option( $prefix . '_ts_items', 1 );
		$atts                   = array(
			'owl_loop'              => 'false',
			'owl_ts_items'          => $woo_ts_items,
			'owl_xs_items'          => $woo_xs_items,
			'owl_sm_items'          => $woo_sm_items,
			'owl_md_items'          => $woo_md_items,
			'owl_lg_items'          => $woo_lg_items,
			'owl_ls_items'          => $woo_ls_items,
			'owl_responsive_margin' => 480,
			'owl_slide_margin'      => 30,
		);
		$classes_contain[]      = $prefix . '-product';
		$atts                   = apply_filters( 'ovic_carousel_related_single_product', $atts );
		$owl_settings           = apply_filters( 'ovic_carousel_data_attributes', 'owl_', $atts );
		if ( $product_args ) : ?>
            <div class="<?php echo esc_attr( implode( ' ', $classes_contain ) ); ?>">
				<?php bianco_related_title_product( $prefix ); ?>
                <div class="owl-slick owl-products equal-container better-height" <?php echo esc_attr( $owl_settings ); ?>>
					<?php foreach ( $product_args as $object ) : ?>
                        <div <?php wc_product_class( $classes ) ?>>
							<?php
							$post_object = get_post( $object->get_id() );
							setup_postdata( $GLOBALS['post'] =& $post_object );
							get_template_part( 'woocommerce/product-styles/content-product', $template_style );
							?>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
		<?php endif;
		wp_reset_postdata();
	}
}
// GET VENDOR SUPORT FOR DOKAN PLUGIN
if ( !function_exists( 'bianco_get_vendor_user_from_dokan' ) ) {
	function bianco_get_vendor_user_from_dokan()
	{
		if ( class_exists( 'WCMp' ) ) {
			global $product;
			$vendor_id = get_post_field( 'post_author', $product->get_id() );
			$vendor    = get_user_by( 'id', $vendor_id );
			printf( '<div class="vendor-info"><span>%s</span><a class="vendor-store" href="%s">%s</a></div>', esc_html__( 'Sold by:', 'bianco' ), dokan_get_store_url( $vendor->ID ), $vendor->display_name );
		}
	}
}

if ( !function_exists( 'bianco_loadmore_products' ) ) {
	function bianco_loadmore_products()
	{
		check_ajax_referer( 'bianco_ajax_frontend', 'security' );
		if ( isset( $_POST['data'] ) && !empty( $_POST['data'] ) && isset( $_POST['paged'] ) ) {
			$paged = $_POST['paged'];
			add_filter( 'woocommerce_shortcode_products_query',
				function ( $args ) use ( $paged ) {
					$args['paged'] = $paged;

					return $args;
				}
			);
			echo bianco_do_shortcode( 'ovic_products', $_POST['data'] );
		}
		wp_die();
	}
}

if ( !function_exists( 'bianco_process_availability' ) ) {
	function bianco_process_availability()
	{
		global $product;
		$units_sold   = get_post_meta( $product->get_id(), 'total_sales', true );
		$availability = $product->get_max_purchase_quantity();
		if ( $availability == '' ) {
			$percent = 0;
		} else {
			$total = $availability + $units_sold;
			$percent       = round( ( ( $units_sold / $total ) * 100 ), 0 );
		}
		?>
        <div class="process-availability">
            <span class="availability-total total">
                <span class="process" style="width: <?php echo esc_attr( $percent ) . '%' ?>"></span>
            </span>
            <div class="availability-text">
                <span class="text"><?php echo sprintf( __( 'already Sold: %s', 'bianco' ), $units_sold ); ?></span>
                <span class="text">
                    <?php echo sprintf( '%s <span>%s</span>', __( 'Available:', 'bianco' ), $availability );?>
                </span>
            </div>
        </div>
		<?php
	}
}

if ( !function_exists('bianco_handle_buy_now_button')){
    function bianco_handle_buy_now_button(){
        check_ajax_referer( 'bianco_ajax_frontend');
        $data = array('status'=>'fail', 'message' => 'Invalid');
        if(!empty( $_POST['product_id'] )){
            $product_id = $_POST['product_id'];
            $is_add_to_cart = WC()->cart->add_to_cart($product_id);
            if($is_add_to_cart){
                $data['status'] = 'ok';
                $data['cart_id'] = $is_add_to_cart;
            }
        }
        wp_send_json_success($data);
        die();
    }
}

if ( !function_exists('bianco_re_format_sale_price')){
    function bianco_re_format_sale_price(  $price, $regular_price, $sale_price ) {
        $custom_price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins><del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
        return $custom_price;
    }
}

if ( !function_exists('bianco_widget_shopping_cart_button_view_cart')){
    function bianco_widget_shopping_cart_button_view_cart(){
        echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward">' . esc_html__( 'View and edit cart', 'bianco' ) . '</a>';
    }
}

if ( !function_exists( 'bianco_woocommerce_clear_cart_via_url' ) ) {
	function bianco_woocommerce_clear_cart_via_url()
	{
		global $woocommerce;
		if ( isset( $_GET['clear-cart'] ) && $_GET['clear-cart'] === 'true' ) {
			$woocommerce->cart->empty_cart();
		}
	}
}

if( !function_exists('bainco_remove_tab_more_seller_product')){
    function bainco_remove_tab_more_seller_product($tabs){
        unset( $tabs['more_seller_product'] );
        return $tabs;
    }
}

if( !function_exists('bianco_single_product_thumnail')){
    function bianco_single_product_thumnail(){
        global $product;
        $gallaries = array();
        $first_image = $product->get_image_id();
        if($first_image){
            $gallaries[] = $first_image;
        }
        $gallaries2 = $product->get_gallery_image_ids();
        if(!empty($gallaries2)){
            $gallaries = array_merge($gallaries,$gallaries2);
        }
        $html_result = '';
        $base_id = uniqid('bianco-thumb');
        if(!empty($gallaries)): ?>
        <div class="product-thumnb-control bianco-thumb-control">
            <div class="presented">
                <a href="<?php echo esc_url($product->get_permalink()); ?>">
                    <?php foreach ($gallaries as $index1 => $img_id1){
                        $img_full_size =  apply_filters( 'ovic_resize_image', $img_id1, 400, 400, false, false, true ); ?>
                        <?php if($index1 == 0){?>
                            <figure id="<?php echo esc_attr($base_id.$index1) ?>" class="loaded show"><?php echo wp_specialchars_decode($img_full_size['img'])?></figure>
                        <?php } else {?>
                            <?php $url_placeholder = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%20" . $img_full_size['width'] . "%20" . $img_full_size['height'] . "%27%2F%3E"; ?>
                            <figure id="<?php echo esc_attr($base_id.$index1) ?>" data-lg_image="<?php echo esc_attr($img_full_size['url']); ?>">
                                <img width="<?php echo esc_attr($img_full_size['width']); ?>" height="<?php echo esc_attr($img_full_size['height']); ?>" src="<?php echo esc_attr($url_placeholder) ?>" class="wp-post-image" alt="" style="display: block;">
                            </figure>
                        <?php }?>
                    <?php } ?>
                </a>
            </div>
            <div class="products-galleries">
                <ul class="pr-thumbnails">
                <?php foreach ($gallaries as $index => $img_id){
                    $class = ($index == 0) ? 'img-item active' : 'img-item';
                    $img_thumb = apply_filters( 'ovic_resize_image', $img_id, '80', '80', false, false, true );?>
                    <li class="<?php echo esc_attr($class); ?>" data-slide_id="#<?php echo esc_attr($base_id.$index) ?>" >
                        <?php echo wp_specialchars_decode($img_thumb['img']); ?>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <?php endif;
    }
}

if( !function_exists('bianco_socail_share_in_quickview')){
    function bianco_socail_share_in_quickview(){
        global $product;
        $article_link = $product->get_permalink();
        $title = $product->get_title();
        $excerpt = $product->get_short_description();
        ?>
        <div class="social-share-links">
            <ul>
                <li><a href="https://twitter.com/home?status=<?php echo esc_url($article_link); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($article_link); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="https://pinterest.com/pin/create/button/?url=&media=<?php echo esc_url($article_link); ?>&description=<?php echo esc_attr($excerpt); ?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                <li><a href="https://plus.google.com/share?url=<?php echo esc_url($article_link); ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($article_link); ?>&title=<?php echo esc_attr($title); ?>&summary=<?php echo esc_attr($excerpt); ?>&source="><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <?php
    }
}

if( !function_exists('bianco_overwrite_single_product_review')){
    function bianco_overwrite_single_product_review($comment_form ){
        $commenter = wp_get_current_commenter();
        $comment_form['title_reply'] = have_comments() ? esc_html__( 'Leave a review', 'bianco' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'bianco' ), get_the_title() );
        $comment_form['fields'] = array(
            'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'bianco' ) . '&nbsp;<span class="required">*</span></label> ' .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required placeholder="' . esc_html__( 'Your name', 'bianco' ) . '" /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'bianco' ) . '&nbsp;<span class="required">*</span></label> ' .
                '<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required placeholder="' . esc_html__( 'Email address', 'bianco' ) . '" /></p>',
        );
        $comment_field = '';
        if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
            $comment_field = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'bianco' ) . '</label><select name="rating" id="rating" aria-required="true" required>
                        <option value="">' . esc_html__( 'Rate&hellip;', 'bianco' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'bianco' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'bianco' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'bianco' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'bianco' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'bianco' ) . '</option>
						</select></div>';
        }
        $comment_field .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'bianco' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="15" aria-required="true" required placeholder="' . esc_html__( 'Your comments', 'bianco' ) . '" ></textarea></p>';
        $comment_form['comment_field'] = $comment_field;
        return $comment_form;
    }
}

if( !function_exists('bianco_show_coundown_inside_product')){
    function bianco_show_coundown_inside_product( $date = ''){
        if(empty($date)){
            global $product;
            $date_on_sale_to = $product->get_date_on_sale_to();
            if ( is_object( $date_on_sale_to ) ) {
                $date = $date_on_sale_to->date( 'm/d/Y H:i:s' );
            }
        }
        ?>
        <?php if(!empty($date)) :?>
        <div class="countdown-box">
            <div class="bianco-countdown"
                 data-datetime="<?php echo esc_attr( $date); ?>"
                 data-txt_day="<?php esc_attr_e( 'Days', 'bianco' ) ?>"
                 data-txt_hour="<?php esc_attr_e( 'Hrs', 'bianco' ) ?>"
                 data-txt_min="<?php esc_attr_e( 'Mins', 'bianco' ) ?>"
                 data-txt_sec="<?php esc_attr_e( 'Secs', 'bianco' ) ?>"
                 data-label_position_top="false">
            </div>
        </div>
        <?php
        endif;
    }
}