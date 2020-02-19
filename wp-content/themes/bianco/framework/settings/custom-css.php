<?php
if ( class_exists( 'BIANCO_TOOLKIT' ) ) {
	add_filter( 'ovic_main_custom_css', 'Bianco_Custom_Css' );
} else {
	add_action( 'wp_enqueue_scripts', 'Bianco_custom_inline_css', 999 );
}
if ( !function_exists( 'Bianco_custom_inline_css' ) ) {
	function Bianco_custom_inline_css(){
		$css     = '';
		$css     = Bianco_Custom_Css( $css );
		$content = preg_replace( '/\s+/', ' ', $css );
        wp_enqueue_style( 'bianco_custom_css');
		wp_add_inline_style( 'bianco_custom_css', $content );
	}
}
if ( !function_exists( 'Bianco_Custom_Css' ) ) {
	function Bianco_Custom_Css( $css ){
        $bianco_bg_color = Bianco_Functions::get_option('bianco_bg_color','#ffffff');
		$main_color = Bianco_Functions::get_option( 'ovic_main_color', '#db4c52' );
		if ( $main_color ) {
			$main_color = str_replace( '#', '', $main_color );
			$main_color = '#' . $main_color;
		}
		$arr_hex_color = bianco_hex2rgb($main_color);
		$css .= "body{background-color: {$bianco_bg_color};}".'
        a:hover,
		a:focus,
		.sticky-post,
		.ovic-custommenu.layout-01 .horizontal .ovic-menu li a:hover,
		.header-market .wrap-vertical-menu .verticalmenu-content .ovic-menu-wapper.vertical .sub-menu:not(.megamenu) li:hover>a::after,
		.header-market .wrap-vertical-menu .verticalmenu-content .ovic-menu-wapper.vertical>ul>li:hover>a,
		.header-market .wrap-vertical-menu .verticalmenu-content .ovic-menu-wapper.vertical>ul>li:hover>a::after,
		.header-child .header-nav .wrap-main-menu .ovic-menu-wapper li.menu-item-has-children:not(menu-item-has-mega-menu)>ul>li a:hover,
		.mega-child-style .widgettitle,
		 blockquote::before,
		.post-item .post-content a,
		.pingback .high-light a,
		.comment-list .reply-content,
		.shop_table td.product-price,
		.shop_table td.product-subtotal,
		.woocommerce-checkout-review-order .shop_table tr.order-total td,
		.product-item .price,
		.product-item.list .stock span,
		.entry-summary .stock span,
		.entry-summary .price,
		.breadcrumb li a:hover span,
		.post-item .post-info .post-author a:hover,
		.blog-grid .group-read-more a,
		.post-item .post-info .post-item-share:hover>a,
		.post-item .post-info .sl-wrapper:hover .icon,
		.post-item .post-info .sl-wrapper .liked .icon,
		.post-item .post-info .sl-wrapper:hover .count,
		.sidebar .search-form .search-submit:hover .bianco-icon,
		.widget .tagcloud a:hover,
		.widget_archive ul li a:hover::before,
		.widget_product_categories ul li a:hover,
		.widget_archive ul li a:hover,
		.pagination .nav-links .page-numbers.prev:hover,
		.pagination .nav-links .page-numbers.next:hover,
		.pagination .nav-links .page-numbers.prev:hover::before,
		.pagination .nav-links .page-numbers.next:hover::after,
		.single-post .post-meta .author-info .author-link,
		.single-post .post-meta .post-tags a:hover,
		.post-item .post-info .sl-button.liked .count,
		.direction-post .dir-item a:not(.mav-link):hover,
		.comments-area .comment-info .comment-meta .high-light:hover,
		.comments-area .comment-info .comment-meta .comment-date:hover,
		.comments-area .comment-info .reply-content a:hover,
		.wc-social-login .ywsl-social:hover i,
		.woocommerce-LostPassword:hover,
		.ovic-custommenu li a:hover,
		.header .topbar-menu li a:hover,
		.header .topbar-menu li a:hover .text-label,
		.header-control .block-minicart .widget_shopping_cart_content ul li a:hover,
		.bianco-nav li a:hover,
		.about-us-love-title,
		.ovic_widget_layered_nav .list-group li a:hover,
		.ovic_widget_layered_nav .list-group li.selected a,
		.woocommerce .woocommerce-cart-form td.product-name a:hover,
		.ourteam-intro .show-first-info .left-info,
		.woocommerce .cart-collaterals .woocommerce-shipping-calculator p a,
		.product-item.style-1 .product-info .product-name a:hover,
		.product-item.style-2 .product-info .product-name a:hover,
		.product-item .product-info .product-name a:hover,
		.breadcrumb.woocommerce-breadcrumb li>a:hover,
		.ovic-price-filters .list-filter li a:hover,
		.ovic_widget_layered_nav .color-group li a:hover .term-name,
		.ovic_widget_layered_nav .color-group li a.selected .term-name,
		.ovic-price-filters .list-filter li a:hover .woocommerce-Price-amount,
		.ovic-price-filters .list-filter li.selected a,
		.ovic-price-filters .list-filter li.selected a .woocommerce-Price-amount,
		.product-item.list .product-inner .product-attr-info .vendor-info .vendor-store:hover,
		.wrap-hero-section .wrap-product-categories .cat-info .details .cate-name a:hover,
		.product-item.list .product-inner .product-info .group-button .compare-button a:hover::before,
        .product-item.list .product-inner .product-info .group-button .yith-wcwl-add-to-wishlist a:hover::before,
        .product-item.list .product-inner .product-info .group-button .compare-button a:hover,
        .product-item.list .product-inner .product-info .group-button .yith-wcwl-add-to-wishlist a:hover,
        .product-item.list .product-inner .product-attr-info .product_title a:hover,
        .single-product .product .entry-summary .wrap-binaco-brand-taxonomy .brand-term,
        .single-product .product .bianco-wrap-product-gallery .woocommerce-product-gallery .flex-control-nav .slick-arrow:hover,
        .single-product .product .bianco-wrap-product-gallery .woocommerce-product-gallery__trigger:hover::before,
        .single-product .product .entry-summary form.cart .yith-wcwl-add-to-wishlist div.show a:hover,
        .single-product .product .entry-summary form.cart .yith-wcwl-add-to-wishlist div.show a:hover::before,
        .single-product .product .entry-summary .product_meta .product-cats .posted_in a:hover,
        .single-product .product .entry-summary .product_meta .wrap-social-shares .list-socials li a:hover,
        .product-item .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse.show a:hover::before,
        .product-item .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse.show a:hover::before,
        .post-item.date-in-front.right-info .post-title a:hover,
        .header-market .wrap-vertical-menu .verticalmenu-content .ovic-menu-wapper>ul li a:hover,
        .wrap-bianco-banner.banner-style1 .banner-link:hover,
        .wrap-bianco-banner.banner-style2 .banner-link:hover,
        .wrap-bianco-banner.banner-style3 .banner-link:hover,
        .wrap-bianco-banner.banner-style4 .banner-link:hover,
        .ovic-custommenu.twice-inline .ovic-menu li a:hover,
        .wrap-bianco-banner.banner-style5 .banner-link,
        .wrap-bianco-banner.banner-style6 .banner-link,
        .wrap-bianco-banner.banner-style7 .banner-link,
        .wrap-bianco-banner.banner-style9 .banner-link:hover,
        .owl-slick.nav-style2 .slick-arrow:hover,
        .header .wcml_currency_switcher ul li a:hover,
        .header-child .header-control>div:not(.block-menu-bar):hover>a .bianco-icon,
        .header-child .header-control .block-compare:hover .compare-count,
        .header-child .header-control .block-wishlist:hover .wishlist-count,
        .header.light-style .topbar-menu .bianco-account-block .inner>ul a:hover,
        .header-child .header-nav .wrap-main-menu .ovic-menu-wapper > ul>li:hover>a,
        .m-sticky-type-2 .mega-child-style.mega-child-01 ul li a:hover,
        .banner-deal .bianco_buy_now:hover,
        .header-tool .block-minicart span,
        .ovic-custommenu.layout-01 .menu a:hover,
        .header-tool .topbar-menu li:hover>.bianco-account-block>i,
        .header-tool .topbar-menu li:hover>.bianco-account-block>span,
        .header-tool .item-top-right>.box-search>a:hover>span,
        .header-tool .own-info .own-phone-number::before,
        .header-tool .box-header-nav .bianco-nav.main-menu>li:hover>a,
        .header-tool .mega-child-style.mega-child-01 ul li a:hover,
        .vertical-mega .megamenu .ovic-custommenu .horizontal .ovic-menu li a:hover,
        .vertical-mega .widget_nav_menu .ovic-menu-wapper .sub-menu:not(.megamenu) li:hover>a,
        .vertical-mega .widget_nav_menu .ovic-menu-wapper .sub-menu:not(.megamenu) li+li:hover>a::after,
        .blog-style-default .post-item .entry-title a:hover,
        .banner-default .text-1 a:hover,
        .banner-style21 .text-5,
        .growl .growl-message a,
        .header-furniture .main-vertical .block-content>.ovic-menu-wapper>ul>li:hover>a::after,
        .header-furniture .ovic-custommenu .horizontal .ovic-menu li a:hover,
        .header-furniture .primary-menu ul.main-menu>li:hover>a,
        .header .header-control .block-compare:hover .bianco-icon,
        .header .header-control .block-compare:hover .compare-count,
        .header .header-control .block-wishlist:hover .bianco-icon,
        .header .header-control .block-wishlist:hover .wishlist-count,
        .header .header-control .block-minicart:hover span::before,
        .header-sticky .ovic-custommenu .horizontal .ovic-menu li a:hover,
        .post-item .post-info .post-comment:hover>.icon,
        .post-item .post-info .post-comment:hover>.count,
        .ovic-iconbox.layout-04 .icon span,
        .ovic-iconbox.layout-05 .icon span,
        .banner-style22 .banner-link,
        .banner-style37 .banner-link:hover,
        .widget.woocommerce.widget_layered_nav li a:hover,
        .main-vertical .block-content>.ovic-menu-wapper>ul>li:hover>a,
        .main-vertical .block-content .ovic-custommenu .horizontal .ovic-menu li a:hover,
        .banner-default .text-1 a:hover::after,
        .block-minicart .widget_shopping_cart_content .buttons .button + .button:hover,
        .banner-style27 .yith-wcwl-add-to-wishlist>div>a:hover::before,
        .banner-style27 .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse.show>a::before,
        .banner-style27 .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse.show>a::before,
        .ovic-tabs.on_left .nav-top-right.ovic-slide .slick-arrow.next:hover,
        .ovic-tabs.on_left .nav-top-right.ovic-slide .slick-arrow.prev:hover,
        .header-digital .primary-menu .ovic-menu-wapper>ul>li:hover>a,
        .header-appliances .ovic-custommenu .horizontal .ovic-menu li a:hover,
        .header-appliances .header-nav .wrap-main-menu .ovic-menu-wapper > ul.main-menu > li:not(.bold-item):hover > a,
        .header:not(.header-digital) .topbar-menu .bianco-account-block > a:hover i,
        .header:not(.header-digital) .topbar-menu .bianco-account-block > a:hover span,
        .ovic-socials.layout-02 ul li a:hover,
        .banner-style38 .texts .cate-link:hover,
        #yith-quick-view-content .social-share-links ul li a:hover,
        #yith-quick-view-content div.woocommerce-product-gallery .flex-control-nav .slick-arrow:hover,
        #yith-quick-view-content div.woocommerce-product-gallery .woocommerce-product-gallery__trigger::before,
        .product-inner.style-wgt .product-info .product-title:hover,
		.flex-control-nav .slick-arrow:hover {
			color: ' . $main_color . ';
		}
        .header.header-furniture .header-control>div.block-wishlist:hover>a>.wishlist-count,
        .header.header-furniture .header-control>div:hover>a>.bianco-icon,
		.content-detail-in-loop .product-inner .product-info .group-button .compare-button a:hover,
		.content-detail-in-loop .product-inner .product-info .group-button .compare-button a:hover::before,
		.content-detail-in-loop .product-inner .product-info .group-button .compare-button a.added,
		.content-detail-in-loop .product-inner .product-info .group-button .compare-button a.added::before,
		.content-detail-in-loop .product-inner .product-info .group-button .yith-wcwl-add-to-wishlist a:hover,
		.content-detail-in-loop .product-inner .product-info .group-button .yith-wcwl-add-to-wishlist a:hover::before,
        .content-detail-in-loop .product-inner .product-info .group-button .yith-wcwl-wishlistexistsbrowse a,
        .content-detail-in-loop .product-inner .product-info .group-button .yith-wcwl-wishlistexistsbrowse a::before,
        .content-detail-in-loop .product-inner .product-info .group-button .yith-wcwl-wishlistaddedbrowse a,
        .content-detail-in-loop .product-inner .product-info .group-button .yith-wcwl-wishlistaddedbrowse a::before { 
            color: ' . $main_color .'!important;
        }
        input[type="text"]:focus, 
        input[type="email"]:focus, 
        textarea:focus,
        input[type="password"]:focus, 
        input[type="tel"]:focus,
        input[type="search"]:focus,
        li.cat-parent.open>a.menu-bar-coltrol,
		.widget .tagcloud a:hover,
		.pagination .nav-links .page-numbers:hover,
		.pagination .nav-links .page-numbers.current,
		.single-post .post-item .post-content blockquote,
		.direction-post .dir-item a.mav-link:hover,
		.header-control .block-minicart .widget_shopping_cart_content ul li a.remove_from_cart_button:hover,
		.product-item .btn-hover-main .product-thumb .group-button div.add-to-cart a:hover,
        .product-item .btn-hover-main .group-button  .compare-button a:hover,
        .product-item .btn-hover-main .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
        .product-item .btn-hover-main .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
        .product-item .btn-hover-main .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
        .product-item .product-inner.inner-v7 .product-thumb .yith-wcqv-button:hover::before, 
        .product-item .product-inner.inner-v7 .product-thumb .group-button div.add-to-cart a:hover, 
        .product-item .product-inner.inner-v7 .group-button .compare-button a:hover, 
        .product-item .product-inner.inner-v7 .group-button .yith-wcwl-add-to-wishlist .show a:hover,
		.woocommerce .woocommerce-cart-form td.actions .coupon input.input-text:focus,
		.woocommerce .woocommerce-form-coupon-toggle,
        .woocommerce .woocommerce-form-login-toggle,
        .ovic_widget_layered_nav .color-group li a.item-type-photo:hover img,
        .ovic_widget_layered_nav .color-group li a.item-type-photo.selected img,
        .single-product .product .bianco-wrap-product-gallery .woocommerce-product-gallery .flex-control-nav li:hover img,
        .single-product .product .bianco-wrap-product-gallery .woocommerce-product-gallery .flex-control-nav li img.flex-active,
        .wrap-bianco-banner.banner-style1:hover .surface.top::after,
        .wrap-bianco-banner.banner-style2:hover .surface.top::after,
        .wrap-bianco-banner.banner-style3:hover .surface.top::after,
        .wrap-bianco-banner.banner-style1:hover .surface.top::before,
        .wrap-bianco-banner.banner-style2:hover .surface.top::before,
        .wrap-bianco-banner.banner-style3:hover .surface.top::before,
        .wrap-bianco-banner.banner-style1:hover .surface.bottom::after,
        .wrap-bianco-banner.banner-style2:hover .surface.bottom::after,
        .wrap-bianco-banner.banner-style3:hover .surface.bottom::after,
        .wrap-bianco-banner.banner-style1:hover .surface.bottom::before,
        .wrap-bianco-banner.banner-style2:hover .surface.bottom::before,
        .wrap-bianco-banner.banner-style3:hover .surface.bottom::before,
        .header-child .box-search .form-content input[type=text],
        .product-item .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
        .product-item .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
        .product-item .group-button .compare-button a.added,
        .header-tool .item-top-right .box-search .form-content,
        .vertical-mega>.widget_nav_menu .ovic-menu-wapper>ul>li:hover>a,
        .banner-deal .bianco_buy_now:hover,
        .product-item.style-6 .product-inner,
        .widget-ovic-mailchimp.inline .email-newsletter:focus,
        .woocommerce .woocommerce-error,
        .woocommerce .woocommerce-info,
        .woocommerce .woocommerce-message,
        .woocommerce-form-register .show_if_seller .input-text:focus,
        .woocommerce .cart-empty,
        .post-pagination>span:not(.title),
        .post-pagination>a:hover>span,
        .page-links>a:hover>span,
        .product-item.style-13 .product-inner,
        .header.header-furniture .box-search .form-content,
        .header-digital .box-search .form-content,
        .page-links>span:not(.page-links-title),
        .woocommerce .woocommerce-form-register input.woocommerce-Input:focus, 
        .woocommerce .woocommerce-form-login input.woocommerce-Input:focus,
        #yith-quick-view-content div.woocommerce-product-gallery .flex-control-nav li>img.flex-active,
        .product-item.style-11 .group-button .add-to-cart>a,
		.post-item .post-thumb .date a{
			border-color: ' . $main_color . ';
		}
		.header.light-style .top-header,
        .backtotop,
        .header-sticky,
        .banner-style13 .banner-link,
        .banner-style10 .banner-link,
        .banner-style11 .banner-link,
        .wrap-bianco-banner.banner-style8 .banner-link,
		li.open>.menu-bar-coltrol,
		.pagination .nav-links .page-numbers:not(.dots):not(.prev):not(.next):hover,
		.pagination .nav-links .page-numbers.current,
		.direction-post .dir-item a.mav-link:hover,
		.comments-area .comment-respond p input[type=submit],
		.woocommerce .woocommerce-form-login .woocommerce-Button,
		.woocommerce .woocommerce-form-register .woocommerce-Button,
		.woocommerce .u-column1>h2,
		.widget-ovic-mailchimp .submit-newsletter,
		.header .block-search .btn-submit,
        .shop-control .chosen-container .chosen-results li.highlighted,
		.header .block-search .chosen-container .chosen-results li.highlighted,
		.header-control .block-minicart .bianco-icon .count,
		.block-minicart .widget_shopping_cart_content .buttons .button:first-child,
		.header-market .header-nav,
		.wpcf7 .wpcf7-form .wpcf7-submit,
		.ourteam-intro .join-info,
		.ovic-slide .slick-arrow:hover,
		.woocommerce .woocommerce-cart-form td .control .btn-number:hover::before,
		.woocommerce .woocommerce-cart-form td .control .btn-number:hover::after,
		.woocommerce .woocommerce-cart-form td.actions .coupon .btn,
		.woocommerce .woocommerce-cart-form td.actions .btn-continue-shopping,
		.woocommerce .cart-collaterals .checkout-button,
        .product-item .btn-hover-main .product-thumb .group-button div.add-to-cart a:hover,
        .product-item .btn-hover-main .group-button  .compare-button a:hover,
        .product-item .btn-hover-main .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
        .product-item .btn-hover-main .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
        .product-item .btn-hover-main .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
        .product-item .btn-hover-main .product-thumb .yith-wcqv-button:hover::before,
        .ovic-price-filters .wrap-input-form .btn-submit,
        .woocommerce .woocommerce-form-login-toggle + .woocommerce-form-login .button[name="login"],
        .woocommerce .woocommerce-form-coupon-toggle + .woocommerce-form-coupon .button[name="apply_coupon"],
        .woocommerce-checkout-review-order .woocommerce-checkout-payment .form-row.place-order .button,
        .product-item.list .product-inner .product-info .group-button .add-to-cart a,
        .single-product .product .entry-summary .single_add_to_cart_button,
        .ovic_woo_crosssell-product .product-grid-title span::before,
        .ovic_woo_crosssell-product .product-grid-title span::after,
        .ovic_woo_upsell-product .product-grid-title span::before,
        .ovic_woo_upsell-product .product-grid-title span::after,        
        .ovic_woo_related-product .product-grid-title span::before,
        .ovic_woo_related-product .product-grid-title span::after,
        .single-product .product .woocommerce-tabs .wc-tabs li::before,
        .single-product .product .woocommerce-tabs .wc-tabs li::after,
        .woocommerce-Tabs-panel--reviews .comment-respond .form-submit input[type=submit],
        .ovic-iconbox.layout-group .lst-item li span.icon,
        .ovic-blog.ovic-blog-list-style1 .ovic-title .title::after,
        .ovic-products-shortcode.product-layout-style-3 .product-item .product-info .add-to-cart a,
        .owl-slick.nav-style1 .slick-arrow:hover::before,
        .wrap-bianco-banner.banner-style1 .banner-link:hover::before,
        .wrap-bianco-banner.banner-style2 .banner-link:hover::before,
        .wrap-bianco-banner.banner-style3 .banner-link:hover::before,
        .wrap-bianco-banner.banner-style4 .banner-link:hover::before,
        .ovic-products-shortcode .add-more-item a,
        .slick-dots li.slick-active button,
        .ovic-slide.brand-vertical .owl-slick .slick-arrow:hover::before,
        .wrap-bianco-banner.banner-style5 .banner-link::before,
        .wrap-bianco-banner.banner-style6 .banner-link::before,
        .wrap-bianco-banner.banner-style7 .banner-link::before,
        .wrap-bianco-banner.banner-style9 .banner-link:hover::before,
        .product-item .product-inner.inner-v7 .product-thumb .yith-wcqv-button:hover::before, 
        .product-item .product-inner.inner-v7 .product-thumb .group-button div.add-to-cart a:hover, 
        .product-item .product-inner.inner-v7 .group-button .compare-button a:hover, 
        .product-item .product-inner.inner-v7 .group-button .yith-wcwl-add-to-wishlist .show a:hover,
        .product-item .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
        .product-item .group-button .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
        .product-item .group-button .compare-button a.added, 
        .header-child .social-lists li a:hover,
        .ovic-products-shortcode .load_more-products,
        .header-tool .item-top-right .block-search .btn-submit:hover,
        .vertical-mega>.widget_nav_menu>.widgettitle,
        .vertical-mega>.widget_nav_menu>.ovic-menu-wapper>ul>li:hover>a,
        .vertical-mega>.widget_nav_menu>.ovic-menu-wapper>ul>li+li:hover>a::before,
        .banner-style24 .banner-link,
        .process-availability .process,
        .banner-style21 .banner-link,
        .banner-style22 .banner-link::before,
        .banner-style23 .btn,
        .no-results .search-form button[type=submit],
        .post-pagination>span:not(.title),
        .post-pagination>a:hover>span,
        .page-links>a:hover>span,
        .page-links>span:not(.page-links-title),
        .post-password-form input[name=Submit],
        .lost_reset_password .woocommerce-Button,
        .woocommerce .wishlist_table td.product-add-to-cart a,
        .woocommerce .return-to-shop .wc-backward,
        .woocommerce-MyAccount-content .edit-account button[type=submit],
        .woocommerce .cart-collaterals .woocommerce-shipping-calculator>section .button,
        .widget_price_filter .ui-slider-handle,
        .widget.widget_price_filter .button,
        .page-404 .content-404 .button,
        .widget_product_search button[type=submit]:hover,
        .widget.woocommerce .woocommerce-widget-layered-nav-dropdown__submit,
        .widget_shopping_cart .widget_shopping_cart_content> p.buttons .button:first-child,
        .header.header-digital .top-header,
        .main-vertical .block-title,
        .ovic-mini-cart .mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar, 
        .ovic-mini-cart .mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar,
        .ovic-mini-cart .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
        .header-digital .topbar-menu .bianco-account-block .inner,
        .ovic-tabs.on_left .custom-tab-link,
        .product-item.style-10 .group-button .add-to-cart>a,
        .product-item.style-9 .group-button .add-to-cart>a,
        .widget-ovic-mailchimp.squares .submit-newsletter,
        .banner-style35 .banner-link,
        .banner-style37 .banner-link:hover::before,
        .header.header-furniture .top-header,
        .product-item.style-11 .group-button .add-to-cart>a:hover,
		.post-item .post-thumb .date a:hover{
			background-color: ' . $main_color . ';
		}
		.header-market.header-appliances .wrap-vertical-menu .block-title,
		.banner-style28 .banner-link:hover{
		    background-color: ' . $main_color . ' !important;
		}
		.blog-grid .post-thumb a figure::after{
			background: linear-gradient(to right, rgba('.$arr_hex_color['red'].','.$arr_hex_color['green'].','.$arr_hex_color['blue'].',0.7) ,rgba(255,255,255,0.2));
		}
		.ovic-blog.ovic-blog-list-style1 .ovic-title .title::before{
		    border-right-color: ' . $main_color . ';
		    border-bottom-color: ' . $main_color . ';
		}
		.ovic-products.loading ul.products::after, 
		.ovic-products.loading .content-product-append::after, 
		.loading-lazy::after, 
		.ovic-accordion::after,
		.widget-ovic-mailchimp .processing::after,
		.tab-container.loading::after{ 
		    border-top-color: ' . $main_color . '; 
        }
		';

		return apply_filters('bianco-custom-css-internal',$css) ;
	}
}
if( ! function_exists( 'bianco_hex2rgb' ) ){
    function bianco_hex2rgb( $color ) {
        $color = trim( $color, '#' );

        if ( strlen( $color ) == 3 ) {
            $r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
            $g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
            $b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
        } else if ( strlen( $color ) == 6 ) {
            $r = hexdec( substr( $color, 0, 2 ) );
            $g = hexdec( substr( $color, 2, 2 ) );
            $b = hexdec( substr( $color, 4, 2 ) );
        } else {
            return array();
        }

        return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    }
}