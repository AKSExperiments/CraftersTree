<?php
/**
 * Name:  Furniture
 **/
?>
<header id="header" class="header header-furniture">
    <div class="top-header">
        <div class="container">
            <div class="header-top-left">
                <?php do_action('bianco_top_left_menu'); ?>
            </div>
            <div class="header-top-right">
                <?php do_action('bianco_top_right_menu'); ?>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="header-middle-inner">
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 wrap-logo">
                        <div class="logo"><?php bianco_get_logo(); ?></div>
                    </div>
                    <div class="col-lg-7 col-md-8 col-sm-8 col-xs-6 wrap-menu">
                        <div class="box-middle">
                            <div class="header-nav-inner header-responsive main-vertical">
                            <?php bianco_header_vertical(true); ?>
                            </div>
                            <div class="box-header-nav primary-menu">
                                <?php
                                    if (has_nav_menu('primary')) {
                                        wp_nav_menu(array(
                                            'menu' => 'primary',
                                            'theme_location' => 'primary',
                                            'depth' => 3,
                                            'container' => '',
                                            'container_class' => '',
                                            'container_id' => '',
                                            'menu_class' => 'clone-main-menu bianco-nav main-menu',
                                            'megamenu' => true,
                                            'mobile_enable' => true,
                                            )
                                        );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 wrap-info">
                        <?php if ( function_exists('icl_object_id') ): ?>
                        <div class="head-info bianco-multilanguages">
                            <?php do_action( 'bianco_header_currency') ?>
                        </div>
                        <?php endif; ?>
                        <div class="header-control">
                            <div class="box-search">
                               <a href="javascript:void(0)"><span class="bianco-icon icon-magnifier" aria-hidden="true"></span></a>
                                <?php bianco_search_form('simple'); ?>
                            </div>
                            <?php do_action( 'bianco_display_wishlist_block' ); ?>
                            <?php do_action( 'bianco_header_mini_cart' ); ?>
                            <div class="block-menu-bar">
                                <a class="menu-bar menu-toggle" href="#"><span></span><span></span><span></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>