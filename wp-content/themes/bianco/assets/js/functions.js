;(function ($) {
    "use strict";
    var $document               = $(document),
        $body                   = $('body'),
        $window                 = $(window),
        winW                    = $window.width(),
        winH                    = $window.height(),
        docH                    = 0,
        winScrLast              = 0,
        winScr                  = 0,
        header_outer_height     = $('#header').outerHeight(),
        $header_sticky          = $('.header-sticky'),
        bianco_countdown        = $('.bianco-countdown:not(.test-mode)'),
        $yith_quick_view_modal  = $('#yith-quick-view-modal'),
        $search_buton           = $('.header.header-furniture .header-control .box-search'),
        scrollbar_on_minicart   = function(e){ $document.find('.ovic-mini-cart .woocommerce-mini-cart').mCustomScrollbar(); },
        isMobile                = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i);

    var BIANCO_THEME = {

        init: function () {
            this.bianco_handle_list_menu();
            this.bianco_sidebar_handle();
            this.bianco_mobile_header_search();
            this.bianco_mobile_clicks();
            this.bianco_equa_height_product_carousel();
            this.bianco_chosen();
            this.bianco_countdown_init();
            this.bianco_handle_buy_now_button();
            this.bianco_custom_resize_slide();
            this.handle_product_right_overfollow();
        },

        onResize: function () {
            this.bianco_equa_height_product_carousel();
            this.handle_product_right_overfollow();
        },

        bianco_countdown_init: function () {
            if ( bianco_countdown.length > 0 ) {
                bianco_countdown.each(function () {
                    var $this     = $(this),
                        time      = $this.data('datetime'),
                        txt_day   = $this.data('txt_day'),
                        txt_hour  = $this.data('txt_hour'),
                        txt_min   = $this.data('txt_min'),
                        txt_sec   = $this.data('txt_sec'),
                        top_label = $this.data('label_position_top'),
                        html      = '';
                    if ( typeof top_label !== 'undefined' && top_label ) {
                        if ( txt_day ) {
                            html += '<div class="countdown-item item-day"><span class="item-label">' + txt_day + '</span><span class="item-value">%D</span></div>';
                        }
                        if ( txt_hour ) {
                            html += '<div class="countdown-item item-hour"><span class="item-label">' + txt_hour + '</span><span class="item-value">%H</span></div>';
                        }
                        if ( txt_min ) {
                            html += '<div class="countdown-item item-min"><span class="item-label">' + txt_min + '</span><span class="item-value">%M</span></div>';
                        }
                        if ( txt_sec ) {
                            html += '<div class="countdown-item item-sec"><span class="item-label">' + txt_sec + '</span><span class="item-value">%S</span></div>';
                        }
                    } else {
                        if ( txt_day ) {
                            html += '<div class="countdown-item item-day"><span class="item-value">%D</span><span class="item-label">' + txt_day + '</span></div>';
                        }
                        if ( txt_hour ) {
                            html += '<div class="countdown-item item-hour"><span class="item-value">%H</span><span class="item-label">' + txt_hour + '</span></div>';
                        }
                        if ( txt_min ) {
                            html += '<div class="countdown-item item-min"><span class="item-value">%M</span><span class="item-label">' + txt_min + '</span></div>';
                        }
                        if ( txt_sec ) {
                            html += '<div class="countdown-item item-sec"><span class="item-value">%S</span><span class="item-label">' + txt_sec + '</span></div>';
                        }
                    }
                    $this.countdown(time, function (event) {
                        $this.html(event.strftime(html));
                    });
                })
            }
        },

        bianco_custom_resize_slide: function () {
            $('.owl-slick.product-list-owl').on('breakpoint', function (event, slick, breakpoint) {
                var owl_slick = $('.owl-products.equal-container , .ovic-products.equal-container');
                if ( owl_slick.length ) {
                    owl_slick.each(function () {
                        var max_height      = 0,
                            $product_inner  = $(this).find('.product-inner');
                        $product_inner.css({
                            'height': 'auto'
                        });
                        $product_inner.each(function () {
                            if ( max_height < $(this).height() ) {
                                max_height = $(this).height();
                            }
                        });
                        $product_inner.height(max_height);
                    });
                }
            });
        },

        bianco_equa_height_product_carousel: function () {
            var products = $('.owl-products.equal-container, .product-list-grid.equal-container, .ovic-products.equal-container, .bianco-product-right-overflow');
            if ( products.length ) {
                setTimeout(function () {
                    products.each(function () {
                        var $this           = $(this),
                            product_inner   = $this.find('.product-inner'),
                            max_height      = 0;
                        product_inner.css('height','auto');
                        $this.find('.product-inner').each(function (index, element) {
                            if ( max_height < $(element).height() ) {
                                max_height = $(element).height();
                            }
                        });
                        product_inner.height(max_height);
                    });
                }, 100);
            }
        },

        bianco_handle_list_menu: function () {
            var cat_parent = $('.widget_product_categories .product-categories .cat-parent');
            if ( cat_parent.length ) {
                cat_parent.each(function (index, el) {
                    var $this = $(this);
                    if ( $this.find('ul.children').length ) {
                        $this.append('<a class="menu-bar-coltrol" href="#"><span></span></a>');
                    }
                });
            }
        },

        bianco_sidebar_handle: function () {
            var sidebar = $('#widget-area, #dokan-secondary'),
                $mobile_footer = $('.mobile-footer');
            if (!sidebar.length ) {
                $mobile_footer.find('.block-menu-filter').remove();
                $mobile_footer.find('.mobile-block').css('width', '33.3333333%');
            }
            $mobile_footer.addClass('show-up');
        },

        bianco_mobile_clicks: function () {
            var menu_twice_line = $('.ovic-custommenu.twice-inline');
            if ( menu_twice_line.length > 0 ) {
                menu_twice_line.each(function (index, element) {
                    $(element).find('.widget.widget_nav_menu').prepend('<a href="javascript:void(0)" class="btn twice-inline-togle"><span class="span-contain"><span class="line-1"></span><span class="line-2"></span></span></a>');
                });
                $document.on('click', '.twice-inline-togle', function (e) {
                    e.preventDefault();
                    $(this).toggleClass('menu-opened').siblings('.ovic-menu-wapper').slideToggle('slow');
                });
            }
        },

        bianco_mobile_header_search: function () {
            $('.header-middle-inner .header-control').on('click', '.box-search-mobile .btn-control', function (e) {
                e.preventDefault();
                $body.addClass('overlay-open');
                $(this).closest('.header-middle-inner').addClass('mobile-search-opened');
                $(this).closest('.header-control').siblings('.box-search').find('input[name=s]').focus();
                return false;
            });
        },

        bianco_chosen: function () {
            var $bianco_selecter =  $('.category-search-option , .shop-control select');
            if ( $bianco_selecter.length) {
                $bianco_selecter.chosen({disable_search_threshold: 10});
            }
        },

        bianco_handle_buy_now_button: function () {
            if ( $('.bianco_buy_now').length > 0 ) {
                $document.on('click', '.bianco_buy_now', function (e) {
                    e.preventDefault();
                    var $this = $(this),
                        url   = bianco_ajax_frontend.ajaxurl,
                        data  = {
                            action: 'bianco_handle_buy_now_button',
                            _ajax_nonce: bianco_ajax_frontend.security,
                            product_id: $this.data('product_id'),
                        };
                    $this.addClass('on_add_to_cart');
                    $.post(url, data, function (data, status) {
                        if ( status == 'success' && data.data[ 'status' ] == 'ok' ) {
                            window.location = wc_add_to_cart_params.cart_url;
                            return 0;
                        } else {

                            if ( $this.attr('href') ) {
                                window.location = $this.attr('href');
                                return;
                            }
                        }
                        $this.removeClass('on_add_to_cart');
                    });
                });
            }
        },

        handle_product_right_overfollow: function () {
            var right_ovflw = $('.bianco-product-right-overflow');
            if( right_ovflw.length ){
                right_ovflw.each( function (index, element) {
                    var _this = $(this),
                        bg_underground = _this.find('.bg_underground'),
                        right_offset = $(document).width()-(_this.offset().left + _this.width());
                    if(parseInt(right_offset, 10) >0){
                        bg_underground.css('right', -right_offset);
                    }else{
                        bg_underground.css('right', 0);
                    }
                })
            }
        }
    };

    $document.on('click', 'a.backtotop', function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });

    $document.on('click', '.filter-toggle', function () {
        $body.addClass('overlay-open');
        $('.sidebar').addClass('open');
        $(this).toggleClass('open');
        return false;
    });

    $document.on('click', '.myaccount-toggle', function () {
        $body.addClass('overlay-open');
        $('.mobile-wpml-switcher').addClass('open');
        $(this).toggleClass('open');
        return false;
    });

    $document.on('click', '.close-block-sidebar', function () {
        $body.removeClass('overlay-open');
        $('.sidebar, .mobile-wpml-switcher').removeClass('open');
        return false;
    });

    $document.on('click', '.ovic-share-socials .share-button', function () {
        $(this).closest('.ovic-share-socials').toggleClass('active');
    });

    $document.on('click', '.widgettitle', function () {
        var p = $(this).parent();
        if ( p.hasClass('opened') ) {
            p.removeClass('opened').find('.ovic-menu-wapper').slideUp("slow");
        } else {
            p.addClass('opened').find('.ovic-menu-wapper').slideDown("slow");
        }
    });

    $document.on('click', '.top-sidebar .arrow-sidebar', function () {
        $(this).closest('.arrow-sidebar').toggleClass('has-open');
        $(this).closest('.sidebar').children('.shop-sidebar').slideToggle(300);
    });

    $document.on('click', '.box-search-mobile .btn-submit', function (e) {
        $(this).closest('.header-middle-inner').toggleClass('active');
        e.preventDefault();
    });

    $document.on('click', '.ovic-tabs .tab-link a', function () {
        $(this).closest('.tab-head').removeClass('open');
    });

    $document.on('click', '.ovic-pin .ovic-popup', function () {
        $(this).closest('.ovic-pin').removeClass('actived');
    });

    $document.on('click', '.ovic-products .load_more-products', function (e) {
        e.preventDefault();
        var $this         = $(this),
            shortcode_id = $this.attr('data-id'),
            data_atts    = window[ 'bianco_shortcode_product_' + shortcode_id ];
        $this.bianco_load_products(data_atts, shortcode_id);
    });

    $document.on('click', '.block-search .close-block-search', function () {
        $body.removeClass('overlay-open').removeClass('open-search-box');
        $(this).closest('.header-middle-inner').removeClass('mobile-search-opened');
        return false;
    });

    $document.on('click', '.overlay-body', function () {
        $body.removeClass('overlay-open').removeClass('open-search-box');
        $('.header-middle-inner').removeClass('mobile-search-opened');
        $('.widget-area, .mobile-wpml-switcher').removeClass('open');
    });

    $document.on('click', '.product-categories .menu-bar-coltrol', function (event) {
        event.preventDefault();
        var $this = $(this);
        if ( !$this.parents().hasClass('open') ) {
            $this.closest('ul.product-categories').find('.open>.children').slideUp(300).parents().removeClass('open');
        }
        $this.parent().toggleClass('open');
        $this.siblings('ul.children').slideToggle(300);
    });

    $document.on('click', '.wrap-social-shares .link-popup', function (e) {
        e.preventDefault();
        var obj   = $(this),
            label = ovic_ajax_frontend.lbl_email_to_friend;
        $('#header').after('<div class="modal fade" id="bianco-emailtofriend-modal" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">' + label + '</h4></div><div class="modal-body"></div></div></div></div>');
        var post_data        = {
                action: 'popup_email_service_via_ajax',
                security: ovic_ajax_frontend.security,
                post_id: obj.data('post_id')
            },
            bianco_modal_box = $('#bianco-emailtofriend-modal');
        $.ajax({
            method: 'POST',
            url: ovic_ajax_frontend.ajaxurl,
            dataType: 'text',
            data: post_data,
            beforeSend: function (xhr) {
                obj.after('<span class="load-email-box"></span>');
            },
            success: function (result, status, xhr) {
                if ( status ) {
                    bianco_modal_box.find('.modal-body').append(result);
                    bianco_modal_box.modal('show');
                    bianco_modal_box.on('hidden.bs.modal', function (e) {
                        this.remove();
                    });
                } else {
                    bianco_modal_box.remove();
                }
                $('.load-email-box').remove();
            },
            error: function (xhr, status, error) {
                $('.load-email-box').remove();
                bianco_modal_box.on('hidden.bs.modal', function (e) {
                    this.remove();
                });
            }
        });
    });

    $document.on('click', '.bianco-thumb-control .pr-thumbnails .img-item:not(.active)', function (e) {
        e.preventDefault();
        var $this       = $(this),
            preseted_id = $this.data('slide_id'),
            preseted    = $this.closest('.products-galleries').siblings('.presented');
        if( $this.hasClass('active')) return 0;
        if( typeof preseted_id !== 'undefined' ){
            var figure = preseted.find(preseted_id);
            if( typeof figure !== 'undefined' ){
                figure.addClass('show');
                figure.siblings('.show').removeClass('show');
                if(!figure.hasClass('loaded')){
                    figure.find('img').attr('src', figure.data('lg_image'));
                    figure.addClass('loaded');
                }
                $this.addClass('active');
                $this.siblings('.active').removeClass('active');
            }
        }
    });

    $document.on('wc_fragments_refreshed , wc_fragments_loaded', scrollbar_on_minicart );

    $document.on('bianco_ajax_tabs_complete', function (event, tabID) {
        var $this = $(tabID).find('.equal-container');
        if($this.length){
            var filter_class = tabID+'.owl-products.equal-container,'+tabID+' .ovic-products.equal-container,'+tabID+' .bianco-product-right-overflow',
                products = $(filter_class);
            if ( typeof products != 'undefined' && products.length ) {
                setTimeout(function () {
                    products.each(function () {
                        $(this).find('.product-inner').css({
                            'height': 'auto'
                        });
                        var _height = 0;
                        $(this).find('.product-inner').each(function (index, element) {
                            if ( _height < $(element).height() ) {
                                _height = $(element).height();
                            }
                        });
                        $(this).find('.product-inner').height(_height);
                    });
                }, 100);
            }
        }
    });

    $document.on('qv_loader_stop', function () {
        $yith_quick_view_modal.find('.entry-summary').mCustomScrollbar();
        $yith_quick_view_modal.find('.flex-control-nav').bianco_carousel();
    });

    $body.on('added_to_wishlist', function (e, el, el_wrap) {
        el.closest('.ovic-wishlist').addClass('added');
        el.siblings('.ajax-loading').css('visibility', 'hidden');
    });

    $body.on('ovic_menuclone_all_menus', function () {
        $('.ovic-menu-clone-wrap').find('.lazy:not(.lazyed)').each(function () {
            var $this   = $(this),
                img_src = $this.attr('data-src');
            if ( img_src !== undefined ) {
                $this.attr('src', img_src);
            }
            $this.addClass('lazyed');
        });
    });

    $body.on('yith_woocompare_open_popup', function (e, data) {
        $.ajax({
            type: 'POST',
            url: bianco_ajax_frontend.ajaxurl,
            data: {
                action: 'bianco_update_compare_count',
            },
            success: function (response) {
                $('.compare-count').html(response);
            },
        });
    });

    $body.on('click', '.quantity .btn-number', function (e) {
        e.preventDefault();
        var $this       = $(this),
            $input      = $this.closest('.quantity').find('input.qty'),
            $step       = parseInt($input.data('step')),
            $val        = parseInt($input.val()),
            $max        = parseInt($input.attr('max')),
            $min        = parseInt($input.attr('min')),
            $value      = $val;
        if( $this.hasClass('quantity-plus')){
            $value      = $val + $step;
            if ( $max && $value > $max ) {
                $value = $max;
            }
        }else{
            $value  = $val - $step;
            if ( $min && $value < $min ) {
                $value = $min;
            }
        }
        $input.val($value).trigger('change');
    });

    $window.on('yith_woocompare_product_removed', function () {
        $.ajax({
            type: 'POST',
            url: bianco_ajax_frontend.ajaxurl,
            data: {
                action: 'bianco_update_compare_count'
            },
            success: function (response) {
                $(parent.document).find(".compare-count").html(response);
            },
        });
    });
    
    $window.on('added_to_wishlist removed_from_wishlist', function () {
        $.ajax({
            url: bianco_ajax_frontend.ajaxurl,
            data: {
                action: 'bianco_update_wishlist_count'
            },
            success: function (data) {
                $('.block-wishlist .count, .wishlist-count').text(data);
            },

        });
    });

    $window.on('resize', function(){ BIANCO_THEME.onResize(); });

    $window.scroll(function (event) {
        event.preventDefault();
        winScr = $window.scrollTop();
        if ( docH == 0 ) {
            docH = $document.height();
        }
        if ( winScr > 1000 ) {
            $('.backtotop').addClass('show');
        } else {
            $('.backtotop').removeClass('show');
        }
    });

    document.addEventListener("DOMContentLoaded", function (){
        BIANCO_THEME.init();
    });

    function resizeCall() {
        winW = $(window).width();
        winH = $(window).height();
        docH = $(document).height();

        if ( bianco_ajax_frontend.ovic_sticky_menu == 1 ) {
            if ( winScr > header_outer_height ) {
                if ( winScr > winScrLast ) {
                    if ( !$header_sticky.hasClass('hide-header') ) {
                        $header_sticky.addClass('hide-header');
                    }
                } else {
                    $header_sticky.addClass('fixed').removeClass('hide-header');
                }
            } else {
                $header_sticky.removeClass('fixed');
            }
        }
        winScrLast = winScr;
        return true;
    }
    if ( !isMobile ) {
        $window.scroll(function (event) {
            event.preventDefault();
            resizeCall();
        });
    } else {
        window.addEventListener("orientationchange", function() {
            resizeCall();
        }, false);
    }

    $.fn.bianco_load_products = function (data_atts, _shortcode_id) {
        var $this             = $(this),
            $tab_animated     = 'bounceIn',
            $data             = data_atts,
            $contain          = $('.ovic-products.' + _shortcode_id),
            $response_wrapper = $contain.find('.response-products'),
            $next_page        = $this.data('next_page'),
            $max_page         = $this.data('max_page'),
            $button           = $contain.find('.button-products a.button');

        $.ajax({
            type: 'POST',
            url: bianco_ajax_frontend.ajaxurl,
            data: {
                action: 'bianco_loadmore_products',
                security: bianco_ajax_frontend.security,
                data: $data,
                paged: $next_page,
            },
            beforeSend: function () {
                $button.addClass('loading');
            },
            success: function (response) {

                var product_items = $(response).find('.product-item');

                if ( $this.closest('.ovic-tabs').length ) {
                    $tab_animated = $this.closest('.ovic-tabs').find('.tab-head a.loaded').data('animate');
                }
                if ( product_items.length ) {
                    if ( $tab_animated !== '' ) {
                        product_items.each(function (i) {
                            var _this  = $(this),
                                _style = _this.attr('style'),
                                _delay = i * 100;

                            _style = (_style === undefined) ? '' : _style;
                            _this.attr('style', _style +
                                ';-webkit-animation-delay:' + _delay + 'ms;' +
                                '-moz-animation-delay:' + _delay + 'ms;' +
                                '-o-animation-delay:' + _delay + 'ms;' +
                                'animation-delay:' + _delay + 'ms;'
                            ).addClass($tab_animated + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                                _this.removeClass($tab_animated + ' animated');
                                _this.attr('style', _style);
                            });
                            $response_wrapper.append(_this);
                        });
                    }
                    setTimeout(function ($response_wrapper) {
                        if ( $response_wrapper.find('.variations_form').length && $.fn.wc_variation_form ) {
                            $response_wrapper.find('.variations_form').each(function () {
                                $(this).wc_variation_form();
                            });
                        }
                    }, 10, $response_wrapper);
                    /* SET WINDOW VALUE */
                    $this.data('next_page', $next_page + 1);
                    if ( $next_page + 1 >= $max_page ) {
                        $button.parent().remove();
                    }
                } else {
                    $button.parent().remove();
                }
                $button.removeClass('loading');
            },
        });
    };

    $.fn.extend({
        bianco_carousel: function(args_configs) {
            var $this           = $(this),
                config          =[],
                default_setting = {
                    arrows:true,
                    dots:false,
                    speed:400,
                    slidesMargin:5,
                    slidesToShow:5,
                    slidesToScroll:1,
                    vertical:false,
                    infinite:false,
                    prevArrow:'<span class="fa fa-angle-left prev"></span>',
                    nextArrow:'<span class="fa fa-angle-right next"></span>'
                };
            if(args_configs){
                config = args_configs
            }else{
                config = default_setting;
            }
            if ( $body.hasClass('rtl') ) {
                config.rtl = true;
            }
            $this.on('init', function () {
                $this.trigger('ovic_trigger_init_slide');
            });
            $this.slick(config);
        }
    });

    $('#yith-quick-view-close').html('&times;');

    if( $search_buton.length ){
        $document.on('click', '.header-control .box-search>a', function (e) {
            e.preventDefault();
            $body.addClass('overlay-open open-search-box');

        });
    }

})(jQuery);